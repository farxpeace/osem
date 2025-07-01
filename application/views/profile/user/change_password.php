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
            <a href="<?php echo base_url(); ?>profile/view_profile" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>Change Password</h3>
        </div>
    </div>
</div>
<div id="app-wrap">
    <div class="mt-3">
        <div class="tf-container">



            <div class="tf-form">
                <div class="group-input">
                    <label>Current Password</label>
                    <input class="" type="text" id="current_password">
                </div>
                <div class="group-input">
                    <label>New Password</label>
                    <input class="" type="text" id="new_password">
                </div>

                <div class="group-input">
                    <label>Re-type New Password</label>
                    <input class="" type="text" id="retype_new_password">
                </div>

                <div class="group-btn-change-name">
                    <a href="javascript: void(0);" onclick="javascript: btn_click_submit_change_password();" class="tf-btn accent large">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('includes/tfpay_bottom_navigation_bar'); ?>
<?php $this->load->view('includes/tfpay_footer'); ?>

<script>
    function btn_click_submit_change_password(){
        var current_password = $("#current_password").val();
        var new_password = $("#new_password").val();
        var retype_new_password = $("#retype_new_password").val();
        $.ajax({
            url: '<?php echo base_url(); ?>profile/user_ajax_change_password',
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    current_password: current_password,
                    new_password: new_password,
                    retype_new_password: retype_new_password,
                }
            },
            success: function(data){
                if(data.status == "success"){
                    Swal.fire({
                        title: 'Success',
                        text: "Password changed!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Ok!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace("<?php echo base_url(); ?>profile/view_profile");
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
