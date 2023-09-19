<?php if($page=='print'){

function thaibaht($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
    return $ret;
}

function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}
?>
<style>
    .border, .table-bordered td{
        border-color:#000 !important;
    }
    body{
        color:#000;
        font-size: 16px;
    }
</style>
    <div class="row">
        <div class="col-3"><img src="assets/img/logo.png" style="height:60px;"></div>
        <div class="col-6 text-center">บริษัท ไทม์ คอนซัลติ้ง จำกัด<br>ใบสำคัญจ่าย<br>Payment Voucher</div>
    </div>
    <div class="row">
        <div class="col-4 offset-8">เลขที่/No <?php 
                                    
                                    $rs = mysqli_query($conn,"SELECT * FROM `db_expense` WHERE `id` = $id");
                                    $row = mysqli_fetch_assoc($rs);
                                    
                                    echo $row['code'];
                                                                    
                                                                    ?><br>วันที่/Date <?php 
                                                                                                                                    
    $cds = explode('-',substr($row['created_at'],0,10));
    echo $cds[2].'/'.$cds[1].'/';
    echo $cds[0]+543;                                               
                                                                    
                                                                    ?></div>
        <div class="col-12">จ่ายให้/Pay to <?php echo $row['pay_to'];?></div>
    </div>

    <table class="table table-bordered"><tbody><tr class="text-center"><td>รายการ/Description</td><td>จำนวนเงิน/Amount</td></tr>
    <?php  
                                    
                                                                        
                                    $rs = mysqli_query($conn,"SELECT `id`, `code`, `name` FROM `db_project` ORDER BY `code` DESC");
                                    while($row = mysqli_fetch_assoc($rs)){
                                        $projs[$row['code']] = $row['code'].' '.substr($row['name'],0,30);
                                    }
                                
                                    $rs = mysqli_query($conn,"SELECT * FROM `db_expense_detail` WHERE status = 2 and `eid` = $id");
                                    while($row = mysqli_fetch_assoc($rs)){    
                                        $acc_no = $row['acc_no'];
                                        $proj_no = $row['proj_no'];
                                
                                        if($proj_no!=''){
                                            $acc_no = $acc_no.'-'.$proj_no;
                                        }
                                
                                        $slt[$acc_no] = ' selected';
                                
                                                                    // foreach ($excel as list($a,$b,$c,$d)) {
                                                            ?>
                                
    <tr><td><?php echo $row['title'];?></td><td class="text-right"><?php 
                                    $cost = $row['cost'];
                                    $total = $cost+$total;
                                    echo number_format($cost,2);
                                    
                                    ?></td></tr>
                                                                <?php 
                                                            
                                                            unset($slt);
                                                            
                                                            }?>    
    
    </tbody><tfoot class="text-right"><tr><td>รวมทั้งหมด</td><td><?php echo number_format($total,2);?></td></tr></tfoot></table>

    <div class="row">
        <div class="col-12">
            <div class="col-12 border bg-light p-3">
                <div class="row">
                    <div class="col-3">จำนวนเงิน The Sum of Bahts</div>
                    <div class="col-9"><?php echo thaibaht($total);?></div>            
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4">
    <div class="col-2">Payment<br>โดยชำระเป็น</div>
    <div class="col-5"><i class="mx-2" data-feather="square"></i> เงินสด/Cash<br><br><i class="mx-2" data-feather="square"></i> เช็คธนาคาร/Bank ............................................................</div>
    <div class="col-5">เช็คลงวันที่/Date ............................................................<br><br>เลขที่เช็ค/No ............................................................</div>
    </div>
    <div class="row">
        <div class="col-4">
        ผู้รับเงิน ............................................................<br><br>วันที่ ............................................................
        </div>
        <div class="col-4">
        ผู้จ่ายเงิน ............................................................<br><br>วันที่ ............................................................
        </div>
        <div class="col-4">
        ผู้อนุมัติ ............................................................<br><br>วันที่ ............................................................
        </div>
    </div>

    <div class="d-flex py-3">
                                <div class="flex"></div>
                                <a href="?mod=expense-view&id=<?php echo $id;?>" class="btn btn-sm btn-secondary d-print-none mr-2">Back</a>
                                <a href="#" class="btn btn-sm btn-primary d-print-none" onClick="window.print();">Print</a>
                            </div>

