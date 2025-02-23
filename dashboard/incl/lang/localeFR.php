<?php
// Translation by @GenericPlayR / masckmaster2007 and @M336G / M336

global $dbPath;
require __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Accueil";
$string["welcome"] = "Bienvenue sur ".$gdps.'!';
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Bienvenue sur le tableau de bord ! Nous te donnons certains conseils après l'installation de celui-ci :<br>
1. Il y a de nouvelles permissions dans la base de données SQL, dans la table \"roles\" ! Vous devriez y jeter un coup d'oeil...<br>
2. Si vous placez un fichier \"icon.png\" dans le dossier \"dashboard\", le logo de votre GDPS s'affichera en haut à gauche !<br>
3. Vous devriez jetez un coup d'oeil à la configuration du dashboard dans \"config/dashboard.php\"!";
$string["wwygdt"] = "Qu'allez-vous faire aujourd'hui?";
$string["game"] = "Jeu";
$string["guest"] = "invité";
$string["account"] = "Compte";
$string["levelsOptDesc"] = "Voir la liste de niveaux";
$string["songsOptDesc"] = "Voir la liste de musiques";
$string["yourClanOptDesc"] = "Voir la liste du clan \"%s\"";
$string["clanOptDesc"] = "Voir la liste de clans";
$string["yourProfile"] = "Votre profil";
$string["profileOptDesc"] = "Voir votre profil";
$string["messengerOptDesc"] ="Ouvrir la messagerie instantanée";
$string["addSongOptDesc"] = "Ré-uploader une musique sur le serveur";
$string["loginOptDesc"] = "Se connecter au compte";
$string["createAcc"] = "Créer un compte";
$string["registerOptDesc"] = "Créer dans %s";
$string["downloadOptDesc"] = "Télécharger %s";

$string["tryCron"] = "Exécuter le Cron";
$string["cronSuccess"] = "Succès !";
$string["cronError"] = "Erreur !";

$string["profile"] = "Profil";
$string["empty"] = "Vide...";
$string["writeSomething"] = "Écrivez quelque chose !";  
$string["replies"] = "Réponses";
$string["replyToComment"] = "Répondre à un commentaire";
$string["settings"] = "Réglages";
$string["allowMessagesFrom"] = "Autoriser les messages de...";
$string["allowFriendReqsFrom"] = "Autoriser les demandes d'amis de...";
$string["showCommentHistory"] = "Voir l'historique des commentaires...";
$string["timezoneChoose"] = "Choisir le fuseau horaire";
$string["yourYouTube"] = "Votre chaîne YouTube";
$string["yourVK"] = "Votre page VK";
$string["yourTwitter"] = "Votre compte Twitter";
$string["yourTwitch"] = "Votre chaîne Twitch";
$string["saveSettings"] = "Sauvegarder les changements";
$string["all"] = "Tous";
$string["friends"] = "Amis";
$string["none"] = "Personne";
$string["youBlocked"] = "Cette personne vous a bloqué !";
$string["cantMessage"] = "Vous ne pouvez pas envoyer de messages à ce joueur !";

$string["accountManagement"] = "Gestion du compte";
$string["changePassword"] = "Changer le mot de passe";
$string["changeUsername"] = "Changer le nom d'utilisateur";
$string["unlistedLevels"] = "Vos niveaux non répertoriés";

$string["manageSongs"] = "Gérer vos musiques";
$string["gauntletManage"] = "Gérer les Gauntlets";
$string["suggestLevels"] = "Niveaux suggérés";

$string["modTools"] = "Outils de modération";
$string["leaderboardBan"] = "Bannir un utilisateur";
$string["unlistedMod"] = "Niveaux non répertoriés";

$string["reuploadSection"] = "Reupload";
$string["songAdd"] = "Ajouter une musique";
$string["songLink"] = "Ajouter une musique avec un lien";
$string["packManage"] = "Gérer les Map Packs";

$string["browse"] = "Naviguer";
$string["statsSection"] = "Statistiques";
$string["dailyTable"] = "Niveaux quotidiens";
$string["modActionsList"] = "Actions des modérateurs";
$string["modActions"] = "Modérateurs du serveur";
$string["gauntletTable"] = "Gauntlets";
$string["packTable"] = "Map Packs";
$string["leaderboardTime"] = "Progrès du classement";

$string["download"] = "Télécharger";
$string["forwindows"] = "Pour Windows";
$string["forandroid"] = "Pour Android";
$string["formac"] = "Pour Mac";
$string["forios"] = "Pour iOS";
$string["third-party"] = "Tiers";
$string["thanks"] = "Merci à ces personnes !";
$string["language"] = "Langues";

