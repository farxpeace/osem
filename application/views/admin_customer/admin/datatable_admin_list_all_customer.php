<?php $this->load->view('includes/dashlite_header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/css/intlTelInput.css">
<style>
    .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags.png");}
    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
        .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags@2x.png");}
    }
    .intl-tel-input {
        width: 100% !important;
    }
</style>
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
            <h3 class="nk-block-title page-title">Membership Report</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="void(0);" onclick="open_modal_add_member()" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Member</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div><!-- .nk-block-between -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <div class="card-inner">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Registered Date</label>

                                <div class="form-control-wrap">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="form-control-select">
                                                <select class="form-control" id="filter_month" style="width: 160px;">
                                                    <option value="all_month" <?php if($filter_month == 'all_month'){ echo 'selected=""'; } ?>>All Month</option>
                                                    <?php
                                                    $start_my    = new DateTime('2024-01');
                                                    $end_my      = new DateTime('2025-01');
                                                    $interval = DateInterval::createFromDateString('1 month');
                                                    $period   = new DatePeriod($start_my, $interval, $end_my);
                                                    foreach ($period as $dt) { ?>
                                                        <option value="<?php echo $dt->format("m") ?>" <?php if($filter_month == $dt->format("m")){ echo 'selected=""'; } ?>><?php echo $dt->format("M") ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-control-select">
                                            <select class="form-control" id="filter_year" style="width: 160px;">
                                                <option value="all_year" <?php if($filter_year == 'all_year'){ echo 'selected=""'; } ?>>All Year</option>
                                                <option value="2025" <?php if($filter_year == '2025'){ echo 'selected=""'; } ?>>2025</option>
                                                <option value="2026" <?php if($filter_year == '2026'){ echo 'selected=""'; } ?>>2026</option>
                                                <option value="2027" <?php if($filter_year == '2027'){ echo 'selected=""'; } ?>>2027</option>
                                                <option value="2028" <?php if($filter_year == '2028'){ echo 'selected=""'; } ?>>2028</option>
                                                <option value="2029" <?php if($filter_year == '2029'){ echo 'selected=""'; } ?>>2029</option>
                                                <option value="2030" <?php if($filter_year == '2030'){ echo 'selected=""'; } ?>>2030</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">&nbsp;</label>
                                <button type="button" class="btn btn-block btn-primary" onclick="filter_datatable();">Filter</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-inner">
                    <table id="example5" class=" nowrap table table-bordered" data-export-title="Export">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>MEMBER NAME</th>
                            <th>PHONE NUMBER</th>
                            <th>IS MEMBER</th>
                            <th>REGISTERED DATE</th>
                            <th>ACTIONS</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_member">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Member</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="full-name">Member Fullname</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control toUpperCase" id="new_fullname" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="full-name">Mobile Number</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="new_mobile_number" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="full-name">Is Member</label>
                        <div class="form-control-wrap">
                            <div class="form-control-select">
                                <select class="form-control" id="new_is_member">
                                    <option value="yes">✅ Yes</option>
                                    <option value="no">❌ No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
                <div id="frame_validate"></div>
            </div>
            <div class="modal-footer bg-light" style="display: block">

                <button type="button" onclick="javascript: submit_new_member();" class="btn btn-lg btn-primary pull-right">Submit</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/intlTelInput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/utils.js"></script>

<script>
    $(function(){
        $("#new_mobile_number").intlTelInput({
            onlyCountries: [
                "my",
                "sg"

            ],
            preferredCountries: [
                "my",
            ],
            separateDialCode: true
        });
    })
</script>
<script type="text/javascript">
    function open_modal_add_member(){
        $('#modal_add_member').modal('show');
    }
</script>
<script>
    function submit_new_member(){
        SwalDompet.fire({
            title: "Confirmation",
            html: "Add new Member ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin_customer/ajax_admin_add_new_customer/',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            fullname: $("#new_fullname").val(),
                            mobile_number: $("#new_mobile_number").intlTelInput("getNumber"),
                            is_member: $("#new_is_member").val()
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'Attendance added', 2500).then(
                                function(value) {
                                    reload_datatable();
                                    $("#modal_add_member").modal('hide');
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
        });
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
                "url": "/admin_customer/ajax_datatable_admin_list_all_customer",
                "type": "POST",
                "data": function(data){
                    data.filter_month = $("#filter_month").val();
                    data.filter_year = $("#filter_year").val()
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
            "order": [1, 'desc'],
            "columns": [
                { "data": "create_dttm", "searchable": "true", "render": function (data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    } },
                { "data": "fullname", "searchable": "true" },
                { "data": "mobile_number", "searchable": "true" },
                { "data": "is_member", "searchable": "true" },
                { "data": "create_dttm", "searchable": "true" },
                { "data": "create_dttm", "searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        //html += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.product_id+'\');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> DELETE</a>';
                        html += ' <a href="<?php echo base_url(); ?>admin_customer/admin_view_customer_detail/?page=customer_detail&customer_id='+row.customer_id+'" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> VIEW</a>';
                        return html;
                    } }
            ],
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0
                }
            ],
        });



    });




    function reload_datatable(){
        blockUI();
        datatable_el1.ajax.reload(function(){
            unblockUI();
        });
    }
    function filter_datatable(){
        blockUI();
        datatable_el1.ajax.reload(function(){
            unblockUI();
        });
    }
</script>

<script type="text/javascript">
    function quick_delete(product_id){
        swal({
                title: "Are you sure?",
                text: "This action cannot be undone",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
            function(){
                $.ajax({
                    url: "<?php echo base_url(); ?>admin_product/ajax_admin_delete_product",
                    type: "POST",
                    dataType: "json",
                    data: {
                        postdata: {
                            product_id: product_id
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){
                            datatable_el.ajax.reload(function(){
                                swal("Success!", "Product deleted!", "success");
                            });
                        } else {
                            sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                    }
                })
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
</script>