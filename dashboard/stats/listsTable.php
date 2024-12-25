<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$dl = new dashboardLib();
$gs = new mainLib();
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("listTable"));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0) {
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = $levels = "";
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
$x = 1;
$packtable = "";
$query = $db->prepare("SELECT * FROM lists WHERE unlisted = 0 ORDER BY listID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse');
	die();
} 
$modcheck = $gs->checkPermission($_SESSION["accountID"], "dashboardModTools");
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["listlevels"]);
	$lvltable = "";
	$listDesc = htmlspecialchars(ExploitPatch::url_base64_decode($pack['listDesc']));
	if(empty($listDesc)) $listDesc = '<text style="color:gray">'.$dl->getLocalizedString("noDesc").'</text>';
    $starspack = $pack["starStars"];
    if($pack["starStars"] == 0) $starspack = '<span style="color:grey">0</span>';
  	$coinspack = $pack["countForReward"];
	$pst = '<p class="profilepic"><i class="fa-solid fa-gem" style="color:#a6fffb"></i> '.$starspack.'</p>';
	if($pack["countForReward"] != 0) $pcc = '<p class="profilepic"><i class="fa-solid fa-circle-check"></i> '.$coinspack.'</p>'; else $pcc = '';
	$pd = '<p class="profilepic"><i class="fa-solid fa-face-smile-beam"></i> '.$gs->getListDiffName($pack['starDifficulty']).'</p>';
	$lk = '<p class="profilepic"><i class="fa-solid fa-thumbs-'.($pack['likes'] - $pack['dislikes'] >= 0 ? 'up' : 'down').'"></i> '.abs($pack['likes'] - $pack['dislikes']).'</p>';
	$dload = '<p class="profilepic"><i class="fa-solid fa-reply fa-rotate-270" style="color: #afff9b;"></i> '.$pack['downloads'].'</p>';
	$packall = $dload.$lk.$pst.$pd.$pcc;
	foreach($lvlarray as &$lvl) {
		$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
		$action = $query->fetch();
		if(!$action) continue;
		$lvltable .= $dl->generateLevelsCard($action, $modcheck);
	}
	// Avatar management
	$avatarImg = '';
    $query = $db->prepare('SELECT userName, iconType, color1, color2, color3, accGlow, accIcon, accShip, accBall, accBird, accDart, accRobot, accSpider, accSwing, accJetpack FROM users WHERE extID = :extID');
    $query->execute(['extID' => $pack["accountID"]]);
    $userData = $query->fetch(PDO::FETCH_ASSOC);
    if($userData) {
        $iconType = ($userData['iconType'] > 8) ? 0 : $userData['iconType'];
        $iconTypeMap = [0 => ['type' => 'cube', 'value' => $userData['accIcon']], 1 => ['type' => 'ship', 'value' => $userData['accShip']], 2 => ['type' => 'ball', 'value' => $userData['accBall']], 3 => ['type' => 'ufo', 'value' => $userData['accBird']], 4 => ['type' => 'wave', 'value' => $userData['accDart']], 5 => ['type' => 'robot', 'value' => $userData['accRobot']], 6 => ['type' => 'spider', 'value' => $userData['accSpider']], 7 => ['type' => 'swing', 'value' => $userData['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userData['accJetpack']]];
        $iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
        $avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userData['color1'] . '&color2=' . $userData['color2'] . ($userData['accGlow'] != 0 ? '&glow=' . $userData['accGlow'] . '&color3=' . $userData['color3'] : '') . '" alt="Avatar" style="width: 30px; height: 30px; vertical-align: middle; object-fit: contain;">';
    }
	$packtable .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
		<div class="profile packcard">
			<div class="packname">
				<h1>'.sprintf($dl->getLocalizedString("demonlistLevel"), htmlspecialchars($pack["listName"]), 0, htmlspecialchars($gs->getAccountName($pack['accountID'])), $avatarImg).'</h1>
				<p>'.$listDesc.'</p>
			</div>
			<div class="form-control longfc song-info">
        		'.$packall.'
			</div>
			<div class="form-control new-form-control packlevels">
				'.$lvltable.'
			</div>
			<div class="commentsdiv" style="margin: 0px 5px">
				<h2 class="comments">ID: '.$pack["listID"].'</h2>
				<h2 class="comments">'.$dl->getLocalizedString('date').': '.$dl->convertToDate($pack["uploadDate"], true).'</h2>
			</div>
		</div>
	</div>';
	$x++;
}
$pagecount = ceil($dailycount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage('<div class="form new-form"><h1>'.$dl->getLocalizedString('listTable').'</h1>
	<div class="form-control clan-form-control">
		'.$packtable.'
	</div>
</div>'.$bottomrow, 'browse');
?>