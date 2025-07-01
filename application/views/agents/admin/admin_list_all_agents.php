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

            <h3>All Leads</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">
        <div class="col-12">
            <?php if(count($list_all_agent) > 0){ ?>

                <input id="container-search" class="form-control" placeholder="Search here..">

                <div id="searchable-container">
                    <div class="card card-bordered mt-3">
                        <div class="card-inner-group ">
                            <?php foreach($list_all_agent as $a => $b){ ?>
                                <a href="/agents/view_agent_detail/?uacc_id=<?php echo $b['uacc_id']; ?>">
                                    <div class="card-inner card-inner-md single_lead" style="border-bottom: 1px solid #dfdfdf !important;">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span><?php echo $this->far_helper->makeInitialsFromSingleWord($b['fullname']) ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?php echo $b['fullname'] ?></span>
                                                <span class="sub-text"><?php echo $b['mobile_number'] ?></span>
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
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('/auth_admin/dashboard/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script>
    $(function(){
        $("#lead_id").on("change", function(){
            onchange_lead_id();
        });

        $( '#searchable-container' ).searchable({
            searchField: '#container-search',
            selector: '.single_lead',
            childSelector: '.user-card',
            show: function( elem ) {
                elem.slideDown(500);
            },
            hide: function( elem ) {
                elem.slideUp( 500 );
            }
        })
    });
    function onchange_lead_id(){
        var lead_id = $("#lead_id").val();

        blockUI_secondary();
        window.location.replace("/leads/history/?lead_id="+lead_id);
    }
</script>
