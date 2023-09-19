<?php 

$sessionf = [
    'session' => 'Session Number',
    'title' => 'Session Name',
    'detail' => 'Session Detail',
    'pix' => 'Cover Pix',
    'guideline' => 'Slide Guideline',
    'chartpool' => 'Chartpool',
    'material' => 'Workshop file + Instruction',
    'status' => 'Status',
];

if(in_array('ld',$edits)||$_SESSION['ses_ulevel']>8){

    if($id!=''){
        $id = $_GET['id'];
        $rs = mysqli_query($conn,"SELECT * FROM `db_elearning` WHERE `id` = $id ORDER BY `id` DESC");
        $row = mysqli_fetch_assoc($rs);
    
        $name = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);
        $v = htmlspecialchars($row['v']);
        $owner = htmlspecialchars($row['owner']);
        $cover = $row['cover'];

        // $rs = mysqli_query($conn,"SELECT * FROM `db_elearning_detail` WHERE `eid` = $id and status = 2 ORDER BY `db_elearning_detail`.`id` ASC");
        // while($row = mysqli_fetch_assoc($rs)){
        //     $details[] = $row['title'].'|'.$row['cost'];
        // }

        // if($month!=$row['month']){
        //     $rs = mysqli_query($conn,"UPDATE `db_elearning` SET `month` = '$month' WHERE `id` = $id;");
        // }

    }else{
        // $month = $_GET['month'];
                
        $sql = "SELECT code FROM `db_elearning` WHERE `month` = '$month' ORDER BY `code` DESC limit 1";
    
        $rs = mysqli_query($conn,$sql);
        $cnt = mysqli_num_rows($rs);
    
        if($cnt!=0){
            $row = mysqli_fetch_assoc($rs);        
            $new_no = explode('/',$row['code'])[1]+1;
            $code = 'PV'.explode('-',$month)[1].'/'.str_pad($new_no, 3, 0, STR_PAD_LEFT);
    
        }else{
            $code = 'PV'.explode('-',$month)[1].'/001';
        }
    }

    if($_GET['alert']=='created'){
        echo '
        <div class="alert alert-info" role="alert">
            <i data-feather="info"></i>
            <span class="mx-2">Success! Your cover letter number is <b>TIME2019/'.str_pad($row['code'], 5, 0, STR_PAD_LEFT).'</b> Please upload PDF file below.</span>
        </div>';
    }
?>
                            <div class="row">
                                <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <strong>ข้อมูลวิดีโอ</strong>
                                            </div>
                                            <div class="card-body">

                                            <form action="action.php" method="post" enctype="multipart/form-data">
<?php

foreach($sessionf as $k => $v){
    if($k=='detail'){
        echo '                                            <div class="form-row">
        <div class="form-group col-sm-12">
        <label>'.$v.'</label>
        <textarea name="'.$k.'" class="form-control" rows="7" placeholder="">'.$description.'</textarea>
</div></div>
';

    }else{
        echo '    <div class="form-row">
        <div class="form-group col-sm-6">
        <label>'.$v.'</label>
                                                            <input type="text" class="form-control" name="'.$k.'" value="'.$k.'" required>
    
    </div></div>
';
    }
}

?>                                                

<div class="form-row pt-2">
<div class="col-6">
<!-- <a href="action.php?mod=del&page=elearning&id=<?php echo $id;?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a> -->
</div>
                                                <div class="col-6 text-right">

                                                    <input type="hidden" name="mod" value="elearning">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button>

                                                </div>
                                                </div>

                                    </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
<?php }?>