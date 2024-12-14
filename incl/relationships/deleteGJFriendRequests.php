<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
if(empty($_POST["targetAccountID"])) exit("-1");
$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);
$query = $db->prepare("DELETE FROM friendreqs WHERE (accountID = :accountID AND toAccountID = :targetAccountID) OR (toAccountID = :accountID AND accountID = :targetAccountID) LIMIT 1");
if($query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID])) $gs->logAction($accountID, 30, $targetAccountID);
echo "1";