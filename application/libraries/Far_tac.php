<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_tac {
    private $CI;
    private $repo;
    public function __construct(){
        //parent::__construct();
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function get_tac_code($column, $value){
        $tac_detail = array();
        $query = $this->CI->db->query("SELECT * FROM far_tac WHERE ".$column."='".$value."'");
        if($query->num_rows() > 0){
            $tac_detail = $query->row_array();
        }
        return $tac_detail;
    }
    function flag_tac_as_used($uacc_id, $tac_code){
        $query = $this->CI->db->query("UPDATE far_tac SET tac_status='used' WHERE uacc_id='".$uacc_id."' AND tac_code='".$tac_code."'");
        if($query){
            return true;
        }else{
            return false;
        }
    }
    function generate_tac_code($data = array()){
        $this->CI->load->library('far_helper');
        $tac_code = $data['tac_code'] ?? $this->CI->far_helper->generateRandomnumber(4);
        $data['tac_code'] = $tac_code;
        $data['tac_status'] = $data['tac_status'] ?? "unused";
        $data['create_dttm'] = $data['create_dttm'] ?? date("Y-m-d H:i:s");
        $data['expired_dttm'] = $data['expired_dttm'] ?? $this->CI->far_date->add_minutes_to_dttm($this->CI->far_meta->get_value('tac_expired_in_minutes'), $data['create_dttm']);
        $this->CI->db->insert('far_tac', $data);
        return $data['tac_code'];
    }
    function get_latest_unused_tac_code($uacc_id){
        $query = $this->CI->db->query("SELECT * FROM far_tac WHERE uacc_id='".$uacc_id."' AND tac_status='unused' ORDER BY create_dttm DESC LIMIT 1");
        $row = $query->row_array();
        return $row;
    }
    function get_latest_unused_tac_code_by_mobile_number($mobile_number){
        $this->flag_unused_as_expired_for_mobile_number();
        $tac_detail = [];
        $query = $this->CI->db->query("SELECT * FROM far_tac WHERE mobile_number='".$mobile_number."' AND tac_status='unused' ORDER BY create_dttm DESC LIMIT 1");
        if($query->row_array() > 0){
            $tac_detail = $query->row_array();
        }
        return $tac_detail;
    }
    function update_far_tac($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('far_tac', $data);
    }
    function flag_unused_as_expired_for_mobile_number(){
        $tac_expired_in_minutes = $this->CI->far_meta->get_value('tac_expired_in_minutes');
        $query = $this->CI->db->query("SELECT * FROM far_tac WHERE tac_status='unused' AND create_dttm < NOW() - INTERVAL ".$tac_expired_in_minutes." MINUTE");
        $list_all_tac = $query->result_array();

        foreach($list_all_tac as $a => $b){
            $this->CI->db->where('tac_id', $b['tac_id']);
            $this->CI->db->update('far_tac', ['tac_status' => "expired"]);
        }
    }
    function flag_used_by_mobile_number_and_tac($mobile_number, $tac_code, $uacc_id){
        $this->CI->db->where('mobile_number', $mobile_number);
        $this->CI->db->where('tac_code', $tac_code);
        $this->CI->db->update('far_tac', ['tac_status' => 'used', 'uacc_id' => $uacc_id]);

    }
    /**
     * Get User Account
     */
    /**
    function get_account($column, $value){
    $query = $this->CI->db->query("SELECT * FROM user_accounts WHERE ".$column."='".$value."'");
    return $query->row_array();
    }
     */
    /**
    function list_account($column, $value){
    $query = $this->CI->db->query("SELECT * FROM user_accounts WHERE ".$column."='".$value."'");
    return $query->result_array();
    }
     */
    /**
     * Insert / Create profile
     * @param array $data
     */
    /**
    function insert_profile($data){
    $this->CI->db->insert('user_profiles', $data);
    return $this->CI->db->insert_id();
    }
     */
    /**
     * Update
     * @param string $key Database column name
     * @param string $key_value Database column value(s)
     * @param string $column Column name to update
     * @param string $value New value for specified column
     */
    /**
    function update_user($key, $key_value, $column, $value){
    $data = array(
    $column => $value
    );
    $this->CI->db->where($key, $key_value);
    $this->CI->db->update('user_accounts', $data);
    }
     */
}
?>