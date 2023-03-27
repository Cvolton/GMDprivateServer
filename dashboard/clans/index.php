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
	$name = base64_decode($clan["clan"]);
	$desc = base64_decode($clan["desc"]);
	$members = $db->prepare("SELECT clan FROM users WHERE clan = :id");
	$members->execute([':id' => $clan["ID"]]);
	$members = count($members->fetchAll()) - 1;
	$dontmind = mb_substr($members, -1);
    if($dontmind == 1) $dm = 0; elseif($dontmind < 5 AND $dontmind > 0) $dm = 1; else $dm = 2;
    if($members > 9 AND $members < 20) $dm = 2;
	if($clan["isClosed"] == 1) $closed = ' <i style="font-size:15px;color:#36393e" class="fa-solid fa-lock"></i>';
	$options .= '<div class="profile" style="display: inherit;border-radius: 30px;margin-top: 15px;flex-wrap: nowrap;padding: 0 5 15 20;min-width: 100%;justify-content: space-between;height: max-content;margin-bottom: 0px;align-items: center;"><div style="width: 100%;display: flex;height: 100%;flex-wrap: wrap;flex-direction: column;justify-content: space-between;"><div style="margin-right: 10px;">
		<div style="display: flex;justify-content: space-between;align-items: center;"><h1 style="width:max-content;text-align:left">'.sprintf($dl->getLocalizedString('demonlistLevel'), '<span style="color:#'.$clan["color"].';grid-gap: 3px;display: inline-flex;">'.$name.$closed.'</span>', $clan["clanOwner"], $gs->getAccountName($clan["clanOwner"])).'</h1><div style="display: flex;grid-gap: 5px;align-items: center;"><h3 style="margin: 0;font-size: 20px;">'.sprintf($dl->getLocalizedString("members".$dm), $membercount).'</h3><button style="width:max-content;padding:15px;height:max-content" type="button" onclick="a(\'clan/'.$name.'\', true, true)" class="btn-rendel"><i class="fa-solid fa-magnifying-glass"></i></button></div></div>
		<p style="margin-bottom: 10px;width:100%;text-align:left">'.$desc.'</p></div></div>
	</div>';
}
if(empty($options)) {
	$style = "align-items: center !important;align-content: center !important;justify-content:center !important;";
	$options = '<h1>'.$dl->getLocalizedString("noClans").'</h1>';
}
if($_SESSION["accountID"] != 0 AND !$isPlayerInClan) $create = '<button style="width: max-content;height: max-content;padding: 13px 14px;font-size: 25px;position: absolute;bottom: 0;right: 0px;" class="btn-rendel" type="button" onclick="a(\'clans/create\')"><i class="fa-solid fa-plus"></i></button>';
$dl->printSong('<div class="form" style="position:relative;padding-bottom: 20px;max-width:60vw;width: 60vw;height:77vh;margin-top:10px;border-radius:45px;overflow:auto;overflow-x:hidden;max-height:80vh;justify-content:flex-start">
	<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("clans").'</h1>
	<div class="form-control" style="'.$style.'display: inherit;border-radius: 45px;margin-top: 15px;flex-wrap: wrap;padding: 0px 15px 15px 15px;overflow-y: auto;min-width: 100%;justify-content: space-between;height: 100%;margin-bottom: 0px;align-items: start;align-content:start;">
		'.$options.'
	</div>'.$create.'
</div>', 'browse');
?>