<?php
    if(isset($_GET['code'])){
        $code = $_GET['code'];
    }else{
        $code = 'sienta';
    }


    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    if(isset($_GET['alert'])){
        if($_GET['alert']=='safedrive'){
            echo '<div class="alert alert-success" role="check">
            <i data-feather="info"></i>
            <span class="mx-2">บันทึกเรียบร้อย เดินทางโดยสวัสดิภาพจ้า</span>
        </div>';

        }elseif($_GET['alert']=='welcomeback'){
            echo '<div class="alert alert-success" role="check">
            <i data-feather="info"></i>
            <span class="mx-2">บันทึกเรียบร้อย Welcome back!</span>
        </div>';

        }
    }


?>

<div class="row">
    <?php
    if($_SESSION['ses_ulevel']>0){
        $rss = mysqli_query($conn,"SELECT DISTINCT DATE(start_date) date FROM `db_reserve` WHERE `code` LIKE '$code' and status > 0 and start_date >= '$today' ORDER BY `date` ASC limit 3");
        while($roww=mysqli_fetch_assoc($rss)){
            $days[] = $roww['date'];
        }

        $sql = "SELECT * FROM `db_reserve` WHERE `code` LIKE '$code' and status > 0 ORDER BY start_date ASC";
        $rss = mysqli_query($conn,$sql);
        while($roww=mysqli_fetch_assoc($rss)){
            $date = substr($roww['start_date'],0,10);
            $hour = substr($roww['start_date'],11,5);
            $hour_end = substr($roww['end_date'],11,5);

            $lefts[$date][] = [
                $roww['id'],
                $roww['uid'],
                $hour,
                $hour_end,
                $roww['note'],
            ];
        }

        $tmr = new DateTime('tomorrow');       

        function getWeekday($date) {
            return date('D', strtotime($date));
        }

        // echo json_encode($lefts);

        foreach($days as $v){
            echo '<div class="col-lg-4 d-flex">
                <div class="card flex">
                    <div class="card-body">
                        <small>'.getWeekday($v).' '.webdate($v);
                        if($v==date("Y-m-d")){
                            echo ' (วันนี้)';
                        }elseif($v==$tmr->format('Y-m-d')){
                            echo ' (พรุ่งนี้)';
                        }
                        echo '<br>';

                        foreach($lefts[$v] as $w){
                            echo $w[2].'-'.$w[3].' / '.$time1[$w[1]].' / '.$w[4];
                            if($_SESSION['ses_ulevel']>7){
                                echo ' <a href="action.php?mod=del&page=carreserve&id='.$w[0].'">ลบ</a>';
                            }
                            // if($w[2]=='0.5'){
                            //     echo ' (ครึ่งวัน)';
                            // }
                            echo '<br>';
                        }
                        
                        echo '</small>
                    </div>
                </div>
            </div><br>';
        }    
    }
?>
</div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Date</span></th>
                                            <th><span class="text-muted">Destination / Recorder</span></th>
                                            <th><span class="text-muted">Remark</span></th>
                                            <th><span class="text-muted">ODO (Mile)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_carrec` ORDER BY `id` DESC");
                                            while($row=mysqli_fetch_assoc($rs)){       
                                                
                                                $dg = explode(' ',$row['date_go']);
                                                if($row['date_back']!=null){
                                                    $db = explode(' ',$row['date_back']);
                                                    $time = substr($dg[1],0,5).'-'.substr($db[1],0,5);
                                                    $km_back = $row['km_back'];
                                                }else{
                                                    $time = substr($dg[1],0,5);
                                                }

                                                // number_format($row['km_go']).'
                                                $length = $row['km_back']-$row['km_go'];

                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">'.$row['id'].'</small>
                                                        </td>
                                                        <td>
                                                            '.$dg[0].'
                                                            <div class="item-except text-muted text-sm h-1x">
                                                            '.$time.'
                                                            </div>
                                                        </td>
                                                        <td class="flex">
                                                            '.$row['destination'].'
                                                            <div class="item-except text-muted text-sm h-1x">
                                                            '.$time1[$row['uid_go']];

                                                            if(isset($km_back)&&$row['uid_go']!=$row['uid_back']){
                                                                echo ', '.$time1[$row['uid_back']];
                                                            }

                                                            echo '</div>
                                                        </td>
                                                        <td>

                                                        '.$row['remark_go'].'
                                                        <div class="item-except text-muted text-sm h-1x">
                                                            '.$row['remark_back'].'
                                                            </div>
                                                        
                                                        </td>
                                                        <td>

                                                        '.$km_back.'<div class="item-except text-muted text-sm h-1x">';

                                                        if($km_back!=''){
                                                            echo number_format($length).'km';
                                                        }else{
                                                            echo 'Driving..';
                                                        }
                                                            echo '</div>';
                                                        

                                                        echo '</td>
                                                    </tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>