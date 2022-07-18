<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/commands.php";

$userName = !empty($_POST['userName']) ? ExploitPatch::remove($_POST['userName']) : "";
$gameVersion = !empty($_POST['gameVersion']) ? ExploitPatch::number($_POST['gameVersion']) : 0;
$comment = ExploitPatch::remove($_POST['comment']);
$comment = ($gameVersion < 20) ? base64_encode($comment) : $comment;
$levelID = ExploitPatch::number($_POST["levelID"]);
$percent = !empty($_POST["percent"]) ? ExploitPatch::remove($_POST["percent"]) : 0;

$id = $mainLib->getIDFromPost();
$register = is_numeric($id);
$userID = $mainLib->getUserID($id, $userName);
$uploadDate = time();
$decodecomment = base64_decode($comment);
if(Commands::doCommands($id, $decodecomment, $levelID)){
	exit("temp_0_Executed command successfully!");
} else {
	exit("temp_0_Failed to execute command!");
}
//banning
$query2 = $db->prepare("SELECT accountID FROM `accounts` WHERE `isBanned` = '1' AND userName = :userName");
$query2->execute([':userName' => $userName]);
if($query2->rowCount() == 1){
	exit("-10");
}

if($id != "" AND $comment != ""){
	//ban comments
	$ban_query = $db->prepare("SELECT commentBanTime, commentBanDuration, commentBanReason FROM users WHERE userID = :userID");
	$ban_query->execute([':userID' => $userID]);
	$ban_result = $ban_query->fetch();
	if ($ban_result['commentBanDuration'] == -1) {
	echo "-10";
	return;
}
	elseif ($ban_result['commentBanTime'] + $ban_result['commentBanDuration'] > $uploadDate) {
		echo "temp_".($ban_result['commentBanTime'] + $ban_result['commentBanDuration'] - $uploadDate)."_".$ban_result['commentBanReason'];
		return;
	}

	$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timeStamp, percent) VALUES (:userName, :comment, :levelID, :userID, :uploadDate, :percent)");
	$query->execute([':userName' => $userName, ':comment' => $comment, ':levelID' => $levelID, ':userID' => $userID, ':uploadDate' => $uploadDate, ':percent' => $percent]);
	echo 1;
	if($register){
		//TODO: improve this
		if($percent != 0){
			$query2 = $db->prepare("SELECT percent FROM levelscores WHERE accountID = :accountID AND levelID = :levelID");
			$query2->execute([':accountID' => $id, ':levelID' => $levelID]);
			$result = $query2->fetchColumn();
			if ($query2->rowCount() == 0) {
				$query = $db->prepare("INSERT INTO levelscores (accountID, levelID, percent, uploadDate)
				VALUES (:accountID, :levelID, :percent, :uploadDate)");
			} else {
				if($result < $percent){
					$query = $db->prepare("UPDATE levelscores SET percent=:percent, uploadDate=:uploadDate WHERE accountID=:accountID AND levelID=:levelID");
					$query->execute([':accountID' => $id, ':levelID' => $levelID, ':percent' => $percent, ':uploadDate' => $uploadDate]);
				}
			}
		}
	}
}else{
	echo -1;
}
?>
