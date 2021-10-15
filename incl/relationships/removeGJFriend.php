<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";

if(empty($_POST['targetAccountID']))
	exit("-1");

$accountID = GJPCheck::getAccountIDOrDie();
$targetAccountID = ExploitPatch::remove($_POST["targetAccountID"]);

$query = "DELETE FROM friendships WHERE person1 = :accountID AND person2 = :targetAccountID";
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);

$query = "DELETE FROM friendships WHERE person2 = :accountID AND person1 = :targetAccountID";
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);

echo "1";