<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/automod.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."config/misc.php";
if(!isset($_POST["delete"])) $_POST["delete"] = "";
if(!isset($_POST["body"])) $_POST["body"] = "";
$id = ExploitPatch::number($_POST["commentID"]);
$auth = ExploitPatch::charclean($_POST["auth"]);
if(!empty($auth)) {
	$check = GeneratePass::isValidToken($auth);
	if(!is_array($check)) exit(json_encode(['success' => false, 'error' => $check]));
	if($_POST["delete"] == 1) {
		$reply = $db->prepare("SELECT * FROM replies WHERE replyID = :id");
		$reply->execute([':id' => $id]);
		$reply = $reply->fetch();
		if($reply["accountID"] == $check['accountID']) {
			$reply = $db->prepare("DELETE FROM replies WHERE replyID = :id");
			$reply->execute([':id' => $id]);
			exit(json_encode(['dashboard' => true, 'success' => true]));
		} else exit(json_encode(['dashboard' => true, 'success' => false]));
	}
	if(empty($_POST["body"])) {
		$reply = $db->prepare("SELECT * FROM replies WHERE commentID = :id ORDER BY replyID DESC");
		$reply->execute([':id' => $id]);
		$reply = $reply->fetchAll();
		$replies = [];
		foreach($reply as &$rep) {
			$body = base64_decode($rep["body"]);
			if($enableCommentLengthLimiter) $body = substr($body, 0, $maxCommentLength);
			$username = $gs->getAccountName($rep["accountID"]);
			$replies[] = [
				'replyID' => $rep['replyID'],
				'commentID' => $id,
				'account' => [
					'username' => $username,
					'accountID' => $rep["accountID"],
					'userID' => $gs->getUserID($rep["accountID"], $username)
				],
				'body' => $body,
				'timestamp' => $rep["timestamp"]
			];
		}
		exit(json_encode(['dashboard' -> true, 'success' => true, 'replies' => $replies, 'count' => count($replies)]));
	} else {
		$userID = $gs->getUserID($check["accountID"], $gs->getAccountName($check["accountID"]));
		$checkBan = $gs->getPersonBan($check["accountID"], $userID, 3);
		if(Automod::isAccountsDisabled(1) || $checkBan) exit(json_encode(['dashboard' => true, 'success' => false]));
		$body = base64_encode(strip_tags(ExploitPatch::rucharclean($_POST["body"])));
		if($enableCommentLengthLimiter && strlen(base64_decode($body)) > $maxCommentLength) exit("-1");
		$reply = $db->prepare("INSERT INTO replies (commentID, accountID, body, timestamp) VALUES (:cid, :acc, :body, :time)");
		if($reply->execute([':cid' => $id, ':acc' => $check['accountID'], ':body' => $body, ':time' => time()])) exit(json_encode(['dashboard' => true, 'success' => true]));
		else exit(json_encode(['dashboard' => true, 'success' => false]));
	}
} else {
	$reply = $db->prepare("SELECT * FROM replies WHERE commentID = :id ORDER BY replyID DESC");
	$reply->execute([':id' => $id]);
	$reply = $reply->fetchAll();
	$replies = [];
	foreach($reply as &$rep) {
		$body = base64_decode($rep["body"]);
		if($enableCommentLengthLimiter) $body = substr(base64_decode($body), 0, $maxCommentLength);
		$username = $gs->getAccountName($rep["accountID"]);
		$replies[] = [
			'replyID' => $rep['replyID'],
			'commentID' => $id,
			'account' => [
				'username' => $username,
				'accountID' => $rep["accountID"],
				'userID' => $gs->getUserID($rep["accountID"], $username)
			],
			'body' => $body,
			'timestamp' => $rep["timestamp"]
		];
	}
	exit(json_encode(['dashboard' => true, 'success' => true, 'replies' => $replies, 'count' => count($replies)]));
}
?>