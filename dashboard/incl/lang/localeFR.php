<?php
// Translation by @GenericPlayR / masckmaster2007
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Acceuil";
$string["welcome"] = "Bienvenue dans ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Alerte!</b> Vous n'avez pas entièrement installé le tableau de bord! Cliquez sur le texte pour le faire.</div>";
$string["levelsWeek"] = "Niveaux publiés en une semaine";
$string["levels3Months"] = "Niveaux publiés en 3 mois";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Bienvenue au tableau de bord! Nous te donnons certains conseils après l'installation:<br>
1. Il y a de nouvelles permissions dans la base de données SQL dans la table 'roles'! Vous devriez y jeter un coup d'oeil...<br>
2. Si vous placez 'icon.png' dans le dossier 'dashboard', alors le logo de votre GDPS va apparaître en haut à gauche!<br>
3. Vous devriez configurer config/dashboard.php!";
$string["wwygdt"] = "Qu'allez vous faire aujourd'hui?";
$string["game"] = "Jeu";
$string["guest"] = "invité";
$string["account"] = "Compte";
$string["levelsOptDesc"] = "Voir la liste des nixeaux";
$string["songsOptDesc"] = "Voir la liste des chansons";
$string["yourClanOptDesc"] = "Voir la liste du clan \"%s\"";
$string["clanOptDesc"] = "Voir la liste des clans";
$string["yourProfile"] = "Votre profile";
$string["profileOptDesc"] = "Voir votre profile";
$string["messengerOptDesc"] ="Ouvrir la messagerie";
$string["addSongOptDesc"] = "Ajouter une chanson dans votre serveur";
$string["loginOptDesc"] = "Se connecter au compte";
$string["createAcc"] = "Créer un compte";
$string["registerOptDesc"] = "Créer dans %s";
$string["downloadOptDesc"] = "Télécharger %s";

$string["tryCron"] = "Exécuter Cron";
$string["cronSuccess"] = "Succès!";
$string["cronError"] = "Erreur!";

$string["profile"] = "Profile";
$string["empty"] = "Vide...";
$string["writeSomething"] = "Écrivez quelque chose!";  
$string["replies"] = "Réponses";
$string["replyToComment"] = "Répondre à un commentaire";
$string["settings"] = "Réglages";
$string["allowMessagesFrom"] = "Autoriser les messages de...";
$string["allowFriendReqsFrom"] = "Autoriser les demandes d'amis de...";
$string["showCommentHistory"] = "Voir l'historique de commentaires...";
$string["yourYouTube"] = "Votre chaîne YouTube";
$string["yourVK"] = "Votre page VK";
$string["yourTwitter"] = "Votre compte Twitter";
$string["yourTwitch"] = "Votre chaîne Twitch";
$string["saveSettings"] = "Sauvegarder les changements";
$string["all"] = "Tous";
$string["friends"] = "Amis";
$string["none"] = "Personne";
$string["youBlocked"] = "Cette personne vous a bloqué!";
$string["cantMessage"] = "Vous ne pouvez pas envoyer des messages à ce joueur!";

$string["accountManagement"] = "Géstion du compte";
$string["changePassword"] = "Changer le mot de passe";
$string["changeUsername"] = "Change le nom d'utilisateur";
$string["unlistedLevels"] = "Vos niveaux non-listés";

$string["manageSongs"] = "Gérer les chansons";
$string["gauntletManage"] = "Gérer les Gauntlets";
$string["suggestLevels"] = "Niveaux suggérés";

$string["modTools"] = "Outils de modération";
$string["leaderboardBan"] = "Bannir un utilisateur";
$string["unlistedMod"] = "Niveaux non-listés";

$string["reuploadSection"] = "Reupload";
$string["songAdd"] = "Ajouter une chanson";
$string["songLink"] = "Ajouter une chanson avec un lien";
$string["packManage"] = "Gérer les Map Packs";

