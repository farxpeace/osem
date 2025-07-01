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
                            <th>REGISTER DATE</th>
                            <th>FULLNAME</th>
                            <th>MYKAD</th>
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
                "url": "<?php echo base_url(); ?>admin_user/ajax_datatable_admin_list_all_users/?show=<?php echo $this->input->get('show') ?>",
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
                { "data": "uacc_date_added", "render": function(data, type, row){
                        var html = "";
                        html += row.uacc_date_added;

                        return html;
                    }  },
                { "data": "fullname", "render": function(data, type, row){
                        var html = "";
                        html += row.fullname+"<br>";


                        html += '<div class="dropdown"><a href="#" class="btn btn-sm btn-primary" data-bs-toggle="dropdown">';
                        html += '<span>User Detail</span><em class="icon ni ni-chevron-down"></em></a> ';
                        html += '<div class="dropdown-menu dropdown-menu-end dropdown-menu-md mt-1"> ';
                        html += '<ul class="link-list-plain">';

                        html += '<li><a href="<?php echo base_url(); ?>admin_order/order_detail/?page=personal_information&simcard_order_id='+row.simcard_order_id+'" ><em class="icon ni ni-user-circle"></em> User Information</a></li>';
                        html += '<li><a href="<?php echo base_url(); ?>admin_order/order_detail/?page=dms_log&simcard_order_id='+row.simcard_order_id+'" ><em class="icon ni ni-repeat"></em> DMS Log</a></li>';
                        html += '<li><a href="<?php echo base_url(); ?>admin_order/order_detail/?page=status_list&simcard_order_id='+row.simcard_order_id+'" ><em class="icon ni ni-file-text"></em> Status List</a></li>';

                        html += '</ul></div></div>';

                        return html;
                    }  },
                { "data": "nric_number", "render": function(data, type, row){
                        var html = "";
                        html += row.nric_number+"<br>";
                        if(row.nric_number){
                            if(row.mykad_front_verification_status == 'pending_admin_verification'){
                                html += '<span class="badge badge_parent bg-warning"><i class="badge_title badge_title_order">order</i> Pending admin</span><br />';
                            }
                        }


                        return html;
                    } },
                { "data": "wallet_myloan_balance", "render": function(data, type, row){
                        var html = "";
                        html += "RM "+row.wallet_myloan_balance+"<br>";

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
