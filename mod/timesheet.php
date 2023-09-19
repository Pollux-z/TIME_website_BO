<?php
    $account_nos = [
        '9001' => 'Project Work',
        '9002' => 'Project Support',
        '9003' => 'Business Development (Project No. Required)',
        '9004' => 'Business Development (No Project No.)',
        '9005' => 'Administration, Business Operation, Support',
        '9007' => 'Training, Education',
        '9008' => 'Product Development',
        '901x' => 'Leave',
    ];                   
    $leave_types = [
        '9010' => 'Vacation',
        '9013' => 'Sick Leave',
        '9014' => 'Compensation Day',
        '9015' => 'Other Leave',
    ];

    if(isset($_GET['month'])){
        $mo = $_GET['month'];
    }else{
        // $mo = date("Y-m");
        $mo = '$year-05';
    }

    $sqll = "SELECT * FROM `db_employee`";
    $rss = mysqli_query($conn,$sqll);

    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = [
            $roww['name'],
            $roww['nick'],
            $roww['position']
        ];
    }

    $sqll = "SELECT * FROM `db_employee` WHERE start_date <= '$mo-31' AND (`end_date` IS NULL OR end_date >= '$mo-01')";
    $rss = mysqli_query($conn,$sqll);

    $i = 0;
    while($roww=mysqli_fetch_assoc($rss)){
        // $time1[$roww['id']] = [
        //     $roww['name'],
        //     $roww['nick'],
        //     $roww['position']
        // ];

        $time11[$roww['id']] = $roww['nick'].' ('.$roww['id'].')';
        $i++;
    }

    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }else{
        $year = date(Y);
    }

?><div class="row mb-4">
    <div class="col-md-6">
        <?php
        
        if($page!='report'){
        if(isset($month)){?>
        <small>Overall timesheet completeness:
            <strong class="text-primary"><?php

    $i = $i-2;
    $pc = number_format($cnt/$i*100);
    echo $cnt.'/'.$i;    
    
            
            ?></strong> (<?php echo $pc;?>%) 
        </small>
        <div class="progress my-3 circle" style="height:6px;">
            <div class="progress-bar circle gd-primary" data-toggle="tooltip" title="<?php echo $pc;?>%" style="width: <?php echo $pc;?>%"></div>
        </div>

            <?php }else{
                echo '<div class="avatar-group">';

        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"timesheet\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        echo implode(' ',$ams).'
        
    </div>';
            }}?>
    </div>
    <div class="col-md-6 text-right">
        <a href="?mod=timesheet">TABLE</a> | <a href="?mod=timesheet&page=summary">SUMMARY</a> | <a href="?mod=timesheet&page=report">REPORT</a><br>
        <?php

        if($page=='report'&&$_SESSION['ses_ulevel']>7){
            echo '<div class="mt-3"><a href="exportData.php?'.$_SERVER['QUERY_STRING'].'" target="_blank"><i class="mx-2" data-feather="download"></i>Download CSV</a></div>';

        }else{

        if(isset($_GET['account_no'])&&$_GET['account_no']!=''){
            $account_no = $_GET['account_no'];
        }else{
            $account_no = '9001';
        }

        if($_SESSION['ses_ulevel']>7){
            // foreach($smonths as $v){
            for($i=1;$i<=12;$i++){
                $v = $year.'-'.str_pad($i,2,0,STR_PAD_LEFT);
                
                if(isset($month)&&$month==$v){
                    $months[] = '<strong>'.$v.'</strong>';
                }else{
                    $months[] = '<a href="?mod=timesheet&page='.$page.'&account_no='.$account_no.'&month='.$v.'">'.$v.'</a>';
                }
            }

            echo implode(' | ',$months).'<br>';
        }

        if(isset($month)){            
            foreach($account_nos as $k => $v){
                if($account_no==$k){
                    $acc_nos[] = '<strong>'.$k.'</strong>';

                }else{
                    $acc_nos[] = '<a href="?mod=timesheet&page=summary&month='.$month.'&account_no='.$k.'" title="'.$v.'">'.$k.'</a>';

                }
            }

            echo implode(' | ',$acc_nos).'<br>';
        }

    }

        ?>

    </div>
