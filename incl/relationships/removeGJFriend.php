<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/cron.php";
$gs = new mainLib();
if(empty($_POST['targetAccountID'])) exit("-1");
$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);
$query = $db->prepare("DELETE FROM friendships WHERE (person1 = :accountID AND person2 = :targetAccountID) OR (person2 = :accountID AND person1 = :targetAccountID)");
if($query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID])) $gs->logAction($accountID, 31, $targetAccountID);
if($automaticCron) Cron::updateFriendsCount($accountID, false);
echo "1";