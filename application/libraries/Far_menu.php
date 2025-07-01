<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Far_menu {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function list_parent(){
        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE parent_id='0' ORDER BY sort ASC");
        $row = $query->result_array();
        return $row;
    }

    function get_menu($menu_id){
        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE id='".$menu_id."'");
        $row = $query->row_array();
        return $row;
    }

    function update_menu($menu_id, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where('id', $menu_id);
        $this->CI->db->update('far_menu', $data);
    }

    public function list_all_menu(){
        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE parent_id='0' ORDER BY sort ASC");
        foreach ($query->result_array() as $row){
            $children = array();
            $query2 = $this->CI->db->query("SELECT * FROM far_menu WHERE parent_id='".$row['id']."'");
            foreach ($query2->result_array() as $row2){
                $children2 = array();
                $query3 = $this->CI->db->query("SELECT * FROM far_menu WHERE parent_id='".$row2['id']."'");
                foreach ($query3->result_array() as $row3){

                    $children2[] = $row3;
                }
                $row2['children'] = $children2;
                $children[] = $row2;
            }
            $row['children'] = $children;
            $output[] = $row;
        }

        return $output;
    }

    public function list_menu_by_group($group_id = 'all'){

        $url_class = $this->CI->router->fetch_class();
        $url_method = $this->CI->router->fetch_method();
        $segs = $this->CI->uri->segment_array();
        $url_method_arr = array(
            $url_method,
            $url_method."/".end($segs)
        );

        $output = array();


        $query = $this->CI->db->query('SELECT * FROM far_menu WHERE parent_id="0" AND FIND_IN_SET("'.$group_id.'",group_id) AND visible="1" ORDER BY sort ASC');
        foreach ($query->result_array() as $row){

            $row['selected_page'] = "no";
            if($row['controller'] == $url_class && $row['method'] == $url_method){
                $row['selected_page'] = "yes";
            }

            $row['full_link'] = "javascript: void(0);";
            if($row['link'] == "ci_controller"){
                $row['full_link'] = base_url().$row['controller']."/".$row['method'];
            }

            $query2 = $this->CI->db->query("SELECT * FROM far_menu WHERE parent_id='".$row['id']."' AND FIND_IN_SET('".$group_id."',group_id) AND visible='1' ORDER BY sort ASC");
            $row['has_children'] = "no";
            if($query2->num_rows() > 0){
                $row['has_children'] = "yes";
            }

            foreach ($query2->result_array() as $row2){
                $row2['selected_page'] = "no";
                if($row2['controller'] == $url_class && $row2['method'] == $url_method){
                    $row2['selected_page'] = "yes";
                    $row['selected_page'] = "yes";
                }
                $row2['full_link'] = "javascript: void(0);";
                if($row2['link'] == "ci_controller"){
                    $row2['full_link'] = base_url().$row2['controller']."/".$row2['method'];
                }




                $query3 = $this->CI->db->query("SELECT * FROM far_menu WHERE parent_id='".$row2['id']."' AND FIND_IN_SET('".$group_id."',group_id) AND visible='1' ORDER BY sort ASC");
                $row2['has_children'] = "no";
                
                if($query3->num_rows() > 0){
                    $row2['has_children'] = "yes";
                    foreach ($query3->result_array() as $row3){
                        $row3['selected_page'] = "no";
                        if($row3['controller'] == $url_class && $row3['method'] == $url_method){
                            $row3['selected_page'] = "yes";
                            $row2['selected_page'] = "yes";
                        }
                        $row3['full_link'] = "javascript: void(0);";
                        if($row3['link'] == "ci_controller"){
                            $row3['full_link'] = base_url().$row3['controller']."/".$row3['method'];
                        }
                        $row2['children'][] = $row3;
                    }
                }
                $row['children'][] = $row2;

            }



            $output[] = $row;
        }
        return $output;
    }

    public function page_title(){
        $url_class = $this->CI->router->fetch_class();
        $url_method = $this->CI->router->fetch_method();

        $query = $this->CI->db->query("SELECT page_title, page_title_small FROM far_menu WHERE controller='".$url_class."' AND method='".$url_method."%' LIMIT 1");

        if($query->num_rows() == 0){
            $segs = $this->CI->uri->segment_array();
            $url_method2 = $url_method."/".end($segs);
            $query = $this->CI->db->query("SELECT page_title, page_title_small FROM far_menu WHERE controller='".$url_class."' AND method='".$url_method2."' LIMIT 1");
        }



        $rows = $query->row();
        return $rows;
    }

    public function breadcrumb(){
        $url_class = $this->CI->router->fetch_class();
        $url_method = $this->CI->router->fetch_method();

        $query = $this->CI->db->query("SELECT parent_id,name,link,controller,method FROM far_menu WHERE controller='".$url_class."' AND method='".$url_method."' LIMIT 1");
        if($query->num_rows() == 0){
            $segs = $this->CI->uri->segment_array();
            $url_method2 = $url_method."/".end($segs);
            $query = $this->CI->db->query("SELECT parent_id,name,link,controller,method FROM far_menu WHERE controller='".$url_class."' AND method='".$url_method2."' LIMIT 1");
        }
        $breadcrumb[] = array('name' => $query->row()->name, 'class' => $query->row()->controller, 'method' => $query->row()->method, 'link' => $query->row()->link);

        $query2 = $this->CI->db->query("SELECT parent_id,name,link,controller,method FROM far_menu WHERE id='".$query->row()->parent_id."' LIMIT 1");
        $breadcrumb[] = array('name' => $query2->row()->name, 'class' => $query2->row()->controller, 'method' => $query2->row()->method, 'link' => $query2->row()->link);

        $reverse_breadcrumb = array_reverse($breadcrumb);

        if(strlen($reverse_breadcrumb[0]['name']) == 0){
            unset($reverse_breadcrumb[0]);
        }

        $final_breadcrumb = array_values($reverse_breadcrumb);

        return $final_breadcrumb;
    }

    public function list_all_group(){
        $query = $this->CI->db->query("SELECT * FROM user_groups");
        return $query->result_array();
    }

    function get_menu_by_class_method_group($class, $method, $ugrp_id){
        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE controller='".$class."' AND method='".$method."' AND FIND_IN_SET('".$ugrp_id."',group_id)");
        $row = $query->row_array();
        return $row;
    }

    function get_menu_by_class_method($class, $method){
        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE controller='".$class."' AND method='".$method."'");
        $row = $query->row_array();
        return $row;
    }

    function get_current_page_title(){
        $page_title = "";
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();

        $currentURL = current_url(); //http://myhost/main
        $params   = $_SERVER['QUERY_STRING']; //my_id=1,3
        $fullURL = $currentURL . '?' . $params;

        $full_method = str_replace(base_url().$class."/", '', $fullURL);

        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE controller='".$class."' AND method='".$full_method."'");
        if($query->num_rows() > 0){
            $page_title = $query->row()->page_title;
        }

        return $page_title;
    }

    function get_current_page_subtitle(){
        $page_title_small = "";
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();

        $currentURL = current_url(); //http://myhost/main
        $params   = $_SERVER['QUERY_STRING']; //my_id=1,3
        $fullURL = $currentURL . '?' . $params;

        $full_method = str_replace(base_url().$class."/", '', $fullURL);

        $query = $this->CI->db->query("SELECT * FROM far_menu WHERE controller='".$class."' AND method='".$full_method."'");
        if($query->num_rows() > 0){
            $page_title_small = $query->row()->page_title_small;
        }

        return $page_title_small;
    }

}


?>