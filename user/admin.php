<?php
class NTAdmin extends user{
    function addUser(){
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Add User</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                                $this->input("t", null, 12, "hidden", "adu", "style='display:none'");
                                $this->input("name", "Full name", 12);
                                $this->input("email", "Email Address", 6, "email");
                                $this->input("phone", "Phone Number", 6);
                                $this->select("roley", "Role", [
                                    ["admin", "Admin"],
                                    ["instructor", "Instructor"]
                                ], 6, false);
                            ?>
                            <div class="col-12">
                                    <br />
                                    <button class="btn btn-windows btn-block" type="submit">Add User</button>
                                    <br />
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    function saveUser($d){
        $d=$this->ins_to_db("users",["name","email","role","pwd","device_id","course","regno"],[$d["name"],$d["email"],$d["roley"],password_hash("Tanzania",PASSWORD_BCRYPT),"ss","cc","cc"]);
    }
    function showUsers(){
        ?>
        <?php
    }
    function getUsers(){
        return $this->select_tbl("users",["name","email","role","status","id"],null);
    }
}