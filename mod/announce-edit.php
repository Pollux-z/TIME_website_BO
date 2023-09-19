<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_announce` WHERE `id` = $id ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);
    
        $title = htmlspecialchars($row['title']);
        $remark = htmlspecialchars($row['remark']);
        $sl[$row['project_id']] = ' selected';
    
        $dt = explode('-',$row['date']);
        $date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        if($_SESSION['ses_uid']!=$row['uid']&&$_SESSION['ses_ulevel']!=9){
            $readonly = ' disabled';
        }
    }

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
                                                
                                                if(isset($id)){
                                                    echo 'TIME'.substr($row['date'],0,4).'/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                }else{
                                                    // echo 'ออกเลขหนังสือใหม่';
                                                }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-12">
                                                        <label>Subject</label>
                                                        <input type="text" class="form-control" name="title" value="<?php echo $title;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label>Issue Date</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="date" value="<?php echo $date;?>"<?php if(isset($readonly)){echo $readonly;}else{echo ' required';}?>>
                                                    </div>     
                                                    <div class="form-group col-sm-6">
                                                        <label>Remark</label>
                                                        <input type="text" class="form-control" name="remark" value="<?php echo $remark;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                        <!-- <small class="form-text text-muted">ใส่เลขหนังสือรูปแบบเดิม ปี 2019 ที่นี่ (จะใช้จริงเลขหนังสือระบบใหม่ ปี 2020)</small> -->
                                                    </div>
                                                    <?php 
                                                    // if(isset($id)&&empty($readonly)){?>
                                                    <div class="form-group col-sm-6">
                                                        <label>PDF with Signature</label>
                                                        <div class="custom-file">
                                                            <input type="file" id="customFile" name="file">                                                            
                                                        </div>
                                                    </div>
                                                    <?php 
                                                // }?>
                                                </div>
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="announce">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>