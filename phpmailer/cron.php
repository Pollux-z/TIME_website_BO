<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include '../global.php';
conndb();

// global cue check
    $rs = mysqli_query($conn,"SELECT * FROM `db_outbox` WHERE `delivered_at` IS NULL");
    while($row=mysqli_fetch_assoc($rs)){
        $outboxs[$row['id']] = [
            'mailto' => $row['mailto'],
            // 'mailto' => 'jommnaja@gmail.com',
            'subject' => $row['subject'],
            'body' => $row['body'],
        ];
    }

    // echo json_encode($outboxs,JSON_UNESCAPED_UNICODE);
    // die();

    if(isset($outboxs)){
        require 'src/Exception.php';
        require 'src/PHPMailer.php';
        require 'src/SMTP.php';
        
        // Sends to email of user
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username   = 'bo.time.notify@gmail.com';                     //SMTP username
        $mail->Password   = 'ffzavnfwggrksjul';                               //SMTP password
    }
// /global cue check

// outbox
$i = 0;
foreach($outboxs as $k => $v){
    $mail->Subject = $v['subject'];
    $mail->Body = $v['body'];
    $mail->CharSet = 'UTF-8';   

    if($i>0){
        $mail->ClearAllRecipients();
     }

    $mail->AddAddress($v['mailto']);
    // $mail->addBCC("pimsuda.w@timeconsulting.co.th");
    // $mail->addBCC("jommnaja@gmail.com");

    if($mail->Send()) {
        $rss = mysqli_query($conn,"UPDATE `db_outbox` SET `delivered_at` = NOW() WHERE `id` = $k LIMIT 1;");

        echo $email.' sent<br>';
    }else{
        echo $email.' failed<br>';
    }
    $i++;
}
// /outbox

closedb();
?>