<?php
session_start();
include '../incl/dashboardLib.php';
include '../'.$dbPath.'incl/lib/connection.php';
include_once '../'.$dbPath.'incl/lib/mainLib.php';
include '../'.$dbPath.'incl/lib/exploitPatch.php';
$dl = new dashboardLib(); 
$gs = new mainLib();
$approveCheck = $gs->checkPermission($_SESSION["accountID"], "demonlistApprove");
$addCheck = $gs->checkPermission($_SESSION["accountID"], "demonlistAdd");
if($_GET["add"] == "1" OR $_GET["change"] == "1") {
    $_POST["change"] = 1;
    $dl->printFooter('../../');
} else $dl->printFooter('../');
if(!empty($_POST["sr"]) AND is_numeric($_POST["sr"])) {
	$dl->title($dl->getLocalizedString('submitRecord'));
	$sub = $db->prepare("SELECT * FROM dlsubmits WHERE accountID = :acc AND levelID = :lvl");
	$sub->execute([':acc' => $_SESSION["accountID"], ':lvl' => $_POST["sr"]]);
	$sub = $sub->fetchAll();
	if(!empty($sub)) exit($dl->printSong('<div class="form">
		<h1>'.sprintf($dl->getLocalizedString('submitRecordForLevel'), $gs->getLevelName($_POST["sr"])).'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.sprintf($dl->getLocalizedString('alreadySubmitted'), $gs->getLevelName($_POST["sr"])).'</p>
			<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
		</form></div>', 'browse'));
	if(!empty($_POST["atts"] AND !empty($_POST["ytlink"]))) {
		$string = $gs->randomString(3);
		$ytlink = str_replace('https://', '', $_POST["ytlink"]);
		$ytlink = str_replace('http://', '', $ytlink);
		$ytlink = str_replace('www.youtube.com/watch?v=', '', $ytlink);
		$ytlink = str_replace('youtu.be/', '', $ytlink);
		$submit = $db->prepare("INSERT INTO dlsubmits (accountID, levelID, atts, ytlink, auth) VALUES (:acc, :lid, :atts, :yt, :str)");
		$submit->execute([':acc' => $_SESSION["accountID"], ':lid' => ExploitPatch::remove($_POST["sr"]), ':atts' => ExploitPatch::remove($_POST["atts"]), ':yt' => ExploitPatch::remove($ytlink), ':str' => $string]);
		$gs->dlSubmit($_SESSION["accountID"], ExploitPatch::remove($_POST["sr"]), ExploitPatch::remove($_POST["atts"]), ExploitPatch::remove($ytlink), $string);
		$dl->printSong('<div class="form">
		<h1>'.sprintf($dl->getLocalizedString('submitRecordForLevel'), $gs->getLevelName($_POST["sr"])).'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.sprintf($dl->getLocalizedString('submitSuccess'), $gs->getLevelName($_POST["sr"])).'</p>
			<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
		</form></div>', 'browse');
	} else {
		$dl->printSong('<div class="form">
		<button type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="a a-btn"><h1>'.sprintf($dl->getLocalizedString('submitRecordForLevel'), $gs->getLevelName($_POST["sr"])).'</h1></button>
		<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString('submitRecordDesc').'</p>
			<div class="field" style="display:flex"><input type="number" name="atts" placeholder="'.$dl->getLocalizedString('atts').'">
			<input style="margin-left:10px" type="text" name="ytlink" placeholder="'.$dl->getLocalizedString('ytlink').'"></div>
			<input type="hidden" name="sr" value="'.ExploitPatch::number($_POST["sr"]).'">
			<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'POST\')" class="btn-song">'.$dl->getLocalizedString('submit').'</button>
		</form></div>', 'browse');
	}
} else {
	if(!empty($_POST["change"]) AND $addCheck) {
		if(isset($_POST["place"]) AND !empty($_POST["id"])) {
				$dl->title($dl->getLocalizedString('changeDemon'));
				$place = ExploitPatch::number($_POST["place"]);
				if($place == 0) {
					$change = $db->prepare("DELETE FROM demonlist WHERE levelID = :id");
					$change->execute([':id' => ExploitPatch::number($_POST["id"])]);
					exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString('changeDemon').'</h1>
				<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString('deletedDemon').'</p>
					<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
				</form></div>', 'browse'));
				}
		}
		$dl->title($dl->getLocalizedString('addDemonTitle'));
		if((!empty($_POST["id"]) AND !empty($_POST["place"]) AND !empty($_POST["points"])) OR (!empty($_POST["change"]) AND !empty($_POST["id"]) AND !empty($_POST["place"]))) {
			$place = ExploitPatch::number($_POST["place"]);
			if($place < 1) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString('addDemon').'</h1>
			<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString('smthWentWrong').'</p>
				<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
			</form></div>', 'browse'));
			$lid = ExploitPatch::number($_POST["id"]);
			$ytlink = ExploitPatch::remove($_POST["ytlink"]);
			$ytlink = str_replace('https://', '', $_POST["ytlink"]);
			$ytlink = str_replace('http://', '', $ytlink);
			$ytlink = str_replace('www.youtube.com/watch?v=', '', $ytlink);
			$ytlink = str_replace('youtu.be/', '', $ytlink);
			$points = ExploitPatch::number($_POST["points"]);
			$place -= 2;
			if($place == "-1") $queryplace = 0; else $queryplace = $place + 1; // sorry about this terrible code, i don't wanna write it again
			$dlist = $db->prepare("SELECT pseudoPoints FROM demonlist ORDER BY pseudoPoints DESC LIMIT 2 OFFSET $queryplace");
			$dlist->execute();
			$dlist = $dlist->fetchAll();
			echo count($dlist);
			if(count($dlist) < 1) $average = 30000;
			else {
			$count = 1;
				foreach($dlist as &$dli) {
					$pseudo["number".$count] = $dli["pseudoPoints"];
					$count++;
				}
				$average = ($pseudo["number1"] + $pseudo["number2"]) / 2;
			}
			$dlc = $db->prepare("SELECT count(levelID) FROM demonlist");
			$dlc->execute();
			$dlc = $dlc->fetchColumn();
			if($place == -1) $average = $average * 2;
			elseif($place + 2 == $dlc) $average = $pseudo["number2"] / 2;
			$place += 2;
			if(empty($_GET["change"])) {
				$add = $db->prepare("INSERT INTO demonlist (levelID, authorID, pseudoPoints, giveablePoints, youtube) VALUES (:lid, :aid, :pp, :gp, :yt)");
				$add->execute([':lid' => $lid, ':aid' => $gs->getLevelAuthor($lid), ':pp' => $average, ':gp' => $points, ':yt' => $ytlink]);
				$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString('addDemon').'</h1>
				<form class="form__inner" method="post" action="">
					<p>'.sprintf($dl->getLocalizedString('addedDemon'), $gs->getLevelName($lid), $place).'</p>
					<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
				</form></div>', 'browse');
			} else {
				$arrayoptions = [':id' => $lid, ':pp' => $average];
				if(!empty($points)) {
					$optns .= ', giveablePoints = :gp';
					$arrayoptions[':gp'] = $points;
				}
				if(!empty($ytlink)) {
					$optns .= ', youtube = :yt';
					$arrayoptions[':yt'] = $ytlink;
				}
				$querylol = "UPDATE demonlist SET pseudoPoints = :pp".$optns." WHERE levelID = :id";
				$change = $db->prepare($querylol);
				$change->execute($arrayoptions);
				$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString('changeDemon').'</h1>
				<form class="form__inner" method="post" action="">
					<p>'.sprintf($dl->getLocalizedString('changedDemon'), $gs->getLevelName($lid), $place).'</p>
					<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString('demonlist').'</button>
				</form></div>', 'browse');
			}
		} elseif(empty($_GET["change"])) $dl->printSong('<div class="form">
		<button type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="a a-btn"><h1>'.$dl->getLocalizedString('addDemon').'</h1></button>
		<form class="form__inner" method="post" action="">
			<div><p>'.$dl->getLocalizedString('addDemonDesc').'</p>
			<button type="button" onclick="a(\'demonlist/change\', true, true, \'GET\')"  class="a a-btn"><p style="font-weight: 700;color: #007bff;">'.$dl->getLocalizedString('changeDemon').'</p></button></div>
			<div class="field"><input type="number" name="id" placeholder="'.$dl->getLocalizedString('levelid').'"></div>
			<div class="field"><input type="number" name="place" placeholder="'.$dl->getLocalizedString('place').'"></div>
			<div class="field"><input type="text" name="ytlink" placeholder="'.$dl->getLocalizedString('ytlink').'"></div>
			<div class="field"><input type="number" name="points" placeholder="'.$dl->getLocalizedString('giveablePoints').'"></div>
			<input type="hidden" name="change" value="1">
			<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist\', true, false, \'POST\')" name="change" value="1" class="btn-song">'.$dl->getLocalizedString('add').'</button>
		</form></div>', 'browse');
		else {
			$list = $db->prepare("SELECT * FROM demonlist ORDER BY pseudoPoints DESC");
			$list->execute();
			$list = $list->fetchAll();
			foreach($list as &$ls) $levels .= '<option value="'.$ls["levelID"].'">'.$gs->getLevelName($ls["levelID"]).'</option>';
			$dl->printSong('<div class="form">
				<button type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="a a-btn"><h1>'.$dl->getLocalizedString('changeDemon').'</h1></button>
				<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString('changeDemonDesc').'</p>
					<div class="field"><select style="margin:0" name="id">'.$levels.'</select></div>
					<div class="field"><input type="number" name="place" placeholder="'.$dl->getLocalizedString('place').'"></div>
					<div class="field"><input type="text" name="ytlink" placeholder="'.$dl->getLocalizedString('ytlink').'"></div>
					<div class="field"><input type="number" name="points" placeholder="'.$dl->getLocalizedString('giveablePoints').'"></div>
					<input type="hidden" name="change" value="1">
					<button style="margin-top:5px;margin-bottom:5px" type="button" onclick="a(\'demonlist/change\', true, true, \'POST\')" name="change" value="1" class="btn-song">'.$dl->getLocalizedString('add').'</button>
			</form></div>', 'browse');
		}
	} elseif(!empty($_POST["approve"]) AND $approveCheck) {
		$dl->title($dl->getLocalizedString('recordList'));
		if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
			$page = ($_GET["page"] - 1) * 10;
			$actualpage = $_GET["page"];
		}else{
			$page = 0;
			$actualpage = 1;
		}
		$table = '<table style="position:relative" class="table table-inverse"><button type="button" onclick="a(\'demonlist\', true, false, \'GET\')" class="btn-block" style="position: absolute;padding: 15px;cursor: pointer;margin-left: -20px;margin-top: -20px;width: max-content;font-size: 21px;z-index: 2;" href="demonlist"><i class="fa-solid fa-arrow-left"></i></button><tr><th>#</th><th>'.$dl->getLocalizedString("levelid").'</th><th>'.$dl->getLocalizedString("levelname").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("atts").'</th><th>'.$dl->getLocalizedString("status").'</th></tr>';
			$query = $db->prepare("SELECT * FROM dlsubmits ORDER BY levelID DESC LIMIT 10 OFFSET $page");
			$query->execute();
			$result = $query->fetchAll();
			if(empty($result)) {
				$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action=".">
					<p>'.$dl->getLocalizedString("emptyPage").'</p>
					<button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
				</form>
			</div>', 'browse');
				die();
			} 
		$x = $page + 1;
		foreach($result as &$action){
			$levelid = $action["levelID"];
			$levelname = $gs->getLevelName($levelid);
			$atts = $action["atts"];
			$player = $gs->getAccountName($action["accountID"]);
			if($action["approve"] == 0) $approve = '<a href="demonlist/approve.php?str='.$action["auth"].'" class="btn-rendel">'.$dl->getLocalizedString('checkRecord').'</a>';
			else $approve = $action["approve"] == 1 ? '<text class="btn-rendel btn-success">'.$dl->getLocalizedString('alreadyApproved').'</text>' : '<text class="btn-rendel btn-size">'.$dl->getLocalizedString('alreadyDenied').'</text>';
			$table .= "<tr><th scope='row'>".$x."</th><td>".$levelid."</td><td>".$levelname."</td><td>".$player."</td><td>".$atts."</td><td>".$approve."</td></tr>";
			$x++;
		}
		$table .= '</table>';
		if(!empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM dlsubmits WHERE accountID LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%'");
		else $query = $db->prepare("SELECT count(*) FROM dlsubmits");
		$query->execute();
		$packcount = $query->fetchColumn();
		$pagecount = ceil($packcount / 10);
		$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
		$dl->printPage($table . $bottomrow, true, "browse");
	} else {
		$dl->title($dl->getLocalizedString("demonlist"));
		$list = $db->prepare("SELECT * FROM demonlist ORDER BY pseudoPoints DESC");
		$list->execute();
		$list = $list->fetchAll();
		$options = '';
		$p = 1;
		foreach($list as &$demons) {
			$levelName = $gs->getLevelName($demons["levelID"]);
			if(empty($levelName)) continue;
			switch($p) {
				case 1:
					$place = '<i class="fa-solid fa-trophy" style="color:#ffd700"> 1</i>';
					break;
				case 2:
					$place = '<i class="fa-solid fa-trophy" style="color:#c0c0c0"> 2</i>';
					break;
				case 3:
					$place = '<i class="fa-solid fa-trophy" style="color:#cd7f32"> 3</i>';
					break;
				default:
					$place = '<i class="fa"># '.$p.'</i>';
					break;
			}
			$submitbtn = '<div class="dlposttext">';
			if($_SESSION["accountID"] != 0) {
				$sub = $db->prepare("SELECT * FROM dlsubmits WHERE accountID = :acc AND levelID = :lvl");
				$sub->execute([':acc' => $_SESSION["accountID"], ':lvl' => $demons["levelID"]]);
				$sub = $sub->fetch();
				if(!empty($_POST["delete"]) AND $sub["approve"] != 1) {
						$sub2 = $db->prepare("DELETE FROM dlsubmits WHERE ID = :id");
						$sub2->execute([':id' => $sub["ID"]]);
						$sub = '';
				}
				if(!empty($sub)) {
					if($sub["approve"] == 1) $submitbtn .= '<button style="width: max-content" class="btn-primary" disabled>'.$dl->getLocalizedString('recordApproved').' <i class="fa-solid fa-trophy"></i></button>';
					elseif($sub["approve"] == -1) $submitbtn .= '<button style="width: max-content;padding:5 13" class="btn-primary" disabled>'.$dl->getLocalizedString('recordDenied').' <i class="fa-solid fa-xmark"></i></button><form method="post" style="margin:0"><button style="padding:10px 12px;width: max-content;font-size: 11px;color:#ffb1ab" class="btn-primary" name="delete" value="1"><i class="fa-solid fa-xmark"></i></button></form>';
					else $submitbtn .= '<button style="width: max-content" class="btn-primary" disabled>'.$dl->getLocalizedString('recordSubmitted').' <i class="fa-solid fa-check"></i></button><form method="post" style="margin:0"><button style="padding:10px 12px;width: max-content;font-size: 11px;color:#ffb1ab" class="btn-primary" name="delete" value="1"><i class="fa-solid fa-xmark"></i></button></form>';
				}
				else $submitbtn .= '<form method="post" name="'.$demons["levelID"].'" action="" style="margin:0"><input type="hidden" name="sr" value="'.$demons["levelID"].'"><button style="width: max-content;margin-right:10px" type="button" onclick="a(\'demonlist\', true, false, \'POST\', false, \''.$demons["levelID"].'\')" name="sr" class="btn-primary" value="'.$demons["levelID"].'">'.$dl->getLocalizedString('submitRecord').'</button></form>';
			} else $submitbtn .= '';
			$beat = $db->prepare("SELECT count(*) FROM dlsubmits WHERE approve = 1 AND levelID = :lid");
			$beat->execute([':lid' => $demons["levelID"]]);
			$beat = $beat->fetchColumn();
			$beat2 = mb_substr($beat, -1);
			if($beat != 0) switch($beat2) {
				case 1:
					$beat = sprintf($dl->getLocalizedString('oneBeat'), $beat);
					break;
				case 2:
				case 3:
				case 4:
					$beat = sprintf($dl->getLocalizedString('lower5Beat'), $beat);
					break;
				default:
					$beat = sprintf($dl->getLocalizedString('above5Beat'), $beat);
					break;
			} else $beat = $dl->getLocalizedString('nooneBeat');
			$submitbtn .= '<i style="margin-left:5px" class="fa-solid fa-medal"> '.$demons["giveablePoints"].', <text style="font-family:\'Google Sans\', \'Inter\'">'.$beat.'</text></i></div>';
			$youtube = !empty($demons["youtube"]) ? '<iframe style="border-radius:10px;" width="300" height="169" src="https://www.youtube.com/embed/'.$demons["youtube"].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' : '';
			$options .= '<div class="form-control dlcard"><div class="dlseconddiv"><div style="margin-right: 10px;">
			<div><h1 class="dlh1" style="width:100%;text-align:left">'.$place.' '.sprintf($dl->getLocalizedString('demonlistLevel'), $levelName, $demons["authorID"], $gs->getAccountName($demons["authorID"])).'</h1></div>
			<p class="dlp">'.htmlspecialchars($gs->getDesc($demons["levelID"], true)).'</p></div>'.$submitbtn.'</div>'.$youtube.'
			</div>';
			$p++;
		} 
		if(empty($options) OR $_GET["e"] == 1) {
			$empty = $addCheck ? $dl->getLocalizedString("addSomeDemons") : $dl->getLocalizedString("askForDemons");
			$options = '<div class="form-control dlemptycard"><h1 class="welcomeh1" style="width:100%">'.$dl->getLocalizedString("errorGeneric").'</h1></div>
			<div class="form-control dlemptycard"><h1 class="welcomeh1" style="width:100%">'.$dl->getLocalizedString("noDemons").'</h1></div>
			<div class="form-control dlemptycard"><h1 class="welcomeh1" style="width:100%">'.$empty.'</h1></div>';
		}
		if($addCheck) $changebtn = '<form style="margin:0" method="post" name="changebtn"><input type="hidden" name="change" value="1"><button type="button" onclick="a(\'demonlist/add\', true, true, \'POST\', false, \'changebtn\')" title="'.$dl->getLocalizedString("addDemonTitle").'" style="right: 0.5vw;" class="btn-primary dlbutton" name="change" value="1"><i class="fa-solid fa-plus"></i></button></form>'; else $changebtn = '';
		if($approveCheck) $approvebtn = '<form style="margin:0" method="post" name="approvebtn"><input type="hidden" name="approve" value="1"><button type="button" onclick="a(\'demonlist\', true, false, \'POST\', false, \'approvebtn\')" title="'.$dl->getLocalizedString("approve").'" style="left: 1.5vw;" class="btn-primary dlbutton" name="approve" value="1"><i class="fa-solid fa-list"></i></button></form>'; else $approvebtn = '';
		$dl->printSong('<div class="form demonlist">'.$options.''.$changebtn.''.$approvebtn.'</div>', 'browse');
	}
}
?>