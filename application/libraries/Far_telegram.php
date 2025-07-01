<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Far_telegram {
    private $CI;
    public $telegram_reply_link;
    public $bot_api_key;
    public $bot_username;
    private $telegram_data;
    private $chat_id;
    private $is_bot;
    private $text_received;
    private $first_name;
    private $username;
    private $language_code;
    private $callback_data;
    private $uacc_id;

    private $list_superadmin_array = array('3696775', '251843149');
    private $is_super_admin = "no";

    private $bedb;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->library('session');
        $this->CI->load->database();


        $this->bot_username = "okkaraoke_bot";
        $this->bot_api_key = "8138408559:AAECrBCb9qg7WsI3mY0OMBi2l3UbbiMrbT0";
        $this->telegram_reply_link = "https://api.telegram.org:443/bot".$this->bot_api_key;
    }

    function process_message($telegram_data){
        $this->telegram_data = $telegram_data;
        $this->chat_id = $telegram_data['message']['from']['id'] ? $telegram_data['message']['from']['id'] : $telegram_data['callback_query']['from']['id'];
        if(in_array($this->chat_id, $this->list_superadmin_array)){
            $this->is_super_admin = "yes";
        }
        /*
        $this->sendChatAction(array(
            'chat_id' => $this->chat_id,
            'action' => 'typing'
        ));
        */

        //get uacc_id if exists
        $query = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."'");
        if($query->num_rows() > 0){
            $this->uacc_id = $query->row()->uacc_id;
        }

        if(is_array($telegram_data['message']) && count($telegram_data['message']) > 0){
            //insert into private params

            $this->is_bot = $telegram_data['message']['from']['is_bot'];
            $this->text_received = $telegram_data['message']['text'];
            $this->first_name = $telegram_data['message']['from']['first_name'];
            $this->username = $telegram_data['message']['from']['username'];
            $this->language_code = $telegram_data['message']['from']['language_code'];

            //start to process
            $this->capture_message($telegram_data);
            $this->is_start_message($this->telegram_data);
            $this->check_for_command_and_reply($this->telegram_data);
        }elseif(is_array($telegram_data['callback_query']) && count($telegram_data['callback_query']) > 0){
            $this->callback_data = $telegram_data['callback_query']['data'];
            $this->text_received = $telegram_data['message']['text'];
            $this->is_bot = $telegram_data['callback_query']['from']['is_bot'];
            $this->first_name = $telegram_data['callback_query']['from']['first_name'];
            $this->username = $telegram_data['callback_query']['from']['username'];
            $this->language_code = $telegram_data['callback_query']['from']['language_code'];

            $this->process_callback_query($telegram_data);
        }


    }

    function check_for_command_and_reply(){

        $message_data = array();
        $message_data['chat_id'] = $this->chat_id;
        $user_detail = $this->CI->far_users->get_user('uacc_id', $this->uacc_id);

        if(base64_encode($this->text_received) == '8J+Vte+4j+KAjeKZgO+4jyBWaWV3IFByb2ZpbGU='){
            $message_data['text'] = "Here is your user profile. Choose any listed button below";
            $message_data["reply_markup"] = $this->keyboard_markup_view_profile();

        }elseif(base64_encode($this->text_received) == '4qyF77iPIEJhY2s='){
            $message_data["reply_markup"] = $this->keyboard_markup_home();
            $message_data['text'] = "OK";

        }elseif(base64_encode($this->text_received) == '8J+Vte+4j+KAjeKZgO+4jyBQcm9maWxl'){ //🕵️‍♀️ Profile
            //get user detail
            if(is_array($user_detail) && count($user_detail) > 0){
                $message_data['text'] = "To view your profile, please choose any listed account(s) below";
                $message_data['reply_markup'] = $this->inlinekeyboard_markup_profile();
            }else{
                $message_data['text'] = "Error while finding your detail. Please contact Administrator (Error Code 11)";
            }


        }elseif(base64_encode($this->text_received) == '8J+RqOKAjfCfkabigI3wn5GmIFJlZmVycmFs'){ //referral detail
            //get user detail
            if(is_array($user_detail) && count($user_detail) > 0){
                $message_data['text'] = "Referral Fullname : \n".$user_detail['userFullname']."\n\n";
                $message_data['text'] .= "Referral Username : \n".$user_detail['uacc_username']."\n";
            }else{
                $message_data['text'] = "Error while finding your detail. Please contact Administrator (Error Code 12)";
            }

        }elseif(base64_encode($this->text_received) == '8J+PpiBCYW5r'){ //bank detail
            //get user detail
            if(is_array($user_detail) && count($user_detail) > 0){
                $message_data['text'] = "Bank Name : \n".$user_detail['bank']['bankName']."\n\n";
                $message_data['text'] .= "Account Holder : \n".$user_detail['bank']['bankAccountHolder']."\n\n";
                $message_data['text'] .= "Account Number : \n".$user_detail['bank']['bankAccountNumber']."\n\n";
            }else{
                $message_data['text'] = "Error while finding your detail. Please contact Administrator (Error Code 13)";
            }

        }elseif(base64_encode($this->text_received) == '8J+bo++4jyBBZGRyZXNz'){ //address detail
            //get user detail
            if(is_array($user_detail) && count($user_detail) > 0){
                $message_data['text'] = "Address 1 : \n".$user_detail['address']['addressLine']."\n\n";
                $message_data['text'] .= "Postcode : \n".$user_detail['address']['addressPostcode']."\n\n";
                $message_data['text'] .= "City : \n".$user_detail['address']['addressCity']."\n\n";
                $message_data['text'] .= "State : \n".$user_detail['address']['addressState']."\n\n";
                $message_data['text'] .= "Country : \n".$user_detail['address']['addressCountry']."\n\n";
            }else{
                $message_data['text'] = "Error while finding your detail. Please contact Administrator (Error Code 14)";
            }

        }elseif(base64_encode($this->text_received) == '8J+Vte+4jyBJZGVudGlmaWNhdGlvbg=='){ //Identification detail
            //get user detail
            if(is_array($user_detail) && count($user_detail) > 0){
                $message_data['text'] = "Type : \n".$user_detail['uacc_identificationType']."\n\n";
                $message_data['text'] .= "Number : \n".$user_detail['uacc_identificationNumber']."\n\n";
                $message_data['text'] .= "Mykad : \n".$user_detail['userMykad']."\n\n";
                $message_data['text'] .= "Passport : \n".$user_detail['userPassport']."\n\n";
            }else{
                $message_data['text'] = "Error while finding your detail. Please contact Administrator (Error Code 15)";
            }

        }elseif(base64_encode($this->text_received) == '8J+bhCBNZW1iZXJzaGlw'){ //Membership detail
            //get user detail
            if(is_array($user_detail) && count($user_detail) > 0){
                $message_data['text'] = "Package Name : \n".$user_detail['membership']['membershipPackageName']."\n\n";
                $message_data['text'] .= "Amount : \n".$user_detail['membership']['membershipPackageAmount']."\n\n";
            }else{
                $message_data['text'] = "Error while finding your detail. Please contact Administrator (Error Code 16)";
            }

        }elseif(base64_encode($this->text_received) == '8J+UkSBSZXF1ZXN0IE9UUA=='){ //request OTP
            $message_data['text'] = "To request an OTP, please choose which account from buttons below";
            $message_data['reply_markup'] = $this->inlinekeyboard_markup_request_otp();




        }elseif(base64_encode($this->text_received) == '8J+UkCBUaWNrZXQgU29sZA=='){ //🔐 Ticket Sold
            $message_data['text'] = "Ticket Sold";
            $message_data["reply_markup"] = $this->keyboard_markup_home();
        }elseif(base64_encode($this->text_received) == 'VW5wYWlyIEFjYw=='){ //Unpair Acc
            $message_data['text'] = "You are trying to unpair Bemobile account with this Telegram. Choose account you would like to unpair below";
            $message_data["reply_markup"] = $this->inlinekeyboard_markup_remove_account();
        }elseif(base64_encode($this->text_received) == 'QWNjb3VudCBQYWlyaW5n'){ //Account Pairing
            $message_data['text'] = "Click Login button below, and login using your Bemobile Email and Password";
            //$message_data["reply_markup"] = $this->inlinekeyboard_markup_login_using_bemobile_account();
        }elseif(base64_encode($this->text_received) == '8J+VkCBPVFAgTGFzdCBUcmFuc2FjdGlvbg=='){ //🕐 OTP Last Transaction
            $message_data['text'] = "To view OTP Last Transaction, please choose which account from buttons below";
            $message_data['reply_markup'] = $this->inlinekeyboard_markup_request_last_otp();
        }elseif(base64_encode($this->text_received) == '8J+kliBTdXBlcmFkbWlu'){ //🤖 Superadmin
            $message_data['text'] = "You are superadmin";
            $message_data['reply_markup'] = $this->inlinekeyboard_markup_superadmin();
        }else{

            //debug emoji
            $message_data['text'] = base64_encode($this->text_received);

            /*
            $this->sendChatAction(array(
                'chat_id' => $message_data['chat_id'],
                'action' => 'typing'
            ));
            $this->ask_chat_gpt($this->text_received);
            */

        }

        if(strlen($message_data['text']) > 1){
            $this->sendMessage($message_data);
        }

    }

    function process_callback_query($telegram_data){
        $message_data = array();
        $message_data['chat_id'] = $this->chat_id;

        $command_split = explode("_", $this->callback_data);
        $command_1 = $command_split[0];
        if($command_1 == 'unpairaccount'){
            $uacc_id_to_unpair = $command_split[1];
            $query = $this->CI->db->query("DELETE FROM telegram_users WHERE uacc_id='".$uacc_id_to_unpair."'");
            $message_data['text'] = "Successfully unpair your Bemobile account. You may pair again later";
            $message_data['reply_markup'] = $this->keyboard_markup_home();
        }elseif($command_1 == "requestotp"){
            $this->uacc_id = $command_split[1];
            $this->generate_otp($this->uacc_id);
        }elseif($command_1 == "requestlastotp"){
            $this->uacc_id = $command_split[1];
            $this->find_last_otp($this->uacc_id);
        }

        if(strlen($message_data['text']) > 1){
            $this->sendMessage($message_data);
        }
    }





    function is_start_message($telegram_data){
        if (strpos($this->text_received, '/start') === 0) {
            $ex = explode(" ", $this->text_received);
            $encoded_uacc_id = $ex[1];
            $decoded_string = base64_decode($encoded_uacc_id);
            $decoded_string_explode = explode("_", $decoded_string);
            $uacc_id = $decoded_string_explode[1];
            $this->uacc_id = $uacc_id;



            //check is uacc_id valid
            $query = $this->CI->db->query("SELECT * FROM user_accounts WHERE uacc_id='".$this->uacc_id."'");
            if($query->num_rows() > 0){


                //check if already registered
                $query4 = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."' AND uacc_id='".$this->uacc_id."'");
                if($query4->num_rows() > 0){
                    //already paired
                    //update first_name and language_code
                    $update_user_data = array(
                        'uacc_id' => $this->uacc_id,
                        'first_name' => $this->first_name,
                        'language_code' => $this->language_code
                    );
                    $this->CI->db->where('chat_id', $this->chat_id);
                    $this->CI->db->where('uacc_id', $this->uacc_id);
                    $this->CI->db->update('telegram_users', $update_user_data);
                    //send already pair
                    $error_authentication_message_data = array(
                        'chat_id' => $this->chat_id,
                        'text' => "Your account already paired"
                    );
                    $error_authentication_message_data["reply_markup"] = $this->keyboard_markup_home();
                    $this->sendMessage($error_authentication_message_data);
                }else{
                    //register user
                    $telegram_users_insert = array(
                        'uacc_id' => $uacc_id,
                        'chat_id' => $this->chat_id,
                        'is_bot' => $this->is_bot,
                        'first_name' => $this->first_name,
                        'username' => $this->username,
                        'language_code'  => $this->language_code
                    );
                    $this->CI->db->insert('telegram_users', $telegram_users_insert);

                    $this->send_welcome_message();
                }



            }else{
                //no data found.
                $no_userdata_found = array();
                $no_userdata_found['chat_id'] = $this->chat_id;
                $no_userdata_found['text'] = "Welcome to Bemobile Telegram Bot\n";
                $no_userdata_found['text'] .= "On this Telegram Bot, you will be able to\n\n";
                $no_userdata_found['text'] .= "👉 Pair / Unpair Bemobile Account\n";
                $no_userdata_found['text'] .= "👉 Request OTP\n";
                $no_userdata_found['text'] .= "👉 View Bemobile Transactions\n";
                $no_userdata_found['text'] .= "👉 View your Profile\n";
                $no_userdata_found['text'] .= "👉 Receive latest news & marketing info\n";
                $no_userdata_found['text'] .= "👉 and many new features will be release later..\n\n";
                $no_userdata_found['text'] .= "By using this bot, you are accept with our terms & conditions.";
                //check if this user already have an account
                $query3 = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."'");
                if($query3->num_rows() > 0){

                    $no_userdata_found['reply_markup'] = $this->keyboard_markup_home();

                }else{

                    $no_userdata_found['reply_markup'] = $this->inlinekeyboard_markup_login_using_bemobile_account();

                }
                $this->sendMessage($no_userdata_found);

            }


        }
    }

    function sendMessage($message_data){
        /*
        $this->sendChatAction(array(
            'chat_id' => $message_data['chat_id'],
            'action' => 'typing'
        ));
        */
        //send message welcome
        $request_url = $this->telegram_reply_link.'/sendMessage?'.http_build_query($message_data);

        $ch = curl_init($request_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);

        curl_close($ch);

        //file_get_contents($request_url);


    }

    function send_welcome_message(){

        //send message welcome
        $message_data = array(
            'chat_id' => $this->chat_id,
            'text' => "Welcome to Bemobile Official Telegram Bot. You can communicate with us instantly and receive latest news. Click any button below to proceed."
        );
        $message_data["reply_markup"] = $this->keyboard_markup_home();
        $this->sendMessage($message_data);


    }

    function keyboard_markup_account(){
        $keyboard = array(
            'is_persistent' => true,
            'resize_keyboard' => true,
            'keyboard' => array(
                array("Account Pairing", "Unpair Acc"),
                array("⬅️ Back"),
            )
        );
        $output = json_encode($keyboard);
        return $output;
    }

    function keyboard_markup_home(){
        $array_superadmin = array();
        if($this->is_super_admin == "yes"){
            $array_superadmin = array("🤖 Superadmin");
        }

        $keyboard = array(
            'is_persistent' => true,
            'resize_keyboard' => true,
            'keyboard' => array(
                array("🔐 Ticket Sold", "🔑 Request OTP"),
                array("🕐 OTP Last Transaction"),
                $array_superadmin
            )
        );
        $output = json_encode($keyboard);
        return $output;
    }
    function keyboard_markup_view_profile(){
        $keyboard = array(
            'is_persistent' => true,
            'resize_keyboard' => true,
            'keyboard' => array(
                array("🕵️‍♀️ Profile", "👨‍👦‍👦 Referral", "🏦 Bank"),
                array("🛣️ Address","🕵️ Identification"),
                array("⬅️ Back", "🛄 Membership"),
            )
        );
        $output = json_encode($keyboard);
        return $output;
    }
    function keyboard_markup_back_to_home(){
        $keyboard = array(
            'is_persistent' => true,
            'resize_keyboard' => true,
            'keyboard' => array(
                array("⬅️ Back"),
            )
        );
        $output = json_encode($keyboard);
        return $output;
    }

    function inlinekeyboard_markup_superadmin(){
        $this->CI->load->library('encryption');
        $superadmin_uacc_id = $this->get_telegram_users_by_column('chat_id', $this->chat_id, 'uacc_id');
        $time = time();
        $encrypted_uacc_id = ($superadmin_uacc_id)+$time;
        $inlineKeyboardMarkup = array(
            'inline_keyboard' => array(
                array(
                    array(
                        'text' => "Open SuperAdmin",
                        "web_app" => array(
                            "url" => "https://web02.bemobile.biz/telegram/webapp/mainframe_superadmin/?uacc_id=".$encrypted_uacc_id."&key=".$time."&chat_id=".$this->chat_id."&u=".($superadmin_uacc_id+5478665)
                        )
                    )
                )
            )
        );
        $output = json_encode($inlineKeyboardMarkup);
        return $output;
    }

    function inlinekeyboard_markup_profile(){
        $this->CI->load->library('encryption');
        $query = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."'");
        $list_bemobile_account = $query->result_array();

        $list_builded = array();
        foreach($list_bemobile_account as $a => $b){
            //get bemobile user detail
            $query2 = $this->CI->db->query("SELECT uacc_id,uacc_username FROM user_accounts WHERE uacc_id='".$b['uacc_id']."'");
            $time = time();
            $encrypted_uacc_id = ($query2->row()->uacc_id)+$time;
            log_message('error', "https://web02.bemobile.biz/telegram/webapp/mainframe/?uacc_id=".$encrypted_uacc_id."&key=".$time);
            $list_builded[] = array(
                'text' => $query2->row()->uacc_username,
                "web_app" => array(
                    "url" => "https://web02.bemobile.biz/telegram/webapp/mainframe/?uacc_id=".$encrypted_uacc_id."&key=".$time
                )
            );
        }
        $inlineKeyboardMarkup = array(
            'inline_keyboard' => array(
                $list_builded
            )
        );
        $output = json_encode($inlineKeyboardMarkup);
        return $output;
    }
    function inlinekeyboard_markup_request_otp(){
        $query = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."'");
        $list_bemobile_account = $query->result_array();

        $list_builded = array();
        foreach($list_bemobile_account as $a => $b){
            //get bemobile user detail
            $query2 = $this->CI->db->query("SELECT uacc_id,uacc_username FROM user_accounts WHERE uacc_id='".$b['uacc_id']."'");
            $list_builded[] = array(
                'text' => $query2->row()->uacc_username,
                'callback_data' => "requestotp_".$query2->row()->uacc_id
            );
        }
        $inlineKeyboardMarkup = array(
            'inline_keyboard' => array(
                $list_builded
            )
        );
        $output = json_encode($inlineKeyboardMarkup);
        return $output;
    }
    function inlinekeyboard_markup_request_last_otp(){
        $query = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."'");
        $list_bemobile_account = $query->result_array();

        $list_builded = array();
        foreach($list_bemobile_account as $a => $b){
            //get bemobile user detail
            $query2 = $this->CI->db->query("SELECT uacc_id,uacc_username FROM user_accounts WHERE uacc_id='".$b['uacc_id']."'");
            $list_builded[] = array(
                'text' => $query2->row()->uacc_username,
                'callback_data' => "requestlastotp_".$query2->row()->uacc_id
            );
        }
        $inlineKeyboardMarkup = array(
            'inline_keyboard' => array(
                $list_builded
            )
        );
        $output = json_encode($inlineKeyboardMarkup);
        return $output;
    }
    function inlinekeyboard_markup_remove_account(){

        $query = $this->CI->db->query("SELECT * FROM telegram_users WHERE chat_id='".$this->chat_id."'");
        $list_bemobile_account = $query->result_array();

        $list_builded = array();
        foreach($list_bemobile_account as $a => $b){
            //get bemobile user detail
            $query2 = $this->CI->db->query("SELECT uacc_id,uacc_username FROM user_accounts WHERE uacc_id='".$b['uacc_id']."'");
            $list_builded[] = array(
                'text' => $query2->row()->uacc_username,
                'callback_data' => "unpairaccount_".$query2->row()->uacc_id
            );
        }

        $inlineKeyboardMarkup = array(
            'inline_keyboard' => array(
                $list_builded
            )
        );
        $output = json_encode($inlineKeyboardMarkup);
        return $output;
    }
    function inlinekeyboard_markup_login_using_bemobile_account(){
        $inlineKeyboardMarkup = array(

            'inline_keyboard' => array(
                array(
                    array(
                        'text' => 'Login to your Bemobile Account ',
                        "web_app" => array(
                            "url" => "https://web02.bemobile.biz/telegram/login/bot/?chat_id=".$this->chat_id
                        )
                    )

                )
            )
        );
        $output = json_encode($inlineKeyboardMarkup);
        return $output;
    }




    function capture_message($telegram_data){

        $chat_id = $telegram_data['message']['chat']['id'];
        $first_name = $telegram_data['message']['chat']['first_name'];
        $username = $telegram_data['message']['chat']['username'];
        $type = $telegram_data['message']['chat']['type'];

        $date = $telegram_data['message']['date'];
        $text = $telegram_data['message']['text'];

        $telegram_chat_insert = array(
            'chat_id' => $chat_id,
            'first_name' => $first_name,
            'username' => $username,
            'type'  => $type,
            'date' => $date,
            'text' => $text,
            'create_dttm' => date("Y-m-d H:i:s")
        );
        $this->CI->db->insert('telegram_chat', $telegram_chat_insert);
    }

    function sendChatAction($message_data){
        //send message welcome
        $request_url = $this->telegram_reply_link.'/sendChatAction?'.http_build_query($message_data);
        file_get_contents($request_url);
    }

    function ask_chat_gpt($question){
        $yourApiKey = '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';

        $ch = curl_init();

        $url = 'https://api.openai.com/v1/chat/completions';

        $api_key = $yourApiKey;

        $query = $question;

        $post_fields = array(
            "model" => "gpt-3.5-turbo",
            "messages" => array(
                array(
                    "role" => "user",
                    "content" => $query
                )
            ),
            "max_tokens" => 1024,
            "temperature" => 0
        );

        $header  = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($result);
        $final_answer = $response->choices[0]->message->content;

        //send message welcome
        $message_data = array(
            'chat_id' => $this->chat_id,
            'text' => $final_answer
        );
        $message_data["reply_markup"] = $this->keyboard_markup_home();
        $this->sendMessage($message_data);
    }

    function insert_new_user($uacc_id, $user_chat_id){
        $this->uacc_id = $uacc_id;
        $this->chat_id = $user_chat_id;
        $telegram_users_insert = array(
            'uacc_id' => $uacc_id,
            'chat_id' => $user_chat_id,
            'is_bot' => 0,
            'first_name' => "",
            'username' => "",
            'language_code'  => "en"
        );
        $this->CI->db->insert('telegram_users', $telegram_users_insert);

        //send welcome
        $this->send_welcome_message();

    }

    function get_telegram_users_by_column($column, $value, $column_name){
        $query = $this->CI->db->query("SELECT ".$column_name." FROM telegram_users WHERE ".$column."='".$value."'");
        $row = $query->row_array();
        return $row[$column_name];
    }

    function send_message_queue($message_data){
        $message_data['create_dttm'] = date("Y-m-d H:i:s");
        $message_data['status'] = 'pending';
        $this->CI->db->insert('telegram_message_out', $message_data);
        return $this->CI->db->insert_id();
    }


    /**
     * Get User Account
     */
    /**
    function get_account($column, $value){
    $query = $this->CI->db->query("SELECT * FROM user_accounts_accounts WHERE ".$column."='".$value."'");
    return $query->row_array();
    }
     */
    /**
    function list_account($column, $value){
    $query = $this->CI->db->query("SELECT * FROM user_accounts_accounts WHERE ".$column."='".$value."'");
    return $query->result_array();
    }
     */

    /**
     * Insert / Create profile
     * @param array $data
     */
    /**
    function insert_profile($data){
    $this->CI->db->insert('user_profiles', $data);
    return $this->CI->db->insert_id();
    }
     */
    /**
     * Update
     * @param string $key Database column name
     * @param string $key_value Database column value(s)
     * @param string $column Column name to update
     * @param string $value New value for specified column
     */
    /**
    function update_user($key, $key_value, $column, $value){
    $data = array(
    $column => $value
    );

    $this->CI->db->where($key, $key_value);
    $this->CI->db->update('user_accounts', $data);
    }
     */

}


?>
