<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/exploitPatch.php";
if(!isset($_GET["delete"])) $_GET["delete"] = "";
if(!isset($_GET["body"])) $_GET["body"] = "";
$id = ExploitPatch::number($_GET["id"]);
$x = 1;
if($_SESSION["accountID"] != 0) {
	if($_GET["delete"] == 1) {
		$reply = $db->prepare("SELECT * FROM replies WHERE replyID = :id");
		$reply->execute([':id' => $id]);
		$reply = $reply->fetch();
		if($reply["accountID"] == $_SESSION["accountID"]) {
			$reply = $db->prepare("DELETE FROM replies WHERE replyID = :id");
			$reply->execute([':id' => $id]);
			exit('1');
		}
	}
	if(empty($_GET["body"])) {
		$reply = $db->prepare("SELECT * FROM replies WHERE commentID = :id ORDER BY replyID DESC");
		$reply->execute([':id' => $id]);
		$reply = $reply->fetchAll();
		foreach($reply as &$rep) {
			if($x > 1) echo ' | ';
			echo $rep["replyID"].', '.$id.', '.$gs->getAccountName($rep["accountID"]).', '.$rep["body"].', '.$dl->convertToDate($rep["timestamp"], true).', '.count($reply);
			$x++;
		}
	} else {
		$body = base64_encode(strip_tags(ExploitPatch::rucharclean($_GET["body"])));
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
		echo $rep["replyID"].', '.$id.', '.$gs->getAccountName($rep["accountID"]).', '.$rep["body"].', '.$dl->convertToDate($rep["timestamp"], true).', '.count($reply);
		$x++;
	}
}
?>