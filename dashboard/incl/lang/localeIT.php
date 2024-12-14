<?php
// Translation by @Fenix668

global $dbPath;
require __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Casa";
$string["welcome"] = "Benvenuto a ".$gdps.'!';
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Benvenuto su Dashboard! Ti diamo alcuni suggerimenti dopo l'installazione:<br>
1. Sembra che siano apparsi nuovi permessi in SQL nella tabella 'ruoli'! Si dovrebbe controllare...<br>
2. Se inserisci 'icon.png' nella cartella 'dashboard', l'icona del tuo GDPS apparirà in alto a sinistra!<br>
3. Dovresti configurare config/dashboard.php!";
$string["wwygdt"] = "Che farai oggi?";
$string["game"] = "Gioco";
$string["guest"] = "ospite";
$string["account"] = "Account";
$string["levelsOptDesc"] = "Visualizza l'elenco dei livelli";
$string["songsOptDesc"] = "Visualizza l'elenco dei brani";
$string["yourClanOptDesc"] = "Visualizza i clan \"%s\"";
$string["clanOptDesc"] = "Visualizza l'elenco dei clan";
$string["yourProfile"] = "Il tuo profilo";
$string["profileOptDesc"] = "Visualizza il tuo profilo";
$string["messengerOptDesc"] ="Apri i messaggi";
$string["addSongOptDesc"] = "Aggiungi brano al server";
$string["loginOptDesc"] = "Accedi all'account";
$string["createAcc"] = "Crea un account";
$string["registerOptDesc"] = "Registrati su %s";
$string["downloadOptDesc"] = "Scarica %s";

$string["tryCron"] = "Esegui Cron";
$string["cronSuccess"] = "Eseguito con successo!";
$string["cronError"] = "Errore!";

$string["profile"] = "Profilo";
$string["empty"] = "Vuoto...";
$string["writeSomething"] = "Scrivi qualcosa!";  
$string["replies"] = "Risposte";
$string["replyToComment"] = "Rispondi a un commento";
$string["settings"] = "Impostazioni";
$string["allowMessagesFrom"] = "Consenti messaggi da...";
$string["allowFriendReqsFrom"] = "Consenti richieste di amicizia da...";
$string["showCommentHistory"] = "Mostra la cronologia dei commenti...";
$string["timezoneChoose"] = "Scegli il fuso orario";
$string["yourYouTube"] = "Il tuo canale YouTube";
$string["yourVK"] = "La tua pagina su VK";
$string["yourTwitter"] = "La tua pagina su Twitter";
$string["yourTwitch"] = "Il tuo canale Twitch";
$string["saveSettings"] = "Salva le impostazioni";
$string["all"] = "Tutto";
$string["friends"] = "Amici";
$string["none"] = "Nessuno";
$string["youBlocked"] = "Questo giocatore ti ha bloccato!";
$string["cantMessage"] = "Non puoi inviare messaggi a questo giocatore!";
  
$string["accountManagement"] = "Gestione account";
$string["changePassword"] = "Cambia la password";
$string["changeUsername"] = "Cambia nome utente";
$string["unlistedLevels"] = "I tuoi livelli non elencati";

$string["manageSongs"] = "Gestisci i brani";
$string["gauntletManage"] = "Gestisci i gauntlets";
$string["suggestLevels"] = "Livelli suggeriti";

$string["modTools"] = "Strumenti di moderazione";
$string["leaderboardBan"] = "Banna un utente";
$string["unlistedMod"] = "Livelli non elencati";

$string["reuploadSection"] = "Ricarica";
$string["songAdd"] = "Aggiungi un brano";
$string["songLink"] = "Aggiungi un brano tramite link";
$string["packManage"] = "Gestisci i map pack";

$string["browse"] = "Naviga";
$string["statsSection"] = "Statistiche";
$string["dailyTable"] = "Livelli giornalieri";
$string["modActionsList"] = "Azioni mod";
$string["modActions"] = "Moderatori del server";
$string["gauntletTable"] = "Elenco dei gauntlet";
$string["packTable"] = "Elenco dei map pack";
$string["leaderboardTime"] = "Avanzamento delle classifiche";

$string["download"] = "Scarica";
$string["forwindows"] = "Per Windows";
$string["forandroid"] = "Per Android";
$string["formac"] = "Per Mac";
$string["forios"] = "Per iOS";
$string["third-party"] = "Terze parti";
$string["thanks"] = "Grazie a queste persone!";
$string["language"] = "Lingua";

