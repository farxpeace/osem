<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_customer extends MY_Controller
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
    function datatable_admin_list_all_customer(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $filter_year = $this->input->get('filter_year') ?? 'all_year';
        $filter_month = $this->input->get('filter_month') ?? 'all_month';
        $filter_uacc_id = $this->input->get('filter_uacc_id') ?? 0;
        $product_id = $this->input->get('product_id');

        $this->data['filter_year'] = $filter_year;
        $this->data['filter_month'] = $filter_month;
        $this->data['filter_uacc_id'] = $filter_uacc_id;

        $this->load->view('admin_customer/admin/datatable_admin_list_all_customer', $this->data);
    }
    function ajax_datatable_admin_list_all_customer()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');
        $filter_month = $this->input->post('filter_month') ?? "all_month";
        $filter_year = $this->input->post('filter_year') ?? "all_year";

        $this->datatables->select('u.customer_id');
        $this->datatables->select('u.fullname');

        $this->datatables->select('u.mobile_number');
        $this->datatables->select('u.is_member');
        $this->datatables->select('u.create_dttm');
        $this->datatables->from('view_customer_list u');

        if($filter_month != "all_month"){
            $this->datatables->where('MONTH(u.create_dttm)', $filter_month);
        }
        if($filter_year != "all_year"){
            $this->datatables->where('YEAR(u.create_dttm)', $filter_year);
        }


        $output = $this->datatables->generate();
        echo $output;
    }
    function admin_view_customer_detail(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $customer_id = $this->input->get('customer_id');
        $page = $this->input->get('page');
        $this->data['page'] = $page;
        $customer_detail = $this->far_customer->get_customer_detail($customer_id);
        $this->data['customer_detail'] = $customer_detail;


        if($page == "customer_detail"){
            $this->load->view('admin_customer/admin_view_customer_detail/customer_detail', $this->data);
        }elseif($page == 'order_detail'){
            $filter_date_start = $this->input->get('filter_date_start') ?? date("01/m/Y");
            $filter_date_end = $this->input->get('filter_date_end') ?? date("t/m/Y");

            $filter_date_start = $this->far_date->convert($filter_date_start, "d/m/Y", "Y-m-d");
            $filter_date_end = $this->far_date->convert($filter_date_end, "d/m/Y", "Y-m-d");

            $this->data['filter_date_start'] = $filter_date_start;
            $this->data['filter_date_end'] = $filter_date_end;

            $this->data['list_sales'] = $this->far_sales->list_sales_by_daterange_and_customer_id($customer_id,$filter_date_start, $filter_date_end);
            $this->load->view('admin_customer/admin_view_customer_detail/order_detail', $this->data);
        }elseif($page == 'reserve_detail'){


            $this->load->view('admin_customer/admin_view_customer_detail/reserve_detail', $this->data);
        }else{
            $this->load->view('users/admin_view_user_detail/dashboard', $this->data);
        }
    }
    function ajax_admin_update_customer_detail(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['fullname']) <= 2){
            $error['package_name'] = "Full Name must be more than 2 character";
        }
        $mobile_number = $this->far_helper->fix_msisdn($postdata['mobile_number']);
        if(strlen($mobile_number) <= 5){
            $error['mobile_number'] = "Mobile Number must be greater than 5 digit";
        }

        $customer_detail = $this->far_customer->get_customer_detail($postdata['customer_id']);
        //print_r($customer_detail); exit();
        if(count($error) == 0){

            //print_r($customer_detail); exit();
            $log_data = array();
            $log_data['uacc_id'] = $this->user['uacc_id'];
            if($customer_detail['fullname'] != $postdata['fullname']){
                $this->far_customer->update_customer_detail('customer_id', $customer_detail['customer_id'], 'fullname', strtoupper($postdata['fullname']));
                $log_data['fullname']['then'] = $customer_detail['fullname'];
                $log_data['fullname']['now'] = $customer_detail['fullname'];
            }

            if($customer_detail['mobile_number'] != $mobile_number){
                $this->far_customer->update_customer_detail('customer_id', $customer_detail['customer_id'], 'mobile_number', $mobile_number);
                $log_data['mobile_number']['then'] = $customer_detail['mobile_number'];
                $log_data['mobile_number']['now'] = $customer_detail['mobile_number'];
            }

            if($customer_detail['is_member'] != $postdata['is_member']){
                $this->far_customer->update_customer_detail('customer_id', $customer_detail['customer_id'], 'is_member', $postdata['is_member']);
                $log_data['is_member']['then'] = $customer_detail['is_member'];
                $log_data['is_member']['now'] = $customer_detail['is_member'];
            }



            $this->far_log->insert($this->user['uacc_id'], 'cms_customer_edit', $log_data);
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_add_new_customer(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['fullname']) <= 2){
            $error['fullname'] = "Fullname Name must be more than 2 character";
        }
        $mobile_number = $this->far_helper->fix_msisdn($postdata['mobile_number']);
        if(strlen($mobile_number) <= 5){
            $error['mobile_number'] = "Mobile Number Name must be greater than 2 digits";
        }
        if(count($error) == 0){
            $insert_data = array(
                'fullname' => strtoupper($postdata['fullname']),
                'mobile_number' => $mobile_number,
                'is_member' => $postdata['is_member'],
                'create_dttm' => date("Y-m-d H:i:s")
            );
            $this->db->insert('customer_detail', $insert_data);
            $customer_id = $this->db->insert_id();
            $output['redirect_url'] = base_url()."admin_customer/admin_view_customer_detail/?page=customer_detail&customer_id=".$customer_id;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_admin_delete_customer(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        $customer_detail = $this->far_customer->get_customer_detail($postdata['customer_id']);
        if(count($error) == 0){

            //change customer fullname
            $new_fullname = "⛔ - ".$customer_detail['fullname'];
            $this->far_customer->update_customer_detail('customer_id', $postdata['customer_id'], 'fullname', $new_fullname);

            //change customer phone number
            $new_mobile_number = "deleted_".date("Y-m-d H:i:s")."_".$customer_detail['mobile_number'];
            $this->far_customer->update_customer_detail('customer_id', $postdata['customer_id'], 'mobile_number', $new_mobile_number);
            $this->far_customer->update_customer_detail('customer_id', $postdata['customer_id'], 'status', 'deleted');

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

    function ajax_dashboard_customer_insight(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');

        $customer_detail = $this->far_customer->get_customer_detail($postdata['customer_id']);
        $this->data['customer_detail'] = $customer_detail;

        $this->load->view('admin_customer/admin/ajax_dashboard_customer_insight', $this->data);
    }

    function reserve_balance_listing(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $filter_year = $this->input->get('filter_year') ?? 'all_year';
        $filter_month = $this->input->get('filter_month') ?? 'all_month';
        $filter_uacc_id = $this->input->get('filter_uacc_id') ?? 0;
        $product_id = $this->input->get('product_id');

        $this->data['filter_year'] = $filter_year;
        $this->data['filter_month'] = $filter_month;
        $this->data['filter_uacc_id'] = $filter_uacc_id;

        $this->load->view('admin_customer/admin/reserve_balance_listing', $this->data);
    }
    function ajax_datatable_reserve_balance_listing(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');
        $filter_month = $this->input->post('filter_month') ?? "all_month";
        $filter_year = $this->input->post('filter_year') ?? "all_year";

        $this->datatables->select('u.customer_id');
        $this->datatables->select('u.fullname');

        $this->datatables->select('u.mobile_number');
        $this->datatables->select('u.is_member');
        $this->datatables->select('u.create_dttm');
        $this->datatables->select('u.reserved_balance');

        $this->datatables->from('view_customer_list u');

        if($filter_month != "all_month"){
            $this->datatables->where('MONTH(u.create_dttm)', $filter_month);
        }
        if($filter_year != "all_year"){
            $this->datatables->where('YEAR(u.create_dttm)', $filter_year);
        }


        $output = $this->datatables->generate();
        echo $output;
    }
}