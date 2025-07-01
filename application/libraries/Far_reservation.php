<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_reservation
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function count_available_reservation($customer_id){
        $query = $this->CI->db->query("SELECT SUM(quantity) AS total_quantity FROM view_stock_list WHERE customer_id='".$customer_id."'");
        return $query->row()->total_quantity ?? 0;
    }
    function list_available_reservation_distinct_by_product_id($customer_id){
        $list_products = [];
        $query = $this->CI->db->query("SELECT ps.*,p.product_name,SUM(ps.quantity) as total_quantity FROM product_stock ps LEFT JOIN product_detail p ON p.product_id=ps.product_id WHERE ps.customer_id='".$customer_id."' AND ps.status='active' GROUP BY ps.product_id");
        if($query->num_rows() > 0){
            $list_products = $query->result_array();
        }
        return $list_products;
    }
    function count_available_reservation_by_product($customer_id, $product_id){
        $query = $this->CI->db->query("SELECT SUM(quantity) AS total_quantity FROM view_stock_list WHERE customer_id='".$customer_id."' AND product_id='".$product_id."'");
        return $query->row()->total_quantity ?? 0;
    }



}