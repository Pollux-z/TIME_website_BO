<?php
    $page = 'quiz';
    if(isset($_GET['answer'])){
        $sid = $_GET['answer'];

    }else{
        $sid = $_GET['sid'];

    }
    
    $rs = mysqli_query($conn,"SELECT session,`title` FROM `db_ld` WHERE `id` = $sid AND `status` > 0");
    $row = mysqli_fetch_assoc($rs);

    $session = $row['session'];
    $session_title = $row['title'];

    // $rs = mysqli_query($conn,"SELECT * FROM `db_ld_minitest` WHERE id = 2 AND `status` > 0");
    // $dt = mysqli_fetch_assoc($rs);

    $card_header = 'Mini Test Session '.$session.' : '.$session_title;

    $rs = mysqli_query($conn,"SELECT qid FROM `db_ld_log_minitest` WHERE `uid` = ".$_SESSION['ses_uid']." AND `status` > 0");
    $cnt = mysqli_num_rows($rs);

    if($cnt>0){
        while($row=mysqli_fetch_assoc($rs)){
            $answered[] = $row['qid'];
        }
    
        $rs = mysqli_query($conn,"SELECT *  FROM `db_ld_minitest` WHERE id not in (".implode(',',$answered).") and `sid` = $sid AND `status` > 0 ORDER BY `quiz` ASC limit 1");
    
    }else{
        $rs = mysqli_query($conn,"SELECT *  FROM `db_ld_minitest` WHERE `sid` = $sid AND `status` > 0 ORDER BY `quiz` ASC limit 1");

    }

    if(mysqli_num_rows($rs)==0){
        echo '<div class="card">
        <div class="card-header">
            <strong>'.$card_header.'</strong>
        </div>                                    
        <div class="card-body">';

        // if(isset($_GET['answer'])){
        // }else{
            echo '<div class="text-center">';
            $rs = mysqli_query($conn,"SELECT id FROM `db_ld_minitest` WHERE `sid` = $sid AND `status` > 0");
            while($row=mysqli_fetch_assoc($rs)){
                $qids[] = $row['id'];
            }

            $rs = mysqli_query($conn,"SELECT * FROM `db_ld_log_minitest` WHERE `uid` = ".$_SESSION['ses_uid']." AND `qid` IN (".implode(',',$qids).") AND `status` > 0");
            while($row = mysqli_fetch_assoc($rs)){
                $scores[$row['qid']] = $row['score'];
            }

            $sum_score = array_sum($scores);

            // if($sum_score>3){
            if($sum_score>3||($sid==5&&$sum_score>=3)){
                $color = 'success';
                $feature = 'x';
                $polyline = '<polyline points="20 6 9 17 4 12"></polyline>';
                $next = '<a href="?mod=ld-workshop&sid='.$sid.'" class="btn btn-primary">Workshop</a>';

            }else{
                $color = 'danger';
                $feature = 'x';
                $polyline = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
                $next = '<a href="action.php?mod=ld&reexam='.$sid.'" class="btn btn-primary">Re-Exam</a>';
            }

            echo '<h2>Total Score<br>
        
            <div class="avatar w-56 m-2 no-shadow gd-'.$color.' mx-auto">        
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-'.$feature.' mx-2">'.$polyline.'</svg>
            </div>
            '.$sum_score.'/'.count($qids).'</h2>
            
            <div class="text-left">';

            $rs = mysqli_query($conn,"SELECT * FROM `db_ld_minitest` WHERE `sid` = ".$_GET['sid']." AND `status` > 0 ORDER BY `quiz` ASC");
            while($dt=mysqli_fetch_assoc($rs)){
                $answer = $dt['answer'];
                ?><h4><?php echo $dt['quiz'].'. '.$dt['title'];?></h4>
                <?php
        
                if($dt['pix']!=''){
                    echo '<img src="uploads/ld/'.$dt['pix'].'" class="border mb-3" style="max-width: 640px;"><br>';
                }
        
                if($dt['choices']=='pix'){
                    for($i=1;$i<=4;$i++){
                        echo '                                                    <div class="mb-3">
                            <label class="md-check">
                                <input type="radio" name="minitest" value="'.$i.'"';
                                if($i==$answer){
                                    echo ' checked';
                                }
                                echo ' disabled>
                                <i class="blue"></i>
                                <img src="uploads/ld/q'.$dt['id'].'-'.$i.'.png" style="max-width:200px;">
                            </label>
                        </div>
';
                    }
                }else{
                    foreach(json_decode($dt['choices']) as $k => $v){
                        $j = $k+1;
                        echo '                                                    <div class="mb-3">
                            <label class="md-check">
                                <input type="radio" value="'.$j.'"';
                                if($j==$answer){
                                    echo ' checked';
                                }
                                echo ' disabled>
                                <i class="blue"></i>
                                '.$v.'
                            </label>
                        </div>
        ';
                    }
                }
        
                ?><?php
            }

            // <a href="?mod=ld-minitest&answer='.$sid.'" class="btn btn-outline-primary">Answer</a>

            echo '</div>
            
            <div class="my-4">                
                '.$next.'
            </div></div>';
    // }

    echo '</div>
    </div>';

    if(isset($_GET['answer'])){
        echo '<div class="text-right">
        <a href="?mod=ld-minitest&sid='.$sid.'" class="btn btn-primary">Back</a>
    </div>';
    }

    }else{
        $dt = mysqli_fetch_assoc($rs);
?>
<form action="action.php" method="post">
    <input type="hidden" name="mod" value="ld">
    <!-- <input type="hidden" name="page" value="result"> -->
    <input type="hidden" name="qid" value="<?php echo $dt['id'];?>">


<div class="card">
                                <div class="card-header">
                                    <strong><?php echo $card_header;?></strong>
                                </div>                                
                                        <div class="card-body">
                                    <h4><?php echo $dt['quiz'].'. '.$dt['title'];?></h4>
                                    <?php
                            
                                    if($dt['pix']!=''){
                                        echo '<img src="uploads/ld/'.$dt['pix'].'" class="border mb-3" style="max-width: 640px;"><br>';
                                    }
                            
                                    if($dt['choices']=='pix'){
                                        for($i=1;$i<=4;$i++){
                                            echo '                                                    <div class="mb-3">
                                                <label class="md-check">
                                                    <input type="radio" name="minitest" value="'.$i.'" required>
                                                    <i class="blue"></i>
                                                    <img src="uploads/ld/q'.$dt['id'].'-'.$i.'.png" style="max-width:200px;">
                                                </label>
                                            </div>
    ';
                                        }
                                    }else{
                                        foreach(json_decode($dt['choices']) as $k => $v){
                                            $j = $k+1;
                                            echo '                                                    <div class="mb-3">
                                                <label class="md-check">
                                                    <input type="radio" name="minitest" value="'.$j.'" required>
                                                    <i class="blue"></i>
                                                    '.$v.'
                                                </label>
                                            </div>
    ';
                                        }
                                    }
                            
                                    ?>
</div>                                
                                
                            </div>

    <div class="text-right">
        <input type="submit" value="Next" class="btn btn-primary">
    </div>
                            </form>
<?php }?>