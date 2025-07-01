<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."third_party/EasyAES/PHP/EasyAES.php";
class Far_encrypt {
    private $CI;
    private $aes;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
        $this->aes = new Crypt('****************', 128, '################');
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
    
    function encrypt($content){
        $encrypted = $this->aes->encrypt($content);
        return $encrypted;
    }
    function decrypt($content){
        $decrypted = $this->aes->decrypt($content);
        return $decrypted;
    }
    
}


?>