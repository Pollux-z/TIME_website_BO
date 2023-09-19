<?php

$accnos = [
    9001 => 'Consulting',
    9002 => 'Project Support',
    9003 => 'Business Development',
    9004 => 'Business Development (ไม่จำเป็นต้องมี Project No.)',
    9005 => 'Business Operation',
    9006 => 'MarTech',
    9007 => 'Training, Education',
    9008 => 'Product Development',
    9009 => 'Corporate Development',
    9010 => 'Vacation',
    9013 => 'Sick Leave',
    9014 => 'Compensation Day',
    9015 => 'Other Leave',
];

$stgnos = [
    'S1' => 'Salesforce for Digital Courses',
    'S2' => 'Cullen & Omdia Subscription',
    'S3' => 'Digital Solutions',
    'S4' => 'Customer Centricity',
    'S5' => 'Potential Partners',
    'S6' => 'G-Procument Opportunities',
    'S7' => 'Public Relation Events',
    'S8' => 'TCPP Program',
];

$mtnos = [
    'MT01' => 'Graphic',
    'MT02' => 'IT',
    'MT03' => 'Production',
    'MT04' => 'Marketing&PR',
];

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

if(isset($_GET['mo'])){
    $mo = $_GET['mo'];
    $sum_hour = 0;

    $rs = mysqli_query($conn,"SELECT * FROM `db_timesheet2` WHERE status = 2 AND `date` LIKE '$mo-%' AND `uid` = $uid ORDER BY `date` ASC");
    while($row=mysqli_fetch_assoc($rs)){
        $dt[$row['id']] = [
            // 'date' => webdate($row['date']),
            'date' => $row['date'],
            'project_no' => $row['project_no'],
            'account_no' => $row['account_no'],
            'hrs' => $row['hrs'],
            'strategy_no' => $row['strategy_no'],
            'martech_no' => $row['martech_no'],      
            'description' => $row['description'],            
        ];
    }
}

?><div class="text-right mb-4 d-none">
    <a href="?mod=timesheet2-summary">Project Summary</a> | 
    <a href="?mod=timesheet2-overall">Overall & Team Summary</a>
</div>

<div class="row">
    <div class="col-lg-9">
    <div class="card" data-sr-id="1" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
        <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h1>
                <?php
                if(isset($_GET['mo'])){
                    $dateObj   = DateTime::createFromFormat('!m', substr($_GET['mo'],5,2));
                    $month_name = $dateObj->format('F');
                    echo $month_name.' '.substr($_GET['mo'],0,4);
    
                }else{
                    echo 'Add New';
                }
                ?></h1>

</div><div class="col-5">

            </div>
            <div class="col-1">
            </div>
        </div>

<div class="row pb-2">
    <div class="col-1">วันที่</div>
    <div class="col-2">Project Number</div>
    <div class="col-2">Account Number</div>
    <div class="col-2">Description (BO,MT เท่านั้น)</div>
    <div class="col-1">Hrs.</div>
    <div class="col-2">Strategy No. (BD,CD เท่านั้น)</div>
    <div class="col-2">MarTech No. (MT เท่านั้น)</div>
</div>        

<form action="action.php" method="post">
    <input type="hidden" name="mod" value="timesheet2">
    <input type="hidden" name="mo" value="<?php echo $mo;?>">
    <input type="hidden" name="uid" value="<?php echo $uid;?>">