$string["loginHeader"] = "Bienvenue, %s!";
$string["logout"] = "Se déconnecter";
$string["login"] = "Se connecter";
$string["wrongNickOrPass"] = "Nom d'utilisateur ou mot de passe incorrect !";
$string["invalidid"] = "ID incorrect !";
$string["loginBox"] = "Se connecter";
$string["loginSuccess"] = "Vous vous êtes connecté à votre compte avec succès !";
$string["loginAlready"] = "Vous êtes déjà connecté !";
$string["clickHere"] = "Tableau de bord";
$string["enterUsername"] = "Entrez votre nom d'utilisateur";
$string["enterPassword"] = "Entrez votre mot de passe";
$string["loginDesc"] = "Vous pouvez vous connecter à votre compte ici !";

$string["register"] = "S'inscrire";
$string["registerAcc"] = "Créer un compte";
$string["registerDesc"] = "Créez un compte !";
$string["repeatpassword"] = "Répétez votre mot de passe";
$string["email"] = "Email";
$string["repeatemail"] = "Répétez votre e-mail";
$string["smallNick"] = "Le nom d'utilisateur est trop court !";
$string["smallPass"] = "Le mot de passe est trop court !";
$string["passDontMatch"] = "Les mots de passe ne correspondent pas !";
$string["emailDontMatch"] = "Les e-mails ne correspondent pas !";
$string["registered"] = "Vous avez créé un compte avec succès !";
$string["bigNick"] = "Le nom d'utilisateur est trop long !";
$string["mailExists"] = "Un compte utilise déjà cet e-mail !";
$string["badUsername"] = "Veuillez utiliser un autre nom d'utilisateur.";

$string["changePassTitle"] = "Changer le mot de passe";
$string["changedPass"] = "Votre mot de passe a été modifié avec succès ! Vous devez désormais vous reconnecter.";
$string["wrongPass"] = "Mot de passe incorrect !";
$string["samePass"] = "Ce mot de passe est le même que le précédent !";
$string["changePassDesc"] = "Vous pouvez changer votre mot de passe ici !";
$string["oldPassword"] = "Ancien mot de passe";
$string["newPassword"] = "Nouveau mot de passe";
$string["confirmNew"] = "Confirmer le mot de passe";

$string["forcePassword"] = "Changer le mot de passe d'un autre joueur";
$string["forcePasswordDesc"] = "Ici, vous pouvez changer le mot de passe d'un autre joueur !";
$string["forceNick"] = "Changer le nom d'utilisateur d'un autre joueur";
$string["forceNickDesc"] = "Ici, vous pouvez changer le nom d'utilisateur d'un autre joueur !";
$string["forceChangedPass"] = "Le mot de passe de <b>%s</b> a été changé avec succès !";
$string["forceChangedNick"] = "Le nom d'utilisateur de <b>%s</b> a été changé avec succès !";
$string["changePassOrNick"] = "Changer le nom d'utilisateur ou le mot de passe d'un joueur";

$string["changeNickTitle"] = "Changer le nom d'utilisateur";
$string["changedNick"] = "Votre nom d'utilisateur a été changé avec succès ! Vous devez désormais vous reconnecter.";
$string["wrongNick"] = "Nom d'utilisateur incorrect !";
$string["sameNick"] = "Ce nom d'utilisateur est le même que le précédent !";
$string["alreadyUsedNick"] = "Le nom d'utilisateur que vous avez entré est déjà pris !";
$string["changeNickDesc"] = "Ici, vous pouvez changer votre nom d'utilisateur !";
$string["oldNick"] = "Ancien nom d'utilisateur";
$string["newNick"] = "Nouveau nom d'utilisateur";
$string["password"] = "Mot de passe";

$string["packCreate"] = "Créer un Map Pack";
$string["packCreateTitle"] = "Créer un Map Pack";
$string["packCreateDesc"] = "Ici, vous pouvez créer un Map Pack !";
$string["packCreateSuccess"] = "Vous avez créé un Map Pack appelé";
$string["packCreateOneMore"] = "Un autre Map Pack ?";
$string["packName"] = "Nom du Map Pack";
$string["color"] = "Couleur";
$string["sameLevels"] = "Vous avez choisi les mêmes niveaux !";
$string["show"] = "Montrer.";
$string["packChange"] = "Modifier le Map Pack";
$string["createNewPack"] = "Créer un nouveau Map Pack !"; // Translate word "create" like its call to action

