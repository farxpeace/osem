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

            <h3>Product</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="row mt-3 me-1 ms-1" style="margin-bottom: 100px;">

        <div class="col-12">
            <input id="container-search" class="form-control" placeholder="Search here..">
            <div id="searchable-container">
            <?php if(count($list_all_product) > 0){ ?>
                <?php foreach($list_all_product as $a => $b){ ?>
                    <div class="card card-bordered single_lead mt-3">
                        <div class="card-inner">
                            <div class="team">
                                <div class="user-card user-card-s2">
                                    <div class="user-info" style="margin-top: 0 !important;">
                                        <h6><?php echo $b['name'] ?></h6>
                                        <span class="sub-text"><?php echo $b['type'] ?></span>
                                        <span class="sub-text">RM <?php echo $b['ppu'] ?></span>
                                    </div>
                                </div>
                                <div class="card card-bordered card-full">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="card-title-group" style="display: block">
                                                <div class="card-title">
                                                    <h6 class="title" style="text-align: center">Batters</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach($b['batters']['batter'] as $c => $d){ ?>
                                            <div class="card-inner card-inner-md">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php echo $d['type'] ?></span>
                                                        <span class="sub-text"><?php echo $d['id'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                                <div class="card card-bordered card-full mt-3">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="card-title-group" style="display: block">
                                                <div class="card-title">
                                                    <h6 class="title" style="text-align: center">Topping</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php foreach($b['topping'] as $c => $d){ ?>
                                            <div class="card-inner card-inner-md">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php echo $d['type'] ?></span>
                                                        <span class="sub-text"><?php echo $d['id'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div><!-- .team -->
                        </div><!-- .card-inner -->
                    </div>
                <?php } ?>
            <?php } ?>
            </div>
        </div>

    </div>



    <div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
        <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
            <a href="javascript: void(0);" onclick="javascript: navigate_to('back');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
            <a href="javascript: void(0);" onclick="javascript: navigate_to('/page/osem/');" id="btn-popup-up" class="tf-btn accent large"><i class="fa-solid fa-angle-left"></i> Back to Dashboard</a>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<script>
    $(function(){
        $( '#searchable-container' ).searchable({
            searchField: '#container-search',
            selector: '.single_lead',
            childSelector: '.card-inner',
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
