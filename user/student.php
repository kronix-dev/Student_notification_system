<?php
class Students extends User{
    function getStudents(){
        $d=$this->select_tbl("students","*",null);
        $e=new Courses();
        $r=[];
        foreach($d as $a){
            $a["course"]=$e->getCourseName($a["course"]);
            array_push($r,$a);
        }
        return $r;
    }
    static function getCourseStudents($c){
        $a=new auth();
        return $a->select_tbl("students","*","course='$c'");
    }
    function addStudent($c){
        return $this->ins_to_db("students",["name","course","phone","yos"],[$c["name"],$c["course"],$c["phone"],$c["yos"]]);
    }
    function studentForm(){
        $c=new Courses();
        $cc=$c->getCourses();
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Add Student</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                                $this->input("t", null, 12, "hidden", "adstu", "style='display:none'");
                                $this->input("name", "Full name", 12);
                                $this->input("phone", "Phone Number", 6);
                                // $this->input("tudom", "Registration number", 6);
                                $this->input("yos", "Year of study", 6);
                                $this->select("course","Select Programme",$cc,6,true,"select2");
                                
                            ?>
                            <div class="col-12">
                                    <br />
                                    <button class="btn btn-windows btn-block" type="submit">Add User</button>
                                    <br />
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}