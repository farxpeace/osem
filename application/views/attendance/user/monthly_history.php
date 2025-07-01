<?php $this->load->view('includes/tfpay_header'); ?>
    <style>
    </style>
    <div class="header is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
        <div class="tf-container">
            <div class="tf-statusbar d-flex justify-content-center align-items-center">
                <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>History</h3>
            </div>
        </div>
    </div>
    <div id="app-wrap" style="margin-bottom: 50px;">
        <div class="row mt-3 ms-1 me-1">
            <div class="col-8">
                <div class="form-group">
                    <div class="form-control-wrap ">
                        <div class="form-control-select">
                            <select class="form-control" id="filter_month">
                                <?php for($month_number = 1; $month_number<=12; $month_number++){ ?>
                                    <?php $month_no = date("m", mktime(0, 0, 0, $month_number, 1)) ?>
                                    <option <?php if($month_no == $filter_month){ echo 'selected=""'; } ?> value="<?php echo $month_no; ?>"><?php echo date("F", mktime(0, 0, 0, $month_number, 1)); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <div class="form-control-wrap ">
                        <div class="form-control-select">
                            <select class="form-control" id="filter_year">
                                <option value="2024" <?php if($filter_year == '2024'){ echo 'selected=""'; } ?>>2024</option>
                                <option value="2025" <?php if($filter_year == '2025'){ echo 'selected=""'; } ?>>2025</option>
                                <option value="2026" <?php if($filter_year == '2026'){ echo 'selected=""'; } ?>>2026</option>
                                <option value="2027" <?php if($filter_year == '2027'){ echo 'selected=""'; } ?>>2027</option>
                                <option value="2028" <?php if($filter_year == '2028'){ echo 'selected=""'; } ?>>2028</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 me-1 ms-1">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner" style="padding-top: 0;">
                        <div class="team">

                            <div class="user-card user-card-s2">

                                <div class="user-info">
                                    <h6 style="font-size: 1.5rem !important;">RM <?php echo $total_pay_by_month_year['total_calculate_grand_pay'] ?></h6>
                                    <span class="sub-text">Total pay for current month</span>
                                </div>
                            </div>
                            <ul class="team-info">
                                <li><span>Prep Work</span><span>RM <?php echo $total_pay_by_month_year['total_prework_sum_rate'] ?></span></li>
                                <li><span>Work</span><span>RM <?php echo $total_pay_by_month_year['total_work_sum_rate'] ?></span></li>
                                <li><span>Overtime</span><span>RM <?php echo $total_pay_by_month_year['total_overtime_sum_rate'] ?></span></li>
                            </ul>

                        </div><!-- .team -->
                    </div><!-- .card-inner -->
                </div>
            </div>
        </div>

        <div class="row mt-3 me-1 ms-1">

            <div class="col-12">
                <div class="card card-bordered card-full">
                    <div class="card-inner-group">
                        <?php if(count($list_clockin_clockout_by_month_year) > 0){ ?>
                            <?php foreach($list_clockin_clockout_by_month_year as $a => $b){ ?>
                            <div class="card-inner card-inner-md">
                                <div class="user-card">
                                    <div class="user-info" style="width: 80% !important;">
                                        <span class="lead-text h6"><?php echo $this->far_date->convert_format($b['shift_date'], "l, j F Y") ?></span>
                                        <span class="lead-text mt-1" style="width: 100% !important; display: block">
                                            <div class="row">
                                                <div class="col-4">
                                                    <?php if($b['has_prework'] == "yes"){?>
                                                        ✅
                                                    <?php }else{ ?>
                                                        ❌
                                                    <?php } ?>
                                                    Prep
                                                </div>
                                                <div class="col-4">
                                                    <?php if($b['has_work'] == "yes"){?>
                                                        ✅
                                                    <?php }else{ ?>
                                                        ❌
                                                    <?php } ?>
                                                    Work
                                                </div>
                                                <div class="col-4">
                                                    <?php if($b['has_overtime'] == "yes"){?>
                                                        ✅
                                                    <?php }else{ ?>
                                                        ❌
                                                    <?php } ?>
                                                    Overtime
                                                </div>
                                            </div>
                                        </span>
                                        <span class="sub-text mt-2">Total Pay : RM<?php echo $b['calculate_grand_pay'] ?></span>
                                    </div>
                                    <div class="user-action">
                                        <a href="<?php echo base_url(); ?>attendance/attendance_by_date/?filter_date=<?php echo $b['shift_date'] ?>" class="btn btn-icon btn-trigger me-n2"><em class="icon ni ni-forward-ios"></em></a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="alert alert-danger alert-icon">
                                <em class="icon ni ni-cross-circle"></em> <strong>No data</strong>! We did not find any clockin for this month
                            </div>
                        <?php } ?>




                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>

<?php $this->load->view('includes/tfpay_footer'); ?>
    <script>
        $(function(){
        });
        function open_modal_confirm_purchase_score_report(){
            $("#modal_confirm_purchase_score_report").modal("show");
        }
    </script>
<script>
    $("#filter_month").on("change", function(){
        onchange_filter_month_and_year();
    });
    $("#filter_year").on("change", function(){
        onchange_filter_month_and_year();
    });
    function onchange_filter_month_and_year(){
        var filter_month = $("#filter_month").val();
        var filter_year = $("#filter_year").val();

        blockUI_secondary();
        window.location.replace("<?php echo base_url(); ?>attendance/monthly_history/?filter_month="+filter_month+"&filter_year="+filter_year);
    }
</script>