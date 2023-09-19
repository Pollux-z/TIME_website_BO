<?php
    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    if($_GET['alert']=='safedrive'){
        echo '<div class="alert alert-success" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">บันทึกเรียบร้อย ประชุมเสร็จแล้วอย่าลืม Check-out ด้วยจ้า</span>
    </div>';

    }elseif($_GET['alert']=='welcomeback'){
        echo '<div class="alert alert-success" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">บันทึกเรียบร้อย</span>
    </div>';

    }


?>
                            <div class="row">

<?php

$assets = [
    'meetingroom' => 'Major Meeting Room.',
    'meetingroom2' => 'Minor Meeting Room.',
    'meetingroom3' => 'P\' Dome Meeting Room.',
    // 'meetingroom4' => 'P\' Joy Meeting Room.',
];

foreach($assets as $k => $v){
    ?>                                <div class="col-sm-3">
    <div class="card">
        <div class="media media-2x1 gd-primary">
            <a class="media-content" href="?mod=reserve-edit&code=<?php echo $k;?>" style="background-image:url(uploads/asset/<?php echo $k;?>.jpg);">
                <strong class="text-fade"></strong>
            </a>
        </div>
        <div class="card-body">
            <?php
            echo '<h5 class="card-title">'.$assets[$k].'</h5><p class="card-text">';
            
            $rss = mysqli_query($conn,"SELECT * FROM `db_asset` WHERE `code` LIKE '$k' AND `date_back` IS NULL");
                    
            if(mysqli_num_rows($rss)!=0){
                $roww = mysqli_fetch_assoc($rss);
                $chkedin = 1;
                echo $roww['destination'];
            }else{
                echo 'No Event';
            }
            
            
            echo '</h5>';

            if(isset($chkedin)){
                    echo '<p class="card-text">Check-in time: '.substr($roww['date_go'],11,5).'</p>
                    <p class="card-text">
                        <small class="text-muted">'.$time1[$roww['uid_go']].'</small>
                    </p>';
        
                    echo '<a href="action.php?mod=checkin&code=meetingroom&id='.$roww['id'].'" class="btn btn-sm box-shadows btn-rounded gd-danger text-white">
                        Check-out
                    </a>';
            }
                    
                $now = date("Y-m-d H:i:s");

                ?>            
        </div>
        <div class="card-body">
            <div class="row">
            <div class="col-12 text-center">                    
                    <a href="?mod=reserve-edit&code=<?php echo $k;?>" id="btn-reserve" class="btn btn-sm box-shadows btn-rounded gd-secondary text-white">
                        Reserve
                    </a>
                </div>                
            </div>
        </div>
    </div>

    Next:<br><br>
    <?php
    unset($dt);
    
    $rss = mysqli_query($conn,"SELECT * FROM `db_reserve` WHERE `code` LIKE '$k' AND end_date >= '$now' AND status != 0 ORDER BY `db_reserve`.`start_date` ASC");
    while($roww=mysqli_fetch_assoc($rss)){
        $sd = explode(' ',$roww['start_date']);
        $dt[$sd[0]][] = [
            'time' => $sd[1],
            'rid' => $roww['id'],
            'note' => $roww['note'],
            'uid' => $roww['uid'],
            'end_date' => $roww['end_date'],
        ];
    }

    if(count($dt)==0){
        echo '-';

    }else{     
        $tmr = new DateTime('tomorrow');
        $ms = [
            '01' => 'ม.ค.',
            '02' => 'ก.พ.',
            '03' => 'มี.ค.',
            '04' => 'เม.ย.',
            '05' => 'พ.ค.',
            '06' => 'มิ.ย.',
            '07' => 'ก.ค.',
            '08' => 'ส.ค.',
            '09' => 'ก.ย.',
            '10' => 'ต.ค.',
            '11' => 'พ.ย.',
            '12' => 'ธ.ค.',
        ];

        foreach($dt as $l => $v){
            if(substr($l,0,10)==$tmr->format('Y-m-d')){
                $day = 'พรุ่งนี้';
                
            }elseif(substr($l,0,10)==date("Y-m-d")){
                $day = 'วันนี้';
            
            }else{
                $ds = explode('-',substr($l,5,5));
                $day = (int)$ds[1].' '.$ms[$ds[0]];

            }

            echo $day.'<br>';

            foreach($v as $w){
                echo '<div class="card">
                    <div class="card-body">
                        <h5 class="card-title">'.$w['note'].'</h5>
                        <p class="card-text"><a href="?mod=reserve-edit&id='.$w['rid'].'">'.substr($w['time'],0,5).' - '.substr($w['end_date'],11,5).'</a></p>
                        <p class="card-text">
                            <small class="text-muted">'.$time1[$w['uid']].'</small>
                        </p>';
            
                        if(!isset($chkedin)){
                            echo '<a href="action.php?mod=checkin&code='.$k.'&note='.$w['note'].'" id="btn-reserve" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">
                            Check-in
                        </a>';
                        }
                        

                                echo '
                    </div>
                </div>';
            }
        }
    }
    
    
    ?>


</div><?php
unset($br);
}

?>

                            </div>



                            <div class="table-responsive d-none">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Asset</span></th>
                                            <th><span class="text-muted">Date</span></th>
                                            <th><span class="text-muted">Project / Recorder</span></th>
                                            <th><span class="text-muted">Remark</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_carrec` ORDER BY `id` DESC");
                                            while($row=mysqli_fetch_assoc($rs)){       
                                                
                                                $dg = explode(' ',$row['date_go']);
                                                if($row['date_back']!=null){
                                                    $db = explode(' ',$row['date_back']);
                                                    $time = substr($dg[1],0,5).'-'.substr($db[1],0,5);
                                                    $km_back = $row['km_back'];
                                                }else{
                                                    $time = substr($dg[1],0,5);
                                                }

                                                // number_format($row['km_go']).'
                                                $length = $row['km_back']-$row['km_go'];

                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['id'].'</small>
                                                        </td>
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['code'].'</small>
                                                        </td>
                                                        <td>
                                                            '.$dg[0].'
                                                            <div class="item-except text-muted text-sm h-1x">
                                                            '.$time.'
                                                            </div>
                                                        </td>
                                                        <td class="flex">
                                                            '.$row['destination'].'
                                                            <div class="item-except text-muted text-sm h-1x">
                                                            '.$time1[$row['uid_go']];

                                                            if(isset($km_back)&&$row['uid_go']!=$row['uid_back']){
                                                                echo ', '.$time1[$row['uid_back']];
                                                            }

                                                            echo '</div>
                                                        </td>
                                                        <td>

                                                        '.$row['remark_go'].'
                                                        <div class="item-except text-muted text-sm h-1x">
                                                            '.$row['remark_back'].'
                                                            </div>
                                                        
                                                        </td>
                                                    </tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>