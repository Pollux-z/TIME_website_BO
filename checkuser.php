<?php
session_start();
require_once("dbconnect.php");

// ตรวจสอบค่าที่ส่งมาผ่าน ajax แบบ POST ในที่นี้เราจะเช็ค 3 ค่า ว่ามีส่งมาไหม
if(isset($_POST['ggname']) && $_POST['ggname']!="" && isset($_POST['ggid']) && $_POST['ggid']!=""
&& isset($_POST['idTK']) && $_POST['idTK']!=""
){
    // กำหนดรูปแบบรหัสสำหรับ gg_authorized สำหรับไว้ใช้ล็อกอิน ในท่ี่นี้ใช้รูปแบบอย่างง่าย 
    // ใช้ ไอดี ต่อกับ รหัสพิเศษกำหนดเอง สามารถไปประยุกต์เข้ารหัสรูปแบบอื่นเพิ่มเติมได้
    $gg_secret_set = "mysecret";
    $gg_string_authorized = $gg_secret_set.trim($_POST['ggid']); // ต่อข้อความสำหรับเข้ารหัส
    $gg_gen_authorized = md5($gg_string_authorized);
     
    $sql_check="SELECT * FROM tbl_simple_user WHERE user_gg_authorized='".$gg_gen_authorized."' AND user_gg_connect=1";
    $result = $mysqli->query($sql_check);
    if($result && $result->num_rows>0){  // มีสมาชิกที่ล็อกอินด้วย google id นี้ในระบบแล้ว
        // ดึงข้อมูลมาแสดง และสร้าง session
        $row = $result->fetch_array();
        $_SESSION['ses_user_id']=$row['user_id'];
        $_SESSION['ses_user_name']=$row['user_name'];       
        $_SESSION['ses_user_email']=$row['user_email'];     
        $_SESSION['ses_user_last_login']=date("Y-m-d H:i:s");
        // อัพเดทเวลาล็อกอินล่าสุด
        $sql_update="UPDATE tbl_simple_user SET user_last_login=NOW(),user_imageurl='".$_POST['ggimageurl']."' WHERE user_id='".$row['user_id']."'";
        $mysqli->query($sql_update);

    }else{   // ไม่พบสมาชิกที่ใช้ google id นี้ล็อกอิน
        // สร้างผู้ใช้ใหม่
        //  สมมติให้ชื่อผู้ใช้ใหม่เป็น gg_ไอดี รหัสผ่านเป็น แรนดอม 
        $sql_insert="INSERT INTO tbl_simple_user SET user_name='gg_".$_POST['ggid']."',user_email='".$_POST['ggemail']."',user_imageurl='".$_POST['ggimageurl']."',user_pass='".rand(11111111, 9999999)."',user_gg_connect='1',user_gg_authorized='".$gg_gen_authorized."',user_last_login=NOW()";  
        $result = $mysqli->query($sql_insert);

        if($result && $mysqli->affected_rows>0){
            $insert_userID = $mysqli->insert_id;
            $sql="SELECT * FROM tbl_simple_user WHERE user_gg_authorized='".$gg_gen_authorized."' AND user_gg_connect=1";
            $result = $mysqli->query($sql);
            if($result && $result->num_rows>0){  // มีสมาชิกที่ล็อกอินด้วย google id นี้ในระบบแล้ว
                // ดึงข้อมูลมาแสดง และสร้าง session
                $row = $result->fetch_array();
                $_SESSION['ses_user_id']=$row['user_id'];
                $_SESSION['ses_user_name']=$row['user_name'];       
                $_SESSION['ses_user_last_login']=date("Y-m-d H:i:s");               
                // อัพเดทเวลาล็อกอินล่าสุด
                $sql_update="UPDATE tbl_simple_user SET user_last_login=NOW(),user_imageurl='".$_POST['ggimageurl']."' WHERE user_id='".$row['user_id']."'";
                $mysqli->query($sql_update);                         
            }
        }         
    }

    $sql_check="SELECT * FROM `db_employee` WHERE `email` LIKE '".$_POST['ggemail']."'";
    $result = $mysqli->query($sql_check);
    if($result && $result->num_rows>0){
        $row = $result->fetch_array();
        $imageurl = "uploads/employee/".$row['id'].".jpg";
        file_put_contents($imageurl, file_get_contents($_POST['ggimageurl']));

        $uid = $row['id'];

        $_SESSION['ses_user_imageurl']=$imageurl;                 
        $_SESSION['ses_uid']=$uid;                
        $_SESSION['ses_ulevel']=$row['level'];        
        $_SESSION['evaluated_at']=$row['evaluated_at'];
        $_SESSION['ses_fullname']=$_POST['ggname'];        

        // if($row['evaluate_at']==null){
        //     $notifies[] = 'evaluate';
        // }

        // $_SESSION['notifies'] = $notifies;

        if($row['name_en']==''){
            $sql_check="UPDATE `db_employee` SET `name_en` = '".$_POST['ggname']."' WHERE `id` = $uid;";
            $result = $mysqli->query($sql_check);    
        }
        
    }elseif($_POST['ggemail']=='jommnaja@gmail.com'){
        $sql_check="SELECT * FROM `db_employee` WHERE `id` = 12";
        $result = $mysqli->query($sql_check);
        $row = $result->fetch_array();
    
        $uid = $row['id'];
        $imageurl = "uploads/employee/$uid.jpg";

        $_SESSION['ses_user_imageurl']=$imageurl;                 
        $_SESSION['ses_uid']=$uid;                
        $_SESSION['ses_ulevel']=$row['level'];        
        $_SESSION['evaluated_at']=$row['evaluated_at'];
        $_SESSION['ses_fullname']=$_POST['ggname'];
    }
    
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
    
    $sql_check="INSERT INTO `db_log` (`act`, `agent`, `ip`, `uid`, `date`) VALUES ('login-".$_POST['ggemail']."', '$agent', '".get_ip_address()."', '$uid', NOW());";
    $result = $mysqli->query($sql_check);


/*echo "<pre>";
echo $gg_gen_authorized;
print_r($_POST);
echo "</pre>";*/
}