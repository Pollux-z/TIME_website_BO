<div class="row">
    <div class="col-6">
        <?php
        $rs = mysqli_query($conn,"SELECT `id`,`nick` FROM `db_employee`");
        while($row=mysqli_fetch_assoc($rs)){
            $time1[$row['id']] = $row['nick'];
        }
        
        $rs = mysqli_query($conn,"SELECT * FROM `db_course` WHERE `id` = $id");
        $row = mysqli_fetch_assoc($rs);

        $course_owner = $row['owner'];

        echo '<h1>'.$row['name'].'</h1>
        '.nl2br($row['description']).'<br><br>';

        ?>
    </div>
    <div class="col-6">
        <img src="
    <?php    
    
    if($row['cover']!=null){
        echo "uploads/course/$id.jpg";
    }else{
        echo 'https://via.placeholder.com/800x400';
    }        
    ?>    
        
        
        " style="width:100%"><br><br>

        <div class="avatar-group mb-5">
        <?php
            $rs = mysqli_query($conn,"SELECT DISTINCT `uid` FROM `db_courserec` WHERE `cid` = $id AND `end_date` IS NOT NULL");
            while($row=mysqli_fetch_assoc($rs)){
                echo '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$time1[$row['uid']].'">
                <img src="uploads/employee/'.$row['uid'].'.jpg" alt=".">
            </a>';
            }
        ?>
            </div> 

            <?php
            
            $rss = mysqli_query($conn,"SELECT * FROM `db_courserec` WHERE `cid` = $id AND `status` = 2 AND `end_date` IS NULL ORDER BY `id` DESC LIMIT 1");
            $roww = mysqli_fetch_assoc($rss);
    
            if(mysqli_num_rows($rss)!=0&&$roww['uid']==$_SESSION['ses_uid']){
                echo '<div class="alert alert-success" role="check">
                    <i data-feather="info"></i>
                    <span class="mx-2">ไปที่เว็บไซต์ ';
    
                if($course_owner=='skilllane'){
                    echo '<a href="https://www.skilllane.com/user/mycourses" target="_blank">https://www.skilllane.com/user/mycourses</a><br>Username: contact@timeconsulting.co.th Password: p@ssw0rd';
    
                }elseif($course_owner=='udemy'){
                    echo '<a href="https://www.udemy.com/home/my-courses/" target="_blank">https://www.udemy.com/home/my-courses/</a><br>Username: contact@timeconsulting.co.th Password: Time1220@';
    
                }elseif($course_owner=='edumall'){
                    echo '<a href="https://learning.edumall.co.th/home/my-course/learning" target="_blank">https://learning.edumall.co.th/home/my-course/learning</a><br>Username: prapaporn.c@timeconsulting.co.th Password: Time1220@';
    
                }            
                echo '<br><br>คลิกปุ่ม Finish เมื่อเลิกเรียนแล้ว เพื่อบันทึกการเข้าเรียนและเปิดให้คนอื่นได้เรียนคอร์สนี้ต่อ</span></div>';
    
                $btn = '<a href="action.php?mod=course-finish&id='.$id.'" class="btn btn-danger">Finish</a>';
    
            }elseif(mysqli_num_rows($rss)!=0){    
                $btn = '<button type="button" class="btn btn-secondary" disabled>'.$time1[$roww['uid']].'กำลังเรียนอยู่</button>';
    
            }else{
                $btn = '<a href="action.php?mod=course-start&id='.$id.'" class="btn btn-primary">Start</a>';
            }
    
            echo $btn;            
            
            ?>

            <div class="card mt-5" id="feed-1">
                <h5 class="p-3">Reviews</h5>

                <div class="p-3 b-t collapse show" id="feed-form-1">
                    <form action="action.php" method="post">
                        <input type="hidden" name="mod" value="comment">
                        <input type="hidden" name="md" value="course">
                        <input type="hidden" name="mid" value="<?php echo $id;?>">

                        <textarea name="message" class="form-control" rows="3" placeholder="พิมพ์ข้อความที่นี่" required></textarea>
                        <div class="d-flex pt-2">
                            <div class="toolbar my-1">
                            </div>
                            <span class="flex"></span>
                            <button class="btn btn-sm btn-primary">Post</button>
                        </div>
                    </form>
                </div>
<?php
    // $rs = mysqli_query($conn,"SELECT `id`, `name_en` FROM `db_employee`");
    // while($row=mysqli_fetch_assoc($rs)){
    //     $time1[$row['id']] = $row['name_en'];
    // }

    $rs = mysqli_query($conn,"SELECT * FROM `db_comment` WHERE `md` = 'course' AND `mid` = $id AND `status` = 2 ORDER BY `created_at` DESC");
    while($row=mysqli_fetch_assoc($rs)){
?>
                <div class="card-header d-flex">
                    <a href="?mod=employee-profile&id=<?php echo $row['uid'];?>">
                        <img src="/uploads/employee/<?php echo $row['uid'];?>.jpg" class="avatar w-40">
                    </a>
                    <div class="mx-3">
                        <a href="?mod=employee-profile&id=<?php echo $row['uid'];?>"><?php echo $time1[$row['uid']];?></a>
                        <div class="text-muted text-sm"><?php echo $row['created_at'];?></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-text mb-3">
                        <p><?php echo nl2br($row['message']);?></p>
                    </div>
                </div>
<?php }?>
            </div>
        
    </div>
</div>