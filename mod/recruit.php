<div style="height:60px;">
    <div class="avatar-group float-right">
        <?php

        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"recruit\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        echo implode(' ',$ams);
        ?>
    </div>
</div>

<?php
    $istatuses = [
        '1t' => '<i data-feather="check-circle"></i> 1st',
        '1f' => '<i data-feather="x-circle"></i> 1st',
        '2t' => '<i data-feather="check-circle"></i> 2nd',
        '2f' => '<i data-feather="x-circle"></i> 2nd',
        '3t' => '<i data-feather="check-circle"></i> 3rd',
        '3f' => '<i data-feather="x-circle"></i> 3rd',
    ];
    $statuses = [
        1 => ['Appointed','info'],
        2 => ['ยื่น Offer แล้ว','primary'],
        3 => ['ปฏิเสธ Offer','danger'],
        4 => ['เซ็นต์สัญญาแล้ว','success'],
    ];
    // $rss = mysqli_query($conn,"SELECT `id`, `nick`,edits FROM `db_employee`");
    // while($roww=mysqli_fetch_assoc($rss)){
    //     $time1[$roww['id']] = $roww['nick'];
    //     if($roww['id']==$_SESSION['ses_uid']){
    //         $edits = json_decode($roww['edits']);
    //     }
    // }

    // echo json_encode($edits).$_SESSION['ses_uid'];
?>
<div class="text-right mb-3">
    Interview Status: 
    <a href="?mod=recruit&interview_status=1t"><i data-feather="check-circle"></i> 1st</a> | 
    <a href="?mod=recruit&interview_status=1f"><i data-feather="x-circle"></i> 1st</a> | 
    <a href="?mod=recruit&interview_status=2t"><i data-feather="check-circle"></i> 2nd</a> | 
    <a href="?mod=recruit&interview_status=2f"><i data-feather="x-circle"></i> 2nd</a> | 
    <a href="?mod=recruit&interview_status=3t"><i data-feather="check-circle"></i> 3rd</a> | 
    <a href="?mod=recruit&interview_status=3f"><i data-feather="x-circle"></i> 3rd</a><br>
    HR Status 
    <?php
    $i = 0;
    foreach($statuses as $v){
        $i++;
        echo '<a href="?mod=recruit&status='.$i.'">'.$statuses[$i][0].'</a> | ';
    }
    ?>
    <br>
    <a href="?mod=recruit">View All</a> |
    <a href="?mod=recruit-summary">Summary Report</a>
<?php
    foreach($proj_stts as $k => $v){
        $pjmns[] = '<a href="?mod=project&status='.$k.'">'.$v.'</a>';
    }

    echo implode(' | ',$pjmns);
