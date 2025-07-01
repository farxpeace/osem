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
<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner">
                <table id="example5" class=" nowrap table" data-export-title="Export">
                    <thead>
                    <tr>
                        <th>USER DETAIL</th>
                        <th>MYKAD</th>
                        <th>CONSENT</th>
                        <th>WALLET</th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('includes/dashlite_footer'); ?>

<script type="text/javascript">
    var datatable_el;
    var datatable_el1
    $(function(){

        datatable_el1 = NioApp.DataTable('#example5', {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>admin_users/ajax_datatable_admin_list_all_supervisor/?show=<?php echo $this->input->get('show') ?>",
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

                        html += '<li><a href="<?php echo base_url(); ?>admin_users/admin_view_user_detail/?page=user_information&uacc_id='+row.uacc_id+'" ><em class="icon ni ni-user-circle"></em> User Information</a></li>';
                        html += '<li><a href="<?php echo base_url(); ?>admin_users/admin_view_user_detail/?page=list_all_wallet_myloan&uacc_id='+row.uacc_id+'" ><em class="icon ni ni-repeat"></em> Wallet MyLoan</a></li>';
                        html += '<li><a href="<?php echo base_url(); ?>admin_users/admin_view_user_detail/?page=status_list&simcard_order_id='+row.simcard_order_id+'" ><em class="icon ni ni-file-text"></em> Status List</a></li>';

                        html += '</ul></div></div>';

                        return html;
                    }  },
                { "data": "nric_number", "render": function(data, type, row){
                        var html = "";

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
    });

    function reload_datatable(){
        blockUI();
        datatable_el.ajax.reload(function(){
            unblockUI();
        });
    }

</script>
