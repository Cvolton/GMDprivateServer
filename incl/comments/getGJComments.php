<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$binaryVersion = $ep->remove($_POST["binaryVersion"]);
$gameVersion = $ep->remove($_POST["gameVersion"]);
$type = $ep->remove($_POST["type"]);
$levelID = $ep->remove($_POST["levelID"]);
$users = array();
if($_POST["mode"]){
	$mode = $ep->remove($_POST["mode"]);
}else{
	$mode = 0;
}
$page = $ep->remove($_POST["page"]);
$commentpage = $page*10;
if($mode==0){
	$query = "SELECT * FROM comments WHERE levelID = :levelID ORDER BY commentID DESC LIMIT 10 OFFSET $commentpage";
}else{
	$query = "SELECT * FROM comments WHERE levelID = :levelID ORDER BY likes DESC LIMIT 10 OFFSET $commentpage";
}
$countquery = "SELECT count(*) FROM comments WHERE levelID = :levelID";
$countquery = $db->prepare($countquery);
$countquery->execute([':levelID' => $levelID]);
$commentcount = $countquery->fetchColumn();
if($commentcount == 0){
	exit("-2");
}
$query = $db->prepare($query);
$query->execute([':levelID' => $levelID]);
$result = $query->fetchAll();
foreach($result as &$comment1) {
	if($comment1["commentID"]!=""){
		$uploadDate = date("d/m/Y G.i", $comment1["timestamp"]);
		$actualcomment = $comment1["comment"];
		if($gameVersion < 20){
			$actualcomment = base64_decode($actualcomment);
		}
		$commentstring .= "2~".$actualcomment."~3~".$comment1["userID"]."~4~".$comment1["likes"]."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"]."~10~".$comment1["percent"]."";
		$query12 = $db->prepare("SELECT userID, userName, icon, color1, color2, iconType, special, extID FROM users WHERE userID = :userID");
		$query12->execute([':userID' => $comment1["userID"]]);
		if ($query12->rowCount() > 0) {
			$user = $query12->fetchAll()[0];
			if(is_numeric($user["extID"])){
				$extID = $user["extID"];
			}else{
				$extID = 0;
			}
			if(!in_array($user["userID"], $users)){
				$users[] = $user["userID"];
				$userstring .=  $user["userID"] . ":" . $user["userName"] . ":" . $extID . "|";
			}
			if($binaryVersion > 31){
				$commentstring .= ":1~".$user["userName"]."~9~".$user["icon"]."~10~".$user["color1"]."~11~".$user["color2"]."~14~".$user["iconType"]."~15~".$user["special"]."~16~".$user["extID"];
			}
			$commentstring .= "|";
		}
	}
}
$commentstring = substr($commentstring, 0, -1);
$userstring = substr($userstring, 0, -1);
echo $commentstring;
if($binaryVersion < 32){
	echo "#$userstring";
}
echo "#".$commentcount.":".$commentpage.":10";
?>