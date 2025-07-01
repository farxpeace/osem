<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Leads extends MY_Controller
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

    function add_new_leads(){
        $this->load->view('leads/user/add_new_leads', $this->data);
    }
    function ajax_add_lead(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['company_name']) < 1){
            $error['company_name'] = "Company name must be greater than 2 characters";
        }

        if(strlen($postdata['pic_name']) < 2){
            $error['pic_name'] = "PIC Name must be more than 3 characters";
        }
        $pic_mobile = $this->far_helper->fix_msisdn($postdata['pic_mobile']);
        if(strlen($pic_mobile) < 5){
            $error['pic_mobile'] = "PIC Mobile must be more than 5 digits";
        }

        if(strlen($postdata['company_registration_number']) < 2){
            $error['company_registration_number'] = "Company Registration must be greater than 2 characters";
        }else{
            $company_registration_number = preg_replace("/[^a-zA-Z0-9]+/", "", $postdata['company_registration_number']);
            $company_registration_number = strtoupper($company_registration_number);
            //check if exists
            $query = $this->db->query("SELECT * FROM lead_detail WHERE company_registration_number='".$company_registration_number."'");
            if($query->num_rows() > 0){
                $error['company_registration_number'] = "Company already exists";
            }
        }



        if(count($error) == 0){
            $create_dttm = date("Y-m-d H:i:s");
            $expired_dttm = $this->far_date->add_days(14,$create_dttm);
            $booth_count = 0;
            $booth_price_single = 0;
            $booth_price_total = 0;
            if($postdata['enable_booth'] == "yes"){
                $booth_count = $postdata['booth_count'];
                $booth_price_single = $postdata['booth_price_single'];
                $booth_price_total = $postdata['booth_price_total'];
            }

            $sponsor_title = "";
            $sponsor_amount = 0;
            if($postdata['enable_sponsor'] == "yes"){
                $sponsor_title = $postdata['sponsor_title'];
                $sponsor_amount = $postdata['sponsor_amount'];
            }
            $insert_data = array(
                'submitter_uacc_id' => $this->user['uacc_id'],
                'assigned_agent_uacc_id' => $this->user['uacc_id'],
                'company_name' => strtoupper($postdata['company_name']),
                'company_registration_number' => $company_registration_number,
                'pic_name' => strtoupper($postdata['pic_name']),
                'pic_mobile' => $pic_mobile,
                'pic_email' => $postdata['pic_email'],
                'booth_count' => $booth_count,
                'booth_price_single' => $booth_price_single,
                'booth_price_total' => $booth_price_total,
                'sponsor_title' => $sponsor_title,
                'sponsor_amount' => $sponsor_amount,
                'status' => 'active',
                'create_dttm' => date("Y-m-d H:i:s"),
                'start_dttm' => date("Y-m-d H:i:s"),
                'expired_dttm' => $expired_dttm
            );

            $lead_id = $this->far_lead->add_new_lead($insert_data);
            $output['lead_id'] = $lead_id;
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

        $lead_id = $this->input->get('lead_id') ?? 0;
        $this->data['lead_id'] = $lead_id;

        if($lead_id < 1){
            $this->data['error_message'] = "Please choose company";
        }else{
            $lead_detail = $this->far_lead->get_lead_detail($lead_id);
            $this->data['lead_detail'] = $lead_detail;
        }


        $this->load->view('leads/user/history', $this->data);
    }

    function my_lead(){

        $list_all_leads = $this->far_lead->list_all_leads_by_staff($this->user['uacc_id']);
        $this->data['list_all_leads'] = $list_all_leads;

        $this->load->view('leads/user/my_lead', $this->data);
    }

    function list_expired_leads(){
        $list_all_leads = $this->far_lead->list_all_expired_leads();
        $this->data['list_all_leads'] = $list_all_leads;

        $this->load->view('leads/user/list_expired_leads', $this->data);
    }

    function ajax_assign_extend_lead(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if($postdata['assigned_agent_uacc_id'] == 0){
            $error['assigned_agent_uacc_id'] = "Please choose agent";
        }
        if($postdata['extend_days'] == 0){
            $error['extend_days'] = "Please choose days";
        }

        $lead_detail = $this->far_lead->get_lead_detail($postdata['lead_id']);
        if(count($lead_detail) < 4){
            $error['lead_id'] = "Lead ID problem. Please contact developer";
        }else{
            if($lead_detail['status_code'] != 'expired'){
                $error['lead_id'] = "Lead status is not expired";
            }
        }

        if(count($error) == 0){

            $start_dttm = date("Y-m-d H:i:s");
            $expired_dttm = $this->far_date->add_days($postdata['extend_days'],$start_dttm);

            //update
            $this->far_lead->update_lead_detail('lead_id', $lead_detail['lead_id'], 'assigned_agent_uacc_id', $postdata['assigned_agent_uacc_id']);
            $this->far_lead->update_lead_detail('lead_id', $lead_detail['lead_id'], 'start_dttm', $start_dttm);
            $this->far_lead->update_lead_detail('lead_id', $lead_detail['lead_id'], 'expired_dttm', $expired_dttm);

            //status
            $lead_status_id = $this->far_lead->create_lead_status($lead_detail['lead_id'], 'assigned', 'Assigned to Agent', $this->user['uacc_id']);
            $this->far_lead->update_lead_detail('lead_id', $lead_detail['lead_id'], 'lead_status_id', $lead_status_id);



            $output['lead_id'] = $lead_detail['lead_id'];
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function admin_list_all_leads(){
        $list_all_leads = $this->far_lead->list_all_leads();
        $this->data['list_all_leads'] = $list_all_leads;

        $this->load->view('leads/admin/admin_list_all_leads', $this->data);
    }
}