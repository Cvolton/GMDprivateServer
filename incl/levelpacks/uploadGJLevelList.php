<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$accountID = GJPCheck::getAccountIDOrDie();
$listID = ExploitPatch::number($_POST["listID"]);
$listName = !empty(ExploitPatch::remove($_POST["listName"])) ? ExploitPatch::remove($_POST["listName"]) : "Unnamed list";
$listDesc = ExploitPatch::remove($_POST["listDesc"]);
$listLevels = ExploitPatch::remove($_POST["listLevels"]);
$difficulty = ExploitPatch::number($_POST["difficulty"]);
$listVersion = ExploitPatch::number($_POST["listVersion"]) == 0 ? 1 : ExploitPatch::number($_POST["listVersion"]);
$original = ExploitPatch::number($_POST["original"]);
$unlisted = ExploitPatch::number($_POST["unlisted"]);
$secret = ExploitPatch::remove($_POST["secret"]);

if($secret != "Wmfd2893gb7") exit("-1");

if($listID != 0) {
	$list = $db->prepare('SELECT * FROM lists WHERE listID = :listID');
	$list->execute([':listID' => $listID]);
	$list = $list->fetch();
	if(!empty($list)) {
		$list = $db->prepare('UPDATE lists SET listDesc = :listDesc, listVersion = :listVersion, accountID = :accountID, userName = :userName, listlevels = :listlevels, starDifficulty = :difficulty, original = :original, unlisted = :unlisted, uploadDate = :timestamp WHERE listID = :listID');
		$list->execute([':listID' => $listID, ':listDesc' => $listDesc, ':listVersion' => $listVersion, ':accountID' => $accountID, ':userName' => $gs->getAccountName($accountID), ':listlevels' => $listLevels, ':difficulty' => $difficulty, ':original' => $original, ':unlisted' => $unlisted, ':timestamp' => time()]);
		exit($listID);
	} else exit(-1);
}

$list = $db->prepare('INSERT INTO lists (listName, listDesc, listVersion, accountID, userName, listlevels, starDifficulty, original, unlisted, uploadDate) VALUES (:listName, :listDesc, :listVersion, :accountID, :userName, :listlevels, :difficulty, :original, :unlisted, :timestamp)');
$list->execute([':listName' => $listName, ':listDesc' => $listDesc, ':listVersion' => $listVersion, ':accountID' => $accountID, ':userName' => $gs->getAccountName($accountID), ':listlevels' => $listLevels, ':difficulty' => $difficulty, ':original' => $original, ':unlisted' => $unlisted, ':timestamp' => time()]);
echo $db->lastInsertId();
?>