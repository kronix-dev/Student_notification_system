<?php
session_start();
require_once '../libs/php/auth.php';
require_once '../libs/php/bs_gui.php';
require_once 'user.php';
require_once 'admin.php';
require_once 'Instructors.php';
require_once 'notifications.php';
require_once 'courses.php';
require_once 'student.php';
require_once 'subjects.php';
require_once 'panels.php';
require_once 'automatedNotifications.php';
require_once 'venue.php';
require_once 'delete.php';
$auth = new auth();
$gui = new gui();
$use = new user();
$d = $use->menus();
$pn = new Panels();
$s = new subject();
$c = new Courses();
$a = new NTAdmin();
$v = new VenueRequest();
$st = new Students();
$del = new DeleteItems();
$use->role = $_SESSION["user"]["role"];
$use->id = $_SESSION["user"]["user_id"];

if (isset($_POST) && isset($_SESSION["user"])) {
    $gui->form_script('engine.php');
    $p = $auth->sanitize_array($_POST);
    $p["uid"] = $_SESSION["user"]["id"];
    $p["role"] = $_SESSION["user"]["role"];
    $n = new Notifications($p);
    $aiN = new AINotification($p);
    if (isset($p["t"])) {
        switch ($p["t"]) {
            case "adc":
                $c->saveCourse($p);
                $c->addCourse();
                break;
            case "preform":
                $c = $cpu->saveForm($p);
                $use->uploadFiles($c);
                break;
            case "ads":
                $s->saveSubject($p);
                $s->AddSubject();
                break;
            case "adu":
                $a->saveUser($p);
                $a->addUser();
                break;
            case "adn":
                $n->sendNotification();
                $n->addNotification();
                break;
            case "adss":
                $aiN->saveSession();
                $aiN->addSession();
                break;
            case "adv":
                $v->saveVenue($p["name"], $p["capacity"]);
                $v->addVenue();
                break;
            case "adstu":
                $st->addStudent($p);
                $st->studentForm();
                break;
            case "vrf":
                $v->requestForm2($p);
                break;
            case "fgrf":
                $v->dialog("check", "Venue has been booked successfully", "success", "12", 0);
                $v->saveVenueRequest($p);
                $v->requestForm();
                break;
            default:
                break;
        }
    }
    if (isset($p["key"]) && isset($p["val"])) {
        $key = $p["key"];
        $val = $p["val"];
        switch ($key) {
            case "adn":
                $n->addNotification();
                break;
            case "adu":
                $a->addUser();
                break;
            case "adc":
                $c->addCourse();
                break;
            case "ads":
                $s->AddSubject();
                break;
            case "adss":
                $aiN->addSession();
                break;
            case "adv":
                $v->addVenue();
                break;
            case "adstu":
                $st->studentForm();
                break;
            case "du":
                $del->deleteUser($val);
                $pn->UserPanel();
                break;
            case "ds":
                $del->deleteSubject($val);
                $pn->SubjectsPanel();
                break;
            case "dc":
                $del->deleteCourse($val);
                $pn->CoursesPanel();
                break;
            case "dv":
                $del->deleteVenue($val);
                $pn->venuePanel();
                break;
            case "dss":
                $del->deleteSession($val);
                $pn->sessionPanel();
                break;
            case "dst":
                $del->deleteStudent($val);
                $pn->StudentsPanel();
                break;
            case "fvdv":
                $v->viewRequest($val);
        }
        if ($key == "menu") {
            unset($_SESSION["uniq"]);
            unset($_SESSION["vstat"]);
            switch ($val) {
                case "nfs":
                    $pn->NotificationPanel();
                    break;
                case "cus":
                    $pn->CoursesPanel();
                    break;
                case "uss":
                    $pn->UserPanel();
                    break;
                case "sus":
                    $pn->SubjectsPanel();
                    break;
                case "ven":
                    $pn->venuePanel();
                    break;
                case "ses":
                    $pn->sessionPanel();
                    break;
                case "stu":
                    $pn->StudentsPanel();
                    break;
                case "lgt":
                    $use->logout();
                    break;
                case "rv":
                    $v->requestForm();
                    break;
                case "vr":
                    $pn->venueRequestPanel();
                    break;
                default:
                    break;
            }
        }
    }
}