$string["browse"] = "Naviguer";
$string["statsSection"] = "Statistiques";
$string["dailyTable"] = "Niveaux quotidiens";
$string["modActionsList"] = "Actions de modérateurs";
$string["modActions"] = "Modérateurs du serveur";
$string["gauntletTable"] = "Liste des Gauntlets";
$string["packTable"] = "Liste des Map Packs";
$string["leaderboardTime"] = "Progrès du classement";

$string["download"] = "Télécharger";
$string["forwindows"] = "Pour Windows";
$string["forandroid"] = "Pour Android";
$string["formac"] = "Pour Mac";
$string["forios"] = "Pour iOS";
$string["third-party"] = "Tiers";
$string["thanks"] = "Merci à ces personnes!";
$string["language"] = "Langues";

$string["loginHeader"] = "Bienvenu, %s!";
$string["logout"] = "Se déconnecter";
$string["login"] = "Se connecter";
$string["wrongNickOrPass"] = "Nom d'utilisateur ou mot de passe incorrect!";
$string["invalidid"] = "ID incorrecte!";
$string["loginBox"] = "Se connecter ";
$string["loginSuccess"] = "Vous vous êtes connecté avec succès au compte!";
$string["loginAlready"] = "Vous êtes déjà connecté!";
$string["clickHere"] = "Tableau de bord";
$string["enterUsername"] = "Entrez le nom d'utilisateur";
$string["enterPassword"] = "Entrez le mot de passe";
$string["loginDesc"] = "Tu peux to connecter dans ton compte ici!";

$string["register"] = "S'inscrire";
$string["registerAcc"] = "Inscription du compte";
$string["registerDesc"] = "Inscrivez votre compte!";
$string["repeatpassword"] = "Répétez le mot de passe";
$string["email"] = "Email";
$string["repeatemail"] = "Répétez l'email";
$string["smallNick"] = "Le nom d'utilisateur est trop court!";
$string["smallPass"] = "Le mot de passe est trop court!";
$string["passDontMatch"] = "Les mots de passe ne correspondent pas!";
$string["emailDontMatch"] = "Les emails ne correspondent pas!";
$string["registered"] = "Vous avez créé un compte avec succès!";
$string["bigNick"] = "Username is too long!";
$string["mailExists"] = "There is a registered account using this email!";

$string["changePassTitle"] = "Changer le mot de passe";
$string["changedPass"] = "Mot de passe changé avec succès! Vous devez vous reconnecter.";
$string["wrongPass"] = "Mot de passe incorrect!";
$string["samePass"] = "Les mots de passe sont les mêmes!";
$string["changePassDesc"] = "Vous pouvez changer votre mot de passe ici!";
$string["oldPassword"] = "Ancien mot de passe";
$string["newPassword"] = "Nouveau mot de passe";
$string["confirmNew"] = "Confirmer le mot de passe";

$string["forcePassword"] = "Changer le mot de passe de force";
$string["forcePasswordDesc"] = "Ici, vous pouvez changer le mot de passe d'un joueur de force!";
$string["forceNick"] = "Changer le nom d'utilisateur de force";
$string["forceNickDesc"] = "Ici, vous pouvez changer le nom d'utilisateur de force!";
$string["forceChangedPass"] = "Le mot de passe de <b>%s</b> à été changé avec succès!";
$string["forceChangedNick"] = "Le nom d'utilisateur de <b>%s</b> à été changé avec succès!";
$string["changePassOrNick"] = "Changer le nom d'utilisateur ou mot de passe du joueur";

$string["changeNickTitle"] = "Changer le nom d'utilisateur";
$string["changedNick"] = "Nom d'utilisateur changé avec succès! Vous devez vous reconnecter.";
$string["wrongNick"] = "Nom d'utilisateur incorrect!";
$string["sameNick"] = "Les noms d'utilisateur que vous avez entré sont les mêmes!";
$string["alreadyUsedNick"] = "Le nom d'utilisateur que vous avez entré est déjà pris!";
$string["changeNickDesc"] = "Ici vous pouvez changer votre nom d'utilisateur!";
$string["oldNick"] = "Ancien nom d'utilisateur";
$string["newNick"] = "Nouveau nom d'utilisateur";
$string["password"] = "Mot de passe";

