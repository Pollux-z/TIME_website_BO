<?php 
    // echo json_encode($teamlead_direct);
    $start_year = 2023;

    $rss = mysqli_query($conn,"SELECT `id`, `name`, `nick`, `position`,end_date FROM `db_employee`");
    $i = 0;
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = [
            $roww['name'],
            $roww['nick'],
            $roww['position']
        ];

        if($roww['end_date']==null){
            $time11[$roww['id']] = $roww['nick'].' ('.$roww['id'].')';
            $i++;
        }
    }
    
    $rss = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
    $roww=mysqli_fetch_assoc($rss);
    $edits = json_decode($roww['edits']);

    echo '<div class="text-right">';
    if(in_array($mod,$edits)||$_SESSION['ses_ulevel']==9||isset($teamlead)){
        echo '<a href="?mod='.$mod.'&page=my">MYSELF</a> | 
        <a href="?mod='.$mod.'">REQUEST</a> | <a href="?mod='.$mod.'&page=balance">BALANCE</a>';
    }
    if(in_array($mod,$edits)||$_SESSION['ses_ulevel']==9){
        echo ' | 
        <a href="?mod=timeoff&page=summary">SUMMARY</a>';
        // if($_SESSION['ses_uid']==12){
            // echo ' | <a href="?mod=timeoff&page=topup">TOPUP HISTORY</a>';
        // }

    }
    echo '</div>';

    $types = [
        'v' => 'Vacation',
        'p' => 'Personal',
        's' => 'Sick',
        'w' => 'w/o Pay',
    ];

    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }else{
        $year = date(Y);
    }

    if($_GET['page']=='topup'){?>                
        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
        <thead>
        <tr class="text-center">
        <th>#</th>
        <th>name</th>
        <th>top-up (days)</th>
        <th>note</th>
        <th>vacation balance</th>
        <th>date</th>
        </tr> </thead> <tbody>
<?php
    $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_topup`");
    while($row=mysqli_fetch_assoc($rs)){
        echo '<tr>
        <td>'.$row['id'].'</td>
        <td>'.$time1[$row['eid']][0].' ('.$time1[$row['eid']][1].')
        <div class="item-except text-muted text-sm h-1x">'.$time1[$row['eid']][2].'</div>
        </td>
        <td class="text-center">'.$row['days'].'</td>
        <td>'.$row['note'].'</td>
        <td class="text-center"><span class="badge bg-success-lt">'.floatval($row['vacation_day']).'</span></td>
        <td>'.$row['created_at'].'</td>
        </tr>';
        }?>
</tbody>
</table>
<?php    }elseif($_GET['page']=='summary'){
        echo '<div class="text-right text-uppercase">
        <a href="?mod=timeoff&page=summary&year='.$year.'&type=v">Vacation</a> | 
        <a href="?mod=timeoff&page=summary&year='.$year.'&type=p">Personal</a> | 
        <a href="?mod=timeoff&page=summary&year='.$year.'&type=s">Sick</a></div>'; 

        $rs = mysqli_query($conn,"SELECT b.uid,month(a.date) month,b.ttype,a.half FROM `db_timeoff_date` a join db_timeoff b where a.tid = b.id and b.status = 2 and a.date like '$year-%'");
        while($row=mysqli_fetch_assoc($rs)){
            $dt[$row['month']][$row['uid']][$row['ttype']] = $row['half']+$dt[$row['month']][$row['uid']][$row['ttype']];
        }

        if(isset($_GET['type'])){
            $type = $_GET['type'];
        }else{
            $type = 'v';
        }
    
        ?>

        <div class="text-center">
            <?php
            
            for($i=$start_year;$i>=2020;$i--){
                $y[] = '<a href="?mod='.$mod.'&page='.$page.'&type='.$type.'&year='.$i.'">'.$i.'</a>';
            }

            echo implode(' | ',$y);

            echo '<h3 class="text-left">'.$types[$type].'</h3>';
            
            ?>
            
        </div>

        <?php if(in_array($mod,$edits)){?>
        <div class="text-right mb-3">
            <a href="/excel/?mod=timeoff-summary&type=<?php echo $type;?>&year=<?php echo $year;?>" class="btn btn-sm btn-white">Excel</a>
        </div>
        <?php }?>


        <!-- <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable"> -->
        <table id="tableSummary" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
        <thead>
        <tr class="text-center">
        <th><?php echo $year;?></th>
        <?php foreach($tmo as $k => $v){echo '<th>'.$v.'</th>';}?>
        <th>Total</th>
        </tr> </thead> <tbody>
        
        <?php
        $month = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
        ];    
        $lc = [
            'v' => 'success',
            'p' => 'primary',
            's' => 'danger',
        ];             
        
        // if(isset($teamlead)){    
        //     $rss = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `parent` = ".$_SESSION['ses_uid']." AND `end_date` IS NULL");
        //     while($row=mysqli_fetch_assoc($rss)){
        //         $subords[] = $row['id'];
        //     }

        //     $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `end_date` IS NULL and id IN (".implode(',',$subords).")");

        // }else{
            $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `end_date` IS NULL and id >2");
        // }
        
        while($row=mysqli_fetch_assoc($rs)){
            $total = 0;
            ?>
        <tr class="text-center">
            <td class="text-left">
                <?php
                    echo $row['nick'];
                ?>
            </td>
            <?php for($i=1;$i<=12;$i++){?>
            <td><?php

                echo '<span class="badge bg-'.$lc[$type].'">'.$dt[$i][$row['id']][$type].'</span>';
                $total = $dt[$i][$row['id']][$type]+$total;
                $month[$i] = $dt[$i][$row['id']][$type]+$month[$i];
        
            ?></td>
            <?php }?>
            <td>
                <?php echo $total;?>
            </td>
        </tr>
        <?php }?>
        <tfoot style="font-weight:bold;">
            <tr class="text-center">
                <td>Total</td>
                <?php 
                        $total = 0;
        
                for($i=1;$i<=12;$i++){?>
                <td><?php
        
        
                if(isset($dt[$i])){
                    echo '<span class="badge bg-'.$lc[$type].'">'.$month[$i].'</span>';        
                    $total = $month[$i]+$total;
                }
        
                ?></td>
                <?php }?>
                <td>
                    <?php echo '<span class="badge bg-'.$lc[$type].'">'.$total.'</span>';?>
                </td>
            </tr>
          </tfoot>
        </table>
        
        <?php 
        // echo json_encode($month);
    }elseif($page=='balance'){
        if(in_array($mod,$edits)){
        ?>
    <div class="text-right"><a href="?mod=timeoff&page=topup">TOPUP HISTORY</a></div>
    <?php }?>

    <div class="text-center">
        <?php
        
        for($i=$start_year;$i>=2020;$i--){
            $y[] = '<a href="?mod='.$mod.'&page='.$page.'&year='.$i.'">'.$i.'</a>';
        }

        echo implode(' | ',$y);
        
        ?>
        <!-- <a href="?mod=<?php echo $mod.'&page='.$page;?>&year=2022">2022</a> | 
        <a href="?mod=<?php echo $mod.'&page='.$page;?>&year=2021">2021</a> | 
        <a href="?mod=<?php echo $mod.'&page='.$page;?>&year=2020">2020</a> -->
    </div>

    <?php if(in_array($mod,$edits)){?>
    <div class="text-right mb-3">
        <a href="/excel/?mod=timeoff-balance&year=<?php echo $year;?>" class="btn btn-sm btn-white">Excel</a>
    </div>
    <?php }
    
    // echo json_encode($edits).'55';?>

<div class="table-responsive">
    <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
        <thead>
            <tr>
                <th><span class="text-muted">#</span></th>                                   
                <th><span class="text-muted">รูป</span></th>
                <th><span class="text-muted">ชื่อ / ตำแหน่ง</span></th>
                <th><span class="text-muted"><?php echo $year;?> Vacation</span></th>
                <th><span class="text-muted">Vacation Left</span></th>
                <th><span class="text-muted">Personal Left</span></th>
                <th><span class="text-muted">Sick Left</span></th>
                <!-- <th><span class="text-muted">Status</span></th> -->
                <th></th>
            </tr>
        </thead>
        <tbody><?php

if(in_array($mod,$edits)){
    $rss = mysqli_query($conn,"SELECT `id`, `name`, `nick`, `position`,end_date FROM `db_employee` WHERE end_date is null and id > 2");

}else{
    $rss = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `parent` = ".$_SESSION['ses_uid']." AND `end_date` IS NULL");
    while($row=mysqli_fetch_assoc($rss)){
        $subords[] = $row['id'];
    }

    $rss = mysqli_query($conn,"SELECT `id`, `name`, `nick`, `position`,end_date FROM `db_employee` WHERE end_date is null and id IN (".implode(',',$subords).")");


}
    $i = 0;
    while($roww=mysqli_fetch_assoc($rss)){
        $uid = $roww['id'];
                    echo '<tr class=" " data-id="'.$roww['id'].'">
                            <td style="text-align:center">
                                <small class="text-muted">'.$roww['id'].'</small>
                            </td>
                            <td>
                                <div class="avatar-group ">
                                    <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                                        <img src="';
                                        $file = 'uploads/employee/'.$roww['id'].'.jpg';
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
                                echo $roww['name'].' ('.$roww['nick'].')';
                                echo '<div class="item-except text-muted text-sm h-1x">
                                '.$roww['position'].'
                                </div>
                            </td>
                            <td class="text-center">';
                            $days = [
                                'v' => 0,
                                'p' => 0,
                                's' => 0,
                            ];
                            $rs = mysqli_query($conn,"SELECT a.date,a.tid,ttype,half FROM `db_timeoff_date` a join db_timeoff b where a.tid = b.id and b.status = 2 and b.uid = $uid and a.date like '$year-%'");
            
                            while($row=mysqli_fetch_assoc($rs)){
                                $days[$row['ttype']] = $row['half']+$days[$row['ttype']];
                                $dates[] = $row['date'].'/'.$row['tid'];
                            }

                            // $rs = mysqli_query($conn,"SELECT vacation_day FROM `db_employee` WHERE `id` = $uid");
                            $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_vacation` WHERE `year` = '$year' AND `uid` = $uid");
                            
                            $row = mysqli_fetch_assoc($rs);
                            $personal_day = 7;
                            $sick_day = 30;
            
                            $left = $row['day']-$days['v'];  

                            echo '<span class="badge bg-success-lt">'.floatval($row['day']).'</span></td>
                            <td class="text-center">';
            
                            // echo json_encode($days);
                                        
                            echo '<span class="badge bg-success">'.$left.'</span>';
            
                            // echo ' - '.implode(', ',$dates);
                            unset($dates);
                                            
                                            
echo '                            </td>
<td class="text-center">';
                            $left = $personal_day-$days['p'];
                            echo '<span class="badge bg-primary">'.$left.'</span></td>
                            <td class="text-center">';
                            $left = $sick_day-$days['s'];
                            echo '<span class="badge bg-danger">'.$left.'</span></td><td>';
                    if(in_array($mod,$edits)){
                           echo '
                                <a href="?mod=timeoff-edit&page=balance&id='.$uid.'" class="text-muted" title="เพิ่มวันพักร้อน">
                                    <i data-feather="file-plus"></i>
                                </a>
                                ';
}
echo '
                        </td>';
                        echo '</tr>';
                }
            ?>                                        
        </tbody>
    </table>
