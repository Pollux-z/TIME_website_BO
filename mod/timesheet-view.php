                            <!-- <div class="d-flex align-items-center py-4">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/img/logo.png" style="height:60px;">
                                    </div>
                                </div>
                                <div class="flex"></div>
                                <div class="text-right">
                                    <div class="text-sm text-fade">EXPENSE</div>
                                    <div class="text-highlight">#<?php 
                                    
    // $rs = mysqli_query($conn,"SELECT * FROM `db_expense` WHERE `id` = $id");
    // $row = mysqli_fetch_assoc($rs);
    
    // echo $row['code'];
                                    
                                    ?></div>
                                    <div class="text-sm text-muted"><?php 
                                    // echo $row['created_at'];?></div>
                                </div>
                            </div> -->
                            <table class="table table-theme table-rows v-middle">
                                <thead>
                                    <tr>
                                        <th class="text-muted">Date</th>
                                        <th class="text-muted">Project No</th>
                                        <th class="text-muted">Account No</th>
                                        <th class="text-muted">Description</th>
                                        <th class="text-muted">Location</th>
                                        <th class="text-muted">Remark</th>
                                        <th class="text-muted text-right">Hour</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php  
                                    
                                                                        
    // $rs = mysqli_query($conn,"SELECT `id`, `code`, `name` FROM `db_project` ORDER BY `code` DESC");
    // while($row = mysqli_fetch_assoc($rs)){
    //     $projs[$row['code']] = $row['code'].' '.substr($row['name'],0,30);
    // }
    $total_hour = 0;
    $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet_detail` WHERE `tid` = $id ORDER BY `date` ASC");
    while($row = mysqli_fetch_assoc($rs)){
        $hour = $row['hour'];
        $total_hour = $hour+$total_hour;
                                    

                                    // foreach ($excel as list($a,$b,$c,$d)) {
                            ?>
                            
                                                                <tr>
                                                                    <td>                        
                                                                    <?php echo $row['date2'];?>
                                                                    </td>
                                                                    <td>                        
                                                                    <?php echo $row['project_no'];?>
                                                                    </td>
                                                                    <td>                        
                                                                    <?php echo $row['account_no'];?>
                                                                    </td>
                                                                    <td>                        
                                                                    <?php echo $row['description'];?>
                                                                    </td>
                                                                    <td>                        
                                                                    <?php echo $row['location'];?>
                                                                    </td>
                                                                    <td><?php echo $row['remark'];?>
                                                                        <!-- <div class="text-sm text-muted">Marketing and TV ads</div> -->
                                                                    </td>
                                                                    <td class="text-right"><?php echo $row['hour'];?></td>
                                                                </tr>
                                                                <?php }?>    
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right no-border">
                                            <small class="muted mx-2">Total: </small>
                                            <strong class="text-success"><?php echo number_format($total_hour,2);?></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex py-3">
                                <div class="flex"></div>
                                <a href="#" class="btn btn-sm btn-primary d-print-none" onClick="window.print();">Print</a>
                            </div>