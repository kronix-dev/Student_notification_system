<?php
function cleaninput($val){
    $san= uhusiano();
    return mysqli_real_escape_string($san,trim(stripslashes(htmlspecialchars($val))));
}
function uhusiano(){
    $san= mysqli_connect("localhost", "u921889602_admix", "balainesh", "u921889602_perm");
    return $san;
}
function formatSizeUnits($bytes){
        if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024){
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1){
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1){
            $bytes = $bytes . ' byte';
        }
        else{
            $bytes = '0 bytes';
        }
        return $bytes;
}
function deabbreviate($name){
    if($name=="dlo"){
        $val="District Land Officer";
    }
    else if($name=="dtp"){
        $val="District Town Planner";
    }
    else if($name=="dheo"){
        $val="District Health & Environment Officer";
    }
    else if($name=="dls"){
        $val="District Land Surveyer";
    }
    else if($name=="de"){
        $val="District Engineer";
    }
    else if($name=="chairman"){
        $val="Chairman";
    }
    else{
        $val="System";
    }
    return $val;
}
function pdocon(){
        $servername="localhost";
        $db="u921889602_perm";
        $usernamex="u921889602_admix";
        $passwordx="balainesh";
        try{
            $con = new PDO("mysql:host=$servername;dbname=$db",$usernamex,$passwordx);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (Exception $ex) {
         echo $ex;
        }
        return $con;
}
function police($uname,$type){
    $xel= pdocon()->prepare("SELECT * FROM users WHERE email='$uname' AND role='$type'");
    $xel->execute();
    $cou=$xel->rowCount();
    if($cou>0){
        
    }
    else{
        header("location:../libs/php/logout.php");
    }
}
function verify_user($uname,$type){
    $xel= pdocon()->prepare("SELECT * FROM users WHERE email='$uname' AND role='$type'");
    $xel->execute();
    $cou=$xel->rowCount();
    if($cou>0){
        return true;
    }
    else{
        return false;
    }
}
function nospaces($str){
    return str_replace(" ", "_", $str);
}
function success_dialog($string){
?>
            <center><div class="por-por"><img src="http://localhost/ecms/members/libs/img/done_2.gif" class="porpo"/></div></center>
            <br/>
            <p><?php echo $string ?></p>
            <center><button class="btn btn-danger" onclick='hidedialog()'>Close</button></center>
<?php
}
function error_dialog($string){
?>
            <center><div class="por-port"><img src="http://localhost/ecms/members/libs/img/close.png" class="porpot"/></div></center>
            <br/>
            <p style="color: red; font-weight: bolder;"><?php echo $string ?></p>
            <center><button class="btn btn-danger" onclick='hidedialog()'>Close</button></center>
<?php
}
function abbreviate($name){
    $cc= explode(" ", $name);
    $d="";
    foreach($cc as $c){
        $d.= substr($c, 0,1);
    }
    return strtoupper($d);
}
function notify_user($msg,$contacts,$cid,$t){
    require_once 'sms.php';
    $c=new SmsController();
    $con= pdocon();
    $cp=$con->prepare("SELECT * FROM halmashauri WHERE id='$cid'");
    $cp->execute();
    $fe=$cp->fetch(PDO::FETCH_ASSOC);
    $ofice_sms=$fe['o_sms_n'];
    $ofice_email=$fe['o_email_n'];
    $client_sms=$fe['sms_n'];
    $client_email=$fe['email_n'];
    if($t=="user"){
        if($ofice_email=="yes"){
            $email="yes";
        }
        if($ofice_sms=="yes"){
            $sms="yes";
        }
    }
    if($t=="client"){
        if($client_email=="yes"){
            $email="yes";
        }
        if($client_sms=="yes"){
            $sms="yes";
        }
    }
    if($email=="yes"){
        if($contacts[0]!=NULL){
            mail($contacts[0],$msg[0],$msg[1],"From: info@buildingpermit.co.tz");
        }
    }
    if($sms=="yes"){
//        echo "sms sent";
        $number= str_replace("+","",str_replace(" ", "", $msg[1]));
        if($number!=12){
            $number="255".(int)$number;
        }
        $c->Sender("dstr.connectbind.com", "ramt-adotech", "Tutasong", "SPV.AFRICA", $msg[1], $number, "0", "1");
        $c->Submit();
    }
}
function checkbox($str){
    if($str=="yes"){
        return "checked";
    }
    else{
        return NULL;
    }
}
function return_type($df){
    $sel= pdocon()->prepare("SELECT * FROM type WHERE id='$df'");
    $sel->execute();
    $d=$sel->fetch(PDO::FETCH_ASSOC);
    return $d['name'];
}
function checkbox_inv($str){
    if($str=="yes"){
        return "yes";
    }
    else{
        return "no";
    }
}
function randomizer(){
    $str="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0978123456hjjasdubmmadsnjlqwertyuiopasdfghjklzxcvbnm________ _";
    $reset= str_shuffle($password.$str);
    return substr($reset,0);
}
function status_color($status){
    $d="black";
    if($status=="denied"){
        $d="red";
    }
    if($status=="approved"){
        $d="green";
    }
    return $d;
}