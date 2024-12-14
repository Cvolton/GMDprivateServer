<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/GJPCheck.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."config/misc.php";
$gs = new mainLib();
$levelID = ExploitPatch::number($_POST['levelID']);
$accountID = GJPCheck::getAccountIDOrDie(true) ?: $_SESSION['accountID'];
if(!$levelID) exit(json_encode(['success' => false, 'error' => 0, 'message' => 'Invalid level ID.']));
$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
$level->execute([':levelID' => $levelID]);
$level = $level->fetch();
if(!$level) exit(json_encode(['success' => false, 'error' => 1, 'message' => 'Level was not found!']));
$isPlayerAnAdmin = false;
if($unlistedLevelsForAdmins) {
	$checkAdmin = $db->prepare('SELECT isAdmin FROM accounts WHERE accountID = :accountID');
	$checkAdmin->execute([':accountID' => $accountID]);
	$checkAdmin = $checkAdmin->fetchColumn();
	if($checkAdmin) $isPlayerAnAdmin = true;
}
if($level["unlisted2"] == 1) if(!($level["extID"] == $accountID || $gs->isFriends($accountID, $level["extID"])) && !$isPlayerAnAdmin) exit(json_encode(['success' => false, 'error' => 1, 'message' => 'Level was not found!']));
$GMDFile = $gs->getGMDFile($levelID);
if(!$GMDFile) exit(json_encode(['success' => false, 'error' => 2, 'message' => 'Level data was not found!']));
exit(json_encode(['success' => true, 'levelName' => $level['levelName'], 'GMD' => base64_encode($GMDFile)]));
?>