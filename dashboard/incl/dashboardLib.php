<?php
$dbPath = '../'; // Path to main directory. It needs to point to main endpoint files. If you didn't change dashboard place, don't change this value. Usually it's '../' (cuz dashboard folder is inside main endpoints folder) (https://imgur.com/a/P8LdhzY).
require __DIR__."/../".$dbPath."config/dashboard.php";
require_once "auth.php";
$au = new au();
$dashCheck = $au->auth($dbPath);
// Dashboard library
class dashboardLib {
	public function printHeader($isSubdirectory = true){
		$this->handleLangStart();
      	global $gdps;
		global $dashboardFavicon;
		if(file_exists("../../incl/cvolton.css")) $css = filemtime("../../incl/cvolton.css");
		elseif(file_exists("../incl/cvolton.css")) $css = filemtime("../incl/cvolton.css");
		else $css = filemtime("incl/cvolton.css");
		echo '<!DOCTYPE html>
				<html lang="en">
					<head>
                    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
						<link rel="icon" type="image/png" sizes="64x64" href="'.$dashboardFavicon.'">
						<meta charset="utf-8">
						<meta name="color-scheme" content="dark">
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit="no">';
          	if($isSubdirectory) echo '<base href="../">'; else echo '<base href=".">';
				echo '<script src="incl/jq.js"></script>
                          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
                          <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
                          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
                          <script src="incl/jsmediatags.js"></script>
                          <script src="incl/imgcolr.js"></script>
						  <link href="incl/fontawesome/css/fontawesome.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/brands.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/solid.css" rel="stylesheet">
						  <link href="incl/fontawesome/css/regular.css" rel="stylesheet">
                          <link async rel="stylesheet" href="incl/cvolton.css?'.$css.'">
						  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                          <title>'.$gdps.'</title>';
		echo '</head>
				<body><div style="height: 100%;display: contents;">';
	}
	public function getLocalizedString($stringName, $lang = '') {
		if(empty($lang)) {
			if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])) {
				if(file_exists(__DIR__.'/lang/locale'.strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))).'.php') $lang = strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
				else $lang = "EN";
			} else $lang = $_COOKIE["lang"];
		}
		$lang = substr($lang, 0, 2);
		$locale = __DIR__."/lang/locale".$lang.".php";
		if(file_exists($locale)) require $locale;
		else require __DIR__."/lang/localeEN.php";
		if(isset($string[$stringName])) return $string[$stringName];
		else {
		    require __DIR__."/lang/localeEN.php";
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
		$this->printNavbar($active, $isSubdirectory);
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
        echo '</div></div></div>';
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
	public function printNavbar($active, $isSubdirectory = true) {
		global $gdps;
		global $lrEnabled;
      	global $msgEnabled;
      	global $songEnabled;
      	global $sfxEnabled;
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
		global $dashboardIcon;
		require_once __DIR__."/../".$dbPath."incl/lib/Captcha.php";
		require __DIR__."/../".$dbPath."config/security.php";
		require __DIR__."/../".$dbPath."config/mail.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
      	require __DIR__."/../".$dbPath."incl/lib/connection.php";
		if(!isset($enableCaptcha)) global $enableCaptcha;
		if(!isset($preactivateAccounts)) global $preactivateAccounts;
      	if($enableCaptcha) {
      	    $captchaTypes = ['hcaptcha', 'grecaptcha', 'turnstile'];
      	    $captchaUsed = $captchaTypes[$captchaType-1];
      	}
		$gs = new mainLib();
		$homeActive = $accountActive = $browseActive = $modActive = $reuploadActive = $statsActive = $msgActive = $profileActive = "";
		switch($active) {
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
			<input type="hidden" id="isSubdirectory" value="'.($isSubdirectory ? 'true' : 'false').'"></input>
			<button href="." onclick="a(\'\')" class="navbar-brand" style="margin-right:0.5rem;background:none;border:none"><img style="width:30px" src="'.$dashboardIcon.'"></button>
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
							<a type="button" href="stats/listsTable.php" onclick="a(\'stats/listsTable.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("listTable").'</a>
							<a type="button" href="stats/songList.php" onclick="a(\'stats/songList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songs").'</a>
							<a type="button" href="stats/SFXList.php" onclick="a(\'stats/SFXList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("sfxs").'</a>';
							if($clansEnabled) $browse .= '<a type="button" href="clans" onclick="a(\'clans\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-dungeon" aria-hidden="false"></i></div>'.$this->getLocalizedString("clans").'</a>';
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
							<a type="button" href="stats/manageSFX.php" onclick="a(\'stats/manageSFX.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("manageSFX").'</a>
							<a type="button" href="stats/favouriteSongs.php" onclick="a(\'stats/favouriteSongs.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-heart" aria-hidden="false"></i></div>'.$this->getLocalizedString("favouriteSongs").'</a>
							<a type="button" href="stats/listsTableYour.php" onclick="a(\'stats/listsTableYour.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("listTableYour").'</a>
						</div>
					</li>' . $browse . '</div></li>';
					echo '<li class="nav-item dropdown '.$reuploadActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-upload" style="margin-right:5" aria-hidden="true"></i>'.$this->getLocalizedString("reuploadSection").'
						</a>
						<div class="dropdown-menu" id="cronview" aria-labelledby="navbarDropdownMenuLink">';
          					if(strpos($songEnabled, '1') !== false) echo '<a type="button" href="songs" onclick="a(\'songs\')" class="dropdown-item"><i class="fa-solid fa-file" style="position: absolute;font-size: 10px;margin: 5px 5px 5px -2px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songAdd").'</a>';
          					if(strpos($songEnabled, '2') !== false) echo '<a type="button" href="reupload/songAdd.php" onclick="a(\'reupload/songAdd.php\')"class="dropdown-item"><i class="fa-solid fa-link" style="position: absolute;font-size: 9px;margin: 5px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("songLink").'</a>';
          					if(strpos($sfxEnabled, '1') !== false) echo '<a type="button" href="sfxs" onclick="a(\'sfxs\')" class="dropdown-item"><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("sfxAdd").'</a>';
								if($lrEnabled == 1) echo '<a type="button" href="levels/levelReupload.php" onclick="a(\'levels/levelReupload.php\')"class="dropdown-item"><i class="fa-solid fa-arrow-down" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelReupload").'</a>
                                <a type="button" href="levels/levelToGD.php" onclick="a(\'levels/levelToGD.php\')"class="dropdown-item"><i class="fa-solid fa-arrow-up" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-cloud" aria-hidden="false"></i></div>'.$this->getLocalizedString("levelToGD").'</a>';
          				echo '<button type="button" class="dropdown-item" id="crbtn" onclick="cron(), event.stopPropagation();"><div class="icon"><i id="iconcron" class="fa-solid fa-bars-progress"></i></div>'.$this->getLocalizedString('tryCron').'</button>
						</div>
					</li>';
			if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")) {
				echo '<li class="nav-item dropdown '.$modActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-wrench" aria-hidden="true"></i> '.$this->getLocalizedString("modTools").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="account/banPerson.php" onclick="a(\'account/banPerson.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-gavel"></i></div>'.$this->getLocalizedString("leaderboardBan").'</a>
							<a type="button" href="stats/banList.php" onclick="a(\'stats/banList.php\')"class="dropdown-item"><i class="fa-solid fa-gavel" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list"></i></div>'.$this->getLocalizedString("banList").'</a>';
							echo '<a type="button" href="stats/unlistedMod.php" onclick="a(\'stats/unlistedMod.php\')"class="dropdown-item"><i class="fa-solid fa-eye-slash" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("unlistedMod").'</a>
							<a type="button" href="stats/suggestList.php" onclick="a(\'stats/suggestList.php\')"class="dropdown-item"><i class="fa-solid fa-user" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("suggestLevels").'</a>
							<a type="button" href="stats/listsTableMod.php" onclick="a(\'stats/listsTableMod.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ul" aria-hidden="false"></i></div>'.$this->getLocalizedString("listTableMod").'</a>';
							echo '<a type="button" href="stats/reportMod.php" onclick="a(\'stats/reportMod.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-exclamation" aria-hidden="false"></i></div>'.$this->getLocalizedString("reportMod").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")) echo '<a type="button" href="levels/packCreate.php" onclick="a(\'levels/packCreate.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-regular fa-folder-open" style="margin-left: 2px;" aria-hidden="false"></i></div>'.$this->getLocalizedString("packManage").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardGauntletCreate")) echo '<a type="button" href="levels/gauntletCreate.php" onclick="a(\'levels/gauntletCreate.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-globe" aria-hidden="false"></i></div>'.$this->getLocalizedString("gauntletManage").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")) {
								echo '<a type="button" href="stats/disabledSongsList.php" onclick="a(\'stats/disabledSongsList.php\')"class="dropdown-item"><i class="fa-solid fa-xmark" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-music" aria-hidden="false"></i></div>'.$this->getLocalizedString("disabledSongs").'</a>';
								echo '<a type="button" href="stats/disabledSFXsList.php" onclick="a(\'stats/disabledSFXsList.php\')"class="dropdown-item"><i class="fa-solid fa-xmark" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-drum" aria-hidden="false"></i></div>'.$this->getLocalizedString("disabledSFXs").'</a>';
							}
							if($gs->checkPermission($_SESSION["accountID"], "toolQuestsCreate")) echo '<a type="button" href="stats/addQuests.php" onclick="a(\'stats/addQuests.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-list-ol" aria-hidden="false"></i></div>'.$this->getLocalizedString("addQuest").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardAddMod")) echo '<a type="button" href="account/addMod.php" onclick="a(\'account/addMod.php\')"class="dropdown-item"><i class="fa-solid fa-plus" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-solid fa-id-badge" aria-hidden="false"></i></div>'.$this->getLocalizedString("addMod").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "commandSharecpAll")) echo '<a type="button" href="levels/shareCP.php" onclick="a(\'levels/shareCP.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-share" aria-hidden="false"></i></div>'.$this->getLocalizedString("shareCPTitle").'</a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardForceChangePassNick")) echo '<a type="button" href="account/forceChange.php" onclick="a(\'account/forceChange.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-pen-to-square" aria-hidden="false"></i></i></div>'.$this->getLocalizedString("changePassOrNick").'   </a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardManageAutomod")) echo '<a type="button" href="automod" onclick="a(\'automod\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-robot" aria-hidden="false"></i></i></div>'.$this->getLocalizedString("automodTitle").'   </a>';
							if($gs->checkPermission($_SESSION["accountID"], "dashboardVaultCodesManage")) echo '<a type="button" href="levels/vaultCodes.php" onclick="a(\'levels/vaultCodes.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-award" aria-hidden="false"></i></i></div>'.$this->getLocalizedString("vaultCodesTitle").'   </a>';
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
							<a type="button" href="stats/modList.php" onclick="a(\'stats/modList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-universal-access" aria-hidden="false"></i></div>'.$this->getLocalizedString("modActions").'</a>
							<a type="button" href="stats/modActionsList.php" onclick="a(\'stats/modActionsList.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list" aria-hidden="false"></i></div>'.$this->getLocalizedString("modActionsList").'</a>
							<a type="button" href="stats/top24h.php" onclick="a(\'stats/top24h.php\')"class="dropdown-item"><div class="icon"><i class="fa-solid fa-list-ol" aria-hidden="false"></i></div>'.$this->getLocalizedString("leaderboardTime").'</a>
						</div>
					</li>
				</ul>
				<ul class="nav navbar-nav ml-auto">';
					if($msgEnabled == 1 AND isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) { 
                        $new = '';
						$newMessagesCount = $db->prepare("SELECT * FROM messages WHERE toAccountID = :acc AND isNew = 0 GROUP BY accID");
                        $newMessagesCount->execute([':acc' => $_SESSION["accountID"]]);
                        $newMessagesCount = count($newMessagesCount->fetchAll());
                        if($newMessagesCount > 0) $new = '<span class="new-messages-notify smaller">'.$newMessagesCount.'</span>';
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
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=RU"><div class="icon flag"><img class="imgflag" src="incl/flags/ru.png?2"></div>Русский</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=EN"><div class="icon flag"><img class="imgflag" src="incl/flags/us.png?2"></div>English</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=TR" title="Translated by EMREOYUN"><div class="icon flag"><img class="imgflag" src="incl/flags/tr.png?2"></div>Türkçe</a>
                            <a class="dropdown-item dontblock" href="lang/switchLang.php?lang=UA" title="Translated by Jamichi"><div class="icon flag"><img class="imgflag" src="incl/flags/ua.png?2"></div>Українська</a>
                            <a class="dropdown-item dontblock" href="lang/switchLang.php?lang=FR" title="Translated by masckmaster2007 and M336"><div class="icon flag"><img class="imgflag" src="incl/flags/fr.png?2"></div>Français</a>
                            <a class="dropdown-item dontblock" href="lang/switchLang.php?lang=ES" title="Translated by Nejik and Maxi"><div class="icon flag"><img class="imgflag" src="incl/flags/es.png?2"></div>Español</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=PT" title="Translated by OmgRod"><div class="icon flag"><img class="imgflag" src="incl/flags/pt.png?2"></div>Português</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=CZ" title="Translated by Matto58"><div class="icon flag"><img class="imgflag" src="incl/flags/cz.png?2"></div>Čeština</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=IT" title="Translated by Fenix668"><div class="icon flag"><img class="imgflag" src="incl/flags/it.png?2"></div>Italiano</a>
       						<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=PL" title="Translated by ExtremeSpe98"><div class="icon flag"><img class="imgflag" src="incl/flags/pl.png?2"></div>Polski</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=VI" title="Translated by TacoEnjoyer"><div class="icon flag"><img class="imgflag" src="incl/flags/vi.png?2"></div>Tiếng Việt</a>
							<a class="dropdown-item dontblock" href="lang/switchLang.php?lang=ID" title="Translated by IHNGEYMING"><div class="icon flag"><img class="imgflag" src="incl/flags/id.png?2"></div>Bahasa Indonesia</a>
						</div>';
						$glob = function_exists('glob') ? (!empty(glob("../download/".$gdps.".*")) OR !empty(glob("download/".$gdps.".*"))) : true;
						if($glob OR !empty($pc) OR !empty($mac) OR !empty($android) OR !empty($ios)) {
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
						if((file_exists("download/".$gdps.".ipa") OR file_exists("../download/".$gdps.".ipa")) AND empty($iosLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$gdps.'.ipa"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a>';
                        elseif(!empty($iosLauncher)) echo '<a class="dropdown-item dontblock" href="download/'.$iosLauncher.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a>';
                        elseif(!empty($ios)) echo '<a class="dropdown-item dontblock" href="'.$ios.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$this->getLocalizedString("forios").'</a>';
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
							<i class="fa-solid fa-user-circle" aria-hidden="true"></i> '.$userName.'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
							<a type="button" href="profile/'.$userName.'" onclick="a(\'profile/'.$userName.'\', true, true)" class="dropdown-item"><div class="icon"><i class="fa-regular fa-id-badge"></i></div>'.$this->getLocalizedString("profile").'</a>';
							$claaan = $gs->isPlayerInClan($_SESSION["accountID"]);
							if($claaan) echo '<a href="clan/'.$gs->getClanInfo($claaan, "clan").'" onclick="a(\'clan/'.$gs->getClanInfo($claaan, "clan").'\', false, true)" class="dropdown-item"><div class="icon"><i class="fa-solid fa-dungeon"></i></div>'.$this->getLocalizedString("yourClan").'</a>';
							echo '<a class="dropdown-item dontblock" href="login/logout.php"><div class="icon"><i class="fa-solid fa-sign-out" aria-hidden="false"></i></div>'.$this->getLocalizedString("logout").'</a>
						</div>
					</li>';
		} else {
			echo '<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa-solid fa-sign-in" aria-hidden="true"></i> '.$this->getLocalizedString("login").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="padding: 15px 15px 0px 15px;min-width: 275px;min-height: 208px;">
									<form action="login/login.php" method="post" name="loginthing">
										<div class="form-group">
											<input type="text" class="form-control login-input" id="usernameField" name="userName" placeholder="'.$this->getLocalizedString("username").'">
										</div>
										<div'.($preactivateAccounts ? ' class="form-group"' : '').'>
											<input type="password" class="form-control login-input" id="passwordField" name="password" placeholder="'.$this->getLocalizedString("password").'">
										</div>
										'.(!$preactivateAccounts ? ($mailEnabled ? '<button type="button" onclick="a(\'login/forgotPassword.php\')" class="forgotPassword">'.$this->getLocalizedString("forgotPasswordTitle").'</button>' : '<button type="button" onclick="a(\'login/activate.php\')" class="forgotPassword">'.$this->getLocalizedString("activateAccount").'</button>') : '').'
										<div style="display: flex;flex-wrap: wrap;justify-content: center"><button type="submit" class="btn-primary btn-block" id="submit" disabled>'.$this->getLocalizedString("login").'</button>
										</form>
										<form action="login/register.php" style="width: 80%;margin-top: 10px;margin-bottom: -5px">
											<button type="button" onclick="a(\'login/register.php\')" class="btn btn-primary">'.$this->getLocalizedString("register").'</button>
										</div>
									</form>
						</div><script>
							$(document).on("keyup keypress change keydown", function() {
								const usernameField1 = document.getElementById("usernameField");
								const passwordField2 = document.getElementById("passwordField");
								const loginBtn = document.getElementById("submit");
								if(loginBtn == null) return;
								if((usernameField1 !== null && passwordField2 !== null) && (!usernameField1.value.trim().length || !passwordField2.value.trim().length)) {
									loginBtn.disabled = true;
									loginBtn.classList.add("btn-block");
									loginBtn.classList.remove("btn-primary");
								} else {
									loginBtn.removeAttribute("disabled");
									loginBtn.classList.remove("btn-block");
									loginBtn.classList.remove("btn-size");
									loginBtn.classList.add("btn-primary");
								}
							});
							</script>';
		}	
		echo '</ul>
			</div>
		</nav>
		<div class="form" style="margin:0px;position:absolute;bottom:50px;color:white;font-size:50px;width:max-content !important;right:50px;padding:25px;transition:0.3s;opacity:0;border-radius:500px" id="loadingloool"><i class="fa-solid fa-spinner fa-spin"></i></div>
		<div id="audioPlayerButton" class="audioDiv showButton"><i id="audioPlayerButtonI" class="fa-solid fa-music"></i></div>
		<div id="audioPlayer" class="audioDiv">
			<div class="cover" onclick="player.play()">
				<i id="audioButton" class="fa-solid fa-circle-play image"></i>
				<img id="audioImage" class="image" src="incl/no-cover.png"></img>
			</div>
			<div class="track">
				<p id="audioName" class="name">'.$this->getLocalizedString("songAddNameFieldPlaceholder").'</p>
				<p id="audioAuthor" class="author">'.$this->getLocalizedString("songAddAuthorFieldPlaceholder").'</p>
				<div class="duration">
					<button onclick="player.previous()" id="audioBackward" style="background: transparent; border: none;" disabled><i class="fa-solid fa-backward"></i></button>
					<input type="range" value="0" max="322" id="audioProgress" class="length"></input>
					<button onclick="player.skip()" id="audioForward" style="background: transparent; border: none;" disabled><i class="fa-solid fa-forward"></i></button>
				</div>
				<div class="buttons">
					<button onclick="player.song.download()">
						<i class="fa-solid fa-download"></i>
					</button>
					<button id="audioButtonStop" onclick="player.stop()">
						<i class="fa-solid fa-square"></i>
					</button>
				</div>
				<audio id="audioSong" src="" style="display: none"></audio>
			</div>
			<div class="volumeDiv">
				<i id="audioVolumeIcon" class="fa-solid fa-volume-high volume show"></i>
				<div id="audioAnotherVolume" class="anotherVolume"><input class="length volume" id="audioVolume" type="range" value="0" max="1000"></input></div>
			</div>
			<div id="audioQueue" class="audioDiv queueDiv"></div>
			<script>
				if(!window.localStorage.volume) window.localStorage.volume = 0.2;
				player = document.getElementById("audioPlayer");
				player.showButton = document.getElementById("audioPlayerButton");
				player.isPlaying = false;
				player.queue = [];
				player.queueDiv = document.getElementById("audioQueue");
				player.covers = {};
				player.number = -1;
				player.button = document.getElementById("audioButton");
				player.buttonBackward = document.getElementById("audioBackward");
				player.buttonForward = document.getElementById("audioForward");
				player.cover = $("#audioImage");
				player.name = document.getElementById("audioName");
				player.author = document.getElementById("audioAuthor");
				player.progress = $("#audioProgress");
				player.volume = document.getElementById("audioVolume");
				player.volume.div = document.getElementById("audioAnotherVolume");
				player.volume.change = function(e, directly = false) {
					v = directly ? e : e.target.value;
					player.song.volume = window.localStorage.volume = v / 1000;
					player.volume.style.backgroundSize = (v / 1000 * 100)+"% 100%";
				}
				player.volume.icon = document.getElementById("audioVolumeIcon");
				player.volume.icon.addEventListener("mouseenter", function() {player.volume.div.classList.add("show"); player.volume.icon.classList.remove("show")});
				player.volume.addEventListener("mouseleave", function() {player.volume.div.classList.remove("show"); player.volume.icon.classList.add("show")});
				player.showButton.addEventListener("mouseenter", function() {player.showButton.classList.add("show"); player.classList.add("show");});
				player.addEventListener("mouseleave", function() {player.showButton.classList.remove("show"); player.classList.remove("show");});
				document.querySelector(":not(#audioPlayer > *), :not(.audioDiv > *), :not(#audioPlayer)").addEventListener("click", function(e) {
					window.e = e;
					if(e.target.id == "audioPlayerButton" || e.target.id == "audioPlayerButtonI") {
						return false;
					}
					let node = e.target.parentNode;
					while (node != null) {
						if (node.id == "audioPlayer" || (node.classList && node.classList.contains("item"))) {
							return false;
						}
						node = node.parentNode;
					}
					player.showButton.classList.remove("show");
					player.classList.remove("show");
				});
				player.song = document.getElementById("audioSong");
				player.song.volume = window.localStorage.volume;
				player.cover.imgcolr((i,c) => {player.color = c+"99";	player.progress.css("background-image", "linear-gradient("+player.color+", "+player.color+"), linear-gradient(#ffffff, #ffffff)");})
				player.progress.update = function(e) {
					playerPercents = e.target.valueAsNumber / player.progress.attr("max") * 100;
					playerPercents = playerPercents > 50 ? playerPercents * 0.98 : playerPercents * 1.02;
					player.progress.css("background-size", playerPercents+"% 100%");
				}
				player.progress.input = function(e) {
					player.song.currentTime = e.target.value;
					player.progress.update(e);
				}
				player.progress.on("change", player.progress.update);
				player.progress.on("input", player.progress.input);
				player.volume.addEventListener("input", player.volume.change);
				player.song.addEventListener("timeupdate", function(e) {player.progress.val(e.target.currentTime).change(); player.progress.attr("max", player.song.duration);});
				player.song.addEventListener("ended", () => {player.skip()});
				player.song.addEventListener("play", () => {
					player.button.classList = "fa-solid fa-circle-pause image";
					if(typeof document.getElementById("icon"+player.song.ID) != "undefined" && document.getElementById("icon"+player.song.ID) != null) document.getElementById("icon"+player.song.ID).classList.replace("fa-play", "fa-pause");
				})
				player.song.addEventListener("pause", () => {
					player.button.classList = "fa-solid fa-circle-play image";
					if(typeof document.getElementById("icon"+player.song.ID) != "undefined" && document.getElementById("icon"+player.song.ID) != null) document.getElementById("icon"+player.song.ID).classList.replace("fa-pause", "fa-play");
				})
				player.play = function() {
					if(!player.isPlaying) return player.process();
					if(player.song.paused) player.song.play(); 
					else player.song.pause();
				}
				player.process = function(previous = false) {
					if(!player.queue.length) return false;
					if(!player.isPlaying) {
						if(document.querySelector(".indicator") == null) {
							indicator = document.createElement("span");
							indicator.classList.add("indicator");
							player.showButton.append(indicator);
						}
						player.number += previous ? -1 : 1;
						player.currentSong = player.queue[player.number];
						player.progress.val(0).change();
						player.song.src = decodeURIComponent(player.currentSong.src);
						player.name.innerHTML = player.currentSong.name;
						player.author.innerHTML = player.currentSong.author;
						player.song.ID = player.currentSong.ID;
						player.volume.value = window.localStorage.volume * 1000;
						player.volume.change(window.localStorage.volume * 1000, true)
						player.song.play();
						player.button.classList = "fa-solid fa-circle-pause image";
						player.progress.attr("max", player.song.duration);
						player.song.setCover(player);
						player.isPlaying = true;
						if(player.number > 0) player.buttonBackward.disabled = false;
						else player.buttonBackward.disabled = true;
						if(player.number >= player.queue.length-1) player.buttonForward.disabled = true;
						else player.buttonForward.disabled = false;
						if(!previous) {
							if(player.queue.length > 1) player.queueDiv.removeChild(document.getElementById("queue"+player.currentSong.ID));
						} else player.updateQueue(player.queue[player.number+1], true);
						player.song.download = function() {
							delete fakeA;
							fakeA = document.createElement("a");
							fakeA.href = player.song.src;
							fakeA.download = player.currentSong.author + " - " + player.currentSong.name + ".mp3";
							fakeA.click();
						}
					}
				}
				player.skip = function() {
					if(player.number >= player.queue.length-1) {
						player.stop();
						return false;
					}
					player.isPlaying = false;
					if(typeof document.getElementById("icon"+player.song.ID) != "undefined" && document.getElementById("icon"+player.song.ID) != null) document.getElementById("icon"+player.song.ID).classList.replace("fa-pause", "fa-play");
					player.process();
				}
				player.previous = function() {
					if(player.number <= 0) return false;
					player.isPlaying = false;
					if(typeof document.getElementById("icon"+player.song.ID) != "undefined" && document.getElementById("icon"+player.song.ID) != null) document.getElementById("icon"+player.song.ID).classList.replace("fa-pause", "fa-play");
					player.process(true);
				}
				player.addToQueue = function(song) {
					player.queue.push(song);
					if(!player.isPlaying) player.process();
					if(player.number > 0) player.buttonBackward.disabled = false;
					else player.buttonBackward.disabled = true;
					if(player.number >= player.queue.length-1) player.buttonForward.disabled = true;
					else player.buttonForward.disabled = false;
					if(player.queue.length > 1) player.updateQueue(song);
				}
				player.song.setCover = function(src1) {
					src = src1;
					player.cover.attr("src", "incl/no-cover.png");
					if(typeof player.covers[src.song.ID] != "undefined") {
						player.cover.attr("src", player.covers[src.song.ID]);
						return player.song.setColor(src.cover);
					} 
					jsmediatags.read(src.song.src, {
						onSuccess: function(tag) {
							if(tag.tags.picture) {
								var { data, format } = tag.tags.picture; 
								let base64String = "";
								for (var i = 0; i < data.length; i++) {
								  base64String += String.fromCharCode(data[i]);
								}
								cover = `data:${format};base64,${window.btoa(base64String)}`;
								player.cover.attr("src", cover);
								player.covers[src.song.ID] = cover;
								player.song.setColor(src.cover);
							} else {
								player.cover.attr("src", "incl/no-cover.png");
							}
						},
						onError: function(e) {
							player.cover.attr("src", "incl/no-cover.png");
						}
					});
				}
				player.song.setColor = function(src) {
					src.imgcolr((i,c) => {player.color = c+"99"; player.progress.css("background-image", "linear-gradient("+player.color+", "+player.color+"), linear-gradient(#ffffff, #ffffff)");})
				}
				player.updateQueue = function(song, first = false) {
					newTrackDiv = document.createElement("div");
					newTrackDiv.id = "queue"+song.ID;
					newTrackDiv.classList.add("item");
					newTrackCover = document.createElement("div");
					newTrackCover.classList.add("cover");
					newTrackI = document.createElement("i");
					newTrackI.classList = "fa-solid fa-circle-play image";
					newTrackI.setAttribute("onclick", "player.queueDiv.move("+song.ID+")");
					newTrackImg = document.createElement("img");
					newTrackImg.classList.add("image");
					if(typeof player.covers[song.ID] == "undefined") newTrackImg.src = "incl/no-cover.png";
					else newTrackImg.src = player.covers[song.ID];
					newTrackCover.append(newTrackI, newTrackImg);
					newTrackNames = document.createElement("div");
					newTrackNames.classList.add("track");
					newTrackName = document.createElement("p");
					newTrackName.classList.add("name");
					newTrackName.innerHTML = song.name;
					newTrackAuthor = document.createElement("p");
					newTrackAuthor.classList.add("author");
					newTrackAuthor.innerHTML = song.author;
					newTrackRemove = document.createElement("button");
					newTrackRemove.classList.add("buttons");
					newTrackRemove.setAttribute("onclick", "player.queueDiv.remove("+song.ID+")")
					newTrackRemoveIcon = document.createElement("i");
					newTrackRemoveIcon.classList = "fa-solid fa-xmark";
					newTrackRemove.append(newTrackRemoveIcon);
					newTrackNames.append(newTrackName, newTrackAuthor, newTrackRemove);
					newTrackDiv.append(newTrackCover, newTrackNames);
					if(!first) player.queueDiv.append(newTrackDiv);
					else player.queueDiv.prepend(newTrackDiv);
				}
				player.queueDiv.move = function(songID) {
					if(player.queue.length > 1) {
						for(const queueID in player.queue) {
							if(queueID <= player.number) continue;
							queueSong = player.queue[queueID];
							if(queueSong.ID != songID) player.queueDiv.removeChild(document.getElementById("queue"+queueSong.ID));
							else {
								player.number = queueID-1;
								if(document.getElementById("icon"+player.currentSong.ID) != null) document.getElementById("icon"+player.currentSong.ID).classList.replace("fa-pause", "fa-play");
								player.isPlaying = false;
								player.process();
								break;
							}
						}
					} else return false;
				}
				player.stop = function() {
					player.showButton.removeChild(document.querySelector(".indicator"));
					player.song.pause();
					if(player.queue.length > 1) {
						for(const queueID in player.queue) {
							if(queueID <= player.number) continue;
							queueSong = player.queue[queueID];
							player.queueDiv.removeChild(document.getElementById("queue"+queueSong.ID));
						}
					}
					player.queue = [];
					player.number = -1;
					player.name.innerHTML  = "'.$this->getLocalizedString("songAddNameFieldPlaceholder").'";
					player.author.innerHTML  = "'.$this->getLocalizedString("songAddAuthorFieldPlaceholder").'";
					player.cover.src = "incl/no-cover.png";
					player.song.ID = "";
					player.song.src = "";
					pauses = document.querySelectorAll("button i.fa-pause");
					for(const pauseBtn in pauses) if(typeof pauses[pauseBtn] == "object") pauses[pauseBtn].classList.replace("fa-pause", "fa-play");
					delete player.currentSong;
					player.isPlaying = false;
					player.showButton.classList.remove("show");
					player.classList.remove("show");
				}
				player.queueDiv.remove = function(song) {
					if(player.queue.length > 1) {
						for(const queueID in player.queue) {
							if(queueID <= player.number) continue;
							queueSong = player.queue[queueID];
							if(queueSong.ID == song) {
								player.queueDiv.removeChild(document.getElementById("queue"+queueSong.ID));
								player.queue.splice(queueID, 1);
								if(player.number > 0) player.buttonBackward.disabled = false;
								else player.buttonBackward.disabled = true;
								if(player.number >= player.queue.length-1) player.buttonForward.disabled = true;
								else player.buttonForward.disabled = false;
								return true;
							}
						}
					}
				}
				window.addEventListener("keydown", function(e) {
					switch(e.key) {
						case "MediaTrackNext":
							player.skip();
							return false;
							break;
						case "MediaTrackPrevious":
							player.previous();
							return false;
							break;
						case "MediaStop":
							player.stop();
							return false;
							break;
						default:
							return true;
							break;
					}
				});
			</script>
		</div>
		<div class="error-divs" id="error-divs"></div>
<script>
	if(document.querySelector("[alt=\'www.000webhost.com\']") != null) document.querySelector("[alt=\'www.000webhost.com\']").parentElement.parentElement.style = "z-index: 0;position: fixed;bottom: 0px;"
	cptch = document.querySelector("#verycoolcaptcha");
	$(document).click(function(event) {
		if(event.target && !event.target.classList.contains("dontblock") && (event.target.classList.contains("dropdown-item") || event.target.classList.contains("icon") || event.target.classList.contains("nav-link") || event.target.classList.contains("fa-solid") || event.target.classList.contains("fa-regular"))) event.preventDefault();
	});
	function a(page, skipcheck = false, skipslash = false, method = "GET", getdata = false, formname = "", isback = false) {
		try {
			if(window.location.pathname.indexOf(page) != "1" || skipcheck) {
				if(!skipslash) page = page + "/";
				phpCheck = page.substr(page.length - 4);
				if(page == "/") page = "";
				if(phpCheck == "php/") page = page.substring(0, page.length - 1);
				document.getElementById("loadingloool").innerHTML = \'<i class="fa-solid fa-spinner fa-spin"></i>\';
				document.getElementById("loadingloool").style.opacity = "1";
				pageLimiters = page.split("?");
				page = pageLimiters[0];
				pg = new XMLHttpRequest();
				sendget = "";
				if(getdata > 0) {
					if(getdata != 69) fd = new FormData(document.getElementsByTagName("form")[document.getElementsByTagName("form").length-getdata]);
					else fd = new FormData(searchform);
					delimiter = "?";
					if(fd.get("search") !== null) {
						sendget = sendget + delimiter + "search=" + encodeURIComponent(fd.get("search"));
						delimiter = "&";
					}
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
					if(fd.get("levelID") !== null) {
						sendget = sendget + delimiter + "levelID=" + encodeURIComponent(fd.get("levelID"));
						delimiter = "&";
					}
					if(fd.get("page") !== null) {
						sendget = sendget + delimiter + "page=" + encodeURIComponent(fd.get("page"));
						delimiter = "&";
					}
				} else if(typeof pageLimiters[1] != "undefined") page = page + "?" + pageLimiters[1];
				pg.open(method, page + sendget, true);
				pg.responseType = "document";
				htmlpage = document.querySelector("#htmlpage");
				navbar = document.querySelector("#navbarepta");
				htmtitle = document.querySelectorAll("title")[0];
				pg.onload = function () {
					$(document).off("keyup keypress change keydown");
					$(document).on("keyup keypress change keydown", function() {
					   const usernameField1 = document.getElementById("usernameField");
					   const passwordField2 = document.getElementById("passwordField");
					   const loginBtn = document.getElementById("submit");
					   if(loginBtn == null) return;
					   if((usernameField1 !== null && passwordField2 !== null) && (!usernameField1.value.trim().length || !passwordField2.value.trim().length)) {
									loginBtn.disabled = true;
									loginBtn.classList.add("btn-block");
									loginBtn.classList.remove("btn-primary");
						} else {
									loginBtn.removeAttribute("disabled");
									loginBtn.classList.remove("btn-block");
									loginBtn.classList.remove("btn-size");
									loginBtn.classList.add("btn-primary");
						}
					});
					'.($enableCaptcha ? 'try {
						if(typeof '.$captchaUsed.' == "object" && typeof '.$captchaUsed.'.getResponse() != "undefined" && document.getElementById("coolcaptcha") != null) '.$captchaUsed.'.reset();
					} catch(e) {
						console.log(e);
					}' : '').'
					if(pg.response.getElementById("htmlpage") != null) {
						document.getElementById("loadingloool").style.opacity = "0";
						checkError = pg.response.getElementById("dashboard-error-text");
						if(checkError != null) {
							createToast(checkError.innerHTML);
							return;
						}
						title = pg.response.querySelectorAll("title")[0];
						scripts = pg.response.querySelectorAll("body script");
						scripts = scripts[scripts.length-1];
						newnavbar = pg.response.querySelector("#navbarepta");
						if(player.isPlaying) {
							if(!player.song.paused) if(typeof pg.response.getElementById("icon"+player.song.ID) != "undefined" && pg.response.getElementById("icon"+player.song.ID) != null) pg.response.getElementById("icon"+player.song.ID).classList.replace("fa-play", "fa-pause");
						}
						child = pg.response.querySelector("#htmlpage");
						htmlpage.replaceWith(child);
						navbar.replaceWith(newnavbar);
						htmtitle.replaceWith(title);
						var scrp = document.createElement("script");
						scrp.id = "pagescript";
						captchascript = document.getElementById("captchascript");
						bottomrowscript = document.getElementById("bottomrowscript");
						lastChar = page.substr(page.length - 1);
						if(lastChar == "/") pageyes = page.split("/")[0];
						else pageyes = page;
						now = document.querySelector("[href=\'"+pageyes+"\']");
						if(now !== null) now.classList.add("now");
						if(typeof scripts.textContent != "undefined") scrp.innerHTML = scripts.textContent;
						if(typeof bottomrowscript != "undefined" && bottomrowscript != null) scrp.innerHTML += bottomrowscript.textContent;
						if(document.getElementById("pagescript") !== null) document.getElementById("pagescript").remove();
						document.body.appendChild(scrp);
						isSubdirectory = document.getElementById("isSubdirectory").value == "true" ? true : false;
						if(!isback) history.pushState(null, null, page + sendget);
						if(typeof document.querySelector("base") != "object") {
							base = document.createElement("base");
							if(page.endsWith("settings")) base.href = "../../";
							else if(isSubdirectory) base.href = "../";
							else base.href = ".";
							document.body.appendChild(base);
						} else {
							base = document.querySelectorAll("base")[0];
							if(page.endsWith("settings")) base.href = "../../";
							else if(isSubdirectory) base.href = "../";
							else base.href = ".";
							document.body.appendChild(base);
						}
						try {
							if(typeof captchascript != "undefined") {
								if(typeof turnstile != "object" && typeof grecaptcha != "object" && typeof hcaptcha != "object") {
									cptscr = document.createElement("script");
									cptscr.id = "captchascript";
									cptscr.setAttribute("src", captchascript.getAttribute("src"));
									document.body.append(cptscr);
									if(typeof turnstile == "object") turnstile.implicitRender();
									if(typeof grecaptcha == "object") grecaptcha.render("coolcaptcha");
									if(typeof hcaptcha == "object") hcaptcha.render("coolcaptcha");
								} else {
									if(typeof turnstile == "object") turnstile.implicitRender();
									if(typeof grecaptcha == "object") grecaptcha.render("coolcaptcha");
									if(typeof hcaptcha == "object") hcaptcha.render("coolcaptcha");
								}
							}
						} catch(e) {}
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
		} catch(e) {
            console.log(e);
        }
	}
	function copysong(id) {
		navigator.clipboard.writeText(id);
		document.getElementById("copy"+id).style.transition = "0.05s";
		document.getElementById("copy"+id).style.color = "#bbffbb";
		setTimeout(function(){document.getElementById("copy"+id).style.transition = "0.2s";}, 1)
		setTimeout(function(){document.getElementById("copy"+id).style.color = "#007bff";}, 200)
	}
	function btnsong(id) {
		btnid = document.getElementById("btn"+id);
		song = {
			src: btnid.getAttribute("download"),
			title: escapeHtml(btnid.title),
			author: escapeHtml(btnid.title.split(/( — | - )/g)[0]),
			name: escapeHtml(btnid.title.split(/( — | - )/g)[2]),
			ID: id
		};
		if(player.isPlaying) {
			if(JSON.stringify(player.currentSong) == JSON.stringify(song)) player.play();
			else if(!player.queue.find(find => find.ID == song.ID)) player.addToQueue(song);
		} else player.addToQueue(song);
	}
	function escapeHtml(text) {
		var map = {
			"&": "&amp;",
			"<": "&lt;",
			">": "&gt;",
			\'"\': "&quot;",
			"\'": "&#039;"
		};
		return text.replace(/[&<>""]/g, function(m) { return map[m]; });
	}
	function downloadLevel(levelID) {
		levelIcon = document.getElementById("levelDownloadIcon" + levelID);
		levelIcon.classList = "fa-solid fa-spinner fa-spin";
		fetch("api/getGMD.php", {
			method: "POST",
			body: "levelID=" + levelID,
			headers: {
				"Content-Type": "application/x-www-form-urlencoded"
			}
		}).then(async function(r) {
			result = await r.json();
			if(result.success) {
				delete fakeA;
				fakeA = document.createElement("a");
				fakeA.href = "data:text/xml;base64," + result.GMD;
				fakeA.download = result.levelName + ".gmd";
				fakeA.click();
			}
			levelIcon.classList = "fa-solid fa-download";
		}).catch(e => {
			levelIcon.classList = "fa-solid fa-download";
		})
	}
	function renameSong(id, isSFX) {
		nfd = new FormData(document.getElementsByName("songrename" + id)[0]);
		ren = new XMLHttpRequest();
		ren.open("POST", "stats/renameSong.php", true);
		ren.onload = function () {
			r = JSON.parse(ren.response);
			if(r.success) {
				if(isSFX) document.getElementById("songname"+id).innerHTML = nfd.get("name");
				else document.getElementById("songname"+id).innerHTML = nfd.get("author") + " — " + nfd.get("name");
			}
		}
		ren.send(nfd);
	}
	function likeSong(id) {
		likebtn = document.getElementById("like" + id);
		if(likebtn.value == 1) {
			document.getElementById("likeicon" + id).classList.add("fa-regular");
			document.getElementById("likeicon" + id).classList.remove("fa-solid");
			likebtn.value = 0;
			likebtn.title = "'.$this->getLocalizedString("likeSong").'";
		} else {
			document.getElementById("likeicon" + id).classList.remove("fa-regular");
			document.getElementById("likeicon" + id).classList.add("fa-solid");
			likebtn.value = 1;
			likebtn.title = "'.$this->getLocalizedString("dislikeSong").'";
		}
		fav = new XMLHttpRequest();
		fav.open("GET", "stats/favourite.php?id=" + id, true);
		fav.onload = function () {
			if(fav.response == "-1") {
				if(likebtn.value == 1) {
					document.getElementById("likeicon" + id).classList.add("fa-regular");
					document.getElementById("likeicon" + id).classList.remove("fa-solid");
					likebtn.value = 0;
					likebtn.title = "'.$this->getLocalizedString("likeSong").'";
				} else {
					document.getElementById("likeicon" + id).classList.remove("fa-regular");
					document.getElementById("likeicon" + id).classList.add("fa-solid");
					likebtn.value = 1;
					likebtn.title = "'.$this->getLocalizedString("dislikeSong").'";
				}
			}
		}
		fav.send();
	}
	function deleteSong(id, isSFX) {
		del = new XMLHttpRequest();
		if(isSFX) addSFX = "&sfx";
		else addSFX = "";
		del.open("GET", "stats/deleteSong.php?ID=" + id + addSFX, true);
		del.onload = function () {
			dl = JSON.parse(del.response);
			if(dl.success) document.getElementById("songCard" + id).remove()
		}
		del.send();
	}
	function disableSong(id, isSFX) {
		del = new XMLHttpRequest();
		if(isSFX) addSFX = "&sfx";
		else addSFX = "";
		del.open("GET", "stats/deleteSong.php?ID=" + id + "&disable" + addSFX, true);
		del.onload = function () {
			dl = JSON.parse(del.response);
			if(dl.success) {
				disableIconDiv = document.getElementById("songDisableIcon" + id);
				disableButtonDiv = document.getElementById("songDisableButton" + id);
				disableTextDiv = document.getElementById("songDisableText" + id);
				isDisabled = disableButtonDiv.innerHTML == "'.$this->getLocalizedString('enable').'";
				if(isDisabled) {
					if(disableIconDiv != null && disableTextDiv != null) {
						disableIconDiv.classList.remove("fa-xmark");
						disableIconDiv.classList.add("fa-check");
						disableTextDiv.innerHTML = "'.$this->getLocalizedString('songIsAvailable').'";
					}
					disableButtonDiv.innerHTML = "'.$this->getLocalizedString('disable').'";
				} else {
					if(disableIconDiv != null && disableTextDiv != null) {
						disableIconDiv.classList.remove("fa-check");
						disableIconDiv.classList.add("fa-xmark");
						disableTextDiv.innerHTML = "'.$this->getLocalizedString('songIsDisabled').'";
					}
					disableButtonDiv.innerHTML = "'.$this->getLocalizedString('enable').'";
				}
			}
		}
		del.send();
	}
	function createToast(text) {
		errorDivs = document.querySelector("#error-divs");
		toast = document.createElement("div");
		toast.classList.add("notify");
		toast.innerHTML = text;
		errorDivs.append(toast);
		setTimeout(function () {toast.classList.add("notify-show");}, 100);
		setTimeout(function () {
			toast.classList.remove("notify-show");
			setTimeout(function () {toast.remove()}, 300);
		}, 3000);
	}
	function cron() {
		var iconCron = document.getElementById("iconcron");
		var cronButton = document.getElementById("crbtn");
		iconCron.classList.remove("fa-bars-progress");
		iconCron.classList.add("fa-spinner");
		iconCron.classList.add("fa-spin");
		fetch("api/runCron.php").then(r => r.json()).then(response => {
			if(response.success) {
				cronButton.innerHTML = \'<div class="icon"><i id="iconcron" class="fa-solid fa-check"></i></div>'.$this->getLocalizedString('cronSuccess').'\';
				iconCron.classList.remove("fa-spinner");
				iconCron.classList.remove("fa-spin");
				iconCron.classList.add("fa-bars-progress");
				cronButton.classList.add("dropdown-success");
				cronButton.classList.remove("dropdown-error");
				cronButton.disabled = true;
			} else {
				cronButton.innerHTML = \'<div class="icon"><i id="iconcron" class="fa-solid fa-xmark"></i></div>'.$this->getLocalizedString('cronError').'\';
				iconCron.classList.remove("fa-spinner");
				iconCron.classList.remove("fa-spin");
				iconCron.classList.add("fa-bars-progress");
				cronButton.classList.remove("dropdown-success");
				cronButton.classList.add("dropdown-error");
			}
		});
	}
	window.addEventListener("popstate", function(e) { 
		a(e.target.location.href, true, true, "GET", false, "", true);
	}, false);
</script>';
	if((date("F", time()) == "December" AND date("j", time()) > 17) OR (date("F", time()) == "January" AND date("j", time()) < 10)) echo "<script>var embedimSnow=document.getElementById(\"embedim--snow\");if(!embedimSnow){function embRand(a,b){return Math.floor(Math.random()*(b-a+1))+a}var embCSS='.embedim-snow{position: absolute;width: 10px;height: 10px;background: white;border-radius: 50%;margin-top:-10px}';var embHTML='';for(i=1;i<200;i++){embHTML+='<i class=\"embedim-snow\"></i>';var rndX=(embRand(0,1000000)*0.0001),rndO=embRand(-100000,100000)*0.0001,rndT=(embRand(3,7)*10).toFixed(2),rndS=(embRand(0,6000)*0.0001).toFixed(2);embCSS+='.embedim-snow:nth-child('+i+'){'+'opacity:'+(embRand(1,10000)*0.0001).toFixed(2)+';'+'transform:translate('+rndX.toFixed(2)+'vw,-10px) scale('+rndS+');'+'animation:fall-'+i+' '+embRand(10,30)+'s -'+embRand(0,30)+'s linear infinite'+'}'+'@keyframes fall-'+i+'{'+rndT+'%{'+'transform:translate('+(rndX+rndO).toFixed(2)+'vw,'+rndT+'vh) scale('+rndS+')'+'}'+'to{'+'transform:translate('+(rndX+(rndO/2)).toFixed(2)+'vw, 105vh) scale('+rndS+')'+'}'+'}'}embedimSnow=document.createElement('div');embedimSnow.id='embedim--snow';embedimSnow.innerHTML='<style>#embedim--snow{position:fixed;left:0;top:0;bottom:0;width:100vw;height:100vh;overflow:hidden;z-index:9999999;pointer-events:none}'+embCSS+'</style>'+embHTML;document.body.appendChild(embedimSnow)}</script>";
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
	public function handleLangStart() {
		if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])){
			if(file_exists('/lang/locale'.strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))).'.php') setcookie("lang", strtoupper(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)), 2147483647, "/");
			else setcookie("lang", "EN", 2147483647, "/");
		}
		if(!isset($_SESSION["accountID"])) $_SESSION["accountID"] = 0;
	}
	public function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
		$rgbArray = [];
		if(strlen($hexStr) == 6) {
			$colorVal = hexdec($hexStr);
			$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['blue'] = 0xFF & $colorVal;
		} elseif (strlen($hexStr) == 3) {
			$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
		} else return false;
		return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; 
	}
	public function convertToDate($timestamp, $acc = false){
		if($acc) {
			if($timestamp == 0) return $this->getLocalizedString("never");
			if(date("d.m.Y", $timestamp) == date("d.m.Y", time())) return date("G:i", $timestamp);
			elseif(date("Y", $timestamp) == date("Y", time())) return date("d.m", $timestamp);
			else return date("d.m.Y", $timestamp);
		} else return date("d.m.Y G:i:s", $timestamp);
	}
	public function createProfileStats($stars = 0, $moons = 0, $diamonds = 0, $goldCoins = 0, $userCoins = 0, $demons = 0, $creatorPoints = 0, $isCreatorBanned = 0, $returnText = true) {
		if($stars == 0) $st = ''; else $st = '<p class="profilepic">'.$stars.' <i class="fa-solid fa-star" style="color:#ffff88"></i></p>';
		if($moons == 0) $ms = ''; else $ms = '<p class="profilepic">'.$moons.' <i class="fa-solid fa-moon" style="color:#80abff"></i></p>';
		if($diamonds == 0) $dm = ''; else $dm = ' <p class="profilepic">'.$diamonds.' <i class="fa-solid fa-gem" style="color:#a6fffb"></i></p>';
		if($goldCoins == 0) $gc = ''; else $gc = '<p class="profilepic">'.$goldCoins.' <i class="fa-solid fa-coins" style="color:#fffd6b"></i></p>';
		if($userCoins == 0) $uc = ''; else $uc = '<p class="profilepic">'.$userCoins.' <i class="fa-solid fa-coins"></i></p>';
		if($demons == 0) $dn = ''; else $dn = '<p class="profilepic">'.$demons.' <i class="fa-solid fa-dragon" style="color:#ffbbbb"></i></p>';
		if($creatorPoints == 0) $cp = ''; else $cp = '<p class="profilepic">'.$creatorPoints.' <i class="fa-solid fa-screwdriver-wrench"></i></p>';
		$all = $st.$ms.$dm.$gc.$uc.$dn.$cp;
		if(empty($all) && $returnText) $all = '<p style="font-size:25px;color:#212529">'.$this->getLocalizedString("empty").'</p>';
		return $all;
	}
	public function generateLevelsCard($action, $modcheck = false, $extraDetails = '') {
		global $dbPath;
		global $iconsRendererServer;
		require __DIR__."/../".$dbPath."incl/lib/connection.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
		$gs = new mainLib();
		$levelid = $action["levelID"];
		$levelname = $action["levelName"];
		$levelIDlol = '<button id="copy'.$action["levelID"].'" class="accbtn songidyeah" onclick="copysong('.$action["levelID"].')">'.$action["levelID"].'</button>';
		$levelDesc = $this->parseMessage(htmlspecialchars(ExploitPatch::url_base64_decode($action["levelDesc"])));
		if(empty($levelDesc)) $levelDesc = '<text style="color:gray">'.$this->getLocalizedString("noDesc").'</text>';
		$levelpass = $action["password"];
		$likes = '<span style="color: #c0c0c0;">'.$action["likes"].'</span>';
		$dislikes = '<span style="color: #c0c0c0;">'.$action["dislikes"].'</span>';
		$stats = '<div class="profilepic" style="display: inline-flex; grid-gap :3px; color: #c0c0c0;"><i class="fa-regular fa-thumbs-up"></i> '.$likes.' '.(isset($action['dislikes']) ? '<text style="color: gray;">•</text> <i class="fa-regular fa-thumbs-down"></i> '.$dislikes : '').'</div>';
		if($modcheck) {
			$levelpass = substr($levelpass, 1);
			$levelpass = preg_replace('/(0)\1+/', '', $levelpass);
			if($levelpass == 0 OR empty($levelpass)) $lp = '<p class="profilepic"><i class="fa-solid fa-unlock"></i> '.$this->getLocalizedString("nopass").'</p>';
			else {
				if(strlen($levelpass) < 4) while(strlen($levelpass) < 4) $levelpass = '0'.$levelpass;
				$lp = '<p class="profilepic"><i class="fa-solid fa-lock"></i> '.$levelpass.'</p>';
			}
			if($action["requestedStars"] <= 0 && $action["requestedStars"] > 10) $rs = '<p class="profilepic"><i class="fa-solid fa-star-half-stroke"></i> 0</p>';
			else $rs = '<p class="profilepic"><i class="fa-solid fa-star-half-stroke"></i> '.$action["requestedStars"].'</p>';
		} else $lp = $rs = '';
		if($action["songID"] > 0) {
			$songlol = $gs->getSongInfo($action["songID"]);
			$songArtists = $gs->getLibrarySongInfo($action["songID"])["artists"];
            $artistIDs = preg_split('/\./', $songArtists);
            $artistIDs = array_filter($artistIDs);
            $artistIDsString = implode(', ', $artistIDs);
            $authorNames = [$songlol["authorName"]];
            foreach($artistIDs as $id) {
                $authorInfo = $gs->getLibrarySongAuthorInfo($id);
                $authorNames[] = $authorInfo["name"];
            }
            $artistNames = implode(', ', $authorNames);
            $btn = '<button type="button" name="btnsng" id="btn'.$action["songID"].'" title="'.($artistNames ? $artistNames : $songlol["authorName"]).' — '.$songlol["name"].'" style="display: contents;color: white;margin: 0;" download="'.str_replace('http://', 'https://', $songlol["download"]).'" onclick="btnsong(\''.$action["songID"].'\');"><div class="icon songbtnpic"><i id="icon'.$action["songID"].'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
			$songid = '<div class="profilepic songpic">'.$btn.'<div class="songfullname"><div class="songauthor">'.($artistNames ? $artistNames : $songlol["authorName"]).'</div><div class="songname">'.$songlol["name"].'</div></div></div>';
		} else $songid = '<p class="profilepic"><i class="fa-solid fa-music"></i> '.strstr($gs->getAudioTrack($action["audioTrack"]), ' by ', true).'</p>';
		$username =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID">'.$action["userName"].'</button></form>';
		$time = $this->convertToDate($action["uploadDate"], true);
		$diff = $gs->getDifficulty($action["starDifficulty"], $action["auto"], $action["starDemonDiff"]);
		if($modcheck) {
			$stars = '<div class="dropdown-menu" style="padding:17px 17px 0px 17px; top:0%;">
				<form style="grid-gap: 10px;" class="form__inner" method="post" action="levels/rateLevel.php">
					<p>'.$this->getLocalizedString('featureLevel').'</p>
					<div class="field"><input type="number" id="p1" name="rateStars" placeholder="'.($action['levelLength'] == 5 ? $this->getLocalizedString("moons") : $this->getLocalizedString("stars")).'" value="'.($action["starStars"] > 0 ? $action["starStars"] : "").'"></div>
					<select style="margin: 0px;" name="featured" onclick="event.stopPropagation();">
						<option value="0">'.$this->getLocalizedString('isAdminNo').'</option>
						<option value="1" '.(($action["starFeatured"] > 0 && $action["starEpic"] == 0) ? 'selected' : '').'>Featured</option>
						<option value="2" '.($action["starEpic"] == 1 ? 'selected' : '').'>Epic</option>
						<option value="3" '.($action["starEpic"] == 2 ? 'selected' : '').'>Legendary</option>
						<option value="4" '.($action["starEpic"] == 3 ? 'selected' : '').'>Mythic</option>
					</select>
					<button type="submit" class="btn-song" id="submit" name="level" value="'.$levelid.'">'.$this->getLocalizedString("rate").'</button>
				</form>
			</div>';
		}
		if($action['levelLength'] == 5) $starIcon = 'moon'; else $starIcon = 'star';
		if(!empty($stars)) $st = '<a class="dropdown" href="#" data-toggle="dropdown"><p class="profilepic active-profile-pic"><i class="fa-solid fa-'.$starIcon.'"></i> '.$diff.', '.$action["starStars"].'</p></a>'.$stars;
		else $st = '<p class="profilepic"><i class="fa-solid fa-'.$starIcon.'"></i> '.$diff.', '.$action["starStars"].'</p>';
		$ln = '<p class="profilepic"><i class="fa-solid fa-clock"></i> '.$gs->getLength($action['levelLength']).'</p>';
		$dls = '<p class="profilepic"><i class="fa-solid fa-reply fa-rotate-270"></i> '.$action['downloads'].'</p>';
		$all = $dls.$stats.$st.$ln.$lp.$rs.$extraDetails;
		// Avatar management
		$avatarImg = '';
		$extIDvalue = $action['extID'];
		$query = $db->prepare('SELECT userName, iconType, color1, color2, color3, accGlow, accIcon, accShip, accBall, accBird, accDart, accRobot, accSpider, accSwing, accJetpack FROM users WHERE extID = :extID');
		$query->execute(['extID' => $extIDvalue]);
		$userData = $query->fetch(PDO::FETCH_ASSOC);
		if($userData) {
			$iconType = ($userData['iconType'] > 8) ? 0 : $userData['iconType'];
			$iconTypeMap = [0 => ['type' => 'cube', 'value' => $userData['accIcon']], 1 => ['type' => 'ship', 'value' => $userData['accShip']], 2 => ['type' => 'ball', 'value' => $userData['accBall']], 3 => ['type' => 'ufo', 'value' => $userData['accBird']], 4 => ['type' => 'wave', 'value' => $userData['accDart']], 5 => ['type' => 'robot', 'value' => $userData['accRobot']], 6 => ['type' => 'spider', 'value' => $userData['accSpider']], 7 => ['type' => 'swing', 'value' => $userData['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userData['accJetpack']]];
			$iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
			$avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userData['color1'] . '&color2=' . $userData['color2'] . ($userData['accGlow'] != 0 ? '&glow=' . $userData['accGlow'] . '&color3=' . $userData['color3'] : '') . '" alt="Avatar" style="width: 30px; height: 30px; vertical-align: middle; object-fit: contain;">';
		}
		$manage = '<a class="btn-rendel btn-manage" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-ellipsis-vertical"></i>
		</a>
		<div onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink">
			<button type="button" class="dropdown-item" onclick="downloadLevel('.$action['levelID'].')">
				<div class="icon"><i id="levelDownloadIcon'.$action['levelID'].'" class="fa-solid fa-download"></i></div>
				'.$this->getLocalizedString("downloadLevelAsGMD").'
			</button>
			<button type="button" class="dropdown-item" onclick="a(\'stats/levelComments.php?levelID='.$action['levelID'].'\', true, true, \'GET\')">
				<div class="icon"><i class="fa-solid fa-comments"></i></div>
				'.$this->getLocalizedString("levelComments").'
			</button>
			<button type="button" class="dropdown-item" onclick="a(\'stats/'.($action['levelLength'] != 5 ? 'level' : 'platformer').'Leaderboards.php?levelID='.$action['levelID'].'\', true, true, \'GET\')">
				<div class="icon"><i class="fa-solid fa-chart-simple"></i></div>
				'.$this->getLocalizedString("levelLeaderboards").'
			</button>'.($gs->checkPermission($_SESSION['accountID'], 'dashboardManageLevels') ? '
			<button type="button" class="dropdown-item" onclick="a(\'levels/manageLevel.php?levelID='.$action['levelID'].'\', true, true, \'GET\')">
				<i class="fa-solid fa-pencil" style="position: absolute;font-size: 10px;margin: 0px 5px 5px -7px;" aria-hidden="false"></i>
				<div class="icon"><i class="fa-solid fa-gamepad"></i></div>
				'.$this->getLocalizedString("manageLevel").'
			</button>' : '').'
		</div>';
		return '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
			<div class="profacclist">
				<div class="accnamedesc">
					<div class="profcard1">
						<h1 class="dlh1 profh1 manage-button-div"><div class="manage-level-name-div">'.$manage.sprintf($this->getLocalizedString("demonlistLevel"), $levelname.'</div>', 0, $action["userName"], $avatarImg).'</h1>
					</div>
					<p class="dlp">'.$levelDesc.'</p>
				</div>
				<div class="form-control acccontrol">
					<div class="acccontrol2">
						'.$all.'
					</div>
					'.$songid.'
				</div>
			</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$this->getLocalizedString("levelid").': <b>'.$levelIDlol.'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$this->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
	}
	public function generateCommentsCard($comment, $commentDeleteCheck = false) {
		global $dbPath;
		global $iconsRendererServer;
		require __DIR__."/../".$dbPath."incl/lib/connection.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
		$gs = new mainLib();
		$commentAccountName = $gs->getUserName($comment['userID']);
		$commentMessage = $this->parseMessage(htmlspecialchars(ExploitPatch::url_base64_decode($comment["comment"])));
		$extIDvalue = $gs->getExtID($comment['userID']);
		$likes = '<span style="color: #c0c0c0;">'.$comment["likes"].'</span>';
		$dislikes = '<span style="color: #c0c0c0;">'.$comment["dislikes"].'</span>';
		$stats = '<i class="fa-regular fa-thumbs-up"></i> '.$likes.' '.(isset($comment['dislikes']) ? '<text style="color: gray;">•</text> <i class="fa-regular fa-thumbs-down"></i> '.$dislikes : '');
		$commentIDDiv = '<button id="copy'.$comment["commentID"].'" class="accbtn big" onclick="copysong('.$comment["commentID"].')">'.$comment["commentID"].'</button>';
		if($commentDeleteCheck || $extIDvalue == $_SESSION['accountID']) $deleteComment = '<button onclick="a(\'stats/levelComments.php?levelID='.$comment['levelID'].'\', true, true, \'POST\', false, \'deleteComment\')" style="color:#ffbbbb;margin-left:5px;width:max-content;padding:7px 10px;font-size:15px"  class="btn-rendel">
			<i class="fa-solid fa-xmark"></i>
			<form name="deleteComment" style="display: none;">
				<input type="hidden" name="deleteCommentID" value="'.$comment["commentID"].'"></input>
			</form>
		</button>';
		$percentText = $comment['percent'] > 0 ? '<text class="profilepercent">'.$comment['percent'].'%</text>' : '';
		// Avatar management
		$avatarImg = '';
		$query = $db->prepare('SELECT userName, iconType, color1, color2, color3, accGlow, accIcon, accShip, accBall, accBird, accDart, accRobot, accSpider, accSwing, accJetpack FROM users WHERE extID = :extID');
		$query->execute([':extID' => $extIDvalue]);
		$userData = $query->fetch(PDO::FETCH_ASSOC);
		if($userData) {
			$iconType = ($userData['iconType'] > 8) ? 0 : $userData['iconType'];
			$iconTypeMap = [0 => ['type' => 'cube', 'value' => $userData['accIcon']], 1 => ['type' => 'ship', 'value' => $userData['accShip']], 2 => ['type' => 'ball', 'value' => $userData['accBall']], 3 => ['type' => 'ufo', 'value' => $userData['accBird']], 4 => ['type' => 'wave', 'value' => $userData['accDart']], 5 => ['type' => 'robot', 'value' => $userData['accRobot']], 6 => ['type' => 'spider', 'value' => $userData['accSpider']], 7 => ['type' => 'swing', 'value' => $userData['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userData['accJetpack']]];
			$iconValue = isset($iconTypeMap[$iconType]) ? $iconTypeMap[$iconType]['value'] : 1;	    
			$avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userData['color1'] . '&color2=' . $userData['color2'] . ($userData['accGlow'] != 0 ? '&glow=' . $userData['accGlow'] . '&color3=' . $userData['color3'] : '') . '" alt="Avatar" style="width: 30px; height: 30px; vertical-align: middle; object-fit: contain;">';
		}
		// Badge management
		$badgeImg = '';
		$queryRoleID = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
		$queryRoleID->execute([':accountID' => $extIDvalue]);	
		if($roleAssignData = $queryRoleID->fetch(PDO::FETCH_ASSOC)) {        
			$queryBadgeLevel = $db->prepare("SELECT modBadgeLevel FROM roles WHERE roleID = :roleID");
			$queryBadgeLevel->execute([':roleID' => $roleAssignData['roleID']]);	    
			if(($modBadgeLevel = $queryBadgeLevel->fetchColumn() ?? 0) >= 1 && $modBadgeLevel <= 3) {
				$badgeImg = '<img src="https://raw.githubusercontent.com/Fenix668/GMDprivateServer/master/dashboard/modBadge_0' . $modBadgeLevel . '_001.png" alt="badge" style="width: 34px; height: 34px; margin-left: -3px; margin-top: -3px; vertical-align: middle;">';
			}
		}
		// Color management
		$queryColorLevel = $gs->getAccountCommentColor($extIDvalue);	
		return '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile big">
				<div style="display:flex">
					<p class="profilenick big" onclick="a(\'profile/'.$commentAccountName.'\', true, true)">'.$avatarImg.$commentAccountName.$badgeImg.$percentText.'</p>
					<div class="delete-comment-div">'.$deleteComment.'<p class="profilelikes big">'.$stats.'</p></div>
				</div>
				<h3 class="profilemsg big"'.($queryColorLevel != '255,255,255' ? ' style="color:rgb('.$queryColorLevel.');"' : '').'>'.$commentMessage.'</h3>
				<h3 class="comments big">
					<text>'.$this->getLocalizedString("ID").': '.$commentIDDiv.'</text>
					<text>'.$this->convertToDate($comment['timestamp'], true).'</text>
				</h3>
			</div>
		</div>';
	}
	public function generateLeaderboardsCard($x, $leaderboard, $action, $leaderboardDeleteCheck = false, $stats = '') {
		global $dbPath;
		global $iconsRendererServer;
		require __DIR__."/../".$dbPath."incl/lib/connection.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
		$gs = new mainLib();
		switch($x) {
			case 1:
				$place = '<i class="fa-solid fa-trophy" style="color:#ffd700;"> 1</i>';
				break;
			case 2:
				$place = '<i class="fa-solid fa-trophy" style="color:#c0c0c0;"> 2</i>';
				break;
			case 3:
				$place = '<i class="fa-solid fa-trophy" style="color:#cd7f32;"> 3</i>';
				break;
			default:
				$place = '<i class="fa" style="color:white;"># '.$x.'</i>';
				break;
		}
		if($leaderboardDeleteCheck) $deleteLeaderboard = '<button onclick="a(\'stats/'.($action['levelLength'] != 5 ? 'level' : 'platformer').'Leaderboards.php?levelID='.$leaderboard['levelID'].'\', true, true, \'POST\', false, \'deleteLeaderboard\')" style="color:#ffbbbb;margin-left:5px;width:max-content;padding:7px 10px;font-size:15px"  class="btn-rendel">
			<i class="fa-solid fa-xmark"></i>
			<form name="deleteLeaderboard" style="display: none;">
				<input type="hidden" name="deleteLeaderboardID" value="'.($action['levelLength'] != 5 ? $leaderboard['scoreID'] : $leaderboard['ID']).'"></input>
			</form>
		</button>';
		// Avatar management
		$avatarImg = '';
		$extIDvalue = $action['extID'];
		$query = $db->prepare('SELECT userName, iconType, color1, color2, color3, accGlow, accIcon, accShip, accBall, accBird, accDart, accRobot, accSpider, accSwing, accJetpack FROM users WHERE extID = :extID');
		$query->execute(['extID' => $extIDvalue]);
		$userData = $query->fetch(PDO::FETCH_ASSOC);
		if($userData) {
			$iconType = ($userData['iconType'] > 8) ? 0 : $userData['iconType'];
			$iconTypeMap = [0 => ['type' => 'cube', 'value' => $userData['accIcon']], 1 => ['type' => 'ship', 'value' => $userData['accShip']], 2 => ['type' => 'ball', 'value' => $userData['accBall']], 3 => ['type' => 'ufo', 'value' => $userData['accBird']], 4 => ['type' => 'wave', 'value' => $userData['accDart']], 5 => ['type' => 'robot', 'value' => $userData['accRobot']], 6 => ['type' => 'spider', 'value' => $userData['accSpider']], 7 => ['type' => 'swing', 'value' => $userData['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userData['accJetpack']]];
			$iconValue = isset($iconTypeMap[$iconType]) ? $iconTypeMap[$iconType]['value'] : 1;	    
			$avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userData['color1'] . '&color2=' . $userData['color2'] . ($userData['accGlow'] != 0 ? '&glow=' . $userData['accGlow'] . '&color3=' . $userData['color3'] : '') . '" alt="Avatar" style="width: 30px; height: 30px; vertical-align: middle; object-fit: contain;">';
		}
		return '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
				<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;">
					<button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'GET\')">
						<div class="acclistdiv">
							<h2 style="color:rgb('.$gs->getAccountCommentColor($userid).'); align-items: baseline;" class="profilenick acclistnick">
								<div class="accounts-badge-icon-div">'.$place.$action["userName"].$avatarImg.'</div>
							</h2>
						</div>
					</button>'.$deleteLeaderboard.'
				</div>
				<div class="form-control song-info" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
				<div class="acccomments"><h3 class="comments" style="margin: 0px;width: max-content;">'.$this->getLocalizedString("accountID").': <b>'.$extIDvalue.'</b></h3><h3 class="comments" style="margin: 0px;width: max-content;">'.$this->getLocalizedString("date").': <b>'.$this->convertToDate($leaderboard['uploadDate'], true).'</b></h3></div>
		</div></div>';
	}
	public function parseMessage($body) {
		global $dbPath;
		require __DIR__."/../".$dbPath."incl/lib/connection.php";
		require_once __DIR__."/../".$dbPath."incl/lib/exploitPatch.php";
		$parseBody = explode(' ', $body);
		$playersFound = $levelsFound = [];
		foreach($parseBody AS &$element) {
			$firstChar = mb_substr($element, 0, 1);
			if(!in_array($firstChar, ['@', '#'])) continue;
			$element = mb_substr($element, 1);
			switch($firstChar) {
				case '@':
					if($playersFound[$element]) break;
					$element = ExploitPatch::charclean($element);
					$check = $db->prepare('SELECT count(*) FROM accounts WHERE userName = :userName AND isActive != 0');
					$check->execute([':userName' => $element]);
					$check = $check->fetchColumn();
					if($check) {
						$body = str_replace('@'.$element, '<span class="messenger-link" onclick="a(\'profile/'.$element.'\', true, true, \'GET\')">@'.$element.'</span>', $body);
						$playersFound[$element] = true;
					}
					break;		
				case '#':
					if(!is_numeric($element) || $levelsFound[$element]) break;
					$check = $db->prepare('SELECT levelName FROM levels WHERE levelID = :levelID AND unlisted = 0 AND unlisted2 = 0');
					$check->execute([':levelID' => $element]);
					$check = $check->fetchColumn();
					if($check) {
						$body = str_replace('#'.$element, '<span class="messenger-link" onclick="a(\'stats/levelsList.php?search='.$check.'\', true, true, \'GET\')">#'.htmlspecialchars($check).'</span>', $body);
						$levelsFound[$element] = true;
					}
					break;					
			}
		}
		return $body;
	}
	public function generateSongCard($song, $extraLabels = '', $includeAuthor = true) {
		global $dbPath;
		require __DIR__."/../".$dbPath."incl/lib/connection.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
		$gs = new mainLib();
		$fontsize = 27;
		$modCheck = $gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs");
		$check = $modCheck ?: ($_SESSION['accountID'] != 0 && $_SESSION['accountID'] == $song['reuploadID']);
		$songsid = $song["ID"];
		$songIDlol = '<button id="copy'.$song["ID"].'" class="accbtn songidyeah" onclick="copysong('.$song["ID"].')">'.$song["ID"].'</button>';
		$time = $this->convertToDate($song["reuploadTime"], true);
		$who = '<button type="button" onclick="a(\'profile/'.$gs->getAccountName($song['reuploadID']).'\', true, true, \'POST\')" style="margin:0;font-size:20px" class="accbtn songacc" name="accountID" value="'.$song["reuploadID"].'">'.$gs->getAccountName($song['reuploadID']).'</button>';
		$author = htmlspecialchars(ExploitPatch::rucharclean($song["authorName"]));
		$name = htmlspecialchars(ExploitPatch::rucharclean($song["name"]));
		$size = $song["size"];
		$download = str_replace('http://', 'https://', $song["download"]);
		if($_SESSION["accountID"] != 0) {
			$favourites = $db->prepare("SELECT * FROM favsongs WHERE songID = :id AND accountID = :aid");
			$favourites->execute([':id' => $songsid, ':aid' => $_SESSION["accountID"]]);
			$favourites = $favourites->fetch();
			if(!empty($favourites)) $favs = '<button title="'.$this->getLocalizedString("dislikeSong").'" id="like'.$songsid.'" value="1" style="display:contents;cursor:pointer" onclick="likeSong('.$songsid.')"><i id="likeicon'.$songsid.'" class="fa-solid fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>'; 
			else $favs = '<button title="'.$this->getLocalizedString("likeSong").'" id="like'.$songsid.'" onclick="likeSong('.$songsid.')" value="0" style="display:contents;cursor:pointer"><i id="likeicon'.$songsid.'" class="fa-regular fa-heart" style="font-size: 25px;color:#ff5c5c"></i></button>';
		}
		if($song["reuploadID"] == 0) {
			$time = "<div style='color:gray'>Newgrounds</div>";
			$who = "<a style='color:#a7a7ff;font-size: 20px;' class='songacc' target='_blank' href='https://".$author.".newgrounds.com/audio';>".$author."</a>";
			$btn = '<button type="button" title="'.$songsid.'.mp3" style="display: contents;color: #ffb1ab;margin: 0;"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i class="fa-solid fa-xmark" aria-hidden="false"></i></div></button>';
		} else $btn = '<button type="button" name="btnsng" id="btn'.$songsid.'" title="'.$author.' - '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$songsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$songsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
		$isDisabled = $song['isDisabled'] != 0;
		if($check) $manage = '<a style="margin-left:5px;width:max-content;color:white;padding:8px;font-size:13px" class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-pencil"></i></a><div onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;transform: translate3d(971px, 200px, 0px);will-change: transform;">
				 <form class="form__inner" method="post" name="songrename'.$songsid.'" style="grid-gap: 10px;">
					<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$songsid.'"></div>
					<div class="field" style="display:none"><input type="hidden" name="page" value="'.$actualpage.'"></div>
					<div class="field"><input type="text" name="author" id="p1" value="'.$author.'" placeholder="'.$author.'"></div>
					<div class="field"><input type="text" name="name" id="p2" value="'.$name.'" placeholder="'.$name.'"></div>
					<button type="button" class="btn-song" id="submit" onclick="renameSong('.$songsid.')">'.$this->getLocalizedString("change").'</button>
					'.($modCheck ? 
						($isDisabled ? '<button id="songDisableButton'.$song['ID'].'" style="width: 85%" type="button" class="btn-song" onclick="disableSong('.$songsid.', false)">'.$this->getLocalizedString("enable").'</button>'
						: '<button id="songDisableButton'.$song['ID'].'" style="width: 85%" type="button" class="btn-song" onclick="disableSong('.$songsid.', false)">'.$this->getLocalizedString("disable").'</button>')
					: '').'
					<button style="width: 70%" type="button" class="btn-song btn-size" onclick="deleteSong('.$songsid.')">'.$this->getLocalizedString("delete").'</button>
				</form>
			</div>';
		if(mb_strlen($author) + mb_strlen($name) > 30) $fontsize = 17;
		elseif(mb_strlen($author) + mb_strlen($name) > 20) $fontsize = 20;
		$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$song["size"].' MB</p>';
		if($includeAuthor) $who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-user-plus"></i> '.$who.'</p>';
		else {
			$isDisabledText = !$isDisabled ? $this->getLocalizedString('songIsAvailable') : $this->getLocalizedString('songIsDisabled');
			$isDisabledIcon = !$isDisabled ? 'check' : 'xmark';
			$who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i id="songDisableIcon'.$song['ID'].'" class="fa-solid fa-'.$isDisabledIcon.'"></i> <span id="songDisableText'.$song['ID'].'">'.$isDisabledText.'</span></p>';
		}
		$stats = $songSize.$who.$extraLabels;
		return '<div id="songCard'.$song['ID'].'" style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
				<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
					<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick"><text id="songname'.$songsid.'">'.$author.' — '.$name.'</text>'.$btn.'</h2>'.$favs.$manage.'
				</div></div>
				<div class="form-control song-info" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
				<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$this->getLocalizedString("songIDw").': <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$this->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
			</div></div>';
	}
	public function generateSFXCard($sfx, $extraLabels = '', $includeAuthor = true) {
		global $dbPath;
		require __DIR__."/../".$dbPath."incl/lib/connection.php";
		require_once __DIR__."/../".$dbPath."incl/lib/mainLib.php";
		$gs = new mainLib();
		$fontsize = 27;
		$modCheck = $gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs");
		$check = $modCheck ?: ($_SESSION['accountID'] != 0 && $_SESSION['accountID'] == $song['reuploadID']);
		$sfxsid = $sfx["ID"];
		$songIDlol = '<button id="copy'.$sfx["ID"].'" class="accbtn songidyeah" onclick="copysong('.$sfx["ID"].')">'.$sfx["ID"].'</button>';
		$time = $this->convertToDate($sfx["reuploadTime"], true);
		$who = '<button type="button" onclick="a(\'profile/'.$gs->getAccountName($sfx['reuploadID']).'\', true, true, \'POST\')" style="margin:0;font-size:20px" class="accbtn songacc" name="accountID" value="'.$sfx["reuploadID"].'">'.$gs->getAccountName($sfx['reuploadID']).'</button>';
		$author = htmlspecialchars($sfx["authorName"]);
		$name = htmlspecialchars($sfx["name"]);
		$size = round($sfx["size"] / 1024 / 1024, 2);
		$download = str_replace('http://', 'https://', $sfx["download"]);
		$btn = '<button type="button" name="btnsng" id="btn'.$sfxsid.'" title="'.$author.' — '.$name.'" style="display: contents;color: white;margin: 0;" download="'.$download.'" onclick="btnsong(\''.$sfxsid.'\');"><div class="icon" style="font-size:13px; height:25px;width:25px;background:#373A3F;margin-left: 5px;"><i id="icon'.$sfxsid.'" name="iconlol" class="fa-solid fa-play" aria-hidden="false"></i></div></button>';
		$isDisabled = $sfx['isDisabled'] != 0;
		if($check) $manage = '<a style="margin-left:5px;width:max-content;color:white;padding:8px;font-size:13px" class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-pencil"></i></a><div onclick="event.stopPropagation()" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;left: 0px;position: absolute;transform: translate3d(971px, 200px, 0px);will-change: transform;">
				 <form class="form__inner" method="post" name="songrename'.$sfxsid.'" style="grid-gap: 10px;">
					<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$sfxsid.'"></div>
					<div class="field" style="display:none"><input type="hidden" name="page" value="'.$actualpage.'"></div>
					<div class="field"><input type="text" name="name" id="p2" value="'.$name.'" placeholder="'.$name.'"></div>
					<input type="hidden" name="sfx" value="1"></input>
					<button type="button" class="btn-song" id="submit" onclick="renameSong('.$sfxsid.', true)">'.$this->getLocalizedString("change").'</button>
					'.($modCheck ? 
						($isDisabled ? '<button id="songDisableButton'.$sfx['ID'].'" style="width: 85%" type="button" class="btn-song" onclick="disableSong('.$sfxsid.', true)">'.$this->getLocalizedString("enable").'</button>'
						: '<button id="songDisableButton'.$sfx['ID'].'" style="width: 85%" type="button" class="btn-song" onclick="disableSong('.$sfxsid.', true)">'.$this->getLocalizedString("disable").'</button>')
					: '').'
					<button style="width: 70%" type="button" class="btn-song btn-size" onclick="deleteSong('.$sfxsid.', true)">'.$this->getLocalizedString("delete").'</button>
				</form>
			</div>';
		if(mb_strlen($name) > 30) $fontsize = 17;
		elseif(mb_strlen($name) > 20) $fontsize = 20;
		$songSize = '<p class="profilepic"><i class="fa-solid fa-weight-hanging"></i> '.$size.' MB</p>';
		if($includeAuthor) $who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-user-plus"></i> '.$who.'</p>';
		else {
			$isDisabledText = !$isDisabled ? $this->getLocalizedString('songIsAvailable') : $this->getLocalizedString('songIsDisabled');
			$isDisabledIcon = !$isDisabled ? 'check' : 'xmark';
			$who = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i id="songDisableIcon'.$sfx['ID'].'" class="fa-solid fa-'.$isDisabledIcon.'"></i> <span id="songDisableText'.$sfx['ID'].'">'.$isDisabledText.'</span></p>';
		}
		$stats = $songSize.$who.$extraLabels;
		return '<div id="songCard'.$sfx['ID'].'" style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><div style="display: flex;width: 100%; justify-content: space-between;align-items: center;">
				<h2 style="margin: 0px;font-size: '.$fontsize.'px;margin-left:5px;display: flex;align-items: center;" class="profilenick"><text id="songname'.$sfxsid.'">'.$name.'</text>'.$btn.'</h2>'.$favs.$manage.'
			</div></div>
			<div class="form-control song-info" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div style="display: flex;justify-content: space-between;margin-top: 10px;"><h3 id="comments" class="songidyeah" style="margin: 0px;width: max-content;align-items: center;">'.$this->getLocalizedString("sfxID").': <b>'.$songIDlol.'</b></h3><h3 id="comments" class="songidyeah"  style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$this->getLocalizedString("date").': <b>'.$time.'</b></h3></div>
		</div></div>';
	}
	public function generateBottomRow($pagecount, $actualpage) {
		$pageminus = $actualpage - 1;
		$pageplus = $actualpage + 1;
      	if($pagecount < 2) return '';
		$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
		$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
		$ng = strpos($_SERVER["REQUEST_URI"], '/songList.php') ? '<form method="get" style="margin:0"><input type="hidden" name="ng" value="1"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 6)" style="margin-right: 10px;border-radius: 500px;" class="btn btn-outline-secondary" type="submit" name="ng" value="1">Newgrounds?</button></form>' : '';
		$inputSearch = !empty($_GET["search"]) ? '<input type="hidden" name="search" value="'.$_GET["search"].'">' : '';
		if(!empty($_GET["type"] OR !empty($_GET["who"]))) $inputSearch .= '<input type="hidden" name="type" value="'.$_GET["type"].'"><input type="hidden" name="who" value="'.$_GET["who"].'">';
		if(!empty($_GET["ng"])) $inputSearch .= '<input type="hidden" name="ng" value="'.$_GET["ng"].'">';
		if(!empty($_GET["levelID"])) $inputSearch .= '<input type="hidden" name="levelID" value="'.$_GET["levelID"].'">';
		if($_GET["ng"] == 1) $ng = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 6)" name="ng" value="0" class="btn btn-outline-secondary" style="border-radius:500px;font-size:20px;margin-right:10px;display: flex;margin-left: 0px;align-items: center;justify-content: center;color: indianred; text-decoration:none"><i class="fa-solid fa-xmark"></i></button>';
		$bottomrow = '<div class="page-buttons">'.sprintf($this->getLocalizedString("pageInfo"), $actualpage, $pagecount).'<div class="btn-group" style="margin-left:auto; margin-right:0; z-index:1; bottom: 50px;">'.$ng.'
		<form method="get" style="margin:0">'.$inputSearch.'<input type="hidden" name="page" value="1"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 5)" name="page" id="first" style="border-top-right-radius:0px !important;border-bottom-right-radius:0px !important;border-radius:500px" value=1 class="btn btn-outline-secondary"><i class="fa-solid fa-backward" aria-hidden="true"></i></button></form>
		<form method="get" style="margin:0">'.$inputSearch.'<input type="hidden" name="page" value="'.$pageminus.'"><button style="border-radius:0" name="page" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 4)" id="prev" value='. $pageminus .' class="btn btn-outline-secondary"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button></form>
		<button class="btn btn-outline-secondary" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">..</button>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="padding:17px 17px 4px 17px;">
				<form action="" method="get">
					<div class="form-group">
					'.$inputSearch.'
						<input type="text" class="form-control" name="page" placeholder="'.$this->getLocalizedString("page").'"></div>
					<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 3)" class="btn btn-primary">'.$this->getLocalizedString("go").'</button>
				</form>
			</div><form method="get" style="margin:0">'.$inputSearch.'<input type="hidden" name="page" value="'.$pageplus.'"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 2)" name="page" style="border-radius:0px"  id="next" class="btn btn-outline-secondary"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button></form>
		<form method="get" style="margin:0;">'.$inputSearch.'<input type="hidden" name="page" value="'.$pagecount.'"><button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 1)" name="page" id="last" style="border-top-left-radius:0px !important;border-bottom-left-radius:0px !important;border-radius:500px" value='. $pagecount .' class="btn btn-outline-secondary"><i class="fa-solid fa-forward" aria-hidden="true"></i></button></form>
		</div></div><script id="bottomrowscript">
			var pagecount = '.$pagecount.';
			var actualpage = '.$actualpage.';
			if(actualpage == 1) {
				document.getElementById("first").disabled = true;
				document.getElementById("prev").disabled = true;
			}
			if(pagecount == actualpage) {
				document.getElementById("last").disabled = true;
				document.getElementById("next").disabled = true;
			}
			</script>';
		return $bottomrow;
	}
	public function title($title) {
      	global $gdps;
		echo '<title>'.$title.' | '.$gdps.'</title>';
	}
}
?>