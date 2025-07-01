<?php $this->load->view('includes/tfpay_header'); ?>
<style>
    .bottom-navigation-bar_stack {
        margin: 0 auto;
        padding-top: 10px;
        padding-bottom: 10px;
        bottom: 60px;
        background: transparent;
        box-shadow: inherit;
    }
</style>
<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Attendance</h3>
        </div>
    </div>
</div>
<div id="app-wrap">

    <div class="row mt-3 me-1 ms-1">
        <div class="col-12">
            <div class="card card-bordered pricing">
                <div class="pricing-head">
                    <div class="pricing-title">
                        <h4 class="card-title title" style="font-size: 1.25rem;"><?php echo $this->far_date->convert_format(date("Y-m-d H:i:s"), "D, j M y") ?></h4>
                        <p class="sub-text">View today attendance detail here.</p>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-4">
                                <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $attendance_detail['prework_hour'] ?? 0; ?></span>
                                <span class="sub-text" >Prep Hour<sup>(s)</sup></span>
                            </div>
                            <div class="col-4">
                                <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $attendance_detail['work_hour'] ?? 0 ?></span>
                                <span class="sub-text" >Working Hour<sup>(s)</sup></span>
                            </div>
                            <div class="col-4">
                                <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $attendance_detail['overtime_hour'] ?? 0 ?></span>
                                <span class="sub-text">OT Hour<sup>(s)</sup></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(count($attendance_detail) > 0){ ?>
                <div class="pricing-body">
                    <?php if($attendance_detail['has_prework'] == "yes"){ ?>
                        <ul class="pricing-features">
                            <li><span class="w-50">Prep Start</span> - <span class="ms-auto"><?php echo $this->far_date->human_readable($attendance_detail['prework_start_dttm']) ?></span></li>
                            <li><span class="w-50">Prep End</span> - <span class="ms-auto"><?php echo $this->far_date->human_readable($attendance_detail['prework_end_dttm']) ?></span></li>
                            <li><span class="w-50">Prep Pay</span> - <span class="ms-auto">RM <?php echo $attendance_detail['prework_sum_rate']; ?></span></li>
                        </ul>
                    <?php }else{ ?>
                        <div class="alert alert-warning alert-icon">
                            <em class="icon ni ni-alert-circle"></em>  <strong>No data</strong> No prep hour found for this date.
                        </div>
                    <?php } ?>

                </div>
                <div class="pricing-body border-top">
                    <?php if($attendance_detail['has_work'] == "yes"){ ?>
                    <ul class="pricing-features">
                        <li><span class="w-50">Work Start</span> - <span class="ms-auto"><?php echo $this->far_date->human_readable($attendance_detail['work_start_dttm']) ?></span></li>
                        <li><span class="w-50">Work End</span> - <span class="ms-auto"><?php echo $this->far_date->human_readable($attendance_detail['work_end_dttm']) ?></span></li>
                        <li><span class="w-50">Work Pay</span> - <span class="ms-auto">RM <?php echo $attendance_detail['work_sum_rate']; ?></span></li>
                    </ul>
                    <?php }else{ ?>
                        <div class="alert alert-warning alert-icon">
                            <em class="icon ni ni-alert-circle"></em>  <strong>No data</strong> No working hour found for this date.
                        </div>
                    <?php } ?>
                </div>
                <div class="pricing-body border-top">
                    <?php if($attendance_detail['has_overtime'] == "yes"){ ?>
                    <ul class="pricing-features">
                        <li><span class="w-50">Overtime Start</span> - <span class="ms-auto"><?php echo $this->far_date->human_readable($attendance_detail['overtime_start_dttm']) ?></span></li>
                        <li><span class="w-50">Overtime End</span> - <span class="ms-auto"><?php echo $this->far_date->human_readable($attendance_detail['overtime_end_dttm']) ?></span></li>
                        <li><span class="w-50">Overtime Pay</span> - <span class="ms-auto">RM <?php echo $attendance_detail['overtime_sum_rate']; ?></span></li>
                    </ul>
                    <?php }else{ ?>
                        <div class="alert alert-warning alert-icon">
                            <em class="icon ni ni-alert-circle"></em>  <strong>No data</strong> No overtime hour found for this date.
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <pre><?php //print_r($attendance_detail); ?></pre>
    <pre><?php //print_r($calculate_shift_date); ?></pre>

    <?php if(!$this->far_attendance->is_already_clockout_by_date($logged_in['uacc_id'], $calculate_shift_date['shift_date'])){ ?>
        <div class="row mt-3 me-1 ms-1" style="padding-bottom: 50px;">
            <div class="col-6">
                <a href="javascript: void(0);" onclick="start_clockin();">
                    <div class="card card-bordered product-card">
                        <div class="card-inner text-center">
                            <img src="https://www.svgrepo.com/show/206454/play.svg" style="width: 44px" />
                            <h5 class="product-title">Clock In</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-6">
                <a href="javascript: void(0);" onclick="start_clockout();">
                    <div class="card card-bordered product-card">
                        <div class="card-inner text-center">
                            <img src="<?php echo base_url(); ?>assets/nex/icons/icon_activation_history-256x256.png" style="width: 44px" />
                            <h5 class="product-title">Clock Out</h5>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    <?php } ?>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    function start_clockout(){
        var error_el;
        reset_form_error();
        blockUI_secondary();
        $.ajax({
            url: '<?php echo base_url(); ?>attendance/start_clockout',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    uacc_id: '<?php echo $logged_in["uacc_id"] ?>',
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    swalTimer('success','Success', 'Clockout success', 2000).then(
                        function(value) {

                        },
                    );
                    if(data.redirect_url){
                        //blockUI();
                        setTimeout(function(){
                            //window.top.location.href = data.redirect_url;
                        }, 2000);
                    }else{

                    }



                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');

                            if($("#"+i).closest('.form-group').find('.error_message')){
                                $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                            }else{
                                $("#"+i).after('<span class="error_message">'+j+'</span>');
                                $(".error_message").show();
                            }

                        } else {
                            //sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                        console.log(i);
                        console.log(j)
                    });

                    if($(".form-group.has-error").length > 0){
                        var element_scroll = $(".form-group.has-error").get(0);
                        $('html,body').animate({
                            scrollTop: $(".app-section").offset().top - $(window).height()/2
                        }, 500);
                    }

                    modal_alert_danger("Unable to Process!", data.message_single, "");


                }


            }
        });
    }
</script>
<script>
    function start_clockin(){
        var error_el;
        reset_form_error();
        blockUI_secondary();
        $.ajax({
            url: '<?php echo base_url(); ?>attendance/start_clockin',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    uacc_id: '<?php echo $logged_in["uacc_id"] ?>',
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){

                    swalTimer('success','Success', 'Clockin success', 2000).then(
                        function(value) {

                        },
                    );
                    if(data.redirect_url){
                        //blockUI();
                        setTimeout(function(){
                            //window.top.location.href = data.redirect_url;
                        }, 2000);
                    }else{

                    }



                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');

                            if($("#"+i).closest('.form-group').find('.error_message')){
                                $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                            }else{
                                $("#"+i).after('<span class="error_message">'+j+'</span>');
                                $(".error_message").show();
                            }

                        } else {
                            //sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                        console.log(i);
                        console.log(j)
                    });

                    if($(".form-group.has-error").length > 0){
                        var element_scroll = $(".form-group.has-error").get(0);
                        $('html,body').animate({
                            scrollTop: $(".app-section").offset().top - $(window).height()/2
                        }, 500);
                    }

                    modal_alert_danger("Unable to Process!", data.message_single, "");


                }


            }
        });
    }
</script>
