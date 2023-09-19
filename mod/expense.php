<div class="mb-3 text-right">
    <a href="?mod=expense&year=<?php echo $year;?>">TABLE</a> | <a href="?mod=expense&page=summary&year=<?php echo $year;?>">SUMMARY</a><br><br>

    <div class="mb-3"><a href="exportData.php?page=<?php echo $mod.'&year='.$year;?>" target="_blank"><i class="mx-2" data-feather="download"></i>Download CSV</a></div>

<form>
<input type="hidden" name="mod" value="expense">
<select name="month">
        <option value="">All 2021</option>
        <?php

        if(isset($_GET['month'])){
            $slt[$_GET['month']] = ' selected';
        }

        $rss = mysqli_query($conn,"SELECT DISTINCT `month` FROM `db_expense` WHERE status != 0 ORDER BY `db_expense`.`month` DESC");
        while($roww=mysqli_fetch_assoc($rss)){
        echo '<option value="'.$roww['month'].'"'.$slt[$roww['month']].'>'.$roww['month'].'</option>';
        }
        ?>
    </select>
    <input type="submit" value="Filter">
</form>
</div>

<div class="text-center">
    <a href="?mod=expense&page=<?php echo $page;?>">2021</a> | 
    <a href="?mod=expense&page=<?php echo $page;?>&year=2020">2020</a>
</div>

