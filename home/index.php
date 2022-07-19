<!DOCTYPE html>
<?php
session_start();
//$_SESSION["client"]=[];
require_once '../libs/php/auth.php';
require_once '../libs/php/bs_gui.php';
require_once '../user/user.php';

$auth=new auth();
$gui=new gui();
$use=new user();
$d=$use->menus();
?>
<html lang="en" class="material-style layout-fixed">

<head>
    <title>SCHEDULING NOTIFICATION SYSTEM</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Empire Bootstrap admin template made using Bootstrap 4, it has tons of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="Empire, bootstrap admin template, bootstrap admin panel, bootstrap 4 admin template, admin template">
    <meta name="author" content="Srthemesvilla" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- Icon fonts -->
    
    <link rel="stylesheet" href="../libs/datepicker/css/pikaday.css"/>
    <link rel="stylesheet" href="../libs/datepicker/css/site.css"/>
    <link rel="stylesheet" href="../libs/assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="../libs/assets/fonts/ionicons.css">
    <link rel="stylesheet" href="../libs/assets/fonts/linearicons.css">
    <link rel="stylesheet" href="../libs/assets/fonts/open-iconic.css">
    <link rel="stylesheet" href="../libs/assets/fonts/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="../libs/assets/fonts/feather.css">
    <!-- Core stylesheets -->
    <link rel="stylesheet" href="../libs/styles/css/animation.css"/>
    <link rel="stylesheet" href="../libs/assets/css/bootstrap-material.css">
    <link rel="stylesheet" href="../libs/assets/css/shreerang-material.css">
    <link rel="stylesheet" href="../libs/assets/css/uikit.css">
    <!-- Libs -->
    <link rel="stylesheet" href="../libs/vendors/select2/css/select2.min.css"/>
    <link rel="stylesheet" href="../libs/files_js/jquery-file-upload.min.css"/>
    <link rel="stylesheet" href="../libs/dt/datatables.min.css">
    <link rel="stylesheet" href="../libs/assets/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../libs/gijgo-combined-1.9.13/css/gijgo.min.css"/>
        <script src="../libs/jquery/jquery-3.3.1.min.js"></script>
 <script src="../libs/gijgo-combined-1.9.13/js/gijgo.min.js"></script>

    <style>
        .app-brand-logo img{
            width: 30px;
            height: 30px;
        }
        .dashd{
            border: 2px dashed #CA5010;
            padding: 10px;
        }
        .card-body{
            overflow-x: auto;
        }
        .ajax-file-upload-filename{
            display: none;
            visibility: hidden;
        }
        .ajax-file-upload-statusbar{
            border: none;
            padding: 0;
            margin: 0;
            background-color:white;
        }
        .ajax-file-upload-progress{
            margin: 0;
            /*border: none;*/
            padding: 0;
            
        }
        .ajax-file-upload-bar{
            background-image: url(assets/img/loader.gif);
            background-position-y: 200px;
        }
        body{
            background-image: url(../libs/img/jpg.jpg);
            background-size: cover;
        }
    </style>
    <!--<link rel="stylesheet" href="assets/libs/flot/flot.css">-->
</head>

<body id="bady">
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <?php 
    // $gui->loader();
    ?>
                    <div  id="applet" class="container-fluid flex-grow-1 container-p-y">                        
                           <?php  
                            $use->loginScreen();
                           ?>
                    </div>
    <script src="../libs/assets/js/pace.js"></script>
    
    
    <script src="../libs/assets/libs/popper/popper.js"></script>
    <script src="../libs/assets/js/bootstrap.js"></script>
    <script src="../libs/assets/js/sidenav.js"></script>
    <script src="../libs/assets/js/layout-helpers.js"></script>
    <script src="../libs/assets/js/material-ripple.js"></script>
    <script src="../libs/datepicker/pikaday.js"></script>
        
    <!-- Libs -->
    <script src="../libs/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../libs/assets/libs/eve/eve.js"></script>
    <script src="../libs/vendors/select2/js/select2.full.min.js"></script>
    <!-- Demo -->
    <script src="../libs/vendors/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript" src="../libs/files_js/jfile.js"></script>
    <script src="../libs/assets/js/demo.js"></script><script src="../libs/assets/js/analytics.js"></script>
    <script type="text/javascript" src="../libs/assets/js/mod.js"></script>
    <?php 
    $gui->form_script('engine.php');
    ?>
</body>

</html>
