<div style="height:60px;">
    <div class="avatar-group float-right">
        <?php

        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"training\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        echo implode(' ',$ams);
        ?>
    </div>
</div>

<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $rs = mysqli_query($conn,"SELECT * FROM `db_recruit` WHERE `id` = $id AND status > 0");
        $row = mysqli_fetch_assoc($rs);

        $name = $row['name'];
        $nick = $row['nick'];
        $dob = webdate($row['dob']);
        $position = $row['position'];
        $file = $row['file'];

    // }else{
    //     $id = $_SESSION['ses_uid'];
    }

    // $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = $id");
    // $row = mysqli_fetch_assoc($rs);


    if($_GET['alert']=='created'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success! Your cover letter number is <b>TIME'.substr($row['date'],0,4).'-'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below when document signed.</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php
                                                
                                                // if(isset($id)){
                                                    // echo 'TIME'.substr($row['date'],0,4).'-'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                // }else{
                                                    // echo 'สร้างโปรเจ็คท์ใหม่';

                                                    // $yr = date(Y);

                                                    // $rs = mysqli_query($conn,"SELECT `code` FROM `db_project` WHERE `code` LIKE '$yr%' AND `status` != 0 ORDER BY `code` DESC LIMIT 1");
                                                    // $row = mysqli_fetch_assoc($rs);
                                                    // $cnt = mysqli_num_rows($rs);

                                                    // if($cnt!=0){
                                                    //     $code = $row['code']+1;
                                                    // }else{
                                                    //     $code = $yr.'01';
                                                    // }                                                    
                                                // }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label>ชื่อหลักสูตร</label>
                                                        <input type="text" class="form-control" name="title" value="<?php echo $title;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ค่าธรรมเนียมการอบรม</label>
                                                        <input type="text" class="form-control" name="fee" value="<?php echo $fee;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>วันที่อบรม</label>
                                                        <div class='input-group input-daterange mb-3' data-plugin="datepicker" data-option="{}">
                                                            <input type='text' class="form-control" name="train_date_from">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">to</span>
                                                            </div>
                                                            <input type='text' class="form-control" name="train_date_to">
                                                        </div>
                                                    </div>  
                                                    <div class="form-group col-sm-6">
                                                        <label>ช่องทางการชำระเงิน</label>
                                                        <input type="text" class="form-control" name="payment" value="<?php echo $payment;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>กำหนดการชำระเงิน</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="payment_due" value="<?php echo $payment_due;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                                                        <!-- <small>*วันสิ้นสุดการทำงานอย่างน้อย 1 เดือนนับจากวันที่ยื่นผ่านระบบ</small> -->
                                                    </div>  
                                                    <div class="form-group col-sm-6">
                                                        <label>วิทยากร</label>
                                                        <input type="text" class="form-control" name="trainer" value="<?php echo $trainer;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>สถานที่อบรม</label>
                                                        <input type="text" class="form-control" name="place" value="<?php echo $place;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>รายละเอียดหลักสูตร</label>
                                                        <textarea class="form-control" rows="7" name="detail"><?php echo $detail;?></textarea>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Upload ไฟล์ที่เกี่ยวข้อง</label><br>
                                                        <input type="file" name="file" id="">
                                                    </div>
                                                    <!-- <div class="form-group col-sm-6">
                                                        <label>Transcript</label><br>
                                                        <input type="file" name="transcript" id="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ID Card</label><br>
                                                        <input type="file" name="idcard" id="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Book Bank</label><br>
                                                        <input type="file" name="bookbank" id="">
                                                    </div> -->
                                                </div>
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="training">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>