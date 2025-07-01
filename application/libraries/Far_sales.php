<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_sales
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function list_sales_by_customer_id($customer_id){
        $list_sales = [];
        $query = $this->CI->db->query("SELECT o.* FROM `order_detail` o WHERE o.customer_id='".$customer_id."' ORDER BY o.create_dttm");
        if($query->num_rows() > 0){
            $list_sales = $query->result_array();
        }
        return $list_sales;
    }

    function list_sales_by_daterange($start_dttm, $end_dttm){
        $end_dttm = date('Y-m-d', strtotime($end_dttm . ' +1 day'));
        $list_sales = [];
        $query = $this->CI->db->query("SELECT * FROM view_order_list WHERE create_dttm BETWEEN '".$start_dttm."' AND '".$end_dttm."'");
        if($query->num_rows() > 0){
            $list_sales = $query->result_array();

            foreach($list_sales as $a => $b){

                //listing
                $calculate_invoice_array = json_decode($b['calculate_invoice_data'], TRUE);
                $list_sales[$a]['calculate_invoice_array'] = $calculate_invoice_array;
            }
        }
        return $list_sales;
    }
    function list_sales_by_daterange_and_customer_id($customer_id, $start_dttm, $end_dttm){
        $end_dttm = date('Y-m-d', strtotime($end_dttm . ' +1 day'));
        $list_sales = [];
        $query = $this->CI->db->query("SELECT * FROM view_order_list WHERE create_dttm BETWEEN '".$start_dttm."' AND '".$end_dttm."' AND customer_id='".$customer_id."'");
        if($query->num_rows() > 0){
            $list_sales = $query->result_array();

            foreach($list_sales as $a => $b){

                //listing
                $calculate_invoice_array = json_decode($b['calculate_invoice_data'], TRUE);
                $list_sales[$a]['calculate_invoice_array'] = $calculate_invoice_array;
            }
        }
        return $list_sales;
    }



}