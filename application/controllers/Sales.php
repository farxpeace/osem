<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sales extends MY_Controller
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
    function add_new_sales(){

        $list_added_to_cart = $this->far_order->list_user_cart($this->user['uacc_id']);
        $this->data['list_added_to_cart'] = $list_added_to_cart;

        //echo "<pre>"; print_r($list_added_to_cart); echo "</pre>";

        $this->load->view('sales/user/add_new_sales', $this->data);
    }
    function ajax_load_cart_by_cart_id(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $cart_id = $postdata['cart_id'] ?? $this->input->get('cart_id');
        $cart_detail = $this->far_order->get_cart_by_cart_id($cart_id);

        if(count($cart_detail) > 3){
            if(($postdata['customer_id'] ?? 0) > 0){
                $this->db->where('cart_id', $cart_detail['cart_id']);
                $this->db->update('cart_detail', ['customer_id' => $postdata['customer_id']]);

                $cart_detail = $this->far_order->get_cart_by_cart_id($cart_id);
            }
        }


        $this->data['cart_detail'] = $cart_detail;

        $this->load->view('sales/user/ajax_load_cart', $this->data);
    }
    function ajax_load_cart(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();



        if(count($error) == 0){

            if($postdata['operation'] == 'add_to_cart'){
                $this->far_order->add_to_cart_per_user($this->user['uacc_id'], $postdata['product_id'], $postdata['quantity']);
            }

            $list_user_cart = $this->far_order->list_user_cart($this->user['uacc_id']);

            $output['list_user_cart'] = $list_user_cart;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_add_new_customer(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
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

        $quantity = $postdata['quantity'] ?? "";
        if(!$quantity){
            $error['quantity'] = "Please check quantity";
        }else{
            if($quantity == 0){
                $error['quantity'] = "Please check quantity";
            }
        }

        $ex = explode("_", $postdata['item']);
        if($ex[0] == 'package'){
            $package_id = $ex[1];
            $package_detail = $this->far_package->get_package_detail($package_id);
            if(count($package_detail) == 0){
                $error['item'] = "Package not found";
            }else{
                if($package_detail['count_available_stock'] < $quantity){
                    $error['item'] = "Quantity error";
                }
            }
        }


        if(count($error) == 0){
            $cart_id = $this->far_order->add_to_cart_by_cart_id($postdata['cart_id'], $postdata['item'], $postdata['quantity'], $this->user['uacc_id'], $postdata['customer_id']);
            $output['status'] = 'success';
            $output['cart_id'] = $cart_id;
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function ajax_add_to_cart_old(){
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
            $remove_from_cart = $this->far_order->remove_product_from_cart($postdata['cart_id'], $postdata['item_id']);
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

        $quantity = $postdata['quantity'];
        if(!preg_match('/[0-9]/', $quantity)){
            $error['quantity'] = "Number only";
        }


        if($quantity > 0){
            //product or package
            $ex = explode("_", $postdata['item_id']);
            $type = $ex[0];


            //get product detail
            if($type == 'product'){
                $product_id = $ex[1];
                //get product detail
                $product_detail = $this->far_product->get_product_detail($product_id);
                if($quantity > $product_detail['count_available_stock']){
                    $error['quantity'] = "Quantity cannot be more than available product";
                }
            }elseif($type == 'package'){
                $package_id = $ex[1];
                $package_detail = $this->far_package->get_package_detail($package_id);
                if($quantity > $package_detail['count_available_stock']){
                    $error['quantity'] = "Quantity cannot be more than available product";
                }
            }

        }


        if(count($error) == 0){
            $remove_from_cart = $this->far_order->edit_quantity_on_cart($postdata['cart_id'], $postdata['item_id'], $postdata['quantity']);
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
            $error['add_stock_remarks'] = "Remarks must be more than 3 characters";
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

    function sales_place_new_order(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(!$postdata['cart_id']){
            $error['cart_id'] = "Please choose cart";
        }else{
            if($postdata['cart_id'] < 1){
                $error['cart_id'] = "Please choose cart";
            }else{
                $cart_detail = $this->far_order->get_cart_detail($postdata['cart_id']);
                if($cart_detail['customer_id'] < 1){
                    $error['cart_id'] = "Please choose customer";
                }
            }
        }

        //payment gateway
        if(!in_array($postdata['payment_gateway'], ['cash', 'ewallet'])){
            $error['payment_gateway'] = "Please choose Payment Method";
        }



        if(count($error) == 0){




            $calculate_invoice_data = $this->far_order->calculate_cart($cart_detail['cart_id']);
            $create_dttm = date("Y-m-d H:i:s");
            $new_order_data = array(
                'order_code' => $this->far_helper->generateRandomString(10),
                'cart_id' => $postdata['cart_id'],
                'customer_id' => $cart_detail['customer_id'],
                'sales_uacc_id' => $this->user['uacc_id'],
                'grand_price' => $calculate_invoice_data['final_grand_total'],
                'grand_total' => $calculate_invoice_data['final_grand_total'],
                'calculate_invoice_data' => json_encode($calculate_invoice_data),
                'payment_gateway' => $postdata['payment_gateway'],
                'create_dttm' => $create_dttm
            );
            $this->db->insert('order_detail', $new_order_data);
            $order_id = $this->db->insert_id();

            //update cart
            $update_cart_data = array(
                'is_checkout' => 'yes',
                'order_id' => $order_id,
            );
            $this->db->where('cart_id', $cart_detail['cart_id']);
            $this->db->update('cart_detail', $update_cart_data);



            //deduct stock
            $item_list = $cart_detail['item_list'];
            $x_item = explode(",", $item_list);
            if(count($x_item) > 0){

                foreach($x_item as $a => $b){
                    //package
                    if (str_contains($b, 'package_')) {
                        $x_package_id = explode("_", $b);
                        $package_id = $x_package_id[1];
                        $package_detail = $this->far_package->get_package_detail($package_id);
                        if(count($package_detail['list_product']) > 0){
                            foreach($package_detail['list_product'] as $c => $d){
                                $insert_data = array(
                                    'product_id' => $d['product_id'],
                                    'remarks' => 'sales_package_'.$d['package_id'],
                                    'quantity' => "-".$d['product_quantity'],
                                    'stock_dttm' => date("Y-m-d"),
                                    'order_id' => $order_id,
                                    'created_by_uacc_id' => $this->user['uacc_id'],
                                    'create_dttm' => date("Y-m-d H:i:s")
                                );
                                $this->db->insert('product_stock', $insert_data);
                            }
                        }

                    }

                    if (str_contains($b, 'product_')) {
                        $x_product_id = explode("_", $b);
                        $product_id = $x_product_id[1];

                        $insert_data = array(
                            'product_id' => $product_id,
                            'remarks' => 'sales',
                            'quantity' => '-1',
                            'stock_dttm' => date("Y-m-d"),
                            'order_id' => $order_id,
                            'created_by_uacc_id' => $this->user['uacc_id'],
                            'create_dttm' => date("Y-m-d H:i:s")
                        );
                        $this->db->insert('product_stock', $insert_data);
                    }



                }
            }

            $output['redirect_url'] = base_url().'sales/my_sales_history';
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function my_sales_history(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);

        $filter_month = $this->input->get('filter_month') ?? date("m");
        $filter_year = $this->input->get('filter_year') ?? date("Y");

        $this->data['filter_month'] = $filter_month;
        $this->data['filter_year'] = $filter_year;

        $list_sales = $this->far_order->list_sales_month_year($this->user['uacc_id'],$filter_month, $filter_year);
        $this->data['list_sales'] = $list_sales;



        $this->load->view('sales/user/my_sales_history', $this->data);
    }
    function ajax_modal_order_detail(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $order_id = $postdata['order_id'] ?? $this->input->get('order_id');
        //$order_id = $postdata['order_id'];

        $order_detail = $this->far_order->get_order_detail($order_id);
        $this->data['order_detail'] = $order_detail;

        $cart_detail = json_decode($order_detail['calculate_invoice_data'], TRUE);
        $this->data['cart_detail'] = $cart_detail;

        $customer_detail = $this->far_customer->get_customer_detail($order_detail['customer_id']);
        $this->data['customer_detail'] = $customer_detail;
        $this->load->view('sales/user/ajax_modal_order_detail', $this->data);
    }
}