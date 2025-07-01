<?php $this->load->view('includes/dashlite_header'); ?>
<style>
    .badge_parent {
        padding-left: 0px;
        min-width: 140px;
    }
    .badge_title {
        background-color: #FFFFFF;
        color: #000000;
        font-style: normal;
        padding: 0 5px;
        border-radius: 2px;
        margin-right: 5px;
    }
    .badge_title_order {
        width: 50px;
    }
    .badge_title_dms {
        width: 50px;
    }
    .badge_title_profile {
        width: 50px;
    }
    .time {
        display: block;
        font-size: 12px;
        color: #8094ae;
        line-height: 1.3;
    }
</style>
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Packages</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="void(0);" onclick="open_modal_add_package()"  class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Package</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- .nk-block-head-content -->
    </div><!-- .nk-block-between -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table id="example5" class=" nowrap table table-bordered" data-export-title="Export">
                    <thead>
                    <tr>
                        <th>CREATED DATE</th>
                        <th>PRODUCT NAME</th>
                        <th>NORMAL PRICE</th>
                        <th>MEMBER PRICE</th>
                        <th>ACTIONS</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_new_package">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Package Detail</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="full-name">Package Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control uppercase" id="new_package_name" required>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer bg-light">

                <button type="button" onclick="javascript: btn_click_add_new_package();" class="btn btn-lg btn-primary pull-right">Create</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>


<script type="text/javascript">
    function open_modal_add_package(){
        $('#modal_add_new_package').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#modal_add_new_package').modal('show');
    }
</script>
<script>
    function btn_click_add_new_package(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();
        blockUI();
        $.ajax({
            url: '<?php echo base_url(); ?>admin_package/admin_ajax_add_package',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    package_name: $("#new_package_name").val()
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    swalTimer('success','Success', 'Package added. Please update information in the next page', 2500).then(
                        function(value) {
                            window.location.href = data.redirect_url;

                        },
                    );
                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');
                            $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                        } else {

                        }
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: j,
                        });
                    })
                }
            }
        })
    }
</script>

<script type="text/javascript">
    var datatable_el;
    var datatable_el1
    $(function(){
        datatable_el1 = NioApp.DataTable('#example5', {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>admin_package/ajax_datatable_admin_list_all_package",
                "type": "POST",
                "data": function(data){
                    var search_by_msisdn = '<?php echo $this->input->get("search_by_msisdn"); ?>';
                    if(search_by_msisdn && search_by_msisdn.length > 6){
                        data.search_by_msisdn = search_by_msisdn;
                    }
                    return data;
                }
            },
            "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
            responsive: {
                details: true
            },
            buttons: ['copy', 'excel', 'csv', 'pdf'],
            "search": {
                "search": "<?php echo $this->input->get('dt_search_query') ?>"
            },
            "order": [0, 'desc'],
            "columns": [
                { "data": "create_dttm", "searchable": "true" },
                { "data": "package_name", "searchable": "true" },
                { "data": "price_normal", "render": function ( data, type, row ) {
                        html = "";
                        html += "RM "+row.price_normal;
                        return html
                    } },
                { "data": "price_member", "render": function ( data, type, row ) {
                        html = "";
                        html += "RM "+row.price_member;
                        return html
                    } },

                { "data": "package_id", "searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        html += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.package_id+'\');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i>&nbsp;</a>';
                        html += ' <a href="<?php echo base_url(); ?>admin_package/admin_view_package_detail/?page=package_detail&package_id='+row.package_id+'" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> VIEW</a>';
                        return html;
                    } }
            ],
        });
        //document.querySelector('div.toolbar').innerHTML = '<b>Custom tool bar! Text/images etc.</b>';

    });
    function reload_datatable(){
        blockUI();
        datatable_el1.ajax.reload(function(){
            unblockUI();
        });
    }
</script>

<script type="text/javascript">
    function quick_delete(package_id){
        SwalDompet.fire({

            title: "Are you sure?",
            html: "Delete this package ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: "<?php echo base_url(); ?>admin_package/ajax_admin_delete_package",
                    type: "POST",
                    dataType: "json",
                    data: {
                        postdata: {
                            package_id: package_id
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('error','Success', 'Package deleted', 1500).then(
                                function(value) {
                                    window.location.reload();
                                },
                            );
                        } else {
                            sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                    }
                })
            }
        });
    }
    var titleCase = function(s) {
        if (!s) return;
        s = s.toLocaleLowerCase().split(" ");
        var ss = "";
        for(i in s) {
            ss += s[i].substr(0,1).toUpperCase() + s[i].substr(1);
            ss += " ";
        }
        return ss.trim();
    }
    $('.uppercase').keyup(function(){
        this.value = this.value.toUpperCase();
    });
</script>