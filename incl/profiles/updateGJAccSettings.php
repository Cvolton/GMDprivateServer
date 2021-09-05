<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();

$accountID = GJPCheck::getAccountIDOrDie();
$mS = $ep->remove($_POST["mS"]);
$frS = $ep->remove($_POST["frS"]);
$cS = $ep->remove($_POST["cS"]);
$youtubeurl = $ep->remove($_POST["yt"]);
$twitter = $ep->remove($_POST["twitter"]);
$twitch = $ep->remove($_POST["twitch"]);

$query = $db->prepare("UPDATE accounts SET mS=:mS, frS=:frS, cS=:cS, youtubeurl=:youtubeurl, twitter=:twitter, twitch=:twitch WHERE accountID=:accountID");
$query->execute([':mS' => $mS, ':frS' => $frS, ':cS' => $cS, ':youtubeurl' => $youtubeurl, ':accountID' => $accountID, ':twitch' => $twitch, ':twitter' => $twitter]);
echo 1;
?>