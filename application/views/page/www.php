<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image:width" content="279">
    <meta property="og:image:height" content="279">
    <meta property="og:title" content="<?php echo base_url(); ?>">
    <meta property="og:description" content="<?php echo $this->far_meta->get_value('title') ?>">
    <meta property="og:image" content="https://i.imgur.com/UuAtAbQ.png">
    <meta property="og:url" content="<?php echo base_url(); ?>">
    <title><?php echo $this->far_meta->get_value('title') ?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:600|Source+Sans+Pro:600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/www/css/applify.css?version=<?php echo time(); ?>"/>


    <link href="<?php echo base_url(); ?>assets/bootstrap-wizard/assets/css/gsdk-bootstrap-wizard.css?time=<?php echo time(); ?>" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>assets/global/plugins/nouislider/jquery.nouislider.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url(); ?>assets/global/plugins/nouislider/jquery.nouislider.pips.min.css" rel="stylesheet" type="text/css"/>




    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/global/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/global/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/global/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url(); ?>assets/global/img/favicons/site.webmanifest">
    <link rel="mask-icon" href="<?php echo base_url(); ?>assets/global/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <script src="https://cdn.firebase.com/libs/firebaseui/3.4.1/firebaseui.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.4.1/firebaseui.css" />
    <script src="https://www.gstatic.com/firebasejs/5.5.7/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyBEqwNiIpRGr2_mrLsl6cqgOAtOIhb5dKY",
            authDomain: "ejariah-2feb9.firebaseapp.com",
            databaseURL: "https://ejariah-2feb9.firebaseio.com",
            projectId: "ejariah-2feb9",
            storageBucket: "ejariah-2feb9.appspot.com",
            messagingSenderId: "97891524070"
        };
        firebase.initializeApp(config);
    </script>
    <script type="text/javascript">
        // FirebaseUI config.
        var uiConfig = {
            signInSuccessUrl: '<?php echo base_url(); ?>auth_admin/dashboard/',
            signInFlow: "popup",
            signInOptions: [
                // Leave the lines as is for the providers you want to offer your users.
                firebase.auth.GoogleAuthProvider.PROVIDER_ID
            ],
            // tosUrl and privacyPolicyUrl accept either url string or a callback
            // function.
            // Terms of service url/callback.
            tosUrl: '<your-tos-url>',
            // Privacy policy url/callback.
            privacyPolicyUrl: function() {
                window.location.assign('<your-privacy-policy-url>');
            },
            callbacks: {
                signInSuccessWithAuthResult: function(authResult, redirectUrl){

                    login_via_firebase_google(authResult);

                    console.log(authResult);
                    return false;
                }
            }
        };

        // Initialize the FirebaseUI Widget using Firebase.

        var ui = new firebaseui.auth.AuthUI(firebase.auth());
        ui.start('#firebaseui-auth-container', uiConfig);

    </script>
