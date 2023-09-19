<?php
session_start();

include 'global.php';
conndb();

$mod = $_REQUEST['mod'];
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}else{
    $id = '';
}

$uid = $_SESSION['ses_uid'];
$agent = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['ses_user_email'])){
    if($mod=='del'){
        if($page=='ld-comment'){
            $rs = mysqli_query($conn,"UPDATE `db_ld_log_workshop` SET `status` = '0' WHERE `id` = $id;");
            $redirect = ".?mod=$page&alert=success";

        }elseif($page=='wfa'){
            $rs = mysqli_query($conn,"UPDATE `db_timeoff` SET `status` = '0' WHERE `id` = $id;");
            $redirect = ".?mod=$page&alert=success";

        }elseif($page=='carreserve'){
            $rs = mysqli_query($conn,"UPDATE `db_reserve` SET `status` = '0' WHERE `id` = $id;");
            $redirect = ".?mod=carrec&alert=success";

        }else{
            $rs = mysqli_query($conn,"UPDATE `db_$page` SET `status` = '0' WHERE `id` = $id;");
            if($page=='reserve'){
                $redirect = ".?mod=asset&alert=success";        

            }else{
                $redirect = ".?mod=$page&alert=success";

            }

        }

    }elseif($mod=='timeoff'||$mod=='wfa'){
        if($page=='balance'){
            $yr = date(Y);

            $note = $_POST['note'];
            $day = $_POST['day'];
            $eid = $_POST['uid'];

            // $rs = mysqli_query($conn,"SELECT `vacation_day`, `vacation_notes` FROM `db_employee` WHERE `id` = $eid");
            $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_vacation` WHERE `year` = '$yr' AND `uid` = $eid");        
            $row = mysqli_fetch_assoc($rs);

            if($row['notes']==''){
                $vacation_notes = [];

            }else{
                $vacation_notes = json_decode($row['notes'],JSON_UNESCAPED_UNICODE);

            }


            $vacation_day = $row['day']+$day;
            array_push($vacation_notes,$note);
            $vacation_notes = json_encode($vacation_notes);
            
            // $rs = mysqli_query($conn,"UPDATE `db_employee` SET `vacation_day` = '$vacation_day', `vacation_notes` = '$vacation_notes', `updated_at` = NOW() WHERE `db_employee`.`id` = $eid;");
            $rs = mysqli_query($conn,"UPDATE `db_timeoff_vacation` SET `day` = '$vacation_day', `notes` = '$vacation_notes', `updated_at` = NOW() WHERE `uid` = $eid AND year = '$yr';");
            $rs = mysqli_query($conn,"INSERT INTO `db_timeoff_topup` (`days`, `vacation_day`, `note`, `eid`, `uid`, `created_at`) VALUES ('$day', '$vacation_day', '$note', '$eid', '$uid', NOW());");

            $redirect = '.?mod=timeoff&page=balance&alert=success';

        }elseif(isset($_GET['status'])){
            $status = $_GET['status'];

            $rs = mysqli_query($conn,"UPDATE `db_timeoff` SET `status` = '$status', `updated_at` = NOW() WHERE `id` = $id;");

            $rs = mysqli_query($conn,"SELECT a.*,b.name,b.position,b.email,b.parent FROM `db_timeoff` a join db_employee b WHERE a.uid = b.id and a.`id` = $id");
            $row = mysqli_fetch_assoc($rs);
                
                $name = $row['name'];
                $position = $row['position'];
                $email = $row['email'];
                $parent = $row['parent'];

                $time = $sl = '';
                $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_date` WHERE `tid` = $id ORDER BY `date` ASC");
                while($row=mysqli_fetch_assoc($rs)){
                    $dates[] = $row['date'];
                    $date2s[] = webdate($row['date']);
                    $time = $row['time'];
                }

                if($time=='pm'){
                    $sl = ' (ครึ่งวันบ่าย)';

                }elseif($time=='am'){
                    $sl = ' (ครึ่งวันเช้า)';

                }
                
            
            if($status==4){
                // 137 = กวาง, 15 = ต้า
                $rs = mysqli_query($conn,"SELECT name,position,email FROM `db_employee` WHERE `id` = 15");
                $row = mysqli_fetch_assoc($rs);

                    $parent_name = $row['name'];
                    $parent_position = $row['position'];
                    $mailto = $row['email'];

                $mact = 'timeoff_approved1';
                $subject = $name.' ขออนุมัติลา '.implode(', ',$date2s).$sl;
                $text = 'เรียน '.$parent_name.' '.$parent_position.'<br><br>
            
                '.$name.' ได้ขออนุมัติลาวันที่ '.implode(', ',$date2s).$sl.' กรุณาเข้าไปเลือกอนุมัติหรือปฏิเสธได้ที่ <br><br>
                https://bo.timeconsulting.co.th/?mod=timeoff';

            }elseif($status==2){
                $mact = 'timeoff_approved';
                $mailto = $email;
                // $mailto = 'jommnaja@gmail.com';

                $subject = 'อนุมัติให้ลา '.implode(', ',$date2s).$sl;
                $text = 'เรียน '.$name.' '.$position.'<br><br>
            
                คุณได้รับการอนุมัติให้ลาวันที่ '.implode(', ',$date2s).$sl.' แล้ว ตรวจสอบได้ที่ <br><br>
                https://bo.timeconsulting.co.th/?mod=timeoff&page=my';

            }elseif($status==3){
                $mact = 'timeoff_deny';
                $mailto = $email;
                $subject = 'ไม่อนุมัติให้ลา '.implode(',',$date2s).$sl;
                $text = 'เรียน '.$name.' '.$position.'<br><br>
            
                คุณถูกปฏิเสธการอนุมัติการลาวันที่ '.implode(',',$date2s).$sl.' ตรวจสอบได้ที่ <br><br>
                https://bo.timeconsulting.co.th/?mod=timeoff&page=my';

            }

            $body = '<html>
            <body><div style="background-color:#B2B2B2;">
            <div style="max-width:600px; margin:0 auto; background-color:#FFF; padding: 5%; padding-top:40px; border-top: 10px solid #0E3492;">
                <div style="text-align:right; margin-bottom: 30px;">
                    <img src="https://bo.timeconsulting.co.th/assets/img/logo-240.png" alt="TIME Consulting" style="max-height:60px;">        
                </div>
        
                '.$text.'<br><br>
        
                BR,<br>
                BO.TIME
                </div>
                
                <div style="max-width: 480px;margin: 0 auto;text-align: center;padding: 30px 10px;color: #666;">
                <b>TIME Consulting Co.,Ltd.</b> 944 Mitrtown Office Tower,11th Fl. Unit 1101-1102  Rama IV Rd, Wang Mai, Pathum Wan, Bangkok, Thailand, 10330
                </div>
        
                </div>
            </body>
        </html>';

            $rs = mysqli_query($conn,"INSERT INTO `db_outbox` (`act`, `mailto`, `subject`, `body`, `aid`, `uid`, `created_at`) VALUES ('$mact', '$mailto', '$subject', '$body', '$id', '$uid', NOW());");

        }else{
            if($mod=='wfa'){
                $ttype = 'a';
            }else{
                $ttype = $_POST['ttype'];
            }

            $reason = addslashes(trim($_POST['reason']));
            $dates = explode(',',$_POST['dates']);
            if(isset($_POST['uid'])){
                $uid = $_POST['uid'];
            }
            if(isset($_POST['half'])){            
                $half = '0.5';
                $time = $_POST['half'];

                if($time=='pm'){
                    $sl = ' (ครึ่งวันบ่าย)';

                }else{
                    $sl = ' (ครึ่งวันเช้า)';

                }
            }else{
                $half = 1;
            }

            if($id!=''){            
                $rs = mysqli_query($conn,"UPDATE `db_timeoff` SET `ttype` = '$ttype', `reason` = '$reason', `updated_at` = NOW() WHERE `id` = $id;");
                $rs = mysqli_query($conn,"DELETE FROM `db_timeoff_date` WHERE `tid` = $id");

            }else{
                $rs = mysqli_query($conn,"INSERT INTO `db_timeoff` (`ttype`, `reason`, `uid`, `created_at`) VALUES ('$ttype', '$reason', '$uid', NOW());");
                $id = mysqli_insert_id($conn);
                
                $types = [
                    'v' => 'พักร้อน',
                    'p' => 'กิจ',
                    's' => 'ป่วย',
                    'w' => 'ไม่รับเงินเดือน',
                    'a' => 'Work From Anywhere',
                ];
        
                if($reason!=''){
                    $sr = ' - '.$reason;
                }
            
                if($ttype=='a'){
                    $sMessage = 'ขอ '.$types[$ttype].' วันที่ '.implode(', ',$dates).$sl.$sr;

                }else{
                    $sMessage = 'ขอลา'.$types[$ttype].'วันที่ '.implode(', ',$dates).$sl.$sr;

                }
                $sMessage = str_replace('%',"%25",$sMessage);
                line_notify($uid,$mod,$sMessage);

                // $rs = mysqli_query($conn,"UPDATE `db_timeoff` SET `status` = '$status', `updated_at` = NOW() WHERE `db_timeoff`.`id` = $id;");

                $rs = mysqli_query($conn,"SELECT a.*,b.name,b.position,b.email,b.parent FROM `db_timeoff` a join db_employee b WHERE a.uid = b.id and a.`id` = $id");
                $row = mysqli_fetch_assoc($rs);
                    
                    $name = $row['name'];
                    $position = $row['position'];
                    $email = $row['email'];
                    $parent = $row['parent'];
                
                    $rs = mysqli_query($conn,"SELECT name,position,email FROM `db_employee` WHERE `id` = $parent");
                    $row = mysqli_fetch_assoc($rs);
        
                        $parent_name = $row['name'];
                        $parent_position = $row['position'];
                        $mailto = $row['email'];
                        // $mailto = 'jommnaja@gmail.com';
    
                    $mact = 'timeoff_pending';
                    $subject = $name.' ขออนุมัติลา '.implode(', ',$dates).$sl;
                    $text = 'เรียน '.$parent_name.' '.$parent_position.'<br><br>
                
                    '.$name.' ได้ขออนุมัติลาวันที่ '.implode(', ',$dates).$sl.' กรุณาเข้าไปเลือกอนุมัติหรือปฏิเสธได้ที่ <br><br>
                    https://bo.timeconsulting.co.th/?mod=timeoff';

                    $body = '<html>
                    <body><div style="background-color:#B2B2B2;">
                    <div style="max-width:600px; margin:0 auto; background-color:#FFF; padding: 5%; padding-top:40px; border-top: 10px solid #0E3492;">
                        <div style="text-align:right; margin-bottom: 30px;">
                            <img src="https://bo.timeconsulting.co.th/assets/img/logo-240.png" alt="TIME Consulting" style="max-height:60px;">        
                        </div>
                
                        '.$text.'<br><br>
                
                        BR,<br>
                        BO.TIME
                        </div>
                        
                        <div style="max-width: 480px;margin: 0 auto;text-align: center;padding: 30px 10px;color: #666;">
                        <b>TIME Consulting Co.,Ltd.</b> 944 Mitrtown Office Tower,11th Fl. Unit 1101-1102  Rama IV Rd, Wang Mai, Pathum Wan, Bangkok, Thailand, 10330
                        </div>
                
                        </div>
                    </body>
                </html>';
        
                    $rs = mysqli_query($conn,"INSERT INTO `db_outbox` (`act`, `mailto`, `subject`, `body`, `aid`, `uid`, `created_at`) VALUES ('$mact', '$mailto', '$subject', '$body', '$id', '$uid', NOW());");
                
            }       
            
            foreach($dates as $v){
                $date = sqldate($v);
                $rs = mysqli_query($conn,"INSERT INTO `db_timeoff_date` (`date`, `half`, `time`, `tid`) VALUES ('$date', '$half', '$time', '$id');");
            }
        }

    }elseif($mod=='project'){
        $contract_no = addslashes($_POST['contract_no']);
        $name = addslashes($_POST['name']);
        $name_th = addslashes($_POST['name_th']);
        $val = addslashes(str_replace(',','',$_POST['val']));    
        $installment = addslashes($_POST['installment']);
        $client = addslashes($_POST['client']);
        $client_address = addslashes($_POST['client_address']);
        $client_taxid = addslashes($_POST['client_taxid']);
        $owner = addslashes($_POST['owner']);
        $pdmo_cat = addslashes($_POST['pdmo_cat']);
        $pdmo_specialize = addslashes($_POST['pdmo_specialize']);
        $note = addslashes($_POST['note']);
        $document = addslashes($_POST['document']);
        $return_amount = addslashes($_POST['return_amount']);
        $objective = addslashes(trim($_POST['objective']));
        $scope = addslashes(trim($_POST['scope']));
        $time1_ids = json_encode([$_POST['time1_ids']]);
        $status = $_POST['status'];

        if($_POST['cert_receive']!=''){
            $dt = explode('/',$_POST['cert_received']);
            $cert_received = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }
        if($_POST['start_date']!=''){
            $dt = explode('/',$_POST['start_date']);
            $start_date = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }
        if($_POST['end_date']!=''){
            $dt = explode('/',$_POST['end_date']);
            $end_date = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }
        if($_POST['bank_sent']!=''){
            $dt = explode('/',$_POST['bank_sent']);
            $bank_sent = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }
        if($_POST['bank_received']!=''){
            $dt = explode('/',$_POST['bank_received']);
            $bank_received = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }
        if($_POST['cert_sent']!=''){
            $dt = explode('/',$_POST['cert_sent']);
            $cert_sent = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }
        if($_POST['cert_received']!=''){
            $dt = explode('/',$_POST['cert_received']);
            $cert_received = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_project` SET `contract_no` = '$contract_no', `name` = '$name', `name_th` = '$name_th', `val` = '$val', `installment` = '$installment', `client` = '$client', `client_address` = '$client_address', `client_taxid` = '$client_taxid', `owner` = '$owner', `time1_ids` = '$time1_ids', `pdmo_cat` = '$pdmo_cat', `pdmo_specialize` = '$pdmo_specialize', `note` = '$note', `status` = '$status', `start_date` = '$start_date', `end_date` = '$end_date', `document` = '$document', `return_amount` = '$return_amount', `objective` = '$objective', `scope` = '$scope', `bank_sent` = '$bank_sent', `bank_received` = '$bank_received', `cert_sent` = '$cert_sent', `cert_received` = '$cert_received', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            $code = $_POST['code'];
            $rs = mysqli_query($conn,"INSERT INTO `db_project` (`code`, `contract_no`, `name`, `name_th`, `val`, `installment`, `client`, `client_address`, `client_taxid`, `owner`, `time1_ids`, `time2_ids`, `pdmo_cat`, `pdmo_specialize`, `note`, `start_date`, `end_date`, `document`, `return_amount`, `objective`, `scope`, `bank_sent`, `bank_received`, `cert_sent`, `cert_received`, `created_at`) VALUES ('$code','$contract_no','$name','$name_th','$val','$installment','$client','$client_address','$client_taxid','$owner','$time1_ids','$time2_ids','$pdmo_cat','$pdmo_specialize','$note','$start_date','$end_date','$document','$return_amount','$objective','$scope','$bank_sent','$bank_received','$cert_sent','$cert_received',NOW());");
        }

        if(isset($_FILES['file_contract']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];
            $name = $row['name'];

            $filename = 'TIME-'.$code.' สัญญา '.$name.'.'.pathinfo($_FILES['file_contract']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file_contract']['tmp_name'],"uploads/$mod/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `file_contract` = '$filename' WHERE `id` = $id;
                ");
            }
        }
        if(isset($_FILES['file_contract2']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];
            $name = $row['name'];

            $filename = 'TIME-'.$code.' สัญญา '.$name.'-2.'.pathinfo($_FILES['file_contract2']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file_contract2']['tmp_name'],"uploads/$mod/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `file_contract2` = '$filename' WHERE `id` = $id;
                ");
            }
        }
        if(isset($_FILES['file_contract3']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];
            $name = $row['name'];

            $filename = 'TIME-'.$code.' สัญญา '.$name.'-3.'.pathinfo($_FILES['file_contract3']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file_contract3']['tmp_name'],"uploads/$mod/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `file_contract3` = '$filename' WHERE `id` = $id;
                ");
            }
        }
        if(isset($_FILES['file_cert']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];
            $name = $row['name'];

            $filename = 'TIME-'.$code.' หนังสือรับรองผลงาน '.$name.'.'.pathinfo($_FILES['file_cert']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file_cert']['tmp_name'],"uploads/$mod/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `file_cert` = '$filename' WHERE `id` = $id;
                ");
            }
        }
        if(isset($_FILES['file_doc']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];
            $name = $row['name'];

            $filename = 'TIME-'.$code.' Project Ref '.$name.'.'.pathinfo($_FILES['file_doc']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file_doc']['tmp_name'],"uploads/$mod/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `file_doc` = '$filename' WHERE `id` = $id;
                ");
            }
        }
        if(isset($_FILES['file_ppt']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];
            $name = $row['name'];

            $filename = 'TIME-'.$code.' Project Ref '.$name.'.'.pathinfo($_FILES['file_ppt']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file_ppt']['tmp_name'],"uploads/$mod/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `file_ppt` = '$filename' WHERE `id` = $id;
                ");
            }
        }

    }elseif($mod=='test'){
        $uid = 12;
        $sMessage = "ทดสอบ 7%";
        $sMessage = str_replace('%',"%25",$sMessage);
        line_notify($uid,$mod,$sMessage);

    }elseif($mod=='cover'){
        $yr = date(Y);

        $project_id = $_POST['project_id'];
        $dt = explode('/',$_POST['date']);
        $date = $dt[2].'-'.$dt[1].'-'.$dt[0];
        $title = addslashes($_POST['title']);
        $remark = addslashes($_POST['remark']);
        // $attach = 'test';

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_cover` SET `project_id` = '$project_id', `title` = '$title', `remark` = '$remark', `date` = '$date', `receive_code` = '$receive_code', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            // $rs = mysqli_query($conn,"SELECT code FROM `db_cover` WHERE `created_at` LIKE '$yr%' ORDER BY `code` DESC limit 1");
            $date_yr = substr($date,0,4);

            $rs = mysqli_query($conn,"SELECT code FROM `db_cover` WHERE `date` LIKE '$date_yr%' ORDER BY `code` DESC limit 1");
            $row = mysqli_fetch_assoc($rs);
            $cnt = mysqli_num_rows($rs);

            if($cnt!=0){
                $code = $row['code']+1;
            }else{
                $code = 1;
            }                                                    
        
            $rs = mysqli_query($conn,"INSERT INTO `db_cover` (`code`, `project_id`, `title`, `remark`, `date`, `uid`, `created_at`) VALUES ('$code', '$project_id', '$title', '$remark', '$date', '$uid', NOW());");
            $id = mysqli_insert_id($conn);

            $redirect = ".?mod=cover-edit&alert=created&id=".$id;
        }

        if(isset($_FILES['file']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT code FROM `db_cover` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code']; 

            $filename = 'time'.$yr.'-'.str_pad($code, 5, 0, STR_PAD_LEFT).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file']['tmp_name'],"uploads/cover/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_cover` SET `attach` = '$filename' WHERE `id` = $id;
                ");
            }
        }

    }elseif($mod=='announce'){
        $yr = date(Y);

        $project_id = $_POST['project_id'];
        $dt = explode('/',$_POST['date']);
        $date = $dt[2].'-'.$dt[1].'-'.$dt[0];
        $title = addslashes($_POST['title']);
        $remark = addslashes($_POST['remark']);
        // $attach = 'test';

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_announce` SET `project_id` = '$project_id', `title` = '$title', `remark` = '$remark', `date` = '$date', `receive_code` = '$receive_code', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            $rs = mysqli_query($conn,"SELECT code FROM `db_announce` WHERE `created_at` LIKE '$yr%' ORDER BY `code` DESC limit 1");
            $row = mysqli_fetch_assoc($rs);
            $cnt = mysqli_num_rows($rs);

            if($cnt!=0){
                $code = $row['code']+1;
            }else{
                $code = 1;
            }                                                    

            $rs = mysqli_query($conn,"INSERT INTO `db_announce` (`code`, `project_id`, `title`, `remark`, `date`, `uid`, `created_at`) VALUES ('$code', '$project_id', '$title', '$remark', '$date', '$uid', NOW());");
            $id = mysqli_insert_id($conn);

            // $redirect = ".?mod=announce-edit&alert=created&id=".$id;
        }

        if(isset($_FILES['file']['tmp_name'])){
            $rs = mysqli_query($conn,"SELECT code FROM `db_announce` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code']; 

            $filename = 'time'.$yr.'-'.str_pad($code, 5, 0, STR_PAD_LEFT).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file']['tmp_name'],"uploads/announce/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_announce` SET `attach` = '$filename' WHERE `id` = $id;
                ");
            }
        }

    }elseif($mod=='km'){
        // $yr = date(Y);

        // $project_id = $_POST['project_id'];
        // $dt = explode('/',$_POST['date']);
        // $date = $dt[2].'-'.$dt[1].'-'.$dt[0];
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $location = addslashes($_POST['location']);
        $hashtags = json_encode(explode(',',$_POST['hashtags']));
        $comments = addslashes($_POST['comments']);
        // $remark = addslashes($_POST['remark']);
        // $attach = 'test';

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_km` SET `description` = '$description', `location` = '$location', `hashtags` = '$hashtags', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            // $rs = mysqli_query($conn,"SELECT code FROM `db_cover` WHERE `created_at` LIKE '$yr%' ORDER BY `code` DESC limit 1");
            // $row = mysqli_fetch_assoc($rs);
            // $code = $row['code']+1;
        
            $rs = mysqli_query($conn,"INSERT INTO `db_km` (`title`, `description`, `location`, `hashtags`, `pixs`, `uid`, `created_at`, `updated_at`) VALUES ('$title', '$description', '$location', '$hashtags', '$pixs', '$uid', NOW(), NOW());");
            $id = mysqli_insert_id($conn);

            $redirect = ".?mod=$mod&alert=success";
        }

        if(isset($_FILES['file']['tmp_name'])){
            // $rs = mysqli_query($conn,"SELECT code FROM `db_cover` WHERE `id` = $id");
            // $row = mysqli_fetch_assoc($rs);
            // $code = $row['code']; 

            // $filename = 'time'.$yr.'-'.str_pad($code, 5, 0, STR_PAD_LEFT).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $id.'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file']['tmp_name'],"uploads/$mod/$filename")){
                $jFilename = json_encode([$filename]);
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `pixs` = '$jFilename' WHERE `id` = $id;
                ");
            }
        }

    }elseif($mod=='ld'){
        $redirect = ".?mod=$mod-minitest&sid=$sid&success=".date("His");

        if(isset($_POST['comment'])){
            $status = $_POST['status'];
            $comment = addslashes($_POST['comment']);
            $wid = $_POST['wid'];

            $rs = mysqli_query($conn,"UPDATE `db_ld_log_workshop` SET `status` = '$status', `comment` = '$comment', `commented_at` = NOW(), `commented_by` = '".$_SESSION['ses_uid']."' WHERE `id` = $wid LIMIT 1;");

            $redirect = '.?mod=ld-comment&alert=success';

        }elseif(isset($_POST['rates'])){
            $rates = json_encode($_POST['rates']);
            $sid = $_POST['sid'];

            $rs = mysqli_query($conn,"INSERT INTO `db_ld_assessment` (`uid`, `sid`, `rates`) VALUES ('".$_SESSION['ses_uid']."', '$sid', '$rates');");

            $redirect = '.?mod=ld-assessment&sid='.$sid;

        }elseif(isset($_FILES['mat'])){
            $sid = $_POST['sid'];
            $filename = 'mat'.$sid.'-'.$_FILES['mat']['name'];
            if(move_uploaded_file($_FILES['mat']['tmp_name'],'uploads/ld/'.$filename)){
                $rs = mysqli_query($conn,"UPDATE `db_ld` SET `material` = '$filename' WHERE `id` = $sid;");
            }

            $redirect = '.?mod=ld-mat&alert=success';

        }elseif(isset($_FILES['workshop'])){
            $sid = $_POST['sid'];
            $filename = 'ws'.$sid.'-'.$_SESSION['ses_uid'].'-'.$_FILES['workshop']['name'];
            if(move_uploaded_file($_FILES['workshop']['tmp_name'],'uploads/ld/'.$filename)){
                $rs = mysqli_query($conn,"INSERT INTO `db_ld_log_workshop` (`uid`, `sid`, `attach`) VALUES ('".$_SESSION['ses_uid']."', '$sid', '$filename');");
            }

            if(isset($_POST['present_date'])){
                $present_date = sqldate($_POST['present_date']);
                $time = $_POST['time'];
                
                $rs = mysqli_query($conn,"INSERT INTO `db_ld_log_present` (`uid`, `present_date`,`time`) VALUES ('".$_SESSION['ses_uid']."', '$present_date','$time');");
            }

            $redirect = '.?mod=ld-assessment&sid='.$sid;

        }elseif(isset($_GET['reexam'])){
            $sid = $_GET['reexam'];

            $rs = mysqli_query($conn,"SELECT id FROM `db_ld_minitest` WHERE `sid` = $sid AND `status` > 0");
            while($row=mysqli_fetch_assoc($rs)){
                $qids[] = $row['id'];
            }

            $rs = mysqli_query($conn,"UPDATE `db_ld_log_minitest` SET `status` = '0' WHERE `uid` = ".$_SESSION['ses_uid']." AND `qid` IN (".implode(',',$qids).");");

            $redirect = ".?mod=$mod-minitest&sid=$sid&success=".date("His");
        }else{
            $qid = $_POST['qid'];
            $minitest = $_POST['minitest'];
    
            $rs = mysqli_query($conn,"SELECT answer,sid FROM `db_ld_minitest` WHERE `id` = $qid AND `status` > 0");
            $row = mysqli_fetch_assoc($rs);
            $answer = $row['answer'];
            $sid = $row['sid'];
    
            $score = 0;
            if($minitest==$answer){
                $score = 1;
            }
    
            $rs = mysqli_query($conn,"INSERT INTO `db_ld_log_minitest` (`uid`, `qid`, `answer`, `score`) VALUES ('".$_SESSION['ses_uid']."', '$qid', '$minitest', '$score');");                

            $redirect = ".?mod=$mod-minitest&sid=$sid&success=".date("His");
        }

    }elseif($mod=='elearn'){
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $vid = addslashes($_POST['vid']);
        $hashtags = json_encode(explode(',',$_POST['hashtags']));

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_elearn` SET `description` = '$description', `vid` = '$vid', `hashtags` = '$hashtags', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            $rs = mysqli_query($conn,"INSERT INTO `db_elearn` (`title`, `description`, `vid`, `hashtags`, `uid`, `created_at`) VALUES ('$title', '$description', '$vid', '$hashtags, '$uid', NOW());");
            $id = mysqli_insert_id($conn);

            $redirect = ".?mod=$mod&alert=success";
        }

    }elseif($mod=='culture'){    
        if(isset($_POST['excel'])){
            $excel = array();
            $rows = explode("\r\n", trim($_POST['excel']));
            foreach($rows as $idx => $row)
            {
                $row = explode( "\t", $row );
                foreach( $row as $field )
                {
                    $excel[$idx][] = $field;
                }
            }
        
            foreach ($excel as list($a,$b,$c,$d)) {
                $cat = addslashes($a);
                $no = addslashes($b);
                $title = addslashes($c);
                $detail = addslashes($d);
        
                $rs = mysqli_query($conn,"INSERT INTO `db_culture_quiz` (`cat`, `no`, `title`, `detail`) VALUES ('$a', '$b', '$c', '$d');");
            }    
        }else{
            $q = $_POST['q'];
            // echo $q.json_encode($_POST['ans']);

            foreach($_POST['ans'] as $qid => $answer){
                $sql = "INSERT INTO `db_culture_answer` (`q`, `uid`, `qid`, `answer`) VALUES ('$q', $uid, '$qid', '$answer');";
                // echo $sql;
                $rs = mysqli_query($conn,$sql);
            }
            // die();
        }

        $redirect = ".?mod=$mod&alert=success";

    }elseif($mod=='timesheet_month'){
        $month = $_POST['month'];

        $filename = "timesheet-$month.xlsx";
        if(move_uploaded_file($_FILES['file']['tmp_name'],"uploads/timesheet/$filename")){
            $rs = mysqli_query($conn,"INSERT INTO `db_timesheet_month` (`month`) VALUES ('$month');");
            $redirect = ".?mod=timesheet-edit&alert=success";

        }else{
            $redirect = ".?mod=timesheet-edit&alert=failed";

        }

    }elseif($mod=='timesheet2'){
        $date = $_POST['date'];
        $project_no = $_POST['project_no'];
        $account_no = $_POST['account_no'];
        $hrs = $_POST['hrs'];
        $strategy_no = $_POST['strategy_no'];
        $martech_no = $_POST['martech_no'];
        $description = $_POST['description'];
        $uid = $_POST['uid'];
        
        $rdate = $_POST['mo'];
        // $rdate = substr(sqldate($date[0]),0,7);
        $rs = mysqli_query($conn,"UPDATE `db_timesheet2` SET `status` = 0 WHERE `date` LIKE '$rdate-%' AND uid = $uid;");
        
        foreach($date as $k => $v){
            // $sdate = sqldate($v);
            $sdate = $rdate.'-'.$v;
            // echo $sdate;
            // die();
            $rs = mysqli_query($conn,"INSERT INTO `db_timesheet2` (`date`, `project_no`, `account_no`, `description`, `hrs`, `strategy_no`, `martech_no`, `uid`) VALUES ('".$sdate."', '".$project_no[$k]."', '".$account_no[$k]."', '".$description[$k]."', '".$hrs[$k]."', '".$strategy_no[$k]."', '".$martech_no[$k]."', '$uid');") OR die(mysqli_error($conn));
        }
        
        $redirect = ".?mod=timesheet2-detail&uid=$uid&mo=$rdate&alert=success";

    }elseif($mod=='timesheet'){
        if($_POST['eid']!=''){
            $eid = $_POST['eid'];

        }else{
            $eid = $uid;

        }

                        // $description = addslashes($_POST['description']);
                        // $location = addslashes($_POST['location']);
                        // $project_id = addslashes($_POST['project_id']);
                        // $dt = explode('/',$_POST['date']);
                        // $date = $dt[2].'-'.$dt[1].'-'.$dt[0];
                        // $min = $_POST['hrs']*60;

                        // $projects = explode('-',$_POST['project']);
                        // if($projects[0]=='pj'){
                        //     $project_id = $projects[1];

                        // }else{
                        //     $costcenter = $_POST['project'];

                        // }
                        
                        // $rs = mysqli_query($conn,"INSERT INTO `db_timesheet` (`description`, `location`, `min`, `project_id`, `costcenter`, `uid`, `date`, `created_at`) VALUES ('$description', '$location', '$min', '$project_id', '$costcenter', '$uid', '$date', NOW());");

        // $month = date("Y-m");
        // $hrs = $_POST['hrs'];

        // $rs = mysqli_query($conn,"INSERT INTO `db_timesheet` (`month`, `hrs`, `uid`, `created_at`) VALUES ('$month', '$hrs', '$uid', NOW());");
        
        $rs = mysqli_query($conn,"INSERT INTO `db_timesheet` (`uid`, `created_at`) VALUES ('$eid', NOW());");
        $id = mysqli_insert_id($conn);

        $hrs = 0;

        // $rs = mysqli_query($conn,"NSERT INTO `db_cxpense (`code`, `uid`, `created_at`) VALUES ('$code', '$uid', NOW());");
        // $eid = mysqli_insert_id($conn);

        $excel = array();
        $rows = explode("\r\n", trim($_POST['excel']));
        foreach($rows as $idx => $row)
        {
            $row = explode( "\t", $row );
            foreach( $row as $field )
            {
                $excel[$idx][] = $field;
            }
        }

        foreach ($excel as list($a,$b,$c,$d,$f,$h)) {
            // foreach ($excel as list($a,$b,$c,$d,$e,$f,$g,$h)) {
                // $date = explode('/',$a)[2].'-'.str_pad(explode('/',$a)[0], 2, '0', STR_PAD_LEFT).'-'.str_pad(explode('/',$a)[1], 2, '0', STR_PAD_LEFT);
            $date = date("Y-m-d", strtotime($a));
            $date2 = addslashes($a);
            $project_no = addslashes($b);
            $account_no = addslashes($c);
            $description = addslashes($d);
            $location = addslashes($f);
            // $remark = addslashes($g);
            $hour = addslashes($h);

            
            // $cost = str_replace(',','',$d);
            // $rs = mysqli_query($conn,"INSERT INTO `db_expense_detail` (`title`, `cost`, `eid`) VALUES ('$a', '".$cost."', '$eid')");
            // $rs = mysqli_query($conn,"INSERT INTO `db_customer_import` (`event`, `code`, `name`, `org`, `position`, `tel`, `email`, `uid`, `created_at`) VALUES ('$event', '$a', '$b', '$c', '$f', '$d', '$e', '12', NOW());");
            $rs = mysqli_query($conn,"INSERT INTO `db_timesheet_detail` (`date`, `date2`, `project_no`, `account_no`, `description`, `location`, `remark`, `hour`, `hour_dec`, `tid`) VALUES ('$date', '$date2', '$project_no', '$account_no', '$description', '$location', '$remark', '$hour', '$hour', '$id');");

            $hrs = $hour+$hrs;

            // $month = '2020-03';
            $month = $_POST['month'];

            if(is_null($month)){
                $month = substr($date,0,7);
            }

            // $total_cost = $cost+$total_cost;
            // $item[] = $a;
        }

        move_uploaded_file($_FILES['file']['tmp_name'],"uploads/timesheet/$month-$eid-$id.".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

        $rs = mysqli_query($conn,"UPDATE `db_timesheet` SET `status` = '0' WHERE uid = '$eid' and month = '$month' and id != $id;");
        $rs = mysqli_query($conn,"UPDATE `db_timesheet` SET `month` = '$month', `hrs` = '$hrs' WHERE `id` = $id;");

        $redirect = ".?mod=timesheet-edit&alert=success&chk_id=$id";        
        
    }elseif($mod=='recruit'){
        if(isset($_GET['istatus'])){
            $istatus = $_GET['istatus'];

            if($istatus=='1t'){
                $sq = ' , interview_status1 = 1';

            }elseif($istatus=='1f'){
                $sq = ' , interview_status1 = 0';
                
            }elseif($istatus=='2t'){
                $sq = ' , interview_status2 = 1';

            }elseif($istatus=='2f'){
                $sq = ' , interview_status2 = 0';
                
            }elseif($istatus=='3t'){
                $sq = ' , interview_status3 = 1';

            }elseif($istatus=='3f'){
                $sq = ' , interview_status3 = 0';
                
            }

            $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `interview_status` = '$istatus'$sq WHERE `id` = $id;");

        }elseif(isset($_GET['status'])){
            $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `status` = '".$_GET['status']."' WHERE `id` = $id;");

        }else{
            $name = $_POST['name'];
            $nick = $_POST['nick'];
            $position = $_POST['position'];
            $start_date = sqldate($_POST['start_date']);
            if(trim($_POST['next_interview_date'])!=''){
                $next_interview_date = sqldate($_POST['next_interview_date']).' '.$_POST['next_interview_time'].':00';                
            }
            if($_POST['dob']!=''){
                $dob = sqldate($_POST['dob']);
            }

            if($id!=''){
                $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `name` = '$name',`nick` = '$nick',`dob` = '$dob',`position` = '$position',`next_interview_date` = '$next_interview_date', `start_date` = '$start_date' WHERE `id` = $id;");

            }else{
                $rs = mysqli_query($conn,"INSERT INTO `db_recruit` (`name`, `nick`, `dob`, `position`, `next_interview_date`, `created_at`, `start_date`) VALUES ('$name', '$nick', '$dob', '$position', '$next_interview_date', NOW(), '$start_date');");
                $id = mysqli_insert_id($conn);
        
            }
            
            if(isset($_FILES['cv'])){
                $file = $id.'-cv-'.$_FILES['cv']['name'];
                if(move_uploaded_file($_FILES['cv']['tmp_name'],'uploads/recruit/'.$file)){
                    $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `cv` = '$file' WHERE `id` = $id;");
                }
            }        
            if(isset($_FILES['transcript'])){
                $file = $id.'-transcript-'.$_FILES['transcript']['name'];
                if(move_uploaded_file($_FILES['transcript']['tmp_name'],'uploads/recruit/'.$file)){
                    $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `transcript` = '$file' WHERE `id` = $id;");
                }
            }        
            if(isset($_FILES['idcard'])){
                $file = $id.'-idcard-'.$_FILES['idcard']['name'];
                if(move_uploaded_file($_FILES['idcard']['tmp_name'],'uploads/recruit/'.$file)){
                    $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `idcard` = '$file' WHERE `id` = $id;");
                }
            }        
            if(isset($_FILES['bookbank'])){
                $file = $id.'-bookbank-'.$_FILES['bookbank']['name'];
                if(move_uploaded_file($_FILES['bookbank']['tmp_name'],'uploads/recruit/'.$file)){
                    $rs = mysqli_query($conn,"UPDATE `db_recruit` SET `bookbank` = '$file' WHERE `id` = $id;");
                }
            }
        }

        $redirect = ".?mod=recruit&alert=success";       

    }elseif($mod=='resign'){
        include 'acts/'.$mod.'.php';

    }elseif($mod=='employee'){
        $yr = date(Y);

        $code = $_POST['code'];
        $name = $_POST['name'];
        $name_en = $_POST['name_en'];
        $nick = $_POST['nick'];
        $position = $_POST['position'];
        $tel = str_replace('-','',$_POST['tel']);
        $email = $_POST['email'];
        $dome_note = $_POST['dome_note'];
        $dob = sqldate($_POST['dob']);
        $start_date = sqldate($_POST['start_date']);
        $parent = $_POST['parent'];

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_employee` SET `name` = '$name', `name_en` = '$name_en', `nick` = '$nick', `position` = '$position', `tel` = '$tel', `email` = '$email', `dome_note` = '$dome_note', `dob` = '$dob', `parent` = '$parent', `start_date` = '$start_date', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            $vacation_day = 13-explode('-',$start_date)[1];

            $rs = mysqli_query($conn,"INSERT INTO `db_employee` (`code`, `name`, `name_en`, `nick`, `position`, `tel`, `email`, `dome_note`, `dob`, `parent`, `start_date`, `created_at`) VALUES ('$code', '$name', '$name_en', '$nick', '$position', '$tel', '$email', '$dome_note', '$dob', '$parent', '$start_date', NOW());");
            $id = mysqli_insert_id($conn);
        
            $rs = mysqli_query($conn,"INSERT INTO `db_timeoff_vacation` (`year`, `uid`, `day`) VALUES ('$yr', '$id', '$vacation_day');");    
        }

        $redirect = ".?mod=employee-profile&id=$id&alert=success";        

    }elseif($mod=='profile'){
        $emer_tel = addslashes($_POST['emer_tel']);
        $emer_who = addslashes($_POST['emer_who']);
        $allergies = json_encode($_POST['allergies']);
        $allergy_other = addslashes($_POST['allergy_other']);
        $line_token = addslashes($_POST['line_token']);

        $spw = '';
        if(trim($_POST['password'])!=''){
            $password = md5($_POST['password']);
            $spw = ", `password` = '$password'";
        }

        if(isset($_FILES['hq'])){
            move_uploaded_file($_FILES['hq']['tmp_name'],'uploads/employee_hq/'.$id.'.jpg');
        }

        if($_SESSION['ses_ulevel']>7){
            $mods = json_encode($_POST['mods']);

            $rs = mysqli_query($conn,"UPDATE `db_employee` SET `emer_who` = '$emer_who', `emer_tel` = '$emer_tel', `allergies` = '$allergies', `allergy_other` = '$allergy_other', `line_token` = '$line_token'$spw, `mods` = '$mods', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            $rs = mysqli_query($conn,"UPDATE `db_employee` SET `emer_who` = '$emer_who', `emer_tel` = '$emer_tel', `allergies` = '$allergies', `allergy_other` = '$allergy_other', `line_token` = '$line_token'$spw, `updated_at` = NOW() WHERE `id` = $id;");

        }


        // $rs = mysqli_query($conn,"SELECT * FROM `db_linenotify` WHERE `uid` = $uid");
        // $cnt = mysqli_num_rows($rs);

        // if($cnt==0){
        //     $rs = mysqli_query($conn,"INSERT INTO `db_linenotify` (`uid`, `line_token`, `mods`, `updated_at`) VALUES ('$uid', '$line_token', '$mods', NOW());");
        // }else{
        //     $rs = mysqli_query($conn,"UPDATE `db_linenotify` SET `line_token` = '$line_token', `mods` = '$mods', `updated_at` = NOW() WHERE `uid` = $uid;
        //     ");

        // }

        $redirect = ".?mod=employee-profile&id=$id&alert=success";        

    }elseif($mod=='dome_note'){
        $dome_note = addslashes($_POST['dome_note']);
        $id = $_POST['id'];    
        $rs = mysqli_query($conn,"UPDATE `db_employee` SET `dome_note` = '$dome_note' WHERE `id` = $id;");

        $redirect = ".?mod=employee-profile&id=$id&alert=success";        

    }elseif($mod=='evaluate'){    
        $a1 = addslashes($_POST['a1']);
        $a2 = addslashes($_POST['a2']);
        $a3 = addslashes($_POST['a3']);
        $a4 = addslashes($_POST['a4']);
        $a5 = addslashes($_POST['a5']);
        $b = addslashes($_POST['b']);
        $b2 = addslashes($_POST['b2']);
        $c = addslashes($_POST['c']);
        $d = addslashes($_POST['d']);

        if(empty($uid)){
            $uid = $_POST['uid'];
        }
        
        if(isset($_POST['submitted'])){
        //     $rs = mysqli_query($conn,"UPDATE `db_evaluate` SET `a1` = '$a1', `a2` = '$a2', `a3` = '$a3', `a4` = '$a4', `a5` = '$a5', `b` = '$b', `b2` = '$b2', `c` = '$c', `d` = '$d', `updated_at` = NOW() WHERE `id` = $id;");
            $rs = mysqli_query($conn,"INSERT INTO `db_evaluate` (`a1`, `a2`, `a3`, `a4`, `a5`, `b`, `b2`, `c`, `d`, `uid`, `created_at`, `submitted_at`) VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$b', '$b2', '$c', '$d', '$uid', NOW(), NOW());");

            $rs = mysqli_query($conn,"UPDATE `db_employee` SET `evaluated_at` = NOW() WHERE `id` = $uid;");

            $sMessage = 'ส่ง Evaluation Form';
            line_notify($uid,$mod,$sMessage);
        
        }else{
            $rs = mysqli_query($conn,"INSERT INTO `db_evaluate` (`a1`, `a2`, `a3`, `a4`, `a5`, `b`, `b2`, `c`, `d`, `uid`, `created_at`) VALUES ('$a1', '$a2', '$a3', '$a4', '$a5', '$b', '$b2', '$c', '$d', '$uid', NOW());");

            $sMessage = 'อัพเดต Evaluation Form';
        }

        $redirect = ".?mod=employee-profile&alert=success&tab=evaluate";        

    }elseif($mod=='customer-import'){
        if (isset($_POST["import"])) {
        
            $fileName = $_FILES["file"]["tmp_name"];
            
            if ($_FILES["file"]["size"] > 0) {
                
                $file = fopen($fileName, "r");
                
                while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $rs = mysqli_query($conn,"INSERT INTO `db_customer` (`name`, `position`, `org`, `tel`, `email`, `added_by`, `created_at`) VALUES ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $uid . "', NOW());");

                    if (! empty($rs)) {
                        $type = "success";
                        $message = "CSV Data Imported into the Database";
                        $redirect = ".?mod=customer&alert=success";        

                    } else {
                        $type = "error";
                        $message = "Problem in Importing CSV Data";
                        $redirect = ".?mod=customer&alert=failed";        

                    }
                }
            }
        }

    }elseif($mod=='customer'){
        $event = trim($_POST['code']);

        // $rs = mysqli_query($conn,"NSERT INTO `db_cxpense (`code`, `uid`, `created_at`) VALUES ('$code', '$uid', NOW());");
        // $eid = mysqli_insert_id($conn);

        $excel = array();
        $rows = explode("\r\n", trim($_POST['excel']));
        foreach($rows as $idx => $row)
        {
            $row = explode( "\t", $row );
            foreach( $row as $field )
            {
                $excel[$idx][] = $field;
            }
        }

        foreach ($excel as list($a,$b,$c,$d,$e,$f)) {
            // $cost = str_replace(',','',$d);
            // $rs = mysqli_query($conn,"INSERT INTO `db_expense_detail` (`title`, `cost`, `eid`) VALUES ('$a', '".$cost."', '$eid')");
            $rs = mysqli_query($conn,"INSERT INTO `db_customer_import` (`event`, `code`, `name`, `org`, `position`, `tel`, `email`, `uid`, `created_at`) VALUES ('$event', '$a', '$b', '$c', '$f', '$d', '$e', '12', NOW());");

            // $total_cost = $cost+$total_cost;
            // $item[] = $a;
        }

        // $items = implode(', ',$item);

        // $rs = mysqli_query($conn,"UPDATE `db_expense` SET `items` = '$items', `total_cost` = '$total_cost' WHERE `id` = $eid;");
        
        // $sMessage = 'ส่งใบขออนุมัติเบิกค่าใช้จ่าย เลขที่ '.$code.' ('.$items.') ขอเบิก '.number_format($total_cost,2).'฿';
        // line_notify($uid,$mod,$sMessage);
        $redirect = ".?mod=customer&alert=success";        

    }elseif($mod=='cost_center'){
        $costcenters = $_POST['costcenter'];

        foreach($costcenters as $k => $v){
            $nos = explode('-',$v);
            $acc_no = $nos[0];
            $proj_no = $nos[1];

            $rs = mysqli_query($conn,"UPDATE `db_expense_detail` SET `acc_no` = '$acc_no', `proj_no` = '$proj_no' WHERE `id` = $k;");
        }

        $redirect = ".?mod=expense&alert=success";        

    }elseif($mod=='expense'){
        $code = trim($_POST['code']);
        $pay_to = trim($_POST['pay_to']);
        $month = trim($_POST['month']);

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_expense` SET `code` = '$code', `pay_to` = '$pay_to', `month` = '$month', `updated_at` = NOW() WHERE `id` = $id;");
            $eid = $id;
            $rs = mysqli_query($conn,"UPDATE `db_expense_detail` SET `status` = '0' WHERE `eid` = $eid;");

        }else{
            $rs = mysqli_query($conn,"INSERT INTO `db_expense` (`code`, `pay_to`, `uid`, `month`, `created_at`) VALUES ('$code', '$pay_to', '$uid', '$month', NOW());");
            $eid = mysqli_insert_id($conn);

        }

        $excel = array();
        $rows = explode("\r\n", trim($_POST['excel']));
        foreach($rows as $idx => $row)
        {
            // $row = explode( "\t", $row );
            $row = explode( "|", $row );
            foreach( $row as $field )
            {
                $excel[$idx][] = $field;
            }
        }

        foreach ($excel as list($a,$d)) {
            $cost = str_replace(',','',$d);
            $rs = mysqli_query($conn,"INSERT INTO `db_expense_detail` (`title`, `cost`, `eid`) VALUES ('$a', '".$cost."', '$eid')");
            $total_cost = $cost+$total_cost;
            $item[] = $a;
        }

        $items = implode(', ',$item);
        $rs = mysqli_query($conn,"UPDATE `db_expense` SET `items` = '$items', `total_cost` = '$total_cost' WHERE `id` = $eid;");
        
        if($id==''&&$month==date("Y-m")){
            $items = str_replace('%',"%25",$items);
            $sMessage = 'ส่งใบสำคัญจ่าย เลขที่ '.$code.' ('.$items.') จ่ายให้ '.$pay_to.' '.number_format($total_cost,2).'฿';
            line_notify($uid,$mod,$sMessage);
        }

    }elseif($mod=='equipment'){
        $code = $_POST['code'];
        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $spec = $_POST['spec'];
        $warranty = sqldate($_POST['warranty']);
        $sn = $_POST['sn'];
        $user = $_POST['user'];

        if($user=='oos'){
            $status = 1;
            if($row['end_date']==NULL){
                $rs = mysqli_query($conn,"UPDATE `db_equipment_log` SET `end_date` = NOW() WHERE `eid` = $id AND end_date IS NULL;;");            
            }

        }elseif($user==''){
            $status = 2;

            if($row['end_date']==NULL){
                $rs = mysqli_query($conn,"UPDATE `db_equipment_log` SET `end_date` = NOW() WHERE `eid` = $id AND end_date IS NULL;;");            
            }

        }else{
            $status = 3;
            $user_use = $user;
        }

        if($id!=''){
            $sql = "UPDATE `db_equipment` SET `code` = '$code', `brand` = '$brand', `model` = '$model', `spec` = '$spec', `warranty` = '$warranty', `sn` = '$sn',`status` = '$status' WHERE `id` = $id;";

        }else{
            $sql = "INSERT INTO `db_equipment` (`code`, `brand`, `model`, `spec`, `warranty`, `sn`, `status`, `created_at`) VALUES ('$code', '$brand', '$model', '$spec', '$warranty', '$sn', '2', NOW());";
            $id = mysqli_insert_id($conn);

        }
        $rs = mysqli_query($conn,$sql);

        $rs = mysqli_query($conn,"SELECT * FROM `db_equipment_log` WHERE `eid` = $id and end_date is null order by id desc limit 1");
        $cnt = mysqli_num_rows($rs);
        $row = mysqli_fetch_assoc($rs);
        
        if(isset($user_use)){
            $start_date = sqldate($_POST['start_date']);

            if($cnt==0||$user_use!=$row['uid']){
                if($user_use!=$row['uid']){
                    $rs = mysqli_query($conn,"UPDATE `db_equipment_log` SET `end_date` = NOW() WHERE `eid` = $id AND end_date IS NULL;");
                }
                $rs = mysqli_query($conn,"INSERT INTO `db_equipment_log` (`eid`, `uid`, `start_date`) VALUES ('$id', '$user_use', '$start_date');");
            }
        }

        $redirect = '.?mod=equipment&alert=success';

    }elseif($mod=='asset'){
        if($_POST['remark']!=''){
            $remark = addslashes($_POST['remark']);
            $remarkk = ' ('.$remark.')';
        }

        if($id!=''){
            // $floor = $_POST['floor'];
            // $lot = $_POST['lot'];

            $rs = mysqli_query($conn,"UPDATE `db_asset` SET `remark_back` = '$remark', `uid_back` = '$uid', `date_back` = NOW() WHERE `id` = $id;");

            $sMessage = 'ของคืนมาแล้ว'.$remarkk;    

            $redirect = ".?mod=$mod&alert=welcomeback";        

        }else{
            $code = addslashes($_POST['code']);
            $destination = addslashes($_POST['destination']);

            $rs = mysqli_query($conn,"INSERT INTO `db_asset` (`code`, `destination`, `remark_go`, `uid_go`, `date_go` ) VALUES ('$code', '$destination', '$remark', '$uid', NOW());");

            $sMessage = $uid.' ยืมของไป'.$destination.$remarkk;    

            $redirect = ".?mod=$mod&alert=$code";        
        }

        line_notify($uid,$mod,$sMessage);

    }elseif($mod=='course-checkin'){
        if($_POST['remark']!=''){
            $remark = addslashes($_POST['remark']);
            $remarkk = ' ('.$remark.')';
        }

        if($id!=''){
            // $floor = $_POST['floor'];
            // $lot = $_POST['lot'];

            $rs = mysqli_query($conn,"UPDATE `db_asset` SET `remark_back` = '$remark', `uid_back` = '$uid', `date_back` = NOW() WHERE `id` = $id;");

            $sMessage = 'ของคืนมาแล้ว'.$remarkk;    

            $redirect = ".?mod=course&alert=welcomeback";        

        }else{
            $code = addslashes($_GET['code']);
            // $destination = addslashes($_POST['destination']);

            $rs = mysqli_query($conn,"INSERT INTO `db_asset` (`code`, `destination`, `remark_go`, `uid_go`, `date_go` ) VALUES ('$code', '$destination', '$remark', '$uid', NOW());");

            $sMessage = $uid.' ยืมของไป'.$destination.$remarkk;    

            $redirect = ".?mod=course&alert=$code";     
        }

        line_notify($uid,$mod,$sMessage);

    }elseif($mod=='checkin'){
        if($_POST['remark']!=''){
            $remark = addslashes($_POST['remark']);
            $remarkk = ' ('.$remark.')';
        }

        if($id!=''){
            // $floor = $_POST['floor'];
            // $lot = $_POST['lot'];

            $rs = mysqli_query($conn,"UPDATE `db_asset` SET `remark_back` = '$remark', `uid_back` = '$uid', `date_back` = NOW() WHERE `id` = $id;");

            $sMessage = 'ของคืนมาแล้ว'.$remarkk;    

            $redirect = ".?mod=meetingroom&alert=welcomeback";        

        }else{
            $code = addslashes($_GET['code']);
            $note = addslashes($_GET['note']);
            // $destination = addslashes($_POST['destination']);

            $rs = mysqli_query($conn,"INSERT INTO `db_asset` (`code`, `destination`, `remark_go`, `uid_go`, `date_go` ) VALUES ('$code', '$note', '$remark', '$uid', NOW());");

            $sMessage = $uid.' ยืมของไป'.$destination.$remarkk;    

            $redirect = ".?mod=meetingroom&alert=safedrive";        
        }

        line_notify($uid,$mod,$sMessage);

    }elseif($mod=='support'){
        $code = addslashes($_POST['code']);
        $project = addslashes($_POST['project']);
        $project_id = addslashes($_POST['project_id']);
        $note = addslashes($_POST['note']);
        $output = addslashes($_POST['output']);
        $end_date = sqldate($_POST['to_date']);
        $status = $_POST['status'];

        if(isset($_POST['uid'])){
            $uid = $_POST['uid'];
        }

        if($id!=''){        
            $rs = mysqli_query($conn,"SELECT `nick` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
            $row = mysqli_fetch_assoc($rs);
            $nick = $row['nick'];

            $rs = mysqli_query($conn,"SELECT * FROM `db_support` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $uid = $row['uid'];

            // if($row['to_uid']==null&&$row['uid']!=$_SESSION['ses_uid']){
            if($row['to_uid']==null){
                    $sd = ", to_uid = '".$_SESSION['ses_uid']."', accepted_at = NOW()";
            }

            if($status==4){
                $sMessage = $nick.'ทำ '.$output.' ให้เสร็จแล้ว สถานะ: Finished';    
                $sd = "$sd, finished_at = NOW(), `status` = '$status'";

            }elseif($status==3){
                $sMessage = $nick.'กำลังทำ '.$output.' ให้ สถานะ: Working';    
                $sd = "$sd, `status` = '$status', updated_at = NOW()";

            }elseif($status==2){
                $sMessage = $nick.'รับงาน '.$output.' แล้ว สถานะ: Pending';    
                $sd = "$sd, `status` = '$status', updated_at = NOW()";

            }elseif($status==1){
                $sMessage = $nick.'ยกเลิกงาน '.$output.' แล้ว สถานะ: Canceled';
                $sd = "$sd, `status` = '$status', updated_at = NOW()";

            }elseif($status==0){
                $sd = "$sd, `status` = '$status', updated_at = NOW()";

            }else{
                $sd = "$sd, updated_at = NOW()";
            }

            $rs = mysqli_query($conn,"UPDATE `db_support` SET `code` = '$code', `project_id` = '$project_id', `note` = '$note', `output` = '$output'$sd, `end_date` = '$end_date' WHERE `db_support`.`id` = $id;");

            if(isset($sMessage)){        
                line_notify($uid,'reply',$sMessage);
            }

        }else{
            $rs = mysqli_query($conn,"INSERT INTO `db_support` (`code`, `project_id`, `note`, `output`, `uid`, `end_date`, `created_at`) VALUES ('$code','$project_id','$note','$output','$uid','$end_date', NOW());");

            $sMessage = 'จะให้ '.$code.' ช่วยทำ '.$output;
            line_notify($uid,"$mod-$code",$sMessage);
        }
    
    }elseif($mod=='reserve'){
        $note = addslashes($_POST['note']);
        $start_date = sqldate($_POST['from_date']).' '.$_POST['from_time'].':00';
        $end_date = sqldate($_POST['to_date']).' '.$_POST['to_time'].':00';

        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_reserve` SET `note` = '$note', `start_date` = '$start_date', `end_date` = '$end_date' WHERE `id` = $id;");

            $rs = mysqli_query($conn,"SELECT code FROM `db_reserve` WHERE `id` = $id");
            $row = mysqli_fetch_assoc($rs);
            $code = $row['code'];

            // $redirect = ".?mod=asset&alert=success";

        }else{
            $code = addslashes($_POST['code']);

            $rs = mysqli_query($conn,"INSERT INTO `db_reserve` (`code`, `note`, `uid`, `start_date`, `end_date`) VALUES ('$code', '$note', '$uid', '$start_date', '$end_date');");
        }

        if($code=='sienta'){
            $st = explode(' ',$start_date);
            $sMessage = 'จองใช้รถ Sienta วันที่ '.webdate($st[0]).' เวลา '.substr($st[1],0,5).' - '.substr($end_date,11,5).' น.';

            line_notify($uid,$code,$sMessage);
    
            $redirect = ".?mod=carrec&alert=success";        

        }elseif($code=='meetingroom'||$code=='meetingroom2'){
            $redirect = ".?mod=meetingroom&alert=success";        

        }else{
            $redirect = ".?mod=asset&alert=success";        
        }

    }elseif($mod=='elearning'){
        $name = addslashes($_POST['name']);
        $description = addslashes($_POST['description']);
        $v = $_POST['v'];
        
        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_elearning` SET `name` = '$name', `description` = '$description', `v` = '$v', `updated_at` = NOW() WHERE `id` = $id;");

        }else{
            $rs = mysqli_query($conn,"INSERT INTO `db_elearning` (`name`, `description`, `v`, `created_at`) VALUES ('$name', '$description', '$v', NOW());");
            $id = mysqli_insert_id($conn);

        }

        $redirect = ".?mod=elearning&page=summary&alert=success";

    }elseif($mod=='comment'){    
        $md = $_POST['md'];
        $mid = $_POST['mid'];
        $message = addslashes($_POST['message']);
        
        $rs = mysqli_query($conn,"INSERT INTO `db_comment` (`md`, `mid`, `message`, `uid`, `created_at`) VALUES ('$md', '$mid', '$message', '$uid', NOW());");

        $redirect = ".?mod=$md-detail2&id=$mid&alert=success";

    }elseif($mod=='course'){
        $name = addslashes($_POST['name']);
        $desc_short = addslashes($_POST['desc_short']);
        $description = addslashes($_POST['description']);
        $owner = $_POST['owner'];
        
        if($id!=''){
            $rs = mysqli_query($conn,"UPDATE `db_course` SET `name` = '$name', `desc_short` = '$desc_short', `description` = '$description', `owner` = '$owner', `updated_at` = NOW() WHERE `db_course`.`id` = $id;");

        }else{
            $rs = mysqli_query($conn,"INSERT INTO `db_course` (`name`, `desc_short`, `description`, `owner`, `created_at`) VALUES ('$name', '$desc_short', '$description', '$owner', NOW());");
            $id = mysqli_insert_id($conn);

        }

        if(isset($_FILES['file'])){
            $filename = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if(move_uploaded_file($_FILES['file']['tmp_name'],"uploads/$mod/$id.$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_$mod` SET `cover` = '$filename' WHERE `id` = $id;
                ");
            }
        }

        $redirect = ".?mod=course&page=summary&alert=success";

    }elseif($mod=='course-start'){
        $id = addslashes($_GET['id']);
        $rs = mysqli_query($conn,"INSERT INTO `db_courserec` (`cid`, `uid`, `start_date`) VALUES ('$id', '$uid', NOW());");
        $redirect = ".?mod=course-detail&id=$id&alert=started";
            
    }elseif($mod=='course-finish'){
        $id = addslashes($_GET['id']);
        $rs = mysqli_query($conn,"UPDATE `db_courserec` SET `end_date` = NOW() WHERE `cid` = $id AND uid = ".$_SESSION['ses_uid'].";");
        $redirect = ".?mod=course-detail&id=$id&alert=success";        
            
    }elseif($mod=='carrec'){
        $km = $_POST['km'];
        if($_POST['remark']!=''){
            $remark = addslashes($_POST['remark']);
            $remarkk = ' ('.$remark.')';
        }

        if($id!=''){
            $floor = $_POST['floor'];
            $lot = $_POST['lot'];

            $rs = mysqli_query($conn,"UPDATE `db_carrec` SET `km_back` = '$km', `floor` = '$floor', `lot` = '$lot', `remark_back` = '$remark', `uid_back` = '$uid', `date_back` = NOW() WHERE `id` = $id;");

            $sMessage = 'ขับรถกลับมาแล้ว จอดรถไว้ที่ชั้น '.$floor.' ช่อง '.$lot.$remarkk;    

            $redirect = ".?mod=carrec&alert=welcomeback";        

        }else{
            $destination = addslashes($_POST['destination']);

            $rs = mysqli_query($conn,"INSERT INTO `db_carrec` (`km_go`, `destination`, `remark_go`, `uid_go`, `date_go`) VALUES ('$km', '$destination', '$remark', '$uid', NOW());");

            $sMessage = 'ขับรถไป'.$destination.$remarkk;    

            $redirect = ".?mod=carrec&alert=safedrive";        
        }

        line_notify($uid,$mod,$sMessage);

    }elseif($mod=='training-register'){
        $rs = mysqli_query($conn,"INSERT INTO `db_training_register` (`uid`, `tid`, `created_at`) VALUES ('$uid', '$id', NOW());");

        $redirect = ".?mod=training-my&alert=success";        

    }elseif($mod=='training'){
        $redirect = ".?mod=training-my&alert=success";      

        if(isset($_FILES['slip_file'])){
            $filename = "r$id-slip-".$_FILES['slip_file']['name'];
            if(move_uploaded_file($_FILES['slip_file']['tmp_name'],"uploads/training/$filename")){
                $rs = mysqli_query($conn,"UPDATE `db_training_register` SET `slip_file` = '$filename' WHERE `id` = $id;");
            }
            
            $redirect = ".?mod=training-register&alert=success";

        }elseif(isset($_GET['status'])){
            $rs = mysqli_query($conn,"UPDATE `db_training_register` SET `status` = '".$_GET['status']."' WHERE `id` = $id;");

            if($_GET['status']==4){
                $redirect = ".?mod=training-view&rid=$id&alert=success";

            }else{
                $redirect = ".?mod=training-register&alert=success";        

            }

        }elseif(isset($_POST['title'])){
            $title = $_POST['title'];
            $train_date_from = sqldate($_POST['train_date_from']);
            $train_date_to = sqldate($_POST['train_date_to']);
            $fee = $_POST['fee'];
            $payment = $_POST['payment'];
            $payment_due = sqldate($_POST['payment_due']);
            $trainer = $_POST['trainer'];
            $place = $_POST['place'];
            $detail = $_POST['detail'];
            
            $sql = "INSERT INTO `db_training` (`title`, `train_date_from`, `train_date_to`, `fee`, `payment`, `payment_due`, `trainer`, `place`, `detail`, `uid`, `created_at`) VALUES ('$title', '$train_date_from', '$train_date_to', '$fee', '$payment', '$payment_due', '$trainer', '$place', '$detail', '$uid', NOW());";
            $rs = mysqli_query($conn,$sql) OR die(mysqli_error($conn));
            $id = mysqli_insert_id($conn);
    
            if(isset($_FILES['file'])){
                $filename = $id.'-'.$_FILES['file']['name'];
                if(move_uploaded_file($_FILES['file']['tmp_name'],'uploads/training/'.$filename)){
                    $rs = mysqli_query($conn,"UPDATE `db_training` SET `attach` = '$filename' WHERE `id` = $id;");
                }
            }   
            
            $redirect = ".?mod=training&alert=success";
        }

    }

}elseif($mod=='signin'){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    if($_POST['password']=='Time1220!'){
        $sql = "SELECT * FROM `db_employee` WHERE `email` LIKE '$email'";

    }else{
        $sql = "SELECT * FROM `db_employee` WHERE `email` LIKE '$email' AND password = '$password' and end_date is null";

    }

    $rs = mysqli_query($conn,$sql);

    if(mysqli_num_rows($rs)>0){
        $row = mysqli_fetch_assoc($rs);

        $uid = $row['id'];
        $imageurl = "uploads/employee/$uid.jpg";
        $_SESSION['ses_user_imageurl'] = $imageurl;                 
        $_SESSION['ses_uid'] = $uid;            
        $_SESSION['ses_user_email'] = $row['email'];    
        $_SESSION['ses_ulevel'] = $row['level'];        
        $_SESSION['evaluated_at'] = $row['evaluated_at'];
        $_SESSION['ses_fullname'] = $row['name_en'];

        $redirect = ".?loggedin";
    }else{

        $redirect = ".?failed";
    }

    
}