$string["loginHeader"] = "Benvenuto/a, %s!";
$string["logout"] = "Disconnettiti";
$string["login"] = "Accedi";
$string["wrongNickOrPass"] = "Nome utente o password errati!";
$string["invalidid"] = "ID non valido!";
$string["loginBox"] = "Accedi all'account";
$string["loginSuccess"] = "Hai effettuato correttamente l'accesso al tuo account!";
$string["loginAlready"] = "Hai già effettuato l'accesso!";
$string["clickHere"] = "Pannello di controllo";
$string["enterUsername"] = "Inserisci nome utente";
$string["enterPassword"] = "Inserisci la password";
$string["loginDesc"] = "Qui puoi accedere al tuo account!";

$string["register"] = "Registrati";
$string["registerAcc"] = "Registrazione dell'account";
$string["registerDesc"] = "Registra il tuo account!";
$string["repeatpassword"] = "Ripeti la password";
$string["email"] = "Email";
$string["repeatemail"] = "Conferma email";
$string["smallNick"] = "Il nome utente è troppo piccolo!";
$string["smallPass"] = "La password è troppo piccola!";
$string["passDontMatch"] = "Le password non corrispondono!";
$string["emailDontMatch"] = "Le email non corrispondono";
$string["registered"] = "Hai registrato con successo un account!";
$string["bigNick"] = "Il nome utente è troppo lungo!";
$string["mailExists"] = "C'è un account registrato che utilizza questa email!";
$string["badUsername"] = "Scegli un altro nome utente.";

$string["changePassTitle"] = "Cambia la password";
$string["changedPass"] = "Password cambiata con successo! Devi accedere nuovamente al tuo account.";
$string["wrongPass"] = "Password errata!";
$string["samePass"] = "Le password che hai inserito sono le stesse!";
$string["changePassDesc"] = "Qui puoi cambiare la tua password!";
$string["oldPassword"] = "Vecchia password";
$string["newPassword"] = "Nuova password";
$string["confirmNew"] = "Conferma password";

$string["forcePassword"] = "Forza la modifica della password";
$string["forcePasswordDesc"] = "Qui puoi forzare la modifica della password del giocatore!";
$string["forceNick"] = "Forza il cambio nome utente";
$string["forceNickDesc"] = "Qui puoi forzare il cambio del nome utente del giocatore!";
$string["forceChangedPass"] = "La password di <b>%s</b> è stata modificata con successo!";
$string["forceChangedNick"] = "Il nome utente di <b>%s</b> è stato modificato con successo!";
$string["changePassOrNick"] = "Cambia nome utente o la password di qualcuno";

$string["changeNickTitle"] = "Cambia nome utente";
$string["changedNick"] = "Nome utente modificato con successo! Devi accedere nuovamente al tuo account.";
$string["wrongNick"] = "Nome utente sbagliato!";
$string["sameNick"] = "I nomi utente che hai inserito sono gli stessi!";
$string["alreadyUsedNick"] = "Il nome utente che hai inserito è già occupato!";
$string["changeNickDesc"] = "Qui puoi cambiare il tuo nome utente!";
$string["oldNick"] = "Vecchio nome utente";
$string["newNick"] = "Nuovo nome utente";
$string["password"] = "Password";

$string["packCreate"] = "Crea un map pack";
$string["packCreateTitle"] = "Crea un map pack";
$string["packCreateDesc"] = "Qui puoi creare un map pack!";
$string["packCreateSuccess"] = "Hai creato con successo un map pack chiamato";
$string["packCreateOneMore"] = "Un altro map pack?";
$string["packName"] = "Nome del map pack";
$string["color"] = "Colore";
$string["sameLevels"] = "Hai scelto gli stessi livelli!";
$string["show"] = "Mostra";
$string["packChange"] = "Cambia map pack";
$string["createNewPack"] = "Crea un nuovo map pack!"; // Translate word "create" like its call to action

