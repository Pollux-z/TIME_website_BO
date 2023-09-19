<?php
        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"ld\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        if(isset($ams[$_SESSION['ses_uid']])){
?>
<div class="row" style="height:50px;">
    <div class="col-6 avatar-group">
        <?php echo implode(' ',$ams);?>
    </div>
    <div class="col-6">
        <div class="btn-group float-right">
            <a href="?mod=ld" class="btn btn-outline-primary">Frontend</a>
            <a href="?mod=ld-comment" class="btn btn-outline-primary">Comment</a>
            <a href="?mod=ld-mat" class="btn btn-outline-primary">Material</a>
            <a href="?mod=ld-feedback" class="btn btn-outline-primary active">Feedback</a>
        </div>
    </div>
</div>
<?php }?>

<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="btn-toolbar mb-3 justify-content-center">
            <div class="btn-group mr-2">
                <?php

                if(isset($_GET['session'])){
                    $session = $_GET['session'];
                }else{
                    $session = 1;
                }
                
                for($i=1;$i<=5;$i++){
                    echo '<a href="?mod=ld-feedback&session='.$i.'" class="btn btn-primary';
                    if($i==$session){
                        echo ' active';
                    }
                    echo '">'.$i.'</a>';
                }
                
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4 text-right">
        <a href="/excel/?mod=ld&session=<?php echo $session;?>" class="btn btn-sm btn-white">Excel</a>
    </div>
</div>

