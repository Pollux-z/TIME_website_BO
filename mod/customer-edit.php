<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_cover` WHERE `id` = $id ORDER BY `id` DESC");
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
            <span class="mx-2">Success! Your cover letter number is <b>TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below.</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>เพิ่มชื่อลงทะเบียนร่วมงาน</strong>
                                            </div>
                                            <div class="card-body">

                                            <?php


    echo '<form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">';

?>



    <div class="form-row">
        <div class="form-group col-sm-6">
        <label>ชื่องาน (slug)</label>
                                                            <input type="text" class="form-control" name="code">
    
    </div></div>
                                            <div class="form-row">
                                                    <div class="form-group col-sm-12">
                                                    <label>Paste from Excel</label>
                                                    <textarea name="excel" class="form-control" rows="7" placeholder="ลำดับที่,ชื่อ,หน่วยงาน,เบอร์โทร,อีเมล์
ลำดับที่,ชื่อ,หน่วยงาน,เบอร์โทร,อีเมล์
..">
</textarea>
</div></div>

                                                <div class="text-right pt-2">

                                                    <input type="hidden" name="mod" value="customer">
                                                    <!-- <input type="hidden" name="id" value="<?php echo $id;?>"> -->
                                                    <button type="submit" class="btn btn-primary">Import</button>

                                                </div>
                                    </form>
                                            </div>
                                        </div>
                                </div>
                            </div>