$string["packCreate"] = "Créer un Map Pack";
$string["packCreateTitle"] = "Créer un Map Pack";
$string["packCreateDesc"] = "Ici vous pouvez créer un Map Pack!";
$string["packCreateSuccess"] = "Vous avez créé un Map Pack appelé";
$string["packCreateOneMore"] = "Un Map Pack de plus?";
$string["packName"] = "Le nom du Map Pack";
$string["color"] = "Couleur";
$string["sameLevels"] = "Vous avez choisi les mêmes niveaux!";
$string["show"] = "Montrer.";
$string["packChange"] = "Modifiez le Map Pack";
$string["createNewPack"] = "Créez un nouveau Map Pack!"; // Translate word "create" like its call to action

$string["gauntletCreate"] = "Créer un Gauntlet";
$string["gauntletCreateTitle"] = "Créer un Gauntlet";
$string["gauntletCreateDesc"] = "Ici vous pouvez créer un Gauntlet!";
$string["gauntletCreateSuccess"] = "Vous avez créé un Gauntlet!";
$string["gauntletCreateOneMore"] = "Un Gauntlet de plus?";
$string["chooseLevels"] = "Choisis des niveaux!";
$string["checkbox"] = "Confirmer";
$string["level1"] = "Niveau 1";
$string["level2"] = "Niveau 2";
$string["level3"] = "Niveau 3";
$string["level4"] = "Niveau 4";
$string["level5"] = "Niveau 5";
$string["gauntletChange"] = "Modifiez le Gauntlet";
$string["createNewGauntlet"] = "Créez un nouveau Gauntlet!"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'You successfully created <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Choose Gauntlet automatically";

$string["addQuest"] = "Ajouter une quête";
$string["addQuestDesc"] = "Ici vous pouvez ajouter une quête!";
$string["questName"] = "Nom de la quête";
$string["questAmount"] = "Quantité réquise";
$string["questReward"] = "Récompense";
$string["questCreate"] = "Créer une quête";
$string["questsSuccess"] = "Vous avez créé une quête avec succès";
$string["invalidPost"] = "Données invalides!";
$string["fewMoreQuests"] = "Il est recommendé de créer quelques quêtes de plus.";
$string["oneMoreQuest?"] = "Une quête de plus?";
$string["changeQuest"] = "Modifiez la quête";
$string["createNewQuest"] = "Créez une nouvelle quête!"; // like gauntlets and mappacks above

$string["levelReupload"] = "Reupload le niveau";
$string["levelReuploadDesc"] = "Ici vous pouvez reupload un niveau de n'importe quel serveur (GDPS)!";
$string["advanced"] = "Options avancées";
$string["errorConnection"] = "Erreur de connexion!";
$string["levelNotFound"] = "Ce niveau n'existe pas!";
$string["robtopLol"] = "D'après de sources TRÈS FIABLES, nous avons pu conclure que RobTop ne vous aime pas :c";
$string["sameServers"] = "Le serveur de source et déstination sont les mêmes!";
$string["levelReuploaded"] = "Niveau reuploadé! ID du niveau:";
$string["oneMoreLevel?"] = "Un niveau de plus?";
$string["levelAlreadyReuploaded"] = "Niveau déjà reupload!";
$string["server"] = "Serveur";
$string["levelID"] = "ID du niveau";
$string["pageDisabled"] = "Cette page est désactivée!";

$string["activateAccount"] = "Activation du compte";
$string["activateDesc"] = "Activez votre compte!";
$string["activated"] = "Votre compte a été activé avec succès!";
$string["alreadyActivated"] = "Votre compte est déjà activé";
$string["maybeActivate"] = "Vous n'avez probablement pas activé votre compte.";
$string["activate"] = "Activer";
$string["activateDisabled"] = "L'activation de compte est désactivé!";

