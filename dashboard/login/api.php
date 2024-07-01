<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/exploitPatch.php";
include "../".$dbPath."config/security.php";
include "../".$dbPath."config/mail.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_POST["userName"]) AND isset($_POST["password"])){
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$valid = GeneratePass::isValidUsrname($userName, $password);
	if($valid != 1){
      	if($valid == -2) exit(json_encode(['success' => false, 'error' => '-2']));
		exit(json_encode(['success' => false, 'error' => '-1']));
	}
	$accountID = $gs->getAccountIDFromName($userName);
	if($accountID == 0) exit(json_encode(['success' => false, 'error' => '-3']));
  	$query = $db->prepare("SELECT auth FROM accounts WHERE accountID = :id");
  	$query->execute([':id' => $accountID]);
  	$auth = $query->fetch();
    if($auth["auth"] == 'none') {
          $auth = $gs->randomString(8);
          $query = $db->prepare("UPDATE accounts SET auth = :auth WHERE accountID = :id");
          $query->execute([':auth' => $auth, ':id' => $accountID]);
		  $auth["auth"] = $auth;
    }
	$color = $gs->getAccountCommentColor($accountID);
	exit(json_encode(["success" => true, "user" => $userName, "id" => $accountID, "auth" => $auth["auth"], "color" => $color]));
} elseif(isset($_GET["auth"])) {
	$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '6' AND timestamp > :time AND value2 = :ip");
	$query6->execute([':time' => time() - (60*60), ':ip' => $gs->getIP()]);
	if($query6->fetchColumn() > 20) exit(json_encode(['success' => false, 'error' => '-3']));
	$auth = ExploitPatch::remove($_GET["auth"]);
	if(empty($auth)) exit(json_encode(['success' => false, 'error' => '-3']));
	$query = $db->prepare("SELECT userName, accountID FROM accounts WHERE auth = :id");
  	$query->execute([':id' => $auth]);
  	$fetch = $query->fetch();
	if(!$fetch[0]) {
		$query = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES ('6',:accid,:time,:ip)");
		$query->execute([':accid' => 0, ':time' => time(), ':ip' => $gs->getIP()]);
		exit(json_encode(['success' => false, 'error' => '-4']));
	} else exit(json_encode(['success' => true, 'user' => $fetch["userName"], 'color' => $gs->getAccountCommentColor($fetch["accountID"])]));
} else exit(json_encode(['success' => false, 'error' => '0']));
?>