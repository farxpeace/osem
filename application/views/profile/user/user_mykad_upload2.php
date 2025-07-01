<?php $this->load->view('includes/tfpay_header'); ?>
<link rel='stylesheet' href='https://foliotek.github.io/Croppie/croppie.css'>
<style>

    .dropzone { text-align: center; }
    .dropzone .dz-preview .dz-remove {
        display: none !important;
    }
    ul.nk-quick-nav {
        display: none !important;
    }
    .nk-menu-trigger {
        display: none !important;
    }
    label.cabinet{
        display: block;
        cursor: pointer;
    }

    label.cabinet input.file{
        position: relative;
        height: 100%;
        width: auto;
        opacity: 0;
        -moz-opacity: 0;
        filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
        margin-top:-30px;
    }

    #upload-demo{
        width: 100%;
        height: 420px;
        padding-bottom:25px;
    }
    #upload-demo_back{
        width: 100%;
        height: 420px;
        padding-bottom:25px;
    }
    .card-title {
        margin-top: 10px;
        font-size: 18px;
        color: #747474;
    }
    .figbutton_trigger_upload {
        width: 60%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin: 0 auto;
    }
    .figbutton_trigger_upload i {
        width: 20px;
        height: 20px;
    }

    .cr-boundary img { max-height: none; max-width: none; }
</style>

<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>MyKad / Passport</h3>
        </div>
    </div>
</div>




<div id="app-wrap" class="row" style="margin-top: 0px">
    <div class="col-12">

        <div class="tf-form" style="margin: 10px; margin-top: 50px">
            <div class="group-input">
                <label>Fullname as per MyKad / Passport</label>
                <input class="uppercase_only" type="text" placeholder="Tony" id="fullname_as_per_mykad" value="<?php echo $logged_in['user_profile']['fullname_as_per_mykad']; ?>">
            </div>
            <div class="group-input">
                <label>MyKad Number</label>
                <input type="number" placeholder="861112235811" id="nric_number" value="<?php echo $logged_in['nric_number']; ?>">
            </div>

        </div>

        <div class="card card-bordered" style="margin: 0px 10px;">
            <div class="card-inner" style="text-align: center !important;">
                <div style="display: flex; align-items: center;">
                    <div style="flex: 1 1 0px;">
                        <h5 class="card-title" style="font-size: 1rem">MyKad Front</h5>
                        <p class="card-text">
                            We will verify and notify you once it is done
                        </p>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="croppie_result_html_front"></div>

                                    <label class="cabinet center-block">
                                        <figure>
                                            <img src="" class="gambar img-responsive img-thumbnail" id="item-img-output" style="width: 100%" />
                                            <figbutton class="btn btn-primary figbutton_trigger_upload"><i class="icon-scan-qr-code"></i> open camera</figbutton>
                                        </figure>
                                        <input type="file" class="item-img file center-block" name="file_photo" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card card-bordered" style="margin: 0px 10px;">
            <div class="card-inner" style="text-align: center !important;">
                <div style="display: flex; align-items: center;">
                    <div style="flex: 1 1 0px;">
                        <h5 class="card-title" style="font-size: 1rem">MyKad Back</h5>
                        <p class="card-text">
                            We will verify and notify you once it is done
                        </p>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="cabinet center-block">
                                        <figure>
                                            <img src="" class="gambar_back img-responsive img-thumbnail" id="item-img-output_back" style="width: 60%" />
                                            <figbutton class="btn btn-primary figbutton_trigger_upload"><i class="icon-scan-qr-code"></i> open camera</figbutton>
                                        </figure>
                                        <input type="file" class="item-img_back file center-block" name="file_photo" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12" style="padding: 25px;">
        <div class="group-btn-change-name">

            <a href="<?php echo base_url(); ?>auth_admin/dashboard" class="tf-btn light large" style="background-color: #b70e0e; color: #FFFFFF">Cancel</a>
            <a href="javascript: void(0);" onclick="javascript: btn_submit_mykad();" class="tf-btn accent large">Submit</a>
        </div>
    </div>
</div>



<div class="tf-panel down" id="popup_crop_image">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-down col-md-4 offset-md-4">
        <div class="header bg_white_color">
            <div class="tf-container">
                <div class="tf-statusbar d-flex justify-content-center align-items-center">
                    <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                    <h3>Crop MyKad</h3>

                </div>
            </div>
        </div>
        <div class="wrap-transfer mb-5">
            <div class="tf-container">
                <div id="upload-demo" class="center-block"></div>
            </div>

        </div>
        <a href="javascript: void(0);" id="confirmCropBtn" class="btn btn-primary" style="width: -webkit-fill-available; margin: 10px;">Confirm <i class="icon-plus fw_7"></i> </a>
    </div>
</div>

<div class="tf-panel down" id="popup_crop_image_back">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-down col-md-4 offset-md-4">
        <div class="header bg_white_color">
            <div class="tf-container">
                <div class="tf-statusbar d-flex justify-content-center align-items-center">
                    <a href="#" class="clear-panel"> <i class="icon-close1"></i> </a>
                    <h3>Crop MyKad</h3>

                </div>
            </div>
        </div>
        <div class="wrap-transfer mb-5">
            <div class="tf-container">
                <div id="upload-demo_back" class="center-block"></div>
            </div>

        </div>
        <a href="javascript: void(0);" id="confirmCropBtn_back" class="btn btn-primary" style="width: -webkit-fill-available; margin: 10px;">Confirm <i class="icon-plus fw_7"></i> </a>
    </div>