<?php if($_GET['page']=='summary'){?>

<!-- <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable"> -->
<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
<thead>
<tr class="text-center">
<th><?php echo $year;?></th>
<?php foreach($tmo as $k => $v){echo '<th>'.$v.'</th>';}?>
<th>Total</th>
</tr> </thead> <tbody>

<?php
    // $rs = mysqli_query($conn,"SELECT a.id,month(b.created_at) month,a.acc_no,a.proj_no,a.cost FROM `db_expense_detail` a join db_expense b where a.eid = b.id and a.status = 2 ORDER BY month,acc_no,proj_no ASC");
    $rs = mysqli_query($conn,"SELECT a.id,b.month,a.acc_no,a.proj_no,a.cost FROM `db_expense_detail` a join db_expense b where b.status != 0 and a.eid = b.id and a.status = 2 ORDER BY month,acc_no,proj_no ASC");
    while($row=mysqli_fetch_assoc($rs)){
        if($row['acc_no']==9001||($row['acc_no']==9005&&$row['proj_no']!='')){
            $costcenter = $row['proj_no'];
        }else{
            $costcenter = $row['acc_no'];
        }

        $dt[$row['month']][$costcenter] = $row['cost']+$dt[$row['month']][$costcenter];
    }

$rs = mysqli_query($conn,"SELECT `code`, `name` FROM `db_project`");
while($row=mysqli_fetch_assoc($rs)){
    $projects[$row['code']] = $row['name'];
}

$bos = [
    'sal' => 'เงินเดือน',
    'off' => 'ค่าใช้จ่ายสำนักงาน (เงินสดย่อย ค่าถ่ายเอกสาร ค่าบัญชี ค่าอื่นๆ)',
    'ren' => 'ค่าเช่าสำนักงาน',
    'oth' => 'ค่าใช้จ่ายอื่นๆ',
    'vat' => 'VAT',
    'pit1' => 'ภงด.1',
    'pit3' => 'ภงด.3',
    'pit53' => 'ภงด.53',
    'pit30' => 'ภพ.30',
    'pit36' => 'ภพ.36',
    'wht' => 'หัก ณ ที่จ่าย',
    'sso' => 'ประกันสังคม',
    'frc' => 'ค่าที่ปรึกษาต่างประเทศ',
    'cap' => 'ค่าใช้จ่ายด้านการลงทุน (CAPEX)',
    'car' => 'ค่าเช่ารถ',
];

$rs = mysqli_query($conn,"SELECT DISTINCT proj_no FROM `db_expense_detail` a join db_expense b WHERE b.status != 0 and a.eid = b.id and a.`status` = 2 and b.created_at like '$year-%' and proj_no != '' ORDER BY `a`.`proj_no` ASC");

while($row=mysqli_fetch_assoc($rs)){
    $total = 0;
    ?>
<tr class="text-right">
    <td class="text-left">
        <?php
            if(array_key_exists($row['proj_no'],$bos)){
                echo '9005 '.$bos[$row['proj_no']];
            }else{
                echo 'TIME-'.$row['proj_no'].' '.$projects[$row['proj_no']];
            }
        ?>
    </td>
    <?php for($i=1;$i<=12;$i++){
        $mo = $year.'-'.str_pad($i, 2, 0, STR_PAD_LEFT);
        
        ?>
    <td><?php

    if($dt[$mo][$row['proj_no']]!=''){
        echo '<a href="?mod=expense-detail&proj_no='.$row['proj_no'].'&month='.$mo.'">'.number_format($dt[$mo][$row['proj_no']],2).'</a>';           

        // echo number_format($dt[$mo][$row['proj_no']],2);        
        $total = $dt[$mo][$row['proj_no']]+$total;
    }

    ?></td>
    <?php }?>
    <td>
        <?php echo number_format($total,2);?>
    </td>
</tr>
<?php }?>
<tfoot style="font-weight:bold;">
    <tr class="text-right">
        <td>Total</td>
        <?php 
                $total = 0;

        for($i=1;$i<=12;$i++){
            $mo = $year.'-'.str_pad($i, 2, 0, STR_PAD_LEFT);
            
            ?>
        <td><?php


        if(isset($dt[$mo])){
            echo number_format(array_sum($dt[$mo]),2);        
            $total = array_sum($dt[$mo])+$total;
        }

        ?></td>
        <?php }?>
        <td>
            <?php echo number_format($total,2);?>
        </td>
    </tr>
  </tfoot>
</table>

<?php }else{

    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    $rss = mysqli_query($conn,"SELECT id,code,name FROM `db_project`");
    while($roww=mysqli_fetch_assoc($rss)){
        $project[$roww['id']] = 'TIME-'.$roww['code'].' '.$roww['name'];
    }

    $rss = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
    $roww = mysqli_fetch_assoc($rss);
    if(in_array('expense',json_decode($roww['edits']))){
        $edit = 'y';
    };

    // echo "SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid'];
    
?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Items</span></th>
                                            <th><span class="text-muted">Total Price</span></th>
                                            <th><span class="text-muted">Pay to</span></th>
                                            <!-- <th><span class="text-muted">By</span></th> -->
                                            <th><span class="text-muted">Date</span></th>
                                            <?php if(isset($edit)){echo '<th><span class="text-muted"></span></th>';}?>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                        
                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_cover` ORDER BY code DESC");
                                            
                                            // '.explode('-',$row['date'])[2].'/'.explode('-',$row['date'])[1].'
                                            $total = 0;
                                            while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['code'].'</small>
                                                        </td>
                                                        <td class="flex">
                                                            <a href="?mod=expense-view&id='.$row['id'].'">'.$row['items'].'</a>
                                                        </td>
                                                        <td class="text-right">'.number_format($row['total_cost'],2).'</td>
                                                        <td class="flex">
                                                            '.$row['pay_to'].'
                                                        </td>';
                                                        // echo '<td>'.$time1[$row['uid']].'</td>';
                                                        echo '<td>'.$row['created_at'].'
                                                        </td>';

                                                        if(isset($edit)){echo '<td><a href="?mod=expense-edit&id='.$row['id'].'" class="btn btn-sm btn-danger">Edit</a>
                                                            </td>';}
                                                        
                                                    echo '</tr>';
                                                    $total = $row['total_cost']+$total;
                                            }
                                        ?>
        </tbody>
        <tfoot style="font-weight:bold;">
            <tr class="text-right">
                <td colspan="2">Total</td>
                <td>
                    <?php echo number_format($total,2);?>
                </td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>
<?php }?>