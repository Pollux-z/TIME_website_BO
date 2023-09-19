<?php
$rs = mysqli_query($conn,"INSERT INTO `db_ld_log_vdo` (`uid`, `vid`) VALUES ('".$_SESSION['ses_uid']."', '".$_GET['vid']."');");    

$rs = mysqli_query($conn,"SELECT * FROM `db_ld_vdo` WHERE `id` = ".$_GET['vid']." AND `status` > 0");
$dt = mysqli_fetch_assoc($rs);

?><style type="text/css">
    .video-container { position: relative; padding-bottom: 56.25%; padding-top: 30px; height: 0; overflow: hidden; }

    .video-container iframe, .video-container object, .video-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>

<h2>Video <?php echo $dt['vdo'].' : '.$dt['title'];?></h2>

<div class="video-container">
    <iframe id="ytplayer" type="text/html" width="720" height="405" src="https://www.youtube.com/embed/<?php echo $dt['youtube_id'];?>?autoplay=1&modestbranding=1" frameborder="0" allowfullscreen></iframe>
</div>

<div class="text-right mt-3">
    <a href="?mod=ld&sid=<?php echo $dt['sid'];?>" class="btn btn-primary">Back</a>
</div>