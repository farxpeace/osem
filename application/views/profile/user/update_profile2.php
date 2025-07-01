<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

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
    #modal_address_dashboard_body {
        min-height: 20vh;
        transition: height 0.5s, height 0.5s;
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

            <div class="upload_mykad_front_frame">
                <form action="uploadFile.php" id="uploadForm_mykad_front" name="frmupload" method="post" enctype="multipart/form-data">
                    <div class="form-group mykad_upload_front upload_waiting">
                        <label class="form-label">MyKad Front</label>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon_upload_status"><i class="fa-solid fa-circle-exclamation"></i></span>
                                </div>
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="mykad_front" name="upload[nric_front]"><label class="form-file-label" for="mykad_front">Choose file</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <div class='progress' id="progressDivId_mykad_front">
                    <div class='progress-bar' id='progressBar_mykad_front'></div>
                    <div class='percent' id='percent_mykad_front'>0%</div>
                </div>
                <div style="height: 10px;"></div>
                <div id='outputImage_mykad_front'></div>
            </div>

            <div class="upload_mykad_back_frame">
                <form action="uploadFile.php" id="uploadForm_mykad_back" name="frmupload" method="post" enctype="multipart/form-data">
                    <div class="form-group mykad_upload_back upload_waiting">
                        <label class="form-label">MyKad Back</label>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon_upload_status"><i id="mykad_upload_back_fa_icon" class="fa-solid fa-circle-exclamation"></i></span>
                                </div>
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="mykad_back" name="upload[nric_back]" accept="image/*" capture="environment">
                                    <label class="form-file-label" for="mykad_back">Choose file</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
                <div class='progress' id="progressDivId_mykad_back">
                    <div class='progress-bar' id='progressBar_mykad_back'></div>
                    <div class='percent' id='percent_mykad_back'>0%</div>
                </div>
                <div style="height: 10px;"></div>
                <div id='outputImage_mykad_back'></div>
            </div>


            <div class="content-card">
                <div class="confirm_address_frame" style="display: none">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="project">
                                <div class="project-head">
                                    <a href="javascript: void(0);" class="project-title">
                                        <div class="project-info">
                                            <h6 class="title address_line_1">Redesign Website</h6>
                                            <span class="sub-text address_line_2">Runnergy</span>
                                            <span class="sub-text postcode_area_location">Runnergy</span>
                                        </div>
                                    </a>
                                </div>
                                <input id="postcode_id" type="hidden" />
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript: void(0);" onclick="javascript: open_modal_address_dashboard();" class="tf-btn large">Add a new address <i class="icon-plus fw_7"></i> </a>
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


<div class="modal modal-bottom fade" id="modal_address_dashboard" tabindex="-1" role="dialog" aria-labelledby="modal_address_dashboard">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="modal-body" id="modal_address_dashboard_body" style="height: 40vh">

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

<script>
    function open_modal_address_dashboard(){
        blockUI_secondary();
        setTimeout(function(){
            $("#modal_address_dashboard_body").load('<?php echo base_url(); ?>profile/ajax_modal_address_dashboard', {
                postdata: {
                    uacc_id: '<?php echo $logged_in["uacc_id"] ?>'
                }
            }, function(){
                unblockUI();
                $("#modal_address_dashboard").modal("show");
            })
        }, 1000)
    }
</script>

<script>
    function onchange_mykad_front(){
        $('#uploadForm_mykad_front').ajaxForm({
            target: '#outputImage',
            url: '<?php echo base_url(); ?>profile/upload_mykad/',
            beforeSubmit: function () {
                $("#outputImage_mykad_front").hide();
                if($("#uploadImage_mykad_front").val() == "") {
                    $("#outputImage_mykad_front").show();
                    $("#outputImage_mykad_front").html("<div class='error'>Choose a file to upload.</div>");
                    return false;
                }

                $("#progressDivId_mykad_front").css("display", "block");
                var percentValue = '0%';

                $('#progressBar_mykad_front').width(percentValue);
                $('#percent_mykad_front').html(percentValue);
            },
            uploadProgress: function (event, position, total, percentComplete) {

                var percentValue = percentComplete + '%';
                $("#progressBar_mykad_front").animate({
                    width: '' + percentValue + ''
                }, {
                    duration: 1000,
                    easing: "linear",
                    step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
                        $("#percent_mykad_front").text(percentText + "%");
                        if(percentText == "100") {
                            $("#outputImage_mykad_front").show();
                        }
                    }
                });
            },
            error: function (response, status, e) {
                alert('Oops something went.');
            },

            complete: function (xhr) {
                var returnData = $.parseJSON(xhr.responseText);
                if (returnData.status == 'success')
                {
                    $("#outputImage_mykad_front").html("MyKad Front upload success!");
                    $(".mykad_upload_front").removeClass('upload_waiting').addClass('upload_success')
                    $(".mykad_upload_back .icon_upload_status i").removeClass('fa-circle-exclamation').addClass('fa-circle-check')
                }
                else{
                    $("#outputImage_mykad_front").show();
                    $("#outputImage_mykad_front").html("<div class='error'>Problem in uploading file.</div>");
                    $("#progressBar_mykad_front").stop();
                }
            }
        });
    }
    function onchange_mykad_back(){
        $('#uploadForm_mykad_back').ajaxForm({
            target: '#outputImage',
            url: '<?php echo base_url(); ?>profile/upload_mykad/',
            beforeSubmit: function () {
                $("#outputImage_mykad_back").hide();
                if($("#uploadImage_mykad_back").val() == "") {
                    $("#outputImage_mykad_back").show();
                    $("#outputImage_mykad_back").html("<div class='error'>Choose a file to upload.</div>");
                    return false;
                }

                $("#progressDivId_mykad_back").css("display", "block");
                var percentValue = '0%';

                $('#progressBar_mykad_back').width(percentValue);
                $('#percent_mykad_back').html(percentValue);
            },
            uploadProgress: function (event, position, total, percentComplete) {

                var percentValue = percentComplete + '%';
                $("#progressBar_mykad_back").animate({
                    width: '' + percentValue + ''
                }, {
                    duration: 1000,
                    easing: "linear",
                    step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
                        $("#percent_mykad_back").text(percentText + "%");
                        if(percentText == "100") {
                            $("#outputImage_mykad_back").show();
                        }
                    }
                });
            },
            error: function (response, status, e) {
                alert('Oops something went.');
            },

            complete: function (xhr) {
                var returnData = $.parseJSON(xhr.responseText);
                if (returnData.status == 'success')
                {
                    console.log('OK upload back')
                    $("#mykad_upload_back_fa_icon").removeClass().addClass('fa-solid fa-circle-check')
                    $("#outputImage_mykad_back").html("MyKad Back upload success!");
                    $(".mykad_upload_back").removeClass('upload_waiting').addClass('upload_success');


                }
                else{
                    $("#outputImage_mykad_back").show();
                    $("#outputImage_mykad_back").html("<div class='error'>Problem in uploading file.</div>");
                    $("#progressBar_mykad_back").stop();
                }
            }
        });
    }
