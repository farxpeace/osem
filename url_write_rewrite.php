<?php
//get request uri
$uri = $_SERVER['REQUEST_URI'];
$parse_url = parse_url($uri);
//explode
$uri_explode = explode("/",$parse_url['path']);
//$uri_explode = array_filter($uri_explode);
$uri_explode = array_values(array_filter($uri_explode, function($value) { return trim($value) !== ''; }));
//rearrange
$segment = array_values(array_filter($uri_explode));
include("./application/third_party/Medoo.php");
use Medoo\Medoo;
if(count($segment) == 1){
    //check if this is a vip user
//include("./application/third_party/Medoo.php");
    include("./application/config/database.php");

//connect to database
    $database = new Medoo([
        'database_type' => 'mysql',
        'database_name' => $db['default']['database'],
        'server' => $db['default']['hostname'],
        'username' => $db['default']['username'],
        'password' => $db['default']['password']
    ]);
    $alias_url_name = strtolower($segment[0]);

    if(strlen($alias_url_name) > 0 && $alias_url_name != 'assets'){

        //process identifier
        $identifier_array = array();
        $identifier_error = array();
        foreach($segment as $a => $b){
            if($a != 0){
                if(preg_match('/[^a-z_\-0-9]/i', strtolower($b))){
                    $identifier_error[] = $b." is not allowed as identifier. Only character and number are allowed.";
                }else{
                    $identifier_array[] = strtolower($b);
                }
            }
        }
        if(count($identifier_error)  == 0){

            $query = $database->query("SELECT * FROM user_accounts WHERE alias_url_name='".$alias_url_name."' AND uacc_group_fk='6' LIMIT 1");
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if(!is_array($row)){
                //echo "You are on wrong page"; exit();
            }else{
                if($row['uacc_id']){
                    $redirect_url = "/page/www/?alias_url_name=".$alias_url_name;
                    if(count($identifier_array) > 0){
                        $identifier_string = implode(",", $identifier_array);
                        $redirect_url .= "&url_identifier=".$identifier_string;
                    }
                    $_SERVER['REQUEST_URI'] = $redirect_url;
                    //insert into database
                }
            }


        }else{
            echo "<h1>".current($identifier_error)."</h1>";
            exit();
        }
    }
}

?>
