<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Domov";
$string["welcome"] = "Vítejte v ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Varování!</b> Nenainstalovali jste plně dashboard! Stiskněte tento text pro instalaci.</div>";
$string["levelsWeek"] = "Úrovně nahrané za poslední týden";
$string["levels3Months"] = "Úrovně nahrané za poslední 3 měsíce";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Vítejte v Dashboard! Dáváme vám pár poinstalačních rad:<br>
1. Vypadá to, že se nová oprávnění objevila v SQL v 'roles' tabulce! Měli byste se podívat...<br>
2. Jestil dáte soubor 'icon.png' do 'dashboard' složky, měla by se ikona vašeho GDPS objevit vlevo nahoře!<br>
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

$string["reuploadSection"] = "Znovunahrát";
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
$string["shareCPSuccess"] = "Úspěšně jste sdílely Creator Pointy úrovně";
$string["shareCPSuccess2"] = "hráči";
$string["updateCron"] = "Možná byste měli aktualizovat Creator Pointy skrz Cron.";
$string["shareCPOneMore"] = "Ještě jednou?";
$string['shareCPSuccessNew'] = 'Úspěšně jste sdílely Creator Pointy úrovně <b>%1$s</b> hráči <b>%2$s</b>!';

$string["messenger"] = "Messenger";
$string["write"] = "Napsat";
$string["send"] = "Odeslat";
$string["noMsgs"] = "Zahajte dialog!";
$string["subject"] = "Nadpis";
$string["msg"] = "Zpráva";
$string["tooFast"] = "Píšete příliš rychle!";

$string["levelToGD"] = "Znovunahrát úroveň na cílový server";
$string["levelToGDDesc"] = "Zde múžete znovunahrát vaši úroveň na cílový server!";
$string["usernameTarget"] = "Uživatelské jméno cílového serveru";
$string["passwordTarget"] = "Heslo cílového serveru";
$string["notYourLevel"] = "Tohle není vaše úroveň!";
$string["reuploadFailed"] = "Chyba při znovunahrávání!";

$string["search"] = "Hledat...";
$string["searchCancel"] = "Zrušit hledání";
$string["emptySearch"] = "Nic nenalezeno!";

$string["demonlist"] = 'Demonlist';
$string["demonlistRecord"] = 'Rekord hráče <b>%s</b>';
$string["alreadyApproved"] = 'Již přijat!';
$string["alreadyDenied"] = 'Již odmítnut!';
$string["approveSuccess"] = 'Úspěšně jste přijali rekord hráče <b>%s</b>!';
$string["denySuccess"] = 'Úspěšně jste odmítli rekord hráče <b>%s</b>!';
$string["recordParameters"] = '<b>%s</b> porazil/a <b>%s</b> v <b>%d</b> pokusech';
$string["approve"] = 'Přijmout';
$string["deny"] = 'Odmítnout';
$string["submitRecord"] = 'Vložit rekord';
$string["submitRecordForLevel"] = 'Vložit rekord pro <b>%s</b>';
$string["alreadySubmitted"] = 'Již jste vložili rekord pro <b>%s</b>!';
$string["submitSuccess"] = 'Úspěšně jste vložili rekord pro <b>%s</b>!';
$string["submitRecordDesc"] = 'Vlkádejte rekordy jenom když jste úroveň porazili!';
$string["atts"] = 'Pokusy';
$string["ytlink"] = 'ID YouTube videa (dQw4w9WgXcQ)';
$string["submit"] = 'Vložit';
$string["addDemonTitle"] = 'Přidat démona';
$string["addDemon"] = 'Přidat démona do demonlistu';
$string["addedDemon"] = 'Přidali jste <b>%s</b> na <b>%d.</b> místo!';
$string["addDemonDesc"] = 'Zde můžete přidat démona do demonlistu!';
$string["place"] = 'Položit';
$string["giveablePoints"] = 'Datelné body';
$string["add"] = 'Přidat';
$string["recordApproved"] = 'Rekord přijat!';
$string["recordDenied"] = 'Rekord odmítnut!';
$string["recordSubmitted"] = 'Rekord vložen!';
$string["nooneBeat"] = 'nikdo neporazil'; //let it be lowercase
$string["oneBeat"] = '1 hráč porazil'; 
$string["lower5Beat"] = '%d hráči porazili'; // russian syntax, sorry
$string["above5Beat"] = '%d hráčů porazilo'; 
$string["demonlistLevel"] = '%s <text class="dltext">od <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';
$string["noDemons"] = 'Vypadá to, že váš demonlist nemá žádné démony...';
$string["addSomeDemons"] = 'Přidejte démony pro vyplnění demonlistu!';
$string["askForDemons"] = 'Zeptejte se administrátora serveru pro přidání některých!';
$string["recordList"] = 'Seznam rekordů';
$string["status"] = 'Stav';
$string["checkRecord"] = 'Zkontrolovat rekord';
$string["record"] = 'Rekord';
$string["recordDeleted"] = 'Rekord byl smazán!';
$string["changeDemon"] = 'Změnit démona';
$string["demonDeleted"] = 'Démon byl smazán!';
$string["changedDemon"] = 'Přesunuli jste <b>%s</b> na <b>%d.</b> místo!';
$string["changeDemonDesc"] = 'Zde můžete přesunout démony!<br>
Jestli chcete démona smazat, nastavte místo na 0.';

