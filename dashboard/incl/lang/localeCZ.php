<?php
global $dbPath;
require __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Domov";
$string["welcome"] = "Vítejte v ".$gdps.'!';
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Vítejte v Dashboard! Dáváme vám pár poinstalačních rad:<br>
1. Vypadá to, že se nová oprávnění objevila v SQL v 'roles' tabulce! Měli byste se podívat...<br>
2. Jestli dáte soubor 'icon.png' do 'dashboard' složky, měla by se ikona vašeho GDPS objevit vlevo nahoře!<br>
3. Měli byste konfigurovat config/dashboard.php!";
$string["wwygdt"] = "Co byste chtěli dnes udělat?";
$string["game"] = "Hra";
$string["guest"] = "host";
$string["account"] = "Účet";
$string["levelsOptDesc"] = "Zobrazit seznam úrovní";
$string["songsOptDesc"] = "Zobrazit seznam skladeb";
$string["yourClanOptDesc"] = "Zobrazit klan \"%s\"";
$string["clanOptDesc"] = "Zobrazit seznam klanů";
$string["yourProfile"] = "Váš profil";
$string["profileOptDesc"] = "Zobrazit váš profil";
$string["messengerOptDesc"] ="Otevřít messenger";
$string["addSongOptDesc"] = "Přidat skladbu na server";
$string["loginOptDesc"] = "Přihlásit se na učet";
$string["createAcc"] = "Vytvořit účet";
$string["registerOptDesc"] = "Registrovat se na %s";
$string["downloadOptDesc"] = "Stáhnout %s";

$string["tryCron"] = "Spustit Cron";
$string["cronSuccess"] = "Úspěch!";
$string["cronError"] = "Chyba!";

$string["profile"] = "Profil";
$string["empty"] = "Prázdno...";
$string["writeSomething"] = "Napište něco!";  
$string["replies"] = "Odpovědi";
$string["replyToComment"] = "Odpovědet komentáři";
$string["settings"] = "Nastavení";
$string["allowMessagesFrom"] = "Povolit zprávy od...";
$string["allowFriendReqsFrom"] = "Povolit žádosti o přátelství od...";
$string["showCommentHistory"] = "Zobrazit historii komentářů...";
$string["timezoneChoose"] = "Vybrat časové pásmo";
$string["yourYouTube"] = "Váš YouTube kanál";
$string["yourVK"] = "Vaše stránka na VK";
$string["yourTwitter"] = "Vaše stránka na Twitter";
$string["yourTwitch"] = "Váš Twitch kanál";
$string["saveSettings"] = "Uložit nastavení";
$string["all"] = "Všichni";
$string["friends"] = "Kamarádi";
$string["none"] = "Nikdo";
$string["youBlocked"] = "Tento uživatel vás blokoval!";
$string["cantMessage"] = "Nemůžete napsat tomuto uživateli!";
  
$string["accountManagement"] = "Správa účtu";
$string["changePassword"] = "Změnit heslo";
$string["changeUsername"] = "Změnit uživatelské jméno";
$string["unlistedLevels"] = "Vaše neviditelné úrovně";

$string["manageSongs"] = "Spravovat skladby";
$string["gauntletManage"] = "Spravovat Gauntlety";
$string["suggestLevels"] = "Doporučené úrovně";

$string["modTools"] = "Moderátorské nástroje";
$string["leaderboardBan"] = "Zabanovat uživatele";
$string["unlistedMod"] = "Neviditelné úrovně";

$string["reuploadSection"] = "Reupload";
$string["songAdd"] = "Přidat skladbu";
$string["songLink"] = "Přidat sklabu odkazem";
$string["packManage"] = "Spravovat Map Packy";

$string["browse"] = "Prohlížet";
$string["statsSection"] = "Statistiky";
$string["dailyTable"] = "Denní úrovně";
$string["modActionsList"] = "Moderátorské činy";
$string["modActions"] = "Moderátoři serveru";
$string["gauntletTable"] = "Seznam Gauntletů";
$string["packTable"] = "Seznam Map Packů";
$string["leaderboardTime"] = "Postup v žebříčku";

