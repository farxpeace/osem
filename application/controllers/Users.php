<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {
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

  		// IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded! 
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
		$this->auth = new stdClass;
		
		// Load 'standard' flexi auth library by default.
		$this->load->library('flexi_auth');	
		
        if (! $this->flexi_auth->is_logged_in_via_password() || ! $this->flexi_auth->is_admin()) 
		{
			// Set a custom error message.
			$this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('auth');
		}
        	
		// Define a global variable to store data that is then used by the end view page.
		$this->data = null;
        $this->global_pass_to_view();
        $this->user = $this->flexi_auth->get_user_by_identity_row_array();
	}
    
    public function global_pass_to_view(){
        $this->data['logged_in'] = $this->flexi_auth->get_user_by_identity_row_array();
        if($this->flexi_auth->is_admin()){
            $this->data['logged_in']['is_admin'] = true;
        }
    }


    function ajax_update_onesignal_player_id(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();


        if(count($error) == 0){

            $this->far_users->update_user('uacc_id', $postdata['uacc_id'], 'onesignal_player_id', $postdata['onesignal_player_id']);

            $output['status'] = 'success';
        }else{
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    
    function datatable_admin_list_all_user(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        
        //echo "<pre>"; print_r($this->far_auth->pages); exit();
        
        $this->load->view('users/admin/datatable_admin_list_all_user', $this->data);
    }
    function ajax_datatable_admin_list_all_user(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');
        $uacc_created_by = $this->user['uacc_id'];
        $this->datatables->select('u.uacc_id');
        $this->datatables->select('u.uacc_username');
        $this->datatables->select('u.badge_no');
        $this->datatables->select('u.fullname');
        $this->datatables->select('u.email');
        $this->datatables->select('u.user_department_id');
        $this->datatables->select('u.user_designation_id');
        $this->datatables->select('u.user_designation_name');
        $this->datatables->select('u.user_department_name');
        $this->datatables->select('u.user_role_name');
        $this->datatables->select('u.user_role_code');
        $this->datatables->select('u.uacc_date_added');
        $this->datatables->select('u.mobile_number');
        $this->datatables->select('u.profile_picture');
        $this->datatables->select('u.user_status');

        $this->datatables->from('view_user_list u');
        
        $this->datatables->where('u.uacc_group_fk', '6');

        $output = $this->datatables->generate();
        echo $output;
    }
    
    
    

    
    function ajax_admin_delete_user(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        
        $user_detail = $this->far_users->get_user('uacc_id', $postdata['uacc_id']);
        if(is_array($user_detail) && count($user_detail) == 0){
            $error['user_detail'] = "User not exists";
        }
        
        if(count($error) == 0){
            
            
            
            //delete user
            $this->far_users->delete_user($postdata['uacc_id']);
            
            $log_data = array();
            $log_data['deleted_uacc_id'] = $user_detail['uacc_id'];
            $log_data['user_detail'] = $user_detail;
            $this->far_log->insert($this->user['uacc_id'], 'cms_admin_delete_user', $log_data);
            
            $output['status'] = 'success';
        }else{
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    
    function admin_view_user_detail(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        
        $uacc_id = $this->input->get('u');
        $page = $this->input->get('page');
        $this->data['page'] = $page;
        //user detail
        $user_detail = $this->far_users->get_user('uacc_id', $uacc_id);
        $this->data['user_detail'] = $user_detail;
        
        $user_profile = $this->far_users->get_profile('uacc_id', $user_detail['uacc_id']);
        $this->data['user_profile'] = $user_profile;
        
        if($page == "edit_basic_info"){
            $this->load->view('users/admin_view_user_detail/edit_basic_info', $this->data);
        }elseif($page == 'user_profile'){
            
            
            $list_all_user_department = $this->far_users->list_all_user_department();
            $this->data['list_all_user_department'] = $list_all_user_department;
            
            $list_all_user_designation = $this->far_users->list_all_user_designation();
            $this->data['list_all_user_designation'] = $list_all_user_designation;
            
            $list_all_user_role = $this->far_users->list_all_user_role();
            $this->data['list_all_user_role'] = $list_all_user_role;
            
            
            $this->load->view('users/admin_view_user_detail/user_profile', $this->data);
        }else{
            $this->load->view('users/admin_view_user_detail/dashboard', $this->data);
        }
    }
    
    function admin_view_student_detail(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        
        $uacc_id = $this->input->get('u');
        $page = $this->input->get('page');
        $this->data['page'] = $page;
        //user detail
        $user_detail = $this->far_users->get_user('uacc_id', $uacc_id);
        $this->data['user_detail'] = $user_detail;
        
        $user_profile = $this->far_users->get_profile('uacc_id', $user_detail['uacc_id']);
        $this->data['user_profile'] = $user_profile;
        
        if($page == "edit_basic_info"){
            $this->load->view('users/admin_view_student_detail/edit_basic_info', $this->data);
        }elseif($page == 'user_profile'){
            
            
            $list_all_user_department = $this->far_users->list_all_user_department();
            $this->data['list_all_user_department'] = $list_all_user_department;
            
            $list_all_user_designation = $this->far_users->list_all_user_designation();
            $this->data['list_all_user_designation'] = $list_all_user_designation;
            
            $list_all_user_role = $this->far_users->list_all_user_role();
            $this->data['list_all_user_role'] = $list_all_user_role;
            
            
            $this->load->view('users/admin_view_student_detail/user_profile', $this->data);
        }else{
            $this->load->view('users/admin_view_student_detail/dashboard', $this->data);
        }
    }
    
    function admin_ajax_update_student(){
        $postdata = $this->input->post('postdata');
        
        $error = array();
        $output = array();
        
        //school name
        if(strlen($postdata['fullname']) <= 2){
            $error['fullname'] = "Fullname number must be more than 2 character";
        }
        
        $list_of_user_department_id_in_array = $this->far_setting->list_of_user_department_id_in_array();
        if(!in_array($postdata['user_department_id'], $list_of_user_department_id_in_array)){
            $error['user_department_id'] = "Please select department";
        }
        

        
        $uacc_id = $postdata['uacc_id'];

    
        if(count($error) == 0){
            
            $user_detail = $this->far_users->get_user('uacc_id', $uacc_id);
            $user_profile = $this->far_users->get_profile('uacc_id', $uacc_id);
            
            $log_data = array();
            $log_data['uacc_id'] = $user_detail['uacc_id'];
            
            if($user_profile['fullname'] != $postdata['fullname']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'fullname', $postdata['fullname']);
                $log_data['fullname']['then'] = $user_profile['fullname'];
                $log_data['fullname']['now'] = $postdata['fullname'];
            }
            
            if($user_detail['mykid'] != $postdata['mykid']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'mykid', $postdata['mykid']);
                $log_data['mykid']['then'] = $user_detail['mykid'];
                $log_data['mykid']['now'] = $postdata['mykid'];
            }
            
            if($user_detail['address'] != $postdata['address']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'address', $postdata['address']);
                $log_data['address']['then'] = $user_detail['address'];
                $log_data['address']['now'] = $postdata['address'];
            }
            if($user_detail['date_of_birth'] != $postdata['date_of_birth']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'date_of_birth', $postdata['date_of_birth']);
                $log_data['date_of_birth']['then'] = $user_detail['date_of_birth'];
                $log_data['date_of_birth']['now'] = $postdata['date_of_birth'];
            }
            
            
            
            
            
            
            if($user_detail['tarikh_masuk_taska'] != $postdata['tarikh_masuk_taska']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'tarikh_masuk_taska', $postdata['tarikh_masuk_taska']);
                $log_data['tarikh_masuk_taska']['then'] = $user_detail['tarikh_masuk_taska'];
                $log_data['tarikh_masuk_taska']['now'] = $postdata['tarikh_masuk_taska'];
            }
            if($user_detail['nama_ibu'] != $postdata['nama_ibu']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'nama_ibu', $postdata['nama_ibu']);
                $log_data['nama_ibu']['then'] = $user_detail['nama_ibu'];
                $log_data['nama_ibu']['now'] = $postdata['nama_ibu'];
            }
            if($user_detail['no_tel_ibu'] != $postdata['no_tel_ibu']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'no_tel_ibu', $postdata['no_tel_ibu']);
                $log_data['no_tel_ibu']['then'] = $user_detail['no_tel_ibu'];
                $log_data['no_tel_ibu']['now'] = $postdata['no_tel_ibu'];
            }
            
            if($user_detail['pekerjaan_ibu'] != $postdata['pekerjaan_ibu']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'pekerjaan_ibu', $postdata['pekerjaan_ibu']);
                $log_data['pekerjaan_ibu']['then'] = $user_detail['pekerjaan_ibu'];
                $log_data['pekerjaan_ibu']['now'] = $postdata['pekerjaan_ibu'];
            }
            if($user_detail['nama_bapa'] != $postdata['nama_bapa']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'nama_bapa', $postdata['nama_bapa']);
                $log_data['nama_bapa']['then'] = $user_detail['nama_bapa'];
                $log_data['nama_bapa']['now'] = $postdata['nama_bapa'];
            }
            if($user_detail['no_tel_bapa'] != $postdata['no_tel_bapa']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'no_tel_bapa', $postdata['no_tel_bapa']);
                $log_data['no_tel_bapa']['then'] = $user_detail['no_tel_bapa'];
                $log_data['no_tel_bapa']['now'] = $postdata['no_tel_bapa'];
            }
            if($user_detail['pekerjaan_bapa'] != $postdata['pekerjaan_bapa']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'pekerjaan_bapa', $postdata['pekerjaan_bapa']);
                $log_data['pekerjaan_bapa']['then'] = $user_detail['pekerjaan_bapa'];
                $log_data['pekerjaan_bapa']['now'] = $postdata['pekerjaan_bapa'];
            }
            if($user_detail['nama_kecemasan'] != $postdata['nama_kecemasan']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'nama_kecemasan', $postdata['nama_kecemasan']);
                $log_data['nama_kecemasan']['then'] = $user_detail['nama_kecemasan'];
                $log_data['nama_kecemasan']['now'] = $postdata['nama_kecemasan'];
            }
            if($user_detail['tarikh_tamat_taska'] != $postdata['tarikh_tamat_taska']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'tarikh_tamat_taska', $postdata['tarikh_tamat_taska']);
                $log_data['tarikh_tamat_taska']['then'] = $user_detail['tarikh_tamat_taska'];
                $log_data['tarikh_tamat_taska']['now'] = $postdata['tarikh_tamat_taska'];
            }
            if($user_detail['guru_kelas_uacc_id'] != $postdata['guru_kelas_uacc_id']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'guru_kelas_uacc_id', $postdata['guru_kelas_uacc_id']);
                $log_data['guru_kelas_uacc_id']['then'] = $user_detail['guru_kelas_uacc_id'];
                $log_data['guru_kelas_uacc_id']['now'] = $postdata['guru_kelas_uacc_id'];
            }
            if($user_detail['user_status'] != $postdata['user_status']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'user_status', $postdata['user_status']);
                $log_data['user_status']['then'] = $user_detail['user_status'];
                $log_data['user_status']['now'] = $postdata['user_status'];
            }
            
            if($user_profile['user_department_id'] != $postdata['user_department_id']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_department_id', $postdata['user_department_id']);
                $log_data['user_department_id']['then'] = $user_profile['user_department_id'];
                $log_data['user_department_id']['now'] = $postdata['user_department_id'];
            }
            if($user_profile['user_designation_id'] != $postdata['user_designation_id']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_designation_id', $postdata['user_designation_id']);
                $log_data['user_designation_id']['then'] = $user_profile['user_designation_id'];
                $log_data['user_designation_id']['now'] = $postdata['user_designation_id'];
            }
            if($user_profile['user_role_id'] != $postdata['user_role_id']){
               $this->far_users->update_profile('uacc_id', $uacc_id, 'user_role_id', $postdata['user_role_id']);
                $log_data['user_role_id']['then'] = $user_profile['user_role_id'];
                $log_data['user_role_id']['now'] = $postdata['user_role_id'];
            }
            if($user_profile['email'] != $postdata['email']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'email', $postdata['email']);
                $log_data['email']['then'] = $user_profile['email'];
                $log_data['email']['now'] = $postdata['email'];
            }
            if($user_profile['mobile_number'] != $postdata['mobile_number']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $postdata['mobile_number']);
                $log_data['mobile_number']['then'] = $user_profile['mobile_number'];
                $log_data['mobile_number']['now'] = $postdata['mobile_number'];
            }
            
            
            if($user_detail['badge_no'] != $postdata['badge_no']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'badge_no', $postdata['badge_no']);
                $log_data['badge_no']['then'] = $user_profile['badge_no'];
                $log_data['badge_no']['now'] = $postdata['badge_no'];
            }
            
            
            $this->far_log->insert($this->user['uacc_id'], 'cms_edit_user_profile', $log_data);
            
           
            
            
            $output['status'] = 'success';
        }else{
            
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    
    
    
    function admin_ajax_update_user(){
        $postdata = $this->input->post('postdata');
        
        $error = array();
        $output = array();
        
        //school name
        if(strlen($postdata['fullname']) <= 2){
            $error['fullname'] = "Machine number must be more than 2 character";
        }
        
        
        
        $list_of_user_department_id_in_array = $this->far_setting->list_of_user_department_id_in_array();
        if(!in_array($postdata['user_department_id'], $list_of_user_department_id_in_array)){
            $error['user_department_id'] = "Please select department";
        }
        
        
        $list_of_user_role_id_in_array = $this->far_setting->list_of_user_role_id_in_array();
        if(!in_array($postdata['user_role_id'], $list_of_user_role_id_in_array)){
            $error['user_role_id'] = "Please select user role";
        }

        
        $uacc_id = $postdata['uacc_id'];

    
        if(count($error) == 0){
            
            $user_detail = $this->far_users->get_user('uacc_id', $uacc_id);
            $user_profile = $this->far_users->get_profile('uacc_id', $uacc_id);
            
            $log_data = array();
            $log_data['uacc_id'] = $user_detail['uacc_id'];
            
            if($user_profile['fullname'] != $postdata['fullname']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'fullname', $postdata['fullname']);
                $log_data['fullname']['then'] = $user_profile['fullname'];
                $log_data['fullname']['now'] = $postdata['fullname'];
            }
            
            if($user_detail['nric'] != $postdata['nric']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'nric', $postdata['nric']);
                $log_data['nric']['then'] = $user_detail['nric'];
                $log_data['nric']['now'] = $postdata['nric'];
            }
            
            if($user_detail['address'] != $postdata['address']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'address', $postdata['address']);
                $log_data['address']['then'] = $user_detail['address'];
                $log_data['address']['now'] = $postdata['address'];
            }
            if($user_detail['date_of_birth'] != $postdata['date_of_birth']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'date_of_birth', $postdata['date_of_birth']);
                $log_data['date_of_birth']['then'] = $user_detail['date_of_birth'];
                $log_data['date_of_birth']['now'] = $postdata['date_of_birth'];
            }
            if($user_detail['start_working_date'] != $postdata['start_working_date']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'start_working_date', $postdata['start_working_date']);
                $log_data['start_working_date']['then'] = $user_detail['start_working_date'];
                $log_data['start_working_date']['now'] = $postdata['start_working_date'];
            }
            if($user_detail['user_status'] != $postdata['user_status']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'user_status', $postdata['user_status']);
                $log_data['user_status']['then'] = $user_detail['user_status'];
                $log_data['user_status']['now'] = $postdata['user_status'];
            }
            if($user_detail['end_working_date'] != $postdata['end_working_date']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'end_working_date', $postdata['end_working_date']);
                $log_data['end_working_date']['then'] = $user_detail['end_working_date'];
                $log_data['end_working_date']['now'] = $postdata['end_working_date'];
            }
            
            
            
            if($user_profile['user_department_id'] != $postdata['user_department_id']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_department_id', $postdata['user_department_id']);
                $log_data['user_department_id']['then'] = $user_profile['user_department_id'];
                $log_data['user_department_id']['now'] = $postdata['user_department_id'];
            }
            if($user_profile['user_designation_id'] != $postdata['user_designation_id']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_designation_id', $postdata['user_designation_id']);
                $log_data['user_designation_id']['then'] = $user_profile['user_designation_id'];
                $log_data['user_designation_id']['now'] = $postdata['user_designation_id'];
            }
            if($user_profile['user_role_id'] != $postdata['user_role_id']){
               $this->far_users->update_profile('uacc_id', $uacc_id, 'user_role_id', $postdata['user_role_id']);
                $log_data['user_role_id']['then'] = $user_profile['user_role_id'];
                $log_data['user_role_id']['now'] = $postdata['user_role_id'];
            }
            if($user_profile['email'] != $postdata['email']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'email', $postdata['email']);
                $log_data['email']['then'] = $user_profile['email'];
                $log_data['email']['now'] = $postdata['email'];
            }
            if($user_profile['mobile_number'] != $postdata['mobile_number']){
                $this->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $postdata['mobile_number']);
                $log_data['mobile_number']['then'] = $user_profile['mobile_number'];
                $log_data['mobile_number']['now'] = $postdata['mobile_number'];
            }
            
            
            if($user_detail['badge_no'] != $postdata['badge_no']){
                $this->far_users->update_user('uacc_id', $uacc_id, 'badge_no', $postdata['badge_no']);
                $log_data['badge_no']['then'] = $user_profile['badge_no'];
                $log_data['badge_no']['now'] = $postdata['badge_no'];
            }
            
            
            $this->far_log->insert($this->user['uacc_id'], 'cms_edit_user_profile', $log_data);
            
           
            
            
            $output['status'] = 'success';
        }else{
            
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    
    
    
    function modal_add_new_user(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        
        $list_all_user_department = $this->far_users->list_all_user_department();
        $this->data['list_all_user_department'] = $list_all_user_department;

        
        $list_all_user_designation = $this->far_users->list_all_user_designation();
        $this->data['list_all_user_designation'] = $list_all_user_designation;
        
        $list_all_user_role = $this->far_users->list_all_user_role();
        $this->data['list_all_user_role'] = $list_all_user_role;
        
        $this->load->view('users/admin/modal_add_new_user', $this->data);
    }
    function ajax_admin_create_new_user(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        
        //check username
        if(!preg_match('/^[a-z0-9_]+$/', strtolower($postdata['add_uacc_username']))){
            $error['add_uacc_username'] = "Username contain invalid character. Only a~z and 0~9 are allowed";
        }
        
        //add_uacc_username
        if(strlen($postdata['add_uacc_username']) < 3){
            $error['add_uacc_username'] = "Username must be more than 3 character";
        }
        //check if username already exists
        if($this->far_users->is_username_exists($postdata['add_uacc_username'])){
            $error['add_uacc_username'] = "Username already exists. Please try using different username";
        }
        
        if(strlen($postdata['add_fullname']) <= 3){
            $error['add_fullname'] = "Fullname must be more than 3 character";
        }
        
        if(strlen($postdata['add_nric']) <= 3){
            $error['add_nric'] = "NRIC must be more than 3 character";
        }
        
        if(strlen($postdata['add_address']) <= 3){
            $error['add_address'] = "Address must be more than 3 character";
        }
        
        if(strlen($postdata['add_date_of_birth']) <= 3){
            $error['add_date_of_birth'] = "Date of Birth must be more than 3 character";
        }
        
        if(strlen($postdata['add_start_working_date']) <= 3){
            $error['add_start_working_date'] = "Start Working Date must be more than 3 character";
        }
        
        if(strlen($postdata['add_user_status']) <= 3){
            $error['add_user_status'] = "User Status must be more than 3 character";
        }
        
        if(strlen($postdata['add_end_working_date']) <= 3){
            //$error['add_end_working_date'] = "End Working Date must be more than 3 character";
        }
        
        
        //department
        $allowed_user_department_id = $this->far_users->list_user_department_id_in_array();
        if(!in_array($postdata['add_user_department_id'], $allowed_user_department_id)){
            $error['add_user_department_id'] = "Please select department";
        }
        
        
        //user_role
        $allowed_user_role_id = $this->far_users->list_user_role_id_in_array();
        if(!in_array($postdata['add_user_role_id'], $allowed_user_role_id)){
            $error['add_user_role_id'] = "Please select User Role";
        }
        

        //email must be unique
        $autocreated_email = mt_rand(111111, 999999).'@nms.tpirs.net';
        
        
        $minLengthPassword = $this->flexi_auth->min_password_length();
        if(strlen($postdata['add_uacc_raw_password']) < $minLengthPassword){
            $error['add_uacc_raw_password'] = "Your password must be at least ".$minLengthPassword." characters";
        }
        //chack valid or not
        if(!$this->flexi_auth->valid_password_chars($postdata['add_uacc_raw_password'])){
            $error['add_uacc_raw_password'] = "Password not valid. Please try again";
        }
        
        if(count($error) == 0){
            //create user
            $email = $autocreated_email;
            $username = $postdata['add_uacc_username'];
            $password = $postdata['add_uacc_raw_password'];
            //$password = '12345678';
            $user_data = array();
            $group_id = 4;
            $activate = TRUE;
            $uacc_id = $this->flexi_auth->insert_user($email, $username, $password, $user_data, $group_id, $activate);
            if($uacc_id){
                $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_raw_password', $password);
                //force_change_password
                $this->far_users->update_user('uacc_id', $uacc_id, 'force_change_password', 'yes');
                
                $this->far_users->update_user('uacc_id', $uacc_id, 'nric', $postdata['add_nric']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'address', $postdata['add_address']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'date_of_birth', $postdata['add_date_of_birth']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'start_working_date', $postdata['add_start_working_date']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'user_status', $postdata['add_user_status']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'end_working_date', $postdata['add_end_working_date']);
                
                //update profile
                $this->far_users->update_profile('uacc_id', $uacc_id, 'fullname', $postdata['add_fullname']);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'email', $email);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $postdata['add_phonemobile']);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'gender', $postdata['add_gender']);
                
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_department_id', $postdata['add_user_department_id']);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_designation_id', $postdata['add_user_designation_id']);
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_role_id', $postdata['add_user_role_id']);
                
                //default profile pic
                $profile_pic_url = $this->far_meta->get_value('default_profile_picture');
                $this->far_users->update_profile('uacc_id', $uacc_id, 'profile_picture_url', $profile_pic_url);
                
                
                
                $log_data = array();
                $log_data['new_user_uacc_id'] = $uacc_id;
                $log_data['user_detail'] = array(
                    'fullname' => $postdata['add_fullname'],
                    'badge_no' => $postdata['add_badge_no']
                );
                $this->far_log->insert($this->user['uacc_id'], 'cms_admin_create_new_user', $log_data);
                
                
                $output['uacc_id'] = $uacc_id;
                $output['status'] = 'success';
            }else{
                $error['message_single'] = "New user creation failed. Please contact administrator";
                $output['status'] = 'error';
            }
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    
    function modal_add_new_student(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        
        $list_all_user_department = $this->far_users->list_all_user_department();
        $this->data['list_all_user_department'] = $list_all_user_department;

        
        $list_all_user_designation = $this->far_users->list_all_user_designation();
        $this->data['list_all_user_designation'] = $list_all_user_designation;
        
        $list_all_user_role = $this->far_users->list_all_user_role();
        $this->data['list_all_user_role'] = $list_all_user_role;
        
        $this->load->view('users/admin/modal_add_new_student', $this->data);
    }
    function ajax_admin_create_new_student(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        
        //check username
        if(!preg_match('/^[a-z0-9_]+$/', strtolower($postdata['uacc_username']))){
            $error['uacc_username'] = "Username contain invalid character. Only a~z and 0~9 are allowed";
        }
        
        //uacc_username
        if(strlen($postdata['uacc_username']) < 3){
            $error['uacc_username'] = "Username must be more than 3 character";
        }
        //check if username already exists
        if($this->far_users->is_username_exists($postdata['uacc_username'])){
            $error['uacc_username'] = "Username already exists. Please try using different username";
        }
        
        if(strlen($postdata['fullname']) <= 3){
            $error['fullname'] = "Fullname must be more than 3 character";
        }
        
        if(strlen($postdata['mykid']) <= 3){
            $error['mykid'] = "MYKID must be more than 3 character";
        }
        
        if(strlen($postdata['address']) <= 3){
            $error['address'] = "Address must be more than 3 character";
        }
        
        if(strlen($postdata['date_of_birth']) <= 3){
            $error['date_of_birth'] = "Date of Birth must be more than 3 character";
        }
        
        if(strlen($postdata['tarikh_masuk_taska']) <= 3){
            $error['tarikh_masuk_taska'] = "Tarikh Masuk Taska must be more than 3 character";
        }
        
        if(strlen($postdata['nama_ibu']) <= 3){
            $error['nama_ibu'] = "Nama Ibu must be more than 3 character";
        }
        if(strlen($postdata['no_tel_ibu']) <= 3){
            $error['no_tel_ibu'] = "No Tel Ibu must be more than 3 character";
        }
        if(strlen($postdata['pekerjaan_ibu']) <= 3){
            $error['pekerjaan_ibu'] = "Pekerjaan Ibu must be more than 3 character";
        }
        
        if(strlen($postdata['nama_bapa']) <= 3){
            $error['nama_bapa'] = "Nama Bapa must be more than 3 character";
        }
        if(strlen($postdata['no_tel_bapa']) <= 3){
            $error['no_tel_bapa'] = "No Tel Bapa must be more than 3 character";
        }
        if(strlen($postdata['pekerjaan_bapa']) <= 3){
            $error['pekerjaan_bapa'] = "Pekerjaan Bapa must be more than 3 character";
        }
        
        if(strlen($postdata['nama_kecemasan']) <= 3){
            $error['nama_kecemasan'] = "Nama Kecemasan must be more than 3 character";
        }
        if(strlen($postdata['no_kecemasan']) <= 3){
            $error['no_kecemasan'] = "No Kecemasan must be more than 3 character";
        }
        if(strlen($postdata['tarikh_tamat_taska']) <= 3){
            //$error['tarikh_tamat_taska'] = "Tarikh Tamat Taska must be more than 3 character";
        }
        
        if(strlen($postdata['user_status']) <= 3){
            $error['user_status'] = "User Status must be more than 3 character";
        }
        
        if(strlen($postdata['guru_kelas_uacc_id']) < 1){
            $error['guru_kelas_uacc_id'] = "Sila pilih guru kelas";
        }
        
        //department
        $allowed_user_department_id = $this->far_users->list_user_department_id_in_array();
        if(!in_array($postdata['user_department_id'], $allowed_user_department_id)){
            $error['user_department_id'] = "Please select department";
        }

        

        //email must be unique
        $autocreated_email = mt_rand(111111, 999999).'@nms.tpirs.net';
        
        
        $minLengthPassword = $this->flexi_auth->min_password_length();
        if(strlen($postdata['uacc_raw_password']) < $minLengthPassword){
            $error['uacc_raw_password'] = "Your password must be at least ".$minLengthPassword." characters";
        }
        //chack valid or not
        if(!$this->flexi_auth->valid_password_chars($postdata['uacc_raw_password'])){
            $error['uacc_raw_password'] = "Password not valid. Please try again";
        }
        
        if(count($error) == 0){
            //create user
            $email = $autocreated_email;
            $username = $postdata['uacc_username'];
            $password = $postdata['uacc_raw_password'];
            //$password = '12345678';
            $user_data = array();
            $group_id = 5;
            $activate = TRUE;
            $uacc_id = $this->flexi_auth->insert_user($email, $username, $password, $user_data, $group_id, $activate);
            if($uacc_id){
                $this->far_users->update_user('uacc_id', $uacc_id, 'uacc_raw_password', $password);
                //force_change_password
                $this->far_users->update_user('uacc_id', $uacc_id, 'force_change_password', 'yes');
                
                $this->far_users->update_user('uacc_id', $uacc_id, 'mykid', $postdata['mykid']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'address', $postdata['address']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'date_of_birth', $postdata['date_of_birth']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'tarikh_masuk_taska', $postdata['tarikh_masuk_taska']);
                
                $this->far_users->update_user('uacc_id', $uacc_id, 'nama_ibu', $postdata['nama_ibu']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'no_tel_ibu', $postdata['no_tel_ibu']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'pekerjaan_ibu', $postdata['pekerjaan_ibu']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'nama_bapa', $postdata['nama_bapa']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'no_tel_bapa', $postdata['no_tel_bapa']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'pekerjaan_bapa', $postdata['pekerjaan_bapa']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'nama_kecemasan', $postdata['nama_kecemasan']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'no_kecemasan', $postdata['no_kecemasan']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'guru_kelas_uacc_id', $postdata['guru_kelas_uacc_id']);
                
                
                $this->far_users->update_user('uacc_id', $uacc_id, 'user_status', $postdata['user_status']);
                $this->far_users->update_user('uacc_id', $uacc_id, 'tarikh_tamat_taska', $postdata['tarikh_tamat_taska']);
                
                //update profile
                $this->far_users->update_profile('uacc_id', $uacc_id, 'fullname', $postdata['fullname']);

                
                $this->far_users->update_profile('uacc_id', $uacc_id, 'user_department_id', $postdata['user_department_id']);

                
                //default profile pic
                $profile_pic_url = $this->far_meta->get_value('default_profile_picture');
                $this->far_users->update_profile('uacc_id', $uacc_id, 'profile_picture_url', $profile_pic_url);
                
                
                
                $log_data = array();
                $log_data['new_user_uacc_id'] = $uacc_id;
                $log_data['user_detail'] = array(
                    'fullname' => $postdata['fullname'],
                    'badge_no' => $postdata['badge_no']
                );
                $this->far_log->insert($this->user['uacc_id'], 'cms_admin_create_new_user', $log_data);
                
                
                $output['uacc_id'] = $uacc_id;
                $output['status'] = 'success';
            }else{
                $error['message_single'] = "New user creation failed. Please contact administrator";
                $output['status'] = 'error';
            }
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    
    function ajax_admin_force_reset_password(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $output = array();
        $error = array();
        $postdata = $this->input->post("postdata");
        
        $user_detail = $this->far_users->get_user_detail_from_view($postdata['uacc_id']);
        if(count($user_detail) == 0){
            $error['uacc_id'] = "User not exists";
        }
        
        if(count($error) == 0){
            
            $change_password = $this->flexi_auth_model->change_password_new($user_detail['uacc_id'], 'welcome123');
            if($change_password){
                $this->far_users->update_user('uacc_id', $user_detail['uacc_id'], 'uacc_raw_password', 'welcome123');
                $this->far_users->update_user('uacc_id', $user_detail['uacc_id'], 'force_change_password', 'yes');
                $this->far_users->update_user('uacc_id', $user_detail['uacc_id'], 'mobile_token', '');
                
                $output['message'] = "Password for ".$user_detail['uacc_username']." has been reset to welcome123.";
                $output['status'] = "success";
                
            }else{
                $output['errors'] = $error;
                $output['error_message_single'] = current($error);
                $output['status'] = 'error';
            }
            
            
        }else{
            $output['errors'] = $error;
            $output['error_message_single'] = current($error);
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    
    
    
    
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */