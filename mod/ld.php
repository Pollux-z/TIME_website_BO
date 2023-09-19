<?php
        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"ld\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        if(isset($ams[$_SESSION['ses_uid']])){
?><div style="height:50px;">
    <div class="btn-group float-right">
        <a href="?mod=ld" class="btn btn-outline-primary active">Frontend</a>
        <a href="?mod=ld-comment" class="btn btn-outline-primary">Comment</a>
        <a href="?mod=ld-mat" class="btn btn-outline-primary">Material</a>
        <a href="?mod=ld-feedback" class="btn btn-outline-primary">Feedback</a>
    </div>
</div>
<?php
        }

if(isset($_GET['sid'])){
    $page_prefix = 'Video';
    $rs = mysqli_query($conn,"SELECT * FROM `db_ld` WHERE `id` = ".$_GET['sid']." AND `status` > 0");
    $row = mysqli_fetch_assoc($rs);

    $rss = mysqli_query($conn,"SELECT id FROM `db_ld_vdo` WHERE `sid` = ".$_GET['sid']." AND `status` > 0 ORDER BY `id` ASC");
    while($roww=mysqli_fetch_assoc($rss)){
        $pl[] = $roww['id'];
    }

    $rss = mysqli_query($conn,"SELECT a.*,b.sid FROM `db_ld_log_vdo` a join db_ld_vdo b where a.vid = b.id and b.sid = ".$_GET['sid']." and a.`uid` = ".$_SESSION['ses_uid']);
    while($roww=mysqli_fetch_assoc($rss)){
        if(!in_array($roww['vid'],$viewed)){
            $viewed[] = $roww['vid'];
        }
    }

    if(!isset($viewed)){
        $viewed[] = $pl[0];
    }else{
        $next = count($viewed);
        $viewed[] = $pl[$next];
    }

    // if(end($viewed)==null&&$_GET['sid']==1){
    if(end($viewed)==null){
        echo '    <div class="alert bg-success py-4" role="alert">
        <div class="d-flex">
            <i data-feather="inbox" width="32" height="32"></i>
            <div class="px-3">
                <h5 class="text-white">Guideline Material</h5>';
                // <a href="uploads/ld/TIME_Slide Guideline ENG_2020 V6.pdf" target="_blank" class="btn btn-white">Slide Guideline (EN)</a>  <a href="uploads/ld/TIME_Slide Guideline_2020_TH.pdf" target="_blank" class="btn btn-white">Slide Guideline (TH)</a>
                foreach(json_decode($row['guideline']) as $k => $v){
                    echo '<a href="uploads/ld/'.$k.'" target="_blank" class="btn btn-white">'.$v.'</a> ';
                }
            echo '</div>
        </div>
    </div>';
    }
?>

<?php
    echo '<h3 class="mb-5">Video Session '.$row['session'].' : '.$row['title'].'</h3>';

}else{
    $page_prefix = 'Session';
    echo '<div class="alert bg-success mb-4 py-4" role="alert">
    <div class="d-flex">
        <i data-feather="info" width="32" height="32"></i>
        <div class="px-3">
        Instruction :<br>
การผ่านแต่ละ session จะต้องได้รับการอนุมัติให้ผ่านจากผู้สอนเท่านั้นจึงจะสามารถผ่าน
ไปเรียนใน session ถัดไปได้ ซึ่งผู้เรียนจะต้องปฏิบัติตามดังนี้<br>
<li>ผู้เรียนจำเป็นต้องดู vdo ให้ครบทุกคลิปที่มี<br>
<li>ทำแบบทดสอบ Mini test<br>
<li>ทำแบบสำรวจ (Evaluation form) เมื่อเรียนเสร็จแล้วทุกครั้ง<br>
<li>ทำ workshop ตามคำสั่งที่ได้รับแล้วแนบไฟล์ส่งเข้าระบบเพื่อรอ comment จากผู้สอนกลับไป

        </div>
    </div>
</div>
';
}

?>