$string["gauntletCreate"] = "Crea gauntlet";
$string["gauntletCreateTitle"] = "Crea gauntlet";
$string["gauntletCreateDesc"] = "Qui puoi creare un gauntlet!";
$string["gauntletCreateSuccess"] = "Hai creato con successo un gauntlet!";
$string["gauntletCreateOneMore"] = "Un altro gauntlet?";
$string["chooseLevels"] = "Scegli i livelli!";
$string["checkbox"] = "Conferma";
$string["level1"] = "Primo livello";
$string["level2"] = "Secondo livello";
$string["level3"] = "Terzo livello";
$string["level4"] = "Quarto livello";
$string["level5"] = "Quinto livello";
$string["gauntletChange"] = "Cambia gauntlet";
$string["createNewGauntlet"] = "Crea un nuovo gauntlet!"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'Hai creato <b>%1$s</b> con successo!';
$string["gauntletSelectAutomatic"] = "Scegli Gauntlet automaticamente";

$string["addQuest"] = "Aggiungi missione";
$string["addQuestDesc"] = "Qui puoi creare una missione!";
$string["questName"] = "Nome della missione";
$string["questAmount"] = "Importo richiesto";
$string["questReward"] = "Ricompensa";
$string["questCreate"] = "Crea una missione";
$string["questsSuccess"] = "Hai creato con successo una missione";
$string["invalidPost"] = "Dati non validi!";
$string["fewMoreQuests"] = "Si consiglia di creare qualche missione in più.";
$string["oneMoreQuest?"] = "Un'altra missione?";
$string["changeQuest"] = "Cambia missione";
$string["createNewQuest"] = "Crea una nuova missione!"; // like gauntlets and mappacks above

$string["levelReupload"] = "Ricarica il livello";
$string["levelReuploadDesc"] = "Qui puoi ricaricare un livello da qualsiasi server!";
$string["advanced"] = "Opzioni avanzate";
$string["errorConnection"] = "Errore di connessione!";
$string["levelNotFound"] = "Questo livello non esiste!";
$string["robtopLol"] = "A RobTop non piaci :c";
$string["sameServers"] = "Il server host e il server di destinazione sono gli stessi!";
$string["levelReuploaded"] = "Livello ricaricato! ID livello:";
$string["oneMoreLevel?"] = "Vuoi ricaricare un livello in più?";
$string["levelAlreadyReuploaded"] = "Livello già ricaricato!";
$string["server"] = "Server";
$string["levelID"] = "ID del livello";
$string["pageDisabled"] = "Questa pagina è disabilitata!";
$string["levelUploadBanned"] = "Ti è stato vietato caricare livelli!";

$string["activateAccount"] = "Attivazione dell'account";
$string["activateDesc"] = "Attiva il tuo account!";
$string["activated"] = "Il tuo account è stato attivato con successo!";
$string["alreadyActivated"] = "Il tuo account è già attivato";
$string["maybeActivate"] = "Forse non hai ancora attivato il tuo account.";
$string["activate"] = "Attiva";
$string["activateDisabled"] = "L'attivazione dell'account è disabilitata!";

$string["addMod"] = "Aggiungi moderatore";
$string["addModDesc"] = "Qui puoi promuovere qualcuno a Moderatore!";
$string["modYourself"] = "Non puoi concederti il ruolo di Moderatore!";
$string["alreadyMod"] = "Questo giocatore è già un moderatore!";
$string["addedMod"] = "Hai concesso con successo il ruolo di moderatore a un giocatore";
$string["addModOneMore"] = "Un moderatore in più?";
$string["modAboveYourRole"] = "Stai cercando di dare un ruolo superiore al tuo!";
$string["makeNewMod"] = "Rendi qualcuno moderatore!";
$string["reassignMod"] = "Riassegnare il moderatore";
$string["reassign"] = "Riassegna";
$string['demotePlayer'] = "Espelli il giocatore dai mod";
$string['demotedPlayer'] = "Hai espulso con successo <b>%s</b>!";
$string['addedModNew'] = "Hai promosso con successo <b>%s</b> a moderatore!";
$string['demoted'] = 'Espulso';

$string["shareCPTitle"] = "Condividi punti creatore";
$string["shareCPDesc"] = "Qui puoi condividere i punti creatore con il giocatore!";
$string["shareCP"] = "Condividi";
$string["alreadyShared"] = "Questo livello ha già condiviso CP con questo giocatore!";
$string["shareToAuthor"] = "Hai provato a condividere CP con l'autore del livello!";
$string["userIsBanned"] = "Questo giocatore è bannato!";
$string["shareCPOneMore"] = "Un'altra condivisione?";
$string['shareCPSuccessNew'] = 'Hai condiviso con successo i punti creatore del livello <b>%1$s</b> con il giocatore <b>%2$s</b>!';