?>
</div>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Name</span></th>
                                            <th><span class="text-muted">Nickname</span></th>
                                            <th><span class="text-muted">Position</span></th>
                                            <th><span class="text-muted">Interview Status</span></th>
                                            <th><span class="text-muted">Next Interview Date</span></th>
                                            <th><span class="text-muted">Team</span></th>
                                            <th><span class="text-muted">Attach</span></th>
                                            <!-- Create by leo : create function start date -->
                                            <th><span class="text-muted">Start date</span></th>
                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
    // $rs = mysqli_query($conn,"SELECT * FROM `db_recruit` where status >0");
    // $cnt = mysqli_num_rows($rs);

    // echo 'โครงการที่มีตอนนี้ทั้งหมด '.$cnt;  
    while($row=mysqli_fetch_assoc($rs)){
        // $owner = $row['owner'];
        // if($owner==''){
        //     $owner = 'TIME';
        // }

        // <a href="?mod='.$md.'-edit&id='.$row['id'].'" class="item-title text-color ">
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$cnt.'</small>
                                                        </td>                                                        
                                                        <td><a href="?mod=recruit-edit&id='.$row['id'].'">'.$row['name'].'</a></td>
                                                        <td>'.$row['nick'].'</td>
                                                        <td>
                                                        '.$row['position'].'
                                                        </td><td>';
                                                        
                                                        if($row['interview_status']==null){
                                                            echo '-';
                                                        }else{
                                                            if(substr($row['interview_status'],1,1)=='t'){
                                                                echo '<span class="badge badge-success text-uppercase">'.$istatuses[$row['interview_status']].'</span>';
                                                            }else{
                                                                echo '<span class="badge badge-danger text-uppercase">'.$istatuses[$row['interview_status']].'</span>';
                                                            }
                                                        }

                                                        echo '</td>

                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.substr($row['next_interview_date'],0,16).'
                                </span>
                                                        </td>
                                                        <td class="flex">';
                                                        
                                                        echo '<span class="badge badge-'.$statuses[$row['status']][1].' text-uppercase">'.$statuses[$row['status']][0].'</span>';
                                                    
                                                    echo '</td>
                                                        <td>';
                                                        
                                                        if($row['cv']!=null){
                                                            echo '<a href="/uploads/recruit/'.$row['cv'].'" title="CV" target="_blank"><i data-feather="file-text"></i></a>';
                                                        }
                                                        if($row['transcript']!=null){
                                                            echo '<a href="/uploads/recruit/'.$row['transcript'].'" title="Transcript" target="_blank"><i data-feather="type"></i></a>';
                                                        }
                                                        if($row['idcard']!=null){
                                                            echo '<a href="/uploads/recruit/'.$row['idcard'].'" title="ID Card" target="_blank"><i data-feather="credit-card"></i></a>';
                                                        }
                                                        if($row['bookbank']!=null){
                                                            echo '<a href="/uploads/recruit/'.$row['bookbank'].'" title="Book Bank" target="_blank"><i data-feather="dollar-sign"></i></a>';
                                                        }
                                                        
                                                        echo '</td>
                                                        
                                                        
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.substr($row['start_date'],0,16).'
                                </span>
                                                        </td>
                                                        <td>
                                                            <div class="item-action dropdown">
                                                                <a href="#" data-toggle="dropdown" class="text-muted">
                                                                    <i data-feather="more-vertical"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">';



                                                                if(substr($row['interview_status'],0,1)==2||substr($row['interview_status'],0,1)==3){
                                                                    if($row['interview_status']!='3t'){
                                                                    echo '<a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&istatus=3t">
                                                                    <i data-feather="check-circle"></i> 3rd
                                                                    </a>';
                                                                }
                                                                if($row['interview_status']!='3f'){
                                                                echo '
                                                                    <a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&istatus=3f">
                                                                    <i data-feather="x-circle"></i> 3rd
                                                                    </a>';
                                                                }
                                                                }


                                                                if(substr($row['interview_status'],0,1)==1||substr($row['interview_status'],0,1)==2){
                                                                    if($row['interview_status']!='2t'){
                                                                    echo '<a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&istatus=2t">
                                                                    <i data-feather="check-circle"></i> 2nd
                                                                    </a>';
                                                                }
                                                                if($row['interview_status']!='2f'){
                                                                echo '
                                                                    <a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&istatus=2f">
                                                                    <i data-feather="x-circle"></i> 2nd
                                                                    </a>';
                                                                }
                                                                }


                                                                if($row['interview_status']==null||substr($row['interview_status'],0,1)==1){
                                                                    if($row['interview_status']!='1t'){
                                                                    echo '<a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&istatus=1t">
                                                                    <i data-feather="check-circle"></i> 1st
                                                                    </a>';
                                                                    }
                                                                    if($row['interview_status']!='1f'){
                                                                    echo '<a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&istatus=1f">
                                                                    <i data-feather="x-circle"></i> 1st
                                                                    </a>';
                                                                    }
                                                                }

                                                                    echo '<a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&status=2">
                                                                    ยื่น Offer แล้ว
                                                                    </a>
                                                                    <a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&status=3">
                                                                ปฏิเสธ Offer
                                                                    </a>
                                                                    <a class="dropdown-item" href="action.php?mod=recruit&id='.$row['id'].'&status=4">
                                                                เซ็นต์สัญญาแล้ว
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item edit" href="?mod='.$md.'-edit&id='.$row['id'].'">
                                                                        Edit
                                                                    </a>
                                                                    <a class="dropdown-item trash" href="action.php?mod=del&page=recruit&id='.$row['id'].'"  onclick="return confirm(\'Are you sure?\')">
                                        Delete item
                                    </a>
                                                                </div>
                                                            </div>
                                                        </td></tr>';
                                                        $cnt--;
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>