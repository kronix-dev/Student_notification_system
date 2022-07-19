<?php
class BPCore extends auth{
    function getLocality($t="region",$id=null){
        if($t=="region"){
            $d=$this->select_tbl("region","*",null);
        }
        else{
            if($id==null){
                $d=$this->select_tbl("halmashauri","*",null);
            }
            else{
                $d=$this->select_tbl("halmashauri","*","rid='$id'");
                foreach($d as $a){
                    ?>
                    <option value="<?php echo $a["id"]?>"><?php echo $a["name"] ?></option>
                    <?php
                }
            }
        }
        return $d;
    }
}