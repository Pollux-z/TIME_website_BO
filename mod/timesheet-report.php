<?php
    $rs = mysqli_query($conn,"SELECT * FROM `db_project` WHERE `status` > 0 ORDER BY `db_project`.`code` DESC");
    while($row=mysqli_fetch_assoc($rs)){
        $projects[$row['code']] = $row['name'];
    }

    $rs = mysqli_query($conn,"SELECT DISTINCT `month` FROM `db_timesheet` WHERE `status` > 0 ORDER BY `db_timesheet`.`month` DESC");
    while($row=mysqli_fetch_assoc($rs)){
        $pmonths[] = $row['month'];
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` ORDER BY `db_employee`.`code` ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $emps[$row['id']] = [
            $row['code'],
            $row['nick'],
        ];
    }


?>

<div class="form-group bg-light p-3">
<form action="">
    <input type="hidden" name="mod" value="timesheet">
    <input type="hidden" name="page" value="report">

    <select name="pcode" and id="pcode">
        <option value="">- Project -</option>
        <?php
            $slp[$_GET['pcode']] = ' selected';
        
            foreach($projects as $k => $v){
                if(!isset($slp["TIME-$k"])){
                    $slp["TIME-$k"] = '';
                }                
                echo '<option value="TIME-'.$k.'"'.$slp["TIME-$k"].'>TIME-'.$k.' '.$v.'</option>';
            }

        ?>
    </select>

<select name="account_no" and id="account_no">
    <option value="">- Account Number -</option>
    <?php
        $sla[$_GET['account_no']] = ' selected';

        $pans = [
            9001 => 'Consulting',
            9002 => 'Project Support',
            9003 => 'BD (with project no.)',
            9004 => 'BD (without project no.)',
            9005 => 'Business Operation',
            9006 => 'MarTech',
            9007 => 'Training, Education',
            9008 => 'Product Development',
            9009 => 'Corporate Development',
        ];
    
        foreach($pans as $k => $v){
            if(!isset($sla[$k])){
                $sla[$k] = '';
            }
            echo '<option value="'.$k.'"'.$sla[$k].'>'.$k.' '.$v.'</option>';
        }

    ?>
</select>

    <select name="time1" and id="time1">
        <option value="">- Name -</option>
        <?php
        $sln[$_GET['time1']] = ' selected';
        
        foreach($emps as $k => $v){
            if(!isset($sln[$k])){
                $sln[$k] = '';
            }
            echo '<option value="'.$k.'"'.$sln[$k].'>TIME-'.str_pad($v[0], 3, '0', STR_PAD_LEFT).' '.$v[1].'</option>';
        }

        ?>
    </select>
    
    <input type="submit" value="Search"><br>

<!-- <select name="month" id="month" id="select2-multiple" class="form-control" multiple>
    <option value="">- Month -</option> -->
    <?php
        $month = $_GET['months'];
        foreach($month as $v){
            $slm[$v] = ' checked';            
        }
    
        foreach($pmonths as $v){
            if(!isset($slm[$v])){
                $slm[$v] = '';
            }
            // echo '<option value="'.$v.'"'.$slm[$v].'>'.$v.'</option>';
            echo '<div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox'.$v.'" name="months[]" value="'.$v.'"'.$slm[$v].'>
            <label class="form-check-label" for="inlineCheckbox'.$v.'">'.$v.'</label>
        </div>';
        }

    ?>
<!-- </select> -->
</form>
    </div>

<!-- <div class="avatar-group "> -->
<?php 
    if($_GET['pcode']!=''){
        $rs = mysqli_query($conn,"SELECT DISTINCT uid FROM `db_timesheet` a join db_timesheet_detail b WHERE a.`status` > 0 and a.id = b.tid and project_no like '".$_GET['pcode']."'");
        while($row=mysqli_fetch_assoc($rs)){
            $pimgs[] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$emps[$row['uid']][1].'">
            <img src="uploads/employee/'.$row['uid'].'.jpg" alt=".">
        </a>';
            $persons[] = $emps[$row['uid']][1];
        }

        $sqp = " and project_no like '".$_GET['pcode']."'";

    }elseif($_GET['months']==''&&$_GET['account_no']==''&&$_GET['time1']==''){
        $sqp = " and project_no like 'jomm'";
        
    }else{
        $sqp = '';
    }

    if($month!=''){
        foreach($month as $v){
            $sqms[] = "month = '$v'";            
        }        
        $sqm = " and (".implode(' OR ',$sqms).")";
    }else{
        $sqm = '';
    }

    if($_GET['account_no']!=''){
        $sqa = " and account_no = '".$_GET['account_no']."'";
    }else{
        $sqa = '';
    }

    if($_GET['time1']!=''){
        $sqt = " and uid like '".$_GET['time1']."'";
    }else{
        $sqt = '';
    }

    $ttlhrs = 0;
    $ttldays = 0;

    // $sql = "SELECT *  FROM `db_timesheet` a join db_timesheet_detail b WHERE a.`status` = 2 and a.id = b.tid and account_no != ''$sqp$sqm$sqa$sqt order by month";
    $sql = "SELECT *  FROM `db_timesheet` a join db_timesheet_detail b WHERE a.`status` = 2 and a.id = b.tid$sqp$sqm$sqa$sqt order by month";
    echo '<!--'.$sql.'-->';
    $rs = mysqli_query($conn,$sql);

    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['uid']] = [
            'project_no' => $row['project_no'],
            // 'account_no' => $row['account_no'],
            // 'month' => $row['month'],
            // 'date' => $row['date2'],
            // 'hour' => $row['hour'],
        ];

        if(!isset($project_nos[$row['uid']])){
            $project_nos[$row['uid']] = [];
        }
        if(!isset($months[$row['uid']])){
            $months[$row['uid']] = [];
        }
        if(!isset($account_nos[$row['uid']])){
            $account_nos[$row['uid']] = [];
        }
        if(!isset($days[$row['uid']])){
            $days[$row['uid']] = 0;
        }
        if(!isset($hours[$row['uid']])){
            $hours[$row['uid']] = 0;
        }

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

    // echo '</div>'.

    // echo implode(', ',$persons);
?>

<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
    <tr>
        <td>Project</td>
        <td>Account Number</td>
        <td>Name</td>
        <td>Month</td>
        <td>Hours</td>
        <td>Day work</td>
    </tr>
    <?php

    // while($row=mysqli_fetch_assoc($rs)){
        // <a href="?mod=timesheet&month='.$v['month'].'&account_no='.$v['account_no'].'" target="_blank">
    $ttldayc = 0;
    foreach($dt as $k => $v){
        sort($project_nos[$k]);
        // foreach($project_nos[$k]){
        //     <a href="?mod=timesheet&page=report&pcode='.$row['project_no'].'">'.$row['project_no'].'</a>
        // }
        sort($account_nos[$k]);
        // foreach($u as $v){
            echo '<tr>
        <td>'.implode(', ',$project_nos[$k]).'</td>
        <td>'.implode(', ',$account_nos[$k]).'</td>
        <td>
            <div class="avatar-group ">
                <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$emps[$k][1].'">
                    <img src="uploads/employee/'.$k.'.jpg" alt=".">
                </a>
            </div> 
    '.$emps[$k][1].'</td>
        <td>
        '.implode(', ',$months[$k]).'
        </td>
        <td>'.$hours[$k].'</td><td>';
        // <td>'.$days[$k].'</td>
        $dayc = $hours[$k]/8;
        echo number_format($dayc,1);
        echo '</td>
    </tr>';
    // $ttlhrs = $v['hour']+$ttlhrs;
    // $ttldays = $days[$k]+$ttlhrs;
        // }
        $ttldayc = $ttldayc + $dayc;
    }

    ?>
    <tr>
        <td>Total</td>
        <td></td>
        <td><?php echo count($dt);?></td>
        <td></td>
        <td><?php echo number_format($ttlhrs,2);?></td>
        <td><?php echo number_format($ttldayc,1);?></td>
    </tr>
</table>
<?php 
// echo json_encode($dt);?>