<?php }else{?>                            <div class="d-flex align-items-center py-4">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/img/logo.png" style="height:60px;">
                                    </div>
                                </div>
                                <div class="flex"></div>
                                <div class="text-right">
                                    <div class="text-sm text-fade">PAYMENT VOUCHER</div>
                                    <div class="text-highlight"><?php 
                                    
    $rs = mysqli_query($conn,"SELECT * FROM `db_expense` WHERE `id` = $id");
    $row = mysqli_fetch_assoc($rs);
    
    echo $row['code'];

    $rs = mysqli_query($conn,"SELECT `id`, `code`, `name` FROM `db_project` WHERE status != 0 ORDER BY `code` DESC");
    while($row = mysqli_fetch_assoc($rs)){
        $projs[$row['code']] = $row['code'].' '.substr($row['name'],0,30);
    }

                                    
                                    ?></div>
                                    <div class="text-highlight">Pay to <?php echo $row['pay_to'];?></div>
                                    <div class="text-sm text-muted"><?php echo $row['created_at'];?></div>
                                </div>
                            </div>

                            <form action="action.php" method="POST">
                                <input type="hidden" name="mod" value="cost_center">
                                <!-- <input type="hidden" name="id" value="<?php echo $id;?>"> -->

                            <table class="table table-theme table-rows v-middle">
                                <thead>
                                    <tr>
                                        <th class="text-muted">
                                            Cost Center
                                            <select id="user_selected" data-plugin="select2" data-option="{}">
                                                <option value="">-- Set All --</option>                                                                            
                                                <option value="9003">9003 - BD</option>
                                                <option value="9007">9007 - Training</option>
                                                <option value="9008">9008 - Prod Dev</option>
                                                <optgroup label="9005 - BO">
                                                    <option value="9005-sal">เงินเดือน</option>
                                                    <option value="9005-off">ค่าใช้จ่ายสำนักงาน</option>
                                                    <option value="9005-ren">ค่าเช่าสำนักงาน</option>
                                                    <option value="9005-oth">ค่าใช้จ่ายอื่นๆ</option>
                                                    <option value="9005-vat">VAT</option>
                                                    <option value="9005-pit1">ภงด.1</option>
                                                    <option value="9005-pit3">ภงด.3</option>
                                                    <option value="9005-pit53">ภงด.50</option>
                                                    <option value="9005-pit53">ภงด.53</option>
                                                    <option value="9005-pit30">ภพ.30</option>
                                                    <option value="9005-pit36">ภพ.36</option>
                                                    <option value="9005-wht">หัก ณ ที่จ่าย</option>
                                                    <option value="9005-sso">ประกันสังคม</option>
                                                    <option value="9005-frc">ค่าที่ปรึกษาต่างประเทศ</option>
                                                    <option value="9005-cap">ค่าใช้จ่ายด้านการลงทุน (CAPEX)</option>
                                                    <option value="9005-car">ค่าเช่ารถ</option>
                                                </optgroup>
                                                <optgroup label="9001 - ค่าใช้จ่ายโครงการ">
                                                    <option value="9001">Other/Unknow Project</option>
                                                    <?php

                                                    foreach($projs as $k => $v){
                                                        echo '<option value="9001-'.$k.'"'.$slt['9001-'.$k].'>'.$v.'</option>';
                                                    }

                                                    ?>
                                                </optgroup>
                                            </select>
                                        </th>
                                        <th class="text-muted">Items</th>
                                        <th class="text-muted text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php  
    if(isset($_GET['id'])){
        $rs = mysqli_query($conn,"SELECT * FROM `db_expense_detail` WHERE status = 2 and `eid` = $id");

    }else{
        $rs = mysqli_query($conn,"SELECT * FROM `db_expense_detail` a join db_expense b WHERE a.eid = b.id and a.status != 0 and a.`proj_no` LIKE '".$_GET['proj_no']."' and b.month = '".$_GET['month']."'");

    }
    while($row = mysqli_fetch_assoc($rs)){    
        $acc_no = $row['acc_no'];
        $proj_no = $row['proj_no'];

        if($proj_no!=''){
            $acc_no = $acc_no.'-'.$proj_no;
        }

        $slt[$acc_no] = ' selected';

                                    // foreach ($excel as list($a,$b,$c,$d)) {
                            ?>
                            
                                                                <tr>
                                                                    <td>
                                                                        <select name="costcenter[<?php echo $row['id'];?>]" class="sel_users form-control" data-plugin="select2" data-option="{}" data-placeholder="Select an option" style="width:300px;" required>
                                                                            <option></option>                                                                            
                                                                            <option value="9003"<?php echo $slt['9003'];?>>9003 - BD</option>
                                                                            <!-- <option value="9005">9005 - BO</option> -->
                                                                            <option value="9007"<?php echo $slt['9007'];?>>9007 - Training</option>
                                                                            <option value="9008"<?php echo $slt['9008'];?>>9008 - Prod Dev</option>
                                                                            <optgroup label="9005 - BO">
                                                                                <option value="9005-sal"<?php echo $slt['9005-sal'];?>>เงินเดือน</option>
                                                                                <option value="9005-off"<?php echo $slt['9005-off'];?>>ค่าใช้จ่ายสำนักงาน</option>
                                                                                <option value="9005-ren"<?php echo $slt['9005-ren'];?>>ค่าเช่าสำนักงาน</option>
                                                                                <option value="9005-oth"<?php echo $slt['9005-oth'];?>>ค่าใช้จ่ายอื่นๆ</option>
                                                                                <option value="9005-vat"<?php echo $slt['9005-vat'];?>>VAT</option>
                                                                                <option value="9005-pit1"<?php echo $slt['9005-pit1'];?>>ภงด.1</option>
                                                                                <option value="9005-pit3"<?php echo $slt['9005-pit3'];?>>ภงด.3</option>
                                                                                <option value="9005-pit53"<?php echo $slt['9005-pit50'];?>>ภงด.50</option>
                                                                                <option value="9005-pit53"<?php echo $slt['9005-pit53'];?>>ภงด.53</option>
                                                                                <option value="9005-pit30"<?php echo $slt['9005-pit30'];?>>ภพ.30</option>
                                                                                <option value="9005-pit36"<?php echo $slt['9005-pit36'];?>>ภพ.36</option>
                                                                                <option value="9005-wht"<?php echo $slt['9005-wht'];?>>หัก ณ ที่จ่าย</option>
                                                                                <option value="9005-sso"<?php echo $slt['9005-sso'];?>>ประกันสังคม</option>
                                                                                <option value="9005-frc"<?php echo $slt['9005-frc'];?>>ค่าที่ปรึกษาต่างประเทศ</option>
                                                                                <option value="9005-cap"<?php echo $slt['9005-cap'];?>>ค่าใช้จ่ายด้านการลงทุน (CAPEX)</option>
                                                                                <option value="9005-car"<?php echo $slt['9005-car'];?>>ค่าเช่ารถ</option>
                                                                            </optgroup>
                                                                            <optgroup label="9001 - ค่าใช้จ่ายโครงการ">
                                                                                <option value="9001">Other/Unknow Project</option>
                                                                                <?php

                                                                                foreach($projs as $k => $v){
                                                                                    echo '<option value="9001-'.$k.'"'.$slt['9001-'.$k].'>'.$v.'</option>';
                                                                                }

                                                                                ?>
                                                                            </optgroup>
                                                                        </select>
                                                                    </td>
                                                                    <td><?php echo $row['title'];?>
                                                                        <!-- <div class="text-sm text-muted">Marketing and TV ads</div> -->
                                                                    </td>
                                                                    <td class="text-right"><?php 
                                    $cost = $row['cost'];
                                    $total = $cost+$total;
                                    echo number_format($cost,2);
                                    
                                    ?></td>
                                                                </tr>
                                                                <?php 
                                                            
                                                            unset($slt);
                                                            
                                                            }?>    
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><input type="submit" class="btn btn-primary" value="Save" ></td>
                                        <td colspan="2" class="text-right no-border">
                                            <small class="muted mx-2">Total: </small>
                                            <strong class="text-success"><?php echo number_format($total,2);?></strong>
                                        </td>
                                    </tr>
                                </tfoot>                                
                            </table>

                            </form>

                            <div class="d-flex py-3">
                                <div class="flex"></div>
                                <a href="?mod=expense-view&id=<?php echo $id;?>&page=print" class="btn btn-sm btn-primary d-print-none">Print Version</a>
                            </div>
                                                        <?php }?>