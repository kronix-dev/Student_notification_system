<?php
class AdminController extends auth{
    public $roles,$v,$forms;
    function __construct($d=[])
    {
        $this->v=$this->sanitize_array($d);
        $this->roles=$this->read_jsonfile("config.json")["roles"];
    }
    function getRole($init){
        $b=0;
        for($i=0;$i<count($this->roles);$i++){
            if($init==$this->roles[$i]["init"]){
                $b=$i;
                break;
            }
        }
        return $this->roles[$b];
    }
    function getUser($u,$view="all"){
        $t=$this->select_tbl("users","*","id='$u'");
        if($view!="all"){
            return $t[0];
        }
        else if($view=="name"){
            return $t[0]["name"];
        }
        else{
            return $t[0]["name"]." (".$t[0]["role"].")";
        }
    }
    
}