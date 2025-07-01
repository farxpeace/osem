<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.3.0
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
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url(); ?>assets/admin/pages/css/login2.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url(); ?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url(); ?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/sweetalert/sweetalert.css"/>
<style>
.sweet-alert div {
    border-radius: 50% !important;
}
.sweet-alert {
    border-radius: 5px !important;
}
.sweet-alert button {
    border-radius: 5px !important;
}
</style>

<style>
.login {
    background-color: #FFFFFF !important;
}
.form-title {
    color: #27c4f9 !important;
}
.login .form-subtitle {
    color: #f56b62;
    font-size: 17px;
    font-weight: 300 !important;
    padding-left: 10px;
}
.input-group {
    border: 1px solid #27c4f9;
}
.login .content .form-control {
    border: none;
    background-color: #a600fb;
    border: 1px solid #a600fb;
    height: 43px;
    color: #d9ecf9;
}
</style>

<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login" style="background-color: #181b21 !important;">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="<?php echo base_url(); ?>">
	   <img src="<?php echo base_url(); ?>assets/barapp/logo/logo-black-600x200.png"alt="" style="max-width: 300px;"  />
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<div class="login-form">
		<div class="form-title">
			<span class="form-title">Welcome.</span>
			<span class="form-subtitle">Please login.</span>
		</div>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
		</div>
		<div class="form-group">
                    	
                    	<div class="input-group">
                    		<span class="input-group-addon">
                    		  <i class="fa fa-envelope"></i>
                    		</span>
                    		<input type="text" class="form-control " placeholder="Username" id="login_email">
                    	</div>
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                    
                    <div class="form-group">
                    	
                    	<div class="input-group">
                    		<span class="input-group-addon">
                    		  <i class="fa fa-lock fa-fw"></i>
                    		</span>
                    		<input type="password" class="form-control " id="login_password" placeholder="Password">
                    	</div>
                        <span class="help-block error_message" style="display: none;"></span>
                    </div>
                    <?php if(is_localhost()){ ?>
                    <div class="form-group">
                        <select class="form-control" id="list_demo_user">
                            <option value="0">Select demo user</option>
                            <?php
                            $list_all_user = array();
                            $query = $this->db->query("SELECT * FROM view_user_list");
                            $show_uacc_group_fk = array(3,4,5,8,9);
                            foreach($query->result_array() as $a => $b){
                                if(in_array($b['uacc_group_fk'], $show_uacc_group_fk)){
                                    $list_all_user[$b['ugrp_name']][] = array('uacc_username' => $b['uacc_username'], 'uacc_raw_password' => $b['uacc_raw_password'], 'fullname' => $b['fullname']);
                                }

                            }
                            ?>

                            <?php foreach($list_all_user as $a => $b){ ?>
                                <optgroup label="<?php echo $a ?>">
                                    <?php foreach($b as $c => $d){ ?>
                                        <option value="<?php echo $d['uacc_username'] ?>" data-password="<?php echo $d['uacc_raw_password'] ?>"><?php echo $d['uacc_username'] ?> <?php echo $d['fullname'] ?></option>
                                    <?php } ?>

                                </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                    <?php } ?>
                    
		<div class="form-actions">
			<button type="button" onclick="javascript: btn_click_login();" class="btn btn-primary btn-block uppercase">Login</button>
		</div>
		
		
		
	</div>
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->
	
	<!-- END FORGOT PASSWORD FORM -->
	<!-- BEGIN REGISTRATION FORM -->
	
	<!-- END REGISTRATION FORM -->
</div>
<div class="copyright hide">
	 2014 © Metronic. Admin Dashboard Template.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<?php $this->load->view('page/footer_full_width'); ?>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    
    
});
</script>
<script>
$(function(){
    $("#list_demo_user").on('change', function(){
        onchange_demo_user();
    })
});
function onchange_demo_user(){
    var selected_password = $("#list_demo_user").find(':selected').attr('data-password');
    var selected_username = $("#list_demo_user").val();
    
    if($("#list_demo_user").length > 0){
        $("#login_email").val(selected_username);
        $("#login_password").val(selected_password);
        btn_click_login();
    }
}
</script>

<script type="text/javascript">
function btn_click_login(){
    var error_el;
    $("#tab_login .has-error").removeClass('has-error');
    $("#tab_login .error_message").hide();
    
    var email = $("#login_email").val();
    var password = $("#login_password").val();
    
    //check fullname
    if (email === false){ 
        $("#login_email").closest('.form-group').addClass('has-error'); 
        $("#login_email").closest('.form-group').find('.error_message').text("Please fill-in email address").show(); return false
    }
    if (email === "") {
        $("#login_email").closest('.form-group').addClass('has-error'); 
        $("#login_email").closest('.form-group').find('.error_message').text("Please fill-in email address").show(); return false
    }
    
    if (password === false){ 
        $("#login_password").closest('.form-group').addClass('has-error'); 
        $("#login_password").closest('.form-group').find('.error_message').text("Password cannot be blank").show(); return false
    }
    if (password === "") {
        $("#login_password").closest('.form-group').addClass('has-error'); 
        $("#login_password").closest('.form-group').find('.error_message').text("Password cannot be blank").show(); return false
    }
    if(email != 'admintest'){
        swal({
            title: "Error",
            html: true,
            text: "Username or Password did not match. Please try again",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true,
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel",
            closeOnConfirm: true,

        }); return false;
    }
    blockUI();
    $.ajax({
        url: '<?php echo base_url(); ?>auth/login_via_ajax',
        type: 'POST',
        dataType: 'json',
        data: { 
            login_identity: email,
            login_password: password,
            remember_me: 1,
            login_user: 'Submit'
        },
        success: function(data){
            if(data){
                window.location.replace("<?php echo base_url(); ?>auth_admin/dashboard");
            }else{
                $.unblockUI();
                swal({
                	title: "Error",
                	html: true,
                	text: "Username or Password did not match. Please try again",
                    type: "error",
                	showCancelButton: false,
                	showConfirmButton: true,
                    confirmButtonText: "Ok",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: true,
                
                })
            }
            
            
        }
    });
}
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>