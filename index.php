<?php
session_start(); // ใช้งาน session

include 'global.php';
conndb();

    if(isset($_GET['mod'])){
        $mod = $_GET['mod'];
    }else{
        $mod = 'announce';
    }   
    
    if(explode('@',$_SESSION['ses_user_email'])[1]!='timeconsulting.co.th'&&$_SESSION['ses_user_email']!='jommnaja@gmail.com'){
        // if(isset($_SESSION['ses_user_email'])&&$_SESSION['ses_user_email']!=''&&explode('@',$_SESSION['ses_user_email'])[1]!='timeconsulting.co.th'){
            include 'mod/login2.php';

    }else{
        if($_SESSION['ses_ulevel']>8){
            $area = 'all';
    
        }else{
            $rs = mysqli_query($conn,"SELECT edits FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
            $row = mysqli_fetch_assoc($rs);
    
            $edits = json_decode($row['edits']);
    
        }

        $page_title = [
            'home' => 'Dashboard',
            'project' => 'Projects',
            'cover' => 'Cover Letter',

            'employee' => 'Team',
            'timesheet' => 'TIMESheet',  
            'timesheet2' => 'Online TIMESheet',  
            'timeoff' => 'TIME-off',

            'carrec' => 'Car Record',
            'meetingroom' => 'Meeting Room',
            'announce' => 'Announcement',
            'consultant' => 'Consultant',
            'customer' => 'Stakeholder',
            'howto' => 'How to',    
            'evaluate' => 'Evaluation & Constructive Feedback Form',                        
            'expense' => 'Payment Voucher',                        
            'internalvdo' => 'E-learning',  
            'km' => 'Knowledge Center',  
            'asset' => 'Asset Record',  
            'reserve' => 'Reservation',  
            'culture' => 'Consulting Culture',
            // 'support' => 'Support Request',
            'course' => 'Online Courses',
            'elearn' => 'E-Learning',
            'elearning' => 'E-Learning',
            // 'wfa' => 'Work From Anywhere',
            'equipment' => 'Equipment',
            'recruit' => 'Recruitment',
            'resign' => 'Resignation',
            'training' => 'Training Course',
            'ld' => 'L&D program self-learning system',
        ];

        $active = ' class="active"';
        $md = explode('-',$mod)[0];

        $msi = $mrc = '';

        if($md=='home'){
            $mh = $active;
            
        }elseif($md=='project'){
            $mp = $active;
            
            $proj_stts = [
                '2' => 'Working',
                '3' => 'Delivered',
                '4' => 'Finished',
                '1' => 'Lost',
            ];

        }elseif($md=='cover'){
            $mc = $active;
            $mrc = $active;

        }elseif($md=='employee'){
            $me = $active;
            $mep = $active;

        }elseif($md=='recruit'||$md=='resign'||$md=='training'){
            // $me = $active;
            $mpe = $active;

        }elseif($md=='timeoff'){
            $mt = $active;
            $mrc = $active;

        }elseif($md=='support'){
            $msp = $active;
            $mrc = $active;

            $sp_stts = [
                2 => 'Pending',
                3 => 'Working',
                4 => 'Finished',
                1 => 'Canceled',
            ];

        }elseif($md=='carrec'){
            $mr = $active;
            $mrc = $active;

        }elseif($md=='meetingroom'){
            $mtr = $active;
            $mrc = $active;

        }elseif($md=='asset'){
            $mas = $active;
            $mrc = $active;


        }elseif($md=='announce'){
            $ma = $active;

        }elseif($md=='consultant'){
            $ms = $active;
            $msi = $active;

        }elseif($md=='customer'){
            $mm = $active;

        }elseif($md=='timesheet'){
            $mts = $active;
            $mep = $active;

        }elseif($md=='howto'){
            $mht = $active;

        }elseif($md=='expense'){
            $mxp = $active;

        }elseif($md=='culture'){
            $mct = $active;

        }elseif($md=='course'){
            $mco = $active;
        }

        // $u = explode($_COOKIE['jomm']);
        // $uid = $u[0];
        // $unick = $u[1];

        $today = date("Y-m-d");

        // $rs = mysql_query($conn,"SELECT level FROM `db_time1` WHERE `id` = $uid AND (`end_date` IS NULL OR `end_date` >= '$today')");
        // $cnt = mysqli_num_rows($rs);

        // if($cnt==0){
        //     include 'mod/login.php';

        // }else{
            ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="20397358781-90us03atq3cf8g6i89kfbn19kcsc7u32.apps.googleusercontent.com">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
        <script src="https://apis.google.com/js/platform.js" async defer></script>

        <title><?php echo $page_title[$md];?> - TIME Consulting</title>
        <meta name="description" content="ระบบฐานข้อมูลกลาง TIME Consulting" />

        <!-- <meta property="og:image" content="https://bo.timeconsulting.co.th/assets/img/logo.png"> -->

        <link rel="apple-touch-icon" sizes="57x57" href="/assets/icon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/assets/icon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/icon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/icon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/icon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/assets/icon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/assets/icon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/assets/icon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/icon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/assets/icon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/assets/icon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/icon/favicon-16x16.png">
        <link rel="manifest" href="/assets/icon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/assets/icon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "0b8d0e8c-0ea0-4ddc-bf63-35cf938558b2",
            });
        });
        </script>        

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!-- style -->
        <!-- build:css assets/css/site.min.css -->
        <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="assets/css/theme.css" type="text/css" />
        <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
        <!-- endbuild -->    

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap" rel="stylesheet">
    </head>
    <body class="layout-row">
        <!-- ############ Aside START-->
        <div id="aside" class="page-sidenav no-shrink bg-light nav-dropdown fade" aria-hidden="true">
            <div class="sidenav h-100 modal-dialog bg-light">
                <!-- sidenav top -->
                <div class="navbar">
                    <!-- brand -->
                    <a href="." class="navbar-brand " target="_top">
                        <img src="assets/img/logo.png" alt="...">
                    </a>
                    <!-- / brand -->
                </div>
                <!-- Flex nav content -->
                <div class="flex scrollable hover">
                    <div class="nav-active-text-primary" data-nav>
                        <ul class="nav bg">
                            <li<?php echo $mrc;?>>
                                <a href="#" class="">
                                    <span class="nav-icon"><i data-feather='clipboard'></i></span>
                                    <span class="nav-text">Admin</span>
                                    <span class="nav-caret"></span>
                                </a>
                                <ul class="nav-sub nav-mega">
                                <li<?php if(isset($mr)){echo $mr;}?>>
                                        <a href="?mod=carrec">
                                            <span class="nav-icon text-secondary"><i data-feather='truck'></i></span>
                                            <span class="nav-text"><?php echo $page_title['carrec'];?></span>
                                        </a>
                                    </li>     
                                    <li<?php if(isset($mtr)){echo $mtr;}?>>
                                        <a href="?mod=meetingroom">
                                            <span class="nav-icon text-secondary"><i data-feather='airplay'></i></span>
                                            <span class="nav-text"><?php echo $page_title['meetingroom'];?></span>
                                        </a>
                                    </li>     
                                    <li<?php if(isset($mas)){echo $mas;}?>>
                                        <a href="?mod=asset">
                                            <span class="nav-icon text-secondary"><i data-feather='clipboard'></i></span>
                                            <span class="nav-text"><?php echo $page_title['asset'];?></span>
                                        </a>
                                    </li>
                                    <?php if(isset($_SESSION['ses_ulevel'])&&$_SESSION['ses_ulevel']>7){?>     
                                    <li>
                                        <a href="?mod=equipment">
                                            <span class="nav-icon text-secondary"><i data-feather='monitor'></i></span>
                                            <span class="nav-text"><?php echo $page_title['equipment'];?></span>
                                        </a>
                                    </li>
<?php }?>
                                    <li<?php if(isset($mc)){echo $mc;}?>>
                                        <a href="?mod=cover">
                                            <span class="nav-icon text-success"><i data-feather='file-text'></i></span>
                                            <span class="nav-text"><?php echo $page_title['cover'];?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li<?php echo $mep;?>>
                                <a href="#" class="">
                                    <span class="nav-icon"><i data-feather='users'></i></span>
                                    <span class="nav-text">TIMER</span>
                                    <span class="nav-caret"></span>
                                </a>
                                <ul class="nav-sub nav-mega">
                                    <li<?php if(isset($me)){echo $me;}?>>
                                        <a href="?mod=employee">
                                            <span class="nav-icon text-danger"><i data-feather='user'></i></span>
                                            <span class="nav-text"><?php echo $page_title['employee'];?></span>
                                        </a>
                                    </li>
                                    <li<?php if(isset($mts)){echo $mts;}?>>
                                        <a href="?mod=timesheet2">
                                            <span class="nav-icon text-danger"><i data-feather='clock'></i></span>
                                            <span class="nav-text"><?php echo $page_title['timesheet2'];?></span>
                                        </a>
                                    </li>
                                    <li<?php if(isset($mt)){echo $mt;}?>>
                                        <a href="?mod=timeoff">
                                            <span class="nav-icon text-danger"><i data-feather='battery-charging'></i></span>
                                            <span class="nav-text"><?php echo $page_title['timeoff'];?></span>
                                        </a>
                                    </li>
                                    <!-- <li>
                                        <a href="?mod=wfa">
                                            <span class="nav-icon text-danger"><i data-feather='wifi'></i></span>
                                            <span class="nav-text"><?php echo $page_title['wfa'];?></span>
                                        </a>
                                    </li> -->
                                </ul>
                            </li>
                            <li<?php echo $msi;?>>
                                <a href="#" class="">
                                    <span class="nav-icon"><i data-feather='check-circle'></i></span>
                                    <span class="nav-text">Learning & Development</span>
                                    <span class="nav-caret"></span>
                                </a>
                                <ul class="nav-sub nav-mega">
                                    <!-- <li<?php if(isset($mct)){echo $mct;}?>>
                                        <a href="?mod=culture"">
                                            <span class="nav-icon text-danger"><i data-feather='check-circle'></i></span>
                                            <span class="nav-text"><?php echo $page_title['culture'];?></span>
                                        </a>
                                    </li> -->
                                    <li<?php if(isset($mco)){echo $mco;}?>>
                                        <a href="?mod=course">
                                            <span class="nav-icon text-danger"><i data-feather='book-open'></i></span>
                                            <span class="nav-text"><?php echo $page_title['course'];?></span>
                                        </a>
                                    </li>
                                    <li<?php if(isset($mt)){echo $mt;}?>>
                                    <!-- <a href="https://www.youtube.com/playlist?list=PLDR1Q6rErapR94BXPDF4TVZR6kICxNDhS" target="_blank"> -->
                                    <a href="?mod=elearning">
                                            <span class="nav-icon text-danger"><i data-feather='video'></i></span>
                                            <span class="nav-text"><?php echo $page_title['internalvdo'];?></span>
                                        </a>
                                    </li>
                                    <li<?php if(isset($mt)){echo $mt;}?>>
                                    <a href="?mod=ld">
                                            <span class="nav-icon text-danger"><i data-feather='video'></i></span>
                                            <span class="nav-text"><?php echo $page_title['ld'];?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li<?php if(isset($msp)){echo $msp;}?>>
                                <a href="?mod=support">
                                    <span class="nav-icon text-danger"><i data-feather='thumbs-up'></i></span>
                                    <span class="nav-text"><?php echo $page_title['support'];?></span>
                                </a>
                            </li> -->
                            <li<?php if(isset($ma)){echo $ma;}?>>
                                <a href="?mod=announce">
                                    <span class="nav-icon text-danger"><i data-feather='volume-2'></i></span>
                                    <span class="nav-text"><?php echo $page_title['announce'];?></span>
                                </a>
                            </li>
                            <li<?php if(isset($mht)){echo $mht;}?>>
                                <a href="?mod=howto">
                                    <span class="nav-icon text-danger"><i data-feather='help-circle'></i></span>
                                    <span class="nav-text"><?php echo $page_title['howto'];?></span>
                                </a>
                            </li>   

                            <?php if($area=='all'||in_array('recruit',$edits)||in_array('project',$edits)||in_array('resign',$edits)){?>                       
                                <li class="nav-header hidden-folded">
                                    <span class="text-muted">Admin Only</span>
                                </li>
                            <?php }?>

                            <?php if($area=='all'||in_array('recruit',$edits)){?>
                                <li<?php if(isset($me)){echo $me;}?>>
                                    <a href="?mod=recruit">
                                        <span class="nav-icon text-danger"><i data-feather='log-in'></i></span>
                                        <span class="nav-text"><?php echo $page_title['recruit'];?></span>
                                    </a>
                                </li>
                            <?php }?>

                            <?php //if($area=='all'||in_array('project',$edits)){?>
                                <li<?php if(isset($mp)){echo $mp;}?>>
                                    <a href="?mod=project">
                                        <span class="nav-icon text-info"><i data-feather='box'></i></span>
                                        <span class="nav-text"><?php echo $page_title['project'];?></span>
                                    </a>
                                </li>
                            <?php //}?>

                            <?php if($area=='all'||in_array('resign',$edits)){?>
                                <li<?php if(isset($mts)){echo $mts;}?>>
                                    <a href="?mod=resign">
                                        <span class="nav-icon text-danger"><i data-feather='log-out'></i></span>
                                        <span class="nav-text"><?php echo $page_title['resign'];?></span>
                                    </a>
                                </li>
                            <?php }?>

                            <?php if($area=='all'||in_array('training',$edits)){?>
                                <li<?php if(isset($mt)){echo $mt;}?>>
                                    <a href="?mod=training">
                                        <span class="nav-icon text-danger"><i data-feather='coffee'></i></span>
                                        <span class="nav-text"><?php echo $page_title['training'];?></span>
                                    </a>
                                </li>
                            <?php }?>

                            <?php if($_SESSION['ses_level']>8||in_array('timesheet',$edits)){
                                echo '                                    <li';
                                if(isset($mts)){echo $mts;}
                                echo '>
                                <a href="?mod=timesheet">
                                    <span class="nav-icon text-danger"><i data-feather=\'clock\'></i></span>
                                    <span class="nav-text">'.$page_title['timesheet'].'</span>
                                </a>
                            </li>
                            ';
                            }?>


                            <!-- <li<?php if(isset($mxp)){echo $mxp;}?>>
                                <a href="?mod=expense">
                                    <span class="nav-icon text-danger"><i data-feather='dollar-sign'></i></span>
                                    <span class="nav-text"><?php echo $page_title['expense'];?></span>
                                </a>
                            </li> -->
                            <!-- <li<?php if(isset($mm)){echo $mm;}?>>
                                <a href="?mod=customer">
                                    <span class="nav-icon text-danger"><i data-feather='target'></i></span>
                                    <span class="nav-text"><?php echo $page_title['customer'];?></span>
                                </a>
                            </li> -->

                            <!-- <li class="nav-header hidden-folded">
                                <span class="text-muted">Developing</span> -->
                            <!-- </li>
                            <li<?php if(isset($mh)){echo $mh;}?>>
                                <a href="?mod=home">
                                    <span class="nav-icon text-primary"><i data-feather='home'></i></span>
                                    <span class="nav-text"><?php echo $page_title['home'];?></span>
                                </a>
                            </li> -->
                            <!-- <li<?php if(isset($ma)){echo $ma;}?>>
                                <a href="?mod=announce">
                                    <span class="nav-icon text-danger"><i data-feather='volume-2'></i></span>
                                    <span class="nav-text"><?php echo $page_title['announce'];?></span>
                                </a>
                            </li> -->
                            <!-- <li<?php if(isset($ms)){echo $ms;}?>>
                                <a href="?mod=consultant">
                                    <span class="nav-icon text-danger"><i data-feather='coffee'></i></span>
                                    <span class="nav-text"><?php echo $page_title['consultant'];?></span>
                                </a>
                            </li> -->
                            <?php //}?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ Aside END-->
        <div id="main" class="layout-column flex">
            <!-- ############ Header START-->
            <div id="header" class="page-header ">
                <div class="navbar navbar-expand-lg">
                    <!-- brand -->
                    <a href="?" class="navbar-brand d-lg-none">
                        <img src="assets/img/logo.png" alt="...">
                    </a>
                    <!-- / brand -->
                    <!-- Navbar collapse -->
                    <div class="collapse navbar-collapse order-2 order-lg-1" id="navbarToggler">
                        <!-- <form class="input-group m-2 my-lg-0 ">
                            <div class="input-group-prepend">
                                <button type="button" class="btn no-shadow no-bg px-0 text-inherit">
                                    <i data-feather="search"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control no-border no-shadow no-bg typeahead" placeholder="Search components..." data-plugin="typeahead" data-api="assets/api/menu.json">
                        </form> -->
                    </div>
                    <ul class="nav navbar-menu order-1 order-lg-2">
                        <li class="nav-item d-none d-sm-block">
                            <a class="nav-link px-2" data-toggle="fullscreen" data-plugin="fullscreen">
                                <i data-feather="maximize"></i>
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link px-2" data-toggle="dropdown">
                                <i data-feather="settings"></i>
                            </a>
                            <!-- ############ Setting START-->
                            <div class="dropdown-menu dropdown-menu-center mt-3 w-md animate fadeIn">
                                <div class="setting px-3">
                                    <div class="mb-2 text-muted">
                                        <strong>Color:</strong>
                                    </div>
                                    <div class="mb-2">
                                        <label class="radio radio-inline ui-check ui-check-md">
                                            <input type="radio" name="bg" value="">
                                            <i></i>
                                        </label>
                                        <label class="radio radio-inline ui-check ui-check-color ui-check-md">
                                            <input type="radio" name="bg" value="bg-dark">
                                            <i class="bg-dark"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- ############ Setting END-->
                        </li>

                        <!-- Notification -->
                        <li class="nav-item dropdown">
                            <a class="nav-link px-2 mr-lg-2" data-toggle="dropdown">
                                <i data-feather="bell"></i>
                                <?php if(isset($_SESSION['evaluated_at'])&&$_SESSION['evaluated_at']==null){?>
                                <span class="badge badge-pill badge-up bg-primary">1</span>
                                <?php }?>
                            </a>
                            <!-- dropdown -->
                            <div class="dropdown-menu dropdown-menu-right mt-3 w-md animate fadeIn p-0">
                                <div class="scrollable hover" style="max-height: 250px">
                                    <div class="list list-row">


                                        




