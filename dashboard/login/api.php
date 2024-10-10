<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/mail.php";
require "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_POST["userName"]) AND isset($_POST["password"])){
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$valid = GeneratePass::isValidUsrname($userName, $password);
	if($valid != 1) {
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
	exit(json_encode(["success" => true, "user" => $userName, "accountID" => $accountID, "auth" => $auth["auth"], "color" => $color]));
} elseif(isset($_GET["auth"])) {
	$auth = ExploitPatch::charclean($_GET["auth"]);
	if(empty($auth)) exit(json_encode(['success' => false, 'error' => '-3']));
	$check = GeneratePass::isValidToken($auth);
	if(!is_array($check)) exit(json_encode(['success' => false, 'error' => $check]));
	else exit(json_encode(['success' => true, 'accountID' => $check['accountID'], 'userID' => $check['userID'], 'user' => $check["userName"], 'color' => $check['color']]));
} else exit(json_encode(['success' => false, 'error' => '0']));
?>