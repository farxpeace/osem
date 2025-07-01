<?php $this->load->view('includes/tfpay_header'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel='stylesheet' type='text/css' media='screen' href='<?php echo base_url(); ?>assets/webcam-easy-master/demo/style/webcam-demo.css?time=<?php echo time(); ?>'>
<style>
    body {
        background-color: #f5f5f5 !important;
    }
</style>
<div class="header is-fixed col-md-4 offset-md-4">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>MyKad Upload</h3>
        </div>
    </div>
</div>
<div id="app-wrap">


</div>

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

    .camera_status_back.pending_snap .camera_image_icon_status i.icon_exclamation {
        display: block;
    }
    .camera_status_back.pending_snap .camera_image_icon_status i.icon_success {
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

<div class="modal modal-bottom fade" id="modal_choose_front_or_back" tabindex="-1" role="dialog" aria-labelledby="modal_choose_front_or_back">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px; ">
            <div class="modal-body">
                <div class="card card-bordered">
                    <div class="card-inner-group">

                        <div class="card-inner card-inner-md camera_status_front pending_snap">
                            <div class="user-card">
                                <div class="user-avatar bg-primary-dim camera_image_icon_status">
                                    <i class="fa-solid fa-circle-exclamation icon_exclamation"></i>
                                    <i class="fa-solid fa-circle-check icon_success"></i>
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">MyKad Front</span><span class="sub-text">Pending image upload</span>
                                </div>
                                <div class="user-action">

                                </div>
                            </div>
                        </div>
                        <div class="card-inner card-inner-md camera_status_back pending_snap">
                            <div class="user-card">
                                <div class="user-avatar bg-pink-dim camera_image_icon_status">
                                    <i class="fa-solid fa-circle-exclamation icon_exclamation"></i>
                                    <i class="fa-solid fa-circle-check icon_success"></i>
                                </div>
                                <div class="user-info">
                                    <span class="lead-text">MyKad Back</span><span class="sub-text">Pending image upload</span>
                                </div>
                                <div class="user-action">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 30px; margin-top: 50px;">
                    <a href="javascript: void(0);" onclick="javascript: open_camera_mykad('front');" class="tf-btn accent large" style="padding: 12px 10px;">MyKad Front</a>
                    <a href="javascript: void(0);" onclick="javascript: open_camera_mykad('back');" class="tf-btn accent large" style="padding: 12px 10px;">MyKad Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-bottom fade" id="modal_name_and_ic_number" tabindex="-1" role="dialog" aria-labelledby="modal_name_and_ic_number">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px; ">
            <div class="modal-body">
                <div class="card card-bordered">
                    <div class="card-inner-group">

                        <div class="card-inner card-inner-md">
                            <div class="group-input" style="margin-bottom: 0px;">
                                <label>Fullname as per MyKad / Passport</label>
                                <input class="uppercase_only" type="text" placeholder="Tony" id="fullname_as_per_mykad">
                            </div>
                        </div>
                        <div class="card-inner card-inner-md">
                            <div class="group-input" style="margin-bottom: 0px;">
                                <label>MyKad Number</label>
                                <input type="number" placeholder="861112235811" id="nric_number">
                            </div>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 0px; margin-top: 10px;">
                    <a href="javascript: void(0);" onclick="javascript: open_modal_choose_front_or_back();" class="tf-btn accent large" style="padding: 12px 10px;">Submit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #camera_mask_mykad {
        position: absolute;
        bottom: 40vh;
        left: 10%;
        width: 80%;
        z-index: 99999;
        background: transparent;
        opacity: 0.7;
        padding: 10px;
        border: 3px solid #000000;
        aspect-ratio: 3 / 1.89;
    }
    #camera_button_mykad {
        position: absolute;
        bottom: 5vh;
        left: 10%;
        width: 80%;
        z-index: 99999;
        background: transparent;
        opacity: 1;
        padding: 10px;
        aspect-ratio: 3 / 1.89;
    }
</style>

