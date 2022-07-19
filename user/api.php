<?php
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request");
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
require_once '../libs/php/auth.php';
require_once 'user.php';
require_once 'automatedNotifications.php';
require_once 'subjects.php';
require_once 'venue.php';
require_once 'admin.php';
require_once 'courses.php';
require_once 'notifications.php';
$input=file_get_contents('php://input');
$json = json_decode($input,false);
class API extends auth{
    public $p;
    function __construct($d){
        $this->p=$this->sanitize_array($d);
    }
    function readRequest(){
        $r=[];
        switch($this->p["argument"]){
            case "get":
                $r=$this->getRec();
                break;
            case "update":
                $r=$this->setRec();
            default:
                break;
        }
        echo json_encode($r);
    }
    function getRec(){
        $n = new Notifications($this->p);
        $ai = new AINotification($this->p);
        return $n->getUnsentNotifications();
    }
    function setRec(){
        $n = new Notifications($this->p);
        $n->updateUnsentNotifications($this->p["nid"]);
        return [];
    }
}
$n= new API($json);
$n->readRequest();