</script>

<script>
    $(function(){
        $('.uppercase_only').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });

        $("#mykad_front").on("change", function(){
            onchange_mykad_front();
            $("#uploadForm_mykad_front").submit();
        })
        $("#mykad_back").on("change", function(){
            onchange_mykad_back();
            $("#uploadForm_mykad_back").submit();
        })
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

    Dropzone.autoDiscover = false;
    $(function(){
        $("div#upload_zone_nric_front").dropzone({
            url: "<?php echo base_url(); ?>registrar_profile/user_verify_profile_issue_upload_nric/?registrar_profile_id=<?php echo $registrar_profile_detail['registrar_profile_id'] ?>",
            parallelUploads: 1,
            maxFiles: 1,
            uploadMultiple: false,
            paramName: 'upload[nric_front]',
            acceptedFiles: '.jpg,.jpeg,.png,image/*',
            capture: 'camera',
            addRemoveLinks: true,
            init: function() {
                this.on("success", function(file, response) {
                    if(response.status == 'success'){
                        $(".upload_status_nric_front .upload_pending").hide();
                        $(".upload_status_nric_front .upload_success").show();
                        $(".upload_status_nric_front").data('upload_status', 'success');
                        update_issue_status();
                    }

                })
            }

        });

        $("div#upload_zone_nric_back").dropzone({
            url: "<?php echo base_url(); ?>registrar_profile/user_verify_profile_issue_upload_nric/?registrar_profile_id=<?php echo $registrar_profile_detail['registrar_profile_id'] ?>",
            parallelUploads: 1,
            maxFiles: 1,
            uploadMultiple: false,
            paramName: 'upload[nric_back]',
            acceptedFiles: '.jpg,.jpeg,.png,image/*',
            capture: 'camera',
            addRemoveLinks: true,
            init: function() {
                this.on("success", function(file, response) {
                    if(response.status == 'success'){
                        $(".upload_status_nric_back .upload_pending").hide();
                        $(".upload_status_nric_back .upload_success").show();
                        $(".upload_status_nric_back").data('upload_status', 'success');
                        update_issue_status();
                    }

                })
            }

        });

        $("div#upload_zone_nric_selfie").dropzone({
            url: "<?php echo base_url(); ?>registrar_profile/user_verify_profile_issue_upload_nric/?registrar_profile_id=<?php echo $registrar_profile_detail['registrar_profile_id'] ?>",
            parallelUploads: 1,
            maxFiles: 1,
            uploadMultiple: false,
            paramName: 'upload[nric_selfie]',
            acceptedFiles: '.jpg,.jpeg,.png,image/*',
            capture: 'camera',
            addRemoveLinks: true,
            init: function() {
                this.on("success", function(file, response) {
                    if(response.status == 'success'){
                        $(".upload_status_nric_selfie .upload_pending").hide();
                        $(".upload_status_nric_selfie .upload_success").show();
                        $(".upload_status_nric_selfie").data('upload_status', 'success');
                        update_issue_status();
                    }

                })
            }
        });
    })


    function update_issue_status(){



        var upload_status_array = [];
        var upload_status_count = $(".upload_status").length;
        $(".upload_status").each(function(i, j){
            var upload_status = $(j).data('upload_status');
            if(upload_status == 'success'){
                upload_status_array.push(upload_status)
            }
        });
        console.log(upload_status_array.length);
        console.log(upload_status_count)
        var upload_status_array_unique = upload_status_array.filter(onlyUnique);
        if(upload_status_array.length == upload_status_count && upload_status_array_unique[0] == 'success'){
            blockUI();
            $.ajax({
                url: "<?php echo base_url(); ?>registrar_profile/ajax_user_update_issue_profile",
                type: "POST",
                dataType: "JSON",
                data: {
                    postdata: {
                        issue_profile_id: '<?php echo $issue_profile_detail["issue_profile_id"] ?>',
                        user_reply_status: "mykad_passport_all_uploaded"
                    }
                },
                success: function(data){
                    if(data.status == 'success'){
                        window.location.replace("<?php echo base_url(); ?>page/thanks_and_logout");
                        return false;
                    }
                }
            })
        }

    }
    function onlyUnique(value, index, array) {
        return array.indexOf(value) === index;
    }
</script>

<script>
    function btn_click_submit_update_profile(){
        var fullname = $("#fullname").val();
        $.ajax({
            url: '<?php echo base_url(); ?>profile/user_ajax_update_profile',
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    fullname: fullname
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