$string["addMod"] = "Ajouter un moderateur";
$string["addModDesc"] = "Ici vous pouvez rendre quelqu'un modérateur!";
$string["modYourself"] = "Vous ne pouvez pas devenir modérateur vous même!";
$string["alreadyMod"] = "Ce joueur est déjà un modérateur!";
$string["addedMod"] = "Vous avez donné les permissions modérateur à un joueur avec succès";
$string["addModOneMore"] = "Un moderateur de plus?";
$string["modAboveYourRole"] = "Tu essayes de donner un rôle supérieur au tiens!";
$string["makeNewMod"] = "Rendre quelqu'un moderateur!";
$string["reassignMod"] = "Retirer un moderateur"; // man idk how to say it :'( // sorry
$string["reassign"] = "Retirer";
$string['demotePlayer'] = "Démod un joueur";
$string['demotedPlayer'] = "Vous avez démod le joueur <b>%s</b> avec succès!";
$string['addedModNew'] = "Vous avez donné les permissions mod à <b>%s</b> avec succès!";
$string['demoted'] = 'Démod (perms mod supprimé)';

$string["shareCPTitle"] = "Partager les Points Créateur";
$string["shareCPDesc"] = "Ici vous pouvez partager les Points Créateur avec un joueur!";
$string["shareCP"] = "Partager";
$string["alreadyShared"] = "Ce niveau à déjà les points créateur partagé à ce joueur!";
$string["shareToAuthor"] = "Vous avez essayé de partager des points créateur à l'auteur du niveau!";
$string["userIsBanned"] = "Ce joueur est banni!";
$string["shareCPSuccess"] = "Vous avez partagé les Points Créateur de ce niveau avec succès";
$string["shareCPSuccess2"] = "vers le joueur";
$string["updateCron"] = "Vous devez peut-être mettre à jour vos Points Créateur.";
$string["shareCPOneMore"] = "Un Partage de plus?";
$string['shareCPSuccessNew'] = 'Vous avez partagé avec succès vos points créateur (CP) du niveau <b>%1$s</b> avec <b>%2$s</b>!';

$string["messenger"] = "Messages";
$string["write"] = "Écrire";
$string["send"] = "Envoyer";
$string["noMsgs"] = "Commencez une discussion!";
$string["subject"] = "Sujet";
$string["msg"] = "Message";
$string["tooFast"] = "Vous tapez trop vite!";

$string["levelToGD"] = "Reupload un niveau à un serveur de déstination";
$string["levelToGDDesc"] = "Ici vous pouvez reupload votre niveau à un serveur de déstination!";
$string["usernameTarget"] = "Nom d'utilisateur du serveur de déstination";
$string["passwordTarget"] = "Mot de passe du serveur de déstination";
$string["notYourLevel"] = "Ce n'est pas votre niveau!";
$string["reuploadFailed"] = "Erreur de reupload de niveau!";

$string["search"] = "Rechercher...";
$string["searchCancel"] = "Annuler la recherche";
$string["emptySearch"] = "Aucun résultat!";

