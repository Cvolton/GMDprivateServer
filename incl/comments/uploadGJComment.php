<?php
chdir(dirname(__FILE__));
//ini_set('display_errors', 1); 
//error_reporting(E_ALL);
include "../lib/connection.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
require_once "../lib/XORCipher.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../misc/commands.php";
$cmds = new Commands();
$gjp = $ep->remove($_POST["gjp"]);
$userName = $ep->remove($_POST["userName"]);
$comment = $ep->remove($_POST["comment"]);
$gameversion = 0;

$levelID = $ep->remove($_POST["levelID"]);
if(!empty($_POST["percent"])){
	$percent = $ep->remove($_POST["percent"]);
}else{
	$percent = 0;
}
if(!empty($_POST["accountID"]) AND $_POST["accountID"]!="0"){
	$id = $ep->remove($_POST["accountID"]);
	$register = 1;
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 0){
		exit("-1");
	}
	
	if($cmds->doCommands($id, $comment, $levelID)){
		exit("-10");
	}
}else{
	$id = $ep->remove($_POST["udid"]);
	$register = 0;
	if(is_numeric($id)){
		exit("-1");
	}
}

$queryChk = $db->prepare("SELECT * FROM accounts WHERE accountID = :accID AND isAdmin = 1");
$queryChk->execute([':accID' => $id]);
if ($queryChk->rowCount() > 0)
{
	$comment = "<cg>".$comment."</c>";
}

$comment = base64_encode($comment);

$userID = $mainLib->getUserID($id, $userName);
$uploadDate = time();
$decodecomment = base64_decode($comment);

if($id != "" AND $comment != ""){

	$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timeStamp, percent) VALUES (:userName, :comment, :levelID, :userID, :uploadDate, :percent)");
	if($register == 1){
		$query->execute([':userName' => $userName, ':comment' => $comment, ':levelID' => $levelID, ':userID' => $userID, ':uploadDate' => $uploadDate, ':percent' => $percent]);
		echo 1;
		if($percent != 0){
			$query2 = $db->prepare("SELECT percent FROM levelscores WHERE accountID = :accountID AND levelID = :levelID");
			$query2->execute([':accountID' => $id, ':levelID' => $levelID]);
			$result = $query2->fetchAll();
			if ($query2->rowCount() == 0) {
				$query = $db->prepare("INSERT INTO levelscores (accountID, levelID, percent, uploadDate)
				VALUES (:accountID, :levelID, :percent, :uploadDate)");
			} else {
				if($result[0]["percent"] < $percent){
					$query = $db->prepare("UPDATE levelscores SET percent=:percent, uploadDate=:uploadDate WHERE accountID=:accountID AND levelID=:levelID");
					$query->execute([':accountID' => $id, ':levelID' => $levelID, ':percent' => $percent, ':uploadDate' => $uploadDate]);
				}
			}
		}
	}else{
		$query->execute([':userName' => $userName, ':comment' => $comment, ':levelID' => $levelID, ':userID' => $userID, ':uploadDate' => $uploadDate, ':percent' => $percent]);
		echo 1;
	}
}else{
	echo -1;
}
?>
