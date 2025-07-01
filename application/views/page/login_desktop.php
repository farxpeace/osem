<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>MyLoan Web</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/dashlite.css?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/theme.css?ver=3.2.0">
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.5.0/firebase-storage.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyBdvFGKCg-XYU4FUdKEK2wSkYKDKRZJ0P4",
            authDomain: "myloan-cb4cd.firebaseapp.com",
            databaseURL: "https://myloan-cb4cd-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "myloan-cb4cd",
            storageBucket: "myloan-cb4cd.appspot.com",
            messagingSenderId: "680417801118",
            appId: "1:680417801118:web:c33ebce22a23eb3f3f5c8f",
            measurementId: "G-VX69Q66GTQ"
        };
        firebase.initializeApp(config);
    </script>
</head>
<body class="nk-body bg-white npc-general pg-auth">
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                <div class="nk-split nk-split-page nk-split-lg">
                    <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                        <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                            <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                        </div>
                        <div class="nk-block nk-block-middle nk-auth-body">
                            <div class="brand-logo pb-5">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img logo-img-lg" src="<?php echo base_url(); ?>assets/dashlite/images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img logo-img-lg" src="<?php echo base_url(); ?>assets/dashlite/images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title">Sign-In</h5>
                                    <div class="nk-block-des">
                                        <p>Use MyLoan App scanner to scan this QR Code.</p>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div id="qrcode"></div>
                        </div><!-- .nk-block -->
                        <div class="nk-block nk-auth-footer">
                            <div class="nk-block-between">
                                <ul class="nav nav-sm">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Terms & Condition</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Privacy Policy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Help</a>
                                    </li>
                                </ul><!-- .nav -->
                            </div>
                            <div class="mt-3">
                                <p>&copy; 2023 MyLoan.</p>
                            </div>
                        </div><!-- .nk-block -->
                    </div><!-- .nk-split-content -->
                    <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true" style="background-color: #064936 !important">
                        <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                            <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                                <div class="slider-item">
                                    <div class="nk-feature nk-feature-center">
                                        <div class="nk-feature-img">
                                            <img class="round" src="<?php echo base_url(); ?>assets/myloan/login_banner_1.png" alt="">
                                        </div>
                                        <div class="nk-feature-content py-4 p-sm-5 text-white">
                                            <h4>MYLOAN</h4>
                                            <p>Financial Assistance That Gives You Possibilities</p>
                                        </div>
                                    </div>
                                </div><!-- .slider-item -->
                                <div class="slider-item">
                                    <div class="nk-feature nk-feature-center">
                                        <div class="nk-feature-img">
                                            <img class="round" src="<?php echo base_url(); ?>assets/myloan/login_banner_2.png" alt="">
                                        </div>
                                        <div class="nk-feature-content py-4 p-sm-5 text-white">
                                            <h4>MYLOAN</h4>
                                            <p>Build A Brighter Financial Future With A Good Score</p>
                                        </div>
                                    </div>
                                </div><!-- .slider-item -->
                            </div><!-- .slider-init -->
                            <div class="slider-dots"></div>
                            <div class="slider-arrows"></div>
                        </div><!-- .slider-wrap -->
                    </div><!-- .nk-split-content -->
                </div><!-- .nk-split -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    </div>
    <!-- main @e -->
</div>
<!-- app-root @e -->
<!-- JavaScript -->
<script src="<?php echo base_url(); ?>assets/dashlite/js/bundle.js?ver=3.2.0"></script>
<script src="<?php echo base_url(); ?>assets/dashlite/js/scripts.js?ver=3.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.qrcode@1.0.3/jquery.qrcode.min.js"></script>
<script src="https://openfpcdn.io/fingerprintjs/v4/iife.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/firebase_desktop_login_gatherings.js?asd=<?php echo time(); ?>"></script>
<script>
    var UniqueId;
    // Initialize the agent at application startup.
    var fpPromise = FingerprintJS.load()
    // Analyze the visitor when necessary.
    fpPromise
        .then(fp => fp.get())
        .then(result => {
            UniqueId = result.visitorId;
            generate_qrcode();
            join_firebase_gathering(UniqueId);
        });
</script>
<script>
    function join_firebase_gathering(UniqueId){

        var FireDesktopLoginGathering = new DesktopLoginGathering(firebase.database(), 'opening');
        var browserData = {};
        browserData.status = "opening";
        FireDesktopLoginGathering.join(UniqueId, browserData);
        var myUserId = UniqueId;

        FireDesktopLoginGathering.onUpdated(function(count, users) {
            console.log('asdasdasd');
            console.log('on update');
            console.log(users)
            var total_browser=0, total_webview=0;

            for(var i in users) {
                if(i == myUserId){
                    var FireBrowserData = users[i];
                    if(FireBrowserData.status == 'scanned'){
                        process_desktop_login(FireBrowserData.uacc_id, FireDesktopLoginGathering);
                        console.log(FireBrowserData);
                        console.log('scanned')
                    }
                }
            }
        });
    }
    function process_desktop_login(uacc_id, FireDesktopLoginGathering){
        $.ajax({
            url: "<?php echo base_url(); ?>page/process_desktop_login",
            type: "POST",
            dataType: "JSON",
            data: {
                postdata: {
                    uacc_id: uacc_id
                }
            },
            success: function (data){
                if(data.status == 'success'){
                    FireDesktopLoginGathering.leave();
                    swalTimer('success','Success', 'Login success.', 1000).then(
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
</script>
<script>
    $(function(){
        setInterval(function(){
            generate_qrcode();
        }, 10000)
    });
    function generate_qrcode(){
        if(UniqueId){
            var qrcode_content = "weblogin_"+UniqueId+"_"+Date.now();
            $('#qrcode').empty().qrcode(qrcode_content);
        }
    }
    function swalTimer(icon,title, html, timer){
        let myPromise = new Promise(function(myResolve) {
            // "Producing Code" (May take some time)
            let timerInterval
            Swal.fire({
                icon: icon,
                title: title,
                html: html,
                timer: timer,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                myResolve();
            })
        });
        return myPromise;
    }
</script>
</html>
