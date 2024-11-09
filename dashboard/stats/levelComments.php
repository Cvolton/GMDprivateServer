<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/automod.php";
require "../".$dbPath."config/misc.php";
$dl->title($dl->getLocalizedString("levelComments"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0) {
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["levelID"])) $_GET["levelID"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = $levels = "";
$levelID = ExploitPatch::number($_GET['levelID']);
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
$commentDeleteCheck = $gs->checkPermission($_SESSION["accountID"], "actionDeleteComment");
$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID".(!$modcheck ? ' AND unlisted = 0' : ''));
$query->execute([':levelID' => $levelID]);
$level = $query->fetch();
if(empty($level)) die($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
		<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
	</form>
</div>', 'browse'));
if($_SESSION['accountID'] != 0) {
	if(isset($_POST['deleteCommentID'])) {
		$commentID = ExploitPatch::number($_POST['deleteCommentID']);
		$query = $db->prepare("SELECT * FROM comments WHERE commentID = :deleteCommentID");
		$query->execute([':deleteCommentID' => $commentID]);
		$comment = $query->fetch();
		$creatorAccID = $gs->getExtID($comment['userID']);
		if($comment && ($commentDeleteCheck || $_SESSION['accountID'] == $creatorAccID)) {
			$query = $db->prepare("DELETE FROM comments WHERE commentID = :deleteCommentID");
			$query->execute([':deleteCommentID' => $commentID]);
			$gs->logAction($_SESSION['accountID'], 13, $comment['userName'], $comment['comment'], $creatorAccID, $commentID, ($comment['likes'] - $comment['dislikes']), $comment['levelID']);
		}
	}
	if(isset($_POST['commentText'])) {
		if(!Automod::isLevelsDisabled(1)) {
			$commentText = trim(ExploitPatch::rucharclean($_POST['commentText']));
			$commentLength = mb_strlen($commentText);
			if($enableCommentLengthLimiter && $commentLength > $maxCommentLength) $alertText = sprintf($dl->getLocalizedString('cantPostCommentsAboveChars'), $maxCommentLength);
			elseif($commentText) {
				$commentText = ExploitPatch::url_base64_encode($commentText);
				$userName = $gs->getAccountName($_SESSION['accountID']);
				$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timeStamp, percent) VALUES (:userName, :comment, :levelID, :userID, :uploadDate, :percent)");
				$query->execute([':userName' => $userName, ':comment' => $commentText, ':levelID' => $levelID, ':userID' => $gs->getUserID($_SESSION['accountID'], $userName), ':uploadDate' => time(), ':percent' => 0]);
				$gs->logAction($_SESSION['accountID'], 15, $userName, $commentText, $db->lastInsertId(), $levelID);
			}
		} else $alertText = $dl->getLocalizedString('commentingIsDisabled');
	}
}
$query = $db->prepare("SELECT * FROM comments WHERE levelID = :levelID ORDER BY timestamp DESC LIMIT 10 OFFSET $page");
$query->execute([':levelID' => $levelID]);
$result = $query->fetchAll();
if(isset($_SERVER["HTTP_REFERER"])) $back = '<form style="display: contents;" method="post" action="'.$_SERVER["HTTP_REFERER"].'">
	<button type="button" onclick="a(\''.$_SERVER["HTTP_REFERER"].'\', true, true, \'GET\')" class="goback no-margin">
		<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
	</button>
</form>';
else $back = '';
foreach($result as &$action) $comments .= $dl->generateCommentsCard($action, $commentDeleteCheck);
if(empty($comments)) $comments = '<div class="empty-section">
	<i class="fa-solid fa-comment-slash"></i>
	<p>'.$dl->getLocalizedString('noComments').'</p>
</div>';
$pagel = '<div class="form new-form twice-form">
	<h1 class="goback-title">'.$back.$dl->getLocalizedString("levelComments").'</h1>
	<div class="form-control new-form-control level-card">
		'.$dl->generateLevelsCard($level, $modcheck).'
	</div>
	<div class="form-control new-form-control">
		'.$comments.'
	</div>
</div>
'.($_SESSION['accountID'] != 0 ? '<div class="field" style="display:flex">
	<form style="display: contents" name="postComment">
		<input maxlength="'.$maxCommentLength.'" style="border-top-right-radius: 0;border-bottom-right-radius: 0; margin-bottom: 10px;" type="text" name="commentText" placeholder="'.$dl->getLocalizedString("commentHere").'">
	</form>
	<button type="button" onclick="a(\'stats/levelComments.php?levelID='.$levelID.'\', true, true, \'POST\', false,\'postComment\')" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important; margin-bottom: 10px;" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("send").'">
		<i class="fa-solid fa-paper-plane"></i>
	</button>
</div>' : '').'
<script>
	'.(isset($alertText) ? 'alert("'.$alertText.'");' : '').'
</script>';
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM comments WHERE levelID = :levelID");
$query->execute([':levelID' => $levelID]);
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "browse");
?>