<div class="modal modal-bottom fade" id="modal_under_construction" tabindex="-1" role="dialog" aria-labelledby="modal_under_construction">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="modal-body" id="modal_under_construction_body" style="height: 60vh">
                <img src="<?php echo base_url(); ?>assets/myloan/banner/banner_coming_soon.png" />
                <div class="bottom-navigation-bar bottom-navigation-bar-receipt col-md-4 offset-md-4" style="margin: 0 auto;padding-top: 10px; padding-bottom: 10px;margin-left: -15px;padding-left: 15px; padding-right: 15px;">
                    <div class="tf-container" style="padding: 0px">
                        <div class="group-btn-change-name" style="display: flex; justify-content: space-between; gap: 10px;">
                            <a href="javascript: void(0);" class="tf-btn light large" data-bs-dismiss="modal" aria-label="Close" style="background-color: #a10000; color: #FFFFFF;"><i class="fa-solid fa-circle-xmark"></i> Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="modal_alert_danger" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="transform: translate(0, 100px) !important;">
        <div class="modal-content">
            <div class="modal-body modal-body-lg text-center" style="padding: 3.75rem 3.75rem;">
                <div class="nk-modal">
                    <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-cross bg-danger"></em>
                    <h4 class="nk-modal-title" style="font-size: 1.25rem; margin-top: 30px !important;">Unable to Process!</h4>
                    <div class="nk-modal-text" style="margin-top: 20px !important;">
                        <p class="lead">We are sorry, we were unable to process your payment. Please try after sometimes.</p>
                        <p class="text-soft">If you need help please contact us at (855) 485-7373.</p>
                    </div>
                    <div class="nk-modal-action mt-5">
                        <a href="#" class="btn btn-lg btn-mw btn-danger" data-bs-dismiss="modal">Return</a>
                    </div>
                </div>
            </div><!-- .modal-body -->
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dashlite/js/bundle.js?ver=3.2.0"></script>
<script src="<?php echo base_url(); ?>assets/dashlite/js/scripts.js?ver=3.2.0aa"></script>
<script src="<?php echo base_url(); ?>assets/dashlite/js/example-toastr.js?ver=3.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/main.js?time=<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/init.js?time=<?php echo time(); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/block-ui@2.70.1/jquery.blockUI.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- PWA -->

<script>
    $.fn.center = function () {
        this.css("position", "absolute");
        this.css("top", ($(window).height() - this.height()) / 2 + $(window).scrollTop() + "px");
        this.css("left", ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + "px");
        return this;
    }
    function open_modal_under_construction(){
        $("#modal_under_construction").modal("show");
    }
</script>
<script>
    const SwalToast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    function TFPanelOpen(element){
        $(element).addClass("panel-open")
    }
    function TFPanelClose(element){
        $(element).removeClass("panel-open")
    }
    function navigate_to(url){
        if(url == 'back'){
            history.back();
        }else{
            window.location.replace(url);
        }

    }
    function blockUI(){
        $(".preload").show();
    }
    function unblockUI(){
        $(".preload").hide();
        $.unblockUI();
    }
    function swalTimer(icon,title, html, timer){
        let myPromise = new Promise(function(myResolve) {
            let timerInterval
            Swal.fire({
                icon: icon,
                title: title,
                html: html,
                timer: timer,
                timerProgressBar: true,
                willOpen: () => {
                    unblockUI();
                },
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b');
                    timerInterval = setInterval(() => {
                        if(b){
                            b.textContent = Swal.getTimerLeft()
                        }
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                myResolve();
            })
        });
        return myPromise;
    }
    function modal_alert_danger(title, text, sub_text){
        if(title.length > 0){
            $("#modal_alert_danger").find('.nk-modal-title').text(title);
        }
        if(text.length > 0){
            $("#modal_alert_danger").find('.nk-modal-text').find('.lead').html(text);
        }
        if(sub_text.length > 0){
            $("#modal_alert_danger").find('.nk-modal-text').find('.text-soft').html(sub_text).show();
        }else{
            $("#modal_alert_danger").find('.nk-modal-text').find('.text-soft').hide();
        }
        $("#modal_alert_danger").modal("show");
    }
    function blockUI_secondary() {
        $.blockUI({
            css: {
                backgroundColor: 'transparent',
                border: 'none'
            },
            message: '<div class="preloader_secondary"><hr/><hr/><hr/><hr/><div id="preloader_text"></div></div>',
            baseZ: 9999999,
            overlayCSS: {
                backgroundColor: '#FFFFFF',
                opacity: 0.7,
                cursor: 'wait'
            }
        });
        $('.blockUI.blockMsg').center();
    }
    function reset_form_error(){
        $(".has-error").removeClass("has-error");
        $(".error_message").hide();
    }
    $(function(){
        $('.force_uppercase').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.force_lowercase').keyup(function() {
            this.value = this.value.toLocaleLowerCase();
        });
    })
</script>

<script>
    $(function(){
        console.log("Trigger time Outaa")
        setTimeout(function(){
            console.log("Settime Out")
            unblockUI();
        }, 2000);
    })

    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            setTimeout(function(){
                console.log("Settime Out")
                unblockUI();
            }, 2000);
        }
    });

</script>
</body>
</html>
