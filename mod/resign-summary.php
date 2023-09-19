<?php
    if(isset($_GET['years'])&&isset($_GET['months'])){
        foreach($_GET['years'] as $v){
            foreach($_GET['months'] as $vv){
                $s[] = "`end_date` LIKE '$v-$vv-%'";
            }
        }

    }elseif(isset($_GET['years'])){
        foreach($_GET['years'] as $v){
            $s[] = "`end_date` LIKE '$v-%'";
        }

    }elseif(isset($_GET['months'])){
        foreach($_GET['months'] as $v){
            $s[] = "`end_date` LIKE '%-$v-%'";
        }

    }

    $sq = implode(' OR ',$s);

    $sql = "SELECT * FROM `db_employee` WHERE $sq ORDER BY `end_date` ASC";
    $rs = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['id']] = [
            $row['name'],
            $row['position'],
            $row['end_date'],
        ];
    }

?><div class="card">
    <div class="card-header">
        <strong>Summary Report</strong>
    </div>
    <div class="card-body">
        <form action="">
            <input type="hidden" name="mod" value="resign-summary">
            <div class="form-group row">
                <div class="col-lg-4"></div>
                <!-- <label class="col-sm-4 col-form-label">เลือกปี</label> -->
                <div class="col-lg-3">
                เลือกปี
                    <select name="years[]" multiple class="form-control">
                        <?php
                            for($i=2020;$i<=date(Y);$i++){
                                if(in_array($i,$_GET['years'])){
                                    $sl = ' selected';
                                }else{
                                    $sl = '';
                                }
                                echo '<option '.$sl.'>'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
            <!-- </div>
            <div class="form-group row"> -->
                <!-- <label class="col-sm-4 col-form-label">เลือกเดือน</label> -->
                <div class="col-lg-3">
                เลือกเดือน
                    <select name="months[]" multiple class="form-control">
                        <?php
                        
                            foreach($tmonth as $k => $v){
                                if(in_array($k,$_GET['months'])){
                                    $sl = ' selected';
                                }else{
                                    $sl = '';
                                }
                                echo '<option value="'.$k.'"'.$sl.'>'.$v.'</option>';
                            }

                        ?>
                        
                    </select>
                </div>
                <div class="col-lg-2">
                    <br><input type="submit" value="Filter">
                </div>
            </div>            
        </form>
    </div>
</div>

<?php if(isset($_GET['years'])||isset($_GET['months'])){?>
<div class="row row-sm sr">
    <div class="col-md-4">
        <div class="card flex">
            <div class="card-body text-center">
                <div class="mb-5">
                        <?php
                        foreach($dt as $k => $v){
                            // if($i<6){
                            echo '<img src="uploads/employee/'.$k.'.jpg" class="rounded-circle w-64 m-1">';                            
                        }
                        
                        ?>
                </div>
                <small class="text-muted">จำนวนคนที่ลาออก</small>
                <div class="text-primary mt-2" style="font-size:80px;" data-plugin="countTo" data-option="{
                from: 0,
                to: <?php 
                $ttr = mysqli_num_rows($rs);
                echo $ttr;?>,
                refreshInterval: 15,
                speed: 500,
                formatter: function (value, options) {
                  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
                }"></div>
            </div>
        </div>

    </div>
    <div class="col-md-2">
        <div class="card flex">
            <div class="card-body text-center">
                <small>ปี</small>
                <h2 class="text-primary mt-3">
                    <?php
                    $y = 0;
                    if(isset($_GET['years'])){
                        foreach($_GET['years'] as $v){
                            echo $v.'<br>';
                            $yi = $v;
                            $y++;
                        }
                    }else{
                        echo 'All';
                    }
                        
                    ?>
                </h2>
            </div>
        </div>

        <div class="card flex">
            <div class="card-body text-center">
                <small>เดือน</small>
                <h2 class="text-primary mt-3">
                    <?php
                    $m = 0;
                    if(isset($_GET['months'])){                        
                        foreach($_GET['months'] as $v){
                            echo $emo[$v].'<br>';
                            $mi = $v;
                            $m++;
                        }
                    }else{
                        echo 'All';
                    }
                    ?>
                </h2>
            </div>
        </div>

        <div class="card flex">
            <div class="card-body text-center">
                <small>จำนวนพนักงาน</small>
                <h2 class="text-primary mt-3">
                    <?php
                    $nmn = $mi+1;
                    $nm = str_pad($nmn, 2, '0', STR_PAD_LEFT); 
                    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `start_date` < '$yi-$nm-01' AND (`end_date` >= '$yi-$mi-01' OR end_date IS NULL)");
                    $ttl = mysqli_num_rows($rs);
                    echo $ttl;
                    ?>
                </h2>
            </div>
        </div>

        <?php if($y==1&&$m==1){?>
        <div class="card flex">
            <div class="card-body text-center">
                <small>Turnover Rate</small>
                <h2 class="text-primary mt-3">
                    <?php
                    echo number_format($ttr/$ttl*100,2);
                    echo '%';
                    ?>
                </h2>
            </div>
        </div>
        <?php }?>

    </div>
    <div class="col-md-6">

                                    <div class="card">
                                        <div class="p-3-4">
                                            <div class="d-flex">
                                                <div>
                                                    <div>รายละเอียด</div>
                                                    <!-- <small class="text-muted">Total: 230</small> -->
                                                </div>
                                                <span class="flex"></span>
                                                <div>
                                                    <a href="/excel/?<?php echo $_SERVER['QUERY_STRING'];?>" class="btn btn-sm btn-white">Excel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-theme v-middle m-0">
                                            <tbody>
<?php
    $i = 0;
    // while($row=mysqli_fetch_assoc($rs)){
    foreach($dt as $k => $v){
        $i++;
        echo '<tr class=" " data-id="'.$k.'">
        <td style="min-width:30px;text-align:center">
            '.$i.'
        </td>
        <td>
            <div class="avatar-group ">
                <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="Urna">
                    <img src="uploads/employee/'.$k.'.jpg" alt=".">
                </a>
            </div>
        </td>
        <td class="flex">
            <a href="https://bo.timeconsulting.co.th/?mod=employee-profile&id='.$k.'" target="_blank">
                '.$v[0].'
            </a>
            <div class="item-mail text-muted h-1x d-none d-sm-block">
                '.$v[1].'
            </div>
        </td>
        <td>
            <span class="item-amount d-none d-sm-block text-sm ">
'.webdate($v[2]).'
</span>
        </td>
        <td>
            <div class="item-action dropdown">
                <a href="#" data-toggle="dropdown" class="text-muted">
                    <i data-feather="more-vertical"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                    <a class="dropdown-item" href="#">
                        See detail
                    </a>
                    <a class="dropdown-item download">
                        Download
                    </a>
                    <a class="dropdown-item edit">
                        Edit
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item trash">
                        Delete item
                    </a>
                </div>
            </div>
        </td>
    </tr>';
    }
?>                                                
                                                

                                            </tbody>
                                        </table>
                                    </div>
    </div>
</div>
<?php }?>