$string["messenger"] = "Messaggi";
$string["write"] = "Scrivi";
$string["send"] = "Invia";
$string["noMsgs"] = "Inizia il dialogo!";
$string["subject"] = "Soggetto";
$string["msg"] = "Messaggio";
$string["tooFast"] = "Stai digitando troppo velocemente!";
$string["messengerYou"] = "Tu:";
$string["chooseChat"] = "Scegli la chat";

$string["levelToGD"] = "Ricarica il livello sul server di destinazione";
$string["levelToGDDesc"] = "Qui puoi ricaricare il tuo livello sul server di destinazione!";
$string["usernameTarget"] = "Nome utente per il server di destinazione";
$string["passwordTarget"] = "Password per il server di destinazione";
$string["notYourLevel"] = "Questo non è il tuo livello!";
$string["reuploadFailed"] = "Errore di ricaricamento del livello!";

$string["search"] = "Ricerca...";
$string["searchCancel"] = "Annulla la ricerca";
$string["emptySearch"] = "Non abbiamo trovato nulla!";

$string["approve"] = 'Approva';
$string["deny"] = 'Rifiuta';
$string["submit"] = 'Invia';
$string["place"] = 'Posto';
$string["add"] = 'Aggiungi';
$string["demonlistLevel"] = '%s <text class="dltext">di <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';

$string["didntActivatedEmail"] = 'Non hai attivato il tuo account tramite email!';
$string["checkMail"] = 'Dovresti controllare la tua email...';

$string["likeSong"] = "Aggiungi il brano ai preferiti";
$string["dislikeSong"] = "Rimuovi il brano dai preferiti";
$string["favouriteSongs"] = "Brani preferiti";
$string["howMuchLiked"] = "Quanto è piaciuto?";
$string["nooneLiked"] = "A nessuno è piaciuto";

$string["clan"] = "Clan";
$string["joinedAt"] = "Unito al clan a: <b>%s</b>";
$string["createdAt"] = "Clan creato a: <b>%s</b>";
$string["clanMembers"] = "Membri del clan";
$string["noMembers"] = "Nessun membro";
$string["clanOwner"] = "Proprietario del clan";
$string["noClanDesc"] = "<i>Nessuna descrizione</i>";
$string["noClan"] = "Questo clan non esiste!";
$string["clanName"] = "Nome del clan";
$string["clanTag"] = "Tag del clan (3-5 caratteri)";
$string["clanDesc"] = "Descrizione del clan";
$string["clanColor"] = "Colore del clan";
$string["dangerZone"] = "Zona pericolosa";
$string["giveClan"] = "Dai clan";
$string["deleteClan"] = "Elimina clan";
$string["goBack"] = "Torna indietro";
$string["areYouSure"] = "Sei sicuro?";
$string["giveClanDesc"] = "Qui puoi dare il tuo clan a un giocatore.";
$string["notInYourClan"] = "Questo giocatore non è nel tuo clan!";
$string["givedClan"] = "Hai ceduto con successo il tuo clan a <b>%s</b>!";
$string["deletedClan"] = "Hai eliminato il clan <b>%s</b>.";
$string["deleteClanDesc"] = "Qui puoi eliminare il tuo clan.";
$string["yourClan"] = "Il tuo clan";
$string["members0"] = "<b>1</b> membro";
$string["members1"] = "<b>%d</b> membri"; 
$string["members2"] = "<b>%d</b> membri"; 
$string["noRequests"] = "Non ci sono richieste. Rilassati!";
$string["pendingRequests"] = "Richieste del clan";
$string["closedClan"] = "Clan chiuso";
$string["kickMember"] = "Calcia un membro";
$string["leaveFromClan"] = "Abbandona il clan";
$string["askToJoin"] = "Invia richiesta di adesione";
$string["removeClanRequest"] = "Elimina la richiesta di adesione";
$string["joinClan"] = "Unisciti al clan";
$string["noClans"] = "Non ci sono clan";
$string["clans"] = "Clan";
$string["alreadyInClan"] = "Sei già nel clan!";
$string["createClan"] = "Crea clan";
$string["createdClan"] = "Hai creato con successo il clan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Qui puoi creare un clan!";
$string["create"] = "Crea";
$string["mainSettings"] = "Impostazioni principali";
$string["takenClanName"] = "Il nome di questo clan è già stato preso!";
$string["takenClanTag"] = "Questo tag clan è già stato preso!";
$string["badClanName"] = "Scegli un altro nome del clan.";
$string["badClanTag"] = "Scegli un altro tag del clan.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> suggerisce <b>%4$s%3$s</b> per</text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> è stato segnalato</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Liste";
$string['listTableMod'] = "Liste non elencate";
$string['listTableYour'] = "Le tue liste non elencate";