$string["demonlist"] = 'Demonlist';
$string["demonlistRecord"] = 'Records de <b>%s</b>';
$string["alreadyApproved"] = 'Déjà approuvé!';
$string["alreadyDenied"] = 'Déjà rejeté!';
$string["approveSuccess"] = 'Vous avez approuvé le record de <b>%s</b> avec succès!';
$string["denySuccess"] = 'Vous avez rejeté le record de <b>%s</b> avec succès!';
$string["recordParameters"] = '<b>%s</b> à battu <b>%s</b> en <b>%d</b> tentatives';
$string["approve"] = 'Approuver';
$string["deny"] = 'Refuser';
$string["submitRecord"] = 'Soumettre le record';
$string["submitRecordForLevel"] = 'Soumettre le record pour <b>%s</b>';
$string["alreadySubmitted"] = 'Vous avez déjà soumit un record pour <b>%s</b>!';
$string["submitSuccess"] = 'Vous avez soumit un record pour <b>%s</b> avec succès!';
$string["submitRecordDesc"] = 'Ne soumettez le record seulement si vous avez battu le niveau!';
$string["atts"] = 'Tentatives';
$string["ytlink"] = 'ID vidéo YouTube (dQw4w9WgXcQ)';
$string["submit"] = 'Soumettre';
$string["addDemonTitle"] = 'Ajouter un demon';
$string["addDemon"] = 'Ajouter un demon à la demonlist';
$string["addedDemon"] = 'Vous avez ajouté <b>%s</b> dans la <b>%d</b>e place!';
$string["addDemonDesc"] = 'Ici vous pouvez ajouter un demon dans la demonlist!';
$string["place"] = 'Placer';
$string["giveablePoints"] = 'Points donnables';
$string["add"] = 'Ajouter';
$string["recordApproved"] = 'Record approuvé!';
$string["recordDenied"] = 'Record rejeté!';
$string["recordSubmitted"] = 'Record soumit!';
$string["nooneBeat"] = 'personne ne l\'a battu'; //let it be lowercase
$string["oneBeat"] = '1 joueur l\'a battu'; 
$string["lower5Beat"] = '%d joueurs l\'ont battu'; // russian syntax, sorry
$string["above5Beat"] = '%d joueurs l\'ont battu'; 
$string["demonlistLevel"] = '%s <text class="dltext">par <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';
$string["noDemons"] = 'Ça à l\'air que votre demonlist n\'a aucun demon...';
$string["addSomeDemons"] = 'Ajoutez certains demons pour remplir la demonlist!';
$string["askForDemons"] = 'Demandez l\'administrateur du serveur\'s qu\'il en ajoute!';
$string["recordList"] = 'Liste des records';
$string["status"] = 'Status';
$string["checkRecord"] = 'Vérifier les records';
$string["record"] = 'Record';
$string["recordDeleted"] = 'Le record à été supprimé!';
$string["changeDemon"] = 'Change demon';
$string["demonDeleted"] = 'Demon was deleted!';
$string["changedDemon"] = 'Vous avez replacé <b>%s</b> à la <b>%d</b>e(re) place!';
$string["changeDemonDesc"] = 'Ici, vous pouvez changer un demon!<br>
Pour le supprimer, mettez la place en 0';

$string["didntActivatedEmail"] = 'Vous n\'avez pas activé votre compte par email!';
$string["checkMail"] = 'Vous devrez vérifier vos mails...';

$string["likeSong"] = "Ajouter la chansons aux favoris";
$string["dislikeSong"] = "Retirer la chansons des favoris";
$string["favouriteSongs"] = "Chansons favorites";
$string["howMuchLiked"] = "Combien ont ils aimé?";
$string["nooneLiked"] = "Personne n'a aimé";

$string["clan"] = "Clan";
$string["joinedAt"] = "Rejoint le clan le: <b>%s</b>";
$string["createdAt"] = "Créé le clan le: <b>%s</b>";
$string["clanMembers"] = "Membres du Clan";
$string["noMembers"] = "Aucun membre";
$string["clanOwner"] = "Propriétaire du clan";
$string["noClanDesc"] = "<i>Aucune déscription</i>";
$string["noClan"] = "Ce clan n'existe pas!";
$string["clanName"] = "Nom du clan";
$string["clanDesc"] = "Déscription du clan";
$string["clanColor"] = "Couleur du clan";
$string["dangerZone"] = "Zone de danger";
$string["giveClan"] = "Donner le clan";
$string["deleteClan"] = "Supprimer le clan";
$string["goBack"] = "Revenir en arrière";
$string["areYouSure"] = "Êtes-vous sûr?";
$string["giveClanDesc"] = "Ici vous pouvez donner votre clan à un joueur.";
$string["notInYourClan"] = "Ce joueur n'est pas dans votre clan!";
$string["givedClan"] = "Vous avez donné votre clan à <b>%s</b> avec succès!";
$string["deletedClan"] = "Vous avez supprimé le clan <b>%s</b>.";
$string["deleteClanDesc"] = "Ici vous pouvez supprimer votre clan.";
$string["yourClan"] = "Votre clan";
$string["members0"] = "<b>1</b> membre";
$string["members1"] = "<b>%d</b> membres"; 
$string["members2"] = "<b>%d</b> membres"; 
$string["noRequests"] = "Il n'y a pas de requêtes. Calmos!";
$string["pendingRequests"] = "Requêtes de clan";
$string["closedClan"] = "Clan férmé";
$string["kickMember"] = "Expulser un membre";
$string["leaveFromClan"] = "Quitter le clan";
$string["askToJoin"] = "Envoyer une demande d'adhésion (rejoindre)";
$string["removeClanRequest"] = "Supprimer la demande d'adhésion";
$string["joinClan"] = "Rejoindre le clan";
$string["noClans"] = "Il n'y a pas de clan";
$string["clans"] = "Clans";
$string["alreadyInClan"] = "Vous êtes déjà dans ce clan!";
$string["createClan"] = "Créer le clan";
$string["createdClan"] = "Vous avez créé le clan <span style='font-weight:700;color:#%s'>%s</span> avec succès!";
$string["createClanDesc"] = "Ici vous pouvez créer un clan!";
$string["create"] = "Créer";
$string["mainSettings"] = "Réglages principaux";
$string["takenClanName"] = "Le nom du clan est déjà prit!";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> à suggéré <b>%4$s%3$s</b> pour</text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> a été signalé</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Listes";
$string['listTableMod'] = "Listes non répértoriées";
$string['listTableYour'] = "Vos listes non répértoriées";

