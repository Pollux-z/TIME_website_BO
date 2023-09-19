<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $rs = mysqli_query($conn,"SELECT * FROM `db_resign` WHERE `id` = $id");
        $row = mysqli_fetch_assoc($rs);

        $reason = $row['reason'];
        $end_date = webdate($row['end_date']);
        $uid = $row['uid'];
        $created_at = webdate(explode(' ',$row['created_at'])[0]);
    
    }else{
        $uid = $_SESSION['ses_uid'];

        $rs = mysqli_query($conn,"SELECT * FROM `db_resign` WHERE `uid` = $uid AND `status` != 0 AND status != 3");
        $cnt = mysqli_num_rows($rs);

        if($cnt>0){
            $row = mysqli_fetch_assoc($rs);

            $id = $row['id'];
            $reason = $row['reason'];
            $end_date = webdate($row['end_date']);
            $uid = $row['uid'];
            $created_at = webdate(explode(' ',$row['created_at'])[0]);   
            if($row['status']==2){
                $readonly = ' disabled';
            }             
        }
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = $uid");
    $row = mysqli_fetch_assoc($rs);

    $name = $row['name'];
    $position = $row['position'];

    if(isset($readonly)){
        echo '<div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">อนุมัติแล้ว</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <!-- <a href="action.php?mod=resign&act=approve&id=<?php echo $id;?>">Approve</a> |
                                                <a href="action.php?mod=resign&act=decline&id=<?php echo $id;?>">Decline</a>
                                                <strong></strong> -->
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label>ชื่อ-นามสกุล</label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>" disabled>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ตำแหน่ง/ทีม</label>
                                                        <input type="text" class="form-control" name="position" value="<?php echo $position;?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <label>Attach</label><br>
                                                        <input type="file" name="file" id="" required>
                                                    </div>
                                                </div>
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="resign">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>