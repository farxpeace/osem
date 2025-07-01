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
            <h3 class="nk-block-title page-title">Attendances</h3>
        </div><!-- .nk-block-head-content -->
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li class="nk-block-tools-opt">
                            <a href="void(0);" onclick="open_modal_add_attendance()" class="toggle btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add Attendance</span></a>
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
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Shift Date</label>

                                <div class="form-control-wrap">
                                    <div class="input-group">
                                        <div class="input-daterange input-group" id="filter_shift_date">
                                            <input type="text" class="input-sm form-control" name="start" value="<?php echo $start; ?>" />
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="input-sm form-control" name="end" value="<?php echo $end; ?>" />
                                            <div class="input-group-append">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="filter_shift_date_type">
                                                        <option value="custom_range" <?php if($filter_shift_date_type == "custom_range"){ echo 'selected=""'; } ?>>⭐ Custom range</option>
                                                        <option value="all" <?php if($filter_shift_date_type == "all"){ echo 'selected=""'; } ?>>⏰ All</option>
                                                        <?php
                                                        $start_my    = new DateTime('2024-01');
                                                        $end_my      = new DateTime('2025-01');
                                                        $interval = DateInterval::createFromDateString('1 month');
                                                        $period   = new DatePeriod($start_my, $interval, $end_my);
                                                        foreach ($period as $dt) { ?>
                                                            <option value="<?php echo $dt->format("m") ?>" <?php if($filter_shift_date_type == $dt->format("m")){ echo 'selected=""'; } ?>><?php echo $dt->format("M") ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="input-group-append" id="frame_filter_shift_date_year" style="display: none">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="filter_shift_date_year">
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
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-inner">
                    <table id="example5" class=" nowrap table table-bordered" data-export-title="Export">
                        <thead>
                        <tr>
                            <th>SHIFT DATE</th>
                            <th>FULLNAME</th>
                            <th>CLOCK-IN</th>
                            <th>CLOCK-OUT</th>
                            <th>PREP</th>
                            <th>WORK</th>
                            <th>OT</th>
                            <th>ACTIONS</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_attendance">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Attendance</h5>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter">
                    <div class="form-group">
                        <label class="form-label" for="full-name">Staff Name</label>
                        <div class="form-control-wrap">
                            <div class="form-control-select">
                                <select class="form-control" id="new_attendance_staff_uacc_id">
                                    <option value="0">Please select Staff</option>
                                    <?php foreach($this->far_staff->list_all_staff() as $a => $b){ ?>
                                        <option value="<?php echo $b['uacc_id']; ?>"><?php echo $b['fullname']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="full-name">Clock-In</label>
                        <div class="form-control-wrap">
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" id="checkin_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                </div>
                                <div class="col-6">
                                    <input type="time" id="checkin_time" class="form-control" value="15:00:00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="full-name">Clock-Out</label>
                        <div class="form-control-wrap">
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" id="checkout_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                </div>
                                <div class="col-6">
                                    <input type="time" id="checkout_time" class="form-control" value="23:00:00">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <div id="frame_validate"></div>
            </div>
            <div class="modal-footer bg-light" style="display: block">

                <button type="button" onclick="javascript: validate_new_attendance();" class="btn btn-lg btn-warning pull-left">Validate</button>

                <button type="button" onclick="javascript: submit_new_attendance();" class="btn btn-lg btn-primary pull-right d-none" id="submit_new_attendance">Submit</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/dashlite_footer'); ?>

<script>
    function validate_new_attendance(){
        var staff_uacc_id = $("#new_attendance_staff_uacc_id").val();
        if(staff_uacc_id < 1){
            Swal.fire({ icon: "error", title: "Oopss..", text: "Please choose staff" }); return false;
        }
        var checkin_dttm = $("#checkin_date").val()+" "+$("#checkin_time").val();
        var checkout_dttm = $("#checkout_date").val()+" "+$("#checkout_time").val();

        $("#frame_validate").load('/admin_attendance/validate_new_attendance', {
            postdata: {
                staff_uacc_id: staff_uacc_id,
                checkin_dttm: checkin_dttm,
                checkout_dttm: checkout_dttm
            }
        }, function(){

        })


    }
</script>
<script>
    function submit_new_attendance(){
        var staff_uacc_id = $("#new_attendance_staff_uacc_id").val();
        if(staff_uacc_id < 1){
            Swal.fire({ icon: "error", title: "Oopss..", text: "Please choose staff" }); return false;
        }
        var checkin_dttm = $("#checkin_date").val()+" "+$("#checkin_time").val();
        var checkout_dttm = $("#checkout_date").val()+" "+$("#checkout_time").val();

        SwalDompet.fire({

            title: "Confirmation",
            html: "Add new attendance for this person ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin_attendance/ajax_admin_add_new_attendance/',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            staff_uacc_id: staff_uacc_id,
                            checkin_dttm: checkin_dttm,
                            checkout_dttm: checkout_dttm
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'Attendance added', 2500).then(
                                function(value) {
                                    reload_datatable()
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

<script>
    $(function(){
        $('#filter_shift_date').datepicker({
            format: "yyyy-mm-dd",
            startView: 2
        })
        $("#filter_shift_date input[name=start], #filter_shift_date input[name=end]").on("change", function(){
            $("#filter_shift_date_type").val("custom_range");
            onchange_filter_shift_date_type();
        });

        $("#filter_shift_date_type, #filter_shift_date_year").on("change", function(){
            onchange_filter_shift_date_type();
        });

        <?php if(strlen($this->input->get('filter_year') ?? "") > 1){ ?>
        $("#frame_filter_shift_date_year").show();
        <?php } ?>
    })
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
    function open_modal_add_attendance(){
        $('#modal_add_attendance').modal('show');
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
                        html += '<a href="javascript: void(0);" onclick="javascript: quick_delete(\''+row.attendance_id+'\');" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> DELETE</a>';
                        //html += ' <a href="<?php echo base_url(); ?>admin_product/admin_view_product_detail/?page=product_detail&product_id='+row.product_id+'" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> VIEW</a>';
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

<script>
    function checkout_manual(attendance_id,fullname, checkin_time, checkout_date){
        var html = "Staff Name : "+fullname+"<br><br>";
        html += 'Check-In Time : '+checkin_time+"<br><br>";
        html += '<div class="row"><div class="col-12 mb-3">Set Check-Out Time</div><div class="col-6"><input type="date" id="new_checkout_date" class="form-control" value="'+checkout_date+'"></div>';
        html += '<div class="col-6"><input type="time" id="new_checkout_time" class="form-control" value="01:00:00"></div></div>'
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
                            checkout_time: $("#new_checkout_date").val()+" "+$("#new_checkout_time").val()
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
<script>
    function quick_delete(attendance_id){
        SwalDompet.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: "/admin_attendance/ajax_admin_delete_attendance",
                    type: "POST",
                    dataType: "json",
                    data: {
                        postdata: {
                            attendance_id: attendance_id
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            datatable_el1.ajax.reload(function(){
                                SwalDompet.fire({
                                    title: "Good job!",
                                    text: "Record deleted!",
                                    icon: "success"
                                });
                            });
                        } else {
                            SwalDompet.fire({
                                icon: "error",
                                title: "Oopss...",
                                text: data.message_single
                            });
                        }
                    }
                })
            }
        });
    }
</script>