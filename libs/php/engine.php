 <?php
session_start();


if(isset($_SESSION["user"])){
    $userx=$_SESSION["user"];
    $role=$userx["role"];
    $uid=$userx["id"];
    $district=$userx["did"];
    $region=$userx["rid"];
    $council=$userx["cid"];
    $email=$userx["email"];
    $zone=$userx["zone"];
}
else{
    $role=0;
    $uid=0;
    $zone=0;
    $district=0;
    $region=0;
    $council=0;
    $userx=[];
    // header("location:http://upas.spvafrica.com");
}
require_once 'auth.php';
require_once 'gui.php';
require_once 'upas.php';
require_once '../../rup/rup.php';
require_once '../../user/user.php';
require_once '../../purchase/purchase_drawing.php';
require_once '../../admin/admin.php';
require_once '../../downloads/downloads.php';
require_once 'settings.php';
require_once 'maintainance.php';
require_once 'report.php';
require_once 'formbuilder.php';
require_once 'formGlue.php';
$auth=new auth();
$gui=new upas_gui();
$user=new user();
$admin=new admin();
$rup=new rup();
$form=new FormBuilder();
$settings=new settings();
$dl=new downloads();
$pc = new purchase_drawing();
$main=new upasActions();
$report=new Report();
$glue=new glue();
$report->role=$role;
$report->cid=$council;
$report->rid=$region;
$main->role=$role;
$user->rid=$region;
$user->cid=$council;
$main->user=$userx;
$date=date("d-M-Y H:i:s");
if(isset($_POST)){
    $c_POST=$auth->sanitize_array($_POST);
}
if(isset($_POST["key"]) && isset($_POST["val"])){
    $key=$auth->sanitize($_POST["key"]);
    $val=$auth->sanitize($_POST["val"]);
    if($key=="view_req"){
        $user->docview($val,$role);
    }
    if($key=="viewForm"){
        $glue->viewFormSelf($val);
    }
    elseif($key=="mapCall"){
        $report->homeReport($val,"c");
    }
    elseif($key=="regCall"){
        $report->homeReport($val,"r");
    }
    elseif($key=="masterplan_properties"){
        $rup->choose_view($region);
    }
    elseif($key=="loadForm"){
        $form->addQuestion($val);
    }
    elseif($key=="overlapwithdoc"){
        if($role=="rup"){
            $rup->list_requests($role,$region);
        }
        else if($role=="zup"){
            $rup->list_requests($role,$zone);
        }
        else if($role=="min"){
            $rup->list_requests($role,0);
        }
        else if($role=="hod" || $role=="atpo"){
            $rup->list_requests($role, $council);
        }
        else{
            $rup->list_requests($role,$uid);
        }
        
    }
    else if($key=="overlapwithall"){
        if($role=="rup"){
            $rup->overlap_with_all_docs($role, $region, $region);
        }
        else if($role=="zup"){
            $rup->overlap_with_all_docs($role, $zone, $region);
        }
        else if($role=="min"){
            $rup->overlap_with_all_docs($role, 0, $region);
        }
        else if($role=="hod" || $role=="atpo"){
            $rup->overlap_with_all_docs($role, $council, $region);
        }
        else{
            $rup->overlap_with_all_docs($role, $uid, $region);
        }
    }
    elseif($key=="select_tp"){
        $_SESSION["color"]=0;
        $rup->get_request_masterplan($val,$region);
    }
    elseif($key=="appeal"){
        $user->appeal_doc($val);
    }
    elseif($key=="viewAnswer"){
        $glue->displayFormAnswers($val);
    }
    elseif($key=="view_file"){
        $gui->form_script("app");
        $rup->file_viewer($val);
    }
    elseif($key=="get_district"){
        $gui->form_script("app");
        $dl->get_district($val);
    }
    elseif($key=="get_council"){
        $gui->form_script("app");
        $dl->get_halmashauri($val);
    }
    elseif($key=="get_ward"){
        $gui->form_script("app");
        $dl->get_kata($val);
    }
    elseif($key=="get_ward_maps"){
        $gui->form_script("app");
        $dl->get_kata_maps($val);
    }
    elseif($key=="sel_dist"){
        $gui->form_script("app");
        $admin->adddistrict_fom($val);
    }
    elseif($key=="sel_dis"){
        $gui->form_script("app");
        $admin->get_districts($val);
    }
    elseif($key=="updateStatus"){
        $admin->updateUserStatus($val);
        $admin->userList();
    }
    elseif($key=="add_cou"){
        $gui->form_script("app");
        // $admin->add_council_fom($did);
    }
    elseif($key=="view_d"){
        $dl->preview_dom_tp($val);
    }
    elseif($key=="init_pay"){
        $pc->init_payment($val);
    }
    elseif($key=="download_d"){
        $dl->initiate_download_payment($val);
    }
    elseif ($key=="verify_payment") {
        $pc->verify_payment($val);
    }
    elseif ($key=="edit_doc"){
        $main->editRequest($val);
    }
    elseif($key=="alause"){
        
    }
    else{
        $gui->toast("Action not defined");
    }
}

