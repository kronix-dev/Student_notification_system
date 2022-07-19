<?php
class settings extends auth{
    function preview_profile($user){
        $gui=new gui();
        $gui->form_script("app");
        ?>
<div id="modal1" class="modal">
    <form class="glass_form">
        <div class="modal-content">
            <input type="hidden" name="tracker" value="upd_pwd"/>
            <h4 class="modal-title"><i class="material-icons prefix big red-text">lock</i>&nbsp;&nbsp;Change Password</h4>
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="cpwd" type="password" name="cpwd" required class="validate">
                <label for="cped">Current Password</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="npwd" type="password" name="npwd" required class="validate">
                <label for="npwd">New Password</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="cnpwd" type="password" name="cnpwd" required class="validate">
                <label for="cnpwd">Confirm Password</label>
            </div>
        </div>
        <div class="modal-footer">
            <button id="load_mp_p" class="waves-effect waves-green blue white-text btn-flat">Change Password</button>&nbsp;&nbsp;
            <button type="reset" class="modal-close waves-effect green white-text waves-green btn-flat">Close</button>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-6 offset-3">
        <div class="card">
            <div class="card-body grey lighten-3">
                <center>
                    <h4><?php echo $user["name"] ?></h4>
                </center>
            </div>
            <div class="card-body grey lighten-4">
                <center>
                    <h6>Phone : <?php echo $user["phone"] ?></h6>
                    <h6>Email : <?php echo $user["email"] ?></h6>
                    <h6>Registration Number : <?php echo $user["reg"] ?></h6>
                    <a class="btn blue waves-effect modal-trigger" href="#modal1">Change Password</a>
                </center>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.modal').modal();
    });
</script>
            <?php
    }
    function change_pwd($pwd,$npwd,$cpwd,$uid,$user){
        $gui=new gui();
        $s= $this->select_tbl("users", ["pwd"], "id='$uid'");
        $c=$s[0]["pwd"];
        if(password_verify($pwd, $c)){
            if($npwd==$cpwd){
                $hash= password_hash($cpwd, PASSWORD_BCRYPT);
                $this->upd_to_db("users", "pwd='$hash'", "id='$uid'");
                $gui->toast("<i class='material-icons'>lock</i>&nbsp;your Password has been Updated");
            }
            else{
                $gui->toast("<i class='material-icons'>lock</i>&nbsp;Passwords did not match");
            }
        }
        else{
            $gui->toast("<i class='material-icons'>lock</i>&nbsp;Incorrect Current Password");
        }
        $this->preview_profile($user);
    }
}