<div class="modal modal-bottom fade" id="modal_open_camera" tabindex="-1" role="dialog" aria-labelledby="modal_open_camera">
    <div class="modal-dialog " role="document" style="margin: 0 auto">
        <div class="modal-content col-md-4 offset-md-4" style="border-top-left-radius: 10px; border-top-right-radius: 10px; background-color: #008136;">
            <div class="modal-body" style="padding: 0;">
                <main id="webcam-app">
                    <!--
                    <div class="form-control webcam-start" id="webcam-control">
                        <label class="form-switch">
                            <input type="checkbox" id="webcam-switch">
                            <i></i>
                        </label>
                    </div>
                    -->

                    <div id="errorMsg" class="col-12 col-md-6 alert-danger d-none">
                        Fail to start camera, please allow permision to access camera. <br/>
                        If you are browsing through social media built in browsers, you would need to open the page in Sarafi (iPhone)/ Chrome (Android)
                        <button id="closeError" class="btn btn-primary ml-3">OK</button>
                    </div>
                    <div class="md-modal md-effect-12">
                        <div id="app-panel" class="app-panel md-content row p-0 m-0">
                            <div id="camera_mask_mykad"></div>
                            <div id="webcam-container" class="webcam-container col-12 d-none p-0 m-0">
                                <video id="webcam" autoplay playsinline ></video>
                                <canvas id="canvas" class="d-none"></canvas>
                                <div class="flash"></div>
                                <audio id="snapSound" src="<?php echo base_url(); ?>assets/webcam-easy-master/demo/audio/snap.wav" preload = "auto"></audio>
                            </div>
                            <div id="cameraControls" class="cameraControls">
                                <a href="#" id="exit-app" title="Exit App" class="d-none"><i class="material-icons">exit_to_app</i></a>
                                <a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a>
                                <a href="#" id="download-photo" download="selfie.png" target="_blank" title="Save Photo" class="d-none"><i class="material-icons">file_download</i></a>
                                <a href="#" id="resume-camera"  title="Resume Camera" class="d-none"><i class="material-icons">camera_front</i></a>
                            </div>
                            <div id="camera_button_mykad" class="d-none">
                                <a href="javascript: void(0);" onclick="javascript: use_this_image();" class="tf-btn light large" style="margin: 12px 10px; background-color: #008136; color: #FFFFFF;">Use this image</a>
                                <a href="javascript: void(0);" onclick="javascript: take_picture_again();" class="tf-btn light large" style="margin: 12px 10px; background-color: #008136; color: #FFFFFF;">Take picture again</a>
                            </div>
                        </div>
                    </div>
                    <div class="md-overlay"></div>
                </main>
                <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 30px; margin-top: 50px;">
                    <a href="javascript: void(0);" onclick="javascript: close_camera_mykad();" class="tf-btn light large" style="margin: 12px 10px; background-color: #e3cb20; color: #FFFFFF;">Close Camera</a>
                </div>
            </div>
        </div>
    </div>
</div>

<input id="mykad_front_back" type="hidden" />
<input id="camera_front_result_base64" type="hidden">
<input id="camera_back_result_base64" type="hidden">

<div class="bottom-navigation-bar col-md-4 offset-md-4" style="margin: 0 auto;padding-top: 10px; padding-bottom: 10px;">
    <div class="tf-container">
        <a href="javascript: void(0);" onclick="javascript: open_modal_choose_front_or_back();" id="btn-popup-up" class="tf-btn accent large">Open Camera</a>
    </div>