$string["download"] = "Stáhnout";
$string["forwindows"] = "Pro Windows";
$string["forandroid"] = "Pro Android";
$string["formac"] = "Pro Mac";
$string["forios"] = "Pro iOS";
$string["third-party"] = "Třetí strana";
$string["thanks"] = "Děkujeme těmto lidem!";
$string["language"] = "Jazyk";

$string["loginHeader"] = "Vítejte, %s!";
$string["logout"] = "Odhlásit se";
$string["login"] = "Přihlásit se";
$string["wrongNickOrPass"] = "Špatné uživatelské jméno nebo heslo!";
$string["invalidid"] = "Neplatné ID!";
$string["loginBox"] = "Přihlásit se k účtu";
$string["loginSuccess"] = "Úspěšně přihlášeno!";
$string["loginAlready"] = "Již jste přihlášeni!";
$string["clickHere"] = "Dashboard";
$string["enterUsername"] = "Uživatelské jméno";
$string["enterPassword"] = "Heslo";
$string["loginDesc"] = "Zde se můžete přihlásit k vašemu účtu!";

$string["register"] = "Registrovat";
$string["registerAcc"] = "Registrace účtu";
$string["registerDesc"] = "Registrujte si účet!";
$string["repeatpassword"] = "Zopakovat heslo";
$string["email"] = "E-mail";
$string["repeatemail"] = "Zopakovat e-mail";
$string["smallNick"] = "Uživatelské jméno je příliš krátké!";
$string["smallPass"] = "Heslo je příliš krátké!";
$string["passDontMatch"] = "Hesla se neshodují!";
$string["emailDontMatch"] = "E-maily se neshodují!";
$string["registered"] = "Úspěšně registrováno!";
$string["bigNick"] = "Uživatelské jméno je příliš dlouhé!";
$string["mailExists"] = "Je již účet s tímto e-mailem!";
$string["badUsername"] = "Prosím zvolte jiné uživatelské jméno.";

$string["changePassTitle"] = "Změnit heslo";
$string["changedPass"] = "Heslo úspěšně změněno! Musíte se znovu přihlásit k vašemu účtu.";
$string["wrongPass"] = "Špatné heslo!";
$string["samePass"] = "Vložili jste stejné heslo!";
$string["changePassDesc"] = "Zde můžete změnit heslo!";
$string["oldPassword"] = "Staré heslo";
$string["newPassword"] = "Nové heslo";
$string["confirmNew"] = "Potvrdit nové heslo";

$string["forcePassword"] = "Vynuceně změnit heslo";
$string["forcePasswordDesc"] = "Zde můžete vynuceně změnit heslo uživatele!";
$string["forceNick"] = "Vynuceně změnit jméno";
$string["forceNickDesc"] = "Zde můžete vynuceně změnit jméno uživatele!";
$string["forceChangedPass"] = "Heslo uživatele <b>%s</b> bylo úspěšně změněno!";
$string["forceChangedNick"] = "Jméno uživatele <b>%s</b> bylo úspěšně změněno!";
$string["changePassOrNick"] = "Změnit uživatelské jméno či heslo hráče";

$string["changeNickTitle"] = "Změnit uživatelské jméno";
$string["changedNick"] = "Uživatelské jméno úspěšně změněno! Musíte se znovu přihlásit k vašemu účtu.";
$string["wrongNick"] = "Špatné uživatelské jméno!";
$string["sameNick"] = "Vložili jste stejné uživatelské jméno!";
$string["alreadyUsedNick"] = "Zadané jméno je již používáno!";
$string["changeNickDesc"] = "Zde můžete změnit uživatelské jméno!";
$string["oldNick"] = "Staré jméno";
$string["newNick"] = "Nové jméno";
$string["password"] = "Heslo";

