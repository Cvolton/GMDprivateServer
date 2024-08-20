<?php
/*
	Welcome to webhooks translation file!
	You're currently at French (Français) language
	Credits: DimisAIO.be, M336
	
	If you see array instead of simple string, that means you can add as many variations of translation as you want and they will be picked randomly
*/
$webhookLang['rateSuccessTitle'] = ['Un nouveau niveau vient d\'être rated !', 'Nouveau niveau rated !', 'Quelqu\'un vient de rate un niveau !']; // This one is array
$webhookLang['rateSuccessTitleDM'] = ['Ton niveau vient d\'être rated !', 'Quelqu\'un vient de rate ton niveau !'];
$webhookLang['rateSuccessDesc'] = '%1$s a rate un niveau !'; // And this one is string
$webhookLang['rateSuccessDescDM'] = '%1$s vient de rate votre niveau ! %2$s';
$webhookLang['rateFailTitle'] = ['Un niveau vient tout juste d\'être un-rated...', 'Quelqu\'un a un-rate un niveau...'];
$webhookLang['rateFailTitleDM'] = ['Ton niveau a été un-rated...', 'Quelqu\'un vient d\'un-rate votre niveau...'];
$webhookLang['rateFailDesc'] = '%1$s a un-rate un niveau...';
$webhookLang['rateFailDescDM'] = '%1$s vient d\'un-rate votre niveau... %2$s';

$webhookLang['levelTitle'] = 'Niveau';
$webhookLang['levelDesc'] = '%1$s par %2$s'; // Name by Creator
$webhookLang['levelIDTitle'] = 'ID du niveau';
$webhookLang['difficultyTitle'] = 'Difficulté';
$webhookLang['difficultyDesc0'] = '%1$s, %2$s étoile'; // Auto, 1 star
$webhookLang['difficultyDesc1'] = '%1$s, %2$s étoiles'; // Easy, 2 stars
$webhookLang['difficultyDesc2'] = '%1$s, %2$s étoiles'; // Hard, 5 stars
$webhookLang['difficultyDescMoon0'] = '%1$s, %2$s lune'; // Auto, 1 moon (Platformer)
$webhookLang['difficultyDescMoon1'] = '%1$s, %2$s lunes'; // Easy, 2 moons (Platformer)
$webhookLang['difficultyDescMoon2'] = '%1$s, %2$s lunes'; // Hard, 5 moons (Platformer)
$webhookLang['statsTitle'] = 'Statistiques';
$webhookLang['requestedTitle'] = 'Difficulté demandé par le créateur';
$webhookLang['requestedDesc0'] = '%1$s étoile'; // 1 star
$webhookLang['requestedDesc1'] = '%1$s étoiles'; // 2 stars
$webhookLang['requestedDesc2'] = '%1$s étoiles'; // 5 stars
$webhookLang['requestedDescMoon0'] = '%1$s lune'; // 1 moon (Platformer)
$webhookLang['requestedDescMoon1'] = '%1$s lunes'; // 2 moons (Platformer)
$webhookLang['requestedDescMoon2'] = '%1$s lunes'; // 5 moons (Platformer)
$webhookLang['descTitle'] = 'Description';
$webhookLang['descDesc'] = '*Aucune description*';
$webhookLang['footer'] = 'Merci d\'avoir joué sur %1$s !';

$webhookLang['suggestTitle'] = ['Jetez un oeil à ce niveau !', 'Un niveau vient d\'être suggéré !', 'Quelqu\'un a suggéré un niveau !'];
$webhookLang['suggestDesc'] = '%1$s a suggéré un niveau !';
$webhookLang['footerSuggest'] = 'Merci d\'avoir modéré sur %1$s !';

$webhookLang['demonlistTitle'] = ['Nouveau record !', 'Quelqu\'un a posté un nouveau record !'];
$webhookLang['demonlistDesc'] = '%1$s a posté son record sur %2$s ! Lien pour approuver : ||%3$s||';
$webhookLang['recordAuthorTitle'] = 'Détenteur du record';
$webhookLang['recordAttemptsTitle'] = 'Essais';
$webhookLang['recordAttemptsDesc0'] = '%1$s essai'; // 1 attempt
$webhookLang['recordAttemptsDesc1'] = '%1$s essais'; // 2 attempts
$webhookLang['recordAttemptsDesc2'] = '%1$s essais'; // 5 attempts
$webhookLang['recordProofTitle'] = 'Preuve';
$webhookLang['demonlistApproveTitle'] = ['Votre record vient d\'être approuvé !', 'Quelq\'un vient d\'approuvé votre record !'];
$webhookLang['demonlistApproveTitleDM'] = ['Votre record a été apporuvé !', 'Quelqu\'un a approuvé votre record !'];
$webhookLang['demonlistApproveDesc'] = '%1$s a approuvé le record de %2$s sur le niveau %3$s !';
$webhookLang['demonlistApproveDescDM'] = '%1$s a approuvé votre record sur le niveau %2$s !';
$webhookLang['demonlistDenyTitle'] = ['Votre record vient d\'être rejeté...', 'Quelq\'un vient de rejeter votre record...'];
$webhookLang['demonlistDenyTitleDM'] = ['Votre record a été rejeté...', 'Quelqu\'un a rejeté votre record...'];
$webhookLang['demonlistDenyDesc'] = '%1$s a rejeté le record de %2$s sur le niveau %3$s!';
$webhookLang['demonlistDenyDescDM'] = '%1$s a rejeté votre record sur le niveau %2$s...';

