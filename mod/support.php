<?php 
    $rss = mysqli_query($conn,"SELECT id,code,name FROM `db_project`");
    while($roww=mysqli_fetch_assoc($rss)){
        $project[$roww['id']] = 'TIME-'.$roww['code'].' '.$roww['name'];
    }

if(in_array('support',$edits)||$_SESSION['ses_ulevel']>7){?>
<div class="text-right mb-2">
    <a href="?mod=support">TABLE</a> | <a href="?mod=support&page=summary">SUMMARY</a><br><br>

    <div class="mb-3">    
        <div class="dropdown mb-2">
            <button class="btn btn-white dropdown-toggle" data-toggle="dropdown"><i class="mx-2" data-feather="download"></i>Download CSV</button>
            <div class="dropdown-menu bg-dark" role="menu">
            <?php

    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }else{
        $year = date(Y);
    }
            
            if($year==2020){
                $start = 6;
                $end = 12;

            }elseif($year==date(Y)){
                $start = 1;
                $end = date(m);
            }else{
                $start = 1;
                $end = 12;
            }

            $mo = ['','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

            for($i=$start;$i<=$end;$i++){                
                echo '<a href="exportData.php?page='.$mod.'&month='.$year.'-'.str_pad($i,2,0,STR_PAD_LEFT).'" target="_blank" class="dropdown-item">
                '.$mo[$i].' '.$year.'
            </a>';
            }
            
            ?>
            </div>
        </div>
    </div>
</div>

<?php }?>

<?php if(isset($_GET['page'])&&$_GET['page']=='summary'){?>
    <div class="text-center">
        <?php
        
        for($i=date(Y);$i>=2020;$i--){
            $yrs[] = '<a href="?mod='.$mod.'&page='.$page.'&type='.$type.'&year='.$i.'">'.$i.'</a>';
        }

        echo implode(' | ',$yrs);
        
        ?>
    </div>

    <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%" data-plugin="dataTable">
<thead>
<tr class="text-center">
<th><?php echo $year;?></th>
<?php foreach($tmo as $k => $v){echo '<th>'.$v.'</th>';}?>
<th>Total</th>
</tr> </thead> <tbody>

<?php
    $rs = mysqli_query($conn,"SELECT id,nick FROM `db_employee`");
    while($row=mysqli_fetch_assoc($rs)){
        $time1[$row['id']]  = $row['nick'];
    }

    $rs = mysqli_query($conn,"SELECT uid,to_uid,output,end_date FROM `db_support` WHERE `status` = 4 AND end_date LIKE '$year-%'");
    while($row=mysqli_fetch_assoc($rs)){
        $supports[$row['to_uid']][substr($row['end_date'],0,7)][] = $row['output'].' - '.$time1[$row['uid']];
    }

    foreach($supports as $k => $v){
        $total = 0;
    ?>
<tr class="text-right">
    <td class="text-left">
        <?php echo $time1[$k];?>
    </td>
    <?php for($i=1;$i<=12;$i++){
        $mo = $year.'-'.str_pad($i, 2, 0, STR_PAD_LEFT);
        
        ?>
    <td><?php

    if($supports[$k][$mo]!=''){
        $cnt = count($supports[$k][$mo]);
        echo '<a href="#" title="- '.implode("\r\n- ",$supports[$k][$mo]).'">'.number_format($cnt).'</a>';           

        // echo number_format($dt[$mo][$row['proj_no']],2);        
        $total = $cnt+$total;
        $ttl_mo[$mo] = $cnt+$ttl_mo[$mo];
    }

    ?></td>
    <?php }?>
    <td>
        <?php echo number_format($total);?>
    </td>
</tr>
<?php }?>
<tfoot style="font-weight:bold;">
    <tr class="text-right">
        <td>Total</td>
        <?php 
                $total = 0;

        for($i=1;$i<=12;$i++){
            $mo = $year.'-'.str_pad($i, 2, 0, STR_PAD_LEFT);
            
            ?>
        <td><?php


        if(isset($ttl_mo[$mo])){
            echo number_format($ttl_mo[$mo]);        
            $total = $ttl_mo[$mo]+$total;
        }

        ?></td>
        <?php }?>
        <td>
            <?php echo number_format($total);?>
        </td>
    </tr>
  </tfoot>
</table>

<?php }else{?>
<div class="text-right mb-3">
    <?php
        foreach($sp_stts as $k => $v){
            $pjmns[] = '<a href="?mod=support&status='.$k.'">'.$v.'</a>';
        }

        echo implode(' | ',$pjmns);
    ?>
</div>

<?php
$colors = [
    1 => 'warning',
    2 => 'danger',
    3 => 'primary',
    4 => 'success',
];
    $rss = mysqli_query($conn,"SELECT `id`, `nick` FROM `db_employee`");
    while($roww=mysqli_fetch_assoc($rss)){
        $time1[$roww['id']] = $roww['nick'];
    }

    if($_GET['alert']=='safedrive'){
        echo '<div class="alert alert-success" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">บันทึกเรียบร้อย ตอนคืนอย่าลืม Scan คืนด้วยจ้า</span>
    </div>';

    }elseif($_GET['alert']=='welcomeback'){
        echo '<div class="alert alert-success" role="check">
        <i data-feather="info"></i>
        <span class="mx-2">บันทึกเรียบร้อย Welcome back!</span>
    </div>';

    }


?>



                            <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Output / From / To / Project / Remark</span></th>
                                            <th><span class="text-muted">Status</span></th>
                                            <th><span class="text-muted">Request Date</span></th>
                                            <th><span class="text-muted"><?php
                                            
                                            if($_GET['status']==4){
                                                echo 'Finished';
                                            }else{
                                                echo 'Accept';
                                            }
                                            
                                            ?> Date</span></th>
                                            <th><span class="text-muted">Due Date</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            // $rs = mysqli_query($conn,"SELECT * FROM `db_carrec` ORDER BY `id` DESC");
                                            while($row=mysqli_fetch_assoc($rs)){       
                                                
                                                $dg = explode(' ',$row['date_go']);
                                                if($row['date_back']!=null){
                                                    $db = explode(' ',$row['date_back']);
                                                    $time = substr($dg[1],0,5).' - '.substr($db[1],0,5);
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
                                                        <a href="?mod=support-edit&id='.$row['id'].'">'.$row['output'].'</a><br>
                                                        <small class="text-muted">
                                                            '.$time1[$row['uid']].'
                                                            <i data-feather="arrow-right"></i>
                                                            '.$row['code'].'
                                                            <i data-feather="arrow-right"></i>
                                                            '.$time1[$row['to_uid']].'
                                                        </small><br>';

                                                        if($row['project_id']!=0){
                                                            echo '<span class="badge badge-warning text-uppercase">'.$project[$row['project_id']].'</span><br>';
                                                        }

                                                        echo $row['note'].'</td><td>

                                                        <span class="badge badge-'.$colors[$row['status']].' text-uppercase">
                                                        '.$sp_stts[$row['status']].'
            </span>
                                                        
                                                        </td><td>'.substr($row['created_at'],0,16).'</td><td>';
                                                        
                                                        if($_GET['status']==4){
                                                            echo substr($row['finished_at'],0,16);
                                                        }else{
                                                            echo substr($row['accepted_at'],0,16);
                                                        }
                                                        
                                                        
                                                        echo '</td><td>'.$row['end_date'].'</td>
                                                    </tr>';
                                            }
                                        ?>                                        
                                        


                                        
                                    </tbody>
                                </table>
                            </div>
<?php }?>