$string['forgotPasswordChangeTitle'] = "Change password";
$string["successfullyChangedPass"] = "Password was successfully changed!";
$string['forgotPasswordTitle'] = "Forgot password?";
$string['maybeSentAMessage'] = "We'll send you a message if this account exists.";
$string['forgotPasswordDesc'] = "Here you can request change password link if you forgot it!";
$string['forgotPasswordButton'] = "Request link";

$string['sfxAdd'] = "Add SFX";
$string["sfxAddError-5"] = "SFX's size is higher than $SFXsize megabytes!";
$string["sfxAddError-6"] = "Something went wrong while uploading SFX!";
$string["sfxAddError-7"] = "You can only upload audio!";
$string['sfxAdded'] = 'SFX added';
$string['yourNewSFX'] = "Take a look at your new SFX!";
$string["sfxAddAnotherBTN"] = "One more SFX?";
$string["sfxAddDesc"] = "Here you can add your SFX!";
$string["chooseSFX"] = "Choose SFX";
$string["sfxAddNameFieldPlaceholder"] = "Name";
$string['sfxs'] = 'SFXs';
$string['sfxID'] = 'SFX ID';
$string['manageSFX'] = 'Manage SFXs';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Upload";
$string["errorGeneric"] = "Une erreur est apparue!";
$string["smthWentWrong"] = "Quelque chose s'est mal passée!";
$string["tryAgainBTN"] = "Réessayez";
//songAdd.php
$string["songAddDesc"] = "Ici vous pouvez ajouter votre chanson!";
$string["songAddUrlFieldLabel"] = "URL de la chanson: (Liens directs or Dropbox seulement)";
$string["songAddUrlFieldPlaceholder"] = "URL de la chanson";
$string["songAddNameFieldPlaceholder"] = "Nom";
$string["songAddAuthorFieldPlaceholder"] = "Auteur";
$string["songAddButton"] = "Choisir la chanson";
$string["songAddAnotherBTN"] = "Une chanson de plus?";
$string["songAdded"] = "Chanson ajouté!";
$string["deletedSong"] = "Vous avez supprimé une chanson avec succès";
$string["renamedSong"] = "Vous avez renomé une chanson avec succès à";
$string["songID"] = "ID de chanson: ";
$string["songIDw"] = "ID de chanson";
$string["songAuthor"] = "Auteur";
$string["size"] = "Taille";
$string["delete"] = "Supprimer";
$string["change"] = "Changer";
$string["chooseFile"] = "Choisir une chanson";
$string['yourNewSong'] = "Take a look at your new song!";
///errors
$string["songAddError-2"] = "URL Invalide";
$string["songAddError-3"] = "Cette chanson à été déjà reupload avec ID:";
$string["songAddError-4"] = "Cette chanson ne peut pas être reupload";
$string["songAddError-5"] = "La taille de la chanson est plus grande que $songSize megabytes";
$string["songAddError-6"] = "Quelque chose de mal s'est passé en uploadant la song! :с";
$string["songAddError-7"] = "Vous ne pouvez upload que de l'audio!";

