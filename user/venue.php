<?php
class VenueRequest extends user
{

    function requestForm()
    {
?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Book a Venue</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                            $this->input("t", null, 12, "hidden", "vrf", "style='display:none'");
                            $this->input("name", "Purpose", 12);

                            $this->select("day", "Choose date", [
                                ["Monday", "Monday"],
                                ["Tuesday", "Tuesday"],
                                ["Wednesday", "Wednesday"],
                                ["Thursday", "Thursday"],
                                ["Friday", "Friday"],
                            ], 12, false, "select2", "required");
                            $this->input("date", "Date", 12, "date");
                            $this->input("time_in", "Time in", 12, "time");
                            $this->input("time_out", "Time out", 12, "time");

                            ?>
                            <div class="col-12">
                                <br />
                                <button class="btn btn-windows btn-block" type="submit">Check free venues</button>
                                <br />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    function requestForm2($d)
    {
        $f = $this->isVenueFree($d);
        $v = $this->filterFreeVenues($f);
    ?>
        <div class="row">
            <?php
            if (count($v) > 0) {
            ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" class="glass_form row">
                                <?php
                                $this->input("t", null, 12, "hidden", "fgrf", "style='display:none'");
                                $this->input("time_in", null, 12, "hidden", $d["time_in"], "style='display:none'");
                                $this->input("time_out", null, 12, "hidden", $d["time_out"], "style='display:none'");
                                $this->input("day", null, 12, "hidden", $d["day"], "style='display:none'");
                                $this->input("date", null, 12, "hidden", $d["date"], "style='display:none'");
                                $this->input("name", null, 12, "hidden", $d["name"], "style='display:none'");
                                $this->select("venue", "Choose Venue", $v, 12, true, "select2", "required");
                                ?>
                                <div class="col-12">
                                    <br />
                                    <button class="btn btn-windows btn-block" type="submit">Request Venue</button>
                                    <br />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                $this->dialog("close", "No available venues, try another time", "danger", 12, 0);
                $this->requestForm();
            }
            ?>
        </div><?php
            }
            function getVenues()
            {
                return $this->select_tbl("venues", "*", null);
            }
            function requests()
            {
                $d = $this->select_tbl("venue_request", ["venue", "id", "instructor", "day", "description", "date", "time_in", "time_out", "date_request"], "1=1 ORDER BY status ASC");
                $f = [];
                foreach ($d as $a) {
                    $a["instructor"] = $this->getUserInfo($a["instructor"])["name"];
                    $a["venueCode"] = $a["venue"];
                    $a["venue"] = $this->getVenueName($a["venue"]);
                    array_push($f, $a);
                }
                // echo json_encode($f);
                return $f;
            }
            function requestsTab()
            {
                $d = $this->select_tbl("venue_request", ["venue", "id", "instructor", "day", "description", "date", "time_in", "time_out", "date_request"], "1=1 ORDER BY status ASC");
                $f = [];
                foreach ($d as $a) {
                    $a["instructor"] = $this->getUserInfo($a["instructor"])["name"];
                    $a["venue"] = $this->getVenueName($a["venue"]);
                    array_push($f, $a);
                }
                // echo json_encode($f);
                return $f;
            }
            function approve()
            {
            }
            function saveVenue($n, $c)
            {
                $this->ins_to_db("venues", ["name", "capacity"], [$n, $c]);
            }
            function viewRequest($id)
            {
                $d = $this->select_tbl("venue_request", "*", "id='$id'")[0];
                ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><b>Venue Request</b></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $this->textC("Purpose", $d["description"], null, 12);
                            $this->textC("Date Submitted", $d["date"], null, 4);
                            $this->textC("Booking Date", $d["date_request"], null, 4);
                            $this->textC("Time Requested", $d["time_in"], null, 4);
                            $this->textC("Time End", $d["time_out"], null, 4);
                            $this->textC("Instructor", $this->getUserInfo($d["instructor"])["name"], null, 4);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
            }
            function saveVenueRequest($d)
            {
                $this->ins_to_db("venue_request", ["venue", "instructor", "description", "day", "time_in", "time_out", "date_request"], [$d["venue"], $d["uid"], $d["name"], $d["day"], $d["time_in"], $d["time_out"], $d["date"]]);
            }
            function denyRequest()
            {
            }
            function getVenueName($o)
            {
                return $this->select_tbl("venues", ["name"], "id='$o'")[0]["name"];
            }
            function addVenue()
            {
    ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Add Venue</h1>
                    </div>
                    <div class="card-body">
                        <form class="glass_form row">
                            <?php
                            $this->input("t", null, 12, "hidden", "adv", "style='display:none'");
                            $this->input("name", "name", 12);
                            $this->input("capacity", "Capacity", 6, "text");
                            ?>
                            <div class="col-12">
                                <br />
                                <button class="btn btn-windows btn-block" type="submit">Add Venue</button>
                                <br />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
            }
            function allVenues()
            {
                return $this->select_tbl("venues", ["name", "capacity", "id"], null);
            }
            function isVenueFree($d)
            {
                $ven = [];
                $ss = new AINotification($d);
                $day = $d["day"];
                $date = $d["date"];
                $dv = $ss->getActiveSessions();
                $dr = $this->requests();
                $used = [];
                foreach ($dv as $a) {
                    if ($day == $a["day"]) {
                        $ti = DateTime::createFromFormat("H:i", $d["time_in"]);
                        $to = DateTime::createFromFormat("H:i", $d["time_out"]);
                        $si = DateTime::createFromFormat("H:i", $a["time_start"]);
                        $so = DateTime::createFromFormat("H:i", $a["time_end"]);
                        if ($ti >= $si && $ti <= $so || $to >= $si && $to <= $so) {
                            array_push($used, $a["venueCode"]);
                        }
                    }
                }
                foreach ($dr as $a) {
                    if ($day == $a["day"] && $date == $a["date_request"]) {
                        $ti = DateTime::createFromFormat("H:i", $d["time_in"]);
                        $to = DateTime::createFromFormat("H:i", $d["time_out"]);
                        $si = DateTime::createFromFormat("H:i", $a["time_in"]);
                        $so = DateTime::createFromFormat("H:i", $a["time_out"]);
                        if ($ti >= $si && $ti <= $so || $to >= $si && $to <= $so) {
                            array_push($used, $a["venueCode"]);
                        }
                    }
                }

                return $used;
            }
            function filterFreeVenues($used)
            {
                $free = [];
                $venues = $this->getVenues();
                for ($i = 0; $i < count($venues); $i++) {
                    if (in_array($venues[$i]["id"], $used)) {
                    } else {
                        array_push($free, $this->getVenue($venues[$i]["id"]));
                    }
                }
                return $free;
            }
            function getVenue($id)
            {
                return $this->select_tbl("venues", "*", "id='$id'")[0];
            }
        }
