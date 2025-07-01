<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_osem
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function is_customer_exists_by_mobile_number($mobile_number){
        $query = $this->CI->db->query("SELECT * FROM customer_detail WHERE mobile_number='".$mobile_number."'");
        if($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    function get_product_detail($product_id){
        $product_detail = array();
        $query = $this->CI->db->query("SELECT * FROM product_detail WHERE product_id='".$product_id."'");
        if($query->num_rows() > 0) {
            $product_detail = $query->row_array();

            //topping_list
            $topping_array = [];
            if(strlen($product_detail['topping_list']) > 0){
                $topping_x = explode(",", $product_detail['topping_list']);
                if(count($topping_x) > 0){
                    foreach($topping_x as $a => $b){
                        $topping_array[] = $this->get_item_by_api_id($b);
                    }
                }
            }
            $product_detail['topping'] = $topping_array;
            unset($product_detail['topping_list']);

            //batter list
            $batters_array = [];
            if(strlen($product_detail['batter_list']) > 0){
                $topping_x = explode(",", $product_detail['batter_list']);
                if(count($topping_x) > 0){
                    foreach($topping_x as $a => $b){
                        $batters_array['batter'][] = $this->get_item_by_api_id($b);
                    }
                }
            }
            $product_detail['batters'] = $batters_array;
            unset($product_detail['batter_list']);
        }
        return $product_detail;
    }
    function get_item_by_api_id($api_id){
        $item_detail = [];
        $query = $this->CI->db->query("SELECT * FROM item_detail WHERE id='".$api_id."'");
        if($query->num_rows() > 0){
            $item_detail = $query->row_array();
        }
        return $item_detail;
    }
    function list_all_product(){
        $list_all_product = array();
        $query = $this->CI->db->query("SELECT product_id FROM `product_detail` ORDER BY name ASC");
        if($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach($results as $a => $b){
                $list_all_product[] = $this->get_product_detail($b['product_id']);
            }
        }
        return $list_all_product;
    }
    function crawl(){
        $url = 'https://repocodes.s3.amazonaws.com/interview.json';
        $timeout = 10;
        /* ---------- 1. Fetch with cURL ---------- */
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $body       = curl_exec($ch);
        $curlErr    = curl_error($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false) {
            throw new RuntimeException("cURL error: $curlErr");
        }
        if ($httpStatus !== 200) {
            throw new RuntimeException("HTTP request failed with status $httpStatus");
        }

        /* ---------- 2. Decode JSON ---------- */
        $data = json_decode($body, true);   // true  => associative array
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('JSON decode error: ' . json_last_error_msg());
        }

        if(count($data) > 0){
            //populate data
            foreach($data as $a => $b){

                //check if product exists
                if($this->is_product_exists($b['id']) == "no"){
                    //insert
                    $insert_data = array(
                        'id' => $b['id'],
                        'type' => $b['type'],
                        'name' => $b['name'],
                        'ppu' => $b['ppu']
                    );
                    $this->CI->db->insert('product_detail', $insert_data);
                    $product_id = $this->CI->db->insert_id();

                }else{
                    $product_id = $b['id'];
                }

                $product_api_id = $b['id'];

                //topping
                if(isset($b['topping']) && count($b['topping']) > 0){
                    $topping_list = [];
                    foreach($b['topping'] as $c => $d){
                        //check if item exists
                        if($this->is_item_exists($d['id']) == "no"){
                            //insert
                            $insert_item = array(
                                'product_api_id' => $product_api_id,
                                'category' => 'topping',
                                'id' => $d['id'],
                                'type' => $d['type'],
                            );
                            $this->CI->db->insert('item_detail', $insert_item);
                            $item_id = $this->CI->db->insert_id();
                        }
                        $topping_list[] = $d['id'];
                    }
                    //print_r($product_id); exit();
                    $this->update_product_detail('id', $product_id, 'topping_list', implode(",", $topping_list));

                }

                if(isset($b['batters']) && count($b['batters']) > 0){
                    $batter_list = [];
                    foreach($b['batters']['batter'] as $c => $d){
                        //check if item exists
                        if($this->is_item_exists($d['id']) == "no"){
                            //insert
                            $insert_item = array(
                                'product_api_id' => $product_api_id,
                                'category' => 'batter',
                                'id' => $d['id'],
                                'type' => $d['type'],
                            );
                            $this->CI->db->insert('item_detail', $insert_item);
                            $item_id = $this->CI->db->insert_id();
                        }
                        $batter_list[] = $d['id'];
                    }
                    //print_r($product_id); exit();
                    $this->update_product_detail('id', $product_id, 'batter_list', implode(",", $batter_list));

                }
            }
        }

        $this->CI->far_meta->update_value('last_crawl_dttm', date("Y-m-d H:i:s"));
        $this->CI->far_meta->update_value('last_crawl_data', json_encode($data));


        return $data;
    }
    function is_product_exists($product_id){
        $is_exists = "no";
        $query = $this->CI->db->query("SELECT product_id FROM product_detail WHERE product_id='".$product_id."'");
        if($query->num_rows() > 0){
            $is_exists = "yes";
        }
        return $is_exists;
    }
    function is_item_exists($id){
        $is_exists = "no";
        $query = $this->CI->db->query("SELECT id FROM item_detail WHERE id='".$id."'");
        if($query->num_rows() > 0){
            $is_exists = "yes";
        }
        return $is_exists;
    }
    function update_product_detail($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('product_detail', $data);
    }
    function list_all_leads_by_agent($assigned_agent_uacc_id){
        $list_all_leads = array();
        $query = $this->CI->db->query("SELECT lead_id FROM `view_lead_list` WHERE assigned_agent_uacc_id='".$assigned_agent_uacc_id."' ORDER BY expired_dttm ASC");
        if($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach($results as $a => $b){
                $list_all_leads[] = $this->get_lead_detail($b['lead_id']);
            }
        }
        return $list_all_leads;
    }
    function list_all_leads(){
        $list_all_leads = array();
        $query = $this->CI->db->query("SELECT lead_id FROM `view_lead_list` ORDER BY company_name ASC");
        if($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach($results as $a => $b){
                $list_all_leads[] = $this->get_lead_detail($b['lead_id']);
            }
        }
        return $list_all_leads;
    }
    function add_new_lead($lead_data){
        $this->CI->db->insert('lead_detail', $lead_data);
        $lead_id = $this->CI->db->insert_id();

        //create status
        $lead_status_id = $this->create_lead_status($lead_id, 'created', 'New Lead Created', $lead_data['submitter_uacc_id']);
        $this->update_lead_detail('lead_id', $lead_id, 'lead_status_id', $lead_status_id);

        $lead_status_id = $this->create_lead_status($lead_id, 'assigned', 'Assigned to Agent', $lead_data['assigned_agent_uacc_id']);
        $this->update_lead_detail('lead_id', $lead_id, 'lead_status_id', $lead_status_id);

        return $lead_id;
    }
    function update_lead_detail($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('lead_detail', $data);
    }

    /** Lead Status **/
    function create_lead_status($lead_id,$status_code, $status_text,$created_by_uacc_id){
        $this->CI->db->insert('lead_status', ['lead_id' => $lead_id, 'status_code' => $status_code, 'status_text' => $status_text, 'created_by_uacc_id' => $created_by_uacc_id, 'create_dttm' => date("Y-m-d H:i:s")]);
        $lead_status_id = $this->CI->db->insert_id();
        return $lead_status_id;
    }
    function list_all_lead_status($lead_id){
        $list_all_lead_status = array();
        $query = $this->CI->db->query("SELECT * FROM `lead_status` WHERE lead_id='".$lead_id."' ORDER BY create_dttm DESC");
        if($query->num_rows() > 0) {
            $list_all_lead_status = $query->result_array();
            foreach($list_all_lead_status as $a => $b){
                $fullname = $this->CI->far_users->get_profile_by_column('uacc_id', $b['created_by_uacc_id'], 'fullname');
                $list_all_lead_status[$a]['created_by_fullname'] = $fullname;
            }
        }
        return $list_all_lead_status;
    }

    function list_all_expired_leads(){
        $list_all_leads = array();
        $query = $this->CI->db->query("SELECT lead_id FROM `view_lead_list` WHERE assigned_agent_uacc_id='0' AND status_code='expired' ORDER BY expired_dttm ASC");
        if($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach($results as $a => $b){
                $list_all_leads[] = $this->get_lead_detail($b['lead_id']);
            }
        }
        return $list_all_leads;
    }
}