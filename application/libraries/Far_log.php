<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Far_log {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function insert($uacc_id, $type, $additional_log_data){
        if(!isset($type)){
            $type = 'activity';
        }
        $insert_data = array();
        $insert_data['create_dttm'] = date("Y-m-d H:i:s");
        $insert_data['uacc_id'] = $uacc_id;
        $insert_data['log_type'] = $type;
        if($additional_log_data){
            $insert_data['log_data_json'] = json_encode($additional_log_data);
        }


        $this->CI->db->insert('far_log', $insert_data);
        return $this->CI->db->insert_id();
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
