<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MY_Controller {
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
        $this->load->helper('cookie');
		$this->load->database();

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;

		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');



		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;

        $upline_user_detail = $this->far_users->check_and_regenerate_referral_cookie();

        $this->data['upline_detail'] = $upline_user_detail;
	}

    function login(){
        if ($this->flexi_auth->is_logged_in()){
			redirect('auth_admin/dashboard');
		}
        $this->load->view('page/login', $this->data);
    }

    function login_user(){
        if ($this->flexi_auth->is_logged_in()){
            redirect('auth_admin/dashboard');
        }
        $this->load->view('page/login_user', $this->data);
    }
    function login_sms(){
        if ($this->flexi_auth->is_logged_in()){
            redirect('auth_admin/dashboard');
        }
        $this->load->view('page/login_sms', $this->data);
    }
    function register_choose_account(){
        $this->load->view('page/register_choose_account', $this->data);
    }
    function register_profile_personal(){

        $this->load->view('page/register_profile_personal', $this->data);
    }

    function landing_page(){
        //redirect('auth_admin/dashboard');
        redirect('pwa_offline_landing.html');
    }
    function get_started(){
        if ($this->flexi_auth->is_logged_in()){
            redirect('auth_admin/dashboard');
        }

        if (!$this->isMobile()) {
            //redirect('page/login_desktop');
        }
        $this->load->view('page/landing_page', $this->data);
    }
    function get_started_page_1(){
        if ($this->flexi_auth->is_logged_in()){

        }else{
            redirect('page/get_started_page_1');
        }

        $this->load->view('page/get_started_page_1', $this->data);
    }
    function login_desktop(){
        if ($this->flexi_auth->is_logged_in()){
            redirect('auth_admin/dashboard');
        }
        $this->load->view('page/login_desktop', $this->data);
    }

    function register(){
        if ($this->flexi_auth->is_logged_in()){
            redirect('auth_admin/dashboard');
        }
        $this->load->view('page/register', $this->data);
    }

    function osem(){

        $this->load->view('page/osem', $this->data);
    }

    function ajax_register_profile_personal(){
        $this->load->library('far_tac');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        if(strlen($postdata['fullname'] ?? "") < 4){
            $error['fullname'] = "Make sure Fullname follow your MyKad";
        }

        //check username
        $username = $postdata['username'] ?? "";
        if(strlen($username) <= 5){
            $error['username'] = "Username must be more than 5 characters";
        }else{
            $check_valid_username = $this->far_users->check_valid_username($username);
            if($check_valid_username != 'ok'){
                $error['username'] = $check_valid_username;
            }else{
                $check_last_digits = substr($username, -2);
                if(!preg_match('/[0-9]/', $check_last_digits)){
                    $error['username'] = "Username must have at least 2 digits in the end";
                }
            }
        }

        //check username must have digits


        $msisdn = $postdata['mobile_number'] ?? 0;
        $msisdn_valid = "no";
        if(strlen($msisdn) < 7){
            $error['mobile_number'] = "Make sure Mobile Number is correct";
        }else{
            if(!preg_match('/\\+[0-9]+/i', $msisdn)){
                $error['mobile_number'] = "Mobile number cannot contains string";
            }else{
                $msisdn = $this->far_helper->fix_msisdn($msisdn);
                $msisdn_valid = "yes";
            }
        }

        if($msisdn_valid == "yes"){
            $tac_number = $postdata['tac_number'] ?? "";
            if(strlen($tac_number) == 0){
                $error['tac_number'] = "Please request OTP Number first";
            }elseif(strlen($tac_number) < 4){
                $error['tac_number'] = "OTP Number must be 4 digits";
            }else{
                //check TAC correct and unused for mobile_verification
                $unused_tac = $this->far_tac->get_latest_unused_tac_code_by_mobile_number($msisdn);
                //print_r($unused_tac); exit();
                if(count($unused_tac) > 0){
                    if($unused_tac['tac_code'] != $tac_number){
                        $error['tac_number'] = "Wrong OTP Number. Please check SMS again";
                    }
                    if($unused_tac['tac_type'] != 'mobile_number_verification'){
                        $error['tac_number'] = "OTP correct, but not used for Registration. Please wait & request OTP again";
                    }
                }else{
                    $error['tac_number'] = "OTP expired. Please request new OTP";
                }
            }

        }


        //email
        $email_address = strtolower($postdata['uacc_email'] ?? "");
        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            $error['uacc_email'] = "Invalid email format";
        }else{
            //check if email exists
            if($this->far_users->is_email_exists($email_address)){
                $error['uacc_email'] = "Email already registered";
            }
        }

        //alias_url_name
        $stored_alias_url_name = get_cookie('alias_url_name') ?? "";
        if(strlen($stored_alias_url_name) < 2){
            $error['alias_url_name'] = "Error with Referral. Please contact administrator (REF:884)";
        }else{
            $upline_user_detail = $this->far_users->get_user('alias_url_name', $stored_alias_url_name);
            if(count($upline_user_detail) < 3){
                $error['alias_url_name'] = "Error with Referral. Please contact administrator (REF:874)";
            }
        }

        //check password
        $password = $postdata['password'] ?? "";
        $password_confirm = $postdata['password_confirm'] ?? "";
        $check_valid_password = $this->far_users->check_valid_password($password, $password_confirm);
        if($check_valid_password != 'ok'){
            $error['password'] = $check_valid_password;
        }

        if(count($error) == 0){

            //register user
            $user_data = [];
            $uacc_id = $this->flexi_auth->insert_user($email_address, $msisdn, $password_confirm, $user_data, 6, TRUE);
            $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_upline_id', $upline_user_detail['uacc_id']);
            $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_raw_password', $password_confirm);
            $this->far_users->update_user('uacc_id', $uacc_id, 'alias_url_name', $username);
            $this->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $msisdn);
            $this->far_users->update_profile('uacc_id', $uacc_id, 'fullname', $postdata['fullname']);
            $this->far_users->update_profile('uacc_id', $uacc_id, 'email', $email_address);

            //construct all upline
            $this->far_unilevel->construct_all_upline($uacc_id);

            //OTP
            $this->far_tac->flag_used_by_mobile_number_and_tac($msisdn, $tac_number, $uacc_id);

            // Added property to the object
            $user_login_detail = new stdClass();
            $user_login_detail->uacc_username = $msisdn;
            $user_login_detail->uacc_id = $uacc_id;
            $user_login_detail->uacc_group_fk = 6;

            $this->flexi_auth_model->set_login_sessions($user_login_detail, TRUE);

            $redirect_url = base_url()."auth_admin/dashboard/";

            $output['redirect_url'] = $redirect_url;
            $output['uacc_id'] = $uacc_id;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function request_otp_register(){
        $this->load->library('far_tac');
        $this->load->library('far_sms');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $msisdn = $this->far_helper->fix_msisdn($postdata['mobile_number'] ?? 0);

        if(strlen($msisdn) < 8){
            $error['mobile_number'] = "Make sure mobile number is valid";
        }else{
            //check is username exists
            $is_username_exists = $this->far_users->is_username_exists($msisdn);
            if($is_username_exists){
                $error['mobile_number'] = "This mobile number already registered";
            }else{
                //check if already request OTP and active or not
                $latest_unused_tac = $this->far_tac->get_latest_unused_tac_code_by_mobile_number($msisdn);
                if(count($latest_unused_tac) > 0){
                    $error['tac_number'] = "Please wait ".$this->far_meta->get_value('tac_expired_in_minutes')." minutes before request new OTP";
                }
            }
        }

        if(count($error) == 0){
            $page_identifier = $this->far_helper->generateRandomString(12);
            $tac_data = array();
            $tac_data['mobile_number'] = $msisdn;
            $tac_data['page_identifier'] = $page_identifier;
            $tac_data['tac_type'] = "mobile_number_verification";

            $tac_code = $this->far_tac->generate_tac_code($tac_data);

            //send SMS
            $sms_message = "NEX: Your OTP number for registration is ".$tac_code.". This OTP only valid for 3 minutes";
            $this->far_sms->send_sms($msisdn, $sms_message);


            $redirect_url = base_url().'page/verify_otp/?identifier='.$page_identifier;
            $output['mobile_number'] = $msisdn;
            $output['redirect_url'] = $redirect_url;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function verify_otp(){
        $this->load->library('far_tac');
        $error = array();
        $page_identifier = $this->input->get('identifier');

        $tac_detail = $this->far_tac->get_tac_code('page_identifier', $page_identifier);
        if(count($tac_detail) > 0){
            if($tac_detail['tac_status'] != 'unused'){
                $error['tac_statuc'] = "OTP expired. Please request again";
                $error['mobile_number'] = $tac_detail['mobile_number'];
                $error['nric_number'] = $tac_detail['nric_number'];
            }
        }else{
            $error['tac_statuc'] = "OTP expired. Please request again";
        }

        $this->data['error'] = $error;

        $this->load->view('page/verify_otp', $this->data);
    }

    function send_tac_login(){
        $this->load->library('far_tac');
        $this->load->library('far_sms');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $msisdn = $this->far_helper->fix_msisdn($postdata['mobile_number']);

        if(strlen($msisdn) < 8){
            $error['mobile_number'] = "Make sure mobile number is valid";
        }


        if(count($error) == 0){
            $page_identifier = $this->far_helper->generateRandomString(12);
            $tac_data = array();
            $tac_data['mobile_number'] = $msisdn;
            $tac_data['page_identifier'] = $page_identifier;
            $tac_data['tac_type'] = "login";

            $tac_code = $this->far_tac->generate_tac_code($tac_data);

            //send SMS
            $sms_message = "CRM: Your OTP number for login is ".$tac_code.". This OTP only valid for 3 minutes";
            $this->far_sms->send_sms($msisdn, $sms_message);


            $redirect_url = base_url().'page/verify_otp/?identifier='.$page_identifier;
            $output['redirect_url'] = $redirect_url;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function update_onesignal_player_id(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();


        if(count($error) == 0){

            $user_token = $this->session->flexi_auth['login_session_token'];
            $token_session_data = array(
                'onesignal_subscription_id' => $postdata['onesignal_subscription_id'],
                'onesignal_player_id' => $postdata['onesignal_player_id']
            );

            $onesignal_registration_status = 'exists';

            //check if exists, ignore
            $query = $this->db->query("SELECT * FROM onesignal_subscription WHERE uacc_id='".$postdata['uacc_id']."' AND onesignal_player_id='".$postdata['onesignal_player_id']."'");
            if($query->num_rows() == 0){
                $onesignal_insert_data = array(
                    'uacc_id' => $postdata['uacc_id'],
                    'onesignal_subscription_id' => $postdata['onesignal_subscription_id'],
                    'onesignal_player_id' => $postdata['onesignal_player_id'],
                    'create_dttm' => date("Y-m-d H:i:s")
                );
                $this->db->insert('onesignal_subscription', $onesignal_insert_data);
                $onesignal_registration_status = 'new';
            }

            $output['onesignal_registration_status'] = $onesignal_registration_status;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function process_desktop_login(){
        $this->load->library('far_tac');
        $this->load->library('far_sms');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $uacc_id = $postdata['uacc_id']-845157845;
        $user_detail = $this->far_users->get_user('uacc_id', $uacc_id);
        if(count($user_detail) == 0){
            $error['user_detail'] = "Can't login user. Wrong ID";
        }

        if(count($error) == 0){

            // Added property to the object
            $user_login_detail = new stdClass();
            $user_login_detail->uacc_username = $user_detail['uacc_username'];
            $user_login_detail->uacc_id = $user_detail['uacc_id'];
            $user_login_detail->uacc_group_fk = 6;

            $this->flexi_auth_model->set_login_sessions($user_login_detail, TRUE);

            $redirect_url = base_url()."auth_admin/dashboard/";
            $output['redirect_url'] = $redirect_url;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function verify_tac_login(){
        $this->load->library('far_tac');
        $this->load->library('far_sms');
        $postdata = $this->input->post('postdata');
        $tac_detail = array();
        $error = array();
        $output = array();


        if(strlen($postdata['page_identifier']) < 8){
            $error['page_identifier'] = "OTP expired. Please request again";
        }
        if(strlen($postdata['tac_number']) != 4){
            $error['tac_number'] = "TAC Number must be 4 digits";
        }

        $query = $this->db->query("SELECT * FROM far_tac WHERE tac_code='".$postdata['tac_number']."' AND page_identifier='".$postdata['page_identifier']."' AND tac_status='unused'");
        if($query->num_rows() != 1){
            $error['tac_status'] = "OTP expired. Please request again";
        }elseif($query->num_rows() == 1){
            $tac_detail = $query->row_array();
        }

        if(count($tac_detail) == 0){
            $error['tac_status'] = "OTP expired. Please request again (1)";
        }

        if(count($error) == 0 && count($tac_detail) > 0){
            $this->load->model('flexi_auth_model');
            $user_login_detail = new stdClass();
            //check if user exists
            $query3 = $this->db->query("SELECT * FROM user_accounts WHERE uacc_username='".$tac_detail['mobile_number']."'");
            if($query3->num_rows() == 0){
                //create user
                $email = $tac_detail['mobile_number']."@crm.qtic.my";
                $login_username = $tac_detail['mobile_number'];
                $login_password = '12345678';
                $user_data = array();
                $group_id = 6;
                $activate = TRUE;

                $uacc_id = $this->flexi_auth->insert_user($email, $login_username, $login_password, $user_data, $group_id, $activate);
                $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_raw_password', $login_password);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $login_username);

                //$this->far_ruko->sync_user($uacc_id);

                // Added property to the object
                $user_login_detail->uacc_username = $login_username;
                $user_login_detail->uacc_id = $uacc_id;
                $user_login_detail->uacc_group_fk = 6;
            }else{
                $uacc_id = $query3->row()->uacc_id;
                $this->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $query3->row()->uacc_username);

                // Added property to the object
                $user_login_detail->uacc_username = $query3->row()->uacc_username;
                $user_login_detail->uacc_id = $query3->row()->uacc_id;
                $user_login_detail->uacc_group_fk = 6;
            }

            $this->far_tac->update_far_tac('tac_id', $tac_detail['tac_id'], 'tac_status', 'used');

            $this->flexi_auth_model->set_login_sessions($user_login_detail, TRUE);


            $redirect_url = base_url().'auth_admin/dashboard';
            $output['redirect_url'] = $redirect_url;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function dashlite(){
        $this->load->view('page/dashlite', $this->data);
    }

    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    function ajax_search_postcode(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        $searchTerm = $this->input->post('searchTerm');
        $searchTerm = strtolower($searchTerm);
        $list_result = array();

        if(isset($searchTerm)){
            $query = $this->db->query("SELECT * FROM postcode WHERE postcode LIKE '%".$searchTerm."%' OR LOWER(area_name) LIKE '%".$searchTerm."%' OR LOWER(post_office) LIKE '%".$searchTerm."%' LIMIT 30");
            $list_result = $query->result_array();
        }else{

        }

        foreach($list_result as $a => $b){
            $output[] = array(
                "id" => $b['postcode_id'],
                "text" => $b['postcode']." - ".$b['area_name'].' - '.$b['post_office']
            );
        }




        echo json_encode($output);
    }

    function www(){

        //$alias_url_name = str_replace("/","", $_SERVER['SCRIPT_URL']);

        //echo "<pre>"; print_r($_SERVER); exit();

        $this->far_users->check_and_regenerate_referral_cookie();

        $alias_url_name = $this->input->get('alias_url_name');
        //check alias
        if(strlen($alias_url_name) > 3){
            $referral_detail = $this->far_users->get_user('alias_url_name', $alias_url_name);

            /*
            if($referral_detail['is_paid_user'] == "yes"){

            }else{

                //get default alias url name
                $referral_detail = $this->flexi_auth->get_random_upline();

            }
             */
        }else{
            $referral_detail = $this->flexi_auth->get_random_upline();
        }

        $ip_info = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$_SERVER['HTTP_X_REAL_IP']), TRUE);
        //echo "<pre>"; print_r($ip_info); exit();
        $referral_visitor_detail = array(
            'uacc_id' => $referral_detail['uacc_id'],
            'alias_url_name' => $referral_detail['alias_url_name'],
            'city' => $ip_info['geoplugin_city'],
            'region' => $ip_info['geoplugin_region'],
            'country' => $ip_info['geoplugin_countryName'],
            'ip_address' => $ip_info['geoplugin_request'],
            'platform' => str_replace('"',"", $_SERVER['HTTP_SEC_CH_UA_PLATFORM']),
            'create_dttm' => date("Y-m-d H:i:s")
        );

        $this->db->insert('referral_visitor', $referral_visitor_detail);


        //print_r($referral_detail);


        $this->load->view('page/referral_landing_page', $this->data);
    }

    function generate_qrcode(){

        $contents = "asdfasdfasdf";
        $path = FCPATH.'assets/score_report/qrcode/';
        $filename = '111111.png';

        $this->far_helper->generate_qrcode($contents, $path, $filename);
    }

    function view_score_report(){
        $score_report_code = $this->input->get('score_report_code');
        $score_report_detail = $this->far_score->get_score_report_by_column('score_report_code', $score_report_code);
        if(count($score_report_detail) > 0){
            $file_path = FCPATH.'assets/score_report/pdf/'.$score_report_detail['score_report_code'].'.pdf';
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush();
            readfile($file_path);
            exit;
        }
    }



}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