$string["didntActivatedEmail"] = 'Nemáte aktivovaný účet!';
$string["checkMail"] = 'Zkontrolujte si e-mail...';

$string["likeSong"] = "Přidat skladbu do oblíbených";
$string["dislikeSong"] = "Odstranit skladbu z oblíbených";
$string["favouriteSongs"] = "Oblíbené skladby";
$string["howMuchLiked"] = "Kolik hodnocení \"to se mi líbí\"?";
$string["nooneLiked"] = "Žádné";

$string["clan"] = "Klan";
$string["joinedAt"] = "Joined clan at: <b>%s</b>";
$string["createdAt"] = "Created clan at: <b>%s</b>";
$string["clanMembers"] = "Clan members";
$string["noMembers"] = "No members";
$string["clanOwner"] = "Clan owner";
$string["noClanDesc"] = "<i>No description</i>";
$string["noClan"] = "This clan doesn't exist!";
$string["clanName"] = "Clan name";
$string["clanTag"] = "Clan tag (3-5 characters)";
$string["clanDesc"] = "Clan description";
$string["clanColor"] = "Clan color";
$string["dangerZone"] = "Danger zone";
$string["giveClan"] = "Give clan";
$string["deleteClan"] = "Delete clan";
$string["goBack"] = "Go back";
$string["areYouSure"] = "Are you sure?";
$string["giveClanDesc"] = "Here you can give your clan to a player.";
$string["notInYourClan"] = "This player is not in your clan!";
$string["givedClan"] = "You successfully gived your clan to <b>%s</b>!";
$string["deletedClan"] = "You deleted clan <b>%s</b>.";
$string["deleteClanDesc"] = "Here you can delete your clan.";
$string["yourClan"] = "Your clan";
$string["members0"] = "<b>1</b> member";
$string["members1"] = "<b>%d</b> members"; 
$string["members2"] = "<b>%d</b> members"; 
$string["noRequests"] = "There is no requests. Chill!";
$string["pendingRequests"] = "Clan requests";
$string["closedClan"] = "Closed clan";
$string["kickMember"] = "Kick member";
$string["leaveFromClan"] = "Leave clan";
$string["askToJoin"] = "Send join request";
$string["removeClanRequest"] = "Delete join request";
$string["joinClan"] = "Join clan";
$string["noClans"] = "There is no clans";
$string["clans"] = "Clans";
$string["alreadyInClan"] = "You're already in clan!";
$string["createClan"] = "Create clan";
$string["createdClan"] = "You successfully created clan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Here you can create a clan!";
$string["create"] = "Create";
$string["mainSettings"] = "Main settings";
$string["takenClanName"] = "This clan name was already taken!";
$string["takenClanTag"] = "This clan tag was already taken!";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> suggested <b>%4$s%3$s</b> for</text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> was reported</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Lists";
$string['listTableMod'] = "Unlisted lists";
$string['listTableYour'] = "Your unlisted lists";

$string['forgotPasswordChangeTitle'] = "Change password";
$string["successfullyChangedPass"] = "Password was successfully changed!";
$string['forgotPasswordTitle'] = "Forgot password?";
$string['maybeSentAMessage'] = "We'll send you a message if this account exists.";
$string['forgotPasswordDesc'] = "Here you can request change password link if you forgot it!";
$string['forgotPasswordButton'] = "Request link";

$string['sfxAdd'] = "Add SFX";
$string["sfxAddError-5"] = "SFX's size is higher than $sfxSize megabytes!";
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

$string['featureLevel'] = 'Feature level';

