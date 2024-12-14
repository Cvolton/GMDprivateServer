<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/cron.php";
$gs = new mainLib();

if(empty($_POST["targetAccountID"])) exit("-1");

$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);
if($accountID == $targetAccountID) exit("-1");

$query = $db->prepare("INSERT INTO blocks (person1, person2) VALUES (:accountID, :targetAccountID)");
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
// Remove from friend list if the two users were friends
$query = $db->prepare("DELETE FROM friendships WHERE (person1 = :accountID AND person2 = :targetAccountID) OR (person1 = :targetAccountID AND person2 = :accountID)");
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
if($automaticCron) Cron::updateFriendsCount($accountID, false);
$gs->logAction($accountID, 29, $targetAccountID);
echo 1;