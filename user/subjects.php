<?php
class subject extends user{
    public $v;
    function AddSubject(){
        $c=new Courses();
        $s=new Instructors();

        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Add Course</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                                $this->input("t", null, 12, "hidden", "ads", "style='display:none'");
                                $this->input("name", "name", 12);
                                $this->input("code", "code", 6, "text");
                                $this->select("courses[]", "Programme",$c->getCourses(), 6,true,"select2","multiple");
                                $this->select("instructor", "Instructor",$s->getInstructors(), 6,true);
                                
                            ?>
                            <div class="col-12">
                                    <br />
                                    <button class="btn btn-windows btn-block" type="submit">Add Subject</button>
                                    <br />
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    function saveSubject($d){
        $dx=$this->ins_to_db("subjects",["name","code","instructor"],[$d["name"],$d["code"],$d["instructor"]]);
        foreach ($d["courses"] as $a){
            $this->assignToCourse($a,$dx);
        }
        return $this->dialog("check","Subject Saved","success",12,0);
    }
    function deleteSubject($id){
        $this->del_from_db("subjects","id='$id'");
        return $this->dialog("check","Subject Deleted","success",12,0);
    }
    function assignToCourse($c,$s){
        $this->ins_to_db("course_subjects",["course","subject"],[$c,$s]);
    }
    function getCourseStudying($subject){
        return $this->select_tbl("course_subjects","*","subject='$subject'");
    }
    function getSubjectTeaching($i){
        return $this->select_tbl("subjects",["id","name"],"instructor='$i'");
    }
    function getSubjects(){
        return $this->select_tbl("subjects",["name","code","id"],null);
    }
    function getSubjectName($d){
        return $this->select_tbl("subjects",["name"],"id='$d'")[0]["name"];
    }
    static function getSubject($id){
        $u=new NTAdmin();
        $d=$u->select_tbl("subjects","*","id='$id'")[0];
        $d["instructor"]= $u->getUser($d["instructor"])["name"];
        return $d;
    }
}