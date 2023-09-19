<?php
include 'global.php';
conndb();

$delimiter = ",";
$filename = $page."_" . date('Ymd-His') . ".csv";
$f = fopen('php://memory', 'w');

if($page=='report'){
    $month = $_GET['months'];

    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` ORDER BY `db_employee`.`code` ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $emps[$row['id']] = [
            $row['code'],
            $row['name_en'],
        ];
    }

    if($_GET['pcode']!=''){
        // $rs = mysqli_query($conn,"SELECT DISTINCT uid FROM `db_timesheet` a join db_timesheet_detail b WHERE a.`status` > 0 and a.id = b.tid and project_no like '".$_GET['pcode']."'");
        // while($row=mysqli_fetch_assoc($rs)){
        //     $pimgs[] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$emps[$row['uid']][1].'">
        //     <img src="uploads/employee/'.$row['uid'].'.jpg" alt=".">
        // </a>';
        //     $persons[] = $emps[$row['uid']][1];
        // }

        $sqp = " and project_no like '".$_GET['pcode']."'";

    }elseif($_GET['months']==''&&$_GET['account_no']==''&&$_GET['time1']==''){
        $sqp = " and project_no like 'jomm'";
    }

    if($month!=''){
        foreach($month as $v){
            $sqms[] = "month = '$v'";            
        }        
        $sqm = " and (".implode(' OR ',$sqms).")";
    }

    if($_GET['account_no']!=''){
        $sqa = " and account_no = '".$_GET['account_no']."'";
    }

    if($_GET['time1']!=''){
        $sqt = " and uid like '".$_GET['time1']."'";
    }

    $ttlhrs = 0;
    $sql = "SELECT *  FROM `db_timesheet` a join db_timesheet_detail b WHERE a.`status` = 2 and a.id = b.tid and account_no != ''$sqp$sqm$sqa$sqt order by month";
    // echo '<!--'.$sql.'-->';
    $rs = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['uid']] = [
            'project_no' => $row['project_no'],
            // 'account_no' => $row['account_no'],
            // 'month' => $row['month'],
            // 'date' => $row['date2'],
            // 'hour' => $row['hour'],
        ];

        if(!in_array($row['project_no'],$project_nos[$row['uid']])){
            if($row['project_no']!=''&&substr(strtoupper(trim($row['project_no'])),0,5)=='TIME-'){
                $project_nos[$row['uid']][] = $row['project_no'];
            }
        }
        if(!in_array($row['account_no'],$account_nos[$row['uid']])){
            if(substr(trim($row['account_no']),0,1)==9){
                $account_nos[$row['uid']][] = $row['account_no'];
            }
        }
        if(!in_array($row['month'],$months[$row['uid']])){
            $months[$row['uid']][] = $row['month'];
        }

        $hours[$row['uid']] = $hours[$row['uid']]+$row['hour'];
        $days[$row['uid']] = $days[$row['uid']]+1;

        $ttlhrs = $row['hour']+$ttlhrs;
        $ttldays = $ttldays+1;
    }

    // echo json_encode($dt);
    // echo json_encode($days);

        // foreach($pimgs as $v){
        //     echo $v;
        // }

    // echo '</div>'.implode(', ',$persons);

    $lineData = ['Project','Account Number','Name','Month','Hours','Day work'];
    fputcsv($f, $lineData, $delimiter);

    foreach($dt as $k => $v){
        sort($project_nos[$k]);
        sort($account_nos[$k]);

        $lineData = [implode(', ',$project_nos[$k]),implode(', ',$account_nos[$k]),$emps[$k][1],implode(', ',$months[$k]),$hours[$k],$days[$k]];
        fputcsv($f, $lineData, $delimiter);
    }

    $lineData = ['Total','',count($dt),'',number_format($ttlhrs,2),$ttldays];

}elseif($page=='expense'){
        if(isset($_GET['year'])){
        $year = $_GET['year'];
    }else{
        $year = '2021';
    } 
    
    $rs = mysqli_query($conn,"SELECT a.id,b.month,a.acc_no,a.proj_no,a.cost FROM `db_expense_detail` a join db_expense b where b.status != 0 and a.eid = b.id and a.status = 2 ORDER BY month,acc_no,proj_no ASC");
    while($row=mysqli_fetch_assoc($rs)){
        if($row['acc_no']==9001||($row['acc_no']==9005&&$row['proj_no']!='')){
            $costcenter = $row['proj_no'];
        }else{
            $costcenter = $row['acc_no'];
        }

        $dt[$row['month']][$costcenter] = $row['cost']+$dt[$row['month']][$costcenter];
    }

    $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project`");
    while($row=mysqli_fetch_assoc($rs)){
        $projects[$row['code']] = $row['name'];
    }

    $bos = [
        'sal' => 'เงินเดือน',
        'off' => 'ค่าใช้จ่ายสำนักงาน',
        'oth' => 'ค่าใช้จ่ายอื่นๆ',
        'vat' => 'VAT',
        'pit1' => 'ภงด.1',
        'pit3' => 'ภงด.3',
        'pit53' => 'ภงด.53',
        'pit30' => 'ภพ.30',
        'pit36' => 'ภพ.36',
        'wht' => 'หัก ณ ที่จ่าย',
        'sso' => 'ประกันสังคม',
        'frc' => 'ค่าที่ปรึกษาต่างประเทศ',
        'cap' => 'ค่าใช้จ่ายด้านการลงทุน (CAPEX)',
    ];

    $lineData = ['Costcenter',$emo['01'],$emo['02'],$emo['03'],$emo['04'],$emo['05'],$emo['06'],$emo['07'],$emo['08'],$emo['09'],$emo['10'],$emo['11'],$emo['12'],'Total'];
    fputcsv($f, $lineData, $delimiter);

    $rs = mysqli_query($conn,"SELECT DISTINCT proj_no FROM `db_expense_detail` a join db_expense b WHERE b.status != 0 and a.eid = b.id and a.`status` = 2 and b.created_at like '$year-%' and proj_no != '' ORDER BY `a`.`proj_no` ASC");

    while($row=mysqli_fetch_assoc($rs)){
        $total = 0;

        if(array_key_exists($row['proj_no'],$bos)){
            $t = '9005 '.$bos[$row['proj_no']];
        }else{
            $t = 'TIME-'.$row['proj_no'].' '.$projects[$row['proj_no']];
        }

        for($i=1;$i<=12;$i++){
            $mo = $year.'-'.str_pad($i, 2, 0, STR_PAD_LEFT);
            if($dt[$mo][$row['proj_no']]!=''){
                $v[$i] = $dt[$mo][$row['proj_no']];               
                $total = $dt[$mo][$row['proj_no']]+$total;
            }
        
        }


        $lineData = [$t,$v[1],$v[2],$v[3],$v[4],$v[5],$v[6],$v[7],$v[8],$v[9],$v[10],$v[11],$v[12],$total];
        fputcsv($f, $lineData, $delimiter);

        unset($v);
    }

    $total = 0;

    for($i=1;$i<=12;$i++){
        $mo = $year.'-'.str_pad($i, 2, 0, STR_PAD_LEFT);

        if(isset($dt[$mo])){
            $v[$i] = array_sum($dt[$mo]);        
            $total = array_sum($dt[$mo])+$total;
        } 
    }

    $lineData = ['Total',$v[1],$v[2],$v[3],$v[4],$v[5],$v[6],$v[7],$v[8],$v[9],$v[10],$v[11],$v[12],$total];
    fputcsv($f, $lineData, $delimiter);

}elseif($page=='support'){
    $rs = mysqli_query($conn,"SELECT `id`, `name` FROM `db_employee`");
    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['id']] = $row['name'];
    }

    $lineData = ['#','ชื่อคนร้องขอ','คนรับงาน','รายละเอียดของงาน','วันที่ร้องขอ','วันที่รับงาน','วันที่ปิดงาน'];
    fputcsv($f, $lineData, $delimiter);

    $sp_stts = [
        2 => 'Pending',
        3 => 'Working',
        4 => 'Finished',
        1 => 'Canceled',
    ];

    $rs = mysqli_query($conn,"SELECT * FROM `db_support` WHERE status != 0 and created_at like '".$_GET['month']."%' ORDER BY `id` DESC");

    while($row=mysqli_fetch_assoc($rs)){
        if($row['to_uid']==null){
            $to_uid = $row['code'];
        }else{
            $to_uid = $dt[$row['to_uid']];
        }

        if($row['finished_at']==null){
            $finished_at = $sp_stts[$row['status']];
        }else{
            $finished_at = $row['finished_at'];
        }

        $lineData = [$row['id'],$dt[$row['uid']],$to_uid,$row['note'],$row['created_at'],$row['accepted_at'],$finished_at];
        fputcsv($f, $lineData, $delimiter);

        unset($v);
    }

}elseif($page=='culture'){
    $q = $_GET['q'];
    $rs = mysqli_query($conn,"SELECT * FROM `db_culture_answer` WHERE `q` LIKE '$q' ORDER BY `id` ASC");    
    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['uid']][$row['qid']] = $row['answer'];
    }

    $lineData = ['Code','Name','1A','1B','1C','2A','2B','2C','3A','3B','4A','4B','4C','5A','5B','5C','6A','6B','6C','6D','7A','7B','7C','8A','8B','8C','8D','8E','9A','9B','10A','10B','11A','11B','12A','12B','13A','13B','14A','14B','15A','15B'];
    fputcsv($f, $lineData, $delimiter);

    $rs = mysqli_query($conn,"SELECT id,code,name_en FROM `db_employee` WHERE id > 2 AND `end_date` IS NULL ORDER BY code ASC");

    while($row=mysqli_fetch_assoc($rs)){
        $lineData = ['TIME'.str_pad($row['code'], 3, '0', STR_PAD_LEFT),$row['name_en'],$dt[$row['id']]['1A'],$dt[$row['id']]['1B'],$dt[$row['id']]['1C'],$dt[$row['id']]['2A'],$dt[$row['id']]['2B'],$dt[$row['id']]['2C'],$dt[$row['id']]['3A'],$dt[$row['id']]['3B'],$dt[$row['id']]['4A'],$dt[$row['id']]['4B'],$dt[$row['id']]['4C'],$dt[$row['id']]['5A'],$dt[$row['id']]['5B'],$dt[$row['id']]['5C'],$dt[$row['id']]['6A'],$dt[$row['id']]['6B'],$dt[$row['id']]['6C'],$dt[$row['id']]['6D'],$dt[$row['id']]['7A'],$dt[$row['id']]['7B'],$dt[$row['id']]['7C'],$dt[$row['id']]['8A'],$dt[$row['id']]['8B'],$dt[$row['id']]['8C'],$dt[$row['id']]['8D'],$dt[$row['id']]['8E'],$dt[$row['id']]['9A'],$dt[$row['id']]['9B'],$dt[$row['id']]['10A'],$dt[$row['id']]['10B'],$dt[$row['id']]['11A'],$dt[$row['id']]['11B'],$dt[$row['id']]['12A'],$dt[$row['id']]['12B'],$dt[$row['id']]['13A'],$dt[$row['id']]['13B'],$dt[$row['id']]['14A'],$dt[$row['id']]['14B'],$dt[$row['id']]['15A'],$dt[$row['id']]['15B']];
        fputcsv($f, $lineData, $delimiter);
    }
}

//move back to beginning of file
fseek($f, 0);

//set headers to download file rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');

//output all remaining data on a file pointer
fpassthru($f);

closedb();

exit;

?>