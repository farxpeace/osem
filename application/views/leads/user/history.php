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

            <h3>Leads History</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">
        <div class="col-12">
            <div class="group-input form-group">
                <label>Company Name</label>
                <select class="form-control" id="lead_id">
                    <option value="0">Please select Leads</option>
                    <?php foreach($this->far_lead->list_all_leads_by_staff($logged_in['uacc_id']) as $a => $b){ ?>

                        <option value="<?php echo $b['lead_id'] ?>" <?php if($b['lead_id'] == $lead_id){ echo "selected='selected'"; } ?>>

                            <?php echo $b['company_name'] ?> (<?php echo $b['pic_mobile'] ?>)</option>
                    <?php } ?>
                </select>
                <span class="help-block error_message" style="display: none;"></span>
            </div>

            <?php if(isset($error_message)){ ?>
                <div class="alert alert-fill alert-primary alert-icon">
                    <em class="icon ni ni-alert-circle"></em> <strong>No data</strong>. Please choose leads from the list
                </div>
            <?php } ?>
        </div>
        <?php if(count($lead_detail ?? []) > 0){ ?>
            <div class="col-12 mt-3">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="team">
                                <div class="user-card user-card-s2">

                                    <div class="user-info">
                                        <h6 style="font-size: 1.3rem"><?php echo $lead_detail['company_name'] ?></h6>
                                        <span class="sub-text"><?php echo $lead_detail['pic_name'] ?></span>
                                        <span class="sub-text">+<?php echo $lead_detail['pic_mobile'] ?></span>
                                    </div>
                                </div>
                                <ul class="team-info">
                                    <li><span>Reg. Date</span><span><?php echo $this->far_date->convert_format($lead_detail['create_dttm'] ?? date("Y-m-d"), "l, j M Y"); ?></span></li>
                                    <li><span>Exp. Date</span><span><?php echo $this->far_date->convert_format($lead_detail['expired_dttm'] ?? date("Y-m-d"), "l, j M Y"); ?></span></li>
                                    <li><span>Countdown</span><span><?php echo $lead_detail['countdown_days']; ?> day<sup>(s)</sup></span></li>
                                </ul>
                                <div class="project-progress">
                                    <div class="project-progress-details">

                                        <div class="project-progress-percent"><?php echo $b['countdown_percentage'] ?>% from expired date.</div>
                                    </div>
                                    <div class="progress progress-pill progress-md bg-danger">
                                        <div class="progress-bar" data-progress="<?php echo $b['countdown_percentage'] ?>" style="width: <?php echo $b['countdown_percentage'] ?>%; background-color: #0ac968; border-top-left-radius: 0; border-bottom-left-radius: 0;"></div>

                                    </div>
                                </div>
                            </div><!-- .team -->
                        </div><!-- .card-inner -->
                        <div class="card-inner card-inner-md">
                            <h4 class="product-title" style="text-align: center;">Booth Details</h4>
                            <ul class="team-statistics">
                                <li><span>RM<?php echo $this->far_helper->number_format_short($lead_detail['booth_price_single']); ?></span><span>Price</span></li>
                                <li><span><?php echo $lead_detail['booth_count'] ?></span><span>Booth<sup>(s)</sup></span></li>
                                <li><span>RM<?php echo $this->far_helper->number_format_short($lead_detail['booth_price_total']); ?></span><span>Total Price</span></li>
                            </ul>

                        </div>
                        <div class="card-inner card-inner-md">
                            <h4 class="product-title" style="text-align: center;">Sponsor Details</h4>
                            <ul class="team-statistics">
                                <li><span>RM<?php echo $this->far_helper->number_format_short($lead_detail['sponsor_amount']); ?></span><span>Amount</span></li>
                                <li><span><?php echo $lead_detail['sponsor_title'] ?></span><span>Title</span></li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner border-bottom bg-lighter py-3">
                            <div class="d-sm-flex align-items-sm-center justify-content-sm-between">
                                <div class="pb-1 pb-sm-0">
                                    <h5 class="title">List Status</h5>
                                </div>
                            </div>
                        </div>

                        <?php foreach($lead_detail['list_all_status'] as $a => $b){ ?>
                            <div class="card-inner border-top">
                                <div class="d-flex">
                                    <div class="fake-class">
                                        <h6 class="mt-0 d-flex align-center"><span><?php echo $b['status_text'] ?></span><span class="badge badge-dim bg-outline-info ms-2"><?php echo $b['created_by_fullname'] ?></span></h6>
                                        <p class="text-soft"><?php echo $this->far_date->convert_format($b['create_dttm'] ?? date("Y-m-d"), "l, j M Y g:i A"); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        <?php } ?>

    </div>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('back');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: navigate_to('/auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    $(function(){
        $("#lead_id").on("change", function(){
            onchange_lead_id();
        })
    });
    function onchange_lead_id(){
        var lead_id = $("#lead_id").val();

        blockUI_secondary();
        window.location.replace("/leads/history/?lead_id="+lead_id);
    }
</script>
