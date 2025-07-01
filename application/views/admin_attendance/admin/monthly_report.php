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
<div class="nk-block-head nk-block-head-sm d-print-none">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Attendances</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">

                    </ul>
                </div>
            </div>
        </div><!-- .nk-block-head-content -->
    </div><!-- .nk-block-between -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-bordered card-preview">
            <div class="card-inner-group">
                <div class="card-inner d-print-none">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Shift Month</label>

                                <div class="form-control-wrap">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="form-control-select">
                                                <select class="form-control" id="filter_month" style="width: 160px;">
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
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Staff</label>
                                <div class="form-control-select">
                                    <select class="form-control" id="filter_uacc_id">
                                        <option value="0">Please select Staff</option>
                                        <option value="all" <?php if($filter_uacc_id == 'all'){ echo 'selected=""'; } ?>>⭐ All Staff</option>
                                        <?php foreach($this->far_staff->list_all_staff() as $a => $b){ ?>
                                            <option value="<?php echo $b['uacc_id'] ?>" <?php if($filter_uacc_id == $b['uacc_id']){ echo "selected=''"; } ?>><?php echo strtoupper($b['fullname']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1" style="display: block">&nbsp;</label>
                                <button type="button" class="btn btn btn-primary" onclick="filter();">Filter</button>
                                <button type="button" class="btn btn btn-warning" onclick="filter('print');">Print</button>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="frame_load_monthly_report">
                    <?php if(count($final_list) > 0){ ?>
                        <?php foreach($final_list as $a => $b){ ?>
                            <div class="card-inner">
                                <table class=" nowrap table table-bordered" data-export-title="Export" style="width: 50%">
                                    <tbody>
                                    <tr>
                                        <td><b>STAFF NAME</b></td>
                                        <td><?php echo strtoupper($b['user_detail']['fullname']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>ATTENDANCE MONTH</b></td>
                                        <td><?php echo $b['attendance_month'] ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class=" nowrap table table-bordered mt-2" data-export-title="Export">
                                    <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>CLOCK-IN</th>
                                        <th>CLOCK-OUT</th>
                                        <th>PREP OT</th>
                                        <th>WORK</th>
                                        <th>NIGHT OT</th>
                                        <th>TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($b['list_attendance'] as $c => $d){ ?>
                                        <tr>
                                            <td><?php echo $d['shift_date'] ?></td>
                                            <td><?php echo $d['clockin_dttm'] ?></td>
                                            <td><?php echo $d['clockout_dttm'] ?></td>
                                            <td>
                                                <?php if($d['prework_sum_rate'] > 0){ ?>
                                                    <?php echo $d['prework_sum_rate'] ?>
                                                <?php }else{ ?>
                                                    -
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($d['work_sum_rate'] > 0){ ?>
                                                    <?php echo $d['work_sum_rate'] ?>
                                                <?php }else{ ?>
                                                    -
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($d['overtime_sum_rate'] > 0){ ?>
                                                    <?php echo $d['overtime_sum_rate'] ?>
                                                <?php }else{ ?>
                                                    -
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($d['calculate_grand_pay'] > 0){ ?>
                                                    <?php echo $d['calculate_grand_pay'] ?>
                                                <?php }else{ ?>
                                                    -
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="text-align: right; font-weight: bold">TOTAL PAY FOR <?php echo $b['attendance_month'] ?></td>
                                            <td style="font-weight: bold">RM <?php echo $b['total_pay'] ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        <?php } ?>
                    <?php }else{ ?>
                    <div class="card-inner">
                        <div class="alert alert-fill alert-primary alert-icon">
                            <em class="icon ni ni-alert-circle"></em> <strong>No data</strong>. Please choose Date & Staff
                        </div>
                    </div>
                    <?php } ?>

                </div>

            </div>

        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>

<script>
    $(function(){

    });

</script>
<script>
    function filter(type){
        var filter_month = $("#filter_month").val();
        var filter_year = $("#filter_year").val();
        var filter_uacc_id = $("#filter_uacc_id").val();

        var redirect_url = "/admin_attendance/monthly_report/?";
        var params = [];
        params.push("filter_month="+filter_month);
        params.push("filter_year="+filter_year);
        params.push("filter_uacc_id="+filter_uacc_id);

        var final_params = params.join("&");
        redirect_url += final_params;

        if(type == 'print'){
            window.print();
        }else{
            blockUI_secondary();
            window.location.replace(redirect_url);
        }

    }
</script>
<script>

    function onchange_filter_shift_date_type(){
        var filter_shift_date_type = $("#filter_shift_date_type").val();
        if(parseInt(filter_shift_date_type) > 0){
            $("#frame_filter_shift_date_year").show();
        } else {
            $("#frame_filter_shift_date_year").hide();
        }

        redirect_filter_shift_date()
    }
    function set_filter_shift_date(){

    }
    function lastDateOfMonth(y, m){
        // Create a new Date object representing the last day of the specified month
        // By passing m + 1 as the month parameter and 0 as the day parameter, it represents the last day of the specified month
        return new Date(y, m + 1, 0).getDate();
    }
    function redirect_filter_shift_date(){

        var redirect_url = "/admin_attendance/datatable_admin_list_all_attendance/?";
        var params = [];
        var filter_shift_date_type = $("#filter_shift_date_type").val();
        var filter_shift_date_startrange = $('#filter_shift_date input[name=start]').data('datepicker').getFormattedDate('yyyy-mm-dd');
        var filter_shift_date_endrange = $('#filter_shift_date input[name=end]').data('datepicker').getFormattedDate('yyyy-mm-dd');
        if(filter_shift_date_type == 'custom_range'){
            params.push("filter_shift_date_type=custom_range");
            if(filter_shift_date_startrange.length > 3 && filter_shift_date_endrange.length > 3){
                params.push("start="+filter_shift_date_startrange);
                params.push("end="+filter_shift_date_endrange);
            }
        } else if(filter_shift_date_type == 'all'){
            params.push("filter_shift_date_type=all");
            params.push("start=2025-01-01");
            params.push("end=2030-12-31");
        } else if(parseInt(filter_shift_date_type) > 0){
            params.push("filter_shift_date_type="+filter_shift_date_type);
            var month = filter_shift_date_type;
            var year = $("#filter_shift_date_year").val();
            params.push("filter_month="+month);
            params.push("filter_year="+year);

            //start
            var firstDateofMonth = year+"-"+month+"-01";
            params.push("start="+firstDateofMonth);
            //end
            var lastDateOfMonthFinal = lastDateOfMonth(month, year);
            params.push("end="+lastDateOfMonthFinal);
        }
        var final_params = params.join("&");
        redirect_url += final_params;
        blockUI_secondary();
        window.location.replace(redirect_url);
        console.log(redirect_url);


    }

</script>

<script type="text/javascript">
    function open_modal_add_product(){
        $('#modal_add_new_product').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
</script>
<script>
    function btn_click_add_new_product(){
        var error_el;
        $(".has-error").removeClass('has-error');
        $(".error_message").hide();
        var post_title = $("#post_title").val();
        Metronic.blockUI({
            boxed: true,
            message: 'Sending data to server...'
        });
        $.ajax({
            url: '<?php echo base_url(); ?>admin_product/admin_ajax_add_product',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    post_title: post_title
                }
            },
            success: function(data){
                Metronic.unblockUI();
                if(data.status == "success"){
                    swal({
                        title: "Success!",
                        text: "Product added. Please update information in the next page",
                        type: "success",
                        closeOnConfirm: true
                    },function(){
                        window.location.href = data.redirect_url;
                    })
                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');
                            $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                        } else {
                            sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                        console.log(i);
                        console.log(j)
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
                "url": "<?php echo base_url(); ?>admin_attendance/ajax_datatable_admin_list_all_attendance/?start=<?php echo $start; ?>&end=<?php echo $end; ?>",
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
                { "data": "shift_date", "searchable": "true" },
                { "data": "fullname", "searchable": "true" },
                { "data": "clockin_dttm", "searchable": "true" },
                { "data": "clockout_dttm","searchable": "true", "render": function ( data, type, row ) {
                        html = "";
                        if(row.clockout_dttm){
                            if((row.clockout_dttm).length < 3){

                            }else{
                                html += row.clockout_dttm;
                            }
                        } else {
                            html += '<a href="javascript: void(0);" onclick="javascript: checkout_manual(\''+row.attendance_id+'\',\''+row.fullname+'\',\''+row.clockin_dttm+'\',\'<?php echo date("Y-m-d",strtotime(' +1 day')) ?>\');" class="btn btn-round btn-sm btn-danger"><i class="fa fa-times"></i> CLOCK-OUT</a>';
                        }
                        return html
                    } },
                { "data": "has_prework","searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        if(row.has_prework == "yes"){
                            html += '✅';
                        } else {
                            html += '❌';
                        }
                        return html
                    } },
                { "data": "has_work","searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        if(row.has_work == "yes"){
                            html += '✅';
                        } else {
                            html += '❌';
                        }
                        return html
                    } },
                { "data": "has_overtime","searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        if(row.has_overtime == "yes"){
                            html += '✅';
                        } else {
                            html += '❌';
                        }
                        return html
                    } },
                { "data": "attendance_id", "searchable": "false", "render": function ( data, type, row ) {
                        html = "";
                        //html += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.product_id+'\');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> DELETE</a>';
                        //html += ' <a href="<?php echo base_url(); ?>admin_product/admin_view_product_detail/?page=product_detail&product_id='+row.product_id+'" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> VIEW</a>';
                        return html;
                    } }
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

<script>
    function checkout_manual(attendance_id,fullname, checkin_time, checkout_date){
        var html = "PR Name : "+fullname+"<br><br>";
        html += 'Check-In Time : '+checkin_time+"<br><br>";
        html += '<div class="row"><div class="col-12 mb-3">Set Check-Out Time</div><div class="col-6"><input type="date" id="checkout_date" class="form-control" value="'+checkout_date+'"></div>';
        html += '<div class="col-6"><input type="time" id="checkout_time" class="form-control" value="01:00:00"></div></div>'
        Swal.fire({
            title: "Are you sure?",
            html: html,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, check-out this Staff"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '/admin_attendance/admin_manual_checkout',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            attendance_id: attendance_id,
                            checkout_time: $("#checkout_date").val()+" "+$("#checkout_time").val()
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == 'success'){
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "Clock-Out for "+fullname+" success",
                            });
                            setTimeout(function(){
                                window.location.reload();
                            }, 1500)
                        }
                    }
                })
            }
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