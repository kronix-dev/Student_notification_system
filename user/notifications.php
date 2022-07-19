<?php
class Notifications extends User
{
    public $role, $v;
    function __construct($d)
    {
        $this->v = $d;
        if (isset($_SESSION["user"])) {
            $this->role = $_SESSION["user"]["role"];
            $this->user = $_SESSION["user"];
        } else {

            $this->role = isset($this->v["role"]) ? $this->v["role"] : "anonymous";
        }
    }
    function sendNotification()
    {
        $receps = [];
        $this->v["type"] = "subject";
        if ($this->v["type"] == "course") {
            foreach ($this->v["course"] as $a) {
                array_push($receps, $this->getNotifeesbyCourse($a));
            }
        } else if ($this->v["type"] == "subject") {
            foreach ($this->getNotifeesBySubject($this->v["subject"]) as $a) {
                // $ab = $this->getNotifeesbyCourse($a["id"]);
                // array_push($receps, $ab);
            }
        }
        $this->ins_to_db("notifications", ["name", "iid", "txt", "subject", "type"], [$this->v["name"], $this->v["uid"], $this->v["nm"], $this->v["subject"], "course"]);
        return $this->dialog("check", "Notification added successfully", "success", 12, 0);
    }

    function getSubjectCourses()
    {
        // $this->select_tbl("course_subject");
    }
    function getNotifeesbyCourse($c)
    {
        $stdd = new Students();
        return $stdd->getCourseStudents($c);
    }
    function getNotifeesBySubject($s)
    {
        $addr = [];
        $rd = new subject();
        $r = $rd->getCourseStudying($s);
        foreach ($r as $a) {
            $d = $this->select_tbl("students", "*", "course='" . $a["course"] . "'");
            foreach ($d as $v) {
                array_push($addr, $v["phone"]);
            }
        }
        return $addr;
    }
    function getNotifications($u)
    {
        if ($this->role == "student") {
            $d = $this->select_tbl("notifications", "*", "iid='$u'");
        } else if ($this->role == "admin") {
            $d = $this->select_tbl("notifications", ["id", "name", "type"], null);
        } else {
            $d = $this->select_tbl("notifications", "*", "iid='$u'");
        }
        return $d;
    }
    function addNotification()
    {
        $c = new Courses();
        $s = new subject();
?>
        <div class="row">
            <div class="col-6 offset-3">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Add New Notification</h5>
                            </div>
                            <div class="card-body">
                                <form class="glass_form row">
                                    <?php
                                    $this->input("t", null, 12, "hidden", "adn", "style='display:none'");
                                    $this->input("name", "name", 12);
                                    $this->input("nm", "Notification Message", 12);
                                    $this->select("subject", "Course", $s->getSubjectTeaching($this->user["id"]), 6, true, "select2");
                                    ?>
                                    <div class="col-12">
                                        <br />
                                        <button class="btn btn-windows btn-block" type="submit">Send Notification</button>
                                        <br />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
    function getUnsentNotifications()
    {
        $f = new AINotification([]);

        $d = $this->select_tbl("notifications", "*", "status='0' LIMIT 1");
        $cc = $f->listenToSoon(false);

        $cv = [];
        foreach ($cc as $a) {
            $t = [];
            $t["message"] = subject::getSubject($a["sid"])["name"] . " Session will start in 30 minutes";
            $t["nid"] = $a["id"];
            $t["addressList"] = $this->getNotifeesBySubject($a["sid"]);
            array_push($cv, $t);
        }
        // echo json_encode($cv);
        foreach ($d as $a) {
            $t = [];
            $t["message"] = $a["txt"];
            $t["nid"] = $a["id"];
            $t["addressList"] = $this->getNotifeesBySubject($a["subject"]);
            array_push($cv, $t);
        }
        return $cv;
    }
    function updateUnsentNotifications($d)
    {
        $this->upd_to_db("notifications", "status='1'", "id='$d'");
    }
}
