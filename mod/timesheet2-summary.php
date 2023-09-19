<?php

$rs = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
while($row=mysqli_fetch_assoc($rs)){
    $time1[$row['id']] = $row['nick'];    
}

?><div class="row">
    <div class="col-md-3">
        Project Summary

        <div class="mt-3" style="height:60px;">
    <div class="avatar-group">
        <?php

        $rss = mysqli_query($conn,"SELECT id,nick,level,mods,edits FROM `db_employee` WHERE `end_date` IS NULL AND (level > 8 OR edits LIKE '%\"timesheet2\"%') ORDER BY `code` ASC");
        while($roww=mysqli_fetch_assoc($rss)){
                $ams[$roww['id']] = '<a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$roww['nick'].'">
                <img src="uploads/employee/'.$roww['id'].'.jpg" alt=".">
            </a>';
        }

        echo implode(' ',$ams);
        ?>
    </div>
</div>

    </div>
    <div class="col-md-3">

    <div class="card flex">
                                                <div class="card-body text-center">
                                                    <small class="text-muted">Total Projects</small>
                                                    <div class="pt-3">
                                                        <div style="height: 30px" class="pos-rlt">
                                                            <div class="pos-abt w-100 d-flex align-items-center justify-content-center">
                                                                <div>
                                                                    <div class="text-highlight text-md">
                                                                        <span data-plugin="countTo" data-option="{
													from: 0,
												    to: <?php
                                                    
                                                    if(isset($_GET['date'])){
                                                        $date = $_GET['date'];

                                                    }else{
                                                        $date = date("d/m/Y",strtotime("-6 day")).' - '.date("d/m/Y");

                                                    }
                                                    $dates = explode(' - ',$date);
                                                    
                                                    // $sql = "SELECT DISTINCT project_no FROM `db_timesheet2` WHERE `date` >= '".sqldate($dates[0])."' AND `date` <= '".sqldate($dates[1])."' AND `project_no` != '' AND `status` > 0";
                                                    $sql = "SELECT id,project_no,account_no,uid,date,hrs FROM `db_timesheet2` WHERE `date` >= '".sqldate($dates[0])."' AND `date` <= '".sqldate($dates[1])."' AND `project_no` != '' AND `status` > 0";
                                                    // echo $sql;
                                                    $rs = mysqli_query($conn,$sql);
                                                    
                                                    while($row=mysqli_fetch_assoc($rs)){
                                                        $pn = str_replace('time','',strtolower($row['project_no']));
                                                        $pn = trim(str_replace('-','',$pn));
                                                        // $pn = trim(explode('-',$row['project_no'])[1]);
                                                        if($pn!=''){
                                                            $month = explode('-',$row['date'])[1];
                                                            $project_nos[$pn][$row['account_no']][$row['uid']][$month][] = $row['hrs'];
                                                        }
                                                    }

                                                    foreach($project_nos as $k => $v){
                                                        $sk[] = "'$k'";
                                                    }
                                                    
                                                    $sql = "SELECT code,name FROM `db_project` WHERE `code` IN (".implode(',',$sk).") ORDER BY `code` DESC";

                                                    $rs = mysqli_query($conn,$sql);
                                                    echo mysqli_num_rows($rs);
                                                    while($row=mysqli_fetch_assoc($rs)){
                                                        $project_list[$row['code']] = $row['name'];
                                                    }                                                    
                                                    
                                                    ?>,
												    refreshInterval: 15,
												    speed: 1000,
												    formatter: function (value, options) {
												      return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
												    }
												    }"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    </div>
    <div class="col-md-6 text-right">
        <?php
//     $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
// $row = mysqli_fetch_assoc($rs);

// $id = $row['id'];
// $name = $row['name'];
// $position = $row['position'];
// $code = $row['code'];
// $level = $row['level'];
// $edits = json_decode($row['edits']);

// if($level==9||in_array('timesheet2',$edits)){
if(array_key_exists($_SESSION['ses_uid'],$ams)){
    echo '<div style="height:60px;"><div class="btn-group float-right">
    <a href="?mod=timesheet2" class="btn btn-outline-primary">My Time Sheet</a>
    <a href="?mod=timesheet2-summary" class="btn btn-outline-primary active">Project Summary</a>
    <a href="?mod=timesheet2-overall" class="btn btn-outline-primary">Overall Summary</a>
</div></div>';
}

?>

        <form>
            <input type="hidden" name="mod" value="timesheet2-summary">
            <?php
            
            $projects = $_GET['projects'];

            foreach($projects as $v){
                echo '            <input type="hidden" name="projects[]" value="'.$v.'">
                ';
            }
            
            ?>
        <input type="text" name="date"<?php echo ' value="'.$date.'"';?> class="btn btn-primary" style="width:260px;" data-plugin="daterangepicker" data-option="{
            opens: 'left',
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }" />
        <input type="submit" value="Filter" class="btn btn-secondary">
        </form>
    </div>
