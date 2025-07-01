<?php $this->load->view('includes/tfpay_header'); ?>
<style>
    body {
        background-color: #f5f5f5;
    }
    .btn-trigger:before {
        background-color: transparent;
    }
    .btn:focus {
        box-shadow: none;
    }
    .accordion-inner {
        border-bottom: none !important;
    }
</style>
<div class="header is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="<?php echo base_url(); ?>auth_admin/dashboard" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Support</h3>
        </div>
    </div>
</div>
<div id="app-wrap" style="margin-bottom: 50px;">
    <div class="content-page wide-sm m-auto" style="margin-top: 20px !important;">
        <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
            <div class="nk-block-head-content text-center">

                <h2 class="nk-block-title fw-normal" style="font-size: 1.5rem; letter-spacing: -0.03em;">Frequently Asked Questions</h2>
            </div>
        </div><!-- .nk-block-head -->
        <div class="nk-block">
            <div class="card">
                <div id="faqs" class="accordion">
                    <div class="accordion-item">
                        <a href="#" class="accordion-head" data-bs-toggle="collapse" data-bs-target="#faq-q1">
                            <h6 class="title">What is CCRIS?</h6>
                            <span class="accordion-icon"></span>
                        </a>
                        <div class="accordion-body collapse show" id="faq-q1" data-bs-parent="#faqs">
                            <div class="accordion-inner">
                                CCRIS stands for Central Credit Reference Information System.
                                CCRIS is owned and operated by Bank Negara Malaysia (BNM) to facilitate credit risk management among banks.
                                CCRIS processes data received from participating financial institutions like us at Myloan.my and turns them into credit reports.
                            </div>
                        </div>
                    </div><!-- .accordion-item -->
                    <div class="accordion-item">
                        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#faq-q2">
                            <h6 class="title">How Do I Read My CCRIS Report?</h6>
                            <span class="accordion-icon"></span>
                        </a>
                        <div class="accordion-body collapse" id="faq-q2" data-bs-parent="#faqs">
                            <div class="accordion-inner">
                                CCRIS keeps track of your payment record for 12 months.
                                If you do not service or make your payment in due for any of your loan, it will be displayed
                                on the CCRIS report in numerical representation. For example, if you have three month’s payment in arrear,
                                your CCRIS report will have the number ‘3’ printed in the column of that particular loan. For more information and
                                getting our expert help to guide you and explain it to you better, get your CCRIS score report with us here, and we’ll
                                help explain your score better for your perusal.
                            </div>
                        </div>
                    </div><!-- .accordion-item -->
                    <div class="accordion-item">
                        <a href="#" class="accordion-head collapsed" data-bs-toggle="collapse" data-bs-target="#faq-q3">
                            <h6 class="title">How Often is CCRIS Updated?</h6>
                            <span class="accordion-icon"></span>
                        </a>
                        <div class="accordion-body collapse" id="faq-q3" data-bs-parent="#faqs">
                            <div class="accordion-inner">
                                The CCRIS system is updated on 15th of every month for every payment made until the end of the previous month. We have some tips for you,
                                it would be wise to apply for a loan after 16th of a month in which all outstanding payments have been made before the end of the previous month.
                            </div>
                        </div>
                    </div><!-- .accordion-item -->
                </div><!-- .accordion -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
        <div class="nk-block">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="align-center flex-wrap flex-md-nowrap g-4">
                        <div class="nk-block-image w-120px flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 118">
                                <path d="M8.916,94.745C-.318,79.153-2.164,58.569,2.382,40.578,7.155,21.69,19.045,9.451,35.162,4.32,46.609.676,58.716.331,70.456,1.845,84.683,3.68,99.57,8.694,108.892,21.408c10.03,13.679,12.071,34.71,10.747,52.054-1.173,15.359-7.441,27.489-19.231,34.494-10.689,6.351-22.92,8.733-34.715,10.331-16.181,2.192-34.195-.336-47.6-12.281A47.243,47.243,0,0,1,8.916,94.745Z" transform="translate(0 -1)" fill="#f6faff" />
                                <rect x="18" y="32" width="84" height="50" rx="4" ry="4" fill="#fff" />
                                <rect x="26" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                <rect x="50" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                <rect x="74" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                <rect x="38" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                <rect x="62" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                <path d="M98,32H22a5.006,5.006,0,0,0-5,5V79a5.006,5.006,0,0,0,5,5H52v8H45a2,2,0,0,0-2,2v4a2,2,0,0,0,2,2H73a2,2,0,0,0,2-2V94a2,2,0,0,0-2-2H66V84H98a5.006,5.006,0,0,0,5-5V37A5.006,5.006,0,0,0,98,32ZM73,94v4H45V94Zm-9-2H54V84H64Zm37-13a3,3,0,0,1-3,3H22a3,3,0,0,1-3-3V37a3,3,0,0,1,3-3H98a3,3,0,0,1,3,3Z" transform="translate(0 -1)" fill="#798bff" />
                                <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="#6576ff" />
                                <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="none" stroke="#6576ff" stroke-miterlimit="10" stroke-width="2" />
                                <line x1="40" y1="22" x2="57" y2="22" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <line x1="40" y1="27" x2="57" y2="27" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <line x1="40" y1="32" x2="50" y2="32" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                <line x1="30.5" y1="87.5" x2="30.5" y2="91.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="28.5" y1="89.5" x2="32.5" y2="89.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="79.5" y1="22.5" x2="79.5" y2="26.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                <line x1="77.5" y1="24.5" x2="81.5" y2="24.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="90.5" cy="97.5" r="3" fill="none" stroke="#9cabff" stroke-miterlimit="10" />
                                <circle cx="24" cy="23" r="2.5" fill="none" stroke="#9cabff" stroke-miterlimit="10" />
                            </svg>
                        </div>
                        <div class="nk-block-content">
                            <div class="nk-block-content-head px-lg-4">
                                <h5>Do You Need More Support?</h5>
                                <p class="text-soft">Come and talk with us. Our customer support service is ready to serve you with any of your inquiries. If you can’t find your answer to waht you’ve been wondering for, you can always contact us with your questions.</p>
                            </div>
                        </div>
                        <div class="nk-block-content flex-shrink-0">
                            <a href="tel:+60163491957" onclick="javascript: call_now();" class="btn btn-lg btn-outline-primary">Call us now</a>
                        </div>
                    </div>
                </div><!-- .card-inner -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
    </div><!-- .content-page -->
</div>




<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>auth_admin/dashboard/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
        <a href="tel:+60163491957" onclick="javascript: call_now();" class="tf-btn accent large">Call us now</a>
    </div>
</div>



<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    function call_now(){
        $("#call_now_hidden").click();
        setTimeout(function(){
            unblockUI();
        }, 1000);
    }
</script>
