<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH . 'third_party/phpqrcode/qrlib.php';

class Far_helper {
    private $CI;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();
    }
    function remove_decimal($number){
        return bcdiv($number, 1, 0);
    }
    function convert_to_currency_format($number){
        return number_format($number, 2, '.', '');
    }
    function generate_qrcode($contents, $path, $filename){
        // generating
        $pngAbsoluteFilePath = $path.$filename;
        QRcode::png($contents, $pngAbsoluteFilePath);
    }

    function list_postcode_distinct(){
        $query = $this->CI->db->query("SELECT DISTINCT(postcode) AS postcode FROM postcode");
        return $query->result_array();
    }

    function server(){
        $output = 'live';
        $server_domain_name = $_SERVER['HTTP_HOST'];
        if($server_domain_name == 'lead.test'){
            $output = 'dev';
        }
        return $output;
    }
    
    /**
     * Convert number to price format.
     */
    function convert_number_to_price_format($number){
        return number_format($number, 2, ".", "," );
    }
    
    function generateRandomnumber($length = 6){
        $result = '';
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
        return $result;
    }

    function generateRandomString($length = 10, $characters = NULL) {
        if(!$characters){
            $characters = '0123456789ABCDEFGHJKLMNOPQRSTUVWXYZ';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function convert_positive_to_negative($positive_value){
        $num = -1 * abs($positive_value);
        return $num;
    }
    
    function convert_negative_to_positive($negative_value){
        return abs($negative_value);
    }
    
    /*
    Copyright (c) 2009, reusablecode.blogspot.com; some rights reserved.
    
    This work is licensed under the Creative Commons Attribution License. To view
    a copy of this license, visit http://creativecommons.org/licenses/by/3.0/ or
    send a letter to Creative Commons, 559 Nathan Abbott Way, Stanford, California
    94305, USA.
    */
 
    // Convert letters and numbers to corresponding NATO phonetic alphabet code words.
    function phonetic($char){
        $nato = array(
            "a" => "alfa", 
            "b" => "bravo", 
            "c" => "charlie", 
            "d" => "delta", 
            "e" => "echo", 
            "f" => "foxtrot", 
            "g" => "golf", 
            "h" => "hotel", 
            "i" => "india", 
            "j" => "juliett", 
            "k" => "kilo", 
            "l" => "lima", 
            "m" => "mike", 
            "n" => "november", 
            "o" => "oscar", 
            "p" => "papa", 
            "q" => "quebec", 
            "r" => "romeo", 
            "s" => "sierra", 
            "t" => "tango", 
            "u" => "uniform", 
            "v" => "victor", 
            "w" => "whisky", 
            "x" => "x-ray", 
            "y" => "yankee", 
            "z" => "zulu", 
            "0" => "zero", 
            "1" => "one", 
            "2" => "two", 
            "3" => "three", 
            "4" => "four", 
            "5" => "five", 
            "6" => "six", 
            "7" => "seven", 
            "8" => "eight", 
            "9" => "niner"
            );
 
        return $nato[strtolower($char)];
    }
    
    function list_all_bank(){
        $query = $this->CI->db->query("SELECT * FROM far_bank WHERE bank_status='available'");
        return $query->result_array();
    }
    function get_bank($column, $value){
        $query = $this->CI->db->query("SELECT * FROM far_bank WHERE ".$column."='".$value."'");
        return $query->row_array();
    }
    function fix_msisdn($phone_number){
        
        //remove non digit
        $phone_number = preg_replace('/[^0-9.]+/', '', $phone_number);

        //check if possible malaysian phone number
        $first_two = substr($phone_number, 0, 2);
        if($first_two == '01'){
            //might be malaysia phone number, add 6.
            $phone_number = '6'.$phone_number;
        }
        
        //filter 6060
        $first_four = substr($phone_number, 0, 4);
        if($first_four == '6060'){
            $phone_number = substr($phone_number, 2);
        }

        //filter 6001
        $first_four = substr($phone_number, 0, 4);
        if($first_four == '6001'){
            $phone_number = '601'.substr($phone_number, 4);
        }
        
        
        //echo $phone_number; exit();
        
        return $phone_number;
    }
    
    function check_phone_number_is_valid($phonenumber){
        require_once APPPATH."third_party/libphonenumber/vendor/autoload.php";
        
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $swissNumberProto = $phoneUtil->parse($phonenumber);
            $isValid = $phoneUtil->isValidNumber($swissNumberProto);
            if($isValid){
                $output = array(
                    'country_code' => $phoneUtil->getRegionCodeForNumber($swissNumberProto)
                );
                return $output;
            }
            
        } catch (\libphonenumber\NumberParseException $e) {
            //var_dump($e);
            return false;
        }
        
        return false;
    }
    
    function split_msisdn_and_prefix($msisdn){
        $output = array();
        $msisdn = $this->fix_msisdn($msisdn);
        $prefix = substr($msisdn, 0, 4);
        $phone_number = substr($msisdn, 4);
        
        $output['prefix'] = $prefix;
        $output['phone_number'] = $phone_number;
        return $output;
    }
    function money_format($number){
        $formatted = number_format($number, 2, '.', ',');
        //$formatted = sprintf('%0.2f', $number);
        return $formatted;
    }
    function replace_http_to_https($string){
        /*
        $string = strtolower($string);
        $url = preg_replace("/^http:/i", "https:", $string);
        */
        $url = str_replace( 'http://', 'https://', $string );
        return $url;
    }
    function isValidEmail($email){ 
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    function DuplicateMySQLRecord($table, $id_field, $id) {
        // load the original record into an array
        $result = $this->CI->db->query("SELECT * FROM ".$table." WHERE ".$id_field."='".$id."'");
        $original_record = $result->row_array();
        //print_r($original_record); exit();
        $this->CI->db->insert($table, array('job_id' => NULL));
        $newid = $this->CI->db->insert_id();
        // generate the query to update the new record with the previous values
        $update_data = array();
        foreach ($original_record as $key => $value) {
            if ($key != $id_field) {
                $update_data[$key] = $value;
            }
        }
        $this->CI->db->where($id_field, $newid);
        $this->CI->db->update($table, $update_data);
        // return the new id
        return $newid;
    }
    function curl_get($url){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'DoDoo Delivery'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);
        return $resp;
    }
    /**
	 * Returns a safe filename, for a given platform (OS), by replacing all
	 * dangerous characters with an underscore.
	 *
	 * @param string $dangerous_filename The source filename to be "sanitized"
	 * @param string $platform The target OS
	 *
	 * @return Boolean string A safe version of the input filename
	 */
    function sanitizeFileName($dangerous_filename, $platform = 'Unix')
  	{
		if (in_array(strtolower($platform), array('unix', 'linux'))) {
			// our list of "dangerous characters", add/remove characters if necessary
  			$dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#");
  		}
  	  	else {
			// no OS matched? return the original filename then...
  	  	  	return $dangerous_filename;
  	  	}
  	
		// every forbidden character is replace by an underscore
		return str_replace($dangerous_characters, '_', $dangerous_filename);
  	}
    
    function get_thumbnail_if_available($full_url_path){
        
        $exploded = explode(base_url(), $full_url_path);
        $new_path = FCPATH.dirname($exploded[1]).'/thumbs/'.basename($full_url_path);
        if (file_exists($new_path)) {
            return dirname($full_url_path).'/thumbs/'.basename($full_url_path);
        }else{
            return $full_url_path;
        }
    }
    
    function check_if_listed_on_banned_username($text){
        $query = $this->CI->db->query("SELECT * FROM banned_username WHERE text LIKE '%".$text."%' LIMIT 1");
        $numrow = $query->num_rows();
        if($numrow > 0){
            return true;
        }else{
            return false;
        }
    }
    
    function foldersize($dir){
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir)
        );
        
        $totalSize = 0;
        foreach ($iterator as $file) {
            $totalSize += $file->getSize();
        }
        return $totalSize;
    }
    
    function sizeFormat($size){ 
        $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision)." ".$units[$i];
    }
    
    function database_size(){
        $user = $this->CI->db->username;
        $password = $this->CI->db->password;
        $host = $this->CI->db->hostname;
        $db_name = $this->CI->db->database;
        
        $query = $this->CI->db->query("SELECT table_schema as 'database_name', 
        sum( data_length + index_length ) as 'size_in_bytes'    
            FROM     information_schema.TABLES
        WHERE table_schema = '".$db_name."'");
        $size_in_bytes = $query->row()->size_in_bytes;
        
        return $size_in_bytes;
    }
    
    function list_disk_usage(){
        
        
        
        
        $output = array();
        $total_storage = 107374127424; //100GB in bytes
        
        //database size
        $output['database']['total_size_in_byte'] = $this->database_size();
        $output['database']['total_size_nice_format'] = $this->formatSizeUnits($output['database']['total_size_in_byte']);
        
        
        
        //system
        $system_total_size_in_byte = $this->foldersize(FCPATH);
        $output['system']['total_size_in_byte'] = $system_total_size_in_byte;
        $output['system']['total_size_nice_format'] = $this->formatSizeUnits($system_total_size_in_byte);
        
        
        $output['total']['total_size_in_byte'] = $output['database']['total_size_in_byte']+$system_total_size_in_byte;
        $output['total']['total_size_nice_format'] = $this->formatSizeUnits($output['total']['total_size_in_byte']);
        
        $output['total']['total_storage'] = $total_storage;
        
        //database percentage
        $percentage_database = ($output['database']['total_size_in_byte']/$total_storage)*100;
        $output['total']['percentage_database'] = round($percentage_database, 2);
        
        $percentage_system = ($output['system']['total_size_in_byte']/$total_storage)*100;
        $output['total']['percentage_system'] = round($percentage_system,2);
        
        $output['total']['percentage'] = round($percentage_database+$percentage_system, 2);
        //echo "<pre>"; print_r($output); echo "</pre>";
        return $output;
    }
    

    
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    function makeInitialsFromSingleWord($name)
    {
        preg_match_all('#([A-Z]+)#', $name, $capitals);
        if (count($capitals[1]) >= 2) {
            return mb_substr(implode('', $capitals[1]), 0, 2, 'UTF-8');
        }
        return mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    }
    function number_format_short( $n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
    function calculateCountdownPercentage(string $startDateStr, string $endDateStr): float
    {

        // Get today's date and time
        $today = new DateTime();

        // Create DateTime objects for start and end dates
        try {
            $startDate = new DateTime($startDateStr);
            $endDate = new DateTime($endDateStr);
        } catch (Exception $e) {
            // Handle invalid date strings
            error_log("Error parsing dates: " . $e->getMessage());
            return 0.0;
        }

        // --- 1. Calculate Total Duration ---
        // Ensure endDate is after startDate for a valid duration
        if ($endDate <= $startDate) {
            // If end date is on or before start date, it's an invalid or zero-length period
            return 0.0;
        }

        $total_interval = $startDate->diff($endDate);
        $total_seconds = ($total_interval->days * 24 * 60 * 60) + ($total_interval->h * 60 * 60) + ($total_interval->i * 60) + $total_interval->s;

        // If for some reason total_seconds is zero or negative (shouldn't happen with $endDate <= $startDate check, but for safety)
        if ($total_seconds <= 0) {
            return 0.0;
        }

        // --- 2. Check if the countdown period has already finished ---
        if ($today >= $endDate) {
            return 100.0; // Countdown is 100% complete
        }

        // --- 3. Check if the countdown period hasn't started yet ---
        if ($today <= $startDate) {
            return 0.0; // Countdown has not yet started
        }

        // --- 4. Calculate Elapsed Duration from Start Date to Today ---
        $elapsed_interval = $startDate->diff($today);
        $elapsed_seconds = ($elapsed_interval->days * 24 * 60 * 60) + ($elapsed_interval->h * 60 * 60) + ($elapsed_interval->i * 60) + $elapsed_interval->s;

        // --- 5. Calculate Countdown Percentage ---
        $countdown_percentage = ($elapsed_seconds / $total_seconds) * 100;

        return round($countdown_percentage, 2); // Round to 2 decimal places for typical percentage display
    }

}
?>