$string["gauntletCreate"] = "Créer un Gauntlet";
$string["gauntletCreateTitle"] = "Créer un Gauntlet";
$string["gauntletCreateDesc"] = "Ici, vous pouvez créer un Gauntlet !";
$string["gauntletCreateSuccess"] = "Vous avez créé un Gauntlet !";
$string["gauntletCreateOneMore"] = "Un autre Gauntlet ?";
$string["chooseLevels"] = "Choisissez des niveaux !";
$string["checkbox"] = "Confirmer";
$string["level1"] = "Niveau 1";
$string["level2"] = "Niveau 2";
$string["level3"] = "Niveau 3";
$string["level4"] = "Niveau 4";
$string["level5"] = "Niveau 5";
$string["gauntletChange"] = "Modifier le Gauntlet";
$string["createNewGauntlet"] = "Créer un nouveau Gauntlet !"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'Vous avez créé le Gauntlet "<b>%1$s</b>" avec succès !';
$string["gauntletSelectAutomatic"] = "Choisir un Gauntlet automatiquement";

$string["addQuest"] = "Ajouter une quête";
$string["addQuestDesc"] = "Ici, vous pouvez ajouter une quête !";
$string["questName"] = "Nom de la quête";
$string["questAmount"] = "Quantité requise";
$string["questReward"] = "Récompense";
$string["questCreate"] = "Créer une quête";
$string["questsSuccess"] = "Vous avez créé une quête avec succès";
$string["invalidPost"] = "Données invalides !";
$string["fewMoreQuests"] = "Il est recommandé de créer quelques quêtes de plus.";
$string["oneMoreQuest?"] = "Une quête de plus ?";
$string["changeQuest"] = "Modifier la quête";
$string["createNewQuest"] = "Créer une nouvelle quête !"; // like gauntlets and mappacks above

$string["levelReupload"] = "Reuploader un niveau";
$string["levelReuploadDesc"] = "Ici, vous pouvez reuploader un niveau de n'importe quel serveur (même d'autres GDPS) !";
$string["advanced"] = "Options avancées";
$string["errorConnection"] = "Erreur de connexion !";
$string["levelNotFound"] = "Ce niveau n'existe pas !";
$string["robtopLol"] = "D'après de sources TRÈS FIABLES, nous avons pu conclure que RobTop ne vous aime pas :c";
$string["sameServers"] = "Le serveur de source et de destination sont les mêmes !";
$string["levelReuploaded"] = "Niveau reuploadé ! ID du niveau:";
$string["oneMoreLevel?"] = "Un autre niveau ?";
$string["levelAlreadyReuploaded"] = "Niveau déjà reuploadé !";
$string["server"] = "Serveur";
$string["levelID"] = "ID du niveau";
$string["pageDisabled"] = "Cette page est désactivée !";
$string["levelUploadBanned"] = "Vous ne pouvez pas uploader d'autres niveaux, car on vous l'a interdit !";

$string["activateAccount"] = "Activation du compte";
$string["activateDesc"] = "Activer votre compte !";
$string["activated"] = "Votre compte a été activé avec succès !";
$string["alreadyActivated"] = "Votre compte est déjà activé";
$string["maybeActivate"] = "Vous n'avez probablement pas activé votre compte.";
$string["activate"] = "Activer";
$string["activateDisabled"] = "L'activation de compte est désactivé !";

$string["addMod"] = "Ajouter un moderateur";
$string["addModDesc"] = "Ici, vous pouvez rendre quelqu'un modérateur de votre GDPS !";
$string["modYourself"] = "Vous ne pouvez pas devenir modérateur vous-même !";
$string["alreadyMod"] = "Ce joueur est déjà un modérateur !";
$string["addedMod"] = "Vous avez donné les permissions de modérateur à un joueur avec succès";
$string["addModOneMore"] = "Un moderateur de plus ?";
$string["modAboveYourRole"] = "Vous ne pouvez pas donner un rôle supérieur au votre !";
$string["makeNewMod"] = "Promouvoir quelqu'un au rôle de moderateur !";
$string["reassignMod"] = "Rétrograder un moderateur"; // man idk how to say it :'( // sorry
$string["reassign"] = "Retirer";
$string['demotePlayer'] = "Rétrograder un joueur";
$string['demotedPlayer'] = "Vous avez rétrograder le joueur <b>%s</b> avec succès !";
$string['addedModNew'] = "Vous avez donné les permissions de modérateur à <b>%s</b> avec succès !";
$string['demoted'] = 'Rétrogradé';

$string["shareCPTitle"] = "Partager des points Créateur";
$string["shareCPDesc"] = "Ici, vous pouvez partager vos points Créateur avec un autre joueur !";
$string["shareCP"] = "Partager";
$string["alreadyShared"] = "Ce niveau à déjà des points Créateur partagé avec ce joueur !";
$string["shareToAuthor"] = "Vous essayez de partager des points Créateur à l'auteur de ce niveau !";
$string["userIsBanned"] = "Ce joueur est banni !";
$string["shareCPOneMore"] = "Un partage de plus?";
$string['shareCPSuccessNew'] = 'Vous avez partagé les points Créateur (CP) du niveau <b>%1$s</b> avec <b>%2$s</b> avec succès !';

