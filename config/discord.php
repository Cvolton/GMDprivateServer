<?php
/*
	This is your Discord bot's configuration
	
	$discordEnabled — true to enable Discord bot connection, false to disable
	$secret — Your bot's secret code
	$bottoken —Your bot's token
	
	If you want DM notifications, this is required
*/
$discordEnabled = false;
$secret = "";
$bottoken = "";
/*
	This is Discord webhooks configuration
	
	$webhooksEnabled — true to enable rate webhooks, false to disable
	$webhooksToEnable — What webhooks you want to enable
	Current available webhooks: rate — rate/unrate webhooks, suggest — suggested levels, demonlist —demonlist records, ban — bans/unbans
	
	Rates:
		$rateWebhook — Webhook link to channel you want to send rates to (PLAYER)
		$suggestWebhook — Webhook link to channel you want to send moderators suggest requests to (MOD)
	Demonlist:
		$dlWebhook — Webhook link to channel you want to send demonlist approving or denying results (PLAYER)
		$dlApproveWebhook — Webhook link to channel you want to send demonlist links for approving or denying (MOD)
	Bans:
		$banWebhook — Webhook link to channel you want to send ban/unban messages
		
	$dmNotifications — true to enable rates and demonlist notifications to player DMs (if he connected his Discord account with in-game account), false to disable
	
	$webhookLanguage — Language webhook will use
	Current available languages: EN — English (English), RU — Russian (Русский), TR — Turkish (Türkçe), UA — Ukrainian (Українська), FR — French (Français) and ES — Spanish (Español)
	
	Emojis:
		$likeEmoji — Custom like emoji ()
		$dislikeEmoji — Custom dislike emoji ()
		$downloadEmoji — Custom download emoji ()
		$tadaEmoji — Custom tada emoji ()
		$sobEmoji — Custom sob emoji ()
	
	Embed config:
		$authorURL — URL to open when author text is clicked
		$authorIconURL — Author icon URL
		$rateTitleURL — URL to open when rate/unrate title text is clicked
		$demonlistTitleURL — URL to open when demonlist title text is clicked
		$linkTitleURL — URL to open when account linking title text is clicked
		$successColor — Color for succeeded actions (rate, demonlist record approve, unban)
		$failColor — Color for failed actions (unrate, demonlist record deny, ban)
		$pendingColor — Color for pending actions (demonlist record submit)
		$footerIconURL — Footer icon URL
		$demonlistThumbnailURL — Image to show for demonlist record submit
		$demonlistLink — link to dashboard's demonlist page
		$linkThumbnailURL — Image to show for account linking
		$unlinkThumbnailURL — Image to show for account unlinking
		$acceptThumbnailURL — Image to show for accepting account linking
		$banThumbnailURL — Image to show for banning players
		$unbanThumbnailURL — Image to show for unbanning players
*/
$webhooksEnabled = false;
$webhooksToEnable = ["rate", "suggest", "demonlist", "ban"];
$rateWebhook = "";
$suggestWebhook = "";
$dlWebhook = "";
$dlApproveWebhook = "";
$banWebhook = "";
$dmNotifications = true;

$webhookLanguage = 'EN';
$likeEmoji = ":+1:";
$dislikeEmoji = ":-1:";
$downloadEmoji = ":arrow_heading_down:";
$tadaEmoji = ":tada:";
$sobEmoji = ":sob:";
$authorURL = "";
$authorIconURL = "";
$rateTitleURL = "";
$demonlistTitleURL = "";
$linkTitleURL = "";
$successColor = "BBFFBB";
$failColor = "FFBBBB";
$pendingColor = "FFCCBB";
$footerIconURL = "";
$demonlistThumbnailURL = "";
$demonlistLink = "https://example.com/dashboard/demonlist"; // dont add another slash at the end!
$linkThumbnailURL = "";
$unlinkThumbnailURL = "";
$acceptThumbnailURL = "";
$banThumbnailURL = "";
$unbanThumbnailURL = "";

// Here you can set role IDs for webhooks which will be mentioned
$rateNotificationRole = "";
$suggestNotificationRole = "";
$dlsubmitNotificationRole = ""; // new submits
$dlrecordNotificationRole = ""; // approved/denied submits
$banNotificationRole = "";
?>
?>
