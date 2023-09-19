<?php
    if(isset($_GET['years'])&&isset($_GET['months'])){
        foreach($_GET['years'] as $v){
            foreach($_GET['months'] as $vv){
                $s[] = "`created_at` LIKE '$v-$vv-%'";
            }
        }

    }elseif(isset($_GET['years'])){
        foreach($_GET['years'] as $v){
            $s[] = "`created_at` LIKE '$v-%'";
        }

    }elseif(isset($_GET['months'])){
        foreach($_GET['months'] as $v){
            $s[] = "`created_at` LIKE '%-$v-%'";
        }

    }

    $sq = implode(' OR ',$s);

    $pass = $fail = $t1 = $t2 = $t3 = 0;

    $sql = "SELECT * FROM `db_recruit` WHERE $sq ORDER BY `created_at` DESC";
    $rs = mysqli_query($conn,$sql);
    // $cnt = mysqli_num_rows($rs);

    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['id']] = [
            $row['name'],
            $row['position'],
            $row['start_date'],
            $row['status'],
        ];
        
        if($row['interview_status3']==1){
            $t3 = $t3+1;

        }elseif($row['interview_status2']==1){
            $t2 = $t2+1;

        }elseif($row['interview_status1']==1){
            $t1 = $t1+1;
        }
        
        if($row['status']==4){
            $pass = $pass+1;
        }else{
            $fail = $fail+1;
        }
    }

    $passes = [
        1 => $t1,
        2 => $t2,
        3 => $t3,
    ];

?><div class="card">
    <div class="card-header">
        <strong>Summary Report</strong>
    </div>
    <div class="card-body">
        <form action="">
            <input type="hidden" name="mod" value="recruit-summary">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">เลือกปี</label>
                <div class="col-lg-4">
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
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">เลือกเดือน</label>
                <div class="col-lg-4">
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
            </div>
            <input type="submit" value="Filter">
        </form>
    </div>
</div>

<?php if(isset($_GET['years'])||isset($_GET['months'])){?>
<div class="row row-sm sr">
    <div class="col-md-4">
        <?php        
        foreach($passes as $k => $v){
            echo '<div class="card flex">
            <div class="card-body text-center">
                <small class="text-muted">จำนวนที่ผ่าน รอบ '.$k.'</small>
                <div class="text-primary mt-2" style="font-size:80px;" data-plugin="countTo" data-option="{
                from: 0,
                to: '.$v.',
                refreshInterval: 15,
                speed: 500,
                formatter: function (value, options) {
                  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
                }
                }"></div>
            </div>
        </div>';
        }
        ?>
        
    </div>
    <div class="col-md-2">
        <div class="card flex">
            <div class="card-body text-center">
                <small>ปี</small>
                <h2 class="text-primary mt-3">
                    <?php
                    if(isset($_GET['years'])){
                        foreach($_GET['years'] as $v){
                            echo $v.'<br>';
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
                    if(isset($_GET['months'])){
                        foreach($_GET['months'] as $v){
                            echo $emo[$v].'<br>';
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
                <small>จำนวนคนเข้าสัมภาษณ์ทั้งหมด</small>
                <h2 class="text-primary mt-3">
                    <?php echo count($dt);?>
                </h2>
            </div>
        </div>

        <div class="card flex">
            <div class="card-body text-center">
                <small>Success Rate</small>
                <h2 class="text-primary mt-3">
                    <?php echo number_format($t3/count($dt)*100,2);?>%
                </h2>
            </div>
        </div>

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
        <td class="flex">
            <a href="https://bo.timeconsulting.co.th/?mod=employee-profile&id='.$k.'" target="_blank">
                '.$v[0].'
            </a>
            <div class="item-mail text-muted h-1x d-none d-sm-block">
                '.$v[1].'
            </div>
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