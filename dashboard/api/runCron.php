<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/cron.php";
require_once "../".$dbPath."incl/lib/GJPCheck.php";
if(!isset($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);

$accountID = GJPCheck::getAccountIDOrDie(true) ?: $_SESSION['accountID'];
if(!$accountID) {
	http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'Please supply a valid account credentials.'])); 
}

$runCron = Cron::doEverything($accountID, true);
if(!$runCron) {
	http_response_code(400);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => 'Please wait a few minutes before running Cron again.'])); 
}

exit(json_encode(['dashboard' => true, 'success' => true])); 
?>