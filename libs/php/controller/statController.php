<?php

class StatController extends auth{
    public $v;
    function __construct($d){
        $this->v=$this->sanitize_array($d);
    }
    function setStatus(){
        $uid=$this->v["uid"];
        $pid=$this->v["pid"];
        $status=$this->v["status"];
        $num=$this->intepret($status);
        $date=date("d.m.Y");
        $d=$this->select_tbl("statuses","*","uid='$uid' AND pid='$pid'");
        if(count($d)>0){
            $id=$d[0]["id"];
            $this->upd_to_db("statuses","status='$status', num='0'","id='$id'");
        }
        else{
            $this->ins_to_db("statuses",["text","nume","uid","pid","comment"],[$status,$num,$uid,$pid,$this->v["comment"]]);
        }
        if($num==6){
            $this->upd_to_db("client_info","status='approved',apdate='$date'","id='$pid'");
        }
    }
    private function intepret($status){
        $admin = new AdminController($this->v);
        $role=$admin->getRole($this->v["role"]);
        if($status=="approved"){
            return $role["num"];
        }
        else{
            return 0;
        }
    }
    function getAuthorizer(){
        $a=new AdminController();
        $id=$this->v["pid"];
        $d=$this->select_tbl("statuses","*","pid='$id' AND nume='6'")[0];
        return $a->getUser($d["uid"],"name");
    }
    function getPermitStatus(){
        $a=new AdminController($this->v);
        $id=$this->v["pid"];
        $b=0;
        $full=false;
        $d=$this->select_tbl("statuses","*","pid='$id'");
        for($i=0;$i<count($d);$i++){
            $b+=$d[$i]["num"];
            $d[$i]["user"]=$a->getUser($d[$i]["uid"],"display");
            if($d[$i]["num"]==6){
                $full=true;
            }
        }
        $res=[];
        $res["statuses"]=$d;
        if($full){
            $res["status"]="Fully Permitted";
        }
        else{
            $res["status"]="On Progress";
        }
    }
}