$string["packCreate"] = "Vytvořit Map Pack";
$string["packCreateTitle"] = "Vytvořit Map Pack";
$string["packCreateDesc"] = "Zde můžete vytvořit Map Pack!";
$string["packCreateSuccess"] = "Úspěšně jste vytvořili Map Pack jménem";
$string["packCreateOneMore"] = "Ještě jeden?";
$string["packName"] = "Jméno Map Packu";
$string["color"] = "Barva";
$string["sameLevels"] = "Vybrali jste stejné úrovně!";
$string["show"] = "Zobrazit";
$string["packChange"] = "Změnit Map Pack";
$string["createNewPack"] = "Vytvořit nový Map Pack!"; // Translate word "create" like its call to action

$string["gauntletCreate"] = "Vytvořit Gauntlet";
$string["gauntletCreateTitle"] = "Vytvořit Gauntlet";
$string["gauntletCreateDesc"] = "Zde můžete vytvořit Gauntlet!";
$string["gauntletCreateSuccess"] = "Úspěšně jste vytvořili Gauntlet!";
$string["gauntletCreateOneMore"] = "Ještě jeden?";
$string["chooseLevels"] = "Vyberte úrovně!";
$string["checkbox"] = "Potrvrdit";
$string["level1"] = "První úrověň";
$string["level2"] = "Druhá úrověň";
$string["level3"] = "Třetí úrověň";
$string["level4"] = "Čtvrtá úrověň";
$string["level5"] = "Pátá úrověň";
$string["gauntletChange"] = "Změnit Gauntlet";
$string["createNewGauntlet"] = "Vytvořit nový Gauntlet!"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'Úspěšně vytvořeno <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Vybrat Gauntlet automaticky";

$string["addQuest"] = "Přidat quest";
$string["addQuestDesc"] = "Zde můžete vytvořit quest!";
$string["questName"] = "Jméno questu";
$string["questAmount"] = "Vyžadované množství";
$string["questReward"] = "Odměna";
$string["questCreate"] = "Vytvořit quest";
$string["questsSuccess"] = "Úspěšně jste vytvořili quest!";
$string["invalidPost"] = "Neplatná data!";
$string["fewMoreQuests"] = "Je doporučeno vytvořit trochu víc questů.";
$string["oneMoreQuest?"] = "Ještě jeden?";
$string["changeQuest"] = "Změnit quest";
$string["createNewQuest"] = "Vytvořit quest!"; // like gauntlets and mappacks above

$string["levelReupload"] = "Znovunahrát úroveň";
$string["levelReuploadDesc"] = "Zde můžete znovunahrát úroveň z jakéhokoli serveru!";
$string["advanced"] = "Pokročilé možnosti";
$string["errorConnection"] = "Chyba připojení!";
$string["levelNotFound"] = "Tato úroveň neexistuje!";
$string["robtopLol"] = "RobTop tě nemá rád :c";
$string["sameServers"] = "Zdrojový server a cílový server je stejný!";
$string["levelReuploaded"] = "Úroveň nahrána! ID úrovně:";
$string["oneMoreLevel?"] = "Ještě jedna?";
$string["levelAlreadyReuploaded"] = "Úroveň již nahrána!";
$string["server"] = "Server";
$string["levelID"] = "ID úrovně";
$string["pageDisabled"] = "Tato stránka je zakázána!";
$string["levelUploadBanned"] = "Máte zákaz nahrávání úrovní!";

$string["activateAccount"] = "Aktivace účtu";
$string["activateDesc"] = "Aktivujte účet!";
$string["activated"] = "Váš účet byl úspěšně aktivován!";
$string["alreadyActivated"] = "Váš účet je již aktivován";
$string["maybeActivate"] = "Možná jste váš účet ještě neaktivovali.";
$string["activate"] = "Aktivovat";
$string["activateDisabled"] = "AKtivace účtů je zakázána!";

