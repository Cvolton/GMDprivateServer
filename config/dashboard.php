<?php
$installed = false;

$gdps = "GDPS"; // Used to title and download
$lrEnabled = 1; // 1 = Level reupload enabled, 0 = disabled
$msgEnabled = 1; // 1 = Messenger enabled, 0 = disabled
$songEnabled = 12; // 0 = Song reupload disabled, add 1 to enable song file reupload, add 2 to enable song link reupload
$songSize = 8; // Max song size in megabytes (i don't recommend setting this value too high)
 
// Below are external download links, disables when you have gdpsName.gdpsFileType in dashboard/download directory

$pc = '';
$mac = '';
$android = '';
$ios = '';

// Below is footer socials settings, leave empty to disable

$vk = ''; // Как https://vk.com/*твой вк*
$discord = ''; // Like https://discord.gg/*discord invite*
$twitter = ''; // I don't have twitter
$youtube = ''; // Like https://youtube.com/channel/*your channel id* or https://youtube.com/c/*your channel name*
$twitch = ''; // Like https://twitch.tv/*your twitch*
?>
