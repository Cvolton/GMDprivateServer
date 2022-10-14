<?php
$installed = true;

$gdps = "GreenCatsServer"; // Used to title and download
$lrEnabled = 0; // 1 = Level reupload enabled, 0 = disabled
$msgEnabled = 1; // 1 = Messenger enabled, 0 = disabled
$songEnabled = 12; // 0 = Song reupload disabled, add 1 to enable song file reupload, add 2 to enable song link reupload
$songSize = 12; // Max song size in megabytes (i don't recommend setting this value too high)
 
// Below are external download links, disabled when you have gdpsName.gdpsFileType in dashboard/download directory

$pc = '';
$mac = '';
$android = '';
$ios = '';

// Below is footer socials settings, leave empty to disable

$vk = 'https://vk.com/suetin2006'; // Как https://vk.com/*твой вк*
$discord = 'https://discord.gcs.icu'; // Like https://discord.gg/*discord invite*
$twitter = 'https://vk.cc/8U7VuC'; // I don't have twitter
$youtube = 'https://youtube.com/c/МегаСвятой'; // Like https://youtube.com/channel/*your channel id* or https://youtube.com/c/*your channel name*
$twitch = 'https://twitch.tv/megasa1nt'; // Like https://twitch.tv/*your twitch*
?>