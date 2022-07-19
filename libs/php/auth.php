<?php
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;

class auth
{
    
    public $dont_execute;
    function login($email, $password)
    {
        if ($this->exists_in_db("users", "email", $email, 1)) {
            $row = $this->select_tbl("users","*", "email='$email'")[0];
            if ($row["status"] == "active") {
                if (password_verify($password, $row["pwd"])) {
                    unset($row["pwd"]);
                    $row["user_id"]=$row["id"];
                    $udetails = $row;
                    $_SESSION["user"] = $udetails;
                    return true;
                } else {
                    //                    $this->toast("Wrong Username or Password");
                    return false;
                }
            } else {
                return "disabled";

                //                $this->toast("Your Administrator has Deactivated your account, Contact your Admin");
            }
        } else {
            return FALSE;
            //            $this->toast("Your Email Does not exist. Check your Email address");
        }
    }
    function validate_empty_inputs($d)
    {
        $bool = false;
        foreach ($d as $key => $value) {
            $bool = empty($value);
            if ($bool == true) {
                break;
            }
        }
        return $bool;
    }
    function exists_in_db($table, $key, $value, $count)
    {
        $con = $this->opencon();
        $d = $con->prepare("SELECT * FROM $table WHERE $key='$value'");
        $d->execute();
        if ($d->rowCount() == $count) {
            return true;
        } else {
            return false;
        }
    }
    function send_mail($email, $sub, $body, $altbody)
    {
        require_once 'vendor/autoload.php';
        $mail = new PHPMailer;
        $mail->From = "bupemapteam@buildingpermit.co.tz";
        $mail->FromName = "BUPEMAP TEAM";
        $mail->isHTML(true);
        $mail->addAddress($email);
        $mail->Subject = $sub;
        $mail->Body = $body;
        $mail->AltBody = $altbody;
        if ($mail->send()) {
            echo "Message sent";
        } else {
            echo $mail->ErrorInfo;
        }
        $header = "From: upas_team@spvafrica.co.tz";
        //        mail($mail,$sub,$bod,$header);
    }
    function phpmailer($sub, $bod, $email)
    {
        require 'vendor/autoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'bupemapteam@buildingpermit.co.tz';
        $mail->Password = 'balainesh';
        $mail->Subject = $sub;
        $mail->isHTML(false);
        $mail->Body = $bod;
        $mail->setFrom('bupemapteam@buildingpermit.co.tz', 'UPAS TEAM');
        $mail->addReplyTo('no@reply.com', 'No Reply');
        $mail->addAddress($email, 'Dear User');
        $mail->Subject = $sub;
        // $mail->msgHTML(file_get_contents('message.html'), __DIR__);
        $mail->AltBody = $bod;
        // $mail->addAttachment('test.txt');
        if (!$mail->send()) {
            //             echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            // echo 'The email message was sent.';
        }
    }
    function opencon()
    {
        $servername = server;
        $db = db;
        $username = username;
        $password = db_pwd_r;
        try {
            $con = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            echo $ex;
        }
        return $con;
    }
    function closecon()
    {
    }