<div class="input_fields_wrap">
    <?php
    
    if(isset($dt)){
        // <input type="text" value="'.$v['account_no'].'" placeholder="Account Number">
        // <input type="text" name="strategy_no[]" value="'.$v['strategy_no'].'" class="form-control" placeholder="Strategy No.">
        // <input type="text" name="date[]" value="'.$v['date'].'" class="form-control" placeholder="วันที่" data-plugin="datepicker" data-option="{todayBtn: \'linked\'}">
        foreach($dt as $k => $v){
            echo '<div class="form-row border-top py-2">
            <div class="col-1"><select name="date[]" class="form-control px-0"><option value=""></option>';

            $sd = substr($v['date'],8,2);
            $sl[number_format($sd)] = ' selected';
            for($i=1;$i<=31;$i++){
                echo '<option'.$sl[$i].'>'.$i.' ('.getWeekday("$mo-$i").')</option>';
            }
            unset($sl);

            echo '</select></div>
            <div class="col-2"><input type="text" name="project_no[]" value="'.$v['project_no'].'" class="form-control" placeholder="TIME-2021xx"></div>            
            <div class="col-2"><select name="account_no[]" class="form-control"><option value="">Account No.</option>';

            $sl[$v['account_no']] = ' selected';
            foreach($accnos as $kk => $vv){
                echo '<option value="'.$kk.'"'.$sl[$kk].'>'.$kk.' - '.$vv.'</option>';
            }
            unset($sl);

            echo '</select></div>
            <div class="col-2"><input type="text" name="description[]" value="'.$v['description'].'" class="form-control"></div>
            <div class="col-1"><input type="text" name="hrs[]" value="'.$v['hrs'].'" class="form-control" placeholder="Hrs."></div>
            <div class="col-1"><select name="strategy_no[]" class="form-control px-0"><option value=""></option>';

            $sl[$v['strategy_no']] = ' selected';
            foreach($stgnos as $kk => $vv){
                echo '<option value="'.$kk.'"'.$sl[$kk].'>'.$kk.' - '.$vv.'</option>';
            }
            unset($sl);

            echo '</select></div><div class="col-2"><select name="martech_no[]" class="form-control"><option value=""></option>';

            $sl[$v['martech_no']] = ' selected';
            foreach($mtnos as $kk => $vv){
                echo '<option value="'.$kk.'"'.$sl[$kk].'>'.$kk.' - '.$vv.'</option>';
            }
            unset($sl);

            echo '</select></div>
            <div class="col-1"><a href="#" class="remove_field">ลบ</a></div>
        </div>        ';

            $sum_hour = $v['hrs']+$sum_hour;
        }

    }else{
        echo '<div class="form-row border-top py-2">
        <div class="col-1"><select name="date[]" class="form-control px-0"><option value=""></option>';
        for($i=1;$i<=31;$i++){
            echo '<option>'.$i.' ('.getWeekday("$mo-$i").')</option>';
        }
        echo '</select></div>
        <div class="col-2"><input type="text" name="project_no[]" class="form-control" placeholder="TIME-2021xx"></div>
        <div class="col-2"><select name="account_no[]" class="form-control"><option value="">..</option>';
        foreach($accnos as $k => $v){
            echo '<option value="'.$k.'">'.$k.' - '.$v.'</option>';
        }
        echo '</select></div>
        <div class="col-2"><input type="text" name="description[]" class="form-control"></div>
        <div class="col-1"><input type="text" name="hrs[]" class="form-control" placeholder="Hrs."></div>
        <div class="col-1"><select name="strategy_no[]" class="form-control px-0"><option value=""></option>';
        foreach($stgnos as $k => $v){
            echo '<option value="'.$k.'">'.$k.' - '.$v.'</option>';
        }
        echo '</select></div><div class="col-2"><select name="martech_no[]" class="form-control"><option value=""></option>';
        foreach($mtnos as $k => $v){
            echo '<option value="'.$k.'">'.$k.' - '.$v.'</option>';
        }
        echo '</select></div>
    </div>        ';

    }

    ?>
    </div>
    <div class="row">
        <div class="col-10">
        <button class="add_field_button btn btn-info">Add Row</button>
        <div class="mt-2 text-danger">* สำหรับพนักงานใหม่ที่อยู่ในช่วง Probation ให้ลงเวลาทำงานใน Project เป็น 9002<br>
        หลังจากผ่าน Probation แล้ว จึงสามารถบันทึก 9001 ได้</div>
        </div>
        <div class="col-2 text-right">
            <input type="submit" value="Submit" class="btn btn-primary">
        </div>
    </div> 
</form>

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
                ID: TIME'.str_pad($code, 3, '0', STR_PAD_LEFT);
                
                if(isset($month_name)){
                    echo '<h5 class="my-4 text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mx-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><br>
                    '.$month_name.'
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
                }
        ?>
        <div class="mt-3"><a href="?mod=timesheet2-full&uid=<?php echo $uid;?>">See Full Report ></a></div>
        </div>
</div>
    </div>
</div>

<script>
    $(document).ready(function() {
	var max_fields      = 100; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="form-row border-top py-2"><div class="col-1"><select name="date[]" class="form-control px-0"><option value=""></option><?
            for($i=1;$i<=31;$i++){
                echo '<option>'.$i.' ('.getWeekday("$mo-$i").')</option>';
            }
            ?></select></div><div class="col-2"><input type="text" name="project_no[]" class="form-control" placeholder="TIME-2021xx"></div><div class="col-2"><select name="account_no[]" class="form-control"><option value="">..</option><?php
            foreach($accnos as $k => $v){
                echo '<option value="'.$k.'">'.$k.' - '.$v.'</option>';
            }
            ?></select></div><div class="col-2"><input type="text" name="description[]" class="form-control"></div><div class="col-1"><input type="text" name="hrs[]" class="form-control" placeholder="Hrs."></div><div class="col-1"><select name="strategy_no[]" class="form-control px-0"><option value=""></option><?php
            foreach($stgnos as $k => $v){
                echo '<option value="'.$k.'">'.$k.' - '.$v.'</option>';
            }
            ?></select></div><div class="col-2"><select name="martech_no[]" class="form-control"><option value=""></option><?php
            foreach($mtnos as $k => $v){
                echo '<option value="'.$k.'">'.$k.' - '.$v.'</option>';
            }
            ?></select></div><div class="col-1"><a href="#" class="remove_field">ลบ</div></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
	})
});
</script><?php

function getWeekday($date) {
    return date('D', strtotime($date));
}

?>