$string['banList'] = 'Banned people list';
$string['expires'] = 'Expires';
$string['unbanPerson'] = 'Unban';
$string['IP'] = 'IP-address';
$string['noBanInPast'] = 'You can\'t ban until past!';
$string['banSuccess'] = 'You successfully banned <b>%1$s</b> until <b>%3$s</b> in «<b>%2$s</b>»!';
$string['person'] = 'Person';
$string['youAreBanned'] = 'You were banned until <b>%2$s</b> for reason:<br><b>%1$s</b>';
$string['banChange'] = 'Change';
$string['system'] = 'System';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Upload";
$string["errorGeneric"] = "Error appeared!";
$string["smthWentWrong"] = "Something went wrong!";
$string["tryAgainBTN"] = "Try again";
//songAdd.php
$string["songAddDesc"] = "Here you can add your song!";
$string["songAddUrlFieldLabel"] = "Song URL: (Direct or Dropbox links only)";
$string["songAddUrlFieldPlaceholder"] = "Song URL";
$string["songAddNameFieldPlaceholder"] = "Name";
$string["songAddAuthorFieldPlaceholder"] = "Author";
$string["songAddButton"] = "Choose song";
$string["songAddAnotherBTN"] = "Another Song?";
$string["songAdded"] = "Song added";
$string["deletedSong"] = "You successfully deleted song";
$string["renamedSong"] = "You successfully renamed song to";
$string["songID"] = "Song ID: ";
$string["songIDw"] = "Song ID";
$string["songAuthor"] = "Author";
$string["size"] = "Size";
$string["delete"] = "Delete";
$string["change"] = "Change";
$string["chooseFile"] = "Choose a song";
$string['yourNewSong'] = "Take a look at your new song!";
///errors
$string["songAddError-2"] = "Invalid URL";
$string["songAddError-3"] = "This song has been reuploaded already with ID:";
$string["songAddError-4"] = "This song isn't reuploadable";
$string["songAddError-5"] = "Song size is higher than $songSize megabytes";
$string["songAddError-6"] = "Something went wrong while uploading a song!";
$string["songAddError-7"] = "You can only upload audio!";

$string[400] = "Bad request!";
$string["400!"] = "Check drivers of your network hardware.";
$string[403] = "Forbidden!";
$string["403!"] = "You don't have access to this page!";
$string[404] = "Page not found!";
$string["404!"] = "Are you sure you typed address correctly?";
$string[500] = "Internal server error!";
$string["500!"] = "Coder made an mistake in the code,</br>
please say about this problem here:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Server is down!";
$string["502!"] = "Load on the server is too big.</br>
Come back later within several hours!";

$string["invalidCaptcha"] = "Invalid captcha response!";
$string["page"] = "Page";
$string["emptyPage"] = "This page is empty!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orbs";
$string["stars"] = "Stars";
$string["coins"] = "Coins";
$string["accounts"] = "Accounts";
$string["levels"] = "Levels";
$string["songs"] = "Songs";
$string["author"] = "Creator";
$string["name"] = "Name";
$string["date"] = "Date";
$string["type"] = "Type";
$string["reportCount"] = "Report count";
$string["reportMod"] = "Reports";
$string["username"] = "Username";
$string["accountID"] = "Account ID";
$string["registerDate"] = "Register date";
$string["levelAuthor"] = "Level author";
$string["isAdmin"] = "Role on server";
$string["isAdminYes"] = "Yes";
$string["isAdminNo"] = "No";
$string["userCoins"] = "User Coins";
$string["time"] = "Time";
$string["deletedLevel"] = "Deleted Level";
$string["mod"] = "Moderator";
$string["count"] = "Amount of actions";
$string["ratedLevels"] = "Rated Levels";
$string["lastSeen"] = "Last Time Online";
$string["level"] = "Level";
$string["pageInfo"] = "Showing page %s of %s";
$string["first"] = "First";
$string["previous"] = "Previous";
$string["next"] = "Next";
$string["never"] = "Never";
$string["last"] = "Last";
$string["go"] = "Go";
$string["levelid"] = "Level ID";
$string["levelname"] = "Level name";
$string["leveldesc"] = "Level description";
$string["noDesc"] = "No description";
$string["levelpass"] = "Password";
$string["nopass"] = "No password";
$string["unrated"] = "Unrated";
$string["rate"] = "Rate";
$string["stats"] = "Stats";
$string["suggestFeatured"] = "Featured?";
$string["whoAdded"] = "Who added?";
$string["moons"] = "Moons";
//modActionsList
$string["banDesc"] = "Here you can ban a player!";
$string["playerTop"] = 'Top of players';
$string["creatorTop"] = 'Top of creators';
$string["levelUploading"] = 'Uploading levels';
$string["successfullyBanned"] = 'Player <b>%1$s</b> with account ID <b>%2$s</b> was successfully banned!';
$string["successfullyUnbanned"] = 'Player <b>%1$s</b> with account ID <b>%2$s</b> was successfully unbanned!';
$string["commentBan"] = 'Commenting';

