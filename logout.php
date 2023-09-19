<?php  
session_start();  
require_once("dbconnect.php");  

$agent = $_SERVER['HTTP_USER_AGENT'];
    
function get_ip_address(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}
if(isset($_SESSION['ses_user_email'])){
    $sql_check="INSERT INTO `db_log` (`act`, `agent`, `ip`, `uid`, `date`) VALUES ('logout-".$_SESSION['ses_user_email']."', '$agent', '".get_ip_address()."', '".$_SESSION['ses_uid']."', NOW());";
    $result = $mysqli->query($sql_check);    
}

unset(  
    $_SESSION['ses_user_id'],  
    $_SESSION['ses_uid'],  
    $_SESSION['ses_ulevel'],  
    $_SESSION['ses_user_name']  ,  
    $_SESSION['ses_user_email']  ,  
    $_SESSION['ses_user_last_login']  
);  
exit;