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
            <h3 class="nk-block-title page-title">Reserve Balance Listing</h3>
        </div><!-- .nk-block-head-content -->

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
                            <th>BALANCE RESERVED</th>
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
<?php $this->load->view('includes/dashlite_footer'); ?>


<script type="text/javascript">
    function open_modal_add_product(){
        $('#modal_add_new_product').modal({
            backdrop: 'static',
            keyboard: false
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
                "url": "/admin_customer/ajax_datatable_reserve_balance_listing",
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
                { "data": "reserved_balance", "searchable": "true" },
                { "data": "create_dttm", "searchable": "true" },
                { "data": "create_dttm", "searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        //html += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.product_id+'\');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> DELETE</a>';
                        html += ' <a href="<?php echo base_url(); ?>admin_customer/admin_view_customer_detail/?page=reserve_detail&customer_id='+row.customer_id+'" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> VIEW</a>';
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