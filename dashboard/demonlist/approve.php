<?php
session_start();
include '../incl/dashboardLib.php';
$dl = new dashboardLib();
include '../'.$dbPath.'incl/lib/exploitPatch.php';
include '../'.$dbPath.'incl/lib/connection.php';
include_once '../'.$dbPath.'incl/lib/mainLib.php';
$gs = new mainLib();
$dl->printFooter('../');
if(!empty($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0 AND $gs->checkPermission($_SESSION["accountID"], 'demonlistApprove')) {
	$str = ExploitPatch::charclean($_GET["str"]);
	$type = ExploitPatch::rucharclean($_POST["type"]);
	$sub = $db->prepare("SELECT * FROM dlsubmits WHERE auth = :str");
	$sub->execute([':str' => $str]);
	$sub = $sub->fetch();
	if(empty($sub)) {
		die($dl->printSong('<div class="form">
			<h1><b>'.$dl->getLocalizedString("record").'</h1>
			<form class="form__inner" method="post" action="demonlist">
				<p>'.$dl->getLocalizedString("recordDeleted").'</p>
				<button style="margin-top:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
			</form></div>', 'browse'));
	}
	if($sub["approve"] == '1') exit($dl->printSong('<div class="form">
			<h1>'.sprintf($dl->getLocalizedString('demonlistRecord'), $gs->getAccountName($sub["accountID"])).'</h1>
			<form class="form__inner" method="post" action="demonlist">
				<p>'.$dl->getLocalizedString("alreadyApproved").'</p>
				<button style="margin-top:5px;" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
			</form></div>', 'browse'));
	elseif($sub["approve"] == '-1') exit($dl->printSong('<div class="form">
			<h1>'.sprintf($dl->getLocalizedString('demonlistRecord'), $gs->getAccountName($sub["accountID"])).'</h1>
			<form class="form__inner" method="post" action="demonlist">
				<p>'.$dl->getLocalizedString("alreadyDenied").'</p>
				<button style="margin-top:5px;" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
			</form></div>', 'browse'));
	if(!empty($type)) {
		if($type == '1') {
			$ok = $db->prepare("UPDATE dlsubmits SET approve = 1 WHERE auth = :str");
			$ok->execute([':str' => $str]);
			$gs->sendDemonlistResultWebhook($_SESSION['accountID'], $sub['ID']);
			exit($dl->printSong('<div class="form">
			<h1>'.sprintf($dl->getLocalizedString('demonlistRecord'), $gs->getAccountName($sub["accountID"])).'</h1>
			<form class="form__inner" method="post" action="demonlist">
				<p>'.sprintf($dl->getLocalizedString("approveSuccess"), $gs->getAccountName($sub["accountID"])).'</p>
				<button style="margin-top:5px;margin-bottom:10px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
			</form></div>', 'browse'));
		} else {
			$ok = $db->prepare("UPDATE dlsubmits SET approve = -1 WHERE auth = :str");
			$ok->execute([':str' => $str]);
			$gs->sendDemonlistResultWebhook($_SESSION['accountID'], $sub['ID']);
			exit($dl->printSong('<div class="form">
			<h1>'.sprintf($dl->getLocalizedString('demonlistRecord'), $gs->getAccountName($sub["accountID"])).'</h1>
			<form class="form__inner" method="post" action="demonlist">
				<p>'.sprintf($dl->getLocalizedString("denySuccess"), $gs->getAccountName($sub["accountID"])).'</p>
				<button style="margin-top:5px;margin-bottom:10px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
			</form></div>', 'browse'));
		}
	} else $dl->printSong('<div class="form">
		<h1>'.sprintf($dl->getLocalizedString('demonlistRecord'), $gs->getAccountName($sub["accountID"])).'</h1>
		<form class="form__inner" style="margin:0" method="post" action="">
			<input type="hidden" name="str" value="'.$str.'">
			<p>'.sprintf($dl->getLocalizedString('recordParameters'), $gs->getAccountName($sub["accountID"]), $gs->getLevelName($sub["levelID"]), $sub["atts"]).'</p>
			<iframe style="border-radius:15px" width="560" height="315" src="https://www.youtube.com/embed/'.$sub["ytlink"].'" title="'.sprintf($dl->getLocalizedString('demonlistRecord'), $gs->getAccountName($sub["accountID"])).'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<div style="display:flex; width: 100%;margin-bottom:10px">
				<button style="background: #5effaf;margin-top: 5px;margin-bottom: 5px;color: #149957;" type="submit" name="type" value="1" class="btn-primary">'.$dl->getLocalizedString('approve').'</button>
				<button style="margin-left:10px;margin-top:5px;margin-bottom:5px" name="type" value="-1"  type="submit" class="btn-primary btn-size">'.$dl->getLocalizedString('deny').'</button>
			</div>
		</form></div>', 'browse');
}
?>