$string["addMod"] = "Přidat moderátora";
$string["addModDesc"] = "Zde můžete někoho povýšit na moderátora!";
$string["modYourself"] = "Nemůžete povýšit sebe!";
$string["alreadyMod"] = "Tento uživatel je již moderátor!";
$string["addedMod"] = "Hráč byl úspěšně povýšen!";
$string["addModOneMore"] = "Ješte jednou?";
$string["modAboveYourRole"] = "Nemůžete dát někomu roli vyšší než vaši nejvyšší!";
$string["makeNewMod"] = "Udělejte někoho moderátorem!";
$string["reassignMod"] = "Znovu přiřadit moderátor";
$string["reassign"] = "Znovu přiřadit";
$string['demotePlayer'] = "Sesadit hráče";
$string['demotedPlayer'] = "Úspěšně jste sesadili hráče <b>%s</b>!";
$string['addedModNew'] = "Úspěšně jste povýšili hráče <b>%s</b> na moderátora!";
$string['demoted'] = 'Sesazeno';

$string["shareCPTitle"] = "Sdílet Creator Pointy";
$string["shareCPDesc"] = "Zde můžete sdílet Creator Pointy!";
$string["shareCP"] = "Sdílet";
$string["alreadyShared"] = "Tato úroveň již měla Creator Pointy sdíleny tomuto hráči!";
$string["shareToAuthor"] = "Nemůžete sdílet Creator Pointy s autorem úrovně!";
$string["userIsBanned"] = "Tento uživatel je zabanován!";	
$string["shareCPOneMore"] = "Ještě jednou?";
$string['shareCPSuccessNew'] = 'Úspěšně jste sdílely Creator Pointy úrovně <b>%1$s</b> hráči <b>%2$s</b>!';

$string["messenger"] = "Messenger";
$string["write"] = "Napsat";
$string["send"] = "Odeslat";
$string["noMsgs"] = "Zahajte dialog!";
$string["subject"] = "Nadpis";
$string["msg"] = "Zpráva";
$string["tooFast"] = "Píšete příliš rychle!";
$string["messengerYou"] = "You:";
$string["chooseChat"] = "Choose chat";

$string["levelToGD"] = "Znovunahrát úroveň na cílový server";
$string["levelToGDDesc"] = "Zde múžete znovunahrát vaši úroveň na cílový server!";
$string["usernameTarget"] = "Uživatelské jméno cílového serveru";
$string["passwordTarget"] = "Heslo cílového serveru";
$string["notYourLevel"] = "Tohle není vaše úroveň!";
$string["reuploadFailed"] = "Chyba při znovunahrávání!";

$string["search"] = "Hledat...";
$string["searchCancel"] = "Zrušit hledání";
$string["emptySearch"] = "Nic nenalezeno!";

$string["approve"] = 'Přijmout';
$string["deny"] = 'Odmítnout';
$string["submit"] = 'Vložit';
$string["place"] = 'Položit';
$string["add"] = 'Přidat';
$string["demonlistLevel"] = '%s <text class="dltext">od <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';

$string["didntActivatedEmail"] = 'Nemáte aktivovaný účet!';
$string["checkMail"] = 'Zkontrolujte si e-mail...';

$string["likeSong"] = "Přidat skladbu do oblíbených";
$string["dislikeSong"] = "Odstranit skladbu z oblíbených";
$string["favouriteSongs"] = "Oblíbené skladby";
$string["howMuchLiked"] = "Kolik hodnocení \"to se mi líbí\"?";
$string["nooneLiked"] = "Žádné";

