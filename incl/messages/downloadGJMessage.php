<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$accountID = GJPCheck::getAccountIDOrDie();
$messageID = ExploitPatch::remove($_POST["messageID"]);

$query = $db->prepare("SELECT accID, toAccountID, timestamp, userName, messageID, subject, isNew, body FROM messages WHERE messageID = :messageID AND (accID = :accID OR toAccountID = :accID) LIMIT 1");
$query->execute([':messageID' => $messageID, ':accID' => $accountID]);
$result = $query->fetch();
if($query->rowCount() == 0) exit("-1");
if(empty($_POST["isSender"])) {
	$query = $db->prepare("UPDATE messages SET isNew = 1, readTime = :readTime WHERE messageID = :messageID AND toAccountID = :accID AND readTime = 0");
	$query->execute([':messageID' => $messageID, ':accID' => $accountID, ':readTime' => time()]);
	$accountID = $result["accID"];
	$isSender = 0;
} else {
	$isSender = 1;
	$accountID = $result["toAccountID"];
}
$query = $db->prepare("SELECT userName, userID, extID, clan FROM users WHERE extID = :accountID");
$query->execute([':accountID' => $accountID]);
$result12 = $query->fetch();
$uploadDate = $gs->makeTime($result["timestamp"]);
$result12["userName"] = $gs->makeClanUsername($result12);
$result["subject"] = ExploitPatch::url_base64_encode(ExploitPatch::translit(ExploitPatch::url_base64_decode($result["subject"])));
$result["body"] = ExploitPatch::url_base64_encode(XORCipher::cipher(ExploitPatch::translit(XORCipher::cipher(ExploitPatch::url_base64_decode($result["body"]), 14251)), 14251));
echo "6:".$result12["userName"].":3:".$result12["userID"].":2:".$result12["extID"].":1:".$result["messageID"].":4:".$result["subject"].":8:".$result["isNew"].":9:".$isSender.":5:".$result["body"].":7:".$uploadDate."";
?>