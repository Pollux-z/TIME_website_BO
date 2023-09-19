<?php
    $rs = mysqli_query($conn,"SELECT * FROM `db_carrec` ORDER BY `id` DESC limit 1");
    $row = mysqli_fetch_assoc($rs);

    if($row['date_back']==null){
        $id = $row['id'];

        $rss = mysqli_query($conn,"SELECT nick FROM `db_employee` WHERE `id` = ".$row['uid_go']);
        $roww=mysqli_fetch_assoc($rss);

        echo '<div class="alert alert-info" role="alert">
        <i data-feather="info"></i>
        <span class="mx-2">'.$roww['nick'].'ขับรถไป '.$row['destination'].'</span>
    </div>';        
    }else{
        $km = $row['km_back'];

        echo '<div class="alert alert-info" role="alert">
        <i data-feather="info"></i>
        <span class="mx-2">รถจอดอยู่ที่ชั้น '.$row['floor'].' ช่องจอดที่ '.$row['lot'].'</span>
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
                                                //     echo 'TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                // }else{
                                                    echo 'รถหมายเลขทะเบียน ฆส-454 (Toyota Sienta)';
                                                // }

                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
<?php if($id){?>
    <div class="form-group col-sm-6">
        <label>ระยะทาง กม./ไมล์ กลับ</label>
        <input type="number" pattern="\d*" class="form-control" name="km" required>
    </div>
    <div class="form-group col-sm-6">
        <label>ชั้นที่จอด</label>
        <select class="form-control" name="floor" required>
        <option></option>
        <option>1</option>
        <option>1A</option>
        <option>1B</option>
        <option>1C</option>
        <option>2</option>
        <option>2A</option>
        <option>2B</option>
        <option>2C</option>
        <option>3</option>
        <option>3A</option>
        <option>3B</option>
        <option>3C</option>
        <option>4</option>
        <option>4A</option>
        <option>4B</option>
    </select>
    </div>
    <div class="form-group col-sm-6">
        <label>ช่องที่จอด</label>
        <input type="text" maxlength="3" class="form-control" name="lot" required>
    </div>

<?php }else{?>
    <div class="form-group col-sm-6">
        <label>ระยะทาง กม./ไมล์ ไป</label>
        <input type="text" pattern="\d*" class="form-control" name="km" value="<?php 
        // echo $km;?>" required>
    </div>
    <div class="form-group col-sm-6">
        <label>สถานที่ไป</label>
        <input type="text" class="form-control" name="destination" required>
    </div>

<?php }?>                                                    
                                                    <div class="form-group col-sm-6">
                                                        <label>หมายเหตุ</label>
                                                        <input type="text" class="form-control" name="remark">
                                                    </div>

                                                </div>
                                                <div class="text-right pt-2">
                                                    <input type="hidden" name="mod" value="carrec">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>