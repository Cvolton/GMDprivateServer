<?php
$installed = false; // DON'T CHANGE IT! It changes automatically

$gdps = "GDPS"; // Used to title and download
$lrEnabled = 1; // 1 = Level reupload enabled, 0 = disabled
$msgEnabled = 1; // 1 = Messenger enabled, 0 = disabled
$clansEnabled = 1; // 1 = Clans enabled, 0 = disabled
$songEnabled = 12; // 0 = Song reupload disabled, add 1 to enable song file reupload, add 2 to enable song link reupload
$sfxEnabled = 1; // 0 = SFX upload disabled, 1 = enabled
$convertEnabled = 1; // 1 = Convert SFX to OGG enabled, 0 = disabled
$songSize = 8; // Max song size in megabytes
$sfxSize = 4.5; // Max SFX size in megabytes
$timeType = 1; // How time will show in-game, 0 - default Cvolton time, 1 - Dashboard-like time, 2 - RobTop-like time
$dashboardIcon = '/dashboard/icon.png'; // Icon at the top left of dashboard, can be link
$dashboardFavicon = '/dashboard/icon.png'; // Icon in browser's tab, can be link
$preenableSongs = true; // true = songs are enabled when reuploading, false = song must be enabled through dashboard/stats/disabledSongsList.php in order to use it
$preenableSFXs = true; // true = SFXs are enabled when reuploading, false = SFX must be enabled through dashboard/stats/disabledSFXsList.php in order to use it
// If you changed dashboard's place, change $dbPath in dashboard/incl/dashboardLib.php

// External download links, disables when you have gdpsName.gdpsFileType in dashboard/download directory

$pc = '';
$mac = '';
$android = '';
$ios = '';

// Launcher executable names (like "launcher.exe"), place them to dashboard/download folder

$pcLauncher = "";
$macLauncher = "";
$androidLauncher = "";
$iosLauncher = "";

// Footer socials settings, leave empty to disable

$vk = ''; // Link to your VK page
$discord = ''; // Link to your Discord server
$twitter = ''; // Link to your Twitter/X page
$youtube = ''; // Link to your YouTube channel
$twitch = ''; // Link to your Twitch channel

// Third-party resourses, fill it if you use something (mods, textures, etc). Syntax of this thing is: array('AVATAR', 'USERNAME', 'SOCIAL OF THIS USER', 'What this person did (optionally)');

$thirdParty[] = array('https://yt3.googleusercontent.com/EZ149IVvU5JX2Fi6yH7R95NQmKdNsea_gggEvJXA0MIZQ397E_WHLLNCgBjL45npnMZNUkpq=s88-c-k-c0x00ffffff-no-rj', 'RobTop', 'https://store.steampowered.com/app/322170/Geometry_Dash/', 'For Geometry Dash');
$thirdParty[] = array('https://avatars.githubusercontent.com/u/5721187', 'Cvolton', 'https://github.com/Cvolton', 'For GDPS code');
$thirdParty[] = array('https://avatars.githubusercontent.com/u/52624723', 'Foxodever', 'https://github.com/foxodever/BetterCvoltonGDPS/blob/main/tools/songs/upload.php', 'For file upload script');

// SFX/Music libraries, syntax is: array(ID (must be unique), LIBRARY NAME, LIBRARY LINK (not to .dat file), LIBRARY TYPE (0 = only SFX, 1 = only music, 2 = both));
// Template: $customLibrary[] = array(1, '', '', 2); 

$customLibrary[] = array(1, 'Geometry Dash', 'https://geometrydashfiles.b-cdn.net', 2); 
$customLibrary[] = array(2, 'GDPSFH', 'https://sfx.fhgdps.com', 0); 
$customLibrary[] = array(3, $gdps, null, 2); // Your GDPS's library, don't remove it
$customLibrary[] = array(4, 'Song File Hub', 'https://api.songfilehub.com', 1);

// SFX converter API links, make one by using code from https://github.com/MegaSa1nt/GDPS-ConvertSFX
// Template: $convertSFXAPI[] = "";

$convertSFXAPI[] = "https://niko.gcs.skin";
$convertSFXAPI[] = "https://lamb.gcs.skin";
$convertSFXAPI[] = "https://omori.gcs.skin"; // You're welcome
$convertSFXAPI[] = "https://im.gcs.skin";
$convertSFXAPI[] = "https://hat.gcs.skin";
$convertSFXAPI[] = "https://converter.m336.dev";

/*
	Level reupload tool
	
	These confing will allow you to customize level reupload tool
	
	$requireAccountForReuploading — if user must enter their account credentials to reupload level
		True — require logging in
		False — don't require to login
	$disallowReuploadingNotUserLevels — if user should be allowed to reupload only their levels
		True — allow reuploading only their levels
		False — allow reuploading any levels
*/

$requireAccountForReuploading = false;
$disallowReuploadingNotUserLevels = false;

/*
	Cobalt API
	
	Use Cobalt API to be able to reupload songs with YouTube links and etc.
	Requires file upload to be enabled!
	
	$useCobalt — Should server use Cobalt to reupload songs by links
		True — use Cobalt
		False — don't use Cobalt

	$cobaltAPI[] — links to Cobalt's APIs
		Server will randomly pick one of Cobalt APIs when reuploading song
		
	Turnstile-protected APIs are currently not supported, sorry
*/

$useCobalt = true;
$cobaltAPI[] = 'https://cobalt.gcs.skin';

/*
	Geometry Dash icons renderer Server
	
	Dashboard shows icons of players, therefore it requires some server to get icons
	
	$iconsRendererServer — what server to use
	
	If gdicon.oat.zone doesn't work for you for some reason, you can use icons.gcs.skin
*/

$iconsRendererServer = 'https://gdicon.oat.zone';
?>
