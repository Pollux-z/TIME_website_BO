<?php if(in_array('expense',$edits)||$_SESSION['ses_ulevel']>8){

    if($id!=''){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_expense` WHERE `id` = $id ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);
    
        $code = htmlspecialchars($row['code']);
        $pay_to = htmlspecialchars($row['pay_to']);
        $month = htmlspecialchars($row['month']);

        $rs = mysqli_query($conn,"SELECT * FROM `db_expense_detail` WHERE `eid` = $id and status = 2 ORDER BY `db_expense_detail`.`id` ASC");
        while($row = mysqli_fetch_assoc($rs)){
            $details[] = $row['title'].'|'.$row['cost'];
        }

        if($month!=$row['month']){
            $rs = mysqli_query($conn,"UPDATE `db_expense` SET `month` = '$month' WHERE `id` = $id;");
        }

    }else{
        $month = $_GET['month'];
                
        $sql = "SELECT code FROM `db_expense` WHERE `month` = '$month' ORDER BY `code` DESC limit 1";
    
        $rs = mysqli_query($conn,$sql);
        $cnt = mysqli_num_rows($rs);
    
        if($cnt!=0){
            $row = mysqli_fetch_assoc($rs);        
            $new_no = explode('/',$row['code'])[1]+1;
            $code = 'PV'.explode('-',$month)[1].'/'.str_pad($new_no, 3, 0, STR_PAD_LEFT);
    
        }else{
            $code = 'PV'.explode('-',$month)[1].'/001';
        }
    }

    if($_GET['alert']=='created'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success! Your cover letter number is <b>TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below.</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>บันทึกค่าใช้จ่าย</strong>
                                            </div>
                                            <div class="card-body">

                                            <?php

if(isset($_GET['excel'])){
    if($_GET['month']!=$month){
        $month = $_GET['month'];

        $sql = "SELECT code FROM `db_expense` WHERE `month` = '$month' ORDER BY `code` DESC limit 1";
        $rs = mysqli_query($conn,$sql);
        $cnt = mysqli_num_rows($rs);
    
        if($cnt!=0){
            $row = mysqli_fetch_assoc($rs);        
            $new_no = explode('/',$row['code'])[1]+1;
            $code = 'PV'.explode('-',$month)[1].'/'.str_pad($new_no, 3, 0, STR_PAD_LEFT);
    
        }else{
            $code = 'PV'.explode('-',$month)[1].'/001';
        }
    }

    echo '<form data-plugin="parsley" data-option="{}" action="action.php" method="POST" enctype="multipart/form-data">';
$excel = array();
$rows = explode("\r\n", trim($_GET['excel']));
foreach($rows as $idx => $row)
{
    $row = explode( "|", $row );
    foreach( $row as $field )
    {
        $excel[$idx][] = $field;
    }
}

?>


<div class="d-flex align-items-center py-4">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/img/logo.png" style="height:60px;">
                                    </div>
                                </div>
                                <div class="flex"></div>
                                <div class="text-right">
                                    <div class="text-sm text-fade">PAYMENT VOUCHER</div>
                                    <div class="text-highlight">#<?php echo $code;?></div>
                                    <div class="text-highlight">Pay to <?php echo $_GET['pay_to'];?></div>
                                    <div class="text-sm text-muted"><?php echo date("j M, Y");?></div>
                                </div>
                            </div>
<table class="table table-theme table-rows v-middle">
                                <thead>
                                    <tr>
                                        <th class="text-muted">Items</th>
                                        <th class="text-muted text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php        
        // foreach ($excel as list($a,$b,$c,$h,$e,$f,$g,$d)) {
        foreach ($excel as list($a,$d)) {            
?>

                                    <tr>
                                        <td><?php echo $a;?>
                                            <!-- <div class="text-sm text-muted">Marketing and TV ads</div> -->
                                        </td>
                                        <td class="text-right"><?php 
        $cost = str_replace(',','',$d);
        $total = $cost+$total;
        echo number_format($cost,2);
        
        ?></td>
                                    </tr>
                                    <?php }?>                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right no-border">
                                            <small class="muted mx-2">Total: </small>
                                            <strong class="text-success"><?php echo number_format($total,2);?></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>



<div class="text-right pt-2">

    <input type="hidden" name="mod" value="expense">
    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">

    <input type="hidden" name="excel" value="<?php echo $_GET['excel'];?>">
    <input type="hidden" name="code" value="<?php echo $code;?>">
    <input type="hidden" name="pay_to" value="<?php echo $_GET['pay_to'];?>">
    <input type="hidden" name="month" value="<?php 
    
    if(!isset($month)){
        echo date(Y).'-'.substr($code,2,2);
    }else{
        echo $month;
    }
    
    ?>">

    <button type="submit" class="btn btn-primary">Save</button>

</div>
<?php        }else{
    echo '<form>';
    ?>

    <div class="form-row">
        <div class="form-group col-sm-6">
            <label>เดือน</label><?php
            
            $mos = [
                '2021-12' => 'DEC 21',
                '2021-11' => 'NOV 21',
                '2021-10' => 'OCT 21',
                '2021-09' => 'SEP 21',
                '2021-08' => 'AUG 21',
                '2021-07' => 'JUL 21',
                '2021-06' => 'JUN 21',
                '2021-05' => 'MAY 21',
                '2021-04' => 'APR 21',
                '2021-03' => 'MAR 21',
                '2021-02' => 'FEB 21',
                '2021-01' => 'JAN 21',
                '2020-12' => 'DEC 20',
                '2020-11' => 'NOV 20',
                '2020-10' => 'OCT 20',
                '2020-09' => 'SEP 20',
                '2020-08' => 'AUG 20',
                '2020-07' => 'JUL 20',
                '2020-06' => 'JUN 20',
                '2020-05' => 'MAY 20',
                '2020-04' => 'APR 20',
                '2020-03' => 'MAR 20',
                '2020-02' => 'FEB 20',
                '2020-01' => 'JAN 20',
            ];

            // echo date(m).'55';
            ?>
            <select name="month" id="month"<?php 
            // if(isset($_GET['id'])){echo ' disabled';}
            ?>><?php

            if(isset($month)){
                $sm[$month] = ' selected';

            }else{
                $sm[date("Y-m")] = ' selected';

            }
            
            foreach($mos as $k => $v){
                // if($k<=date(m)){
                    echo '<option value="'.$k.'"'.$sm[$k].'>'.$v.'</option>';
                // }
            }
            
            ?>
            </select> 
        </div>
    <!-- <div class="form-group col-sm-6">
        <label>เลขที่ใบสำคัญจ่าย</label>
                                                            <input type="text" class="form-control" name="code" value="<?php echo $code;?>" required>
    
    </div> -->
    </div>
    <div class="form-row">
        <div class="form-group col-sm-6">
        <label>จ่ายให้</label>
                                                            <input type="text" class="form-control" name="pay_to" value="<?php echo $pay_to;?>" required>
    
    </div></div>
                                            <div class="form-row">
                                                    <div class="form-group col-sm-12">
                                                    <label>รายการ</label>
                                                    <textarea name="excel" class="form-control" rows="7" placeholder="รายการ|จำนวนเงิน
รายการ|จำนวนเงิน
.." required><?php echo implode("\n",$details);?>
</textarea>
</div></div>
<div class="form-row pt-2">
<div class="col-6">
<a href="action.php?mod=del&page=expense&id=<?php echo $id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
</div>
                                                <div class="col-6 text-right">

                                                    <input type="hidden" name="mod" value="expense-edit">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Import</button>

                                                </div>
                                                </div>
                                                <?php }?>
                                    </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
<?php }?>