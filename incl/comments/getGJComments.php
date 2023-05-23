<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$commentstring = "";
$userstring = "";
$users = array();

$binaryVersion = isset($_POST['binaryVersion']) ? ExploitPatch::remove($_POST["binaryVersion"]) : 0;
$gameVersion = isset($_POST['gameVersion']) ? ExploitPatch::remove($_POST["gameVersion"]) : 0;
$mode = isset($_POST["mode"]) ? ExploitPatch::remove($_POST["mode"]) : 0;
$count = (isset($_POST["count"]) AND is_numeric($_POST["count"])) ? ExploitPatch::remove($_POST["count"]) : 10;
$page = isset($_POST['page']) ? ExploitPatch::remove($_POST["page"]) : 0;

$commentpage = $page*$count;

if($mode==0)
	$modeColumn = "commentID";
else
	$modeColumn = "likes";

if(isset($_POST['levelID'])){
	$filterColumn = 'levelID';
	$filterToFilter = '';
	$displayLevelID = false;
	$filterID = ExploitPatch::remove($_POST["levelID"]);
	$userListJoin = $userListWhere = $userListColumns = "";
}
elseif(isset($_POST['userID'])){
	$filterColumn = 'userID';
	$filterToFilter = 'comments.';
	$displayLevelID = true;
	$filterID = ExploitPatch::remove($_POST["userID"]);
	$userListColumns = ", levels.unlisted";
	$userListJoin = "INNER JOIN levels ON comments.levelID = levels.levelID";
	$userListWhere = "AND levels.unlisted = 0";
}
else
	exit(-1);

$countquery = "SELECT count(*) FROM comments $userListJoin WHERE ${filterToFilter}${filterColumn} = :filterID $userListWhere";
$countquery = $db->prepare($countquery);
$countquery->execute([':filterID' => $filterID]);
$commentcount = $countquery->fetchColumn();
if($commentcount == 0){
	exit("-2");
}


$query = "SELECT comments.levelID, comments.commentID, comments.timestamp, comments.comment, comments.userID, comments.likes, comments.isSpam, comments.percent, users.userName, users.icon, users.color1, users.color2, users.iconType, users.special, users.extID FROM comments LEFT JOIN users ON comments.userID = users.userID ${userListJoin} WHERE comments.${filterColumn} = :filterID ${userListWhere} ORDER BY comments.${modeColumn} DESC LIMIT ${count} OFFSET ${commentpage}";
$query = $db->prepare($query);
$query->execute([':filterID' => $filterID]);
$result = $query->fetchAll();
$visiblecount = $query->rowCount();

foreach($result as &$comment1) {
	if($comment1["commentID"]!=""){
		$uploadDate = date("d/m/Y G.i", $comment1["timestamp"]);
		$commentText = ($gameVersion < 20) ? base64_decode($comment1["comment"]) : $comment1["comment"];
		if($displayLevelID) $commentstring .= "1~".$comment1["levelID"]."~";
		$commentstring .= "2~".$commentText."~3~".$comment1["userID"]."~4~".$comment1["likes"]."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"]."~10~".$comment1["percent"];
		if ($comment1['userName']) { //TODO: get rid of queries caused by getMaxValuePermission and getAccountCommentColor
			$extID = is_numeric($comment1["extID"]) ? $comment1["extID"] : 0;
			if($binaryVersion > 31){
				$badge = $gs->getMaxValuePermission($extID, "modBadgeLevel");
				$colorString = $badge > 0 ? "~12~".$gs->getAccountCommentColor($extID) : "";

				$commentstring .= "~11~${badge}${colorString}:1~".$comment1["userName"]."~7~1~9~".$comment1["icon"]."~10~".$comment1["color1"]."~11~".$comment1["color2"]."~14~".$comment1["iconType"]."~15~".$comment1["special"]."~16~".$extID;
			}elseif(!in_array($comment1["userID"], $users)){
				$users[] = $comment1["userID"];
				$userstring .=  $comment1["userID"] . ":" . $comment1["userName"] . ":" . $extID . "|";
			}
			$commentstring .= "|";
		}
	}
}

$commentstring = substr($commentstring, 0, -1);
echo $commentstring;
if($binaryVersion < 32){
	$userstring = substr($userstring, 0, -1);
	echo "#$userstring";
}
echo "#${commentcount}:${commentpage}:${visiblecount}";
?>
