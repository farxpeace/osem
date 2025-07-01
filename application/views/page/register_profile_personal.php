<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/css/intlTelInput.css">
<style>
    .iti--show-flags {
        width: 100%;
    }
    .iti__tel-input {
        padding-left: 78px !important;
    }
</style>
<div class="header is-fixed col-md-4 offset-md-4">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="<?php echo base_url(); ?>page/register_choose_account" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Register</h3>

        </div>
    </div>
</div>
    <div class="app-section st1 mt-1 mb-5 bg_white_color">
        <div class="tf-container" style="padding-bottom: 100px; margin-top: 50px;">
            <div class="row g-3">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="fullname">Full Name as per MyKad</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control valid force_uppercase" id="fullname" name="fullname" placeholder="Full Name">
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <div class="form-control-wrap">
                            <input type="tel" class="form-control" id="username" name="username" placeholder="Choose your username">
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="mobile_number">Phone Number</label>
                        <div class="form-control-wrap">
                            <input type="tel" class="form-control" id="mobile_number" name="mobile_number" placeholder="Your phone number" style="width: 100%; padding-left: 78px;">
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="tac_number">OTP</label>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="OTP Number from SMS" id="tac_number">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-dim" onclick="confirm_send_tac();">Request OTP</button>
                                </div>
                            </div>
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="uacc_email">Email Address</label>
                        <div class="form-control-wrap">
                            <input type="email" class="form-control valid force_lowercase" id="uacc_email" name="uacc_email" placeholder="Your valid email here">
                            <span class="help-block error_message" style="display: none;"></span>
                        </div>
                    </div>
                </div>



                <div class="col-12">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="password" placeholder="Enter your password">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Confirm Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input autocomplete="new-password" type="password" class="form-control form-control-lg" required id="password_confirm" placeholder="Enter your password">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label" for="alias_url_name">Referral Code</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control valid" id="alias_url_name" name="alias_url_name" value="<?php echo $upline_detail['alias_url_name']; ?> (<?php echo $upline_detail['user_profile']['fullname']; ?>)" disabled >
                        </div>
                    </div>
                </div>

                <a href="javascript: void(0);" onclick="javascript: demo_data();" class="tf-btn accent large">DEMO DATA</a>

            </div>
        </div>
    </div>
</div>

<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>page/register_choose_account');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
        <a href="javascript: void(0);" onclick="javascript: submit_registration();" class="tf-btn accent large">Proceed Registration</a>

    </div>
</div>
<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/intlTelInput.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chance/1.0.11/chance.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/keypress/2.1.4/keypress.min.js"></script>

<script>
    const input = document.querySelector("#mobile_number");
    const mobile_numberIntl = window.intlTelInput(input, {
        initialCountry: "my",
        onlyCountries: ["my", "id", "sg"],
        separateDialCode: true,
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.0/build/js/utils.js"),
    });

</script>

<script>
    function confirm_send_tac(){
        reset_form_error();
        var mobile_number = mobile_numberIntl.getNumber();
        Swal.fire({
            title: "Confirmation",
            html: "We will send OTP to <b>"+mobile_number+"</b>. <br><br>Make sure this number are valid &amp; able to receive SMS",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirmed!",
            cancelButtonText: "Edit Mobile number",
            customClass: {
                actions: 'vertical-buttons',
                cancelButton: 'top-margin'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url(); ?>page/request_otp_register',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        postdata: {
                            mobile_number: mobile_numberIntl.getNumber(),
                        }
                    },
                    success: function(data){
                        unblockUI();
                        if(data.status == "success"){
                            swalTimer('success','Success', 'OTP sent to '+data.mobile_number+'. Please wait 3 minutes before requesting new OTP', 2500).then(
                                function(value) {


                                },
                            );
                        }else{
                            var eell = data.errors;
                            $.each(eell, function(i,j){
                                var el_on_page = $("#"+i).length;
                                if (el_on_page){
                                    $("#"+i).closest('.form-group').addClass('has-error');

                                    if($("#"+i).closest('.form-group').find('.error_message')){
                                        $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                                    }else{
                                        $("#"+i).after('<span class="error_message">'+j+'</span>');
                                        $(".error_message").show();
                                    }

                                } else {
                                    //sweetAlert("Oops...", "Something went wrong!", "error");
                                }
                                console.log(i);
                                console.log(j)
                            });

                            if($(".form-group.has-error").length > 0){
                                var element_scroll = $(".form-group.has-error").get(0);
                                $('html,body').animate({
                                    scrollTop: $(".app-section").offset().top - $(window).height()/2
                                }, 500);
                            }

                            modal_alert_danger("Unable to Process!", data.message_single, "");


                        }


                    }
                });
            }
        });
    }

    function submit_registration(){
        var error_el;
        reset_form_error();
        blockUI_secondary();
        $.ajax({
            url: '<?php echo base_url(); ?>page/ajax_register_profile_personal',
            type: 'POST',
            dataType: 'json',
            data: {
                postdata: {
                    fullname: $("#fullname").val(),
                    username: $("#username").val(),
                    mobile_number: mobile_numberIntl.getNumber(),
                    uacc_email: $("#uacc_email").val(),
                    password: $("#password").val(),
                    password_confirm: $("#password_confirm").val(),
                    tac_number: $("#tac_number").val()
                }
            },
            success: function(data){
                unblockUI();
                if(data.status == "success"){
                    if(data.redirect_url){
                        blockUI();
                        setTimeout(function(){
                            window.top.location.href = data.redirect_url;
                        }, 2000);
                    }else{

                    }



                }else{
                    var eell = data.errors;
                    $.each(eell, function(i,j){
                        var el_on_page = $("#"+i).length;
                        if (el_on_page){
                            $("#"+i).closest('.form-group').addClass('has-error');

                            if($("#"+i).closest('.form-group').find('.error_message')){
                                $("#"+i).closest('.form-group').find('.error_message').text(j).show();
                            }else{
                                $("#"+i).after('<span class="error_message">'+j+'</span>');
                                $(".error_message").show();
                            }

                        } else {
                            //sweetAlert("Oops...", "Something went wrong!", "error");
                        }
                        console.log(i);
                        console.log(j)
                    });

                    if($(".form-group.has-error").length > 0){
                        var element_scroll = $(".form-group.has-error").get(0);
                        $('html,body').animate({
                            scrollTop: $(".app-section").offset().top - $(window).height()/2
                        }, 500);
                    }

                    modal_alert_danger("Unable to Process!", data.message_single, "");


                }


            }
        });
    }
</script>

<script type="text/javascript">
    var listener = new window.keypress.Listener();
    $(function(){
        listener.sequence_combo("a s d", function() {
            demo_data()
        }, true);

    });
    function demo_data(){
        var fullname = chance.name();
        $("#fullname").val((fullname+" Test").toUpperCase());

        var uacc_username = fullname.replace(/\s/g, '').toLowerCase()+Math.floor(Math.random() * (99 - 11 + 1));
        $("#username").val(uacc_username);
        mobile_numberIntl.setNumber('+60137974467');


        var email = uacc_username+"@dsnt.com.my";
        $("#uacc_email").val(email);
        $("#password").val('12345678');
        $("#password_confirm").val('12345678');
    }
</script>
