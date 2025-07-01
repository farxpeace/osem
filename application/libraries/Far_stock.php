<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_stock
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function count_available_stock($product_id){
        $query = $this->CI->db->query("SELECT SUM(quantity) AS total_quantity FROM view_stock_list WHERE product_id='".$product_id."'");
        return $query->row()->total_quantity ?? 0;
    }
    function count_stock_in($product_id){
        $query = $this->CI->db->query("SELECT SUM(quantity) AS total_quantity FROM view_stock_list WHERE product_id='".$product_id."' AND quantity > 0");
        return $query->row()->total_quantity ?? 0;
    }
    function count_stock_out($product_id){
        $query = $this->CI->db->query("SELECT SUM(quantity) AS total_quantity FROM view_stock_list WHERE product_id='".$product_id."' AND quantity < 0");
        return $query->row()->total_quantity ?? 0;
    }
    function get_product_stock_detail($product_stock_id){
        $product_stock_detail = [];
        $query = $this->CI->db->query("SELECT * FROM view_stock_list WHERE product_stock_id='".$product_stock_id."'");
        if($query->num_rows() > 0){
            $product_stock_detail = $query->row_array();
        }
        return $product_stock_detail;
    }


}