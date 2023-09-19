<?php
session_start(); // ใช้งาน session
require_once("dbconnect.php");//  ไฟล์เชื่อมต่อฐานข้อมูล
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="20397358781-90us03atq3cf8g6i89kfbn19kcsc7u32.apps.googleusercontent.com">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>    
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <title>Business Operation - TIME Consulting</title>
    
        <meta name="description" content="ระบบฐานข้อมูลกลาง TIME Consulting" />

        <meta property="og:type" content="website">
        <meta property="og:title" content="Business Operation - TIME Consulting">
        <meta property="og:url" content="https://bo.timeconsulting.co.th">
        <meta property="og:image" content="https://bo.timeconsulting.co.th/assets/img/logo.png">
        <meta property="og:description" content="ระบบฐานข้อมูลกลาง TIME Consulting">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <!-- style -->
        <!-- build:css ../assets/css/site.min.css -->
        <link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="../assets/css/theme.css" type="text/css" />
        <link rel="stylesheet" href="../assets/css/style.css" type="text/css" />
        <!-- endbuild -->
    </head>
    <body class="layout-row">
        <div class="d-flex flex-column flex">
            <div class="row no-gutters h-100">
                <div class="col-md-6 bg-primary" style="background-image: url('assets/img/TIME-wallpaper2-4.jpg'); background-size: cover; background-position: bottom;">
                    <div class="p-3 p-md-5 d-flex flex-column h-100">
                        <!-- <h4 class="mb-3 text-white">logo</h4> -->
                        <a href="//timeconsulting.co.th" target="_blank">
                            <img src="assets/img/logo-w.png" alt="..." style="height:100px;">
                        </a>
                        <!-- <div class="text-fade">Business Operation</div> -->
                        <div class="d-flex flex align-items-center justify-content-center">
                        </div>
                        <div class="d-flex text-sm text-fade">
                            <!-- <a href="index.html" class="text-white">About</a> -->
                            <span class="flex"></span>
                            <!-- <a href="#" class="text-white mx-1">Terms</a>
                            <a href="#" class="text-white mx-1">Policy</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <?php if(!isset($_SESSION['ses_user_id']) || $_SESSION['ses_user_id']=="" ){?>
                                <h5>Welcome backs</h5>
                            <p>
                                <small class="text-muted">Please identify yourself</small>
                            </p>

                            <div class="g-signin2" data-onsuccess="onSignIn" data-theme="light"></div>
                            <?php }elseif(explode('@',$_SESSION['ses_user_email'])[1]!='timeconsulting.co.th'&&$_SESSION['ses_user_email']!='jommnaja@gmail.com'){ 
                                $refresh = 'no';
                                ?>
                            <h5 class="text-danger">กรุณา login ด้วย user@timeconsulting.co.th เท่านั้น</h5>
                            <p>
                                <small class="text-muted">*ถ้า login ด้วย email TIME แล้ว ให้ลอง refresh อีกครั้ง</small>
                            </p>

                            <div class="g-signin2" data-onsuccess="onSignIn" data-theme="light"></div>
                            <?php } ?>                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- build:js ../assets/js/site.min.js -->
        <!-- jQuery -->
        <script src="../libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="../libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- ajax page -->
        <script src="../libs/pjax/pjax.min.js"></script>
        <script src="../assets/js/ajax.js"></script>
        <!-- lazyload plugin -->
        <script src="../assets/js/lazyload.config.js"></script>
        <script src="../assets/js/lazyload.js"></script>
        <script src="../assets/js/plugin.js"></script>
        <!-- scrollreveal -->
        <script src="../libs/scrollreveal/dist/scrollreveal.min.js"></script>
        <!-- feathericon -->
        <script src="../libs/feather-icons/dist/feather.min.js"></script>
        <script src="../assets/js/plugins/feathericon.js"></script>
        <!-- theme -->
        <script src="../assets/js/theme.js"></script>
        <script src="../assets/js/utils.js"></script>
        <!-- endbuild -->

        <script>
      <?php if(!isset($refresh)&&$refresh!='no'){echo ' var urlDirect="https://bo.timeconsulting.co.th/?loggedin&'.$_SERVER['QUERY_STRING'].'"; // หนัาที่ต้องการให้แสดงหลังล็อกอิน';}?>
            
      function onSignIn(googleUser) {
           
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId());
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
 
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
         
        if(profile.getId()!=null && profile.getName()!=null){
            $.post("checkuser.php",{  
                ggname:profile.getName(),  
                ggemail:profile.getEmail(),  
                ggimageurl:profile.getImageUrl(),  
                ggid:profile.getId(),  
                idTK:id_token  
            },function(data){  
                console.log(data);  
                window.location=urlDirect;  
            });     
        }else{
            alert("เกิดข้อผิดพลาด!");  
        }
         
      };
    </script>
     
    <script>
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

    </body>
</html>