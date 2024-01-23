<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$dl->title($dl->getLocalizedString("packCreateTitle"));
$dl->printFooter('../');
$allPacks = '';
if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")){
if(!empty($_POST["packName"])) {
		if(!Captcha::validateCaptcha()) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'levels/packCreate.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
		die();
		}
	$accountID = $_SESSION["accountID"];
	if($_POST['level_1'] == $_POST['level_3'] OR $_POST['level_3'] == $_POST['level_2'] OR $_POST['level_1'] == $_POST['level_2']) {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("sameLevels").'</p>
	        <button type="button" onclick="a(\'levels/packCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>', 'mod');
		die();
	}
	$name = ExploitPatch::remove($_POST["packName"]);
	$color = ExploitPatch::remove($dl->hex2RGB($_POST["color"], true));
	$stars = ExploitPatch::remove($_POST["stars"]);
	$coins = ExploitPatch::remove($_POST["coins"]);
	if(!is_numeric($_POST['level_1']) OR !is_numeric($_POST['level_2']) OR !is_numeric($_POST['level_3']) OR $stars > 10 OR $stars < 0 OR $coins > 2 OR $coins < 0 OR !$gs->getLevelName(ExploitPatch::remove($_POST['level_1'])) OR !$gs->getLevelName(ExploitPatch::remove($_POST['level_2'])) OR !$gs->getLevelName(ExploitPatch::remove($_POST['level_3']))) {
	$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidPost").'</p>
	        <button type="button" onclick="a(\'levels/packCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$levels = ExploitPatch::remove($_POST['level_1']) . ',' . ExploitPatch::remove($_POST['level_2']) . ',' . ExploitPatch::remove($_POST['level_3']);
	switch($stars) {
		case 1:
			$diff = 0;
			break;
		case 2:
			$diff = 1;
			break;
		case 3:
			$diff = 2;
			break;
		case 4:
		case 5:
			$diff = 3;
			break;
		case 6:
		case 7:
			$diff = 4;
			break;
		case 8:
		case 9:
			$diff = 5;
			break;
		case 10:
			$diff = 6;
			break;
	}
	$query = $db->prepare("INSERT INTO mappacks (name, levels, stars, coins, difficulty, rgbcolors, colors2, timestamp) VALUES (:name, :levels, :stars, :coins, :diff, :rgb, :c2, :time)");
	$query->execute([':name' => $name, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':diff' => $diff, ':rgb' => $color, ':c2' => ExploitPatch::remove(str_replace("#", '', $_POST["color"])), ':time' => time()]);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3, value4, value7) VALUES ('17',:value,:timestamp,:account,:levels, :stars, :coins, :rgb)");
	$query->execute([':value' => $name, ':timestamp' => time(), ':account' => $accountID, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':rgb' => $color]);
	$success = $dl->getLocalizedString("packCreateSuccess").' <b style="color:'.$_POST["color"].'">'.$name."</b>!";
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("packCreateTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$success.'</p>
	    <button type="button" onclick="a(\'levels/packCreate.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("packCreateOneMore").'</button>
    </form>
</div>', 'mod');
} else {
  	$packs = $db->prepare("SELECT ID, name, stars, coins, rgbcolors FROM mappacks ORDER BY ID DESC");
  	$packs->execute();
  	$packs = $packs->fetchAll();
  	foreach($packs as &$pack) $allPacks .= '<button type="submit" onclick="pack('.$pack["ID"].')" class="btn-primary itembtn">
        <h2 class="subjectnotyou" style="color:rgb('.$pack["rgbcolors"].')" id="name'.$pack["ID"].'">'.$pack["name"].' <i style="opacity:0; margin-right: 10px; color: white; font-size: 13px;transition:0.2s" id="spin'.$pack["ID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
        <h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$pack["ID"].'"><i class="fa-solid fa-star"></i> '.$pack["stars"].' | <i class="fa-solid fa-coins"></i> '.$pack["coins"].'</h2>
    </button>';
	$dl->printSong('<div class="form-control itemsbox">
	<div class="itemoverflow"><div class="itemslist">
    <button type="submit" onclick="pack(0)" class="btn-primary itembtn">
        <h2 class="subjectnotyou">'.$dl->getLocalizedString("packCreate").'</h2>
        <h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;">'.$dl->getLocalizedString("createNewPack").'</h2>
    </button>'.$allPacks.'
    </div></div>
    <div class="form" style="margin:0;width:100%">
    <h1>' . $dl->getLocalizedString("packCreateTitle") . '</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>' . $dl->getLocalizedString("packCreateDesc") . '</p>
    <div class="field"><input type="text" name="packName" id="p1" placeholder="' . $dl->getLocalizedString("packName") . '"></div>
	<div class="field color123"><input type="color" id="color" name="color" placeholder="' . $dl->getLocalizedString("color") . '"></div>
	<div id="selecthihi">
	<select name="stars" id="stars">
		<option value="10">10 '.$dl->getLocalizedString("starsLevel2").'</option>
		<option value="9">9 '.$dl->getLocalizedString("starsLevel2").'</option>
		<option value="8">8 '.$dl->getLocalizedString("starsLevel2").'</option>
		<option value="7">7 '.$dl->getLocalizedString("starsLevel2").'</option>
		<option value="6">6 '.$dl->getLocalizedString("starsLevel2").'</option>
		<option value="5">5 '.$dl->getLocalizedString("starsLevel2").'</option>
		<option value="4">4 '.$dl->getLocalizedString("starsLevel1").'</option>
		<option value="3">3 '.$dl->getLocalizedString("starsLevel1").'</option>
		<option value="2">2 '.$dl->getLocalizedString("starsLevel1").'</option>
		<option value="1">1 '.$dl->getLocalizedString("starsLevel0").'</option>
	</select>
	<select name="coins" id="coins">
		<option value="2">2 '.$dl->getLocalizedString("coins1").'</option>
		<option value="1">1 '.$dl->getLocalizedString("coins0").'</option>
	</select>
	</div>
    <div class="field">
		<input id="p2" name="level_1" type="number" placeholder="'.$dl->getLocalizedString("levelid").'">
		<input id="p3" style="margin:0px 3px" name="level_2" type="number" placeholder="'.$dl->getLocalizedString("levelid").'">
		<input id="p4" name="level_3" type="number" placeholder="'.$dl->getLocalizedString("levelid").'">
    </div>'.Captcha::displayCaptcha(true).'<button type="button" onclick="a(\'levels/packCreate.php\', true, false, \'POST\')" class="btn-primary btn-block" id="submit" disabled>' . $dl->getLocalizedString("packCreate") . '</button>
    </form>
    </div></div>
    <script>
    function pack(id) {
      if(id != 0) {
     	  document.getElementById("spin" + id).style.opacity = "1";
          map = new XMLHttpRequest();
          map.open("GET", "levels/packs.php?id=" + id, true);
          map.onload = function() {
          	  document.getElementById("spin" + id).style.opacity = "0";
              mp = map.response.split(" | ");
              name = mp[1];
              stars = mp[2];
              coins = mp[3];
              rgb = mp[4].split(",");
              levels = mp[5].split(",");
              document.getElementById("p1").value = name;
              document.getElementById("p2").value = levels[0];
              document.getElementById("p3").value = levels[1];
              document.getElementById("p4").value = levels[2];
              document.getElementById("color").value = rgbToHex(rgb[0], rgb[1], rgb[2]);
              document.querySelector("#stars").value = stars;
              document.querySelector("#coins").value = coins;
              document.getElementsByTagName("h1")[0].innerHTML = \'<i id="x" class="fa-solid fa-xmark" style="color:#ffb1ab;opacity:0;transition:0.2s"></i> '.$dl->getLocalizedString("packChange").' <i id="x2" style="color:#ffb1ab;opacity:0;transition:0.2s" class="fa-solid fa-xmark"></i>\';
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("change").' <b><text style=\"color:" + rgbToHex(rgb[0], rgb[1], rgb[2]) + "\">" + name + "</text></b>.";
          	  document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("change").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "change(" + id + ")");
          }
          map.send();
      } else {
      		  document.getElementById("p1").value = "";
              document.getElementById("p2").value = "";
              document.getElementById("p3").value = "";
              document.getElementById("p4").value = "";
              document.getElementById("color").value = "#000000";
              document.querySelector("#stars").value = 10;
              document.querySelector("#coins").value = 2;
              document.getElementsByTagName("h1")[0].innerHTML = "'.$dl->getLocalizedString("packCreateTitle").'";
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("packCreateDesc").'";
              document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("packCreate").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "a(\'levels/packCreate.php\', true, false, \'POST\')");
      }
    }
