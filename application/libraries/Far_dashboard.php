<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Far_dashboard {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function total_staff(){
        $query = $this->CI->db->query("SELECT COUNT(uacc_id) as total_user FROM user_accounts WHERE uacc_group_fk='6'");
        return $query->row()->total_user;
    }
    function total_customer(){
        $query = $this->CI->db->query("SELECT COUNT(customer_id) as total_user FROM view_customer_list");
        return $query->row()->total_user ?? 0;
    }
    function total_product_type(){
        $query = $this->CI->db->query("SELECT COUNT(product_id) as total FROM view_product_list");
        return $query->row()->total ?? 0;
    }
    function total_stock_balance(){
        $query = $this->CI->db->query("SELECT SUM(quantity) as total FROM product_stock");
        return $query->row()->total ?? 0;
    }
    function total_sales_per_month($date){
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));
        $query = $this->CI->db->query("SELECT SUM(grand_total) as total FROM view_order_list WHERE MONTH(create_dttm)='".$month."' AND YEAR(create_dttm)='".$year."'");
        return $query->row()->total ?? 0;
    }
    function total_sales_per_date($date){
        $query = $this->CI->db->query("SELECT SUM(grand_total) as total FROM view_order_list WHERE DATE(create_dttm)='".$date."'");
        return $query->row()->total ?? 0;
    }
    function total_sales_per_date_and_cash($date){
        $query = $this->CI->db->query("SELECT SUM(grand_total) as total FROM view_order_list WHERE DATE(create_dttm)='".$date."' AND payment_gateway='cash'");
        return $query->row()->total ?? 0;
    }
    function total_sales_per_date_and_ewallet($date){
        $query = $this->CI->db->query("SELECT SUM(grand_total) as total FROM view_order_list WHERE DATE(create_dttm)='".$date."' AND payment_gateway='ewallet'");
        return $query->row()->total ?? 0;
    }
    function total_order(){
        $query = $this->CI->db->query("SELECT COUNT(order_id) as total FROM view_order_list");
        return $query->row()->total ?? 0;
    }
    function total_order_by_cash(){
        $query = $this->CI->db->query("SELECT COUNT(order_id) as total FROM view_order_list WHERE payment_gateway='cash'");
        return $query->row()->total ?? 0;
    }
    function total_order_by_ewallet(){
        $query = $this->CI->db->query("SELECT COUNT(order_id) as total FROM view_order_list WHERE payment_gateway='ewallet'");
        return $query->row()->total ?? 0;
    }
    function total_sales(){
        $query = $this->CI->db->query("SELECT SUM(grand_total) as total FROM view_order_list");
        return $query->row()->total ?? 0;
    }

    function latest_5_orders(){
        $latest_5_orders = [];
        $query = $this->CI->db->query("SELECT * FROM view_order_list ORDER BY create_dttm DESC LIMIT 5");
        if($query->num_rows() > 0){
            $latest_5_orders = $query->result_array();
        }
        return $latest_5_orders;
    }

    function count_total_attendance_without_clockout(){
        $query = $this->CI->db->query("SELECT COUNT(attendance_id) as total FROM view_attendance_list WHERE LENGTH(COALESCE(clockout_dttm, '')) < 4");
        return $query->row()->total;
    }


    function total_user(){
        $query = $this->CI->db->query("SELECT COUNT(uacc_id) as total_user FROM user_accounts WHERE uacc_group_fk='6'");
        return $query->row()->total_user;
    }

    
    
    
}


?>