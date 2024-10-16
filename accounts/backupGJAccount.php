<?php
chdir(dirname(__FILE__));
if(function_exists("set_time_limit")) set_time_limit(0);
if(function_exists("ini_set")) {
	ini_set("memory_limit","128M");
	ini_set("post_max_size","50M");
	ini_set("upload_max_filesize","50M");
}
require "../config/security.php";
require "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/mainLib.php";
require_once "../incl/lib/exploitPatch.php";
$gs = new mainLib();
$userName = ExploitPatch::charclean($_POST["userName"]);
$password = !empty($_POST["password"]) ? $_POST["password"] : "";
$saveData = ExploitPatch::remove($_POST["saveData"]);

if(empty($_POST["accountID"])) {
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchColumn();
} else $accountID = ExploitPatch::number($_POST["accountID"]);

if(!is_numeric($accountID)) exit("-1");

$pass = 0;
if(!empty($_POST["password"])) $pass = GeneratePass::isValid($accountID, $_POST["password"]);
elseif(!empty($_POST["gjp2"])) $pass = GeneratePass::isGJP2Valid($accountID, $_POST["gjp2"]);
if($pass == 1) {
	$saveDataArr = explode(";",$saveData);
	$saveData = ExploitPatch::url_base64_decode($saveDataArr[0]);
	$saveData = gzdecode($saveData);
	$orbs = explode("</s><k>14</k><s>",$saveData)[1];
	$orbs = explode("</s>",$orbs)[0] ?? 0;
	$lvls = explode("<k>GS_value</k>",$saveData)[1];
	$lvls = explode("</s><k>4</k><s>",$lvls)[1];
	$lvls = explode("</s>",$lvls)[0] ?? 0;
	$saveData = str_replace("<k>GJA_002</k><s>".$password."</s>", "<k>GJA_002</k><s>password</s>", $saveData);
	$saveData = gzencode($saveData);
	$saveData = ExploitPatch::url_base64_encode($saveData);
	$saveData = $saveData . ";" . $saveDataArr[1];
	file_put_contents("../data/accounts/$accountID",$saveData);
	file_put_contents("../data/accounts/keys/$accountID","");
	$query = $db->prepare("UPDATE `users` SET `orbs` = :orbs, `completedLvls` = :lvls WHERE extID = :extID");
	$query->execute([':orbs' => $orbs, ':extID' => $accountID, ':lvls' => $lvls]);
	$gs->logAction($accountID, 5, $userName, filesize("../data/accounts/$accountID"), $orbs, $lvls);
	echo "1";
} else {
	$gs->logAction($accountID, 7, $userName, strlen($saveData));
	echo "-1";
}
?>
