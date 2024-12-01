<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/GJPCheck.php";
require_once "../../config/misc.php";
$gs = new mainLib();

$commentstring = "";
$userstring = "";
$users = array();

$binaryVersion = isset($_POST['binaryVersion']) ? ExploitPatch::number($_POST["binaryVersion"]) : 0;
$gameVersion = isset($_POST['gameVersion']) ? ExploitPatch::number($_POST["gameVersion"]) : 0;
$mode = isset($_POST["mode"]) ? ExploitPatch::number($_POST["mode"]) : 0;
$count = (isset($_POST["count"]) AND is_numeric($_POST["count"])) ? ExploitPatch::number($_POST["count"]) : 10;
$page = isset($_POST['page']) ? ExploitPatch::remove($_POST["page"]) : 0;

$commentpage = $page*$count;

if($mode == 0) $modeColumn = "commentID";
else $modeColumn = "likes";

if(isset($_POST['levelID'])) {
	$filterColumn = 'levelID';
	$filterToFilter = '';
	$displayLevelID = false;
	$filterID = ExploitPatch::numbercolon($_POST["levelID"]);
	if($_POST["levelID"] > 0) {
		$levelExists = $db->prepare("SELECT COUNT(*) FROM levels WHERE levelID = :levelID");
		$levelExists->execute([':levelID' => $filterID]);
	} else {
		$levelExists = $db->prepare("SELECT COUNT(*) FROM lists WHERE listID = :levelID");
		$levelExists->execute([':levelID' => ExploitPatch::number($filterID)]);
	}
	if($levelExists->fetchColumn() == 0) exit("-2"); // Don't return comments from nonexistent levels
	$userListJoin = "";
} elseif(isset($_POST['userID'])) {
	$filterColumn = 'userID';
	$filterToFilter = 'comments.';
	$displayLevelID = true;
	$filterID = ExploitPatch::number($_POST["userID"]);
	$userListColumns = ", levels.unlisted";
	$userListJoin = " LEFT JOIN levels ON comments.levelID = levels.levelID LEFT JOIN lists ON (comments.levelID * -1) = lists.listID";
	$userListWhere = "AND (levels.unlisted = 0 OR lists.unlisted = 0)";
	$accountID = !empty($_POST['accountID']) ? GJPCheck::getAccountIDOrDie() : 0;
	$targetAccountID = $gs->getExtID($filterID);
	$cS = $db->prepare("SELECT cS FROM accounts WHERE accountID = :targetAccountID");
	$cS->execute([':targetAccountID' => $targetAccountID]);
	$cS = $cS->fetchColumn();
	if($accountID != $targetAccountID && (($cS == 1 && !$gs->isFriends($accountID, $targetAccountID)) || $cS > 1)) exit("-2");
} else exit("-1");

$countquery = "SELECT count(*) FROM comments {$userListJoin} WHERE ${filterToFilter}${filterColumn} = :filterID {$userListWhere}";
$countquery = $db->prepare($countquery);
$countquery->execute([':filterID' => $filterID]);
$commentcount = $countquery->fetchColumn();
if($commentcount == 0) exit("-2");

$query = "SELECT comments.levelID, comments.commentID, comments.timestamp, comments.comment, comments.userID, comments.likes, comments.isSpam, comments.percent, users.userName, users.clan, users.icon, users.color1, users.color2, users.iconType, users.special, users.extID FROM comments LEFT JOIN users ON comments.userID = users.userID {$userListJoin} WHERE comments.${filterColumn} = :filterID {$userListWhere} ORDER BY comments.${modeColumn} DESC LIMIT ${count} OFFSET ${commentpage}";
$query = $db->prepare($query);
$query->execute([':filterID' => $filterID]);
$result = $query->fetchAll();
$visiblecount = $query->rowCount();

foreach($result as &$comment1) {
	if(!empty($comment1["commentID"])) {
      	$uploadDate = $gs->makeTime($comment1["timestamp"]);
		$comment1['comment'] = ExploitPatch::translit(ExploitPatch::url_base64_decode($comment1["comment"]));
		if($enableCommentLengthLimiter) $commentText = mb_substr($comment1['comment'], 0, $maxCommentLength);
		$commentText = ($gameVersion < 20) ? ExploitPatch::gd_escape($comment1["comment"]) : ExploitPatch::url_base64_encode($comment1["comment"]);
		if($displayLevelID) $commentstring .= "1~".$comment1["levelID"]."~";
		if($commentAutoLike && array_key_exists($comment1["commentID"], $specialCommentLikes)) $likes = $comment1["likes"] * $specialCommentLikes[$comment1["commentID"]]; // Multiply by the specified value
        else  $likes = $comment1["likes"]; // Normal like value
		if($likes < -2) $comment1["isSpam"] = 1;
		$commentstring .= "2~".$commentText."~3~".$comment1["userID"]."~4~".$likes."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"]."~10~".$comment1["percent"];
		if($comment1['userName']) {
			$comment1["extID"] = is_numeric($comment1["extID"]) ? $comment1["extID"] : 0;
			$comment1['userName'] = $gs->makeClanUsername($comment1);
			if($binaryVersion > 31) {
				$badge = $gs->getMaxValuePermission($comment1["extID"], "modBadgeLevel");
				$colorString = $badge > 0 ? "~12~".$gs->getAccountCommentColor($comment1["extID"]) : "";
				$commentstring .= "~11~${badge}${colorString}:1~".$comment1["userName"]."~7~1~9~".$comment1["icon"]."~10~".$comment1["color1"]."~11~".$comment1["color2"]."~14~".$comment1["iconType"]."~15~".$comment1["special"]."~16~".$comment1["extID"];
			} elseif(!in_array($comment1["userID"], $users)) {
				$users[] = $comment1["userID"];
				$userstring .=  $comment1["userID"] . ":" . $comment1["userName"] . ":" . $comment1["extID"] . "|";
			}
			$commentstring .= "|";
		}
	}
}

$commentstring = substr($commentstring, 0, -1);
echo $commentstring;
if($binaryVersion < 32) {
	$userstring = substr($userstring, 0, -1);
	echo "#$userstring";
}
echo "#${commentcount}:${commentpage}:${visiblecount}";
?>