<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";

$accountID = GJPCheck::getAccountIDOrDie();
$mS = ExploitPatch::remove($_POST["mS"]);
$frS = ExploitPatch::remove($_POST["frS"]);
$cS = ExploitPatch::remove($_POST["cS"]);
$youtubeurl = ExploitPatch::remove($_POST["yt"]);
$twitter = ExploitPatch::remove($_POST["twitter"]);
$twitch = ExploitPatch::remove($_POST["twitch"]);

if(substr($youtubeurl, 0, 4) == "../@") $youtubeurl = "@" . substr($youtubeurl, 4);
$youtubeurl = mb_ereg_replace("(?!^@)[^a-zA-Z0-9_]", "", $youtubeurl);
$twitter = mb_ereg_replace("[^a-zA-Z0-9_]", "", $twitter);
$twitch = mb_ereg_replace("[^a-zA-Z0-9_]", "", $twitch);

$query = $db->prepare("UPDATE accounts SET mS=:mS, frS=:frS, cS=:cS, youtubeurl=:youtubeurl, twitter=:twitter, twitch=:twitch WHERE accountID=:accountID");
$query->execute([':mS' => $mS, ':frS' => $frS, ':cS' => $cS, ':youtubeurl' => $youtubeurl, ':accountID' => $accountID, ':twitch' => $twitch, ':twitter' => $twitter]);
echo 1;
?>
