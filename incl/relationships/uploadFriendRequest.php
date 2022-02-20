<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
//here im getting all the data
if(empty($_POST["toAccountID"])){
	exit("-1");
}
$accountID = GJPCheck::getAccountIDOrDie();
$toAccountID = ExploitPatch::number($_POST["toAccountID"]);
if ($toAccountID == $accountID) {
	exit("-1");
}
$comment = ExploitPatch::remove($_POST["comment"]);
$uploadDate = time();
$blocked = $db->query("SELECT ID FROM `blocks` WHERE person1 = $toAccountID AND person2 = $accountID")->fetchAll(PDO::FETCH_COLUMN);
$frSOnly = $db->query("SELECT frS FROM `accounts` WHERE accountID = $toAccountID AND frS = 1")->fetchAll(PDO::FETCH_COLUMN);
$query = $db->prepare("SELECT count(*) FROM friendreqs WHERE (accountID=:accountID AND toAccountID=:toAccountID) OR (toAccountID=:accountID AND accountID=:toAccountID)");
$query->execute([':accountID' => $accountID, ':toAccountID' => $toAccountID]);
if($query->fetchColumn() == 0 and empty($blocked[0]) and empty($frSOnly[0])){
	$query = $db->prepare("INSERT INTO friendreqs (accountID, toAccountID, comment, uploadDate)
	VALUES (:accountID, :toAccountID, :comment, :uploadDate)");
	$query->execute([':accountID' => $accountID, ':toAccountID' => $toAccountID, ':comment' => $comment, ':uploadDate' => $uploadDate]);
	echo 1;
}else{
	echo -1;
}
?>
