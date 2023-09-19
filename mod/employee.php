<?php if($page=='summary'){?>
    <?php foreach($years as $yr => $lists){?>
    <?php
        $pc = number_format(count($lists)/$cnt*100);
        $yo = date(Y)-$yr;
        echo $yo.' = total: '.count($lists).' ('.$pc.'%)';
        foreach($lists as $v){
            echo ' '.$v;
        }        
    ?>
    <div class="progress mx-2 flex" style="height:4px;">
        <div class="progress-bar gd-success" style="width: <?php echo $pc;?>%"></div>
    </div>
<?php }?>


<?php }else{?>

<div class="row" style="margin-bottom: 30px;">
    <div class="col-md-6">
        <!-- The text field -->
        <input type="text" value="<?php echo implode(',',$emails);?>" id="myInput">

        <!-- The button used to copy the text -->
        <button onclick="myFunction()" class="btn btn-primary">Copy All E-mail</button>

        <br><br>
        <b>Job Description</b><br>
        - <a href="uploads/employee/Case Team Assistant Position Summary.pdf" target="_blank">Case Team Assistant</a><br>
        - <a href="uploads/employee/BD Roles & Responsibilities.pdf" target="_blank">Business Development (BD)</a><br>
        - <a href="uploads/employee/BO_Job Responsibilities_280520.pdf" target="_blank">Business Operation (BO)</a><br>
        
    </div>
    <?php if($_SESSION['ses_ulevel']>7){?>
    <div class="col-md-6">    
        <?php 
        $sum = 0;
        foreach($years as $yr => $lists){?>
        <?php
            $pc = number_format(count($lists)/$cnt*100);
            $yo = date('Y')-$yr;
            echo $yo.' = total: '.count($lists).' ('.$pc.'%)';
            foreach($lists as $v){
                echo ' '.$v;
                $sum = $sum + $yo;
            }        
        ?>
        <div class="progress mx-2 flex" style="height:4px;">
            <div class="progress-bar gd-success" style="width: <?php echo $pc;?>%"></div>
        </div>
        <?php }?>
        <div class="mt-1">ค่าเฉลี่ยอายุ <span class="badge badge-success text-uppercase" style="font-size:1em;">
        <?php echo number_format($sum/$cnt,2);?> ปี
            </span></div>
    </div>
    <?php }?>
</div>

<?php

$rss = mysqli_query($conn,"SELECT * FROM `db_timesheet` WHERE `month` = '2020-10' AND `status` = 2 ORDER BY `id` ASC");
while($roww=mysqli_fetch_assoc($rss)){
    $ts2[] = $roww['uid'];
}
$rss = mysqli_query($conn,"SELECT * FROM `db_timesheet` WHERE `month` = '2020-11' AND `status` = 2 ORDER BY `id` ASC");
while($roww=mysqli_fetch_assoc($rss)){
    $ts1[] = $roww['uid'];
}

$rss = mysqli_query($conn,"SELECT DISTINCT `uid` FROM `db_culture_answer`");
while($roww=mysqli_fetch_assoc($rss)){
    $cts[] = $roww['uid'];
}

?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>                                            
                                            <th><span class="text-muted">รูป</span></th>
                                            <th><span class="text-muted">ชื่อ / ตำแหน่ง</span></th>
                                            <th><span class="text-muted">Tel</span></th>
                                            <th><span class="text-muted">Timesheet</span></th>
                                            <th><span class="text-muted">Culture</span></th>
                                            <th><span class="text-muted d-none d-sm-block">E-mail</span></th>
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody><?php
    // $rs = mysqli_query($conn,"SELECT * FROM `db_time1` ORDER BY code DESC");
    // <a href="?mod='.$md.'-edit&id='.$row['id'].'" class="item-title text-color ">
    while($row=mysqli_fetch_assoc($rs)){
                                                echo '<tr class=" " data-id="'.$row['id'].'">
                                                        <td style="text-align:center">
                                                            <small class="text-muted">TIME'.str_pad($row['code'], 3, '0', STR_PAD_LEFT).'</small>
                                                        </td>
                                                        <td>
                                                            <div class="avatar-group ">
                                                                <a href="#" class="avatar ajax w-32" data-toggle="tooltip" title="'.$row['nick'].'">
                                                                    <img src="';
                                                                    $file = 'uploads/employee/'.$row['id'].'.jpg';
                                                                    if(file_exists($file)){
                                                                        echo $file;
                                                                    }else{
                                                                        echo '/assets/img/logo.png';
                                                                    }
                                                                    echo '" alt=".">
                                                                </a>
                                                            </div>                                                        
                                                        </td>
                                                        <td class="flex">';
                                                        // if($_SESSION['ses_uid']==12){
                                                            echo '<a href="?mod=employee-profile&id='.$row['id'].'">'.$row['name'].' ('.$row['nick'].')</a>';
                                                        // }else{
                                                        //     echo $row['name'].' ('.$row['nick'].')';
                                                        // }
                                                            echo '<div class="item-except text-muted text-sm h-1x">
                                                            '.$row['position'].'
                                                            </div>
                                                        </td>
                                                        <td>
                                                        '.$row['tel'].'
                                                        </td><td>';

if(in_array($row['id'],$ts1)){
    echo '<span class="item-badge badge text-uppercase  bg-success  ">DEC</span> ';
}                                                        
if(in_array($row['id'],$ts2)){
    echo '<span class="item-badge badge text-uppercase  bg-success  ">NOV</span> ';
}                                                        


                                                        echo '</td><td>';

if(in_array($row['id'],$cts)){
    // echo '<a href="?mod=culture&id='.$row['id'].'" class="item-badge badge text-uppercase  bg-success  ">Q2</a> ';
    echo '<span class="item-badge badge text-uppercase  bg-success  ">Q2</span> ';

}

                                                        echo '</td>';
                                                        // echo '<td>
                                                        // ';

                                                        // if($row['evaluated_at']!=null){
                                                        //     $ed = str_replace('-','',$row['evaluated_at']);
                                                        //     $ed = str_replace(' ','',$ed);
                                                        //     $ed = str_replace(':','',$ed);
                                                        //     $ed = substr($ed,5,7);

                                                        //     if($_SESSION['ses_uid']==2||$_SESSION['ses_uid']==12){
                                                        //         echo '<a href="?mod=employee-profile&tab=evaluate&id='.$row['id'].'"><span class="item-badge badge text-uppercase  bg-success  ">
                                                        //         Sent '.$ed.'
                                                        //     </span></a>';
                                                        //     }else{
                                                        //         echo '<span class="item-badge badge text-uppercase  bg-success  ">
                                                        //         Sent '.$ed.'
                                                        //     </span>';
                                                        //     }

                                                        // }else{
                                                        //     echo '<span class="item-badge badge text-uppercase    bg-secondary">
                                                        //     Unsend
                                                        // </span>';
                                                        // }
                                                        
                                                        // echo '
                                                        // </td>';
                                                        echo '<td>
                                                            <span class="item-amount d-none d-sm-block text-sm [object Object]">
                                                            '.$row['email'].'
                                </span>
                                                        </td>

                                                    </tr>';
                                                //     <td>
                                                //     <div class="item-action dropdown">
                                                //         <a href="#" data-toggle="dropdown" class="text-muted">
                                                //             <i data-feather="more-vertical"></i>
                                                //         </a>
                                                //         <div class="dropdown-menu dropdown-menu-right bg-black" role="menu">
                                                //             <a class="dropdown-item" href="#">
                                                //                 See detail
                                                //             </a>';

                                                            


                                                //             echo '<a class="dropdown-item edit" href="?mod='.$md.'-edit&id='.$row['id'].'">
                                                //                 Edit
                                                //             </a>
                                                //             <div class="dropdown-divider"></div>
                                                //             <a class="dropdown-item trash">
                                                //                 Delete item
                                                //             </a>
                                                //         </div>
                                                //     </div>
                                                // </td>
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>
<?php }?>