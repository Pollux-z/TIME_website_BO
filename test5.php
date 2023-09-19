<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <!-- <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="20397358781-90us03atq3cf8g6i89kfbn19kcsc7u32.apps.googleusercontent.com"> -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>     -->
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->

    <title>Team - TIME Consulting</title>
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
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/icon/android-icon-192x192.png">
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
        OneSignal.push(function () {
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
                        <li>
                            <a href="#" class="">
                                <span class="nav-icon"><i data-feather='clipboard'></i></span>
                                <span class="nav-text">Admin</span>
                                <span class="nav-caret"></span>
                            </a>
                            <ul class="nav-sub nav-mega">
                                <li>
                                    <a href="?mod=carrec">
                                        <span class="nav-icon text-secondary"><i data-feather='truck'></i></span>
                                        <span class="nav-text">Car Record</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?mod=meetingroom">
                                        <span class="nav-icon text-secondary"><i data-feather='airplay'></i></span>
                                        <span class="nav-text">Meeting Room</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?mod=asset">
                                        <span class="nav-icon text-secondary"><i data-feather='clipboard'></i></span>
                                        <span class="nav-text">Asset Record</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="?mod=equipment">
                                        <span class="nav-icon text-secondary"><i data-feather='monitor'></i></span>
                                        <span class="nav-text">Equipment</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?mod=cover">
                                        <span class="nav-icon text-success"><i data-feather='file-text'></i></span>
                                        <span class="nav-text">Cover Letter</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="active">
                            <a href="#" class="">
                                <span class="nav-icon"><i data-feather='users'></i></span>
                                <span class="nav-text">TIMER</span>
                                <span class="nav-caret"></span>
                            </a>
                            <ul class="nav-sub nav-mega">
                                <li class="active">
                                    <a href="?mod=employee">
                                        <span class="nav-icon text-danger"><i data-feather='user'></i></span>
                                        <span class="nav-text">Team</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?mod=timesheet2">
                                        <span class="nav-icon text-danger"><i data-feather='clock'></i></span>
                                        <span class="nav-text">Online TIMESheet</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?mod=timeoff">
                                        <span class="nav-icon text-danger"><i
                                                data-feather='battery-charging'></i></span>
                                        <span class="nav-text">TIME-off</span>
                                    </a>
                                </li>
                                <!-- <li>
                                        <a href="?mod=wfa">
                                            <span class="nav-icon text-danger"><i data-feather='wifi'></i></span>
                                            <span class="nav-text"></span>
                                        </a>
                                    </li> -->
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="">
                                <span class="nav-icon"><i data-feather='check-circle'></i></span>
                                <span class="nav-text">Learning & Development</span>
                                <span class="nav-caret"></span>
                            </a>
                            <ul class="nav-sub nav-mega">
                                <!-- <li>
                                        <a href="?mod=culture"">
                                            <span class="nav-icon text-danger"><i data-feather='check-circle'></i></span>
                                            <span class="nav-text">Consulting Culture</span>
                                        </a>
                                    </li> -->
                                <li>
                                    <a href="?mod=course">
                                        <span class="nav-icon text-danger"><i data-feather='book-open'></i></span>
                                        <span class="nav-text">Online Courses</span>
                                    </a>
                                </li>
                                <li>
                                    <!-- <a href="https://www.youtube.com/playlist?list=PLDR1Q6rErapR94BXPDF4TVZR6kICxNDhS" target="_blank"> -->
                                    <a href="?mod=elearning">
                                        <span class="nav-icon text-danger"><i data-feather='video'></i></span>
                                        <span class="nav-text">E-learning</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?mod=ld">
                                        <span class="nav-icon text-danger"><i data-feather='video'></i></span>
                                        <span class="nav-text">L&D program self-learning system</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li>
                                <a href="?mod=support">
                                    <span class="nav-icon text-danger"><i data-feather='thumbs-up'></i></span>
                                    <span class="nav-text"></span>
                                </a>
                            </li> -->
                        <li>
                            <a href="?mod=announce">
                                <span class="nav-icon text-danger"><i data-feather='volume-2'></i></span>
                                <span class="nav-text">Announcement</span>
                            </a>
                        </li>
                        <li>
                            <a href="?mod=howto">
                                <span class="nav-icon text-danger"><i data-feather='help-circle'></i></span>
                                <span class="nav-text">How to</span>
                            </a>
                        </li>


                        <li class="nav-header hidden-folded">
                            <span class="text-muted">Admin Only</span>
                        </li>

                        <li class="active">
                            <a href="?mod=recruit">
                                <span class="nav-icon text-danger"><i data-feather='log-in'></i></span>
                                <span class="nav-text">Recruitment</span>
                            </a>
                        </li>

                        <li>
                            <a href="?mod=project">
                                <span class="nav-icon text-info"><i data-feather='box'></i></span>
                                <span class="nav-text">Projects</span>
                            </a>
                        </li>

                        <li>
                            <a href="?mod=resign">
                                <span class="nav-icon text-danger"><i data-feather='log-out'></i></span>
                                <span class="nav-text">Resignation</span>
                            </a>
                        </li>

                        <li>
                            <a href="?mod=training">
                                <span class="nav-icon text-danger"><i data-feather='coffee'></i></span>
                                <span class="nav-text">Training Course</span>
                            </a>
                        </li>



                        <!-- <li>
                                <a href="?mod=expense">
                                    <span class="nav-icon text-danger"><i data-feather='dollar-sign'></i></span>
                                    <span class="nav-text">Payment Voucher</span>
                                </a>
                            </li> -->
                        <!-- <li>
                                <a href="?mod=customer">
                                    <span class="nav-icon text-danger"><i data-feather='target'></i></span>
                                    <span class="nav-text">Stakeholder</span>
                                </a>
                            </li> -->

                        <!-- <li class="nav-header hidden-folded">
                                <span class="text-muted">Developing</span> -->
                        <!-- </li>
                            <li>
                                <a href="?mod=home">
                                    <span class="nav-icon text-primary"><i data-feather='home'></i></span>
                                    <span class="nav-text">Dashboard</span>
                                </a>
                            </li> -->
                        <!-- <li>
                                <a href="?mod=announce">
                                    <span class="nav-icon text-danger"><i data-feather='volume-2'></i></span>
                                    <span class="nav-text">Announcement</span>
                                </a>
                            </li> -->
                        <!-- <li>
                                <a href="?mod=consultant">
                                    <span class="nav-icon text-danger"><i data-feather='coffee'></i></span>
                                    <span class="nav-text">Consultant</span>
                                </a>
                            </li> -->
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
                        </a>
                        <!-- dropdown -->
                        <div class="dropdown-menu dropdown-menu-right mt-3 w-md animate fadeIn p-0">
                            <div class="scrollable hover" style="max-height: 250px">
                                <div class="list list-row">







                                    <div class="list-item " data-id="12">
                                        <div class="flex">
                                            <div class="item-feed h-2x">
                                                No new notification
                                            </div>
                                        </div>
                                    </div>


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
                            <span class="avatar w-24" style="margin: -2px;"><img src="uploads/employee/45.jpg"
                                    alt="..."></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right w mt-3 animate fadeIn">
                            <a class="dropdown-item" href="?mod=employee-profile&id=45">
                                <span>Apisit Aubdulrohim</span>
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
                <div class="b-b">
                    <div class="d-flex padding">
                        <div>
                            <h2 class="text-md text-highlight">
                                Team </h2>

                        </div>
                        <span class="flex"></span>
                        <div>
                            <a href="?mod=employee"><button id="btn-new"
                                    class="btn btn-sm box-shadows btn-rounded gd-secondary text-white">
                                    View All
                                </button></a>
                        </div>
                    </div>
                </div>


                <div class="page-content" id="page-content">
                    <div class="padding">




                        <div class="card">
                            <div class="card-header bg-dark bg-img p-0 no-border" data-stellar-background-ratio="0.1"
                                style="background-image:url(../assets/img/b3.jpg);" data-plugin="stellar">
                                <div class="bg-dark-overlay r-2x no-r-b">
                                    <div class="d-md-flex">
                                        <div class="p-4">
                                            <div class="d-flex">
                                                <a href="#">
                                                    <span class="avatar w-64">
                                                        <img src="uploads/employee/45.jpg" alt=".">
                                                        <i class="on"></i>
                                                    </span>
                                                </a>
                                                <div class="mx-3">
                                                    <h5 class="mt-2">อภิสิทธิ์ อับดุลรอฮิม</h5>
                                                    <div class="text-fade text-sm"><span class="m-r">Senior IT
                                                            Engineer</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="flex"></span>
                                        <div class="align-items-center d-flex p-4">
                                            <div class="toolbar">
                                                <a href="tel:0612659963"
                                                    class="btn btn-sm btn-icon bg-dark-overlay btn-rounded">
                                                    <i data-feather="phone" width="12" height="12"
                                                        class="text-fade"></i>
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
                                            <a class="nav-link active" href="#" data-toggle="tab"
                                                data-target="#tab_4">Profile</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="tab" data-target="#evaluate">Evaluation</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_1">Timesheet</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#" data-toggle="tab" data-target="#tab_2">Activity</a>
                                            </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="tab"
                                                data-target="#tab_3">Equipment</a>
                                        </li>

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
                                                        <img src="uploads/employee/45.jpg" class="avatar w-40">
                                                    </a>
                                                    <div class="mx-3">
                                                        Apisit Aubdulrohim <div class="text-muted text-sm">
                                                            <input name="date" type='text' class="form-control mb-3"
                                                                data-plugin="datepicker" value="27/08/2022"
                                                                data-option="{daysOfWeekHighlighted: [0,6]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="p-3 b-t">

                                                    <div class="row row-sm">
                                                        <div class="col-5">
                                                            <input name="location" type="text" class="form-control"
                                                                placeholder="Location" required>
                                                        </div>
                                                        <div class="col-5">
                                                            <select name="project" class="form-control"
                                                                data-plugin="select2" data-option="{}"
                                                                data-placeholder="Project" style="width:100% !important"
                                                                required>
                                                                <option></option>
                                                                <optgroup label="Projects">
                                                                    <option value="pj-256">TIME-202230 ONDE TU Digital
                                                                        Technology Plan for Disable</option>
                                                                    <option value="pj-255">TIME-202229 TTC-Cert
                                                                        Availability Assessment</option>
                                                                    <option value="pj-252">TIME-202228 TAT Assessment
                                                                    </option>
                                                                    <option value="pj-254">TIME-202227 BAAC Foresight
                                                                    </option>
                                                                    <option value="pj-251">TIME-202226 NIEC Combined 65
                                                                    </option>
                                                                    <option value="pj-253">TIME-202225 NIEC Telecom 65
                                                                    </option>
                                                                    <option value="pj-250">TIME-202224 Huawei Thailand
                                                                        Digital Talent</option>
                                                                    <option value="pj-249">TIME-202223 MVNO Go-to-Market
                                                                    </option>
                                                                    <option value="pj-248">TIME-202221 NBTC IC System
                                                                    </option>
                                                                    <option value="pj-247">TIME-202220 TAT Training
                                                                    </option>
                                                                    <option value="pj-246">TIME-202218 NT NSW</option>
                                                                    <option value="pj-240">TIME-202217 NBTC Consumer
                                                                        Protection </option>
                                                                    <option value="pj-241">TIME-202216 TED Fund
                                                                        Valuation 2022</option>
                                                                    <option value="pj-244">TIME-202215 GPSC Digital
                                                                        Content</option>
                                                                    <option value="pj-243">TIME-202214 GLO Digital Lotto
                                                                        Social Impact</option>
                                                                    <option value="pj-242">TIME-202213 NBTC Telecom
                                                                        Service Definition</option>
                                                                    <option value="pj-239">TIME-202211 NBTC USO Training
                                                                    </option>
                                                                    <option value="pj-238">TIME-202210 PEA ENCOM
                                                                        Strategic Plan</option>
                                                                    <option value="pj-237">TIME-202209 SAT HRD Plan
                                                                    </option>
                                                                    <option value="pj-236">TIME-202208 EXIM Corporate
                                                                        Strategy</option>
                                                                    <option value="pj-235">TIME-202207 SRT EA</option>
                                                                    <option value="pj-234">TIME-202206 ERC Master Data
                                                                        Set</option>
                                                                    <option value="pj-233">TIME-202205 OPDC Re-process
                                                                        and Prototype</option>
                                                                    <option value="pj-231">TIME-202204 MoTs Tourism
                                                                        Labor Survey</option>
                                                                    <option value="pj-232">TIME-202203 MoTs Tourism
                                                                        Survey</option>
                                                                    <option value="pj-230">TIME-202202 NBTC Omdia and
                                                                        Cullen 2022</option>
                                                                    <option value="pj-225">TIME-202201 DGA Readiness
                                                                        Survey</option>
                                                                    <option value="pj-229">TIME-202184 ONDE Fund
                                                                        Regulation</option>
                                                                    <option value="pj-228">TIME-202183 ONDE Fund
                                                                        Strategic Plan</option>
                                                                    <option value="pj-227">TIME-202182 DASTA Carrying
                                                                        Capacity</option>
                                                                    <option value="pj-226">TIME-202181 ETDA E-commerce
                                                                        Training</option>
                                                                    <option value="pj-216">TIME-202180 ETDA Streaming
                                                                        Platform Business Model</option>
                                                                    <option value="pj-219">TIME-202179 ETDA Foresight
                                                                    </option>
                                                                    <option value="pj-215">TIME-202178 ETDA Master Plan
                                                                        Evaluation</option>
                                                                    <option value="pj-224">TIME-202177 ETDA Digital ID
                                                                    </option>
                                                                    <option value="pj-223">TIME-202176 BEC EA</option>
                                                                    <option value="pj-222">TIME-202175 ERC E-Licensing &
                                                                        Fund Management</option>
                                                                    <option value="pj-221">TIME-202174 ALRO Agricultural
                                                                        DB and Mobile App</option>
                                                                    <option value="pj-220">TIME-202173 SBPAC Smart City
                                                                        Yala</option>
                                                                    <option value="pj-217">TIME-202172 NIA Valuation
                                                                        2022</option>
                                                                    <option value="pj-214">TIME-202171 NIA IOP 2021
                                                                    </option>
                                                                    <option value="pj-205">TIME-202170 ONDE DES Policy
                                                                        and Plan Review</option>
                                                                    <option value="pj-218">TIME-202169 SME APAC Miniter
                                                                        Conference</option>
                                                                    <option value="pj-213">TIME-202168 TCEB Master Plan
                                                                    </option>
                                                                    <option value="pj-212">TIME-202167 ETDA e-Commerce
                                                                        65</option>
                                                                    <option value="pj-211">TIME-202166 NCSA Cyber
                                                                        Security Training</option>
                                                                    <option value="pj-210">TIME-202165 MCOT EA</option>
                                                                    <option value="pj-209">TIME-202164 GSB Big Data
                                                                        Analytics</option>
                                                                    <option value="pj-208">TIME-202163 ERC Licensing
                                                                        Platform</option>
                                                                    <option value="pj-207">TIME-202162 NBTC Fund NGSO
                                                                        Satellite</option>
                                                                    <option value="pj-191">TIME-202161 EFAI Strategic
                                                                        Plan</option>
                                                                    <option value="pj-204">TIME-202160 HII Data Platform
                                                                    </option>
                                                                    <option value="pj-203">TIME-202159 SME Policy
                                                                        Networking</option>
                                                                    <option value="pj-202">TIME-202158 TCEB MICE Insight
                                                                    </option>
                                                                    <option value="pj-201">TIME-202157 ETDA Digital
                                                                        Platform Governance</option>
                                                                    <option value="pj-200">TIME-202156 NBTC Fund Telecom
                                                                        Digital Service Index</option>
                                                                    <option value="pj-199">TIME-202155 ONDE Digital
                                                                        Outlook Ph4</option>
                                                                    <option value="pj-197">TIME-202153 MoTS Policy
                                                                        Recommendation</option>
                                                                    <option value="pj-190">TIME-202152 NCSA Cyber Risk
                                                                        Assessment</option>
                                                                    <option value="pj-196">TIME-202151 OIC Fund
                                                                        Strategic and IT Plans</option>
                                                                    <option value="pj-195">TIME-202150 ONDE PMO</option>
                                                                    <option value="pj-194">TIME-202149 ETDA Dashboard
                                                                    </option>
                                                                    <option value="pj-193">TIME-202148 TCG Financial
                                                                        gateway</option>
                                                                    <option value="pj-192">TIME-202146 Huawei 5G City
                                                                    </option>
                                                                    <option value="pj-189">TIME-202145 TED Fund
                                                                        Valuation 2021</option>
                                                                    <option value="pj-188">TIME-202144 Huawei White
                                                                        Paper</option>
                                                                    <option value="pj-187">TIME-202143 ERC Project
                                                                        Evaluation</option>
                                                                    <option value="pj-186">TIME-202142 NBTC Telco
                                                                        Network Measures</option>
                                                                    <option value="pj-185">TIME-202141 DPA Digital Plan
                                                                    </option>
                                                                    <option value="pj-184">TIME-202140 TAT Organization
                                                                        Assesment</option>
                                                                    <option value="pj-183">TIME-202139 L&D Platform
                                                                    </option>
                                                                    <option value="pj-182">TIME-202138 LiveTIME</option>
                                                                    <option value="pj-181">TIME-202137 Thaicom Satellite
                                                                        Auction</option>
                                                                    <option value="pj-180">TIME-202136 DGA Digital
                                                                        Government Master Plan</option>
                                                                    <option value="pj-179">TIME-202135 BAAC New Business
                                                                    </option>
                                                                    <option value="pj-178">TIME-202134 ONDE Digital
                                                                        Program Certification</option>
                                                                    <option value="pj-177">TIME-202133 Huawei 5G Survey
                                                                    </option>
                                                                    <option value="pj-176">TIME-202132 NBTCFund Cable
                                                                        OTT</option>
                                                                    <option value="pj-169">TIME-202131 NBTC Radio in
                                                                        Disruption</option>
                                                                    <option value="pj-175">TIME-202130 NBTC Consumer
                                                                        Protection 65</option>
                                                                    <option value="pj-174">TIME-202129 RTAF VR Simulator
                                                                    </option>
                                                                    <option value="pj-168">TIME-202128 SAT
                                                                        SocialEconomic Valuation</option>
                                                                    <option value="pj-173">TIME-202126 SKIC M-Business
                                                                    </option>
                                                                    <option value="pj-167">TIME-202125 STOU NBTC Radio
                                                                        Support</option>
                                                                    <option value="pj-166">TIME-202124 NIA Portfolio
                                                                        Management</option>
                                                                    <option value="pj-165">TIME-202123 NBTC Satellite
                                                                        Study</option>
                                                                    <option value="pj-172">TIME-202122 TKPark Digital
                                                                        Plan</option>
                                                                    <option value="pj-164">TIME-202121 BAAC Organization
                                                                        Assesment</option>
                                                                    <option value="pj-163">TIME-202120 NIEC Combined 64
                                                                    </option>
                                                                    <option value="pj-161">TIME-202119 NIEC Telecom 64
                                                                    </option>
                                                                    <option value="pj-160">TIME-202118 NIEC 5G and
                                                                        Satellite 64</option>
                                                                    <option value="pj-162">TIME-202118 NIEC Telecom64
                                                                        and Hot Topics</option>
                                                                    <option value="pj-159">TIME-202117 TINT Digital
                                                                        Roadmap</option>
                                                                    <option value="pj-157">TIME-202116 DGA E-Gov
                                                                        Readiness Survey</option>
                                                                    <option value="pj-158">TIME-202116 TINT PDPA
                                                                    </option>
                                                                    <option value="pj-156">TIME-202115 MEA Cyber
                                                                        Security Master Plan</option>
                                                                    <option value="pj-171">TIME-202113 ONDE 5G Incentive
                                                                        Measures</option>
                                                                    <option value="pj-170">TIME-202112 ONDE 5G Ecosystem
                                                                    </option>
                                                                    <option value="pj-155">TIME-202111 NIDA Market
                                                                        Analysis</option>
                                                                    <option value="pj-154">TIME-202110 SACICT ISO27001
                                                                    </option>
                                                                    <option value="pj-153">TIME-202109 TIME HR Digital
                                                                        Transformation</option>
                                                                    <option value="pj-152">TIME-202108 DPT EA and
                                                                        Digital Master Plan</option>
                                                                    <option value="pj-151">TIME-202107 NBTC Digital
                                                                        Platform Survey</option>
                                                                    <option value="pj-150">TIME-202106 Ombusmans Big
                                                                        Data</option>
                                                                    <option value="pj-149">TIME-202105 DoT Tourism DB
                                                                    </option>
                                                                    <option value="pj-148">TIME-202104 MoC Digital
                                                                        Master Plan</option>
                                                                    <option value="pj-147">TIME-202103 ONDE TU Digital
                                                                        Training</option>
                                                                    <option value="pj-146">TIME-202102 NBTC Cullen and
                                                                        Omdia Subscription 2021</option>
                                                                    <option value="pj-145">TIME-202101 NIA Valuation
                                                                        2021</option>
                                                                    <option value="pj-144">TIME-202100 OIC Data
                                                                        Governance</option>
                                                                    <option value="pj-143">TIME-202099 NIEC Radio
                                                                        Evaluation</option>
                                                                    <option value="pj-142">TIME-202098 OIC Strategic
                                                                        Management</option>
                                                                    <option value="pj-141">TIME-202097 OIC NIB</option>
                                                                    <option value="pj-140">TIME-202096 OIC EA and PMC
                                                                    </option>
                                                                    <option value="pj-139">TIME-202095 ETDA Assessment
                                                                        and Evaluation</option>
                                                                    <option value="pj-138">TIME-202094 ETDA E-Commerce
                                                                        Survey</option>
                                                                    <option value="pj-137">TIME-202093 ETDA Master Plan
                                                                    </option>
                                                                    <option value="pj-136">TIME-202092 ETDA Transaction
                                                                        Database</option>
                                                                    <option value="pj-135">TIME-202091 ETDA Social and
                                                                        Economic Impact</option>
                                                                    <option value="pj-134">TIME-202090 ETDA
                                                                        E-Transaction Development Index</option>
                                                                    <option value="pj-133">TIME-202089 TCEB Innovation
                                                                        Ecosystem</option>
                                                                    <option value="pj-132">TIME-202088 TCEB Industry
                                                                        Focused Report</option>
                                                                    <option value="pj-131">TIME-202087 CAAT Aviation
                                                                        statistical system</option>
                                                                    <option value="pj-130">TIME-202086 CAAT Big Data
                                                                        Analytic</option>
                                                                    <option value="pj-128">TIME-202084 NBTC OTT Impacts
                                                                        on Mobile</option>
                                                                    <option value="pj-127">TIME-202083 STO Gov Data
                                                                        System Phase 1</option>
                                                                    <option value="pj-126">TIME-202082 MoTS Master Plan
                                                                    </option>
                                                                    <option value="pj-125">TIME-202081 MWA Digital
                                                                        Competency</option>
                                                                    <option value="pj-124">TIME-202080 CPAll Pitching
                                                                    </option>
                                                                    <option value="pj-123">TIME-202079 SPC Digital
                                                                        Mindset</option>
                                                                    <option value="pj-122">TIME-202078 CRG Omnichannel
                                                                    </option>
                                                                    <option value="pj-121">TIME-202077 ERC Digital
                                                                        Master Plan</option>
                                                                    <option value="pj-120">TIME-202076 ERC Post COD
                                                                        Audit</option>
                                                                    <option value="pj-119">TIME-202075 TPBS Technology
                                                                        Master Plan</option>
                                                                    <option value="pj-118">TIME-202074 PlayingCard
                                                                        Marketing Strategy </option>
                                                                    <option value="pj-116">TIME-202073 OFFO Operation
                                                                        Efficiency Enhancement</option>
                                                                    <option value="pj-115">TIME-202072 CMG Omnichannel
                                                                    </option>
                                                                    <option value="pj-114">TIME-202071 Fujisu DX
                                                                        Consulting</option>
                                                                    <option value="pj-113">TIME-202070 NIA Innovation
                                                                        Organization Program</option>
                                                                    <option value="pj-112">TIME-202069 NSF PDPA</option>
                                                                    <option value="pj-111">TIME-202068 NBTC Fund
                                                                        Spectrum Valuation</option>
                                                                    <option value="pj-110">TIME-202067 TAT Ph2 Digital
                                                                        Trainings</option>
                                                                    <option value="pj-109">TIME-202066 ONDE Foresight
                                                                    </option>
                                                                    <option value="pj-108">TIME-202065 ONDE Thailand
                                                                        Digital Outlook Ph3</option>
                                                                    <option value="pj-107">TIME-202064 Huawei 5G Impact
                                                                    </option>
                                                                    <option value="pj-106">TIME-202063 Huawei 5G
                                                                        Thailand Data Center Insight</option>
                                                                    <option value="pj-105">TIME-202062 Huawei 5G
                                                                        Thailand Insight Ph2</option>
                                                                    <option value="pj-104">TIME-202061 NBTC Fund
                                                                        Immersive AR_VR</option>
                                                                    <option value="pj-103">TIME-202060 TPBS Digital DNA
                                                                    </option>
                                                                    <option value="pj-102">TIME-202059 SAM LRS</option>
                                                                    <option value="pj-101">TIME-202058 NBTC OTT Event
                                                                    </option>
                                                                    <option value="pj-100">TIME-202057 SKGF-TELEVISA
                                                                    </option>
                                                                    <option value="pj-99">TIME-202056 Siasun TIME
                                                                        Go-to-Market Strategy</option>
                                                                    <option value="pj-97">TIME-202054 SACICT Digital
                                                                        Master Plan</option>
                                                                    <option value="pj-96">TIME-202053 TED Fund Valuation
                                                                    </option>
                                                                    <option value="pj-95">TIME-202052 NBTC Fund 5G
                                                                        Satellite</option>
                                                                    <option value="pj-94">TIME-202051 OTCC Digital
                                                                        Master Plan</option>
                                                                    <option value="pj-93">TIME-202050 NBTC Spectrum Fee
                                                                    </option>
                                                                    <option value="pj-91">TIME-202049 Thaicom Pitching
                                                                    </option>
                                                                    <option value="pj-90">TIME-202048 S&J Strategy
                                                                    </option>
                                                                    <option value="pj-89">TIME-202047 DEFund 2020
                                                                    </option>
                                                                    <option value="pj-88">TIME-202046 ETDA Action Plan
                                                                    </option>
                                                                    <option value="pj-87">TIME-202045 TIME 5G Hub
                                                                        Thailand</option>
                                                                    <option value="pj-86">TIME-202044 TIME People
                                                                        Network</option>
                                                                    <option value="pj-85">TIME-202043 DGA Foreign
                                                                        Platform</option>
                                                                    <option value="pj-84">TIME-202042 TPBS Digital
                                                                        Competencies</option>
                                                                    <option value="pj-83">TIME-202041 TIME Thai Consult
                                                                        Registration Q2/20</option>
                                                                    <option value="pj-82">TIME-202040 TIME Consulting
                                                                        Culture</option>
                                                                    <option value="pj-81">TIME-202039 TIME CI/CD
                                                                        Guideline</option>
                                                                    <option value="pj-80">TIME-202038 GPSC Customer
                                                                        Engagement</option>
                                                                    <option value="pj-74">TIME-202037 NBTC Telecom
                                                                        Market Intelligence</option>
                                                                    <option value="pj-60">TIME-202035 Huawei 5G Thailand
                                                                        Insight</option>
                                                                    <option value="pj-72">TIME-202034 NIEC Combine63
                                                                    </option>
                                                                    <option value="pj-71">TIME-202033 NIEC HRD
                                                                        Evaluation</option>
                                                                    <option value="pj-70">TIME-202032 NIEC Digital TV
                                                                        Evaluation</option>
                                                                    <option value="pj-69">TIME-202031 NIEC Must Carry
                                                                    </option>
                                                                    <option value="pj-68">TIME-202030 NIEC TV Evaluation
                                                                        63</option>
                                                                    <option value="pj-67">TIME-202029 NIEC Duct
                                                                        Evalution</option>
                                                                    <option value="pj-66">TIME-202028 NIEC Telecom
                                                                        Master Plan Evaluation</option>
                                                                    <option value="pj-65">TIME-202027 NIEC Audit Model
                                                                    </option>
                                                                    <option value="pj-64">TIME-202026 NIEC Telecom
                                                                        Evaluation 63</option>
                                                                    <option value="pj-62">TIME-202024 NBTC OTT
                                                                        Subscription 2020</option>
                                                                    <option value="pj-59">TIME-202023 TU Digital Plan
                                                                        and Policy Seminar</option>
                                                                    <option value="pj-58">TIME-202022 ONDE MIL2020
                                                                    </option>
                                                                    <option value="pj-61">TIME-202021 NBTC MC Audit
                                                                    </option>
                                                                    <option value="pj-51">TIME-202020 DGA Service
                                                                        Platform Master Plan</option>
                                                                    <option value="pj-92">TIME-202019 TAT Digital
                                                                        Assessment and Workshop</option>
                                                                    <option value="pj-49">TIME-202018 TIME Team Event
                                                                        2020</option>
                                                                    <option value="pj-48">TIME-202017 TIME KM Phase 1
                                                                    </option>
                                                                    <option value="pj-47">TIME-202016 MBK Digital
                                                                        Strategy</option>
                                                                    <option value="pj-46">TIME-202015 Electrolux Digital
                                                                        Mindset and Change Mgmt</option>
                                                                    <option value="pj-45">TIME-202014 Krungsri Digital
                                                                        Mindset Townhall</option>
                                                                    <option value="pj-44">TIME-202013 MoI Cyber Security
                                                                    </option>
                                                                    <option value="pj-41">TIME-202010 AFP Digital
                                                                        Mindset</option>
                                                                    <option value="pj-40">TIME-202009 TIME Digital
                                                                        Assessment</option>
                                                                    <option value="pj-39">TIME-202008 EXAT Digital
                                                                        Master Plan</option>
                                                                    <option value="pj-37">TIME-202006 NBTC Audit Study
                                                                        Project</option>
                                                                    <option value="pj-34">TIME-202002 Krungsri VP and
                                                                        SME Transformation</option>
                                                                    <option value="pj-33">TIME-202001 CPAll Next
                                                                        Generation Leader 2020</option>
                                                                    <option value="pj-56">TIME-201968 KTB Digital
                                                                        Transformation</option>
                                                                    <option value="pj-5">TIME-201961 NBTC Pure LRIC
                                                                        Model</option>
                                                                    <option value="pj-4">TIME-201960 NBTC AS Re-model
                                                                    </option>
                                                                    <option value="pj-75">TIME-201959 DGA Digital
                                                                        Transformation Program</option>
                                                                    <option value="pj-52">TIME-201957 NBTC Fund 2020
                                                                        Projects</option>
                                                                    <option value="pj-15">TIME-201954 ONDE Thailand
                                                                        Digital Outlook Ph2</option>
                                                                    <option value="pj-28">TIME-201953 OIC IT Master Plan
                                                                    </option>
                                                                    <option value="pj-25">TIME-201950 Marvel Avengers
                                                                    </option>
                                                                    <option value="pj-24">TIME-201949 Marvel Consumer
                                                                    </option>
                                                                    <option value="pj-23">TIME-201948 Marvel Telecom
                                                                    </option>
                                                                    <option value="pj-22">TIME-201946 Marvel TV</option>
                                                                    <option value="pj-54">TIME-201940 Mobifone Strategy
                                                                    </option>
                                                                    <option value="pj-9">TIME-201929 TE Optus Auction
                                                                        2019</option>
                                                                    <option value="pj-53">TIME-201916 ThaiOil Digital
                                                                        Transformation</option>
                                                                    <option value="pj-21">TIME-201907 NBTC Broadcast IC
                                                                    </option>
                                                                    <option value="pj-20">TIME-201901 NBTC OTT
                                                                        Subscription 2019</option>
                                                                    <option value="pj-50">TIME-201881 TMA MICE
                                                                        Innovation</option>
                                                                    <option value="pj-16">TIME-201801 STOU USO Digital
                                                                        Literacy</option>
                                                                </optgroup>
                                                                <optgroup label="Cost Center">
                                                                    <option value="BO">Business Operation</option>
                                                                    <option value="BD">Business Development</option>
                                                                    <option value="OT">อื่นๆ</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-2">
                                                            <input name="hrs" type="number" step="0.01"
                                                                class="form-control" placeholder="Hours" required>
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
                                                    <textarea name="description" class="form-control" rows="3"
                                                        placeholder="Task Description" required></textarea>
                                                    <div class="d-flex pt-2">
                                                        <div class="toolbar my-1">
                                                        </div>
                                                        <span class="flex"></span>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">Post</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="card" id="feed-1">
                                            <div class="card-header d-flex">
                                                <a href="#">
                                                    <img src="uploads/employee/45.jpg" class="avatar w-40">
                                                </a>
                                                <div class="mx-3">
                                                    <a href="#">Apisit Aubdulrohim</a>
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
                                                    <p>Arcu risus tortor sed erat odio faucibus amet, arcu, integer
                                                        cursus enim quis vitae felis</p>
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
                                                            <a href='#'>@TUT</a> team
                                                        </div>
                                                        <div class="tl-date text-muted mt-1">2 days ago</div>
                                                    </div>
                                                </div>
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-content">
                                                        <div class="">
                                                            <a href='#'>@Netflix</a> hackathon
                                                        </div>
                                                        <div class="tl-date text-muted mt-1">25/12 18</div>
                                                    </div>
                                                </div>
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-content">
                                                        <div class="">Just saw this on the
                                                            <a href='#'>@eBay</a> dashboard, dude is an absolute unit.
                                                        </div>
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
                                                            <a href='#'>@NextUI</a> submit a ticket request
                                                        </div>
                                                        <div class="tl-date text-muted mt-1">1 hour ago</div>
                                                    </div>
                                                </div>
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-content">
                                                        <div class="">Developers of
                                                            <a href='#'>@iAI</a>, the AI assistant based on Free
                                                            Software
                                                        </div>
                                                        <div class="tl-date text-muted mt-1">1 day ago</div>
                                                    </div>
                                                </div>
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-content">
                                                        <div class="">
                                                            <a href='#'>@WordPress</a> How To Get Started With WordPress
                                                        </div>
                                                        <div class="tl-date text-muted mt-1">20 minutes ago</div>
                                                    </div>
                                                </div>
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-content">
                                                        <div class="">From design to dashboard,
                                                            <a href='#'>@Dash</a> builds custom hardware according to
                                                            on-site requirements
                                                        </div>
                                                        <div class="tl-date text-muted mt-1">21 July</div>
                                                    </div>
                                                </div>
                                                <div class="tl-item  ">
                                                    <div class="tl-dot ">
                                                    </div>
                                                    <div class="tl-content">
                                                        <div class="">Fun project from this weekend. Both computer
                                                            replicas are fully functional</div>
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
                                    <div class="tab-pane fade show active" id="tab_4">
                                        <div class="card">
                                            <div class="px-4 py-4">
                                                <div class="text-right"><a href="?mod=employee-edit&id=45"><i
                                                            class="mx-2" data-feather="edit-2"></i></a></div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Name</small>
                                                        <div class="my-2">Apisit Aubdulrohim</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Nickname</small>
                                                        <div class="my-2">ลีโอ</div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Cell Phone</small>
                                                        <div class="my-2">0612659963</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted">E-mail</small>
                                                        <div class="my-2">apisit.a@timeconsulting.co.th</div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Birthday</small>
                                                        <div class="my-2">26 Jun 1991 (31 years)</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <small class="text-muted">Employee ID</small>
                                                        <div class="my-2">TIME112</div>
                                                    </div>
                                                </div>

                                                <form action="action.php" method="post" enctype="multipart/form-data">
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Start Date</small>
                                                            <div class="my-2">2020-06-15</div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <small class="text-muted">HQ Profile Photo</small>
                                                            <div class="custom-file">
                                                                <input type="file" name="hq">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Emergency Telephone No.</small>
                                                            <div class="my-2">
                                                                <input type="text" name="emer_tel" class="form-control"
                                                                    value="0890471917">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Who</small>
                                                            <div class="my-2">
                                                                <input type="text" name="emer_who" class="form-control"
                                                                    value="บิดา">


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
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergies[]" id="inlineCheckbox4"
                                                                        value="0" checked>
                                                                    <label class="form-check-label"
                                                                        for="inlineCheckbox4">ไม่แพ้</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergies[]" id="inlineCheckbox1"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="inlineCheckbox1">แพ้กุ้ง</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergies[]" id="inlineCheckbox2"
                                                                        value="2">
                                                                    <label class="form-check-label"
                                                                        for="inlineCheckbox2">แพ้ปู</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="allergies[]" id="inlineCheckbox3"
                                                                        value="3">
                                                                    <label class="form-check-label"
                                                                        for="inlineCheckbox3">ไม่กินเนื้อ</label>
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
                                                                <input type="text" name="allergy_other"
                                                                    class="form-control" placeholder="โปรดระบุ"
                                                                    value="">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">LINE Token</small>
                                                            <div class="my-2">
                                                                <input type="text" name="line_token"
                                                                    class="form-control"
                                                                    value="mqQkh0IMSE9syIsAI31LyfpW5rVhIhsffCq3RsCf6tU">
                                                                <small class="form-text text-muted"><a
                                                                        href="https://notify-bot.line.me/my/"
                                                                        target="_blank">Get Token</a></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted">Mods</small>
                                                            <div class="my-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod0" value="carrec" checked>
                                                                    <label class="form-check-label" for="mod0">Car
                                                                        Record</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod1" value="expense" checked>
                                                                    <label class="form-check-label"
                                                                        for="mod1">Expense</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod2" value="evaluate">
                                                                    <label class="form-check-label"
                                                                        for="mod2">Evaluation</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod3" value="timeoff" checked>
                                                                    <label class="form-check-label"
                                                                        for="mod3">Time-off</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod4" value="wfa">
                                                                    <label class="form-check-label"
                                                                        for="mod4">WFA</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod5" value="resign">
                                                                    <label class="form-check-label"
                                                                        for="mod5">Resignation</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod6" value="support-case">
                                                                    <label class="form-check-label" for="mod6">Sup-Case
                                                                        Team</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod7" value="support-acc"
                                                                        checked>
                                                                    <label class="form-check-label"
                                                                        for="mod7">Sup-Accounting & Finance</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod8" value="support-hr"
                                                                        checked>
                                                                    <label class="form-check-label"
                                                                        for="mod8">Sup-HR</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod9" value="support-adm"
                                                                        checked>
                                                                    <label class="form-check-label"
                                                                        for="mod9">Sup-Admin</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod10" value="support-it"
                                                                        checked>
                                                                    <label class="form-check-label"
                                                                        for="mod10">Sup-IT</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="mods[]" id="mod11" value="support-mkt"
                                                                        checked>
                                                                    <label class="form-check-label"
                                                                        for="mod11">Sup-Marketing</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="mod" value="profile">
                                                    <input type="hidden" name="id" value="45">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="evaluate">

                                        <div class="card">

                                            <div class="px-4 py-4">
                                                <div>
                                                    <h5 class="card-title">
                                                        H2/2019 Evaluation Form <a href="#" title="Help"
                                                            data-toggle="modal" data-target="#modal">
                                                            <i data-feather="help-circle"></i>
                                                        </a><br>
                                                        แบบประเมินผลงานประจำ H2 ปี ค.ศ. 2019</h5>
                                                    <small>(แบบฟอร์มนี้ เมื่อ Save แล้ว
                                                        สามารถแก้ไขหรือเขียนเพิ่มเติมภายหลังได้)</small>
                                                    <!-- Evaluation & Constructive Feedback Form -->

                                                    <p><small>Agenda / Topic</small></p>
                                                    <form method="post" action="action.php">
                                                        <p><strong>1. In this period, I have contributed, delivered
                                                                and/or created value to:</strong><br>
                                                            ในช่วงครึ่งปีนี้ ฉันได้มีส่วนร่วมหรือสนับสนุน
                                                            สร้างสรรค์ผลงาน และ/หรือสร้างคุณค่าให้แก่:

                                                            <!-- Contribution / Value Creation -->
                                                        </p>

                                                        <div class="form-group">
                                                            <label>1.1 Project Deliverable<br>
                                                                ผลงานในโครงการ (ทั้งตาม Scope
                                                                และสิ่งที่ส่งมอบให้กับลูกค้านอกเหนือจาก Scope)
                                                            </label>
                                                            <textarea name="a1" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1.2 Work Environment, People & Project Team
                                                                Development<br>
                                                                การพัฒนาสภาพแวดล้อมในการทำงาน เพื่อนร่วมงานในองค์กร
                                                                และทีมงานในโครงการ</label>
                                                            <textarea name="a2" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1.3 Knowledge & Process Development<br>
                                                                การพัฒนาองค์ความรู้และ/หรือกระบวนงานในองค์กร
                                                                <!-- Sharing -->
                                                            </label>
                                                            <textarea name="a3" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1.4 Sales (Sale Opportunity, Sale Lead Proposal, Sale
                                                                Close)<br>
                                                                การสร้างรายได้ (การสร้างสรรค์โอกาสในการขาย,
                                                                การพัฒนาและจัดทำข้อเสนอ, การปิดการขาย)</label>
                                                            <textarea name="a4" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>1.5 Client Satisfaction (do not meet, meet, exceed
                                                                expectation) and Client Relationship<br>
                                                                ความพึงพอใจของลูกค้า (ต่ำกว่า, ตามที่, เกิน ความคาดหวัง)
                                                                และความสัมพันธ์กับลูกค้า</label>
                                                            <textarea name="a5" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><strong>2. I have learned the following lessons in
                                                                    this period</strong><br>

                                                                <!-- Lessons Learned from the experience in the last half -->
                                                                ในช่วงครึ่งปีที่ผ่านมา ฉันได้เรียนรู้บทเรียนต่างๆ
                                                                ดังต่อไปนี้</label>
                                                            <!-- <textarea name="b" class="form-control" rows="20"></textarea> -->
                                                        </div>
                                                        <div class="form-group">
                                                            <label>2.1 Positive or Value Added / Fulfilment<br>
                                                                บทเรียนที่ดีและสร้างคุณค่า/เติมเต็มให้แก่ฉัน
                                                            </label>
                                                            <textarea name="b" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>2.2 Challenges and Ways or Recommendations to
                                                                Overcome / Improve / Solve / Prevent<br>
                                                                ความท้าทายที่ฉันพบ และแนวทางหรือข้อเสนอแนะในการพัฒนา
                                                                แก้ไข ป้องกัน
                                                            </label>
                                                            <textarea name="b2" class="form-control"
                                                                rows="20"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label><strong>3. I am seeing my future development with the
                                                                    company as: </strong><br>
                                                                1. Role & Responsibility*<br>
                                                                2. Industry or Competency Practice**<br>
                                                                3. Skills and Expertise Development<br>
                                                                ฉันมองเห็นการพัฒนาในอนาคตของตัวฉันกับบริษัทเป็นอย่างไรในด้าน:<br>
                                                                1. บทบาทหน้าที่*<br>
                                                                2.
                                                                ความสนใจและความเชี่ยวชาญในอุตสาหกรรม/การปฏิบัติงาน**<br>
                                                                3. การพัฒนาทักษะและความเชี่ยวชาญ</label>
                                                            <textarea name="c" class="form-control"
                                                                rows="20"></textarea>
                                                            <small class="form-text text-muted">
                                                                * Example: Team Leader (TL), Project Manager (PM), Work
                                                                Stream/Work Plan Leader (WL), Project Owner (PO),
                                                                Subject Matter Expert (SME), Project
                                                                Supporter/Co-Ordinator (PS), Business Development (BD),
                                                                Sale (S)<br>
                                                                ** Example: Telecom & Broadband / TV Media &
                                                                Broadcasting / Digital Policy & Strategy / Digital
                                                                Innovation & Transformation / อื่นๆ (โปรดระบุ)</small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label><strong>4. To achive the future picture, I would need
                                                                    the following help/support/resource etc. (and
                                                                    how?)</strong><br>
                                                                เพื่อที่จะได้พัฒนาตัวฉันตามที่ได้ตั้งไว้ ฉันต้องการ
                                                                ความช่วยเหลือ/การส่งเสริม/สนับสนุน/ทรัพยากรในด้าน:
                                                                (และอย่างไร?)
                                                            </label>
                                                            <textarea name="d" class="form-control"
                                                                rows="20"></textarea>

                                                        </div>

                                                        <input type="hidden" name="mod" value="evaluate">
                                                        <input type="hidden" name="uid" value="45">
                                                        <button type="submit" class="btn btn-secondary">Save</button>
                                                        <button type="submit" name="submitted" value="1"
                                                            class="btn btn-primary">Submit to p'Dome</button>
                                                        <small class="form-text text-muted">
                                                            สามารถ Save ไว้ก่อนได้ โดยข้อความจะยังไม่ส่งถึงพี่โดม
                                                            ถ้ากรอกเสร็จและไม่ต้องการแก้ไขอะไรแล้ว ให้คลิกปุ่ม Submit to
                                                            p'Dome เมื่อกดแล้วจะไม่สามารถแก้ไขได้อีก
                                                        </small>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-4">
                                <img src="uploads/employee_hq/45.jpg" class="img-fluid">
                                <div class="card sticky" style="z-index: 1">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <strong>Team Lead</strong>
                                        <a href="?mod=employee-profile&id=142"
                                            class="nav-link d-flex align-items-center px-2 text-color border-0">
                                            <span class="avatar w-24" style="margin: -2px;"><img
                                                    src="uploads/employee/142.jpg" alt="..."></span>
                                        </a>

                                        <!-- Wrap with <div>...buttons...</div> if you have multiple buttons -->
                                    </div>

                                    <div class="list list-row">
                                        <!-- <div class="list-item " data-id="7">
                                                <span class="text-muted">Past Projects</span>
                                            </div> -->
                                    </div>
                                    <div class="card-header">
                                        <strong>Project Owner</strong>
                                    </div>
                                    <div class="list list-row">
                                        <!-- <div class="list-item " data-id="7">
                                                <span class="text-muted">Past Projects</span>
                                            </div> -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
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
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/xdrgRDVPeH8"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
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
        <script src="assets/js/lazyload.config.php"></script>
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
            var urlDirect = "https://bo.timeconsulting.co.th";

            function signOut() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                    $.post("logout.php", function () {
                        console.log('User signed out.');
                        window.location = urlDirect;
                    });

                });
            }
        </script>

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

</body>

</html>