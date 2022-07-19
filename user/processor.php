<?php
class processor extends auth{
    public $uid;
    function saveForm($d){
        $price=$this->getUsePrice($d["landuse"]);
        $st=date("YmdHis");
        $adp=null;
        $c=$this->ins_to_db("client_info",
        ["cl_name","phone","email","address","plot_no","block","village","ward","plan_status","plint_area","built_area","front","rear","rhs","lhs","approx_price","storestat","stories","adp","area","pl_coverage","pl_ratio","land_use","uniqid","cid","valid"],
        [$d["name"],$d["phone"],$d["email"],$d["address"],$d["plot"],$d["block"],$d["village"],$d["ward"],$d["plan"],$d["plinth_area"],$d["built_area"],$d["front"],$d["rear"],$d["right"],$d["left"],$price,$d["store"],$d["stories"],$adp,null,$d["plot_coverage"],$d["plot_ratio"],$d["landuse"],uniqid(),$d["district"],$st]);
        $this->ins_to_db("architect_info",["ar_name","phone","regnumber","email","class","identifier","address"],[$d["arch_name"],$d["arch_phone"],$d["arch_reg"],$d["arch_email"],"Architectural Engineer",$c,$d["arch_addr"]]);
        $this->ins_to_db("architect_info",["ar_name","phone","regnumber","email","class","identifier","address"],[$d["struct_name"],$d["struct_phone"],$d["struct_reg"],$d["struct_email"],"Structural Engineer",$c,$d["struct_addr"]]);
        $_SESSION["uniq"]=$c;
        return $c;
    }
    function getUsePrice($id){
        return $this->select_tbl("land_uses","*","id='$id'")[0]["price"];
    }
    function getLocality($t="region",$id=null){
        if($t=="region"){
            $d=$this->select_tbl("region","*",null);
        }
        else{
            if($id==null){
                $d=$this->select_tbl("district","*",null);
            }
            else{
                $d=$this->select_tbl("district","*","rid='$id'");
            }
        }
        return $d;
    }
    function uploadAttachments($d,$u){
        $this->ins_to_db("attachments",["file_link","identifier","type"],[$d[1],$u,"attachment"]);
    }
}