<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_product extends MY_Controller
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
    function datatable_admin_list_all_product()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        //echo "<pre>"; print_r($this->far_auth->pages); exit();
        $this->load->view('admin_product/admin/datatable_admin_list_all_product', $this->data);
    }
    function ajax_datatable_admin_list_all_product()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');
        $uacc_created_by = $this->user['uacc_id'];
        $this->datatables->select('u.product_id');
        $this->datatables->select('u.product_name');

        $this->datatables->select('u.sku');
        $this->datatables->select('u.price_normal');
        $this->datatables->select('u.price_member');
        $this->datatables->select('u.main_category');
        $this->datatables->select('u.product_image_fullurl');
        $this->datatables->select('u.total_stock_in');
        $this->datatables->select('u.total_stock_out');
        $this->datatables->select('u.current_stock');
        $this->datatables->select('u.create_dttm');
        $this->datatables->from('view_product_list u');
        $output = $this->datatables->generate();
        echo $output;
    }
    function admin_view_product_detail(){
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $product_id = $this->input->get('product_id');
        $page = $this->input->get('page');
        $this->data['page'] = $page;
        $product_detail = $this->far_product->get_product_detail($product_id);
        $this->data['product_detail'] = $product_detail;

        $this->data['user_detail'] = $this->user;

        if($page == "product_detail"){
            $this->load->view('admin_product/admin_view_product_detail/product_detail', $this->data);
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
    function admin_ajax_update_product(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['product_name']) < 1){
            $error['product_name'] = "Product Name must be more than 2 character";
        }
        if(strlen($postdata['price_normal']) < 1){
            $error['price_normal'] = "Price must be more than 2 character";
        }
        if(strlen($postdata['price_member']) < 1){
            $error['price_member'] = "Price must be more than 2 character";
        }
        if(count($error) == 0){
            $product_detail = $this->far_product->get_product_detail($postdata['product_id']);
            $log_data = array();
            $log_data['uacc_id'] = $this->user['uacc_id'];
            if($product_detail['product_name'] != $postdata['product_name']){
                $this->far_product->update_product_detail('product_id', $product_detail['product_id'], 'product_name', $postdata['product_name']);
                $log_data['product_name']['then'] = $product_detail['product_name'];
                $log_data['product_name']['now'] = $postdata['product_name'];
            }
            if($product_detail['price_normal'] != $postdata['price_normal']){
                $this->far_product->update_product_detail('product_id', $product_detail['product_id'], 'price_normal', $postdata['price_normal']);
                $log_data['price_normal']['then'] = $product_detail['price_normal'];
                $log_data['price_normal']['now'] = $postdata['price_normal'];
            }
            if($product_detail['price_member'] != $postdata['price_member']){
                $this->far_product->update_product_detail('product_id', $product_detail['product_id'], 'price_member', $postdata['price_member']);
                $log_data['price_member']['then'] = $product_detail['price_member'];
                $log_data['price_member']['now'] = $postdata['price_member'];
            }
            if($product_detail['main_category'] != $postdata['main_category']){
                $this->far_product->update_product_detail('product_id', $product_detail['product_id'], 'main_category', $postdata['main_category']);
                $log_data['main_category']['then'] = $product_detail['main_category'];
                $log_data['main_category']['now'] = $postdata['main_category'];
            }
            if($product_detail['sku'] != $postdata['sku']){
                $this->far_product->update_product_detail('product_id', $product_detail['product_id'], 'sku', $postdata['sku']);
                $log_data['sku']['then'] = $product_detail['sku'];
                $log_data['sku']['now'] = $postdata['sku'];
            }
            if($product_detail['product_description'] != $postdata['product_description']){
                $this->far_product->update_product_detail('product_id', $product_detail['product_id'], 'product_description', $postdata['product_description']);
                $log_data['product_description']['then'] = $product_detail['product_description'];
                $log_data['product_description']['now'] = $postdata['product_description'];
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
    function admin_ajax_add_product(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['product_name']) <= 2){
            $error['product_name'] = "Product Name must be more than 2 character";
        }
        if(count($error) == 0){
            $insert_data = array(
                'product_name' => $postdata['product_name'],
                'create_dttm' => date("Y-m-d H:i:s"),
                'product_status' => 'active'
            );
            $this->db->insert('product_detail', $insert_data);
            $product_id = $this->db->insert_id();
            $output['redirect_url'] = base_url()."admin_product/admin_view_product_detail/?page=product_detail&product_id=".$product_id;
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
    function ajax_admin_delete_product(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            $this->far_product->update_product_detail('product_id', $postdata['product_id'], 'product_status', 'deleted');
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
    function admin_ajax_add_stock_list(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['quantity']) < 1){
            $error['add_stock_quantity'] = "Quantity must be more than 0";
        }
        if(strlen($postdata['remarks']) < 2){
            $error['add_stock_remarks'] = "Remarks must be more than 3 characters";
        }
        if(count($error) == 0){
            $insert_data = array(
                'product_id' => $postdata['product_id'],
                'remarks' => $postdata['remarks'],
                'quantity' => $postdata['quantity'],
                'create_dttm' => date("Y-m-d H:i:s"),
                'created_by_uacc_id' => $this->user['uacc_id']
            );
            $this->db->insert('product_stock', $insert_data);
            $product_id = $this->db->insert_id();
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function ajax_dashboard_product_insight(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');

        $product_detail = $this->far_product->get_product_detail($postdata['product_id']);
        $this->data['product_detail'] = $product_detail;

        $this->load->view('admin_product/admin/ajax_dashboard_product_insight', $this->data);
    }

    function product_transaction(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $filter_year = $this->input->get('filter_year') ?? date("Y");
        $filter_month = $this->input->get('filter_month') ?? date("m");
        $filter_product_id = $this->input->get('filter_product_id') ?? 0;
        $product_id = $this->input->get('product_id');

        $this->data['filter_year'] = $filter_year;
        $this->data['filter_month'] = $filter_month;
        $this->data['filter_product_id'] = $filter_product_id;

        $list_attendance = [];
        $list_attendance_all = [];
        $final_list = [];
        if($filter_product_id != 'all' && $filter_product_id == 0){
            $this->data['error_message'] = "Please select Date & Staff";
        }else{
            if($filter_product_id == 'all'){
                $query = $this->db->query("SELECT * FROM view_stock_list ORDER BY create_dttm DESC");
            }else{
                $query = $this->db->query("SELECT * FROM view_stock_list WHERE product_id='".$filter_product_id."' ORDER BY create_dttm DESC");
            }
            if($query->num_rows() > 0){
                $list_attendance = $query->result_array();
            }

            if(count($list_attendance) > 0){
                //sorting
                foreach ($list_attendance as $key => $item) {
                    $list_attendance_all[$item['product_id']][$key] = $item;
                }

                ksort($list_attendance_all, SORT_NUMERIC);
            }
        }

        if(count($list_attendance_all) > 0){
            foreach($list_attendance_all as $a => $b){
                $total_pay_for_month = 0;
                $product_detail = $this->far_product->get_product_detail($a);
                foreach($b as $c => $d){

                }



                $final_list[] = [
                    'product_detail' => $product_detail,
                    'list_transaction' => $b,
                    'total_pay' => $total_pay_for_month,
                    'attendance_month' => strtoupper(date("F Y", strtotime($filter_year."-".$filter_month)))
                ];
            }
        }

        $this->data['final_list'] = $final_list;


        $this->load->view('admin_product/admin/product_transaction', $this->data);
    }
    function ajax_admin_delete_product_stock_id(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        //check id
        $product_stock_detail = $this->far_stock->get_product_stock_detail($postdata['product_stock_id']);
        if(count($product_stock_detail) < 3){
            $error['product_stock_id'] = "Stock error. Please refer to developer";
        }

        if(count($error) == 0){
            $this->db->where('product_stock_id', $postdata['product_stock_id']);
            $this->db->delete('product_stock');

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
}