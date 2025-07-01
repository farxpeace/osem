<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Far_setting {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    
    /**
     * User Role
     */
    function list_of_user_role(){
        $query = $this->CI->db->query("SELECT * FROM user_role WHERE user_role_status='active'");
        return $query->result_array();
    }
    function insert_user_role($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('user_role', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_user_role($user_role_id){
        $this->CI->db->delete('user_role', array('user_role_id' => $user_role_id)); 
    }
    function get_user_role($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_role WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_user_role($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('user_role', $data); 
    }
    function list_of_user_role_id_in_array(){
        $query = $this->CI->db->query("SELECT user_role_id FROM user_role WHERE user_role_status='active'");
        $rows = $query->result_array();
        $list_of_user_role_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_user_role_id_in_array[] = $b['user_role_id'];
        }
        return $list_of_user_role_id_in_array;
    }
    
    /**
     * Designation
     */
    function list_of_user_designation(){
        $query = $this->CI->db->query("SELECT * FROM user_designation WHERE user_designation_status='active'");
        return $query->result_array();
    }
    function insert_user_designation($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('user_designation', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_user_designation($user_designation_id){
        $this->CI->db->delete('user_designation', array('user_designation_id' => $user_designation_id)); 
    }
    function get_user_designation($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_designation WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_user_designation($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('user_designation', $data); 
    }
    function list_of_user_designation_id_in_array(){
        $query = $this->CI->db->query("SELECT user_designation_id FROM user_designation WHERE user_designation_status='active'");
        $rows = $query->result_array();
        $list_of_user_designation_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_user_designation_id_in_array[] = $b['user_designation_id'];
        }
        return $list_of_user_designation_id_in_array;
    }
    
    /**
     * Department
     */
    function list_of_user_department(){
        $query = $this->CI->db->query("SELECT * FROM user_department WHERE user_department_status='active'");
        return $query->result_array();
    }
    function insert_user_department($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('user_department', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_user_department($user_department_id){
        $this->CI->db->delete('user_department', array('user_department_id' => $user_department_id)); 
    }
    function get_user_department($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_department WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_user_department($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('user_department', $data); 
    }
    function list_of_user_department_id_in_array(){
        $query = $this->CI->db->query("SELECT user_department_id FROM user_department WHERE user_department_status='active'");
        $rows = $query->result_array();
        $list_of_user_department_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_user_department_id_in_array[] = $b['user_department_id'];
        }
        return $list_of_user_department_id_in_array;
    }
    
    /**
     * Machine
     */
    function list_of_skf_machine(){
        $query = $this->CI->db->query("SELECT * FROM skf_machine WHERE skf_machine_status='active'");
        return $query->result_array();
    }
    function insert_skf_machine($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_machine', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_machine($skf_machine_id){
        $this->CI->db->delete('skf_machine', array('skf_machine_id' => $skf_machine_id)); 
    }
    function get_skf_machine($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_machine WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_machine($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_machine', $data); 
    }
    function list_of_skf_machine_id_in_array(){
        $query = $this->CI->db->query("SELECT skf_machine_id FROM skf_machine WHERE skf_machine_status='active'");
        $rows = $query->result_array();
        $list_of_skf_machine_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_skf_machine_id_in_array[] = $b['skf_machine_id'];
        }
        return $list_of_skf_machine_id_in_array;
    }
    
    function is_skf_machine_id_active($skf_machine_id){
        $query = $this->CI->db->query("SELECT * FROM skf_machine WHERE skf_machine_id='".$skf_machine_id."' AND skf_machine_status='active' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * Issue
     */
    function list_of_skf_issue(){
        $query = $this->CI->db->query("SELECT * FROM skf_issue WHERE skf_issue_status='active' ORDER BY is_others ASC");
        return $query->result_array();
    }
    function insert_skf_issue($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_issue', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_issue($skf_issue_id){
        $this->CI->db->delete('skf_issue', array('skf_issue_id' => $skf_issue_id)); 
    }
    function get_skf_issue($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_issue WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_issue($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_issue', $data); 
    }
    function list_of_skf_issue_id_in_array(){
        $query = $this->CI->db->query("SELECT skf_issue_id FROM skf_issue WHERE skf_issue_status='active'");
        $rows = $query->result_array();
        $list_of_skf_issue_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_skf_issue_id_in_array[] = $b['skf_issue_id'];
        }
        return $list_of_skf_issue_id_in_array;
    }
    
    
    /**
     * Location
     */
    function list_of_skf_location(){
        $query = $this->CI->db->query("SELECT * FROM skf_location WHERE skf_location_status='active' ORDER BY is_others ASC");
        
        $list_of_skf_location = $query->result_array();
        //change to integer type
        foreach($list_of_skf_location as $a => $b){
            
            //get sublocation
            $list_of_skf_sublocation = $this->list_of_skf_sublocation($b['skf_location_id']);
            
            $list_of_skf_location[$a]['list_of_skf_sublocation'] = $list_of_skf_sublocation;
            
            
            
            $list_of_skf_location[$a]['skf_location_id'] = (integer)$list_of_skf_location[$a]['skf_location_id'];
        }
        
        return $list_of_skf_location;
    }
    function insert_skf_location($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_location', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_location($skf_location_id){
        $this->CI->db->delete('skf_location', array('skf_location_id' => $skf_location_id)); 
    }
    function get_skf_location($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_location WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_location($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_location', $data); 
    }
    function list_of_skf_location_id_in_array(){
        $query = $this->CI->db->query("SELECT skf_location_id FROM skf_location WHERE skf_location_status='active'");
        $rows = $query->result_array();
        $list_of_skf_location_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_skf_location_id_in_array[] = $b['skf_location_id'];
        }
        return $list_of_skf_location_id_in_array;
    }
    function is_skf_location_id_active($skf_location_id){
        $query = $this->CI->db->query("SELECT * FROM skf_location WHERE skf_location_id='".$skf_location_id."' AND skf_location_status='active' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * Sub Location
     */
    function list_of_skf_sublocation($skf_location_id = NULL){
        $where = "";
        if(strlen($skf_location_id) > 0){
            $where = "AND s.skf_location_id='".$skf_location_id."'";
        }
        $query = $this->CI->db->query("SELECT
            s.skf_sublocation_id,
            s.skf_location_id,
            l.skf_location_name,
            s.skf_sublocation_name,
            s.skf_sublocation_remarks,
            s.floor_plan_fullurl,
            s.is_others,
            s.is_none,
            s.skf_sublocation_status,
            s.create_dttm
        FROM skf_sublocation s 
        LEFT JOIN skf_location l ON l.skf_location_id=s.skf_location_id
         WHERE s.skf_sublocation_status='active' $where ORDER BY s.is_others ASC");
        
        
        
        $list_of_skf_sublocation = $query->result_array();
        //change to integer type
        foreach($list_of_skf_sublocation as $a => $b){
            $list_of_skf_sublocation[$a]['skf_location_id'] = (integer)$list_of_skf_sublocation[$a]['skf_location_id'];
            $list_of_skf_sublocation[$a]['skf_sublocation_id'] = (integer)$list_of_skf_sublocation[$a]['skf_sublocation_id'];
            
            $list_of_skf_sublocation[$a]['is_none'] = (integer)$list_of_skf_sublocation[$a]['is_none'];
        }
        
        return $list_of_skf_sublocation;
        
        
    }
    function insert_skf_sublocation($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_sublocation', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_sublocation($skf_sublocation_id){
        $this->CI->db->delete('skf_sublocation', array('skf_sublocation_id' => $skf_sublocation_id)); 
    }
    function get_skf_sublocation($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_sublocation WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_sublocation($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_sublocation', $data); 
    }
    function list_of_skf_sublocation_id_in_array(){
        $query = $this->CI->db->query("SELECT skf_sublocation_id FROM skf_sublocation WHERE skf_sublocation_status='active'");
        $rows = $query->result_array();
        $list_of_skf_sublocation_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_skf_sublocation_id_in_array[] = $b['skf_sublocation_id'];
        }
        return $list_of_skf_sublocation_id_in_array;
    }
    function is_skf_sublocation_id_active($skf_sublocation_id){
        $query = $this->CI->db->query("SELECT * FROM skf_sublocation WHERE skf_sublocation_id='".$skf_sublocation_id."' AND skf_sublocation_status='active' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * Cooling Tower Location
     */
    function list_of_checklist_location_cooling_tower(){
        $query = $this->CI->db->query("SELECT * FROM checklist_location_cooling_tower WHERE checklist_location_cooling_tower_status='active' ORDER BY is_others ASC");
        return $query->result_array();
    }
    function insert_checklist_location_cooling_tower($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('checklist_location_cooling_tower', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_checklist_location_cooling_tower($checklist_location_cooling_tower_id){
        $this->CI->db->delete('checklist_location_cooling_tower', array('checklist_location_cooling_tower_id' => $checklist_location_cooling_tower_id)); 
    }
    function get_checklist_location_cooling_tower($column, $value){
        $query = $this->CI->db->query("SELECT * FROM checklist_location_cooling_tower WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_checklist_location_cooling_tower($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('checklist_location_cooling_tower', $data); 
    }
    function list_of_checklist_location_cooling_tower_id_in_array(){
        $query = $this->CI->db->query("SELECT checklist_location_cooling_tower_id FROM checklist_location_cooling_tower WHERE checklist_location_cooling_tower_status='active'");
        $rows = $query->result_array();
        $list_of_checklist_location_cooling_tower_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_checklist_location_cooling_tower_id_in_array[] = $b['checklist_location_cooling_tower_id'];
        }
        return $list_of_checklist_location_cooling_tower_id_in_array;
    }
    function is_checklist_location_cooling_tower_id_active($checklist_location_cooling_tower_id){
        $query = $this->CI->db->query("SELECT * FROM checklist_location_cooling_tower WHERE checklist_location_cooling_tower_id='".$checklist_location_cooling_tower_id."' AND checklist_location_cooling_tower_status='active' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Compressor Location
     */
    function list_of_checklist_location_compressor(){
        $query = $this->CI->db->query("SELECT * FROM checklist_location_compressor WHERE checklist_location_compressor_status='active' ORDER BY is_others ASC");
        return $query->result_array();
    }
    function insert_checklist_location_compressor($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('checklist_location_compressor', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_checklist_location_compressor($checklist_location_compressor_id){
        $this->CI->db->delete('checklist_location_compressor', array('checklist_location_compressor_id' => $checklist_location_compressor_id)); 
    }
    function get_checklist_location_compressor($column, $value){
        $query = $this->CI->db->query("SELECT * FROM checklist_location_compressor WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_checklist_location_compressor($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('checklist_location_compressor', $data); 
    }
    function list_of_checklist_location_compressor_id_in_array(){
        $query = $this->CI->db->query("SELECT checklist_location_compressor_id FROM checklist_location_compressor WHERE checklist_location_compressor_status='active'");
        $rows = $query->result_array();
        $list_of_checklist_location_compressor_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_checklist_location_compressor_id_in_array[] = $b['checklist_location_compressor_id'];
        }
        return $list_of_checklist_location_compressor_id_in_array;
    }
    function is_checklist_location_compressor_id_active($checklist_location_compressor_id){
        $query = $this->CI->db->query("SELECT * FROM checklist_location_compressor WHERE checklist_location_compressor_id='".$checklist_location_compressor_id."' AND checklist_location_compressor_status='active' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Plant
     */
    function list_of_skf_plant(){
        $query = $this->CI->db->query("SELECT * FROM skf_plant WHERE skf_plant_status='active' ORDER BY is_others ASC");
        return $query->result_array();
    }
    function insert_skf_plant($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_plant', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_plant($skf_plant_id){
        $this->CI->db->delete('skf_plant', array('skf_plant_id' => $skf_plant_id)); 
    }
    function get_skf_plant($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_plant WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_plant($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_plant', $data); 
    }
    function list_of_skf_plant_id_in_array(){
        $query = $this->CI->db->query("SELECT skf_plant_id FROM skf_plant WHERE skf_plant_status='active'");
        $rows = $query->result_array();
        $list_of_skf_plant_id_in_array = array();
        foreach($rows as $a => $b){
            $list_of_skf_plant_id_in_array[] = $b['skf_plant_id'];
        }
        return $list_of_skf_plant_id_in_array;
    }
    /**
     * Category
     */
    function list_of_skf_category(){
        $query = $this->CI->db->query("SELECT * FROM skf_category WHERE skf_category_status='active' ORDER BY is_others ASC");
        $list_of_skf_category = $query->result_array();
        //change to integer type
        foreach($list_of_skf_category as $a => $b){
            
            //get sub-category
            $list_of_skf_subcategory = $this->list_of_skf_subcategory($b['skf_category_id']);
            $list_of_skf_category[$a]['list_of_skf_subcategory'] = $list_of_skf_subcategory;
            
            
            $list_of_skf_category[$a]['skf_category_id'] = (integer)$list_of_skf_category[$a]['skf_category_id'];
        }
        
        return $list_of_skf_category;
    }
    function insert_skf_category($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_category', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_category($skf_category_id){
        $this->CI->db->delete('skf_category', array('skf_category_id' => $skf_category_id)); 
    }
    function get_skf_category($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_category WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_category($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_category', $data); 
    }
    
    /**
     * Sub Category
     */
    function list_of_skf_subcategory($skf_category_id = NULL){
        if(strlen($skf_category_id) > 0){
            $select_category_id = "AND c.skf_category_id='".$skf_category_id."'";
        }
        
        
        $query = $this->CI->db->query("SELECT
            s.skf_subcategory_id,
            c.skf_category_id,
            c.skf_category_name,
            s.skf_subcategory_name,
            s.skf_subcategory_status,
            s.is_others,
            s.is_none
        FROM skf_subcategory s
        
        LEFT JOIN skf_category c ON c.skf_category_id=s.skf_category_id
        
         WHERE s.skf_subcategory_status='active' $select_category_id ORDER BY s.is_others ASC");
         
         $list_of_skf_subcategory = $query->result_array();
        //change to integer type
        foreach($list_of_skf_subcategory as $a => $b){
            $list_of_skf_subcategory[$a]['skf_subcategory_id'] = (integer)$list_of_skf_subcategory[$a]['skf_subcategory_id'];
            $list_of_skf_subcategory[$a]['skf_category_id'] = (integer)$list_of_skf_subcategory[$a]['skf_category_id'];
            
            $list_of_skf_subcategory[$a]['is_none'] = (integer)$list_of_skf_subcategory[$a]['is_none'];
        }
         
         
        return $list_of_skf_subcategory;
    }
    function insert_skf_subcategory($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_subcategory', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_subcategory($skf_subcategory_id){
        $this->CI->db->delete('skf_subcategory', array('skf_subcategory_id' => $skf_subcategory_id)); 
    }
    function get_skf_subcategory($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_subcategory WHERE ".$column."='".$value."'");
        $subcategory_detail = $query->row_array() ? $query->row_array() : array();
        return $subcategory_detail;
    }
    function update_skf_subcategory($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_subcategory', $data); 
    }
    
    /**
     * Resolution Method
     */
    function list_of_skf_resolution_method(){
        $query = $this->CI->db->query("SELECT * FROM skf_resolution_method WHERE skf_resolution_method_status='active' ORDER BY is_others ASC");
        return $query->result_array();
    }
    function is_active_skf_resolution_method($skf_resolution_method_id){
        $query = $this->CI->db->query("SELECT * FROM skf_resolution_method WHERE skf_resolution_method_id='".$skf_resolution_method_id."' AND skf_resolution_method_status='active'");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    function insert_skf_resolution_method($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('skf_resolution_method', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_skf_resolution_method($skf_resolution_method_id){
        $this->CI->db->delete('skf_resolution_method', array('skf_resolution_method_id' => $skf_resolution_method_id)); 
    }
    function get_skf_resolution_method($column, $value){
        $query = $this->CI->db->query("SELECT * FROM skf_resolution_method WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_skf_resolution_method($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('skf_resolution_method', $data); 
    }
    
     /**
     * Checklist
     */
    function get_checklist_category_with_items($checklist_category_id){
        $output = array();
        $this->CI->load->library('skf/far_checklist');
        
        $checklist_category_detail = $this->get_checklist_category('checklist_category_id', $checklist_category_id);
        
        $output['checklist_category_detail'] = $checklist_category_detail;
        $output['populate_form'] = $this->CI->far_checklist->populate_form_by_checklist_category_code($checklist_category_detail['checklist_category_code']);
        
        
        return $output;
    }
    function list_of_checklist_category(){
        $query = $this->CI->db->query("SELECT * FROM checklist_category WHERE checklist_category_status='active' ORDER BY is_others ASC");
        return $query->result_array();
    }
    function insert_checklist_category($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('checklist_category', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_checklist_category($checklist_category_id){
        $this->CI->db->delete('checklist_category', array('checklist_category_id' => $checklist_category_id)); 
    }
    function get_checklist_category($column, $value){
        $query = $this->CI->db->query("SELECT * FROM checklist_category WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_checklist_category($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('checklist_category', $data); 
    }
    function is_checklist_item_id_exists($checklist_item_id, $checklist_category_id){
        $query = $this->CI->db->query("SELECT * FROM checklist_item WHERE checklist_item_id='".$checklist_item_id."' AND checklist_category_id='".$checklist_category_id."' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Inovar Unit
     */
    function list_of_inovar_defect_type(){
        $query = $this->CI->db->query("SELECT * FROM inovar_defect_type WHERE inovar_defect_type_status='active' ORDER BY is_others ASC");
        $list_of_inovar_defect_type = $query->result_array();
        //change to integer type
        foreach($list_of_inovar_defect_type as $a => $b){
            $list_of_inovar_defect_type[$a]['inovar_defect_type_id'] = (integer)$list_of_inovar_defect_type[$a]['inovar_defect_type_id'];
            $list_of_inovar_defect_type[$a]['is_others'] = (integer)$list_of_inovar_defect_type[$a]['is_others'];
        }
        
        return $list_of_inovar_defect_type;
    }
    function insert_inovar_defect_type($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('inovar_defect_type', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_inovar_defect_type($inovar_defect_type_id){
        $this->CI->db->delete('inovar_defect_type', array('inovar_defect_type_id' => $inovar_defect_type_id)); 
    }
    function get_inovar_defect_type($column, $value){
        $query = $this->CI->db->query("SELECT * FROM inovar_defect_type WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_inovar_defect_type($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('inovar_defect_type', $data); 
    }
    
    /**
     * Inovar Area FIeld
     */
    function list_of_inovar_area_field(){
        $query = $this->CI->db->query("SELECT * FROM inovar_area_field WHERE inovar_area_field_status='active' ORDER BY is_others ASC");
        $list_of_inovar_area_field = $query->result_array();
        //change to integer type
        foreach($list_of_inovar_area_field as $a => $b){
            $list_of_inovar_area_field[$a]['inovar_area_field_id'] = (integer)$list_of_inovar_area_field[$a]['inovar_area_field_id'];
            $list_of_inovar_area_field[$a]['is_others'] = (integer)$list_of_inovar_area_field[$a]['is_others'];
        }
        
        return $list_of_inovar_area_field;
    }
    function insert_inovar_area_field($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('inovar_area_field', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_inovar_area_field($inovar_area_field_id){
        $this->CI->db->delete('inovar_area_field', array('inovar_area_field_id' => $inovar_area_field_id)); 
    }
    function get_inovar_area_field($column, $value){
        $query = $this->CI->db->query("SELECT * FROM inovar_area_field WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_inovar_area_field($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('inovar_area_field', $data); 
    }
    
    /**
     * Inovar Materials
     */
    function list_of_inovar_materials(){
        $query = $this->CI->db->query("SELECT * FROM inovar_materials WHERE inovar_materials_status='active' ORDER BY is_others ASC");
        $list_of_inovar_materials = $query->result_array();
        //change to integer type
        foreach($list_of_inovar_materials as $a => $b){
            $list_of_inovar_materials[$a]['inovar_materials_id'] = (integer)$list_of_inovar_materials[$a]['inovar_materials_id'];
            $list_of_inovar_materials[$a]['is_others'] = (integer)$list_of_inovar_materials[$a]['is_others'];
        }
        
        return $list_of_inovar_materials;
    }
    function insert_inovar_materials($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('inovar_materials', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_inovar_materials($inovar_materials_id){
        $this->CI->db->delete('inovar_materials', array('inovar_materials_id' => $inovar_materials_id)); 
    }
    function get_inovar_materials($column, $value){
        $query = $this->CI->db->query("SELECT * FROM inovar_materials WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_inovar_materials($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('inovar_materials', $data); 
    }
    
    /**
     * Inovar Materials
     */
    function list_of_inovar_delivery_options(){
        $query = $this->CI->db->query("SELECT * FROM inovar_delivery_options WHERE inovar_delivery_options_status='active' ORDER BY is_others ASC");
        $list_of_inovar_delivery_options = $query->result_array();
        //change to integer type
        foreach($list_of_inovar_delivery_options as $a => $b){
            $list_of_inovar_delivery_options[$a]['inovar_delivery_options_id'] = (integer)$list_of_inovar_delivery_options[$a]['inovar_delivery_options_id'];
            $list_of_inovar_delivery_options[$a]['is_others'] = (integer)$list_of_inovar_delivery_options[$a]['is_others'];
        }
        
        return $list_of_inovar_delivery_options;
    }
    function insert_inovar_delivery_options($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('inovar_delivery_options', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_inovar_delivery_options($inovar_delivery_options_id){
        $this->CI->db->delete('inovar_delivery_options', array('inovar_delivery_options_id' => $inovar_delivery_options_id)); 
    }
    function get_inovar_delivery_options($column, $value){
        $query = $this->CI->db->query("SELECT * FROM inovar_delivery_options WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_inovar_delivery_options($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('inovar_delivery_options', $data); 
    }
    
    /**
     * Inovar Project
     */
    function list_of_inovar_project(){
        $query = $this->CI->db->query("SELECT * FROM inovar_project WHERE inovar_project_status='active' ORDER BY is_others ASC");
        $list_of_inovar_project = $query->result_array();
        //change to integer type
        foreach($list_of_inovar_project as $a => $b){
            $list_of_inovar_project[$a]['inovar_project_id'] = (integer)$list_of_inovar_project[$a]['inovar_project_id'];
            $list_of_inovar_project[$a]['is_others'] = (integer)$list_of_inovar_project[$a]['is_others'];
        }
        
        return $list_of_inovar_project;
    }
    function insert_inovar_project($data){
        $data['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('inovar_project', $data); 
        return $this->CI->db->insert_id();
    }
    function delete_inovar_project($inovar_project_id){
        $this->CI->db->delete('inovar_project', array('inovar_project_id' => $inovar_project_id)); 
    }
    function get_inovar_project($column, $value){
        $query = $this->CI->db->query("SELECT * FROM inovar_project WHERE ".$column."='".$value."'");
        $category_detail = $query->row_array() ? $query->row_array() : array();
        return $category_detail;
    }
    function update_inovar_project($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('inovar_project', $data); 
    }
    
    
}

?>