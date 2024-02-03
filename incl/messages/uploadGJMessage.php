<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gameVersion =  ExploitPatch::remove($_POST["gameVersion"]);
$binaryVersion =  ExploitPatch::remove($_POST["binaryVersion"]);
$secret =  ExploitPatch::remove($_POST["secret"]);
$subject =  ExploitPatch::remove($_POST["subject"]);
$toAccountID =  ExploitPatch::number($_POST["toAccountID"]);
$body =  ExploitPatch::remove($_POST["body"]);
$accID =  GJPCheck::getAccountIDOrDie();
if($accID == $toAccountID){
    exit("-1");
}
$query3 = $db->prepare("SELECT userName FROM users WHERE extID = :accID ORDER BY userName DESC");
$query3->execute([':accID' => $accID]);
$userName = $query3->fetchColumn();
$id = ExploitPatch::remove($_POST["accountID"]);
$register = 1;
$userID = $gs->getUserID($id);
$uploadDate = time();

$blockedQuery = $db->prepare("SELECT ID FROM `blocks` WHERE person1 = :toAccountID AND person2 = :accID");
$blockedQuery->execute([':toAccountID' => $toAccountID, ':accID' => $accID]);
$blocked = $blockedQuery->fetchAll(PDO::FETCH_COLUMN);

$mSOnlyQuery = $db->prepare("SELECT mS FROM `accounts` WHERE accountID = :toAccountID AND mS > 0");
$mSOnlyQuery->execute([':toAccountID' => $toAccountID]);
$mSOnly = $mSOnlyQuery->fetchAll(PDO::FETCH_COLUMN);

$friendQuery = $db->prepare("SELECT ID FROM `friendships` WHERE (person1 = :accID AND person2 = :toAccountID) || (person2 = :accID AND person1 = :toAccountID)");
$friendQuery->execute([':accID' => $accID, ':toAccountID' => $toAccountID]);
$friend = $friendQuery->fetchAll(PDO::FETCH_COLUMN);

$query = $db->prepare("INSERT INTO messages (subject, body, accID, userID, userName, toAccountID, secret, timestamp)
VALUES (:subject, :body, :accID, :userID, :userName, :toAccountID, :secret, :uploadDate)");

if (!empty($mSOnly[0]) and $mSOnly[0] == 2) {
    echo -1;
} else {
    if (empty($blocked[0]) and (empty($mSOnly[0]) || !empty($friend[0]))) {
        $query->execute([':subject' => $subject, ':body' => $body, ':accID' => $id, ':userID' => $userID, ':userName' => $userName, ':toAccountID' => $toAccountID, ':secret' => $secret, ':uploadDate' => $uploadDate]);
        echo 1;
    } else {
        echo -1;
    }
}
?>