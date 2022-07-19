<?php
class Instructors extends user{
    function getInstructors(){
        return $this->select_tbl("users","*","role='instructor'");
    }
    function getInstructor($d){
        
    }
    function deleteInstructor($id){
        return $this->del_from_db("users","id='$id'");
    }
    function showInstructors(){
        $d =  $this->select_tbl("users",["name","email","phone"],"role='instructor'");
        $this->tableTurner($d,["id","Name","Email","Phone"],"view_instructor");
    }
    function instructorView(){
        
    }
}