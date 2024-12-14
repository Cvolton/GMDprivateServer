<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/cron.php";
$gs = new mainLib();
if(empty($_POST["requestID"])) exit("-1");
$accountID = GJPCheck::getAccountIDOrDie();
$requestID = ExploitPatch::remove($_POST["requestID"]);

$query = $db->prepare("SELECT accountID, toAccountID FROM friendreqs WHERE ID = :requestID");
$query->execute([':requestID' => $requestID]);
$request = $query->fetch();
$reqAccountID = $request["accountID"];
$toAccountID = $request["toAccountID"];
if($toAccountID != $accountID OR $reqAccountID == $accountID) exit("-1");
$query = $db->prepare("INSERT INTO friendships (person1, person2, isNew1, isNew2) VALUES (:accountID, :targetAccountID, 1, 1)");
$query->execute([':accountID' => $reqAccountID, ':targetAccountID' => $toAccountID]);
$gs->logAction($accountID, 28, $reqAccountID);
$query = $db->prepare("DELETE from friendreqs WHERE ID = :requestID LIMIT 1");
$query->execute([':requestID' => $requestID]);
if($automaticCron) Cron::updateFriendsCount($accountID, false);
echo "1";
?>