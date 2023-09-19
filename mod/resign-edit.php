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
                                    <form data-plugin="parsley" data-option="{}" action="action.php" method="POST"<?php if(!isset($_GET['id'])){echo ' onsubmit="return confirm(\'คุณยืนยันในการลาออกหรือไม่ หากยังไม่มั่นใจสามารถกดยกเลิกได้นะคะ\');"';}?>>
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
                                                        <div class="form-group">
                                                            <label>เหตุผลการลาออก</label>
                                                            <textarea name="reason" rows="5" class="form-control"<?php if(isset($readonly)){echo $readonly;}?> required><?php echo $reason;?></textarea>
                                                        </div>      
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                        <label>วันที่สิ้นสุดการทำงาน</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="end_date" value="<?php echo $end_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?> required>
                                                        <small>*วันสิ้นสุดการทำงานอย่างน้อย 1 เดือนนับจากวันที่ยื่นผ่านระบบ<?php
                                                        
                                                        if(isset($created_at)){
                                                            echo '('.$created_at.')';
                                                        }
                                                        
                                                        ?></small>
                                                    </div> 

                                                    <?php 
                                                    // echo $mod.' '.json_encode($edits);

                                                    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `parent` = $uid AND `end_date` IS NULL");

                                                    if(mysqli_num_rows($rs)>0&&(in_array(explode('-',$mod)[0],$edits)||$_SESSION['ses_ulevel']==9)){?>
                                                    <div class="form-group">
                                                        <label>Move to new team lead</label>
                                                        <select class="form-control" data-plugin="select2" data-option="{}" name="time1_ids"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                                                            <option value="">- Please select -</option>
                                                            <?php
                                                             
        $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `end_date` IS NULL ORDER BY `code` ASC");
        while($row=mysqli_fetch_assoc($rs)){
            echo '<option value="'.$row['id'].'"'.$sp[$row['id']].'>TIME-'.str_pad($row['code'], 3, '0', STR_PAD_LEFT).' '.$row['name'].'</option>';
        }
    ?>
                                                        </select>
                                                    </div>
                                                    <?php }?>

                                                    <?php if(isset($created_at)){?>
                                                    <!-- <div class="form-group">
                                                        <label>สถานะ</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                            <label class="form-check-label" for="inlineRadio1">Pending</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                            <label class="form-check-label" for="inlineRadio2">Approve</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                                            <label class="form-check-label" for="inlineRadio3">Decline</label>
                                                        </div>
                                                    </div> -->
                                                                            
                                                    <?php }?>    
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