<?php
class DeleteItems extends user{
    function deleteCourse($id){
        $this->del_from_db("courses","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteSubject($id){
        $this->del_from_db("subjects","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteInstructor($id){
        $this->del_from_db("users","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteVenue($id){
        $this->del_from_db("venues","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteStudent($id){
        $this->del_from_db("students","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteSession($id){
        $this->del_from_db("tb_sessions","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteUser($id){
        $this->del_from_db("users","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
    function deleteNotification($id){
        $this->del_from_db("notifications","id='$id'");
        $this->dialog("check","Deletion Successful","success",12,0);
    }
}