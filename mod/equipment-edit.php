<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM `db_equipment` WHERE `id` = $id";
        $rs = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($rs);
    
        $code = htmlspecialchars($row['code']);
        $brand = htmlspecialchars($row['brand']);
        $model = htmlspecialchars($row['model']);
        $spec = htmlspecialchars($row['spec']);
        $warranty = webdate($row['warranty']);
        $sn = htmlspecialchars($row['sn']);
        $status = htmlspecialchars($row['status']);
        
        $rs = mysqli_query($conn,"SELECT * FROM `db_equipment_log` WHERE `eid` = $id and end_date is null order by id desc limit 1");
        $cnt = mysqli_num_rows($rs);

        if($cnt!=0){
            $row = mysqli_fetch_assoc($rs);

            $uid = $row['uid'];
            $start_date = webdate($row['start_date']);
        }

        // $remark = htmlspecialchars($row['remark']);
        // $sl[$row['project_id']] = ' selected';
    
        // $dt = explode('-',$row['date']);
        // $date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // if($_SESSION['ses_uid']!=$row['uid']&&$_SESSION['ses_ulevel']!=9){
        //     $readonly = ' disabled';
        // }
    }

    $statuses = [
        1 => 'Out of service',
        2 => 'Available',
        3 => 'In Use',
    ];

    if($_GET['alert']=='created'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success! Your announce letter number is <b>TIME'.substr($row['date'],0,4).'/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below when document signed.</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php
                                                
                                                // if(isset($id)){
                                                //     echo 'TIME'.substr($row['date'],0,4).'/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                // }else{
                                                    // echo 'ออกเลขหนังสือใหม่';
                                                // }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label>ID</label>
                                                        <input type="text" class="form-control" name="code" value="<?php echo $code;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Brand</label>
                                                        <input type="text" class="form-control" name="brand" value="<?php echo $brand;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Model</label>
                                                        <input type="text" class="form-control" name="model" value="<?php echo $model;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Spec laptop</label>
                                                        <input type="text" class="form-control" name="spec" value="<?php echo $spec;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Warranty</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="warranty" value="<?php echo $warranty;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                        <!-- <input type="text" class="form-control" name="warranty" value="<?php echo $warranty;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>> -->
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>S/N</label>
                                                        <input type="text" class="form-control" name="sn" value="<?php echo $sn;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                </div>
                                                <div class="form-row">   

                                                    <div class="form-group col-sm-6">
                                                        <label>User use</label>
                                                        <select name="user" id="user" class="form-control"<?php 
                                                        // if(isset($_GET['id'])){echo ' disabled';}
                                                        ?>>
                                                            <option value="">Available</option>
                                                            <option value="oos"<?php
                                                            
                                                            if($status==1){echo ' selected';}
                                                            
                                                            ?>>Out of Service</option>
                                                            <?php
                                                            
                                                            $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `end_date` IS NULL ORDER BY `db_employee`.`nick` ASC");

                                                            $su[$uid] = ' selected';

                                                            while($row=mysqli_fetch_assoc($rs)){
                                                                echo '<option value="'.$row['id'].'"'.$su[$row['id']].'>'.$row['nick'].'</option>';
                                                            }
                                                            
                                                            ?>
                                                        </select>
                                                        <!-- <input type="text" class="form-control" name="user_use" value="<?php echo $user_use;?>"<?php if(isset($readonly)){echo $readonly;}?>> -->
                                                        <!-- <small class="form-text text-muted">ใส่เลขหนังสือรูปแบบเดิม ปี 2019 ที่นี่ (จะใช้จริงเลขหนังสือระบบใหม่ ปี 2020)</small> -->
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Start Date</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="start_date" value="<?php echo $start_date;?>"<?php if(isset($readonly)){echo $readonly;}else{
                                                            // echo ' required';
                                                            }?>>
                                                    </div>  

                                                    <?php 
                                                    // if(isset($id)&&empty($readonly)){?>
                                                    <!-- <div class="form-group col-sm-6">
                                                        <label>PDF with Signature</label>
                                                        <div class="custom-file">
                                                            <input type="file" id="customFile" name="file">                                                            
                                                        </div>
                                                    </div> -->
                                                    <?php 
                                                // }?>
                                                </div>
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="equipment">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>