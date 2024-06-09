<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."config/misc.php";
if(!isset($_POST["delete"])) $_POST["delete"] = "";
if(!isset($_POST["body"])) $_POST["body"] = "";
$id = ExploitPatch::number($_POST["id"]);
$x = 1;
if($_SESSION["accountID"] != 0) {
	if($_POST["delete"] == 1) {
		$reply = $db->prepare("SELECT * FROM replies WHERE replyID = :id");
		$reply->execute([':id' => $id]);
		$reply = $reply->fetch();
		if($reply["accountID"] == $_SESSION["accountID"]) {
			$reply = $db->prepare("DELETE FROM replies WHERE replyID = :id");
			$reply->execute([':id' => $id]);
			exit('1');
		}
	}
	if(empty($_POST["body"])) {
		$reply = $db->prepare("SELECT * FROM replies WHERE commentID = :id ORDER BY replyID DESC");
		$reply->execute([':id' => $id]);
		$reply = $reply->fetchAll();
		foreach($reply as &$rep) {
			if($x > 1) echo ' | ';
			$body = $rep["body"];
			if($enableCommentLengthLimiter) $body = base64_encode(substr(base64_decode($body), 0, $maxCommentLength));
			echo $rep["replyID"].', '.$id.', '.$gs->getAccountName($rep["accountID"]).', '.$body.', '.$dl->convertToDate($rep["timestamp"], true).', '.count($reply);
			$x++;
		}
	} else {
		$body = base64_encode(strip_tags(ExploitPatch::rucharclean($_POST["body"])));
		if($enableCommentLengthLimiter && strlen(base64_decode($body)) > $maxCommentLength) exit("-1");
		$reply = $db->prepare("INSERT INTO replies (commentID, accountID, body, timestamp) VALUES (:cid, :acc, :body, :time)");
		$reply->execute([':cid' => $id, ':acc' => $_SESSION["accountID"], ':body' => $body, ':time' => time()]);
		echo 1;
	}
} else {
	$reply = $db->prepare("SELECT * FROM replies WHERE commentID = :id ORDER BY replyID DESC");
	$reply->execute([':id' => $id]);
	$reply = $reply->fetchAll();
	foreach($reply as &$rep) {
		if($x > 1) echo ' | ';
		$body = $rep["body"];
		if($enableCommentLengthLimiter) $body = base64_encode(substr(base64_decode($body), 0, $maxCommentLength));
		echo $rep["replyID"].', '.$id.', '.$gs->getAccountName($rep["accountID"]).', '.$body.', '.$dl->convertToDate($rep["timestamp"], true).', '.count($reply);
		$x++;
	}
}
?>