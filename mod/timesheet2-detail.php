<?php

if(isset($_GET['uid'])){
    $uid = $_GET['uid'];
}else{
    $uid = $_SESSION['ses_uid'];
}

$rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `id` = ".$uid);
$row = mysqli_fetch_assoc($rs);

$id = $row['id'];
$name = $row['name'];
$position = $row['position'];
$code = $row['code'];

if(1==2){
    echo '<div class="btn-group mb-4">
    <a href="?mod=timesheet2-summary" class="btn btn-outline-primary active">Project Summary</a>
    <a href="?mod=timesheet2-overall" class="btn btn-outline-primary">Overall & Team Summary</a>
</div>';
}
?>

<div class="row">
    <div class="col-lg-9">
    <div class="card" data-sr-id="1" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h1><?php
                
                if(isset($_GET['mo'])){
                    $dateObj   = DateTime::createFromFormat('!m', substr($_GET['mo'],5,2));
                    echo $dateObj->format('F').' '.substr($_GET['mo'],0,4);
    
                }else{
                    echo 'Add New';
                }
                
                ?></h1>
            </div>
            <div class="col-6 text-right">
                <a href="/excel/?mod=timesheet2-detail&mo=<?php echo $_GET['mo'];?>" class="btn btn-sm btn-white">Excel</a>
            </div>
        </div>

<div class="row pb-2 text-center">
    <div class="col-2">วันที่</div>
    <div class="col-2">Project Number</div>
    <div class="col-2">Account Number</div>
    <div class="col-2">Hrs.</div>
    <div class="col-2">Strategy No.</div>
    <div class="col-2">MarTech No.</div>
</div>        

<?php
if(isset($_GET['mo'])){    
    $mo = $_GET['mo'];
    $sum_hour = 0;

    if(substr($mo,0,4)>2021){        
        $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet2` WHERE status = 2 AND `date` LIKE '$mo-%' AND `uid` = $uid ORDER BY `date` ASC");
        while($row=mysqli_fetch_assoc($rs)){
            $dt[] = [
                'date' => webdate($row['date']),
                'project_no' => $row['project_no'],
                'account_no' => $row['account_no'],
                'hour' => $row['hrs'],
                'strategy_no' => $row['strategy_no'],
                'martech_no' => $row['martech_no'],
            ];
        }

    }else{
        $rs = mysqli_query($conn,"SELECT a.id,a.date,a.date2,a.project_no,a.account_no,a.hour FROM `db_timesheet_detail` a join db_timesheet b where a.tid = b.id and b.status = 2 and (a.hour >0 or a.hour_dec > 0) AND b.uid = ".$_SESSION['ses_uid']." and b.month like '".$_GET['mo']."' ORDER BY `a`.`date` ASC");
        while($row=mysqli_fetch_assoc($rs)){
            $dt[] = [
                'date' => $row['date2'],
                'project_no' => $row['project_no'],
                'account_no' => $row['account_no'],
                'hour' => $row['hour'],
            ];
        }
    }

    foreach($dt as $k => $v){        
        echo '<div class="form-row border-top py-2 text-center">
        <div class="col-2">'.$v['date'].'</div>
        <div class="col-2">'.$v['project_no'].'</div>
        <div class="col-2">'.$v['account_no'].'</div>
        <div class="col-2">'.$v['hour'].'</div>
        <div class="col-2">'.$v['strategy_no'].'</div>
        <div class="col-2">'.$v['martech_no'].'</div>
    </div>';

        $sum_hour = $v['hour']+$sum_hour;
    }

}else{?>
<form action="action.php" method="post">
    <input type="hidden" name="mod" value="timesheet2">
<div class="input_fields_wrap">
    <?php
    
    // for($i=0;$i<5;$i++){
        echo '<div class="form-row border-top py-2 text-center">
        <div class="col-2"><input type="text" name="date[]" class="form-control" placeholder="วันที่" data-plugin="datepicker" data-option="{todayBtn: \'linked\'}"></div>
        <div class="col-3"><input type="text" name="project_no[]" class="form-control" placeholder="Project Number"></div>
        <div class="col-2"><input type="text" name="account_no[]" class="form-control" placeholder="Account Number"></div>
        <div class="col-2"><input type="text" name="hrs[]" class="form-control" placeholder="Hrs."></div>
        <div class="col-2"><input type="text" name="strategy_no[]" class="form-control" placeholder="Strategy No."></div>
    </div>        ';
    // }
    
    ?>
    </div>
    <div class="row">
        <div class="col-6">
        <!-- <button class="add_field_button btn btn-info" onclick="return false;">Add Row</button> -->
        </div>
        <div class="col-6 text-right">
            <input type="submit" value="Submit" class="btn btn-primary">
        </div>
    </div> 
</form>
<button class="add_field_button btn btn-info">Add Row</button>

<?php }?>

</div></div>

    </div>
    <div class="col-lg-3 text-center">
    <div class="card" data-sr-id="2" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <?php
        
        echo '<a href="#">
                    <div class="avatar w-64 mx-auto">
        <img src="/uploads/employee/'.$id.'.jpg" alt=".">
        <i class="on"></i>
        </div>
                </a>
        
                <h5 class="mt-3 text-center text-primary">
                    '.$name.'
                </h5>'.$position.'<br>
                ID: TIME'.str_pad($code, 3, '0', STR_PAD_LEFT).'
                
                <h5 class="my-4 text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><br>
                '.$dateObj->format('F').'
                </h5>
                
                Total Work Hours
                <h3 class="mb-3 text-primary">'.$sum_hour.'</h3>
                    
                Total Work Hours/week
                <h3 class="mb-3 text-primary">';
                echo $sum_hour/4;
                echo '</h3>
                
                Total Man Day
                <h3 class="mb-5 text-primary">';
                echo $sum_hour/8;
                echo '</h3>';
        
        ?>
        <a href="?mod=timesheet2-full&uid=<?php echo $uid.'&year='.substr($mo,0,4);?>">See Full Report ></a><br>
        </div>
</div>
    </div>
</div>

<script>
    $(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="form-row border-top py-2"><div class="col-2"><input type="text" class="form-control" placeholder="วันที่" data-plugin="datepicker" data-option="{todayBtn: \'linked\'}"></div><div class="col-3"><input type="text" class="form-control" placeholder="Project Number"></div><div class="col-2"><input type="text" class="form-control" placeholder="Account Number"></div><div class="col-2"><input type="text" class="form-control" placeholder="Hrs."></div><div class="col-2"><input type="text" class="form-control" placeholder="Strategy No."></div><div class="col-1"><a href="#" class="remove_field">Remove</a></div></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
	})
});
</script>