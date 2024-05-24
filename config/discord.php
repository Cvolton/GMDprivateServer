<?php
/*
	This is your Discord bot's configuration
	
	$discordEnabled — true to enable Discord bot connection, false to disable
	$secret — Your bot's secret code
	$bottoken — Your bot's token
	
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
		$likeEmoji — Custom like emoji (👍)
		$dislikeEmoji — Custom dislike emoji (👎)
		$downloadEmoji — Custom download emoji (⤵️)
		$tadaEmoji — Custom tada emoji (🎉)
		$sobEmoji — Custom sob emoji (😭)
	
	Embed config:
		$authorURL — URL to open when author text is clicked
		$authorIconURL — Author icon URL
		$rateTitleURL — URL to open when rate/unrate title text is clicked
		$demonlistTitleURL — URL to open when demonlist title text is clicked
		$linkTitleURL — URL to open when account linking title text is clicked
		$successColor — Color for succeeded actions (rate, demonlist record approve, unban)
		$failColor — Color for failed actions (unrate, demonlist record deny, ban)
		$pendingColor — Color for pending actions (demonlist record submit)
		$dailyColor — Color for daily webhooks
		$weeklyColor — Color for weekly webhooks
		$eventColor — Color for event webhooks
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
$webhooksToEnable = ["rate", "suggest", "demonlist", "ban", "daily"];
$rateWebhook = "";
$suggestWebhook = "";
$dlWebhook = "";
$dlApproveWebhook = "";
$banWebhook = "";
$dailyWebhook = "";
$dmNotifications = false;

$webhookLanguage = 'EN'; // Country codes (caps lock), translations are available in the webhooks/langs folder

// Set custom emojis for your webhooks here!
$likeEmoji = ":+1:";
$dislikeEmoji = ":-1:";
$downloadEmoji = ":arrow_heading_down:";
$tadaEmoji = ":tada:";
$sobEmoji = ":sob:";

$difficultiesURL = "https://gcs.icu/WTFIcons/difficulties/"; // URL from where difficulties should be retrieved for rate/send webhooks; DONT FORGET ABOUT THE SLASH AT THE END!

$authorURL = "";
$authorIconURL = "";
$rateTitleURL = "";
$demonlistTitleURL = "";
$linkTitleURL = "";
$successColor = "BBFFBB"; // optional, if you leave it blank you will enable automatic colors for the webhook based on the difficulty of the level
$failColor = "FFBBBB";
$pendingColor = "FFCCBB";
$dailyColor = "FF9999";
$weeklyColor = "CACACA";
$eventColor = "EEB3E5";

$footerIconURL = "";
$demonlistThumbnailURL = "";
$demonlistLink = "https://example.com/dashboard/demonlist"; // dont add another slash at the end!
$linkThumbnailURL = "";
$unlinkThumbnailURL = "";
$acceptThumbnailURL = "";
$banThumbnailURL = "";
$unbanThumbnailURL = "";

/* 
	This is the text which will be sent with notifications but outside of embed.
	You can mention roles: <@&role_id>
 	And people: <@user_id>
  	And channels: <#channel_id>
	
	$rateNotificationText — Text to show when rating a level
	$unrateNotificationText — Text to show when unrating a level
	$suggestNotificationText — Text to show when suggesting a level
	$dlsubmitNotificationText — Text to show when submitting new demonlist record
	$dlrecordNotificationText — Text to show when approving/denying  demonlist records
	$banNotificationText — Text to show when banning/unbanning people
	$dailyNotificationText — Text to show when new daily level appears
	$weeklyNotificationText — Text to show when new weekly level appears
	$eventNotificationText — Text to show when new event level appears
*/

$rateNotificationText = "";
$unrateNotificationText = "";
$suggestNotificationText = "";
$dlsubmitNotificationText = "";
$dlrecordNotificationText = "";
$banNotificationText = "";
$dailyNotificationText = "";
$weeklyNotificationText = "";
$eventNotificationText = "";
?>
