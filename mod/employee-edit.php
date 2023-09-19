<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = $id");
        $row = mysqli_fetch_assoc($rs);

        $code = htmlspecialchars($row['code']);
        $nick = htmlspecialchars($row['nick']);
        $name = htmlspecialchars($row['name']);
        $name_en = htmlspecialchars($row['name_en']);
        $position = htmlspecialchars($row['position']);
        $tel = htmlspecialchars($row['tel']);
        $email = htmlspecialchars($row['email']);
        // $time1_ids = json_decode($row['time1_ids']);
        // // $time2_ids = $row['time2_ids'];
        $dob = webdate($row['dob']);
        $start_date = webdate($row['start_date']);
        $dome_note = htmlspecialchars($row['dome_note']);
        $sp[$row['parent']] = ' selected';

        // $status = $row['status'];

        // $return_amount = $row['return_amount'];
        // $objective = $row['objective'];
        // $scope = $row['scope'];

        // $file_contract = $row['file_contract'];
        // $file_cert = $row['file_cert'];
        // $file_doc = $row['file_doc'];
        // $file_ppt = $row['file_ppt'];
        
        // $sp[$time1_ids[0]] = ' selected';
        // $sd[$row['document']] = ' selected';
    
        // $dt = explode('-',$row['start_date']);
        // $start_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['end_date']);
        // $end_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['bank_sent']);
        // $bank_sent = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['bank_received']);
        // $bank_received = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['cert_sent']);
        // $cert_sent = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['cert_received']);
        // $cert_received = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['paid_date']);
        // $paid_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // if($_SESSION['ses_uid']!=$row['uid']&&$_SESSION['ses_ulevel']!=9){
        //     $readonly = ' disabled';
        // }
        $next_code = '';

    }else{
        $rss = mysqli_query($conn,"SELECT code FROM `db_employee`  
        ORDER BY `db_employee`.`code`  DESC LIMIT 1");
        $roww = mysqli_fetch_assoc($rss);

        $next_code = str_pad($roww['code'], 3, 0, STR_PAD_LEFT)+1;
    }

    // $documents = [
    //     'หลักประกันสัญญา',
    //     'ค่าที่ปรึกษาล่วงหน้า',
    // ];

    if($_GET['alert']=='created'){
        // echo '
        // <div class="alert alert-info" role="alert">
        //     <i data-feather="info"></i>
        //     <span class="mx-2">Success! Your cover letter number is <b>TIME'.substr($row['date'],0,4).'-'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below when document signed.</span>
        // </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php
                                                
                                                if(isset($id)){
                                                    echo 'TIME'.str_pad($row['code'], 3, 0, STR_PAD_LEFT);
                                                }else{
                                                    echo 'เพิ่มพนักงานใหม่';
                                                }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
<?php if(!$id){?>
                                                    <div class="form-group col-sm-12">
                                                        <label>Employee Code</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3">TIME</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="code" id="code" aria-describedby="basic-addon3" value="<?php echo $next_code;?>" required>
                                                        </div>
                                                    </div>
                                            <?php }?>
                                                    <div class="form-group col-sm-12">
                                                        <label>ชื่อ (English)</label>
                                                        <input type="text" class="form-control" name="name_en" value="<?php echo $name_en;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label>ชื่อ (ไทย)</label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ชื่อเล่น (ไทย)</label>
                                                        <input type="text" class="form-control" name="nick" value="<?php echo $nick;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ตำแหน่ง</label>
                                                        <input type="text" class="form-control" name="position" value="<?php echo $position;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>เบอร์โทร</label>
                                                        <input type="tel" class="form-control" name="tel" value="<?php echo $tel;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>E-mail</label>
                                                        <input type="email" class="form-control" name="email" value="<?php echo $email;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                        <!-- <small class="form-text text-muted">พิมพ์มูลค่า แล้วคั่นด้วย , เช่น 500000,500000,1000000</small> -->
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>วันเกิด</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="dob" value="<?php echo $dob;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>วันเริ่มทำงาน</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="start_date" value="<?php echo $start_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Team Lead</label>
                                                        <select class="form-control" data-plugin="select2" data-option="{}" name="parent"<?php if(isset($readonly)){echo $readonly;
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
                                                    <div class="form-group col-sm-6">
                                                        <label>หมายเหตุ
</label>
                                                        <textarea class="form-control" name="dome_note"<?php if(isset($readonly)){echo $readonly;}?>><?php echo $dome_note;?></textarea>
                                                    </div>         
                                                </div>

                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="employee">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>