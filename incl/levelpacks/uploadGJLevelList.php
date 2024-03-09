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

if($secret != "Wmfd2893gb7") exit("-100");
if(count(explode(',', $listLevels)) == 0) exit("-6");
if(!is_numeric($accountID)) exit("-9");

if($listID != 0) {
	$list = $db->prepare('SELECT * FROM lists WHERE listID = :listID AND accountID = :accountID');
	$list->execute([':listID' => $listID, ':accountID' => $accountID]);
	$list = $list->fetch();
	if(!empty($list)) {
		$list = $db->prepare('UPDATE lists SET listDesc = :listDesc, listVersion = :listVersion, listlevels = :listlevels, starDifficulty = :difficulty, original = :original, unlisted = :unlisted, updateDate = :timestamp WHERE listID = :listID');
		$list->execute([':listID' => $listID, ':listDesc' => $listDesc, ':listVersion' => $listVersion, ':listlevels' => $listLevels, ':difficulty' => $difficulty, ':original' => $original, ':unlisted' => $unlisted, ':timestamp' => time()]);
		exit($listID);
	}
}
$list = $db->prepare('INSERT INTO lists (listName, listDesc, listVersion, accountID, listlevels, starDifficulty, original, unlisted, uploadDate) VALUES (:listName, :listDesc, :listVersion, :accountID, :listlevels, :difficulty, :original, :unlisted, :timestamp)');
$list->execute([':listName' => $listName, ':listDesc' => $listDesc, ':listVersion' => $listVersion, ':accountID' => $accountID, ':listlevels' => $listLevels, ':difficulty' => $difficulty, ':original' => $original, ':unlisted' => $unlisted, ':timestamp' => time()]);
echo $db->lastInsertId();
?>