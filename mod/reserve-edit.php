
<style>
select option:disabled {
    color: #ddd;
}
</style>
    <?php
    if($id!=''){
        $rs = mysqli_query($conn,"SELECT * FROM `db_reserve` WHERE `id` = $id AND `status` > 0");
        $row = mysqli_fetch_assoc($rs);

        $note = $row['note'];
        $start_date = explode(' ',$row['start_date']);
        $end_date = explode(' ',$row['end_date']);

        $sd = explode('-',$start_date[0]);
        $ed = explode('-',$end_date[0]);

        $from_date = $sd[2].'/'.$sd[1].'/'.$sd[0];
        $to_date = $ed[2].'/'.$ed[1].'/'.$ed[0];
        $from_time = substr($start_date[1],0,5);
        $to_time = substr($end_date[1],0,5);

        $slft[$from_time] = ' selected';                            
        $sltt[$to_time] = ' selected';
    }else{
        $from_date = webdate($today);
        $to_date = webdate($today);
    }

    $times = ['07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30','00:00','00:30','01:00','01:30','02:00','02:30','03:00','03:30','04:00','04:30','05:00','05:30','06:00','06:30'];
    
?><div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Reserve <?php echo ucfirst($_GET['code']);?></strong>
            </div>
            <div class="card-body">
            <form action="action.php" method="POST">


<?php
    if($_GET['code']=='skilllane'||$_GET['code']=='edumall'||$_GET['code']=='udemy'){

        ?>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">Course</label>
            <div class="col-sm-9">
                <select name="note" id="event-title" class="form-control" required>
                            <option value="">Course Name</option>
                            <?php
                                    $rs = mysqli_query($conn,"SELECT * FROM `db_course` WHERE `owner` LIKE '".$_GET['code']."' ORDER BY `db_course`.`name` ASC");
                                    while($row=mysqli_fetch_assoc($rs)){
echo '<option>'.$row['name'].'</option>';
                                    }                            
                            
                            ?>
                            

                        </select>
            </div>
        </div>
        
        <?php
    }else{ 
?>            
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Project</label>
                    <div class="col-sm-9">
                        <input name="note" value="<?php echo $note;?>" id="event-title" type="text" class="form-control" placeholder="" required>
                    </div>
                </div>
<?php }?>


                <div class="form-group row row-sm">
                    <label class="col-sm-3 col-form-label">Date</label>
                    <div class="col-sm-9">
                        <div class='input-group input-daterange' data-plugin="datepicker" data-option="{todayBtn: 'linked',autoclose: true}">
                            <input type='text' class="form-control" name="from_date" value="<?php echo $from_date;?>" onchange="showCustomer(this.value,'<?php echo $_GET['code'];?>')" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">to</span>
                            </div>
                            <input type='text' class="form-control" name="to_date" value="<?php echo $to_date;?>" required>
                        </div>                        
                    </div>
                </div>
                <div class="form-group row row-sm">
                    <label class="col-sm-3 col-form-label">Time</label>
                    <div class="col-sm-9">

                    <div class="input-group input-daterange" id="txtHint">
                        <?php
                        $code = $_GET['code'];
                        $q = $today;
                        
                    $sql = "SELECT * FROM `db_reserve` WHERE `code` LIKE '".$code."' and start_date like '$q%' ORDER BY `db_reserve`.`start_date` ASC";
                    
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
                    </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <?php
                        
                            // if($id!=''&&$_SESSION['ses_ulevel']>7){
                                echo '<a href="action.php?mod=del&page=reserve&id='.$id.'" class="btn gd-danger text-white btn-rounded" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>';
                            // }

                        ?>                        
                    </div>
                    <div class="col-sm-9">
                        <input type="hidden" name="mod" value="<?php echo explode('-',$mod)[0];?>">
                        <?php
                        
                            if($id!=''){
                                echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
                            }else{
                                echo '<input type="hidden" name="code" value="'.$_GET['code'].'">';
                            }

                        ?>
                        
                        <button type="submit" id="btn-save" class="btn gd-primary text-white btn-rounded">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div></div>

    <script>
function showCustomer(str,code)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (this.readyState==4 && this.status==200)
    {
    document.getElementById("txtHint").innerHTML=this.responseText;
    }
  }
xmlhttp.open("GET","gettime.php?code="+code+"&q="+str,true);
xmlhttp.send();
}
</script>