function rgbToHex(r, g, b) {
  return "#" + (1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1);
}

function hexToRgb(hex) {
  var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
  hex = hex.replace(shorthandRegex, function(m, r, g, b) {
    return r + r + g + g + b + b;
  });
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null;
}

function change(id) {
	document.getElementById("spin" + id).style.opacity = "1";
	newname = document.getElementById("p1").value;
    newlevels = document.getElementById("p2").value + "," + document.getElementById("p3").value + "," + document.getElementById("p4").value;
    newcolor = hexToRgb(document.getElementById("color").value).r + "," + hexToRgb(document.getElementById("color").value).g + "," + hexToRgb(document.getElementById("color").value).b;
    newstars = document.querySelector("#stars").value;
    newcoins = document.querySelector("#coins").value;
    chg = new XMLHttpRequest();
    chg.open("GET", "levels/packs.php?id=" + id + "&name=" + newname + "&levels=" + newlevels + "&color=" + newcolor + "&stars=" + newstars + "&coins=" + newcoins, true);
    chg.onload = function() {
		document.getElementById("spin" + id).style.opacity = "0";
		if(chg.response != "-1") {
			document.getElementById("x").style.opacity = "0";
			document.getElementById("x2").style.opacity = "0";
			document.getElementById("submit").classList.remove("btn-size");
			document.getElementById("name" + id).innerHTML = newname + \' <i style="opacity:0;transition:0.2s;margin-right: 10px; color: white; font-size: 13px;" id="spin\' + id + \'" class="fa-solid fa-spinner fa-spin"></i>\';
			document.getElementById("stats" + id).innerHTML = \'<i class="fa-solid fa-star"></i> \' + newstars + \' | <i class="fa-solid fa-coins"></i> \' + newcoins;
			document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("change").' <b><text style=\"color:rgb(" + newcolor + ")\">" + newname + "</text></b>.";
		} else {
			document.getElementById("x").style.opacity = "1";
			document.getElementById("x2").style.opacity = "1";
			document.getElementById("submit").classList.add("btn-size");
		}
    }
    chg.send();
}

$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const p3 = document.getElementById("p3");
   const p4 = document.getElementById("p4");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length || !p2.value.trim().length || !p3.value.trim().length || !p4.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-song");
	}
})</script>', 'mod');
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