$string['forgotPasswordChangeTitle'] = "Cambia la password";
$string["successfullyChangedPass"] = "La password è stata modificata con successo!";
$string['forgotPasswordTitle'] = "Hai dimenticato la password?";
$string['maybeSentAMessage'] = "Ti invieremo un messaggio se questo account esiste.";
$string['forgotPasswordDesc'] = "Qui puoi richiedere il link per cambiare la password se l'hai dimenticata!";
$string['forgotPasswordButton'] = "Richiedi collegamento";

$string['sfxAdd'] = "Aggiungi effetti sonori";
$string["sfxAddError-5"] = "La dimensione di SFX è superiore ai megabyte di $sfxSize!";
$string["sfxAddError-6"] = "Qualcosa è andato storto durante il caricamento degli SFX!";
$string["sfxAddError-7"] = "Puoi caricare solo audio!";
$string['sfxAdded'] = 'Aggiunti effetti sonori';
$string['yourNewSFX'] = "Dai un'occhiata ai tuoi nuovi effetti sonori!";
$string["sfxAddAnotherBTN"] = "Un altro effetto sonoro?";
$string["sfxAddDesc"] = "Qui puoi aggiungere i tuoi effetti sonori!";
$string["chooseSFX"] = "Scegli effetti sonori";
$string["sfxAddNameFieldPlaceholder"] = "Nome";
$string['sfxs'] = 'Effetti sonori';
$string['sfxID'] = 'ID effetto sonoro';
$string['manageSFX'] = 'Gestisci gli effetti sonori';

$string['featureLevel'] = 'Livelli in primo piano';

$string['banList'] = 'Elenco delle persone vietate';
$string['expires'] = 'Scade';
$string['unbanPerson'] = 'Sbanna';
$string['IP'] = 'Indirizzo IP';
$string['noBanInPast'] = 'Non puoi bannare fino a quando non sarà passato!';
$string['banSuccess'] = 'Hai bannato con successo <b>%1$s</b> fino al <b>%3$s</b> a «<b>%2$s</b>»!';
$string['person'] = 'Persona';
$string['youAreBanned'] = 'Sei stato bannato fino al <b>%2$s</b> per il motivo:<br><b>%1$s</b>';
$string['banChange'] = 'Modifica';
$string['system'] = 'Sistema';

$string['levelComments'] = 'Commenti del livello';
$string['levelLeaderboards'] = 'Classifiche del livello';
$string['manageLevel'] = 'Gestisci il livello';
$string['noComments'] = 'Non ci sono commenti!';
$string['commentHere'] = 'Pubblica commento...';
$string['weekLeaderboards'] = 'Per una settimana';
$string['noLeaderboards'] = 'Nessuna classifica!';
$string['manageLevelDesc'] = 'Qui puoi cambiare livello!';
$string['silverCoins'] = 'Monete d\'argento';
$string['unlistedLevel'] = 'Livello non in elenco';
$string['lockUpdates'] = 'Blocca l\'aggiornamento';
$string['lockCommenting'] = 'Blocca i commenti';
$string['successfullyChangedLevel'] = 'Hai cambiato livello con successo!';
$string['successfullyDeletedLevel'] = 'Hai eliminato il livello con successo!';

$string['resendMailTitle'] = 'Send email message again';
$string['resendMailHint'] = 'Didn\'t get mail message?';
$string['resendMailDesc'] = 'Here you can send email message again if you didn\'t get it!';
$string['resendMailButton'] = 'Send message';

