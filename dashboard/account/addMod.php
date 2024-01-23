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
$dl->title($dl->getLocalizedString("addMod"));
$dl->printFooter('../');
$options = $allMods = '';
if($gs->checkPermission($_SESSION["accountID"], "dashboardAddMod")){
	$accountID = $_SESSION["accountID"];
if(!empty($_POST["user"])) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	$mod = ExploitPatch::number($_POST["user"]);
	$role = ExploitPatch::charclean($_POST["role"]);
	if(!is_numeric($role)) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidPost").'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	if(!is_numeric($mod)) $mod = $gs->getAccountIDFromName($mod); 
	$query = $db->prepare("SELECT accountID FROM accounts WHERE accountID=".$mod."");
	$query->execute();
	$res = $query->fetchAll();
	if(count($res) == 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("nothingFound").'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	if($role < $gs->getMaxValuePermission($_SESSION["accountID"], 'roleID')) die($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("modAboveYourRole").'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod'));
	if($mod == $accountID) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("modYourself").'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	$query = $db->prepare("SELECT accountID FROM roleassign WHERE accountID=:mod");
	$query->execute([':mod' => $mod]);
	$res = $query->fetchAll();
	if(count($res) != 0) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("alreadyMod").'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'mod');
		die();
	}
	if($role != '-1') {
		$query = $db->prepare("INSERT INTO roleassign (roleID, accountID) VALUES (:role, :mod)");
		$query->execute([':role' => $role, ':mod' => $mod]);
		$mod2 = $gs->getAccountName($mod);
		$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3) VALUES ('20', :value, :timestamp, :account, :value2, :value3)");
		$query->execute([':value' => $mod2, ':timestamp' => time(), ':account' => $accountID, ':value2' => $mod, ':value3' => $role]);
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("addMod").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.sprintf($dl->getLocalizedString("addedModNew"), $mod).'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("addModOneMore").'</button>
		</form>
		</div>', 'mod');
	} else {
		$query = $db->prepare("DELETE FROM roleassign WHERE accountID = :accID");
		$query->execute([':accID' => $accountID]);
		$mod2 = $gs->getAccountName($mod);
		$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3) VALUES ('20', :value, :timestamp, :account, :value2, :value3)");
		$query->execute([':value' => $mod2, ':timestamp' => time(), ':account' => $accountID, ':value2' => $mod, ':value3' => -1]);
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("addMod").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.sprintf($dl->getLocalizedString("demotedPlayer"), $mod).'</p>
			<button type="button" onclick="a(\'account/addMod.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("addModOneMore").'</button>
		</form>
		</div>', 'mod');
	}
} else {
	$rls = $cls = '';
	$query = $db->prepare("SELECT roleName, roleID, commentColor FROM roles WHERE roleID >= :id");
	$query->execute([':id' => $gs->getMaxValuePermission($_SESSION["accountID"], 'roleID')]);
	$query = $query->fetchAll();
	foreach($query as &$role) {
		$options .= '<option value="'.$role["roleID"].'">'.$role["roleName"].'</option>';
		$rls .=  $role['roleID'].': "'.trim($role['roleName']).'", ';
		$cls .=  $role['roleID'].': "'.trim($role['commentColor']).'", ';
	}
	$rls = substr($rls, 0, -2);
	$cls = substr($cls, 0, -2);
	$options .= '<option value="-1">'.$dl->getLocalizedString('demotePlayer').'</option>';
	$mods = $db->prepare("SELECT * FROM roleassign WHERE roleID >= :id GROUP BY accountID DESC");
  	$mods->execute([':id' => $gs->getMaxValuePermission($_SESSION["accountID"], 'roleID')]);
  	$mods = $mods->fetchAll();
  	foreach($mods as &$mod) {
		$name = $db->prepare("SELECT roleName FROM roles WHERE roleID = :id");
		$name->execute([':id' => $mod["roleID"]]);
		$name = $name->fetch();
		$modName = $name["roleName"];
		$time = $db->prepare("SELECT * FROM modactions WHERE type = 20 AND value2 = :id GROUP BY timestamp DESC LIMIT 1");
		$time->execute([':id' => $mod["accountID"]]);
		$time = $time->fetch();
		if(empty($time["timestamp"])) $time["timestamp"] = 0;
		$allMods .= '<button type="submit" id="wholeButton'.$mod["assignID"].'" onclick="mod('.$mod["assignID"].')" class="btn-primary itembtn">
			<h2 class="subjectnotyou" id="name'.$mod["assignID"].'" style="color:rgb('.$gs->getAccountCommentColor($mod["accountID"]).');font-weight:700">'.$gs->getAccountName($mod["accountID"]).' <i style="opacity: 0; margin-right: 10px; color: white; font-size: 13px;transition:0.2s" id="spin'.$mod["assignID"].'" class="fa-solid fa-spinner fa-spin"></i></h2>
			<h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;" id="stats'.$mod["assignID"].'"><i class="fa-solid fa-circle-dot" id="circle'.$mod["assignID"].'" style="color:rgb('.$gs->getAccountCommentColor($mod["accountID"]).')"></i> <span id="roleName'.$mod["assignID"].'">'.$modName.'</span> | <i class="fa-regular fa-clock"></i> '.$dl->convertToDate($time["timestamp"], true).'</h2>
		</button>';
	}
	$dl->printSong('<div class="form-control itemsbox">
	<div class="itemoverflow"><div class="itemslist">
    <button type="submit" onclick="mod(0)" class="btn-primary itembtn">
        <h2 class="subjectnotyou">'.$dl->getLocalizedString("addMod").'</h2>
        <h2 class="messagenotyou" style="font-size: 15px;color: #c0c0c0;">'.$dl->getLocalizedString("makeNewMod").'</h2>
    </button>'.$allMods.'
    </div></div>
	<div class="form quests-form" style="margin:0;width:150%">
    <h1>'.$dl->getLocalizedString("addMod").'</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>'.$dl->getLocalizedString("addModDesc").'</p>
    <div class="field"><input type="text" name="user" id="p1" placeholder="' . $dl->getLocalizedString("banUserID") . '"></div>
	<div id="selecthihi">
	<select name="role" id="roles">
		'.$options.'
	</select>
	</div>
	'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'account/addMod.php\', true, true, \'POST\')" id="submit" class="btn-primary btn-block" disabled>' . $dl->getLocalizedString("addMod") . '</button>
    </form>
    </div></div><script>
allRoles = {'.$rls.'}
allColors = {'.$cls.'}
function mod(id) {
      if(id != 0) {
     	  document.getElementById("spin" + id).style.opacity = "1";
          map = new XMLHttpRequest();
          map.open("GET", "account/mods.php?id=" + id, true);
          map.onload = function() {
          	  document.getElementById("spin" + id).style.opacity = "0";
              mp = map.response.split(" | ");
              role = mp[1];
              name = mp[2];
			  user = mp[3];
              document.getElementById("p1").value = name;
			  document.getElementById("p1").disabled = true;
			  document.querySelector("#roles").value = role;
              document.getElementsByTagName("h1")[0].innerHTML = "'.$dl->getLocalizedString("reassignMod").'";
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("reassign").' <b>" + user + "</b>.";
          	  document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("reassign").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "change(" + id + ")");
          }
          map.send();
      } else {
      		  document.getElementById("p1").value = "";
			  document.getElementById("p1").removeAttribute("disabled");
			  document.querySelector("#roles").value = 3;
              document.getElementsByTagName("h1")[0].innerHTML = "'.$dl->getLocalizedString("addMod").'";
              document.getElementsByTagName("p")[0].innerHTML = "'.$dl->getLocalizedString("addModDesc").'";
              document.getElementById("submit").innerHTML = "'.$dl->getLocalizedString("addMod").'";
              document.getElementById("submit").type = "button";
              document.getElementById("submit").setAttribute("onclick", "a(\'account/addMod.php\', true, true, \'POST\')");
      }
    }
function change(id) {
	document.getElementById("spin" + id).style.opacity = "1";
    newrole = document.querySelector("#roles").value;
	newname = document.getElementById("p1").value;
    chg = new XMLHttpRequest();
    chg.open("GET", "account/mods.php?id=" + id + "&role=" + newrole + "&acc=" + newname, true);
    chg.onload = function() {
    	document.getElementById("spin" + id).style.opacity = "0";
		if(chg.response != "-1") {
			document.getElementById("submit").classList.remove("btn-size");
			if(newrole == "-1") {
				wholeButton = document.getElementById("wholeButton"+id);
				wholeButton.parentNode.removeChild(wholeButton);
			} else {
				document.getElementById("roleName"+id).innerHTML = allRoles[newrole];
				document.getElementById("circle"+id).style.color = "rgb("+allColors[newrole]+")";
				document.getElementById("name"+id).style.color = "rgb("+allColors[newrole]+")";
			}
		}
		else {
			document.getElementById("submit").classList.add("btn-size");
		}
    }
    chg.send();
}
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-primary");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-primary");
	}
});
</script>', 'mod');
}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>');
?>