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


                                <div class="col-12">
                                    <div class="alert bg-success mb-5 py-4" role="alert">
                                        <div class="d-flex">
                                            <i data-feather="info" width="32" height="32"></i>
                                            <div class="px-3">
                                                <h5 class="alert-heading">ประกาศ</h5>
                                                <p>กรุณาใช้ไฟล์ 2022 Excel Template ตั้งแต่วันนี้เป็นต้นไป</p>
                                                <!-- <a href="#" class="btn text-white" data-dismiss="alert" aria-label="Close">Dismiss</a> -->

                                                <?php

    $mos = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
           
    echo '<a href="uploads/timesheet/timesheet-2022.xlsx" class="btn btn-white mx-1"><i data-feather="download"></i> &nbsp;2022 Excel Template</a>';
    echo '<a href="uploads/timesheet/MT_timesheet-2022.xlsx" class="btn btn-white mx-1"><i data-feather="download"></i> &nbsp;2022 Excel Template for MarTech</a>';
    echo '<a href="uploads/timesheet/BD_timesheet-2022.xlsx" class="btn btn-white mx-1"><i data-feather="download"></i> &nbsp;2022 Excel Template for BD</a>';

    // $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet_month` ORDER BY `id` DESC limit 1");
    // while($row=mysqli_fetch_assoc($rs)){
    //     echo '<a href="uploads/timesheet/timesheet-'.$row['month'].'.xlsx" class="btn btn-white mx-1"><i data-feather="download"></i> &nbsp;'.$mos[explode('-',$row['month'])[1]].'\''.substr(explode('-',$row['month'])[0],2).' Excel Template</a>';
    // }
                                                
                                                ?>                                            

                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php
    echo '<form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">';
    
    $rs = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
    $row = mysqli_fetch_assoc($rs);
    $edits = json_decode($row['edits']);

    if(in_array('timesheet',$edits)){
    ?>
                                                <div class="form-group row">
                                                    <label for="eid" class="col-sm-3 col-form-label">ชื่อพนักงาน</label>
                                                    <div class="col-sm-9">
                                                    <select name="eid" id="eid">
                                                        <option value="">..</option>
                                                            <?php
                                                            
                                                            $rs = mysqli_query($conn,"SELECT `id`, `code`, `name` FROM `db_employee` WHERE `end_date` IS NULL ORDER BY `code` ASC");
                                                            while($row=mysqli_fetch_assoc($rs)){
                                                                echo '<option value="'.$row['id'].'">TIME'.str_pad($row['code'],3,'0',STR_PAD_LEFT).' - '.$row['name'].'</option>';
                                                            }
                                                            
                                                            ?>
                                                            
                                                            </select>
                                                    </div>
                                                </div>
                                                <?php }?>

                                                <div class="form-group row">
                                                    <label for="month" class="col-sm-3 col-form-label">Month</label>
                                                    <div class="col-sm-9">
<?php
                                                    $mos = [
                // '12' => 'DEC',
                // '11' => 'NOV',
                // '10' => 'OCT',
                // '09' => 'SEP',
                // '08' => 'AUG',
                // '07' => 'JUL',
                // '06' => 'JUN',
                // '05' => 'MAY',
                // '04' => 'APR',
                '03' => 'MAR',
                '02' => 'FEB',
                '01' => 'JAN',
            ];

            ?>
            <select name="month" id="month"><?php

            // if(isset($month)){
            //     $sm[$month] = ' selected';

            // }else{
                $month = date('m')-1;
                $last_month = str_pad($month, 2, '0', STR_PAD_LEFT); 
                $sm[date("Y-$last_month")] = ' selected';

            // }
            
            foreach($mos as $k => $v){
                // if($k<=date(m)){
                    echo '<option value="2022-'.$k.'"'.$sm["2022-$k"].'>'.$v.' 22</option>';
                // }
            }?>                                                        
                                                        </select>
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
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Paste from Excel</label>
                                                    <div class="col-sm-9">
                                                    <textarea name="excel" class="form-control" rows="7" placeholder="Date,Project Number,Account Number,Task Description,Location,Hours
Date,Project Number,Account Number,Task Description,Location,Hours
.." required>
</textarea>

<small class="form-text text-muted">ก๊อปปี้ใน Excel มาวางในช่องนี้ ตั้งแต่เซลล์ E11 ถึง J แถวสุดท้าย (วันสุดท้ายของเดือน)</small>
                                                    </div>
                                                </div>
                                                <div class="text-right pt-2">
                                                    <input type="hidden" name="mod" value="timesheet">
                                                    <button type="submit" class="btn btn-primary">Import</button>

                                                </div>

                                            </form>
                                            </div>
                                        </div>
                                </div>
                            </div>