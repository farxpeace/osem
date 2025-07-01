<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/css/intlTelInput.css">
<style>
    .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags.png");}
    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
        .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/img/flags@2x.png");}
    }
    .intl-tel-input {
        width: 100% !important;
    }
</style>
<div class="boarding-section" style="background-color: #952300">
    <div class="tf-container">
        <div class="images" style="text-align: center;">
            <img src="<?php echo base_url(); ?>assets/nex/logo-yellow-256x256.png" alt="image" style="width: 80%; height: auto">
        </div>
    </div>
</div>
<div class="mt-7 login-section">
    <div class="tf-container">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="card card-bordered" style="border: none">

                        <div class="row g-0 col-sep col-sep-md col-sep-xl">
                            <div class="col-12">
                                <div class="card-inner">
                                    <div class="nk-stepper-content">
                                        <div class="nk-stepper-steps stepper-steps" >
                                            <div class="nk-stepper-step" style="display: block !important;">
                                                <h5 class="title mb-3">Choose Profile Type</h5>
                                                <p>
                                                    Account registration allows for remembering details about the user, product wish lists, preferences, interests, shipping and billing addresses, VAT number for
                                                </p>
                                                <ul class="row g-3 mt-3">
                                                    <li class="col-6">
                                                        <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                            <input type="radio" class="custom-control-input" name="cp1-profile-type" id="cp1-profile-personal" value="profile_personal" required>
                                                            <label class="custom-control-label" for="cp1-profile-personal">
                                                                <span class="d-flex flex-column text-center px-sm-3">
                                                                    <em class="icon icon-circle icon-circle-lg bg-teal ni ni-user"></em>
                                                                    <span class="lead-text mb-1 mt-3">Personal</span>
                                                                    <span class="sub-text">For dealer or personal use</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="col-6">
                                                        <div class="custom-control custom-control-sm custom-radio pro-control custom-control-full">
                                                            <input type="radio" class="custom-control-input" name="cp1-profile-type" id="cp1-profile-corporate" value="profile_corporate" required>
                                                            <label class="custom-control-label" for="cp1-profile-corporate">
											<span class="d-flex flex-column text-center px-sm-3">
											<em class="icon icon-circle icon-circle-lg bg-orange ni ni-briefcase"></em>
											<span class="lead-text mb-1 mt-3">Corporate</span>
											<span class="sub-text">Constant workflow independent tasks.</span>
											</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="alert alert-danger alert-icon mt-3" id="error_choose_profile" style="display: none">
                                            <em class="icon ni ni-cross-circle"></em> <strong>Error</strong> Please choose profile
                                        </div>
                                        <button type="button" onclick="javascript: btn_click_choose_profile();" class="tf-btn accent large">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <!-- .nk-block -->
        </div>
    </div>
</div>
<?php $this->load->view('includes/tfpay_footer'); ?>
<script>
    $(function(){
        setTimeout(function(){
            console.log("Settime Out")
            unblockUI();
        }, 2000);
    })

</script>
<script>
    function btn_click_choose_profile(){
        $("#error_choose_profile").hide();
        var selected_profile = $("input[name='cp1-profile-type']:checked").val();
        if(selected_profile){
            if(selected_profile == 'profile_corporate'){
                Swal.fire({
                    text: "You cannot register as a Corporate account yet",
                    icon: "info"
                });
            } else if(selected_profile == 'profile_personal'){
                blockUI();
                window.location.replace("<?php echo base_url(); ?>page/register_profile_personal");
            }
        }else{
            $("#error_choose_profile").show();
        }
        return false;
        blockUI();
        $.ajax({
            url: '<?php echo base_url(); ?>auth/login_via_ajax',
            type: 'POST',
            data: {
                login_identity: email,
                login_password: password,
                remember_me: 1,
                login_user: 'Submit'
            },
            success: function(data){
                if(data){
                    window.location.replace("<?php echo base_url(); ?>auth_admin/dashboard");
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: "Username or Password did not match. Please try again",
                        icon: "error"
                    });
                    unblockUI();
                }
            }
        });
    }
</script>