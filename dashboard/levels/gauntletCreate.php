<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."config/security.php";
$dl->title($dl->getLocalizedString("gauntletCreateTitle"));
$dl->printFooter('../');
$allGauntlets = '';
if($gs->checkPermission($_SESSION["accountID"], "dashboardGauntletCreate")) {
	if(isset($_POST['level_1'], $_POST['level_2'], $_POST['level_3'], $_POST['level_4'], $_POST['level_5'], $_POST['gauntlet_id'])) {
			if(!Captcha::validateCaptcha()) {
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
					<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>', 'mod');
			die();
			}
		$accountID = $_SESSION["accountID"];
		$gauntletLevels = [ExploitPatch::number($_POST['level_1']), ExploitPatch::number($_POST['level_2']), ExploitPatch::number($_POST['level_3']), ExploitPatch::number($_POST['level_4']), ExploitPatch::number($_POST['level_5'])];
		if(array_unique($gauntletLevels) != $gauntletLevels) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("sameLevels").'</p>
				<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
			die();
		}
		if($_POST['level_1'] == "l1" OR $_POST['level_2'] == "l2" OR $_POST['level_3'] == "l3" OR $_POST['level_4'] == "l4" OR $_POST['level_5'] == "l5") { // idk if its need for now, but ill keep it here
		$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("chooseLevels").'</p>
				<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
				</div>', 'mod');
			die();
		}
		if(!is_numeric($_POST['gauntlet_id']) OR !is_numeric($_POST['level_1']) OR !is_numeric($_POST['level_2']) OR !is_numeric($_POST['level_3']) OR !is_numeric($_POST['level_4']) OR !is_numeric($_POST['level_5'])) {
		$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidPost").'</p>
				<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
				</div>', 'mod');
			die();
		}
		$gauntletID = ExploitPatch::number($_POST['gauntlet_id']);
		$levels = $gauntletLevels[0].','.$gauntletLevels[1].','.$gauntletLevels[2].','.$gauntletLevels[3].','.$gauntletLevels[4];
		if($gauntletID > 0) {
			$check = $db->prepare("SELECT * FROM gauntlets WHERE ID = :gid");
			$check->execute([':gid' => $gauntletID]);
			$check = $check->fetch();
			if($check > 0) { // Shit code // Why
				$query = $db->prepare("INSERT INTO gauntlets (level1, level2, level3, level4, level5, timestamp) VALUES (:l1, :l2, :l3, :l4, :l5, :t)");
				$query->execute([':l1' => $gauntletLevels[0], ':l2' => $gauntletLevels[1], ':l3' => $gauntletLevels[2], ':l4' => $gauntletLevels[3], ':l5' => $gauntletLevels[4], ':t' => time()]);
			} else {
				$query = $db->prepare("INSERT INTO gauntlets (ID, level1, level2, level3, level4, level5, timestamp) VALUES (:gid, :l1, :l2, :l3, :l4, :l5, :t)");
				$query->execute([':gid' => $gauntletID, ':l1' => $gauntletLevels[0], ':l2' => $gauntletLevels[1], ':l3' => $gauntletLevels[2], ':l4' => $gauntletLevels[3], ':l5' => $gauntletLevels[4], ':t' => time()]);
			}
		} else {
			$query = $db->prepare("INSERT INTO gauntlets (level1, level2, level3, level4, level5, timestamp) VALUES (:l1, :l2, :l3, :l4, :l5, :t)");
			$query->execute([':l1' => $gauntletLevels[0], ':l2' => $gauntletLevels[1], ':l3' => $gauntletLevels[2], ':l4' => $gauntletLevels[3], ':l5' => $gauntletLevels[4], ':t' => time()]);
		}
		$gauntletID = $db->lastInsertId();
		$gs->sendLogsGauntletChangeWebhook($gauntletID, $_SESSION['accountID']);
		$query = $db->prepare("INSERT INTO modactions  (type, value, value3, timestamp, account) VALUES ('18', :value, :value3, :timestamp, :account)");
		$query->execute([':value' => $levels, ':value3' => $gauntletID, ':timestamp' => time(), ':account' => $accountID]);
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("gauntletCreateTitle").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.sprintf($dl->getLocalizedString("gauntletCreateSuccessNew"), $gs->getGauntletName($gauntletID).' Gauntlet').'</p>
			<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("gauntletCreateOneMore").'</button>
		</form>
	</div>', 'mod');
	} else {
		$gauntlets = $db->prepare("SELECT * FROM gauntlets ORDER BY ID ASC");
		$gauntlets->execute();
		$gauntlets = $gauntlets->fetchAll();
		foreach($gauntlets as &$gauntlet) {
			$strs = $db->prepare("SELECT SUM(starStars) FROM levels WHERE levelID IN (:l1, :l2, :l3, :l4, :l5)");
			$strs->execute([':l1' => $gauntlet["level1"], ':l2' => $gauntlet["level2"], ':l3' => $gauntlet["level3"], ':l4' => $gauntlet["level4"], ':l5' => $gauntlet["level5"]]);
			$stars = $strs->fetch();
			$allGauntlets .= '<button type="submit" onclick="gauntlet('.$gauntlet["ID"].')" class="btn-primary itembtn">
				<h2 class="subjectnotyou" id="name'.$gauntlet["ID"].'"><text id="gname'.$gauntlet["ID"].'">'.$gs->getGauntletName($gauntlet["ID"]).' Gauntlet</text> <i style="opacity:0;transition:0.2s; margin-right: 10px; color: white; font-size: 13px;" id="spin'.$gauntlet["ID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
				<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$gauntlet["ID"].'"><i class="fa-solid fa-star"></i> '.$stars["SUM(starStars)"].' | <i class="fa-solid fa-clock"></i> '.$dl->convertToDate($gauntlet["timestamp"], true).'</h2>
			</button>';
		}
		$gauntletOptions = '<option id="gauntlet_id_option" value="-1">'.$dl->getLocalizedString("gauntletSelectAutomatic").'</option>';
		$query = $db->prepare('SELECT ID FROM gauntlets');
		$query->execute();
		$query = $query->fetchAll();
		$gauntletArray = [];
		foreach($query AS &$key) $gauntletArray[] = $key['ID'];
		for($x = 1; $x <= $gs->getGauntletCount(); $x++) {
			if(is_array($gauntletArray) && !in_array($x, $gauntletArray)) $gauntletOptions .= '<option id="gauntlet_id_option'.$x.'" value="'.$x.'">'.$gs->getGauntletName($x).' Gauntlet</option>';
		}
		$dl->printSong('<div class="form-control itemsbox chatdiv">
		<div class="itemoverflow"><div class="itemslist">
		<button type="submit" onclick="gauntlet(0)" class="btn-primary itembtn">
			<h2 class="subjectnotyou">'.$dl->getLocalizedString("gauntletCreate").'</h2>
			<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;">'.$dl->getLocalizedString("createNewGauntlet").'</h2>
		</button>'.$allGauntlets.'
		</div></div>
		<div class="form" style="margin:0;width:150%">
			<h1>' . $dl->getLocalizedString("gauntletCreateTitle") . '</h1>
			<form class="form__inner form__create" method="post" action="">
			<p>' . $dl->getLocalizedString("gauntletCreateDesc") . '</p>
			<div class="field" style="grid-gap:5px">
			<input id="l1" name="level_1" type="number" placeholder="'.$dl->getLocalizedString("level1").'">
			<input id="l2" name="level_2" type="number" placeholder="'.$dl->getLocalizedString("level2").'">
			</div>
			<div class="field" style="grid-gap:5px">
			<input id="l3" name="level_3" type="number" placeholder="'.$dl->getLocalizedString("level3").'">
			<input id="l4" name="level_4" type="number" placeholder="'.$dl->getLocalizedString("level4").'">
			</div>
			<div class="field" style="grid-gap:5px">
			<input id="l5" name="level_5" type="number" placeholder="'.$dl->getLocalizedString("level5").'">
			<select name="gauntlet_id" id="gauntlet_id">
				'.$gauntletOptions.'
			</select>
		</div>
			'.Captcha::displayCaptcha(true).'
			<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'POST\')" class="btn-primary id="submit">' . $dl->getLocalizedString("gauntletCreate") . '</button>
		</form>
		</div></div>
		<script>
		captchaType = '.($enableCaptcha ? $captchaType : 0).';
		function gauntlet(id) {
		  if(id != 0) {
			  document.getElementById("spin" + id).style.opacity = "1";
			  map = new XMLHttpRequest();
			  map.open("GET", "levels/gauntlets.php?id=" + id, true);
			  map.onload = function() {
				  document.getElementById("spin" + id).style.opacity = "0";
				  mp = JSON.parse(map.response);
				  gid = mp["ID"];
				  l1 = mp["l1"];
				  l2 = mp["l2"];
				  l3 = mp["l3"];
				  l4 = mp["l4"];
				  l5 = mp["l5"];
				  name = mp["name"];
				  document.getElementById("l1").value = l1;
				  document.getElementById("l2").value = l2;
				  document.getElementById("l3").value = l3;
				  document.getElementById("l4").value = l4;
				  document.getElementById("l5").value = l5;
				  document.getElementById("gauntlet_id_option").value = gid;
				  document.getElementById("gauntlet_id_option").innerHTML = name;
				  document.getElementById("gauntlet_id").value = gid;
				  document.getElementsByTagName("h1")[0].innerHTML = \'<i id="x" class="fa-solid fa-xmark" style="color:#ffb1ab;opacity:0;transition:0.2s"></i> '.$dl->getLocalizedString("gauntletChange").' <i id="x2" style="color:#ffb1ab;opacity:0;transition:0.2s" class="fa-solid fa-xmark"></i>\';
				  document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("change").' <b>" + name + "</b>.";
				  document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("change").'";
				  document.getElementById("submit").type = "button";
				  document.getElementById("submit").setAttribute("onclick", "change(" + id + ")");
			  }
			  map.send();
		  } else {
				  document.getElementById("l1").value = "";
				  document.getElementById("l2").value = "";
				  document.getElementById("l3").value = "";
				  document.getElementById("l4").value = "";
				  document.getElementById("l5").value = "";
				  document.getElementById("gauntlet_id_option").value = -1;
				  document.getElementById("gauntlet_id_option").innerHTML = "'.$dl->getLocalizedString("gauntletSelectAutomatic").'";
				  document.getElementById("gauntlet_id").value = -1;
				  document.getElementsByTagName("h1")[0].innerHTML = "'.$dl->getLocalizedString("gauntletCreateTitle").'";
				  document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("gauntletCreateDesc").'";
				  document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("gauntletCreate").'";
				  document.getElementById("submit").type = "button";
				  document.getElementById("submit").setAttribute("onclick", "a(\'levels/gauntletCreate.php\', true, false, \'POST\')");
		  }
		}
	function change(id) {
		switch(captchaType) {
			case 1:
				captcha = hcaptcha;
				captchaName = "h-captcha-response";
				break;
			case 2:
				captcha = grecaptcha;
				captchaName = "g-recaptcha-response";
				break;
			case 3:
				captcha = turnstile;
				captchaName = "cf-turnstile-response";
				break;
			default:
				captcha = false;
				captchaName = "noCaptcha";
				break;
		}
		document.getElementById("spin" + id).style.opacity = "1";
		newl1 = document.getElementById("l1").value;
		newl2 = document.getElementById("l2").value;
		newl3 = document.getElementById("l3").value;
		newl4 = document.getElementById("l4").value;
		newl5 = document.getElementById("l5").value;
		newgid = document.getElementById("gauntlet_id").value;
		if(captcha) captchaResponse = captcha.getResponse();
		else captchaResponse = "";
		chg = new XMLHttpRequest();
		chg.open("GET", "levels/gauntlets.php?id=" + id + "&l1=" + newl1 + "&l2=" + newl2 + "&l3=" + newl3 + "&l4=" + newl4 + "&l5=" + newl5 + "&gid=" + newgid + "&"+captchaName+"=" + captchaResponse, true);
		chg.onload = function() {
			document.getElementById("spin" + id).style.opacity = "0";
			response = JSON.parse(chg.response);
			if(response.success) {
				if(document.getElementById("x") != null) document.getElementById("x").style.opacity = "0";
				if(document.getElementById("x2") != null) document.getElementById("x2").style.opacity = "0";
				document.getElementById("submit").classList.remove("btn-size");
				oldGName = document.getElementById("gname"+id).innerHTML;
				document.getElementById("gname"+id).innerHTML = response.name;
				document.getElementById("name"+id).parentElement.setAttribute("onclick", "gauntlet("+newgid+")");
				document.getElementById("name"+id).id = "name"+newgid;
				document.getElementById("gname"+id).id = "gname"+newgid;
				document.getElementById("spin"+id).id = "spin"+newgid;
				document.getElementById("stats"+id).id = "stats"+newgid;
				document.getElementById("gauntlet_id_option"+newgid).value = id;
				document.getElementById("gauntlet_id_option"+newgid).innerHTML = oldGName;
				document.getElementById("gauntlet_id_option"+newgid).id = "gauntlet_id_option"+id;
				document.getElementById("gauntlet_id_option").value = newgid;
				document.getElementById("gauntlet_id_option").innerHTML = response.name;
				document.getElementById("gauntlet_id").value = newgid;
				document.getElementById("submit").setAttribute("onclick", "change("+newgid+")");
			} else {
				document.getElementById("x").style.opacity = "1";
				document.getElementById("x2").style.opacity = "1";
				document.getElementById("submit").classList.add("btn-size");
			}
			captcha.reset();
		}
		chg.send();
	}
	</script>', 'mod');
	}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>