</div>


<?php $this->load->view('includes/tfpay_bottom_navigation_bar'); ?>

<?php $this->load->view('includes/tfpay_footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/exif-js@2.3.0/exif.min.js"></script>
<script src='https://foliotek.github.io/Croppie/croppie.js'></script>



<!--
<script>
    // Start upload preview image
    $(".gambar_back").attr("src", "https://myloan.tpirs.net/assets/myloan/mykad_example/example_mykad_nric_back.png");
    var $uploadCrop_back,
        tempFilename_back,
        rawImg_back,
        imageId_back;


    function readFile_back(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo_back').addClass('ready');
                rawImg_back = e.target.result;
                open_modal_crop_back(rawImg_back);

            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop_back = $('#upload-demo_back').croppie({
        viewport: {
            width: 200,
            height: 126.5,
        },
        enableOrientation: true,
        enableResize: false,
        mouseWheelZoom: 'ctrl',

        enforceBoundary: true,
        enableExif: true
    });

    $('.item-img_back').on('change', function () {
        imageId_back = $(this).data('id');
        tempFilename_back = $(this).val();
        $('#cancelCropBtn').data('id', imageId_back);
        readFile_back(this);
    });
    $('#confirmCropBtn_back').on('click', function (ev) {
        $uploadCrop_back.croppie('result', {
            type: 'blob',
            format: 'jpeg',
            quality: 1,
            size: {width: 1200, type: 'square'}
        }).then(function (resp) {
            blob_mykad_back = resp;
            var reader = new FileReader();
            reader.readAsDataURL(resp);
            reader.onloadend = function() {
                var base64data = reader.result;
                $('#item-img-output_back').attr('src', base64data);
            }
            TFPanelClose("#popup_crop_image_back");
            //$uploadCrop_back.croppie('destroy');
        });
    });
    // End upload preview image

    function open_modal_crop_back(rawImg_back){
        // alert('Shown pop');
        $uploadCrop_back.croppie('bind', {
            url: rawImg_back
        }).then(function(){
            console.log('jQuery bind complete');
        });
        TFPanelOpen("#popup_crop_image_back");
    }
</script>
-->

<script>
    // Start upload preview image
    $(".gambar_back").attr("src", "https://myloan.tpirs.net/assets/myloan/mykad_example/example_mykad_nric_back.png");
    var $uploadCrop_back,
        tempFilename_back,
        rawImg_back,
        imageId_back;


    function readFile_back(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo_back').addClass('ready');
                rawImg_back = e.target.result;
                open_modal_crop_back(rawImg_back);

            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop_back = $('#upload-demo_back').croppie({
        viewport: {
            width: 200,
            height: 126.5,
        },
        enableOrientation: true,
        enableResize: false,
        mouseWheelZoom: 'ctrl',

        enforceBoundary: true,
        enableExif: true
    });

    $('.item-img_back').on('change', function () {
        imageId_back = $(this).data('id');
        tempFilename_back = $(this).val();
        $('#cancelCropBtn').data('id', imageId_back);
        readFile_back(this);
    });
    $('#confirmCropBtn_back').on('click', function (ev) {
        $uploadCrop_back.croppie('result', {
            type: 'blob',
            format: 'jpeg',
            quality: 1,
            size: {width: 1200, type: 'square'}
        }).then(function (resp) {
            blob_mykad_back = resp;
            var reader = new FileReader();
            reader.readAsDataURL(resp);
            reader.onloadend = function() {
                var base64data = reader.result;
                $('#item-img-output_back').attr('src', base64data);
            }
            TFPanelClose("#popup_crop_image_back");
            //$uploadCrop_back.croppie('destroy');
        });
    });
    // End upload preview image

    function open_modal_crop_back(rawImg_back){
        // alert('Shown pop');
        $uploadCrop_back.croppie('bind', {
            url: rawImg_back
        }).then(function(){
            console.log('jQuery bind complete');
        });
        TFPanelOpen("#popup_crop_image_back");
    }
</script>

<script>
    // Start upload preview image
    $(".gambar").attr("src", "https://myloan.tpirs.net/assets/myloan/mykad_example/example_mykad_nric_front.png");
    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;


    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                rawImg = e.target.result;
                open_modal_crop(rawImg);

            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 200,
            height: 126.5,
        },
        enableOrientation: true,
        enableResize: false,
        enforceBoundary: true,
        enableExif: true,
    });

    $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId);
        readFile(this);
    });
    $('#confirmCropBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {
                width: 200,
                height: 126.5,
            }
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            TFPanelClose("#popup_crop_image");
            //$uploadCrop.croppie('destroy');
        });
    });
    // End upload preview image

    function open_modal_crop(rawImg){
        TFPanelOpen("#popup_crop_image");
        setTimeout(function(){
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function(){
                //$uploadCrop.croppie('setZoom', '1.5');
                console.log('jQuery bind complete');
            });
        }, 1000)


    }
</script>


<script>
    var blob_mykad_front;
    var blob_mykad_back;
    function btn_submit_mykad(){

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
    function base64ToBlob(base64, mime)
    {
        mime = mime || '';
        var sliceSize = 1024;
        var byteChars = window.atob(base64);
        var byteArrays = [];

        for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
            var slice = byteChars.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        return new Blob(byteArrays, {type: mime});
    }
</script>

