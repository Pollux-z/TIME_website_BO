<?php
    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` ORDER BY `db_employee`.`code` ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $emps[$row['id']] = $row['nick'];
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet_detail` a join db_timesheet b where a.hour >0 and b.status >0 and a.account_no in (9001,9002) and a.tid = b.id ORDER BY account_no,project_no ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['account_no']][$row['project_no']][$row['uid']][] = $row['hour'];
    }

?>
<table class="table table-bordered text-center">
    <tr>
        <td rowspan="2">Name</td>
        <td colspan="<?php echo count($dt[9001]);?>">9001</td>
        <td rowspan="2">Name</td>
        <td colspan="<?php echo count($dt[9002]);?>">9002</td>
        <td rowspan="2">Sum</td>
    </tr>
    <tr>
<?php
    foreach($dt[9001] as $a => $b){
        echo '<td>'.$a.'</td>';
    }
    foreach($dt[9002] as $i => $j){
        echo '<td>'.$i.'</td>';
    }
?>
    </tr>
<?php
    $total_sum = 0;
    foreach($emps as $c => $d){
        $sum = 0;
        echo '<tr><td>'.$d.' ('.$c.')</td>';
        foreach($dt[9001] as $e => $f){
            echo '<td>';
            if(isset($dt[9001][$e][$c])){
                $val = array_sum($dt[9001][$e][$c]);
                echo $val;

                $sum = $sum+$val;
                $sumt[9001][$e][] = $val;
            }
            echo '</td>';

            // $sum[$c][] = $val;
        }
        echo '<td>'.$d.' ('.$c.')</td>';
        foreach($dt[9002] as $g => $h){
            echo '<td>';
            if(isset($dt[9002][$g][$c])){
                $val = array_sum($dt[9002][$g][$c]);
                echo $val;

                $sum = $sum+$val;
                $sumt[9002][$g][] = $val;
            }
            echo '</td>';

            // $sum[$c][] = $val;
        }
        echo '<td>';
        
        // $sum = array_sum($val);
        $total_sum = $total_sum+$sum;

        echo $sum.'</td></tr>';
        unset($sum);
    }
?>    
    <tr>
        <td>Sum</td>
        <?php

        foreach($dt[9001] as $a => $b){
            echo '<td>'.array_sum($sumt[9001][$a]).'</td>';
        }
        echo '<td></td>';
        foreach($dt[9002] as $i => $j){
            echo '<td>'.array_sum($sumt[9002][$i]).'</td>';
        }

        ?>
        <td><?php echo $total_sum;?></td>
    </tr>
</table>
<?php 
// echo json_encode($dt);?>