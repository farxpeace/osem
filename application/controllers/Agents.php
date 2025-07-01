<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agents extends MY_Controller
{
    private $user;

    function __construct()
    {
        parent::__construct();

        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
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

        if (!$this->flexi_auth->is_logged_in_via_password() || !$this->flexi_auth->is_admin()) {
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

    public function global_pass_to_view()
    {
        $this->data['logged_in'] = $this->flexi_auth->get_user_by_identity_row_array();
        if ($this->flexi_auth->is_admin()) {
            $this->data['logged_in']['is_admin'] = true;
        }
    }

    function admin_list_all_agents(){

        $list_all_agent = $this->far_agent->list_all_agent();
        $this->data['list_all_agent'] = $list_all_agent;

        $this->load->view('agents/admin/admin_list_all_agents', $this->data);
    }
    function admin_delete_agent(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $user_detail = $this->far_agent->get_agent_detail($postdata['uacc_id']);
        if(is_array($user_detail) && count($user_detail) == 0){
            $error['user_detail'] = "User not exists";
        }else{
            if($user_detail['total_assigned_leads'] > 0){
                $error['user_detail'] = "Agent has a leads. Cannot delete";
            }
        }

        if(count($error) == 0){


            $this->far_agent->delete_agent($postdata['uacc_id']);

            $output['status'] = 'success';
        }else{
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function view_agent_detail(){
        $this->far_auth->allowed_group('3,6', $this->user['ugrp_id']);

        $agent_uacc_id = $this->input->get('uacc_id');

        $agent_detail = $this->far_agent->get_agent_detail($agent_uacc_id);
        $this->data['agent_detail'] = $agent_detail;

        $this->load->view('agents/admin/view_agent_detail', $this->data);
    }
}