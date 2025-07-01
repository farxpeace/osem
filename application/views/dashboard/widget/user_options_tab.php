<style>
    .wrapper_user_options {
        text-align:left;
        margin-top: 10px;
    }

    .tabs{
        font-size:13px;
        padding:0px;
        list-style:none;
        background:#fff;
        box-shadow:0px 5px 20px rgba(0,0,0,0.1);
        display:inline-block;
        border-radius:50px;
        position:relative;
        width: 100%;
    }

    .tabs a{
        text-decoration:none;
        color: #777;
        text-transform:uppercase;
        padding:10px 20px;
        display:inline-block !important;
        position:relative;
        z-index:1;
        transition-duration:0.6s;
    }

    .tabs a.active{
        color:#fff;
    }

    .tabs a i{
        margin-right:5px;
    }

    .tabs .selector{
        height:100%;
        display:inline-block;
        position:absolute;
        left:0px;
        top:0px;
        z-index:1;
        border-radius:50px;
        transition-duration:0.6s;
        transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);

        background: rgb(254,60,0);
        background: -moz-linear-gradient(180deg, rgba(254,60,0,1) 0%, rgba(163,40,2,1) 92%);
        background: -webkit-linear-gradient(180deg, rgba(254,60,0,1) 0%, rgba(163,40,2,1) 92%);
        background: linear-gradient(180deg, rgba(254,60,0,1) 0%, rgba(163,40,2,1) 92%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#fe3c00",endColorstr="#a32802",GradientType=1);
    }
</style>
<style>
    .card-button {
        background-color: #eb3904;
    }
    .card-button .lead-text, .card-button .sub-text {
        color: #FFFFFF !important;
    }
    .card-button .icon {
        color: #FFFFFF;
    }

    .card-button-green {
        background-color: #00991a;
    }
    .card-button-green .lead-text, .card-button-green .sub-text {
        color: #FFFFFF !important;
    }
    .card-button-green .icon {
        color: #FFFFFF;
    }
</style>