</div>

<?php    
    if($_SESSION['ses_ulevel']!=9){
        $rs = mysqli_query($conn,"SELECT code FROM `db_project` WHERE `time1_ids` LIKE '%\"".$_SESSION['ses_uid']."\"%'");
        while($row=mysqli_fetch_assoc($rs)){
            $pms[] = "'TIME-".$row['code']."'";
        }
    }

if(!isset($month)&&$page=='summary'){
?>
<div class="row" data-plugin="apexcharts">

<?php if($_SESSION['ses_ulevel']==9){?>
<div class="col-2">
<?php
$year_total_hrs = 0;

$mName = [
    $year.'-01' => 'Jan',
    $year.'-02' => 'Feb',
    $year.'-03' => 'Mar',
    $year.'-04' => 'Apr',
    $year.'-05' => 'May',
    $year.'-06' => 'Jun',
    $year.'-07' => 'Jul',
    $year.'-08' => 'Aug',
    $year.'-09' => 'Sep',
    $year.'-10' => 'Oct',
    $year.'-11' => 'Nov',
    $year.'-12' => 'Dec',
];

// foreach($smonths as $v){
for($i=1;$i<=12;$i++){
    $v = $year.'-'.str_pad($i,2,0,STR_PAD_LEFT);

    $rs = mysqli_query($conn,"SELECT sum(hrs) total_hrs FROM `db_timesheet` WHERE `month` = '$v' AND status = 2 ORDER BY `id` ASC");
    $row = mysqli_fetch_assoc($rs);

    echo '<div class="row">
    <div class="col-6">
        <a href="?mod=timesheet&page=summary&month='.$v.'" class="btn btn-secondary btn-block">'.$mName[$v].'</a>
    </div>
    <div class="col-6">
        '.number_format($row['total_hrs']).'
    </div>
</div>
';
    $year_total_hrs = $year_total_hrs+$row['total_hrs'];
    $vals[] = $row['total_hrs'];
}

echo '<div class="row">
    <div class="col-6">
        total
    </div>
    <div class="col-6">
        '.number_format($year_total_hrs).'
    </div>
</div>
';

?></div>
    <div class="col-10">
        <div id="a-c-1">
        </div>
    </div>
<?php }?>
    <div class="col-12">
    
<?php
    $rs = mysqli_query($conn,"SELECT a.id,a.project_no,a.account_no,a.hour,b.month FROM `db_timesheet_detail` a join db_timesheet b WHERE a.tid = b.id and b.status = 2 and hour >0 and account_no not in (9010,9013,9015) ORDER BY month,account_no,project_no ASC");

    while($row=mysqli_fetch_assoc($rs)){
        if($row['account_no']!=9001){
            $costcenter = $row['account_no'];
        }else{
            $costcenter = $row['project_no'];
        }

        $dt[$row['month']][$costcenter] = $row['hour']+$dt[$row['month']][$costcenter];
    }

    // echo json_encode($dt);
?>

    <div class="text-center">
        <a href="?mod=<?php echo $mod.'&page='.$page.'&type='.$type;?>">2022</a> | 
        <a href="?mod=<?php echo $mod.'&page='.$page.'&type='.$type;?>&year=2021">2021</a> | 
        <a href="?mod=<?php echo $mod.'&page='.$page.'&type='.$type;?>&year=2020">2020</a>
    </div>

    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
<thead>
<tr class="text-center">
<th><?php echo $year;?></th>
<?php foreach($tmo as $k => $v){echo '<th>'.$v.'</th>';}?>
<th>Total (hrs)</th>
</tr> </thead> <tbody>

<?php
if($_SESSION['ses_ulevel']==9){
    $rs = mysqli_query($conn,"SELECT DISTINCT account_no FROM `db_timesheet_detail` a join db_timesheet b WHERE a.tid = b.id and b.status = 2 and hour >0 and account_no not in (9001,9010,9013,9015)");

    while($row=mysqli_fetch_assoc($rs)){
        $total = 0;
?>
<tr class="text-right">
    <td><?php 

    if($row['account_no']!=''){
        echo $row['account_no'].' - '.$account_nos[$row['account_no']];
    }else{
        echo 'ไม่ระบุ';
    }

    ?></td>
    <?php for($i=1;$i<=12;$i++){?>
    <td><?php

        $mo = str_pad($i, 2, '0', STR_PAD_LEFT);
        $mo = "$year-$mo";

        if($dt[$mo][$row['account_no']]!=''){
            echo floatval($dt[$mo][$row['account_no']]);
            $total = $dt[$mo][$row['account_no']]+$total;   
            $tb_total[$mo][] = $dt[$mo][$row['account_no']];
        }

    ?></td>
    <?php }?>
    <td>
        <?php echo number_format($total,2);?>
    </td>
</tr>
<?php }
}

$rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project`");
while($row=mysqli_fetch_assoc($rs)){
    $projects[$row['code']] = $row['name'];
}

if($_SESSION['ses_ulevel']!=9){
    $sql = "SELECT DISTINCT project_no FROM `db_timesheet_detail` a join db_timesheet b WHERE a.tid = b.id and b.status = 2 and hour >0 and project_no != '' and account_no = 9001 and project_no IN (".implode(',',$pms).")";
    $rs = mysqli_query($conn,$sql);

}else{
    $rs = mysqli_query($conn,"SELECT DISTINCT project_no FROM `db_timesheet_detail` a join db_timesheet b WHERE a.tid = b.id and b.status = 2 and hour >0 and project_no != '' and account_no = 9001");

}

while($row=mysqli_fetch_assoc($rs)){
    $total = 0;
    ?>
<tr class="text-right">
    <td>
    <?php
        $proj_no = str_replace('TIME-','',$row['project_no']);
        echo $row['project_no'].' - '.$projects[$proj_no];
    ?>
    </td>
    <?php for($i=1;$i<=12;$i++){?>
    <td><?php

        $mo = str_pad($i, 2, '0', STR_PAD_LEFT);
        $mo = "$year-$mo";

        if($dt[$mo][$row['project_no']]!=''){
            echo floatval($dt[$mo][$row['project_no']]);           
  
            $total = $dt[$mo][$row['project_no']]+$total;
            $tb_total[$mo][] = $dt[$mo][$row['project_no']];
        }

    ?></td>
    <?php }?>
    <td>
        <?php echo number_format($total,2);?>
    </td>
</tr>
<?php }
if($_SESSION['ses_ulevel']>0){
?>
<tfoot style="font-weight:bold;">
    <tr class="text-right">
        <td>Total (hrs)</td>
        <?php 
                $total = 0;

        for($i=1;$i<=12;$i++){?>
        <td><?php

        $mo = str_pad($i, 2, '0', STR_PAD_LEFT);
        $mo = "$year-$mo";

        if(isset($dt[$mo])){
            echo '<a href="?mod=timesheet&page=summary&month='.$mo.'">'.number_format(array_sum($tb_total[$mo]),2).'</a>';
            $total = array_sum($tb_total[$mo])+$total;
        }

        ?></td>
        <?php }?>
        <td>
            <?php echo number_format($total,2);?>
        </td>
    </tr>
  </tfoot>
    <?php }?>
</table>    
    
    </div>
</div><?php
    }else{
        $rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project` ORDER BY `code` DESC");
        while($row=mysqli_fetch_assoc($rs)){
            $time2['TIME-'.$row['code']] = $row['name'];
        }    
?>

<?php if(isset($_GET['project'])){?>

    <h5><?php echo $_GET['project'].' - '.$time2[$_GET['project']].' - '.$emo[explode('-',$_GET['month'])[1]].' '.explode('-',$_GET['month'])[0]
        
        ?></h5>

    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
<?php    
    $rs = mysqli_query($conn,"SELECT a.date2,a.description,a.location,a.remark,a.hour,b.uid FROM `db_timesheet_detail` a join db_timesheet b WHERE a.`project_no` LIKE '".$_GET['project']."' and a.tid = b.id and b.status = 2 and b.month = '".$_GET['month']."'");

    $total = 0;
    echo '<thead><tr><th>Name</th><th>Date</th><th>Description</th><th>Location</th><th>Remark</th><th>Hour</th></tr><tbody>';

    while($row=mysqli_fetch_assoc($rs)){
        echo '<tr><td class="flex">'.$time1[$row['uid']][1].'</td><td>'.$row['date2'].'</td><td>'.$row['description'].'</td><td>'.$row['location'].'</td><td>'.$row['remark'].'</td><td class="text-center">'.floatval($row['hour']).'</td></tr>';

    $total = $row['hour']+$total;
}
    echo '</tbody><tfoot><tr><td class="text-right" colspan="5">Total</td><td class="text-center">'.$total.'</td></tr></tfoot>';
?>
</table>
<?php

}elseif($page=='report'){
    include "mod/$mod-$page.php";

}elseif($page!='summary'){
    

    if(isset($_GET['month'])){
        $month = $_GET['month'];
        
    }else{
        $month = $smonths[0];
    }

    $rs = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
    $row = mysqli_fetch_assoc($rs);
    $edits = json_decode($row['edits']);

    if($_SESSION['ses_ulevel']==9||in_array('timesheet',$edits)){
        $rs = mysqli_query($conn,"SELECT * FROM `db_$mod` WHERE month = '$month' and status > 1 ORDER BY id DESC");
        $tt = 'ID';
        $tf = 'id';

    }else{
        $rs = mysqli_query($conn,"SELECT * FROM `db_$mod` WHERE uid = '".$_SESSION['ses_uid']."' and status > 1 ORDER BY id DESC");
        $tt = 'Month';
        $tf = 'month';
    }

    ?>
    <div class="text-center">
        <a href="?mod=<?php echo $mod.'&page='.$page.'&type='.$type;?>">2022</a> | 
        <a href="?mod=<?php echo $mod.'&page='.$page.'&type='.$type;?>&year=2021">2021</a> | 
        <a href="?mod=<?php echo $mod.'&page='.$page.'&type='.$type;?>&year=2020">2020</a>
    </div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted"><?php echo $tt;?></span></th>                                            
                                            <th><span class="text-muted">รูป</span></th>
                                            <th><span class="text-muted">ชื่อ / ตำแหน่ง</span></th>
                                            <th><span class="text-muted">Attach</span></th>
                                            <th><span class="text-muted">Hrs</span></th>
                                            <th><span class="text-muted d-none d-sm-block">Update Date</span></th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
    while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row[$tf].'</small>
                                                        </td>
                                                        <td>
                                                            <div class="avatar-group ">
                                                                <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$time1[$row['uid']][1].'">
                                                                    <img src="';
                                                                    $file = 'uploads/employee/'.$row['uid'].'.jpg';
                                                                    if(file_exists($file)){
                                                                        echo $file;
                                                                    }else{
                                                                        echo '/assets/img/logo.png';
                                                                    }
                                                                    echo '" alt=".">
                                                                </a>
                                                            </div>                                                        
                                                        </td>
                                                        <td class="flex">';
                                                            echo $time1[$row['uid']][0].' ('.$time1[$row['uid']][1].')';
                                                            echo '<div class="item-except text-muted text-sm h-1x">
                                                            '.$time1[$row['uid']][2].'
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            ';
                                                            
                                                                echo '<a href="uploads/timesheet/'.$row['month'].'-'.$row['uid'].'-'.$row['id'].'.xlsx" class="btn btn-icon btn-rounded btn-white" title="XLSX">
                                                                <i data-feather="file-text"></i>
                                                            </a>';
                                                            
                                                            echo '
                                </span>
                                                        </td>';
                                                        echo '<td>
                                                        '.$row['hrs'].'
                                                        </td>
                                                        <td>
                                                        '.$row['created_at'].'
                                                        </td>

                                                    </tr>';
                                            }
                                        ?>                                        
                                                                                
                                    </tbody>
                                </table>
                            </div>
                                        <?php }else{?>
                                            
                                            <div class="page-content page-container" id="page-content">
                        <div class="padding">
                            <div class="row" data-plugin="apexcharts">

                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">                                        
                                            <?php echo $account_nos[$account_no].' ('.$account_no.')';?>
                                        </div>
                                        <div class="card-body">
                                            <?php if($account_no=='9001'){?>
                                            <div id="a-c-5">
                                            </div>
                                            <?php }?>

                                            <?php

    $projects = [];
    $rs = mysqli_query($conn,"SELECT b.id,a.id tid,a.uid,b.date2,b.project_no,b.description,b.location,b.remark,b.hour FROM `db_timesheet` a JOIN db_timesheet_detail b WHERE a.`month` = '$month' AND a.`status` = 2 and a.id = b.tid and b.account_no = '$account_no'");
    while($row=mysqli_fetch_assoc($rs)){
        $projects[$row['project_no']][$row['uid'].'-'.$row['tid']][] = [
            [
                'id' => $row['id'],
                'date' => $row['date2'],
                'description' => $row['description'],
                'location' => $row['location'],
                'remark' => $row['remark'],
                'hour' => $row['hour']
            ]
        ];
    }    

    if($account_no=='901x'){
        $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet_detail` a join db_timesheet b WHERE a.`account_no` LIKE '901%' and a.tid = b.id and b.status = 2 and b.month = '".$month."' ORDER BY account_no ASC");

        while($row=mysqli_fetch_assoc($rs)){
            $leaves[$row['account_no']][$row['uid']][] = [
                $row['date2'] => $row['description'],
            ];
        }

    }elseif($_SESSION['ses_ulevel']==9){
        $rs = mysqli_query($conn,"SELECT a.project_no,sum(a.hour) total_hour FROM `db_timesheet_detail` a join db_timesheet b where a.tid = b.id and b.`month` = '".$month."' AND b.`status` = 2 and account_no = $account_no GROUP BY a.project_no ORDER BY `total_hour` DESC");
        
    }else{
        $rs = mysqli_query($conn,"SELECT a.project_no,sum(a.hour) total_hour FROM `db_timesheet_detail` a join db_timesheet b where a.tid = b.id and b.`month` = '".$month."' AND b.`status` = 2 and account_no = $account_no and project_no IN (".implode(',',$pms).") GROUP BY a.project_no ORDER BY `total_hour` DESC");
    }

    $i = 1;

    $hide_tab = [9010,9013,9014,9015];

        if($account_no=='901x'){
            echo '<h6>Leave types</h6>';
        }else{
            echo '<h6>Projects in this month</h6>';    
        }
    ?>

    <div id="accordion" class="mb-4">
    
    <?php
    if($account_no=='901x'){
            foreach($leaves as $k => $v){
            $project_no = $k;
            ?>
            
    
                                            <div class="card mb-1">
                                                <div class="card-header no-border" id="heading<?php echo $i;?>">
                                                    <a href="#" data-toggle="collapse" data-target="#collapse<?php echo $i;?>" aria-expanded="false" aria-controls="collapse<?php echo $i;?>">
                                                        <!-- Total Hours เลข TIME ชือโปรเจ็คท์ Detail -  -->
                                                        <?php      
                                                                                                            
                                                            echo $project_no.' '.$leave_types[$project_no];
                                                            // echo '<i class="mx-2" data-feather="clock"></i>'.number_format($row['total_hour']).'hrs';
        
                                                        ?>
                                                    </a>
                                                    </div>
                                                <div id="collapse<?php echo $i;?>" class="collapse<?php if($project_no==''&&$account_no!='9001'){echo ' show';}?>" aria-labelledby="heading<?php echo $i;?>" data-parent="#accordion">
                                                    <div class="card-body">
                                                    <div class="mb-3">
                                            <ul class="nav nav-pills" id="myTab" role="tablist">
                                            <?php
                                                $t = 0;
                                                foreach($v as $eid => $days){
                                                    $total_hour = 0;
                                                    $ks = explode('-',$k);
                                                    
                                                    foreach($v as $b){
                                                        foreach($b as $d){
                                                            $total_hour = $total_hour+$d['hour'];
                                                        }
                                                    }
                                            ?>
                                                <li class="nav-item">
                                                    <a class="nav-link<?php if($t==0){echo ' active';}?>" id="<?php echo $project_no.$eid;?>-tab" data-toggle="tab" href="#b<?php echo $project_no.$eid;?>" role="tab" aria-controls="<?php echo $roww['id'];?>" aria-selected="true"><?php echo $time1[$eid][1];?> <?php echo count($days).' Days';?></a>
                                                </li>
                                                <?php 
                                        
                                        $t++;
                                        unset($detail);
    
                                    }?>
                                                <!-- <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                        <div class="tab-content mb-4">
    
    
    
    
                                        <?php
                                            $t = 0;
                                            foreach($v as $eid => $days){
                                                $total_hour = 0;
                                                $ks = explode('-',$k);
                                        ?>
                                            <div class="tab-pane fade<?php if($t==0){echo ' show active';}?>" id="b<?php echo $project_no.$eid;?>" role="tabpanel" aria-labelledby="<?php echo $project_no.$eid;?>-tab">
                                                <div class="row">
                                                    <div class="col-1">
                                                        <a href="#" class="avatar ajax w-64" data-toggle="tooltip" title="<?php echo $time1[$eid][1];?>"><img src="uploads/employee/<?php echo $eid;?>.jpg" alt="."></a><br>
                                                        <?php 
                                                        // echo '<a href="uploads/timesheet/'.$month.'-'.$k.'.xlsx"><i class="mx-2" data-feather="file-text"></i>';?></a>
                                                    </div>
                                                    <div class="col-11">
                                                        <table class="table table-sm table-striped">
                                                        <thead class="text-muted">
                                                            <tr>
                                                                <th><i class="mx-2" data-feather="calendar"></i>Date</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            foreach($days as $b){
                                                                foreach($b as $da => $db){
                                                                    echo '<tr>';
                                                                    echo '<td>'.$da.'</td>
                                                                    <td>'.$db.'</td>';
                                                                    echo '</tr>
                                                                    ';
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        </table>    
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $t++;}?>
    
    
                                            <!-- <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
                                                <p>Nisi, mattis sit sed dis suspendisse faucibus pellentesque at vitae quis turpis odio risus congue mi suspendisse sapien, cras cursus</p>
                                            </div>
                                            <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab">
                                                <p>Sit diam facilisis dictumst eu lectus felis sapien id imperdiet non cursus facilisis orci hendrerit nunc, id sed montes, id</p>
                                            </div> -->
                                        </div>    
                                                    </div>
                                                </div>
                                            </div>
    
    
    
                                            
                                                
            
            <?php
                                                        $i++;
                                                }
        
    }else{
        while($row=mysqli_fetch_assoc($rs)){
            $project_no = $row['project_no'];
        ?>
        

                                        <div class="card mb-1">
                                            <div class="card-header no-border" id="heading<?php echo $i;?>">
                                                <a href="#" data-toggle="collapse" data-target="#collapse<?php echo $i;?>" aria-expanded="false" aria-controls="collapse<?php echo $i;?>">
                                                    <!-- Total Hours เลข TIME ชือโปรเจ็คท์ Detail -  -->
                                                    <?php      
                                                    
                                                
                                                    if($time2["$project_no"]!=''){
                                                        echo $project_no.' '.$time2[$project_no].'<i class="mx-2" data-feather="clock"></i>'.number_format($row['total_hour']).'hrs';

                                                    }else{
                                                        if(!in_array($account_no,$hide_tab)){
                                                            echo $project_no.' (Unknown)<i class="mx-2" data-feather="clock"></i>'.number_format($row['total_hour']).'hrs';
                                                        }
                                                    }

                                                    ?>
                                                </a>
                                                </div>
                                            <div id="collapse<?php echo $i;?>" class="collapse<?php if($project_no==''&&$account_no!='9001'){echo ' show';}?>" aria-labelledby="heading<?php echo $i;?>" data-parent="#accordion">
                                                <div class="card-body">
                                                <div class="mb-3">
                                        <ul class="nav nav-pills" id="myTab" role="tablist">
                                        <?php
                                            $t = 0;
                                            foreach($projects[$project_no] as $k => $v){
                                                $total_hour = 0;
                                                $ks = explode('-',$k);
                                                
                                                foreach($v as $b){
                                                    foreach($b as $d){
                                                        $total_hour = $total_hour+$d['hour'];
                                                    }
                                                }
                                        ?>
                                            <li class="nav-item">
                                                <a class="nav-link<?php if($t==0){echo ' active';}?>" id="<?php echo $project_no.$ks[0];?>-tab" data-toggle="tab" href="#b<?php echo $project_no.$ks[0];?>" role="tab" aria-controls="<?php echo $roww['id'];?>" aria-selected="true"><?php echo $time1[$ks[0]][1];?> <?php 
                                                
                                                if(in_array($account_no,$hide_tab)){
                                                    echo count($v).' Days';
                                                }else{
                                                    echo $total_hour.' Hrs.';
                                                }
                                                ?></a>
                                            </li>
                                            <?php 
                                    
                                    $t++;
                                    unset($detail);

                                }?>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                                            </li> -->
                                        </ul>
                                    </div>
                                    <div class="tab-content mb-4">




                                    <?php
                                        $t = 0;
                                        foreach($projects[$project_no] as $k => $v){
                                            $total_hour = 0;
                                            $ks = explode('-',$k);
                                    ?>
                                        <div class="tab-pane fade<?php if($t==0){echo ' show active';}?>" id="b<?php echo $project_no.$ks[0];?>" role="tabpanel" aria-labelledby="<?php echo $project_no.$ks[0];?>-tab">
                                            <div class="row">
                                                <div class="col-1">
                                                    <a href="#" class="avatar ajax w-64" data-toggle="tooltip" title="<?php echo $time1[$ks[0]][1];?>"><img src="uploads/employee/<?php echo $ks[0];?>.jpg" alt="."></a><br>
                                                    <?php echo '<a href="uploads/timesheet/'.$month.'-'.$k.'.xlsx"><i class="mx-2" data-feather="file-text"></i></a>';?>
                                                </div>
                                                <div class="col-11">
                                                    <table class="table table-sm table-striped">
                                                    <thead class="text-muted">
                                                        <tr>
                                                            <th><i class="mx-2" data-feather="calendar"></i>Date</th>
                                                            <th><i class="mx-2" data-feather="map-pin"></i>Location</th>
                                                            <th>Description</th>
                                                            <th><i class="mx-2" data-feather="clock"></i>Hours</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        foreach($v as $b){
                                                            foreach($b as $d){
                                                                echo '<tr>';
                                                                echo '<td>'.$d['date'].'</td>
                                                                <td>'.$d['location'].'</td>
                                                                <td>'.$d['description'].'</td>
                                                                <td>'.$d['hour'].'</td>';
                                                                echo '</tr>
                                                                ';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    </table>    
                                                </div>
                                            </div>
                                        </div>
                                        <?php $t++;}?>


                                        <!-- <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
                                            <p>Nisi, mattis sit sed dis suspendisse faucibus pellentesque at vitae quis turpis odio risus congue mi suspendisse sapien, cras cursus</p>
                                        </div>
                                        <div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab">
                                            <p>Sit diam facilisis dictumst eu lectus felis sapien id imperdiet non cursus facilisis orci hendrerit nunc, id sed montes, id</p>
                                        </div> -->
                                    </div>







                                                





                                                </div>
                                            </div>
                                        </div>



                                        
                                            
        
        <?php
                                                    $i++;
                                            }
                                        }
                                        ?>                                        
                                        

                                        
                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div></div></div>
                                            
                                            <?php }}?>