</div>


        <div class="card" data-sr-id="1"
            style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
            <div class="card-body">
            <!-- <a href="/excel/?mod=timesheet-summary&amp;years%5B%5D=2021"
        class="btn btn-sm btn-white">Excel</a> -->


        <h4 class="mt-3">Projects Name</h4>
        <form>
        <div class="row">
                <input type="hidden" name="mod" value="timesheet2-summary">
                <input type="hidden" name="date" value="<?php echo $date;?>">
            <?php
        
            foreach($project_nos as $k => $v){
                echo '            <div class="col-sm-6">
                <label class="md-check">
                    <input type="checkbox" name="projects[]" value="'.$k.'"';
                    if(in_array($k,$projects)){
                        echo ' checked';
                    }
                    echo '>
                    <i class="blue"></i>
                    TIME-'.$k.': '.$project_list[$k].'
                </label>
            </div>
';
            }
            
            ?>
        </div>
<input type="submit" value="Summary" class="btn btn-primary mt-3">
        </form>
        
<?php 
if(isset($_GET['projects'])){echo '<h4 class="mt-3">Results Projects:</h4>';}

$ants = [
    9001 => 'Project Owners',
    9002 => 'Project Supporters',
    9003 => 'BD (w/Project No.)',
    9004 => 'BD (w/o Project No.',
    9005 => 'BO',
    9006 => 'MarTech',
    9007 => 'Training, Education',
    9008 => 'Product Development',
    9009 => 'CD',
    9010 => 'Vacation',
    9013 => 'Sick Leave',
    9014 => 'Compensation Day',
    9015 => 'Other Leave',
];

?>     


                                    <div id="accordion" class="mb-4">
<?php

    $total_cumulate = $i = 0;

    foreach($project_nos as $k => $v){
        if(in_array($k,$projects)){
        $total_hrs = $total_mandays = 0;

    echo '                                        <div class="card mb-1">
<div class="card-header no-border bg-primary" id="heading'.$i.'">
    <a href="#" class="text-white" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="';
    if($i==0){
        echo 'true';
    }else{
        echo 'false';
    }
    echo '" aria-controls="collapse'.$i.'">
        TIME-'.$k.': '.$project_list[$k].'
    </a>
</div>
<div id="collapse'.$i.'" class="collapse';
if($i==0){
    echo ' show';
}
echo '" aria-labelledby="heading'.$i.'" data-parent="#accordion">
    <div class="card-body">';

    foreach($v as $kk => $vv){
        echo $ants[$kk].' ('.$kk.')<br>';
        echo '<table class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
        <thead>
        <tr class="text-center">
            <th>Name</th>
            <th>Hrs/Month</th>
            <th style="width:160px;">Total (hrs)</th>
            <th style="width:160px;">Total Man Days</th>
        </tr>';
        foreach($vv as $kkk => $vvv){
            echo '<tr>
            <td style="width:160px;">';
            if(in_array('timesheet2',$edits)||$level==9){
                echo '<a href="?mod=timesheet2&uid='.$kkk.'">'.$time1[$kkk].'</a>';

            }else{
                echo $time1[$kkk];

            }
            echo '</td>
            <td>';
            
            $sum_hrs = 0;
            foreach($vvv as $kkkk => $vvvv){
                $mos[] = $emo[$kkkk].' = '.array_sum($vvvv);
                $sum_hrs = $sum_hrs+array_sum($vvvv);                
            }
            $mandays = $sum_hrs/8;

            echo implode(' | ',$mos);
            unset($mos);

            echo '</td>
            <td class="text-center">'.$sum_hrs.'</td>
            <td class="text-center">'.$mandays.'</td>
            </tr>';            

            $total_hrs = $total_hrs+$sum_hrs;
            $total_mandays = $total_hrs/8;
        }

        echo '</table>';
    }   
    echo '<table class="table table-striped table-bordered font-weight-bold" cellspacing="0" width="100%" data-plugin="dataTable">
    <tr><td style="width:160px;">Total Summary</td><td>'.$total_mo.'</td><td class="text-center" style="width:160px;">'.$total_hrs.'</td><td class="text-center" style="width:160px;">'.$total_mandays.'</td></tr>
    </table>';

    echo '    </div>
</div>
</div>
';

$total_cumulate = $total_cumulate+$total_hrs;
$i++;
}
    }

?>
                                    </div>
<div class="p-3">
<?php

// $total_cumulate_manday = $total_cumulate/8;

// echo '<table class="table table-striped table-bordered font-weight-bold bg-success" cellspacing="0" width="100%" data-plugin="dataTable">
// <tr>
//     <td>Total Cumulative Summary</td>
//     <td class="text-center" style="width:160px;">'.$total_cumulate.'</td>
//     <td class="text-center" style="width:160px;">'.$total_cumulate_manday.'</td>
// </tr>
// </table>';


?>   </div>                             
</div>


            </div></div>