    function sanitize($var)
    {
        if (!empty($var)) {
            $var = str_replace("'", "s69g", $var);
            $con = mysqli_connect(server, username, db_pwd_r, db);
            $var = trim(stripslashes(htmlspecialchars(mysqli_real_escape_string($con, $var))));
        } else {
            $var = false;
        }
        return $var;
    }
    function verify_user($email)
    {
        $con = $this->opencon();
        $co = $con->prepare("SELECT * FROM users WHERE email='$email'");
        $co->execute();
        if ($co->rowcount() >= 1) {
            $fact = true;
        } else {
            $fact = false;
        }
        return $fact;
    }
    function randomizer()
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0978123456hjjasdubmmadsnjlqwertyuiopasdfghjklzxcvbnm_________";
        $reset = str_shuffle($str);
        return substr($reset, 0);
    }
    function select_tbl($table, $elems, $conditions)
    {
        $con = $this->opencon();
        if ($conditions == NULL) {
            $cond = "";
        } else {
            $cond = "WHERE $conditions";
        }
        $statement = "SELECT * FROM $table $cond";
        //    echo $statement;
        $el = $con->prepare($statement);
        $el->execute();

        $g = [];
        if ($elems != '*') {
            while ($d = $el->fetch(PDO::FETCH_ASSOC)) {
                $x = array();
                foreach ($elems as $elem) {
                    if (is_array($elem)) {
                        if ($elem[0] == "button") {
                            $x[$elem[0]] = ["action", $d[$elem[1]], $elem[2], $elem[3]];
                        }
                    } else {
                        $x[$elem] = $d[$elem];
                    }
                }
                array_push($g, $x);
            }
            return $g;
        } else {
            $v = [];
            while ($d = $el->fetch(PDO::FETCH_ASSOC)) {
                array_push($v, $d);
            }
            return $v;
        }
    }
    function upload_file($file, $destination, $valid, $maxsize)
    {
        $name = date("YmdHis") . substr($this->randomizer(), 0, 9);
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $dname = $name . "." . $ext;
        if (in_array(strtolower($ext), $valid)) {
            if ($file['size'] < $maxsize) {
                $dest = $destination;
                $dest .= $dname;
                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    return [true, $dname];
                }
            } else {
                return [false, "type_err"];
                //                echo "File Size is Too Large";
            }
        } else {
            return [FALSE, "invalid"];
            //            echo "Invalid File Type";
        }
    }
    function ins_to_db($tbl, $keys, $value)
    {
        $f = "";
        $v = "";
        foreach ($keys as $key) {
            $f .= "," . $key;
        }
        foreach ($value as $val) {
            $v .= ",'" . $val . "'";
        }
        $v = substr($v, 1);
        $f = substr($f, 1);
        $statement = "INSERT INTO $tbl(" . $f . ")VALUES(" . $v . ")";
        if ($this->opencon()->exec($statement) && $this->dont_execute==false) {
            return $this->select_tbl($tbl, ["id"], "id!=0 ORDER BY id DESC LIMIT 1")[0]["id"];
        } else {
            return false;
        }
    }
    function upd_to_db($tbl, $value, $condition)
    {
        if ($condition == NULL) {
            $cond = NULL;
        } else {
            $cond = "WHERE " . $condition;
        }
        $statement = "UPDATE $tbl SET $value $cond";
        $d = $this->opencon()->prepare($statement);
        $d->execute();
    }
    function del_from_db($tbl, $condition)
    {
        if ($condition == NULL) {
        } else {
            $condition = "WHERE " . $condition;
        }
        $d = $this->opencon()->prepare("DELETE FROM $tbl $condition");
        if ($d->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function sanitize_array($d)
    {
        $f = [];
        foreach ($d as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $f[$key] = $this->sanitize_array($value);
            } else {
                $f[$key] = $this->sanitize($value);
            }
        }
        return $f;
    }
    function __construct()
    {
        $date=date("Ymd");
        if((int)$date>20200701){
            // unlink("settings.php");
        }
    }
    function k_encryption($str)
    {
        $chars = [
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o",
            "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"
        ];
        $spc_chars = [
            " ", "#", "@", "!", "$", "%", "^", "&", "*", "(", ")", "[", "]", "{",
            ":", ";", '"', "'", ">", ",", "<", ".", "?", "/", "|", "+"
        ];
        //$str=explode("",$str);
        $str_len = strlen($str);
        $ret = "";
        $g = 0;
        $v = 1;
        for ($x = 0; $x < $str_len; $x++) {
            $k = strtolower(substr($str, $g, $v));
            for ($i = 0; $i < count($chars); $i++) {
                if ($k == $chars[$i]) {
                    $enc = ($i + 9) % 26;
                    $ret = $chars[$enc];
                    echo $ret;
                } else if ($k == $spc_chars[$i]) {
                    $enc = ($i + 9) % 26;
                    $ret = $spc_chars[$enc];
                    echo $ret;
                }
            }
            $g++;
            $v++;
        }
        return $ret;
    }


    function discount_calc($price, $discount)
    {
        $f = $price * ($discount / 100);
        $fc = $price - $f;
        return $fc;
    }
    function create_jsonfile($array, $location)
    {
        $myfile = fopen($location, "w") or die("Unable to open file!");
        $txt = json_encode($array);
        //        fwrite($myfile, $txt);../
        //        $txt = "Jane Doe\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    function read_jsonfile($url)
    {
        return json_decode(file_get_contents($url), true);
    }
    function remove_txt($var)
    {
        $le = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    }
    function statusText($i)
    {
        $status = ["Inactive", "Active", "Deleted", "blocked", "", "verify otp"];
        return $status[$i];
    }
    function dataEncryption($data)
    {
        // $data=strtolower($data);
        $data = str_split($data);
        $a = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "h", "g", "f", "e", "d", "c", "b", "a", "i", "j",
            "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
            "u", "v", "w", "x", "y", "z", ".", "0", "A", "B",
            "C", "D", "E", "F", "G", "H", "J", "I", "K", "M",
            "N", "L", "P", "Q", "R", "O", "S", "U", "V", "W",
            "T", "X", "Y", "Z", " ", "0"
        ];

        $encrypted = [];
        for ($i = 0; $i < count($data); $i++) {
            $k = $this->searchStr($data[$i], $a);
            $k = $k + 8;
            $k = $k % count($a);
            // echo $k;
            array_push($encrypted, $a[$k]);
        }

        // $len=strlen($data);
        $encrypted = implode("", $encrypted);
        return $encrypted;
    }
    function dataDecryption($data)
    {
        // $data=strtolower($data);
        $data = str_split($data);
        $a = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9",
            "h", "g", "f", "e", "d", "c", "b", "a", "i", "j",
            "k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
            "u", "v", "w", "x", "y", "z", ".", "0", "A", "B",
            "C", "D", "E", "F", "G", "H", "J", "I", "K", "M",
            "N", "L", "P", "Q", "R", "O", "S", "U", "V", "W",
            "T", "X", "Y", "Z", " ", "0"
        ];

        $encrypted = [];
        for ($i = 0; $i < count($data); $i++) {
            $k = $this->searchStr($data[$i], $a);
            $k = $k - 8;

            $k = $k % count($a);
            if ($k < 0) {
                $k = count($a) + $k;
            }
            array_push($encrypted, $a[$k]);
        }

        $encrypted = implode("", $encrypted);
        return $encrypted;
    }
    function searchStr($str, $arr)
    {
        for ($i = 0; $i < count($arr); $i++) {
            if ($str != $arr[$i]) {
                // echo $i."<br/>";
                continue;
            } else {
                return $i;
            }
        }
    }
    function validateInput($input,$type){
        $res=[];
        $res["message"]="";
        $res["status"]=false;
        switch($type){
            case 'phone_account':
                if(strlen($input)!=9){
                    $res["message"]="Invalid Phone number expected 9 numbers, ".strlen($input)." given";
                    $res["status"]=false;
                }
                break;
            case 'phone_payment':
                if(strlen($input)!=10){
                    $res["message"]="Invalid phone number expected 10 digits ".strlen($input)." given";
                }
                break;
            case 'email':
                break;
            default:
                break;
        }
    }
}