<? if(isset($_SESSION['evaluated_at'])&&$_SESSION['evaluated_at']==null){?>
                                        <div class="list-item " data-id="12">
                                            <div>
                                                <a href="?mod=employee-profile&tab=evaluate">
                                                    <span class="w-32 avatar gd-info">
		                          E
		                    </span>
                                                </a>
                                            </div>
                                            <div class="flex">
                                                <div class="item-feed h-2x">
                                                    <a href="?mod=employee-profile&tab=evaluate">Evaluation Form</a>
                                                </div>
                                            </div>
                                        </div>
<?php }else{?>
    <div class="list-item " data-id="12">
                                            <div class="flex">
                                                <div class="item-feed h-2x">
                                                    No new notification
                                                </div>
                                            </div>
                                        </div>
<?php }?>


                                    </div>
                                </div>
                                <!-- <div class="d-flex px-3 py-2 b-t">
                                    <div class="flex">
                                        <span>6 Notifications</span>
                                    </div>
                                    <a href="page.setting.html">See all
                                        <i class="fa fa-angle-right text-muted"></i>
                                    </a>
                                </div> -->
                            </div>
                            <!-- / dropdown -->
                        </li>

                        <!-- User dropdown menu -->
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link d-flex align-items-center px-2 text-color">
                                <span class="avatar w-24" style="margin: -2px;"><?php if(isset($_SESSION['ses_user_imageurl'])){echo '<img src="'.$_SESSION['ses_user_imageurl'].'" alt="...">';}?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right w mt-3 animate fadeIn">
                                <a class="dropdown-item" href="?mod=employee-profile">
                                    <span><?php if(isset($_SESSION['ses_fullname'])){echo $_SESSION['ses_fullname'];};?></span>
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="signOut();">Sign out</a>
                                </div>
                                <!-- ############ Setting END-->
                        </li>
                        <!-- Navarbar toggle btn -->
                        <li class="nav-item d-lg-none">
                            <!-- <a href="#" class="nav-link px-2" data-toggle="collapse" data-toggle-class data-target="#navbarToggler">
                                <i data-feather="search"></i>
                            </a> -->
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link px-1" data-toggle="modal" data-target="#aside">
                                <i data-feather="menu"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ############ Footer END-->
            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <?php 
                    
                    if($mod=='expense'){
                        $rss = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
                        $roww = mysqli_fetch_assoc($rss);

                        if(!in_array('expense',json_decode($roww['edits']))){
                            $forbidden = 'yes';
                        }

                    }elseif($md=='course'||$md=='timeoff'||$md=='elearning'||$md=='elearning-test'){
                        $rss = mysqli_query($conn,"SELECT `edits` FROM `db_employee` WHERE `id` = ".$_SESSION['ses_uid']);
                        $roww = mysqli_fetch_assoc($rss);

                        $edits = json_decode($roww['edits']);
                    }

                    
                    if($mod=='timeoff-calendar'){?>
                        <div class="b-b">
                                <div class="d-flex padding">
                                    <div>
                                        <h2 class="text-md text-highlight">
                                            Calendar
                                        </h2>
                                        <small class="text-muted"><?php echo date("l, j F Y");?></small>
                                        <a class="badge badge-sm badge-pill b-a mx-1" id="todayview">Today</a>
                                    </div>
                                    <span class="flex"></span>
                                    <div>
                                        <?php
                                        if(isset(explode('-',$mod)[1])){
                                            if(explode('-',$mod)[0]=='reserve'){
                                                $vlink = 'asset';

                                            }else{
                                                $vlink = explode('-',$mod)[0];
                                            }
                                            echo '<a href="?mod='.$vlink.'"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-secondary text-white">
                                            View All
                                        </button></a>';

                                    }else{
                                        echo '<a href="?mod='.explode('-',$mod)[0].'-edit"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">
                                            Add New
                                        </button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="nav-active-border b-success px-3">
                                    <ul class="nav text-sm" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" id="dayview" data-toggle="tab">Day</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="weekview" data-toggle="tab">Week</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" id="monthview" data-toggle="tab">Month</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <?php if($_GET['alert']=='success'){?>
                            <div class="alert alert-success" role="alert">
                                <i data-feather="check"></i>
                                <span class="mx-2">Data have been saved</span>
                            </div>
                            <?php }?>
                            
                            <?php include "mod/$mod.php";?>

                <?php }else{

                    if($page!='print'&&!isset($forbidden)){
                    ?>
                    <div class="b-b">
                        <div class="d-flex padding">
                            <div>
                                <h2 class="text-md text-highlight">
                                    <?php echo $page_title[$md];
                                    
                                    if($md=='timesheet'){
                                        echo '<a href="#" title="Help" data-toggle="modal" data-target="#modal">
                                        <i data-feather="help-circle"></i>
                                    </a>';
                                    }
                                    
                                    ?>
                                </h2>
                                <?php if(empty(explode('-',$mod)[1])&&explode('-',$mod)[0]!='meetingroom'){?>
                                <small class="text-muted">Total <?php 
                                
                                // if($mod=='project'){

                                    // if($_SESSION['ses_ulevel']==9){
                                    // }else{
                                    //     $adt = " WHERE status =2 AND `time1_ids` LIKE '%\"".$_SESSION['ses_uid']."\"%'";
                                    // }

                                // }elseif($mod=='cover'){
                                    // if($_SESSION['ses_ulevel']<9){
                                    //     $rs = mysqli_query($conn,"SELECT id FROM `db_project` WHERE `time1_ids` LIKE '%\"".$_SESSION['ses_uid']."\"%'");
                                    //     while($row=mysqli_fetch_assoc($rs)){
                                    //         $projects[] = $row['id'];
                                    //     }
                                    //     $projects_ids = implode(',',$projects);
                                    //     $adt = ' WHERE `project_id` IN ('.$projects_ids.')';
                                    // }
                                // }

                                if($mod=='customer'){
                                    $rs = mysqli_query($conn,"SELECT * FROM `db_customer_import`$adt ORDER BY id DESC");
    
                                }elseif($mod=='employee'){
                                    $rs = mysqli_query($conn,"SELECT nick,dob,email FROM `db_$mod` WHERE `end_date` IS NULL order by dob asc");  
                                    while($row=mysqli_fetch_assoc($rs)){
                                        $emails[] = $row['email'];
                                        $yr = substr($row['dob'],0,4);
                                        $years[$yr][] = $row['nick'];
                                    }               

                                    $rs = mysqli_query($conn,"SELECT * FROM `db_$mod` WHERE `end_date` IS NULL ORDER BY id DESC");                                    
    
                                }elseif($mod=='timesheet'){
                                    $rs = mysqli_query($conn,"SELECT DISTINCT `month` FROM `db_timesheet` WHERE status != 0 ORDER BY `month` DESC");
                                    while($row=mysqli_fetch_assoc($rs)){
                                            $smonths[] = $row['month'];
                                    }

                                    if(isset($_GET['month'])){
                                        $month = $_GET['month'];
                                        $rs = mysqli_query($conn,"SELECT * FROM `db_$mod` WHERE month = '$month' and status > 1 ORDER BY id DESC");
                                
                                    }

                                }else{
                                    if($md=='asset'){
                                        // if($_SESSION['ses_ulevel']<8){
                                        //     $adt = ' WHERE status != 0 AND uid = '.$_SESSION['ses_uid'];
                                        // }else{
                                            $adt = " WHERE code not in ('udemy','skilllane','edumall','meetingroom')";
                                        // }

                                    }elseif($md=='timeoff'){
                                        $rss = mysqli_query($conn,"SELECT id FROM `db_employee` WHERE `end_date` IS NULL AND `parent` = ".$_SESSION['ses_uid']);
                                        while($roww=mysqli_fetch_assoc($rss)){
                                            $teamlead[] = "'".$roww['id']."'";
                                            $teamlead_direct[] = $roww['id'];
                                        }
                                        // $_SESSION['ses_ulevel']>7||
                                        if($page!='my'&&(in_array($md,$edits))){
                                            $adt = ' WHERE status != 0 AND ttype NOT LIKE \'a\'';

                                        }elseif($page!='my'&&!in_array($md,$edits)&&(isset($teamlead))){
                                            if($_SESSION['ses_uid']==2||$_SESSION['ses_uid']==17||$_SESSION['ses_uid']==179){
                                                $rss = mysqli_query($conn,"SELECT * FROM `db_employee` WHERE `parent` IN (".implode(',',$teamlead).") AND `end_date` IS NULL");
                                                while($roww=mysqli_fetch_assoc($rss)){
                                                    $teamlead[] = "'".$roww['id']."'";
                                                }
                                            }

                                            $adt = ' WHERE status != 0 AND uid IN ('.implode(',',$teamlead).') AND ttype NOT LIKE \'a\'';

                                        }else{
                                            $adt = ' WHERE status != 0 AND ttype NOT LIKE \'a\' AND uid = '.$_SESSION['ses_uid'];
                                        }

                                    }elseif($md=='project'||$md=='support'){                                        
                                        if(isset($_GET['status'])){
                                            $adt = " WHERE status =".$_GET['status'];
    
                                        }else{
                                            $adt = " WHERE status =2 OR status =3";
    
                                        }
    
                                    }elseif($md=='equipment'||$md=='resign'){
                                        $adt = " WHERE status !=0";

                                    }elseif($md=='recruit'){
                                        if(isset($_GET['interview_status'])){
                                            $adt = " WHERE `interview_status` LIKE '".$_GET['interview_status']."' AND `status` > 0";

                                        }elseif(isset($_GET['status'])){
                                            $adt = " WHERE `status` LIKE '".$_GET['status']."' AND `status` > 0";

                                        }else{
                                            $adt = " WHERE `status` > 0";

                                        }

                                    }elseif($md=='expense'){
                                        if(isset($_GET['year'])){
                                            $year = $_GET['year'];
                                        }else{
                                            $year = '2021';
                                        } 
                                    
                                        if(isset($_GET['month'])&&$_GET['month']!=''){
                                            $adt = " WHERE status = 2 AND month = '".$_GET['month']."'";
                                                // $adt = " WHERE status =".$_GET['status'];
    
                                        }else{
                                            $adt = " WHERE status =2 AND month LIKE '$year-%'";
    
                                        }
    
                                    }elseif(isset($_GET['month'])){
                                        $adt = " WHERE month = '".$_GET['month']."'";
                                            
                                    }else{
                                        $adt = '';
                                    }

                                    if($md=='wfa'){
                                        if($_SESSION['ses_ulevel']<8){
                                            $adt = ' WHERE status != 0 AND ttype LIKE \'a\' AND uid = '.$_SESSION['ses_uid'];
                                        }else{
                                            $adt = ' WHERE status != 0 AND ttype LIKE \'a\'';
                                        }
                                        $sql = "SELECT * FROM `db_timeoff`$adt ORDER BY id DESC";

                                    }else{
                                        $sql = "SELECT * FROM `db_$md`$adt ORDER BY id DESC";

                                    }

                                    // echo $sql.'/'.$_SESSION['ses_uid'];
                                    $rs = mysqli_query($conn,$sql);

                                }

                                $cnt = mysqli_num_rows($rs);
                                echo '<!--'.$sql.'-->';
                                echo $cnt;
                                
                                ?> Records</small>
                                <?php }?>

                            </div>
                            <span class="flex"></span>
                            <div>
                                <?php
                                $vtext = 'View All';
                                if(isset(explode('-',$mod)[1])){
                                    if((explode('-',$mod)[0]=='resign'&&$_SESSION['ses_ulevel']<9)){

                                    }else{
                                        $code = $_GET['code'];
                                        if($code=='meetingroom'||$code=='meetingroom2'){
                                            $vlink = 'meetingroom';

                                        }elseif(explode('-',$mod)[0]=='meetingroom'){
                                            $vlink = 'reserve-edit&code=meetingroom';
                                            $vtext = 'Reserve';

                                        }elseif(explode('-',$mod)[0]=='reserve'){
                                            if($_GET['code']=='sienta'){
                                                $vlink = 'carrec';

                                            }else{
                                                $vlink = 'asset';

                                            }
    
                                        }elseif($mod=='expense-detail'&&isset($_GET['proj_no'])){
                                            $vlink = 'expense&page=summary';

                                        }else{
                                            $vlink = explode('-',$mod)[0];
                                        }

                                        echo '<a href="?mod='.$vlink.'"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-secondary text-white">
                                        '.$vtext.'
                                    </button></a>';
                                    }

                                }elseif(empty(explode('-',$mod)[1])){
                                    if($mod=='carrec'){
                                            echo '<a href="?mod=reserve-edit&amp;code=sienta" id="btn-reserve" class="btn btn-sm box-shadows btn-rounded gd-secondary text-white mr-2">
                                            Reserve
                                        </a> <a href="?mod='.explode('-',$mod)[0].'-edit"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">
                                            Record
                                        </button></a>';
        
                                            }elseif($mod=='culture'&&$_GET['page']!='summary'&&$_SESSION['ses_ulevel']>7){
                                        echo '<a href="?mod='.$mod.'&page=summary"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">
                                        View All
                                    </button></a>';

                                    }elseif($mod=='ld'){
                                        if(isset($_GET['sid'])){
                                            echo '<a href="?mod='.explode('-',$mod)[0].'"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">View All</button></a>';                                            
                                        }

                                    }elseif(($mod!='project'&&$mod!='timesheet2'&&$mod!='howto'&&$mod!='asset'&&$mod!='culture'&&$mod!='meetingroom'&&$mod!='course'&&$mod!='elearning'&&$mod!='elearning-test')||(in_array('course',$edits)||($_SESSION['ses_ulevel']>7&&($mod=='project'||$mod=='employee'||$mod=='course'||$mod=='training'||$mod=='resign'||$mod=='recruit'||$mod=='elearning'||$mod=='elearning-test')))){

                                        echo '<a href="?mod='.explode('-',$mod)[0].'-edit"><button id="btn-new" class="btn btn-sm box-shadows btn-rounded gd-primary text-white">';

                                        if($mod=='resign'){
                                            echo 'Resignation Form';
                                            
                                        }else{
                                            echo 'Add New';
                                        }

                                    
                                        echo '</button></a>';
                                    }
                                }
                                ?>
                            
                            </div>
                        </div>
                    </div>
<?php }?>


                    <div class="page-content<?php if(isset($_GET['page'])&&$_GET['page']!='summary'){echo ' page-container';}?>" id="page-content">
                        <div class="padding">
                        
                            <?php if(isset($_GET['alert'])&&$_GET['alert']=='success'){?>
                            <div class="alert alert-success" role="alert">
                                <i data-feather="check"></i>
                                <span class="mx-2">Data have been saved</span>
                            </div>
                            <?php }?>

                            <?php 
                                if(!isset($forbidden)){
                                    include "mod/$mod.php";
                                }
                            ?>
                        </div>
                    </div>
                <?php }?>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
            <!-- ############ Footer START-->
            <!-- <div id="footer" class="page-footer hide">
                <div class="d-flex p-3">
                    <span class="text-sm text-muted flex">&copy; Copyright. TIME Consulting</span>
                    <div class="text-sm text-muted">Version 1.0</div>
                </div>
            </div> -->
            <!-- ############ Footer END-->
        </div>

                            <!-- .modal -->
                            <div id="modal" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog ">
                                    <div class="modal-content ">
                                        <div class="modal-header ">
                                            <div class="modal-title text-md">Help</div>
                                            <button class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="p-4 text-center">
                                                

                                            <div class="videoWrapper">
                                                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php
                                                
                                                if($md=='timesheet'){
                                                    echo '-KxpLymQI1g';
                                                }elseif($md=='employee'){
                                                    echo 'xdrgRDVPeH8';
                                                }
                                                
                                                ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Save Changes</button> -->
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->

        <div class="g-signin2" data-onsuccess="onSignIn" data-theme="light" style="display:none;"></div>

        <!-- build:js assets/js/site.min.js -->
        <!-- jQuery -->
        <script src="libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- ajax page -->
        <script src="libs/pjax/pjax.min.js"></script>
        <script src="assets/js/ajax.js"></script>
        <!-- lazyload plugin -->
        <script src="assets/js/lazyload.config.php<?php
        
        if($mod=='timesheet'&&isset($_GET['month'])){
            echo "?$mod=$month";

        }elseif($mod=='timesheet'&&$page!='report'){
            echo "?timesheet_summary=".implode(',',array_reverse($vals));

        }elseif($mod=='timesheet2-full'&&isset($_GET['uid'])){
            echo "?uid=".$_GET['uid']."&year=".$year;
        }
        
        ?>"></script>
        <script src="assets/js/lazyload.js"></script>
        <script src="assets/js/plugin.js"></script>
        <!-- scrollreveal -->
        <script src="libs/scrollreveal/dist/scrollreveal.min.js"></script>
        <!-- feathericon -->
        <script src="libs/feather-icons/dist/feather.min.js"></script>
        <script src="assets/js/plugins/feathericon.js"></script>
        <!-- theme -->
        <script src="assets/js/theme.js"></script>
        <script src="assets/js/utils.js"></script>
        <!-- endbuild -->

<script>
        var urlDirect="https://bo.timeconsulting.co.th";

      function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            $.post("logout.php",function(){  
                  console.log('User signed out.');
                  window.location=urlDirect;
            });             
 
        });
      }
    </script>  

<?php if($md=='employee'){?>
<script>
    function myFunction() {
    /* Get the text field */
    var copyText = document.getElementById("myInput");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
    }
</script>
<?php }elseif($_GET['mod']=='expense-view'){?>
    <script>
        $(document).ready(function(){

        // Initialize Select2
        // $('.sel_users').select2();

        // Set option selected onchange
        $('#user_selected').change(function(){
        var value = $(this).val();

        // Set selected 
        $('.sel_users').val(value);
        $('.sel_users').select2().trigger('change');

        });
        });
    </script>

<?php }?>

</body>

</html>        
        
        <?php
    // }
    }
    
    closedb();

    ?>