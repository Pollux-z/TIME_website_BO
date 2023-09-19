<!-- <div class="text-right mb-3"><a href="uploads/cover/TIME Cover Letter Design 2020 V2.docx" target="_blank"><i class="mx-2" data-feather="download"></i>Download Template</a></div> -->

<?php
    $statuses = [
        1 => ['Out of service','warning'],
        2 => ['Available','success'],
        3 => ['In Use','danger'],
    ];

    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    $rss = mysqli_query($conn,"SELECT * FROM `db_equipment_log` WHERE `end_date` IS NULL");
    while($roww=mysqli_fetch_assoc($rss)){
        $inUse[$roww['eid']] = [$roww['uid'],$roww['start_date']];
    }

    // $rss = mysqli_query($conn,"SELECT id,code,name FROM `db_project`");
    // while($roww=mysqli_fetch_assoc($rss)){
    //     $project[$roww['id']] = 'TIME-'.$roww['code'].' '.$roww['name'];
    // }
?>
                            <div class="row justify-content-end mb-3">
                                <div class="col-sm-6 alert bg-info">
                                    <div class="mb-2">
                                        <small>Equipment statistics</small>
                                    </div>
                                    <div class="row row-sm text-center">
                                        <div class="col-4">
                                            <div class="text-highlight text-md"><?php echo $cnt;?></div>
                                            <small>Total</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-md"><?php
                                                                                        
                                            $rss = mysqli_query($conn,"SELECT id FROM `db_equipment` WHERE `status` = 3");
                                            $icnt = mysqli_num_rows($rss);

                                            echo $icnt;
                                            
                                            ?></div>
                                            <small>In Use</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-md"><?php echo $cnt-$icnt;?></div>
                                            <small>Spare</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Brand</span></th>
                                            <th><span class="text-muted">Model</span></th>
                                            <th><span class="text-muted">Spec laptop</span></th>
                                            <th><span class="text-muted">Warranty</span></th>
                                            <th><span class="text-muted">S/N</span></th>
                                            <th><span class="text-muted">Status</span></th>
                                            <th><span class="text-muted">User use</span></th>
                                            <th><span class="text-muted">Use start date</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                        
                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_cover` ORDER BY code DESC");
                                            
                                            // '.explode('-',$row['date'])[2].'/'.explode('-',$row['date'])[1].'
                                            
                                            while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['code'].'</small>
                                                        </td>
                                                        <td>'.$row['brand'].'
                                                        </td>
                                                        <td>'.$row['model'].'
                                                        </td>
                                                        <td>'.$row['spec'].'
                                                        </td>
                                                        <td>'.$row['warranty'].'
                                                        </td>
                                                        <td>'.$row['sn'].'
                                                        </td>
                                                        <td>
                                
                                <span class="badge badge-'.$statuses[$row['status']][1].' text-uppercase">
                                '.$statuses[$row['status']][0].'
            
    </span>
                            </td>                                                        <td>'.$time1[$inUse[$row['id']][0]].'
                            </td>
                            <td>'.$inUse[$row['id']][1].'
                            </td>
<td>';
    // if(in_array($mod,$edits)){
        // if($_COOKIE['ses_ulevel']>7){
            echo '<div class="item-action dropdown">
                                <a href="#" data-toggle="dropdown" class="text-muted">
                                    <i data-feather="more-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                                    <a class="dropdown-item" href="?mod='.$mod.'-edit&id='.$row['id'].'">
                                        Edit
                                    </a>';
                                // if($row['status']!=2){
                                //     echo '<a class="dropdown-item" href="action.php?mod='.$mod.'&status=2&id='.$row['id'].'">
                                //         Approve
                                //     </a>';
                                // }
                                // if($row['status']!=3){
                                //     echo '<a class="dropdown-item download" href="action.php?mod='.$mod.'&status=3&id='.$row['id'].'">
                                //         Deny
                                //     </a>';
                                // }

                                    echo '<div class="dropdown-divider"></div>
                                    <a class="dropdown-item trash" href="action.php?mod=del&page='.$mod.'&id='.$row['id'].'">
                                        Delete item
                                    </a>
                                 </div>';
echo '                            </div>';
    // }
echo '
                        </td>
                                                    </tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>