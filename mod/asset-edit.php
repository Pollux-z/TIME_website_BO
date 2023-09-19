<?php
    $rss = mysqli_query($conn,"SELECT id,uid_go,date_back FROM `db_asset` WHERE `code` LIKE '".$_GET['code']."' ORDER BY `id` DESC limit 1");
    $roww = mysqli_fetch_assoc($rss);

    $cntt = mysqli_num_rows($rss);

    // $rs = mysqli_query($conn,"SELECT * FROM `db_asset` ORDER BY `id` DESC limit 1");
    // $row = mysqli_fetch_assoc($rs);

    // if($row['date_back']==null){
    //     $id = $row['id'];

    //     $rss = mysqli_query($conn,"SELECT nick FROM `db_employee` WHERE `id` = ".$row['uid_go']);
    //     $roww=mysqli_fetch_assoc($rss);

    //     echo '<div class="alert alert-info" role="alert">
    //     <i data-feather="info"></i>
    //     <span class="mx-2">'.$roww['nick'].'ขับรถไป '.$row['destination'].'</span>
    // </div>';        
    // }else{
    //     $km = $row['km_back'];

    //     echo '<div class="alert alert-info" role="alert">
    //     <i data-feather="info"></i>
    //     <span class="mx-2">อุปกรณ์อยู่ที่ '.$row['uid_go'].'</span>
    // </div>';
    // }


?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php
                                                
                                                // if(isset($id)){
                                                //     echo 'TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                // }else{
                                                    // echo 'รถหมายเลขทะเบียน ฆส-454 (Toyota Sienta)';
                                                    if($roww['date_back']==null&&$cntt!=0){
                                                        $status = 'return';
                                                        echo 'บันทึกคืน';
                                                    }else{
                                                        echo 'บันทึกยืม';
                                                    }
                                                    echo 'อุปกรณ์/บริการ: '.$_GET['code'];
                                                // }

                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
<?php if($status!='return'){?>
    <div class="form-group col-sm-6">
        <label>ชื่องาน</label>
        <input type="text" class="form-control" name="destination" required>
    </div>

<?php }else{$id = $roww['id'];}?>                                                    
                                                    <div class="form-group col-sm-6">
                                                        <label>หมายเหตุ (ถ้ามี)</label>
                                                        <input type="text" class="form-control" name="remark">
                                                    </div>

                                                </div>
                                                <div class="text-right pt-2">
                                                    <input type="hidden" name="mod" value="asset">
                                                    <input type="hidden" name="code" value="<?php echo $_GET['code'];?>">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>