$string["clan"] = "Klan";
$string["joinedAt"] = "Přidáno ke klanu: <b>%s</b>";
$string["createdAt"] = "Klan vytvořen: <b>%s</b>";
$string["clanMembers"] = "Členové klanu";
$string["noMembers"] = "Žádní členové";
$string["clanOwner"] = "Vlastník klanu";
$string["noClanDesc"] = "<i>Bez popisu</i>";
$string["noClan"] = "Tento klan neexistuje!";
$string["clanName"] = "Jméno klanu";
$string["clanTag"] = "Jmenovka klanu (3-5 znaků)";
$string["clanDesc"] = "Popis klanu";
$string["clanColor"] = "Barva klanu";
$string["dangerZone"] = "Zóna nebezpečí";
$string["giveClan"] = "Předat klan";
$string["deleteClan"] = "Smazat klan";
$string["goBack"] = "Jít zpět";
$string["areYouSure"] = "Jste si jistí?";
$string["giveClanDesc"] = "Zde můžete předat klan jinému hráči.";
$string["notInYourClan"] = "Tento hráč není ve vašem klanu!";
$string["givedClan"] = "Úspěšně jste předali klan hráči <b>%s</b>!";
$string["deletedClan"] = "Smazali jste klan <b>%s</b>.";
$string["deleteClanDesc"] = "Zde můžete smazat klan.";
$string["yourClan"] = "Váš klan";
$string["members0"] = "<b>1</b> člen";
$string["members1"] = "<b>%d</b> členové"; 
$string["members2"] = "<b>%d</b> členů"; 
$string["noRequests"] = "Nejsou žádné žádosti. Uklidni se!";
$string["pendingRequests"] = "Žádosti o přidání se";
$string["closedClan"] = "Zavřený klan";
$string["kickMember"] = "Vyhodit člena";
$string["leaveFromClan"] = "Opustit klan";
$string["askToJoin"] = "Odeslat žádost o přidání se";
$string["removeClanRequest"] = "Smazat žádost o přidání se";
$string["joinClan"] = "Přidat se ke klanu";
$string["noClans"] = "Nejsou žádné klany";
$string["clans"] = "Klany";
$string["alreadyInClan"] = "Již jste v klanu!";
$string["createClan"] = "Vytvořit klan";
$string["createdClan"] = "Úspěšně jste vytvořili klan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Zde můžete vytvořit klan!";
$string["create"] = "Vytvořit";
$string["mainSettings"] = "Hlavní nastavení";
$string["takenClanName"] = "This clan name was already taken!";
$string["takenClanTag"] = "This clan tag was already taken!";
$string["badClanName"] = "Please choose another clan name.";
$string["badClanTag"] = "Please choose another clan tag.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> navhrhl/a <b>%4$s%3$s</b> pro </text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> nahlásil/a </text><text class="levelname">%2$s</text>';

$string['listTable'] = "Listy";
$string['listTableMod'] = "Neveřejné listy";
$string['listTableYour'] = "Vaše neveřejné listy";

$string['forgotPasswordChangeTitle'] = "Změnit heslo";
$string["successfullyChangedPass"] = "Heslo bylo změněno!";
$string['forgotPasswordTitle'] = "Zapomenuto heslo?";
$string['maybeSentAMessage'] = "Odešleme vám zprávu pokud tento účet existuje.";
$string['forgotPasswordDesc'] = "Zde můžete požádat o odkaz pro změnu hesla, zapomněli-li jste ho!";
$string['forgotPasswordButton'] = "Požádat o odkaz";

$string['sfxAdd'] = "Přidat zvukový efekt";
$string["sfxAddError-5"] = "Velikost zvukového efektu je větší, než $sfxSize megabajtů!";
$string["sfxAddError-6"] = "Něco se pokazilo při nahrávání zvukového efektu!";
$string["sfxAddError-7"] = "Můžete jen nahrát audio!";
$string['sfxAdded'] = 'Zvukový efekt přidán';
$string['yourNewSFX'] = "Vyzkoušejte si váš nový zv. efekt!";
$string["sfxAddAnotherBTN"] = "Ještě jeden?";
$string["sfxAddDesc"] = "Zde můžete přidat vlastní zvukový efekt!";
$string["chooseSFX"] = "Vybrat zv. efekt";
$string["sfxAddNameFieldPlaceholder"] = "Jméno";
$string['sfxs'] = 'Zvukové efekty';
$string['sfxID'] = 'ID zv. efektu';
$string['manageSFX'] = 'Spravovat zv. efekty';