</div>
<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="<?php echo base_url(); ?>assets/webcam-easy-master/dist/webcam-easy.js?time=<?php echo time(); ?>"></script>
<script src='<?php echo base_url(); ?>assets/webcam-easy-master/demo/js/app.js?time=<?php echo time(); ?>'></script>
<script>
    function use_this_image(){
        afterTakePhoto();
        close_camera_mykad();

        open_modal_choose_front_or_back();
    }
    function take_picture_again(){
        webcam.stream()
            .then(facingMode =>{
                removeCapture();
            });
        $("#camera_button_mykad").addClass("d-none");
    }
    function open_camera_mykad(mykad_front_back){
        $("#modal_choose_front_or_back").modal("hide");
        $("#modal_open_camera").modal("show");

        //hide use this image button
        $("#camera_button_mykad").addClass("d-none");

        $("#mykad_front_back").val(mykad_front_back)

        $('.md-modal').addClass('md-show');
        webcam.start()
            .then(result =>{
                cameraStarted();
                //console.log("webcam started");
            })
            .catch(err => {
                displayError();
            });
    }
    function close_camera_mykad(){

        //stop camera
        cameraStopped();
        webcam.stop();
        removeCapture();
        $("#modal_open_camera").modal("hide");
    }

    function open_modal_choose_front_or_back(){
        var camera_front_result_base64 = $("#camera_front_result_base64").val();
        var camera_back_result_base64 = $("#camera_back_result_base64").val();
        var fullname_as_per_mykad = $("#fullname_as_per_mykad").val();
        var nric_number = $("#nric_number").val();

        console.log("fullname_as_per_mykad "+ fullname_as_per_mykad.length);
        console.log("nric_number "+ nric_number.length);

        if(camera_front_result_base64.length > 30){
            $(".camera_status_front").removeClass('pending_snap').addClass("success_snap");
        } else {
            $(".camera_status_front").removeClass('success_snap').addClass("pending_snap");
        }

        if(camera_back_result_base64.length > 30){
            $(".camera_status_back").removeClass('pending_snap').addClass("success_snap");
        } else {
            $(".camera_status_back").removeClass('success_snap').addClass("pending_snap");
        }

        if(camera_front_result_base64.length > 30 && camera_back_result_base64.length > 30  && fullname_as_per_mykad.length > 5 && nric_number.length > 5){
            //submit
            submit_to_server();
        }else if(camera_front_result_base64.length > 30 && camera_back_result_base64.length > 30  && (fullname_as_per_mykad.length < 5 || nric_number.length < 5)){
            $("#modal_name_and_ic_number").modal("show");
            Swal.fire({
                icon: 'info',
                text: 'Please fill in Fullname and MyKad number',
            })
        }else if(camera_front_result_base64.length < 30 || camera_back_result_base64.length < 30){
            $("#modal_choose_front_or_back").modal("show");
        }


    }

</script>
<script>

    function submit_to_server(){

        var blob_mykad_front = dataURItoBlob($("#camera_front_result_base64").val());
        var blob_mykad_back = dataURItoBlob($("#camera_back_result_base64").val());

        var formData = new FormData();
        formData.append('upload[nric_front]', blob_mykad_front);
        formData.append('upload[nric_back]', blob_mykad_back);
        formData.append('postdata[fullname_as_per_mykad]', $("#fullname_as_per_mykad").val());
        formData.append('postdata[nric_number]', $("#nric_number").val())

        blockUI();

        $.ajax({
            url: "<?php echo base_url(); ?>profile/user_upload_mykad_front_back",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data){
                unblockUI();
                data = $.parseJSON(data);
                if(data.status == 'success'){
                    $('#uploadImageModal').modal('hide');
                    $('#uploaded_image').html(data);
                    swalTimer('success','Success', 'We will verify your MyKad submission', 3000).then(
                        function(value) {
                            window.location.href = "<?php echo base_url(); ?>auth_admin/dashboard/";
                        },
                    );
                }else{
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message_single,
                        backdrop:`
                            #bb0011
                        `
                    })
                }

            }
        });

    }
    function dataURItoBlob(dataURI) {
        // convert base64 to raw binary data held in a string
        // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
        var byteString = atob(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

        // write the bytes of the string to an ArrayBuffer
        var ab = new ArrayBuffer(byteString.length);

        // create a view into the buffer
        var ia = new Uint8Array(ab);

        // set the bytes of the buffer to the correct values
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        // write the ArrayBuffer to a blob, and you're done
        var blob = new Blob([ab], {type: mimeString});
        return blob;

    }
</script>


