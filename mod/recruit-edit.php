<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $rs = mysqli_query($conn,"SELECT * FROM `db_recruit` WHERE `id` = $id AND status > 0");
        $row = mysqli_fetch_assoc($rs);

        $name = $row['name'];
        $nick = $row['nick'];
        $dob = webdate($row['dob']);
        $position = $row['position'];
        $file = $row['file'];
        if($row['next_interview_date']!=null){
            $nis = explode(' ',$row['next_interview_date']);
            $next_interview_date = webdate($nis[0]);
            $next_interview_time = substr($nis[1],0,5);
        }
        $start_date = $row['start_date'];

    // }else{
    //     $id = $_SESSION['ses_uid'];
    }

    // $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = $id");
    // $row = mysqli_fetch_assoc($rs);


    if($_GET['alert']=='created'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success! Your cover letter number is <b>TIME'.substr($row['date'],0,4).'-'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below when document signed.</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="action.php" method="POST" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong><?php
                                                
                                                // if(isset($id)){
                                                    // echo 'TIME'.substr($row['date'],0,4).'-'.str_pad($row['code'], 5, 0, STR_PAD_LEFT);
                                                // }else{
                                                    // echo 'สร้างโปรเจ็คท์ใหม่';

                                                    // $yr = date(Y);

                                                    // $rs = mysqli_query($conn,"SELECT `code` FROM `db_project` WHERE `code` LIKE '$yr%' AND `status` != 0 ORDER BY `code` DESC LIMIT 1");
                                                    // $row = mysqli_fetch_assoc($rs);
                                                    // $cnt = mysqli_num_rows($rs);

                                                    // if($cnt!=0){
                                                    //     $code = $row['code']+1;
                                                    // }else{
                                                    //     $code = $yr.'01';
                                                    // }                                                    
                                                // }
                                                
                                                ?></strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label>ชื่อ-นามสกุล</label>
                                                        <input type="text" class="form-control" name="name" value="<?php echo $name;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ชื่อเล่น</label>
                                                        <input type="text" class="form-control" name="nick" value="<?php echo $nick;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>วันเดือนปีเกิด</label>
                                                        <input type='text' class="form-control mb-3" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="dob" value="<?php echo $dob;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                                                    </div>  
                                                    <div class="form-group col-sm-6">
                                                        <label>ตำแหน่งที่สมัคร</label>
                                                        <input type="text" class="form-control" name="position" value="<?php echo $position;?>">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>CV/Resume</label><br>
                                                        <input type="file" name="cv" id="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Transcript</label><br>
                                                        <input type="file" name="transcript" id="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>ID Card</label><br>
                                                        <input type="file" name="idcard" id="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label>Book Bank</label><br>
                                                        <input type="file" name="bookbank" id="">
                                                    </div>
                                                </div>

                                                <label class="mt-3">สัมภาษณ์ครั้งต่อไป</label>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <input type='text' class="form-control mb-3" placeholder="วันที่" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="next_interview_date" value="<?php echo $next_interview_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        // }else{echo ' required';
                                                        }?>>
                                                    </div>  
                                                    <div class="form-group col-sm-6">
                                                        <select name="next_interview_time" id="" class="form-control">
                            <option value="">เวลา</option><?php
                            
                            $times = ['07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30','00:00','00:30','01:00','01:30','02:00','02:30','03:00','03:30','04:00','04:30','05:00','05:30','06:00','06:30'];

                            foreach($times as $v){
                                echo '<option';
                                if($next_interview_time==$v){
                                    echo ' selected';
                                }
                                echo '>'.$v.'</option>';
                            }
                            
                            ?></select>
                                                 <!-- Create by Leo : Test create update accept recruitment  -->
                                                <label class="mt-3">วันที่เริ่มงาน</label>
                                                <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <input type='text' class="form-control mb-3" placeholder="วันที่" data-plugin="datepicker" data-option="{todayBtn: 'linked'}" name="start_date" value="<?php echo $start_date;?>"  autocomplete="off"<?php if(isset($readonly)){echo $readonly;
                                                        }?>>
                                                    </div>  
                                                </div> 
                                                <!-- end -->
                                                </div>

                                                        
                                                <div class="text-right pt-2">
                                                <?php if(empty($readonly)){?>
                                                    <input type="hidden" name="mod" value="recruit">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>