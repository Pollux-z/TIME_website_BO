<div class="row">
    <!-- <div class="col-12"> -->
        <?php
        // $rs = mysqli_query($conn,"SELECT `id`,`nick` FROM `db_employee`");
        // while($row=mysqli_fetch_assoc($rs)){
        //     $time1[$row['id']] = $row['nick'];
        // }
        
        $rs = mysqli_query($conn,"SELECT * FROM `db_elearning` WHERE `id` = $id");
        $row = mysqli_fetch_assoc($rs);

        // $elearning_owner = $row['owner'];

        // echo '<h1>'.$row['name'].'</h1>
        // '.nl2br($row['description']).'<br><br>';

        ?>
    <!-- </div> -->
    <div class="col-12">
    <div class="videowrapper"><iframe width="853" height="480" src="https://www.youtube.com/embed/<?php echo $row['v'];?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div><br><br>

        <div class="avatar-group mb-5">
        <?php
            $rs = mysqli_query($conn,"SELECT DISTINCT `uid` FROM `db_elearningrec` WHERE `cid` = $id AND `end_date` IS NOT NULL");
            while($row=mysqli_fetch_assoc($rs)){
                echo '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$time1[$row['uid']].'">
                <img src="uploads/employee/'.$row['uid'].'.jpg" alt=".">
            </a>';
            }
        ?>
            </div> 

            <?php
            
            $rss = mysqli_query($conn,"SELECT * FROM `db_elearningrec` WHERE `cid` = $id AND `status` = 2 AND `end_date` IS NULL ORDER BY `id` DESC LIMIT 1");
            $roww = mysqli_fetch_assoc($rss);
    
            if(mysqli_num_rows($rss)!=0&&$roww['uid']==$_SESSION['ses_uid']){
                echo '<div class="alert alert-success" role="check">
                    <i data-feather="info"></i>
                    <span class="mx-2">ไปที่เว็บไซต์ ';
    
                if($elearning_owner=='skilllane'){
                    echo '<a href="https://www.skilllane.com/user/mycourses" target="_blank">https://www.skilllane.com/user/mycourses</a><br>Username: contact@timeconsulting.co.th Password: p@ssw0rd';
    
                }elseif($elearning_owner=='udemy'){
                    echo '<a href="https://www.udemy.com/home/my-courses/" target="_blank">https://www.udemy.com/home/my-courses/</a><br>Username: contact@timeconsulting.co.th Password: Time1220@';
    
                }elseif($elearning_owner=='edumall'){
                    echo '<a href="https://learning.edumall.co.th/home/my-course/learning" target="_blank">https://learning.edumall.co.th/home/my-course/learning</a><br>Username: prapaporn.c@timeconsulting.co.th Password: Time1220@';
    
                }            
                echo '<br><br>คลิกปุ่ม Finish เมื่อเลิกเรียนแล้ว เพื่อบันทึกการเข้าเรียนและเปิดให้คนอื่นได้เรียนคอร์สนี้ต่อ</span></div>';
    
                $btn = '<a href="action.php?mod=elearning-finish&id='.$id.'" class="btn btn-danger">Finish</a>';
    
            }elseif(mysqli_num_rows($rss)!=0){    
                $btn = '<button type="button" class="btn btn-secondary" disabled>'.$time1[$roww['uid']].'กำลังเรียนอยู่</button>';
    
            // }else{
                // $btn = '<a href="action.php?mod=elearning-start&id='.$id.'" class="btn btn-primary">Start</a>';
            }
    
            echo $btn;            
            
            ?>

        
    </div>
</div>

<style type="text/css">
            .videowrapper {
                float: none;
                clear: both;
                width: 100%;
                position: relative;
                padding-bottom: 56.25%;
                padding-top: 25px;
                height: 0;
            }
            .videowrapper iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 80%;
                height: 80%;
            }
            </style>