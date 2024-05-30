<?php
/*
	Welcome to webhooks translation file!
	You're currently at Turkish (Türkçe) language
	Credits: EMREOYUN
 	Will be completed soon
	
	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['New level was rated!', 'New rated level!', 'Someone rated a level!']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['Your level was rated!', 'Someone rated your level!'];
$webhookLang['rateSuccessDesc'] = '%1$s rated a level!'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '%1$s rated your level! %2$s';
$webhookLang['rateFailTitle'] = ['Level was unrated!', 'Someone unrated a level!'];
$webhookLang['rateFailTitleDM'] = ['Your level was unrated!', 'Someone unrated your level!'];
$webhookLang['rateFailDesc'] = '%1$s unrated a level!';
$webhookLang['rateFailDescDM'] = '%1$s unrated your level! %2$s';

$webhookLang['levelTitle'] = 'Bölüm';
$webhookLang['levelDesc'] = '%1$s, %2$s tarafından'; // Name by Creator
$webhookLang['levelIDTitle'] = 'Bölüm ID';
$webhookLang['difficultyTitle'] = 'Zorluk';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s yıldız'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s yıldız'; // Easy, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s yıldız'; // Hard, 5 stars
$webhookLang['difficultyDescMoon0'] = '%1$s, %2$s ay'; // Auto, 1 moon (Platformer)
$webhookLang['difficultyDescMoon1'] = '%1$s, %2$s ay'; // Easy, 2 moons (Platformer)
$webhookLang['difficultyDescMoon2'] = '%1$s, %2$s ay'; // Hard, 5 moons (Platformer)
$webhookLang['statsTitle'] = 'İstatistikler';
$webhookLang['requestedTitle'] = 'Creator requested';
$webhookLang['requestedDesc0'] = '%1$s yıldız'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s yıldız'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s yıldız'; // 5 stars
$webhookLang['requestedDescMoon0'] = '%1$s ay'; // 1 moon (Platformer)
$webhookLang['requestedDescMoon1'] = '%1$s ay'; // 2 moons (Platformer)
$webhookLang['requestedDescMoon2'] = '%1$s ay'; // 5 moons (Platformer)
$webhookLang['descTitle'] = 'Açıklama';
$webhookLang['descDesc'] = '*Açıklama yok*';
$webhookLang['footer'] = '%1$s, oynadığın için teşekkürler!';

$webhookLang['suggestTitle'] = ['Check this level!', 'Level was suggested!', 'Someone suggested a level!'];
$webhookLang['suggestDesc'] = '%1$s suggested a level to rate!';
$webhookLang['footerSuggest'] = '%1$s, thank you for moderating!';

$webhookLang['demonlistTitle'] = ['Yeni rekor!', 'Biri yeni bir rekor paylaştı!'];
$webhookLang['demonlistDesc'] = '%1$s posted their %2$s completion! Link to approve: ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Record author';
$webhookLang['recordAttemptsTitle'] = 'Deneme';
$webhookLang['recordAttemptsDesc0'] = '%1$s deneme'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s deneme'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s deneme'; // 5 attempts
$webhookLang['recordProofTitle'] = 'Proof';
$webhookLang['demonlistApproveTitle'] = ['Record was approved!', 'Someone approved a record!'];
$webhookLang['demonlistApproveTitleDM'] = ['Your record was approved!', 'Someone approved your record!'];
$webhookLang['demonlistApproveDesc'] = '%1$s approved %2$s\'s record of level %3$s!';
$webhookLang['demonlistApproveDescDM'] = '%1$s approved your record of level %2$s!';
$webhookLang['demonlistDenyTitle'] = ['Record was denied!', 'Someone denied a record!'];
$webhookLang['demonlistDenyTitleDM'] = ['Your record was denied!', 'Someone denied your record!'];
$webhookLang['demonlistDenyDesc'] = '%1$s denied %2$s\'s record of level %3$s!';
$webhookLang['demonlistDenyDescDM'] = '%1$s denied your record of level %2$s!';

$webhookLang['accountLinkTitle'] = ['Account linking!', 'Someone wants to link account!'];
$webhookLang['accountLinkDesc'] = 'It seems like %1$s wants to link their in-game account to your Discord account. Post **!discord accept *code*** in your in-game profile to do it. If that\'s not you - **ignore** this message!';
$webhookLang['accountCodeFirst'] = 'First number';
$webhookLang['accountCodeSecond'] = 'Second number';
$webhookLang['accountCodeThird'] = 'Third number';
$webhookLang['accountCodeFourth'] = 'Fourth number';
$webhookLang['accountUnlinkTitle'] = ['Account unlinking!', 'You unlinked your account!'];
$webhookLang['accountUnlinkDesc'] = 'You successfully unlinked %1$s from your Discord account!';
$webhookLang['accountAcceptTitle'] = ['Account linking!', 'You linked your account!'];
$webhookLang['accountAcceptDesc'] = 'You successfully linked %1$s to your Discord account!';

$webhookLang['playerBanTitle'] = ['Player was banned!', 'Someone banned someone!', 'Ban!'];
$webhookLang['playerBanTitleDM'] = ['You were banned!', 'Someone banned you!', 'Ban!'];
$webhookLang['playerUnbanTitle'] = ['Player was unbanned!', 'Someone unbanned someone!', 'Unban!'];
$webhookLang['playerUnbanTitleDM'] = ['You were unbanned!', 'Someone unbanned you!', 'Unban!'];
$webhookLang['playerBanTopDesc'] = '%1$s banned %2$s from players top!';
$webhookLang['playerBanTopDescDM'] = '%1$s banned you from players top.';
$webhookLang['playerUnbanTopDesc'] = '%1$s unbanned %2$s from players top!';
$webhookLang['playerUnbanTopDescDM'] = '%1$s unbanned you from players top!';
$webhookLang['playerBanCreatorDesc'] = '%1$s banned %2$s from creators top!';
$webhookLang['playerBanCreatorDescDM'] = '%1$s banned you from creators top.';
$webhookLang['playerUnbanCreatorDesc'] = '%1$s unbanned %2$s from creators top!';
$webhookLang['playerUnbanCreatorDescDM'] = '%1$s unbanned you from creators top!';
$webhookLang['playerBanUploadDesc'] = '%1$s banned %2$s from uploading levels!';
$webhookLang['playerBanUploadDescDM'] = '%1$s banned uploading levels to you.';
$webhookLang['playerUnbanUploadDesc'] = '%1$s unbanned %2$s from uploading levels!';
$webhookLang['playerUnbanUploadDescDM'] = '%1$s unbanned uploading levels to you!';
$webhookLang['playerModTitle'] = 'Moderatör';
$webhookLang['playerReasonTitle'] = 'Sebep';
$webhookLang['playerBanReason'] = '*Sebep yok*';
$webhookLang['footerBan'] = '%1$s.';
$webhookLang['playerBanCommentDesc'] = '%1$s banned %2$s\'s ability to comment!';
$webhookLang['playerBanCommentDescDM'] = '%1$s banned ability to comment to you.';
$webhookLang['playerUnbanCommentDesc'] = '%1$s unbanned %2$s\'s ability to comment!';
$webhookLang['playerUnbanCommentDescDM'] = '%1$s unbanned ability to comment to you!';

$webhookLang['dailyTitle'] = 'New daily level!';
$webhookLang['dailyTitleDM'] = 'Your level is daily!';
$webhookLang['dailyDesc'] = 'This level is daily now!';
$webhookLang['dailyDescDM'] = 'Your level became daily! %1$s';
$webhookLang['weeklyTitle'] = 'New weekly level!';
$webhookLang['weeklyTitleDM'] = 'Your level is weekly!';
$webhookLang['weeklyDesc'] = 'This level is weekly now!';
$webhookLang['weeklyDescDM'] = 'Your level became weekly! %1$s';
$webhookLang['eventTitle'] = 'New event level!';
$webhookLang['eventTitleDM'] = 'Your level is event level!';
$webhookLang['eventDesc'] = 'This level is event level now!';
$webhookLang['eventDescDM'] = 'Your level was used in event! %1$s';
?>
