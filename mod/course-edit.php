<?php if(in_array('course',$edits)||$_SESSION['ses_ulevel']>7){

    if($id!=''){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_course` WHERE `id` = $id ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);
    
        $name = htmlspecialchars($row['name']);
        $desc_short = htmlspecialchars($row['desc_short']);
        $description = htmlspecialchars($row['description']);
        $owner = htmlspecialchars($row['owner']);
        $cover = $row['cover'];

        // $rs = mysqli_query($conn,"SELECT * FROM `db_course_detail` WHERE `eid` = $id and status = 2 ORDER BY `db_course_detail`.`id` ASC");
        // while($row = mysqli_fetch_assoc($rs)){
        //     $details[] = $row['title'].'|'.$row['cost'];
        // }

        // if($month!=$row['month']){
        //     $rs = mysqli_query($conn,"UPDATE `db_course` SET `month` = '$month' WHERE `id` = $id;");
        // }

    }else{
        // $month = $_GET['month'];
                
        $sql = "SELECT code FROM `db_course` WHERE `month` = '$month' ORDER BY `code` DESC limit 1";
    
        $rs = mysqli_query($conn,$sql);
        $cnt = mysqli_num_rows($rs);
    
        if($cnt!=0){
            $row = mysqli_fetch_assoc($rs);        
            $new_no = explode('/',$row['code'])[1]+1;
            $code = 'PV'.explode('-',$month)[1].'/'.str_pad($new_no, 3, 0, STR_PAD_LEFT);
    
        }else{
            $code = 'PV'.explode('-',$month)[1].'/001';
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
                                                <strong>ข้อมูลคอร์สออนไลน์</strong>
                                            </div>
                                            <div class="card-body">

                                            <form action="action.php" method="post" enctype="multipart/form-data">

    <div class="form-row">
        <div class="form-group col-sm-6">
            <label>Course Platform</label><?php

            $assets = [
                'skilllane' => 'SkillLane',
                'udemy' => 'Udemy',
                'edumall' => 'EduMall',
            ];
            // $mos = [
            //     '12' => 'DEC',
            //     '11' => 'NOV',
            //     '10' => 'OCT',
            //     '09' => 'SEP',
            //     '08' => 'AUG',
            //     '07' => 'JUL',
            //     '06' => 'JUN',
            //     '05' => 'MAY',
            //     '04' => 'APR',
            //     '03' => 'MAR',
            //     '02' => 'FEB',
            //     '01' => 'JAN',
            // ];

            // echo date(m).'55';
            ?>
            <select name="owner" id="owner"<?php 
            // if(isset($_GET['id'])){echo ' disabled';}
            ?>><option value=""></option><?php

            // if(isset($owner)){
            //     $sm[$month] = ' selected';

            // }else{
            //     $sm[date("Y-m")] = ' selected';

            // }

            $sm[$owner] = ' selected';
            
            foreach($assets as $k => $v){
                // if($k<=date(m)){
                    echo '<option value="'.$k.'"'.$sm["$k"].'>'.$v.'</option>';
                // }
            }
            
            ?>
            </select> 
        </div>
    <!-- <div class="form-group col-sm-6">
        <label>เลขที่ใบสำคัญจ่าย</label>
                                                            <input type="text" class="form-control" name="code" value="<?php echo $code;?>" required>
    
    </div> -->
    </div>
    <div class="form-row">
        <div class="form-group col-sm-6">
        <label>ชื่อคอร์ส</label>
                                                            <input type="text" class="form-control" name="name" value="<?php echo $name;?>" required>
    
    </div></div>
    <div class="form-row">
        <div class="form-group col-sm-6">
            <label>รายละเอียดสั้น</label>
            <textarea name="desc_short" class="form-control" rows="4" placeholder="" maxlength="300" required><?php echo $desc_short;?></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-sm-12">
            <label>รายละเอียดยาว</label>
            <!-- <textarea name="description" class="form-control" rows="7" placeholder="" required><?php echo $description;?></textarea> -->
            <div class="mb-3 note-editor-inline">
                                <textarea name="description" data-plugin="summernote" data-option="{
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['insert', ['link','table','hr']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['misc', ['undo','redo','codeview']]
        ]
      }"><?php echo $description;?>
                                </textarea>
                            </div>
        </div>
    </div>

<div class="form-row">
    <div class="form-group col-sm-6">
        <label>Cover Image</label>
        <div class="custom-file">
            <input type="file" id="customFile" name="file">                                                            
        </div>
        <?php
        
        if($cover!=null){
            echo '<img src="uploads/course/'.$id.'.jpg" alt="">';
        }
        
        ?>
        
    </div>
</div>

<div class="form-row pt-2">
<div class="col-6">
<!-- <a href="action.php?mod=del&page=course&id=<?php echo $id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a> -->
</div>
                                                <div class="col-6 text-right">

                                                    <input type="hidden" name="mod" value="course">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>

                                                </div>
                                                </div>

                                    </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
<?php }?>