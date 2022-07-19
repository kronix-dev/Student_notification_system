<?php 
class FormBuilder extends auth{
    function formdisplay($i){
        $gui=new gui();
        // $gui->form_script("app");
        $m=$this->select_tbl("form","*","id='$i'")[0];
        $form=$this->read_jsonfile($m["location"]);
        ?>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header blue white-text">HUSIS Quick Form</div>
                    <div class="card-body">
                        <form class="glass_form">
                            <h5><?php echo $m["name"]?></h5>
                            <?php
                            $gui->tinput("sdas","title","Title Eg. Company Name/Council Name/Region Name  ","required","edit","text");
                            ?>
                            <input type="hidden" name="tracker" value="glass_quick"/>
                            <input type="hidden" name="fid" value="<?php echo $i ?>"/>
                            <br/><br/>
                            <?php 
                            foreach($form["components"] as $a){
                                $inni=[];
                                echo "<p>".$a["title"]."</p>";
                                if($a["type"]=="table"){
                                    $options=[];
                                    for($i=0;$i<count($a["inputs"]);$i++){
                                        array_push($options,[$a["inputs"][$i]["name"],$a["inputs"][$i]["type"]]);
                                    }
                                    $gui->double_input("gl".uniqid(),$options,$a["holders"],true,$a["autosum"],"c43");
                                }
                                elseif($a["type"]=="field"){
                                    $gui->tinput("uisa".uniqid(),$a["inputName"],$a["name"],"required","edit",$a["values"]);
                                }
                                elseif($a["type"]=="select"){
                                    $ax=[];
                                    foreach($a["values"] as $v){
                                        array_push($ax,[$v,$v]);
                                    }
                                    $gui->select_input_b($a["inputName"],$a["name"],$ax,"required","liu-".uniqid());
                                }
                            }
                            ?>
                            <input type="submit" value="Save" class="btn blue"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    function createForm(){
        $gui=new gui();
        $gui->form_script("app");
        $select=[
            ["region","Regional Officers"],
            ["council","Planning Authority (Councils)"],
            ["company","Companies"]
        ];
        ?>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header blue white-text">Create A Form</div>
                    <div class="card-body">
                        <form class="glass_form">
                            <input type="hidden" value="adfm" name="tracker"/>
                            <?php 
                            $gui->tinput("n","name","Form Name","required","edit","text");
                            $gui->select_input_b("user","Choose User Group",$select,"required","sel");
                            ?>
                            
                            <input type="submit" class="btn blue"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->formList();
    }
    function addQuestion($fid){
        $gui=new gui();
        $select=[
            ["field","Text/Number Input"],
            ["table","Table Filling"],
            ["select","Choosing from a list"]
        ];
        $gui->form_script("app");
        ?>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header blue white-text">Create Question field</div>
                    <div class="card-body">
                        <form class="glass_form">
                            <input type="hidden" value="<?php echo $fid ?>" name="form_id"/>
                            <input type="hidden" value="addqn" name="tracker"/>
                            <?php 
                                $gui->select_input_b("type","Question Type",$select,"required","se");
                            ?>
                            <input type="submit" class="btn blue" value="Next"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->formdisplay($fid);

    }
    function formQuery($d){
        $x=$d["form_id"];
        if($d["type"]=="select"){
            $this->createSelect($x);
        }
        elseif($d["type"]=="field"){
            $this->createInput($x);
        }
        elseif($d["type"]=="table"){
            $this->createTable($x);
        }
    }  
    function createSelect($d){
        $gui=new gui();
        $gui->form_script("app");
        ?>
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-header blue white-text"></div>
                        <div class="card-body">
                            <form class="glass_form">
                                <input type="hidden" name="tracker" value="createselect"/>
                                <input type="hidden" name="form_id" value="<?php echo $d?>"/>
                                <textarea name="desc" row="5" placeholder="Description" required></textarea>
                                <?php 
                                    $gui->tinput("id","name","Field name","required","edit","text");
                                    $gui->tinput("id","tvalues","Values (Comma separated)","required","edit","text");
                                ?>
                                <input type="submit" value="Add Question" class="btn blue"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
    function createTable($d){
        $gui=new gui();
        $options=[
            ["id"=>"number","name"=>"number"],
            ["id"=>"text","name"=>"text"]
        ];
        $options2=[
            ["id"=>"yes","name"=>"yes"],
            ["id"=>"no","name"=>"no"]
        ];
        $inputs=[
            ["name","text"],
            ["type","select",$options],
            ["autosum","select",$options2]
        ];
        $holders=[
            "Column Name","Field type","Auto Sum"
        ];
        $gui->form_script("app");
        ?>
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="card">
                        <div class="card-header blue white-text">Create a Table Input</div>
                        <div class="card-body">
                            <form class="glass_form">
                                <input type="hidden" name="tracker" value="createTable"/>
                                <input type="hidden" name="form_id" value="<?php echo $d?>"/>
                                <textarea name="desc" row="5" placeholder="Description" required></textarea>
                                <br/>
                            <?php
                                $gui->double_input("dbl",$inputs,$holders,true,false,"x");
                            ?>
                            <p>
                                <label>
                                    <input type="checkbox" checked name="autosum" value="1"/>
                                    <span>Auto Sum Numerical fields</span>
                                </label>
                            </p>
                            <input type="submit" value="Save" class="btn blue"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
    function createInput($d){
        $gui=new gui();
        $select=[
            ["text","Text"],
            ["number","Number"]
        ];
        $gui->form_script("app");
        ?>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body">
                        <form class="glass_form">
                            <input type="hidden" name="tracker" value="createInput"/>
                            <input type="hidden" name="form_id" value="<?php echo $d?>"/>
                            <textarea name="desc" row="5" placeholder="Description" required></textarea>
                            <?php 
                                $gui->tinput("na","name","Field Name","required","edit","text");
                                $gui->select_input_b("input_type","Input type",$select,"required","idol");
                            ?>
                            <input type="submit" value="Save" class="btn blue"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    function saveSelect($d){
        $form_id=$d["form_id"];
        $a=$this->select_tbl("form","*","id='$form_id'");
        $component=[];
        $component["type"]="select";
        $component["name"]=$d["name"];
        $component["title"]=$d["desc"];
        $component["inputName"]="sel-".date("YmddHis");
        $component["values"]=explode(",",$d["tvalues"]);
        $form=$this->read_jsonfile($a[0]["location"]);
        array_push($form["components"],$component);
        $this->create_jsonfile($form,$a[0]["location"]);
        $this->addQuestion($form_id);
    }
    function saveInput($d){
        $form_id=$d["form_id"];
        $a=$this->select_tbl("form","*","id='$form_id'");
        $component=[];
        $component["type"]="field";
        $component["name"]=$d["name"];
        $component["title"]=$d["desc"];
        $component["inputName"]="inp_".date("YmddHis");
        $component["values"]=$d["input_type"];
        $form=$this->read_jsonfile($a[0]["location"]);
        array_push($form["components"],$component);
        $this->create_jsonfile($form,$a[0]["location"]);
        $this->addQuestion($form_id);
    }
    function saveTable($d){
        $form_id=$d["form_id"];
        $a=$this->select_tbl("form","*","id='$form_id'");
        $inputs=[];
        for($i=0;$i<count($d["name"]);$i++){
            $imm=[];
            $imm["holder_name"]=$d["name"][$i];
            $imm["type"]=$d["type"][$i];
            // $imm["autosum"]=$d["autosum"][$i];
            $imm["name"]="inp_".uniqid();
            array_push($inputs,$imm);
        }
        $component=[];
        $component["type"]="table";
        $component["name"]=$d["name"];
        $component["holders"]=$d["name"];
        $component["types"]=$d["type"];
        $component["title"]=$d["desc"];
        $component["inputs"]=$inputs;
        $component["values"]=$d["type"];
        $v=false;
        if(isset($d["autosum"]) && $d["autosum"]=="1"){
            $v=true;
        }
        $component["autosum"]=$v;
        $form=$this->read_jsonfile($a[0]["location"]);
        array_push($form["components"],$component);
        $this->create_jsonfile($form,$a[0]["location"]);
        $this->addQuestion($form_id);
    }
    function saveForm($d){
        $form=[];
        $form["name"]=$d["name"];
        $form["userGroup"]=$d["user"];
        $form["components"]=[];
        $form["id"]=date("YmdHis");
        $loc="forms/".$form["id"].".json";
        $this->create_jsonfile($form,$loc);
        $x=$this->ins_to_db("form",["name","grouping","fid","location"],[$d["name"],$d["user"],$form["id"],$loc]);
        $this->addQuestion($x);
    }
    function formList(){
        $d=$this->select_tbl("form");
        ?>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header blue white-text">All Forms</div>
                    <div class="card-body">
                        <ul class="collapsible">
                            <?php
                                foreach($d as $a){
                                    $ddid=$a["id"];
                                    ?>
                                    <li>
                                        <div class="collapsible-header"><?php echo strtoupper($a["name"]) ?></div>
                                        <div class="collapsible-body">
                                        <a class="btn blue" onclick="loadToDiv('loadForm','<?php echo $a["id"] ?>','app')" href="#">View This Form</a>
                                            <a class="btn red" onclick="loadToDiv('delForm','<?php echo $a["id"] ?>','app')" href="#">Delete This Form</a><br/><br/><br/>
                                            <ol>
                                                <?php
                                                $dxc=$this->select_tbl("form_answers","*","form_id='$ddid'");
                                                foreach($dxc as $ac){
                                                    ?>
                                                    <li><p class="blue-text" onclick="loadToDiv('viewAnswer','<?php echo $ac["id"]?>','app')"><?php echo $ac["title"] ?></p></li>
                                                    <?php
                                                }
                                                ?>
                                            </ol>
                                        </div>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>
                        <table class="table table-bordered">
                            <tr>
                                <th>Form Name</th>
                                <th>Action</th>
                            </tr>
                            <?php 
                                foreach($d as $a){
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <script>
            $(document).ready(function(){
                $('.collapsible').collapsible();
            });
        </script>
        <?php
    }
    function viewFormSelf($i){
        $gui=new gui();
        $gui->form_script("app");
        $this->formdisplay($i);
    }
    function getForm($id){
        $d=$this->select_tbl("form","*","id='$id'");
        return $this->read_jsonfile($d[0]["location"]);
    }
}
?>
