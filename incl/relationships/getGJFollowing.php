<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/cron.php";
$gs = new mainLib();

$usersArray = [];
$accountID = GJPCheck::getAccountIDOrDie();

$following = $db->prepare("SELECT person2 FROM follows WHERE person1 = :accountID");
$following->execute([":accountID" => $accountID]);
$following = $following->fetchAll();

foreach($following AS &$follow) $usersArray[] = $follow["person2"];
$usersString = implode(",", $usersArray);

exit($usersString);