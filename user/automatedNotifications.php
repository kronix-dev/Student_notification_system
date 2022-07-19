<?php
class AINotification extends user
{
    public $v;
    function __construct($d)
    {
        $this->v = $d;
    }
    function addSession()
    {
        $c = $this->select_tbl("courses", "*", null);
        $cc = $this->select_tbl("subjects", "*", null);
        $v = $this->select_tbl("venues", "*", null);
?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Add Session</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                            $this->input("t", null, 12, "hidden", "adss", "style='display:none'");
                            $this->select("day", "Choose Day", [
                                ["Monday", "Monday"],
                                ["Tuesday", "Tuesday"],
                                ["Wednesday", "Wednesday"],
                                ["Thursday", "Thursday"],
                                ["Friday", "Friday"]
                            ], 12, false, "select2 mb-3");
                            $this->select("type", "Choose Type", [
                                ["Tutorial", "Tutorial"],
                                ["Lecture", "Lecture"],
                                ["Lab", "Lab"]
                            ], 12, false, "select2 mb-3");
                            $this->input("stm", "Start Time", 6, "time");
                            $this->input("etm", "End Time", 6, "time");
                            $this->select("course[]", "Choose Programme", $c, 12, true, "select2", "multiple");
                            $this->select("subject", "Choose Course", $cc, 12, true, "select2");
                            $this->select("venue", "Choose Venue", $v, 12, true, "select2");
                            ?>
                            <div class="col-12">
                                <br />
                                <button class="btn btn-windows btn-block" type="submit">Add Session</button>
                                <br />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
    function saveSession()
    {
        $this->ins_to_db("tb_sessions", ["subject", "time_start", "time_end", "day", "courses", "venue", "type"], [
            $this->v["subject"],
            $this->v["stm"],
            $this->v["etm"],
            $this->v["day"],
            json_encode($this->v["course"]),
            $this->v["venue"],
            $this->v["type"]
        ]);
        return 0;
    }
    function getActiveSessions($exlude = false)
    {
        $d = $this->select_tbl("tb_sessions", "*", null);
        $course = new Courses();
        $sb = new subject();
        $vn = new VenueRequest();
        $ad = new NTAdmin();
        $dd = [];
        foreach ($d as $a) {
            $cc = [];
            $fg = $sb->getSubject($a["subject"]);
            if (!$exlude) {
                $a["sid"] = $a["subject"];
                $a["venueCode"] = $a["venue"];
            }
            $a["subject"] = $sb->getSubjectName($a["subject"]);
            $a["venue"] = $vn->getVenueName($a["venue"]);
            $a["courses"] = json_decode($a["courses"]);
            $a["instructor"] = $fg["instructor"];
            foreach ($a["courses"] as $b) {
                array_push($cc, $course->getCourseName($b));
            }
            $a["courses"] = implode(", ", $cc);
            array_push($dd, $a);
        }
        return $dd;
    }
    function listSessions()
    {
    }
    function listenToSoon()
    {
        $day = date("D");
        $time = DateTime::createFromFormat("H:i", date("H:i"));
        $d = $this->getActiveSessions(false);
        $r = [];
        foreach ($d as $a) {
            if ($day == $a["day"] && $this->isItTime(date("H:i"), $a["time_start"]) && $this->isNotSent($a["id"])) {
                array_push($r, $a);
            }
        }
        return $r;
    }
    function isItTime($t1, $t2)
    {
        //take away two dates check if less than 30 minutes and not more or less to 0;
        $t1 = $this->createTime((int)str_replace(":", "", $t1));
        $t2 = $this->createTime((int)str_replace(":", "", $t2));
        $t3 = $t2 - $t1;
        return $t3 == 30 ? true : false;
    }
    function createTime($t)
    {
        $ti = $t / 100;
        $tt = $t % 100;
        $tt2 = (($ti - $tt / 100) * 40);
        $time = $t - $tt2;
        return $time;
    }
    function createSheet()
    {
    }
    function callMasterPhone()
    {
    }
    function isNotSent()
    {
        return true;
    }
}
