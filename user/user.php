<?php
class user extends auth
{
    var $role;
    var $id;
    public $user;
    function __construct()
    {
        if (isset($_SESSION["user"])) {
            $this->user = $_SESSION["user"];
        }
    }
    function menus($role = null)
    {
        if (isset($_SESSION["user"])) {
            $role = $_SESSION["user"]["role"];
        }
        $d = [
            ["Programme", "document","cus"],
            ["Courses","document","sus"],
            ["Students","user","stu"],
            ["users","users","uss"],
            ["Venue","venue","ven"],
            ["Notifications", "plus-circle", "nfs"],
            ["Sessions","info","ses"],
            ["Venue Requests","info","vr"],
            ["Log out", "log-out", "lgt"],
        ];
        $m = [];
        if ($role == "admin") {
            $m = [0,1,2,3,4,5,6,7,8];
        } elseif ($role == "instructor") {
            $m = [0,5];
        } else {
            $m = [0,5];
        }
        $f = [];
        foreach ($m as $x) {
            array_push($f, $d[$x]);
        }
        return $f;
    }
    function uploadFiles()
    {
        $this->dialog("check", "You have completed step 1 of your building permit request, Complete the following step to Finish the request process", "primary", 12, 88);
?>
        <div class="row">
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div id="fileupl"></div>
                        <script>
                            $(document).ready(function() {
                                $("#fileupl").uploadFile({
                                    url: "engine.php",
                                    fileName: "flies"
                                });
                            });
                        </script>
                        <button class="btn btn-windows" onclick="loadToDiv('done','d','applet')">Send Request</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function getUserInfo($u){
        return $this->select_tbl("users","*","id='$u'")[0];
    }
    function loginScreen()
    {
    ?>
        <div class="row">
            <div class="col-md-4 offset-4">
                <div class="card">
                    <div class="card-header">
                        <center>
                            <h3>Welcome to Schedule Notification System</h3>
                        </center>
                    </div>
                    <div class="card-body">
                        <div>
                            <form class="glass_form">
                                <?php
                                $this->input("t", null, 12, "hidden", "lg", "style='display:none'");
                                ?>
                                <input type="email" class="form-control" required="" placeholder="Email Address" name="email" value=""><br />
                                <input type="password" class="form-control" required="" placeholder="Password" name="pwd" value=""><br />
                                <center>
                                    <button type="submit" value="Sign in" class="btn btn-windows btn-block">Sign In</button>
                                </center>
                            </form>
                        </div>
                        <div class="card-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    function select($name, $placeholder, $values, $size = 4, $t = true, $class = null,$extra = null)
    {
        if ($t == true) {
        ?>
            <div class="col-md-<?php echo $size ?>">
                <label><?php echo $placeholder ?></label>
                <br/>
                <select id="<?php echo $name ?>" name="<?php echo $name ?>" class="form-control <?php echo $class ?>" <?php echo $extra ?>>
                    <option disabled value=""><?php echo $placeholder ?></option>
                    <?php
                    foreach ($values as $v) {
                    ?>
                        <option value="<?php echo $v["id"] ?>"><?php echo $v["name"] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

        <?php
        } else {
        ?>
            <div class="col-md-<?php echo $size ?>">
                <label><?php echo $placeholder ?></label>
                <br/>
                <select name="<?php echo $name ?>" class="form-control <?php echo $class ?>"  <?php echo $extra ?>>
                    <option disabled value=""><?php echo $placeholder ?></option>
                    <?php
                    foreach ($values as $v) {
                    ?>
                        <option value="<?php echo $v[0] ?>"><?php echo $v[1] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        <?php
        }
    }
    function tableTurner($d, $columns, $abval)
    {
        // sort($columns);
        array_push($columns,"action");
        $cols=[];
        foreach($columns as $f){
            $b=[];
            $b["title"]=$f;
            array_push($cols,$b);
        }
        // $d = $this->select_tbl("client_info", "*", null);
        $dataset = [];
        $i = 1;
        $dd=[];
        if(count($d)>0){
            $keys=array_keys($d[0]);
            // sort($keys);
            foreach ($d as $a) {
                $t=[];
                foreach($keys as $z){
                    if($z!="id"){
                        array_push($t,$a[$z]);
                    }
                }
                $n=[
                    $this->actionButton("f".$abval, $a["id"], "<i class='fa fast fa-eye'></i>", "primary"),
                    $this->actionButton($abval, $a["id"], "<i class='fa fast fa-trash'></i>", "primary"),
                ];
                $cx="";
                foreach($n as $a){
                    $cx.=$a;
                }
                array_push($t,$cx);
                array_push($dataset, $t);
                $i++;
            }
        }
        ?>
        <table id="data" class="table table-info r-sc table-hover display dataTable no-footer">
            
        </table>

        <script>
            var dataset = <?php echo json_encode($dataset) ?>;
            $('#data').DataTable({
                dom: 'Bfrtip',
                "bPaginate": true,
                autoWidth: false,
                "info": true,
                "bFilter": true,
                data: dataset,
                columns: <?php echo json_encode($cols) ?>,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "drawCallback": function() {
                    $('.dt-buttons > .btn').addClass('btn-outline-light btn-sm');
                }
            });
            $(document).ready(function() {

            });
        </script>
    <?php
    }
    function getStatus($id)
    {
        $s = $this->select_tbl("statuses", "*", "pid='$id'");

        ?>
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Comments and Action Centre</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        foreach ($s as $a) {
                            $user = $this->getUser($a["uid"]);
                            if ($a["nume"] == "1" || $a["nume"] == "6") {
                        ?>
                                <div class="alert alert-success">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            $this->textC($user["name"], $a["comment"], null, 12);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="alert alert-danger">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            $this->textC($user["name"], $a["comment"], null, 12);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <?php if (isset($_SESSION["udetails"])) { ?>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    if ($this->checkApprovalStatus($_SESSION["udetails"]["user_id"], $id)) {
                                    } else {
                                    ?>
                                        <form class="glass_form">
                                            <h4>Put Your comments here</h4>
                                            <div class="row">
                                                <?php
                                                $this->input("t", null, 12, "hidden", "comment");
                                                $this->input("pid", null, 12, "hidden", $id);
                                                $this->input("comment", "Comments", 12, "textarea");
                                                $this->input("status", "Approve", 2, "radio", "Approved");
                                                $this->input("status", "Deny", 2, "radio", "Denied");
                                                ?>
                                            </div>
                                            <button type="submit" value="Sign in" class="btn btn-windows">Update Status</button>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
    }
    function getActiveUser()
    {
        return $_SESSION["udetails"];
    }
    function getUser($u)
    {
        $d = $this->select_tbl("users", "*", "id='$u'");
        return $d[0];
    }
    function textC($label, $text, $id = null, $size = 4)
    {
        if ($id == null) {
            $id = "o" . uniqid();
        } else if (is_int($id)) {
            $size = $id;
        }
        ?>
            <div class="col-<?php echo $size; ?>">
                <label><?php echo $label ?></label>
                <p id="<?php echo $id ?>"><?php echo $text ?></p>
            </div>
        <?php
    }
    function input($name, $placeholder, $size = "4", $type = "text", $value = null, $extra = "required")
    {
        ?>
            <div class="col-<?php echo $size ?>" <?php if ($extra == "style='display:none'") {
                                                        echo $extra;
                                                    } ?>>
                <?php
                if ($type == "radio") {
                ?>
                    <label><?php echo $placeholder ?></label>
                    &nbsp;&nbsp;&nbsp;
                    <input type="<?php echo $type ?>" name="<?php echo $name ?>" id="<?php echo $name ?>" placeholder="<?php echo $placeholder ?>" value="<?php echo $value ?>" <?php echo $extra ?> />
                    <?php
                } else {
                    if ($type != "hidden") {
                    ?>
                        <label><?php echo $placeholder ?></label>
                    <?php
                    }
                    ?>

                    <input type="<?php echo $type ?>" name="<?php echo $name ?>" id="<?php echo $name ?>" placeholder="<?php echo $placeholder ?>" value="<?php echo $value ?>" <?php echo $extra ?> class="form-control" />
                <?php
                }
                ?>
            </div><?php
                }
                function actionButton($action, $id, $actionname, $color)
                {
                    $btn = '<button class="btn btn-sm btn-' . $color . '" onclick="loadToDiv(\' ' . $action . '\',\'' . $id . '\',\'applet\')">' . $actionname . '</button>';
                    return $btn;
                }
                function textWC($text, $color)
                {
                    return '<font color="' . $color . '">' . $text . '</font>';
                }
                function imageLB($url, $size = 4)
                {
                    ?>
            <div class="col-<?php echo $size  ?>">
                <img src="<?php echo $url ?>" style="width: 100%;height: auto;border-radius: 10" />
            </div>
        <?php
                }
                function remarksLB($id)
                {
        ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Remarks & Comments</div>
                        <div class="card-body">
                            <div>
                                <form class="glass_form">
                                    <?php
                                    $this->input("cidd", null, 12, "hidden", $id, "style='display:none'");
                                    $this->input("t", null, 12, "hidden", "com", "style='display:none'");
                                    $this->input("comment", "Your Comments", 12);
                                    $this->input("choice", "Approve", 6, "radio", "approved", "checked");
                                    $this->input("choice", "Deny", 6, "radio", "denied", "checked");
                                    ?>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-macos">Save & Continue</button>
                                    </div>
                                </form>
                            </div>
                            <?php
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
                }
                function logout()
                {
                    session_destroy()
        ?>
            <script>
                window.location.href = "../home/";
            </script>
        <?php
                }
                function registrationUser()
                {
        ?>
            <div class="row">
                <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-header">
                            <center>
                                <h4>Client Registration</h4>
                            </center>
                        </div>
                        <div class="card-body">
                            <form class="glass_form row">
                                <?php
                                $this->input("t", null, 12, "hidden", "rg", "style='display:none'");
                                $this->input("name", "Full name", 12);
                                $this->input("email", "Email Address", 6, "email");
                                $this->input("phone", "Phone Number", 6);
                                $this->select("employer", "Employer", [
                                    ["gvt", "Government"],
                                    ["pvt", "Private"],
                                    ["fl", "Free Lancer"]
                                ], 6, false);
                                $this->input("temp", "Employer's name (LGA / Company name)");
                                $this->input("rnum", "Registration number", 6);
                                $this->input("dname", "Director's name");
                                $this->input("pwd", "Password", 6, "password");
                                $this->input("cpwd", "Confirm Password", 6, "cpwd");
                                ?>
                                <div class="col-12">
                                    <br />
                                    <button class="btn btn-windows btn-block" type="submit">Sign Up</button>
                                    <br />
                                    <button onclick="loadToDiv('vl','l','applet')" class="btn btn-link btn-block">Already a member? Login here</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        <?php
                }
                function dialog($icon, $text, $color, $size, $offset)
                {
        ?>
            <div class="row">
                <div class="col-<?php echo $size ?> offset-<?php echo $offset ?>">
                    <div class="card card-body mb-2">
                        <div class="row">
                            <div class="col-md-1">
                                <font color="<?php echo $color ?>"><i class="feather icon-<?php echo $icon ?>"></i></font>
                            </div>
                            <div class="col-md-11">
                                <font color="<?php echo $color ?>"><?php echo $text ?></font>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
                }
                function autoCalc()
                {
        ?>
            <script>
                $(function() {
                    $("#parea,#lvr,#site,#fval,#eval,#pval,#mvval,#bval,#trc,#depr").on("keyup", function() {
                        var area = Number($("#parea").val());
                        var rate = Number($("#lvr").val());
                        var c = area * rate;
                        var trc = c + Number($("#site").val()) +
                            Number($("#fval").val()) +
                            Number($("#eval").val()) +
                            Number($("#pval").val()) +
                            Number($("#mvval").val());
                        var tmv = trc * Number($("#depr"));
                        $("#tmval").val(tmv.toFixed(2));
                        $("#lval").val(c.toFixed(2));
                        $("#trc").val(trc.toFixed(2));
                    });
                    $("#area,#roca").on("keyup", function() {
                        var area = Number($("#area").val());
                        var rate = Number($("#roca").val());
                        var c = area * rate;
                        $("#bval").val(c.toFixed(2));
                    });
                });
            </script>
        <?php
                }
                function controlnumber()
                {
        ?>
            <div class="row">
                <div class="col-md-8 offset-2">
                    <div class="card">
                        <div class="card-header">Control Number & Payment Verification</div>
                        <div class="card-body">
                            <p>You have successfully completed the data entry process. Please proceed to pay, by retrieving a control number close to you.</p>
                            <h4>Steps To Follow</h4>
                            <ol>
                                <li>Get a Control number</li>
                                <li>Make payments to the control number</li>
                                <li>Take a screenshot or payslip photo of the GEPG message</li>
                                <li>then <a href="#" onclick="">click here</a> to verify your payments</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        <?php
                }
                function paymentVerify()
                {
        ?>
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-header">Control Number & Payment Verification</div>
                        <div class="card-body">
                            <form class="glass_form row">
                                <?php
                                $this->input("t", null, 12, "hidden", "pvr", "style='display:none'");
                                $this->input("cn", "Control Number", 12);
                                ?>
                                <div class="col-12">
                                    <label for="cnfe">
                                        <input type="file" name="cnf" id="cnfe" style="display:none" />
                                        <div class="btn btn-primary">
                                            <i class="fa fa-file"></i>
                                            Upload Control number or Reciept
                                        </div>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Save & Finish</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
                }
                function reportform()
                {
                    $d = $this->select_tbl("users", ["id", "name"], "role='client'");
                    array_push($d, ["id" => "all", "name" => "All"]);
        ?>
            <div class="row">
                <div class="col-md-8 offset-2">
                    <div class="card">
                        <div class="card-header">Report Portal</div>
                        <div class="card-body">
                            <form class="glass_form">
                                <div class="row">
                                    <?php
                                    $this->input("t", null, 12, "hidden", "rep", "style='display:none'");
                                    $this->input("type", "Day", 4, "radio", "day", "");
                                    $this->input("type", "Month", 4, "radio", "month", "");
                                    $this->input("type", "Year", 4, "radio", "year", "");
                                    echo "<div class='col-12'><hr/></div>";
                                    $this->input("type", "Range", 4, "radio", "range", "");
                                    $this->input("fromd", "Starting Date", 4, "date", "", "");
                                    $this->input("tod", "End Date", 4, "date", "", "d");
                                    echo "<div class='col-12'><hr/><h4>Query Options</h4></div>";

                                    $this->input("which", "Valuer's Name", 6, "radio", "uname", "");
                                    $this->select("uname", "Choose Officer", $d, 6, true, "select2");
                                    echo "<div class='col-12'><br/></div>";
                                    ?>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-macos">Save & Continue</button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <?php
                }
            }
