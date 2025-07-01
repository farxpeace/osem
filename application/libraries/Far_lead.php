<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_lead
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
    function get_lead_detail($lead_id){
        $lead_detail = array();
        $query = $this->CI->db->query("SELECT * FROM view_lead_list WHERE lead_id='".$lead_id."'");
        if($query->num_rows() > 0) {
            $lead_detail = $query->row_array();

            //countdown days
            $duration_between_two_dates = $this->CI->far_date->duration_between_two_dates(date("Y-m-d"), $lead_detail['expired_dttm']);
            $lead_detail['countdown_days'] = $duration_between_two_dates['days'];

            $list_all_status = $this->list_all_lead_status($lead_id);
            $lead_detail['list_all_status'] = $list_all_status;

            //calculate countdown percentage
            $countdown_percentage = $this->CI->far_helper->calculateCountdownPercentage($lead_detail['start_dttm'] ?? $lead_detail['create_dttm'], $lead_detail['expired_dttm']);
            $lead_detail['countdown_percentage'] = $countdown_percentage;
        }
        return $lead_detail;
    }
    function list_all_leads_by_staff($assigned_agent_uacc_id){
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