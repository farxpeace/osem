<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends MY_Controller {
    private $user;
    //private $error = array();
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
        $this->load->library('far_setting');
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
    /**
     * designation
     */
     function list_designation(){
        $this->load->view('settings/list_designation', $this->data);
    }
    function ajax_dt_list_designation(){
        $this->load->library('datatables');
        $this->datatables->select('o.user_designation_id');
        $this->datatables->select('o.user_designation_name');
        $this->datatables->select('o.create_dttm');
        $this->datatables->from('user_designation o');
        $this->datatables->where('o.user_designation_status', 'active');
        $output = $this->datatables->generate();
        echo $output;
    }
    function ajax_admin_get_designation(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $designation_detail = $this->far_setting->get_user_designation('user_designation_id', $postdata['user_designation_id']);
        //print_r($ob_scope_of_work_detail); exit();
        echo json_encode($designation_detail);
    }
    function ajax_admin_edit_designation(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        //company name
        if(strlen($postdata['edit_user_designation_name']) <= 2){
            $error['edit_user_designation_name'] = "Designantion name must be more than 3 character";
        }
        if(count($error) == 0){
            //update
            $this->far_setting->update_user_designation('user_designation_id', $postdata['edit_user_designation_id'], 'user_designation_name', $postdata['edit_user_designation_name']);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_delete_designation(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            //delete from database
            $this->far_setting->delete_user_designation($postdata['user_designation_id']);
            $output['status'] = 'success';
        }else{
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
      function ajax_admin_add_new_designation(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        //school name
        if(strlen($postdata['add_user_designation_name']) <= 2){
            $error['add_user_designation_name'] = "Description name must be more than 3 character";
        }
        if(count($error) == 0){
            //insert school
            $insert_data = array(
                'user_designation_name' => $postdata['add_user_designation_name'],
            );
            $tg_id = $this->far_setting->insert_user_designation($insert_data);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    /**
         *  Role
         */
    function list_user_role(){
        $this->load->view('settings/list_user_role', $this->data);
    }
    function ajax_dt_list_user_role(){
        $this->load->library('datatables');
        $this->datatables->select('o.user_role_id');
        $this->datatables->select('o.user_role_code');
        $this->datatables->select('o.user_role_name');
        $this->datatables->select('o.create_dttm');
        $this->datatables->from('user_role o');
        $this->datatables->where('o.user_role_status', 'active');
        $output = $this->datatables->generate();
        echo $output;
    }
    function ajax_admin_add_new_user_role(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        //school name
        if(strlen($postdata['add_user_role_name']) <= 2){
            $error['add_user_role_name'] = "Description name must be more than 3 character";
        }
        if(count($error) == 0){
            //insert school
            $insert_data = array(
                'user_role_name' => $postdata['add_user_role_name'],
                'user_role_code' => $postdata['add_user_role_code'],
            );
            $tg_id = $this->far_setting->insert_user_role($insert_data);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_delete_user_role(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            //delete from database
            $this->far_setting->delete_ob_user_role($postdata['user_role_id']);
            $output['status'] = 'success';
        }else{
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    /**
     * Department
     */
     function list_department(){
        
        $this->load->view('settings/list_department', $this->data);
    }
    function ajax_dt_list_department(){
        $this->load->library('datatables');
        $this->datatables->select('o.user_department_id');
        $this->datatables->select('o.user_department_name');
        $this->datatables->select('o.user_department_head_uacc_id');
        $this->datatables->select('o.create_dttm');
        $this->datatables->select('u.fullname');
        $this->datatables->select('u.badge_no');
        $this->datatables->from('user_department o');
        $this->datatables->join('view_user_list u', 'o.user_department_head_uacc_id=u.uacc_id', 'left');
        $this->datatables->where('o.user_department_status', 'active');
        $output = $this->datatables->generate();
        echo $output;
    }
    function ajax_admin_get_department(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $department_detail = $this->far_setting->get_user_department('user_department_id', $postdata['user_department_id']);
        //print_r($ob_scope_of_work_detail); exit();
        echo json_encode($department_detail);
    }
    function ajax_admin_edit_department(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        //company name
        if(strlen($postdata['edit_user_department_name']) <= 2){
            $error['edit_user_department_name'] = "Designantion name must be more than 3 character";
        }
        if(count($error) == 0){
            //update
            $this->far_setting->update_user_department('user_department_id', $postdata['edit_user_department_id'], 'user_department_name', $postdata['edit_user_department_name']);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_delete_department(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            //delete from database
            $this->far_setting->delete_user_department($postdata['user_department_id']);
            $output['status'] = 'success';
        }else{
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
      function ajax_admin_add_new_department(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        //school name
        if(strlen($postdata['add_user_department_name']) <= 2){
            $error['add_user_department_name'] = "Description name must be more than 3 character";
        }
        if(count($error) == 0){
            //insert school
            $insert_data = array(
                'user_department_name' => $postdata['add_user_department_name']
            );
            $tg_id = $this->far_setting->insert_user_department($insert_data);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
}
/* End of file auth.php */
/* Location: ./application/controllers/auth.php */