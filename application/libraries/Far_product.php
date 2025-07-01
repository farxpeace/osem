<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_product
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function list_all_product(){
        $list_all_product = [];
        $query = $this->CI->db->query("SELECT * FROM view_product_list WHERE product_status='active'");
        if($query->num_rows() > 0){
            $list_all_product = $query->result_array();
            foreach($list_all_product as $a => $b){
                //count_available_stock
                $count_available_stock = $this->CI->far_stock->count_available_stock($b['product_id']);
                $list_all_product[$a]['count_available_stock'] = $count_available_stock;
            }
        }



        return $list_all_product;
    }
    function get_product_detail($product_id){
        $product_detail = array();
        $query = $this->CI->db->query("SELECT * FROM view_product_list WHERE product_id='".$product_id."'");
        if($query->num_rows() > 0){
            $product_detail = $query->row_array();

            $count_available_stock = $this->CI->far_stock->count_available_stock($product_id);
            $product_detail['count_available_stock'] = $count_available_stock;
        }
        return $product_detail;
    }
    function list_product_pagination($startAt, $perPage, $main_category, $search_input){
        //$perPage = 10;
        //$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
        //$startAt = $perPage * ($page - 1);
        $list_products = array();
        $main_category_query = "";
        if(strlen($main_category) > 0){
            $main_category_query = " AND main_category='$main_category'";
        }
        if(strlen($search_input) > 0){
            $search_input_query = " AND post_title LIKE '%$search_input%'";
        }
        $query = $this->CI->db->query("SELECT * FROM view_product_list WHERE 1 ".$main_category_query." $search_input_query ORDER BY product_id ASC LIMIT $startAt, $perPage");
        //echo "SELECT * FROM product_detail WHERE 1 ".$main_category_query." ORDER BY product_id ASC LIMIT $startAt, $perPage"; exit();
        if($query->num_rows() > 0){
            $list_products = $query->result_array();
            foreach($list_products as $a => $b){
                $list_products[$a]['images_sanitized'] = $b['product_image_fullurl'];
                $list_products[$a]['regular_price'] = $this->CI->far_helper->convert_to_currency_format($b['regular_price']);
            }
        }
        return $list_products;
    }
    function sanitize_images_url($url){
        //$short = substr($str, 0, strpos( $str, $url);
        $ex = explode(" ! ", $url);
        $test = pathinfo($url);
        return $ex[0];
    }
    function list_all_category(){
        $query = $this->CI->db->query("SELECT main_category, COUNT(main_category) AS total_product FROM view_product_list GROUP BY main_category");
        return $query->result_array();
    }
    function update_product_detail($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('product_detail', $data);
    }
}