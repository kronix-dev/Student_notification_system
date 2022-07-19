<?php
class Courses extends user{
    function getCourses(){
        $d=$this->select_tbl("courses",["id","name","duration"],null);
        return $d;
    }
    function addCourse(){
        ?>
        <div class="row">
            <div class="col-4 offset-4">
                <div class="card">
                    <div class="card-header">
                        <h1>Add Programme</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                                $this->input("t", null, 12, "hidden", "adc", "style='display:none'");
                                $this->input("name", "programme Name", 12);
                                $this->input("code","Short form",6,"text");
                                $this->input("duration","duration",6,"text");
                            ?>
                            <div class="col-12">
                                <br />
                                <button class="btn btn-windows btn-block" type="submit">Add Programme</button>
                                <br />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    function getCoursesubjects($course){
        $d=$this->select_tbl("course_subjects","*","course='$course'");
        return $d;
    }
    function saveCourse($d){
        $this->ins_to_db("courses",["name","code","duration"],[$d["name"],$d["code"],$d["duration"]]);
        return $this->dialog("check","Programme added successfully","success",12,0);
    }
    function getCourseName($i){
        return $this->select_tbl("courses",["name"],"id='$i'")[0]["name"];

    }
}
?>