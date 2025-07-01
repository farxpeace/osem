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
            <?php if(count($list_all_leads) > 0){ ?>

                <input id="container-search" class="form-control" placeholder="Search here..">

                <div id="searchable-container">
                    <?php foreach($list_all_leads as $a => $b){ ?>
                        <div class="card card-bordered single_lead mt-3">
                            <div class="card-inner-group ">
                                <div class="card-inner">
                                    <div class="project">
                                        <div class="project-head">
                                            <a href="#" class="project-title">
                                                <div class="user-avatar sq bg-purple"><span><?php echo $this->far_helper->makeInitialsFromSingleWord($b['company_name']) ?></span></div>
                                                <div class="project-info">
                                                    <h6 class="title" style="margin-bottom: 2px !important;"><?php echo $b['company_name'] ?></h6>
                                                    <span class="sub-text"><?php echo $b['pic_name'] ?></span>
                                                </div>
                                            </a>

                                        </div>
                                        <div class="project-details">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="btn-group btn-block">
                                                        <a href="tel:+<?php echo $b['pic_mobile'] ?>" type="button" class="btn btn-outline-primary"><?php echo $b['pic_mobile'] ?></a>
                                                        <?php if(strlen($b['pic_email']) > 3){ ?>
                                                            <a href="mailto:<?php echo $b['pic_email'] ?>" type="button" class="btn btn-outline-primary"><?php echo $b['pic_email'] ?></a>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="project-progress">
                                            <div class="project-progress-details">

                                                <div class="project-progress-percent"><?php echo $b['countdown_percentage'] ?>% from expired date.</div>
                                            </div>
                                            <div class="progress progress-pill progress-md bg-danger">
                                                <div class="progress-bar" data-progress="<?php echo $b['countdown_percentage'] ?>" style="width: <?php echo $b['countdown_percentage'] ?>%; background-color: #0ac968; border-top-left-radius: 0; border-bottom-left-radius: 0;"></div>

                                            </div>
                                        </div>
                                        <ul class="team-info">
                                            <li><span>Countdown</span><span class="badge badge-dim bg-danger" style="padding: 3px 12px !important"><span style="font-size: 0.9rem;"><?php echo $b['countdown_days'] ?> Days Left</span></span></li>
                                            <li><span>Expired Date</span><span class="badge badge-dim bg-danger" style="padding: 3px 12px !important"><span style="font-size: 0.9rem;"><?php echo $this->far_date->convert_format($b['expired_dttm'], 'l, j F Y') ?></span></span></li>
                                            <li>
                                                <span>Status</span>
                                                <span><span class="badge bg-info" style="color: #FFFFFF; font-size: 14px;"><?php echo $b['status_text'] ?></span></span>
                                            </li>
                                        </ul>
                                        <div class="project-meta">



                                        </div>
                                    </div>
                                </div>
                                <div class="card-inner card-inner-md">
                                    <h4 class="product-title" style="text-align: center;">Booth Details</h4>
                                    <ul class="team-statistics">
                                        <li><span>RM<?php echo $this->far_helper->number_format_short($b['booth_price_single']); ?></span><span>Price</span></li>
                                        <li><span><?php echo $b['booth_count'] ?></span><span>Booth<sup>(s)</sup></span></li>
                                        <li><span>RM<?php echo $this->far_helper->number_format_short($b['booth_price_total']); ?></span><span>Total Price</span></li>
                                    </ul>

                                </div>
                                <div class="card-inner card-inner-md">
                                    <h4 class="product-title" style="text-align: center;">Sponsor Details</h4>
                                    <ul class="team-statistics">
                                        <li><span>RM<?php echo $this->far_helper->number_format_short($b['sponsor_amount']); ?></span><span>Amount</span></li>
                                        <li><span><?php echo $b['sponsor_title'] ?></span><span>Title</span></li>
                                    </ul>

                                </div>
                            </div>

                        </div>
                    <?php } ?>
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
            childSelector: '.card-inner-group',
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