$string["messenger"] = "Messages";
$string["write"] = "Écrire";
$string["send"] = "Envoyer";
$string["noMsgs"] = "Commencez une discussion !";
$string["subject"] = "Sujet";
$string["msg"] = "Message";
$string["tooFast"] = "Vous tapez trop vite!";
$string["messengerYou"] = "You:";
$string["chooseChat"] = "Choose chat";

$string["levelToGD"] = "Reupload un niveau vers un autre serveur";
$string["levelToGDDesc"] = "Ici, vous pouvez reuploader un de vos niveaus vers le serveur de destination de votre choix !";
$string["usernameTarget"] = "Nom d'utilisateur sur le serveur de destination";
$string["passwordTarget"] = "Mot de passe sur le serveur de destination";
$string["notYourLevel"] = "Ce n'est pas votre niveau !";
$string["reuploadFailed"] = "Une erreur s'est produite lors du reupload de ce niveau !";

$string["search"] = "Rechercher...";
$string["searchCancel"] = "Annuler la recherche";
$string["emptySearch"] = "Aucun résultat !";

$string["approve"] = 'Approuver';
$string["deny"] = 'Rejeter';
$string["submit"] = 'Soumettre';
$string["place"] = 'Placer';
$string["add"] = 'Ajouter';
$string["demonlistLevel"] = '%s <text class="dltext"> par <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';

$string["didntActivatedEmail"] = 'Vous n\'avez pas activé votre compte par e-mail !';
$string["checkMail"] = 'Vous devriez vérifier votre boîte mail...';

$string["likeSong"] = "Ajouter la musique aux favoris";
$string["dislikeSong"] = "Retirer la musique des favoris";
$string["favouriteSongs"] = "Musiques favorites";
$string["howMuchLiked"] = "Combien ont aimé ?";
$string["nooneLiked"] = "Personne n'a aimé";

$string["clan"] = "Clan";
$string["joinedAt"] = "A rejoint le clan le : <b>%s</b>";
$string["createdAt"] = "A créé le clan le : <b>%s</b>";
$string["clanMembers"] = "Membres du clan";
$string["noMembers"] = "Aucun membre";
$string["clanOwner"] = "Propriétaire du clan";
$string["noClanDesc"] = "<i>Aucune description</i>";
$string["noClan"] = "Ce clan n'existe pas !";
$string["clanName"] = "Nom du clan";
$string["clanTag"] = "Clan tag (3-5 characters)";
$string["clanDesc"] = "Description du clan";
$string["clanColor"] = "Couleur du clan";
$string["dangerZone"] = "Zone de danger";
$string["giveClan"] = "Donner le clan";
$string["deleteClan"] = "Supprimer le clan";
$string["goBack"] = "Revenir en arrière";
$string["areYouSure"] = "Êtes-vous sûr?";
$string["giveClanDesc"] = "Ici, vous pouvez donner votre clan à un autre joueur.";
$string["notInYourClan"] = "Ce joueur n'est pas dans votre clan !";
$string["givedClan"] = "Vous avez donné votre clan à <b>%s</b> avec succès !";
$string["deletedClan"] = "Vous avez supprimé le clan <b>%s</b>.";
$string["deleteClanDesc"] = "Ici vous pouvez supprimer votre clan.";
$string["yourClan"] = "Votre clan";
$string["members0"] = "<b>1</b> membre";
$string["members1"] = "<b>%d</b> membres"; 
$string["members2"] = "<b>%d</b> membres"; 
$string["noRequests"] = "Il n'y a pas de requêtes. Calmez-vous !";
$string["pendingRequests"] = "Requêtes de clan";
$string["closedClan"] = "Clan fermé";
$string["kickMember"] = "Expulser un membre";
$string["leaveFromClan"] = "Quitter le clan";
$string["askToJoin"] = "Envoyer une demande d'adhésion (rejoindre)";
$string["removeClanRequest"] = "Supprimer la demande d'adhésion";
$string["joinClan"] = "Rejoindre le clan";
$string["noClans"] = "Il n'y a pas de clans";
$string["clans"] = "Clans";
$string["alreadyInClan"] = "Vous êtes déjà dans ce clan !";
$string["createClan"] = "Créer le clan";
$string["createdClan"] = "Vous avez créé le clan <span style='font-weight:700;color:#%s'>%s</span> avec succès !";
$string["createClanDesc"] = "Ici vous pouvez créer un clan !";
$string["create"] = "Créer";
$string["mainSettings"] = "Réglages principaux";
$string["takenClanName"] = "Le nom du clan est déjà pris !";
$string["takenClanTag"] = "Ce tag de clan est déjà pris !";
$string["badClanName"] = "Please choose another clan name.";
$string["badClanTag"] = "Please choose another clan tag.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> a suggéré <b>%4$s%3$s</b> pour </text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> a été signalé </text><text class="levelname">%2$s</text>';

