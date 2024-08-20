<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";

if(empty($_POST["targetAccountID"]))
	exit("-1");

$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);

if($accountID == $targetAccountID) {
	exit("-1");
}

$query = $db->prepare("INSERT INTO blocks (person1, person2) VALUES (:accountID, :targetAccountID)");
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
// Remove from friend list if the two users were friends
$query = $db->prepare("DELETE FROM friendships WHERE (person1 = :accountID AND person2 = :targetAccountID) OR (person1 = :targetAccountID AND person2 = :accountID)");
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);

exit("1");
?>