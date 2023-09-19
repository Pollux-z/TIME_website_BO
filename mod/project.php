<?php
    $rss = mysqli_query($conn,"SELECT `id`, `nick`,edits FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
        if($roww['id']==$_SESSION['ses_uid']){
            $edits = json_decode($roww['edits']);
        }
    }

    // echo json_encode($edits).$_SESSION['ses_uid'];
?>
<div class="text-right mb-3">
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
                                            <th><span class="text-muted">เลข TIME</span></th>
                                            <th><span class="text-muted">ชือโปรเจ็คท์</span></th>
                                            <th><span class="text-muted">PM</span></th>
                                            <th><span class="text-muted">เลขสัญญา</span></th>
                                            <th><span class="text-muted d-none d-sm-block">วันเริ่มสัญญา</span></th>
                                            <th><span class="text-muted d-none d-sm-block">วันสิ้นสุดสัญญา</span></th>
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody><?php
    // $rs = mysqli_query($conn,"SELECT * FROM `db_projects` WHERE status =2");
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
                                                            <small class="text-muted">TIME-'.$row['code'].'</small>
                                                        </td>
                                                        <td class="flex">
                                                            ';

                                                            if(in_array('project',$edits)||$_SESSION['ses_ulevel']>7){
                                                                echo '<a href=?mod=project-edit&id='.$row['id'].'>'.$row['name'].'</a>';
    
                                                            }else{
                                                                echo $row['name'];
    
                                                            }

                                                            if($row['status']==3){
                                                                echo ' <span class="item-badge badge text-uppercase  bg-success  ">
                                                                '.$proj_stts[$row['status']].'
                                                            </span>';
                                                            }
                                                            echo '<div class="item-except text-muted text-sm h-1x">
                                                            '.$row['name_th'].'</div>
                                                        </td>
                                                        <td>';
                                                        $time1_ids = json_decode($row['time1_ids']);

                                                        if(isset($time1_ids)){
                                                            foreach($time1_ids as $v){
                                                                $team_list[] = $time1[$v];
                                                            }

                                                            echo implode(', ',$team_list);
                                                        }
                                                        $team_list = '';

                                                        echo '</td>
                                                        <td>
                                                        '.$row['contract_no'].'
                                                        </td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.$row['start_date'].'
                                </span>
                                                        </td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.$row['end_date'].'
                                </span>
                                                        </td>';
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