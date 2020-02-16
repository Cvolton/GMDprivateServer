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
$toAccountID =  $ep->number($_POST["toAccountID"]);
$body =  $ep->remove($_POST["body"]);
$accID =  $ep->number($_POST["accountID"]);
$query3 = "SELECT userName FROM users WHERE extID = :accID ORDER BY userName DESC";
$query3 = $db->prepare($query3);
$query3->execute([':accID' => $accID]);
$userName = $query3->fetchColumn();
//continuing the accounts system
$id = $ep->remove($_POST["accountID"]);
$register = 1;
$userID = $gs->getUserID($id);
$uploadDate = time();

$blocked = $db->query("SELECT ID FROM `blocks` WHERE person1 = $toAccountID AND person2 = $accID")->fetchAll(PDO::FETCH_COLUMN);
$mSOnly = $db->query("SELECT mS FROM `accounts` WHERE accountID = $toAccountID AND mS > 0")->fetchAll(PDO::FETCH_COLUMN);
$friend = $db->query("SELECT ID FROM `friendships` WHERE (person1 = $accID AND person2 = $toAccountID) || (person2 = $accID AND person1 = $toAccountID)")->fetchAll(PDO::FETCH_COLUMN);

$query = $db->prepare("INSERT INTO messages (subject, body, accID, userID, userName, toAccountID, secret, timestamp)
VALUES (:subject, :body, :accID, :userID, :userName, :toAccountID, :secret, :uploadDate)");

$GJPCheck = new GJPCheck();
$gjpresult = $GJPCheck->check($gjp,$id);
if (!empty($mSOnly[0]) and $mSOnly[0] == 2) {
    echo -1;
} else {
    if ($gjpresult == 1 and empty($blocked[0]) and (empty($mSOnly[0]) || !empty($friend[0]))) {
        $query->execute([':subject' => $subject, ':body' => $body, ':accID' => $id, ':userID' => $userID, ':userName' => $userName, ':toAccountID' => $toAccountID, ':secret' => $secret, ':uploadDate' => $uploadDate]);
        echo 1;
    } else {
        echo -1;
    }
}
?>