<?php $this->load->view('includes/tfpay_header'); ?>
<style>
    body {
        background-color: #f5f5f5 !important;
    }
    #signature_wrap {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        height: 200px;
        width: 100%;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin: 0;
        padding: 0px 16px;
        font-family: Helvetica, Sans-Serif;
        margin-top: 0vh;
    }
    .signature-pad {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        font-size: 10px;
        width: 100%;
        height: 100%;
        max-width: 700px;
        max-height: 460px;
        border: 0px solid #e8e8e8;
        background-color: #f5f5f5;
        border-radius: 4px;
        padding: 0px;
    }



    .signature-pad--body {
        position: relative;
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        border: 1px solid #f4f4f4;
        height: 50vh;
    }

    .signature-pad--body
    canvas {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.02) inset;
    }

    .signature-pad--footer {
        color: #C3C3C3;
        text-align: center;
        font-size: 1.2em;
        margin-top: 8px;
    }

    .signature-pad--actions {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        margin-top: 8px;
    }

    #github img {
        border: 0;
    }

    @media (max-width: 940px) {
        #github img {
            width: 90px;
            height: 90px;
        }
    }
</style>

<div class="app-header st1">
    <div class="tf-container">
        <div class="tf-topbar d-flex justify-content-center align-items-center">
            <a href="#" class="back-btn"><i class="icon-left white_color"></i></a>
            <h3 class="white_color">Consent</h3>
        </div>
    </div>
</div>
<div class="card-secton topup-content">
    <div class="tf-container">
        <div class="tf-balance-box">
            <div class="d-flex justify-content-between align-items-center">
                <p>Date :</p>
                <h3><?php echo date("l, j M Y g:i A") ?></h3>
            </div>
            <div class="tf-spacing-16"></div>
            <div class="tf-form">
                <div class="group-input input-field input-money">
                    <label for="">Fullname as per MyKad</label>
                    <input type="text" value="<?php echo $logged_in['user_profile']['fullname_as_per_mykad'] ?>" disabled="" class="search-field value_input st1">
                </div>
            </div>

        </div>

    </div>
</div>


<div id="app-wrap">
    <div id="signature_wrap">
        <div id="signature-pad" class="signature-pad">
            <div class="signature-pad--body">
                <canvas></canvas>
            </div>
            <div class="signature-pad--footer">
                <div class="description">Sign inside box above using your finger or stylus pen.</div>

                <div class="signature-pad--actions">

                </div>
            </div>
        </div>
    </div>

</div>

<div class="bottom-navigation-bar col-md-4 offset-md-4" style="margin: 0 auto;padding-top: 10px; padding-bottom: 10px;">
    <div class="tf-container">
        <div class="group-btn-change-name">

            <a href="javascript: void();" class="tf-btn light large" onclick="javascript: clear_signature();" style="background-color: #b70e0e; color: #FFFFFF">Clear</a>
            <a href="javascript: void(0);" onclick="javascript: save_signature();" class="tf-btn accent large save">Submit</a>
        </div>
    </div>
</div>


<?php $this->load->view('includes/tfpay_footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var changeColorButton = wrapper.querySelector("[data-action=change-color]");
    var undoButton = wrapper.querySelector("[data-action=undo]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
    var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
    var canvas = wrapper.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas, {
        // It's Necessary to use an opaque color when saving image as JPEG;
        // this option can be omitted if only saving as PNG or SVG
        backgroundColor: 'rgb(255, 255, 255)'
    });

    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);

        // This part causes the canvas to be cleared
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        // This library does not listen for canvas changes, so after the canvas is automatically
        // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
        // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
        // that the state of this library is consistent with visual state of the canvas, you
        // have to clear it manually.
        signaturePad.clear();
    }

    // On mobile devices it might make more sense to listen to orientation change,
    // rather than window resize events.
    window.onresize = resizeCanvas;
    resizeCanvas();

    function download(dataURL, filename) {
        var blob = dataURLToBlob(dataURL);
        var url = window.URL.createObjectURL(blob);

        var a = document.createElement("a");
        a.style = "display: none";
        a.href = url;
        a.download = filename;

        document.body.appendChild(a);
        a.click();

        window.URL.revokeObjectURL(url);
    }

    // One could simply use Canvas#toBlob method instead, but it's just to show
    // that it can be done using result of SignaturePad#toDataURL.
    function dataURLToBlob(dataURL) {
        // Code taken from https://github.com/ebidel/filer.js
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], { type: contentType });
    }
    function clear_signature(){
        signaturePad.clear();
    }
    function save_signature(){
        if (signaturePad.isEmpty()) {
            alert("Please provide a signature first.");
        } else {
            var dataURL = signaturePad.toDataURL();



            Swal.fire({
                imageUrl: dataURL,
                input: 'checkbox',
                inputValue: 0,
                inputPlaceholder: 'I agree with the terms and conditions',
                inputValidator: (result) => {
                    return !result && 'You need to agree with T&C'
                },
                text: "By clicking agree button below, you are agreed with out terms & conditions",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Agree',
                willOpen: () => {
                    $("#swal2-checkbox").addClass("form-check-input")
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    blockUI();
                    var blob = dataURLToBlob(dataURL);
                    var formData = new FormData();
                    formData.append('upload[signature]', blob);
                    formData.append('postdata[uacc_id]', '<?php echo $logged_in["uacc_id"] ?>');

                    $.ajax({
                        url: "<?php echo base_url(); ?>profile/user_upload_signature",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data){
                            //unblockUI();
                            data = $.parseJSON(data);
                            if(data.status == 'success'){
                                swalTimer('success','Success', 'Thanks for signing consent letter.', 3000).then(
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
            });
        }
    }

</script>


