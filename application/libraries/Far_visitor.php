<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Far_visitor
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function count_total_visitor($uacc_id){
        $query = $this->CI->db->query("SELECT COUNT(uacc_id) AS total_visitor FROM referral_visitor WHERE uacc_id='".$uacc_id."'");
        return $query->row()->total_visitor ?? 0;
    }
    function top_5_visitor_location($uacc_id){
        $list_visitor = [];
        $query = $this->CI->db->query("SELECT city, region, country, COUNT(referral_visitor_id) AS total_visitor FROM `referral_visitor` WHERE uacc_id='".$uacc_id."' GROUP BY country");
        if($query->num_rows() > 0){
            $list_visitor = $query->result_array();
        }
        return $list_visitor;
    }
}