$string[400] = "Mauvaise requette!";
$string["400!"] = "Vérifiez vos pilotes réseau.";
$string[403] = "Interdit!";
$string["403!"] = "Vous n'avez pas accès à cette page!";
$string[404] = "Page non trouvée!";
$string["404!"] = "Êtes-vous sûr d'avoir bien tapé l'URL?";
$string[500] = "Erreur du serveur!";
$string["500!"] = "Le codeur a fait une bétise dans le code,</br>
s'il vous plaît parlez en ici:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Le serveur est en panne!";
$string["502!"] = "Le chargement du serveur est trop grand.</br>
Revennez plus tard dans quelques heures!";

$string["invalidCaptcha"] = "Réponse captcha invalide!";
$string["page"] = "Page";
$string["emptyPage"] = "Cette page est vide!";
// Tourner dans le vide vide, tourner dans le vide vide, tourner dans le vide, il me fait tooooouuuurneeer!
/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orbs";
$string["stars"] = "Étoiles";
$string["coins"] = "Pièces";
$string["accounts"] = "Comptes";
$string["levels"] = "Niveaux";
$string["songs"] = "Chansons";
$string["author"] = "Créateur";
$string["name"] = "Nom";
$string["date"] = "Date";
$string["type"] = "Type";
$string["reportCount"] = "Compte de rapport";
$string["reportMod"] = "Rapports";
$string["username"] = "Nom d'utilisateur";
$string["accountID"] = "ID de Compte";
$string["registerDate"] = "Date d'inscription";
$string["levelAuthor"] = "Auteur du niveau";
$string["isAdmin"] = "Role dans le serveur";
$string["isAdminYes"] = "Oui";
$string["isAdminNo"] = "Non";
$string["userCoins"] = "Pièces utilisateur";
$string["time"] = "Temps";
$string["deletedLevel"] = "Niveau(x) Supprimé(s)";
$string["mod"] = "Moderateur";
$string["count"] = "Quantité d'actions";
$string["ratedLevels"] = "Niveaux rate (étoilés)";
$string["lastSeen"] = "Dernière fois en ligne";
$string["level"] = "Niveau";
$string["pageInfo"] = "Affichage de la page %s à %s";
$string["first"] = "Début";
$string["previous"] = "Précédent";
$string["next"] = "Prochain";
$string["never"] = "Jamais";
$string["last"] = "Fin";
$string["go"] = "Go";
$string["levelid"] = "ID du Niveau";
$string["levelname"] = "Nom du Niveau";
$string["leveldesc"] = "Description du Niveau";
$string["noDesc"] = "Pas de description";
$string["levelpass"] = "Mot de passe";
$string["nopass"] = "Aucun mot de passe";
$string["unrated"] = "Unrate (retiré d'étoiles)";
$string["rate"] = "Rate (étoiler)";
$string["stats"] = "Statistique";
$string["suggestFeatured"] = "En vedette?";
$string["whoAdded"] = "Qui l'a ajouté?";
//modActionsList
$string["banDesc"] = "Ici vous pouvez bannir un joueur du classement!";
$string["playerTop"] = 'Top of players';
$string["creatorTop"] = 'Top of creators';

$string["admin"] = "Administrateur";
$string["elder"] = "Ancien Modérateur";
$string["moder"] = "Modérateur";
$string["player"] = "Joueur";

$string["starsLevel2"] = "étoiles";
$string["starsLevel1"] = "étoiles";
$string["starsLevel0"] = "étoile";
$string["coins2"] = "pièces";
$string["coins1"] = "pièces";
$string["coins0"] = "pièce";
$string["time0"] = "fois";
$string["time1"] = "fois";
$string["times"] = "fois";
$string["action0"] = "action";
$string["action1"] = "actions";
$string["action2"] = "actions";
$string["lvl0"] = "niveau";
$string["lvl1"] = "niveaux";
$string["lvl2"] = "niveaux";
$string["player0"] = "joueur";
$string["player1"] = "joueurs";
$string["player2"] = "joueurs";
$string["unban"] = "Débannir";
$string["isBan"] = "Bannir";