<?php if(isset($_GET['sid'])){
    $rs = mysqli_query($conn,"SELECT * FROM `db_ld_log_workshop` WHERE `uid` = ".$_SESSION['ses_uid']." AND `sid` = ".$_GET['sid']." AND `status` > 0 ORDER BY id DESC");
    $row = mysqli_fetch_assoc($rs);

    if($row['status']==3){
        $color = 'success';
        $feature = 'x';
        $polyline = '<polyline points="20 6 9 17 4 12"></polyline>';
        $next = '<a href="?mod=ld" class="btn btn-primary">Done</a>';

    }else{
        $color = 'danger';
        $feature = 'x';
        $polyline = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
        // $next = '<a href="action.php?mod=ld&reexam='.$_GET['sid'].'" class="btn btn-primary">Re-Exam</a>';
        $next = '<a href="?mod=ld-workshop&sid='.$_GET['sid'].'" class="btn btn-primary">Re-Exam</a>';
    }

    echo '<h2>Examiner Part</h2>

    <div class="row">
        <div class="col-3">
            <div class="avatar w-56 m-2 no-shadow gd-'.$color.' mx-auto">        
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="feather feather-'.$feature.' mx-2">'.$polyline.'</svg>
            </div>
        </div>
        <div class="col-9">
            '.nl2br($row['comment']).'
        </div>
    </div>

    <div class="my-4 text-right">
        '.$next.'
    </div></div>';

    if($row['read_at']==null){
        $wid = $row['id'];
        $rs = mysqli_query($conn,"UPDATE `db_ld_log_workshop` SET `read_at` = NOW() WHERE `id` = $wid;");
    }
?>

<?php }elseif(isset($_GET['id'])){?>
<form action="action.php" method="post">
    <input type="hidden" name="mod" value="ld">
    <input type="hidden" name="wid" value="<?php echo $_GET['id'];?>">
    Name: <?php

$rs = mysqli_query($conn,"SELECT * FROM `db_ld_log_workshop` WHERE `id` = ".$_GET['id']." AND `status` > 0");
$row = mysqli_fetch_assoc($rs);

$uid = $row['uid'];
$sid = $row['sid'];

$rs = mysqli_query($conn,"SELECT `name` FROM `db_employee` WHERE `id` = $uid");
$row = mysqli_fetch_assoc($rs);
echo $row['name'];
    
    ?><br>
    Session: <?php
    
    $rs = mysqli_query($conn,"SELECT * FROM `db_ld` WHERE `id` = $sid");
    $row = mysqli_fetch_assoc($rs);
    echo $row['session'].' - '.$row['title'];
    
    ?><br>
    <input type="radio" name="status" value="2" required> Fail <input type="radio" name="status" value="3" required> Pass<br>
    <textarea name="comment" id="" cols="30" rows="10" placeholder="Comment here"></textarea><br>
    <input type="submit" value="Submit">
</form>
    
<?php }else{
    $rss = mysqli_query($conn,"SELECT `id`, `name`, `nick`, `position`,end_date FROM `db_employee`");
    $i = 0;
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = [
            $roww['name'],
            $roww['nick'],
            $roww['position']
        ];

        // if($roww['end_date']==null){
        //     $time11[$roww['id']] = $roww['nick'].' ('.$roww['id'].')';
        //     $i++;
        // }
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_ld_assessment` WHERE sid = $session");

    // $rss = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
    // $roww=mysqli_fetch_assoc($rss);
    // $edits = json_decode($roww['edits']);

    // if(in_array($mod,$edits)||$_SESSION['ses_ulevel']==9){
    //     echo '<div class="text-right"><a href="?mod='.$mod.'">REQUEST</a> | <a href="?mod='.$mod.'&page=balance">BALANCE</a> | <a href="?mod=timeoff&page=summary">SUMMARY</a>';
    //     echo '</div>';
    // }

?>
<div class="table-responsive">
    <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
        <thead>
            <tr>
                <th><span class="text-muted">#</span></th>                                   
                <th><span class="text-muted">รูป</span></th>
                <th><span class="text-muted">ชื่อ / ตำแหน่ง</span></th>
                <th><span class="text-muted">Session</span></th>
                <th><span class="text-muted">1</span></th>
                <th><span class="text-muted">2</span></th>
                <th><span class="text-muted">3</span></th>
                <th><span class="text-muted">4</span></th>
                <th><span class="text-muted">5</span></th>
            </tr>
        </thead>
        <tbody><?php
    // $sql = "SELECT a.* FROM `db_timeoff_date` a join db_timeoff b where a.tid = b.id and b.status != 0 ORDER BY `date` ASC";
    // $rss = mysqli_query($conn,$sql);
    // while($roww=mysqli_fetch_assoc($rss)){
    //     $chkdt[$roww['tid']][] = $roww['date'];
    //     $dates[$roww['tid']][] = webdate($roww['date']);
    //     $half[$roww['tid']] = $roww['time'];
    // }

    // $statuses = [
    //     1 => ['Pending','warning'],
    //     2 => ['Approved','success'],
    //     3 => ['Denied','danger'],
    // ];

    while($row=mysqli_fetch_assoc($rs)){
                    echo '<tr class=" " data-id="'.$row['id'].'">
                            <td style="text-align:center">
                                <small class="text-muted">'.$row['id'].'</small>
                            </td>
                            <td>
                                <div class="avatar-group ">
                                    <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$row['nick'].'">
                                        <img src="';
                                        $file = 'uploads/employee/'.$row['uid'].'.jpg';
                                        if(file_exists($file)){
                                            echo $file;
                                        }else{
                                            echo '/assets/img/logo.png';
                                        }
                                        echo '" alt=".">
                                    </a>
                                </div>                                                        
                            </td>
                            <td class="flex">';
                                echo $time1[$row['uid']][0].' ('.$time1[$row['uid']][1].')';
                                echo '<div class="item-except text-muted text-sm h-1x">
                                '.$time1[$row['uid']][2].'
                                </div>
                            </td>
                            <td>'.$row['sid'].'</td>';                            
                            foreach(json_decode($row['rates'],true)[1] as $k => $v){
                                echo '<td class="flex">'.$v.'</td>';
                            }
                            echo '</tr>';
                }
            ?>                                        
            


            
        </tbody>
    </table>
</div><?php }?>