<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reservation extends MY_Controller
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

    function reserve_stock(){
        $this->load->view('reservation/user/reserve_stock', $this->data);
    }
    function ajax_reserve_stock(){
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
                'stock_type' => 'reserved',
                'customer_id' => $postdata['customer_id'],
                'created_by_uacc_id' => $this->user['uacc_id'],
                'create_dttm' => date("Y-m-d H:i:s")
            );
            $this->db->insert('product_stock', $insert_data);
            $product_stock_id = $this->db->insert_id();
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function redeem(){
        $customer_id = $this->input->get('customer_id') ?? 0;
        $this->data['customer_id'] = $customer_id;

        $product_id = $this->input->get('product_id') ?? 0;
        $this->data['product_id'] = $product_id;

        if($customer_id < 1){
            $this->data['error_message'] = "Please choose customer";
        }elseif($customer_id > 0 && $product_id > 0){
            $customer_detail = $this->far_customer->get_customer_detail($customer_id);
            $this->data['customer_detail'] = $customer_detail;

            $product_detail = $this->far_product->get_product_detail($product_id);
            $this->data['product_detail'] = $product_detail;
        }else{
            $this->data['error_message'] = "Please choose customer & product";
        }


        $this->load->view('reservation/user/redeem', $this->data);
    }
    function ajax_redeem_stock(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['quantity']) < 1){
            $error['add_stock_quantity'] = "Quantity must be more than 0";
        }
        if(strlen($postdata['remarks']) < 2){
            //$error['add_stock_remarks'] = "Remarks must be more than 3 characters";
        }

        //check if quantity and product id has an available
        $available = $this->far_reservation->count_available_reservation_by_product($postdata['customer_id'], $postdata['product_id']);
        if($postdata['quantity'] > $available){
            $error['quantity'] = "Please check quantity";
        }

        $availabe_stock = $this->far_stock->count_available_stock($postdata['product_id']);
        if($postdata['quantity'] > $availabe_stock){
            $error['quantity'] = "Unfortunately, this product not available on stock. Currently available are ".$availabe_stock." pieces only";
        }

        if(count($error) == 0){
            $insert_data = array(
                'product_id' => $postdata['product_id'],
                'remarks' => $postdata['remarks'],
                'quantity' => $this->far_helper->convert_positive_to_negative($postdata['quantity']),
                'stock_dttm' => $postdata['stock_dttm'] ?? date("Y-m-d"),
                'stock_type' => 'redeemed',
                'customer_id' => $postdata['customer_id'],
                'created_by_uacc_id' => $this->user['uacc_id'],
                'create_dttm' => date("Y-m-d H:i:s")
            );
            $this->db->insert('product_stock', $insert_data);
            $product_stock_id = $this->db->insert_id();
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function history(){

        $customer_id = $this->input->get('customer_id') ?? 0;
        $this->data['customer_id'] = $customer_id;

        if($customer_id < 1){
            $this->data['error_message'] = "Please choose customer";
        }else{
            $customer_detail = $this->far_customer->get_customer_detail($customer_id);
            $this->data['customer_detail'] = $customer_detail;
        }


        $this->load->view('reservation/user/history', $this->data);
    }
}