<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/mainLib.php";

$string = "1:1253292:2:13:3:party:4:Rmlyc3QgRm9sbG93ZXIh:5:U29tZW9uZSBpcyBub3cgPGN5PmZvbGxvd2luZzwvYz4geW91IQ==:6:34 minutes:7:1:8:0:9:0:10:geometry.ach.level01b:11:0:12:0:13:0:14:0:15:0:16:#1:0:10";
$stringArray = explode(":", $string);
$stringKeys = [];

for($i = 1; $i < count($stringArray); $i += 2) {
	$stringKeys[$stringArray[$i - 1]] = $stringArray[$i];
}

$notificationID = "112321";
$unknown2 = "0";
$notificationIcon = "keydemon";
$notificationTitle = ExploitPatch::url_base64_encode("Test notification");
$notificationDescription = ExploitPatch::url_base64_encode("This is a test notification. авплроавлыогрвлодпва");
$notificationTime = "15;55";
$notificationIsNew = "1";
$unknown8 = "0";
$unknown9 = "0";
$notificationAchievement = ""; // put achievement ID here to give this achievement to user
$unknown11 = "0";
$unknown12 = "0";
$notificationHasChest = "1";
$notificationChestType = "9"; // > 9 crashes game
$notificationTargetAccountID = "1";

$notificationsArray = [];

for($i = 1; $i < 10; $i++) {
	$notificationsArray[] = "1:".($notificationID + $i).":2:".$unknown2.":3:".$notificationIcon.":4:".$notificationTitle.":5:".$notificationDescription.":6:".$notificationTime.":7:".$notificationIsNew.":8:".$unknown8.":9:".$unknown9.":10:".$notificationAchievement.":11:".$unknown11.":12:".$unknown12.":13:".$notificationHasChest.":14:".$notificationChestType.":15:".$notificationTargetAccountID;
}

exit(implode("|", $notificationsArray)."#1:0:10");
?>