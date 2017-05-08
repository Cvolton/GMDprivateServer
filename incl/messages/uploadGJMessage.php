<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp =  $ep->remove($_POST["gjp"]);
$gameVersion =  $ep->remove($_POST["gameVersion"]);
$binaryVersion =  $ep->remove($_POST["binaryVersion"]);
$secret =  $ep->remove($_POST["secret"]);
$subject =  $ep->remove($_POST["subject"]);
$toAccountID =  $ep->remove($_POST["toAccountID"]);
$body =  $ep->remove($_POST["body"]);
$accID =  $ep->remove($_POST["accountID"]);
$query3 = "SELECT userName FROM users WHERE extID = :accID ORDER BY userName DESC";
$query3 = $db->prepare($query3);
$query3->execute([':accID' => $accID]);
$userName = $query3->fetchColumn();
//continuing the accounts system
$id = $ep->remove($_POST["accountID"]);
$register = 1;
$userID = $gs->getUserID($id);
$uploadDate = time();

$query = $db->prepare("INSERT INTO messages (subject, body, accID, userID, userName, toAccountID, secret, timestamp)
VALUES (:subject, :body, :accID, :userID, :userName, :toAccountID, :secret, :uploadDate)");

$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$id);
if($gjpresult == 1){
	$query->execute([':subject' => $subject, ':body' => $body, ':accID' => $id, ':userID' => $userID, ':userName' => $userName, ':toAccountID' => $toAccountID, ':secret' => $secret, ':uploadDate' => $uploadDate]);
	echo 1;
}else{echo -1;}
?>