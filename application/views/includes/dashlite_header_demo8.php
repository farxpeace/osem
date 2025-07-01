<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/dashlite/images/favicon.png">
    <!-- Page Title  -->
    <title>MyLoan</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/dashlite.css?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/theme.css?ver=3.2.0">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url(); ?>assets/dashlite/css/skins/theme-green.css?ver=3.2.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        i.fa-regular, i.fa-solid {
            margin-right: 6px;
            margin-left: 6px;
        }
        /* Spinner */
        .spinner2 {
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
        </style>

</head>

<body class="nk-body bg-lighter ">
<div class="nk-app-root">
    <!-- wrap @s -->
    <div class="nk-wrap ">
        <!-- main header @s -->
        <div class="nk-header is-theme">
            <div class="container-fluid">
                <div class="nk-header-wrap">
                    <div class="nk-menu-trigger me-sm-2 d-lg-none">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-header-brand">
                        <a href="html/index.html" class="logo-link">
                            <img class="logo-light logo-img" src="<?php echo base_url(); ?>assets/dashlite/images/logo.png" srcset="<?php echo base_url(); ?>assets/dashlite/images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="<?php echo base_url(); ?>assets/dashlite/images/logo-dark.png" srcset="<?php echo base_url(); ?>assets/dashlite/images/logo-dark2x.png 2x" alt="logo-dark">
                        </a>
                    </div><!-- .nk-header-brand -->
                    <div class="nk-header-menu ms-auto" data-content="headerNav">
                        <div class="nk-header-mobile">
                            <div class="nk-header-brand">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="<?php echo base_url(); ?>assets/dashlite/images/logo.png" srcset="<?php echo base_url(); ?>assets/dashlite/images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="<?php echo base_url(); ?>assets/dashlite/images/logo-dark.png" srcset="<?php echo base_url(); ?>assets/dashlite/images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-menu-trigger me-n2">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                            </div>
                        </div>
                        <?php
                        $url_class = $this->router->fetch_class();
                        $url_method = $this->router->fetch_method();
                        $segs = $this->uri->segment_array();
                        $url_method_arr = array(
                            $url_method,
                            $url_method."/".end($segs)
                        );
                        $list_menu = $this->far_menu->list_menu_by_group($this->flexi_auth->get_user_group_id());
                        $page_title = "";
                        $page_title_small = "";
                        $breadcrumb = array();
                        ?>

                        <?php if(is_array($list_menu) && count($list_menu) > 0){ ?>
                            <ul class="nk-menu nk-menu-main ui-s2">

                                <?php foreach($list_menu as $a => $b){ ?>
                                    <?php if($b['selected_page'] == "yes"){ $page_title = $b['page_title']; $page_title_small = $b['page_title_small']; $breadcrumb[] = $b['page_title']; } ?>

                                    <li class="nk-menu-item <?php if($b['has_children'] == "yes"){ echo "has-sub"; } ?>">
                                        <a href="<?php echo $b['full_link'] ?>" class="nk-menu-link <?php if($b['has_children'] == "yes"){ echo "nk-menu-toggle"; } ?>">
                                            <span class="nk-menu-text"><i class="<?php echo $b['icon-class'] ?>"></i> <span class="menu_name"><?php echo $b['name'] ?></span></span>
                                        </a>
                                        <?php if($b['has_children'] == "yes"){ ?>
                                            <ul class="nk-menu-sub">
                                                <?php foreach($b['children'] as $c => $d){ ?>
                                                    <?php if($d['selected_page'] == "yes"){ $page_title = $d['page_title']; $page_title_small = $b['page_title_small']; $breadcrumb[] = $d['page_title']; } ?>
                                                    <li class="nk-menu-item">
                                                        <a href="<?php echo $d['full_link'] ?>" class="nk-menu-link <?php if(is_array($d['children']) && count($d['children']) > 0){ echo 'nk-menu-toggle'; } ?>">
                                                            <span class="nk-menu-text"><i class="<?php echo $d['icon-class'] ?>"></i><span class="menu_name"><?php echo $d['name'] ?></span></span>
                                                        </a>

                                                        <?php if(is_array($d['children']) && count($d['children']) > 0){ ?>
                                                            <ul class="nk-menu-sub">
                                                            <?php foreach($d['children'] as $e => $f){ ?>

                                                                <li class="nk-menu-item">
                                                                    <a href="<?php echo $f['full_link'] ?>" class="nk-menu-link">
                                                                        <span class="nk-menu-text"><i class="<?php echo $f['icon-class'] ?>"></i><span class="menu_name"><?php echo $f['name'] ?></span></span>
                                                                    </a>
                                                                </li>

                                                            <?php } ?>
                                                                </ul>
                                                        <?php } ?>






                                                    </li>
                                                <?php } ?>
                                            </ul><!-- .nk-menu-sub -->
                                        <?php } ?>
                                    </li>

                                <?php } ?>
                            </ul><!-- .nk-menu -->
                        <?php } ?>
                    </div><!-- .nk-header-menu -->
                    <div class="nk-header-tools">
                        <ul class="nk-quick-nav">


                            <li class="dropdown user-dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                    <div class="user-toggle">
                                        <div class="user-avatar sm">
                                            <em class="icon ni ni-user-alt"></em>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1 is-light">
                                    <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                        <div class="user-card">
                                            <div class="user-avatar">
                                                <span>AB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?php echo $logged_in['user_profile']['fullname']; ?></span>
                                                <span class="sub-text"><?php echo $logged_in['uacc_email']; ?></span>
                                            </div>
                                            <div class="user-action">
                                                <a class="btn btn-icon me-n2" href="html/user-profile-setting.html"><em class="icon ni ni-setting"></em></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-inner user-account-info">
                                        <h6 class="overline-title-alt">Account Balance</h6>
                                        <div class="user-balance">1,494.23 <small class="currency currency-usd">USD</small></div>
                                        <div class="user-balance-sub">Locked <span>15,495.39 <span class="currency currency-usd">USD</span></span></div>
                                        <a href="#" class="link"><span>Withdraw Balance</span> <em class="icon ni ni-wallet-out"></em></a>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                            <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                            <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                            <li><a class="dark-mode-switch" href="#"><em class="icon ni ni-moon"></em><span>Dark Mode</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="javascript: void(0);" onclick="javascript: logout();"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li><!-- .dropdown -->
                        </ul><!-- .nk-quick-nav -->
                    </div><!-- .nk-header-tools -->
                </div><!-- .nk-header-wrap -->
            </div><!-- .container-fliud -->
        </div>
        <!-- main header @e -->
        <!-- content @s -->
        <div class="nk-content ">
            <div class="container-fluid">
                <div class="nk-content-inner">
                    <div class="nk-content-body">