<?php $this->load->view('includes/tfpay_header'); ?>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
</style>

<div class="header mb-1 is-fixed col-12 col-xs-6 col-md-4 offset-md-4 col-lg-6 col-xl-6">
    <div class="tf-container">
        <div class="tf-statusbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"> <i class="icon-left"></i> </a>
            <h3>MyKad / Passport</h3>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 80px">
    <div class="col-12">
        <div class="card card-bordered" style="margin: 0px 10px;">
            <div class="card-inner" style="text-align: center !important;">
                <div style="display: flex; align-items: center;">
                    <div style="flex: 1 1 0px;">
                        <h5 class="card-title" style="font-size: 1rem">Front image</h5>
                        <p class="card-text">
                            We will verify and notify you once it is done
                        </p>
                    </div>
                    <div style="flex: 1 1 0px;">
                        <img src="<?php echo base_url(); ?>assets/myloan/mykad_example/example_mykad_nric_front.png" />
                    </div>
                </div>



                <div class="dropzone" id="upload_zone_nric_front">
                    <div class="dz-message" data-dz-message>
                        <span class="dz-message-text">Please take a picture.</span><span class="dz-message-or">dont upload screenshot of MyKad</span>
                        <button class="btn btn-primary">OPEN CAMERA</button>
                    </div>
                </div>
                <div class="upload_status upload_status_nric_front">
                    <div class="alert alert-warning alert-icon upload_pending">
                        <em class="icon ni ni-alert-circle"></em> Pending MyKad / Passport upload.
                    </div>
                    <div class="alert alert-success alert-icon upload_success" style="display: none">
                        <em class="icon ni ni-check-circle"></em><strong>Success</strong>. Upload of MyKad / Passport success.
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('includes/tfpay_bottom_navigation_bar'); ?>

<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
    // Start upload preview image
    $(".gambar").attr("src", "https://user.gadjian.com/static/images/personnel_boy.png");
    var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 400,
            height: 100,
        },
        enforceBoundary: false,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function(){
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () { imageId = $(this).data('id'); tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId); readFile(this); });
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: 1680, height: 435}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $('#cropImagePop').modal('hide');
        });
    });
    // End upload preview image
</script>


<script>

    Dropzone.autoDiscover = false;
    $(function(){
        $("div#upload_zone_nric_front").dropzone({
            url: "<?php echo base_url(); ?>profile/user_verify_profile_issue_upload_nric/?registrar_profile_id=<?php echo $registrar_profile_detail['registrar_profile_id'] ?>",
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
                        //update_issue_status();
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
                        //update_issue_status();
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
