<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/exploitPatch.php";
$dl->title($dl->getLocalizedString("gauntletCreateTitle"));
$dl->printFooter('../');
$allGauntlets = '';
if(!isset($_POST["checkbox_data"])) $_POST["checkbox_data"] = "";
if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")){
if($_POST["checkbox_data"] == 'on') {
		if(!Captcha::validateCaptcha()) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
		die();
		}
	$accountID = $_SESSION["accountID"];
	if ($_POST['level_1'] == $_POST['level_2'] ||
    $_POST['level_1'] == $_POST['level_3'] ||
    $_POST['level_1'] == $_POST['level_4'] ||
    $_POST['level_1'] == $_POST['level_5'] ||
    $_POST['level_2'] == $_POST['level_1'] ||
    $_POST['level_2'] == $_POST['level_3'] ||
    $_POST['level_2'] == $_POST['level_4'] ||
    $_POST['level_2'] == $_POST['level_5'] ||
    $_POST['level_3'] == $_POST['level_1'] ||
    $_POST['level_3'] == $_POST['level_2'] ||  /* Sorry */
    $_POST['level_3'] == $_POST['level_4'] ||  /* Say "no" to same levels! */
    $_POST['level_3'] == $_POST['level_5'] || 
    $_POST['level_4'] == $_POST['level_1'] ||
    $_POST['level_4'] == $_POST['level_2'] ||
    $_POST['level_4'] == $_POST['level_3'] ||
    $_POST['level_4'] == $_POST['level_5'] ||
    $_POST['level_5'] == $_POST['level_1'] ||
    $_POST['level_5'] == $_POST['level_2'] ||
    $_POST['level_5'] == $_POST['level_3'] ||
	$_POST['level_5'] == $_POST['level_4']) {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("sameLevels").'</p>
	        <button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>', 'mod');
		die();
	}
	if($_POST['level_1'] == "l1" OR $_POST['level_2'] == "l2" OR $_POST['level_3'] == "l3" OR $_POST['level_4'] == "l4" OR $_POST['level_5'] == "l5") { // idk if its need for now, but ill keep it here
	$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("chooseLevels").'</p>
	        <button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	if(!is_numeric($_POST['level_1']) OR !is_numeric($_POST['level_2']) OR !is_numeric($_POST['level_3']) OR !is_numeric($_POST['level_4']) OR !is_numeric($_POST['level_5'])) {
	$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidPost").'</p>
	        <button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$levels = ExploitPatch::remove($_POST['level_1']) . ',' . ExploitPatch::remove($_POST['level_2']) . ',' . ExploitPatch::remove($_POST['level_3']). ',' . ExploitPatch::remove($_POST['level_4']). ',' . ExploitPatch::remove($_POST['level_5']);
	$query = $db->prepare("INSERT INTO gauntlets (level1, level2, level3, level4, level5, timestamp) VALUES (:l1, :l2, :l3, :l4, :l5, :t)");
	$query->execute([':l1' => ExploitPatch::remove($_POST["level_1"]), ':l2' => ExploitPatch::remove($_POST["level_2"]), ':l3' => ExploitPatch::remove($_POST["level_3"]), ':l4' => ExploitPatch::remove($_POST["level_4"]), ':l5' => ExploitPatch::remove($_POST["level_5"]), ':t' => time()]);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account) VALUES ('18',:value,:timestamp,:account)");
	$query->execute([':value' => $levels, ':timestamp' => time(), ':account' => $accountID]);
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("gauntletCreateTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("gauntletCreateSuccess").'</p>
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
			<h2 class="subjectnotyou" id="name'.$gauntlet["ID"].'">'.$gs->getGauntletName($gauntlet["ID"]).' Gauntlet <i style="opacity:0;transition:0.2s; margin-right: 10px; color: white; font-size: 13px;" id="spin'.$gauntlet["ID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
			<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$gauntlet["ID"].'"><i class="fa-solid fa-star"></i> '.$stars["SUM(starStars)"].'</h2>
		</button>';
	}
	$dl->printSong('<div class="form-control itemsbox">
	<div class="itemoverflow"><div class="itemslist">
    <button type="submit" onclick="gauntlet(0)" class="btn-primary itembtn">
        <h2 class="subjectnotyou">'.$dl->getLocalizedString("gauntletCreate").'</h2>
        <h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;">'.$dl->getLocalizedString("createNewGauntlet").'</h2>
    </button>'.$allGauntlets.'
    </div></div>
	<div class="form" style="margin:0;width:100%">
		<h1>' . $dl->getLocalizedString("gauntletCreateTitle") . '</h1>
		<form class="form__inner form__create" method="post" action="">
		<p>' . $dl->getLocalizedString("gauntletCreateDesc") . '</p>
		<div class="field" style="grid-gap:5px">
		<input id="l1" name="level_1" type="number" placeholder="'.$dl->getLocalizedString("level1").'">
		<input id="l2" name="level_2" type="number" placeholder="'.$dl->getLocalizedString("level2").'">
		</div>
		<div class="field">
		<input id="l3" name="level_3" type="number" placeholder="'.$dl->getLocalizedString("level3").'">
		</div>
		<div class="field" style="grid-gap:5px">
		<input id="l4" name="level_4" type="number" placeholder="'.$dl->getLocalizedString("level4").'">
		<input id="l5" name="level_5" type="number" placeholder="'.$dl->getLocalizedString("level5").'">
    </div>
	<div class="checkbox"><input class="checkbox" type="checkbox" name="checkbox_data" required>'.$dl->getLocalizedString("checkbox").'</div>
	', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="button" onclick="a(\'levels/gauntletCreate.php\', true, false, \'POST\')" class="btn-primary btn-block" id="submit" disabled>' . $dl->getLocalizedString("gauntletCreate") . '</button>
    </form>
    </div></div>
    <script>
	function gauntlet(id) {
      if(id != 0) {
     	  document.getElementById("spin" + id).style.opacity = "1";
          map = new XMLHttpRequest();
          map.open("GET", "levels/gauntlets.php?id=" + id, true);
          map.onload = function() {
          	  document.getElementById("spin" + id).style.opacity = "0";
              mp = map.response.split(" | ");
              l1 = mp[1];
              l2 = mp[2];
              l3 = mp[3];
              l4 = mp[4];
              l5 = mp[5];
			  name = mp[6];
              document.getElementById("l1").value = l1;
              document.getElementById("l2").value = l2;
              document.getElementById("l3").value = l3;
              document.getElementById("l4").value = l4;
              document.getElementById("l5").value = l5;
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
              document.getElementsByTagName("h1")[0].innerHTML = "'.$dl->getLocalizedString("gauntletCreateTitle").'";
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("gauntletCreateDesc").'";
              document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("gauntletCreate").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "a(\'levels/gauntletCreate.php\', true, false, \'POST\')");
      }
    }
function change(id) {
	document.getElementById("spin" + id).style.opacity = "1";
	newl1 = document.getElementById("l1").value;
	newl2 = document.getElementById("l2").value;
	newl3 = document.getElementById("l3").value;
	newl4 = document.getElementById("l4").value;
	newl5 = document.getElementById("l5").value;
    chg = new XMLHttpRequest();
    chg.open("GET", "levels/gauntlets.php?id=" + id + "&l1=" + newl1 + "&l2=" + newl2 + "&l3=" + newl3 + "&l4=" + newl4 + "&l5=" + newl5, true);
    chg.onload = function() {
		document.getElementById("spin" + id).style.opacity = "0";
		if(chg.response != "-1") {
			document.getElementById("x").style.opacity = "0";
			document.getElementById("x2").style.opacity = "0";
			document.getElementById("submit").classList.remove("btn-size");
		} else {
			document.getElementById("x").style.opacity = "1";
			document.getElementById("x2").style.opacity = "1";
			document.getElementById("submit").classList.add("btn-size");
		}
    }
    chg.send();
}
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("l1");
   const p2 = document.getElementById("l2");
   const p3 = document.getElementById("l3");
   const p4 = document.getElementById("l4");
   const p5 = document.getElementById("l5");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length || !p2.value.trim().length || !p3.value.trim().length || !p4.value.trim().length || !p5.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-song");
	}
});
</script>';
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