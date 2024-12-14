<?php
require "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
$udid = ExploitPatch::remove($_POST["udid"]);
$userName = ExploitPatch::charclean($_POST["userName"]);
$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
$query->execute([':userName' => $userName]);
if($query->rowCount() == 0) exit("-1");
$accountID = $query->fetchColumn();
$pass = 0;
if(!empty($_POST["password"])) $pass = GeneratePass::isValidUsrname($userName, $_POST["password"]);
elseif(!empty($_POST["gjp2"])) $pass = GeneratePass::isGJP2ValidUsrname($userName, $_POST["gjp2"]);
if($pass == 1) {
	$gs->logAction($accountID, 2);
	$userID = $gs->getUserID($accountID, $userName);
	if(!is_numeric($udid)) {
		$query2 = $db->prepare("SELECT userID FROM users WHERE extID = :udid");
		$query2->execute([':udid' => $udid]);
		$usrid2 = $query2->fetchColumn();
		$query2 = $db->prepare("UPDATE levels SET userID = :userID, extID = :extID WHERE userID = :usrid2");
		$query2->execute([':userID' => $userID, ':extID' => $accountID, ':usrid2' => $usrid2]);	
	}
	exit($accountID.",".$userID);
} elseif($pass == '-1') exit('-12');
exit('-1');
?>