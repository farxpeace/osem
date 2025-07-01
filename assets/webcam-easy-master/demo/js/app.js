const webcamElement = document.getElementById('webcam');

const canvasElement = document.getElementById('canvas');

const snapSoundElement = document.getElementById('snapSound');

const webcam = new Webcam(webcamElement, 'environment', canvasElement, snapSoundElement);

let hideElement = true;






$("#take-photo").click(function () {
    beforeTakePhoto();
    let picture = webcam.snap();
    document.querySelector('#download-photo').href = picture;

    var front_or_back = $("#mykad_front_back").val();
    if(front_or_back == 'front'){
        $("#camera_front_result_base64").val(picture);
    }else if(front_or_back == 'back'){
        $("#camera_back_result_base64").val(picture);
    }
    afterTakePhoto();
});

$("#resume-camera").click(function () {
    webcam.stream()
        .then(facingMode =>{
            removeCapture();
        });
});

$("#exit-app").click(function () {
    close_camera_mykad()
    $("#webcam-switch").prop("checked", false).change();
});

function displayError(err = ''){
    if(err!=''){
        $("#errorMsg").html(err);
    }
    $("#errorMsg").removeClass("d-none");
}

function cameraStarted(){
    $("#errorMsg").addClass("d-none");
    $('.flash').hide();
    $("#webcam-control").removeClass("webcam-off");
    $("#webcam-control").addClass("webcam-on");
    $(".webcam-container").removeClass("d-none");
    if(hideElement){
        $("#wpfront-scroll-top-container").addClass("d-none");
        $(".sd-sharing-enabled").addClass("d-none d-lg-block");
        $(".floatingchat-container-wrap-mobi").addClass("d-none");
    }
    window.scrollTo(0, 0); 
    $('body').css('overflow-y','hidden');
}

function cameraStopped(doScroll = false, appName = "webcam-app"){
    $("#errorMsg").addClass("d-none");
    $("#webcam-control").removeClass("webcam-on");
    $("#webcam-control").addClass("webcam-off");
    $(".webcam-container").addClass("d-none");
    $('.md-modal').removeClass('md-show');
    if(hideElement){
        $("#wpfront-scroll-top-container").removeClass("d-none");
        $(".sd-sharing-enabled").removeClass("d-none d-lg-block");
        $(".floatingchat-container-wrap-mobi").removeClass("d-none");
    }
    if(doScroll){
        $('body').css('overflow-y','scroll');
        $([document.documentElement, document.body]).animate({
            scrollTop: ($("#"+appName).offset().top - 80)
    }, 1000);    }
}


function beforeTakePhoto(){
    $('.flash')
        .show() 
        .animate({opacity: 0.3}, 500) 
        .fadeOut(500)
        .css({'opacity': 0.7});
    window.scrollTo(0, 0); 
    $('#webcam-control').addClass('d-none');
    $('#cameraControls').addClass('d-none');
}

function afterTakePhoto(){
    webcam.stop();
    $('#canvas').removeClass('d-none');
    $('#take-photo').addClass('d-none');
    $('#exit-app').removeClass('d-none');
    $('#download-photo').removeClass('d-none');
    $('#resume-camera').removeClass('d-none');
    $('#cameraControls').removeClass('d-none');

    $("#camera_button_mykad").removeClass('d-none');
}

function removeCapture(){
    $('#canvas').addClass('d-none');
    $('#webcam-control').removeClass('d-none');
    $('#cameraControls').removeClass('d-none');
    $('#take-photo').removeClass('d-none');
    $('#exit-app').addClass('d-none');
    $('#download-photo').addClass('d-none');
    $('#resume-camera').addClass('d-none');
}