<?php

if(isset($_GET['year'])){
    $year = $_GET['year'];

}else{
    $year = date(Y);
}

// $hrs["$year-01"][] = $hrs["$year-02"][] = $hrs["$year-03"][] = $hrs["$year-04"][] = $hrs["$year-05"][] = $hrs["$year-06"][] = $hrs["$year-07"][] = $hrs["$year-08"][] = $hrs["$year-09"][] = $hrs["$year-10"][] = $hrs["$year-11"][] = $hrs["$year-12"][] = 0;

$last_month = "$year-01";
if(isset($_GET['uid'])){
    $uid = $_GET['uid'];
}else{
    $uid = $_SESSION['ses_uid'];
}

if($year<2022){
    $rs = mysqli_query($conn,"SELECT a.id,b.month,a.hour,b.created_at FROM `db_timesheet_detail` a join db_timesheet b where a.tid = b.id and b.status = 2 and (a.hour >0 or a.hour_dec > 0) AND b.uid = ".$_SESSION['ses_uid']." and b.month like '$year-%' ORDER BY `b`.`created_at` DESC");
    while($row=mysqli_fetch_assoc($rs)){
        $mo = $row['month'];
        $hrs[$mo][] = $row['hour'];
        if(!isset($update[$mo])){
            $update[$mo] = $row['created_at'];
        }

        if($mo>$last_month){
            $last_month = $mo;
        }
    }

}else{
    $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet2` WHERE status = 2 AND `uid` = $uid ORDER BY `created_at` DESC");
    while($row=mysqli_fetch_assoc($rs)){
        $mo = substr($row['date'],0,7);
        $hrs[$mo][] = $row['hrs'];
        if(!isset($update[$mo])){
            $update[$mo] = $row['created_at'];
        }

        if($mo>$last_month){
            $last_month = $mo;
        }
    }
    
}

$rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
$row = mysqli_fetch_assoc($rs);

$id = $row['id'];
$name = $row['name'];
$position = $row['position'];
$code = $row['code'];
$level = $row['level'];
$edits = json_decode($row['edits']);

if($uid!=$_SESSION['ses_uid']){
    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = ".$uid);
    $row = mysqli_fetch_assoc($rs);
    
    $id = $row['id'];
    $name = $row['name'];
    $position = $row['position'];
    $code = $row['code'];
}

if($level==9||in_array('timesheet2',$edits)){
    echo '<div style="height:60px;"><div class="btn-group float-right">
    <a href="?mod=timesheet2" class="btn btn-outline-primary active">My Time Sheet</a>
    <a href="?mod=timesheet2-summary" class="btn btn-outline-primary">Project Summary</a>
    <a href="?mod=timesheet2-overall" class="btn btn-outline-primary">Overall Summary</a>
</div></div>';
}
?>

<div class="row">
    <div class="col-lg-9">
    <div class="card" data-sr-id="1" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h1>My Time Sheet</h1>

</div><div class="col-5">
    <form>
        <input type="hidden" name="mod" value="timesheet2">
        <?php if($level==9||in_array('timesheet2',$edits)){?>
        <select name="uid"><option value="">เลือกคน</option><?php

        $rs = mysqli_query($conn,"SELECT id,code,nick FROM `db_employee` WHERE id > 2 and `end_date` IS NULL ORDER BY `code` ASC");
        while($row=mysqli_fetch_assoc($rs)){
            echo '<option value="'.$row['id'].'"';
                    if($uid==$row['id']){
                        echo ' selected';
                    }
                    echo '>'.str_pad($row['code'], 3, '0', STR_PAD_LEFT).' '.$row['nick'].'</option>';
        }
                                
                ?></select><?php }?>
                <select name="year"><option value="">เลือกปี</option><?php
                
                for($i=date(Y);$i>=2020;$i--){
                    echo '<option';
                    if($year==$i){
                        echo ' selected';
                    }
                    echo '>'.$i.'</option>';
                }
                
                ?></select>
                <input type="submit" value="ดู">
</form>
            </div>
            <div class="col-1">
                <!-- <a href="/excel/?mod=timesheet2-full&year=<?php echo $year;?>" class="btn btn-sm btn-white">Excel</a> -->
            </div>
        </div>
        <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <td>เดือน</td>
                            <td>Total Hrs.</td>
                            <td>Date Update</td>
                            <td>Edit</td>
                            <td>Detail</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
foreach($emo as $k => $v){
    echo '<tr class="text-center">
    <td>'.$v.'</td>
    <td>'.array_sum($hrs["$year-$k"]).'</td>
    <td>'.$update["$year-$k"].'</td>
    <td>';
    if($year>2021){
        echo '<a href="?mod=timesheet2-edit&uid='.$uid.'&mo='.$year.'-'.$k.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit mx-2"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></a>';
    }
    echo '</td>
    <td>
        <a href="?mod=timesheet2-detail&uid='.$uid.'&mo='.$year.'-'.$k.'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart mx-2"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg></a>
    </td>
</tr>';
}

                        ?>
                    </tbody>
                </table>
</div></div>

    </div>
    <div class="col-lg-3 text-center">
    <div class="card" data-sr-id="2" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <?php
        
        echo '<a href="#">
                    <div class="avatar w-64 mx-auto">
        <img src="/uploads/employee/'.$id.'.jpg" alt=".">
        <i class="on"></i>
        </div>
                </a>
        
                <h5 class="mt-3 text-center text-primary">
                    '.$name.'
                </h5>'.$position.'<br>
                ID: TIME'.str_pad($code, 3, '0', STR_PAD_LEFT).'
                
                <h5 class="my-4 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><br>
                ';
                                
                $dateObj   = DateTime::createFromFormat('!m', substr($last_month,5,2));
                echo $dateObj->format('F');

                echo '</h5>
                
                Total Work Hours
                <h3 class="mb-3 text-primary">';
                
                $sum_last_month = array_sum($hrs[$last_month]);
                $manday = $sum_last_month/8;

                echo $sum_last_month;

                echo '</h3>
                    
                Total Work Hours/week
                <h3 class="mb-3 text-primary">';
                echo $sum_last_month/4;
                echo '</h3>
                
                Total Man Day
                <h3 class="mb-5 text-primary">'.$manday.'</h3>';
        
        ?>
        <a href="?mod=timesheet2-full&uid=<?php echo $uid;?>&year=<?php echo $year;?>">See Full Report ></a><br>
        </div>
</div>
    </div>
</div>