<?php
    if($page=='balance'){?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <strong>Basic Form</strong> Elements
                    </div> -->

                    <form action="action.php" method="post" class="form-horizontal">
                    <div class="card-body card-block">     
                    <?php if($_SESSION['ses_ulevel']>7){?>                                   
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="select" class=" form-control-label">Employee</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <?php
                                    
                                    $rs = mysqli_query($conn,"SELECT `name`, `nick` FROM `db_employee` WHERE `id` = $id");
                                    $row = mysqli_fetch_assoc($rs);
                                    echo $row['name'].' ('.$row['nick'].')';
                                    
                                    ?>
                                </div>
                            </div>
                                    <?php }?>

                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Top-up Days</label>
                                        </div>
                                        <div class="col-1">
                                            <input type="number" name="day" id="text-input" name="text-input" placeholder="Your answer" class="form-control" value="1" required>
                                            <!-- <small class="form-text text-muted">This is a help text</small> -->
                                        </div>
                                    </div>  
                                    <div class="row form-group">
                                        <div class="col col-md-3">
                                            <label for="text-input" class=" form-control-label">Note</label>
                                        </div>
                                        <div class="col-12 col-md-9">
                                            <input type="text" name="note" id="text-input" name="text-input" placeholder="Your answer" class="form-control" required>
                                            <!-- <small class="form-text text-muted">This is a help text</small> -->
                                        </div>
                                    </div>                                      
                    </div>
                    <div class="card-footer">
                        <input type="hidden" name="mod" value="wfa">
                        <input type="hidden" name="page" value="balance">
                        <input type="hidden" name="uid" value="<?php echo $id;?>">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div></form>

                </div>
            </div>
        </div>

<?php    }else{
    if(isset($_GET['id'])){
        $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff` WHERE `id` = $id AND `status` != 0");
        $row = mysqli_fetch_assoc($rs);

        $ttype = $row['ttype'];
        $reason = $row['reason'];
        $uid = $row['uid'];

        $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_date` WHERE `tid` = $id ORDER BY `date` ASC");
        while($row = mysqli_fetch_assoc($rs)){
            $dates[] = webdate($row['date']);
            $half = $row['half'];
        }

    }else{
        $uid = $_SESSION['ses_uid'];

    }
    
    ?>
<div class="row row-sm">
    <div class="col-lg-12 d-flex">
        <div class="card flex">
            <div class="card-body">
                <small>Work From Anywhere:
                    <strong class="text-primary"><?php
                          

    $days = [
        'v' => 0,
        'p' => 0,
        's' => 0,
    ];

    $yr = date(Y);

    $rs = mysqli_query($conn,"SELECT ttype,half FROM `db_timeoff_date` a join db_timeoff b where a.date like '$yr-%' and a.tid = b.id and b.status = 2 and b.uid = ".$uid);

    while($row=mysqli_fetch_assoc($rs)){
        $days[$row['ttype']] = $row['half']+$days[$row['ttype']];
    }

    // echo json_encode($days);
                
    $rs = mysqli_query($conn,"SELECT wfa_day FROM `db_employee` WHERE `id` = ".$uid);
    // $rs = mysqli_query($conn,"SELECT * FROM `db_timeoff_vacation` WHERE `year` = '$yr' AND `uid` = $uid");

    $row = mysqli_fetch_assoc($rs);
    $personal_day = 7;
    $sick_day = 30;

    $left = $row['wfa_day']-$days['a'];  
    echo $left;

                    
                    ?> days</strong>
                </small>
                <div class="progress my-3 circle" style="height:6px;">
                    <div class="progress-bar circle gd-secondary" data-toggle="tooltip" style="width: <?php echo ceil($left/$row['wfa_day']*100);?>%"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-lg-4 d-flex">
        <div class="card flex">
            <div class="card-body">
                <small>Personal Leave:
                    <strong class="text-primary"><?php $left = $personal_day-$days['p'];echo $left;?> days</strong>
                </small>
                <div class="progress my-3 circle" style="height:6px;">
                    <div class="progress-bar circle gd-primary" data-toggle="tooltip" style="width: <?php echo ceil($left/$personal_day*100);?>%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex">
        <div class="card flex">
            <div class="card-body">
                <small>Sick Leave:
                    <strong class="text-primary"><?php $left = $sick_day-$days['s'];echo $left?> days</strong>
                </small>
                <div class="progress my-3 circle" style="height:6px;">
                    <div class="progress-bar circle gd-danger" data-toggle="tooltip" style="width: <?php echo ceil($left/$sick_day*100);?>%"></div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<div class="row">
    <div class="col-lg-12">
                                <div class="card">
                                    <!-- <div class="card-header">
                                        <strong>Basic Form</strong> Elements
                                    </div> -->

                                    <form action="action.php" method="post" class="form-horizontal">
                                    <div class="card-body card-block">     
                                    <?php if($_SESSION['ses_ulevel']>7){?>                                   
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Employee</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="uid" id="uid" class="form-control"<?php if(isset($_GET['id'])){echo ' disabled';}?> required>
                                                        <option value="">Please select</option>
                                                        <?php
                                                        
                                                        $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `end_date` IS NULL AND id > 2 ORDER BY `db_employee`.`nick` ASC");

                                                        $su[$uid] = ' selected';

                                                        while($row=mysqli_fetch_assoc($rs)){
                                                            echo '<option value="'.$row['id'].'"'.$su[$row['id']].'>'.$row['nick'].'</option>';
                                                        }
                                                        
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                                    <?php }?>

                                            <!-- <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Type of Leave</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="ttype" id="select" class="form-control" required>
                                                        <option value="">Please select</option>

                                                        <?php $st[$ttype] = ' selected';?>
                                                        <option value="v"<?php echo $st['v'];?>>Vacation leave</option>
                                                        <option value="p"<?php echo $st['p'];?>>Personal leave</option>
                                                        <option value="s"<?php echo $st['s'];?>>Sick leave</option>
                                                        <option value="w"<?php echo $st['w'];?>>Leave without pay</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Note</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" name="reason" id="text-input" name="text-input" value="<?php echo $reason;?>" placeholder="Your answer" class="form-control">
                                                    <!-- <small class="form-text text-muted">This is a help text</small>-->
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">วันที่ Work From Anywhere</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type='text' name="dates" value="<?php echo implode(',',$dates);?>" placeholder="Your answer" class="form-control mb-3" data-plugin="datepicker" data-option="{multidate: true,clearBtn: true,daysOfWeekDisabled: [0,6]}" autocomplete="off" required>
                                                    <small class="form-text text-muted">เลือกเฉพาะวันที่ต้องการจะขอ Work From Anywhere ไม่รวมวันเสาร์อาทิตย์ และวันหยุดตาม<a href="/uploads/announce/time2021-00003.jpg" target="_blank">ประกาศ AIA</a></small>
                                                </div>
                                            </div>                                        
                                    </div>
                                    <div class="card-footer">
                                    <input type="hidden" name="mod" value="wfa">
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div></form>

                                </div>
                                                    </div></div><?php }?>