<?php $this->load->view('includes/tfpay_header'); ?>

<div class="app-header">
    <div class="tf-container">
        <div class="tf-topbar d-flex justify-content-between align-items-center">
            <a class="user-info d-flex justify-content-between align-items-center" href="<?php echo base_url(); ?>profile/view_profile/">
                <img src="/assets/lead/logo/logo-transparent-96x96-spinner.png" alt="image" style="border: 1px solid #ffffff;">
                <div class="content">
                    <h4 class="white_color" style="font-size: 0.9rem !important; line-height: 0.6rem !important;">Think Osem Sdn Bhd</h4>
                    <p class="white_color fw_4">Osem</p>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="card-secton">
    <div class="tf-container">
        <div class="tf-balance-box" style="display: none">
            <div class="balance">
                <div class="row">
                    <div class="col-6 br-right">
                        <div class="row">
                            <div class="col-8">
                                <p>NEX Wallet:</p>
                                <h3>RM <?php //echo $this->far_wallet_nex->sum_total_amount_per_user($logged_in['uacc_id']); ?></h3>
                            </div>
                            <div class="col-4">
                                <a href="<?php echo base_url(); ?>wallet_nex/user_reload_wallet">
                                    <div class="icon-box">
                                        <img src="<?php echo base_url(); ?>assets/nex/icons/icon_wallet-256x256.png" style="width: 30px;" />
                                    </div>
                                    Reload
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <a href="<?php echo base_url(); ?>wallet_nex/user_reload_wallet">
                                    <div class="icon-box">
                                        <img src="<?php echo base_url(); ?>assets/nex/icons/icon_gold-256x256.png" style="width: 30px;" />
                                    </div>
                                    Buy
                                </a>
                            </div>
                            <div class="col-8" style="text-align: right">
                                <p>NEX Gold:</p>
                                <h3><?php //echo $this->far_wallet_nex->sum_total_amount_per_user($logged_in['uacc_id']); ?>g</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="wallet-footer">


            </div>
        </div>
    </div>
</div>


<div class="tf-container mt-5">
    <div class="card card-bordered">
        <div class="card-inner">
            <h4 class="card-title mb-1" style="font-size: 1rem">Pseudo API</h4>
            <ul class="box-service mt-3" style="grid-template-columns: repeat(2, 1fr);">
                <li>
                    <a href="/osem/crawl/">
                        <div class="icon-box">
                            <img src="https://www.svgrepo.com/show/183316/book.svg" style="width: 40px" />
                        </div>
                        Crawl
                    </a>
                </li>
                <li>
                    <a href="/osem/list_all/">
                        <div class="icon-box bg_color_1">
                            <img src="https://www.svgrepo.com/show/128893/user-list.svg" style="width: 24px" />
                        </div>
                        Product
                    </a>
                </li>
            </ul>
        </div>
    </div>



</div>

<pre><?php //print_r($logged_in); ?></pre>
<?php $this->load->view('includes/tfpay_bottom_navigation_bar'); ?>
<div class="modal fade" id="modal_complete_profile">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal_fara modal-content">
            <div class="heading">
                <h4 class="fw_6 text-center">
                    Please complete your profile.
                </h4>
                <p class="fw_4 mt-2 text-center">Your full profile are needed to be completed first before proceed with our system.</p>
            </div>
            <div class="bottom">
                <a href="<?php echo base_url(); ?>profile/update_profile/" class="tf-btn accent large">Update Profile</a>
            </div>
        </div>
    </div>