$string['featureLevel'] = 'Zvláštně ohodnotirt úroveň';

$string['banList'] = 'Seznam zabanovaných osob';
$string['expires'] = 'Expiruje se';
$string['unbanPerson'] = 'Odbanovat';
$string['IP'] = 'IP adresa';
$string['noBanInPast'] = 'Nemůžete zabanovat v minulosti!';
$string['banSuccess'] = 'Zabanovali jste osobu <b>%1$s</b> do <b>%3$s</b> kvůli «<b>%2$s</b>»!';
$string['person'] = 'Osoba';
$string['youAreBanned'] = 'Byli jste zabanováni do <b>%2$s</b> z důvodu:<br><b>%1$s</b>';
$string['banChange'] = 'Změnit';
$string['system'] = 'Systém';

$string['levelComments'] = 'Level comments';
$string['levelLeaderboards'] = 'Level leaderboards';
$string['manageLevel'] = 'Manage level';
$string['noComments'] = 'No comments!';
$string['commentHere'] = 'Publish comment...';
$string['weekLeaderboards'] = 'For a week';
$string['noLeaderboards'] = 'No leaderboards!';
$string['manageLevelDesc'] = 'Here you can change level!';
$string['silverCoins'] = 'Silver coins';
$string['unlistedLevel'] = 'Unlisted level';
$string['lockUpdates'] = 'Lock updating';
$string['lockCommenting'] = 'Lock commenting';
$string['successfullyChangedLevel'] = 'You successfully changed level!';
$string['successfullyDeletedLevel'] = 'You successfully deleted level!';

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

$string["reuploadBTN"] = "Nahrát";
$string["errorGeneric"] = "Chyba nastala!";
$string["smthWentWrong"] = "Něco se pokazilo!";
$string["tryAgainBTN"] = "Zkusit znovu";
//songAdd.php
$string["songAddDesc"] = "Zde můžete přidat vlastní skladbu!";
$string["songAddUrlFieldLabel"] = "URL skladby: (pouze přímé či Dropbox odkazy)";
$string["songAddUrlFieldPlaceholder"] = "URL skladby";
$string["songAddNameFieldPlaceholder"] = "Jméno";
$string["songAddAuthorFieldPlaceholder"] = "Autor";
$string["songAddButton"] = "Vybrat skladbu";
$string["songAddAnotherBTN"] = "Ještě jedna?";
$string["songAdded"] = "Skladba přidána";
$string["deletedSong"] = "Úspěšně jste smazali skladbu";
$string["songID"] = "ID skladby: ";
$string["songIDw"] = "ID skladby";
$string["songAuthor"] = "Autor";
$string["size"] = "Velikost";
$string["delete"] = "Smazat";
$string["change"] = "Změnit";
$string["chooseFile"] = "Vybrat skladbu";
$string['yourNewSong'] = "Vyzkoušejte si vaši nově nahranou skladbu!";
///errors
$string["songAddError-2"] = "Neplatná URL adresa";
$string["songAddError-3"] = "Tato skladba byla již nahrána s ID:";
$string["songAddError-4"] = "Tato skladba nelze nahrát";
$string["songAddError-5"] = "Skladba je větší než $songSize megabajtů";
$string["songAddError-6"] = "Něco se pokazilo při nahrávání skladby!";
$string["songAddError-7"] = "Můžete jen nahrát audio!";

