<?php
session_start();
require_once '../libs/php/auth.php';
require_once '../libs/php/bs_gui.php';
require_once '../user/user.php';
$auth=new auth();
$gui=new gui();
$u=new user();

if(isset($_POST)){
    $p=$auth->sanitize_array($_POST);
    $gui->form_script();
    if(isset($p["t"])){
        if($p["t"]=="lg"){
            $d=$auth->login($p["email"],$p["pwd"]);
            echo $d;    
            if($d===true){
                $u->dialog("check", "Login Successful, you are being redirected", "green", 4, 4);
                ?>
                <script>window.location.href="../user/";</script>
                <?php
            }else if($d=="disabled"){
                $u->dialog("x", "Your account is not active, please contact your system administrator for assistance", "red",4,4);
            }
            else{
                $u->dialog("x", "Wrong Email Address or Password", "red",4,4);
            }
            $u->loginScreen();
        }
    }
    
}
