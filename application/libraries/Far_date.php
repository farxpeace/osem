<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Far_date {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }

    function human_readable($dttm){
        $date = new DateTime($dttm);
        $converted = $date->format("D, j M y g:i A");
        return $converted;
    }

    function convert($dttm, $from_format = "Y-m-d", $to_format = "Y-m-d"){
        $myDateTime = DateTime::createFromFormat($from_format, $dttm);
        $newDateString = $myDateTime->format($to_format);

        return $newDateString;
    }
    
    function convert_format($dttm, $to_format){
        $date = new DateTime($dttm);
        $converted = $date->format($to_format);
        return $converted;
    }
    
    function convert_to_timestamp($dttm){
        $date = new DateTime($dttm);
        return $date->getTimestamp() * 1000;
    }
    
    function list_all_month_between_two_dates($date_start, $date_end, $output_format = 'Y-m-d'){
        $start    = new DateTime($date_start);
        $start->modify('first day of this month');
        $end      = new DateTime($date_end);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        
        $list_date = array();
        $output = array();
        foreach ($period as $dt) {
            $x = $dt->format("Y-m-d H:i:s");
            $list_date['output_format'] = $dt->format($output_format);
            $list_date['timestamp'] = strtotime($x);
            $list_date['standard'] = $x;
            $list_date['standard_month_year'] = $dt->format("Ym");
            $list_date['start_date_for_this_month'] = $dt->format("Y-m").'-01';
            $list_date['end_date_for_this_month'] = $dt->format("Y-m-t");
            $list_date['year'] = $dt->format("Y");
            $list_date['month'] = $dt->format("m");
            $output[] = $list_date;
        }
        
        return $output;
    }
    
    function timestamp(){
        $milliseconds = round(microtime(true) * 1000);
        return $milliseconds;
    }
    
    function validate_date_format($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    
    function add_minutes_to_dttm($minutes_to_add, $dttm = NULL){
        if(!$dttm){
            $dttm = date("Y-m-d H:i:s");
        }
        

        $time = new DateTime($dttm);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        
        $stamp = $time->format('Y-m-d H:i:s');
        return $stamp;
    }
    function add_days($days, $dttm, $format = "Y-m-d H:i:s"){
        $new_dttm = date($format, strtotime('+'.$days.' days', strtotime($dttm)));

        return $new_dttm;
    }
    function add_hours_to_dttm($hours, $dttm, $format = "Y-m-d H:i:s"){
        $new_dttm = date($format, strtotime('+'.$hours.' hours', strtotime($dttm)));
        
        return $new_dttm;
    }
    
    function sec2hms($secs) {
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
        
        $secs = round($secs);
        $secs = abs($secs);
        $hours = floor($secs / 3600);

        $minutes = substr('00' . floor(($secs / 60) % 60), -2);
        $seconds = substr('00' . $secs % 60, -2);
        
        $output = array();
        $output['hours'] = sprintf('%02d', $hours);
        $output['minutes'] = sprintf('%02d', $minutes);
        $output['seconds'] = sprintf('%02d', $seconds);
        
        return $output;
        
        
    }

    function duration_between_two_dates($start_dttm, $end_dttm){
        $output = array();
        $start_date = new DateTime($start_dttm);
        $since_start = $start_date->diff(new DateTime($end_dttm));
        $nice_date = "";
        $output['days_total'] = $since_start->days;
        $output['years'] = $since_start->y;
        $output['months'] = $since_start->m;
        $output['days'] = $since_start->d;
        $output['hours'] = $since_start->h;
        $output['minutes'] = $since_start->i;
        $output['seconds'] = $since_start->s;
        if ($output['years']) { $nice_date .= $since_start->format("%y years "); }
        if ($output['months']) { $nice_date .= $since_start->format("%m months "); }
        if ($output['days']) { $nice_date .= $since_start->format("%d days "); }
        if ($output['hours']) { $nice_date .= $since_start->format("%h hours "); }
        if ($output['minutes']) { $nice_date .= $since_start->format("%i minutes "); }
        if($nice_date == ""){
            if ($output['seconds']) { $nice_date .= $since_start->format("%s seconds "); }
        }

        $date = new DateTime($start_dttm);
        $date2 = new DateTime($end_dttm);
        $output['total_seconds'] = $date2->getTimestamp() - $date->getTimestamp();
        //
        $output['nice_date'] = $nice_date;
        return $output;
    }

    function get_age($dttm){
        $dob = new DateTime($dttm);
        $today   = new DateTime('today');
        $year = $dob->diff($today)->y;
        $month = $dob->diff($today)->m;
        $day = $dob->diff($today)->d;
        return $year;
    }

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function secondsToHoursMinutes($seconds) {

        // Calculate the hours
        $hours = floor($seconds / 3600);

        // Calculate the remaining seconds
        // into minutes
        $minutes = floor(($seconds % 3600) / 60);

        $seconds = substr('00' . $seconds % 60, -2);
        $seconds_final = sprintf('%02d', $seconds);
        // Return the result as an
        // associative array
        $nicetime = "";
        if($hours > 0){
            $nicetime .= $hours." hours ";
        }
        if($minutes > 0){
            $nicetime .= $minutes." minutes ";
        }
        if($seconds_final > 0){
            $nicetime .= $seconds_final." seconds";
        }
        return [
            'hours'   => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds_final,
            'nicetime' => $nicetime
        ];
    }
    
}

?>