$string['listTable'] = "Listes";
$string['listTableMod'] = "Listes non répertoriées";
$string['listTableYour'] = "Vos listes non répertoriées";

$string['forgotPasswordChangeTitle'] = "Changer de mot de passe";
$string["successfullyChangedPass"] = "Votre mot de passe a été modifié avec succès !";
$string['forgotPasswordTitle'] = "Mot de passe oublié ?";
$string['maybeSentAMessage'] = "Nous vous enverrons un message si ce compte existe.";
$string['forgotPasswordDesc'] = "Ici, vous pouvez demander à ce que l'on vous envoie un lien de changement de mot de passe si vous avez oublié le vôtre !";
$string['forgotPasswordButton'] = "Envoyer le lien";

$string['sfxAdd'] = "Ajouter un SFX";
$string["sfxAddError-5"] = "La taille de votre SFX est supérieur à la taille maximale de $sfxSize mégaoctets !";
$string["sfxAddError-6"] = "Quelque chose a mal tourné lors de l'upload du SFX !";
$string["sfxAddError-7"] = "Vous ne pouvez uploader que des fichiers audio !";
$string['sfxAdded'] = 'SFX ajouté';
$string['yourNewSFX'] = "Jetez un coup d'œil à votre SFX !";
$string["sfxAddAnotherBTN"] = "Un autre SFX ?";
$string["sfxAddDesc"] = "Ici, vous pouvez ré-uploader des SFXs !";
$string["chooseSFX"] = "Choisir un SFX";
$string["sfxAddNameFieldPlaceholder"] = "Nom";
$string['sfxs'] = 'SFXs';
$string['sfxID'] = 'ID du SFX';
$string['manageSFX'] = 'Gérer vos SFXs';

$string['featureLevel'] = 'Feature un niveau';

$string['banList'] = 'Liste de joueurs bannis';
$string['expires'] = 'Expire';
$string['unbanPerson'] = 'Déban';
$string['IP'] = 'Adresse IP';
$string['noBanInPast'] = 'Vous ne pouvez pas bannir un joueur avec une date antérieure à celle aujourd\'hui';
$string['banSuccess'] = 'Vous avez banni <b>%1$s</b> avec succès jusqu\'au <b>%3$s</b> dans la catégorie "<b>%2$s</b>" !';
$string['person'] = 'Personne';
$string['youAreBanned'] = 'Vous avez été banni jusqu\'au <b>%2$s</b> pour la raison : <br><b>%1$s</b>';
$string['banChange'] = 'Changer';
$string['system'] = 'Système';

$string['levelComments'] = 'Commentaires du niveau';
$string['levelLeaderboards'] = 'Classements du niveau';
$string['manageLevel'] = 'Gérer le niveau';
$string['noComments'] = 'Aucun commentaire !';
$string['commentHere'] = 'Publier un commentaire...';
$string['weekLeaderboards'] = 'Durant la semaine';
$string['noLeaderboards'] = 'Pas de classement !';
$string['manageLevelDesc'] = 'Ici, vous pouvez gérer les paramètres d\'un niveau !';
$string['silverCoins'] = 'Silver coins';
$string['unlistedLevel'] = 'Niveau non-listé';
$string['lockUpdates'] = 'Vérouiller les mises à jour';
$string['lockCommenting'] = 'Vérouiller les commentaires';
$string['successfullyChangedLevel'] = 'Vous avez changé les paramètres de ce niveau avec succès !';
$string['successfullyDeletedLevel'] = 'Vous avez supprimé ce niveau avec succès !';

$string['resendMailTitle'] = 'Renvoyer un e-mail';
$string['resendMailHint'] = 'Vous n\'avez pas reçu d\'e-mail?';
$string['resendMailDesc'] = 'Ici vous pouvez ré-envoyer un e-mail si vous ne l\'avez pas reçu !';
$string['resendMailButton'] = 'Envoyer l\'e-mail';