$string['automodTitle'] = 'Automod';
$string['possibleLevelsSpamming'] = 'Possible levels spamming';
$string['disableLevelsUploading'] = 'Disable levels uploading';
$string['possibleAccountsSpamming'] = 'Possible accounts spamming';
$string['disableAccountsRegistering'] = 'Disable registering accounts';
$string['possibleCommentsSpamming'] = 'Possible comments spamming';
$string['disableComments'] = 'Disable commenting';
$string['similarCommentsCount'] = 'Similar comments count';
$string['similarityValueOfAllComments'] = 'Similarity value out of all comments';
$string['possibleCommentsSpammer'] = 'Possible comments spammer';
$string['banCommenting'] = 'Ban commenting';
$string['spammerUsername'] = 'Spammer\'s username';
$string['possibleAccountPostsSpamming'] = 'Possible account posts spamming';
$string['disablePosting'] = 'Disable posting';
$string['similarPostsCount'] = 'Similar posts count';
$string['similarityValueOfAllPosts'] = 'Similarity value out of all posts';
$string['possibleAccountPostsSpammer'] = 'Possible account posts spammer';
$string['possibleRepliesSpamming'] = 'Possible replies spamming';
$string['possibleRepliesSpammer'] = 'Possible replies spammer';
$string['similarRepliesCount'] = 'Similar replies count';
$string['similarityValueOfAllReplies'] = 'Similarity value out of all replies';
$string['unknownWarning'] = 'Unknown warning';
$string['before'] = 'Before';
$string['after'] = 'After';
$string['compare'] = 'Compare';
$string['resolvedWarning'] = 'Resolved warning';
$string['resolveWarning'] = 'Resolve warning';
$string['enabled'] = 'Enabled';
$string['disabled'] = 'Disabled';
$string['yesterday'] = 'Yesterday';
$string['today'] = 'Today';
$string['uploading'] = 'Uploading';
$string['commenting'] = 'Commenting';
$string['leaderboardSubmits'] = 'Leaderboard submits';
$string['manageLevels'] = 'Manage levels';
$string['disableLevelsUploading'] = 'Disable levels uploading';
$string['disableLevelsCommenting'] = 'Disable levels commenting';
$string['disableLevelsLeaderboardSubmits'] = 'Disable levels leaderboard submits';
$string['disable'] = 'Disable';
$string['enable'] = 'Enable';
$string['registering'] = 'Registering';
$string['accountPosting'] = 'Making account posts';
$string['updatingProfileStats'] = 'Updating profile stats';
$string['messaging'] = 'Messaging';
$string['manageAccounts'] = 'Manage accounts';
$string['disableAccountsRegistering'] = 'Disable registering new accounts';
$string['disableAccountPosting'] = 'Disable making account posts';
$string['disableUpdatingProfileStats'] = 'Disable updating profile stats';
$string['disableMessaging'] = 'Disable messaging';

$string['cantPostCommentsAboveChars'] = 'You cannot post comments above %1$s characters!';
$string['replyingIsDisabled'] = 'Replying to comments is currently disabled!';
$string['youAreBannedFromCommenting'] = 'You are banned from commenting!';
$string['cantPostAccountCommentsAboveChars'] = 'You cannot post account comments above %1$s characters!';
$string['commentingIsDisabled'] = 'Commenting is currently disabled!';
$string['noWarnings'] = 'No warnings';
$string['messagingIsDisabled'] = 'Direct messages are currently disabled!';

$string['downloadLevelAsGMD'] = 'Save as .gmd';

$string['songIsAvailable'] = 'Available';
$string['songIsDisabled'] = 'Not available';
$string['disabledSongs'] = 'Disabled songs';
$string['disabledSFXs'] = 'Disabled SFXs';

$string['vaultCodesTitle'] = 'Add vault code';
$string['vaultCodeExists'] = 'Code with this name already exists!';
$string['reward'] = 'Reward';
$string['vaultCodePickOption'] = 'Choose reward type';
$string['vaultCodesCreate'] = 'Create code';
$string['createNewVaultCode'] = 'Create new code!';
$string['vaultCodesDesc'] = 'Here you can create new code!';
$string['vaultCodesEditTitle'] = 'Change vault code';
$string['vaultCodesEditDesc'] = 'Here you can change already existing code!';
$string['vaultCodeName'] = 'Code';
$string['vaultCodeUses'] = 'Number of uses (0 for infinite uses)';
$string['editRewards'] = 'Change rewards';
$string['rewards'] = 'Rewards';

