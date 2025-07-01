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
            <h3 class="nk-block-title page-title">Fulfillment</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="javascript: void(0);" data-bs-toggle="modal" data-bs-target="#modal_add_staff" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Fulfillment</span></a>
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
                <table id="example5" class=" nowrap table" data-export-title="Export">
                    <thead>
                    <tr>
                        <th>USER DETAIL</th>
                        <th>LINKED</th>
                        <th>CONSENT</th>
                        <th>WALLET</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_staff">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fulfillment Info</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="full-name">Username</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="new_staff_username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Password</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="new_staff_password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Full Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="new_staff_fullname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="full-name">Link user account</label>
                        <div class="form-control-wrap">
                            <select class="form-control" id="new_staff_link_account_uacc_id">
                                <option value="0">Dont link with any accounts</option>
                                <?php foreach($this->far_users->list_all_user() as $a => $b){ ?>
                                    <option value="<?php echo $b['uacc_id'] ?>"><?php echo $b['fullname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" onclick="javascript: generate_demo_user();" class="btn btn-lg btn-primary pull-left" style="margin-right: auto">Demo user</button>
                <button type="button" onclick="javascript: submit_create_new_staff();" class="btn btn-lg btn-primary pull-right">Create</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>
<script src="<?php echo base_url() ?>assets/jquery-malaysia-user-generator.js?time=<?php echo time(); ?>"></script>
<script>
    function generate_demo_user(){
        $.FaraUserGenerator.init({
            prepend_username: 'staff_'
        },function(output_data){
            $("#new_staff_username").val(output_data.username);
            $("#new_staff_password").val(output_data.password)
            $("#new_staff_fullname").val(output_data.fullname)
        });
    }
    function submit_create_new_staff(){
        var html_content = "Create new staff ?";
        SwalDompet.fire({
            title: 'Are you sure?',
            html: html_content,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            showLoaderOnConfirm: true
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin_users/ajax_admin_create_new_staff/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            uacc_username: $("#new_staff_username").val(),
                            uacc_raw_password: $("#new_staff_password").val(),
                            fullname: $("#new_staff_fullname").val(),
                            link_account_uacc_id: $("#new_staff_link_account_uacc_id").val(),
                            uacc_group_fk: '9'
                        }
                    },
                    success: function(data){
                        if(data.status == "success"){
                            unblockUI();
                            let timerInterval
                            Swal.fire({
                                title: 'Success',
                                html: 'Automatically close in <b></b> milliseconds.',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log('I was closed by the timer')
                                }
                            })
                            window.location.reload();
                        }else{
                            unblockUI();
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');
                                    $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                } else {
                                }
                                SwalDompet.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: j,
                                })
                            });
                        }
                    }
                });
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
                "url": "<?php echo base_url(); ?>admin_users/ajax_datatable_admin_list_all_fulfillment/?show=<?php echo $this->input->get('show') ?>",
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
            "order": [2, 'desc'],
            "columns": [
                { "data": "fullname", "render": function(data, type, row){
                        var html = "";
                        html += row.uacc_username+"<br>";
                        html += row.fullname+"<br>";
                        html += '<div class="dropout"><a href="#" class="btn btn-sm btn-primary" data-bs-toggle="dropdown">';
                        html += '<span>User Detail</span><em class="icon ni ni-chevron-down"></em></a> ';
                        html += '<div class="dropdown-menu mt-1"> ';
                        html += '<ul class="link-list-plain">';
                        html += '<li><a href="<?php echo base_url(); ?>admin_users/admin_view_user_detail/?page=staff_information&uacc_id='+row.uacc_id+'" ><em class="icon ni ni-user-circle"></em> Staff Information</a></li>';
                        html += '</ul></div></div>';
                        return html;
                    }  },
                { "data": "nric_number", "render": function(data, type, row){
                        var html = "";
                        if(row.user_detail){
                            if(row.user_detail.linked_uacc_id){
                                html += "<span>"+row.user_detail.linked_account_detail.uacc_username+"</span><br />";
                                html += "<span>"+row.user_detail.linked_account_detail.fullname+"</span><br />";
                            }
                        }
                        if(row.fullname_as_per_mykad){
                            html += row.fullname_as_per_mykad+"<br>";
                            html += '<span class="time">'+row.nric_number+'</span>';
                            if(row.mykad_front_verification_status == 'pending_admin_verification'){
                                html += '<span class="badge badge-sm bg-warning">Pending admin</span><br />';
                            } else if(row.mykad_front_verification_status == 'verified'){
                                html += '<span class="badge badge-sm bg-success">Verified</span><br />';
                            }else{
                                html += row.mykad_front_verification_status
                            }
                        }
                        return html;
                    } },
                { "data": "signature_verification_status", "render": function(data, type, row){
                        var html = "";
                        if(row.signature_verification_status){
                            if(row.signature_verification_status == 'verified'){
                                html += '<span class="badge badge-sm bg-success">Signed</span><br />';
                            } else if(row.signature_verification_status == 'pending_user_signature'){
                                html += '<span class="badge badge-sm bg-warning">Pending User Signature</span><br />';
                            }else{
                                html += row.signature_verification_status
                            }
                        }
                        return html;
                    } },
                { "data": "wallet_myloan_total", "render": function(data, type, row){
                        var html = "";
                        html += "RM "+row.wallet_myloan_total+"<br>";
                        return html;
                    }},
            ],
        });
        //document.querySelector('div.toolbar').innerHTML = '<b>Custom tool bar! Text/images etc.</b>';


        $("#new_staff_link_account_uacc_id").select2({
            placeholder: "Select a user",
            allowClear: true,
            dropdownParent: $("#modal_add_staff")
        });
    });
    function reload_datatable(){
        blockUI();
        datatable_el.ajax.reload(function(){
            unblockUI();
        });
    }
</script>