<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_agent
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function get_agent_detail($uacc_id){
        $agent_detail = [];
        $query = $this->CI->db->query("SELECT * FROM view_user_list WHERE uacc_id='".$uacc_id."'");
        if($query->num_rows() > 0){
            $agent_detail = $query->row_array();
            $agent_detail['total_assigned_leads'] = $this->count_total_leads($uacc_id);

            $list_all_leads = $this->CI->far_lead->list_all_leads_by_agent($uacc_id);
            $agent_detail['list_all_leads'] = $list_all_leads;
            //count total leads
        }
        return $agent_detail;
    }
    function list_all_agent(){
        $list_all_agent = [];
        $query = $this->CI->db->query("SELECT uacc_id FROM view_user_list WHERE uacc_group_fk='6'");
        if($query->num_rows() > 0){
            $list_agent = $query->result_array();
            foreach($list_agent as $a => $b){
                $list_all_agent[] = $this->get_agent_detail($b['uacc_id']);
            }
        }
        return $list_all_agent;
    }

    function count_total_leads($uacc_id){
        $query = $this->CI->db->query("SELECT * FROM lead_detail WHERE assigned_agent_uacc_id='".$uacc_id."'");
        return $query->num_rows();
    }

    function delete_agent($uacc_id){
        //update fullname
        $agent_detail = $this->get_agent_detail($uacc_id);

        //new fullname
        $new_fullname = "DELETED-".time()."-".$agent_detail['fullname'];
        $new_fullname = strtoupper($new_fullname);
        $this->CI->far_users->update_profile('uacc_id', $uacc_id, 'fullname', $new_fullname);

        $new_mobile = "DELETED-".time()."-".$agent_detail['mobile_number'];
        $this->CI->far_users->update_profile('uacc_id', $uacc_id, 'mobile_number', $new_mobile);

        //new username
        $new_username = "DELETED-".time()."-".$agent_detail['uacc_username'];
        $this->CI->far_users->update_user('uacc_id', $uacc_id, 'uacc_username', $new_username);

        //change group to 9999
        $this->CI->far_users->update_user('uacc_id', $uacc_id, 'uacc_group_fk', 9999);

    }

}