$string['automodTitle'] = 'Automod';
$string['possibleLevelsSpamming'] = 'Potentiel spam de niveaux';
$string['disableLevelsUploading'] = 'Désactiver la publication de niveaux';
$string['possibleAccountsSpamming'] = 'Possible spam de comptes';
$string['disableAccountsRegistering'] = 'Désactiver la création de nouveaux comptes';
$string['possibleCommentsSpamming'] = 'Potentiel spam de commentaires';
$string['disableComments'] = 'Désactiver la publication de commentaires';
$string['similarCommentsCount'] = 'Nombre de commentaires similaires';
$string['similarityValueOfAllComments'] = 'Similarité entre tous les commentaires';
$string['possibleCommentsSpammer'] = 'Potentiel spammer de commentaires';
$string['banCommenting'] = 'Interdire la publication de commentaires';
$string['spammerUsername'] = 'Nom d\'utilisateur du spammer';
$string['possibleAccountPostsSpamming'] = 'Potentiel spam de posts';
$string['disablePosting'] = 'Désactiver la publication de posts';
$string['similarPostsCount'] = 'Nombre de posts similaires';
$string['similarityValueOfAllPosts'] = 'Similarité entre tous les posts';
$string['possibleAccountPostsSpammer'] = 'Potentiel spammer de posts';
$string['possibleRepliesSpamming'] = 'Potentiel spam de réponses';
$string['possibleRepliesSpammer'] = 'Potentiel spammer de réponses';
$string['similarRepliesCount'] = 'Nombre de réponses similaires';
$string['similarityValueOfAllReplies'] = 'Similarité entre toutes les réponses';
$string['unknownWarning'] = 'Alerte inconnue';
$string['before'] = 'Avant';
$string['after'] = 'Après';
$string['compare'] = 'Comparer';
$string['resolvedWarning'] = 'Alerte résolue';
$string['resolveWarning'] = 'Marquer l\'alerte comme résolue';
$string['enabled'] = 'Activé';
$string['disabled'] = 'Désactivé';
$string['yesterday'] = 'Hier';
$string['today'] = 'Aujourd\'hui';
$string['uploading'] = 'Publications de niveaux';
$string['commenting'] = 'Commentaires';
$string['leaderboardSubmits'] = 'Soumissions de records';
$string['manageLevels'] = 'Editer les niveaux';
$string['disableLevelsUploading'] = 'Désactiver la publication de niveaux';
$string['disableLevelsCommenting'] = 'Désactiver la publication de commentaires sur les niveaux';
$string['disableLevelsLeaderboardSubmits'] = 'Désactiver la soumission de records sur les classements de niveaux';
$string['disable'] = 'Désactiver';
$string['enable'] = 'Activer';
$string['registering'] = 'Créations de comptes';
$string['accountPosting'] = 'Publications de posts';
$string['updatingProfileStats'] = 'Mises à jour des stats de profil';
$string['messaging'] = 'Envoi de messages instantanés';
$string['manageAccounts'] = 'Gérer les comptes';
$string['disableAccountsRegistering'] = 'Désactiver la création de nouveaux comptes';
$string['disableAccountPosting'] = 'Désactiver la publication de nouveaux posts';
$string['disableUpdatingProfileStats'] = 'Désactiver les mises à jour de stats de profil';
$string['disableMessaging'] = 'Désactiver les messages instantanés';

$string['cantPostCommentsAboveChars'] = 'Vous ne pouvez pas poster de commentaires de plus de %1$s charactères !';
$string['replyingIsDisabled'] = 'La publication de réponses est actuellement désactivée !';
$string['youAreBannedFromCommenting'] = 'Vous êtes interdit de publier de nouveaux commentaires!';
$string['cantPostAccountCommentsAboveChars'] = 'Vous ne pouvez pas publier de posts de plus de %1$s charactères !';
$string['commentingIsDisabled'] = 'La publication de commentaires est actuellement désactivée !';
$string['noWarnings'] = 'Pas d\'avertissements';
$string['messagingIsDisabled'] = 'Direct messages are currently disabled!';

$string['downloadLevelAsGMD'] = 'Enregistrer en .gmd';

$string['songIsAvailable'] = 'Disponible';
$string['songIsDisabled'] = 'Non-disponible';
$string['disabledSongs'] = 'Musiques désactivées';
$string['disabledSFXs'] = 'SFXs désactivés';

$string['vaultCodesTitle'] = 'Ajouter un code secret';
$string['vaultCodeExists'] = 'Un code secret avec ce nom existe déjà !';
$string['reward'] = 'Récompense';
$string['vaultCodePickOption'] = 'Séléctionner le type de récompense';
$string['vaultCodesCreate'] = 'Créer un code secret';
$string['createNewVaultCode'] = 'Créer un nouveau code secret !';
$string['vaultCodesDesc'] = 'Ici, vous pouvez créer un nouveau code secret !';
$string['vaultCodesEditTitle'] = 'Changer le code secret';
$string['vaultCodesEditDesc'] = 'Ici, vous pouvez changer un code secret existant !';
$string['vaultCodeName'] = 'Code secret';
$string['vaultCodeUses'] = 'Nombre d\'utilisations maximum (0 pour une utilisation infinie)';
$string['editRewards'] = 'Modifier les récompenses';
$string['rewards'] = 'Récompenses';

