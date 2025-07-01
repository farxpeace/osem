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
<div class="boarding-section" style="background: #012169">
    <div class="tf-container">
        <div class="images" style="text-align: center;">
            <img src="/assets/lead/logo/logo-black-600x200.png?asd=asdasdasdf" alt="image" style="width: 80%; height: auto">
        </div>
    </div>
</div>
<div class="mt-7 login-section">
    <div class="tf-container">
        <div class="tf-form">
            <h1>Login</h1>
            <div class="group-input">
                <input type="number" placeholder="0137974467" id="mobile_number">
            </div>

            <div class="group-input">
                <button type="button" onclick="javascript: btn_click_request_tac();" class="tf-btn accent large">Request TAC</button>
            </div>

            <?php if($this->far_helper->server() == 'dev'){ ?>
                <div class="group-input form-group">
                    <select class="form-control" id="autologin" onchange="javascript: onchange_autologin();">
                        <option>Auto Login for testing <?php echo $this->far_helper->server(); ?></option>

                        <optgroup label="Staff">
                            <?php $query = $this->db->query("SELECT u.uacc_id,u.uacc_username,u.uacc_raw_password,u.fullname FROM view_user_list u WHERE u.uacc_group_fk='6'"); ?>
                            <?php foreach($query->result_array() as $a => $b){ ?>
                                <option value="<?php echo $b['uacc_id'] ?>" data-uacc_username="<?php echo $b['uacc_username'] ?>" data-uacc_raw_password="<?php echo $b['uacc_raw_password']; ?>"><?php echo $b['fullname'] ?> (<?php echo $b['uacc_username'] ?>)</option>
                            <?php } ?>
                        </optgroup>

                    </select>

                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/intlTelInput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.0/js/utils.js"></script>
<script>
    $(function(){
        $("#mobile_number").intlTelInput({
            onlyCountries: [
                "my",
                "sg",
                "au",
                "id",
                "th",
                "bn",
                "hk",
                "tw",
                "mo"
            ],
            preferredCountries: [
                "my",
                "id"
            ],
            separateDialCode: true
        });
    });
</script>
<script>
    function btn_click_request_tac(){
        var mobile_number = $("#mobile_number").intlTelInput("getNumber");
        Swal.fire({
            title: 'Are you sure?',
            html: "SMS containing TAC Code will be sent to "+mobile_number,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm!'
        }).then((result) => {
            if (result.isConfirmed) {
                blockUI();
                $.ajax({
                    url: '<?php echo base_url(); ?>page/send_tac_login',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        postdata: {
                            mobile_number: mobile_number
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
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: j,
                                })
                            })
                        }
                    }
                })
                //
            }
        })
    }
</script>

<?php if($this->far_helper->server() == 'dev'){ ?>
<script>
    function btn_click_login(username, password){
        var error_el;
        $("#tab_login .has-error").removeClass('has-error');
        $("#tab_login .error_message").hide();

        if (password === false){
            $("#login_password").closest('.form-group').addClass('has-error');
            $("#login_password").closest('.form-group').find('.error_message').text("Password cannot be blank").show(); return false
        }
        if (password === "") {
            $("#login_password").closest('.form-group').addClass('has-error');
            $("#login_password").closest('.form-group').find('.error_message').text("Password cannot be blank").show(); return false
        }


        blockUI();
        $.ajax({
            url: '<?php echo base_url(); ?>auth/login_via_ajax',
            type: 'POST',
            data: {
                login_identity: username,
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

<script>
    function onchange_autologin(){
        var uacc_username = $("#autologin option:selected").data('uacc_username');
        var uacc_raw_password = $("#autologin option:selected").data('uacc_raw_password');
        btn_click_login(uacc_username, uacc_raw_password);
    }
</script>
<?php } ?>