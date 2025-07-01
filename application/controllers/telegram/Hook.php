<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Load composer
require APPPATH . 'third_party/php-telegram-bot/vendor/autoload.php';

class Hook extends MY_Controller {
    private $user;
    private $bot_api_key = "8138408559:AAECrBCb9qg7WsI3mY0OMBi2l3UbbiMrbT0";
    private $bot_username = "okkaraoke_bot";
    private $hook_url = "https://karaforeverok.com/telegram/hook/webhook/";
    function __construct()
    {
        parent::__construct();
        // Load required CI libraries and helpers.
        $this->load->database();
        $this->load->library('far_telegram');
    }

    function index(){

    }

    function webhook(){
        $userId = "";
        $getupdate = file_get_contents('php://input'); // for webhook

        $telegram_data = json_decode($getupdate, TRUE);

        //capture chat message
        $this->far_telegram->process_message($telegram_data);

        $request_bin_endpoint = "";
        if(is_array($telegram_data['message']) && count($telegram_data['message']) > 0){
            $request_bin_endpoint = "message";
            $message = $telegram_data['message']['text'];
            if (strpos($message, '/start') === 0) {
                $request_bin_endpoint = "start";
            }
        }elseif(is_array($telegram_data['callback_query']) && count($telegram_data['callback_query']) > 0){
            $request_bin_endpoint = "callback_query";
        }else{
            $request_bin_endpoint = "telegram/message";
        }

        //log
        define("DEBUG", 1);
        define("LOG_FILE", FCPATH."logsfile/telegram/hook/telegram_hook_".date('Y-m-d').".log");
        $log_message = PHP_EOL . "================================== [ LOG START ". date("Y-m-d H:i:s"). " ] ================================". PHP_EOL;
        error_log(print_r($telegram_data, true), 3, LOG_FILE);
        $log_message = PHP_EOL . "================================== [ LOG END ". date("Y-m-d H:i:s"). " ] ================================". PHP_EOL;
        error_log($log_message, 3, LOG_FILE);
        /*
        $handle = curl_init('https://enthd2mhnsjd.x.pipedream.net/'.$request_bin_endpoint);
        //send to request bin
        $data = [
            'URL' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
            'USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'POST' => $_POST,
            'RETURN' => json_decode($out1),
            'TELEGRAM_RESPONSE_DATA' => $telegram_data,
            'GET' => $_GET

        ];
        $encodedData = json_encode($data);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $encodedData);
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($handle);
        */



    }

    function webhook_composer(){
        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($this->bot_api_key, $this->bot_username);

            // Handle telegram webhook request
            $telegram->handle();
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            // echo $e->getMessage();
        }
    }

    function setWebHook(){

        try {
            // Create Telegram API object
            $telegram = new Longman\TelegramBot\Telegram($this->bot_api_key, $this->bot_username);

            // Set webhook
            $result = $telegram->setWebhook($this->hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (Longman\TelegramBot\Exception\TelegramException $e) {
            // log telegram errors
            // echo $e->getMessage();
        }
    }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
