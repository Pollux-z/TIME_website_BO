<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_elearn` WHERE `id` = $id AND `status` != 0 ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);

        $title = htmlspecialchars($row['title']);
        $description = htmlspecialchars($row['description']);
        $vid = htmlspecialchars($row['vid']);
        $hashtags = json_decode($row['hashtags']);

        // $sp[$time1_ids[0]] = ' selected';

        // $dt = explode('-',$row['paid_date']);
        // $paid_date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        // if($_SESSION['ses_uid']!=$row['uid']&&$_SESSION['ses_ulevel']!=9){
        //     $readonly = ' disabled';
        // }

        // $documents = [
        //     'หลักประกันสัญญา',
        //     'ค่าที่ปรึกษาล่วงหน้า',
        // ];
    }

    if($_GET['alert']=='created'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success! Your cover letter number is <b>TIME-'.$row['code'].'</b> Please upload PDF file below when document signed.</span>
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
                                                    echo 'TIME-'.$row['code'];
                                                }else{
                                                    echo 'ออกเลขหนังสือใหม่';
                                                }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img src="https://img.youtube.com/vi/<?php echo $row['vid'];?>/0.jpg" alt="" class="img-fluid">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="form-row">
                                                            <div class="form-group col-sm-12">
                                                                <label>Title</label>
                                                                <input type="text" class="form-control" name="title" value="<?php echo $title;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                            </div>
                                                            <div class="form-group col-sm-12">
                                                                <label>Description</label>
                                                                <textarea name="description" id="" cols="30" rows="10" class="form-control"<?php if(isset($readonly)){echo $readonly;}?>><?php echo $description;?></textarea>
                                                            </div>
                                                            <div class="form-group col-sm-12">
                                                                <label>YouTube ID</label>
                                                                <input type="text" class="form-control" name="vid" value="<?php echo $vid;?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                            </div>
                                                            <div class="form-group col-sm-12">
                                                                <label>Hashtag</label>
                                                                <input type="text" class="form-control" name="hashtags" value="<?php echo implode(',',$hashtags);?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                            </div>
<!--
                                                        <?php if(isset($id)){?>
                                                            <div class="form-group col-sm-12">
                                                                <label>Comment</label>
                                                                <input type="text" class="form-control" name="comment" value=""<?php if(isset($readonly)){echo $readonly;}?>>
                                                                <?php
                                                                
                                                                foreach($comments as $v){
                                                                    echo $v[0].' ('.$v[1].')<br>';
                                                                }
                                                                
                                                                ?>
                                                                <!-- <small class="form-text text-muted">เช่น มหาวิทยาลัย</small> -->
                                                            </div>
                                                        <?php }?>


                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="elearn">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>