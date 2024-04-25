<?php
/*
	Welcome to webhooks translation file!
	You're currently at French (Français) language
	Credits: DimisAIO.be
	
	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['Un noveau niveau à été rate!', 'Nouveau niveau rate!', 'Quelqu\'un a rate un niveau!']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['Ton niveau a été rate!', 'Quelqu\'un a rate ton niveau!'];
$webhookLang['rateSuccessDesc'] = '%1$s a rate un niveau!'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '%1$s a rate ton niveau! %2$s';
$webhookLang['rateFailTitle'] = ['Ce niveau a été dé-rate!', 'Quelqu\'un a dé-rate un niveau!'];
$webhookLang['rateFailTitleDM'] = ['Ton niveau a été dé-rate!', 'Quelqu\'un a dé-rate ton niveau!'];
$webhookLang['rateFailDesc'] = '%1$s a dé-rate un niveau!';
$webhookLang['rateFailDescDM'] = '%1$s a dé-rate ton niveau! %2$s';

$webhookLang['levelTitle'] = 'Niveau';
$webhookLang['levelDesc'] = '%1$s par %2$s'; // Name by Creator
$webhookLang['levelIDTitle'] = 'ID du niveau';
$webhookLang['difficultyTitle'] = 'Difficulté';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s étoile'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s étoiles'; // Easy, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s étoiles'; // Hard, 5 stars
$webhookLang['statsTitle'] = 'Statistiques';
$webhookLang['requestedTitle'] = 'Demandé par le créateur';
$webhookLang['requestedDesc0'] = '%1$s étoile'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s étoiles'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s étoiles'; // 5 stars
$webhookLang['descTitle'] = 'Déscription';
$webhookLang['descDesc'] = '*Aucune déscription*';
$webhookLang['footer'] = '%1$s, merci d\'avoir joué!';

$webhookLang['suggestTitle'] = ['Check this level!', 'Level was suggested!', 'Someone suggested a level!'];
$webhookLang['suggestDesc'] = '%1$s suggested a level to rate!';
$webhookLang['footerSuggest'] = '%1$s, thank you for moderating!';

$webhookLang['demonlistTitle'] = ['New record!', 'Someone posted new record!'];
$webhookLang['demonlistDesc'] = '%1$s posted their %2$s completion! Link to approve: ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Record author';
$webhookLang['recordAttemptsTitle'] = 'Attempts';
$webhookLang['recordAttemptsDesc0'] = '%1$s attempt'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s attempts'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s attempts'; // 5 attempts
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
$webhookLang['playerModTitle'] = 'Moderator';
$webhookLang['playerReasonTitle'] = 'Reason';
$webhookLang['playerBanReason'] = '*No reason*';
$webhookLang['footerBan'] = '%1$s.';
?>