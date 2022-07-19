<?php
class PermitController extends auth{
    function __construct()
    {
        
    }
    function savePermit(){
        
    }
    function getType($id)
    {
        return $this->select_tbl("land_uses", ["name"], "id='$id'")[0]["name"];
    }
    function generateQR($uid){
        ?>
        <script>
            $(document).ready(function() {
            $('#qr').ClassyQR({
            create: true,
            type: 'text', 
            text: '<?php echo $uid?>' 
            });
            });
        </script>
        <?php
    }
    function permit($id){
        $d=$this->select_tbl("client_info","*","id='$id'")[0];
        $b=new BPCore();
        $adp=$d["id"]."/".$this->getADP($d["ap_date"]);
        $st=new StatController(["uid"=>$_SESSION["udetails"],"pid"=>$id]);
        ?>
        <style>
        .app-brand-logo img{
            width: 30px;
            height: 30px;
        }
        .dashd{
            border: 2px dashed #CA5010;
            padding: 10px;
        }
        .card-body{
            overflow-x: auto;
        }
        .ajax-file-upload-filename{
            display: none;
            visibility: hidden;
        }
        .ajax-file-upload-statusbar{
            border: none;
            padding: 0;
            margin: 0;
            background-color:white;
        }
        .ajax-file-upload-progress{
            margin: 0;
            /*border: none;*/
            padding: 0;
            
        }
        .ajax-file-upload-bar{
            background-image: url(assets/img/loader.gif);
            background-position-y: 200px;
        }
        body{
            background-image: none;
            background-size: cover;
            background-color: #fff;
        }
        .permcontainer{
            width:100%;
            height: 100%;
            border:2px double #000;
            background-color: #fff;
        }
        .cont{
            margin: 46px;
        }
        .cs{
            margin-top: 70px;
        }
        .ros{
            margin-top: 80px;
        }
        p{
            font-size: 12pt;
        }
        
    </style>
        <div class="permcontainer">
                               <div class="cont">
                                   <center>
                                       <h4><b>United Republic of Tanzania<br/>President Office Regional Administration and Local Government</b></h4>
                                       <h4>Arusha District Council</h4>
                                       <p>(All letters must be addressed to the council director)</p>
                                    </center>
                                       <div class="row">
                                           <div class="col-md-8"><p>
                                               Arusha Region,<br/>
                                               Telegram: Arusha,<br/>
                                               Phone: 0736 500 476,<br/>
                                               Fax: 250 3701,<br/>
                                               Email: ded@arushadc@go.tz<br/>
                                               Website: www.arushadc.go.tz</p>
                                           </div>
                                           <div class="col-md-3 offset-1">
                                               <p>District Executive Director,<br/>
                                               P.O.BOX 2330,<br/>
                                               <b>ARUSHA</b></p>
                                           </div>
                                       </div>
                                       <div class="row cs">
                                           <div class="col-md-8">
                                               <p><b>Ref No: <?php echo $adp ?></b><br/>
                                               <i>ADC/<?php echo $d["cl_name"] ?></i>,<br/>
                                               <?php echo $d["address"] ?>,<br/></p>
                                           </div>
                                           <div class="col-md-3 offset-1">
                                               <p><b><?php echo date("d-M-Y") ?></b></p>
                                           </div>
                                       </div>
                                       <div class="ros">
                                           <center>
                                               <h4><b>Building Permit No ADP/<?php echo $adp?></b></h4>
                                           </center>
                                           <p>
                                           Permission is hereby issued to
                                            <b><?php echo $d["cl_name"]?></b>
                                            . To erect <b><?php echo $this->getType($d["land_use"]) ?></b> Building on plot <b><?php echo $d["plot_no"] ?></b>. Block <b><?php echo $d["block"] ?></b>. Area <b><?php echo $d["village"] ?></b>. In accordance to approved plan 
                                            <b><?php ?></b> attached here to and with all conditions imposed by the regulations, CAP 188
                                           </p>
                                       </div>
                                        <div class="row ros">
                                            <div class="col-md-4">
                                                <center>
                                                    <p><?php echo $st->getAuthorizer()["name"]; ?><br/>For District Executive Director<br/> Date: <?php echo $d["apdate"] ?></p>
                                                </center>
                                            </div>
                                            <div class="col-md-4 offset-3">
                                                <div style="border: 2px dashed black;min-height:40px">
                                                    <div id="qr"></div>
                                                </div>
                                            </div>
                                        </div>
                               </div>
                           </div>
                           <div class="row noprint">
                                <div class="col-md-6">
                                    <button onclick="print()" class="btn btn-success">Print Document</button>
                                    <button onclick="window.location.reload()" class="btn btn-windows">Home</button>
                                </div>
                           </div>
        <?php
        $this->generateQR($id);
 }
 function getADP($date){
    $d=explode(".",$date);
    if($d[1]>6){
        return $d[2] . "/ ". (int)$d[2]+1;
    }
    else{
        return $d[2]-1 . "/ ". (int)$d[2];
    }
 }
}