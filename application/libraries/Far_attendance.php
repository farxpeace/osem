<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Far_attendance
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function check_today_clockin($dttm){
        $calculate_shift_date = $this->calculate_shift_date($dttm);
    }
    function get_attendance_detail($attendance_id){
        $attendance_detail = [];
        $query = $this->CI->db->query("SELECT * FROM attendance_detail WHERE attendance_id='".$attendance_id."'");
        if($query->num_rows() > 0){
            $attendance_detail = $query->row_array();
        }
        return $attendance_detail;
    }
    function get_attendance_detail_by_shift_date($uacc_id, $shift_date){
        $attendance_detail = [];
        $query = $this->CI->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$uacc_id."' AND shift_date='".$shift_date."'");
        if($query->num_rows() > 0){
            $attendance_detail = $this->get_attendance_detail($query->row()->attendance_id);
        }
        return $attendance_detail;
    }
    function update_attendance_detail($key, $key_value, $column, $value){
        $data = array(
            $column => $value
        );
        $this->CI->db->where($key, $key_value);
        $this->CI->db->update('attendance_detail', $data);
    }
    function start_clockout($attendance_id, $clockout_dttm = NULL){
        if(is_null($clockout_dttm)){
            $clockout_dttm = date("Y-m-d H:i:s");
        }

        $attendance_detail = $this->get_attendance_detail($attendance_id);
        $calculate_working_hour = $this->process_clockout_latest($attendance_detail['clockin_dttm'], $clockout_dttm);

        $update_data = [];
        $grand_pay = 0;
        foreach($calculate_working_hour as $a => $b){
            $update_data['clockout_dttm'] = $b['clockout_dttm'];

            //prep
            if($b['timeline_name'] == "Prep"){
                $update_data['has_prework'] = ($b['is_eligible'] == "1") ? "yes" : "no";
                $update_data['prework_rate'] = $b['pay_price'] ?? "0.00";
                $update_data['prework_sum_rate'] = $b['total_pay'] ?? "0.00";
                $update_data['calculate_prework_json'] = json_encode($b);
            }elseif($b['timeline_name'] == "Work"){
                $update_data['has_work'] = ($b['is_eligible'] == "1") ? "yes" : "no";
                $update_data['work_rate_per_day'] = $b['pay_price'] ?? "0.00";
                $update_data['work_sum_rate'] = $b['total_pay'] ?? "0.00";
                $update_data['calculate_work_json'] = json_encode($b);
            }elseif($b['timeline_name'] == "Overtime"){
                $update_data['has_overtime'] = ($b['is_eligible'] == "1") ? "yes" : "no";
                $update_data['overtime_sum_rate'] = $b['total_pay'] ?? "0.00";
                $update_data['calculate_overtime_json'] = json_encode($b);
            }


            //$grand_pay
            $grand_pay = $grand_pay+$b['total_pay'];

        }
        $update_data['calculate_grand_pay'] = $grand_pay;

        /*
        $update_data = [
            'clockout_dttm' => $clockout_dttm,

            'has_prework' => $calculate_working_hour['has_prework'],
            'prework_start_dttm' => $calculate_working_hour['prework_start_dttm'],
            'prework_end_dttm' => $calculate_working_hour['prework_end_dttm'],
            'prework_hour' => $calculate_working_hour['calculate_prework']['prework_hour'] ?? 0,
            'prework_rate' => $calculate_working_hour['calculate_prework']['prework_rate'] ?? 0,
            'prework_sum_rate' => $calculate_working_hour['calculate_prework']['prework_sum_rate'] ?? 0,
            'calculate_prework_json' => json_encode($calculate_working_hour['calculate_prework']),

            'has_work' => $calculate_working_hour['has_work'],
            'work_start_dttm' => $calculate_working_hour['work_start_dttm'],
            'work_end_dttm' => $calculate_working_hour['work_end_dttm'],
            'work_hour' => $calculate_working_hour['calculate_work']['hours'] ?? 0,
            'work_rate_per_day' => $calculate_working_hour['work_rate_per_day'],
            'work_sum_rate' => $calculate_working_hour['work_sum_rate'] ?? 0,
            'calculate_work_json' => json_encode($calculate_working_hour['calculate_work'] ?? NULL),

            'has_overtime' => $calculate_working_hour['has_overtime'],
            'overtime_start_dttm' => $calculate_working_hour['overtime_start_dttm'] ?? NULL,
            'overtime_end_dttm' => $calculate_working_hour['overtime_end_dttm'] ?? NULL,
            'overtime_hour' => $calculate_working_hour['calculate_overtime']['overtime_hour'] ?? 0,
            'overtime_sum_rate' => $calculate_working_hour['calculate_overtime']['overtime_sum_rate'] ?? 0,
            'calculate_overtime_json' => json_encode($calculate_working_hour['calculate_overtime'] ?? NULL),

            'calculate_grand_pay' => $calculate_working_hour['calculate_grand_pay']
        ];
        */
        $this->CI->db->where('attendance_id', $attendance_detail['attendance_id']);
        $this->CI->db->update('attendance_detail', $update_data);

        return $attendance_detail;

    }
    function start_clockout_deprecated($attendance_id, $clockout_dttm = NULL){
        if(is_null($clockout_dttm)){
            $clockout_dttm = date("Y-m-d H:i:s");
        }

        //$clockout_dttm = "2025-04-05 01:30:00";
        $attendance_detail = $this->get_attendance_detail($attendance_id);
        $calculate_working_hour = $this->calculate_working_hour($attendance_detail['clockin_dttm'], $clockout_dttm);

        //print_r($calculate_working_hour); exit();

        $update_data = [
            'clockout_dttm' => $clockout_dttm,

            'has_prework' => $calculate_working_hour['has_prework'],
            'prework_start_dttm' => $calculate_working_hour['prework_start_dttm'],
            'prework_end_dttm' => $calculate_working_hour['prework_end_dttm'],
            'prework_hour' => $calculate_working_hour['calculate_prework']['prework_hour'] ?? 0,
            'prework_rate' => $calculate_working_hour['calculate_prework']['prework_rate'] ?? 0,
            'prework_sum_rate' => $calculate_working_hour['calculate_prework']['prework_sum_rate'] ?? 0,
            'calculate_prework_json' => json_encode($calculate_working_hour['calculate_prework']),

            'has_work' => $calculate_working_hour['has_work'],
            'work_start_dttm' => $calculate_working_hour['work_start_dttm'],
            'work_end_dttm' => $calculate_working_hour['work_end_dttm'],
            'work_hour' => $calculate_working_hour['calculate_work']['hours'] ?? 0,
            'work_rate_per_day' => $calculate_working_hour['work_rate_per_day'],
            'work_sum_rate' => $calculate_working_hour['work_sum_rate'] ?? 0,
            'calculate_work_json' => json_encode($calculate_working_hour['calculate_work'] ?? NULL),

            'has_overtime' => $calculate_working_hour['has_overtime'],
            'overtime_start_dttm' => $calculate_working_hour['overtime_start_dttm'] ?? NULL,
            'overtime_end_dttm' => $calculate_working_hour['overtime_end_dttm'] ?? NULL,
            'overtime_hour' => $calculate_working_hour['calculate_overtime']['overtime_hour'] ?? 0,
            'overtime_sum_rate' => $calculate_working_hour['calculate_overtime']['overtime_sum_rate'] ?? 0,
            'calculate_overtime_json' => json_encode($calculate_working_hour['calculate_overtime'] ?? NULL),

            'calculate_grand_pay' => $calculate_working_hour['calculate_grand_pay']
        ];
        $this->CI->db->where('attendance_id', $attendance_detail['attendance_id']);
        $this->CI->db->update('attendance_detail', $update_data);

        return $attendance_detail;

    }
    function start_clockin($uacc_id, $shift_date){
        $calculate_shift_date = $this->calculate_shift_date($shift_date);

        $insert_data = [
            'uacc_id' => $uacc_id,
            'shift_date' => $shift_date,
            'shift_start_dttm' => $calculate_shift_date['shift_start_dttm'],
            'shift_end_dttm' => $calculate_shift_date['shift_end_dttm'],
            'clockin_dttm' => date("Y-m-d H:i:s")
        ];
        $this->CI->db->insert('attendance_detail', $insert_data);

        return $this->CI->db->insert_id();

    }
    function get_unfinished_clockin($uacc_id, $shift_date){
        $attendance_detail = [];
        $query = $this->CI->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$uacc_id."' AND shift_date='".$shift_date."' AND clockin_dttm IS NOT NULL AND clockout_dttm IS NULL AND status='active'");
        if($query->num_rows() > 0){
            $attendance_detail = $query->row_array();
        }
        return $attendance_detail;
    }

    function calculate_shift_date($dttm){
        $output = [];
        $Date = new DateTime($dttm);

        $shift_date_start_hour = $this->CI->far_meta->get_value('shift_date_start_hour'); //9
        $work_end_hour = $this->CI->far_meta->get_value('work_end_hour'); //23

        $year = $Date->format("Y");
        $month = $Date->format("m");
        $day = $Date->format("d");
        $hour = $Date->format("H");
        $minute = $Date->format("i");
        $given_dttm = array(
            'dttm' => $dttm,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'hour' => $hour,
            'minute' => $minute
        );

        $is_overtime = "no";
        $eligible_to_clockin_clockout = "yes";
        //if after 9 in the morning
        if($hour >= $shift_date_start_hour && $hour <= $work_end_hour){
            $shift_date = $Date->format("Y-m-d");

        }else{
            if($hour >= 0 && $hour <= 5){
                $shift_date = $Date->modify('-1 day')->format("Y-m-d");
                $is_overtime = "yes";

            }else{
                $eligible_to_clockin_clockout = "no";
            }
        }

        if($eligible_to_clockin_clockout == "yes"){

            //shift_start_dttm
            $shift_start_dttm = $shift_date." ".$shift_date_start_hour.":00:00";
            $shift_end_dttm = $shift_date." ".$work_end_hour.":59:59";

            $output['given_dttm'] = $given_dttm;
            $output['shift_date'] = $shift_date;
            $output['shift_start_dttm'] = $shift_start_dttm;
            $output['shift_end_dttm'] = $shift_end_dttm;
            $output['is_overtime'] = $is_overtime;
            $output['eligible_to_clockin_clockout'] = $eligible_to_clockin_clockout;
        }else{
            $output['eligible_to_clockin_clockout'] = $eligible_to_clockin_clockout;
        }



        return $output;
    }

    function calculate_working_hour_old($clockin_dttm, $clockout_dttm){
        $output = [];
        $has_ot = "no";
        $has_prework = "no";
        $Date_clockin = new DateTime($clockin_dttm);
        $Date_clockout = new DateTime($clockout_dttm);

        $clockin_date = $Date_clockin->format("Y-m-d");

        $ot_start_dttm = "";
        $ot_end_dttm = "";

        $calculate_ot_seconds = NULL;


        if($Date_clockin->format("Y-m-d") == $Date_clockout->format("Y-m-d")){

        }else{
            $has_ot = "yes";

            $Date_ot = new DateTime($clockin_date);
            $ot_start_dttm = $Date_ot->modify('+1 day')->format("Y-m-d")." 00:00:00";
            $ot_end_dttm = $clockout_dttm;

            //calculate OT hours
            $calculate_ot_seconds = $this->CI->far_date->duration_between_two_dates($ot_start_dttm, $ot_end_dttm);
        }

        //check pre work
        if($Date_clockin->format("H") < 16){
            $has_prework = "yes";
            $prework_start_dttm = $Date_clockin->format("Y-m-d H:i:s");
            $prework_end_dttm = $Date_clockin->format("Y-m-d")." 16:00:00";

            $calculate_prework = $this->CI->far_date->duration_between_two_dates($prework_start_dttm, $prework_end_dttm);

            $work_start_dttm = $Date_clockin->format("Y-m-d")." 16:00:00";
        }else{

            $work_start_dttm = $clockin_dttm;
        }


        $work_end_dttm_modified = $Date_clockin->format("Y-m-d")." 23:59:59";
        $Date_work_end = new DateTime($work_end_dttm_modified);
        if($has_ot == "yes"){
            $work_end_dttm = $Date_work_end->modify("+1 second")->format("Y-m-d H:i:s");
        }else{
            $work_end_dttm = $clockout_dttm;
        }


        //calculate working hours
        $calculate_work_seconds = $this->CI->far_date->duration_between_two_dates($work_start_dttm, $work_end_dttm);
        $work_seconds = $calculate_work_seconds['total_seconds'];



        $output['clockin_dttm'] = $clockin_dttm;
        $output['clockout_dttm'] = $clockout_dttm;
        $output['has_prework'] = $has_prework;
        $output['prework_start_dttm'] = $prework_start_dttm ?? NULL;
        $output['prework_end_dttm'] = $prework_end_dttm ?? NULL;
        $output['calculate_prework'] = $calculate_prework ?? [];
        $output['prework_seconds'] = $calculate_prework['total_seconds'] ?? NULL;

        $output['work_start_dttm'] = $work_start_dttm;
        $output['work_end_dttm'] = $work_end_dttm;
        $output['calculate_work_seconds'] = $calculate_work_seconds;
        $output['work_seconds'] = $calculate_work_seconds['total_seconds'];
        $output['has_overtime'] = $has_ot;
        $output['overtime_start_dttm'] = $ot_start_dttm ?? NULL;
        $output['overtime_end_dttm'] = $ot_end_dttm ?? NULL;
        $output['calculate_ot_seconds'] = $calculate_ot_seconds ?? [];
        $output['overtime_seconds'] = $calculate_ot_seconds['total_seconds'] ?? NULL;
        return $output;
    }
    function calculate_working_hour($clockin_dttm, $clockout_dttm){
        $output = [];
        $has_prework = "no";
        $has_work = "no";
        $has_overtime = "no";

        $shift_date_start_hour = $this->CI->far_meta->get_value('shift_date_start_hour'); //9
        $prework_end_hour = $this->CI->far_meta->get_value('prework_end_hour'); //16
        $work_end_hour = $this->CI->far_meta->get_value('work_end_hour'); //12

        $Date_clockin = new DateTime($clockin_dttm);
        $Date_clockout = new DateTime($clockout_dttm);

        $clockin_date = $Date_clockin->format("Y-m-d");
        $clockin_hour = $Date_clockin->format("H");
        $clockin_minute = $Date_clockin->format("i");

        $clockout_date = $Date_clockout->format("Y-m-d");
        $clockout_hour = $Date_clockout->format("H");
        $clockout_minute = $Date_clockout->format("i");

        if($clockin_hour >= $shift_date_start_hour && $clockin_hour < $prework_end_hour){ $has_prework = "yes"; }
        if($clockin_hour >= $shift_date_start_hour && $clockout_hour <= $work_end_hour){ $has_work = "yes"; }
        if(($clockin_hour >= $shift_date_start_hour && $clockin_hour <= $work_end_hour) && ($clockout_date == date('Y-m-d', strtotime($clockin_date. ' +1 days')))){ $has_overtime = "yes"; }


        if($has_prework == "yes"){
            $prework_start_dttm = $clockin_dttm;

            //if same day
            if($clockin_date == $clockout_date){
                if($clockout_hour > $shift_date_start_hour && $clockout_hour < $prework_end_hour){
                    $prework_end_dttm = $clockout_dttm;
                }else{
                    $prework_end_dttm = $clockout_date." ".$prework_end_hour.":00:00";
                }
            }else{
                if($clockout_hour > $shift_date_start_hour && $clockout_hour < $prework_end_hour){
                    $prework_end_dttm = $clockout_dttm;
                }else{
                    $prework_end_dttm = date('Y-m-d', strtotime($clockout_date. ' -1 days'))." ".$prework_end_hour.":00:00";
                }
            }

            //calculate prework
            $calculate_prework = $this->CI->far_date->duration_between_two_dates($prework_start_dttm, $prework_end_dttm);
            //alter prework hour
            if($calculate_prework['minutes'] > 0){
                $calculate_prework['prework_hour'] = $calculate_prework['hours']+1;
            }else{
                $calculate_prework['prework_hour'] = $calculate_prework['hours'];
            }
            $calculate_prework['prework_rate'] = $this->CI->far_meta->get_value('prework_rate_per_hour');
            $calculate_prework['prework_sum_rate'] = $this->CI->far_meta->get_value('prework_rate_per_hour')*$calculate_prework['prework_hour'] ?? 0;
        }

        if($has_overtime == "yes"){

            $overtime_start_dttm = date('Y-m-d 00:00:00', strtotime($clockin_date. ' +1 days'));
            if($clockout_hour > 2){
                $overtime_end_dttm = $clockout_dttm;
            }else{
                $overtime_end_dttm = $clockout_dttm;
            }

            //calculate prework
            $calculate_overtime = $this->CI->far_date->duration_between_two_dates($overtime_start_dttm, $overtime_end_dttm);
            //alter prework hour
            if($calculate_overtime['minutes'] > 0){
                if($clockout_hour < 2){
                    $calculate_overtime['overtime_hour'] = $calculate_overtime['hours']+1;
                }else{
                    $calculate_overtime['overtime_hour'] = $calculate_overtime['hours'];
                }

            }else{
                $calculate_overtime['overtime_hour'] = $calculate_overtime['hours'];
            }
            $calculate_overtime['overtime_rate'] = $this->CI->far_meta->get_value('overtime_rate_per_hour');
            $calculate_overtime['overtime_sum_rate'] = $this->CI->far_meta->get_value('overtime_rate_per_hour')*$calculate_overtime['overtime_hour'] ?? 0;
        }


        //Actual work
        if($has_prework == "yes" && ($clockout_hour >= $prework_end_hour && $clockout_hour <= $work_end_hour)){
            $has_work = "yes";
            $work_start_dttm = $clockin_date." ".$prework_end_hour.":00:00";
            $work_end_dttm = $clockin_date." ".$work_end_hour.":00:00";
        }elseif($has_prework == "yes" && (date('Y-m-d', strtotime($clockin_date. ' +1 days')) == $clockout_date)){
            $has_work = "yes";
            $work_start_dttm = $clockin_date." ".$prework_end_hour.":00:00";
            $work_end_dttm = $clockin_date." ".$work_end_hour.":00:00";
        }elseif($has_prework == "no" && (date('Y-m-d', strtotime($clockin_date. ' +1 days')) == $clockout_date)){
            $has_work = "yes";
            $work_start_dttm = $clockin_date." ".$prework_end_hour.":00:00";
            $work_end_dttm = $clockin_date." ".$work_end_hour.":00:00";
        }elseif($has_prework == "no" && ($clockout_hour >= $prework_end_hour && $clockout_hour <= $work_end_hour)){
            $has_work = "yes";
            $work_start_dttm = $clockin_date." ".$prework_end_hour.":00:00";
            $work_end_dttm = $clockin_date." ".$work_end_hour.":00:00";
        }else{
            $has_work = "no";
        }

        $work_rate_per_day = $this->CI->far_meta->get_value('work_rate_per_day');
        $work_sum_rate = 0;
        if($has_work == "yes"){
            $work_sum_rate = 1*$work_rate_per_day = $this->CI->far_meta->get_value('work_rate_per_day');
        }

        //calculate work hour
        if(isset($work_end_dttm)){
            if($work_end_dttm > $clockout_dttm){
                $work_end_dttm = $clockout_dttm;
            }
            $calculate_work = $this->CI->far_date->duration_between_two_dates($work_start_dttm, $work_end_dttm);
        }



        //calculate sum pay
        $calculate_grand_pay = ($calculate_prework['prework_sum_rate'] ?? 0)+$work_sum_rate+($calculate_overtime['overtime_sum_rate'] ?? 0);

        $output['clockin_dttm'] = $clockin_dttm;
        $output['clockout_dttm'] = $clockout_dttm;
        $output['has_prework'] = $has_prework;
        $output['prework_start_dttm'] = $prework_start_dttm ?? NULL;
        $output['prework_end_dttm'] = $prework_end_dttm ?? NULL;
        $output['calculate_prework'] = $calculate_prework ?? [];

        $output['has_work'] = $has_work;
        $output['work_start_dttm'] = $work_start_dttm ?? NULL;
        $output['work_end_dttm'] = $work_end_dttm ?? NULL;
        $output['work_rate_per_day'] = $work_rate_per_day ?? 0;
        $output['work_sum_rate'] = $work_sum_rate ?? 0;
        $output['calculate_work'] = $calculate_work ?? [];

        $output['has_overtime'] = $has_overtime;
        $output['overtime_start_dttm'] = $overtime_start_dttm ?? NULL;
        $output['overtime_end_dttm'] = $overtime_end_dttm ?? NULL;
        $output['calculate_overtime'] = $calculate_overtime ?? [];

        $output['calculate_grand_pay'] = $calculate_grand_pay;
        return $output;
    }

    function is_already_checkin_today($uacc_id, $shift_date){
        $is_already_checkin_today = FALSE;
        $query = $this->CI->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$uacc_id."' AND shift_date='".$shift_date."' AND status='active'");
        if($query->num_rows() > 0){
            $is_already_checkin_today = TRUE;
        }
        return $is_already_checkin_today;
    }

    function is_already_clockout_by_date($uacc_id, $shift_date){
        $is_already_checkin_today = FALSE;
        $query = $this->CI->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$uacc_id."' AND shift_date='".$shift_date."' AND clockin_dttm IS NOT NULL AND clockout_dttm IS NOT NULL AND status='active'");
        if($query->num_rows() > 0){
            $is_already_checkin_today = TRUE;
        }
        return $is_already_checkin_today;
    }

    function list_clockin_clockout_by_month_year($uacc_id, $month, $year){
        $list_clockin_clockout = [];
        $query = $this->CI->db->query("SELECT * FROM attendance_detail WHERE uacc_id='".$uacc_id."' AND MONTH(shift_date)='".$month."' AND YEAR(shift_date)='".$year."' AND clockin_dttm IS NOT NULL AND clockout_dttm IS NOT NULL AND status='active' ORDER BY shift_date ASC");
        if($query->num_rows() > 0){
            $list_clockin_clockout = $query->result_array();
        }
        return $list_clockin_clockout;
    }
    function total_pay_by_month_year($uacc_id, $month, $year){
        $list_pay = [];
        $list_pay['total_prework_sum_rate'] = 0;
        $list_pay['total_work_sum_rate'] = 0;
        $list_pay['total_overtime_sum_rate'] = 0;
        $list_pay['total_calculate_grand_pay'] = 0;
        $list_clockin_clockout_by_month_year = $this->list_clockin_clockout_by_month_year($uacc_id, $month, $year);
        if(count($list_clockin_clockout_by_month_year) > 0){
            foreach($list_clockin_clockout_by_month_year as $a => $b){
                $list_pay['total_prework_sum_rate'] = $list_pay['total_prework_sum_rate']+$b['prework_sum_rate'];
                $list_pay['total_work_sum_rate'] = $list_pay['total_work_sum_rate']+$b['work_sum_rate'];
                $list_pay['total_overtime_sum_rate'] = $list_pay['total_overtime_sum_rate']+$b['overtime_sum_rate'];
                $list_pay['total_calculate_grand_pay'] = $list_pay['total_calculate_grand_pay']+$b['calculate_grand_pay'];
            }
        }

        $list_pay['total_prework_sum_rate'] = $this->CI->far_helper->convert_number_to_price_format($list_pay['total_prework_sum_rate']);
        $list_pay['total_work_sum_rate'] = $this->CI->far_helper->convert_number_to_price_format($list_pay['total_work_sum_rate']);
        $list_pay['total_overtime_sum_rate'] = $this->CI->far_helper->convert_number_to_price_format($list_pay['total_overtime_sum_rate']);
        $list_pay['total_calculate_grand_pay'] = $this->CI->far_helper->convert_number_to_price_format($list_pay['total_calculate_grand_pay']);

        return $list_pay;
    }

    function process_clockout($clockin_dttm, $clockout_dttm){
        $list_timeline = [];
        $query = $this->CI->db->query("SELECT * FROM attendance_timeline ORDER BY sorting ASC");
        if($query->num_rows() > 0){
            $list_timeline = $query->result_array();
            foreach($list_timeline as $a => $b){
                $calculate_hour = $this->calculate_hour($b, $clockin_dttm, $clockout_dttm);


                $list_timeline[$a]['timeline_start'] = $calculate_hour['timeline_start'];
                $list_timeline[$a]['timeline_end'] = $calculate_hour['timeline_end'];

                $list_timeline[$a]['is_fit_timeline'] = $calculate_hour['is_fit_timeline'];
                $list_timeline[$a]['calc_start_time'] = $calculate_hour['calc_start_time'];
                $list_timeline[$a]['calc_end_time'] = $calculate_hour['calc_end_time'];

                $list_timeline[$a]['seconds'] = $calculate_hour['seconds'];

                $list_timeline[$a]['durations'] = $calculate_hour['durations'] ?? [];

                $list_timeline[$a]['work_hours'] = $calculate_hour['work_hours'];
                $list_timeline[$a]['total_pay'] = $this->CI->far_helper->convert_to_currency_format($calculate_hour['total_pay']);

                $list_timeline[$a]['use_ceil_minutes'] = $calculate_hour['use_ceil_minutes'];

            }
        }

        return $list_timeline;
    }

    function start_clockout_new($attendance_id, $clockout_dttm){
        $attendance_detail = $this->get_attendance_detail($attendance_id);

        $processed = $this->process_clockout($attendance_detail['clockin_dttm'], $clockout_dttm);

        echo "<pre>"; print_r($processed);
    }

    function calculate_hour($timeline_detail, $clockin_dttm, $clockout_dttm){
        $output = [];
        $is_fit = "no";
        $in_time = date("H:i:s", strtotime($clockin_dttm));
        $out_time = date("H:i:s", strtotime($clockout_dttm));

        $in_time = $clockin_dttm;
        $out_time = $clockout_dttm;

        $in_date = date("Y-m-d", strtotime($clockin_dttm));
        $out_date = date("Y-m-d", strtotime($clockout_dttm));

        //hack
        if(strtotime($timeline_detail['start_dttm']) < strtotime($timeline_detail['end_dttm'])){
            $timeline_detail['start_dttm'] = date("Y-m-d", strtotime($clockin_dttm))." ".$timeline_detail['start_dttm'];
            $timeline_detail['end_dttm'] = date("Y-m-d", strtotime($clockin_dttm))." ".$timeline_detail['end_dttm'];
        }else{
            $timeline_detail['start_dttm'] = date("Y-m-d", strtotime($clockin_dttm))." ".$timeline_detail['start_dttm'];
            $timeline_detail['end_dttm'] = date('Y-m-d', strtotime('+1 days', strtotime($clockin_dttm)))." ".$timeline_detail['end_dttm'];
            //$timeline_detail['end_dttm'] = date("Y-m-d", strtotime($clockin_dttm))." ".$timeline_detail['end_dttm'];
        }


        //if perfect fall in range
        if(strtotime($in_time) >= strtotime($timeline_detail['start_dttm']) && strtotime($out_time) <= strtotime($timeline_detail['end_dttm'])){
            $minimum_working_minutes = 3;
            $working_minutes = (strtotime($in_time)-strtotime($timeline_detail['start_dttm']))/60;
            if($working_minutes > $minimum_working_minutes){
                $is_fit = "✅ok";
            }else{
                $is_fit = "❌no";
            }

        }else{
            //if clockin fall, but clockout more
            if(strtotime($in_time) >= strtotime($timeline_detail['start_dttm']) && strtotime($out_time) >= strtotime($timeline_detail['end_dttm'])){
                if(strtotime($in_time) > strtotime($timeline_detail['end_dttm'])){
                    $is_fit = "❌no";
                }else{
                    $is_fit = "✅ok";
                }

            }else{
                if(strtotime($out_time) <= strtotime($timeline_detail['end_dttm']) && strtotime($out_time) >= strtotime($timeline_detail['start_dttm'])){
                    $is_fit = "✅ok";
                }else{
                    if(strtotime($clockin_dttm) <= strtotime($timeline_detail['start_dttm']) && strtotime($out_time) >= strtotime($timeline_detail['end_dttm'])){
                        $is_fit = "✅ok";
                    }else{


                        $early_allowance = $this->CI->far_meta->get_value('calm_period_early_checkin_minutes') * 60;
                        if(strtotime($in_time) >= (strtotime($timeline_detail['start_dttm']) - $early_allowance)){
                            $is_fit = "✅ok";
                        }else{
                            $is_fit = "❌no";
                        }



                    }

                }

            }
        }


        //check hour
        if(strtotime($in_time) >= strtotime($timeline_detail['start_dttm'])){
            $calc_start_time = $in_time;
        }else{
            $calc_start_time = $timeline_detail['start_dttm'];
        }




        if(strtotime($out_time) <= strtotime($timeline_detail['end_dttm'])){
            $calc_end_time = $out_time;
        }else{
            $calc_end_time = $timeline_detail['end_dttm'];
        }
        

        //different days
        if($in_date < $out_date){



            $shift_end = $this->CI->far_meta->get_value('shift_end');
            $shift_end_dttm = date('Y-m-d', strtotime('+1 days', strtotime($clockin_dttm)))." ".$shift_end;
            if(strtotime($out_time) <= strtotime($timeline_detail['end_dttm']) ){
                if(strtotime($timeline_detail['end_dttm']) < strtotime($timeline_detail['start_dttm'])){
                    if(strtotime($clockout_dttm) > strtotime($shift_end_dttm)){
                        $is_fit = "✅ok";
                        $calc_end_time = $shift_end_dttm;
                    }else{
                        $is_fit = "✅ok";
                        $calc_end_time = $clockout_dttm;
                    }


                }else{
                    if(strtotime($in_time) > strtotime($timeline_detail['end_dttm'])){
                        $is_fit = "❌no";
                    }else{
                        if(strtotime($clockout_dttm) > strtotime($shift_end_dttm)){
                            $is_fit = "✅ok";
                            $calc_end_time = $shift_end_dttm;
                        }else{
                            $is_fit = "✅ok";
                            $calc_end_time = $clockout_dttm;
                        }

                    }
                }

            }
        }

        if($is_fit == '✅ok'){

            $seconds = strtotime($calc_end_time) - strtotime($calc_start_time);
            $durations = $this->CI->far_date->secondsToHoursMinutes($seconds);
            $work_hours = $durations['hours'];
            $use_ceil_minutes = "no";
            if($durations['minutes'] > $this->CI->far_meta->get_value('ceil_minutes')){
                $work_hours = $durations['hours']+1;
                $use_ceil_minutes = "yes";
            }

            if($work_hours == 0){
                $is_fit = "❌no";
            }

            if($is_fit == "✅ok"){
                if($timeline_detail['pay_type'] == "perslot"){
                    $total_pay = $timeline_detail['pay_price'];
                }elseif($timeline_detail['pay_type'] == "perhour"){
                    $total_pay = $work_hours*$timeline_detail['pay_price'];
                }

            }

            $output['timeline_start'] = $timeline_detail['start_dttm'];
            $output['timeline_end'] = $timeline_detail['end_dttm'];
            $output['calc_start_time'] = $calc_start_time;
            $output['calc_end_time'] = $calc_end_time;
            $output['seconds'] = $seconds;
            $output['durations'] = $durations;
            $output['work_hours'] = $work_hours;
            $output['total_pay'] = $total_pay ?? 0;
            $output['use_ceil_minutes'] = $use_ceil_minutes;
        }else{
            $output['timeline_start'] = NULL;
            $output['timeline_end'] = NULL;
            $output['calc_start_time'] = NULL;
            $output['calc_end_time'] = NULL;
            $output['seconds'] = NULL;
            $output['durations'] = [];
            $output['work_hours'] = 0;
            $output['total_pay'] = 0;
            $output['use_ceil_minutes'] = "no";
        }


        $output['is_fit_timeline'] = $is_fit;

        return $output;
    }

    function process_clockout_latest($clockin_dttm, $clockout_dttm){
        $list_timeline = [];
        $query = $this->CI->db->query("SELECT * FROM attendance_timeline ORDER BY sorting ASC");
        if($query->num_rows() > 0){
            $list_timeline = $query->result_array();
            foreach($list_timeline as $a => $b){

                $list_timeline[$a]['clockin_dttm'] = $clockin_dttm;
                $list_timeline[$a]['clockout_dttm'] = $clockout_dttm;

                $start_dttm = date("Y-m-d", strtotime($clockin_dttm))." ".$b['start_dttm'];
                $list_timeline[$a]['start_dttm'] = $start_dttm;

                $end_dttm = date("Y-m-d", strtotime($clockin_dttm))." ".$b['end_dttm'];
                $list_timeline[$a]['end_dttm'] = $end_dttm;

                if($b['timeline_name'] == "Overtime"){
                    $end_dttm = date("Y-m-d", strtotime("+1 days", strtotime($clockin_dttm)))." ".$b['end_dttm'];
                    $list_timeline[$a]['end_dttm'] = $end_dttm;
                }
            }

            foreach($list_timeline as $a => $b){

            }

            $this->processTimelines($list_timeline,$clockin_dttm, $clockout_dttm);
        }

        return $list_timeline;
    }
    function processTimelines_deepseek(&$timelines, $clockin_dttm, $clockout_dttm) {
        $clockin = new DateTime($clockin_dttm);
        $clockout = new DateTime($clockout_dttm);

        foreach ($timelines as &$timeline) {
            $start = new DateTime($timeline['start_dttm']);
            $end = new DateTime($timeline['end_dttm']);

            // Handle overnight cases (end time is next day)
            if ($end < $start) {
                $end->modify('+1 day');
            }

            // Check eligibility
            $is_eligible = ($clockin < $end) && ($clockout > $start);
            $timeline['is_eligible'] = $is_eligible;

            if ($is_eligible) {
                // For Prep timeline: If working minutes > 45, consider it 1 hour
                if ($timeline['timeline_name'] === 'Prep') {
                    $overlap_start = max($clockin, $start);
                    $overlap_end = min($clockout, $end);

                    $interval = $overlap_start->diff($overlap_end);
                    $total_minutes = ($interval->h * 60) + $interval->i;

                    // If more than 45 minutes, set to 1 hour
                    if ($total_minutes > 45) {
                        $timeline['working_minutes'] = 60;
                        $timeline['working_hours'] = 1;
                    } else {
                        $timeline['working_minutes'] = $total_minutes;
                        $timeline['working_hours'] = $total_minutes / 60;
                    }

                    $timeline['total_pay'] = round($timeline['working_hours'] * $timeline['pay_price'], 2);

                }
                // For Overtime: Must span midnight AND use start_dttm (ignore clockin)
                elseif ($timeline['timeline_name'] === 'Overtime') {
                    // Check if clockout is on the next day
                    $clockout_date = $clockout->format('Y-m-d');
                    $clockin_date = $clockin->format('Y-m-d');
                    $is_overnight = ($clockout_date > $clockin_date);

                    if (!$is_overnight) {
                        $timeline['is_eligible'] = false;
                        $timeline['working_minutes'] = 0;
                        $timeline['working_hours'] = 0;
                        $timeline['total_pay'] = 0;
                        continue; // Skip calculation
                    }

                    $overlap_start = $start;
                    // Use end_dttm as limit if clockout is beyond it
                    $overlap_end = min($clockout, $end);

                    // Calculate exact minutes and hours
                    $interval = $overlap_start->diff($overlap_end);
                    $total_minutes = ($interval->h * 60) + $interval->i;
                    $timeline['working_minutes'] = $total_minutes;

                    // Convert to hours (round up if >50 minutes)
                    $hours = floor($total_minutes / 60);
                    $remaining_minutes = $total_minutes % 60;
                    $timeline['working_hours'] = ($remaining_minutes > 50) ? $hours + 1 : $hours + ($remaining_minutes / 60);

                    $timeline['total_pay'] = round($timeline['working_hours'] * $timeline['pay_price'], 2);
                }
                // For Work timeline (perslot)
                else {
                    // Default: Use overlapping period
                    $overlap_start = max($clockin, $start);
                    $overlap_end = min($clockout, $end);

                    // Calculate exact minutes and hours
                    $interval = $overlap_start->diff($overlap_end);
                    $total_minutes = ($interval->h * 60) + $interval->i;
                    $timeline['working_minutes'] = $total_minutes;

                    // Convert to hours (round up if >50 minutes)
                    $hours = floor($total_minutes / 60);
                    $remaining_minutes = $total_minutes % 60;
                    $timeline['working_hours'] = ($remaining_minutes > 50) ? $hours + 1 : $hours + ($remaining_minutes / 60);

                    // Calculate total pay
                    if ($timeline['pay_type'] === 'perhour') {
                        $timeline['total_pay'] = round($timeline['working_hours'] * $timeline['pay_price'], 2);
                    } elseif ($timeline['pay_type'] === 'perslot') {
                        $timeline['total_pay'] = $timeline['pay_price']; // Flat rate
                    }
                }
            } else {
                $timeline['working_minutes'] = 0;
                $timeline['working_hours'] = 0;
                $timeline['total_pay'] = 0;
            }
        }
        unset($timeline); // Break the reference
    }
    function processTimelines(&$timelines, $clockin_dttm, $clockout_dttm) {
        $clockin = new DateTime($clockin_dttm);
        $clockout = new DateTime($clockout_dttm);

        $prep_minimum_minutes_to_mark_as_eligible = $this->CI->far_meta->get_value('prep_minimum_minutes_to_mark_as_eligible');
        $ot_minimum_minutes_to_mark_as_eligible = $this->CI->far_meta->get_value('ot_minimum_minutes_to_mark_as_eligible');

        foreach ($timelines as &$timeline) {
            $start = new DateTime($timeline['start_dttm']);
            $end = new DateTime($timeline['end_dttm']);

            // Handle overnight cases (end time is next day)
            if ($end < $start) {
                $end->modify('+1 day');
            }

            // Check eligibility
            $is_eligible = ($clockin < $end) && ($clockout > $start);
            $timeline['is_eligible'] = $is_eligible;

            if ($is_eligible) {
                $overlap_start = null;
                $overlap_end = null;

                if ($timeline['timeline_name'] === 'Overtime') {
                    // For Overtime: Must span midnight AND use start_dttm (ignore clockin)
                    $clockout_date = $clockout->format('Y-m-d');
                    $clockin_date = $clockin->format('Y-m-d');
                    $is_overnight = ($clockout_date > $clockin_date);

                    if (!$is_overnight) {
                        $timeline['is_eligible'] = false;
                        $timeline['working_minutes'] = 0;
                        $timeline['working_hours'] = 0;
                        $timeline['total_pay'] = 0;
                        continue; // Skip calculation if not overnight
                    }

                    // If clockout_dttm is more than end_dttm, use end_dttm as a limit for Overtime
                    $overlap_start = $start;
                    $overlap_end = min($clockout, $end);

                } else {
                    // Default: Use overlapping period
                    $overlap_start = max($clockin, $start);
                    $overlap_end = min($clockout, $end);
                }

                // Calculate exact minutes and hours
                $interval = $overlap_start->diff($overlap_end);
                $total_minutes = ($interval->h * 60) + $interval->i;

                // Specific rule for 'Prep' timeline: if minutes less than $prep_minimum_minutes_to_mark_as_eligible, consider it 0 hour and ineligible
                if ($timeline['timeline_name'] === 'Prep' && $total_minutes < $prep_minimum_minutes_to_mark_as_eligible) {
                    $timeline['is_eligible'] = false;
                    $timeline['working_minutes'] = 0;
                    $timeline['working_hours'] = 0;
                    $timeline['total_pay'] = 0;
                    continue; // Skip further calculation for this timeline
                }

                // For 'Overtime' timeline: if working minutes are less than $ot_minimum_minutes_to_mark_as_eligible, consider it not eligible
                if ($timeline['timeline_name'] === 'Overtime' && $total_minutes < $ot_minimum_minutes_to_mark_as_eligible) {

                    $timeline['is_eligible'] = false;
                    $timeline['working_minutes'] = 0;
                    $timeline['working_hours'] = 0;
                    $timeline['total_pay'] = 0;
                    continue; // Skip further calculation for this timeline
                }

                $timeline['working_minutes'] = $total_minutes;

                // Convert to hours based on pay_type and timeline_name rules
                $hours = floor($total_minutes / 60);
                $remaining_minutes = $total_minutes % 60;
                $calculated_hours = 0;

                if ($timeline['timeline_name'] === 'Overtime') {


                    // NEW RULE: For 'Overtime' timeline
                    $fractional_hour = $remaining_minutes / 60;

                    if ($fractional_hour > 0.1) {
                        // Round up if more than 0.1
                        $calculated_hours = $hours + 1;
                    } elseif ($fractional_hour < 0.4) {
                        // Round down (to the whole hour) if less than 0.4
                        $calculated_hours = $hours; // Effectively truncates the fractional part
                    } else {
                        // Otherwise, keep the precise fractional hours
                        $calculated_hours = $hours + $fractional_hour;
                    }
                } elseif ($timeline['pay_type'] === 'perhour') {
                    // If remaining minutes are less than 10, consider it 1 hour if there are any minutes.
                    if ($remaining_minutes > 0 && $remaining_minutes < 10) {
                        $calculated_hours = $hours + 1;
                    } else {
                        $calculated_hours = ($remaining_minutes > 50) ? $hours + 1 : $hours + ($remaining_minutes / 60);
                    }
                } else {
                    // Original logic for other pay types (e.g., perslot)
                    $calculated_hours = ($remaining_minutes > 50) ? $hours + 1 : $hours + ($remaining_minutes / 60);
                }

                $timeline['working_hours'] = $calculated_hours;
                if($timeline['pay_type'] === 'perhour'){
                    $timeline['working_hours'] = ceil($timeline['working_hours']);
                }

                //remove decimal
                $timeline['working_hours'] = bcdiv($timeline['working_hours'], 1, 1);

                // Calculate total pay
                if ($timeline['pay_type'] === 'perhour') {
                    //round down

                    $timeline['total_pay'] = round($timeline['working_hours'] * $timeline['pay_price'], 2);
                } elseif ($timeline['pay_type'] === 'perslot') {
                    $timeline['total_pay'] = $timeline['pay_price']; // Flat rate
                }
            } else {
                $timeline['working_minutes'] = 0;
                $timeline['working_hours'] = 0;
                $timeline['total_pay'] = 0;
            }
        }
        unset($timeline); // Break the reference
    }


}