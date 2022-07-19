<?php
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
// header('Access-Control-Allow-Headers: token, Content-Type');
include 'admin.php';