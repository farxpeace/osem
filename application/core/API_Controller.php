<?php

class API_Controller extends CI_Controller
{
    public $error = array();
    private $post;
    function __construct(){
        
        parent::__construct();
        $this->load->library('far_api');
        
        if(strlen($_POST['language']) < 2){
            //echo "lang not set";
            $validate_mobile_token = $this->far_api->get_user_from_mobile_token_if_exists();
            $_POST['language'] = $validate_mobile_token['user_profile']['language'];
        }
        //$_POST['language'] = $_POST['language'] ? $_POST['language'] : "en";
        //load language
        
        $this->lang->load('intelmx_lang', $_POST['language']);
        
        
        //if($validate_mobile_token['user_profile']['language'])
        $this->write_log();
    }
    
    function __destruct(){
        $out1 = ob_get_contents();
        
        define("DEBUG", 1);
        define("LOG_FILE", FCPATH."logsfile/api/".date('Y-m-d').".log");
        
        $json_nice = json_encode($out1, JSON_PRETTY_PRINT);
        
        $write_data = "RETURN:\t".$out1.PHP_EOL;

        error_log($write_data, 3, LOG_FILE);
        
        
        $log_message = PHP_EOL . "================================== [ LOG END ". date("Y-m-d H:i:s"). " ] ================================". PHP_EOL;
        error_log($log_message, 3, LOG_FILE);
        
        
        
        //send to request bin
        $handle = curl_init('https://en7xkfcee3xx.x.pipedream.net/'.$this->router->fetch_class().'/'.$this->router->fetch_method());
        
        
        $data = [
            'URL' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'POST' => $_POST,
            'RETURN' => json_decode($out1),
            'FILES' => $_FILES,
            //'SERVER' => $_SERVER,
            'GET' => $_GET,
            //'POST_RAW' => $_POST
            
        ];
        
        
        
        
        $encodedData = json_encode($data);
        
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $encodedData);
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($handle);
    }
    
    function write_log(){
        ob_start();
        
        define("DEBUG", 1);
        define("LOG_FILE", FCPATH."logsfile/api/".date('Y-m-d').".log");
        $log_message = PHP_EOL . "================================== [ LOG START ". date("Y-m-d H:i:s"). " ] ================================". PHP_EOL;
        error_log($log_message, 3, LOG_FILE);
        
        $postdata_json = json_decode(file_get_contents('php://input'),true);
        if(is_array($postdata_json) && count($postdata_json) != 0){
            $write = $postdata_json;
        }else{
            $write = $this->input->post();
        }
        
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $write_data = "URL :\t".$actual_link.PHP_EOL;
        $write_data .= "TYPE:\t".$_SERVER['REQUEST_METHOD'].PHP_EOL;
        if(count($write) > 0){
            $write_data .= "DATA:";
            foreach($write as $a => $b){
                $write_data .= "\t[".$a."] ".$b.PHP_EOL;
            }
            
            if($_FILES){
                $write_data .= print_r($_FILES, true);
            }
        }
        
        
        //$write_data .= print_r($write, true).PHP_EOL;
        error_log($write_data, 3, LOG_FILE);
        //error_log(print_r($_SERVER, TRUE), 3, LOG_FILE);
        
        $additional_data = array(
            "url" => $actual_link,
            "controller" => $this->router->fetch_class(),
            "method" => $this->router->fetch_method()
        );
        //error_log(print_r($additional_data, TRUE), 3, LOG_FILE);
        
        
        
    }
    
    function detect_what_device(){
        //Detect special conditions devices
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
        $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        
        //do something with this information
        if( $iPod || $iPhone ){
            //browser reported as an iPhone/iPod touch -- do something here
        }else if($iPad){
            //browser reported as an iPad -- do something here
        }else if($Android){
            //browser reported as an Android device -- do something here
        }else if($webOS){
            //browser reported as a webOS device -- do something here
        }
        
        return $device_detected;
    }
}

