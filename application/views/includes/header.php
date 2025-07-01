<?php
$user_profile = $this->far_users->get_profile('uacc_id', $logged_in['uacc_id']);
?>
<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.9.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo $this->far_meta->get_value('title'); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- Primary Meta Tags -->
<title>MYLOAN</title>
<meta name="title" content="MYLOAN">
<meta name="description" content="MYLOAN">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo base_url(); ?>">
<meta property="og:title" content="MYLOAN">
<meta property="og:description" content="MYLOAN">
<meta property="og:image" content="<?php echo base_url(); ?>assets/global/img/logo-main.png?asd=aa">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo base_url(); ?>">
<meta property="twitter:title" content="MYLOAN">
<meta property="twitter:description" content="MYLOAN">
<meta property="twitter:image" content="<?php echo base_url(); ?>assets/global/img/logo-main.png?asd=aa">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<!-- <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> -->
<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/sweetalert/sweetalert.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/css/plugins-md.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="<?php echo base_url(); ?>assets/admin/layout/css/themes/light.css?testtime=<?php echo time(); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<style>
/* Spinner */
        .spinner {
          width: 50px;
          height: 50px;
          display: inline-block;
          padding: 0px;
          border-radius: 100% !important;
          border: 6px solid;
          border-top-color: #005a9c;
          border-bottom-color: #005a9c;
          border-left-color: rgba(0, 90, 156, 0.15);
          border-right-color: rgba(0, 90, 156, 0.15);
          -webkit-animation: spinner 0.8s ease-in-out infinite alternate;
          animation: spinner 0.8s ease-in-out infinite alternate;
        }
        @keyframes spinner {
          from {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
          }
          to {
            -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
          }
        }
        @-webkit-keyframes spinner {
          from {
            -webkit-transform: rotate(0deg);
          }
          to {
            -webkit-transform: rotate(360deg);
          }
        }

.sweet-alert div {
    border-radius: 50% !important;
}
.sweet-alert {
    border-radius: 5px !important;
}
.sweet-alert button {
    border-radius: 5px !important;
}
.page-header.navbar .page-logo {
    padding-left: 0px !important;
}
.page-header.navbar .page-logo .logo-default {
    margin: 0px 0px 0px 0px !important;
}

/*  Left Menu   */
.page-sidebar .page-sidebar-menu > li.active > a {
    background: #008136;
}
.page-sidebar .page-sidebar-menu > li.active > a:hover {
    background: #008136;
}
.page-sidebar .page-sidebar-menu > li.active > a > .selected {
    border-left: 8px solid #008136;
}
.page-sidebar .page-sidebar-menu > li.active > a, .page-sidebar .page-sidebar-menu > li.active.open > a {
    background: #008136;
}
.page-sidebar .page-sidebar-menu > li.active > a, .page-sidebar .page-sidebar-menu > li.active.open > a:hover {
    background: #008136;
}
.page-sidebar .page-sidebar-menu > li.active.open > a > .selected, .page-sidebar .page-sidebar-menu > li.active > a > .selected {
    border-left: 8px solid #008136;
}
.sidebar-toggler {
    margin-bottom: 10px;
}
.page-header.navbar .hor-menu .navbar-nav > li > a:hover {
    background: #0c7d3c !important;
}
@media (max-width: 767px){
    .page-header.navbar {
        padding: 0 10px 0 0px;
    }
}

@media (max-width: 480px){
    .page-header.navbar .top-menu {
        display: block;
        clear: none !important;
    }
}

nav .navbar-nav {
    margin: 0px -15px !important;
}

.page-header.navbar .top-menu .navbar-nav > li.dropdown .dropdown-toggle:hover {
    background-color: #0c7d3c !important;
}
.page-header.navbar .top-menu .navbar-nav > li.dropdown-user > .dropdown-toggle > .username {
    color: #000000;
}
.page-header.navbar .top-menu .navbar-nav > li.dropdown .dropdown-toggle:hover {
    background-color: #e2e2e2 !important;
}
.page-header.navbar .top-menu .navbar-nav > li.dropdown .dropdown-toggle:hover > i {
    color: #000000;
}
</style>
<style>
.modal.modal_one_hundred_percent_width {
    width: 98% !important;
    left: 1% !important;
    margin-left: 0px !important;
}
</style>
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/global/img/favicons/apple-touch-icon.png?a=1">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/global/img/favicons/favicon-32x32.png?a=1">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/global/img/favicons/favicon-16x16.png?a=1">
<link rel="manifest" href="<?php echo base_url(); ?>assets/global/img/favicons/site.webmanifest?a=1">
<link rel="mask-icon" href="<?php echo base_url(); ?>assets/global/img/favicons/safari-pinned-tab.svg?a=1" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content page-footer-fixed">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top" style="background-color: #008136;">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo base_url(); ?>/auth_admin/dashboard">
                <img src="<?php echo base_url(); ?>assets/myloan/logo-256x256.png?asd=<?php echo time(); ?>" style="width: 46px" alt="logo" class="logo-default hidden-md hidden-sm hidden-lg"/>
                <img src="<?php echo base_url(); ?>assets/myloan/logo-235x46.png?asd=<?php echo time(); ?>" alt="logo" class="logo-default hidden-xs"/>
			</a>
			<div class="menu-toggler sidebar-toggler hide">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
        
        <div class="hor-menu hor-menu-light">
			<ul class="nav navbar-nav" style="margin-top: 0px;">
				<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the horizontal opening on mouse hover -->
				
				
				
				
			</ul>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- BEGIN INBOX DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END INBOX DROPDOWN -->
				<!-- BEGIN TODO DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END TODO DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <?php
                if(strlen($user_profile['profilepic_url']) > 4){
                    $url_of_picture = $user_profile['profilepic_url'];
                }else{
                    $url_of_picture = base_url()."assets/global/img/intelmx/male_default_user.png";
                }
                ?>
                <style>
                .page-header.navbar .top-menu .navbar-nav > li.dropdown .dropdown-toggle:hover {
                    background-color: #901827;
                }
                </style>
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    					<img alt="" class="img-circle" src="<?php echo $url_of_picture; ?>"/>
    					<span class="username username-hide-on-mobile">
    					<?php echo ucwords(strtolower($user_profile['fullname'])); ?> </span>
    					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						
      
						<li>
							<a href="<?php echo base_url(); ?>auth/logout" data-logout="yes">
							<i class="icon-key"></i> Log Keluar </a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN QUICK SIDEBAR TOGGLER -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				
				<!-- END QUICK SIDEBAR TOGGLER -->
			</ul>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
    <?php $this->load->view('includes/left_menu'); ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

            <?php $this->load->view('includes/breadcrumb4'); ?>