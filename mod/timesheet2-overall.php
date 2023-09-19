<style>
th:first-child, td:first-child
{
  position:sticky;
  left:0px;
  background-color:#fff;
}
</style><?php

$rs = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee` where id > 2 and end_date is null");
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
                                                    <small class="text-muted">Overall Total (hrs)</small>
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
                                                    
                                                    $total_hrs = 0;
                                                    $rs = mysqli_query($conn,"SELECT id,account_no,uid,hrs FROM `db_timesheet2` WHERE `date` >= '".sqldate($dates[0])."' AND `date` <= '".sqldate($dates[1])."' AND `status` > 0 and hrs >0");
                                                    while($row=mysqli_fetch_assoc($rs)){
                                                        $dt[$row['account_no']][$row['uid']][$row['id']] = $row['hrs'];
                                                        $total_hrs = $total_hrs+$row['hrs'];
                                                    }
                                                                                                    
                                                    echo $total_hrs;
                                                        
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

if(array_key_exists($_SESSION['ses_uid'],$ams)){
    echo '<div style="height:60px;"><div class="btn-group float-right">
    <a href="?mod=timesheet2" class="btn btn-outline-primary">My Time Sheet</a>
    <a href="?mod=timesheet2-summary" class="btn btn-outline-primary">Project Summary</a>
    <a href="?mod=timesheet2-overall" class="btn btn-outline-primary active">Overall Summary</a>
</div></div>';
}

?>

        <form>
            <input type="hidden" name="mod" value="timesheet2-overall">
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


        <div class="card" data-sr-id="1" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-header">
            <div class="row">
            <div class="col-6 pt-2">
                <h4>Overall</h4>
            </div>
            <div class="col-6 text-right">
                <a href="/excel/?mod=timesheet2-overall&date=<?php echo $date;?>" class="btn btn-sm btn-white">Excel</a>
            </div>
            </div>
        </div>
            <div class="card-body">
<?php 
$ants = [
    9001 => 'Consulting',
    9002 => 'Project Support',
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

<div class="table-responsive">
  <table class="table">
      <thead class="text-center">
        <tr>
        <th>Account Number</th>
        <th style="min-width: 165px;">Meaning</th>
        <?php
        
        foreach($time1 as $k => $v){
            echo '<th><a href="?mod=timesheet2&uid='.$k.'">'.$v.'</a></th>';
        }
        
        ?>
    </tr>
    </thead>
    <tbody class="text-center">    
    <?php
        foreach($ants as $k => $v){
            echo '        <tr>
            <td>'.$k.'</td>
            <td>'.$v.'</td>';
            
            foreach($time1 as $kk => $vv){
                echo '<td>';
                if(isset($dt[$k][$kk])){
                    $total = array_sum($dt[$k][$kk]);
                    echo $total;
                    $dtt[$kk][$k] = $total;

                }else{
                    echo '-';
                }
                echo '</td>';
            }
            
        echo '</tr>
    ';
        }
        echo '        <tr>
        <td>Total hrs</td>
        <td></td>';
        
        foreach($time1 as $kk => $vv){
            echo '<td>';
            if(isset($dtt[$kk])){
                echo array_sum($dtt[$kk]);
            }else{
                echo '-';
            }
            echo '</td>';
        }
        
    echo '</tr>
        <tr>
<td>Man Day</td>
<td></td>';

foreach($time1 as $kk => $vv){
    echo '<td>';
    if(isset($dtt[$kk])){
        echo array_sum($dtt[$kk])/8;
    }else{
        echo '-';
    }
    echo '</td>';
}

echo '</tr>
';

    ?>
    </tbody>
</table>
    </div>


                           
</div></div></div>