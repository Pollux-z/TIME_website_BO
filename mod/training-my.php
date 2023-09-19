<?php
    $statuses = [
        1 => ['Pending','info'],
        2 => ['Declined','danger'],
        3 => ['Approved','success'],
        4 => ['Successful Payment','primary'],
    ];
?>

<div class="btn-group float-right">
    <a href="?mod=training" class="btn btn-outline-primary">Upcoming Courses</a>
    <a href="?mod=training-my" class="btn btn-outline-primary active">My Registration</a>
    <a href="?mod=training-register" class="btn btn-outline-primary">Registration Status</a>
    <a href="?mod=training-summary" class="btn btn-outline-primary">Summary Report</a>
</div>

<h3 class="mb-5">My Registration</h3>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <!-- <th><span class="text-muted">Name</span></th> -->
                                            <th><span class="text-muted">Course</span></th>
                                            <th><span class="text-muted">Date</span></th>
                                            <th><span class="text-muted">Status</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
                                    
    $rs = mysqli_query($conn,"SELECT id,title FROM `db_training`");
    while($row=mysqli_fetch_assoc($rs)){
        $courses[$row['id']] = $row['title'];
    }

    $rs = mysqli_query($conn,"SELECT a.*,b.name,b.nick,b.position FROM `db_training_register` a join db_employee b WHERE a.uid = b.id and a.uid = ".$_SESSION['ses_uid']." and a.`status` > 0 ORDER BY a.`id` DESC");

    while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['id'].'</small>
                                                        </td>                                                        
                                                        <td><a href="?mod=training-view&rid='.$row['id'].'">'.$courses[$row['tid']].'</a></td>
                                                        <td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.$row['created_at'].'
                                </span>
                                                        </td>
                                                        <td class="flex">';
                                                        
                                                        echo '<span class="badge badge-'.$statuses[$row['status']][1].' text-uppercase">'.$statuses[$row['status']][0].'</span>';
                                                    
                                                    echo '</td>
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



                                                                    echo '<a class="dropdown-item" href="action.php?mod=training&id='.$row['id'].'&status=3">
                                                                    Approve
                                                                    </a>
                                                                    <a class="dropdown-item" href="action.php?mod=training&id='.$row['id'].'&status=2">
                                                                Decline
                                                                    </a>
                                                                    <a class="dropdown-item" href="action.php?mod=training&id='.$row['id'].'&status=4">
                                                                Successful Payment
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item edit" href="?mod='.$md.'-edit&id='.$row['id'].'">
                                                                        Edit
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td></tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>