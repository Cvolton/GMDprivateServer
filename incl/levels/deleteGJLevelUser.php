<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../../config/misc.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../lib/cron.php";
$gs = new mainLib();

$levelID = ExploitPatch::remove($_POST["levelID"]);
$accountID = GJPCheck::getAccountIDOrDie();

if(!is_numeric($levelID)) exit("-1");

$userID = $gs->getUserID($accountID);
$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID AND userID = :userID AND starStars = 0");
$query->execute([':levelID' => $levelID, ':userID' => $userID]);
$getLevelData = $query->fetch();

if(!$getLevelData) exit("-1");

$query = $db->prepare("DELETE FROM comments WHERE levelID = :levelID");
$query->execute([':levelID' => $levelID]);
$query = $db->prepare("DELETE FROM levels WHERE levelID = :levelID AND userID = :userID LIMIT 1");
$query->execute([':levelID' => $levelID, ':userID' => $userID]);
if(file_exists("../../data/levels/$levelID")) rename("../../data/levels/$levelID","../../data/levels/deleted/$levelID");
echo "1";
$gs->logAction($accountID, 8, $getLevelData['levelName'], $getLevelData['levelDesc'], $getLevelData['extID'], $levelID, $getLevelData['starStars'], $getLevelData['starDifficulty']);
$gs->sendLogsLevelChangeWebhook($levelID, $accountID, $getLevelData);
if($automaticCron) {
	Cron::autoban($accountID, false);
	Cron::updateCreatorPoints($accountID, false);
	Cron::updateSongsUsage($accountID, false);
}
?>