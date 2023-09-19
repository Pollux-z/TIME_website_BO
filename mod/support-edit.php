<?php
    if(isset($_GET['id'])){
        $rs = mysqli_query($conn,"SELECT * FROM `db_support` WHERE `id` = $id AND `status` > 0");
        $row = mysqli_fetch_assoc($rs);

        $code = $row['code'];
        $project = $row['project'];
        $note = $row['note'];
        $output = $row['output'];
        // $start_date = webdate($row['start_date']);
        $end_date = webdate($row['end_date']);
        $uid = $row['uid'];
        $to_uid = $row['to_uid'];

        $sp[$row['project_id']] = ' selected';
        $su[$row['uid']] = ' selected';
        $ss[$row['status']] = ' selected';
    }else{
        $ss[2] = ' selected';
    }

    $codes = [
        // 'case' => 'Case Team',
        'acc' => 'BO / Accounting & Finance',
        'hr' => 'BO / HR',
        'adm' => 'BO / Admin',
        'it' => 'MarTech / IT',
        'mkt' => 'MarTech / Marketing',
        'cta' => 'Case Team Assistant',
    ];

    $rs = mysqli_query($conn,"SELECT `nick`, `line_token` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
    $row = mysqli_fetch_assoc($rs);

    if($row['line_token']==''){
        echo '<div class="alert alert-info" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">รับแจ้งเตือนอัพเดตสถานะงานเข้า LINE '.$row['nick'].'ได้แล้ววันนี้ โดยกรอกรหัส LINE Token ที่<a href="?mod=employee-profile">หน้าโปรไฟล์</a></span>
        </div>';
    }

?><div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
            <form action="action.php" method="POST">

<?php if($_SESSION['ses_ulevel']>7){?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">From</label>
                    <div class="col-sm-9">
                    <select class="form-control" data-plugin="select2" data-option="{}" name="uid"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                    <option value="">- Please select -</option>
                            <?php
                            
                            $rs = mysqli_query($conn,"SELECT id,nick FROM `db_employee` WHERE `end_date` IS NULL ORDER BY `db_employee`.`code` ASC");
                            while($row=mysqli_fetch_assoc($rs)){
                                echo '<option value="'.$row['id'].'"'.$su[$row['id']].'>'.$row['nick'].'</option>';
                            }

                            // foreach($codes as $k => $v){
                            // }
                            
                            ?>                            
                        </select>
                    </div>
                </div>
                            <?php }?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">To</label>
                    <div class="col-sm-9">
                    <select class="form-control" data-plugin="select2" data-option="{}" name="code"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                    <option value="">- Please select -</option>
                            <?php
                            
                            $sc[$code] = ' selected';

                            foreach($codes as $k => $v){
                                echo '<option value="'.$k.'"'.$sc[$k].'>'.$v.'</option>';
                            }
                            
                            ?>                            
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Project</label>
                    <div class="col-sm-9">
                    <select class="form-control" data-plugin="select2" data-option="{}" name="project_id"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                            <option value="">- Please select -</option>
                                                            <option value="0"<?php echo $sp[0];?>>Other Project</option>
                                                            <?php
                                                        
                                                            $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `email` LIKE '".$_SESSION['ses_user_email']."'");
                                                            $row=mysqli_fetch_assoc($rs);
                                                            $uid = $row['id'];
    
                                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_projects` WHERE `time1_ids` LIKE '%\"$uid\"%'");
                                                            // if($_SESSION['ses_ulevel']==9){
                                                                $adt = " WHERE status !=0";
                                                            // }else{
                                                            //     $adt = " WHERE status =2 AND `time1_ids` LIKE '%\"".$_SESSION['ses_uid']."\"%'";
                                                            // }                                                            
                                                            $rs = mysqli_query($conn,"SELECT * FROM `db_project`$adt order by code desc");
                                                            while($row=mysqli_fetch_assoc($rs)){
            echo '<option value="'.$row['id'].'"'.$sp[$row['id']].'>TIME-'.$row['code'].' '.$row['name'].'</option>';
        }
    ?>
                                                        </select>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Project</label>
                    <div class="col-sm-9">
                        <input name="project" id="project" type="text" class="form-control" placeholder="" value="<?php echo $project;?>" required>
                    </div>
                </div> -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Instruction</label>
                    <div class="col-sm-9">
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control" required><?php echo $note;?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Output</label>
                    <div class="col-sm-9">
                        <input name="output" id="output" type="text" class="form-control" placeholder="" value="<?php echo $output;?>" required>
                    </div>
                </div>

                <div class="form-group row row-sm">
                    <label class="col-sm-3 col-form-label">Due Date</label>
                    <div class="col-sm-9">
                        <input type='text' class="form-control" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="to_date" value="<?php echo $end_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                        
                     
                    </div>
                </div>

                <?php if($id&&($to_uid==$_SESSION['ses_uid']||$to_uid==null)){?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-control" data-plugin="select2" data-option="{}" name="status"<?php if(isset($readonly)){echo $readonly;}else{
                            // echo ' required';
                            }?>>
                            <?php 
                                foreach($sp_stts as $k => $v){
                                    echo '<option value="'.$k.'"'.$ss[$k].'>'.$v.'</option>';
                                }
                            ?>                                                                                                               </select>
                    </div>
                </div>
                            <?php }?>

                <div class="form-group row">
                    <label class="col-sm-3"></label>
                    <div class="col-sm-9">
                        <input type="hidden" name="mod" value="<?php echo explode('-',$mod)[0];?>">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <button type="submit" id="btn-save" class="btn gd-primary text-white btn-rounded">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>