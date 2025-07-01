<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include APPPATH . 'third_party/myic.class.php';
class Attendance extends MY_Controller
{
    private $user;

    function __construct()
    {
        parent::__construct();
        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }
        // Load required CI libraries and helpers.
        $this->load->database();
        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;
        // Load 'standard' flexi auth library by default.
        $this->load->library('flexi_auth');
        if (!$this->flexi_auth->is_logged_in_via_password() || !$this->flexi_auth->is_admin()) {
            // Set a custom error message.
            $this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
        // Define a global variable to store data that is then used by the end view page.
        $this->data = null;
        $this->user = $this->far_users->get_user('uacc_id', $this->flexi_auth->get_user_id());
        $this->global_pass_to_view();
    }

    public function global_pass_to_view()
    {
        $this->data['logged_in'] = $this->user;
        if ($this->flexi_auth->is_admin()) {
            $this->data['logged_in']['is_admin'] = true;
        }
    }

    function today_attendance_summary(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);

        //calculate shift date
        $calculate_shift_date = $this->far_attendance->calculate_shift_date(date("Y-m-d H:i:s"));
        $this->data['calculate_shift_date'] = $calculate_shift_date;
        //check unfinished attendance
        $unfinished_attendance = $this->far_attendance->get_unfinished_clockin($this->user['uacc_id'],$calculate_shift_date['shift_date']);
        $this->data['unfinished_attendance'] = $unfinished_attendance;

        //attendance detail
        $attendance_detail = $this->far_attendance->get_attendance_detail_by_shift_date($this->user['uacc_id'], $calculate_shift_date['shift_date']);
        $this->data['attendance_detail'] = $attendance_detail;

        $is_already_clockout = "no";
        if($this->far_attendance->is_already_clockout_by_date($this->user['uacc_id'],$calculate_shift_date['shift_date'])){
            $is_already_clockout = "yes";
        }
        $this->data['is_already_clockout'] = $is_already_clockout;

