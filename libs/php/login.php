<?php
include"con.php";
include"functions.php";
if(isset($_POST['username']) && isset($_POST['password'])){
    $username= cleaninput($_POST['username']);
    $pass= cleaninput($_POST['password']);
    $sel=$con->prepare("SELECT * FROM users WHERE username='$username'");
    $sel->execute();
    $count=$sel->rowcount();
    if($count>0){
        $row=$sel->fetch(PDO::FETCH_ASSOC);
        $hash=$row['pwd'];
        if(password_verify($pass, $hash)){
            if($row['status']=="Inactive"){
                echo "<div class='alert alert-danger'>Your account has been deactivated please contact your Administrator for more information</div>";
            }
            else{
                $udetails=array();
                $role=$row['role'];
                $udetails['user_id']=$row['id'];
                $udetails['email']=$row['email'];
                $udetails['phone']=$row['phone'];
                $udetails['fname']=$row['fname'];
                $udetails['role']=$row['role'];
                $udetails['sign']=$row['sign'];
                $udetails['username']=$row['username'];
                $udetails['council']=$row['council'];
                $_SESSION['udetails']=$udetails;
                if($role=="admin" || $role=="chairman" || $role=="cashier" || $role=="static" || $role=="dict"){
                ?>
                <script type="text/javascript">
                    window.location.href="<?php echo $role?>";
                </script>
                <?php
                }
                else{
                    ?>
                <script type="text/javascript">
                    window.location.href="user";
                </script>
                        <?php
                }
            }
        }
        else{
            echo "<div class='alert alert-danger'>Wrong Username Or Password</div>";
        }
    }
    else{
        echo "<div class='alert alert-danger'>Wrong Username Or Password</div>";
    }
}
else{
    
}