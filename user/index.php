<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION["user"])){
    
require_once '../libs/php/auth.php';
require_once '../libs/php/bs_gui.php';

require_once 'user.php';
require_once 'admin.php';
require_once 'Instructors.php';
require_once 'notifications.php';
require_once 'courses.php';
require_once 'student.php';
require_once 'subjects.php';
require_once 'panels.php';
$auth=new auth();
$gui=new gui();
$use=new user();
$d=$use->menus();
$p=new Panels();
}
else{
    header("location:../home/");
}
?>
<html lang="en" class="material-style layout-fixed">

<head>
    <title>BUPEMAP</title>

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
    <link rel="stylesheet" href="../libs/vendors/datatables.net-dt/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../libs/assets/libs/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../libs/gijgo-combined-1.9.13/css/gijgo.min.css"/>
    <link rel="stylesheet" href="../libs/box/bootstrap-lightbox.min.css"/>
    <link rel="stylesheet" href="../libs/custom/main.css"/>
    <script src="../libs/jquery/jquery-3.3.1.min.js"></script>
    <script src="../libs/gijgo-combined-1.9.13/js/gijgo.min.js"></script>
    <script src="../libs/box/bootstrap-lightbox.js"></script>
    <script src="../libs/assets/js/pace.js"></script>
    
    
    <script src="../libs/assets/libs/popper/popper.js"></script>
    <script src="../libs/assets/js/bootstrap.js"></script>
    <script src="../libs/assets/js/sidenav.js"></script>
    <script src="../libs/assets/js/layout-helpers.js"></script>
    <script src="../libs/assets/js/material-ripple.js"></script>
    <script src="../libs/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../libs/datepicker/pikaday.js"></script>
    <!-- <script src="../libs/vendors/datatables.net/js/jquery.dataTables.min.js"></script> -->
    <script src="../libs/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../libs/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../libs/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="../libs/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../libs/vendors/jszip/dist/jszip.min.js"></script>
    <script src="../libs/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../libs/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="../libs/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../libs/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../libs/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <!-- Libs -->
    <script src="../libs/assets/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../libs/qrcode/js/jquery.classyqr.js"></script>
    <script src="../libs/assets/libs/eve/eve.js"></script>
    <script src="../libs/vendors/select2/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous"></script>
    <!-- Demo -->
    <script type="text/javascript" src="../libs/files_js/jfile.js"></script>
    <script src="../libs/assets/js/demo.js"></script><script src="../libs/assets/js/analytics.js"></script>
    <script type="text/javascript" src="../libs/assets/js/mod.js"></script>
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
        .buttons-html5,.buttons-print{
            background-color: #CA5010;
        }
        .buttons-html5,.buttons-print span{
            color:white;
        }
        .btn-outline-light:active, .btn-outline-light.active, .show > .btn-outline-light.dropdown-toggle {
            background: black;
            color:white;
        }
        .buttons-html5:hover,.buttons-print:hover{
            background-color: #000;
            color: white;
        }
        .data_filter{
            float:right;
        }
    </style>
    <!--<link rel="stylesheet" href="assets/libs/flot/flot.css">-->
</head>

<body id="bady">
    <?php 
    // $gui->loader();
    ?>
    <div id="modal"></div>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->
    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <!-- [ Layout sidenav ] Start -->
            <div id="layout-sidenav" class="layout-sidenav sidenav-dark sidenav sidenav-vertical bg-white logo-dark">
                <!-- Brand demo (see assets/css/demo/demo.css) -->
                <div class="app-brand demo">
                    <span class="app-brand-logo demo">
                        <!-- <img src="../libs/img/coat.png" alt="Brand Logo" class="img-fluid"> -->
                        <i class="feather sidenav-icon  icon-user"></i>
                    </span>
                    <a href="#" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Notification Manager</a>
                    <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
                        <i class="ion ion-md-menu align-middle"></i>
                    </a>
                </div>
                <div class="sidenav-divider mt-0"></div>

                <!-- Links -->
                <ul class="sidenav-inner py-1">

                    <!-- Dashboards -->
                
                    <!-- Layouts -->
                    <li class="sidenav-divider mb-1"></li>
                    <?php
                    foreach($d as $a){
                       ?>
                    <li onclick="loadToDiv('menu','<?php echo $a[2] ?>','applet')" class="sidenav-item">
                        <a href="#!" class="sidenav-link">
                            <i class="sidenav-icon feather icon-<?php echo $a[1]?>"></i>
                            <div><?php echo $a[0]?></div>
                        </a>
                    </li>
                       <?php 
                    }
                    ?>
                </ul>
            </div>
            <div id="dashbd" class="layout-container">
                    <a href="index.html" class="navbar-brand app-brand demo d-lg-none py-0 mr-4">
                        <span class="app-brand-logo demo">
                            <img src="../libs/img/coat.png" alt="Brand Logo" class="img-fluid">
                        </span>
                        <span class="app-brand-text demo font-weight-normal ml-2">Welcome to Notification Information Management System</span>
                    </a>

                    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
                        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:">
                            <i class="ion ion-md-menu text-large align-middle"></i>
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
                        <hr class="d-lg-none w-100 my-2">

                        <div class="navbar-nav align-items-lg-center">
                        </div>
                    </div>
                </nav>

                <div class="layout-content">
                    <div  id="applet" class="container-fluid flex-grow-1 container-p-y">                        
                           <?php  
                           $p->Panelify();
                                   ?>
                        </div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    
    <?php 
    $gui->form_script('../user/engine.php');
    ?>
</body>

</html>
