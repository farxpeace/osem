<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_package extends MY_Controller
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
        $this->user = $this->flexi_auth->get_user_by_identity_row_array();
        $this->user['user_profile'] = $this->far_users->get_profile('uacc_id', $this->user['uacc_id']);
        $this->global_pass_to_view();
    }
    public function global_pass_to_view()
    {
        $this->data['logged_in'] = $this->user;
        if ($this->flexi_auth->is_admin()) {
            $this->data['logged_in']['is_admin'] = true;
        }
    }
    function datatable_admin_list_all_package()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        //echo "<pre>"; print_r($this->far_auth->pages); exit();
        $this->load->view('admin_package/admin/datatable_admin_list_all_package', $this->data);
    }
    function ajax_datatable_admin_list_all_package()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');
        $uacc_created_by = $this->user['uacc_id'];
        $this->datatables->select('u.package_id');
        $this->datatables->select('u.package_name');

        $this->datatables->select('u.price_normal');
        $this->datatables->select('u.price_member');
        $this->datatables->select('u.create_dttm');
        $this->datatables->from('package_detail u');
        $output = $this->datatables->generate();
        echo $output;
    }
    function admin_view_package_detail(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $package_id = $this->input->get('package_id');
        $page = $this->input->get('page');
        $this->data['page'] = $page;
        $package_detail = $this->far_package->get_package_detail($package_id);
        $this->data['package_detail'] = $package_detail;

        $this->data['user_detail'] = $this->user;

        $this->data['list_all_product'] = $this->far_product->list_all_product();

        if($page == "package_detail"){
            $this->load->view('admin_package/admin_view_package_detail/package_detail', $this->data);
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
    function admin_ajax_update_package(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['package_name']) <= 2){
            $error['package_name'] = "Package Name must be more than 2 character";
        }
        if(strlen($postdata['price_normal']) <= 1){
            $error['price_normal'] = "Normal Price must be more than 1 digit";
        }
        if(strlen($postdata['price_member']) <= 1){
            $error['price_member'] = "Member Price must be more than 1 digit";
        }
        if(count($error) == 0){
            $package_detail = $this->far_package->get_package_detail($postdata['package_id']);
            $log_data = array();
            $log_data['uacc_id'] = $this->user['uacc_id'];
            if($package_detail['package_name'] != $postdata['package_name']){
                $this->far_package->update_package_detail('package_id', $package_detail['package_id'], 'package_name', $postdata['package_name']);
                $log_data['package_name']['then'] = $package_detail['package_name'];
                $log_data['package_name']['now'] = $postdata['package_name'];
            }

            if($package_detail['price_normal'] != $postdata['price_normal']){
                $this->far_package->update_package_detail('package_id', $package_detail['package_id'], 'price_normal', $postdata['price_normal']);
                $log_data['price_normal']['then'] = $package_detail['price_normal'];
                $log_data['price_normal']['now'] = $postdata['price_normal'];
            }

            if($package_detail['price_member'] != $postdata['price_member']){
                $this->far_package->update_package_detail('package_id', $package_detail['package_id'], 'price_member', $postdata['price_member']);
                $log_data['price_member']['then'] = $package_detail['price_member'];
                $log_data['price_member']['now'] = $postdata['price_member'];
            }

            $this->far_log->insert($this->user['uacc_id'], 'cms_package_edit', $log_data);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function admin_ajax_add_package(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['package_name']) <= 2){
            $error['package_name'] = "Package Name must be more than 2 character";
        }
        if(count($error) == 0){
            $insert_data = array(
                'package_name' => $postdata['package_name'],
                'create_dttm' => date("Y-m-d H:i:s")
            );
            $this->db->insert('package_detail', $insert_data);
            $package_id = $this->db->insert_id();
            $output['redirect_url'] = base_url()."admin_package/admin_view_package_detail/?page=package_detail&package_id=".$package_id;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_delete_package(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){

            $this->far_package->update_package_detail('package_id', $postdata['package_id'], 'status', 'deleted');


            //delete package_product
            $this->far_package->update_package_product('package_id', $postdata['package_id'], 'status', 'deleted');


            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    /** Upload */
    public function product_upload(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $product_id = $this->input->post('product_id');
        $error = array();
        $output = array();
        $config = array(
            'encrypt_name' => TRUE,
            'upload_path' => FCPATH."assets/uploads/products/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf|zip|mp4|mp3",
            'overwrite' => TRUE,
            'max_size' => "30480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
        );
        $this->load->library('upload', $config);
        if($this->upload->do_upload('upload'))
        {
            $data = array('upload_data' => $this->upload->data());
            $uploaded_data = $data['upload_data'];
            $full_url = str_replace(FCPATH,base_url(),$uploaded_data['full_path']);
            $this->far_product->update_product_detail('product_id', $product_id, 'product_image_fullurl', $full_url);
            $output['full_url'] = $full_url;
            $output['status'] = 'success';
            $output['msg'] = "Success upload";
            $output['success'] = TRUE;
        }else{
            $error = array('error' => $this->upload->display_errors());
            //$output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_delete_product_from_package(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            $this->db->where('product_id', $postdata['product_id']);
            $this->db->where('package_id', $postdata['package_id']);
            $this->db->delete('package_product');
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    /** Stock */
    function ajax_datatable_admin_list_all_stock_list()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $this->load->library('datatables');
        $uacc_created_by = $this->user['uacc_id'];
        $this->datatables->select('u.product_stock_id');
        $this->datatables->select('u.product_id');
        $this->datatables->select('u.quantity');
        $this->datatables->select('u.remarks');
        $this->datatables->select('u.create_dttm');
        $this->datatables->where('product_id', $postdata['product_id']);
        $this->datatables->from('view_stock_list u');
        $output = $this->datatables->generate();
        echo $output;
    }
    function admin_ajax_add_product_list(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        $product_detail = $this->far_product->get_product_detail($postdata['product_id']);
        if(count($product_detail) < 3){
            $error['product_id'] = "Please choose product";
        }

        if (!preg_match('/^[1-9][0-9]*$/', $postdata['quantity'])) {
            $error['quantity'] = "Please input number only";
        }

        if($postdata['quantity'] < 1){
            $error['quantity'] = "Quantity must be more than 0";
        }

        if(count($error) == 0){
            $insert_data = array(
                'package_id' => $postdata['package_id'],
                'product_id' => $product_detail['product_id'],
                'product_quantity' => $postdata['quantity'],
                'create_dttm' => date("Y-m-d H:i:s")
            );
            $this->db->insert('package_product', $insert_data);
            $product_id = $this->db->insert_id();
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function package_listing(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);

        $list_all_package = $this->far_package->list_all_package();
        $this->data['list_all_package'] = $list_all_package;

        $this->load->view('admin_package/admin/package_listing', $this->data);
    }
}