$string['alsoBanIP'] = 'Bannir l\'IP';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Upload";
$string["errorGeneric"] = "Une erreur s'est produite !";
$string["smthWentWrong"] = "Quelque chose a mal tourné !";
$string["tryAgainBTN"] = "Réessayez";
//songAdd.php
$string["songAddDesc"] = "Ici vous pouvez ajouter votre musique !";
$string["songAddUrlFieldLabel"] = "URL de la musique : (Liens direct or Dropbox seulement)";
$string["songAddUrlFieldPlaceholder"] = "URL de la musique";
$string["songAddNameFieldPlaceholder"] = "Nom";
$string["songAddAuthorFieldPlaceholder"] = "Auteur";
$string["songAddButton"] = "Choisir une musique";
$string["songAddAnotherBTN"] = "Une musique de plus?";
$string["songAdded"] = "Musique ajoutée !";
$string["deletedSong"] = "Vous avez supprimé une musique avec succès";
$string["songID"] = "ID de la musique : ";
$string["songIDw"] = "ID de la musique";
$string["songAuthor"] = "Auteur";
$string["size"] = "Taille";
$string["delete"] = "Supprimer";
$string["change"] = "Changer";
$string["chooseFile"] = "Choisir une chanson";
$string['yourNewSong'] = "Jetez un coup d'œil à votre musique !";
///errors
$string["songAddError-2"] = "URL Invalide";
$string["songAddError-3"] = "Cette musique à été déjà reupload avec l'ID :";
$string["songAddError-4"] = "Cette musique ne peut pas être reupload";
$string["songAddError-5"] = "La taille de votre musique est supérieur à la taille maximale de $songSize mégaoctets";
$string["songAddError-6"] = "Quelque chose a mal tourné lors du reupload de la musique ! :с";
$string["songAddError-7"] = "Vous ne pouvez upload que des fichiers audio !";

$string[400] = "Mauvaise requête !";
$string["400!"] = "Vérifiez vos pilotes réseau.";
$string[403] = "Interdit !";
$string["403!"] = "Vous n'avez pas le droit d'accéder à cette page !";
$string[404] = "Page introuvable !";
$string["404!"] = "Êtes-vous sûr d'avoir saisi la bonne URL ?";
$string[500] = "Erreur interne !";
$string["500!"] = "Il y a un problème dans le code,</br>
signalez-le ici :</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Le serveur est en panne !";
$string["502!"] = "La charge sur le serveur est trop grande.</br>
Revennez plus tard !";

$string["invalidCaptcha"] = "Réponse captcha invalide !";
$string["page"] = "Page";
$string["emptyPage"] = "Cette page est vide !";
// Tourner dans le vide vide, tourner dans le vide vide, tourner dans le vide, il me fait tooooouuuurneeer!
/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orbes";
$string["stars"] = "Étoiles";
$string["coins"] = "Pièces";
$string["accounts"] = "Comptes";
$string["levels"] = "Niveaux";
$string["songs"] = "Musiques";
$string["author"] = "Créateur";
$string["name"] = "Nom";
$string["date"] = "Date";
$string["type"] = "Type";
$string["reportCount"] = "Nombre de signalements";
$string["reportMod"] = "Signalements";
$string["username"] = "Nom d'utilisateur";
$string["accountID"] = "ID du compte";
$string["registerDate"] = "Date d'inscription";
$string["isAdminYes"] = "Oui";
$string["isAdminNo"] = "Non";
$string["userCoins"] = "Pièces utilisateur";
$string["time"] = "Temps";
$string["deletedLevel"] = "Niveau(x) supprimé(s)";
$string["mod"] = "Modérateur";
$string["count"] = "Quantité d'actions";
$string["ratedLevels"] = "Niveaux rated (étoilés)";
$string["lastSeen"] = "Dernière fois en ligne";
$string["level"] = "Niveau";
$string["pageInfo"] = "Affichage de la page %s à %s";
$string["first"] = "Début";
$string["previous"] = "Précédent";
$string["next"] = "Prochain";
$string["never"] = "Jamais";
$string["last"] = "Fin";
$string["go"] = "Go";
$string["levelid"] = "ID du niveau";
$string["levelname"] = "Nom du niveau";
$string["leveldesc"] = "Description du niveau";
$string["noDesc"] = "Pas de description";
$string["levelpass"] = "Mot de passe";
$string["nopass"] = "Aucun mot de passe";
$string["unrated"] = "Unrated";
$string["rate"] = "Rated (étoilé)";
$string["stats"] = "Statistiques";
$string["suggestFeatured"] = "En vedette ?";
$string["whoAdded"] = "Qui l'a ajouté ?";
$string["moons"] = "Moons";