        $this->load->view('attendance/user/today_attendance_summary', $this->data);
    }

    function start_clockin(){
        $this->load->library('far_tac');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        //calculate shift date
        $calculate_shift_date = $this->far_attendance->calculate_shift_date(date("Y-m-d H:i:s"));
        if($calculate_shift_date['eligible_to_clockin_clockout'] == "no"){
            $error['clockin_dttm'] = "Not eligible to clockin";
        }else{

            $shift_date = $calculate_shift_date['shift_date'];
            //check unfinished attendance
            $unfinished_attendance = $this->far_attendance->get_unfinished_clockin($this->user['uacc_id'],$shift_date);
            if(count($unfinished_attendance) > 0){
                $error['clockin_dttm'] = "You already clockin today";
            }
        }

        if($this->far_attendance->is_already_checkin_today($this->user['uacc_id'], $shift_date)){
            $error['clockin_dttm'] = "You already clock-in today.";
        }

        if(count($error) == 0){

            $attendance_id = $this->far_attendance->start_clockin($this->user['uacc_id'], $shift_date);
            $attendance_detail = $this->far_attendance->get_attendance_detail($attendance_id);


            $redirect_url = base_url()."auth_admin/dashboard/";

            $output['redirect_url'] = $redirect_url;
            $output['response_html'] = "Clock-In success for today<br><br> (".$this->far_date->convert_format($attendance_detail['shift_date'],'D, j M Y').")";
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function start_clockout(){
        $this->load->library('far_tac');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        //calculate shift date
        $calculate_shift_date = $this->far_attendance->calculate_shift_date(date("Y-m-d H:i:s"));
        if($calculate_shift_date['eligible_to_clockin_clockout'] == "no"){
            $error['clockin_dttm'] = "Not eligible to clockout";
        }else{

            $shift_date = $calculate_shift_date['shift_date'];
            //check unfinished attendance
            $unfinished_attendance = $this->far_attendance->get_unfinished_clockin($this->user['uacc_id'],$shift_date);
            if(count($unfinished_attendance) == 0){
                $error['clockin_dttm'] = "You havent clockin yet";
            }
        }

        if($this->far_attendance->is_already_clockout_by_date($this->user['uacc_id'],$shift_date)){
            $error['clockin_dttm'] = "Already clock out";
        }




        if(count($error) == 0){


            //echo "<pre>"; print_r($unfinished_attendance); exit();


            $attendance_id = $this->far_attendance->start_clockout($unfinished_attendance['attendance_id']);

            $redirect_url = base_url()."auth_admin/dashboard/";

            $output['redirect_url'] = $redirect_url;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function monthly_history(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $filter_month = $this->input->get('filter_month') ?? 0;
        $filter_year = $this->input->get('filter_year') ?? 0;

        if($filter_month == 0){ $filter_month = date("m"); }
        if($filter_year == 0){ $filter_year = date("Y"); }

        $this->data['filter_month'] = $filter_month;
        $this->data['filter_year'] = $filter_year;

        $list_clockin_clockout_by_month_year = $this->far_attendance->list_clockin_clockout_by_month_year($this->user['uacc_id'],$filter_month, $filter_year);
        $this->data['list_clockin_clockout_by_month_year'] = $list_clockin_clockout_by_month_year;

        $total_pay_by_month_year = $this->far_attendance->total_pay_by_month_year($this->user['uacc_id'], $filter_month, $filter_year);
        $this->data['total_pay_by_month_year'] = $total_pay_by_month_year;

        $this->load->view('attendance/user/monthly_history', $this->data);
    }

    function attendance_by_date(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);
        $filter_date = $this->input->get('filter_date') ?? 0;
        if($filter_date == 0){ $filter_date = date("Y-m-d"); }
        $this->data['filter_date'] = $filter_date;

        //attendance detail
        $attendance_detail = $this->far_attendance->get_attendance_detail_by_shift_date($this->user['uacc_id'], $filter_date);
        $this->data['attendance_detail'] = $attendance_detail;

        $this->load->view('attendance/user/attendance_by_date', $this->data);
    }



    function start_clockout_new(){
        $this->load->library('far_tac');
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        //calculate shift date
        $calculate_shift_date = $this->far_attendance->calculate_shift_date(date("Y-m-d H:i:s"));
        if($calculate_shift_date['eligible_to_clockin_clockout'] == "no"){
            $error['clockin_dttm'] = "Not eligible to clockout";
        }else{

            $shift_date = $calculate_shift_date['shift_date'];
            //check unfinished attendance
            $unfinished_attendance = $this->far_attendance->get_unfinished_clockin($this->user['uacc_id'],$shift_date);
            if(count($unfinished_attendance) == 0){
                $error['clockin_dttm'] = "You havent clockin yet";
            }
        }

        if($this->far_attendance->is_already_clockout_by_date($this->user['uacc_id'],$shift_date)){
            $error['clockin_dttm'] = "Already clock out";
        }




        if(count($error) == 0){

            echo "<pre>"; print_r($unfinished_attendance); exit();

            //echo "<pre>"; print_r($this->far_attendance->start_clockout_new($unfinished_attendance['attendance_id'], date("Y-m-d H:i:s"))); exit();

            $attendance_id = $this->far_attendance->start_clockout($unfinished_attendance['attendance_id']);

            $redirect_url = base_url()."auth_admin/dashboard/";

            $output['redirect_url'] = $redirect_url;
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function ajax_load_frame_current_attendance(){
        $this->far_auth->allowed_group('6', $this->user['ugrp_id']);

        //attendance detail
        $attendance_detail = $this->far_attendance->get_attendance_detail_by_shift_date($this->user['uacc_id'], date("Y-m-d"));
        $this->data['attendance_detail'] = $attendance_detail;

        $this->load->view('attendance/user/ajax_load_frame_current_attendance', $this->data);
    }
}