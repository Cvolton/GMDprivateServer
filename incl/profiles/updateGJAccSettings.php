<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$accountID = GJPCheck::getAccountIDOrDie();
$mS = ExploitPatch::remove($_POST["mS"]);
$frS = ExploitPatch::remove($_POST["frS"]);
$cS = ExploitPatch::remove($_POST["cS"]);
$gF = ExploitPatch::remove($_POST["gF"]);
$gO = ExploitPatch::remove($_POST["gO"]);
$youtubeurl = ExploitPatch::remove($_POST["yt"]) ?: "";
$twitter = ExploitPatch::remove($_POST["twitter"]) ?: "";
$twitch = ExploitPatch::remove($_POST["twitch"]) ?: "";
$instagram = ExploitPatch::remove($_POST["instagram"]) ?: "";
$tiktok = ExploitPatch::remove($_POST["tiktok"]) ?: "";
$discord = ExploitPatch::remove($_POST["discord"]) ?: "";
$custom = ExploitPatch::remove($_POST["custom"]) ?: "";

$getAccountData = $db->prepare("SELECT * FROM accounts WHERE accountID = :accountID");
$getAccountData->execute([':accountID' => $accountID]);
$getAccountData = $getAccountData->fetch();

$youtubeurl = mb_ereg_replace("[^a-zA-Z0-9_]", "", $youtubeurl);
$twitter = mb_ereg_replace("[^a-zA-Z0-9_]", "", $twitter);
$twitch = mb_ereg_replace("[^a-zA-Z0-9_]", "", $twitch);
$instagram = mb_ereg_replace("[^a-zA-Z0-9_]", "", $instagram);
$tiktok = mb_ereg_replace("[^a-zA-Z0-9_]", "", $tiktok);
$discord = mb_ereg_replace("[^a-zA-Z0-9_]", "", $discord);
$custom = mb_ereg_replace("[^a-zA-Z0-9_]", "", $custom);

$query = $db->prepare("UPDATE accounts SET mS = :mS, frS = :frS, cS = :cS, gF = :gF, gO = :gO, youtubeurl = :youtubeurl, twitter = :twitter, twitch = :twitch, instagram = :instagram, tiktok = :tiktok, discord = :discord, custom = :custom WHERE accountID = :accountID");
$query->execute([':mS' => $mS, ':frS' => $frS, ':cS' => $cS, ':gF' => $gF, ':gO' => $gO, ':youtubeurl' => $youtubeurl, ':accountID' => $accountID, ':twitch' => $twitch, ':twitter' => $twitter, ':instagram' => $instagram, ':tiktok' => $tiktok, ':discord' => $discord, ':custom' => $custom]);
echo 1;
$gs->logAction($accountID, 27, $mS, $frS, $cS, $gF, $gO);
$gs->logAction($accountID, 82, $youtubeurl, $twitch, $twitter, $instagram, $tiktok, $discord);
$gs->sendLogsAccountChangeWebhook($accountID, $accountID, $getAccountData);
?>