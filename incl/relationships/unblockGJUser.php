<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
if(empty($_POST['targetAccountID'])) exit("-1");

$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);

$query = $db->prepare("DELETE FROM blocks WHERE person1 = :accountID AND person2 = :targetAccountID");
if($query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID])) $gs->logAction($accountID, 32, $targetAccountID);
echo "1";