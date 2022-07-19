<?php
class Report extends auth
{
    public $role, $userID, $levelID, $cid, $rid;
    function home()
    {
        $gui = new gui();
        $gui->form_script("app");
?>
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-header">Reporting Portal</div>
                    <form class="glass_form">
                        <div class="card-body">
                            <?php
                            $gui->hinput("generate_report");
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <p>
                                        <label>
                                            <input class="with-gap" name="type" value="daily" type="radio" checked />
                                            <span>Daily Report</span>
                                        </label>
                                        <label>
                                            <input class="with-gap" value="monthly" name="type" type="radio" />
                                            <span>Monthly Report</span>
                                        </label>
                                        <label>
                                            <input class="with-gap" name="type" value="range" type="radio" checked />
                                            <span>Generate from range</span>
                                        </label>
                                    </p>
                                    <hr>
                                    <h6>Range Options</h6>

                                </div>
                                <div class="col-6">
                                    <div class="input-field">
                                        <i class="material-icons prefix">mode_edit</i>
                                        <input id="reg" type="date" class="validate" name="bdate" />
                                        <label for="reg">Beggining Date</label>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="input-field">
                                        <i class="material-icons prefix">mode_edit</i>
                                        <input id="ref" type="date" class="validate" name="edate" />
                                        <label for="ref">Ending Date</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p>
                                        <label>
                                            <input type="checkbox" checked name="main" value="1" />
                                            <span>Display main report</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input type="checkbox" checked name="extra" value="1" />
                                            <span>Include total Planned area</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input type="checkbox" checked name="include" value="1" />
                                            <span>Include Land use Report</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="submit" value="Get Report" class="btn blue" />
                            <!-- <a href="#" class="btn yellow darken-3">View Generated reports</a> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    function reportStyle()
    {
    ?>
        <style>
            td {
                padding: 10px 2px;
                border: 1px solid black;
                font-size: 12px;
                text-align: center;
            }

            .b {
                font-weight: bold;
            }
        </style>
        <button class="btn noprint" onclick="print()">Print Report</button>
    <?php
    }
    function regionalData($r){
            $d=$this->select_tbl("region_data","*","rid='$r'")[0];
            $tpp=($d["pas"]*100)/$d["pla"];
            ?>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Total Area (sqKM)</th>
                    <td><?php echo $d["raa"] ?> Km<sup>2</sup></td>
                </tr>
                <tr>
                    <th>Size of Planning Area</th>
                    <td><?php echo $d["pas"] ?> m<sup>2</sup></td>
                </tr>
                <tr>
                    <th>Planned Area</th>
                    <td><?php echo $d["pla"] ?> m<sup>2</sup></td>
                </tr>
                <tr>
                    <th>Percentage of Planned Area</th>
                    <td><?php echo substr($tpp,0,5) ?>%</td>
                </tr>
                <tr>
                    <th>Number of GPS</th>
                    <td><?php echo $d["nogps"] ?></td>
                </tr>
                <tr>
                    <th>Number of TP Drawings (Since independence)</th>
                    <td><?php echo $d["dno"] ?></td>
                </tr>
                <tr>
                    <th>Number of scanned DS</th>
                    <td><?php echo $d["scane"] ?></td>
                </tr>
                <tr>
                    <th>Number of unscanned DS</th>
                    <td><?php echo $d["nscan"] ?></td>
                </tr>
                <tr>
                    <th>Number of Digitized</th>
                    <td><?php echo $d["digitized"] ?></td>
                </tr>
                <tr>
                    <th>Number of Gazzeted Planning Area</th>
                    <td><?php echo $d["gazz"] ?></td>
                </tr>
                <tr>
                    <th>Number of Ungazzeted</th>
                    <td><?php echo $d["notgazz"] ?></td>
                </tr>
            </table>
            <?php
    }
    function homeReport($cid,$t){
        if($t=="r"){
            $this->regionalData($cid);
        }
        else{
            $d=$this->select_tbl("council_data","*","cid='$cid'")[0];

            $tpp=($d["planarea"]*100)/$d["ukubwa"];
            ?>
            <!-- <div class="card">
                <div class="card-header"></div>
                <div class="card-body">

                </div>
            </div> -->
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Total Area (sqKM)</th>
                    <td><?php echo $d["ukubwa"] ?> Km<sup>2</sup></td>
                </tr>
                <tr>
                    <th>Planned Area</th>
                    <td><?php echo $d["planarea"] ?> Km<sup>2</sup></td>
                </tr>
                <tr>
                    <th>Percentage of Planned Area</th>
                    <td><?php echo substr($tpp,0,5) ?>%</td>
                </tr>
                <tr>
                    <th>Number of TP Drawings(Since independence)</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Number of scanned DS</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Number of unscanned DS</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Number of Digitized</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Name of Gazzeted Planning Area</th>
                    <td><?php echo $d["maeneoy"] ?></td>
                </tr>
                <tr>
                    <th>Name of Ungazzeted</th>
                    <td><?php echo $d["maeneon"] ?></td>
                </tr>
            </table>
            <?php
        }
    }
    function generate($v)
    {
        $extra = false;
        if ($v["type"] == "range") {
            $b = str_replace("-", "", $v["bdate"]);
            $bdate = explode("-", $v["bdate"]);
            $edate = explode("-", $v["edate"]);
            $e = str_replace("-", "", $v["edate"]);
            $d = $this->select_tbl("request", "*", "dateReport>='$b' AND dateReport<='$e' AND status='approved'");
            if (date("m") > 6) {
                $fs = date("Y") + 1;
                $ddd = "Tarehe: " . $bdate[2] . "/" . $bdate[1] . "/" . $bdate[0] . " Hadi tarehe " . $edate[2] . "/" . $edate[1] . "/" . $bdate[0];
            } else {
                $fs = date("Y") - 1;
                $ddd = "Tarehe: " . $bdate[2] . "/" . $bdate[1] . "/" . $bdate[0] . " Hadi tarehe " . $edate[2] . "/" . $edate[1] . "/" . $bdate[0];
            }
        } elseif ($v["type"] == "monthly") {
            $da = date("Ym");
            $d = $this->select_tbl("request", "*", "dateReport LIKE '$da%' AND status='approved'");
            if (date("m") > 6) {
                $fs = date("Y") + 1;
                $ddd = "Mwaka wa Fedha " . date("Y") . "/" . $fs . " Mwezi " . date("m/Y");
            } else {
                $fs = date("Y") - 1;
                $ddd = "Mwaka wa Fedha " . $fs . "/" . date("Y") . " Mwezi " . date("m/Y");
            }
        } elseif ($v["type"] == "daily") {
            $da = date("Ymd");
            if (date("m") > 6) {
                $fs = date("Y") + 1;
                $ddd = "Mwaka wa Fedha " . date("Y") . "/" . $fs . " Tarehe " . date("d/m/Y");
            } else {
                $fs = date("Y") - 1;
                $ddd = "Mwaka wa Fedha " . $fs . "/" . date("Y") . " Tarehe " . date("d/m/Y");
            }
            $d = $this->select_tbl("request", "*", "dateReport='$da' AND status='approved'");
        } elseif ($v["type"] == "weekly") {
        }
        if ($this->role == "atpo") {
            $report = $this->ministryReport($d, "district");
        } elseif ($this->role == "director") {
            $report = $this->ministryReport($d, "all");
            // $report=$this->tpoReport($this->cid,$d);
        } elseif ($this->role == "rup") {
            $report = $this->ministryReport($d, "region");
        } else {
            $report = $this->ministryReport($d, "district");
        }
        if (isset($v["extra"])) {
            $extra = true;
        }
        if (isset($v["main"])) {
            $this->viewReport($report, $extra, $ddd);
        }
        if (isset($v["include"])) {
            $this->landUseReport(6);
        }
        if ($this->role != "make") {
            $this->reportStyle();
        }
        return $report;
    }
    function viewReport($report, $extra, $date)
    {
        $this->reportStyle();
    ?>
        <div class="row">
            <div class="col-12">
                <table border='2'>
                    <tr>
                        <td class="b" colspan="11">IDARA YA MAENDELEO YA MAKAZI</td>
                    </tr>
                    <tr>
                        <td class="b" colspan="11">TAKWIMU ZA TAARIFA ZA UTEKELEZAJI WA KAZI ZA MIPANGOMIJI (<?php echo $date ?>)</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="b" colspan="3">IDADI YA MICHORO YA MIPANGOMIJI</td>
                        <td class="b" colspan="3">IDADI YA VIWANJA</td>
                        <td class="b" rowspan="2">MABADILIKO YA MATUMIZI YA ARDHI</td>
                        <td class="b" rowspan="2">VIBALI VYA UJENZI</td>
                    </tr>
                    <tr>
                        <td>No</td>
                        <td>MKOA</td>
                        <td>MAMLAKA YA UPANGAJI</td>
                        <td>UPANGAJI WA KAWAIDA(MAENEO MAPYA)</td>
                        <td>URASIMISHAJI</td>
                        <td>MAREKEBISHO</td>
                        <td>UPANGAJI WA KAWAIDA(MAENEO MAPYA)</td>
                        <td>URASIMISHAJI</td>
                        <td>MAREKEBISHO</td>
                    </tr>


                    <?php
                    // echo json_encode($report["data"]);
                    $i = 0;
                    if ($report["type"] == "min") {
                        foreach ($report["data"] as $a) {
                            $i++;
                            $isgone = 0;
                            foreach ($a["halm"] as $x) {
                    ?>
                                <tr>
                                    <?php
                                    if ($isgone == 0) {
                                        $isgone = 1;
                                    ?>

                                        <td class="b"><?php echo $i ?></td>
                                        <td class="b"><?php echo $a["name"] ?></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td></td>
                                        <td></td>
                                    <?php
                                    }
                                    ?>
                                    <td><?php echo $x["name"] ?></td>
                                    <td><?php echo $x["report"]["tp"] ?></td>
                                    <td><?php echo $x["report"]["uras"] ?></td>
                                    <td><?php echo $x["report"]["mare"] ?></td>
                                    <td><?php echo $x["report"]["itp"] ?></td>
                                    <td><?php echo $x["report"]["iuras"] ?></td>
                                    <td><?php echo $x["report"]["imare"] ?></td>
                                    <td><?php echo $x["report"]["ab"] ?></td>
                                    <td><?php echo $x["report"]["cb"] ?></td>

                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td class="b">sub total</td>
                                <td></td>
                                <td></td>
                                <td class="b"><?php echo $a["x1t"] ?></td>
                                <td class="b"><?php echo $a["x2t"] ?></td>
                                <td class="b"><?php echo $a["x3t"] ?></td>
                                <td class="b"><?php echo $a["y1t"] ?></td>
                                <td class="b"><?php echo $a["y2t"] ?></td>
                                <td class="b"><?php echo $a["y3t"] ?></td>
                                <td class="b"><?php echo $a["x4t"] ?></td>
                                <td class="b"><?php echo $a["y4t"] ?></td>
                            </tr>
                            <tr>
                                <td colspan="11"></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td class="b">Grand Total</td>
                            <td colspan="2"></td>
                            <td class="b"><?php echo $report["tpt"] ?></td>
                            <td class="b"><?php echo $report["urast"] ?></td>
                            <td class="b"><?php echo $report["maret"] ?></td>
                            <td class="b"><?php echo $report["itpt"] ?></td>
                            <td class="b"><?php echo $report["iurast"] ?></td>
                            <td class="b"><?php echo $report["imaret"] ?></td>
                            <td class="b"><?php echo $report["ac"] ?></td>
                            <td class="b"><?php echo $report["cb"] ?></td>
                        </tr>
                    <?php

                    }
                    ?>



                </table>

            </div>
            <div class="col-4">
                <table>
                    <tr>
                        <th></th>
                        <th>SUMMARY</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Michoro ya Mipangomiji</td>
                        <td><?php echo $report["urast"] + $report["maret"] + $report["tpt"] ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Idadi ya Viwanja</td>
                        <td><?php echo $report["iurast"] + $report["imaret"] + $report["itpt"] ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Michoro ya Urasimishaji</td>
                        <td><?php echo $report["urast"] ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Viwanja vya Urasimishaji</td>
                        <td><?php echo $report["iurast"] ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Mabadiliko ya matumizi</td>
                        <td><?php echo $report["ac"] ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Vibali vya ujenzi</td>
                        <td><?php echo $report["cb"] ?></td>
                    </tr>
                    <?php if ($extra) {
                    ?>
                        <tr>
                            <td>7</td>
                            <td class="b">Total Planned Area</td>
                            <td><?php echo $report["totalPlanned"] ?></td>
                        </tr>
                    <?php
                    } ?>
                </table>
            </div>
        </div>
    <?php
    }
    function ministryReport($d, $type)
    {
        if ($type == "all") {
            $r = $this->select_tbl("region", "*", null);
        }
        if ($type == "region" || $type == "district") {
            $r = $this->select_tbl("region", "*", "id='" . $this->rid . "'");
        }
        $xxp = [];
        $xxp["type"] = "min";
        $xxp["data"] = [];
        $xxp["tpt"] = 0;
        $xxp["urast"] = 0;
        $xxp["maret"] = 0;
        $xxp["itpt"] = 0;
        $xxp["iurast"] = 0;
        $xxp["imaret"] = 0;
        $xxp["ac"] = 0;
        $xxp["cb"] = 0;
        $xxp["totalPlanned"] = 0;
        $xxp["landuse"] = [];
        foreach ($r as $pp) {
            // $pp["d"]=[];
            $pp["halm"] = [];
            $pp["x1t"] = 0;
            $pp["x2t"] = 0;
            $pp["x3t"] = 0;
            $pp["x4t"] = 0;
            $pp["y1t"] = 0;
            $pp["y2t"] = 0;
            $pp["y3t"] = 0;
            $pp["y4t"] = 0;
            $xid = $pp["id"];
            if ($type == "district") {
                $c = $this->select_tbl("councils", "*", "id='" . $this->cid . "'");
            } else {
                $c = $this->select_tbl("councils", "*", "rid='$xid'");
            }
            $pp["halm"] = [];
            foreach ($c as $xx) {
                $x1 = 0;
                $x2 = 0;
                $x3 = 0;
                $y1 = 0;
                $y2 = 0;
                $y3 = 0;
                $x4 = 0;
                $y4 = 0;
                foreach ($d as $a) {
                    $pl = $this->select_tbl("land_use", "*", "rid='" . $a["uniqid"] . "'");
                    $ttp = 0;
                    $xxpi = 0;
                    foreach ($pl as $cv) {
                        $ttp += $cv["noplots"];
                        $xxpi += $cv["area"];
                    }
                    if ($a["cid"] == $xx["id"]) {
                        if ($a["type"] == "1") {
                            $x1++;
                            $y1 += $ttp;
                            $pp["x1t"]++;
                            $pp["y1t"] += $ttp;
                            $xxp["itpt"] += $ttp;
                            $xxp["tpt"]++;
                        }
                        if ($a["type"] == "2") {
                            $x2++;
                            $y2 += $ttp;
                            $pp["x2t"]++;
                            $pp["y2t"] += $ttp;
                            $xxp["urast"]++;
                            $xxp["iurast"] += $ttp;
                        }
                        if ($a["type"] == "3") {
                            $xxp["maret"]++;
                            $xxp["imaret"] += $ttp;
                            $x3++;
                            $y3 += $ttp;
                            $pp["x3t"]++;
                            $pp["y3t"] += $ttp;
                        }
                        if ($a["type"] == "4") {
                            $x4++;
                            $y4++;
                            $pp["x4t"]++;
                            $pp["y4t"] += $ttp;
                            $xxp["ac"]++;
                            $xxp["cb"] += $ttp;
                        }
                    }
                }
                $xx["report"] = [];
                $xx["report"]["tp"] = $x1;
                $xx["report"]["uras"] = $x2;
                $xx["report"]["mare"] = $x3;
                $xx["report"]["itp"] = $y1;
                $xx["report"]["iuras"] = $y2;
                $xx["report"]["imare"] = $y3;
                $xx["report"]["ab"] = $x4;
                $xx["report"]["cb"] = $y4;
                array_push($pp["halm"], $xx);
            }
            array_push($xxp["data"], $pp);
        }
        // print_r($c);
        return $xxp;
    }
    function landUseReport($i, $class = "", $rid = "*")
    {
        $d = $this->select_tbl("land_uses", "*", null);
    ?>
        <div class="row">
            <div class="col-<?php echo $i ?>">
                <p>Overall Land Use Report (Global)</p>
                <table class="<?php echo $class ?>">
                    <tr>
                        <td>Land Use</td>
                        <td>Number Of Plots</td>
                        <td>Total Planned Area</td>
                    </tr>
                    <?php
                    foreach ($d as $a) {
                        $e = 0;
                        $ee = 0;
                        foreach ($this->select_tbl("land_use", "*", "id='" . $a["id"] . "'") as $se) {
                            if (is_array($rid)) {
                                if (in_array($se["rid"], $rid)) {
                                    $e += $se["noplots"];
                                    $ee += $se["area"];
                                }
                            } else {
                                $e += $se["noplots"];
                                $ee += $se["area"];
                            }
                        }
                    ?>
                        <tr>
                            <td><?php echo $a["name"] ?></td>
                            <td><?php echo $e ?></td>
                            <td><?php echo $ee ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    <?php
    }
    function computeLandReport()
    {
    }
    function dailyReport()
    {
    ?>
        <div class="row">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-header blue white-text">Daily Report</div>
                    <div class="card-body">
                        <form class="glass_form">
                            <input type="hidden" name="tracker" value="dailyRep" />
                            <?php
                            $gui = new gui();
                            $gui->tinput("da", "date", "Date Of The Report", "required", "calender", "date");
                            $gui->tinput("no", "build", "Number of Building permits", "required", "edit", "number");
                            $gui->tinput("no", "nlr", "Number of License of residence", "required", "edit", "number");
                            $gui->tinput("no", "npc", "Number of Planning consents", "required", "edit", "number");
                            ?>
                            <input type="submit" class="btn blue" value="Save Report" />
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header blue white-text">Saved Reports</div>
                    <div class="card-body">
                        <?php
                        $d = $this->select_tbl("halmashauri_report", "*", "cid='$this->cid' ORDER BY id DESC");
                        ?>
                        <table class="table table-striped table-bordered">
                            <tr class="blue white-text">
                                <th>Building permits</th>
                                <th>License of Residence</th>
                                <th>Planning Consents</th>
                                <th>Date of Report</th>
                                <th>Date submited</th>
                            </tr>
                            <?php
                            foreach ($d as $a) {
                            ?>
                                <tr>
                                    <td><?php echo $a["building_permits"] ?></td>
                                    <td><?php echo $a["leseni"] ?></td>
                                    <td><?php echo $a["planningConsent"] ?></td>
                                    <td><?php echo $a["date"] ?></td>
                                    <td><?php echo $a["submition"] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $gui->form_script("app");
    }
    function saveDailyReport($d)
    {
        $b = str_replace("-", "", $d["date"]);
        $bdate = explode("-", $d["date"]);
        $this->ins_to_db("halmashauri_report", ["date", "repdate", "submition", "planningConsent", "building_permits", "leseni", "cid"], [$d["date"], $b, date("d-m-Y"), $d["npc"], $d["build"], $d["nlr"], $this->cid]);
        $this->dailyReport();
    }
    function mapData($id)
    {
        $this->role = "make";
        $this->cid = $id;
        $d = [];
        $d["type"] = "range";
        $d["bdate"] = "1961-12-09";
        $d["edate"] = date("Y-m-d");
        $x = $this->generate($d);
        $c = $this->ministryReport($x, "district");
        // $this->displayMapData($x);
        $this->mapReport($id,12,"table table-bordered table-striped tle-primary");
    }
    function displayMapData($report)
    {
        //    $this->reportStyle();
    ?>
        <div class="row">
            <div class="col-12">
                <?php
                // $this->mapReport(12, );
                ?>
            </div>
        </div>
    <?php
    }
    function mapReport($cid, $i, $class = "")
    {
        $rid=[];
        $ds = $this->select_tbl("request", "*", "cid='$cid'");
        foreach($ds as $a){
            array_push($rid,$a["uniqid"]);
        }
        $d = $this->select_tbl("land_uses", "*", null);
    ?>
        
        <div class="row">
            <div class="col-<?php echo $i ?>">
                <div class="card">
                    <div class="card-header">
                        <p>Overall Land Use Report From 9th December, 1961 to <?php echo date('d F, Y') ?></p>
                    </div>
                    <div class="card-body">
                        <table class="<?php echo $class ?>">
                            <tr>
                                <td>Land Use</td>
                                <td>Number Of Plots</td>
                                <td>Total Planned Area</td>
                            </tr>
                            <?php
                            foreach ($d as $a) {
                                $e = 0;
                                $ee = 0;
                                foreach ($this->select_tbl("land_use", "*", "id='" . $a["id"] . "'") as $se) {
                                    if (is_array($rid)) {
                                        if (in_array($se["rid"], $rid)) {
                                            $e += $se["noplots"];
                                            $ee += $se["area"];
                                        }
                                    } else {
                                        $e += $se["noplots"];
                                        $ee += $se["area"];
                                    }
                                }
                            ?>
                                <tr>
                                    <td><?php echo $a["name"] ?></td>
                                    <td><?php echo $e ?></td>
                                    <td><?php echo $ee ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}
