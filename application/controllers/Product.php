<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends MY_Controller
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
        $this->user = $this->far_users->get_user('uacc_id', $this->flexi_auth->get_user_id());
        $this->global_pass_to_view();
    }
    public function global_pass_to_view()
    {
        $this->data['logged_in'] = $this->user;
        if ($this->flexi_auth->is_admin()) {
            $this->data['logged_in']['is_admin'] = true;
        }
    }
    function add_new_stock(){
        $stock_type = $this->input->get('stock_type') ?? "stock_in";
        $this->data['stock_type'] = $stock_type;
        $this->load->view('product/user/add_new_stock', $this->data);
    }
    function stock_out(){
        $this->load->view('product/user/add_new_stock', $this->data);
    }
    function list_products_scroll(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $search_input = $this->input->get('search');
        $this->data['search_input'] = $search_input;
        $list_product = $this->far_product->list_product_pagination(0, 10, $this->input->get('main_category'), $search_input);
        $this->data['list_product'] = $list_product;
        //count total in cart
        $total_in_cart = $this->far_order->count_total_in_cart($this->user['uacc_id']);
        $this->data['total_in_cart'] = $total_in_cart;
        $this->load->view('product/sales/list_products_scroll', $this->data);
    }
    function ajax_load_product(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            $list_product = $this->far_product->list_product_pagination($postdata['start_at'], $postdata['per_page'], $postdata['main_category'], $postdata['search']);
            $output['list_product'] = $list_product;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_add_to_cart(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            $count_total_cart = $this->far_order->add_to_cart_per_user($this->user['uacc_id'], $postdata['product_id'], $postdata['quantity']);
            $output['count_total_cart'] = $count_total_cart;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function view_user_cart(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $list_added_to_cart = $this->far_order->list_user_cart($this->user['uacc_id']);
        $this->data['list_added_to_cart'] = $list_added_to_cart;
        $this->load->view('product/sales/view_user_cart', $this->data);
    }
    function ajax_select2_customer_search(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        $q = $this->input->get("q");
        if(count($error) == 0){
            $list_results = array();
            $list_customer = array();
            $query = $this->db->query("SELECT * FROM customer_detail WHERE (shipping_company LIKE '".$q."%' OR shipping_first_name LIKE '".$q."%') GROUP BY customer_id");
            if($query->num_rows() > 0){
                $list_customer = $query->result_array();
                foreach($list_customer as $a => $b){
                    $list_results[] = array(
                        'id' => $b['customer_id'],
                        'text' => $b['billing_first_name'],
                        'shipping_company' => $b['shipping_company'],
                        'customer_id' => $b['customer_id']
                    );
                }
            }
            $output['results'] = $list_results;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_remove_product_from_cart(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){
            $remove_from_cart = $this->far_order->remove_product_from_cart($postdata['cart_id'], $postdata['product_id']);
            $output['remove_from_cart'] = $remove_from_cart;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_edit_product_quantity(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(!preg_match('/[0-9]/', $postdata['quantity'])){
            $error['quantity'] = "Number only";
        }
        if(count($error) == 0){
            $remove_from_cart = $this->far_order->edit_quantity_on_cart($postdata['cart_id'], $postdata['product_id'], $postdata['quantity']);
            $output['remove_from_cart'] = $remove_from_cart;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function choose_category(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $list_all_category = $this->far_product->list_all_category();
        $this->data['list_all_category'] = $list_all_category;
        $this->load->view('product/sales/choose_category', $this->data);
    }
    function ajax_modal_product_detail(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $product_detail = $this->far_product->get_product_detail($postdata['product_id']);
        $this->data['product_detail'] = $product_detail;
        //count total in cart
        $total_in_cart = $this->far_order->count_total_in_cart($this->user['uacc_id']);
        $this->data['total_in_cart'] = $total_in_cart;
        $this->load->view('product/sales/ajax_modal_product_detail', $this->data);
    }

    function admin_ajax_add_stock(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['quantity']) < 1){
            $error['add_stock_quantity'] = "Quantity must be more than 0";
        }
        if(strlen($postdata['remarks']) < 2){
            //$error['add_stock_remarks'] = "Remarks must be more than 3 characters";
        }
        if(count($error) == 0){
            $insert_data = array(
                'product_id' => $postdata['product_id'],
                'remarks' => $postdata['remarks'],
                'quantity' => $postdata['quantity'],
                'stock_dttm' => $postdata['stock_dttm'] ?? date("Y-m-d"),
                'created_by_uacc_id' => $this->user['uacc_id'],
                'create_dttm' => date("Y-m-d H:i:s")
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

    function stock_history(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);

        $product_id = $this->input->get('product_id') ?? 0;
        $this->data['product_id'] = $product_id;

        $select_month = $this->input->get('month') ?? "all";
        $select_year = $this->input->get('year') ?? date("Y");

        $this->data['select_month'] = $select_month;
        $this->data['select_year'] = $select_year;


        if($product_id > 0){
           //$query = $this->db->
        }


        $this->load->view('product/user/stock_history', $this->data);
    }

    function ajax_frame_stock_history(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $product_detail = $this->far_product->get_product_detail($postdata['product_id']);
        $this->data['product_detail'] = $product_detail;

        $this->load->view('product/user/ajax_frame_stock_history', $this->data);
    }

}