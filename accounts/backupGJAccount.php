<?php
ini_set("memory_limit","128M");
ini_set("post_max_size","50M");
ini_set("upload_max_filesize","50M");
include "../connection.php";
require "../incl/generatePass.php";
require_once "../incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$userName = $ep->remove($_POST["userName"]);
$pass2 = $_POST["password"];
$password = md5($pass2 . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$saveData = $ep->remove($_POST["saveData"]);
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
	$saveDataArr = explode(";",$saveData); //splitting ccgamemanager and cclocallevels
	$saveData = str_replace("-","+",$saveDataArr[0]); //decoding
	$saveData = str_replace("_","/",$saveData);
	$saveData = base64_decode($saveData);
	$saveData = gzdecode($saveData);
	$orbs = explode("</s><k>14</k><s>",$saveData)[1];
	$orbs = explode("</s>",$orbs)[0];
	$lvls = explode("<k>GS_value</k>",$saveData)[1];
	$lvls = explode("</s><k>4</k><s>",$lvls)[1];
	$lvls = explode("</s>",$lvls)[0];
	$saveData = str_replace($pass2, "not the actual password", $saveData); //replacing pass
	//file_put_contents($userName, $saveData);
	$saveData = gzencode($saveData); //encoding back
	$saveData = base64_encode($saveData);
	$saveData = str_replace("+","-",$saveData);
	$saveData = str_replace("/","_",$saveData);
	$saveData = $saveData . ";" . $saveDataArr[1]; //merging ccgamemanager and cclocallevels
	//$query = $db->prepare("UPDATE `accounts` SET `saveData` = :saveData WHERE userName = :userName");
	//$query->execute([':saveData' => $saveData, ':userName' => $userName]);
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName");
	$query->execute([':userName' => $userName]);
	$accountID = $query->fetchAll()[0]["accountID"];
	if(!is_numeric($accountID)){
		exit("-1");
	}
	file_put_contents("../data/accounts/$accountID",$saveData);
	$query = $db->prepare("SELECT extID FROM users WHERE userName = :userName LIMIT 1");
	$query->execute([':userName' => $userName]);
	$result = $query->fetchAll();
	$result = $result[0];
	$extID = $result["extID"];
	$query = $db->prepare("UPDATE `users` SET `orbs` = :orbs, `completedLvls` = :lvls WHERE extID = :extID");
	$query->execute([':orbs' => $orbs, ':extID' => $extID, ':lvls' => $lvls]);
	echo "1";
}
else
{
	echo -1;
}
?>