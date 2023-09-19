<?php
    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    if($_GET['alert']=='safedrive'){
        echo '<div class="alert alert-success" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">บันทึกเรียบร้อย ตอนคืนอย่าลืม Scan คืนด้วยจ้า</span>
    </div>';

    }elseif($_GET['alert']=='welcomeback'){
        echo '<div class="alert alert-success" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">บันทึกเรียบร้อย Welcome back!</span>
    </div>';

    }


?>
                            <div class="row">

<?php

$assets = [
    // 'recorder' => 'Recorder',
    // 'clicker' => 'Clicker',
    // 'usbc' => 'USB Type C Hub',

    // 'webcam' => 'Conference Camera',
    // 'zoom' => 'Zoom',
    // 'meetingroom' => 'Meeting Room',

    'skilllane' => 'SkillLane',
    'udemy' => 'Udemy',
    'edumall' => 'EduMall',
    
    // 'pocketwifi' => 'Pocket WIFI',
];

// foreach($assets as $k => $v){

    $rs = mysqli_query($conn,"SELECT * FROM `db_course` ORDER BY `name` ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $k = $row['id'];
        $v = $row['name'];
    ?>                                <div class="col-sm-4">
    <div class="card">
        <div class="media media-2x1 gd-primary">
            <a class="media-content" href="?mod=asset-edit&code=<?php echo $k;?>" style="background-image:url(uploads/asset/<?php echo $row['owner'];?>.jpg);<?php 
            
            $rss = mysqli_query($conn,"SELECT uid_go,date_back FROM `db_asset` WHERE `code` LIKE '$k' ORDER BY `id` DESC limit 1");
            $roww = mysqli_fetch_assoc($rss);
            
            if(mysqli_num_rows($rss)>0&&$roww['date_back']==null){
                $br = ' <span class="badge badge-danger">'.$time1[$roww['uid_go']].'ใช้อยู่</span>';
                echo 'filter: grayscale(100%);';
            }
            
            ?>">
                <strong class="text-fade"></strong>
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $v;?>                                            
                <?php echo $br;?>                                   
            </h5>
            <?php 
            // if($k=='zoom'){
                $now = date("Y-m-d H:i:s");
                $rss = mysqli_query($conn,"SELECT * FROM `db_reserve` WHERE `code` LIKE '$v' AND `start_date` <= '$now' and end_date >= '$now' and status = 2");
                if(mysqli_num_rows($rss)!=0){
                    $roww = mysqli_fetch_assoc($rss);
                    echo '<b>Now: '.$time1[$roww['uid']].' '.substr($roww['start_date'],11,5).'-'.substr($roww['end_date'],11,5).' น.</b><br>';
                }

                $sql = "SELECT * FROM `db_reserve` WHERE `code` LIKE '$k' AND start_date > '$now' and status = 2 ORDER BY `start_date` ASC";
                // echo $sql;
                $rss = mysqli_query($conn,$sql);

                if(mysqli_num_rows($rss)!=0){                    
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

                    while($roww = mysqli_fetch_assoc($rss)){
                        if(substr($roww['start_date'],0,10)==$tmr->format('Y-m-d')){
                            $day = 'พรุ่งนี้';
                            
                        }elseif(substr($roww['start_date'],0,10)==date("Y-m-d")){
                            $day = 'วันนี้';
                        
                        }else{
                            $ds = explode('-',substr($roww['start_date'],5,5));
                            $day = (int)$ds[1].' '.$ms[$ds[0]];
        
                        }
    
                        echo 'Next: '.$time1[$roww['uid']].' '.$day.' '.substr($roww['start_date'],11,5).'-'.substr($roww['end_date'],11,5).' น.</b><br>';
                    }

                }else{
                    echo 'ยังไม่มีคนจอง';
                }
                // while($roww = mysqli_fetch_assoc($rss)){
                //     echo 'Next: '.$time1[$roww['uid']].' '.$roww['start_date'].'-'.$roww['end_date'];
                // }

                // echo 'Now: เมย์ 11:30-13:00<br>Next: วิน พรุ่งนี้ 8:00-16:00';}else{echo 'ยังไม่มีคนจอง';
                // }
                ?>            
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <a href="?mod=asset-edit&code=<?php echo $k;?>" id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">
                        Record
                    </a>
                </div>
                <div class="col-6 text-right">
                    <a href="?mod=reserve-edit&code=<?php echo $k;?>" id="btn-reserve" class="btn btn-sm box-shadows btn-rounded gd-secondary text-white">
                        Reserve
                    </a>
                </div>
            </div>
        </div>
    </div>
</div><?php
unset($br);
}

?>

                            </div>



                            <div class="table-responsive">
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