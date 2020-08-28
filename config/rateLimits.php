<?php

//registerGJAccount.php - Registering accounts

$accountsMade = 0; // indicates how many accounts to be made to disable registering accounts, set 0 to disable rate limiting
$accountsDuration = 0; //indicates the duration of the accounts to be made in a certain time to disable registering accounts
$disableAccountRegisterTime = 0; //indicates how much time to registering accounts is disbaled for

//uploadGJLevel.php - Uploading levels

$levelsUploaded = 0; // indicates how many accounts to be made to disable uploading levels, set 0 to disable rate limiting
$levelsDuration = 0; //indicates the duration of the levels to be made in a certain time to disable uploading levels
$disableLevelUploadTime = 0; //indicates how much time to uploading levels is disbaled for

//likeGJItem.php - Liking

$likesDone = 0; // indicates how many accounts to be made to disable liking, set 0 to disable rate limiting
$likesDuration = 0; //indicates the duration of the likes to be made in a certain time to disable uploading levels
$disableLikeTime = 0; //indicates how much time liking is disbaled for


/*
for Duration and Disabling Time
1 = 1 second
60 = 1 minute
300 = 5 minutes
3600 = 1 hour
*/
?>