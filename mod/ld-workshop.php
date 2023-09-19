<?php
    $rs = mysqli_query($conn,"SELECT * FROM `db_ld` WHERE `id` = ".$_GET['sid']." AND `status` > 0");
    $dt = mysqli_fetch_assoc($rs);
?><div class="row">
    <div class="col-12">
        <div class="alert bg-success py-4" role="alert">
            <div class="d-flex">
                <i data-feather="inbox" width="32" height="32"></i>
                <div class="px-3">
                    <?php
                    
                    if($_GET['sid']==1){
                        // <a href="uploads/ld/'.$dt['guideline'].'" target="_blank" class="btn btn-white">Slide Guideline</a>
                        echo '<h5 class="text-white">Guideline Material</h5>';
                        foreach(json_decode($dt['guideline']) as $k => $v){
                            echo '<a href="uploads/ld/'.$k.'" target="_blank" class="btn btn-white">'.$v.'</a> ';
                        }
                        echo '<br><br>';
                    }
                    
                    ?>                    

                    <h5 class="text-white">Workshop Material</h5>
                    <?php
                        foreach(json_decode($dt['material']) as $k => $v){
                            echo '<a href="uploads/ld/'.$k.'" target="_blank" class="btn btn-white">'.$v.'</a> ';
                        }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="alert bg-white py-4" role="alert">
            <div class="d-flex">
                <i data-feather="send" width="32" height="32" class="text-primary"></i>
                <div class="px-3">
                    <form action="action.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="mod" value="ld">
                    <input type="hidden" name="sid" value="<?php echo $_GET['sid'];?>">

                    <h5>Send Workshop</h5>                    
                    <input type="file" name="workshop" required><br>

                    <?php
                    
                    if($_GET['sid']==5){
                        echo '<h5 class="mt-4">Presentation Date</h5>                    
                        <input type="text" name="present_date" class="form-control" data-plugin="datepicker" data-option="{autoclose: true, startDate: \''.date("d/m/Y").'\'}" required>
                        <select name="time" class="form-control mb-3" required>
                        <option value="">Time</option>
                        <option value="9">9am-10am</option>
                        <option value="10">10am-11am</option>
                        <option value="11">11am-12pm</option>
                        <option value="12">12pm-1pm</option>
                        <option value="13">1pm-2pm</option>
                        <option value="14">2pm-3pm</option>
                        <option value="15">3pm-4pm</option>
                        <option value="16">4pm-5pm</option>
                        <option value="17">5pm-6pm</option>
                        <option value="18">6pm-7pm</option>
                    </select>';
                    }
                    
                    ?>                                        

                    <input type="submit" value="Submit" class="btn btn-primary mt-2">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>