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
            <h3>Agent Detail</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">
        <?php if(count($agent_detail ?? []) > 0){ ?>
            <div class="col-12 mt-3">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="team">
                                <div class="user-card user-card-s2">

                                    <div class="user-info">
                                        <h6 style="font-size: 1.3rem"><?php echo $agent_detail['fullname'] ?></h6>
                                        <span class="sub-text"><?php echo $agent_detail['email'] ?></span>
                                        <span class="sub-text">+<?php echo $agent_detail['mobile_number'] ?></span>
                                    </div>
                                </div>
                                <ul class="team-info">
                                    <li><span>Reg. Date</span><span><?php echo $this->far_date->convert_format($agent_detail['uacc_date_added'] ?? date("Y-m-d"), "l, j M Y"); ?></span></li>
                                    <li><span>Assigned Leads</span><span><?php echo $agent_detail['total_assigned_leads']; ?></span></li>
                                </ul>

                            </div><!-- .team -->
                        </div><!-- .card-inner -->

                    </div>

                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card card-bordered">
                    <div class="card-inner-group">
                        <div class="card-inner border-bottom bg-lighter py-3">
                            <div class="d-sm-flex align-items-sm-center justify-content-sm-between">
                                <div class="pb-1 pb-sm-0">
                                    <h5 class="title">Leads listing</h5>
                                </div>
                            </div>
                        </div>
                        <?php if(count($agent_detail['list_all_leads']) > 0){ ?>
                            <?php foreach($agent_detail['list_all_leads'] as $a => $b){ ?>
                                <a href="/leads/history/?lead_id=<?php echo $b['lead_id'] ?>">
                                    <div class="card-inner card-inner-md single_lead" style="border-bottom: 1px solid #dfdfdf !important;">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span><?php echo $this->far_helper->makeInitialsFromSingleWord($b['company_name']) ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?php echo $b['company_name'] ?></span>
                                                <span class="sub-text"><?php echo $b['company_registration_number'] ?></span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown">
                                                    <em class="icon ni ni-forward-ios"></em>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="card-inner card-inner-md single_lead" style="display: block; text-align: center">
                                <div class="user-card">
                                    No leads for this agent yet


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