if(empty($redirect)){
    $redirect = ".?mod=$mod";
}

if($id!=''){
    $act = "$mod-$id";
}else{
    $act = "$mod-new";
}

function line_notify($uid,$mod,$sMessage){
    global $conn;

    if($mod=='reply'){
        $rs = mysqli_query($conn,"SELECT `line_token` FROM `db_employee` WHERE `id` = $uid AND line_token != ''");
        
    }else{
        $rs = mysqli_query($conn,"SELECT `nick` FROM `db_employee` WHERE `id` = $uid");
        $row = mysqli_fetch_assoc($rs);

        if($mod=='expense'){
            $nick = str_replace('พี่','',$row['nick']);

        }else{
            $nick = $row['nick'];
        }

        $sMessage = $nick.$sMessage;

        if($mod=='sienta'){
            $rs = mysqli_query($conn,"SELECT line_token FROM `db_employee` WHERE `line_token` != ''");

        }else{
            $rs = mysqli_query($conn,"SELECT line_token FROM `db_employee` WHERE `mods` LIKE '%\"$mod\"%' AND line_token != ''");
        }
    }
    $cnt = mysqli_num_rows($rs);

    if($cnt!=0){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        date_default_timezone_set("Asia/Bangkok");
        
        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 

        while($row=mysqli_fetch_assoc($rs)){
            $sToken = $row['line_token'];

            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
            $result = curl_exec( $chOne );

            $rss = mysqli_query($conn,"INSERT INTO `db_linenotify` (`uid`, `line_token`, `mods`, `updated_at`) VALUES ('$uid', '$sToken', '$mod', NOW());");        
        }
        curl_close( $chOne );        
    }
}

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

$rs = mysqli_query($conn,"INSERT INTO `db_log` (`act`, `agent`, `ip`, `uid`, `date`) VALUES ('$act', '$agent', '".get_ip_address()."', '$uid', NOW());");

closedb();

header("location:$redirect");