<div class="wrapper_user_options">
    <nav class="tabs">
        <div class="selector"></div>
        <a href="#" class="active" id="tab_panel_account_holder" data-tab_content="tab_content_account_holder" style="width: 49.5%; text-align: center">Subscriber</a>
        <a href="#" data-tab_content="tab_content_dealer" style="width: 49.5%; text-align: center">Dealer</a>
    </nav>
    <div class="user_options_tab_content" style="padding: 10px 0px">
        <div id="tab_content_account_holder" class="tab_contents"  style="display: none">
            <div class="card card-bordered">
                <div class="card-inner">
                    <h4 class="card-title mb-1" style="font-size: 1rem !important;">Sales &amp; Marketing board</h4>
                    <div class="row mt-3">
                        <div class="col-12" style="text-align: center">
                            <span class="h4 fw-500" style="font-size: 1.5rem; font-weight: 700;"><?php echo $this->far_visitor->count_total_visitor($logged_in['uacc_id']); ?></span>
                            <span class="sub-text">Visitor<sup>(s)</sup></span>
                        </div>
                    </div>
                    <div class="collapse" id="collapseDes1" style="">
                        <div class="divider">
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-bordered h-100">
                                    <div class="card-inner mb-n2">
                                        <div class="card-title-group">
                                            <div class="card-title card-title-sm">
                                                <h6 class="title">Top 5 Visitor</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-list is-compact">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span>Location</span></div>
                                            <div class="nk-tb-col text-end"><span>Visitor</span></div>
                                        </div><!-- .nk-tb-head -->
                                        <?php foreach($this->far_visitor->top_5_visitor_location($logged_in['uacc_id']) as $a => $b){ ?>
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span class="tb-sub"><span><?php echo $b['city'].", ".$b['region'].", ".$b['country'] ?></span></span>
                                            </div>
                                            <div class="nk-tb-col text-end">
                                                <span class="tb-sub tb-amount"><span><?php echo $b['total_visitor'] ?></span></span>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div><!-- .nk-tb-list -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer rating-card-footer bg-light border-top d-flex align-center justify-content-between">
                    <a class="switch-text collapsed" data-bs-toggle="collapse" href="#collapseDes1" aria-expanded="false">
                        <div class="link link-gray switch-text-normal">
                            <span>Less Info</span><em class="icon ni ni-upword-ios"></em>
                        </div>
                        <div class="link link-gray switch-text-collapsed">
                            <span>More Info</span><em class="icon ni ni-downward-ios"></em>
                        </div>
                    </a>
                    <a href="javascript: void(0);" onclick="javascript: share_alias_url_name();" class="btn btn-sm btn-primary">Invite your friend <i class="fa-solid fa-share"></i></a>
                </div>
            </div>


        </div>


        <div id="tab_content_dealer" class="tab_contents"  style="display: none">



            <div class="row mt-3">
                <div class="col-12">
                    <a href="<?php echo base_url(); ?>dealer/list_dealer_package/">
                        <div class="card card-bordered card-full card-button-green">
                            <div class="card-inner-group">
                                <div class="card-inner card-inner-md">
                                    <div class="user-card">
                                        <div class="user-avatar" style="background-color: transparent !important;">
                                            <img src="https://www.svgrepo.com/show/217712/package-shipping-and-delivery.svg" style="border-radius: 0" />
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text">Dealer Package</span>
                                            <span class="sub-text">Become a Dealer with exclusive offer</span>
                                        </div>
                                        <div class="user-action">
                                            <em class="icon ni ni-forward-ios"></em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="<?php echo base_url(); ?>dealer/my_network_dashboard/">
                        <div class="card card-bordered card-full card-button-green">
                            <div class="card-inner-group">
                                <div class="card-inner card-inner-md">
                                    <div class="user-card">
                                        <div class="user-avatar" style="background-color: transparent !important;">
                                            <img src="https://www.svgrepo.com/show/299279/users-group.svg" style="border-radius: 0" />
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text">My Network</span>
                                            <span class="sub-text">Manage your downline structure</span>
                                        </div>
                                        <div class="user-action">
                                            <em class="icon ni ni-forward-ios"></em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <a href="<?php echo base_url(); ?>affiliate/dashboard/">
                <div class="card card-bordered card-full card-button">
                    <div class="card-inner-group">
                        <div class="card-inner card-inner-md">
                            <div class="user-card">
                                <div class="user-avatar" style="background-color: transparent !important;">
                                    <img src="https://www.svgrepo.com/show/530450/page-analysis.svg" />
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">Affiliate Dashboard</span>
                                    <span class="sub-text">Activation, Downline &amp; Commission</span>
                                </div>
                                <div class="user-action">
                                    <em class="icon ni ni-forward-ios"></em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-6">
        <a href="<?php echo base_url(); ?>affiliate/activate_subscriber">
            <div class="card card-bordered product-card" style="background-color: #fe3c00;">
                <div class="card-inner text-center">
                    <div>
                        <span class="title" style="font-size: 1.0rem; font-weight: bold; color: #FFFFFF">0.0007 g</span>
                    </div>
                    <img src="<?php echo base_url(); ?>assets/nex/icons/icon_gold-256x256.png" style="width: 44px">
                    <h5 class="product-title" style="color: #FFFFFF">NEX Gold &rarr;</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6">
        <a href="<?php echo base_url(); ?>dealer/list_dealer_package">
            <div class="card card-bordered product-card" style="background-color: #fe3c00;">
                <div class="card-inner text-center">
                    <div>
                        <span class="title" style="font-size: 1.0rem; font-weight: bold; color: #FFFFFF">0.0087 g</span>
                    </div>
                    <img src="<?php echo base_url(); ?>assets/nex/icons/icon-nex-reward-256x256.png?asd=asd" style="width: 44px">
                    <h5 class="product-title" style="color: #FFFFFF">NEX Reward &rarr;</h5>
                </div>
            </div>
        </a>
    </div>
</div>



<script>
    var waitForJQuery = setInterval(function () {
        if (typeof $ != 'undefined') {

            $(function(){
                var tabs = $('.tabs');
                var selector = $('.tabs').find('a').length;

                var activeItem = tabs.find('.active');

                $(".tab_contents").slideUp('slow');

                var active_tab_id = $(activeItem).data("tab_content")
                $("#"+active_tab_id).show('slow')

                var activeWidth = activeItem.innerWidth();
                $(".selector").css({
                    "left": activeItem.position.left + "px",
                    "width": "49.9%"
                });

                $(".tabs").on("click","a",function(e){
                    var selected_tab = e;
                    e.preventDefault();
                    $('.tabs a').removeClass("active");
                    $(this).addClass('active');
                    var activeWidth = $(this).innerWidth();
                    var itemPos = $(this).position();
                    $(".selector").animate({
                        "left":itemPos.left + "px",
                        "width": "49.9%"
                    }, function(){
                        var activeItem = tabs.find('.active');

                        $(".tab_contents").slideUp('slow');

                        var active_tab_id = $(activeItem).data("tab_content")
                        $("#"+active_tab_id).show('slow')
                    });
                });
            })

            clearInterval(waitForJQuery);
        }
    }, 10);

</script>

<script>
    function share_alias_url_name(){
        var is_affiliate = "<?php echo $logged_in['is_affiliate']; ?>";
        if(is_affiliate == "no"){
            modal_alert_danger("Unable to Process!", 'You are not affiliate. Contact your dealer to become an affiliate', "");
            return false;
        }else{
            var title = "NEX Beyon";
            var text = "Daftar akaun NEX secara percuma sekarang!";
            var url = '<?php echo base_url().$logged_in["alias_url_name"] ?? ""; ?>';
            const share_data = {title, text, url};
            try {
                navigator.share(share_data);
            }
            catch(e) {
                console.log('share error', e);
            }
        }

    }
</script>