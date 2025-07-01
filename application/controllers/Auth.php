<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
 
    function __construct() 
    {
        parent::__construct();
		
		// To load the CI benchmark and memory usage profiler - set 1==1.
		if (1==2) 
		{
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE, 
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE, 
				'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
			); 
			$this->output->set_profiler_sections($sections);
			$this->output->enable_profiler(TRUE);
		}
		
		// Load required CI libraries and helpers.
		$this->load->database();
		$this->load->library('session');
 		$this->load->helper('url');
 		$this->load->helper('form');

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;
		
		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');	
		
        
     	// Redirect users logged in via password (However, not 'Remember me' users, as they may wish to login properly).
		if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'auth/logout'){
		  
            if(uri_string() == 'auth/logout_admin'){
                
            } else {
                // Preserve any flashdata messages so they are passed to the redirect page.
    			if ($this->session->flashdata('message')) { $this->session->keep_flashdata('message'); }
    			
    			// Redirect logged in admins (For security, admin users should always sign in via Password rather than 'Remember me'.
    			if ($this->flexi_auth->is_admin()) 
    			{
    				redirect('auth_admin/dashboard');
    			}
    			else
    			{
    				redirect('auth_public/dashboard');
    			}
            }
          
			
		}
		
		
		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// flexi auth demo
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * Many of the functions within this controller load a custom model called 'demo_auth_model' that has been created for the purposes of this demo.
	 * The 'demo_auth_model' file is not part of the flexi auth library, it is included to demonstrate how some of the functions of flexi auth can be used.
	 *
	 * These demos show working examples of how to implement some (most) of the functions available from the flexi auth library.
	 * This particular controller 'auth', is used as the main login page, user registration, and for forgotten password requests.
	 * 
	 * All demos are to be used as exactly that, a demonstation of what the library can do.
	 * In a few cases, some of the examples may not be considered as 'Best practice' at implementing some features in a live environment.
	*/

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Login / Registration
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * index
	 * Forwards to 'login'.
	 */ 
	function index()
    {
		$this->login();
	}
 
	/**
	 * login
	 * Login page used by all user types to log into their account.
	 * This demo includes 3 example accounts that can be logged into via using either their email address or username. The login details are provided within the view page.
	 * Users without an account can register for a new account.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */ 
    function login()
    {	
		// If 'Login' form has been submited, attempt to log the user in.
		if ($this->input->post('login_user'))
		{
		      
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->login();
            
		}
			
		// CAPTCHA Example
		// Check whether there are any existing failed login attempts from the users ip address and whether those attempts have exceeded the defined threshold limit.
		// If the user has exceeded the limit, generate a 'CAPTCHA' that the user must additionally complete when next attempting to login.
		if ($this->flexi_auth->ip_login_attempts_exceeded())
		{
			/**
			 * reCAPTCHA
			 * http://www.google.com/recaptcha
			 * To activate reCAPTCHA, ensure the 'recaptcha()' function below is uncommented and then comment out the 'math_captcha()' function further below.
			 *
			 * A boolean variable can be passed to 'recaptcha()' to set whether to use SSL or not.
			 * When displaying the captcha in a view, if the reCAPTCHA theme has been set to one of the template skins (See https://developers.google.com/recaptcha/docs/customization),
			 *  then the 'recaptcha()' function generates all the html required.
			 * If using a 'custom' reCAPTCHA theme, then the custom html must be PREPENDED to the code returned by the 'recaptcha()' function.
			 * Again see https://developers.google.com/recaptcha/docs/customization for a template 'custom' html theme. 
			 * 
			 * Note: To use this example, you will also need to enable the recaptcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
			*/
			# $this->data['captcha'] = $this->flexi_auth->recaptcha(FALSE);
						
			/**
			 * flexi auths math CAPTCHA
			 * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
			 * For flexibility on CAPTCHA presentation, the 'math_captcha()' function only generates a string of the equation, see the example below.
			 * 
			 * To activate math_captcha, ensure the 'math_captcha()' function below is uncommented and then comment out the 'recaptcha()' function above.
			 *
			 * Note: To use this example, you will also need to enable the math_captcha examples in 'models/demo_auth_model.php', and 'views/demo/login_view.php'.
			*/
			# $this->data['captcha'] = $this->flexi_auth->math_captcha(FALSE);
		}
				
		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		
        $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
        if($scheme == 'http'){
            redirect(base_url());
        }
        redirect(base_url());
		//$this->load->view('login/login', $this->data);
    }
    
    function register_via_ejauth(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        
        $is_alias_url_name_available = $this->far_users->is_alias_url_name_available($postdata['edit_alias_url_name']);
        if($is_alias_url_name_available['status'] == "error"){
            $error['edit_alias_url_name'] = reset($is_alias_url_name_available['errors']);
        }
        
        /*
        //check if email already registered
        $is_email_registered = $this->far_users->get_user_by_column('uacc_username', strtolower($postdata['email']), 'uacc_id');
        if($is_email_registered){
            $error['email'] = "Email ini telah didaftarkan. Sila gunakan email lain";
        }
        */
        if(strlen($postdata['email']) < 3){
            $error['email'] = "Sila masukkan alamat email anda";
        }
        
        
        //check mobile
        if(strlen($postdata['phonemobile']) < 8){
            $error['phonemobile'] = "Nombor Telefon Bimbit mestilah melebihi 8 digit";
        }
        
        if(!preg_match('/^\+?\d+$/', $postdata['phonemobile'])){
            $error['phonemobile'] = "Nombor Telefon Bimbit mestilah digit sahaja";
        }
        
        //validate password
        if(strlen($postdata['password']) < $this->flexi_auth->min_password_length()){
            $error['password'] = "Password mestilah sekurang-kurangnya ".$this->flexi_auth->min_password_length()." aksara";
        }
        
        if(!$this->flexi_auth->valid_password_chars($postdata['password'])){
            $error['password'] = "Password mengandungi aksara yang tidak dibenarkan. Sila cuba password lain.";
        }
        
        
        
        if(count($error) == 0){
            
            
            
            //try to register
            $email_address_register = $postdata['edit_alias_url_name']."@system.hg";
            $username = $postdata['edit_alias_url_name'];
            $password = $postdata['password'];
            $user_data = array();
            $group_id = 5;
            $activate = TRUE;
            $uacc_id = $this->flexi_auth->insert_user($email_address_register, $username, $password, $user_data, $group_id, $activate);
            if($uacc_id){
                   $this->far_users->update_user('uacc_id', $uacc_id, 'alias_url_name', $postdata['edit_alias_url_name']);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'phonemobile', $postdata['phonemobile']);
                
                //update
                $referral_detail = $this->far_users->check_and_regenerate_referral_cookie();
                $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_upline_id', $referral_detail['uacc_id']);
                $this->far_users->regenerate_upline_list($uacc_id);
                
                $this->far_users->send_sms_registration_success($uacc_id);
                
                $this->far_users->send_sms_registration_success_to_direct_upline($uacc_id);
                
                $output['uacc_id'] = $uacc_id;
                $output['status'] = 'success';
            }else{
                $error['uacc_id'] = "Terdapat ralat. Sila cuba semula menggunakan maklumat lain";
                $output['message_single'] = current($error);
                $output['errors'] = $error;
                $output['status'] = 'error';
            }
            
            
            
            
            
        }else{
            
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
        
    }
    
    function login_via_firebase_google(){
        $this->load->library('far_jwt');
        $output = array();
        
        $email_address = $this->input->post('email_address');
        $token = $this->input->post('token');
        
        $postdata = $this->input->post('postdata');
        
        $validate = $this->far_jwt->validate_token_from_firebase_google($token, $email_address);
        
        //success
        if($validate){
            //check if user registered or not
            $user_detail = $this->far_users->get_user('uacc_username', $email_address);
            if(count($user_detail) > 0){
                //login user and redirect to dashboard
                $try_to_login = $this->flexi_auth->login($email_address, $user_detail['uacc_raw_password'], TRUE);
                if($try_to_login){
                    $output['status'] = 'success';
                    $output['redirect'] = base_url().'auth_admin/dashboard';
                    $final_uacc_id = $user_detail['uacc_id'];
                    
                    //update Fullname
                    if(strlen($postdata['displayName']) > 2){
                        $this->far_users->update_profile('uacc_id', $final_uacc_id, 'fullname', $postdata['displayName']);
                    }
                    
                    if(strlen($postdata['photoURL']) > 2){
                        $this->far_users->update_profile('uacc_id', $final_uacc_id, 'profilepic_url', $postdata['photoURL']);
                    }
                }else{
                    $output['status'] = 'error';
                }
                
                
            }else{
                //register user, then redirect to dashboard
                //create user
                $username = $email_address;
                $password = '584555485785';
                $user_data = array();
                $group_id = 5;
                $activate = TRUE;
                $uacc_id = $this->flexi_auth->insert_user($email_address, $username, $password, $user_data, $group_id, $activate);
                if($uacc_id){
                    
                    //generate auto alias_url_name
                    $alias_url_name = $uacc_id.$this->far_helper->generateRandomString(10);
                    $this->far_users->update_user('uacc_id', $uacc_id, 'alias_url_name', $alias_url_name);
                    
                    $referral_detail = $this->far_users->check_and_regenerate_referral_cookie();
                    $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_upline_id', $referral_detail['uacc_id']);
                    $this->far_users->regenerate_upline_list($uacc_id);
                    
                    $try_to_login = $this->flexi_auth->login($email_address, $password, TRUE);
                    if($try_to_login){
                        $output['status'] = 'success';
                        $output['redirect'] = base_url().'auth_admin/dashboard';
                    }
                    
                    $final_uacc_id = $uacc_id;
                }else{
                    $output['status'] = 'error';
                    
                }
            }
            
            if(isset($final_uacc_id)){
                
                
            }
            
            
            
        }
        
        header('Content-Type: application/json');
        echo json_encode($output);
        
    }

	/**
	 * login_via_ajax
	 * A simplified version of the above 'login' method that instead uses ajax to submit a users credentials.
	 * This demo includes 3 example accounts that can be logged into via using either their email address or username. The login details are provided within the view page.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */ 
    function login_via_ajax()
    {
        
		if ($this->input->is_ajax_request())
		{
		  //echo "asdasd"; exit();
			$this->load->model('demo_auth_model');
			
			$this->demo_auth_model->login_via_ajax();

			die($this->flexi_auth->is_logged_in());
		}
		else
		{
			$this->load->view('demo/login_via_ajax_view', $this->data);
		}
    }

	/**
	 * register_account
	 * User registration page used by all new users wishing to create an account.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */ 
	function register_account()
	{
		// Redirect user away from registration page if already logged in.
		if ($this->flexi_auth->is_logged_in()) 
		{
			redirect(base_url());
		}
		// If 'Registration' form has been submitted, attempt to register their details as a new account.
		else if ($this->input->post('register_user'))
		{			
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->register_account();
		}
		
		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/public_examples/register_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Account Activation
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * activate_account
	 * User account activation via email.
	 * The default setup of this demo requires that new account registrations must be authenticated via email before the account is activated.
	 * In this demo, this page is accessed via an activation link in the 'views/includes/email/activate_account.tpl.php' email template.
	 */ 
	function activate_account($user_id, $token = FALSE)
	{
		// The 3rd activate_user() parameter verifies whether to check '$token' matches the stored database value.
		// This should always be set to TRUE for users verifying their account via email.
		// Only set this variable to FALSE in an admin environment to allow activation of accounts without requiring the activation token.
		$this->flexi_auth->activate_user($user_id, $token, TRUE);

		// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

		redirect(base_url());
	}
	
	/**
	 * resend_activation_token
	 * Resend user an activation token via email.
	 * If a user has not received/lost their account activation email, they can request a new activation email to be sent to them.
	 * In this demo, this page is accessed via a link on the login page.
	 */ 
	function resend_activation_token()
	{
		// If the 'Resend Activation Token' form has been submitted, resend the user an account activation email.
		if ($this->input->post('send_activation_token')) 
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->resend_activation_token();
		}
		
		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/public_examples/resend_activation_token_view', $this->data);		
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Forgotten Password
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * forgotten_password
	 * Send user an email to verify their identity. Via a unique link in this email, the user is redirected to the site so they can then reset their password.
	 * In this demo, this page is accessed via a link on the login page.
	 *
	 * Note: This is step 1 of an example of allowing users to reset a forgotten password manually. 
	 * See the auto_reset_forgotten_password() function below for an example of directly emailing the user a new randomised password.
	 */ 
	function forgotten_password()
	{
		// If the 'Forgotten Password' form has been submitted, then email the user a link to reset their password.
		if ($this->input->post('send_forgotten_password')) 
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->forgotten_password();
		}
		
		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/public_examples/forgot_password_view', $this->data);		
	}
	
	/**
	 * manual_reset_forgotten_password
	 * This is step 2 (The last step) of an example of allowing users to reset a forgotten password manually. 
	 * See the auto_reset_forgotten_password() function below for an example of directly emailing the user a new randomised password.
	 * In this demo, this page is accessed via a link in the 'views/includes/email/forgot_password.tpl.php' email template, which must be set to 'auth/manual_reset_forgotten_password/...'.
	 */
	function manual_reset_forgotten_password($user_id = FALSE, $token = FALSE)
	{
		// If the 'Change Forgotten Password' form has been submitted, then update the users password.
		if ($this->input->post('change_forgotten_password')) 
		{
			$this->load->model('demo_auth_model');
			$this->demo_auth_model->manual_reset_forgotten_password($user_id, $token);
		}
		
		// Get any status message that may have been set.
		$this->data['message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		

		$this->load->view('demo/public_examples/forgot_password_update_view', $this->data);
	}

	/**
	 * auto_reset_forgotten_password
	 * This is an example of automatically reseting a users password as a randomised string that is then emailed to the user. 
	 * See the manual_reset_forgotten_password() function above for the manual method of changing a forgotten password.
	 * In this demo, this page is accessed via a link in the 'views/includes/email/forgot_password.tpl.php' email template, which must be set to 'auth/auto_reset_forgotten_password/...'.
	 */
	function auto_reset_forgotten_password($user_id = FALSE, $token = FALSE)
	{
		// forgotten_password_complete() will validate the token exists and reset the password.
		// To ensure the new password is emailed to the user, set the 4th argument of forgotten_password_complete() to 'TRUE' (The 3rd arg manually sets a new password so set as 'FALSE').
		// If successful, the password will be reset and emailed to the user.
		$this->flexi_auth->forgotten_password_complete($user_id, $token, FALSE, TRUE);
			
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
		
		redirect(base_url());
	}
		
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Logout
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * logout
	 * This example logs the user out of all sessions on all computers they may be logged into.
	 * In this demo, this page is accessed via a link on the demo header once a user is logged in.
	 */
	function logout($redirect = "/") 
	{
		// By setting the logout functions argument as 'TRUE', all browser sessions are logged out.
		$this->flexi_auth->logout(TRUE);
		
        
        
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());		
 
		redirect($redirect);
    }
    
    function logout_admin(){
        // By setting the logout functions argument as 'TRUE', all browser sessions are logged out.
        $this->flexi_auth->logout(TRUE);



        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        redirect(base_url().'admin');
    }
	
	/**
	 * logout_session
	 * This example logs the user only out of their CURRENT browser session (e.g. Internet Cafe), but no other logged in sessions (e.g. Home and Work).
	 * In this demo, this controller method is actually not linked to. It is included here as an example of logging a user out of only their current session.
	 */
	function logout_session() 
	{
		// By setting the logout functions argument as 'FALSE', only the current browser session is logged out.
		$this->flexi_auth->logout(FALSE);

		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());		
        
		redirect(base_url());
    }	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */