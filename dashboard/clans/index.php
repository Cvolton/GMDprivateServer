<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
if(!$clansEnabled) exit($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action=".">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("pageDisabled").'</p>
	<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
	</form>
</div>', 'browse'));
$isPlayerInClan = $gs->isPlayerInClan($_SESSION["accountID"]);
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("clans"));
$clans = $db->prepare("SELECT clans.*, COUNT(users.clan) AS members FROM clans LEFT JOIN users ON clans.id = users.clan GROUP BY clans.id ORDER BY members DESC;");
$clans->execute();
$clans = $clans->fetchAll();
$style = $closed = $create = "";
foreach($clans as &$clan) {
	$closed = '';
	$name = htmlspecialchars(base64_decode($clan["clan"]));
	$tag = htmlspecialchars(base64_decode($clan["tag"]));
	$desc = $dl->parseMessage(htmlspecialchars(base64_decode($clan["desc"])));
	if(empty($desc)) $desc = $dl->getLocalizedString("noClanDesc");
	$members = $db->prepare("SELECT count(clan) FROM users WHERE clan = :id");
	$members->execute([':id' => $clan["ID"]]);
	$members = $members->fetchColumn() - 1;
	$dontmind = mb_substr($members, -1);
    if($dontmind == 1) $dm = 0; elseif($dontmind < 5 AND $dontmind > 0) $dm = 1; else $dm = 2;
    if($members > 9 AND $members < 20) $dm = 2;
	if($clan["isClosed"] == 1) $closed = ' <i style="font-size:15px;color:#36393e" class="fa-solid fa-lock"></i>';
	// Avatar management
	$avatarImg = '';
    $query = $db->prepare('SELECT userName, iconType, color1, color2, color3, accGlow, accIcon, accShip, accBall, accBird, accDart, accRobot, accSpider, accSwing, accJetpack FROM users WHERE extID = :extID');
    $query->execute(['extID' => $clan["clanOwner"]]);
    $userData = $query->fetch(PDO::FETCH_ASSOC);
    if($userData) {
        $iconType = ($userData['iconType'] > 8) ? 0 : $userData['iconType'];
        $iconTypeMap = [0 => ['type' => 'cube', 'value' => $userData['accIcon']], 1 => ['type' => 'ship', 'value' => $userData['accShip']], 2 => ['type' => 'ball', 'value' => $userData['accBall']], 3 => ['type' => 'ufo', 'value' => $userData['accBird']], 4 => ['type' => 'wave', 'value' => $userData['accDart']], 5 => ['type' => 'robot', 'value' => $userData['accRobot']], 6 => ['type' => 'spider', 'value' => $userData['accSpider']], 7 => ['type' => 'swing', 'value' => $userData['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userData['accJetpack']]];
        $iconValue = isset($iconTypeMap[$iconType]) ? $iconTypeMap[$iconType]['value'] : 1;	    
        $avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userData['color1'] . '&color2=' . $userData['color2'] . ($userData['accGlow'] != 0 ? '&glow=' . $userData['accGlow'] . '&color3=' . $userData['color3'] : '') . '" alt="Avatar" style="width: 30px; height: 30px; vertical-align: middle; object-fit: contain;">';
    }
	$options .= '<div class="profile clanscard"><div style="margin-right: 10px;width: 100%">
		<div class="clansname"><h1>'.sprintf($dl->getLocalizedString('demonlistLevel'), '<span style="color:#'.$clan["color"].';grid-gap: 3px;display: inline-flex;"> ['.$tag.'] '.$name.$closed.'</span>', $clan["clanOwner"], $gs->getAccountName($clan["clanOwner"]), $avatarImg).'</h1>
		<div class="clansmembercount"><h3 style="margin: 0;font-size: 20px;">'.sprintf($dl->getLocalizedString("members".$dm), $members).'</h3><button style="width:max-content;padding:15px;height:max-content" type="button" onclick="a(\'clan/'.$name.'\', true, true)" class="btn-rendel"><i class="fa-solid fa-magnifying-glass"></i></button></div></div>
		<p class="clansdesc">'.$desc.'</p></div>
	</div>';
}
if(empty($options)) {
	$style = "align-items: center !important;align-content: center !important;justify-content:center !important;";
	$options = '<h1>'.$dl->getLocalizedString("noClans").'</h1>';
}
if($_SESSION["accountID"] != 0 AND !$isPlayerInClan) $create = '<button style="width: max-content;height: max-content;padding: 13px 14px;font-size: 25px;position: absolute;bottom: 0;right: 0px;" class="btn-rendel" type="button" onclick="a(\'clans/create.php\')"><i class="fa-solid fa-plus"></i></button>';
$dl->printSong('<div class="form clan-form clans">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("clans").'</h1>
	<div class="form-control clan-form-control" style="'.$style.'">
		'.$options.'
	</div>'.$create.'
</div>', 'browse');
?>