$string['alsoBanIP'] = 'Also ban IP';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Carica";
$string["errorGeneric"] = "È apparso l'errore!";
$string["smthWentWrong"] = "Qualcosa è andato storto!";
$string["tryAgainBTN"] = "Riprova";
//songAdd.php
$string["songAddDesc"] = "Qui puoi aggiungere il tuo brano!";
$string["songAddUrlFieldLabel"] = "URL del brano: (solo collegamenti diretti o Dropbox)";
$string["songAddUrlFieldPlaceholder"] = "URL del brano";
$string["songAddNameFieldPlaceholder"] = "Nome";
$string["songAddAuthorFieldPlaceholder"] = "Autore";
$string["songAddButton"] = "Scegli il brano";
$string["songAddAnotherBTN"] = "Un altro brano?";
$string["songAdded"] = "Brano aggiunto";
$string["deletedSong"] = "Hai eliminato il brano con successo";
$string["songID"] = "ID del brano: ";
$string["songIDw"] = "ID del brano";
$string["songAuthor"] = "Autore";
$string["size"] = "Dimensione";
$string["delete"] = "Elimina";
$string["change"] = "Modifica";
$string["chooseFile"] = "Scegli un brano";
$string['yourNewSong'] = "Dai un'occhiata al tuo nuovo brano!";
///errors
$string["songAddError-2"] = "URL non valido";
$string["songAddError-3"] = "Questa canzone è stata già ricaricata con ID:";
$string["songAddError-4"] = "Questa canzone non è ricaricabile";
$string["songAddError-5"] = "La dimensione del brano è superiore a $songSize megabyte";
$string["songAddError-6"] = "Qualcosa è andato storto durante il caricamento di una canzone!";
$string["songAddError-7"] = "Puoi caricare solo audio!";

$string[400] = "Brutta richiesta!";
$string["400!"] = "Controlla i driver dell'hardware di rete.";
$string[403] = "Vietato!";
$string["403!"] = "Non hai accesso a questa pagina!";
$string[404] = "Pagina non trovata!";
$string["404!"] = "Sei sicuro di aver digitato l'indirizzo correttamente?";
$string[500] = "Errore interno del server!";
$string["500!"] = "Il programmatore ha commesso un errore nel codice,</br>
per favore parla di questo problema qui:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Il server è caduto!";
$string["502!"] = "Il carico sul server è troppo grande.</br>
Torna più tardi entro qualche ora!";

$string["invalidCaptcha"] = "Risposta captcha non valida!";
$string["page"] = "Pagina";
$string["emptyPage"] = "Questa pagina è vuota!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Sfere";
$string["stars"] = "Stelle";
$string["coins"] = "Monete";
$string["accounts"] = "Account";
$string["levels"] = "Livelli";
$string["songs"] = "Brani";
$string["author"] = "Creatore";
$string["name"] = "Nome";
$string["date"] = "Data";
$string["type"] = "Tipo";
$string["reportCount"] = "Conteggio delle segnalazioni";
$string["reportMod"] = "Segnalazioni";
$string["username"] = "Nome utente";
$string["accountID"] = "ID dell'account";
$string["registerDate"] = "Data di registrazione";
$string["levelAuthor"] = "Autore del livello";
$string["isAdmin"] = "Ruolo sul server";
$string["isAdminYes"] = "Si";
$string["isAdminNo"] = "No";
$string["userCoins"] = "Monete utente";
$string["time"] = "Tempo";
$string["deletedLevel"] = "Livello eliminato";
$string["mod"] = "Moderatore";
$string["count"] = "Quantità di azioni";
$string["ratedLevels"] = "Livelli nominali";
$string["lastSeen"] = "L'ultima volta online";
$string["level"] = "Livello";
$string["pageInfo"] = "Visualizzazione della pagina %s di %s";
$string["first"] = "Primo";
$string["previous"] = "Precedente";
$string["next"] = "Prossimo";
$string["never"] = "Mai";
$string["last"] = "Ultimo";
$string["go"] = "Vai";
$string["levelid"] = "ID del livello";
$string["levelname"] = "Nome del livello";
$string["leveldesc"] = "Descrizione del livello";
$string["noDesc"] = "Nessuna descrizione";
$string["levelpass"] = "Password";
$string["nopass"] = "Nessuna password";
$string["unrated"] = "Senza votazione";
$string["rate"] = "Votazione";
$string["stats"] = "Stelle";
$string["suggestFeatured"] = "In primo piano?";
$string["whoAdded"] = "Chi ha aggiunto?";
$string["moons"] = "Lune";

$string["banDesc"] = "Qui puoi bannare un giocatore!";
$string["playerTop"] = 'Classifica dei giocatori';
$string["creatorTop"] = 'Classifica dei creatori';
$string["levelUploading"] = 'Caricamento livelli';
$string["successfullyBanned"] = 'Il giocatore <b>%1$s</b> con ID account <b>%2$s</b> è stato bannato con successo!';
$string["successfullyUnbanned"] = 'Il giocatore <b>%1$s</b> con ID account <b>%2$s</b> è stato sbloccato con successo!';
$string["commentBan"] = 'Commentando';