</head>
<style>
    .ui-gradient-purple {
        background: linear-gradient(45deg, #536d5e 0%, #1ec665 50%, #027934 100%);
    }

    .firebaseui-card-footer.firebaseui-provider-sign-in-footer {
        display: none;
    }
    .firebaseui-idp-button {
        max-width: 240px !important;
    }

    @media (max-width:768px){
        .main .wizard_container{
            margin-bottom: 50px;
        }
    }

    @media (min-width: 768px){
        .navbar-form {
            margin-top: 21px;
            margin-bottom: 21px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .btn-wd {
            min-width: 140px;
        }
    }
</style>

<style>
    .input-inline {
        display: inline-block !important;
        width: auto !important;
        vertical-align: middle !important;
    }

    .calculator_frame {
        text-align: left;
    }
    .calculator_description {
        margin-bottom: 10px;
    }
    .calculator_description_final {
        text-align: center;
    }
    .text_calculator_final_amount {
        font-style: italic;
        font-size: x-large;
    }
    /* Button */
    .red.btn {
        color: #FFFFFF;
        background-color: #cb5a5e;
    }
    .red.btn:hover, .red.btn:focus, .red.btn:active, .red.btn.active {
        color: #FFFFFF;
        background-color: #c23f44;
    }
    /* Button */
    .blue.btn {
        color: #FFFFFF;
        background-color: #3598dc;
    }
    .blue.btn:hover, .blue.btn:focus, .blue.btn:active, .blue.btn.active {
        color: #FFFFFF;
        background-color: #2386ca;
    }
</style>

<style>
    .nav-tabs {
        border-bottom: 1px solid #ddd;
    }
    .nav-tabs > li {
        float: left;
        margin-bottom: -1px;
    }
    .nav-tabs > li > a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
    }
    .nav-tabs > li > a:hover {
        border-color: #eee #eee #ddd;
    }
    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:hover,
    .nav-tabs > li.active > a:focus {
        color: #555;
        cursor: default;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
    .nav-tabs.nav-justified {
        width: 100%;
        border-bottom: 0;
    }
    .nav-tabs.nav-justified > li {
        float: none;
    }
    .nav-tabs.nav-justified > li > a {
        margin-bottom: 5px;
        text-align: center;
    }
    .nav-tabs.nav-justified > .dropdown .dropdown-menu {
        top: auto;
        left: auto;
    }
    @media (min-width: 768px) {
        .nav-tabs.nav-justified > li {
            display: table-cell;
            width: 1%;
        }
        .nav-tabs.nav-justified > li > a {
            margin-bottom: 0;
        }
    }
    .nav-tabs.nav-justified > li > a {
        margin-right: 0;
        border-radius: 4px;
    }
    .nav-tabs.nav-justified > .active > a,
    .nav-tabs.nav-justified > .active > a:hover,
    .nav-tabs.nav-justified > .active > a:focus {
        border: 1px solid #ddd;
    }
    @media (min-width: 768px) {
        .nav-tabs.nav-justified > li > a {
            border-bottom: 1px solid #ddd;
            border-radius: 4px 4px 0 0;
        }
        .nav-tabs.nav-justified > .active > a,
        .nav-tabs.nav-justified > .active > a:hover,
        .nav-tabs.nav-justified > .active > a:focus {
            border-bottom-color: #fff;
        }
    }
    .nav-stacked > li {
        float: none;
    }
    .nav-stacked > li + li {
        margin-top: 2px;
        margin-left: 0;
    }
    .nav-justified {
        width: 100%;
    }
    .nav-justified > li {
        float: none;
    }
    .nav-justified > li > a {
        margin-bottom: 5px;
        text-align: center;
    }
    .nav-justified > .dropdown .dropdown-menu {
        top: auto;
        left: auto;
    }
    @media (min-width: 768px) {
        .nav-justified > li {
            display: table-cell;
            width: 1%;
        }
        .nav-justified > li > a {
            margin-bottom: 0;
        }
    }
    .nav-tabs-justified {
        border-bottom: 0;
    }
    .nav-tabs-justified > li > a {
        margin-right: 0;
        border-radius: 4px;
    }
    .nav-tabs-justified > .active > a,
    .nav-tabs-justified > .active > a:hover,
    .nav-tabs-justified > .active > a:focus {
        border: 1px solid #ddd;
    }
    @media (min-width: 768px) {
        .nav-tabs-justified > li > a {
            border-bottom: 1px solid #ddd;
            border-radius: 4px 4px 0 0;
        }
        .nav-tabs-justified > .active > a,
        .nav-tabs-justified > .active > a:hover,
        .nav-tabs-justified > .active > a:focus {
            border-bottom-color: #fff;
        }
    }
    .tab-content > .tab-pane {
        display: none;
    }
    .tab-content > .active {
        display: block;
    }
    .nav-tabs .dropdown-menu {
        margin-top: -1px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    li.pakej-tab-li.active a {
        color: #000000;
    }

    li.pakej-tab-li a {
        color: #000000;
    }
    @media (max-width: 768px) {
        .nav-justified > li {
            display: table-cell;
            width: 1%;
        }
        .nav-justified > li > a  {
            border-bottom: 1px solid #ddd !important;
            border-radius: 4px 4px 0 0 !important;
            margin-bottom: 0 !important;
        }

        .spinner-input {
            height: 32px;
        }

        li.pakej-tab-li.active a {
            border-bottom: 0 !important;
        }
    }
</style>

<style>
    .noUi-handle {
        touch-action: none;
    }

    .wizard-card .tab-content {
        min-height: auto !important;
    }
</style>
<!-- <body class="ui-transparent-nav" data-fade_in="on-load"> -->
<body class="ui-transparent-nav">

<!-- Navbar Fixed + Default -->
<nav class="navbar navbar-fixed-top transparent navbar-default">
    <div class="container">

        <!-- Navbar Logo -->
        <a class="ui-variable-logo navbar-brand" href="<?php echo base_url(); ?>" title="Applify - App Landing HTML Template">
            <!-- Default Logo -->
            <img class="logo-default" src="<?php echo base_url(); ?>assets/global/img/tnb/logo-172x40-white_bg.png?a=<?php echo time(); ?>" alt="Applify - App Landing HTML Template" data-uhd>
            <!-- Transparent Logo -->
            <img class="logo-transparent" src="<?php echo base_url(); ?>assets/global/img/tnb/logo-172x40.png?a=<?php echo time(); ?>" alt="Applify - App Landing HTML Template" data-uhd>
        </a><!-- .navbar-brand -->

        <!-- Navbar Toggle -->
        <a href="demo-waves.html#" class="ui-mobile-nav-toggle pull-right"></a>

        <!-- Navbar Button -->
        <?php if($this->flexi_auth->is_logged_in()){ ?>
            <a href="<?php echo base_url(); ?>auth_admin/dashboard" class="btn btn-sm ui-gradient-peach pull-right">Go to Dashboard</a>
        <?php }else{ ?>
            <a href="javascript: void(0);" class="btn btn-sm ui-gradient-peach pull-right" onclick="javascript: EJ.open_login_popup();">Login</a>
        <?php } ?>


        <!-- Navbar Navigation -->
        <div class="ui-navigation navbar-right">
            <ul class="nav navbar-nav">
                <!-- Nav Item -->
                <li class="dropdown active">
                    <a href="javascript: void(0);" onclick="javascript: BtnScrollToTop();">
                        Utama
                    </a>
                </li>
                <li class="">
                    <a href="javascript: void(0);" data-scrollto="wizard_section">
                        Daftar
                    </a>
                </li>
                <!-- Nav Item -->

                <!-- Nav Item -->

                <!-- Nav Item -->

                <!-- Nav Item -->

            </ul><!--.navbar-nav -->
        </div><!--.ui-navigation -->
    </div><!-- .container -->
</nav> <!-- nav -->

<!-- Main Wrapper -->
<div class="main" role="main">

    <!-- Waves Hero -->
    <div class="ui-hero hero-lg ui-waves ui-gradient-purple" >
        <div class="container">
            <div class="row">

                <div class="col-sm-12 animate" data-show="fade-in-left" data-delay="400">
                    <div id="wizard_section" class="section" style="padding-top: 0px;">
                        <div class="wizard_container">

                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <!--      Wizard container        -->

                                    <!-- wizard container -->
                                </div>
                            </div>


                        </div><!-- .container -->
                    </div>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .ui-hero .slider-pro -->

    <!-- App Features Section -->
    <!-- .section -->

    <!-- Tabbed Showcase Section -->
    <!-- .section -->

    <!-- Call To Action Section -->
    <!-- .section -->

    <!-- App Screens Section -->
    <!-- .section -->

    <!-- Video Section -->
    <!-- .section -->

    <!-- Pricing Cards Section -->
    <?php if(!$this->flexi_auth->is_logged_in()){ ?>
        <div id="login_area" class="section">
            <div class="container ">
                <!-- Section Heading -->
                <div class="section-heading center">
                    <h2 class="heading text-indigo">
                        Log Masuk ke sistem
                    </h2>

                </div><!-- .section-heading -->


                <div id="firebaseui-auth-container"></div>



                <!-- UI Pricing Cards / Owl Carousel On Mobile -->
                <!-- .ui-pricing-cards -->

                <!-- Pricing Footer -->
                <!-- .ui-pricing-footer -->

            </div><!-- .container -->
        </div><!-- .section -->
    <?php } ?>
    <!-- Client Logos Section  -->
    <!-- .ui-clients-logos  -->

    <!-- App Stats Section -->
    <!-- .section -->

    <!--  Blog Posts Section -->
    <!-- .section -->

    <!--  Testimonial Section -->
    <!-- .section -->

    <!-- Subscribe Footer -->
    <footer class="ui-footer subscribe-footer ui-waves">
        <div class="ui-gradient-purple footer-bg">
            <div class="container">
                <!-- Form Card -->

                <!--  Download Section -->
                <div class="text-center download-section">
                    <h2 class="heading">Register with HEIS Now</h2>
                    <p class="paragraph">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </p>
                    <div class="actions">
                        <a class="btn ui-gradient-green btn-app-store btn-download shadow-lg"><span>Available on the</span> <span>App Store</span></a>
                        <a class="btn ui-gradient-blue btn-google-play btn-download shadow-lg"><span>Available on </span> <span>Google Play</span></a>
                    </div>
                </div>
            </div><!-- .container -->
        </div><!-- .footer-bg -->

        <!-- Footer Copyright -->
        <div class="footer-copyright bg-dark-gray">
            <div class="container">
                <div class="row">
                    <!-- Copyright -->
                    <div class="col-xs-6">
                        <p>
                            &copy; 2018 <a href="https://www.facebook.com/farxpeace" target="_blank" title="Apps">Ijul Farizul</a> All Rights Reserved
                        </p>
                    </div>
                    <!-- Social Icons -->
                    <div class="col-xs-6 text-right">
                        <a class="btn ui-gradient-blue btn-circle shadow-md">
                            <span class="fa fa-facebook"></span>
                        </a>
                        <a class="btn ui-gradient-peach btn-circle shadow-md">
                            <span class="fa fa-instagram"></span>
                        </a>
                        <a class="btn ui-gradient-green btn-circle shadow-md">
                            <span class="fa fa-twitter"></span>
                        </a>
                        <a class="btn ui-gradient-purple btn-circle shadow-md">
                            <span class="fa fa-pinterest"></span>
                        </a>
                    </div>
                </div>
            </div><!-- .container -->
        </div><!-- .footer-copyright -->
    </footer><!-- .ui-footer -->
</div><!-- .main -->

<!-- Scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/www/js/libs/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/www/js/libs/slider-pro/jquery.sliderPro.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/www/js/libs/owl.carousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/www/js/libs/form-validator/form-validator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/www/js/libs/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/www/js/applify/applify.js"></script>

<script src="<?php echo base_url(); ?>assets/bootstrap-wizard/assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>



<script type="text/javascript">
    $(function(){
        $(".firebaseui-idp-google .firebaseui-idp-text-long").text("Log masuk dengan Google")
    })
</script>

<script type="text/javascript">
    function BtnScrollToTop(){
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
</script>

<script type="text/javascript">
    function login_via_firebase_google(authResult){
        var user = authResult.user;

        var token = authResult.credential['idToken'];
        var email_address = authResult.user['email'];

        var displayName = user.displayName;
        var email = user.email;
        var emailVerified = user.emailVerified;
        var photoURL = user.photoURL;
        var uid = user.uid;
        var phoneNumber = user.phoneNumber;
        var providerData = user.providerData;

        $.ajax({
            url: "<?php echo base_url(); ?>auth/login_via_firebase_google",
            type: "POST",
            dataType: "json",
            data: {
                token: token,
                email_address: email_address,
                postdata: {
                    displayName: displayName,
                    emailVerified: emailVerified,
                    photoURL: photoURL,
                    uid: uid,
                    phoneNumber: phoneNumber,
                    providerData: providerData
                }

            },
            success: function(data){
                if(data.status == 'success'){
                    if(data.redirect){
                        window.location.href = data.redirect;
                    }
                }
            }
        })
    }
</script>







<script type="text/javascript" src="<?php echo base_url(); ?>assets/ejauth.js?time=<?php echo time(); ?>"></script>

</body>
</html>
