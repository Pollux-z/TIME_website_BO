<div style="height:60px;">
    <div class="avatar-group float-right">
        <?php

        $rs = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL ORDER BY `code` ASC");
        while($row=mysqli_fetch_assoc($rs)){
            if(in_array('project',json_decode($row['edits']))||$row['level']>7){
                $ams[$row['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$row['nick'].'">
                <img src="uploads/employee/'.$row['id'].'.jpg" alt=".">
            </a>';
            }
        }

        echo implode(' ',$ams);
        ?>
    </div>
</div>

<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_project` WHERE `id` = $id AND `status` != 0 ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);

        $code = htmlspecialchars($row['code']);
        $contract_no = htmlspecialchars($row['contract_no']);
        $name = htmlspecialchars($row['name']);
        $name_th = htmlspecialchars($row['name_th']);
        $val = htmlspecialchars($row['val']);
        $installment = htmlspecialchars($row['installment']);        
        $client = htmlspecialchars($row['client']);
        $client_address = htmlspecialchars($row['client_address']);
        $client_taxid = htmlspecialchars($row['client_taxid']);
        $owner = htmlspecialchars($row['owner']);
        $time1_ids = json_decode($row['time1_ids']);
        // $time2_ids = $row['time2_ids'];
        $pdmo_cat = htmlspecialchars($row['pdmo_cat']);
        $pdmo_specialize = htmlspecialchars($row['pdmo_specialize']);
        $note = htmlspecialchars($row['note']);
        $status = $row['status'];

        $return_amount = $row['return_amount'];
        $objective = $row['objective'];
        $scope = $row['scope'];

        $file_contract = $row['file_contract'];
        $file_contract2 = $row['file_contract2'];
        $file_contract3 = $row['file_contract3'];
        $file_cert = $row['file_cert'];
        $file_doc = $row['file_doc'];
        $file_ppt = $row['file_ppt'];
        
        $sp[$time1_ids[0]] = ' selected';
        $sd[$row['document']] = ' selected';
        $ss[$row['status']] = ' selected';
    
        $dt = explode('-',$row['start_date']);
        $start_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        $dt = explode('-',$row['end_date']);
        $end_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        $dt = explode('-',$row['bank_sent']);
        $bank_sent = $dt[2].'/'.$dt[1].'/'.$dt[0];

        $dt = explode('-',$row['bank_received']);
        $bank_received = $dt[2].'/'.$dt[1].'/'.$dt[0];

        $dt = explode('-',$row['cert_sent']);
        $cert_sent = $dt[2].'/'.$dt[1].'/'.$dt[0];

        $dt = explode('-',$row['cert_received']);
        $cert_received = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // $dt = explode('-',$row['paid_date']);
        // $paid_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // if($_SESSION['ses_uid']!=$row['uid']&&$_SESSION['ses_ulevel']!=9){
        //     $readonly = ' disabled';
        // }
    }

    $documents = [
        'หลักประกันสัญญา',
        'ค่าที่ปรึกษาล่วงหน้า',
    ];

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
                                    <form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php
                                                
                                                if(isset($id)){
                                                    echo 'TIME'.substr($row['date'],0,4).'-'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                }else{
                                                    echo 'สร้างโปรเจ็คท์ใหม่';

                                                    $yr = date(Y);

                                                    $rs = mysqli_query($conn,"SELECT `code` FROM `db_project` WHERE `code` LIKE '$yr%' AND `status` != 0 ORDER BY `code` DESC LIMIT 1");
                                                    $row = mysqli_fetch_assoc($rs);
                                                    $cnt = mysqli_num_rows($rs);

                                                    if($cnt!=0){
                                                        $code = $row['code']+1;
                                                    }else{
                                                        $code = $yr.'01';
                                                    }                                                    
                                                }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
<?php if(!$id){?>
                                                    <div class="form-group col-sm-12">
                                                        <label>Project Code</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3">TIME-</span>
                                                            </div>
                                                            <input type="text" class="form-control" name="code" id="code" value="<?php echo $code;?>" aria-describedby="basic-addon3" required>
                                                        </div>
                                                    </div>
                                            <?php }?>
                                                    <div class="form-group col-sm-12">
                                                        <label>ชื่อ Project (English)</label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>"<?php if(isset($readonly)){echo $readonly;}?> required>
                                                    </div>
                                                    <div class="form-group col-sm-12">
                                                        <label>ชื่อโครงการ (ภาษาไทย)</label>
                                                        <input type="text" class="form-control" name="name_th" value="<?php echo $name_th;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>เลขที่สัญญา</label>
                                                        <input type="text" class="form-control" name="contract_no" value="<?php echo $contract_no;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ชื่อหน่วยงานผู้ว่าจ้าง</label>
                                                        <input type="text" class="form-control" name="client" value="<?php echo $client;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ที่อยู่</label>
                                                        <textarea name="client_address" id="" cols="30" rows="4" class="form-control"<?php if(isset($readonly)){echo $readonly;}?>><?php echo $client_address;?></textarea>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>เลขที่ผู้เสียภาษี</label>
                                                        <input type="text" class="form-control" name="client_taxid" value="<?php echo $client_taxid;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label> มูลค่าโครงการ </label>
                                                        <input type="text" class="form-control" name="val" value="<?php echo $val;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label> งวดเงิน </label>
                                                        <input type="text" class="form-control" name="installment" value="<?php echo $installment;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                        <small class="form-text text-muted">พิมพ์มูลค่า แล้วคั่นด้วย , เช่น 500000,500000,1000000</small>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>หน่วยงานเจ้าของโครงการ</label>
                                                        <input type="text" class="form-control" name="owner" value="<?php echo $owner;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                        <small class="form-text text-muted">เช่น มหาวิทยาลัย</small>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>PM</label>
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
                                                    <div class="form-group col-sm-6">
                                                        <label>วันเริ่มสัญญา</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="start_date" value="<?php echo $start_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>วันสิ้นสุดสัญญา</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="end_date" value="<?php echo $end_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>หนังสือค้ำประกัน</label>
                                                        <select class="form-control" data-plugin="select2" data-option="{}" name="document"<?php if(isset($readonly)){echo $readonly;}else{
                                                            // echo ' required';
                                                            }?>>
                                                            <option value="">- Please select -</option>
                                                            <?php 
                                                                foreach($documents as $v){
                                                                    echo '<option value="'.$v.'"'.$sd[$v].'>'.$v.'</option>';
                                                                }
                                                            ?>                                                                                                               </select>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>สถานะ</label>
                                                        <select class="form-control" data-plugin="select2" data-option="{}" name="status"<?php if(isset($readonly)){echo $readonly;}else{
                                                            // echo ' required';
                                                            }?>>
                                                            <?php 
                                                                foreach($proj_stts as $k => $v){
                                                                    echo '<option value="'.$k.'"'.$ss[$k].'>'.$v.'</option>';
                                                                }
                                                            ?>                                                                                                               </select>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Bank Guarantee	 ส่งออก</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="bank_sent" value="<?php echo $bank_sent;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ได้รับ</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="bank_received" value="<?php echo $bank_received;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>หนังสือรับรองผลงาน	ส่งออก</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="cert_sent" value="<?php echo $cert_sent;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ได้รับ</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="cert_received" value="<?php echo $cert_received;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>เงินคืน</label>
                                                        <input type="text" class="form-control" name="return_amount" value="<?php echo $return_amount;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>pdmo สาขา</label>
                                                        <input type="text" class="form-control" name="pdmo_cat" value="<?php echo $pdmo_cat;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ความเชี่ยวชาญ</label>
                                                        <input type="text" class="form-control" name="pdmo_specialize" value="<?php echo $pdmo_specialize;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>หมายเหตุ
</label>
                                                        <input type="text" class="form-control" name="note" value="<?php echo $note;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>         
                                                </div>
                                                <div class="form-row">                                  
                                                    <div class="form-group col-sm-6">
                                                        <label>วัตถุประสงค์โครงการ</label>
                                                        <textarea name="objective" id="" cols="30" rows="10" class="form-control"<?php if(isset($readonly)){echo $readonly;}?>><?php echo $objective;?></textarea>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ขอบเขตงาน</label>
                                                        <textarea name="scope" id="" cols="30" rows="10" class="form-control"<?php if(isset($readonly)){echo $readonly;}?>><?php echo $scope;?></textarea>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>สัญญา</label>
                                                        <div class="custom-file">
                                                            <?php if($file_contract!=''){echo '<a href="uploads/project/'.$file_contract.'" target="_blank"><i class="mx-2" data-feather="file"></i>'.$file_contract.'</a>';}else{echo '<input type="file" id="file_contract" name="file_contract">';}?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>สัญญา (2)</label>
                                                        <div class="custom-file">
                                                            <?php if($file_contract2!=''){echo '<a href="uploads/project/'.$file_contract2.'" target="_blank"><i class="mx-2" data-feather="file"></i>'.$file_contract2.'</a>';}else{echo '<input type="file" id="file_contract2" name="file_contract2">';}?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>สัญญา (3)</label>
                                                        <div class="custom-file">
                                                            <?php if($file_contract3!=''){echo '<a href="uploads/project/'.$file_contract3.'" target="_blank"><i class="mx-2" data-feather="file"></i>'.$file_contract3.'</a>';}else{echo '<input type="file" id="file_contract3" name="file_contract3">';}?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>หนังสือรับรองผลงาน</label>
                                                        <div class="custom-file">
                                                        <?php if($file_cert!=''){echo '<a href="uploads/project/'.$file_cert.'" target="_blank"><i class="mx-2" data-feather="file"></i>'.$file_cert.'</a>';}else{echo '<input type="file" id="file_cert" name="file_cert">';}?>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Project ref (Word)</label>
                                                        <div class="custom-file">
                                                        <?php if($file_doc!=''){echo '<a href="uploads/project/'.$file_doc.'" target="_blank"><i class="mx-2" data-feather="file"></i>'.$file_doc.'</a>';}else{echo '<input type="file" id="file_doc" name="file_doc">';}?>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Project ref (PowerPoint)</label>
                                                        <div class="custom-file">
                                                            <?php if($file_ppt!=''){echo '<a href="uploads/project/'.$file_ppt.'" target="_blank"><i class="mx-2" data-feather="file"></i>'.$file_ppt.'</a>';}else{echo '<input type="file" id="file_ppt" name="file_ppt">';}?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="project">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>