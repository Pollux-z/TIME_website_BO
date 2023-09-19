<?php
include 'global.php';
conndb();

// $code = 'meetingroom';
$code = $_GET['code'];
$q = sqldate($_GET['q']);
// echo $q;

$times = ['07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30','00:00','00:30','01:00','01:30','02:00','02:30','03:00','03:30','04:00','04:30','05:00','05:30','06:00','06:30'];
                    
                    $sql = "SELECT * FROM `db_reserve` WHERE `code` LIKE '".$code."' and start_date like '$q%' ORDER BY `db_reserve`.`start_date` ASC";
                    // echo $sql;
                    // die();
                    
                    ?>
                        <select name="from_time" id="" class="form-control" required>
                            <option value="">From</option>
                            <?php

                                $rs = mysqli_query($conn,$sql);
                                while($row=mysqli_fetch_assoc($rs)){
                                    $ranges[] = [strtotime($row['start_date']),strtotime($row['end_date'])];
                                }

                                foreach($times as $v){
                                    $chk = strtotime("$q $v");
                                    foreach($ranges as $w){
                                        if($chk>=$w[0]&&$chk<$w[1]){
                                            $dab = ' disabled';
                                        }
                                    }
                                    echo '<option'.$slft[$v].$dab.'>'.$v.'</option>';
                                    $dab = '';
                                }
                            
                            ?>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text">to</span>
                        </div>
                        <select name="to_time" id="" class="form-control" required>
                            <option value="">To</option>
                            <?php

foreach($times as $v){
    $chk = strtotime("$q $v");
    foreach($ranges as $w){
        if($chk>$w[0]&&$chk<=$w[1]){
            $dab = ' disabled';
        }
    }
    echo '<option'.$sltt[$v].$dab.'>'.$v.'</option>';
    $dab = '';
}

closedb();

                            
                            ?>
                        </select>