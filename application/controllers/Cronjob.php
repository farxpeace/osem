<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        //phpinfo();
        // To load the CI benchmark and memory usage profiler - set 1==1.

        // Load required CI libraries and helpers.
        $this->load->database();

        // IMPORTANT! This global must be defined BEFORE the flexi auth library is loaded!
        // It is used as a global that is accessible via both models and both libraries, without it, flexi auth will not work.
        $this->auth = new stdClass;

        $this->data = null;
    }

    function minutely_check_expired_lead(){
        $query = $this->db->query("SELECT * FROM view_lead_list WHERE status_code='assigned' AND expired_dttm < CURRENT_TIMESTAMP");
        if($query->num_rows() > 0){
            $list_expired = $query->result_array();

            foreach($list_expired as $a => $b){
                //change status to expired
                //create status
                $lead_status_id = $this->far_lead->create_lead_status($b['lead_id'], 'expired', 'Expired', '1');
                $this->far_lead->update_lead_detail('lead_id', $b['lead_id'], 'lead_status_id', $lead_status_id);

                //change assigned_staff_uacc_id to 0
                $this->far_lead->update_lead_detail('lead_id', $b['lead_id'], 'assigned_agent_uacc_id', '0');


            }
        }
        echo "OK";
    }

    function daily_telegram_report(){
        $this->load->library('far_telegram');
        $chat_id = '-4855814148';

        $shift_date = date('Y-m-d',strtotime("-1 days"));
        $message = "⏰ Attendance report for ".date("D, j F Y",strtotime($shift_date))."\n\n";

        //total attendance
        $query5 = $this->db->query("SELECT COUNT(attendance_id) AS total_attendance FROM attendance_detail WHERE shift_date='".$shift_date."'");
        $total_attendance = $query5->row()->total_attendance ?? 0;

        //missing checkout
        $query6 = $this->db->query("SELECT a.uacc_id,a.clockin_dttm,p.fullname FROM attendance_detail a LEFT JOIN user_profiles p ON p.uacc_id=a.uacc_id WHERE a.shift_date='".$shift_date."' AND a.clockout_dttm IS NULL");
        $total_missing = $query6->num_rows() ?? 0;

        $message .= "✅ Total Check-In : <b>".$total_attendance." persons</b>\n";
        $message .= "❓ Missing Check-Out : <b>".$total_missing." persons</b>\n\n";

        if($total_missing > 0){
            $message .= "List Staff without Clock-Out\n";
            foreach($query6->result_array() as $a => $b){
                $message .= ($a+1).". ".$b['fullname']." (".$b['clockin_dttm'].")\n";
            }
        }
        $message .= "─── ⋆⋅☆⋅⋆ ───── ⋆⋅☆⋅⋆ ──\n\n";

        //echo "<pre>"; echo $message; exit();

        $message_data = array(
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML'
        );
        $this->far_telegram->sendMessage($message_data);
    }














}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */