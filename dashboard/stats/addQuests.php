<?php
session_start();
error_reporting(E_ALL);
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/generatePass.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("addQuest"));
$dl->printFooter('../');
$allQuests = '';
if($gs->checkPermission($_SESSION["accountID"], "toolQuestsCreate")) {
if(!empty($_POST["type"]) AND !empty($_POST["amount"]) AND !empty($_POST["reward"]) AND !empty($_POST["names"])){
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'stats/addQuests.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
	die();
	}
	$type = ExploitPatch::number($_POST["type"]);
	$amount = ExploitPatch::number($_POST["amount"]);
    $reward = ExploitPatch::number($_POST["reward"]);
    $name = ExploitPatch::remove($_POST["names"]);
	$accountID = $_SESSION["accountID"];
		if(!is_numeric($type) OR !is_numeric($amount) OR !is_numeric($reward) OR $type > 3 OR $type < 1){
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidPost").'</p>
				<button type="button" onclick="a(\'stats/addQuests.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
			die();
		}
		$query = $db->prepare("INSERT INTO quests (type, amount, reward, name) VALUES (:type,:amount,:reward,:name)");
		$query->execute([':type' => $type, ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
		$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value2, value3, value4) VALUES ('25',:value,:timestamp,:account,:amount,:reward,:name)");
		$query->execute([':value' => $type, ':timestamp' => time(), ':account' => $accountID, ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
		$success = $dl->getLocalizedString("questsSuccess").' <b>'. $name. '</b>!';
		if($db->lastInsertId() < 3) {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("addQuest").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$success.'</p>
			<p>'.$dl->getLocalizedString("fewMoreQuests").'</p>
			<button type="button" onclick="a(\'stats/addQuests.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("oneMoreQuest?").'</button>
			</form>
		</div>', 'mod');
		} else {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("addQuest").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$success.'</p>
			<button type="button" onclick="a(\'stats/addQuests.php\', true, false, \'GET\')"" class="btn-primary">'.$dl->getLocalizedString("oneMoreQuest?").'</button>
			</form>
		</div>', 'mod');
		}
	} else {
	$quests = $db->prepare("SELECT * FROM quests ORDER BY ID ASC");
  	$quests->execute();
  	$quests = $quests->fetchAll();
  	foreach($quests as &$quest) {
	switch($quest["type"]) {
		case 1:
			$questType = '<i class="fa-solid fa-circle-dot"></i> '.$dl->getLocalizedString("orbs");
			break;
		case 2:
			$questType = '<i class="fa-solid fa-coins"></i> '.$dl->getLocalizedString("coins");
			break;
		case 3:
			$questType = '<i class="fa-solid fa-star"></i> '.$dl->getLocalizedString("stars");
			break;
	}
		$allQuests .= '<button type="submit" onclick="quest('.$quest["ID"].')" class="btn-primary itembtn">
			<h2 class="subjectnotyou" id="name'.$quest["ID"].'">'.$quest["name"].' <i style="opacity: 0; margin-right: 10px; color: white; font-size: 13px;transition:0.2s" id="spin'.$quest["ID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
			<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$quest["ID"].'">'.$questType.' | <i class="fa-solid fa-check"></i> '.$quest["amount"].' | <i class="fa-solid fa-gem"></i> '.$quest["reward"].'</h2>
		</button>';
	}
		$dl->printSong('<div class="form-control itemsbox chatdiv">
		<div class="itemoverflow"><div class="itemslist">
    <button type="submit" onclick="quest(0)" class="btn-primary itembtn">
        <h2 class="subjectnotyou">'.$dl->getLocalizedString("questCreate").'</h2>
        <h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;">'.$dl->getLocalizedString("createNewQuest").'</h2>
    </button>'.$allQuests.'
    </div></div>
	<div class="form quests-form" style="margin:0;width:170%">
    <h1>'.$dl->getLocalizedString("addQuest").'</h1>
    <form class="form__inner" method="post" action="">
	<p>'.$dl->getLocalizedString("addQuestDesc").'</p>
	 <div class="field" id="selecthihi">
	 <input class="quest" type="text" name="names" id="p1" placeholder="'.$dl->getLocalizedString("questName").'"></div>
	 <div class="field" id="selecthihi">
		<select name="type" id="types">
			<option value="1">'.$dl->getLocalizedString("orbs").'</option>
			<option value="2">'.$dl->getLocalizedString("coins").'</option>
			<option value="3">'.$dl->getLocalizedString("stars").'</option>
		</select></div>
        <div class="field" id="selecthihi">
		<input class="number" type="number" name="amount" id="p2" placeholder="'.$dl->getLocalizedString("questAmount").'">
		<input class="number" type="number" name="reward" id="p3" placeholder="'.$dl->getLocalizedString("questReward").'">
		</div>
		', 'mod');
		Captcha::displayCaptcha();
        echo '<button type="button" onclick="a(\'stats/addQuests.php\', true, false, \'POST\')" class="btn-song" id="submit">'.$dl->getLocalizedString("questCreate").'</button>
    </form>
</div></div>
<script>
function types(type) {
	switch(type) {
		case "1":
			return \'<i class="fa-solid fa-circle-dot"></i> '.$dl->getLocalizedString("orbs").'\';
			break;
		case "2":
			return \'<i class="fa-solid fa-coins"></i> '.$dl->getLocalizedString("coins").'\';
			break;
		case "3":
			return \'<i class="fa-solid fa-star"></i> '.$dl->getLocalizedString("stars").'\';
			break;
	}
}
 function quest(id) {
      if(id != 0) {
     	  document.getElementById("spin" + id).style.opacity = "1";
          map = new XMLHttpRequest();
          map.open("GET", "stats/quests.php?id=" + id, true);
          map.onload = function() {
          	  document.getElementById("spin" + id).style.opacity = "0";
              mp = map.response.split(" | ");
              name = mp[1];
              type = mp[2];
              amount = mp[3];
              reward = mp[4];
              document.getElementById("p1").value = name;
              document.getElementById("p2").value = amount;
              document.getElementById("p3").value = reward;
			  document.querySelector("#types").value = type;
              document.getElementsByTagName("h1")[0].innerHTML = \'<i id="x" class="fa-solid fa-xmark" style="color:#ffb1ab;opacity:0;transition:0.2s"></i> '.$dl->getLocalizedString("changeQuest").' <i id="x2" style="color:#ffb1ab;opacity:0;transition:0.2s" class="fa-solid fa-xmark"></i>\';
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("change").' <b>" + name + "</b>.";
          	  document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("change").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "change(" + id + ")");
          }
          map.send();
      } else {
      		  document.getElementById("p1").value = "";
              document.getElementById("p2").value = "";
              document.getElementById("p3").value = "";
			  document.querySelector("#types").value = 1;
              document.getElementsByTagName("h1")[0].innerHTML = "'.$dl->getLocalizedString("addQuest").'";
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("addQuestDesc").'";
              document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("questCreate").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "a(\'stats/addQuests.php\', true, false, \'POST\')");
      }
    }
function change(id) {
	document.getElementById("spin" + id).style.opacity = "1";
	newname = document.getElementById("p1").value;
    newamount = document.getElementById("p2").value;
    newreward = document.getElementById("p3").value;
    newtype = document.querySelector("#types").value;
	typeName = types(newtype);
    chg = new XMLHttpRequest();
    chg.open("GET", "stats/quests.php?id=" + id + "&name=" + newname + "&type=" + newtype + "&amount=" + newamount + "&reward=" + newreward, true);
    chg.onload = function() {
    	document.getElementById("spin" + id).style.opacity = "0";
		if(chg.response != "-1") {
			document.getElementById("x").style.opacity = "0";
			document.getElementById("x2").style.opacity = "0";
			document.getElementById("submit").classList.remove("btn-size");
			document.getElementById("name" + id).innerHTML = newname + \' <i style="opacity:0;transition:0.2s; margin-right: 10px; color: white; font-size: 13px;" id="spin\' + id + \'" class="fa-solid fa-spinner fa-spin"></i>\';
			document.getElementById("stats" + id).innerHTML = typeName + \' | <i class="fa-solid fa-check"></i> \' + newamount + \' | <i class="fa-solid fa-gem"></i> \' + newreward;
			document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("change").' <b>" + newname + "</b>.";
		} else {
			document.getElementById("x").style.opacity = "1";
			document.getElementById("x2").style.opacity = "1";
			document.getElementById("submit").classList.add("btn-size");
		}
    }
    chg.send();
}
</script>';
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
}
?>