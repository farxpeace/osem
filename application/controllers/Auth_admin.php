<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_admin extends MY_Controller {
    private $user;
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

		// Check user is logged in as an admin.
		// For security, admin users should always sign in via Password rather than 'Remember me'.
		if (! $this->flexi_auth->is_logged_in_via_password() || ! $this->flexi_auth->is_admin()) 
		{
			// Set a custom error message.
			$this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('auth');
		}
		
		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;

        $this->user = $this->far_users->get_user('uacc_id', $this->flexi_auth->get_user_id());
        $this->global_pass_to_view();
	}
    
    public function global_pass_to_view(){
        $this->data['logged_in'] = $this->user;
        if($this->flexi_auth->is_admin()){
            $this->data['logged_in']['is_admin'] = true;
        }
    }

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// flexi auth demo
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * Many of the functions within this controller load a custom model called 'demo_auth_admin_model' that has been created for the purposes of this demo.
	 * The 'demo_auth_admin_model' file is not part of the flexi auth library, it is included to demonstrate how some of the functions of flexi auth can be used.
	 *
	 * These demos show working examples of how to implement some (most) of the functions available from the flexi auth library.
	 * This particular controller 'auth_admin', is used by logged in admins to manage users and user groups.
	 * 
	 * All demos are to be used as exactly that, a demonstation of what the library can do.
	 * In a few cases, some of the examples may not be considered as 'Best practice' at implementing some features in a live environment.
	*/

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Quick Help Guide
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * db_column() function
	 * Columns defined using the 'db_column()' functions are referencing native table columns from the auth libraries 'user_accounts' table.
	 * Using the 'db_column()' function ensures if the column names are changed via the auth config file, then no further references to those table columns 
	 * within the CI installation should need to be updated, as the function will auto reference the config files updated column name.
	 * Native library column names can be defined without using this function, however, you must then ensure that all references to those column names are 
	 * updated throughout the site if later changed.
	 */

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Dashboard
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * index
	 * Forwards to the admin dashboard.
	 */ 
	function index()
    {
		$this->dashboard();
	}
 
 	/**
 	 * dashboard (Admin)
 	 * The public account dashboard page that acts as the landing page for newly logged in public users.
 	 * The dashboard provides links to some examples of the features available from the flexi auth library.  
 	 */
    function dashboard()
    {
        $this->load->library('far_dashboard');
        $this->load->library('far_helper');
		$this->data['message'] = $this->session->flashdata('message');
		
		$user_group_id = $this->flexi_auth->get_user_group_id();


        //$this->load->library('onesignal');
        //$response = $this->onesignal->send_pn_to_user(2181, 'test', 'test message');
        //print_r($response); exit();

        if($user_group_id == 6){
            $this->load->view('dashboard/6_tfpay_dashboard', $this->data);
        }elseif($user_group_id == 3){

            $current_date = date("Y-m-d");
            $monthly_pay_filter_month = date("m", strtotime("-1 months",strtotime($current_date)));
            $monthly_pay_filter_year = date("Y", strtotime("-1 months",strtotime($current_date)));
            $this->data['monthly_pay_filter_month'] = $monthly_pay_filter_month;
            $this->data['monthly_pay_filter_year'] = $monthly_pay_filter_year;

            $monthly_sale_filter_month = date("m", strtotime("-1 months",strtotime($current_date)));
            $monthly_sale_filter_year = date("Y", strtotime("-1 months",strtotime($current_date)));
            $this->data['monthly_sale_filter_month'] = $monthly_sale_filter_month;
            $this->data['monthly_sale_filter_year'] = $monthly_sale_filter_year;

            $this->load->view('dashboard/3_dashlite_dashboard', $this->data);
        }else{
            $dashboard_filepath = FCPATH.'application'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'dashboard'.DIRECTORY_SEPARATOR.$user_group_id.'_dashboard.php';
            $this->data['dashboard_filepath'] = $dashboard_filepath;
            if(file_exists($dashboard_filepath)){
                $this->load->view('dashboard/'.$user_group_id.'_dashboard', $this->data);
            }else{
                $this->load->view('dashboard/default_dashboard', $this->data);
            }
        }
        

        
        
	}


}

/* End of file auth_admin.php */
/* Location: ./application/controllers/auth_admin.php */