if(isset($_POST["tracker"])){
    $tr=$auth->sanitize($_POST["tracker"]);
    if($tr=="layer_selector"){
        $layer=$auth->sanitize($_POST["layer"]);
        $rup->layer_selector($region,$layer);
    }
    if($tr=="adfm"){
        $form->saveForm($c_POST);
    }
    if($tr=="glass_quick"){
        $glue->saveFormToDb($c_POST);
        $glue->allForms($role);
    }
    if($tr=="addqn"){
        $form->formQuery($c_POST);
    }
    if($tr=="createInput"){
        $form->saveInput($c_POST);
    }
    if($tr=="createselect"){
        $form->saveSelect($c_POST);
    }
    if($tr=="createTable"){
        $form->saveTable($c_POST);
    }
    if($tr=="filters"){
        $mp_id=$auth->sanitize($_POST["mid"]);
        $filter=$_POST["prop"];
        $rup->prepare_masterplan($filter,$mp_id);
    }
    if($tr=="layers"){
        $_SESSION["color"]=0;
        $filter=$_POST["prop"];
        $rup->add_layers($filter);
    }
    if($tr=="adduser"){

        $main->addInternalUser($c_POST);
        $admin->adduserform();
        // $auth->registeruser($fname,$email,$phone,$role,$reg,$gender);
        // echo $dd;
    }
    if($tr=="adTP"){
        $main->addTP($c_POST);
        $admin->tpManager();
    }
    if($tr=="resetPWD"){
        $main->resetPWD($c_POST);
    }
    if($tr=="dailyRep"){
        $report->saveDailyReport($c_POST);
    }
    if($tr=="adReg"){
        $admin->add_region($c_POST);
        $admin->regionManagement();
    }
    if($tr=="adDis"){
        $admin->add_district($c_POST);
        $admin->regionManagement();
    }
    if($tr=="adCouncil"){
        $admin->add_council($c_POST);
        $admin->regionManagement();
    }
    if($tr=="registration"){
        $main->registerApplicant($c_POST);
    }
    if($tr=="updateChecklist"){
        $main->updateChecklist($c_POST);
        $user->docview($auth->select_tbl("request","*","uniqid='".$c_POST["rid"]."'")[0]["id"],$_SESSION["user"]["role"]);
    }
    if($tr=="addward"){
        $w=$auth->sanitize($_POST["wname"]);
        $admin->addward($w,$council);
    }
    if($tr=="verify_token"){
        $cn=$auth->sanitize($_POST["cn"]);
        $pc->verify_payment($cn);
    }
    if($tr=="upd_pwd"){
        $pwd=$auth->sanitize($_POST["cpwd"]);
        $npwd=$auth->sanitize($_POST["npwd"]);
        $cnpwd=$auth->sanitize($_POST["cnpwd"]);
        $settings->change_pwd($pwd, $npwd, $cnpwd, $uid,$userx);
    }
    if($tr=="view_mp"){
        $mpid=$auth->sanitize($_POST["mid"]);
        $filter=$_POST["filters"];
        $arrayed=[];
        foreach ($filter as $param){
            $arrayed[$param]=$_POST[$param];
        }
        $rup->view_masterplan($mpid,$filter,$arrayed);
    }
    if($tr=="login"){
        $email=$auth->sanitize($_POST['email']);
        $password=$auth->sanitize($_POST['password']);
        if($email!=false && $password!=false){
            $auth->login($email, $password);
        }
        
    }
    if($tr=="geo_masterplan"){
        if(isset($_FILES['geojson'])){
            $val=$_SESSION["docid"];
            $filename=$auth->upload_file($_FILES['geojson'], "attachment", "Drawing File", ["geojson"], 3000000000,NULL);
            $arr=array();
            if($filename[0]!=false){
                $mpx=$auth->ins_to_db("docs", ["name","type","rid"], [$filename[1],"Shape Layer",$val]);
                $auth->upd_to_db("councils", "masterpan='$mpx'", "id='$council'");
                $arr['status']="ok";
            }
            else{
                $arr['status']=$filename[1];
            }
            echo json_encode($arr);
        }
    }
    if($tr=="ver"){
        $pc->verify_payment($id);
    }
}
if(isset($_POST['call'])){
    $call=$auth->sanitize($_POST['call']);
    if($call=="auser"){
        $admin->adduserform();
    }
    if($call=="crform"){
        $form->createForm();
    }
    elseif($call=="tpr"){
        $admin->tpManager();
    }
    else if($call=="docs"){
        $user->open_gui($uid);
    }
    elseif($call=="qf"){
        $glue->allForms($role);
    }
    else if($call=="reports"){
        $report->home();
    }
    //Dashboard
    else if($call=="dashboard"){
        // $gui->admin_dashboard();
        $main->dashboard();
    }
    else if($call=="gis"){
        $main->mapView();
    }
    else if($call=="dashboard_atpo"){
        $gui->atpo_dashboard();
    }
    //Admin
    else if($call=="vusers"){
        $admin->userList();
    }
    else if($call=="kata_man"){
        $admin->list_wards($council);
    }
    else if($call=="aregion"){
        $admin->areas();
    }
    else if($call=="settings"){
        $settings->preview_profile($userx);
    }
    else if($call=="cpadd"){
        $user->compilationList();
    }
    elseif($call=="rdm"){
        $admin->regionManagement();
    }
    elseif($call=="dailyRep"){
        $report->dailyReport();
    }
    elseif($call=="alause") {
       $admin->addLandUse();
    }
    elseif ($call=="azone") {
        $head=array("Zone Name","Action");
        $gui->button(["action","null","Add New Zone","add_zone"]);
        $val=$admin->select_tbl("district", ["name",["button","id","View Zone","view_zone"]], NULL);
        $gui->card(["table",[$head,$val]],"col-md-6 offset-3","light");
    }
    else if ($call=="adistricts") {
        //        $head=array("District Name","Region","Action");
        $admin->districts();
        //        $gui->button(["action","null","Add New District","add_district"]);
        //        $val=$auth->select_tbl("district", ["name","region",["button","id","View District","view_district"]], NULL);
        //        $gui->card(["table",[$head,$val]],"col-md-6 offset-3","light");
        
        //        $gui->card($contents, $size, $color_class);
    }
    else if($call=="acouncil"){
        $admin->councils();
    }
    //Verify and Comment
    elseif ($call=="verif") {
        $head=array("Name","Date","Status","Action");
        $user->pending_reqs("*",$role);
    }
    elseif($call=="adoc"){
        $user->addocform();
    }
    else if($call=="tpoadd"){
        $gui->addtpoform();
    }
    //Regional Officer
    elseif ($call=="masterplan") {
        $hid=$council;
        $rup->open_gui($hid);
        //        $head=array("Name","Date","Status","Action");
        //        $gui->button(["action","null","Add New Request","add_doc"]);
        //        $val=$auth->select_tbl("request", ["name","date","status",["button","id","View Request","view_doc"]], "status='pending' ORDER BY id DESC");
        //        $gui->card(["table",[$head,$val]],"col-md-6 offset-3","light");
    }
    else if($call=="stats"){
        $user->statistics();
    }
    else{
        echo "Error Kronix";
    }
}
if(isset($_POST["generate_report"])){
    $report->generate($c_POST);
}
if(isset($_POST['req'])){
    $req=$auth->sanitize($_POST['req']);
    if(isset($_GET['id'])){
        $id=$auth->sanitize($_GET['id']);
        if($req=="view_user"){
            $gui->view_user($admin->pull_user($id));
        }
        else if($req=="add_region"){
            $gui->card(["region_fom",""],"col-4 offset-4","light");
        }
        // else if($req=="add_doc"){
        //     echo "<div class='card-panel'>";
        //     // $->addocform();
        //     echo "</div>";
        // }
        elseif ($req=="add_district"){
            echo "<div class='card-panel col-4 offset-4'>";
            $admin->adddistrict_fom(null);
            echo "</div>";
        }
        elseif($req=="view_doc"){
        //       echo "<div class='card-panel col-4 offset-4'>";
            
        }
    }
}
if(isset($_POST['region_di'])){
    
}
if(isset($_POST['district_d'])){
    $regname=$auth->sanitize($_POST['regname']);
    $district=$auth->sanitize($_POST['disname']);
    $auth->ins_to_db("district", ["name","rid"], [$district,$regname]);
}
if(isset($_GET['sect'])){
    $id=$auth->sanitize($_POST['id']);
    if($_GET['sect']=="sel_dis"){
        $gui->select_input_query("did", $auth->select_tbl("district",["id","name"],"rid='$id'"), "Select District", "counci", "wilaya","new","selco");
    }
    elseif($_GET['sect']=="selco"){
        $gui->select_input_query("cid", $auth->select_tbl("councils","*","did='$id'"),"Select Council","war","councix","new","selwa");
    }
}
if(isset($_FILES['report'])){
    $val=$_SESSION["docid"];
    $filename=$auth->upload_file($_FILES['report'], "attachment", "Drawing File", ["pdf"], 3000000000,NULL);
    $arr=array();
    if($filename[0]!=false){
        $auth->ins_to_db("docs", ["name","type","rid","doc_name"], [$filename[1],"Planning Brief",$val,"PDF document"]);
        $arr['status']="ok";
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($arr);
}
if(isset($_FILES['dwg'])){
    $val=$_SESSION["docid"];
    $filename=$auth->upload_file($_FILES['dwg'], "attachment", "Drawing File", ["dwg","dxf","DXF","DWG"], 3000000000,NULL);
    $arr=array();
    if($filename[0]!=false){
        $auth->ins_to_db("docs", ["name","type","rid","doc_name"], [$filename[1],"Drawing Files",$val,"Drawing File (.dwg)"]);
        $arr['status']="ok";
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($arr);
}
if(isset($_FILES['appeal_doc'])){
    $val=$_SESSION["docidd"];
    $filename=$auth->upload_file($_FILES['appeal_doc'], "attachment", "Drawing File", ["pdf"], 3000000000,NULL);
    $arr=array();
    if($filename[0]!=false){
        $auth->ins_to_db("docs", ["name","type","rid","doc_name"], [$filename[1],"appeal PDF document",$val,"Appeal Document"]);
        $arr['status']="ok";
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($arr);
}
if(isset($_FILES['geojson'])){
    $val=$_SESSION["docid"];
    $filename=$auth->upload_file($_FILES['geojson'], "attachment", "Drawing File", ["kml","KML"], 3000000000000,NULL);
    $arr=array();
    if($filename[0]!=false){
        $auth->ins_to_db("docs", ["name","type","rid","doc_name"], [$filename[1],"KML Layer",$val,"KML LAYER (.kml)"]);
        $arr['status']="ok";
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($arr);
}

if(isset($_FILES['geojson_masterplan'])){
    $val="MASTERPLAN";
    $filename=$auth->upload_file($_FILES['geojson_masterplan'], "attachment", "Masterplan_Halmashauri", ["geojson","GeoJSON"], 30000000000000,NULL);
    $dope=array();
    if($filename[0]==true){
        $i=$auth->ins_to_db("docs", ["name","type","rid"], [$filename[1],"Masterplan",$val]);
        $auth->upd_to_db("region", "masterplan='$i'", "id='$region'");
        $python=json_decode(shell_exec("python ../python/jsonparser.py $filename[1] $i Zone_Name"),true);
        // echo $python;
        foreach($python as $em){
            $filename = str_replace("/","",$em);
            $filename = str_replace(" ","_",$filename);
            $auth->ins_to_db("docs",["doc_name","name","rid"],[str_replace("","",$em),$i.$filename.".geojson",$i]);
        }
        //        $arr['status']="ok";
        $dope["status"]="ok";
        $dope["message"]="Masterplan has been uploaded Successfully";
        $dope["script"]=resetform;
        //        echo json_encode($dope);
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($dope);
}
if(isset($_FILES['geojson_masterplan_density'])){
    $val="";
    $filename=$auth->upload_file($_FILES['geojson_masterplan_density'], "attachment", "Masterplan_region", ["geojson","GeoJSON"], 30000000000000,NULL);
    $dope=array();
    if($filename[0]!=false){
        $i=$auth->ins_to_db("docs", ["name","type","rid"], [$filename[1],"Masterplan",$val]);
        $auth->upd_to_db("region", "densityplan='$i'", "id='$region'");
        $python=json_decode(shell_exec("python ../python/jsonparser.py $filename[1] $i Density"),true);
        // echo $python;
        foreach($python as $em){
            if($em!="None"){
                $filename = str_replace("/","",$em);
                $filename = str_replace(" ","_",$filename);
            }
            else{
                $filename="nil";
            }
            $auth->ins_to_db("docs",["doc_name","name","rid"],[str_replace("","",$em),$i.$filename.".geojson",$i]);
        }
        //        $arr['status']="ok";
        $dope["status"]="ok";
        $dope["message"]="Masterplan has been uploaded Successfully";
        $dope["script"]=resetform;
        //        echo json_encode($dope);
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($dope);
}
if(isset($_FILES['extra'])){
        $val=$_SESSION["docid"];
    $filename=$auth->upload_file($_FILES['extra'], "attachment", "Drawing File", ["dwg","pdf","jpg","png","jpeg"], 3000000000,NULL);
    $arr=array();
    if($filename[0]!=false){
        $auth->ins_to_db("docs", ["name","type","rid"], [$filename[1],"Comment",$val]);
        $arr['status']="ok";
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($arr);
}
if(isset($_FILES['mins'])){
    $val=$_SESSION["docid"];
    $filename=$auth->upload_file($_FILES['mins'], "attachment", "Drawing File", ["pdf"], 3000000000,NULL);
    $arr=array();
    if($filename[0]!=false){
        $auth->ins_to_db("docs", ["name","type","rid"], [$filename[1],"Minutes of Meeting",$val]);
        $_SESSION["mom"]=1;
        $arr['status']="ok";
    }
    else{
        $arr['status']=$filename[1];
    }
    echo json_encode($arr);
}

if(isset($_POST['comment'])){
    $val=$_SESSION["docid"];
    $comment=$auth->sanitize($_POST['comment']);
    $status=$auth->sanitize($_POST['stat']);
    $rid=$auth->sanitize($_POST['rid']);
    $com=$comment;
    $auth->ins_to_db("comment", ["comment","status","rid","uniqid","date","uid"], [$com,$status,$rid,$val,$date,$uid]);
    $dope=array();
    $doper["response"]=resetform.hideloader;
    $doper["status"]="ok";
    if($role=="atpo"){
        $auth->upd_to_db("request", "atpo='$status'", "uniqid='$rid'");
        $doper["message"]="Request has been ".$status;
    }
    else if($role=="hod"){
        $doper["message"]="Request has been ".$status;
        if(isset($_SESSION["mom"]) && $_SESSION["mom"]==1){
            $auth->upd_to_db("request", "hod='$status'", "uniqid='$rid'");
            $doper["message"]="Request has been ".$rid;
        }
        else{
            $doper["message"]="Please Upload Minutes of Meetings";
        }
    }
    else if($role=="rup"){
        $auth->upd_to_db("request", "rup='$status' AND status='$status'", "uniqid='$rid'");
        $doper["message"]="Request has been ".$status;
    }
    // else if($role=="zonal"){
    //     $auth->upd_to_db("request", "lev2='$status'", "uniqid='$rid'");
    //     $doper["message"]="Request has been ".$status;
    // }
    // else if($role=="min"){
    //     $auth->upd_to_db("request", "lev3='$status' AND status='$status'", "uniqid='$rid'");
    //     $doper["message"]="Request has been ".$status;
    // }
    else{
        $doper["message"]="$role";
    }
    if($status=="denied"){
        $auth->upd_to_db("request", "status='$status'", "uniqid='$rid'");
    }
    $user->pending_reqs("*",$_SESSION["user"]["role"]);
    $gui->toast("Request has been ".$status);
}

if(isset($_POST['appeal'])){
    $reason=$auth->sanitize($_POST['reason']);
    $f=$auth->ins_to_db("appeal_requests",["req_uniqid","reason"],[$_SESSION["docid"],$reason]);
    $gui->toast("The appeal request has been fowarded to the Ministry");
    $user->open_gui($uid);
}

if(isset($_POST['ad_document'])){
    $d=$auth->sanitize_array($_POST);
    $d["uid"]=$uid;
    $main->addRequest($d);
    // $val=$_SESSION["docid"];
    // $name=$auth->sanitize($_POST['name']);
    // $dno=$auth->sanitize($_POST['dno']);
    // $type=$auth->sanitize($_POST["type"]);
    // $dscale=$auth->sanitize($_POST['scale']);
    // $basemap=$auth->sanitize($_POST['basemap']);
    // $cname=$auth->sanitize($_POST['cname']);
    // $sname=$auth->sanitize($_POST['sname']);
    // $dname=$auth->sanitize($_POST['dname']);
    // $cha=$auth->sanitize($_POST["land_from"]);
    // $cht=$auth->sanitize($_POST["land_to"]);
    // $cn=$auth->sanitize($_POST['cn']);
    // $region=$auth->sanitize($_POST["rid"]);
    // $cid=$auth->sanitize($_POST["cid"]);
    // $valu=array();
    // $date_o=date("d-M-Y H:i:s");
    // array_push($valu, $dname);
    // array_push($valu, $dno);
    // array_push($valu, $dscale);
    // array_push($valu, $cname);
    // array_push($valu, $sname);
    // array_push($valu, $name);
    // $lause=$_POST['lause'];
    // $use_l=array();
    // foreach($lause as $use){
    //     if($use!=false){
    //         array_push($use_l, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "use";
    //     }
    // }
    // $noplot=$_POST['noplot'];
    // $plot_no=array();
    // foreach($noplot as $use){
    //     if($use!=false){
    //         array_push($plot_no, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "plot";
    //     }
    // }
    // $total_p=$_POST['totalpercent'];
    // $p_total=array();
    // foreach($total_p as $use){
    //     if($use!=false){
    //         array_push($p_total, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "tot";
    //     }
    // }
    // $area=$_POST['area'];
    // $area_l=array();
    // foreach($area as $use){
    //     if($use!=false){
    //         array_push($area_l, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "area";
    //     }
    // }
    // $rev=$_POST['rev'];
    // $rev_l=array();
    // foreach($rev as $use){
    //     if($use!=false){
    //         array_push($rev_l, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "rev";
    //     }
    // }
    // $rev_date=$_POST['date'];
    // $rd_l=array();
    // foreach($rev as $use){
    //     if($use!=false){
    //         array_push($rd_l, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "date";
    //     }
    // }
    // $adjoining=$_POST['Adjoining'];
    // $adj_l=array();
    // foreach($adjoining as $use){
    //     if($use!=false){
    //         array_push($adj_l, $use);
    //     }
    //     else{
    //         array_push($valu, $use);
    //         // echo "adjoining";
    //     }
    // }
    
    
    // //    WANANGU NA WANAAOOOO
    // //    
    // //    Niggas
    // if(in_array(false, $valu)==false){
    //     $c=count($use_l);
    //     for($i=0;$i<$c;$i++){
    //         $land_u=$use_l[$i];
    //         $plotno=$plot_no[$i];
    //         $area_v=$area_l[$i];
    //         $po_total=$p_total[$i];
    //         $auth->ins_to_db("land_use", ["lause","noplots","area","total","rid"], [$land_u,$plotno,$area_v,$po_total,$val]);
    //     }
    //     $d=count($adj_l);
    //     for($i=0;$i<$d;$i++){
    //         $adj=$adj_l[$i];
    //         $auth->ins_to_db("adjoining", ["adjoining","rid"], [$adj,$val]);
    //     }
    //     $e=count($rev_l);
    //     for($i=0;$i<$e;$i++){
    //         $revs=$rev_l[$i];
    //         $date=$rd_l[$i];
    //         $auth->ins_to_db("revision", ["revision","date","rid"], [$revs,$date,$val]);
    //     }
    //     // $cn=$pc->request_control_number();
    //     // $cn=$
    //     $wid=$auth->sanitize($_POST["ward"]);
    //     $auth->ins_to_db("request", ["name","wid","date","uniqid","scale","cname","sname","dname","dno","rid","cid","did","uid","cn","dateReport","chafro","chato","type"], [$name,$wid,$date_o,$val,$dscale,$cname,$sname,$dname,$dno,$region,$council,$district,$uid,$cn,date("Ymd"),$cha,$cht,$type]);
    //     $dope=array();
    //     $dope["status"]="ok";
    //     $dope["message"]="";
    //     // $auth->send_mail($email, "Your TP Drawing has been added to the system","In order for your request to become active you are required to pay 200,000TSH \n Pay through this Control number : $cn");
    //     $dope["script"]=resetform;
    //     // echo json_encode($dope);
    //     $gui->toast("Your request has been added Successfully, please make sure you have paid the fee");
    //     $user->open_gui($uid);
    // }
}