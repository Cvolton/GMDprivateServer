<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("leaderboardTime"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$time = time() - 86400;
$bans = $gs->getAllBansOfBanType(0);
$extIDs = $userIDs = $bannedIPs = [];
foreach($bans AS &$ban) {
	switch($ban['personType']) {
		case 0:
			$extIDs[] = $ban['person'];
			break;
		case 1:
			$userIDs[] = $ban['person'];
			break;
		case 2:
			$bannedIPs[] = $gs->IPForBan($ban['person'], true);
			break;
	}
}
$extIDsString = implode("','", $extIDs);
$userIDsString = implode("','", $userIDs);
$bannedIPsString = implode("|", $bannedIPs);
$queryArray = [];
if(!empty($extIDsString)) $queryArray[] = "extID NOT IN ('".$extIDsString."')";
if(!empty($userIDsString)) $queryArray[] = "userID NOT IN ('".$userIDsString."')";
if(!empty($bannedIPsString)) $queryArray[] = "IP NOT REGEXP '".$bannedIPsString."'";
$queryText = !empty($queryArray) ? '('.implode(' AND ', $queryArray).') AND' : '';
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.extID WHERE type = '9' AND timestamp > :time AND ".$queryText." actions.value > 0 GROUP BY (stars) DESC ORDER BY stars DESC LIMIT 10 OFFSET $page");
$query->execute([':time' => $time]);
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
foreach($result as &$action){
	$userid = $action["extID"];
	$stars = $action["stars"];
	$strs = $stars[strlen($stars)-1];
	if($strs == 1) $star = 0; elseif($strs < 5 AND $strs != 0 AND ($stars > 20 OR $stars < 10)) $star = 1; else $star = 2;
	$coin = $db->prepare("SELECT SUM(coins) FROM levelscores WHERE accountID = :id AND uploadDate > :time");
	$coin->execute([':id' => $userid, ':time' => $time]);
	$coins = $coin->fetchColumn();
	if(empty($coins)) $coins = 0;
	$cns = $coins[strlen($coins)-1];
  	if($cns == 1) $lvl = 0; elseif($cns < 5 AND $cns > 0 AND ($cns > 20 OR $cns < 10)) $lvl = 1; else $lvl = 2;
	if(empty($action["userCoins"])) $action["userCoins"] = 0;
	$st = '<p class="profilepic">'.$action["stars"].' <i class="fa-solid fa-star"></i></p>';
	$uc = '<p class="profilepic">'.$action["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
	$stats = $dl->createProfileStats($action["stars"], 0, 0, 0, $action['userCoins'], 0, 0, 0);
	switch($x) {
		case 1:
			$place = '<i class="fa-solid fa-trophy" style="color:#ffd700;"> 1</i>';
			break;
		case 2:
			$place = '<i class="fa-solid fa-trophy" style="color:#c0c0c0;"> 2</i>';
			break;
		case 3:
			$place = '<i class="fa-solid fa-trophy" style="color:#cd7f32;"> 3</i>';
			break;
		default:
			$place = '<i class="fa" style="color:white;"># '.$x.'</i>';
			break;
	}
	// Avatar management
	$avatarImg = '';
	$extIDvalue = $action['extID'];
    $query = $db->prepare('SELECT userName, iconType, color1, color2, color3, accGlow, accIcon, accShip, accBall, accBird, accDart, accRobot, accSpider, accSwing, accJetpack FROM users WHERE extID = :extID');
    $query->execute(['extID' => $extIDvalue]);
    $userData = $query->fetch(PDO::FETCH_ASSOC);
    if($userData) {
        $iconType = ($userData['iconType'] > 8) ? 0 : $userData['iconType'];
        $iconTypeMap = [0 => ['type' => 'cube', 'value' => $userData['accIcon']], 1 => ['type' => 'ship', 'value' => $userData['accShip']], 2 => ['type' => 'ball', 'value' => $userData['accBall']], 3 => ['type' => 'ufo', 'value' => $userData['accBird']], 4 => ['type' => 'wave', 'value' => $userData['accDart']], 5 => ['type' => 'robot', 'value' => $userData['accRobot']], 6 => ['type' => 'spider', 'value' => $userData['accSpider']], 7 => ['type' => 'swing', 'value' => $userData['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userData['accJetpack']]];
        $iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
        $avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userData['color1'] . '&color2=' . $userData['color2'] . ($userData['accGlow'] != 0 ? '&glow=' . $userData['accGlow'] . '&color3=' . $userData['color3'] : '') . '" alt="Avatar" style="width: 30px; height: 30px; vertical-align: middle; object-fit: contain;">';
    }
	$members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'GET\')"><div class="acclistdiv">
				<h2 style="color:rgb('.$gs->getAccountCommentColor($userid).'); align-items: baseline;" class="profilenick acclistnick"><div class="accounts-badge-icon-div">'.$place.$action["userName"].$avatarImg.'</div></h2>
			</div></button></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div class="acccomments"><h3 class="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("accountID").': <b>'.(is_numeric($userid) ? $userid : 0).'</b></h3></div>
		</div></div>';
		$x++;
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("leaderboardTime").'</h1>
<div class="form-control new-form-control">
		'.$members.'
	</div></div>';
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND ".$queryText." timestamp > :time  GROUP BY (stars) DESC ORDER BY stars DESC");
$query->execute([':time' => $time]);
$packcount = 0;
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "stats");
?>