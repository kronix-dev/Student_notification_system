<?php
class Panels extends user
{
    public $role, $v = [];
    function __construct()
    {
        $this->role = $_SESSION["user"]["role"];
    }
    function NotificationPanel()
    {
        $n = new Notifications($this->v);
        $d = $n->getNotifications($_SESSION["user"]["id"]);
?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Notifications Panel</h4>
                </div>
                <div class="row">
                    <?php
                    if ($this->role != "student") {
                    ?>
                        <div class="col-4">
                            <button onclick="loadToDiv('adn','n','applet')" class="btn btn-primary">Add Notification</button>
                        </div>
                    <?php } ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Notifications</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($d, ["name", "type"], "ntu");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function UserPanel()
    {
        $n = new NTAdmin();
    ?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Users Panel</h4>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button onclick="loadToDiv('adu','n','applet')" class="btn btn-primary">Add User</button>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Users</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($n->getUsers(), ["name", "email", "role", "status"], "du");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function SubjectsPanel()
    {
        $s = new subject();
        $d = $s->getSubjects();
    ?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Courses Panel</h4>
                </div>
                <div class="row">
                    <div class="col-4 mb-3">
                        <button onclick="loadToDiv('ads','kk','applet')" class="btn btn-primary">Add Course</button>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Courses</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($d, ["name", "code"], "ds");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function CoursesPanel()
    {
        $c = new Courses();
        $d = $c->getCourses();
    ?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Programmes Panel</h4>
                </div>
                <div class="row">
                    <div class="col-4 mb-3">
                        <button onclick="loadToDiv('adc','kk','applet')" class="btn btn-primary">Add Programmes</button>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Programmes</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($d, ["name", "duration"], "dc");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function StudentsPanel()
    {
        $t = new Students();
        $d = $t->getStudents();
    ?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Student's Panel</h4>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button onclick="loadToDiv('adstu','n','applet')" class="btn btn-primary">Add Student</button>

                        <!-- <button onclick="loadToDiv('add',2,'applet')" class="btn btn-primary">Add Student</button> -->
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Students</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($d, ["Name",  "Year of study", "Phone","Programme"], "dst");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function Panelify()
    {
        $this->NotificationPanel();
        // $this->UserPanel();
        // $this->CoursesPanel();
    }
    function sessionPanel()
    {
        $s = new AINotification($this->v);
        $d = $s->getActiveSessions(true);
    ?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Sessions</h4>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button onclick="loadToDiv('adss',2,'applet')" class="btn btn-primary">Add Sessions</button>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Sessions</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($d, ["Programme", "Time Start", "Time End", "Course","Day", "Venue", "Type", "Instructor"], "dss");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function venuePanel()
    {
        $v = new VenueRequest();
        $d = $v->requests();
        $u = $v->allVenues();
    ?>
        <div class="row">
            <div class="col-12">
                <div class="heading">
                    <h4>Venue Panel</h4>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button onclick="loadToDiv('adv','a','applet')" class="btn btn-primary">Add Venue</button>
                        <button onclick="loadToDiv('menu','rv','applet')" class="btn btn-success">Venue Requests</button>
                    </div>
                    <div class="col-4">
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>All Venues</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $this->tableTurner($u, ["Name", "Capacity"], "dv");
                                ?>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    <?php
    }
    function venueRequestPanel()
    {
        $v = new VenueRequest();
        $d = $v->requestsTab();
    ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>All Venue Requests</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        $this->tableTurner($d,["Venue","Instructor","Day","Description","date","Time in", "Time out","Booking date"],"vdv");
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
?>