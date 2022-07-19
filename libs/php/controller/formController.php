<?php
class FormController extends auth{
    public $forms,$cla,$clb;
    function __construct()
    {
        $this->forms=$this->read_jsonfile("config.json")["forms"];
    }
    function getForm($cla,$clb){
        for($i=0;$i<count($this->forms[$cla]);$i++){
            if($this->forms[$cla][$i]["name"]==$clb){
                $z=$i;
                break;
            }
        }
        return $this->forms[$cla][$z];
    }
}