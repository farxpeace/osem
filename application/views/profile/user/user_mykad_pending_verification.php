<?php $this->load->view('includes/tfpay_header'); ?>

<style>
    body {
        background-color: #f5f5f5 !important;
    }
</style>


<div class="header is-fixed col-md-4 offset-md-4">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>MyKad Verification</h3>
        </div>
    </div>
</div>
<div id="app-wrap" style="background-color: #f5f5f5;">
    <div class="bill-payment-content">
        <div class="tf-container">
            <div class="wrapper-bill">
                <div class="archive-top">
                         <span class="circle-box lg bg-critical">
                             <svg width="63" height="62" viewBox="0 0 63 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M31.5 11.2783L27.023 7.68753L22.5459 11.2824L18.069 7.68753V50.3189L22.5459 53.9139L27.023 50.3189L31.5 53.9139L31.6334 53.5819L32.3766 30.9701L31.6419 11.3564L31.5 11.2783Z" fill="white"/>
                                 <path d="M40.454 11.2824L35.977 7.68753L31.5 11.2783V53.9139L35.977 50.3189L40.454 53.9139L44.931 50.3189V7.68753L40.454 11.2824Z" fill="white"/>
                                 <path d="M21.681 17.808V21.364H31.642L31.9964 19.5859L31.642 17.808H21.681Z" fill="#C5C5C5"/>
                                 <path d="M31.5051 17.808H35.6749V21.364H31.5051V17.808Z" fill="#C5C5C5"/>
                                 <path d="M21.681 31.2109H29.7102V34.7669H21.681V31.2109Z" fill="#C5C5C5"/>
                                 <path d="M21.681 38.3227H29.7102V41.8786H21.681V38.3227Z" fill="#4A84F6"/>
                                 <path d="M21.6597 24.3728V27.9286H31.6419L31.9964 26.0385L31.6419 24.3728H21.6597Z" fill="#C5C5C5"/>
                                 <path d="M31.5051 24.3728H41.3404V27.9287H31.5051V24.3728Z" fill="#C5C5C5"/>
                                 <path d="M37.7163 40.5659C36.3815 40.4515 35.4027 39.943 34.7035 39.2438L35.6951 37.8327C36.1655 38.3285 36.8647 38.7734 37.7164 38.926V36.9555C36.407 36.6376 34.9832 36.1419 34.9832 34.413C34.9832 33.1291 36.0002 32.0358 37.7164 31.8578V30.6756H38.9114V31.8833C39.941 31.9977 40.8182 32.379 41.5047 33.0146L40.5005 34.3622C40.0429 33.9427 39.4835 33.6757 38.9114 33.5358V35.2901C40.2335 35.6206 41.7082 36.1292 41.7082 37.8707C41.7082 39.2819 40.7801 40.3751 38.9114 40.5658V41.7099H37.7164V40.5659H37.7163ZM37.7163 34.9979V33.4597C37.157 33.536 36.8391 33.841 36.8391 34.2733C36.8392 34.6419 37.1951 34.8326 37.7163 34.9979ZM38.9114 37.248V38.9514C39.5597 38.8242 39.8648 38.4556 39.8648 38.0488C39.8648 37.6294 39.4707 37.426 38.9114 37.248Z" fill="#F2C71C"/>
                             </svg>
                         </span>
                    <h1><a href="#" class="critical_color" style="font-size: calc(0.75em + 1vmin)">PENDING VERIFICATION</a></h1>
                    <h3 class="mt-2 fw_6">MyKad application received</h3>
                    <p class="fw_4 mt-2" style="margin: 0 10px 10px 10px;">Your MyKad will be reviewed by our team. We will notify you in 1~3 working days. Some of our services need a MyKad verification. Here is some of what you can do after your MyKad has been approved.</p>
                    <div class="list-bill-view mb-4" style="margin-right: 10px; margin-left: 10px">
                        <svg width="28" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.6875 6.4375V9.71875C19.6875 10.1716 19.32 10.5391 18.8672 10.5391C18.4144 10.5391 18.0469 10.1716 18.0469 9.71875V6.4375C18.0469 5.98469 18.4144 5.61719 18.8672 5.61719C19.32 5.61719 19.6875 5.98469 19.6875 6.4375Z" fill="#FABE2C"></path>
                            <path d="M22.9688 4.79688V9.71875C22.9688 10.1716 22.6012 10.5391 22.1484 10.5391C21.6956 10.5391 21.3281 10.1716 21.3281 9.71875V4.79688C21.3281 4.34406 21.6956 3.97656 22.1484 3.97656C22.6012 3.97656 22.9688 4.34406 22.9688 4.79688Z" fill="#6AA9FF"></path>
                            <path d="M26.25 3.15625V9.71875C26.25 10.1716 25.8825 10.5391 25.4297 10.5391C24.9769 10.5391 24.6094 10.1716 24.6094 9.71875V3.15625C24.6094 2.70344 24.9769 2.33594 25.4297 2.33594C25.8825 2.33594 26.25 2.70344 26.25 3.15625Z" fill="#FF435B"></path>
                            <path d="M14.7658 1.51562V12.1797L7.82051 11.7422L2.55957 8.32531C4.44301 3.72883 8.91809 0.695312 13.9455 0.695312C14.3983 0.695312 14.7658 1.06281 14.7658 1.51562Z" fill="#FED843"></path>
                            <path d="M26.2499 13C26.2499 19.5259 21.1826 24.8562 14.7655 25.2773C14.4943 25.2954 14.2209 25.3047 13.9452 25.3047C11.895 25.3047 9.89125 24.7977 8.10352 23.832L9.73867 17.1562L14.7655 12.1797H25.4296C25.8824 12.1797 26.2499 12.5472 26.2499 13Z" fill="#FF7B4A"></path>
                            <path d="M26.25 13C26.25 19.5259 21.1827 24.8562 14.7656 25.2773V12.1797H25.4297C25.8825 12.1797 26.25 12.5472 26.25 13Z" fill="#FF435B"></path>
                            <path d="M14.7656 12.1799C14.2102 13.1513 7.99121 24.0285 7.68359 24.5666C7.44297 24.9516 6.93602 25.067 6.55266 24.8269C2.57141 22.3331 0 17.9281 0 13.0002C0 11.4919 0.239531 10.0077 0.712031 8.58907C0.855313 8.15978 1.32016 7.92681 1.75 8.07009C1.7588 8.07288 14.6494 12.1432 14.7656 12.1799Z" fill="#7ED8F6"></path>
                            <path d="M28 9.71875C28 10.1716 27.6325 10.5391 27.1797 10.5391H17.2266C16.7738 10.5391 16.4062 10.1716 16.4062 9.71875C16.4062 9.26594 16.7738 8.89844 17.2266 8.89844H27.1797C27.6325 8.89844 28 9.26594 28 9.71875Z" fill="#61729B"></path>
                        </svg>
                        <div class="content">
                            <h4 style="text-align: left">MyLoan CTOS Score</h4>
                            <p style="text-align: left">Purchase your CTOS score.</p>
                        </div>
                    </div>
                </div>
                <div class="dashed-line"></div>

            </div>


        </div>

    </div>
</div>






<div class="tf-panel up">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-up wrap-panel-clear">
        <div class="heading">
            <p>Are you sure you want to delete this card?</p>
            <a href="#" class="critical_color">Delete</a>
        </div>
        <div class="bottom">
            <a class="clear-panel" href="#">Cancel</a>
        </div>
    </div>
</div>


<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container">
        <a href="<?php echo base_url(); ?>auth_admin/dashboard/" class="tf-btn accent large">Back to Dashboard</a>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
