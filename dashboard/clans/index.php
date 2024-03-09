<?php
session_start();
include "../incl/dashboardLib.php";
$dl = new dashboardLib();
global $clansEnabled;
if(!$clansEnabled) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>', 'browse'));
include "../".$dbPath."incl/lib/exploitPatch.php";
include_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$isPlayerInClan = $gs->isPlayerInClan($_SESSION["accountID"]);
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("clans"));
$clans = $db->prepare("SELECT * FROM clans ORDER BY creationDate DESC");
$clans->execute();
$clans = $clans->fetchAll();
$style = $closed = $create = "";
foreach($clans as &$clan) {
	$closed = '';
	$name = htmlspecialchars(base64_decode($clan["clan"]));
	$desc = htmlspecialchars(base64_decode($clan["desc"]));
	if(empty($desc)) $desc = $dl->getLocalizedString("noClanDesc");
	$members = $db->prepare("SELECT count(clan) FROM users WHERE clan = :id");
	$members->execute([':id' => $clan["ID"]]);
	$members = $members->fetchColumn() - 1;
	$dontmind = mb_substr($members, -1);
    if($dontmind == 1) $dm = 0; elseif($dontmind < 5 AND $dontmind > 0) $dm = 1; else $dm = 2;
    if($members > 9 AND $members < 20) $dm = 2;
	if($clan["isClosed"] == 1) $closed = ' <i style="font-size:15px;color:#36393e" class="fa-solid fa-lock"></i>';
	$options .= '<div class="profile clanscard"><div style="margin-right: 10px;width: 100%">
		<div class="clansname"><h1>'.sprintf($dl->getLocalizedString('demonlistLevel'), '<span style="color:#'.$clan["color"].';grid-gap: 3px;display: inline-flex;">'.$name.$closed.'</span>', $clan["clanOwner"], $gs->getAccountName($clan["clanOwner"])).'</h1>
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