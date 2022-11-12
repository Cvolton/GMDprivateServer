<?php
$dbPath = '../'; // Path to main directory. If you didn't changed dashboard place, don't change this value. Usually, its /database (https://imgur.com/a/P8LdhzY). 
include __DIR__."/../".$dbPath."config/dashboard.php";
include_once "auth.php";
$au = new au();
$au->auth($dbPath);
// Dashboard library
class dashboardLib{
	public function printHeader($isSubdirectory = true){
		$this->handleLangStart();
      	global $gdps;
		echo '<!DOCTYPE html>
				<html lang="en">
					<head>
                    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
						<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
						<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
						<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
						<link rel="manifest" href="/site.webmanifest">
						<meta charset="utf-8">';
          	if($isSubdirectory) echo '<base href="../">';
				echo '<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                          <script src="https://kit.fontawesome.com/10e18026cb.js" crossorigin="anonymous"></script>
                          <script async src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
                          <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
                          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
						  <link href="incl/fontawesome/css/fontawesome.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/brands.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/solid.css" rel="stylesheet">
                          <link async rel="stylesheet" href="incl/cvolton.css">
                          <title>'.$gdps.'</title>
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
		echo '</head>
				<body>';
	}
	public function getLocalizedString($stringName){
		if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])){
			if(file_exists('/lang/locale'.strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))).'.php') $lang = strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
			else $lang = "EN";
		}else{
			$lang = $_COOKIE["lang"];
		}
		$locale = __DIR__ . "/lang/locale".$lang.".php";
		if(file_exists($locale)){
			include $locale;
		}else{
			include __DIR__ . "/lang/localeEN.php";
		}
		if($lang == "TEST"){
			return "lnf:$stringName";
		}
		if(isset($string[$stringName])){
			return $string[$stringName];
		}else{
			return "lnf:$stringName";
		}
	}
	public function printBoxBody(){
		echo '<div class="container container-box">
					<div class="card">
						<div class="card-block buffer">';
	}
	public function printBox($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active);
		$this->printBoxBody();
		echo "$content";
		$this->printBoxFooter();
		$this->printFooter();
	}
	public function printSong($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active);
		echo "$content";
	}
	public function printBoxFooter(){
		echo '</div></div></div>';
	}
	public function printFooter($sub = ''){
      	global $vk;
      	global $discord;
      	global $twitter;
      	global $youtube;
      	global $twitch;
		echo '</form><div class="footer">'.$this->getLocalizedString("footer").'<div>';
        if($youtube != '') echo '<a href="'.$youtube.'" target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/youtube.png"></a>';
        if($discord != '') echo '<a href="'.$discord.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/discord.png"></a>';
      	if($twitter != '') echo '<a href="'.$twitter.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/twitter.png"></a>';
      	if($vk != '') echo '<a href="'.$vk.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/vk.png"></a>';
      	if($twitch != '') echo '<a href="'.$twitch.'"target="_blank"><img class="socials" style="width: 20px" src="'.$sub.'incl/socials/twitch.png"></a>';
        echo '</div></div></body>
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
  	public function title($title) {
      	global $gdps;
		echo '<title>'.$title.' | '.$gdps.'</title>';
	}
	public function printNavbar($active){
		global $gdps;
		global $lrEnabled;
      	global $msgEnabled;
      	global $songEnabled;
      	global $pc;
      	global $mac;
      	global $android;
        global $ios;
      	global $dbPath;
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
      	include __DIR__."/../".$dbPath."incl/lib/connection.php";
		$gs = new mainLib();
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
			<a class="navbar-brand" href=""><img style="width:32px" src="icon.png"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item '.$homeActive.' ">
						<a class="nav-link" href="">
							<i class="fa-solid fa-house"></i> '.$this->getLocalizedString("homeNavbar").'
						</a>
					</li>';
		$browse = '<li class="nav-item dropdown '.$browseActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-folder-open" aria-hidden="true"></i> '.$this->getLocalizedString("browse").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="stats/accountsList.php"><div class="icon"><i class="fa-solid fa-user" aria-hidden="false"></i></div>'.$this->getLocalizedString("accounts").'</a>
							<a class="dropdown-item" href="stats/levelsList.php"><div class="icon"><i class="fa-solid fa-gamepad" style="margin-top: 1px;"></i></div>'.$this->getLocalizedString("levels").'</a>
							<a class="dropdown-item" href="stats/packTable.php"><div class="icon"><i class="fa-regular fa-folder-open" aria-hidden="false"></i></div>'.$this->getLocalizedString("packTable").'</a>
							<a class="dropdown-item" href="stats/gauntletTable.php"><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletTable").'</a>
							<a class="dropdown-item" href="stats/songList.php"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songs").'</a>';
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
			echo '
					<li class="nav-item dropdown '.$accountActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-user" aria-hidden="true"></i> '.$this->getLocalizedString("accountManagement").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="account/changePassword.php"><div class="icon"><i class="fa-solid fa-key" aria-hidden="false"></i></div>'.$this->getLocalizedString("changePassword").'</a>
							<a class="dropdown-item" href="account/changeUsername.php"><div class="icon"><i class="fa-solid fa-user" aria-hidden="false"></i></div>'.$this->getLocalizedString("changeUsername").'</a>
							<a class="dropdown-item" href="stats/unlisted.php"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedLevels").'</a>
							<a class="dropdown-item" href="stats/manageSongs.php"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("manageSongs").'</a>
						</div>
					</li>' . $browse . '</div></li>';
					echo '<li class="nav-item dropdown '.$reuploadActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-upload" style="margin-right:5" aria-hidden="true"></i> '.$this->getLocalizedString("reuploadSection").'
						</a>
                            
						<div class="dropdown-menu" id="cronview" aria-labelledby="navbarDropdownMenuLink">';
          					if(strpos($songEnabled, '1') !== false) echo '<a class="dropdown-item" href="songs/"><i class="fa-solid fa-file" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -2px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songAdd").'</a>';
          					if(strpos($songEnabled, '2') !== false) echo '<a class="dropdown-item" href="reupload/songAdd.php"><i class="fa-solid fa-link" style="position: absolute;font-size: 9px;margin: 5px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songLink").'</a>';
								if($lrEnabled == 1) echo '<a class="dropdown-item" href="levels/levelReupload.php"><i class="fa-solid fa-arrow-down" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelReupload").'</a>
                                <a class="dropdown-item" href="levels/levelToGD.php"><i class="fa-solid fa-arrow-up" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelToGD").'</a>';
          				echo '<button class="dropdown-item" id="crbtn" onclick="cron(), event.stopPropagation();"><div class="icon"><i id="iconcron" class="fa-solid fa-bars-progress"></i></div>'.$this->getLocalizedString('tryCron').'</button>
                        <script>
								function cron(){
									cr = new XMLHttpRequest();
                                    cr.open("GET", "../'.$dbPath.'tools/cron/cron.php", true);
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
                                        	on.innerHTML = \'<div class="icon"><i id="iconcron" class="fa-solid fa-xmark"></i></div>'.$this->getLocalizedString('cronError').'\';;
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
							<a class="dropdown-item" href="stats/leaderboardsBan.php"><div class="icon"><i class="fa-solid fa-ban"></i></div>'.$this->getLocalizedString("leaderboardBan").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")) {
								echo '<a class="dropdown-item" href="levels/packCreate.php"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-regular fa-folder-open" style="margin-left: 2px;" aria-hidden="false"></i></div>'.$this->getLocalizedString("packManage").'</a>
							<a class="dropdown-item" href="levels/gauntletCreate.php"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletManage").'</a>';}
							echo '<a class="dropdown-item" href="stats/unlistedMod.php"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedMod").'</a>
							<a class="dropdown-item" href="stats/suggestList.php"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("suggestLevels").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "toolQuestsCreate")) {
								echo '<a class="dropdown-item" href="stats/addQuests.php"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list-ol" aria-hidden="false"></i></div>'.$this->getLocalizedString("addQuest").'</a>';} 
							echo '<a class="dropdown-item" href="stats/reportMod.php"><div class="icon"><i class="fa-solid fa-exclamation" aria-hidden="false"></i></div>'.$this->getLocalizedString("reportMod").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardAddMod")) {
							echo '<a class="dropdown-item" href="account/addMod.php"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -5px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-id-badge" aria-hidden="false"></i></div>'.$this->getLocalizedString("addMod").'</a>';}
							if($gs->checkPermission($_SESSION["accountID"], "commandSharecpAll")) {
							echo '<a class="dropdown-item" href="levels/shareCP.php"><div class="icon"><i class="fa-solid fa-share" aria-hidden="false"></i></div>'.$this->getLocalizedString("shareCPTitle").'</a>';}
							if($gs->checkPermission($_SESSION["accountID"], "dashboardForceChangePassNick")) {
							echo '<a class="dropdown-item" href="account/forceChange.php"><div class="icon"><i class="fa-solid fa-gavel" aria-hidden="false"></i></i></div>'.$this->getLocalizedString("changePassOrNick").'   </a>';}
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
							<a class="dropdown-item" href="stats/dailyTable.php"><div class="icon"><i class="fa-regular fa-sun" aria-hidden="false"></i></div>'.$this->getLocalizedString("dailyTable").'</a>
							<a class="dropdown-item" href="stats/modActions.php"><div class="icon"><i class="fa-solid fa-universal-access" aria-hidden="false"></i></div>'.$this->getLocalizedString("modActions").'</a>
							<a class="dropdown-item" href="stats/modActionsList.php"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("modActionsList").'</a>
							<a class="dropdown-item" href="stats/top24h.php"><div class="icon"><i class="fa-solid fa-list-ol" aria-hidden="false"></i></div>'.$this->getLocalizedString("leaderboardTime").'</a>
						</div>
					</li>
				</ul>
				<ul class="nav navbar-nav ml-auto">';
					if($msgEnabled == 1 AND isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) { 
                      if($_SESSION["msgNew"] != 1) {
                        	$new = '';
							$msg = $db->prepare("SELECT isNew FROM messages WHERE toAccountID=:acc AND isNew=0");
                        	$msg->execute([':acc' => $_SESSION["accountID"]]);
                        	$msg = $msg->fetchAll();
                        	if(count($msg) != 0) {
								$_SESSION["msgNew"] = 1;
                              	$new = '<i class="fa-solid fa-circle" id="notify" aria-hidden="true" style="font-size: 10px;margin-left: -5;margin-right: 3px;color: #e35151;"></i></div>';
							}
                          } else {
							$new = '<i class="fa-solid fa-circle" id="notify" aria-hidden="true" style="font-size: 10px;margin-left: -5;margin-right: 3px;color: #e35151;"></i></div>';
							}
                      echo '<li class="nav-item dropdown">
						<div style="display:flex"><a class="nav-link '.$msgActive.'" href="messenger/" id="navbarDropdownMenuLink">
							<i class="fa-solid fa-comments" aria-hidden="true"></i> '.$this->getLocalizedString("messenger").'</a>'.$new;
                    }
      				echo '
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-language" aria-hidden="true"></i> '.$this->getLocalizedString("language").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="lang/switchLang.php?lang=RU"><div class="icon flag"><img class="imgflag" src="incl/flags/ru.png"></div>Русский</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=EN"><div class="icon flag"><img class="imgflag" src="incl/flags/us.png"></div>English</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=TR" title="Translated by EMREOYUN"><div class="icon flag"><img class="imgflag" src="incl/flags/tr.png"></div>Türkçe</a>
                            <a class="dropdown-item" href="lang/switchLang.php?lang=UA" title="Translated by Jamichi""><div class="icon flag"><img class="imgflag" src="incl/flags/ua.png"></div>Українська</a>
						</div>';
						if(!empty(glob("../download/".$gdps.".*")) OR !empty(glob("download/".$gdps.".*")) OR !empty($pc) OR !empty($mac) OR !empty($android) OR !empty($ios)) {
							echo '
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-download" aria-hidden="true"></i> '.$this->getLocalizedString("download").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
						if(file_exists("download/".$gdps.".zip") OR file_exists("../download/".$gdps.".zip")) echo '<a class="dropdown-item" href="download/'.$gdps.'.zip"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$this->getLocalizedString("forwindows").'</a>';
                        elseif(!empty($pc)) echo '<a class="dropdown-item" href="'.$pc.'"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$this->getLocalizedString("forwindows").'</a>';
						if(file_exists("download/".$gdps.".dmg") OR file_exists("../download/".$gdps.".dmg")) echo '<a class="dropdown-item" href="download/'.$gdps.'.dmg"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("formac").'</a>';
                        elseif(!empty($mac)) echo '<a class="dropdown-item" href="'.$mac.'"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("formac").'</a>';
						if(file_exists("download/".$gdps.".apk") OR file_exists("../download/".$gdps.".apk")) echo '<a class="dropdown-item" href="download/'.$gdps.'.apk"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$this->getLocalizedString("forandroid").'</a>';
                        elseif(!empty($android)) echo '<a class="dropdown-item" href="'.$android.'"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$this->getLocalizedString("forandroid").'</a>';
						if(file_exists("download/".$gdps.".ipa") OR file_exists("../download/".$gdps.".ipa")) echo '<a class="dropdown-item" href="download/'.$gdps.'.ipa"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a></div>';
                        elseif(!empty($ios)) echo '<a class="dropdown-item" href="'.$ios.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a></div>';
						}
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
			$userName = $gs->getAccountName($_SESSION["accountID"]);
			echo'<li class="nav-item dropdown '.$profileActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-user-circle" aria-hidden="true"></i> '.sprintf($this->getLocalizedString("loginHeader"), $userName).'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="profile/"><div class="icon"><i class="fa-regular fa-id-badge"></i></div>'.$this->getLocalizedString("profile").'</a>
							<a class="dropdown-item" href="login/logout.php"><div class="icon"><i class="fa-solid fa-sign-out" aria-hidden="false"></i></div>'.$this->getLocalizedString("logout").'</a>
						</div>
					</li>';
		}else{
			/*echo '<li class="nav-item">
						<a class="nav-link" href="login/login.php"><i class="fa-solid fa-sign-in" aria-hidden="true"></i> '.$this->getLocalizedString("login").'</a>
					</li>';*/
			echo '<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-sign-in" aria-hidden="true"></i> '.$this->getLocalizedString("login").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="padding: 15px 15px 0px 15px;min-width: 275px;min-height: 208px;">
									<form action="login/login.php" method="post">
										<div class="form-group">
											<input type="text" class="form-control login-input" id="usernameField" name="userName" placeholder="'.$this->getLocalizedString("username").'">
										</div>
										<div class="form-group">
											<input type="password" class="form-control login-input" id="passwordField" name="password" placeholder="'.$this->getLocalizedString("password").'">
										</div>
										<div style="display: flex;flex-wrap: wrap;justify-content: center"><button type="submit" class="btn-primary btn-block" id="submit" disabled>'.$this->getLocalizedString("login").'</button>
										</form><form action="login/register.php" style="width: 80%;margin-top: 10px;margin-bottom: -5px">
										<button type="submit"class="btn btn-primary">'.$this->getLocalizedString("register").'</button>
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
		echo'	</ul>
			</div>
		</nav>';
	}
	public function printPage($content, $isSubdirectory = true, $navbar = "home"){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($navbar);
		echo '<div class="container d-flex flex-column">
				<div class="row fill d-flex justify-content-start content buffer">
					'.$content.'
				</div>
			</div>';
		$this->printFooter();
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
	public function convertToDate($timestamp){
		return date("d.m.Y G:i:s", $timestamp);
	}
	public function generateBottomRow($pagecount, $actualpage){
		$pageminus = $actualpage - 1;
		$pageplus = $actualpage + 1;
      	if($pagecount < 2) return '';
		$inputSearch = !empty($_GET["search"]) ? '<input type="hidden" name="search" value="'.$_GET["search"].'">' : '';
		$bottomrow = '<div>'.sprintf($this->getLocalizedString("pageInfo"),$actualpage,$pagecount).'</div><div class="btn-group" style="margin-left:auto; margin-right:0;">';
		$bottomrow .= '<form method="get" style="margin:0">'.$inputSearch.'<button type="submit" name="page" id="first" style="border-top-right-radius:0px !important;border-bottom-right-radius:0px !important;border-radius:500px" value=1 class="btn btn-outline-secondary"><i class="fa-solid fa-backward" aria-hidden="true"></i> '.$this->getLocalizedString("first").'</button></form><form method="get" style="margin:0">'.$inputSearch.'<button style="border-radius:0" type="submit" id="prev" value='. $pageminus .' class="btn btn-outline-secondary"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i> '.$this->getLocalizedString("previous").'</button></form>';
		//updated to ".."
		$bottomrow .= '<a class="btn btn-outline-secondary" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">..</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="padding:17px 17px 4px 17px;">
				<form action="" method="get">
					<div class="form-group">
						<input type="text" class="form-control" name="page" placeholder="'.$this->getLocalizedString("page").'">';
		foreach($_GET as $key => $param){
			if($key != "page"){
				$bottomrow .= '<input type="hidden" name="'.$key.'" value="'.$param.'">';
			}
		}
		$bottomrow .= '</div>
					<button type="submit" class="btn btn-primary btn-block">'.$this->getLocalizedString("go").'</button>
				</form>
			</div>';
		$bottomrow .= '<form method="get" style="margin:0">'.$inputSearch.'<button type="submit" name="page" style="border-radius:0px" value='.$pageplus.' id="next" class="btn btn-outline-secondary">'.$this->getLocalizedString("next").' <i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button></form><form method="get" style="margin:0;">'.$inputSearch.'<button type="submit" name="page" id="last" style="border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;border-radius:500px" value='. $pagecount .' class="btn btn-outline-secondary">'.$this->getLocalizedString("last").' <i class="fa-solid fa-forward" aria-hidden="true"></i></button></form>';
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
}
?>