$string["banDesc"] = "Ici, tu peux bannir un joueur !";
$string["playerTop"] = 'Meilleurs joueurs';
$string["creatorTop"] = 'Meilleurs créateurs';
$string["levelUploading"] = 'Uploader des niveaux';
$string["successfullyBanned"] = '<b>%1$s</b>, avec l\'ID de compte <b>%2$s</b>, a été banni avec succès !';
$string["successfullyUnbanned"] = '<b>%1$s</b>, avec l\'ID de compte <b>%2$s</b> a été débanni avec succès !';
$string["commentBan"] = 'Commentaires';

$string["player"] = "Joueur";

$string["starsLevel2"] = "étoiles";
$string["starsLevel1"] = "étoiles";
$string["starsLevel0"] = "étoile";
$string["coins1"] = "pièces";
$string["coins0"] = "pièce";
$string["unban"] = "Débannir";
$string["isBan"] = "Bannir";

$string["noCoins"] = "Sans pièces";
$string["noReason"] = "Aucune raison";
$string["noActions"] = "Aucune action";
$string["noRates"] = "Aucun rate";

$string["future"] = "Futur";

$string["spoiler"] = "Spoiler";
$string["accid"] = "avec ID de compte";
$string["banned"] = "a été banni avec succès !";
$string["unbanned"] = "a été débanni avec succès !";
$string["ban"] = "Bannir";
$string["nothingFound"] = "Ce joueur n'existe pas !";
$string["banUserID"] = "Nom d'utilisateur ou ID de compte";
$string["banUserPlace"] = "Bannir un utilisateur";
$string["banYourself"] = "Vous ne pouvez pas vous bannir vous-même !"; 
$string["banYourSelfBtn!"] = "Bannir quelqu'un d'autre";
$string["banReason"] = "Raison du bannissement";
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
$string["modAction11"] = "Partagé les points Créateur";
$string["modAction12"] = "A publié / a cessé de publier le niveau";
$string["modAction13"] = "Changé la description du niveau";
$string["modAction14"] = "Activé/désactivé le LDM";
$string["modAction15"] = "(Dé)Banni du classement";
$string["modAction16"] = "Changement de l'ID d'une musique";
$string["modAction17"] = "A créé un Map Pack";
$string["modAction18"] = "A créé un Gauntlet";
$string["modAction19"] = "A changé une musique";
$string["modAction20"] = "Donné les permissions modérateur à un joueur";
$string["modAction21"] = "Map Pack modifié";
$string["modAction22"] = "Gauntlet modifié";
$string["modAction23"] = "Quête modifiée";
$string["modAction24"] = "Ré-assigné un joueur";
$string["modAction25"] = "A créé une quête";
$string["modAction26"] = "A changé le nom d'utilisateur/mot de passe du joueur";
$string["modAction27"] = "A changé un SFX";
$string["modAction28"] = "Banned person";
$string["modAction29"] = "Locked/unlocked level updating";
$string["modAction30"] = "La liste a été rate";
$string["modAction31"] = "La liste a été sent (envoyé aux modérateurs)";
$string["modAction32"] = "La list a été (ou a eu son) featured (supprimé)";
$string["modAction33"] = "Liste publié (ou enlevé)";
$string["modAction34"] = "Liste supprimé";
$string["modAction35"] = "Changé le créateur de la liste";
$string["modAction36"] = "Changé le nom de la liste";
$string["modAction37"] = "Changé la description de la liste"; // snoring
$string["modAction38"] = "A (dé)vérouiller les commentaires d'un niveau";
$string["modAction39"] = "A (dé)vérouiller les commentaires d'une liste";
$string["modAction40"] = "A enlevé un niveau de la liste des niveaux suggérés";
$string["modAction41"] = "A suggéré un niveau";
$string["modAction42"] = "Created vault code";
$string["modAction43"] = "Changed vault code";
$string["modAction44"] = "Set level as event level";
$string["everyActions"] = "Toutes les actions";
$string["everyMod"] = "Tous les modérateurs";
$string["Kish!"] = "Partez d'ici !";
$string["noPermission"] = "Vous n'avez pas la permission !";
$string["noLogin?"] = "Vous n'êtes pas connecté à votre compte !";
$string["LoginBtn"] = "Se connecter au compte";
$string["dashboard"] = "Tableau de bord";
$string["userID"] = 'ID Utilisateur (userid)';
