<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_cover` WHERE `id` = $id ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);
    
        $title = htmlspecialchars($row['title']);
        $remark = htmlspecialchars($row['remark']);
        $sl[$row['project_id']] = ' selected';
    
        $dt = explode('-',$row['date']);
        $date = $dt[2].'/'.$dt[1].'/'.$dt[0];

        if($_SESSION['ses_uid']!=$row['uid']&&$_SESSION['ses_ulevel']!=9){
            $readonly = ' disabled';
        }
    }

    // if($_GET['alert']=='created'){
    //     echo '
    //     <div class="alert alert-info" role="alert">
    //         <i data-feather="info"></i>
    //         <span class="mx-2">Success! Your cover letter number is <b>TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below.</span>
    //     </div>';
    // }

    if(isset($_GET['chk_id'])){

?>
                            <table class="table table-theme table-rows v-middle table-hover">
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

        $id = $_GET['chk_id'];

        $total_hour = 0;
        $rss = mysqli_query($conn,"SELECT * FROM `db_timesheet_detail` WHERE `tid` = $id ORDER BY `date` ASC");
        while($roww = mysqli_fetch_assoc($rss)){
            $hour = $roww['hour'];
            $total_hour = $hour+$total_hour;
                                        

                                        // foreach ($excel as list($a,$b,$c,$d)) {
                                ?>
                                
                                                                    <tr>
                                                                        <td>                        
                                                                        <?php echo $roww['date2'];?>
                                                                        </td>
                                                                        <td>                        
                                                                        <?php echo $roww['project_no'];?>
                                                                        </td>
                                                                        <td>                        
                                                                        <?php echo $roww['account_no'];?>
                                                                        </td>
                                                                        <td>                        
                                                                        <?php echo $roww['description'];?>
                                                                        </td>
                                                                        <td>                        
                                                                        <?php echo $roww['location'];?>
                                                                        </td>
                                                                        <td><?php echo $roww['remark'];?>
                                                                            <!-- <div class="text-sm text-muted">Marketing and TV ads</div> -->
                                                                        </td>
                                                                        <td class="text-right"><?php echo $roww['hour'];?></td>
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





                                <div class="row">
                                    <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <strong>บันทึก Timesheet<?php
                                                    
                                                    // if(isset($id)){
                                                    //     echo 'TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                    // }else{
                                                    //     echo 'ออกเลขหนังสือใหม่';
                                                    // }
                                                    
                                                    ?></strong>
                                                </div>
                                                <div class="card-body">

                                                <?php

    if(isset($_GET['excel'])){
        echo '<form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">';
    $excel = array();
    $rows = explode("\r\n", trim($_GET['excel']));
    foreach($rows as $idx => $row)
    {
        $row = explode( "\t", $row );
        foreach( $row as $field )
        {
            $excel[$idx][] = $field;
        }
    }

    ?>
                                
    <?php }?>

<?php        }?>



<?php
    echo '<form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">';
    
    ?>

                                                <div class="form-group row">
                                                    <label for="month" class="col-sm-3 col-form-label">Month</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="month" value="<?php 
                                                                                                                
                                                        $row = mysqli_fetch_assoc($rs);
                                                        $mo = explode('-',$row['month'])[1]+1;
                                                        $mo = str_pad($mo, 2, 0, STR_PAD_LEFT);

                                                        if($mo==13){
                                                            $mo = '01';
                                                            $yr = explode('-',$row['month'])[0]+1;

                                                        }else{
                                                            $yr = explode('-',$row['month'])[0];

                                                        }
                                                        
                                                        echo "$yr-$mo";
                                                        
                                                        ?>"<?php if(isset($readonly)){echo $readonly;}?>>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Excel</label>
                                                    <div class="col-sm-9">
                                                        <div class="custom-file">
                                                            <input type="file" id="customFile" name="file" required>
                                                            <!-- <label class="custom-file-label" for="customFile">Choose file</label> -->
                                                        </div>

                                                        <!-- <small class="form-text text-muted">Download Excel Template - <a href="uploads/timesheet/timesheet-jan20.xlsx">January 2020</a> / <a href="uploads/timesheet/timesheet-feb20.xlsx">February 2020</a> / <a href="uploads/timesheet/timesheet-mar20.xlsx">March 2020</a></small> -->

                                                    </div>
                                                </div>
                                                <div class="text-right pt-2">
                                                    <input type="hidden" name="mod" value="timesheet_month">
                                                    <button type="submit" class="btn btn-primary">Create</button>

                                                </div>

                                            </form>
                                            </div>
                                        </div>
                                </div>
                            </div>