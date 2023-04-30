<?php
$installed = false; // DON'T CHANGE IT! It changes automatically

$gdps = "GDPS"; // Used to title and download
$lrEnabled = 1; // 1 = Level reupload enabled, 0 = disabled
$msgEnabled = 1; // 1 = Messenger enabled, 0 = disabled
$clansEnabled = 1; // 1 = Clans enabled, 0 = disabled
$songEnabled = 12; // 0 = Song reupload disabled, add 1 to enable song file reupload, add 2 to enable song link reupload
$songSize = 8; // Max song size in megabytes (i don't recommend setting this value too high)
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

$vk = ''; // Как https://vk.com/*твой вк*
$discord = ''; // Like https://discord.gg/*discord invite*
$twitter = ''; // I don't have twitter
$youtube = ''; // Like https://youtube.com/channel/*your channel id* or https://youtube.com/c/*your channel name*
$twitch = ''; // Like https://twitch.tv/*your twitch*

// Third-party resourses, fill it if you use something (mods, textures, etc). Syntax of this thing is: array('AVATAR', 'USERNAME', 'SOCIAL OF THIS USER', 'What this person did (optionally)');

$thirdParty[] = array('https://yt3.googleusercontent.com/EZ149IVvU5JX2Fi6yH7R95NQmKdNsea_gggEvJXA0MIZQ397E_WHLLNCgBjL45npnMZNUkpq=s88-c-k-c0x00ffffff-no-rj', 'RobTop', 'https://store.steampowered.com/app/322170/Geometry_Dash/', 'For Geometry Dash');
$thirdParty[] = array('https://avatars.githubusercontent.com/u/5721187', 'Cvolton', 'https://github.com/Cvolton', 'For GDPS code');
$thirdParty[] = array('https://avatars.githubusercontent.com/u/52624723', 'Foxodever', 'https://github.com/foxodever/BetterCvoltonGDPS/blob/main/tools/songs/upload.php', 'For file upload script');
?>