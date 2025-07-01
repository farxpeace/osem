<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_auth {
    private $CI;
    private $user;
    private $pages;
    private $current_group_id;
    private $is_allowed;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function allowed_group($allowed_groups, $ugrp_id){
        if(!is_array($allowed_groups)){
            $allowed_x = explode(',', $allowed_groups);
            $allowed_groups = $allowed_x;
        }
        if(!in_array($ugrp_id, $allowed_groups)){
            if($this->is_ajax()){
                $output = array(
                    'status' => 'error',
                    'auth_msg' => 'You are not authorized to view this page',
                    'auth_redirect' => base_url().'auth'
                );
                echo json_encode($output);
            }else{
                // Set a custom error message.
                $this->CI->flexi_auth->set_error_message('You are not authorized to view this page', TRUE);
                $this->CI->session->set_flashdata('message', $this->CI->flexi_auth->get_messages());
                redirect('auth');
            }
            exit();
        }
    }
    function is_ajax(){
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
            return true;
        }else{
            return false;
        }
    }
}
?>
