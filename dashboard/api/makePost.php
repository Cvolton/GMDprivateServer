<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."incl/lib/automod.php";
require_once "../".$dbPath."incl/lib/GJPCheck.php";
require_once "../".$dbPath."config/misc.php";
$gs = new mainLib();
if(!isset($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);
$accountID = GJPCheck::getAccountIDOrDie(true);
if(!$accountID) {
	http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'Please supply a valid account credentials.'])); 
}
$body = trim(ExploitPatch::rucharclean($_POST['body']));
if(empty($body)) {
	http_response_code(400);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => 'Please enter post message.'])); 
}
$userID = $gs->getUserID($accountID);
$checkBan = $gs->getPersonBan($accountID, $userID, 3);
if($checkBan) {
	http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 3, 'message' => 'You are banned!', 'reason' => base64_decode($checkBan['reason']), 'expires' => $checkBan['expires']])); 
}
$query = $db->prepare("SELECT timestamp FROM acccomments WHERE userID = :userID ORDER BY timestamp DESC LIMIT 1");
$query->execute([':userID' => $userID]);
$res = $query->fetch();
$time = time() - 5;
if($res["timestamp"] > $time) {
	http_response_code(400);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 4, 'message' => 'You send posts too fast.'])); 
}
if($enableCommentLengthLimiter && strlen($body) > $maxAccountCommentLength) {
	http_response_code(400);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 5, 'message' => 'Your post is too long.'])); 
} else {
	$accountUsername = $gs->getAccountName($accountID);
	$body = ExploitPatch::url_base64_encode($body);
	$query = $db->prepare("INSERT INTO acccomments (userID, userName, comment, timestamp) VALUES (:userID, :name, :body, :time)");
	$query->execute([':userID' => $userID, ':name' => $accountUsername, ':body' => $body, ':time' => time()]);
	$gs->logAction($accountID, 14, $accountUsername, $body, $db->lastInsertId());
	Automod::checkAccountPostsSpamming($userID);
	exit(json_encode(['dashboard' => true, 'success' => true])); 
}
exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 6, 'message' => 'Unexpected error.'])); 
?>