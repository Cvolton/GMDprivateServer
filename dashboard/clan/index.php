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
		</div>', 'profile'));
include "../".$dbPath."incl/lib/exploitPatch.php";
include_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$getID = explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-1];
if($getID == "settings") {
    $getID = explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-2];
    $_POST["settings"] = 1;
    $dl->printFooter('../../');
	echo '<base href="../../">';
	if(isset($_GET['pending'])) $_POST['pending'] = 1;
} else $dl->printFooter('../');
$clanid = str_replace("%20", " ", ExploitPatch::remove($getID));
if(!is_numeric($clanid)) $clanid = $gs->getClanID($clanid);
$clan = $gs->getClanInfo($clanid);
$isPlayerInClan = $gs->isPlayerInClan($_SESSION["accountID"]);
if(!$clanid OR !$clan) {
	$dl->title($dl->getLocalizedString("clan"));
	exit($dl->printSong('<div class="form">
                	   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
               	 	   <form class="form__inner" method="post" action="">
              		  <p>'.$dl->getLocalizedString("noClan").'</p>
              		  <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
      				 </form>
    			</div>', 'profile'));
}
$dl->title($dl->getLocalizedString("clan").' '.$clan["clan"]);
$back = $members = $settings = $menu = $pending = $membermenu = $requests = $closed = $kick = "";
if(isset($_SERVER["HTTP_REFERER"])) $back = '<form method="post" style="margin:0px" action="'.$_SERVER["HTTP_REFERER"].'"><button style="margin-top: 5px;margin-bottom:5px" type="button" onclick="a(\''.$_SERVER["HTTP_REFERER"].'\', true, true, \'GET\')" class="goback"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>'; else $back = '';
if(!empty($clan)) {
    if(isset($_POST["settings"]) AND $_POST["settings"] == 1 AND $clan["clanOwner"] == $_SESSION["accountID"]) {
        if(!isset($_POST["ichangedsmth"])) {
            if(isset($_POST["givethisclan"])) {
                if(isset($_POST["newOwner"])) {
                    $newOwner = ExploitPatch::number($_POST["newOwner"]);
                    $mbrs = $db->prepare("SELECT * FROM users WHERE clan = :cid AND extID = :own");
                    $mbrs->execute([':cid' => $clan["ID"], ':own' => $newOwner]);
                    $mbrs = $mbrs->fetch();
                    if(empty($mbrs)) exit($dl->printSong('<div class="form">
                	   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
               	 	   <form class="form__inner" method="post" action="">
              		  <p>'.$dl->getLocalizedString("notInYourClan").'</p>
              		  <button type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("settings").'</button>
      				 </form>
    			</div>', 'profile'));
    			    else {
    			        $giveclan = $db->prepare("UPDATE clans SET clanOwner = :own WHERE ID = :id");
    			        $giveclan->execute([':own' => $newOwner, ':id' => $clan["ID"]]);
    			        exit($dl->printSong('<div class="form">
                        	   <h1>'.$dl->getLocalizedString("clan").'</h1>
                       	 	   <form class="form__inner" method="post" action="">
                      		  <p>'.sprintf($dl->getLocalizedString("givedClan"), $gs->getAccountName($newOwner)).'</p>
                      		  <button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("clan").'</button>
              				 </form>
        			</div>', 'profile'));
    			    }
                }
                $mbrs = $db->prepare("SELECT * FROM users WHERE clan = :cid AND extID != :own");
                $mbrs->execute([':cid' => $clan["ID"], ':own' => $clan["clanOwner"]]);
                $mbrs = $mbrs->fetchAll();
                foreach($mbrs as &$mbr) $members .= '<option value="'.$mbr["extID"].'">'.$mbr["userName"].'</option>';
                exit($dl->printSong('<div class="form" style="width: 60vw;max-height: 80vh;position:relative">
            	<div style="height: 100%;width: 100%;"><div class="smallpage">
                	<form method="post" style="margin:0px" action=""><button type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'GET\')" class="goback" style="margin-top:0px"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>
                	<div style="display: flex;flex-direction: column;align-items: center"><h1 style="margin: 0px">'.$dl->getLocalizedString("areYouSure").'</h1></div>
                	<p style="margin-bottom: 10px;">'.$dl->getLocalizedString("giveClanDesc").'</p>
                	<form method="post" style="width:100%">
                	    <select name="newOwner">
                	        '.$members.'
                	    </select>
                	<input type="hidden" name="givethisclan" value="1"></input>
                	</form>
                	<button style="margin-bottom:10px" class="btn-song" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\')">'.$dl->getLocalizedString("giveClan").'</button>
                	</div>
        </div>', 'profile'));
            } elseif(isset($_POST["delclan"])) {
                if(isset($_POST["yesdelete"]) AND $_POST["yesdelete"] == 1) {
                    $delete = $db->prepare("DELETE FROM clans WHERE ID = :id");
                    $delete->execute([':id' => $clan["ID"]]);
					$delete = $db->prepare("UPDATE users SET clan = 0 WHERE clan = :id");
					$delete->execute([':id' => $clan["ID"]]);
                    exit($dl->printSong('<div class="form">
                        	   <h1>'.$dl->getLocalizedString("clan").'</h1>
                       	 	   <form class="form__inner" method="post" action="">
                      		  <p>'.sprintf($dl->getLocalizedString("deletedClan"), $clan["clan"]).'</p>
                      		  <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
              				 </form>
        			</div>', 'profile'));
                }
                exit($dl->printSong('<div class="form" style="width: 60vw;max-height: 80vh;position:relative">
            	<div style="height: 100%;width: 100%;"><div class="smallpage">
                	<form method="post" style="margin:0px" action=""><button type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'GET\')" class="goback" style="margin-top:0px"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>
                	<div style="display: flex;flex-direction: column;align-items: center"><h1 style="margin: 0px">'.$dl->getLocalizedString("areYouSure").'</h1></div>
                	<p style="margin-bottom: 10px;">'.$dl->getLocalizedString("deleteClanDesc").'</p>
                	<form method="post" style="width:100%;margin:0px" name="nolol">
                    	<input type="hidden" name="settings" value="1"></input>
                	</form>
                	<form method="post" style="width:100%;margin:0px" name="delete">
                	    <input type="hidden" name="settings" value="1"></input>
                	    <input type="hidden" name="yesdelete" value="1"></input>
                	    <input type="hidden" name="delclan" value="1"></input>
                	</form>
                	<div class="btns"><button style="margin-bottom:10px" class="btn-song btn-success" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\', false, \'nolol\')">'.$dl->getLocalizedString("goBack").'</button>
                	<button style="margin-bottom:10px;width:50%" style="margin-bottom:10px;width: 50%;" class="btn-song btn-size" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\', false, \'delete\')">'.$dl->getLocalizedString("deleteClan").'</button></div>
                	</div>
        </div>', 'profile'));
            } elseif(isset($_POST["pending"])) {
				if((isset($_POST["yes"]) OR isset($_POST["no"])) AND is_numeric($_POST["accountID"])) {
					$reqs = $db->prepare("SELECT * FROM clanrequests WHERE clanID = :id AND accountID = :acc");
					$reqs->execute([':id' => $clan["ID"], ':acc' => ExploitPatch::number($_POST["accountID"])]);
					$reqs = $reqs->fetch();
					if(!empty($reqs)) {
							$reqs = $db->prepare("DELETE FROM clanrequests WHERE accountID = :acc AND clanID = :cid");
							$reqs->execute([':acc' => ExploitPatch::number($_POST["accountID"]), ':cid' => $clan["ID"]]);
							if(isset($_POST["yes"])) {
								$join = $db->prepare("UPDATE users SET clan = :cid, joinedAt = :time WHERE extID = :id");
								$join->execute([':cid' => $clan["ID"], ':id' => ExploitPatch::number($_POST["accountID"]), ':time' => time()]);
							}
					}
				}
				$reqs = $db->prepare("SELECT * FROM clanrequests WHERE clanID = :id ORDER BY timestamp DESC");
				$reqs->execute([':id' => $clan["ID"]]);
				$reqs = $reqs->fetchAll();
				foreach($reqs as &$rqs) {
					$mbrs = $db->prepare("SELECT * FROM users WHERE extID = :id");
					$mbrs->execute([':id' => $rqs["accountID"]]);
					$mbr = $mbrs->fetch();
					if($mbr["clan"] != 0) continue;
					if($mbr["stars"] == 0) $st = ''; else $st = '<p class="profilepic">'.$mbr["stars"].' <i class="fa-solid fa-star"></i></p>';
					if($mbr["moons"] == 0) $ms = ''; else $ms = '<p class="profilepic">'.$mbr["moons"].' <i class="fa-solid fa-moon"></i></p>';
					if($mbr["diamonds"] == 0) $dm = ''; else $dm = ' <p class="profilepic">'.$mbr["diamonds"].' <i class="fa-solid fa-gem"></i></p>';
					if($mbr["coins"] == 0) $gc = ''; else $gc = '<p class="profilepic">'.$mbr["coins"].' <i class="fa-solid fa-coins" style="color:#ffffbb"></i></p>';
					if($mbr["userCoins"] == 0) $uc = ''; else $uc = '<p class="profilepic">'.$mbr["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
					if($mbr["demons"] == 0) $dn = ''; else $dn = '<p class="profilepic">'.$mbr["demons"].' <i class="fa-solid fa-dragon"></i></p>';
					if($mbr["creatorPoints"] == 0) $cp = ''; else $cp = '<p class="profilepic">'.$mbr["creatorPoints"].' <i class="fa-solid fa-screwdriver-wrench"></i></p>';
					$stats = $st.$dm.$gc.$uc.$dn.$cp;
					if(empty($stats)) $stats = '<p style="font-size:25px;color:#212529">'.$dl->getLocalizedString("empty").'</p>';
					$requests .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
						<div class="profile"><div style="display:flex"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$mbr["userName"].'\', true, true, \'GET\')"><h2 style="color:rgb('.$gs->getAccountCommentColor($mbr["extID"]).')" class="profilenick">'.$mbr["userName"].'</h2></button></div>
						<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
						<form style="width:100%"></form>
						<form name="yes">
							<input type="hidden" name="yes" value="1"></input>
							<input type="hidden" name="pending" value="1"></input>
							<input type="hidden" name="accountID" value="'.$rqs["accountID"].'"></input>
						</form>
						<form name="no">
							<input type="hidden" name="no" value="1"></input>
							<input type="hidden" name="pending" value="1"></input>
							<input type="hidden" name="accountID" value="'.$rqs["accountID"].'"></input>
						</form>
						<div style="display:flex;width:100%;grid-gap:5px"><button class="btn-song btn-success" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\', false, \'yes\')">'.$dl->getLocalizedString("approve").'</button>
						<button class="btn-song btn-size" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\', false, \'no\')">'.$dl->getLocalizedString("deny").'</button></div>
					</div></div>';
				}
				if(empty($requests)) $requests = '<div class="messenger" style="grid-gap: 10px;display: grid;align-content: space-between;">
						<h3 style="margin: 20px 0px 20px 0px;">'.$dl->getLocalizedString("noRequests").'</h3>
					</div>';
				exit($dl->printSong('<div class="form" style="width: 60vw;max-height: 80vh;position:relative">
                	   <h1>'.$dl->getLocalizedString("pendingRequests").'</h1>
               	 	   <form class="form__inner" method="post" action="">
              		    <div class="form-control" style="overflow-wrap: anywhere;display: flex;border-radius: 30px;flex-wrap: wrap;padding-top: 0;max-height: 45vh;padding-bottom: 10px;min-width: 100%;height: max-content;margin-bottom: 5px;align-items: center;">
							'.$requests.'
						</div>
						<input type="hidden" name="pending" value="1"></input>
              		  <button type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("settings").'</button>
      				 </form>
    			</div>', 'profile'));
			}
			if($clan["isClosed"] == 1) {
				$clIcon = '<i id="closeicon" class="fa-solid fa-toggle-on"></i>';
				$pending = '<form style="margin:0" method="post" name="pending"><div><h2 style="text-align:right;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("pendingRequests").'</h2>
                                        <input type="hidden" name="pending" value="1">
                                        <button style="height: max-content; '.($gs->isPendingRequests($clan['ID']) ? 'border: solid 2px #e35151' : '').'" class="btn-rendel" type="button" onclick="a(\'clan/'.$clan['clan'].'/settings\', true, true, \'POST\', false, \'pending\')">'.$dl->getLocalizedString("pendingRequests").'</button>
                                    </form></div>';
			}
			else $clIcon = '<i id="closeicon" class="fa-solid fa-toggle-off"></i>';
        	exit($dl->printSong('<div class="form" style="width: 60vw;max-height: 80vh;position:relative">
            	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;flex-wrap:wrap">
                	<form method="post" style="margin:0px" action=""><button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'GET\')" class="goback" style="margin-top:0px"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>
                      <div style="display: flex;flex-direction: column;align-items: center"><h1>'.$dl->getLocalizedString("settings").'</h1></div>
                      <div style="width: 100%">
                      <form method="post" class="mainsettings" name="mainsettings">
                              <div style="width: 100%;"><h2 style="color: gray;width: 100%;text-align: left;margin: 0;margin-bottom: -10px;font-weight: 500;">'.$dl->getLocalizedString("mainSettings").'</h2>
							  <div class="messenger" style="height:100%;grid-gap: 10px;display: grid;align-content: space-between;">
                                  <div>
                                    <h2 style="text-align:left;margin:0;margin-bottom: 3px;">'.$dl->getLocalizedString("clanName").'</h2>
                                    <input class="form-control" name="clanname" value="'.$clan["clan"].'" placeholder="'.$clan["clan"].'" type="text"></input>
                                  </div>
                                  <div>
                                    <h2 style="text-align:left;margin:0;margin-bottom: 3px;">'.$dl->getLocalizedString("clanDesc").'</h2>
                                    <input class="form-control" name="clandesc" value="'.$clan["desc"].'" placeholder="'.$dl->getLocalizedString("clanDesc").'" type="text"></input>
                                  </div>
                                  <div>
                                    <h2 style="text-align:left;margin:0;margin-bottom: 3px;">'.$dl->getLocalizedString("clanColor").'</h2>
                                    <div class="field color123"><input name="clancolor" value="#'.$clan["color"].'" placeholder="'.$dl->getLocalizedString("clanDesc").'" type="color"></input></div>
                                  </div>
                              </div></div>
                              <div class="secondsettingsform"><h2 style="color: #ffbbbb;width: 100%;text-align: right;margin: 0;margin-bottom: -10px;font-weight: 500;">'.$dl->getLocalizedString("dangerZone").'</h2>
							  <div class="messenger" style="height:100%;grid-gap: 10px;padding-bottom: 0px;display: grid;align-items: flex-end;">
							  <div style="display: flex;justify-content: space-between;align-items: center;">
								<h2 style="text-align:left;margin:0;font-size: 20px;">'.$dl->getLocalizedString("closedClan").'</h2>
								<button style="display:contents;cursor:pointer;font-size: 35px;" type="button" onclick="clanClose()" style="display:contents">'.$clIcon.'</button>
								<input type="hidden" id="closeinput" name="isclosed" value="'.$clan["isClosed"].'"></input>
								<input type="hidden" name="ichangedsmth" value="1"></input>
								<input type="hidden" name="settings" value="1"></input>
							  </div><form style="margin:0" reason="Idk why, but it broked and deletes from page, so dont remove it"></form>
                                <div style="display: grid;grid-gap: 5px;margin:0">
									'.$pending.'
                                    <div>
									<h2 style="text-align:right;margin:0;margin-bottom: 3px;">'.$dl->getLocalizedString("giveClan").'</h2>
                                    <form method="post" style="margin:0" name="givemeclan">
                                        <input type="hidden" name="givethisclan" value="1">
                                        <button style="height: max-content;" class="btn-rendel" type="button" onclick="a(\'clan/'.$clan['clan'].'/settings\', true, true, \'POST\', false, \'givemeclan\')">'.$dl->getLocalizedString("giveClan").'</button>
                                    </form></div>
                                    <div>
                                    <form method="post" name="deleteclan">
                                        <h2 style="text-align:right;margin:0;margin-bottom: 3px;">'.$dl->getLocalizedString("deleteClan").'</h2>
                                        <input type="hidden" name="delclan" value="1">
                                        <button style="height: max-content;" class="btn-song btn-size" type="button" onclick="a(\'clan/'.$clan['clan'].'/settings\', true, true, \'POST\', false, \'deleteclan\')">'.$dl->getLocalizedString("deleteClan").'</button>
                                    </form></div>
                                </div>
                              </div></div>
                        </div>
                       </form>
                    <button style="margin-bottom:10px" class="btn-song" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\', false, \'mainsettings\')">'.$dl->getLocalizedString("saveSettings").'</button>
                </div>
        </div></div>
		<script>
			function clanClose() {
				icon = document.getElementById("closeicon");
				input = document.getElementById("closeinput");
				if(icon.classList.contains("fa-toggle-off")) {
					input.value = 1;
					icon.classList.add("fa-toggle-on");
					icon.classList.remove("fa-toggle-off");
				} else {
					input.value = 0;
					icon.classList.add("fa-toggle-off");
					icon.classList.remove("fa-toggle-on");
				}
			}
		</script>', 'profile'));
        } else {
            $name = base64_encode(strip_tags(ExploitPatch::rucharclean(str_replace(' ', '', $_POST["clanname"]), 20)));
            $desc = base64_encode(strip_tags(ExploitPatch::rucharclean($_POST["clandesc"], 255)));
            $color = ExploitPatch::charclean(mb_substr($_POST["clancolor"], 1), 6);
			$isClosed = ExploitPatch::number($_POST["isclosed"], 1);
            if(!empty($name) AND !empty($color) AND is_numeric($isClosed)) {
				$check = $db->prepare('SELECT count(*) FROM clans WHERE clan LIKE :c');
				$check->execute([':c' => $name]);
				$check = $check->fetchColumn();
				if($check > 0) exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action=".">
						<p>'.$dl->getLocalizedString("takenClanName").'</p>
							<button type="button" onclick="a(\'clan/'.$clan['clan'].'/settings\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>', 'browse'));
                $update = $db->prepare("UPDATE clans SET `clan` = :n, `desc` = :d, `color` = :c, `isClosed` = :ic WHERE `ID` = :id");
                $update->execute([':id' => $clan["ID"], ':n' => $name, ':d' => $desc, ':c' => $color, ':ic' => $isClosed]);
                $clan["clan"] = htmlspecialchars(base64_decode($name));
                $clan["desc"] = htmlspecialchars(base64_decode($desc));
                $clan["color"] = $color;
				$clan["isClosed"] = $isClosed;
            }
        }
    }
    if(isset($_POST["leave"]) AND $_POST["leave"] == 1 AND $isPlayerInClan == $clan["ID"] AND $clan["clanOwner"] != $_SESSION["accountID"]) {
        $leave = $db->prepare("UPDATE users SET clan = 0, joinedAt = :time WHERE extID = :id");
        $leave->execute([':time' => time(), ':id' => $_SESSION["accountID"]]);
        $isPlayerInClan = false;
    }
    elseif(isset($_POST["join"]) AND !$isPlayerInClan AND $_SESSION["accountID"] != 0) {
        if($clan["isClosed"] == 1) {
            if($_POST["join"] == 1) {
                $join = $db->prepare("SELECT * FROM clanrequests WHERE accountID = :acc AND clanID = :cid");
                $join->execute([':acc' => $_SESSION["accountID"], ':cid' => $clan["ID"]]);
                $join = $join->fetch();
                if(empty($join)) {
                    $join = $db->prepare("INSERT INTO clanrequests (accountID, clanID, timestamp) VALUES (:acc, :cid, :time)");
                    $join->execute([':acc' => $_SESSION["accountID"], ':cid' => $clan["ID"], ':time' => time()]);
                }
            } else {
                $join = $db->prepare("DELETE FROM clanrequests WHERE accountID = :acc AND clanID = :cid");
                $join->execute([':acc' => $_SESSION["accountID"], ':cid' => $clan["ID"]]);
            }
        } else {
            $join = $db->prepare("UPDATE users SET clan = :cid, joinedAt = :j WHERE extID = :id");
            $join->execute([':id' => $_SESSION["accountID"], ':cid' => $clan["ID"], ':j' => time()]);
            $isPlayerInClan = $clan["ID"];
        }
    }
	if(isset($_POST["kick"]) AND is_numeric($_POST["accountID"]) AND $clan["clanOwner"] == $_SESSION["accountID"]) {
		$kick = $db->prepare("SELECT clan FROM users WHERE extID = :id");
		$kick->execute([':id' => ExploitPatch::number($_POST["accountID"])]);
		$kick = $kick->fetch();
		if($kick["clan"] == $clan["ID"] AND $clan["clanOwner"] != ExploitPatch::number($_POST["accountID"])) {
			$kick = $db->prepare("UPDATE users SET clan = 0, joinedAt = :j WHERE extID = :id");
            $kick->execute([':id' => ExploitPatch::number($_POST["accountID"]), ':j' => time()]);
		}
	}
    if($clan["isClosed"] == 1) $closed = ' <i style="font-size:15px;color:#36393e" class="fa-solid fa-lock"></i>';
    $clanname = "<h1 class='clanname' style='color:#".$clan["color"].";'>".htmlspecialchars($clan["clan"]).$closed."</h1>";
    $mbrs = $db->prepare("SELECT * FROM users WHERE clan = :cid");
    $mbrs->execute([':cid' => $clan["ID"]]);
    $mbrs = $mbrs->fetchAll();
    foreach($mbrs as &$mbr) {
		if($clan["clanOwner"] == $_SESSION["accountID"]) $kick = '<form name="kick" style="margin:0px"><input type="hidden" name="kick" value="1"></input><input type="hidden" name="accountID" value="'.$mbr["extID"].'"></input></form>
			<button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'POST\', false, \'kick\')" style="width: max-content;height: max-content;color: #ffbbbb;padding: 7px 10px;" title="'.$dl->getLocalizedString("kickMember").'" class="btn-rendel"><i class="fa-solid fa-xmark"></i></button>';
        if($mbr["stars"] == 0) $st = ''; else $st = '<p class="profilepic">'.$mbr["stars"].' <i class="fa-solid fa-star"></i></p>';
		if($mbr["moons"] == 0) $ms = ''; else $ms = '<p class="profilepic">'.$mbr["moons"].' <i class="fa-solid fa-moon"></i></p>';
        if($mbr["diamonds"] == 0) $dm = ''; else $dm = ' <p class="profilepic">'.$mbr["diamonds"].' <i class="fa-solid fa-gem"></i></p>';
        if($mbr["coins"] == 0) $gc = ''; else $gc = '<p class="profilepic">'.$mbr["coins"].' <i class="fa-solid fa-coins" style="color:#ffffbb"></i></p>';
        if($mbr["userCoins"] == 0) $uc = ''; else $uc = '<p class="profilepic">'.$mbr["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
        if($mbr["demons"] == 0) $dn = ''; else $dn = '<p class="profilepic">'.$mbr["demons"].' <i class="fa-solid fa-dragon"></i></p>';
        if($mbr["creatorPoints"] == 0) $cp = ''; else $cp = '<p class="profilepic">'.$mbr["creatorPoints"].' <i class="fa-solid fa-screwdriver-wrench"></i></p>';
        $stats = $st.$ms.$dm.$gc.$uc.$dn.$cp;
        if(empty($stats)) $stats = '<p style="font-size:25px;color:#212529">'.$dl->getLocalizedString("empty").'</p>';
		$mbr["userName"] = $mbr["userName"] == 'Undefined' ? $gs->getAccountName($mbr['extID']) : $mbr['userName'];
        if($mbr["extID"] != $clan["clanOwner"]) $members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div class="clanmemberndiv"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$mbr["userName"].'\', true, true, \'GET\')"><h2 style="color:rgb('.$gs->getAccountCommentColor($mbr["extID"]).')" class="profilenick clanmembernick">'.$mbr["userName"].'</h2></button>'.$kick.'</div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<h3 id="comments" style="justify-content: flex-end;grid-gap: 0.5vh;">'.sprintf($dl->getLocalizedString("joinedAt"), $dl->convertToDate($mbr["joinedAt"], true)).'</h3>
		</div></div>';
		else $owner = '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display:flex"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$mbr['userName'].'\', true, true, \'GET\')"><h1 style="margin: 0;margin-bottom: 10px;color:rgb('.$gs->getAccountCommentColor($mbr["extID"]).')" class="profilenick clanownernick">'.$mbr["userName"].' <i style="color:#ffff91" class="fa-solid fa-crown"></i></h1></button></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<h3 class="comments clancreatetext">'.sprintf($dl->getLocalizedString("createdAt"), $dl->convertToDate($clan["creationDate"], true)).'</h3>
		</div></div>';
    }
    if(empty($members)) $members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			    <h1 style="margin: 10;margin-top: 20px;">'.$dl->getLocalizedString("noMembers").'</h1>
			</div>';
	$clan['desc'] = htmlspecialchars($clan['desc']);
	if(empty($clan["desc"])) $clan["desc"] = $dl->getLocalizedString("noClanDesc");
    if($clan["clanOwner"] == $_SESSION["accountID"]) $settings = '<form method="post" style="margin:0px" name="settingsform"><input type="hidden" name="settings" value="1"><button style="margin-top: 5px;margin-bottom:5px;position: relative" type="button" onclick="a(\'clan/'.$clan["clan"].'/settings\', true, true, \'POST\', false, \'settingsform\')" title="'.$dl->getLocalizedString("settings").'" class="msgupd" name="settings" value="1">'.($gs->isPendingRequests($clan['ID']) ? '<i style=" position: absolute;top: 18%; left: 18%;font-size: 40%; border: solid 3px #212529;border-radius: 500px;color: #e35151;" class="fa-solid fa-circle" aria-hidden="true"></i>' : '').'<i class="fa-solid fa-gear" aria-hidden="true"></i></button></form>';
    elseif($isPlayerInClan == $clan["ID"]) $membermenu = '<form name="leave" style="margin:0"><input name="leave" type="hidden" value="1"></input></form><button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'POST\', false, \'leave\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>'.$dl->getLocalizedString("leaveFromClan").'</button>';
    elseif(!$isPlayerInClan) {
        if($clan["isClosed"] == 1) {
            $join = $db->prepare("SELECT * FROM clanrequests WHERE accountID = :acc AND clanID = :cid");
            $join->execute([':acc' => $_SESSION["accountID"], ':cid' => $clan["ID"]]);
            $join = $join->fetch();
            if(empty($join)) $membermenu = '<form name="join" style="margin:0"><input name="join" type="hidden" value="1"></input></form><button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'POST\', false, \'join\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-arrow-right-to-bracket"></i></div>'.$dl->getLocalizedString("askToJoin").'</button>';
            else $membermenu = '<form name="join" style="margin:0"><input name="join" type="hidden" value="-1"></input></form><button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'POST\', false, \'join\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-xmark"></i></div>'.$dl->getLocalizedString("removeClanRequest").'</button>';
        } else $membermenu = '<form name="join" style="margin:0"><input name="join" type="hidden" value="1"></input></form><button type="button" onclick="a(\'clan/'.$clan["clan"].'\', true, true, \'POST\', false, \'join\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-user-plus"></i></div>'.$dl->getLocalizedString("joinClan").'</button>';
    }
    $membercount = count($mbrs) - 1; // cuz owner
    $dontmind = mb_substr($membercount, -1);
    if($dontmind == 1) $dm = 0; elseif($dontmind < 5 AND $dontmind > 0) $dm = 1; else $dm = 2;
    if($membercount > 9 AND $membercount < 20) $dm = 2;
    if($_SESSION["accountID"] != 0 AND $clan["clanOwner"] != $_SESSION["accountID"] AND !empty($membermenu)) $menu = '<li class="nav-item dropdown dropleft" style="position: absolute;right: 8px; list-style-type: none;top: 8px;">
					<a style="margin: 0px;padding: 10px 17px; font-size: 17px;" class="nav-link dropdown-toggle menu-arrow dropleft msgupd" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical" aria-hidden="true"></i></a>
					<div style="background: #141414" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink">
						'.$membermenu.'
					</div>
				</li>';
    $dl->printSong('<div class="form profileform">
    	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;">
    	<style>.menu-arrow::after {display:none}</style>
        	'.$back.'<div style="display: flex;flex-direction: column;align-items: center">'.$clanname.'</div>'.$settings.$menu.'
        </div>
        <p class="clandesc">'.$clan["desc"].'</p>
        <div>
            <h3 class="clanownertext">'.$dl->getLocalizedString("clanOwner").'</h3>
            <div class="form-control clan-owner-form">'.$owner.'</div>
        </div>
        <div>
            <div style="width:100%;display:flex;justify-content: space-between;"><h3 class="clanmemberstext" style="text-align: left;">'.$dl->getLocalizedString("clanMembers").'</h3>
            <h3 class="clanmemberstext" style="text-align: right;">'.sprintf($dl->getLocalizedString("members".$dm), $membercount).'</h3></div>
            <div class="form-control dmbox" style="overflow-wrap: anywhere;display: flex;border-radius: 30px;flex-wrap: wrap;padding-top: 0;max-height: 33.5vh;padding-bottom: 10px;min-width: 100%;height: max-content;margin-bottom: 17px;align-items: center;">
        	'.$members.'
</div></div></div>', 'profile');
}
?>
