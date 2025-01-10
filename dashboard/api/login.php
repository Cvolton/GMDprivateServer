<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/security.php";
require "../".$dbPath."config/mail.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_POST["userName"]) AND isset($_POST["password"])){
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$valid = GeneratePass::isValidUsrname($userName, $password);
	if($valid != 1) {
      	if($valid == -2) exit(json_encode(['success' => false, 'error' => '-2']));
		exit(json_encode(['success' => false, 'error' => '-1']));
	}
	$accountID = $gs->getAccountIDFromName($userName);
	if($accountID == 0) exit(json_encode(['success' => false, 'error' => '-3']));
  	$query = $db->prepare("SELECT auth FROM accounts WHERE accountID = :accountID");
  	$query->execute([':accountID' => $accountID]);
  	$auth = $query->fetchColumn();
    if($auth == 'none') {
          $auth = $gs->randomString(8);
          $query = $db->prepare("UPDATE accounts SET auth = :auth WHERE accountID = :accountID");
          $query->execute([':auth' => $auth, ':accountID' => $accountID]);
    }
	$color = $gs->getAccountCommentColor($accountID);
	$gs->logAction($accountID, 2);
	$userID = $gs->getUserID($accountID, $userName);
	$action = $db->prepare("SELECT * FROM users WHERE userID = :userID");
	$action->execute([':userID' => $userID]);
	$action = $action->fetch();
	$iconType = ($action['iconType'] > 8) ? 0 : $action['iconType'];
    $iconTypeMap = [0 => ['type' => 'cube', 'value' => $action['accIcon']], 1 => ['type' => 'ship', 'value' => $action['accShip']], 2 => ['type' => 'ball', 'value' => $action['accBall']], 3 => ['type' => 'ufo', 'value' => $action['accBird']], 4 => ['type' => 'wave', 'value' => $action['accDart']], 5 => ['type' => 'robot', 'value' => $action['accRobot']], 6 => ['type' => 'spider', 'value' => $action['accSpider']], 7 => ['type' => 'swing', 'value' => $action['accSwing']], 8 => ['type' => 'jetpack', 'value' => $action['accJetpack']]];
    $iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
    $avatarImg = $iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $action['color1'] . '&color2=' . $action['color2'] . ($action['accGlow'] != 0 ? '&glow=' . $action['accGlow'] . '&color3=' . $action['color3'] : '');
	$clanID = $gs->isPlayerInClan($accountID);
	if($clanID) {
		$clan = $gs->getClanInfo($clanID);
		$clanArray = [
			'name' => $clan['clan'],
			'color' => $clan['color']
		];
	} else $clanArray = [];
	exit(json_encode(["success" => true, "user" => $userName, "accountID" => $accountID, "auth" => $auth, "color" => $color, "mainIcon" => $avatarImg, 'clan' => $clanArray]));
} elseif(isset($_GET["auth"])) {
	$auth = ExploitPatch::charclean($_GET["auth"]);
	if(empty($auth)) exit(json_encode(['success' => false, 'error' => '-3']));
	$check = GeneratePass::isValidToken($auth);
	if(!is_array($check)) exit(json_encode(['success' => false, 'error' => $check]));
	else {
		$gs->logAction($check['accountID'], 2);
		$action = $db->prepare("SELECT * FROM users WHERE userID = :userID");
		$action->execute([':userID' => $check['userID']]);
		$action = $action->fetch();
		$iconType = ($action['iconType'] > 8) ? 0 : $action['iconType'];
		$iconTypeMap = [0 => ['type' => 'cube', 'value' => $action['accIcon']], 1 => ['type' => 'ship', 'value' => $action['accShip']], 2 => ['type' => 'ball', 'value' => $action['accBall']], 3 => ['type' => 'ufo', 'value' => $action['accBird']], 4 => ['type' => 'wave', 'value' => $action['accDart']], 5 => ['type' => 'robot', 'value' => $action['accRobot']], 6 => ['type' => 'spider', 'value' => $action['accSpider']], 7 => ['type' => 'swing', 'value' => $action['accSwing']], 8 => ['type' => 'jetpack', 'value' => $action['accJetpack']]];
		$iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
		$avatarImg = $iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $action['color1'] . '&color2=' . $action['color2'] . ($action['accGlow'] != 0 ? '&glow=' . $action['accGlow'] . '&color3=' . $action['color3'] : '');
		$clanID = $gs->isPlayerInClan($check['accountID']);
		if($clanID) {
			$clan = $gs->getClanInfo($clanID);
			$clanArray = [
				'name' => $clan['clan'],
				'color' => $clan['color']
			];
		} else $clanArray = [];
		exit(json_encode(['success' => true, 'accountID' => $check['accountID'], 'userID' => $check['userID'], 'user' => $check["userName"], 'color' => $check['color'], "mainIcon" => $avatarImg, 'clan' => $clanArray]));
	}
} else exit(json_encode(['success' => false, 'error' => '0']));
?>