<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

include '../global.php';
conndb();

$process = 'approved';
$child = 17;

if($process=='request1'){
    $parent = 2;
    $rs = mysqli_query($conn,"SELECT * FROM db_employee WHERE id in ($parent,$child)");
    while($row=mysqli_fetch_assoc($rs)){
        $uid[$row['id']] = [
            'name' => $row['name'],
            'email' => $row['email'],
            'position' => $row['position'],
        ];
    }
    $subject = $uid[$child]['name'].' ขออนุมัติลาวันที่ 22/22/2222';
    $message = '<html>
    <body><div style="background-color:#B2B2B2;">
    <div style="max-width:600px; margin:0 auto; background-color:#FFF; padding: 5%; padding-top:40px; border-top: 10px solid #0E3492;">
        <div style="text-align:right; margin-bottom: 30px;">
            <img src="https://tat.timeconsulting.co.th/assessment/images/logo.png" alt="TIME Consulting" style="max-height:60px;">        
        </div>

        เรียน '.$uid[$parent]['name'].' '.$uid[$parent]['position'].'<br><br>

        '.$uid[$child]['name'].' ได้ขออนุมัติการลา กรุณาเข้าไปเลือกอนุมัติหรือปฏิเสธได้ที่ <br><br>
        https://bo.timeconsulting.co.th/?mod=timeoff<br><br>

        BR,<br>
        BO.TIME
        </div>
        
        <div style="max-width: 480px;margin: 0 auto;text-align: center;padding: 30px 10px;color: #666;">
        <b>TIME Consulting Co.,Ltd.</b> 944 Mitrtown Office Tower,11th Fl. Unit 1101-1102  Rama IV Rd, Wang Mai, Pathum Wan, Bangkok, Thailand, 10330
        </div>

        </div>
    </body>
</html>';
    
}elseif($process=='request2'){
    $parent = 137;
    $rs = mysqli_query($conn,"SELECT * FROM db_employee WHERE id in ($parent,$child)");
    while($row=mysqli_fetch_assoc($rs)){
        $uid[$row['id']] = [
            'name' => $row['name'],
            'email' => $row['email'],
            'position' => $row['position'],
        ];
    }
    $subject = $uid[$child]['name'].' ขออนุมัติลาวันที่ 22/22/2222';
    $message = '<html>
    <body><div style="background-color:#B2B2B2;">
    <div style="max-width:600px; margin:0 auto; background-color:#FFF; padding: 5%; padding-top:40px; border-top: 10px solid #0E3492;">
        <div style="text-align:right; margin-bottom: 30px;">
            <img src="https://tat.timeconsulting.co.th/assessment/images/logo.png" alt="TIME Consulting" style="max-height:60px;">        
        </div>

        เรียน '.$uid[$parent]['name'].' '.$uid[$parent]['position'].'<br><br>

        '.$uid[$child]['name'].' ได้ขออนุมัติการลา กรุณาเข้าไปเลือกอนุมัติหรือปฏิเสธได้ที่ <br><br>
        https://bo.timeconsulting.co.th/?mod=timeoff<br><br>

        BR,<br>
        BO.TIME
        </div>
        
        <div style="max-width: 480px;margin: 0 auto;text-align: center;padding: 30px 10px;color: #666;">
        <b>TIME Consulting Co.,Ltd.</b> 944 Mitrtown Office Tower,11th Fl. Unit 1101-1102  Rama IV Rd, Wang Mai, Pathum Wan, Bangkok, Thailand, 10330
        </div>

        </div>
    </body>
</html>';

}elseif($process=='approved'){
    $rs = mysqli_query($conn,"SELECT * FROM db_employee WHERE id in ($child)");
    while($row=mysqli_fetch_assoc($rs)){
        $uid[$row['id']] = [
            'name' => $row['name'],
            'email' => $row['email'],
            'position' => $row['position'],
        ];
    }
    $subject = 'อนุมัติให้ลาวันที่ 22/22/2222';
    $message = '<html>
    <body><div style="background-color:#B2B2B2;">
    <div style="max-width:600px; margin:0 auto; background-color:#FFF; padding: 5%; padding-top:40px; border-top: 10px solid #0E3492;">
        <div style="text-align:right; margin-bottom: 30px;">
            <img src="https://tat.timeconsulting.co.th/assessment/images/logo.png" alt="TIME Consulting" style="max-height:60px;">        
        </div>

        เรียน '.$uid[$child]['name'].' '.$uid[$child]['position'].'<br><br>

        คุณได้รับการอนุมัติการลาแล้ว ตรวจสอบได้ที่ <br><br>
        https://bo.timeconsulting.co.th/?mod=timeoff<br><br>

        BR,<br>
        BO.TIME
        </div>
        
        <div style="max-width: 480px;margin: 0 auto;text-align: center;padding: 30px 10px;color: #666;">
        <b>TIME Consulting Co.,Ltd.</b> 944 Mitrtown Office Tower,11th Fl. Unit 1101-1102  Rama IV Rd, Wang Mai, Pathum Wan, Bangkok, Thailand, 10330
        </div>

        </div>
    </body>
</html>';

}

closedb();

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'bo.time.notify@gmail.com';                     //SMTP username
    $mail->Password   = 'ffzavnfwggrksjul';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('contact@timeconsulting.co.th', 'BO TIME');
    $mail->addAddress('jommnaja@gmail.com', $uid[$parent]['name']);     //Add a recipient
    // $mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}