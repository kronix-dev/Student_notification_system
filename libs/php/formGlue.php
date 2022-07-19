<?php
class glue extends FormBuilder{
    function saveFormToDb($d){
        $fid=$d["fid"];
        $loca="form_answers/".uniqid().".json";
        $this->create_jsonfile($d,$loca);
        $this->ins_to_db("form_answers",["form_id","location","uid","title"],[$d["fid"],$loca,$_SESSION["user"]["id"],$d["title"]]);
        $gui=new gui();
        $gui->toast("Form has been submitted successfully");

        // $d=$this->select_tbl("form","*","id='$fid'");
        // $form=$this->read_jsonfile($d[0]["location"]);
        // $ans=[];
        // // $ans["fid"]
        // foreach($form["components"] as $f){
        //     $cv=[];
        //     if($f["type"]=="table"){
        //         for($i=0;$i<count($f["inputs"]);$i++){
        //             $an=[];
        //             // $an[$f["inputs"][$i]["name"]]=;
        //         }
        //     }
        //     else{

        //     }
        // }
    }
    function allForms($role){
        if($role=="rup"){
            $c="region";
        }
        else if($role=="atpo"){
            $c="council";
        }
        else{
            $c="company";
        }
        $d=$this->select_tbl("form","*","grouping='$c'");
        ?>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header blue white-text">All Forms</div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <th></th>
                            </tr>
                            <?php
                                foreach($d as $a){
                                    $id=$a["id"];
                                    ?>
                                    <tr>
                                        <?php
                                            $uid=$_SESSION["user"]["id"];
                                            $xc=$this->select_tbl("form_answers","*","form_id='$id' AND uid='$uid'");
                                            if(count($xc)>0){
                                                ?>
                                                <td class="green lighten-4" onclick="loadToDiv('viewAnswer','<?php echo $xc[0]["id"]?>','app')"><?php echo $a["name"] ?></td>   
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <td class="blue lighten-4" onclick="loadToDiv('viewForm','<?php echo $a["id"] ?>','app')"><?php echo $a["name"] ?></td>
                                                <?php
                                            }
                                        ?>
                                    </tr>
                                    <?php
                                }
                             ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    function displayFormAnswers($i){
        $d=$this->select_tbl("form_answers","*","id='$i'");
        $ans=$this->read_jsonfile($d[0]["location"]);
        $fid=$d[0]["form_id"];
        $form=$this->getForm($fid);
        $gui=new gui();
        ?>
        <div class="row">
            <?php 
                $this->formOrigin($d[0]["uid"]);
            ?>
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header blue white-text">HUSIS Quick Form</div>
                    <div class="card-body">
                        <h5><?php echo $form["name"]?></h5>
                        <br/><br/>
                        <?php 
                        foreach($form["components"] as $a){
                            $inni=[];
                            echo "<p><b>".$a["title"]."</b></p>";
                            if($a["type"]=="table"){
                                $options=[];
                                ?>
                                <table class=" table-responsive table-hover table table-striped">
                                    <tr>
                                        <?php
                                        for($i=0;$i<count($a["inputs"]);$i++){
                                            // array_push($options,[$a["inputs"][$i]["name"],$a["inputs"][$i]["type"]]);
                                            ?>
                                            <th><?php echo $a["inputs"][$i]["holder_name"] ?></th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                    for($i9=0;$i9<count($ans[$a["inputs"][0]["name"]]); $i9++) {
                                        ?>
                                        <tr>
                                            <?php
                                            for($i1=0;$i1<count($a["inputs"]);$i1++){
                                                // array_push($options,[$a["inputs"][$i]["name"],$a["inputs"][$i]["type"]]);
                                                ?>
                                                <td><?php echo $ans[$a["inputs"][$i1]["name"]][$i9] ?></td>
                                                <?php
                                            }
                                                ?>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                                <?php
                            }
                            elseif($a["type"]=="field" || $a["type"]=="select"){
                                ?>
                                <p><?php echo $ans[$a["inputName"]] ?></p>
                                <?php
                            }
    
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    private function formOrigin($uid){
        $gui=new gui();
        $upas=new upas_gui();
        $d=$this->select_tbl("users","*","id='$uid'")[0];
        ?>
        <style>
            td,th{
                border: 1px solid gainsboro;
            }
        </style>
        <div class="col-8 offset-2">
            <div class="card">
                <div class="card-header blue white-text">Sender's Information</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><b>Submitted by</b> </td>
                            <td><?php echo $d["fname"] ?></td>
                        </tr>
                        <?php
                            if($d["role"]=="atpo"){
                            ?>
                            <tr>
                                <td><b>Region</b> </td>
                                <td><?php echo $upas->regionName($d["regid"],"region")?></td>
                            </tr>
                            <tr>
                                <td><b>Planning Authorty</b> </td>
                                <td><?php echo $upas->regionName($d["cid"],"regionas")?></td>
                            </tr>
                            <?php
                            }
                            else if($d["role"]=="rup"){
                            ?>
                            <tr>
                                <td><b>Planning Authorty</b> </td>
                                <td><?php echo $upas->regionName($d["regid"],"region")?></td>
                            </tr>
                            <?php
                            }
                            else{
                                ?>
                                <tr>
                                    <td><b>Company Name</b> </td>
                                    <td><?php echo $upas->regionName($d["rid"],"company")?></td>
                                </tr>
                                <?php
                            }
                        ?>
                        <tr>
                            <td><b>Email Address</b> </td>
                            <td><?php echo $d["email"] ?></td>
                        </tr>
                        <tr>
                            <td><b>Phone Number</b> </td>
                            <td><?php echo $d["phone"] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}