</div>
<div class="tf-panel down">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-down col-md-4 offset-md-4">
        <div class="header bg_white_color">
            <div class="tf-container">
                <div class="tf-statusbar d-flex justify-content-center align-items-center">
                    <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                    <h3>MyLoan Wallet</h3>
                    <a href="40_qr-code.html" class="action-right"><i class="icon-qrcode4"></i></a>
                </div>
            </div>
        </div>
        <div class="wrap-transfer mb-5">
            <div class="tf-container">
                <a href="<?php echo base_url(); ?>wallet_myloan/dashboard_transaction" class="action-sheet-transfer">
                    <div class="icon"><i class="icon-friends"></i></div>
                    <div class="content">
                        <h4 class="fw_6" >Wallet Transaction</h4>
                        <p>History of MyLoan Wallet</p>
                    </div>
                </a>
                <a href="<?php echo base_url(); ?>wallet_myloan/user_reload_wallet" class="action-sheet-transfer">
                    <div class="icon"><i class="icon-bank2"></i></div>
                    <div class="content">
                        <h4 class="fw_6">Reload Wallet</h4>
                        <p>Topup wallet using FPX online banking</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="tf-panel card-popup">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-down col-md-4 offset-md-4">
        <div class="header">
            <div class="tf-container">
                <div class="tf-statusbar d-flex justify-content-center align-items-center">
                    <a href="#" class="clear-panel"> <i class="icon-left"></i> </a>
                    <h3>Manage Your Card</h3>
                </div>
            </div>
        </div>
        <div class="content-card mt-3 mb-5">
            <div class="tf-container">
                <div class="tf-card-list bg_surface_color large out-line">
                    <div class="logo">
                        <img src="<?php echo base_url(); ?>assets/tfpay-app-pwa/images/logo-banks/card-visa.png" alt="image">
                    </div>
                    <div class="info">
                        <h4 class="fw_6"><a href="38_card-detail.html">Mastercard</a></h4>
                        <p>****  ****  ****   7576</p>
                    </div>
                    <input type="checkbox" class="tf-checkbox circle-check" checked>
                </div>
                <p class="auth-line">Choose other card for payment</p>
                <ul class="box-card">
                    <li class="tf-card-list medium bt-line">
                        <div class="logo">
                            <img src="<?php echo base_url(); ?>assets/tfpay-app-pwa/images/logo-banks/card-visa2.png" alt="image">
                        </div>
                        <div class="info">
                            <h4 class="fw_6"><a href="38_card-detail.html">Visacard</a></h4>
                            <p>****  ****  ****   3245</p>
                        </div>
                        <input type="checkbox" class="tf-checkbox circle-check">
                    </li>
                    <li class="tf-card-list medium bt-line">
                        <div class="logo">
                            <img src="<?php echo base_url(); ?>assets/tfpay-app-pwa/images/logo-banks/card-visa.png" alt="image">
                        </div>
                        <div class="info">
                            <h4 class="fw_6"><a href="38_card-detail.html">Mastercard</a></h4>
                            <p>****  ****  ****   7576</p>
                        </div>
                        <input type="checkbox" class="tf-checkbox circle-check">
                    </li>
                    <li class="tf-card-list medium">
                        <div class="logo">
                            <img src="<?php echo base_url(); ?>assets/tfpay-app-pwa/images/logo-banks/card-visa2.png" alt="image">
                        </div>
                        <div class="info">
                            <h4 class="fw_6"><a href="38_card-detail.html">Visacard</a></h4>
                            <p>****  ****  ****   7214</p>
                        </div>
                        <input type="checkbox" class="tf-checkbox circle-check">
                    </li>
                </ul>
                <div class="tf-spacing-20"></div>
                <a href="34_card.html" class="tf-btn large">Add a new card <i class="icon-plus fw_7"></i> </a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/tfpay_footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/swiper-bundle.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/swiper.js"></script>

<script>
    var swiper = new Swiper(".banner-nex", {
        speed: 1000,
        parallax: true,
        slidesPerView: 1.2,
        spaceBetween: 16,
        loop: true,
        navigation: {
            clickable: true,
            nextEl: ".button-lo-next",
            prevEl: ".button-lo-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },

        breakpoints: {
            1024: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            500: {
                slidesPerView: 1,
            },
        },
    });
</script>

<?php if(isset($logged_in['user_profile']) && strlen($logged_in['user_profile']['fullname']) < 3){ ?>
    <script>
        $(function(){
            $("#modal_complete_profile").modal("show");
        });
    </script>
<?php } ?>