$string[400] = "Špatný požadavek!";
$string["400!"] = "Zkontrolujte ovladače sítě.";
$string[403] = "Zakázáno!";
$string["403!"] = "Nemáte přístup k této stránce!";
$string[404] = "Stránka nenalezena!";
$string["404!"] = "Jste si jistí, že jste zadali správně adresu?";
$string[500] = "Vnitřní serverová chyba!";
$string["500!"] = "Programátor udělal chybu v kódu,</br>
prosím nahlašte zde tuto chybu: (v angličtině nebo ruštině)</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Server spadl!";
$string["502!"] = "Server je příliš zaneprázdněn.</br>
Vraťte se za pár hodin!";

$string["invalidCaptcha"] = "Špatná CAPTCHA odpověď!";
$string["page"] = "Stránka";
$string["emptyPage"] = "Tato stránka je prázdná!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orby";
$string["stars"] = "Hvězdy";
$string["coins"] = "Mince";
$string["accounts"] = "Účty";
$string["levels"] = "Úrovně";
$string["songs"] = "Skladby";
$string["author"] = "Tvůrce";
$string["name"] = "Jméno";
$string["date"] = "Datum";
$string["type"] = "Typ";
$string["reportCount"] = "Počet nahlášení";
$string["reportMod"] = "Nahlášení";
$string["username"] = "Uživatelské jméno";
$string["accountID"] = "ID účtu";
$string["registerDate"] = "Datum registrace";
$string["isAdminYes"] = "Ano";
$string["isAdminNo"] = "Ne";
$string["userCoins"] = "Bronzové mince";
$string["time"] = "Čas";
$string["deletedLevel"] = "Smazaná úroveň";
$string["mod"] = "Moderátor";
$string["count"] = "Počet činů";
$string["ratedLevels"] = "Ohodnocené úrovně";
$string["lastSeen"] = "Naposledy online";
$string["level"] = "Úroveň";
$string["pageInfo"] = "Strana %s z %s";
$string["first"] = "První";
$string["previous"] = "Poslední";
$string["next"] = "Další";
$string["never"] = "Nikdy";
$string["last"] = "Poslední";
$string["go"] = "Jít";
$string["levelid"] = "ID úrovně";
$string["levelname"] = "Jméno úrovně";
$string["leveldesc"] = "Popis úrovně";
$string["noDesc"] = "Bez popisu";
$string["levelpass"] = "Heslo";
$string["nopass"] = "Bez hesla";
$string["unrated"] = "Neohodnocená";
$string["rate"] = "Ohodnotit";
$string["stats"] = "Statistiky";
$string["suggestFeatured"] = "Speciálně ohodnoceno?";
$string["whoAdded"] = "Kdo přidal?";
$string["moons"] = "Měsíce";

$string["banDesc"] = "Zde můžete zabanovat hráče!";
$string["playerTop"] = 'Žebříčky hráčů';
$string["creatorTop"] = 'Žebříčky tvůrců';
$string["levelUploading"] = 'Nahrávání úrovní';
$string["successfullyBanned"] = 'Hráč <b>%1$s</b> s ID účtu <b>%2$s</b> byl úspěšně zabanován!';
$string["successfullyUnbanned"] = 'Hráč <b>%1$s</b> s ID účtu <b>%2$s</b> byl úspěšně odbanován!';
$string["commentBan"] = 'Komentování';

$string["player"] = "Hráč";

$string["starsLevel2"] = "hvězd";
$string["starsLevel1"] = "hvězdy";
$string["starsLevel0"] = "hvězda";
$string["coins1"] = "mince";
$string["coins0"] = "mince";
$string["unban"] = "Odbanován";
$string["isBan"] = "Zabanován";

$string["noCoins"] = "Bez mincí";
$string["noReason"] = "Bez důvodu";
$string["noActions"] = "Žádné činy";
$string["noRates"] = "Žádné ohodnocení";

$string["future"] = "Budoucnost";

