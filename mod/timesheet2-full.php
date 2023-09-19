<?php

if(isset($_GET['year'])){
    $year = $_GET['year'];

}else{
    $year = date(Y);
}

if(isset($_GET['uid'])){
    $uid = $_GET['uid'];
}else{
    $uid = $_SESSION['ses_uid'];
}

$rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = ".$uid);
$row = mysqli_fetch_assoc($rs);

$id = $row['id'];
$name = $row['name'];
$position = $row['position'];
$code = $row['code'];

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
    $sum_hour = $sum_manday = 0;
    $hour = $manday = [
        "$year-01" => 0,
        "$year-02" => 0,
        "$year-03" => 0,
        "$year-04" => 0,
        "$year-05" => 0,
        "$year-06" => 0,
        "$year-07" => 0,
        "$year-08" => 0,
        "$year-09" => 0,
        "$year-10" => 0,
        "$year-11" => 0,
        "$year-12" => 0,
    ];
    $rs = mysqli_query($conn,"SELECT date,sum(hrs) sum_hrs FROM `db_timesheet2` WHERE date like '$year-%' and `uid` = $uid AND `status` > 0 GROUP BY month(date)");
    while($row=mysqli_fetch_assoc($rs)){
        $hour[substr($row['date'],0,7)] = $row['sum_hrs'];
        $manday[substr($row['date'],0,7)] = $row['sum_hrs']/8;        
        $sum_hour = $sum_hour+$row['sum_hrs'];        
    }
    $sum_manday = $sum_hour/8;

    $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet2` WHERE `uid` = $uid ORDER BY `created_at` DESC");
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

?>
<div class="text-right"><a href="/excel/?mod=timesheet2-full&year=<?php echo $year;?>"
        class="btn btn-sm btn-white">Excel</a>
</div>
<h1>Full Report</h1>

<div class="row">
    <div class="col-md-8">
        <!--Total Work Hours<br>
        January - December <?php echo $year;?><br>
        [bar graph]<br><?php

        // echo json_encode($hour).'='.$sum_hour;

        // $sum_hour = 0;
                        
                        // foreach($emo as $k => $v){
                        //     echo '<tr class="text-center">
                        //     <td>'.$v.'</td>
                        //     <td>'.array_sum($hrs["$year-$k"]).'</td>
                        // </tr>';

                        //     $sum_hour = array_sum($hrs["$year-$k"])+$sum_hour;
                        // }
                        
                                                ?>





                        -->
    </div>
    <div class="col-md-4 text-center">
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
    ID: TIME'.str_pad($code, 3, '0', STR_PAD_LEFT);

        ?>

<form>
        <input type="hidden" name="mod" value="timesheet2-full">
        <input type="hidden" name="uid" value="<?php echo $uid;?>">
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
</div>


<div class="row mt-3">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                Total Work Hours & Man Day <?php echo $year;?>
            </div>
            <div class="card-body" style="height: 240px">
                <canvas id="chart-bar-bar" data-plugin="chartjs">
                </canvas>
            </div>
        </div>
    </div>
    <div class="col-md-2 text-center">
        
        <div class="card mb-4" data-sr-id="1"
            style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
            <div class="card-body">
                <small>จำนวนชั่วโมงการทำงานตลอดทั้งปี</small>
                <h2 class="mt-2"><?php echo $sum_hour;?></h2>
            </div>
        </div>

        <div class="card" data-sr-id="1"
            style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
            <div class="card-body">
                <small>จำนวนวันทำงานตลอดทั้งปี</small>
                <h2 class="mt-2"><?php echo $sum_manday;?></h2>
            </div>
        </div>

        <div class="card" data-sr-id="1"
            style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
            <div class="card-body">
                <small>จำนวนวันหยุดตลอดทั้งปี</small>
                <h2 class="mt-2"><?php 
                
                $rs = mysqli_query($conn,"SELECT SUM(a.half) days FROM `db_timeoff_date` a join db_timeoff b where a.tid = b.id and b.uid = ".$_SESSION['ses_uid']." and a.date like '$year-%'");
                $row = mysqli_fetch_assoc($rs);

                echo $row['days'];
                
                ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Project Work (9001)
            </div>
            <div class="card-body" style="height: 240px">
                <canvas id="chart-doughnut">
                </canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">       
        
    <div class="card">
                                        <table class="table table-theme v-middle m-0">
                                            <thead>
                                                <th>รายละเอียด</th>
                                                <th>Total Hrs.</th>
                                            </thead>                                            
                                            <tbody>
                                            <?php
        
        $sql = "SELECT id,code,name FROM `db_project`";
        $rs = mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($rs)){
            $ptitle["TIME-".$row['code']] = $row['name'];
        }

        $rs = mysqli_query($conn,"SELECT project_no,sum(hrs) sum_hrs FROM `db_timesheet2` WHERE date like '$year-%' and `uid` = $uid AND `status` > 0 and project_no != '' and account_no = 9001 GROUP by project_no ORDER BY `sum_hrs` DESC");
        while($row=mysqli_fetch_assoc($rs)){
            echo '<tr class=" " data-id="'.$row['project_no'].'">
        <td class="flex">'.$row['project_no'].' '.$ptitle[$row['project_no']].'</td>
        <td>
            <span class="item-amount d-sm-block">'.$row['sum_hrs'].'</span>
        </td>
    </tr>';

        }

            
        ?>




                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
    </div>
</div>