<?php $this->load->view('includes/tfpay_header'); ?>

<style>
    .dropzone { text-align: center; }
    .avatar-upload {
        position: relative;
        max-width: 100px;
        margin: 50px auto;
    }
    .avatar-upload .avatar-edit {
        position: absolute;
        right: -12px;
        z-index: 1;
        top: -10px;
    }
    .avatar-upload .avatar-edit input {
        display: none;
    }
    .avatar-upload .avatar-edit input + label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }
    .avatar-upload .avatar-edit input + label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }
    .avatar-upload .avatar-edit input + label:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #F6B21B;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
    }
    .avatar-upload .avatar-preview {
        width: 100px;
        height: 100px;
        position: relative;
        border-radius: 100%;
        border: 3px solid #008136;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    }
    .avatar-upload .avatar-preview > div {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>

<div class="header">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Personal Details</h3>
        </div>
    </div>
</div>
<div id="app-wrap" style="padding-top: 0px; margin-bottom: 50px">
    <div class="tf-container">

        <div class="avatar-upload">
            <div class="avatar-edit">
                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
                <div id="imagePreview" onclick="javascript: $('#imageUpload').click();" style="background-image: url(<?php echo $logged_in['user_profile']['profile_picture_url'] ?>);">
                </div>

            </div>
        </div>


        <div class="tf-form">
            <div class="group-input">
                <label>Nickname</label>
                <input class="uppercase_only" type="text" placeholder="Tony" id="fullname" value="<?php echo $logged_in['user_profile']['fullname']; ?>">
            </div>

            <div class="group-input">
                <label>Fullname (as per MyKad)</label>
                <input class="uppercase_only" type="text" placeholder="Tony" id="fullname_as_per_mykad" value="<?php echo $logged_in['user_profile']['fullname_as_per_mykad']; ?>">
            </div>
            <div class="group-input">
                <label>MyKad Number</label>
                <input type="number" placeholder="861112235811" id="nric_number" value="<?php echo $logged_in['user_profile']['nric_number']; ?>">
            </div>

            <a href="javascript: void(0);" onclick="javascript: open_modal_choose_front_or_back();" id="btn-popup-up" class="tf-btn accent large" style="margin-bottom: 20px;">Click to Upload MyKad</a>

            <div class="content-card" style="margin-bottom: 10px">
                <div id="widget_mykad"></div>
            </div>

            <div class="content-card" >
                <div id="address_management"></div>
            </div>
            <style>
                .monthly_commitment_item_amount {
                    font-size: 12px;
                }
            </style>
            <div class="content-card" style="margin-top: 10px;">
                <div id="income_management">
                </div>
            </div>


            <?php if($logged_in['mykad_verification_status'] == 'verified'){ ?>
                <div class="tf-card-block d-flex align-items-center justify-content-between" style="margin-bottom: 20px;">
                    <div class="inner d-flex align-items-center">
                        <i class="logo icon-wallet-filled-money-tool"></i>
                        <div class="content">
                            <h4><a href="javascript: void(0);" class="fw_6"><?php echo $logged_in['user_profile']['fullname_as_per_mykad']; ?></a></h4>
                            <p><?php echo $logged_in['nric_number']; ?></p>
                        </div>
                    </div>
                    <span class="text-success">MyKad Verified!</span>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<style>
    .preloader_bg {
        background-color: #008136;
    }
    .preloader_container {
        background: #008136;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: center;
        align-content: center;
        margin: 0px -15px;
    }

    .flex {
        min-height: 60pt;
        margin-top: 50pt;
    }

    @-webkit-keyframes loading {
        0% {
            width: 50pt;
            height: 50pt;
            margin-top: 0;
        }
        25% {
            height: 4pt;
            margin-top: 23pt;
        }
        50% {
            width: 4pt;
        }
        75% {
            width: 50pt;
        }
        100% {
            width: 50pt;
            height: 50pt;
            margin-top: 0;
        }
    }

    @keyframes loading {
        0% {
            width: 50pt;
            height: 50pt;
            margin-top: 0;
        }
        25% {
            height: 4pt;
            margin-top: 23pt;
        }
        50% {
            width: 4pt;
        }
        75% {
            width: 50pt;
        }
        100% {
            width: 50pt;
            height: 50pt;
            margin-top: 0;
        }
    }
    .loader {
        width: 50pt;
        height: 50pt;
        border-radius: 100%;
        border: #FFFFFF 4pt solid;
        margin-left: auto;
        margin-right: auto;
        background-color: transparent;
        -webkit-animation: loading 1s infinite;
        animation: loading 1s infinite;
    }

    .load-text {
        padding-top: 15px;
        text-align: center;
        font: 14pt "Helvetica Neue", Helvetica, Arial, sans-serif;
        color: white;
    }

</style>
<pre><?php print_r($logged_in) ?></pre>
<div class="modal modal-bottom fade" id="modal_choose_front_or_back" tabindex="-1" role="dialog" aria-labelledby="modal_choose_front_or_back">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px; ">
            <div class="modal-body">
                <div class="card card-bordered">
                    <div class="card-inner-group">


                        <div class="card-inner card-inner-md camera_status_front pending_snap">
                            <div class="user-card">
                                <?php if(count($logged_in['user_profile']['mykad']['nric_front']) > 0){ ?>
                                    <div class="user-avatar bg-primary-dim camera_image_icon_status">
                                        <img src="<?php echo $logged_in['user_profile']['mykad']['nric_front']['attachment_thumbnail_fullurl'] ?>" style="width: 40px; height: 40px" />
                                    </div>
                                <?php }else{ ?>
                                    <div class="user-avatar bg-primary-dim camera_image_icon_status">
                                        <i class="fa-solid fa-circle-exclamation icon_exclamation"></i>
                                        <i class="fa-solid fa-circle-check icon_success"></i>
                                        <i class="fa-solid fa-spinner fa-spin icon_uploading"></i>
                                    </div>
                                <?php } ?>

                                <div class="user-info">
                                    <span class="lead-text">MyKad Front</span><span class="sub-text upload_mykad_front_status_text">Pending image upload</span>
                                </div>
                                <div class="user-action">
                                    <a href="javascript: void(0);" onclick="javascript: open_camera_mykad_front();" class="tf-btn large" style="padding: 0px;">
                                        <img src="<?php echo base_url(); ?>assets/myloan/icon_camera_mykad-256x256.png?asd=asd" style="width: 40px" />
                                    </a>
                                </div>

                            </div>

                        </div>

                        <div class="card-inner card-inner-md camera_status_back pending_snap">
                            <div class="user-card">
                                <div class="user-avatar bg-primary-dim camera_image_icon_status">
                                    <i class="fa-solid fa-circle-exclamation icon_exclamation"></i>
                                    <i class="fa-solid fa-circle-check icon_success"></i>
                                    <i class="fa-solid fa-spinner fa-spin icon_uploading"></i>
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">MyKad Back</span><span class="sub-text upload_mykad_back_status_text">Pending image upload</span>
                                </div>
                                <div class="user-action">

                                    <a href="javascript: void(0);" onclick="javascript: open_camera_mykad_back();" class="tf-btn large" style="padding: 0px;">
                                        <img src="<?php echo base_url(); ?>assets/myloan/icon_camera_mykad-256x256.png?asd=asd" style="width: 40px" />

                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; gap: 0px; margin-bottom: 30px; margin-top: 50px;">
                    <a href="javascript: void(0);" data-bs-dismiss="modal" class="tf-btn accent large" style="padding: 12px 10px; background-color: #a50000; border: 1px solid #a50000;">Close</a>

                    <form action="uploadFile.php" id="uploadForm_mykad_front" name="frmupload" method="post" enctype="multipart/form-data">
                        <input type="file" accept="image/*" capture="environment" id="fileinput_mykad_front" name="upload[nric_front]" style="display: none" />
                    </form>
                    <form action="uploadFile.php" id="uploadForm_mykad_back" name="frmupload" method="post" enctype="multipart/form-data">
                        <input type="file" accept="image/*" capture="environment" id="fileinput_mykad_back" name="upload[nric_back]" style="display: none" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>profile/view_profile/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
        <a href="javascript: void(0);" onclick="javascript: btn_click_submit_update_profile();" class="tf-btn accent large">Update Profile</a>
    </div>
</div>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php if(count($logged_in['user_address']) == 1){ ?>
    <script>
        $(function(){
            $(".address_line_1").text('<?php echo $logged_in['user_address'][0]['address_line_1'] ?>');
            $(".address_line_2").text('<?php echo $logged_in['user_address'][0]['address_line_2'] ?>');
            $(".postcode_area_location").text('<?php echo $logged_in['user_address'][0]['area_name'].", ".$logged_in['user_address'][0]['post_office'].", ".$logged_in['user_address'][0]['state_code'] ?>')
            $("#postcode_id").val('<?php echo $logged_in['user_address'][0]['postcode_id'] ?>');
            $("#user_address_id").val('<?php echo $logged_in['user_address'][0]['user_address_id'] ?>')
            $(".confirm_address_frame").show();
        })
    </script>
<?php } ?>

<script>
    var AddressManagement;
    var IncomeManagement;
    var WidgetMykad;
    $(function(){
        AddressManagement = $("#address_management").address_management({
            base_url: '<?php echo base_url(); ?>',
            uacc_id: '<?php echo $logged_in['uacc_id']; ?>',
            user_address_id: '<?php echo $logged_in['user_address'][0]['user_address_id'] ?>',
            btn_add_new_address: '.btn_add_new_address',
            btn_choose_address: '.btn_choose_address'
        });

        IncomeManagement = $("#income_management").income_management({
            base_url: '<?php echo base_url(); ?>',
            uacc_id: '<?php echo $logged_in['uacc_id']; ?>',
            incomeData: {
                monthly_gross_income: '10000',
                monthly_net_income: '1000',
                monthly_allowance: '300',
                monthly_hire_purchase: '250',
                monthly_mortgage: '500',
                monthly_personal_loan: '800',
                monthly_credit_card: '5000',

            }
        });
        WidgetMykad = $("#widget_mykad").widget_mykad({
            base_url: '<?php echo base_url(); ?>',
            uacc_id: '<?php echo $logged_in['uacc_id']; ?>',
        });

    })
</script>



<script>
    $(function(){
        $('.uppercase_only').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });


    });

</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
                blockUI();
                var $data = { 'uacc_id': '<?php echo $logged_in["uacc_id"]; ?>', 'file': reader.result };
                $.ajax({
                    dataType: "JSON",
                    type: 'POST',
                    url: '<?php echo base_url(); ?>profile/user_upload_profile_photo',
                    data: $data,
                    success: function(data) {
                        unblockUI();
                        if(data.status == "success"){
                            Swal.fire({
                                title: 'Success',
                                text: "Profile updated",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'Ok!'
                            })
                        }else{

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
                    },
                    error: function(response) {

                    },
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        //readURL(this);
        readURL(this);
    });
</script>

<script>
    function onlyUnique(value, index, array) {
        return array.indexOf(value) === index;
    }
</script>

<script>
    function btn_click_submit_update_profile(){
        var fullname = $("#fullname").val();
        var fullname_as_per_mykad = $("#fullname_as_per_mykad").val();
        var nric_number = $("#nric_number").val();
        var user_address_id = AddressManagement.get_user_address_id();

        if(user_address_id == ''){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please choose address',
            })
            return false;
        }
        if($(".camera_status_front").hasClass('pending_snap')){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please upload MyKad Front',
            })
            return false;
        }
        if($(".camera_status_back").hasClass('pending_snap')){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please upload MyKad Front',
            })
            return false;
        }

        $.ajax({
            url: '<?php echo base_url(); ?>profile/user_ajax_update_profile',
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    fullname: fullname,
                    fullname_as_per_mykad: fullname_as_per_mykad,
                    nric_number: nric_number,
                    postcode_id: postcode_id
                }
            },
            success: function(data){
                if(data.status == "success"){
                    Swal.fire({
                        title: 'Success',
                        text: "Profile updated",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            history.back();
                        }
                    })
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
    }
</script>