<?php
if(isset($_GET['sid'])){
    $rs = mysqli_query($conn,"SELECT `vid` FROM `db_ld_log_vdo` WHERE `uid` = ".$_SESSION['ses_uid']." ORDER BY `vid` DESC LIMIT 1");
    $row = mysqli_fetch_assoc($rs);
    $currentview = $row['vid'];

    $rs = mysqli_query($conn,"SELECT id FROM `db_ld_vdo` WHERE `id` > $currentview AND `sid` = ".$_GET['sid']." and status > 0  
    ORDER BY `id` ASC LIMIT 1");
    $row = mysqli_fetch_assoc($rs);
    $nextview = $row['id'];

    $rs = mysqli_query($conn,"SELECT * FROM `db_ld_vdo` WHERE `sid` = ".$_GET['sid']." AND `status` > 0");
    $button_label = 'Watch';
    $go_mod = '-vdo';
    $go_name = 'vid';
    
}else{    
    $rs = mysqli_query($conn,"SELECT * FROM `db_ld_log_workshop` WHERE `uid` = ".$_SESSION['ses_uid']." AND `status` > 1");
    while($row=mysqli_fetch_assoc($rs)){
        $comments[$row['sid']] = [
            $row['status'],
            $row['read_at'],
        ];
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_ld` WHERE `status` > 0 ORDER BY session ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $pl[] = $row['id'];
    }

    $rs = mysqli_query($conn,"SELECT DISTINCT sid FROM `db_ld_log_workshop` WHERE `uid` = ".$_SESSION['ses_uid']." AND `status` > 2");
    while($row=mysqli_fetch_assoc($rs)){
        $viewed[] = $row['sid'];
    }

    if(!isset($viewed)){
        $viewed[] = $pl[0];
    }else{
        $next = count($viewed);
        $viewed[] = $pl[$next];
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_ld` WHERE `status` > 0 ORDER BY session ASC");

    $button_label = 'Start';
    $go_mod = '';
    $go_name = 'sid';
}

$i = 0;

// echo json_encode($comments);

while($row=mysqli_fetch_assoc($rs)){
    if(isset($_GET['sid'])){
        $tn = 'https://img.youtube.com/vi/'.$row['youtube_id'].'/mqdefault.jpg';
        $sub_id = $row['vdo'];

    }else{
        $tn = 'uploads/ld/'.$row['pix'];
        $sub_id = $row['session'];
        $button = '<a href="?mod=ld'.$go_mod.'&'.$go_name.'='.$row['id'].'" class="btn w-sm mb-1 btn-rounded btn-outline-info mt-3">'.$button_label.'</a>';
    }

    if(in_array($row['id'],$viewed)){
        $textcolor = $opacity = '';
        $button = '<a href="?mod=ld'.$go_mod.'&'.$go_name.'='.$row['id'].'" class="btn w-sm mb-1 btn-rounded btn-outline-info mt-3">'.$button_label.'</a>';

    }else{
        $textcolor = ' style="color:#999;"';
        $opacity = ' style="opacity: 0.5;"';
        $button = '<button class="btn w-sm mb-1 btn-rounded btn-outline-info mt-3" disabled>'.$button_label.'</button>';

    }

echo '<div class="row mb-3">
    <div class="col-md-3"><img src="'.$tn.'" class="img-fluid"'.$opacity.'></div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-9">
                <h4'.$textcolor.'>'.$page_prefix.' '.$sub_id.' : '.$row['title'].'</h4>';

                // <i class="mr-1" data-feather="calendar"></i> อบรมวันที่ '.webdate($row['train_date_from']).' - '.webdate($row['train_date_to']).'<br>
            echo '</div>
            <div class="d-none">
                จำนวนที่รับสมัคร: 2 คน
            </div>
        </div>
        '.$row['detail'].'
        
        <div class="row mt-5">
            <div class="col-6">
                '.$button.'
            </div>
            <div class="col-6 text-right">';
            if(isset($comments[$row['id']])){
                echo '  <a class="nav-link px-2 mr-lg-2" href="?mod=ld-comment&sid='.$row['id'].'">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>';
                if($comments[$row['id']][1]==null){
                    echo '<span class="badge badge-pill badge-up bg-danger">N</span>';
                }
                echo '</a>';
            }
        echo '</div>
        </div>
    </div>
</div>';
$i++;
}

if(isset($_GET['sid'])){
    echo '<div class="text-right">';
    if(end($viewed)==null){
        // if($_GET['sid']==5){
        //     echo '<a href="?mod=ld-workshop&sid='.$_GET['sid'].'" class="btn btn-primary">Workshop</a>';
        // }else{
            echo '<a href="?mod=ld-minitest&sid='.$_GET['sid'].'" class="btn btn-primary">Mini Test</a>';
        // }

    }else{
        echo '<button class="btn btn-primary" disabled>Mini Test</button>';

    }
    echo '</div>';
}

?>