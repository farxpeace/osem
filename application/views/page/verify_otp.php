<?php $this->load->view('includes/tfpay_header'); ?>
    <div class="header">
        <div class="tf-container">
            <div class="tf-statusbar br-none d-flex justify-content-center align-items-center">
                <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
                <h3>Verification OTP</h3>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="tf-container">
            <form class="tf-form tf-form-verify" action="07_verify-account.html">
                <div class="d-flex group-input-verify">
                    <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify">
                    <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify">
                    <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify">
                    <input type="tel" maxlength="1" pattern="[0-9]" class="input-verify">
                </div>
                <div class="text-send-code">
                    <p class="fw_4">A code has been sent to your phone</p>
                    <p class="primary_color fw_7">Resend in&nbsp;<span class="js-countdown" data-timer="60" data-labels=" :  ,  : , : , "></span></p>
                </div>
                <div class="bottom-navigation-bar bottom-btn-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
                    <button type="button" class="tf-btn accent large" onclick="javascript: btn_verify_tac();">Continue</button>
                </div>
            </form>
        </div>
    </div>
<?php $this->load->view('includes/tfpay_footer'); ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/count-down.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/tfpay-app-pwa/javascript/verify-input.js"></script>
    <script>
        $(function(){
            $(".input-verify").keyup(function(){
                auto_verify();
            });
        });
        function auto_verify(){
            var tac_number = "";
            $(".input-verify").each(function(i, j){
                tac_number += $(this).val();
            });
            var reg = /^\d+$/;
            if(reg.test(tac_number)){
                if(tac_number.length == 4){
                    btn_verify_tac();
                }
            }
        }
    </script>
    <script>
        function btn_verify_tac(){
            var tac_number = "";
            $(".input-verify").each(function(i, j){
                tac_number += $(this).val();
            })
            $.ajax({
                url: '<?php echo base_url(); ?>page/verify_tac_login',
                type: "POST",
                dataType: "JSON",
                data: {
                    postdata: {
                        tac_number: tac_number,
                        page_identifier: '<?php echo $this->input->get("identifier") ?>'
                    }
                },
                success: function(data){
                    if(data.status == "success"){
                        window.location.replace(data.redirect_url);
                    }else{
                        unblockUI();
                        var eell = data.errors;
                        $.each(eell, function(i,j){
                            var el_on_page = $("#"+i).length;
                            if (el_on_page){
                                $("#"+i).closest('.form-group').addClass('has-error');
                                $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                            } else {
                            }
                            Swal.fire({
                                title: 'Oops...',
                                text: j,
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'Ok!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace('<?php echo base_url(); ?>page/login_user/?mobile_number=<?php echo $error["mobile_number"] ?? ""; ?>&nric_number=<?php echo $error["nric_number"] ?? ""; ?>');
                                }
                            })
                        })
                    }
                }
            })
        }
    </script>
<?php if(count($error) > 0){ ?>
    <script>
        $(function(){
            Swal.fire({
                title: 'OTP expired!!',
                text: "Please request OTP again",
                icon: 'error',
                showCancelButton: false,
                confirmButtonText: 'Request OTP again'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('<?php echo base_url(); ?>page/login_user/?mobile_number=<?php echo $error["mobile_number"] ?>&nric_number=<?php echo $error["nric_number"]; ?>');
                }
            })
        })
    </script>
<?php } ?>
