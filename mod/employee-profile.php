<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];

    }else{
        $id = $_SESSION['ses_uid'];
    }

    $rs = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE id = $id");
    $row=mysqli_fetch_assoc($rs);

    $dome_note = $row['dome_note'];
    $parent = $row['parent'];

    $file = 'uploads/employee/'.$row['id'].'.jpg';
    if(file_exists($file)){
        $profile_img = $file;
    }else{
        $profile_img = '/assets/img/logo.png';
    }   

    if($row['name_en']!=''){
        $profile_name = $row['name_en'];
    }else{
        $profile_name = $row['name'];
    }

?>


<div class="card">
                                <div class="card-header bg-dark bg-img p-0 no-border" data-stellar-background-ratio="0.1" style="background-image:url(../assets/img/b3.jpg);" data-plugin="stellar">
                                    <div class="bg-dark-overlay r-2x no-r-b">
                                        <div class="d-md-flex">
                                            <div class="p-4">
                                                <div class="d-flex">
                                                    <a href="#">
                                                        <span class="avatar w-64">
                  <img src="<?php echo $profile_img;?>" alt=".">
                  <i class="on"></i>
                </span>
                                                    </a>
                                                    <div class="mx-3">
                                                        <h5 class="mt-2"><?php echo $row['name'];?></h5>
                                                        <div class="text-fade text-sm"><span class="m-r"><?php echo $row['position'];?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="flex"></span>
                                            <div class="align-items-center d-flex p-4">
                                                <div class="toolbar">
                                                    <a href="tel:<?php echo $row['tel'];?>" class="btn btn-sm btn-icon bg-dark-overlay btn-rounded">
                                                        <i data-feather="phone" width="12" height="12" class="text-fade"></i>
                                                    </a>
                                                    <!-- <a href="#" class="btn btn-sm btn-icon bg-dark-overlay btn-rounded">
                                                        <i data-feather="more-vertical" width="12" height="12" class="text-fade"></i>
                                                    </a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="d-flex">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item">
                                                <a class="nav-link<?php
                                                
                                                if($_GET['tab']=='evaluate'){
                                                    $te = ' active';
                                                    $te2 = ' show active';

                                                }else{
                                                    $tp = ' active';
                                                    $tp2 = ' show active';
                                                }

                                                echo $tp;
                                                
                                                ?>" href="#" data-toggle="tab" data-target="#tab_4">Profile</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link<?php echo $te;?>" href="#" data-toggle="tab" data-target="#evaluate">Evaluation</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_1">Timesheet</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_2">Activity</a>
                                            </li> -->
                                            <?php if($_SESSION['ses_ulevel']==9){?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_3">Equipment</a>
                                            </li>
                                            <?php }?>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade" id="tab_1">


                                            
                                            <div class="card" id="feed-11">
                                                <form method="POST" action="action.php">
                                                    <input type="hidden" name="mod" value="timesheet">
                                                    <div class="card-header d-flex">
                                                    <a href="#">
                                                        <img src="<?php echo $profile_img;?>" class="avatar w-40">
                                                    </a>
                                                    <div class="mx-3">
                                                        <?php echo $profile_name;?>
                                                        <div class="text-muted text-sm">
                                                            <input name="date" type='text' class="form-control mb-3" data-plugin="datepicker" value="<?php echo date("d/m/Y");?>" data-option="{daysOfWeekHighlighted: [0,6]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="p-3 b-t">

                                                        <div class="row row-sm">
                                                            <div class="col-5">
                                                                <input name="location" type="text" class="form-control" placeholder="Location" required>
                                                            </div>
                                                            <div class="col-5">
                                                                <select name="project" class="form-control" data-plugin="select2" data-option="{}" data-placeholder="Project" style="width:100% !important" required>
                                                                    <option></option>
                                                                    <optgroup label="Projects">
                                                                        <?php
                                                                        
                                                                        $rss = mysqli_query($conn,"SELECT * FROM `db_project` WHERE `status` = 2 ORDER BY `code` DESC");
                                                                        while($roww=mysqli_fetch_assoc($rss)){
                                                                            echo '<option value="pj-'.$roww['id'].'">TIME-'.$roww[code].' '.$roww['name'].'</option>';

                                                                        }
                                                                        
                                                                        ?>
                                                                    </optgroup>
                                                                    <optgroup label="Cost Center">
                                                                        <option value="BO">Business Operation</option>
                                                                        <option value="BD">Business Development</option>
                                                                        <option value="OT">อื่นๆ</option>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                            <div class="col-2">
                                                                <input name="hrs" type="number" step="0.01" class="form-control" placeholder="Hours" required>
                                                                <select class="form-control">
                                                                    <option value="">00</option>
                                                                    <option value="">15</option>
                                                                    <option value="">30</option>
                                                                    <option value="">45</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                </div>
                                                <div class="p-3 b-t collapse show" id="feed-form-1">
                                                        <textarea name="description" class="form-control" rows="3" placeholder="Task Description" required></textarea>
                                                        <div class="d-flex pt-2">
                                                            <div class="toolbar my-1">
                                                            </div>
                                                            <span class="flex"></span>
                                                            <button type="submit" class="btn btn-sm btn-primary">Post</button>
                                                        </div>
                                                </div>
                                            </form>
                                        </div>

                                            <div class="card" id="feed-1">
                                                <div class="card-header d-flex">
                                                    <a href="#">
                                                        <img src="<?php echo $profile_img;?>" class="avatar w-40">
                                                    </a>
                                                    <div class="mx-3">
                                                        <a href="#"><?php echo $profile_name;?></a>
                                                        <div class="text-muted text-sm">Wed, 25 Dec 2019</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="p-3 b-t">
                                                    <div class="toolbar toolbar-mx">
                                                        <a href="#" class="text-muted">
                                                            <i data-feather="navigation" width="12" height="12"></i>
                                                            TIME Office
                                                        </a>
                                                        <a href="#feed-form-1" class="text-muted" data-toggle="collapse">
                                                            <i data-feather="box" width="12" height="12"></i>
                                                            Project Name
                                                        </a>
                                                        <a href="#" class="text-muted">
                                                            <i data-feather="clock" width="12" height="12"></i>
                                                            8 Hrs
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                <div class="card-body b-t">
                                                    <div class="card-text mb-3">
                                                        <p>Arcu risus tortor sed erat odio faucibus amet, arcu, integer cursus enim quis vitae felis</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="tab_2">
                                            <div class="card p-4">
                                                <div class="timeline animates animates-fadeInUp">
                                                    <div class="tl-item  active">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">Added to
                                                                <a href='#'>@TUT</a> team</div>
                                                            <div class="tl-date text-muted mt-1">2 days ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">
                                                                <a href='#'>@Netflix</a> hackathon</div>
                                                            <div class="tl-date text-muted mt-1">25/12 18</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">Just saw this on the
                                                                <a href='#'>@eBay</a> dashboard, dude is an absolute unit.</div>
                                                            <div class="tl-date text-muted mt-1">1 Week ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">Prepare the documentation for the
                                                                <a href='#'>Fitness app</a>
                                                            </div>
                                                            <div class="tl-date text-muted mt-1">20 minutes ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">
                                                                <a href='#'>@NextUI</a> submit a ticket request</div>
                                                            <div class="tl-date text-muted mt-1">1 hour ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">Developers of
                                                                <a href='#'>@iAI</a>, the AI assistant based on Free Software</div>
                                                            <div class="tl-date text-muted mt-1">1 day ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">
                                                                <a href='#'>@WordPress</a> How To Get Started With WordPress</div>
                                                            <div class="tl-date text-muted mt-1">20 minutes ago</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">From design to dashboard,
                                                                <a href='#'>@Dash</a> builds custom hardware according to on-site requirements</div>
                                                            <div class="tl-date text-muted mt-1">21 July</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">Fun project from this weekend. Both computer replicas are fully functional</div>
                                                            <div class="tl-date text-muted mt-1">03/12 18</div>
                                                        </div>
                                                    </div>
                                                    <div class="tl-item  ">
                                                        <div class="tl-dot ">
                                                        </div>
                                                        <div class="tl-content">
                                                            <div class="">We help companies deliver reliable and beautiful
                                                                <a href='#'>@IOSapps</a>
                                                            </div>
                                                            <div class="tl-date text-muted mt-1">13/12 18</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_3">
                                            <div class="card p-4">
                                                <div class="list list-row row">
                                                    <div class="list-item col-sm-6 no-border" data-id="17">
                                                        <div>
                                                            <a href="#">
                                                                <span class="w-40 avatar gd-warning">
                                                                    D
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="#" class="item-author text-color ">Dell</a>
                                                            <a href="#" class="item-company text-muted h-1x">
                                                            TIME-C11
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="list-item col-sm-6 no-border" data-id="9">
                                                        <div>
                                                            <a href="#">
                                                                <span class="w-40 avatar gd-info">
                                                                    L
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="flex">
                                                            <a href="#" class="item-author text-color ">Lenovo</a>
                                                            <a href="#" class="item-company text-muted h-1x">
                                                                TIME-M11
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade<?php echo $tp2;?>" id="tab_4">
                                            <div class="card">
                                                <div class="px-4 py-4">
                                                    <?php 
                                                        if($_SESSION['ses_ulevel']>7){
                                                            echo '<div class="text-right"><a href="?mod=employee-edit&id='.$id.'"><i class="mx-2" data-feather="edit-2"></i></a></div>';                                                        
                                                        }
                                                    ?>

                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Name</small>
                                                            <div class="my-2"><?php echo $row['name_en'];?></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Nickname</small>
                                                            <div class="my-2"><?php echo $row['nick'];?></div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Cell Phone</small>
                                                            <div class="my-2"><?php echo $row['tel'];?></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">E-mail</small>
                                                            <div class="my-2"><?php echo $row['email'];?></div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Birthday</small>
                                                            <div class="my-2"><?php 
                                                            
                                                            $dob = explode('-',$row['dob']);
                                                            
                                                            $mo = [
                                                                '01' => 'Jan',
                                                                '02' => 'Feb',
                                                                '03' => 'Mar',
                                                                '04' => 'Apr',
                                                                '05' => 'May',
                                                                '06' => 'Jun',
                                                                '07' => 'Jul',
                                                                '08' => 'Aug',
                                                                '09' => 'Sep',
                                                                '10' => 'Oct',
                                                                '11' => 'Nov',
                                                                '12' => 'Dec',
                                                            ];

                                                            echo $dob[2].' '.$mo[$dob[1]];

                                                            if($_SESSION['ses_ulevel']>7){
                                                                $yo = date(Y)-$dob[0];
                                                                echo ' '.$dob[0].' ('.$yo.' years)';
                                                            }

                                                            ?></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Employee ID</small>
                                                            <div class="my-2">TIME<?php echo str_pad($row['code'], 3, '0', STR_PAD_LEFT);?></div>
                                                        </div>
                                                    </div>

                                                    <?php if($_SESSION['ses_uid']==$id||$_SESSION['ses_ulevel']>7){
                                                    // if($_SESSION['ses_ulevel']>6){?>
                                                    <form action="action.php" method="post" enctype="multipart/form-data">
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Start Date</small>
                                                            <div class="my-2"><?php echo $row['start_date'];?></div>
                                                        </div>
                                                        <?php if($_SESSION['ses_ulevel']>7||$id==$_SESSION['ses_uid']){?>
                                                            <div class="col-md-6">
                                                                <small class="text-muted">HQ Profile Photo</small>
                                                                <div class="custom-file">
                                                                    <input type="file" name="hq">                                                            
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Set New Password</small>
                                                            <div class="my-2">
                                                                <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Leave blank to use current password">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Emergency Telephone No.</small>
                                                            <div class="my-2">
                                                            <input type="text" name="emer_tel" class="form-control" value="<?php 
                                                            // if($row['emer_tel']!=''){
                                                                    echo $row['emer_tel'];
                                                                // }else{
                                                                //  echo '<small>Unknown</small>';   
                                                                // }?>"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Who</small>
                                                            <div class="my-2">
                                                            <input type="text" name="emer_who" class="form-control" value="<?php 
                                                            // if($row['emer_tel']!=''){
                                                                    echo $row['emer_who'];
                                                                // }else{
                                                                //  echo '<small>Unknown</small>';   
                                                                // }?>">
                                                                
                                                                 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Checkbox inline</label>
                                                <div class="col-sm-8">
                                                    <div class="mt-2">
                                                        
                                                    </div>
                                                </div>
                                            </div> -->
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Allergies</small>
                                                            <div class="my-2">
                                                               <?php
                                                               
                                                               $allergies = json_decode($row['allergies']);
                                                               
                                                               ?>
                                                            <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="allergies[]" id="inlineCheckbox4" value="0"<?php if(in_array('0',$allergies)){echo ' checked';}?>>
                                                            <label class="form-check-label" for="inlineCheckbox4">ไม่แพ้</label>
                                                        </div><div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="allergies[]" id="inlineCheckbox1" value="1"<?php if(in_array(1,$allergies)){echo ' checked';}?>>
                                                            <label class="form-check-label" for="inlineCheckbox1">แพ้กุ้ง</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="allergies[]" id="inlineCheckbox2" value="2"<?php if(in_array(2,$allergies)){echo ' checked';}?>>
                                                            <label class="form-check-label" for="inlineCheckbox2">แพ้ปู</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="allergies[]" id="inlineCheckbox3" value="3"<?php if(in_array(3,$allergies)){echo ' checked';}?>>
                                                            <label class="form-check-label" for="inlineCheckbox3">ไม่กินเนื้อ</label>
                                                        </div>
                                                                </div>
                                                        </div>


                                                        <!-- <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Text</label>
                                                <div class="col-sm-8">
                                                    
                                                </div>
                                            </div> -->



                                                        <div class="col-md-6">
                                                            <small class="text-muted">Other</small>
                                                            <div class="my-2">
                                                            <input type="text" name="allergy_other" class="form-control" placeholder="โปรดระบุ" value="<?php echo $row['allergy_other'];?>">
                                                                </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">LINE Token</small>
                                                            <div class="my-2">
                                                            <input type="text" name="line_token" class="form-control" value="<?php echo $row['line_token'];?>">
                                                            <small class="form-text text-muted"><a href="https://notify-bot.line.me/my/" target="_blank">Get Token</a></small>
                                                                </div>
                                                        </div>
                                                        <?php if($_SESSION['ses_ulevel']>7){?>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Mods</small>
                                                            <div class="my-2">
                                                               <?php
                                                               
                                                               $mods = json_decode($row['mods']);

                                                               $titles = [
                                                                'carrec' => 'Car Record',
                                                                'expense' => 'Expense',
                                                                'evaluate' => 'Evaluation',
                                                                'timeoff' => 'Time-off',
                                                                'wfa' => 'WFA',
                                                                'resign' => 'Resignation',
                                                                
                                                                'support-case' => 'Sup-Case Team',
                                                                'support-acc' => 'Sup-Accounting & Finance',
                                                                'support-hr' => 'Sup-HR',
                                                                'support-adm' => 'Sup-Admin',
                                                                'support-it' => 'Sup-IT',
                                                                'support-mkt' => 'Sup-Marketing',                                                        
                                                               ];

                                                               $i = 0;
                                                               foreach($titles as $k => $v){
                                                                   echo '<div class="form-check form-check-inline">
                                                                   <input class="form-check-input" type="checkbox" name="mods[]" id="mod'.$i.'" value="'.$k.'"';
                                                                   
                                                                   if(in_array($k,$mods)){echo ' checked';}
                                                                   
                                                                   echo '>
                                                                   <label class="form-check-label" for="mod'.$i.'">'.$v.'</label>
                                                               </div>';
                                                               $i++;
                                                               }
                                                               
                                                               ?>


                                                                </div>
                                                        </div>
                                                        <?php }?>
                                                    </div>

                                                    <input type="hidden" name="mod" value="profile">
                                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                                    <button type="submit" class="btn btn-primary">Save</button> 
                                                    </form>
                                                    <?php }?>
                                                    <?php 
                                                
                                                // }?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade<?php echo $te2;?>" id="evaluate">
                                        <?php

$rs = mysqli_query($conn,"SELECT * FROM `db_evaluate` WHERE `uid` = $id ORDER BY id DESC LIMIT 1");
if(mysqli_num_rows($rs)!=0){
    $row = mysqli_fetch_assoc($rs);
    $a1 = $row['a1'];
    $a2 = $row['a2'];
    $a3 = $row['a3'];
    $a4 = $row['a4'];
    $a5 = $row['a5'];
    $b = $row['b'];
    $b2 = $row['b2'];
    $c = $row['c'];
    $d = $row['d'];

    if($row['submitted_at']==null){
        // echo '<input type="hidden" name="id" value="'.$row['id'].'">';
    }else{
        $disabled = ' disabled';
    }
}

?>                                        
<?php if($disabled){?>
    <div class="alert alert-success" role="alert">
                                                <i data-feather="check"></i>
                                                <span class="mx-2">Evaluation submitted to p'Dome</span>
                                            </div>
<?php    }elseif(isset($_GET['alert'])){?>
                                            <div class="alert alert-success" role="alert">
                                                <i data-feather="check"></i>
                                                <span class="mx-2">Evaluation have been updated</span>
                                            </div>
<?php }?>
                                            <div class="card">
                                                
                                            <div class="px-4 py-4">
                                                    <div>
                                                    <h5 class="card-title">
                                                    H2/2019 Evaluation Form <a href="#" title="Help" data-toggle="modal" data-target="#modal">
                                        <i data-feather="help-circle"></i>
                                    </a><br>
                                                    แบบประเมินผลงานประจำ H2 ปี ค.ศ. 2019</h5>
                                                    <small>(แบบฟอร์มนี้ เมื่อ Save แล้ว สามารถแก้ไขหรือเขียนเพิ่มเติมภายหลังได้)</small>
                                                    <!-- Evaluation & Constructive Feedback Form -->
                                                    
                                                    <p><small>Agenda / Topic</small></p>
                                                <form method="post" action="action.php">
                                                    <p><strong>1. In this period, I have contributed, delivered and/or created value to:</strong><br>
                                                    ในช่วงครึ่งปีนี้ ฉันได้มีส่วนร่วมหรือสนับสนุน สร้างสรรค์ผลงาน และ/หรือสร้างคุณค่าให้แก่:

                                                    <!-- Contribution / Value Creation -->
                                                    </p>

                                                    <div class="form-group">
                                                        <label>1.1 Project Deliverable<br>
                                                        ผลงานในโครงการ (ทั้งตาม Scope และสิ่งที่ส่งมอบให้กับลูกค้านอกเหนือจาก Scope)
                                                        </label>
                                                        <textarea name="a1" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $a1;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>1.2 Work Environment, People & Project Team Development<br>
                                                        การพัฒนาสภาพแวดล้อมในการทำงาน เพื่อนร่วมงานในองค์กร และทีมงานในโครงการ</label>
                                                        <textarea name="a2" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $a2;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>1.3 Knowledge & Process Development<br>
                                                        การพัฒนาองค์ความรู้และ/หรือกระบวนงานในองค์กร
                                                         <!-- Sharing -->
                                                         </label>
                                                        <textarea name="a3" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $a3;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>1.4 Sales (Sale Opportunity, Sale Lead Proposal, Sale Close)<br>
                                                        การสร้างรายได้ (การสร้างสรรค์โอกาสในการขาย, การพัฒนาและจัดทำข้อเสนอ, การปิดการขาย)</label>
                                                        <textarea name="a4" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $a4;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>1.5 Client Satisfaction (do not meet, meet, exceed expectation) and Client Relationship<br>
                                                        ความพึงพอใจของลูกค้า (ต่ำกว่า, ตามที่, เกิน ความคาดหวัง) และความสัมพันธ์กับลูกค้า</label>
                                                        <textarea name="a5" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $a5;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label><strong>2. I have learned the following lessons in this period</strong><br>
                                                        
                                                        <!-- Lessons Learned from the experience in the last half -->
                                                        ในช่วงครึ่งปีที่ผ่านมา ฉันได้เรียนรู้บทเรียนต่างๆ ดังต่อไปนี้</label>
                                                        <!-- <textarea name="b" class="form-control" rows="20"><?php echo $b;?></textarea> -->
                                                    </div>
                                                    <div class="form-group">
                                                        <label>2.1 Positive or Value Added / Fulfilment<br>
                                                        บทเรียนที่ดีและสร้างคุณค่า/เติมเต็มให้แก่ฉัน
                                                        </label>
                                                        <textarea name="b" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $b;?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>2.2 Challenges and Ways or Recommendations to Overcome / Improve / Solve / Prevent<br>
                                                        ความท้าทายที่ฉันพบ และแนวทางหรือข้อเสนอแนะในการพัฒนา แก้ไข ป้องกัน
                                                        </label>
                                                        <textarea name="b2" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $b2;?></textarea>
                                                    </div>                                                                       
                                                    <div class="form-group">
                                                        <label><strong>3. I am seeing my future development with the company as: </strong><br>
                                                        1. Role & Responsibility*<br>
                                                        2. Industry or Competency Practice**<br>
                                                        3. Skills and Expertise Development<br>
ฉันมองเห็นการพัฒนาในอนาคตของตัวฉันกับบริษัทเป็นอย่างไรในด้าน:<br>
1. บทบาทหน้าที่*<br>
2. ความสนใจและความเชี่ยวชาญในอุตสาหกรรม/การปฏิบัติงาน**<br>
3. การพัฒนาทักษะและความเชี่ยวชาญ</label>
                                                        <textarea name="c" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $c;?></textarea>
                                                        <small class="form-text text-muted">
                                                        * Example: Team Leader (TL), Project Manager (PM), Work Stream/Work Plan Leader (WL), Project Owner (PO), Subject Matter Expert (SME), Project Supporter/Co-Ordinator (PS), Business Development (BD), Sale (S)<br>
                                                        ** Example: Telecom & Broadband / TV Media & Broadcasting / Digital Policy & Strategy / Digital Innovation & Transformation / อื่นๆ (โปรดระบุ)</small>
                                                    </div>

                                                    <div class="form-group">
                                                        <label><strong>4. To achive the future picture, I would need the following help/support/resource etc. (and how?)</strong><br>
                                                        เพื่อที่จะได้พัฒนาตัวฉันตามที่ได้ตั้งไว้ ฉันต้องการ ความช่วยเหลือ/การส่งเสริม/สนับสนุน/ทรัพยากรในด้าน: (และอย่างไร?)
                                                        </label>
                                                        <textarea name="d" class="form-control" rows="20"<?php echo $disabled;?>><?php echo $d;?></textarea>

                                                    </div>                                           
                                                    <?php if(empty($disabled)){?>         
                                                    <input type="hidden" name="mod" value="evaluate">
                                                    <input type="hidden" name="uid" value="<?php echo $id;?>">                                                    
                                                    <button type="submit" class="btn btn-secondary">Save</button> <button type="submit" name="submitted" value="1" class="btn btn-primary">Submit to p'Dome</button>                                                   
                                                    <small class="form-text text-muted">
                                                        สามารถ Save ไว้ก่อนได้ โดยข้อความจะยังไม่ส่งถึงพี่โดม ถ้ากรอกเสร็จและไม่ต้องการแก้ไขอะไรแล้ว ให้คลิกปุ่ม Submit to p'Dome เมื่อกดแล้วจะไม่สามารถแก้ไขได้อีก    
                                                    </small>
                                                    <?php }?>
                                                </form>
                                            </div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-lg-4">
                                <?php 
                                    $file_location = 'uploads/employee_hq/'.$id.'.jpg';
                                    if(file_exists($file_location)){
                                        echo '<img src="'.$file_location.'" class="img-fluid">';
                                    }
                                ?>                                
                                    <div class="card sticky" style="z-index: 1">
<?php if($parent>0){?>                                    
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>Team Lead</strong>

                                    

  <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
</div>

                                        <div class="list list-row">
<?php
    // $cl = [
    //     2020 => 'success',
    //     2019 => 'info',
    //     2018 => 'primary',
    // ];
    
    // $rs = mysqli_query($conn,"SELECT id,code,name FROM `db_project` WHERE `time1_ids` LIKE '%\"$id\"%' ORDER BY `db_project`.`code` DESC");
    $rs = mysqli_query($conn,"SELECT *  FROM `db_employee` WHERE `id` = $parent and end_date is null");
    while($row=mysqli_fetch_assoc($rs)){
        // $yr = substr($row['code'],0,4);
        // $no = substr($row['code'],4,2);
        $file = 'uploads/employee/'.$row['id'].'.jpg';
        if(file_exists($file)){
            $profile_img = $file;
        }else{
            $profile_img = '/assets/img/logo.png';
        }   
    
?>
                                            <div class="list-item " data-id="8">
                                                <div>
                                                    <a href="?mod=employee-profile&id=<?php echo $row['id'];?>">
                                                        <span class="w-40 avatar" style="margin: -2px;"><img src="<?php echo $profile_img;?>" alt="..."></span>
                                                    </a>
                                                </div>
                                                <div class="flex">
                                                    <a href="?mod=employee-profile&id=<?php echo $row['id'];?>" class="item-author text-color "><?php echo $row['name'];?></a>
                                                    <a href="?mod=employee-profile&id=<?php echo $row['id'];?>" class="item-company text-muted h-1x">
                                                        <?php echo $row['position'];?>
                                                    </a>
                                                </div>
                                            </div>
    <?php }?>
                                            <!-- <div class="list-item " data-id="7">
                                                <span class="text-muted">Past Projects</span>
                                            </div> -->
                                        </div>    
                                        <?php }?>    
<?php
    $rs = mysqli_query($conn,"SELECT *  FROM `db_employee` WHERE `parent` = $id and end_date is null");

    if(mysqli_num_rows($rs)>0){?>                                                                    
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                    <strong>Subordinates</strong>

</div>

                                        <div class="list list-row">
<?php
    // $cl = [
    //     2020 => 'success',
    //     2019 => 'info',
    //     2018 => 'primary',
    // ];
    
    // $rs = mysqli_query($conn,"SELECT id,code,name FROM `db_project` WHERE `time1_ids` LIKE '%\"$id\"%' ORDER BY `db_project`.`code` DESC");
    while($row=mysqli_fetch_assoc($rs)){
        // $yr = substr($row['code'],0,4);
        // $no = substr($row['code'],4,2);
        $file = 'uploads/employee/'.$row['id'].'.jpg';
        if(file_exists($file)){
            $profile_img = $file;
        }else{
            $profile_img = '/assets/img/logo.png';
        }   
    
?>
                                            <div class="list-item " data-id="8">
                                                <div>
                                                    <a href="?mod=employee-profile&id=<?php echo $row['id'];?>">
                                                        <span class="w-40 avatar" style="margin: -2px;"><img src="<?php echo $profile_img;?>" alt="..."></span>
                                                    </a>
                                                </div>
                                                <div class="flex">
                                                    <a href="?mod=employee-profile&id=<?php echo $row['id'];?>" class="item-author text-color "><?php echo $row['name'];?></a>
                                                    <a href="?mod=employee-profile&id=<?php echo $row['id'];?>" class="item-company text-muted h-1x">
                                                        <?php echo $row['position'];?>
                                                    </a>
                                                </div>
                                            </div>
    <?php }?>
                                            <!-- <div class="list-item " data-id="7">
                                                <span class="text-muted">Past Projects</span>
                                            </div> -->
                                        </div>
<?php }?>                                        
                                        <div class="card-header">
                                            <strong>Project Owner</strong>
                                        </div>
                                        <div class="list list-row">
<?php
    $cl = [
        2020 => 'success',
        2019 => 'info',
        2018 => 'primary',
    ];
    $rs = mysqli_query($conn,"SELECT id,code,name FROM `db_project` WHERE `time1_ids` LIKE '%\"$id\"%' ORDER BY `db_project`.`code` DESC");
    while($row=mysqli_fetch_assoc($rs)){
        $yr = substr($row['code'],0,4);
        $no = substr($row['code'],4,2);
?>
                                            <div class="list-item " data-id="8">
                                                <div>
                                                    <a href="?mod=project">
                                                        <span class="w-40 avatar gd-<?php echo $cl[$yr];?>">
                                                            <?php echo $no;?>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="flex">
                                                    <a href="?mod=project" class="item-author text-color "><?php echo $row['name'];?></a>
                                                    <a href="?mod=project" class="item-company text-muted h-1x">
                                                        TIME<?php echo $row['code'];?>
                                                    </a>
                                                </div>
                                            </div>
    <?php }?>
                                            <!-- <div class="list-item " data-id="7">
                                                <span class="text-muted">Past Projects</span>
                                            </div> -->
                                        </div>
                                        
<?php if($_SESSION['ses_uid']==12||$_SESSION['ses_uid']==1){?>
    <form method="post" action="action.php">
        <div class="card-header" style="margin-top: 1.5rem;">
            <strong>P'Dome Note</strong>
        </div>
        <div class="px-4 py-4">
            <div class="form-group">
                <textarea name="dome_note" class="form-control" rows="20"><?php echo $dome_note;?></textarea>
            </div>     
            <input type="hidden" name="mod" value="dome_note">
            <input type="hidden" name="id" value="<?php echo $id;?>">                                             
            <button type="submit" class="btn btn-secondary">Save</button>                                         
        </div>
    </form>
                                    
                                    
                                    </div>
<?php }?>
                                </div>
                            </div>