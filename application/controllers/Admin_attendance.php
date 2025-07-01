<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_attendance extends MY_Controller
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
        $this->user = $this->flexi_auth->get_user_by_identity_row_array();
        $this->user['user_profile'] = $this->far_users->get_profile('uacc_id', $this->user['uacc_id']);
        $this->global_pass_to_view();
    }
    public function global_pass_to_view()
    {
        $this->data['logged_in'] = $this->user;
        if ($this->flexi_auth->is_admin()) {
            $this->data['logged_in']['is_admin'] = true;
        }
    }
    function datatable_admin_list_all_attendance()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);

        $start = $this->input->get('start') ?? date("Y-m-01");
        $end = $this->input->get('end') ?? date("Y-m-t");

        $filter_month = $this->input->get('filter_month') ?? "";
        $this->data['filter_month'] = $filter_month;

        $filter_year = $this->input->get('filter_year') ?? "";
        $this->data['filter_year'] = $filter_year;

        $filter_shift_date_type = $this->input->get('filter_shift_date_type') ?? "custom_range";
        if($filter_shift_date_type == 'all'){
            $start = "2025-01-01";
            $end = "2030-12-01";
        }else{
            if($filter_month > 0 && $filter_year > 0){
                $start = date("Y-m-01", strtotime($filter_year."-".$filter_month));
                $end = date("Y-m-t", strtotime($filter_year."-".$filter_month));
            }
        }
        $this->data['filter_shift_date_type'] = $filter_shift_date_type;



        $this->data['start'] = $start;
        $this->data['end'] = $end;

        //echo "<pre>"; print_r($this->far_auth->pages); exit();
        $this->load->view('admin_attendance/admin/datatable_admin_list_all_attendance', $this->data);
    }
    function ajax_datatable_admin_list_all_attendance()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');
        $start = $this->input->get('start') ?? date("Y-m-01");
        $end = $this->input->get('end') ?? date("Y-m-t");

        $start_month = date("m", strtotime($start));
        $start_year = date("Y", strtotime($start));

        $this->datatables->select('u.attendance_id');
        $this->datatables->select('u.uacc_id');
        $this->datatables->select('u.fullname');
        $this->datatables->select('u.shift_date');
        $this->datatables->select('u.clockin_dttm');
        $this->datatables->select('u.clockout_dttm');
        $this->datatables->select('u.has_prework');
        $this->datatables->select('u.has_work');
        $this->datatables->select('u.has_overtime');

        $this->datatables->from('view_attendance_list u');

        $this->datatables->where('u.shift_date BETWEEN "'.$start.'" AND "'.$end.'"');

        $output = $this->datatables->generate();
        echo $output;
    }
    function ajax_datatable_admin_list_all_attendance_all()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $this->load->library('datatables');

        $postdata = $this->input->post('postdata');


        $this->datatables->select('u.attendance_id');
        $this->datatables->select('u.uacc_id');
        $this->datatables->select('u.fullname');
        $this->datatables->select('u.shift_date');
        $this->datatables->select('u.clockin_dttm');
        $this->datatables->select('u.clockout_dttm');
        $this->datatables->select('u.has_prework');
        $this->datatables->select('u.has_work');
        $this->datatables->select('u.has_overtime');
        $this->datatables->select('u.calculate_grand_pay');

        $this->datatables->from('view_attendance_list u');

        if($postdata['uacc_id'] ?? 0 > 0){
            $this->datatables->where('uacc_id', $postdata['uacc_id']);
        }

        $output = $this->datatables->generate();
        echo $output;
    }
    function ajax_admin_delete_attendance(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(count($error) == 0){

            $this->far_attendance->update_attendance_detail('attendance_id', $postdata['attendance_id'], 'status', 'deleted');

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function admin_manual_checkout(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $attendance_detail = $this->far_attendance->get_attendance_detail($postdata['attendance_id']);
        if(count($attendance_detail) < 4){
            $error['attendance_id'] = "Attendance not found";
        }



        if(count($error) == 0){

            $this->far_attendance->start_clockout($postdata['attendance_id'], $postdata['checkout_time']);

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    /** Stock */
    function ajax_datatable_admin_list_all_stock_list()
    {
        $this->far_auth->allowed_group('3,6,7', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $this->load->library('datatables');
        $uacc_created_by = $this->user['uacc_id'];
        $this->datatables->select('u.product_stock_id');
        $this->datatables->select('u.product_id');
        $this->datatables->select('u.quantity');
        $this->datatables->select('u.remarks');
        $this->datatables->select('u.create_dttm');
        $this->datatables->where('product_id', $postdata['product_id']);
        $this->datatables->from('view_stock_list u');
        $output = $this->datatables->generate();
        echo $output;
    }
    function admin_ajax_add_stock_list(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();
        if(strlen($postdata['quantity']) < 1){
            $error['add_stock_quantity'] = "Quantity must be more than 0";
        }
        if(strlen($postdata['remarks']) < 2){
            $error['add_stock_remarks'] = "Remarks must be more than 3 characters";
        }
        if(count($error) == 0){
            $insert_data = array(
                'product_id' => $postdata['product_id'],
                'remarks' => $postdata['remarks'],
                'quantity' => $postdata['quantity'],
                'create_dttm' => date("Y-m-d H:i:s")
            );
            $this->db->insert('product_stock', $insert_data);
            $product_id = $this->db->insert_id();
            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }
    function monthly_report(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $filter_year = $this->input->get('filter_year') ?? date("Y");
        $filter_month = $this->input->get('filter_month') ?? date("m");
        $filter_uacc_id = $this->input->get('filter_uacc_id') ?? 0;
        $product_id = $this->input->get('product_id');

        $this->data['filter_year'] = $filter_year;
        $this->data['filter_month'] = $filter_month;
        $this->data['filter_uacc_id'] = $filter_uacc_id;

        $list_attendance = [];
        $list_attendance_all = [];
        $final_list = [];
        if($filter_uacc_id != 'all' && $filter_uacc_id == 0){
            $this->data['error_message'] = "Please select Date & Staff";
        }else{
            if($filter_uacc_id == 'all'){
                $query = $this->db->query("SELECT * FROM view_attendance_list WHERE MONTH(shift_date)='".$filter_month."' AND YEAR(shift_date)='".$filter_year."' ORDER BY shift_date ASC");
            }else{
                $query = $this->db->query("SELECT * FROM view_attendance_list WHERE MONTH(shift_date)='".$filter_month."' AND YEAR(shift_date)='".$filter_year."' AND uacc_id='".$filter_uacc_id."' ORDER BY shift_date ASC");
            }
            if($query->num_rows() > 0){
                $list_attendance = $query->result_array();
            }

            if(count($list_attendance) > 0){
                //sorting
                foreach ($list_attendance as $key => $item) {
                    $list_attendance_all[$item['uacc_id']][$key] = $item;
                }

                ksort($list_attendance_all, SORT_NUMERIC);
            }
        }

        if(count($list_attendance_all) > 0){
            foreach($list_attendance_all as $a => $b){
                $total_pay_for_month = 0;
                $user_detail = $this->far_users->get_user_simple($a);
                foreach($b as $c => $d){
                    $total_pay_for_month = $total_pay_for_month+$d['calculate_grand_pay'];
                }



                $final_list[] = [
                    'user_detail' => $user_detail,
                    'list_attendance' => $b,
                    'total_pay' => $total_pay_for_month,
                    'attendance_month' => strtoupper(date("F Y", strtotime($filter_year."-".$filter_month)))
                ];
            }
        }

        $this->data['final_list'] = $final_list;


        $this->load->view('admin_attendance/admin/monthly_report', $this->data);
    }

    function validate_new_attendance(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');
        $error = [];

        $calculate_shift_date = $this->far_attendance->calculate_shift_date($postdata['checkin_dttm']);
        //check if attendance exists
        $query = $this->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$postdata['staff_uacc_id']."' AND shift_date='".$calculate_shift_date['shift_date']."' AND status='active'");
        if($query->num_rows() > 0){
            $error['shift_date'] = "Attendance for ".$calculate_shift_date['shift_date']." already exists. Please delete and insert again";
        }

        //check if time is correct
        if(strtotime($postdata['checkin_dttm']) > strtotime($postdata['checkout_dttm'])){
            $error['checkin_date'] = "Check-In Date must be less than Check-out Date";
        }else{
            // Example date/time string (e.g., from a database or form)
            $checkin_unix = strtotime($postdata['checkin_dttm']); // Example: 5 PM today
            // Get the current Unix timestamp
            $checkout_unix = strtotime($postdata['checkout_dttm']); // Equivalent to strtotime('now')
            // Define 20 hours in seconds (2 hours * 60 minutes/hour * 60 seconds/minute)
            $twoHoursInSeconds = 20 * 60 * 60; //

            // Check if the difference between the current time and the past time is greater than 2 hours
            if (($checkout_unix - $checkin_unix) > $twoHoursInSeconds) {
                $error['checkout_date'] = "Check-Out cannot be more than 20 hours";
            }
        }

        if(count($error) == 0){

            $validation = $this->far_attendance->process_clockout_latest($postdata['checkin_dttm'], $postdata['checkout_dttm']);
            $this->data['validation'] = $validation;
        }else{

            $this->data['message_single'] = current($error) ?? "";
        }


        $this->load->view('admin_attendance/admin/validate_new_attendance', $this->data);
    }
    function ajax_admin_add_new_attendance(){
        $postdata = $this->input->post('postdata');
        $error = array();
        $output = array();

        $calculate_shift_date = $this->far_attendance->calculate_shift_date($postdata['checkin_dttm']);
        //check if attendance exists
        $query = $this->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$postdata['staff_uacc_id']."' AND shift_date='".$calculate_shift_date['shift_date']."' AND status='active'");
        if($query->num_rows() > 0){
            $error['shift_date'] = "Attendance for ".$calculate_shift_date['shift_date']." already exists. Please delete and insert again";
        }

        //check if time is correct
        if(strtotime($postdata['checkin_dttm']) > strtotime($postdata['checkout_dttm'])){
            $error['checkin_date'] = "Check-In Date must be less than Check-out Date";
        }else{
            // Example date/time string (e.g., from a database or form)
            $checkin_unix = strtotime($postdata['checkin_dttm']); // Example: 5 PM today
            // Get the current Unix timestamp
            $checkout_unix = strtotime($postdata['checkout_dttm']); // Equivalent to strtotime('now')
            // Define 20 hours in seconds (2 hours * 60 minutes/hour * 60 seconds/minute)
            $twoHoursInSeconds = 20 * 60 * 60; //

            // Check if the difference between the current time and the past time is greater than 2 hours
            if (($checkout_unix - $checkin_unix) > $twoHoursInSeconds) {
                $error['checkout_date'] = "Check-Out cannot be more than 20 hours";
            }
        }


        if(count($error) == 0){

            $insert_data = [
                'uacc_id' => $postdata['staff_uacc_id'],
                'shift_date' => $calculate_shift_date['shift_date'],
                'shift_start_dttm' => $calculate_shift_date['shift_start_dttm'],
                'shift_end_dttm' => $calculate_shift_date['shift_end_dttm'],
                'clockin_dttm' => $postdata['checkin_dttm']
            ];
            $this->db->insert('attendance_detail', $insert_data);

            $attendance_id = $this->db->insert_id();
            //process clockout
            $this->far_attendance->start_clockout($attendance_id, $postdata['checkout_dttm']);

            $output['status'] = 'success';
        }else{
            $output['message_single'] = current($error);
            $output['errors'] = $error;
            $output['status'] = 'error';
        }
        echo json_encode($output);
    }

    function ajax_graph_monthly_pay(){
        $this->far_auth->allowed_group('3', $this->user['ugrp_id']);
        $postdata = $this->input->post('postdata');

        $list_pay = [];
        $query = $this->db->query("SELECT shift_date,SUM(calculate_grand_pay) AS total_pay FROM attendance_detail WHERE MONTH(shift_date)='".$postdata['filter_month']."' AND YEAR(shift_date)='".$postdata['filter_year']."' AND status='active' GROUP BY shift_date");
        if($query->num_rows() > 0){
            $list_pay = $query->result_array();
            foreach($list_pay as $a => $b){
                $list_pay[$a]['nicedate'] = date("d", strtotime($b['shift_date']));
            }
        }
        $this->data['list_pay'] = $list_pay;
        $this->load->view('admin_attendance/admin/ajax_graph_monthly_pay', $this->data);
    }
}