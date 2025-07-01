<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$this->CI->db->escape_str()
class Far_users {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function get_user_detail_from_view($uacc_id){
        $output = array();
        $query = $this->CI->db->query("
            SELECT * FROM view_user_list WHERE uacc_id='".$uacc_id."'
        ");

        if($query->num_rows() > 0){

            $output = $query->row_array();

            foreach($output as $a => $b){
                if(strpos($a, "_id") !== false){
                    $output[$a] = (int)$b;
                }elseif(is_array($b)){
                    foreach($b as $c => $d){
                        if(strpos($c, "_id") !== false){
                            $output[$a][$c] = (int)$d;
                        }
                    }
                }
            }



        }

        return $output;
    }

    function get_user_simple($uacc_id){
        $output = array();

        $query = $this->CI->db->query("SELECT
            v.uacc_id,
            v.uacc_username,
            v.uacc_group_fk AS ugrp_id,
            v.uacc_group_fk,
            v.ugrp_name,
            v.fullname,
            v.gender,
            v.email,
            v.mobile_number,
            v.profile_picture_url
         FROM view_user_list v


         WHERE v.uacc_id='".$uacc_id."'");
        if($query->num_rows() > 0){
            $user_detail = $query->row_array();
            $is_profile_completed_array = array();

            if(strlen($user_detail['fullname']) < 2){
                $is_profile_completed_array[] = "no";
            }
            if(in_array("no", $is_profile_completed_array)){
                $is_profile_completed = "no";
            }else{
                $is_profile_completed = "yes";
            }
            $user_detail['is_profile_completed'] = $is_profile_completed;


            $output = $user_detail;
        }

        return $output;
    }



    /**
     * Get User Account
     */
    function get_account($column, $value){
        $output = [];
        $query = $this->CI->db->query("SELECT * FROM user_accounts WHERE ".$column."='".$this->CI->db->escape_str($value)."'");
        if($query->num_rows() > 0){
            $output = $query->row_array();
            $this->refix_user_profiles($output['uacc_id']);
        }
        return $output;
    }

    function is_user_exists($uacc_id){
        $query = $this->CI->db->query("SELECT uacc_id FROM user_accounts WHERE uacc_id='".$uacc_id."'");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function is_username_exists($uacc_username){
        $query = $this->CI->db->query("SELECT uacc_id FROM user_accounts WHERE uacc_username='".$uacc_username."'");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    function is_email_exists($email_address){
        $query = $this->CI->db->query("SELECT uacc_id FROM user_accounts WHERE uacc_email='".$email_address."'");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    function is_badge_no_exists($badge_no){
        $query = $this->CI->db->query("SELECT uacc_id FROM user_accounts WHERE badge_no='".$badge_no."'");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function get_user($column, $value){
        $user_detail = array();
        $query = $this->CI->db->query("SELECT * FROM user_accounts WHERE ".$column."='".$this->CI->db->escape_str($value)."'");
        if($query->num_rows() > 0){
            $user_detail = $query->row_array();
            $this->refix_user_profiles($user_detail['uacc_id']);
            $user_detail['ugrp_id'] = $user_detail['uacc_group_fk'];

            //user group
            $query2 = $this->CI->db->query("SELECT * FROM user_groups WHERE ugrp_id='".$user_detail['uacc_group_fk']."'");
            $user_detail['user_group_detail'] = $query2->row_array();

            //user profile
            $query3 = $this->CI->db->query("SELECT * FROM user_profiles WHERE uacc_id='".$user_detail['uacc_id']."'");
            $user_detail['user_profile'] = $query3->row_array();


            //profile_picture_url
            $user_detail['user_profile']['profile_picture_url'] = $user_detail['user_profile']['profile_picture_url'] ?? base_url().'assets/lead/logo/logo-transparent-96x96-spinner.png';




        }



        return $user_detail;
    }

    function count_marketing_visitor($uacc_id){
        $query = $this->CI->db->query("SELECT COUNT(marketing_visitor_id) AS total_visitor FROM marketing_visitor WHERE uacc_id='".$uacc_id."'");
        return $query->row()->total_visitor;
    }

    function get_user_by_column($column, $value, $column_name){
        $query = $this->CI->db->query("SELECT ".$column_name." FROM user_accounts WHERE ".$column."='".$this->CI->db->escape_str($value)."'");
        $row = $query->row_array();
        return $row[$column_name];
    }

    function list_account($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_accounts WHERE ".$column."='".$this->CI->db->escape_str($value)."'");
        return $query->result_array();
    }

    /**
     * Get Profile
     */
    function get_profile($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_profiles WHERE ".$column."='".$this->CI->db->escape_str($value)."'");
        $row = $query->row_array();
        if(count($row) > 0){
            $this->refix_user_profiles($row['uacc_id']);
            //profilepic_url
            if(isset($row['profile_picture_url']) && strlen($row['profile_picture_url']) < 5){
                $row['profile_picture'] = $this->CI->far_meta->get_value('default_profile_picture');
            }

            $row['user_department_id'] = (integer)$row['user_department_id'];
            $row['user_designation_id'] = (integer)$row['user_designation_id'];
        }

        return $row;
    }

    function get_profile_by_column($column, $value, $column_name){
        $query = $this->CI->db->query("SELECT ".$column_name." FROM user_profiles WHERE ".$column."='".$this->CI->db->escape_str($value)."'");
        $row = $query->row_array();
        return $row[$column_name];
    }

    function insert_profile($data = array()){
        $this->CI->db->insert('user_profiles', $data);
        return $this->CI->db->insert_id();
    }

    function update_profile($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );

        $this->CI->db->where($key, $this->CI->db->escape_str($key_value));
        $this->CI->db->update('user_profiles', $data);
    }

    /**
     * Department
     */
    function list_all_user_department(){
        $query = $this->CI->db->query("SELECT * FROM user_department WHERE user_department_status='active'");
        return $query->result_array();
    }
    function list_user_department_id_in_array(){
        $list_all_user_department = $this->list_all_user_department();
        $output = array();
        foreach($list_all_user_department as $a => $b){
            $output[] = $b['user_department_id'];
        }
        return $output;
    }
    function get_user_department($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_department WHERE ".$column."='".$value."'");
        $row = $query->row_array();

        $row['user_department_id'] = (integer)$row['user_department_id'];

        return $row;
    }

    /**
     * Designation
     */
    function list_all_user_designation(){
        $query = $this->CI->db->query("SELECT * FROM user_designation WHERE user_designation_status='active'");
        return $query->result_array();
    }
    function list_user_designation_id_in_array(){
        $list_all_user_designation = $this->list_all_user_designation();
        $output = array();
        foreach($list_all_user_designation as $a => $b){
            $output[] = $b['user_designation_id'];
        }
        return $output;
    }
    function get_user_designation($column, $value){
        $query = $this->CI->db->query("SELECT * FROM user_designation WHERE ".$column."='".$value."'");
        $row = $query->row_array();

        $row['user_designation_id'] = (integer)$row['user_designation_id'];

        return $row;
    }

    /**
     * User Role
     */
    function get_user_role($user_role_id){
        $query = $this->CI->db->query("SELECT * FROM user_role WHERE user_role_id='".$user_role_id."'");
        return $query->row_array();
    }

    function list_all_user_role(){
        $query = $this->CI->db->query("SELECT * FROM user_role WHERE user_role_status='active'");
        return $query->result_array();
    }
    function list_user_role_id_in_array(){
        $list_all_user_role = $this->list_all_user_role();
        $output = array();
        foreach($list_all_user_role as $a => $b){
            $output[] = $b['user_role_id'];
        }
        return $output;
    }
    function list_all_users_by_role($user_role_id){
        $query = $this->CI->db->query("
            SELECT
                u.uacc_id,
                p.fullname


            FROM user_accounts u
            LEFT JOIN user_profiles p
            ON u.uacc_id=p.uacc_id

            WHERE p.user_role_id='".$user_role_id."'");
        return $query->result_array();
    }

    function list_all_user(){
        $query = $this->CI->db->query("
            SELECT
                *
            FROM view_user_list

            WHERE uacc_group_fk='6'");
        return $query->result_array();
    }

    function list_all_staff(){
        $query = $this->CI->db->query("
            SELECT
                u.uacc_id,
                p.fullname


            FROM user_accounts u
            LEFT JOIN user_profiles p
            ON u.uacc_id=p.uacc_id

            WHERE u.uacc_group_fk='4'");
        return $query->result_array();
    }

    /**
     * Get Group Detail
     */
    function get_group($ugrp_id){
        $query = $this->CI->db->query("SELECT * FROM user_groups WHERE ugrp_id='".$ugrp_id."'");
        return $query->row_array();
    }

    function get_user_group($uacc_id){
        $query = $this->CI->db->query("SELECT ugrp_id,ugrp_name,ugrp_desc,ugrp_admin FROM user_accounts u LEFT JOIN user_groups g ON u.uacc_group_fk=g.ugrp_id WHERE u.uacc_id='".$uacc_id."'");
        return $query->row_array();
    }

    function update_user($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );

        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('user_accounts', $data);
    }

    function list_all_user_group(){
        $query = $this->CI->db->query("SELECT * FROM user_groups");
        return $query->result_array();
    }

    /**
     * List All user accounts and profile
     * @param array $exclude_array_group_id Group ID to exclude from the list. If no specified, will show all group
     * @param array $exclude_array_user_id User Accounts ID (uacc_id) to exclude from the list. If no specified, will show all group
     *@return array
     */
    function list_all_users(){

        $query = $this->CI->db->query("
        SELECT
            u.uacc_id,u.uacc_group_fk,u.uacc_username,p.firstname,p.lastname,u.uacc_email
        FROM user_accounts u LEFT JOIN user_profiles p
        ON u.uacc_id=p.uacc_id");
        return $query->result_array();



    }
    function delete_user($uacc_id){
        //make sure user is a user
        $user_detail = $this->get_user('uacc_id', $uacc_id);
        if($user_detail['uacc_group_fk'] == '4'){



            //delete user profiles
            $this->CI->db->where('uacc_id', $user_detail['uacc_id']);
            $this->CI->db->delete('user_profiles');
            //delete user_accounts
            $this->CI->db->where('uacc_id', $user_detail['uacc_id']);
            $this->CI->db->delete('user_accounts');


        }elseif($user_detail['uacc_group_fk'] == '5'){
            //delete user profiles
            $this->CI->db->where('uacc_id', $user_detail['uacc_id']);
            $this->CI->db->delete('user_profiles');
            //delete user_accounts
            $this->CI->db->where('uacc_id', $user_detail['uacc_id']);
            $this->CI->db->delete('user_accounts');


        }
    }


    function check_if_already_registered($phonemobile){

        $query = $this->CI->db->query("
            SELECT
                u.uacc_id,
                u.uacc_username,
                COALESCE(p.nickname, '') AS nickname,
                p.profilepic_url AS profilepic_url
            FROM user_accounts u
            LEFT JOIN user_profiles p ON u.uacc_id=p.uacc_id
            WHERE u.uacc_username='".$phonemobile."'
        ");
        $rows = $query->row_array();
        if(count($rows) > 0){
            $output = $rows;
        }else{
            $output = FALSE;
        }
        return $output;
    }

    function check_if_already_registered_and_verified($uacc_id){
        $query = $this->CI->db->query("
            SELECT
                u.uacc_id,
                u.uacc_username,
                COALESCE(p.nickname, '') AS nickname,
                p.profilepic_url AS profilepic_url
            FROM user_accounts u
            LEFT JOIN user_profiles p ON u.uacc_id=p.uacc_id
            WHERE u.uacc_id='".$uacc_id."'
            AND u.sms_verified='yes'
        ");
        $rows = $query->row_array();
        if(count($rows) > 0){
            $output = $rows;
        }else{
            $output = FALSE;
        }
        return $output;
    }

    function change_password($uacc_id, $new_password){
        $this->CI->load->model('flexi_auth_model');
        $change_password = $this->CI->flexi_auth_model->change_password_new($uacc_id, $new_password);
        if($change_password){
            //$this->update_user('uacc_id', $uacc_id, 'uacc_raw_password', $new_password);
            $this->update_user('uacc_id', $uacc_id, 'reset_password_auth_key', '');
            return true;
        }else{
            return false;
        }
    }













    function generate_qrcontent_if_not_exists($uacc_id){
        $qr_content_db = $this->get_user_by_column('uacc_id', $uacc_id, 'qr_content');
        if(strlen($qr_content_db) < 5){
            $qr_content_db = "O".$uacc_id."O".$this->CI->far_helper->generateRandomString(20, '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ')."O".($uacc_id+1042);
            $this->update_user('uacc_id', $uacc_id, 'qr_content', $qr_content_db);
        }

        return $qr_content_db;
    }

    function decrypt_qr_content($qr_content){
        $x = explode("O", $qr_content);

        $uacc_id = $x[1];
        $secret_code = $x[3];
        if($uacc_id+1042 == $secret_code){
            $this->CI->load->library('far_api');
            $output = $this->CI->far_api->output_user_detail($uacc_id);
            return $output;
        }else{
            return false;
        }
    }

    function create_mykad_attachment($extradata = null){
        $extradata['create_dttm'] = date("Y-m-d H:i:s");
        $this->CI->db->insert('mykad_attachment', $extradata);
        return $this->CI->db->insert_id();
    }
    function list_mykad_attachment_active($uacc_id){
        $list_mykad_attachment_active = array();
        $query = $this->CI->db->query("SELECT * FROM mykad_attachment WHERE uacc_id='".$uacc_id."' AND status='active'");
        if($query->num_rows() > 0){
            $list_mykad_attachment_active = $query->result_array();
            foreach($list_mykad_attachment_active as $a => $b){
                if($b['verification_status'] == 'pending_admin_verification'){
                    $list_mykad_attachment_active[$a]['status_text'] = "Processing";
                    $list_mykad_attachment_active[$a]['status_sub_text'] = "We are currently processing your MyKad. You still can upload new MyKad Front image by clicking 'Camera Button' above";
                }
            }
        }
        return $list_mykad_attachment_active;
    }
    function get_mykad_attachment($mykad_attachment_id){
        $query = $this->CI->db->query("SELECT * FROM mykad_attachment WHERE mykad_attachment_id='".$mykad_attachment_id."'");
        return $query->row_array();
    }
    function update_mykad_attachment($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('mykad_attachment', $data);
    }

    /**
     * Virtual Account Number
     */
    function get_virtual_account_number($uacc_id){
        $virtual_account_number = $uacc_id*87448448;
        return $virtual_account_number;
    }
    function get_uacc_id_from_virtual_account_number($virtual_account_number){
        $uacc_id = $virtual_account_number/87448448;
        return $uacc_id;
    }


    function check_and_regenerate_referral_cookie(){
        $this->CI->load->helper('cookie');
        $new_alias_url_name = $this->CI->input->get('alias_url_name') ?? "";

        if(strlen($new_alias_url_name) > 0){
            //check if valid
            $new_user_detail = $this->get_user('alias_url_name', $new_alias_url_name);
            $final_user_detail = $new_user_detail;
            $final_alias_url_name = $new_alias_url_name;
            //echo print_r($new_user_detail); exit();
        }else{

            //get cookie
            $stored_alias_url_name = get_cookie('alias_url_name') ?? "";
            if(strlen($stored_alias_url_name) > 4){

                //check if valid
                $stored_user_detail = $this->get_user('alias_url_name', $stored_alias_url_name);
                $final_user_detail = $stored_user_detail;
                $final_alias_url_name = $stored_alias_url_name;
            }else{
                //no stored referral or invalid. Reset to default
                $default_upline = $this->get_random_upline();
                $final_user_detail = $default_upline;
                $final_alias_url_name = $default_upline['alias_url_name'];
            }

        }

        //check if user deleted
        if(!isset($final_user_detail)){
            $default_upline = $this->get_random_upline();
            $final_user_detail = $default_upline;
            $final_alias_url_name = $default_upline['alias_url_name'];
        }

        //set cookie again
        set_cookie('alias_url_name', $final_alias_url_name, time() + (10 * 365 * 24 * 60 * 60));

        return $final_user_detail;
    }

    function get_random_upline(){
        $uacc_id = 1;
        $random_upline_detail = $this->get_user('uacc_id', $uacc_id);
        return $random_upline_detail;
    }

    function check_valid_username($alias_url_name){
        $output = "ok";
        if ($alias_url_name == trim($alias_url_name) && str_contains($alias_url_name, ' ')) {
            $output = "Error. Username cannot have spaces";
        }
        if(preg_match('/[A-Z]/', $alias_url_name)){
            $output = "Username cannot have Capital letter";
        }
        if(preg_match_all("/[0-9]/", $alias_url_name ) > 2){
            $output = "Username only can have maximum 2 digits";
        }elseif(preg_match_all("/[0-9]/", $alias_url_name ) <= 2 && preg_match_all("/[0-9]/", $alias_url_name ) != 0){

            if(!preg_match('/[a-z]+[0-9]+/i', $alias_url_name)){
                $output = "Digits must be at last string";
            }elseif(preg_match('/[a-z]+[0-9]+[a-z]+/i', $alias_url_name)){
                $output = "Digits cannot in the middle";
            }
        }
        if(strlen($alias_url_name) <= 5){
            $output = "Username must be more than 5 characters";
        }else{
            if(strlen($alias_url_name) > 8){
                $output = "Username must be below than 8 characters";
            }
        }

        //check agains database for banned keyword
        $banned_keywords = explode(",",$this->CI->far_meta->get_value('banned_username_keyword'));
        foreach ($banned_keywords as $keyword) {
            if (strpos($alias_url_name, $keyword) !== FALSE) { // Yoshi version
                $output = "Username contains banned keyword (".$keyword.")";
                break;
            }
        }

        if($this->is_username_exists($alias_url_name)){
            $output = "Username already taken";
        }

        $list_codeigniter_function = [];


        $this->CI->load->helper('file');
        $controllers = get_filenames( APPPATH . 'controllers/' );
        foreach( $controllers as $k => $v ){
            if( strpos( $v, '.php' ) === FALSE){
                unset( $controllers[$k] );
            }
        }

        foreach( $controllers as $controller ){

            $withoutExt = preg_replace('/\.\w+$/', '', $controller);
            $list_codeigniter_function[] = strtolower($withoutExt);
            include_once APPPATH . 'controllers/' . $controller;

            $className = str_replace( '.php', '', $controller );
            try {
                $methods = get_class_methods( $className );
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }



            foreach( $methods as $method ){
                $list_codeigniter_function[] = strtolower($method);
            }
        }
        foreach ($list_codeigniter_function as $keyword) {
            if (strpos($alias_url_name, $keyword) !== FALSE) { // Yoshi version
                $output = "Username contains banned keyword (".$keyword.")";
                break;
            }
        }



        return $output;
    }

    function check_valid_password($password, $password_confirm){
        $output = "ok";
        //check length
        if(strlen($password) < 8){
            $output = "Password must be more than 8 characters";
        }else{
            if(preg_match_all("/[0-9]/", $password ) == 0){
                $output = "Password must have atleast 1 digits";
            }else{
                if($password != $password_confirm){
                    $output = "Please confirm your password correctly";
                }
            }
        }



        return $output;
    }

    function refix_user_profiles($uacc_id){
        $query = $this->CI->db->query("SELECT uacc_id FROM user_profiles WHERE uacc_id='".$uacc_id."'");
        if($query->num_rows() > 1){
            //delete
            echo "DELETE";
        }
    }

}


?>
