<?php
    $statuses = [
        1 => ['Pending','info'],
        2 => ['Declined','danger'],
        3 => ['Approved','warning'],
        4 => ['Successful Payment','primary'],
    ];

    if(isset($_GET['rid'])){
        $rid = $_GET['rid'];

        $rs = mysqli_query($conn,"SELECT * FROM `db_training_register` WHERE `id` = $rid AND `status` > 0");
        $row = mysqli_fetch_assoc($rs);

        $uid = $row['uid'];
        $id = $row['tid'];
        $rstatus = $row['status'];

    }else{
        $uid = $_SESSION['ses_uid'];
        $id = $_GET['id'];
    }

$sql = "SELECT a.uid,a.status,b.name,b.position FROM `db_training_register` a join db_employee b WHERE a.uid = b.id and a.`uid` = $uid AND a.tid = $id AND a.`status` > 0";
// echo $sql;
$rs = mysqli_query($conn,$sql);    
if(mysqli_num_rows($rs)>0){
    $row = mysqli_fetch_assoc($rs);

    $e_uid = $row['uid'];
    $e_name = $row['name'];
    $e_position = $row['position'];
    $e_status = $row['status'];
    // $id = $row['tid'];    
}

$rs = mysqli_query($conn,"SELECT * FROM `db_training` WHERE `id` = $id AND `status` = 2");    
$row = mysqli_fetch_assoc($rs);

$title = $row['title'];
$fee = $row['fee'];
$payment_due = webdate($row['payment_due']);
$date_payment = $row['date_payment'];
$payment = $row['payment'];
$trainer = $row['trainer'];
$train_date_from = webdate($row['train_date_from']);
$train_date_to = webdate($row['train_date_to']);
$place = $row['place'];

?><div class="row">
    <div class="col-md-4">        
        <?php
        
        if(isset($e_status)){
            echo '<a href="#">
            <div class="avatar w-128 mx-auto">
<img src="/uploads/employee/'.$e_uid.'.jpg" alt=".">
<i class="on"></i>
</div>
        </a>

        <div class="mt-3 text-center">
            ชื่อผุ้อบรม: '.$e_name.'<br>
            ตำแหน่ง: '.$e_position.'<br>';

            // if(isset($e_status)){
                // echo 'status: '.$e_status;
                echo '<span class="badge badge-'.$statuses[$e_status][1].' text-uppercase">'.$statuses[$e_status][0].'</span>';

                if(isset($rstatus)&&$rstatus>3){
                    echo '<br><br><form action="action.php" method="post" enctype="multipart/form-data"><input type="hidden" name="mod" value="training"><input type="hidden" name="id" value="'.$rid.'">
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Slip</span>
                        </div>
                        <div class="custom-file" style="max-width:200px;">
                            <input type="file" name="slip_file" class="custom-file-input" id="slip_file">
                            <label class="custom-file-label" for="slip_file">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <input type="submit" value="Upload" class="btn btn-outline-secondary">
                        </div>
                    </div>
                    
                    </form>';
                }


            // }

            echo '</div>';
        }
        
        ?>
    </div>
    <div class="col-md-8">
        <h1><?php echo $title;?></h1><br>
        ค่าธรรมเนียมการอบรม: <?php echo number_format($fee,2);?> บาท กำหนดชำระภายในวันที่ <?php echo $payment_due;?><br>
        อบรมวันที่ <?php echo $train_date_from.' - '.$train_date_to;?><br>
        <br>
        รายละเอียดการชำระเงิน: <?php echo $payment;?><br>
        <!-- ช่องทางการชำระเงิน โอนผ่านบัญชี xx เลขที่บัญชี xx<br><br> -->
        <br>
        วิทยากร:<br>
        <?php echo $trainer;?><br>
        <br>
        สถานที่อบรม<br>
        <?php echo $place;?>

        <div class="mt-3">
            <?php
            
            if(!isset($e_status)){
                echo '<a href="action.php?mod=training-register&id='.$id.'" class="btn btn-primary">Register</a>';
            }

            ?>
            
        </div>
    </div>
</div>