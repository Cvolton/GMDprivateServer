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

$query = $db->prepare("INSERT INTO follows (person1, person2, timestamp) VALUES (:accountID, :targetAccountID, :timestamp)");
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID, ":timestamp" => time()]);
if($automaticCron) Cron::updateFriendsCount($accountID, false);
$gs->logAction($accountID, 80, $targetAccountID);
echo 1;