$string["admin"] = "Administrator";
$string["elder"] = "Elder moderator";
$string["moder"] = "Moderator";
$string["player"] = "Player";

$string["starsLevel2"] = "stars";
$string["starsLevel1"] = "stars";
$string["starsLevel0"] = "star";
$string["coins2"] = "coins";
$string["coins1"] = "coins";
$string["coins0"] = "coin";
$string["time0"] = "time";
$string["time1"] = "times";
$string["times"] = "times";
$string["action0"] = "action";
$string["action1"] = "actions";
$string["action2"] = "actions";
$string["lvl0"] = "level";
$string["lvl1"] = "levels";
$string["lvl2"] = "levels";
$string["player0"] = "player";
$string["player1"] = "players";
$string["player2"] = "players";
$string["unban"] = "Unban";
$string["isBan"] = "Ban";

$string["noCoins"] = "Without coins";
$string["noReason"] = "No reason";
$string["noActions"] = "No actions";
$string["noRates"] = "No rates";

$string["future"] = "Future";

$string["spoiler"] = "Spoiler";
$string["accid"] = "with account ID";
$string["banned"] = "was successfully banned!";
$string["unbanned"] = "was successfully unbanned!";
$string["ban"] = "Ban";
$string["nothingFound"] = "This player doesn't exist!";
$string["banUserID"] = "Username or account ID";
$string["banUserPlace"] = "Ban a user";
$string["banYourself"] = "You can't ban yourself!"; 
$string["banYourSelfBtn!"] = "Ban someone else";
$string["banReason"] = "Ban reason";
$string["action"] = "Action";
$string["value"] = "1st value";
$string["value2"] = "2nd value";
$string["value3"] = "3rd value";
$string["modAction1"] = "Rated a level";
$string["modAction2"] = "Un/featured a level";
$string["modAction3"] = "Un/verified coins";
$string["modAction4"] = "Un/epiced a level";
$string["modAction5"] = "Set as daily feature";
$string["modAction6"] = "Deleted a level";
$string["modAction7"] = "Creator change";
$string["modAction8"] = "Renamed a level";
$string["modAction9"] = "Changed level password";
$string["modAction10"] = "Changed demon difficulty";
$string["modAction11"] = "Shared CP";
$string["modAction12"] = "Un/published level";
$string["modAction13"] = "Changed level description";
$string["modAction14"] = "Enabled/disabled LDM";
$string["modAction15"] = "Leaderboard un/banned";
$string["modAction16"] = "Song ID change";
$string["modAction17"] = "Created a Map Pack";
$string["modAction18"] = "Created a Gauntlet";
$string["modAction19"] = "Changed song";
$string["modAction20"] = "Granted a moderator to player";
$string["modAction21"] = "Changed Map Pack";
$string["modAction22"] = "Changed Gauntlet";
$string["modAction23"] = "Changed quest";
$string["modAction24"] = "Reassigned a player";
$string["modAction25"] = "Created a quest";
$string["modAction26"] = "Changed player's username/password";
$string["modAction27"] = "Changed SFX";
$string["modAction28"] = "Banned person";
$string["modAction30"] = "Rated list";
$string["modAction31"] = "Sent list";
$string["modAction32"] = "Un/featured list";
$string["modAction33"] = "Un/published list";
$string["modAction34"] = "Deleted list";
$string["modAction35"] = "Changed list's creator";
$string["modAction36"] = "Changed list's name";
$string["modAction37"] = "Changed list's description";
$string["everyActions"] = "Any actions";
$string["everyMod"] = "All moderators";
$string["Kish!"] = "Go away!";
$string["noPermission"] = "You don't have permission!";
$string["noLogin?"] = "You are not logged into your account!";
$string["LoginBtn"] = "Login into account";
$string["dashboard"] = "Dashboard";
$string["userID"] = 'User ID';
//errors
$string["errorNoAccWithPerm"] = "Error: No accounts with the '%s' permission have been found";
