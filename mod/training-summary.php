<?php

    if(isset($_GET['employee'])){
        $employee = $_GET['employee'];
    }

// $rs = mysqli_query($conn,"SELECT `id`, `name` FROM `db_employee`");
// while($row=mysqli_fetch_assoc($rs)){
//     $time1[$row['id']] = $row['name'];
// }

?><div class="btn-group float-right">
    <a href="?mod=training" class="btn btn-outline-primary">Upcoming Courses</a>
    <a href="?mod=training-my" class="btn btn-outline-primary">My Registration</a>
    <a href="?mod=training-register" class="btn btn-outline-primary">Registration Status</a>
    <a href="?mod=training-summary" class="btn btn-outline-primary active">Summary Report</a>
</div>

<h3 class="mb-5">Summary Report</h3>

<?php
    if(isset($_GET['years'])&&isset($_GET['months'])){
        foreach($_GET['years'] as $v){
            foreach($_GET['months'] as $vv){
                $s[] = "b.train_date_from LIKE '$v-$vv-%'";
            }
        }

    }elseif(isset($_GET['years'])){
        foreach($_GET['years'] as $v){
            $s[] = "b.train_date_from LIKE '$v-%'";
        }

    }elseif(isset($_GET['months'])){
        foreach($_GET['months'] as $v){
            $s[] = "b.train_date_from LIKE '%-$v-%'";
        }

    }

    $sq = ' and ('.implode(' OR ',$s).')';

    $pass = $fail = $t1 = $t2 = $t3 = 0;

    $su = '';
    if(isset($_GET['employee'])){
        $su = ' and a.`uid` = '.$_GET['employee'];
    }

    $sql = "SELECT a.*,b.title,b.train_date_from FROM `db_training_register` a join db_training b WHERE a.tid = b.id$su$sq";
    // echo $sql;
    $rs = mysqli_query($conn,$sql);
    // $cnt = mysqli_num_rows($rs);

    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['id']] = [
            $row['title'],
            $row['train_date_from'],
            // $row['start_date'],
            // $row['status'],
        ];
        
        if($row['interview_status3']==1){
            $t3 = $t3+1;

        }elseif($row['interview_status2']==1){
            $t2 = $t2+1;

        }elseif($row['interview_status1']==1){
            $t1 = $t1+1;
        }
        
        if($row['status']==4){
            $pass = $pass+1;
        }else{
            $fail = $fail+1;
        }
    }

    $passes = [
        1 => $t1,
        2 => $t2,
        3 => $t3,
    ];

?>
<div class="card">
    <div class="card-header">
        <strong>Summary Report</strong>
    </div>
    <div class="card-body">
        <form action="">
            <input type="hidden" name="mod" value="training-summary">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">เลือกรายชื่อ</label>
                <div class="col-lg-4">
                    <select name="employee" class="form-control" required>
                        <option value="">เลือก..</option>
                        <?php

                        $rs = mysqli_query($conn,"SELECT DISTINCT a.`uid`,b.code,b.name FROM `db_training_register` a join db_employee b where a.uid = b.id ORDER BY `b`.`name` ASC");
                        while($row=mysqli_fetch_assoc($rs)){
                            echo '<option value="'.$row['uid'].'"';
                            if($employee==$row['uid']){
                                echo ' selected';
                                $e_name = $row['name'];
                            }
                            echo '>'.$row['name'].'</option>';
                        }


                            // for($i=2020;$i<=date(Y);$i++){
                            //     if(in_array($i,$_GET['years'])){
                            //         $sl = ' selected';
                            //     }else{
                            //         $sl = '';
                            //     }
                            // }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">เลือกปี</label>
                <div class="col-lg-4">
                    <select name="years[]" multiple class="form-control">
                        <?php
                            for($i=2022;$i<=date(Y);$i++){
                                if(in_array($i,$_GET['years'])){
                                    $sl = ' selected';
                                }else{
                                    $sl = '';
                                }
                                echo '<option '.$sl.'>'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">เลือกเดือน</label>
                <div class="col-lg-4">
                    <select name="months[]" multiple class="form-control">
                        <?php
                        
                            foreach($tmonth as $k => $v){
                                if(in_array($k,$_GET['months'])){
                                    $sl = ' selected';
                                }else{
                                    $sl = '';
                                }
                                echo '<option value="'.$k.'"'.$sl.'>'.$v.'</option>';
                            }

                        ?>
                        
                    </select>
                </div>
            </div>
            <input type="submit" value="Filter">
        </form>
    </div>
</div>

<?php if(isset($_GET['years'])||isset($_GET['months'])){?>
<div class="row row-sm sr">
    <div class="col-md-4">        
        <?php        
                    echo '<a href="#">
                    <div class="avatar w-64 mx-auto">
        <img src="/uploads/employee/'.$employee.'.jpg" alt=".">
        <i class="on"></i>
        </div>
                </a>
        
                <div class="mt-3 text-center">
                    ชื่อผุ้อบรม: '.$e_name.'<br>
                </div>';

                $v = count($dt);
        // foreach($passes as $k => $v){
            echo '<div class="card flex mt-3">
            <div class="card-body text-center">
                <small class="text-muted">จำนวนคอร์สที่เรียน</small>
                <div class="text-primary mt-2" style="font-size:80px;" data-plugin="countTo" data-option="{
                from: 0,
                to: '.$v.',
                refreshInterval: 15,
                speed: 500,
                formatter: function (value, options) {
                  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
                }"></div>
            </div>
        </div>';
        // }
        ?>
        
    </div>
    <div class="col-md-2">
        <div class="card flex">
            <div class="card-body text-center">
                <small>ปี</small>
                <h2 class="text-primary mt-3">
                    <?php
                    if(isset($_GET['years'])){
                        foreach($_GET['years'] as $v){
                            echo $v.'<br>';
                        }
                    }else{
                        echo 'All';
                    }
                        
                    ?>
                </h2>
            </div>
        </div>

        <div class="card flex">
            <div class="card-body text-center">
                <small>เดือน</small>
                <h2 class="text-primary mt-3">
                    <?php
                    if(isset($_GET['months'])){
                        foreach($_GET['months'] as $v){
                            echo $emo[$v].'<br>';
                        }
                    }else{
                        echo 'All';
                    }
                    ?>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">

                                    <div class="card">
                                        <div class="p-3-4">
                                            <div class="d-flex">
                                                <div>
                                                    <div>รายละเอียดคอร์สที่เรียน</div>
                                                    <!-- <small class="text-muted">Total: 230</small> -->
                                                </div>
                                                <span class="flex"></span>
                                                <div>
                                                    <a href="/excel/?<?php echo $_SERVER['QUERY_STRING'];?>" class="btn btn-sm btn-white">Excel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-theme v-middle m-0">
                                            <tbody>
<?php
    $i = 0;
    // while($row=mysqli_fetch_assoc($rs)){
    foreach($dt as $k => $v){
        $i++;
        echo '<tr class=" " data-id="'.$k.'">
        <td style="min-width:30px;text-align:center">
            '.$i.'
        </td>
        <td class="flex">'.$v[0].'</td>
        <td class="flex">'.webdate($v[1]).'</td>
    </tr>';
    }
?>                                                
                                                

                                            </tbody>
                                        </table>
                                    </div>
    </div>
</div>
<?php }?>