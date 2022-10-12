<?php
$sessionGrants = true; //false = GJP check is done every time; true = GJP check is done once per hour; significantly improves performance, slightly descreases security
$unregisteredSubmissions = false; //false = green accounts can't upload levels, appear on the leaderboards etc; true = green accounts can do everything
$preactivateAccounts = true; //false = accounts need to be activated at tools/account/activateAccount.php; true = accounts can log in immediately
$activeBanIP = false; //false = passive banip check (like cvolton's one), true = active banip check (ip check every connection to gdps)

/*
	Captcha settings
	Currently the only supported provider is hCaptcha
	https://www.hcaptcha.com/
*/
$enableCaptcha = false;
$hCaptchaKey = "";
$hCaptchaSecret = "";
