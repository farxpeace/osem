<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title><?php echo $this->far_meta->get_value('title') ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/dashlite.css?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/theme.css?ver=3.2.0">
    <!-- Favicon and Touch Icons  -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/tfpay-app-pwa/images/logo.png" />
    <!-- Font -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/tfpay-app-pwa/fonts/fonts.css" />
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/tfpay-app-pwa/fonts/icons-alipay.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/tfpay-app-pwa/styles/bootstrap.css?time=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/tfpay-app-pwa/styles/swiper-bundle.min.css">
    <link rel="stylesheet"type="text/css" href="<?php echo base_url(); ?>assets/tfpay-app-pwa/styles/styles.css"/>
    <link rel="manifest" href="<?php echo base_url(); ?>_manifest.json?asd=assad" data-pwa-version="set_in_manifest_and_pwa_js">

    <link rel="icon" type="image/png" href="/assets/lead/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/lead/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/assets/lead/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/lead/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MBD" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.css" integrity="sha512-Of+yU7HlIFqXQcG8Usdd67ejABz27o7CRB1tJCvzGYhTddCi4TZLVhh9tGaJCwlrBiodWCzAx+igo9oaNbUk5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-borderless/borderless.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/side-drawer-modal-bootstrap/bootstrap-side-modals.css" />
    <style>
        .preload-container {
            background: #012169 !important;
        }
        .preload-logo {
            background-image: url(/assets/lead/logo/logo-transparent-96x96-spinner.png?asd=asd);
            background-color: transparent !important;
        }
        .tf-btn.accent {
            background-color: #ffce00;
            border: 1px solid #ffce00;
            color: #313131;
        }
        .tf-btn.accent:hover {
            color: #FFFFFF;
            border-color: #af8c00;
            background-color: #af8c00;
        }
        .tf-statusbar {
            background: #181b21;
        }
        .tf-statusbar .back-btn {
            color: #FFFFFF;
        }
        .tf-statusbar h3 {
            color: #FFFFFF;
        }
        .panel-box {
            margin: 0 auto !important;
        }
        .clear-panel i, .action-right i {
            color: #FFFFFF !important;
        }
        .tf-navigation-bar li.active a i {
            color: #012169;
        }
        @media (min-width: 768px){
            .col-md-4 {
                flex: 0 0 auto;
                width: 33.33333333% !important;
            }
        }
        .app-header {
            background: #012169 !important;
        }
    </style>
    <style>

        .toast {
            z-index: 999999999 !important;
            opacity: 1 !important;
        }
    </style>
    <style>
        .modal_fara.modal-content {
            max-width: 273px;
        }
        .modal_fara.modal-content .heading {
            border-bottom: 1px solid #dddddd;
            padding: 16px;
        }
        .modal_fara.modal-content .heading h4 {
            padding: 0px 30px;
        }
        .modal_fara.modal-content .bottom {
            padding: 10px 15px;
        }
        .modal_fara.modal-content .bottom a {
            padding: 11px 16px;
            font-size: 16px;
            line-height: 24px;
            text-align: center;
        }
        .modal-dialog {
            min-height: auto;
        }
        @media (min-width: 576px){
            .modal-dialog {
                min-height: auto !important;
            }
        }
    </style>
    <style>
        .preloader_secondary {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /*change these sizes to fit into your project*/
            width: 100px;
            height: 100px;
        }
        .preloader_secondary hr {
            border: 0;
            margin: 0;
            width: 40%;
            height: 40%;
            position: absolute;
            border-radius: 50%;
            animation: spin 2s ease infinite;
            opacity: 0.9;
        }
        .preloader_secondary :first-child {
            background: #19a68c;
            animation-delay: -1.5s;
        }
        .preloader_secondary :nth-child(2) {
            background: #f63d3a;
            animation-delay: -1s;
        }
        .preloader_secondary :nth-child(3) {
            background: #fda543;
            animation-delay: -0.5s;
        }
        .preloader_secondary :last-child {
            background: #193b48;
        }
        .preloader_secondary #preloader_text {
            color: #000000;
            background-color: transparent;
            position: absolute;
            top: calc(50% + 60px);
        }
        .preloader_secondary #preloader_progressbar {
            color: #000000;
            background-color: transparent;
            position: absolute;
            top: calc(50% + 90px);
        }
        @keyframes spin {
            0%,
            100% {
                transform: translate(0);
            }
            25% {
                transform: translate(160%);
            }
            50% {
                transform: translate(160%, 160%);
            }
            75% {
                transform: translate(0, 160%);
            }
        }
    </style>
    <style>
        .ni {
            font-family: "Nioicon" !important;
        }
        .error_message {
            display: none;
            color: #df3d5a;
            font-size: 12px;
            padding-left: 1px;
        }
        .has-error .form-label {
            color: #d33f3f;
        }
        .help-block {
            display: block;
        }
        h6.title {
            font-size: 1.1rem !important;
        }
    </style>
    <style>
        .card-button {
            background-color: #eb3904;
        }
        .card-button .lead-text, .card-button .sub-text {
            color: #FFFFFF !important;
        }
        .card-button .icon {
            color: #FFFFFF;
        }

        .card-button-green {
            background-color: #00991a;
        }
        .card-button-green .lead-text, .card-button-green .sub-text {
            color: #FFFFFF !important;
        }
        .card-button-green .icon {
            color: #FFFFFF;
        }
    </style>
    <style>
        .form-text-hint {
            position: absolute;
            right: 2px;
            top: 2px;
            height: calc(2.125rem + 9px);
            display: flex
        ;
            align-items: center;
            color: #2263b3;
            padding-left: 1rem;
            padding-right: 0.75rem;
            background: #fff;
            border-radius: 4px;
        }
        .overline-title {
            font-size: 14px;
            line-height: 1.2;
            letter-spacing: 0.2em;
            color: #8094ae;
            text-transform: uppercase;
            font-weight: 700;
            font-family: Roboto, sans-serif;
        }
    </style>
    <style>
        .project-title {
            align-items: normal !important;
        }
    </style>
</head>
<body class="col-md-4 offset-md-4">
<!-- preloade -->
<div class="preload preload-container">
    <div class="preload-logo">
        <div class="spinner"></div>
    </div>
</div>
<!-- /preload -->

<!-- Install PWA -->
<style>
    #install {

    }
</style>
<?php if(!is_localhost()){ ?>


<button id="install" class="btn btn-danger btn-lg" style="border-radius: 0; text-transform: none;" hidden>Click to install Osem</button>
<script>
    let installPrompt = null;
    const installButton = document.querySelector("#install");

    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        installPrompt = event;
        installButton.removeAttribute("hidden");
    });

    //Trigger install prompt
    installButton.addEventListener("click", async () => {
        if (!installPrompt) {
            return;
        }
        const result = await installPrompt.prompt();
        console.log(`Install prompt was: ${result.outcome}`);
        disableInAppInstallPrompt();
    });

    function disableInAppInstallPrompt() {
        installPrompt = null;
        installButton.setAttribute("hidden", "");
    }

    //Responding to app install
    window.addEventListener("appinstalled", () => {
        disableInAppInstallPrompt();
    });

    function disableInAppInstallPrompt() {
        installPrompt = null;
        installButton.setAttribute("hidden", "");
    }
</script>
<?php } ?>

