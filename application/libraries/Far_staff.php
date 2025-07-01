<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_staff
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function list_all_staff(){
        $list_all_staff = [];
        $query = $this->CI->db->query("SELECT * FROM view_user_list WHERE uacc_group_fk='6'");
        if($query->num_rows() > 0){
            $list_all_staff = $query->result_array();
        }
        return $list_all_staff;
    }

}