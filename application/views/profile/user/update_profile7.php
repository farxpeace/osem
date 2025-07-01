<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.9.0/css/lightgallery.css" />
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
<style>
    .upload_waiting .icon_upload_status {
        background-color: #db0f0f;
        color: #FFFFFF;
    }
    .upload_success .icon_upload_status {
        background-color: #008136;
        color: #FFFFFF;
    }
</style>
<style>
    .camera_status_front .camera_image_icon_status i {
        font-size: 40px;
    }
    .camera_status_front.pending_snap .camera_image_icon_status i {
        color: #c30000;
    }
    .camera_status_front.pending_snap .camera_image_icon_status i.icon_exclamation {
        display: block;
    }
    .camera_status_front.pending_snap .camera_image_icon_status i.icon_success {
        display: none;
    }
    .camera_status_front.pending_snap .camera_image_icon_status i.icon_uploading {
        display: none;
    }
    .camera_status_front.uploading_image .camera_image_icon_status i.icon_uploading {
        display: block;
    }
    .camera_status_front.uploading_image .camera_image_icon_status i.icon_success {
        display: none;
    }
    .camera_status_front.uploading_image .camera_image_icon_status i.icon_exclamation {
        display: none;
    }
    .camera_status_front.success_snap .camera_image_icon_status i {
        color: #09971b;
    }
    .camera_status_front.success_snap .camera_image_icon_status i.icon_exclamation {
        display: none;
    }
    .camera_status_front.success_snap .camera_image_icon_status i.icon_success {
        display: block;
    }
    /* Back */
    .camera_status_back .camera_image_icon_status i {
        font-size: 40px;
    }
    .camera_status_back.pending_snap .camera_image_icon_status i {
        color: #c30000;
    }
    .camera_status_back.uploading_image .camera_image_icon_status i.icon_uploading {
        display: block;
    }
    .camera_status_back.uploading_image .camera_image_icon_status i.icon_success {
        display: none;
    }
    .camera_status_back.uploading_image .camera_image_icon_status i.icon_exclamation {
        display: none;
    }
    .camera_status_back.pending_snap .camera_image_icon_status i.icon_exclamation {
        display: block;
    }
    .camera_status_back.pending_snap .camera_image_icon_status i.icon_success {
        display: none;
    }
    .camera_status_back.pending_snap .camera_image_icon_status i.icon_uploading {
        display: none;
    }
    .camera_status_back.success_snap .camera_image_icon_status i {
        color: #09971b;
    }
    .camera_status_back.success_snap .camera_image_icon_status i.icon_exclamation {
        display: none;
    }
    .camera_status_back.success_snap .camera_image_icon_status i.icon_success {
        display: block;
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
<div id="app-wrap" style="padding-top: 0px; margin-bottom: 50px; background-color: #fbfbfb">
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
                <label>Email</label>
                <input class="" type="text" id="email" value="<?php echo $logged_in['user_profile']['email']; ?>">
            </div>
            <div class="content-card" style="margin-bottom: 10px">
                <div id="widget_mykad"></div>
            </div>
            <div class="content-card">
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
<div class="bottom-navigation-bar st1 bottom-btn-fixed col-md-4 offset-md-4" style="margin: 0 auto;">
    <div class="tf-container" style="display: flex; justify-content: space-between; gap: 10px;">
        <a href="javascript: void(0);" onclick="javascript: navigate_to('<?php echo base_url(); ?>profile/view_profile/');" class="tf-btn accent large" style="width: 70px; padding: 5px;"><i class="fa-solid fa-angle-left"></i></a>
        <a href="javascript: void(0);" onclick="javascript: btn_click_submit_update_profile();" class="tf-btn accent large">Update Profile</a>
    </div>
</div>
<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.9.0/js/lightgallery-all.js"></script>
<script>
    var AddressManagement;
    var IncomeManagement;
    var WidgetMyKad;
    $(function(){
        AddressManagement = $("#address_management").address_management({
            base_url: '<?php echo base_url(); ?>',
            uacc_id: '<?php echo $logged_in['uacc_id']; ?>',
            user_address_id: '<?php echo $logged_in['user_address'][0]['user_address_id'] ?? "0"; ?>',
            btn_add_new_address: '.btn_add_new_address',
            btn_choose_address: '.btn_choose_address'
        });
        IncomeManagement = $("#income_management").income_management({
            base_url: '<?php echo base_url(); ?>',
            uacc_id: '<?php echo $logged_in['uacc_id']; ?>',
        });
        WidgetMyKad = $("#widget_mykad").widget_mykad({
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
        blockUI_secondary();
        $.ajax({
            url: '<?php echo base_url(); ?>profile/user_ajax_update_profile',
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    fullname: fullname,
                    email: $("#email").val(),
                    fullname_as_per_mykad: fullname_as_per_mykad,
                    nric_number: nric_number,
                    user_address_id: user_address_id
                }
            },
            success: function(data){
                if(data.status == "success"){
                    swalTimer('success','Success', 'Profile updated', 2000).then(
                        function(value) {
                            if(data.redirect_url){
                                window.location.replace(data.redirect_url);
                            }
                        },
                    );
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