$webhookLang['accountLinkTitle'] = ['Liaison de comptes !', 'Quelqu\'un veut relier son compte au vôtre !'];
$webhookLang['accountLinkDesc'] = 'On dirait que %1$s veut relier son compte en jeu à votre compte Discord. Utilisez la commande **!discord accept *code*** dans votre profil en jeu pour accepter cette liaison de comptes. Si ce n\'est pas vous, **ignorez** ce message !';
$webhookLang['accountCodeFirst'] = 'Premier chiffre';
$webhookLang['accountCodeSecond'] = 'Deuxième chiffre';
$webhookLang['accountCodeThird'] = 'Troisième chiffre';
$webhookLang['accountCodeFourth'] = 'Quatrième chiffre';
$webhookLang['accountUnlinkTitle'] = ['Déliaison de comptes!', 'Vous venez d\'enlever le lien entre vos deux comptes !'];
$webhookLang['accountUnlinkDesc'] = 'Vous venez de retirer le lien entre %1$s et votre compte Discord avec succès !';
$webhookLang['accountAcceptTitle'] = ['Liason de comptes !', 'Vous venez de lier votre compte !'];
$webhookLang['accountAcceptDesc'] = 'Vous venez de relier %1$s à votre compte Discord avec succès !';

$webhookLang['playerBanTitle'] = ['Un joueur vient d\'être banni !', 'Un modérateur a banni un joueur !', 'Ban !'];
$webhookLang['playerBanTitleDM'] = ['Vous avez été banni !', 'Un modérateur vous a banni !', 'Banni !'];
$webhookLang['playerUnbanTitle'] = ['Un joueur vient d\'être unban !', 'Un modérateur a unban quelqu\'un!', 'Unban !'];
$webhookLang['playerUnbanTitleDM'] = ['Vous avez été unbanned !', 'Un modérateur vous a unban !', 'Unbanned !'];
$webhookLang['playerBanTopDesc'] = '%1$s a banni %2$s du classement des meilleurs joueurs !';
$webhookLang['playerBanTopDescDM'] = '%1$s vous a banni du classement des meilleurs joueurs.';
$webhookLang['playerUnbanTopDesc'] = '%1$s a unban %2$s du classement des meilleurs joueurs !';
$webhookLang['playerUnbanTopDescDM'] = '%1$s vous a unban du classement des meilleurs joueurs !';
$webhookLang['playerBanCreatorDesc'] = '%1$s a banni %2$s du classement des meilleurs créateurs !';
$webhookLang['playerBanCreatorDescDM'] = '%1$s vous a banni du classement des meilleurs créateurs.';
$webhookLang['playerUnbanCreatorDesc'] = '%1$s a unban %2$s du classement des meilleurs créateurs !';
$webhookLang['playerUnbanCreatorDescDM'] = '%1$s vous a unban du classement des meilleurs créateurs !';
$webhookLang['playerBanUploadDesc'] = '%1$s a interdit à %2$s d\'uploader d\'autres niveaux!';
$webhookLang['playerBanUploadDescDM'] = '%1$s vous a interdit d\'uploader plus de niveaux.';
$webhookLang['playerUnbanUploadDesc'] = '%1$s a levé l\'interdiction de %2$s d\'uploader d\'autres niveaux !';
$webhookLang['playerUnbanUploadDescDM'] = '%1$s a levé votre interdiction d\'uploader plus de niveaux !';
$webhookLang['playerModTitle'] = 'Modérateur';
$webhookLang['playerReasonTitle'] = 'Raison';
$webhookLang['playerBanReason'] = '*Aucune raison*';
$webhookLang['footerBan'] = '%1$s.';
$webhookLang['playerBanCommentDesc'] = '%1$s a interdit à %2$s de faire des commentaires';
$webhookLang['playerBanCommentDescDM'] = '%1$s vous a interdit de faire des commentaires';
$webhookLang['playerUnbanCommentDesc'] = '%1$s a levé l\'interdiction de %2$s de faire des commentaires !';
$webhookLang['playerUnbanCommentDescDM'] = '%1$s a levé votre interdiction de faire des commentaires !';
$webhookLang['playerBanAccountDesc'] = '%1$s banned %2$s\'s account!';
$webhookLang['playerBanAccountDescDM'] = '%1$s banned your account.';
$webhookLang['playerUnbanAccountDesc'] = '%1$s unbanned %2$s\'s account!';
$webhookLang['playerUnbanAccountDescDM'] = '%1$s unbanned your account!';
$webhookLang['playerExpiresTitle'] = 'Expires';
$webhookLang['playerTypeTitle'] = 'Person type';
$webhookLang['playerTypeName0'] = 'Account ID';
$webhookLang['playerTypeName1'] = 'User ID';
$webhookLang['playerTypeName2'] = 'IP-address';

$webhookLang['dailyTitle'] = 'Nouveau niveau journalier !';
$webhookLang['dailyTitleDM'] = 'Votre niveau a été désigné comme niveau du jour !';
$webhookLang['dailyDesc'] = 'Ce niveau est désormais le niveau du jour !';
$webhookLang['dailyDescDM'] = 'Votre niveau a été désigné comme niveau du jour ! %1$s';
$webhookLang['weeklyTitle'] = 'Nouveau niveau hebdomadaire!';
$webhookLang['weeklyTitleDM'] = 'Votre niveau a été désigné comme niveau de la semaine !';
$webhookLang['weeklyDesc'] = 'Ce niveau est désormais le niveau de la semaine !';
$webhookLang['weeklyDescDM'] = 'Votre niveau a été désigné comme niveau de la semaine ! %1$s';
$webhookLang['eventTitle'] = 'Nouveau niveau événement !';
$webhookLang['eventTitleDM'] = 'Votre niveau a été désigné comme niveau événement !';
$webhookLang['eventDesc'] = 'Ce niveau est désormais un niveau événement !';
$webhookLang['eventDescDM'] = 'Votre niveau a été utilisé lors d\'un événement ! %1$s';
?>