<?php
session_start();
require "incl/dashboardLib.php";
$dl = new dashboardLib();
require $dbPath."incl/lib/connection.php";
require $dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require $dbPath."config/dashboard.php";
if(!$installed) header('Location: install.php');
if(isset($_GET["installed"])) $install = '<div style="margin-top:20px;margin-bottom:0px;width:80%" class="notify notify-show"><p>'.$dl->getLocalizedString("tipsAfterInstalling").'</p></div>'; 
$dl->printFooter();
$downloadlinks = '';
$name = $gs->getAccountName($_SESSION["accountID"]);
global $pc;
global $mac;
global $android;
global $ios;
global $pcLauncher;
global $macLauncher;
global $androidLauncher;
global $iosLauncher;
if(empty($name)) {
	$namebtn = $dl->getLocalizedString("guest");
	if((file_exists("download/".$gdps.".zip") OR file_exists("../download/".$gdps.".zip")) AND empty($pcLauncher)) $downloadlinks .= '<a class="dropdown-item dontblock" href="download/'.$gdps.'.zip"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forwindows").'</a>';
    elseif(!empty($pcLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$pcLauncher.'"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forwindows").'</a>';
    elseif(!empty($pc)) $downloadlinks .='<a class="dropdown-item dontblock" href="'.$pc.'"><div class="icon"><i class="fa-brands fa-windows" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forwindows").'</a>';
	if((file_exists("download/".$gdps.".dmg") OR file_exists("../download/".$gdps.".dmg")) AND empty($macLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$gdps.'.dmg"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$dl->getLocalizedString("formac").'</a>';
    elseif(!empty($macLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$macLauncher.'"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$dl->getLocalizedString("formac").'</a>';
    elseif(!empty($mac)) $downloadlinks .='<a class="dropdown-item dontblock" href="'.$mac.'"><i class="fa-solid fa-desktop" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -6px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$dl->getLocalizedString("formac").'</a>';
	if((file_exists("download/".$gdps.".apk") OR file_exists("../download/".$gdps.".apk")) AND empty($androidLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$gdps.'.apk"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forandroid").'</a>';
    elseif(!empty($androidLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$androidLauncher.'"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forandroid").'</a>';
    elseif(!empty($android)) $downloadlinks .='<a class="dropdown-item dontblock" href="'.$android.'"><div class="icon"><i class="fa-brands fa-android" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forandroid").'</a>';
	if((file_exists("download/".$gdps.".ipa") OR file_exists("../download/".$gdps.".ipa")) AND empty($iosLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$gdps.'.ipa"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forios").'</a>';
    elseif(!empty($iosLauncher)) $downloadlinks .='<a class="dropdown-item dontblock" href="download/'.$iosLauncher.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forios").'</a>';
    elseif(!empty($ios)) $downloadlinks .='<a class="dropdown-item dontblock" href="'.$ios.'"><i class="fa-solid fa-mobile-screen-button" style="position: absolute;font-size: 10px;margin: 3px 5px 5px -3px;" aria-hidden="false"></i><div class="icon"><i class="fa-brands fa-apple" aria-hidden="false"></i></div>'.$dl->getLocalizedString("forios").'</a>';
	$accountcards = '<button onclick="a(\'login/login.php\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-sign-in"></i></div>'.$dl->getLocalizedString("login").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("loginOptDesc").'</p></div></div></div>
				</button>
				<button onclick="a(\'login/register.php\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><i class="fa-solid fa-plus" style="position: absolute;font-size: 15px;margin: 5px 5px 5px -2px;" aria-hidden="false"></i><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-user"></i></div>'.$dl->getLocalizedString("createAcc").'</h1></div>
					<p class="mpp">'.sprintf($dl->getLocalizedString("registerOptDesc"), $gdps).'</p></div></div></div>
				</button>
				<button onclick="download()" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-download"></i></div>'.$dl->getLocalizedString("download").'</h1></div>
					<p class="mpp">'.sprintf($dl->getLocalizedString("downloadOptDesc"), $gdps).'</p></div></div></div>
				</button>
				<div id="downloadid" style="display:none;font-size: 24px;display: none;grid-gap: 10px;">'.$downloadlinks.'</div>';
} else {
	$namebtn = '<button onclick="a(\'profile/'.$name.'\', true, true, \'GET\')" style="padding:0;font-weight: 900;background:none;border:none;cursor:pointer;color:rgb('.$gs->getAccountCommentColor($_SESSION["accountID"]).')">'.$name.'</button>';
	$accountcards = '<button onclick="a(\'profile/'.$name.'\', true, true, \'GET\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-dungeon"></i></div>'.$dl->getLocalizedString("yourProfile").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("profileOptDesc").'</p></div></div></div>
				</button>
				<button onclick="a(\'messenger\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-comments"></i></div>'.$dl->getLocalizedString("messenger").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("messengerOptDesc").'</p></div></div></div>
				</button>
	<button onclick="a(\'songs\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><i class="fa-solid fa-plus mpsmall" style="position: absolute;font-size: 15px;margin: 5px 5px 5px -2px;" aria-hidden="false"></i><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-music"></i></div>'.$dl->getLocalizedString("songAdd").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("addSongOptDesc").'</p></div></div></div>
				</button>';
}
$claaan = $gs->isPlayerInClan($_SESSION["accountID"]);
if($claaan) {
	$clan = $gs->getClanInfo($claaan);
	$clancard = '<button onclick="a(\'clan/'.$clan["clan"].'\', true, true)" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1" style="color:#'.$clan["color"].'"><div class="icon mph1" style="color:white;font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-dungeon"></i></div>'.$clan["clan"].'</h1></div>
					<p class="mpp">'.sprintf($dl->getLocalizedString("yourClanOptDesc"), $clan["clan"]).'</p></div></div></div>
				</button>';
} else $clancard = '<button onclick="a(\'clans\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-dungeon"></i></div>'.$dl->getLocalizedString("clans").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("clanOptDesc").'</p></div></div></div>
				</button>';
$dl->printSong($install.'<div class="maindiv">
	<h1 class="welcomeh1" style="width:100%;color:white;text-align:center">'.sprintf($dl->getLocalizedString("loginHeader"), "<text style=''>".$namebtn."</text>").'</h1>
	<p class="welcomep" id="bruh">'.$dl->getLocalizedString("welcome").'</p>
	<h3 class="welcomeh3" style="color: white;font-style: italic;">'.$dl->getLocalizedString("wwygdt").'</h3>
	<div class="secondarydiv">
		<div class="form mainlist">
			<p style="font-size: 27px;">'.$dl->getLocalizedString("game").'</p>
			<div style="width:100%;grid-gap: 10px;display: grid;">
				<button onclick="a(\'stats/levelsList.php\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-gamepad"></i></div>'.$dl->getLocalizedString("levels").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("levelsOptDesc").'</p></div></div></div>
				</button>
				<button onclick="a(\'stats/songList.php\')" style="background:none;border:none;cursor:pointer;width: 100%;padding: 0px;border-radius: 30px;"><div class="lilcard"><div class="lilcardcontent"><div style="margin-right: 10px;">
					<div style="display: flex;justify-content: space-between;align-items: center;"><h1 class="mainpagecardh1"><div class="icon mph1" style="font-size: 25px;height: 50px;width: 50px;"><i class="fa-solid fa-music"></i></div>'.$dl->getLocalizedString("songs").'</h1></div>
					<p class="mpp">'.$dl->getLocalizedString("songsOptDesc").'</p></div></div></div>
				</button>
				'.$clancard.'
			</div>
		</div>
		<div class="form mainlist last">
			<p style="font-size: 27px;">'.$dl->getLocalizedString("account").'</p>
			<div style="width:100%;grid-gap: 10px;display: grid;">'.$accountcards.'</div>
		</div>
	</div>
</div>
<script>
	function download() {
		div = document.getElementById("downloadid");
		if(div.style.display == "none") div.style.display = "grid";
		else div.style.display = "none";
	}
</script>', "home", false);
?>