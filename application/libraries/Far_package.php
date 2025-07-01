<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Far_package
{
    private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function list_all_package(){
        $list_all_package = [];
        $query = $this->CI->db->query("SELECT * FROM package_detail WHERE status='active'");
        if($query->num_rows() > 0){
            $list_all_package = $query->result_array();
            foreach($list_all_package as $a => $b){
                $query2 = $this->CI->db->query("SELECT pack.*,p.product_name FROM package_product pack LEFT JOIN product_detail p ON pack.product_id=p.product_id WHERE pack.package_id='".$b['package_id']."'");
                /*
                $list_all_product = $query2->result_array();
                foreach($list_all_product as $c => $d){
                    $product_detail = $this->CI->far_product->get_product_detail($d['product_id']);
                    $list_all_package[$a]['list_product'][] = $product_detail;
                }
                */

                //package detail
                $package_detail = $this->get_package_detail($b['package_id']);
                $list_all_package[$a] = $package_detail;


            }
        }
        return $list_all_package;
    }

    function is_package_available_for_sale($package_id, $quantity){
        $output = "yes";
        $package_detail = $this->get_package_detail($package_id);

        return $package_detail;

    }

    function get_package_detail($package_id){
        $package_detail = array();
        $query = $this->CI->db->query("SELECT * FROM package_detail WHERE package_id='".$package_id."'");
        $available_package_array = [];

        if($query->num_rows() > 0){
            $package_detail = $query->row_array();

            //list package_product
            $query2 = $this->CI->db->query("SELECT pack.*,p.product_name FROM package_product pack LEFT JOIN product_detail p ON pack.product_id=p.product_id WHERE pack.package_id='".$package_detail['package_id']."'");

            $list_all_product = $query2->result_array();
            foreach($list_all_product as $c => $d){
                $product_detail = $this->CI->far_product->get_product_detail($d['product_id']);
                $list_all_product[$c]['count_available_stock'] = $product_detail['count_available_stock'];

                //available package based on product quantity
                $available_package_quantity_based_on_product_detail = $this->CI->far_helper->remove_decimal($product_detail['count_available_stock']/$d['product_quantity']);
                $list_all_product[$c]['available_package_quantity_based_on_product_detail'] = $available_package_quantity_based_on_product_detail;

                $available_package_array[] = $available_package_quantity_based_on_product_detail;
            }

            $package_detail['list_product'] = $list_all_product;

            $package_detail['available_package_array'] = $available_package_array;
            if(count($available_package_array) > 0){
                $package_detail['count_available_stock'] = min($available_package_array);
            }else{
                $package_detail['count_available_stock'] = 0;
            }

        }
        return $package_detail;
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
    function update_package_detail($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('package_detail', $data);
    }
    function update_package_product($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('package_product', $data);
    }
}