$string["spoiler"] = "Spoiler";
$string["accid"] = "s ID účtu";
$string["banned"] = "byl úspěšně zabanován!";
$string["unbanned"] = "byl úspěšně odbanován!";
$string["ban"] = "Zabanovat";
$string["nothingFound"] = "Tento hráč neexistuje!";
$string["banUserID"] = "Uživatelské jméno či ID účtu";
$string["banUserPlace"] = "Zabanovat uživatele";
$string["banYourself"] = "Nemůžete zabanovat sebe!"; 
$string["banYourSelfBtn!"] = "Zabanovat někoho jiného";
$string["banReason"] = "Důvod";
$string["action"] = "Čin";
$string["value"] = "První hodnota";
$string["value2"] = "Druhá hodnota";
$string["value3"] = "Třetí hodnota";
$string["modAction1"] = "Ohodnotil(a) úroveň";
$string["modAction2"] = "Odstranil/přidal(a) zvláštní hodnocení úrovně";
$string["modAction3"] = "Odstranil/přidal(a) stříbrné mince";
$string["modAction4"] = "Odstranil/přidal(a) epické hodnocení úrovně";
$string["modAction5"] = "Nastavil/a jako denní úroveň";
$string["modAction6"] = "Odstranil(a) úroveň";
$string["modAction7"] = "Změnil(a) autora úrovně";
$string["modAction8"] = "Přejmenoval(a) úroveň";
$string["modAction9"] = "Změnil(a) heslo úrovně";
$string["modAction10"] = "Změnil(a) démonové ohodnocení úrovně";
$string["modAction11"] = "Sdílel(a) CP";
$string["modAction12"] = "Vytvořil/smazal(a) úroveň";
$string["modAction13"] = "Změnil(a) popis úrovně";
$string["modAction14"] = "Přidal/odstranil(a) LDM možnost";
$string["modAction15"] = "Za-/odbanoval(a) hráče z žebříčků";
$string["modAction16"] = "Změnil(a) ID skladby";
$string["modAction17"] = "Vytvořil(a) Map Pack";
$string["modAction18"] = "Vytvořil(a) Gauntlet";
$string["modAction19"] = "Změnil(a) skladbu";
$string["modAction20"] = "Předal(a) moderátora hráči";
$string["modAction21"] = "Změnil(a) Map Pack";
$string["modAction22"] = "Změnil(a) Gauntlet";
$string["modAction23"] = "Změnil(a) quest";
$string["modAction24"] = "Přeřadil(a) hráče";
$string["modAction25"] = "Vytvořil(a) quest";
$string["modAction26"] = "Změnil(a) jméno/heslo hráče";
$string["modAction27"] = "Změnil(a) zvukový efekt";
$string["modAction28"] = "Zabanoval(a) osobu";
$string["modAction29"] = "Locked/unlocked level updating";
$string["modAction30"] = "Ohodnotil(a) list";
$string["modAction31"] = "Odeslal(a) list";
$string["modAction32"] = "Odstranil/přidal(a) zvláštní hodnocení listu";
$string["modAction33"] = "Vytvořil/smazal(a) list";
$string["modAction34"] = "Odstranil(a) list";
$string["modAction35"] = "Změnil(a) autora listu";
$string["modAction36"] = "Změnil(a) jméno listu";
$string["modAction37"] = "Změnil(a) popis listu";
$string["modAction38"] = "Locked/unlocked level commenting";
$string["modAction39"] = "Locked/unlocked list commenting";
$string["modAction40"] = "Removed sent level";
$string["modAction41"] = "Suggested level";
$string["modAction42"] = "Created vault code";
$string["modAction43"] = "Changed vault code";
$string["modAction44"] = "Set level as event level";
$string["everyActions"] = "Všechny činy";
$string["everyMod"] = "Každý moderátor";
$string["Kish!"] = "Nemáš co tady dělat!";
$string["noPermission"] = "Nemáte oprávnění!";
$string["noLogin?"] = "Nejste přihlášeni k účtu!";
$string["LoginBtn"] = "Přihlásit se";
$string["dashboard"] = "Dashboard";
$string["userID"] = 'ID uživatele';
