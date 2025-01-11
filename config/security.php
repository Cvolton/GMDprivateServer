<?php
$unregisteredSubmissions = false; // false = green accounts can't upload levels, appear on the leaderboards etc; true = green accounts can do everything
$preactivateAccounts = true; // false = accounts need to be activated at dashboard/login/activate.php; true = accounts can log in immediately

$filterUsernames = 2; // 0 = Disabled, 1 = Checks if the username is word, 2 = Checks if the username contains word
$bannedUsernames = [ // Add words to ban if it is a username/if it is in a username
	'RobTop',
	'nig',
	'fag'
];

$filterClanNames = 2; // 0 = Disabled, 1 = Checks if the clan name is word, 2 = Checks if the clan name contains word
$bannedClanNames = [ // Add words to ban if it is a clan name/if it is in a clan name
	'Support',
	'Administration',
	'Moderation',
	'nig',
	'fag'
];

$filterClanTags = 2; // 0 = Disabled, 1 = Checks if the clan tag is word, 2 = Checks if the clan tag contains word
$bannedClanTags = [ // Add words to ban if it is a clan tag/if it is in a clan tag
	'ADMIN',
	'MOD',
	'nig',
	'fag'
];

/*
	Captcha settings
	Supports: hCaptcha, reCaptcha, Cloudflare Turnstile (why not!)
	hCaptcha: https://www.hcaptcha.com/
	reCaptcha: https://www.google.com/recaptcha/
	Cloudflare Turnstile: https://www.cloudflare.com/products/turnstile/
*/

$enableCaptcha = false;
$captchaType = 1; // 1 for hCaptcha, 2 for reCaptcha and 3 for CF-Turnstile
$CaptchaKey = "";
$CaptchaSecret = "";

/*
	Block access from free proxies and common VPNs
	Below are URLs for proxies and VPSs
	Should only return list of IPs without any other HTML code
	Syntax: $proxies['NAME OF IPs'] = 'LINK';
*/

$blockFreeProxies = true; // true = check if person uses free proxy
$blockCommonVPNs = true; // true = check if person uses a common VPN
// URLs for IPs of proxies
$proxies['http'] = 'https://fhgdps.com/proxies/http.txt';
$proxies['https'] = 'https://fhgdps.com/proxies/https.txt';
$proxies['socks4'] = 'https://fhgdps.com/proxies/socks4.txt';
$proxies['socks5'] = 'https://fhgdps.com/proxies/socks5.txt';
$proxies['unknown'] = 'https://fhgdps.com/proxies/unknown.txt';
// URLs for IP ranges of VPNs
$vpns['vpn'] = 'https://raw.githubusercontent.com/X4BNet/lists_vpn/main/output/vpn/ipv4.txt';

/*
	GDPS automod config

	$warningsPeriod — period of time in seconds, when new warnings of same type won't show to prevent warn spamming

	$levelsCountModifier — modifier to yesterday levels count to avoid small levels increase warning
		if(Levels today > Levels yesterday * Levels modifier) WARNING;
	$levelsCheckPeriod — what period of time in seconds to check
	
	$accountsCountModifier — modifier to yesterday accounts count to avoid small accounts increase warning
		if(Accounts today > Accounts yesterday * Accounts modifier) WARNING;
	$accountsCheckPeriod — what period of time in seconds to check
	
	$commentsCheckPeriod — comments posted in this period of time in seconds will be checked
		600 is 10 minutes, so comments posted in last 10 minutes would be checked
*/

$warningsPeriod = 86400;

$levelsCountModifier = 1.3;
$levelsCheckPeriod = 86400;

$accountsCountModifier = 1.3;
$accountsCheckPeriod = 86400;

$commentsCheckPeriod = 600;
?>
