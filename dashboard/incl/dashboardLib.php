<?php
$dbPath = '../'; // Path to main directory. It needs to point to main endpoint files. If you didn't changed dashboard place, don't change this value. Usually, its '../' (cuz dashboard folder is inside main endpoints folder) (https://imgur.com/a/P8LdhzY).
include __DIR__."/../".$dbPath."config/dashboard.php";
include_once "auth.php";
$au = new au();
$au->auth($dbPath);
// Dashboard library
class dashboardLib {
	public function printHeader($isSubdirectory = true){
		$this->handleLangStart();
      	global $gdps;
		echo '<!DOCTYPE html>
				<html lang="en">
					<head>
                    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
						<link rel="icon" type="image/png" sizes="64x64" href="/favicon.png">
						<meta charset="utf-8">
						<meta name="color-scheme" content="dark">
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit="no">';
          	if($isSubdirectory) echo '<base href="../">';
				echo '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                          <script src="https://kit.fontawesome.com/10e18026cb.js" crossorigin="anonymous"></script>
                          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
                          <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
                          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
						  <link href="incl/fontawesome/css/fontawesome.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/brands.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/solid.css" rel="stylesheet">
                          <link async rel="stylesheet" href="incl/cvolton.css">
						  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                          <title>'.$gdps.'</title>';
		echo '</head>
				<body><div style="height: 100%;display: contents;">';
	}
	public function getLocalizedString($stringName, $lang = ''){
		if(empty($lang)) {
			if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])){
				if(file_exists('/lang/locale'.strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))).'.php') $lang = strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
				else $lang = "EN";
			}else{
				$lang = $_COOKIE["lang"];
			}
		}
		$locale = __DIR__ . "/lang/locale".$lang.".php";
		if(file_exists($locale)){
			include $locale;
		}else{
			include __DIR__ . "/lang/localeRU.php";
		}
		if($lang == "TEST"){
			return "$stringName";
		}
		if(isset($string[$stringName])){
			return $string[$stringName];
		}else{
		    include __DIR__."/lang/localeEN.php";
		    if(isset($string[$stringName])) return $string[$stringName];
			else return "lnf:$stringName";
		}
	}
	public function printBoxBody(){
		echo '<span id="htmlpage" style="width: 100%;height: 100%;display: contents;"><div class="container container-box">
					<div class="card">
						<div class="card-block buffer">';
	}
	public function printBox($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active);
		$this->printBoxBody();
		echo $content;
		$this->printBoxFooter();
		$this->printFooter();
	}
	public function printSong($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active);
		echo '<span id="htmlpage" style="width: 100%;height: 100%;display: contents;">'.$content.'</span>';
	}
	public function printBoxFooter(){
		echo '</div></div></div></span>';
	}
	public function printFooter($sub = ''){
		global $dbPath;
      	global $vk;
      	global $discord;
      	global $twitter;
      	global $youtube;
      	global $twitch;
		echo '<div class="footer">'.$this->getLocalizedString("footer").'<div>';
        if($youtube != '') echo '<a href="'.$youtube.'" target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/youtube.png"></a>';
        if($discord != '') echo '<a href="'.$discord.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/discord.png"></a>';
      	if($twitter != '') echo '<a href="'.$twitter.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/twitter.png"></a>';
      	if($vk != '') echo '<a href="'.$vk.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/vk.png"></a>';
      	if($twitch != '') echo '<a href="'.$twitch.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/twitch.png"></a>';
        echo '</div></div></div></body>
		</html>';
	}
	public function printLoginBox($content){
		$this->printBox("<h1 id='center'>".$this->getLocalizedString("loginBox")."</h1>".$content);
	}
	public function printLoginBoxInvalid(){
		$this->printLoginBox("<p>".$this->getLocalizedString("wrongNickOrPass")."");
	}
	public function printLoginBoxError($content){
		$this->printLoginBox("<p>An error has occured: $content. <a href=''>Click here to try again.</a>");
	}
	public function printNavbar($active){
		global $gdps;
		global $lrEnabled;
      	global $msgEnabled;
      	global $songEnabled;
      	global $clansEnabled;
      	global $pc;
      	global $mac;
      	global $android;
        global $ios;
        global $pcLauncher;
        global $macLauncher;
        global $androidLauncher;
        global $iosLauncher;
		global $thirdParty;
      	global $dbPath;
		include_once __DIR__."/../".$dbPath."incl/lib/Captcha.php";
		include_once __DIR__."/../".$dbPath."config/security.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
      	include __DIR__."/../".$dbPath."incl/lib/connection.php";
		$gs = new mainLib();
		if($enableCaptcha) {
			echo '<div id="captchadiv">';
			Captcha::displayCaptcha('no');
			echo "</div>";
		}
		$homeActive = $accountActive = $browseActive = $modActive = $reuploadActive = $statsActive = $msgActive = $profileActive = "";
		switch($active){
			case "home":
				$homeActive = "active tooactive";
				break;
			case "account":
				$accountActive = "active tooactive";
				break;
			case "browse":
				$browseActive = "active tooactive";
				break;
			case "mod":
				$modActive = "active tooactive";
				break;
			case "reupload":
				$reuploadActive = "active tooactive";
				break;
			case "stats":
				$statsActive = "active tooactive";
				break;
           	case "msg":
				$msgActive = "active tooactive";
				break;
           	case "profile":
				$profileActive = "active tooactive";
				break;
		}
		echo '<nav id="navbarepta" class="navbar navbar-expand-lg navbar-dark menubar">
			<a href="." onclick="a(\'\')" class="navbar-brand" style="margin-right:0.5rem;background:none;border:none"><img style="width:30px" src="icon.png"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item '.$homeActive.' ">
						<a href="." onclick="a(\'\')" style="background:none;border:none" class="nav-link" >
							<i class="fa-solid fa-house"></i> '.$this->getLocalizedString("homeNavbar").'
						</a>
					</li>';
		$browse = '<li class="nav-item dropdown '.$browseActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> '.$this->getLocalizedString("browse").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="stats/accountsList.php" onclick="a(\'stats/accountsList.php\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-user" aria-hidden="false"></i></div>'.$this->getLocalizedString("accounts").'</a>
							<a type="button" href="stats/levelsList.php" onclick="a(\'stats/levelsList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-gamepad" style="margin-top: 1px;"></i></div>'.$this->getLocalizedString("levels").'</a>
							<a type="button" href="stats/packTable.php" onclick="a(\'stats/packTable.php\')"class="dropdown-item"><div class="icon"><i class="fa-regular fa-folder-open" aria-hidden="false"></i></div>'.$this->getLocalizedString("packTable").'</a>
							<a type="button" href="stats/gauntletTable.php" onclick="a(\'stats/gauntletTable.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletTable").'</a>
							<a type="button" href="stats/songList.php" onclick="a(\'stats/songList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songs").'</a>
							<a type="button" href="demonlist" onclick="a(\'demonlist\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-dragon" aria-hidden="false"></i></div>'.$this->getLocalizedString("demonlist").'</a>
							<a type="button" href="clans" onclick="a(\'clans\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-dungeon" aria-hidden="false"></i></div>'.$this->getLocalizedString("clans").'</a>';
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) {
			echo '<li class="nav-item dropdown '.$accountActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-user" aria-hidden="true"></i> '.$this->getLocalizedString("accountManagement").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="account/changePassword.php" onclick="a(\'account/changePassword.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-key" aria-hidden="false"></i></div>'.$this->getLocalizedString("changePassword").'</a>
							<a type="button" href="account/changeUsername.php" onclick="a(\'account/changeUsername.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-user" aria-hidden="false"></i></div>'.$this->getLocalizedString("changeUsername").'</a>
							<a type="button" href="stats/unlisted.php" onclick="a(\'stats/unlisted.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedLevels").'</a>
							<a type="button" href="stats/manageSongs.php" onclick="a(\'stats/manageSongs.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("manageSongs").'</a>
							<a type="button" href="stats/favouriteSongs.php" onclick="a(\'stats/favouriteSongs.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-heart" aria-hidden="false"></i></div>'.$this->getLocalizedString("favouriteSongs").'</a>
						</div>
					</li>' . $browse . '</div></li>';
					echo '<li class="nav-item dropdown '.$reuploadActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-upload" style="margin-right:5" aria-hidden="true"></i> '.$this->getLocalizedString("reuploadSection").'
						</a>
                            
						<div class="dropdown-menu" id="cronview" aria-labelledby="navbarDropdownMenuLink">';
          					if(strpos($songEnabled, '1') !== false) echo '<a type="button" href="songs" onclick="a(\'songs\')" class="dropdown-item"><i class="fa-solid fa-file" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -2px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songAdd").'</a>';
          					if(strpos($songEnabled, '2') !== false) echo '<a type="button" href="reupload/songAdd.php" onclick="a(\'reupload/songAdd.php\')"class="dropdown-item"><i class="fa-solid fa-link" style="position: absolute;font-size: 9px;margin: 5px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songLink").'</a>';
								if($lrEnabled == 1) echo '<a type="button" href="levels/levelReupload.php" onclick="a(\'levels/levelReupload.php\')"class="dropdown-item"><i class="fa-solid fa-arrow-down" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelReupload").'</a>
                                <a type="button" href="levels/levelToGD.php" onclick="a(\'levels/levelToGD.php\')"class="dropdown-item"><i class="fa-solid fa-arrow-up" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelToGD").'</a>';
          				echo '<button type="button" class="dropdown-item" id="crbtn" onclick="cron(), event.stopPropagation();"><div class="icon"><i id="iconcron" class="fa-solid fa-bars-progress"></i></div>'.$this->getLocalizedString('tryCron').'</button>
                        <script>
								function cron(){
									cr = new XMLHttpRequest();
                                    cr.open("GET", "'.$dbPath.'tools/cron/cron.php", true);
                                    var ic = document.getElementById("iconcron");
                                    var on = document.getElementById("crbtn");
                                    ic.classList.remove("fa-bars-progress");
                                    ic.classList.add("fa-spinner");
                                    ic.classList.add("fa-spin");
                                    cr.onload = function (){
										if(cr.response == "1") {
                                        	on.innerHTML = \'<div class="icon"><i id="iconcron" class="fa-solid fa-check"></i></div>'.$this->getLocalizedString('cronSuccess').'\';
                                   			ic.classList.remove("fa-spinner");
                                   			ic.classList.remove("fa-spin");
                                            ic.classList.add("fa-bars-progress");
                                            on.classList.add("dropdown-success");
                                            on.classList.remove("dropdown-error");
                                            on.disabled = true;
										}
										else {
                                        	on.innerHTML = \'<div class="icon"><i id="iconcron" class="fa-solid fa-xmark"></i></div>'.$this->getLocalizedString('cronError').'\';
                                   			ic.classList.remove("fa-spinner");
                                   			ic.classList.remove("fa-spin");
                                            ic.classList.add("fa-bars-progress");
                                            on.classList.remove("dropdown-success");
                                            on.classList.add("dropdown-error");
										}
                                    }
                                    cr.send();
                            	}
</script>
						</div>
					</li>';
			if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
				echo '<li class="nav-item dropdown '.$modActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-wrench" aria-hidden="true"></i> '.$this->getLocalizedString("modTools").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="stats/leaderboardsBan.php" onclick="a(\'stats/leaderboardsBan.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-ban"></i></div>'.$this->getLocalizedString("leaderboardBan").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")) {
								echo '<a type="button" href="levels/packCreate.php" onclick="a(\'levels/packCreate.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-regular fa-folder-open" style="margin-left: 2px;" aria-hidden="false"></i></div>'.$this->getLocalizedString("packManage").'</a>
							<a type="button" href="levels/gauntletCreate.php" onclick="a(\'levels/gauntletCreate.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletManage").'</a>';}
							echo '<a type="button" href="stats/unlistedMod.php" onclick="a(\'stats/unlistedMod.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedMod").'</a>
							<a type="button" href="stats/suggestList.php" onclick="a(\'stats/suggestList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("suggestLevels").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "toolQuestsCreate")) {
								echo '<a type="button" href="stats/addQuests.php" onclick="a(\'stats/addQuests.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list-ol" aria-hidden="false"></i></div>'.$this->getLocalizedString("addQuest").'</a>';} 
							echo '<a type="button" href="stats/reportMod.php" onclick="a(\'stats/reportMod.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-exclamation" aria-hidden="false"></i></div>'.$this->getLocalizedString("reportMod").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardAddMod")) {
							echo '<a type="button" href="account/addMod.php" onclick="a(\'account/addMod.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-id-badge" aria-hidden="false"></i></div>'.$this->getLocalizedString("addMod").'</a>';}
							if($gs->checkPermission($_SESSION["accountID"], "commandSharecpAll")) {
							echo '<a type="button" href="levels/shareCP.php" onclick="a(\'levels/shareCP.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-share" aria-hidden="false"></i></div>'.$this->getLocalizedString("shareCPTitle").'</a>';}
							if($gs->checkPermission($_SESSION["accountID"], "dashboardForceChangePassNick")) {
							echo '<a type="button" href="account/forceChange.php" onclick="a(\'account/forceChange.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-gavel" aria-hidden="false"></i></i></div>'.$this->getLocalizedString("changePassOrNick").'   </a>';}
							echo '</div>
					</li>';
			}
		}else{
			echo $browse."</div></li>";
		}
		echo '		
					<li class="nav-item dropdown '.$statsActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-chart-column" aria-hidden="true"></i> '.$this->getLocalizedString("statsSection").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="stats/dailyTable.php"  onclick="a(\'stats/dailyTable.php\')" class="dropdown-item"><div class="icon"><i class="fa-regular fa-sun" aria-hidden="false"></i></div>'.$this->getLocalizedString("dailyTable").'</a>
							<a type="button" href="stats/modActions.php" onclick="a(\'stats/modActions.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-universal-access" aria-hidden="false"></i></div>'.$this->getLocalizedString("modActions").'</a>
							<a type="button" href="stats/modActionsList.php" onclick="a(\'stats/modActionsList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("modActionsList").'</a>
							<a type="button" href="stats/top24h.php" onclick="a(\'stats/top24h.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ol" aria-hidden="false"></i></div>'.$this->getLocalizedString("leaderboardTime").'</a>
						</div>
					</li>
				</ul>
				<ul class="nav navbar-nav ml-auto">';
					if($msgEnabled == 1 AND isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) { 
                        	$new = '';
							$msg = $db->prepare("SELECT isNew FROM messages WHERE toAccountID=:acc AND isNew=0");
                        	$msg->execute([':acc' => $_SESSION["accountID"]]);
                        	$msg = $msg->fetchAll();
                        	if(count($msg) != 0) {
								$_SESSION["msgNew"] = 1;
                              	$new = '<i class="fa-solid fa-circle" id="notify" aria-hidden="true" style="font-size: 10px;margin-left: -5;margin-right: 3px;color: #e35151;"></i></div>';
							} else {
								$new = '';
						}
                      echo '<li class="nav-item dropdown">
						<div style="display:flex"><a type="button" href="messenger" style="background: none;border: none;" onclick="a(\'messenger\')"class="nav-link '.$msgActive.'" id="navbarDropdownMenuLink">
							<i class="fa-solid fa-comments" aria-hidden="true"></i> '.$this->getLocalizedString("messenger").'</a>'.$new;
                    }
      				echo '
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-language" aria-hidden="true"></i> '.$this->getLocalizedString("language").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=RU"><div class="icon flag"><img class="imgflag" src="incl/flags/ru.png"></div>Русский</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=EN"><div class="icon flag"><img class="imgflag" src="incl/flags/us.png"></div>English</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=TR" title="Translated by EMREOYUN"><div class="icon flag"><img class="imgflag" src="incl/flags/tr.png"></div>Türkçe</a>
                            <a class="dropdown-item dontblock" href="lang/switchLang.php?lang=UA" title="Translated by Jamichi"><div class="icon flag"><img class="imgflag" src="incl/flags/ua.png"></div>Українська</a>
                            <a class="dropdown-item dontblock" href="lang/switchLang.php?lang=FR" title="Translated by masckmaster2007"><div class="icon flag"><img class="imgflag" src="incl/flags/fr.png"></div>Français</a>
						</div>';
						if(!empty(glob("../download/".$gdps.".*")) OR !empty(glob("download/".$gdps.".*")) OR !empty($pc) OR !empty($mac) OR !empty($android) OR !empty($ios)) {
							echo '
					<li class="nav-item dropdown"  id="thirdp">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-download" aria-hidden="true"></i> '.$this->getLocalizedString("download").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" id="dptp" aria-labelledby="navbarDropdownMenuLink">';
						if((file_exists("download/".$gdps.".zip") OR file_exists("../download/".$gdps.".zip")) AND empty($pcLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$gdps.'.zip"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$this->getLocalizedString("forwindows").'</a>';
                        elseif(!empty($pcLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$pcLauncher.'"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$this->getLocalizedString("forwindows").'</a>';
                        elseif(!empty($pc)) echo '<a class="dropdown-item dontblock" href="'.$pc.'"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$this->getLocalizedString("forwindows").'</a>';
						if((file_exists("download/".$gdps.".dmg") OR file_exists("../download/".$gdps.".dmg")) AND empty($macLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$gdps.'.dmg"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("formac").'</a>';
                        elseif(!empty($macLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$macLauncher.'"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("formac").'</a>';
                        elseif(!empty($mac)) echo '<a class="dropdown-item dontblock" href="'.$mac.'"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("formac").'</a>';
						if((file_exists("download/".$gdps.".apk") OR file_exists("../download/".$gdps.".apk")) AND empty($androidLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$gdps.'.apk"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$this->getLocalizedString("forandroid").'</a>';
                        elseif(!empty($androidLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$androidLauncher.'"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$this->getLocalizedString("forandroid").'</a>';
                        elseif(!empty($android)) echo '<a class="dropdown-item dontblock" href="'.$android.'"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$this->getLocalizedString("forandroid").'</a>';
						if((file_exists("download/".$gdps.".ipa") OR file_exists("../download/".$gdps.".ipa")) AND empty($iosLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$gdps.'.ipa"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a></div>';
                        elseif(!empty($iosLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$iosLauncher.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a></div>';
                        elseif(!empty($ios)) echo '<a class="dropdown-item dontblock" href="'.$ios.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a></div>';
						if(!empty($thirdParty)) {
							foreach($thirdParty as &$thp) {
								if(isset($tpcheck[$thp[1]])) continue;
								$tp .= '<a title="'.$thp[3].'" class="dropdown-item dontblock" target="_blank" href="'.$thp[2].'"><div class="icon flag"><img style="border-radius:500px" class="imgflag" src="'.$thp[0].'"></div> '.$thp[1].'</a>';
								$tpcheck[$thp[1]] = "set";
							}
							echo '<button type="button" title="'.$this->getLocalizedString("thanks").'" id="tpbtn" data-bs class="dropdown-item dropdown-toggle" onclick="tp(1)" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="icon"><i class="fa-solid fa-handshake-simple" aria-hidden="true"></i></div> '.$this->getLocalizedString("third-party").'
								</button>
								<div style="border-radius: 30px;background: #141414;width: 92%;margin-left: 4%; margin-top: 5px;padding: 9px 0px;display:none" id="tp">
								'.$tp.'
								</div></div>
								<script>
									function tp(type) {
										event.stopPropagation();
										if(type == 1) { 
											document.getElementById("tp").style.display = "block";
											document.getElementById("tpbtn").setAttribute("onclick", "tp(0)");
										}
										else {
											document.getElementById("tp").style.display = "none";
											document.getElementById("tpbtn").setAttribute("onclick", "tp(1)");
										}
									}
								</script>';
							}
						}
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
			$userName = $gs->getAccountName($_SESSION["accountID"]);
			echo'<li class="nav-item dropdown '.$profileActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-user-circle" aria-hidden="true"></i> '.sprintf($this->getLocalizedString("loginHeader"), $userName).'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="profile/'.$userName.'" onclick="a(\'profile/'.$userName.'\')" class="dropdown-item"><div class="icon"><i class="fa-regular fa-id-badge"></i></div>'.$this->getLocalizedString("profile").'</a>';
							$claaan = $gs->isPlayerInClan($_SESSION["accountID"]);
							if($claaan) echo '<a href="clan/'.$gs->getClanInfo($claaan, "clan").'" onclick="a(\'clan/'.$gs->getClanInfo($claaan, "clan").'\', false, true)" class="dropdown-item"><div class="icon"><i class="fa-solid fa-dungeon"></i></div>'.$this->getLocalizedString("yourClan").'</a>';
							echo '<a class="dropdown-item dontblock" href="login/logout.php"><div class="icon"><i class="fa-solid fa-sign-out" aria-hidden="false"></i></div>'.$this->getLocalizedString("logout").'</a>
						</div>
					</li>';
		}else{
			echo '<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-sign-in" aria-hidden="true"></i> '.$this->getLocalizedString("login").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="padding: 15px 15px 0px 15px;min-width: 275px;min-height: 208px;">
									<form action="login/login.php" method="post" name="loginthing">
										<div class="form-group">
											<input type="text" class="form-control login-input" id="usernameField" name="userName" placeholder="'.$this->getLocalizedString("username").'">
										</div>
										<div class="form-group">
											<input type="password" class="form-control login-input" id="passwordField" name="password" placeholder="'.$this->getLocalizedString("password").'">
										</div>
										<div style="display: flex;flex-wrap: wrap;justify-content: center"><button type="submit" class="btn-primary btn-block" id="submit" disabled>'.$this->getLocalizedString("login").'</button>
										</form><form action="login/register.php" style="width: 80%;margin-top: 10px;margin-bottom: -5px">
										<button type="button" onclick="a(\'login/register.php\')" class="btn btn-primary">'.$this->getLocalizedString("register").'</button>
										</div>
									</form>
						</div><script>
$(document).change(function(){
   const p1 = document.getElementById("usernameField");
   const p2 = document.getElementById("passwordField");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length || !p2.value.trim().length) {
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
</script>';
		}		
		echo '</ul>
			</div>
		</nav>
		<div class="form" style="margin:0px;position:absolute;bottom:50px;color:white;font-size:50px;width:max-content;right:50px;padding:25px;transition:0.3s;opacity:0;border-radius:500px" id="loadingloool"><i class="fa-solid fa-spinner fa-spin"></i></div>
<script>
	cptch = document.querySelector("#verycoolcaptcha");
	$(document).click(function(event) {
		if(event.target && !event.target.classList.contains("dontblock") && (event.target.classList.contains("dropdown-item") || event.target.classList.contains("icon") || event.target.classList.contains("nav-link") || event.target.classList.contains("fa-solid") || event.target.classList.contains("fa-regular"))) event.preventDefault();
	});
	function a(page, skipcheck = false, skipslash = false, method = "GET", getdata = false, formname = "", isback = false) {
		if((window.location.pathname.indexOf(page) != "1" || page == "profile") || skipcheck) {
			phpCheck = page.substr(page.length - 4);
			if(phpCheck != ".php" && page != "" && page != "profile/'.$gs->getAccountName($_SESSION["accountID"]).'" && !skipslash) page = page + "/";
			document.getElementById("loadingloool").innerHTML = \'<i class="fa-solid fa-spinner fa-spin"></i>\';
			document.getElementById("loadingloool").style.opacity = "1";
			pg = new XMLHttpRequest();
			sendget = "";
			if(getdata >= 0) {
				if(getdata != 69) fd = new FormData(document.getElementsByTagName("form")[document.getElementsByTagName("form").length-getdata]);
				else fd = new FormData(searchform);
				delimiter = "?";
				if(fd.get("page") !== null) {
					sendget = sendget + delimiter + "page=" + encodeURIComponent(fd.get("page"));
					delimiter = "&";
				}
				if(fd.get("search") !== null) {
					sendget = sendget + delimiter + "search=" + encodeURIComponent(fd.get("search"));
					delimiter = "&";
				}
				// I\'m sorry, guys
				if(fd.get("type") !== null) {
					sendget = sendget + delimiter + "type=" + encodeURIComponent(fd.get("type"));
					delimiter = "&";
				}
				if(fd.get("who") !== null) {
					sendget = sendget + delimiter + "who=" + encodeURIComponent(fd.get("who"));
					delimiter = "&";
				}
				if(fd.get("ng") !== null) {
					sendget = sendget + delimiter + "ng=" + encodeURIComponent(fd.get("ng"));
					delimiter = "&";
				}
			} 
			pg.open(method, page + sendget, true);
			pg.responseType = "document";
			htmlpage = document.querySelector("#htmlpage");
			navbar = document.querySelector("#navbarepta");
			htmtitle = document.querySelectorAll("title")[0];
			pg.onload = function (){
				if(pg.response.getElementById("htmlpage") != null) {
					document.getElementById("loadingloool").style.opacity = "0";
					title = pg.response.querySelectorAll("title")[0];
					scripts = pg.response.querySelectorAll("body script");
					scripts = scripts[scripts.length-1];
					newnavbar = pg.response.querySelector("#navbarepta");
					if(typeof document.getElementsByClassName("audio")[0] !== "undefined" && pg.response.getElementById("btn"+document.getElementsByClassName("audio")[0].id) !== null) if(!document.getElementsByTagName("audio")[0].paused) pg.response.getElementById("icon"+document.getElementsByClassName("audio")[0].id).classList.replace("fa-play", "fa-pause");
					child = pg.response.querySelector("#htmlpage");
					htmlpage.replaceWith(child);
					navbar.replaceWith(newnavbar);
					htmtitle.replaceWith(title);
					var scrp = document.createElement("script");
					scrp.id = "pagescript";
					lastChar = page.substr(page.length - 1);
					if(lastChar == "/") pageyes = page.split("/")[0];
					else pageyes = page;
					now = document.querySelector("[href=\'"+pageyes+"\']");
					if(now !== null) now.classList.add("now");
					if(typeof scripts.textContent != "undefined") scrp.innerHTML = scripts.textContent;
					if(document.getElementById("pagescript") !== null) document.getElementById("pagescript").remove();
					document.body.appendChild(scrp);
					if(!isback) history.pushState(null,null,page);
					if(page != "" && typeof document.getElementsByTagName("base")[0] == "undefined") {
						base = document.createElement("base");
						base.href = "../";
						document.body.appendChild(base);
					}
					if(document.querySelector("base").getAttribute("href") == "/") document.querySelector("base").href = "../";
					if(page == "" && typeof document.querySelector("base") == "object") {
						base2 = document.querySelector("base");
						base2.href = ".";
						document.body.appendChild(base2);
					} else if(typeof document.querySelector("base") == "object") {
						base2 = document.querySelector("base");
						base2.href = "../";
						document.body.appendChild(base2);
					}
					if(typeof coolcaptcha != "undefined") { 
						if(cptch == null) coolcaptcha.replaceWith(captch);
						else coolcaptcha.replaceWith(cptch);
						$(".h-captcha").not("#captchadiv > #verycoolcaptcha")[0].style.display = "block";
					}
				} else {
					document.getElementById("loadingloool").innerHTML = \'<i class="fa-solid fa-xmark" style="color:#ffb1ab;padding: 0px 8px;"></i>\';
					setTimeout(function () {document.getElementById("loadingloool").style.opacity = "0";}, 1000);
				}
			}
			if(document.getElementById("progress") !== null) {
				prog = document.getElementById("progress");
				prog.value = "0";
				pg.upload.onprogress = function (event) {
					prog.max = event.total;
					prog.style.display = "block";
					prog.value = event.loaded;
				}
			}
			if(method == "POST") {
			    if(formname == "") fd = new FormData(document.getElementsByTagName("form")[document.getElementsByTagName("form").length-1]);
				else fd = new FormData(document.getElementsByName(formname)[0]);
				pg.send(fd);
			} else if(getdata >= 0) {
				pg.send(sendget);
			} else pg.send();
		}
	}
	window.addEventListener("popstate", function(e) { 
		goback = window.location.pathname.split("/");
		if(goback[goback.length-1] != "") {
			backpage = goback[goback.length-2]+"/"+goback[goback.length-1];
			if(backpage != "undefined/") a(backpage, true, true, "GET", false, "", true);
			else a(\'\', true, true, "GET", false, "", true);
		} else {
			backpage = goback[goback.length-3]+"/"+goback[goback.length-2];
			if(backpage != "undefined/") a(backpage, true, false, "GET", false, "", true);
			else a(\'\', true, true, "GET", false, "", true);
		}
	}, false);
	setTimeout(function () {captch = cptch.cloneNode(true)}, 1);
</script>';
	}
	public function printPage($content, $isSubdirectory = true, $navbar = "home"){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($navbar);
		echo '<span id="htmlpage" style="width: 100%;height: 100%;display: contents;"><div class="container d-flex flex-column">
				<div class="row fill d-flex justify-content-start content buffer">
					'.$content.'
				</div>
			</div></span>';
	}
	public function handleLangStart(){
		if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])){
			if(file_exists('/lang/locale'.strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))).'.php') setcookie("lang", strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)), 2147483647, "/");
			else setcookie("lang", "EN", 2147483647, "/");
		}
		if(!isset($_SESSION["accountID"])) $_SESSION["accountID"] = 0;
        if(!isset($_SESSION["msgNew"])) $_SESSION["msgNew"] = 0;
	}
	public function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
    $rgbArray = array();
    if (strlen($hexStr) == 6) {
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) {
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false;
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; 
	}
	public function convertToDate($timestamp, $acc = false){
		if($acc) {
			if($timestamp == 0) return $this->getLocalizedString("never");
			if(date("d", $timestamp) == date("d", time())) return date("G:i", $timestamp);
			elseif(date("Y", $timestamp) == date("Y", time())) return date("d.m", $timestamp);
			else return date("d.m.Y", $timestamp);
		} else return date("d.m.Y G:i:s", $timestamp);
	}
	public function generateBottomRow($pagecount, $actualpage){
		$pageminus = $actualpage - 1;
		$pageplus = $actualpage + 1;
      	if($pagecount < 2) return '';
		$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
		$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
		$pagelol = explode("?", $pagelol)[0];
		$ng = strpos($_SERVER["REQUEST_URI"], '/songList.php') ? '<form method="get" style="margin:0"><input type="hidden" name="ng" value="1"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 6)" style="margin-right: 10px;border-radius: 500px;" class="btn btn-outline-secondary" type="submit" name="ng" value="1">Newgrounds?</button></form>' : '';
		$inputSearch = !empty($_GET["search"]) ? '<input type="hidden" name="search" value="'.$_GET["search"].'">' : '';
		if(!empty($_GET["type"] OR !empty($_GET["who"]))) $inputSearch .= '<input type="hidden" name="type" value="'.$_GET["type"].'"><input type="hidden" name="who" value="'.$_GET["who"].'">';
		if(!empty($_GET["ng"])) $inputSearch .= '<input type="hidden" name="ng" value="'.$_GET["ng"].'">';
		if($_GET["ng"] == 1) $ng = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 6)" name="ng" value="0" class="btn btn-outline-secondary" style="border-radius:500px;font-size:20px;margin-right:10px;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none"><i class="fa-solid fa-xmark"></i></button>';
		$bottomrow = '<div>'.sprintf($this->getLocalizedString("pageInfo"),$actualpage,$pagecount).'</div><div class="btn-group" style="margin-left:auto; margin-right:0;z-index:1;">';
		$bottomrow .= $ng.'<form method="get" style="margin:0">'.$inputSearch.'<input type="hidden" name="page" value="0"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 5)" name="page" id="first" style="border-top-right-radius:0px !important;border-bottom-right-radius:0px !important;border-radius:500px" value=1 class="btn btn-outline-secondary"><i class="fa-solid fa-backward" aria-hidden="true"></i> '.$this->getLocalizedString("first").'</button></form>
		<form method="get" style="margin:0">'.$inputSearch.'<input type="hidden" name="page" value="'.$pageminus.'"><button style="border-radius:0" name="page" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 4)" id="prev" value='. $pageminus .' class="btn btn-outline-secondary"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i> '.$this->getLocalizedString("previous").'</button></form>';
		//updated to ".."
		$bottomrow .= '<a class="btn btn-outline-secondary" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">..</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="padding:17px 17px 4px 17px;">
				<form action="" method="get">
					<div class="form-group">
					'.$inputSearch.'
						<input type="text" class="form-control" name="page" placeholder="'.$this->getLocalizedString("page").'">';
		$bottomrow .= '</div>
					<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 3)" class="btn btn-primary">'.$this->getLocalizedString("go").'</button>
				</form>
			</div>';
		$bottomrow .= '<form method="get" style="margin:0">'.$inputSearch.'<input type="hidden" name="page" value="'.$pageplus.'"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 2)" name="page" style="border-radius:0px"  id="next" class="btn btn-outline-secondary">'.$this->getLocalizedString("next").' <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button></form>
		<form method="get" style="margin:0;">'.$inputSearch.'<input type="hidden" name="page" value="'.$pagecount.'"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 1)" name="page" id="last" style="border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;border-radius:500px" value='. $pagecount .' class="btn btn-outline-secondary">'.$this->getLocalizedString("last").' <i class="fa-solid fa-forward" aria-hidden="true"></i></button></form>';
		$bottomrow .= "</div><script>
			function disableElement(element){
				if(element){
					element.className += first.className ? ' disabled' : 'disabled';
				}
			}
			var pagecount = $pagecount;
			var actualpage = $actualpage;
			if(actualpage == 1){
				document.getElementById('first').disabled = true;
				document.getElementById('prev').disabled = true;
			}
			if(pagecount == actualpage){
				document.getElementById('last').disabled = true;
				document.getElementById('next').disabled = true;
			}
			</script>";
		return $bottomrow;
	}
	public function generateLineChart($elementID, $name, $data){
		$labels = implode('","', array_keys($data));
		$data = implode(',', $data);
		$chart = "<script>
					var ctx = document.getElementById(\"$elementID\");
					var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: [\"$labels\"],
							datasets: [{
								label: '$name',
								data: [$data],
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
									'rgba(255,99,132,1)'
								],
							}]
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							}
						}
					});
					</script>";
		return $chart;
	}
	public function title($title) {
      	global $gdps;
		echo '<title>'.$title.' | '.$gdps.'</title>';
	}
}
?>