</div>
    
<?php }else{?>
<div class="row">

    <div class="col-12">
        <div class="alert bg-success my-4 py-4" role="alert">
            <div class="d-flex">
                <i data-feather="info" width="32" height="32"></i>
                <div class="px-3">
                    Please submit the times you need to take off work and the type of leave you are taking. The Time off request must be submitted and approved by Supervisor at least 1 day before your requested leave day.<br>
                    ระบุประเภทของการลา วันและเวลาที่ต้องการขอลา แบบฟอร์มการลาจะต้องถูกส่งและอนุมัติก่อนการลาอย่างน้อย 1 วัน ยกเว้นกรณีลาป่วย
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <table class="table table-theme">
            <tr>
            <?php
    if($_SESSION['ses_ulevel']>=1){    
        $rss = mysqli_query($conn,"SELECT DISTINCT date FROM `db_timeoff_date` a join db_timeoff b WHERE b.ttype not like 'a' and a.date >= '$today' and a.tid = b.id and b.status IN (1,2,4) ORDER BY a.`date` ASC limit 5");
        while($roww=mysqli_fetch_assoc($rss)){
            $days[] = $roww['date'];
        }

        $sql = "SELECT date,time,ttype,uid FROM `db_timeoff_date` a join db_timeoff b where b.ttype not like 'a' and a.tid = b.id and b.status IN (1,2,4) and a.date in ('".implode('\',\'',$days)."')";
        $rss = mysqli_query($conn,$sql);
        while($roww=mysqli_fetch_assoc($rss)){
            $lefts[$roww['date']][] = [
                $roww['uid'],
                $roww['ttype'],
                $roww['time'],
            ];
        }

        $tmr = new DateTime('tomorrow');       

        function getWeekday($date) {
            return date('D', strtotime($date));
        }

        // echo json_encode($lefts);
        foreach($days as $v){
            echo '<td class="border-right" width="20%">
                        <small><div class="text-primary">'.getWeekday($v).' '.webdate($v);
                        if($v==date("Y-m-d")){
                            echo ' (วันนี้)';
                        }elseif($v==$tmr->format('Y-m-d')){
                            echo ' (พรุ่งนี้)';
                        }
                        echo '</div>';

                        foreach($lefts[$v] as $w){
                            echo $time1[$w[0]][1].' - '.$types[$w[1]];
                            if($w[2]=='pm'){
                                echo ' (ครึ่งวันบ่าย)';
                            }elseif($w[2]=='am'){
                                echo ' (ครึ่งวันเช้า)';
                            }
                            echo '<br>';
                        }
                        
                        echo '</small>
                    </td>';
        }    
    }
?>
            </tr>
        </table>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
        <thead>
            <tr>
                <th><span class="text-muted">#</span></th>                                   
                <th><span class="text-muted">รูป</span></th>
                <th><span class="text-muted">ชื่อ / ตำแหน่ง</span></th>
                <th><span class="text-muted">Type</span></th>
                <th><span class="text-muted">Reason</span></th>
                <th><span class="text-muted">Dates</span></th>
                <th><span class="text-muted">Status</span></th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php
    $sql = "SELECT a.* FROM `db_timeoff_date` a join db_timeoff b where a.tid = b.id and b.status != 0 ORDER BY `date` ASC";
    $rss = mysqli_query($conn,$sql);
    while($roww=mysqli_fetch_assoc($rss)){
        $chkdt[$roww['tid']][] = $roww['date'];
        $dates[$roww['tid']][] = webdate($roww['date']);
        $half[$roww['tid']] = $roww['time'];
    }

    // echo '<!--'.json_encode($half).'-->';
    // echo '<!--'.$sql.'-->';

    // echo json_encode($dates);

    // $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff` WHERE `status` != 0 ORDER BY id DESC");
    // $cnt = mysqli_num_rows($rs);

    // echo 'โครงการที่มีตอนนี้ทั้งหมด '.$cnt;  

    $statuses = [
        1 => ['Pending','warning'],
        2 => ['Approved','success'],
        3 => ['Denied','danger'],
        4 => ['Approved 1','info'],
    ];

    while($row=mysqli_fetch_assoc($rs)){
    // $owner = $row['owner'];
    // if($owner==''){
    //     $owner = 'TIME';
    // }

    // <a href="?mod='.$md.'-edit&id='.$row['id'].'" class="item-title text-color ">
                    echo '<tr class=" " data-id="'.$row['id'].'">
                            <td style="text-align:center">
                                <small class="text-muted">'.$row['id'].'</small>
                            </td>
                            <td>
                                <div class="avatar-group ">
                                    <a href="?mod=employee-profile&id='.$row['uid'].'" class="avatar ajax w-32" data-toggle="tooltip" title="'.$row['nick'].'">
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
                            <td class="flex">
                                ';

                                // if(in_array('project',$edits)||$_SESSION['ses_ulevel']>7){
                                //     echo '<a href=?mod=project-edit&id='.$row['id'].'>'.$row['name'].'</a>';

                                // }else{
                                //     echo $row['name'];

                                // }

                                // if($row['status']==3){
                                //     echo ' <span class="item-badge badge text-uppercase  bg-success  ">
                                //     Finished
                                // </span>';
                                // }
                                echo '<div class="item-except text-muted text-sm h-1x">
                                '.$types[$row['ttype']].'</div>
                            </td>
                            <td>';
                            // $time1_ids = json_decode($row['time1_ids']);

                            // foreach($time1_ids as $v){
                            //     $team_list[] = $time1[$v];
                            // }

                            // echo implode(', ',$team_list);
                            // $team_list = '';

                            echo $row['reason'].'</td>
                            <td><span class="item-amount d-none d-sm-block text-sm [object Object]">
                            ';
                
                            echo implode(',<br>',$dates[$row['id']]);

                            if($half[$row['id']]=='pm'){
                                echo '<br>(ครึ่งวันบ่าย)';

                            }elseif($half[$row['id']]=='am'){
                                echo '<br>(ครึ่งวันเช้า)';
                            }

                            echo '
                            </span></td>
                            <td>
                                
                                <span class="badge badge-'.$statuses[$row['status']][1].' text-uppercase">
                                '.$statuses[$row['status']][0].'
            
    </span>
                            </td><td>';
                            if(in_array($mod,$edits)){
                                echo '<div class="item-action dropdown">
                                     <a href="#" data-toggle="dropdown" class="text-muted">
                                         <i data-feather="more-vertical"></i>
                                     </a>
                                     <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                                         <a class="dropdown-item" href="?mod=timeoff-edit&id='.$row['id'].'">
                                             Edit
                                         </a>';
                                     if($row['status']!=2){
                                         echo '<a class="dropdown-item" href="action.php?mod=timeoff&status=2&id='.$row['id'].'">
                                             Approve
                                         </a>';
                                     }
                                     if($row['status']!=3){
                                         echo '<a class="dropdown-item download" href="action.php?mod=timeoff&status=3&id='.$row['id'].'">
                                             Deny
                                         </a>';
                                     }
     
                                         echo '<div class="dropdown-divider"></div>
                                         <a class="dropdown-item trash" href="action.php?mod=del&page=timeoff&id='.$row['id'].'">
                                             Delete item
                                         </a>
                                      </div>';
     echo '                            </div>';
     
         }elseif(isset($teamlead)&&$row['status']!=2&&$row['status']!=3&&in_array($row['uid'],$teamlead_direct)){
            echo '<div class="item-action dropdown">
                 <a href="#" data-toggle="dropdown" class="text-muted">
                     <i data-feather="more-vertical"></i>
                 </a>
                 <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">';
                 if($row['status']==1){
                 echo '
                     <a class="dropdown-item" href="?mod=timeoff-edit&id='.$row['id'].'">
                         Edit
                     </a>';
                 }
                 if($row['status']!=4){
                     echo '<a class="dropdown-item" href="action.php?mod=timeoff&status=4&id='.$row['id'].'">
                         Approve
                     </a>';
                 }
                 if($row['status']!=3){
                     echo '<a class="dropdown-item download" href="action.php?mod=timeoff&status=3&id='.$row['id'].'">
                         Deny
                     </a>';
                 }

echo '                            </div>';

}elseif($row['uid']==$_SESSION['ses_uid']&&date("Ymd")<str_replace('-','',$chkdt[$row['id']][0])){
        echo '<div class="item-action dropdown">
        <a href="#" data-toggle="dropdown" class="text-muted">
            <i data-feather="more-vertical"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">';
            if($row['status']==1){
                echo '<a class="dropdown-item" href="?mod=timeoff-edit&id='.$row['id'].'">
                    Edit
                </a><div class="dropdown-divider"></div>';
            }
            echo '
            <a class="dropdown-item trash" href="action.php?mod=del&page=timeoff&id='.$row['id'].'">
                Delete item
            </a>
         </div>';
echo '                            </div>';        
    }
echo '
                        </td>';
    //                         <td>
    //                             <span class="item-amount d-none d-sm-block text-sm [object Object]">
    //                             '.$row['end_date'].'
    // </span>
    //                         </td>';
                            // <td>
                            //     <div class="item-action dropdown">
                            //         <a href="#" data-toggle="dropdown" class="text-muted">
                            //             <i data-feather="more-vertical"></i>
                            //         </a>
                            //         <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                            //             <a class="dropdown-item" href="#">
                            //                 See detail
                            //             </a>';

                                        


                            //             echo '<a class="dropdown-item edit" href="?mod='.$md.'-edit&id='.$row['id'].'">
                            //                 Edit
                            //             </a>
                            //             <div class="dropdown-divider"></div>
                            //             <a class="dropdown-item trash">
                            //                 Delete item
                            //             </a>
                            //         </div>
                            //     </div>
                            // </td>

                        echo '</tr>';
                }
            ?>                                        
            


            
        </tbody>
    </table>
</div>
<?php }?>