$string["noCoins"] = "Sans pièces";
$string["noReason"] = "Aucune raison";
$string["noActions"] = "Aucune action";
$string["noRates"] = "Aucun rate";

$string["future"] = "Future";

$string["spoiler"] = "Spoiler";
$string["accid"] = "avec ID de compte";
$string["banned"] = "a été banni avec succès!";
$string["unbanned"] = "a été débanni avec succès!";
$string["ban"] = "Bannir";
$string["nothingFound"] = "Ce joueur n'éxiste pas!";
$string["banUserID"] = "Nom d'utilisateur ou ID de compte";
$string["banUserPlace"] = "Bannir un utilisateur";
$string["banYourself"] = "Vous ne pouvez pas bannir vous-même!"; 
$string["banYourSelfBtn!"] = "Bannir quelqu'un d'autre";
$string["banReason"] = "Raison du ban";
$string["action"] = "Action";
$string["value"] = "1ère valeur";
$string["value2"] = "2ème valeur";
$string["value3"] = "3ème valeur";
$string["modAction1"] = "A rate un niveau";
$string["modAction2"] = "A mis/plus mis en vedette un niveau";
$string["modAction3"] = "A/n'as pas vérifié les pièces";
$string["modAction4"] = "A/n'as pas epic un niveau";
$string["modAction5"] = "Placé comme niveau quotidien";
$string["modAction6"] = "A supprimé un niveau";
$string["modAction7"] = "Changement de créateur";
$string["modAction8"] = "A renommé un niveau";
$string["modAction9"] = "A changé le mot de passe du niveau";
$string["modAction10"] = "Changé la difficulté démon";
$string["modAction11"] = "Partagé les CP (points créateur)";
$string["modAction12"] = "A publié / a cessé de publier le niveau";
$string["modAction13"] = "Changé la déscription du niveau";
$string["modAction14"] = "Activé/désactivé le LDM";
$string["modAction15"] = "(Dé)Banni du classement";
$string["modAction16"] = "Changement de l'ID de chanson";
$string["modAction17"] = "A créé un Map Pack";
$string["modAction18"] = "A créé un Gauntlet";
$string["modAction19"] = "A changé une chanson";
$string["modAction20"] = "Donné les permissions modérateur à un joueur";
$string["modAction21"] = "Map Pack modifié";
$string["modAction22"] = "Gauntlet modifié";
$string["modAction23"] = "Quête modifiée";
$string["modAction24"] = "Reassigned a player";
$string["modAction25"] = "A créé une quête";
$string["modAction26"] = "A changé le nom d'utilisateur/mot de passe du joueur";
$string["modAction30"] = "La liste a été rate";
$string["modAction31"] = "La liste a été sent (envoyé aux modérateurs)";
$string["modAction32"] = "La list a été (ou a eu son) featured (supprimé)";
$string["modAction33"] = "Liste publié (ou enlevé)";
$string["modAction34"] = "Liste supprimé";
$string["modAction35"] = "Changé le créateur de la liste";
$string["modAction36"] = "Changé le nom de la liste";
$string["modAction37"] = "Changé la description de la liste"; // snoring
$string["everyActions"] = "Toutes les actions";
$string["everyMod"] = "Tous les modérateurs";
$string["Kish!"] = "Part d'ici!";
$string["noPermission"] = "Vous n'avez pas la permission!";
$string["noLogin?"] = "Vous n'êtes pas connecté à votre compte!";
$string["LoginBtn"] = "Se connecter au compte";
$string["dashboard"] = "Tableau de bord";
$string["userID"] = 'ID Utilisateur (userid)';
//errors
$string["errorNoAccWithPerm"] = "Erreur: Aucun compte avec la permission '%s' a été trouvé";