$string["player"] = "Giocatore";

$string["starsLevel2"] = "stelle";
$string["starsLevel1"] = "stelle";
$string["starsLevel0"] = "stella";
$string["coins1"] = "monete";
$string["coins0"] = "moneta";
$string["unban"] = "Sbanna";
$string["isBan"] = "Banna";

$string["noCoins"] = "Senza monete";
$string["noReason"] = "Nessuna ragione";
$string["noActions"] = "Nessuna azione";
$string["noRates"] = "Nessuna valutazione";

$string["future"] = "Futuro";

$string["spoiler"] = "Spoiler";
$string["accid"] = "con ID dell'account";
$string["banned"] = "è stato bannato con successo!";
$string["unbanned"] = "è stato sbloccato con successo!";
$string["ban"] = "Banna";
$string["nothingFound"] = "Questo giocatore non esiste!";
$string["banUserID"] = "Nome utente o ID account";
$string["banUserPlace"] = "Banna un utente";
$string["banYourself"] = "Non puoi bannarti!"; 
$string["banYourSelfBtn!"] = "Banna qualcun altro";
$string["banReason"] = "Motivo del ban";
$string["action"] = "Azione";
$string["value"] = "Primo valore";
$string["value2"] = "Secondo valore";
$string["value3"] = "Terzo valore";
$string["modAction1"] = "Valutato un livello";
$string["modAction2"] = "Livello featured/unfeatured";
$string["modAction3"] = "Monete verificate/non verificate";
$string["modAction4"] = "Livello epico/non epico";
$string["modAction5"] = "Imposta come funzionalità quotidiana";
$string["modAction6"] = "Eliminato un livello";
$string["modAction7"] = "Cambiamento del Creatore";
$string["modAction8"] = "Rinominato un livello";
$string["modAction9"] = "Password del livello modificata";
$string["modAction10"] = "Difficoltà del demon modificata";
$string["modAction11"] = "CP condiviso";
$string["modAction12"] = "Livello non/pubblicato";
$string["modAction13"] = "Descrizione del livello modificata";
$string["modAction14"] = "LDM abilitato/disabilitato";
$string["modAction15"] = "Classifica non/vietata";
$string["modAction16"] = "Modifica dell'ID del brano";
$string["modAction17"] = "Creato un map pack";
$string["modAction18"] = "Creato un gauntlet";
$string["modAction19"] = "Brano cambiato";
$string["modAction20"] = "Concesso un moderatore al giocatore";
$string["modAction21"] = "Map pack modificato";
$string["modAction22"] = "Gauntlet modificato";
$string["modAction23"] = "Missione modificata";
$string["modAction24"] = "Riassegnato un giocatore";
$string["modAction25"] = "Creata una missione";
$string["modAction26"] = "Nome utente/password del giocatore modificati";
$string["modAction27"] = "Effetti sonori modificati";
$string["modAction28"] = "Persona bannata";
$string["modAction29"] = "Aggiornamento del livello bloccato/sbloccato";
$string["modAction30"] = "Elenco valutato";
$string["modAction31"] = "Elenco inviato";
$string["modAction32"] = "Elenco non/in primo piano";
$string["modAction33"] = "Elenco non/pubblicato";
$string["modAction34"] = "Elenco eliminato";
$string["modAction35"] = "Creatore dell'elenco modificato";
$string["modAction36"] = "Nome della lista cambiato";
$string["modAction37"] = "Descrizione della lista modificata";
$string["modAction38"] = "Commenti del livello bloccati/sbloccati";
$string["modAction39"] = "Commenti lista bloccata/sbloccata";
$string["modAction40"] = "Removed sent level";
$string["modAction41"] = "Suggested level";
$string["modAction42"] = "Created vault code";
$string["modAction43"] = "Changed vault code";
$string["modAction44"] = "Set level as event level";
$string["everyActions"] = "Qualsiasi azione";
$string["everyMod"] = "Tutti i moderatori";
$string["Kish!"] = "Vai via!";
$string["noPermission"] = "Non hai il permesso!";
$string["noLogin?"] = "Non hai effettuato l'accesso al tuo account!";
$string["LoginBtn"] = "Accedi all'account";
$string["dashboard"] = "Ritorna al pannello";
$string["userID"] = 'ID utente';