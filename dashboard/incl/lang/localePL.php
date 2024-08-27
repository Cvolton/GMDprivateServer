<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Dom";
$string["welcome"] = "Witaj w ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Uwaga!</b> Nie ukończyłeś(aś) instalacji panelu! Kliknij na ten tekst aby to zrobić.</div>";
$string["levelsWeek"] = "Poziomy wysłane w ciągu tygodnia";
$string["levels3Months"] = "Poziomy wysłane w ciągu 3 miesięcy";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Witaj na panelu! Oto kilka porad po instalacji:<br>
1. Wygląda na to, że pojawiły się nowe uprawnienia w tabeli SQL 'roles'! Powinieneś(naś) to sprawdzić...<br>
2. Jeśli wrzucisz 'icon.png' do folderu 'dashboard', ikona twojego GDPS pojawi się w lewym górnym rogu!<br>
3. Powinieneś(naś) skonfigurować config/dashboard.php!";
$string["wwygdt"] = "Co dzisiaj zrobisz?";
$string["game"] = "Gra";
$string["guest"] = "gość";
$string["account"] = "Konto";
$string["levelsOptDesc"] = "Zobacz listę poziomów";
$string["songsOptDesc"] = "Zobacz listę piosenek";
$string["yourClanOptDesc"] = "Zobacz klan \"%s\"";
$string["clanOptDesc"] = "Zobacz listę klanów";
$string["yourProfile"] = "Twój profil";
$string["profileOptDesc"] = "Zobacz swój profil";
$string["messengerOptDesc"] ="Otwórz komunikator";
$string["addSongOptDesc"] = "Dodaj piosenkę do serwerów";
$string["loginOptDesc"] = "Zaloguj się";
$string["createAcc"] = "Stwórz konto";
$string["registerOptDesc"] = "Zarejestruj %s";
$string["downloadOptDesc"] = "Pobierz %s";

$string["tryCron"] = "Uruchom Cron";
$string["cronSuccess"] = "Sukces!";
$string["cronError"] = "Błąd!";

$string["profile"] = "Profil";
$string["empty"] = "Puste...";
$string["writeSomething"] = "Napisz coś!";  
$string["replies"] = "Odpowiedzi";
$string["replyToComment"] = "Odpowiedz na komentarz";
$string["settings"] = "Ustawienia";
$string["allowMessagesFrom"] = "Zezwól na wiadomości od...";
$string["allowFriendReqsFrom"] = "Zezwól na friend requesty od...";
$string["showCommentHistory"] = "Pokaż historię komentarzy...";
$string["timezoneChoose"] = "Wybierz strefę czasową";
$string["yourYouTube"] = "Twój kanał na YouTube";
$string["yourVK"] = "Twoja strona na VK";
$string["yourTwitter"] = "Twoja strona na Twitterze";
$string["yourTwitch"] = "Twój kanał Twitch";
$string["saveSettings"] = "Zapisz ustawienia";
$string["all"] = "Wszyscy";
$string["friends"] = "Przyjaciele";
$string["none"] = "Nikt";
$string["youBlocked"] = "Ten gracz cię zablokował!";
$string["cantMessage"] = "Nie możesz napisać do tego gracza!";
  
$string["accountManagement"] = "Zarządzanie kontem";
$string["changePassword"] = "Zmień hasło";
$string["changeUsername"] = "Zmień nazwę";
$string["unlistedLevels"] = "Twoje ukryte poziomy";

$string["manageSongs"] = "Zarządzaj piosenkami";
$string["gauntletManage"] = "Zarządzaj Gauntletami";
$string["suggestLevels"] = "Zasugerowane poziomy";

$string["modTools"] = "Narzędzia moderatora";
$string["leaderboardBan"] = "Zbanuj użytkownika";
$string["unlistedMod"] = "Ukryte poziomy";

$string["reuploadSection"] = "Zreuploaduj";
$string["songAdd"] = "Dodaj piosenkę";
$string["songLink"] = "Dodaj piosenkę za pomocą linku";
$string["packManage"] = "Zarządzaj Map Packami";

$string["browse"] = "Przeglądaj";
$string["statsSection"] = "Statystyki";
$string["dailyTable"] = "Poziomy daily";
$string["modActionsList"] = "Akcje moderatora";
$string["modActions"] = "Moderatorzy serwera";
$string["gauntletTable"] = "Lista Gauntletów";
$string["packTable"] = "Lista Map Packów";
$string["leaderboardTime"] = "Progres leaderboardów";

$string["download"] = "Pobierz";
$string["forwindows"] = "Dla Windowsa";
$string["forandroid"] = "Dla Androida";
$string["formac"] = "Dla Maca";
$string["forios"] = "Dla iOSa";
$string["third-party"] = "Zewnętrzny";
$string["thanks"] = "Dziękuję tym osobom!";
$string["language"] = "Język";

$string["loginHeader"] = "Witaj, %s!";
$string["logout"] = "Wyloguj się";
$string["login"] = "Zaloguj się";
$string["wrongNickOrPass"] = "Zła nazwa lub hasło!";
$string["invalidid"] = "Nieprawidłowe ID!";
$string["loginBox"] = "Zaloguj się na konto";
$string["loginSuccess"] = "Pomyślnie zalogowałeś(aś) się na swoje konto!";
$string["loginAlready"] = "Jesteś zalogowany(a)!";
$string["clickHere"] = "Panel";
$string["enterUsername"] = "Wpisz nazwę";
$string["enterPassword"] = "Wpisz hasło";
$string["loginDesc"] = "Możesz tutaj zalogować się na swoje konto!";

$string["register"] = "Zarejestruj się";
$string["registerAcc"] = "Rejestracja konta";
$string["registerDesc"] = "Zarejestruj swoje konto!";
$string["repeatpassword"] = "Powtórz hasło";
$string["email"] = "Email";
$string["repeatemail"] = "Powtórz email";
$string["smallNick"] = "Nazwa jest za krótka!";
$string["smallPass"] = "Hasło jest za krótkie!";
$string["passDontMatch"] = "Hasła się nie zgadzają!";
$string["emailDontMatch"] = "Emaile się nie zgadzają";
$string["registered"] = "Pomyślnie zarejestrowałeś(aś) konto!";
$string["bigNick"] = "Nazwa jest za długa!";
$string["mailExists"] = "Istnieje zarejestrowane konto używające tego adresu email!!";
$string["badUsername"] = "Proszę wybrać inną nazwę.";

$string["changePassTitle"] = "Zmień hasło";
$string["changedPass"] = "Hasło pomyślnie zmienione! Teraz musisz ponownie się zalogować na swoje konto.";
$string["wrongPass"] = "Złe hasło!";
$string["samePass"] = "Hasła są takie same!";
$string["changePassDesc"] = "Możesz tutaj zmienić swoje hasło!";
$string["oldPassword"] = "Stare hasło";
$string["newPassword"] = "Nowe hasło";
$string["confirmNew"] = "Potwierdź hasło";

$string["forcePassword"] = "Wymuś zmianę hasła";
$string["forcePasswordDesc"] = "Możesz tutaj wymusić zmianę hasła gracza!";
$string["forceNick"] = "Wymuś zmianę nazwy";
$string["forceNickDesc"] = "Możesz tutaj wymusić zmianę nazwy gracza!";
$string["forceChangedPass"] = "Hasło gracza <b>%s</b> zostało pomyślnie zmienione!";
$string["forceChangedNick"] = "Nazwa gracza <b>%s</b> została pomyślnie zmieniona!";
$string["changePassOrNick"] = "Zmień nazwę lub hasło gracza";

$string["changeNickTitle"] = "Zmień nazwę";
$string["changedNick"] = "Nazwa pomyślnie zmieniona! Teraz musisz ponownie się zalogować na swoje konto.";
$string["wrongNick"] = "Wrong username!";
$string["sameNick"] = "Nazwy są takie same!";
$string["alreadyUsedNick"] = "Wprowadzona nazwa jest zajęta!";
$string["changeNickDesc"] = "Możesz tutaj zmienić swoją nazwę!";
$string["oldNick"] = "Stara nazwa";
$string["newNick"] = " Nowa nazwa";
$string["password"] = "Hasło";

$string["packCreate"] = "Stwórz Map Packa";
$string["packCreateTitle"] = "Stwórz Map Packa";
$string["packCreateDesc"] = "Możesz tutaj stworzyć Map Packa!";
$string["packCreateSuccess"] = "Pomyślnie stworzono Map Packa o nazwie";
$string["packCreateOneMore"] = "Jeszcze jeden Map Pack?";
$string["packName"] = "Nazwa Map Packa";
$string["color"] = "Kolor";
$string["sameLevels"] = "Wybrałeś(aś) takie same poziomy!";
$string["show"] = "Pokaż";
$string["packChange"] = "Zmień Map Packa";
$string["createNewPack"] = "Stwórz nowego Map Packa!"; // Translate word "create" like its call to action

$string["gauntletCreate"] = "Stwórz Gauntlet";
$string["gauntletCreateTitle"] = "Stwórz Gauntlet";
$string["gauntletCreateDesc"] = "Możesz tutaj stworzyć Gauntlet!";
$string["gauntletCreateSuccess"] = "Pomyślnie utworzono Gauntlet!";
$string["gauntletCreateOneMore"] = "Jeszcze jeden Gauntlet?";
$string["chooseLevels"] = "Wybierz poziomy!";
$string["checkbox"] = "Potwierdź";
$string["level1"] = "Pierwszy poziom";
$string["level2"] = "Drugi poziom";
$string["level3"] = "Trzeci poziom";
$string["level4"] = "Czwarty poziom";
$string["level5"] = "Piąty poziom";
$string["gauntletChange"] = "Zmień Gauntlet";
$string["createNewGauntlet"] = "Stwórz nowy Gauntlet!"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'Pomyślnie utworzono <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Wybierz Gauntlet automatycznie";

$string["addQuest"] = "Dodaj questa";
$string["addQuestDesc"] = "Możesz tutaj stworzyć questa!";
$string["questName"] = "Nazwa zadania";
$string["questAmount"] = "Wymagana ilość";
$string["questReward"] = "Nagroda";
$string["questCreate"] = "Stwórz questa";
$string["questsSuccess"] = "Pomyślnie utworzono questa";
$string["invalidPost"] = "Nieprawidłowe dane!";
$string["fewMoreQuests"] = "Zalecane jest utworzenie kilku więcej questów.";
$string["oneMoreQuest?"] = "Jeszcze jeden quest?";
$string["changeQuest"] = "Zmień questa";
$string["createNewQuest"] = "Stwórz nowego questa!"; // like gauntlets and mappacks above

$string["levelReupload"] = "Zreuploaduj poziom";
$string["levelReuploadDesc"] = "Możesz tutaj zreuploadować poziom z dowolnego serwera!";
$string["advanced"] = "Zaawansowane ustawienia";
$string["errorConnection"] = "Błąd połączenia!";
$string["levelNotFound"] = "Ten poziom nie istnieje!";
$string["robtopLol"] = "RobTop cię nie lubi :c";
$string["sameServers"] = "Serwer hosta i serwer docelowy jest taki sam!";
$string["levelReuploaded"] = "Poziom zreuploadowany! ID Poziomu:";
$string["oneMoreLevel?"] = "Jeszcze jeden poziom?";
$string["levelAlreadyReuploaded"] = "Poziom już został zreuploadowany!";
$string["server"] = "Serwer";
$string["levelID"] = "ID Poziomu";
$string["pageDisabled"] = "Ta strona jest wyłączona!";
$string["levelUploadBanned"] = "Jesteś zbanowany na wysyłanie poziomów!";

$string["activateAccount"] = "Aktywacja konta";
$string["activateDesc"] = "Aktywuj swoje konto!";
$string["activated"] = "Twoje konto zostało pomyślnie aktywowane!";
$string["alreadyActivated"] = "Twoje konto jest już aktywowane";
$string["maybeActivate"] = "Może jeszcze nie aktywowałeś(aś) swojego konta.";
$string["activate"] = "Aktywuj";
$string["activateDisabled"] = "Aktywacja kont jest wyłączona!";

$string["addMod"] = "Dodaj moderatora";
$string["addModDesc"] = "Możesz tutaj promować na stanowisko Moderatora!";
$string["modYourself"] = "Nie możesz promować samego siebie na moderatora!";
$string["alreadyMod"] = "Ten gracz już jest Moderatorem!";
$string["addedMod"] = "Pomyślnie promowałeś(aś) gracza na Moderatora";
$string["addModOneMore"] = "Jeszcze jeden moderator?";
$string["modAboveYourRole"] = "Próbujesz dać role powyżej swojej najwyższej!";
$string["makeNewMod"] = "Zrób kogoś moderatorem!";
$string["reassignMod"] = "Przypisz ponownie moderatora";
$string["reassign"] = "Przypisz ponownie";
$string['demotePlayer'] = "Zdegraduj gracza";
$string['demotedPlayer'] = "Pomyślnie zdegradowano <b>%s</b>!";
$string['addedModNew'] = "Pomyślnie promowano <b>%s</b> na Moderatora!";
$string['demoted'] = 'Degradowano';

$string["shareCPTitle"] = "Przekaż Creator Pointy";
$string["shareCPDesc"] = "Możesz tutaj przekazać graczowi Creator Pointy!";
$string["shareCP"] = "Przekaż";
$string["alreadyShared"] = "Ten poziom już dał CP graczowi!";
$string["shareToAuthor"] = "Próbujesz przekazać CP autorowi poziomu!";
$string["userIsBanned"] = "Ten gracz jest zbanowany!";
$string["shareCPSuccess"] = "Pomyślnie przekazano Creator Pointy poziomu";
$string["shareCPSuccess2"] = "graczowi";
$string["updateCron"] = "Może powinieneś(innaś) zaktualizować Creator Pointy.";
$string["shareCPOneMore"] = "Jeszcze jedno przekazanie?";
$string['shareCPSuccessNew'] = 'Pomyślnie przekazano Creator Pointy poziomu <b>%1$s</b> graczowi <b>%2$s</b>!';

$string["messenger"] = "Komunikator";
$string["write"] = "Napisz";
$string["send"] = "Wyślij";
$string["noMsgs"] = "Rozpocznij dialog!";
$string["subject"] = "Temat";
$string["msg"] = "Wiadomość";
$string["tooFast"] = "Piszesz za szybko!";
$string["messengerYou"] = "You:";
$string["chooseChat"] = "Choose chat";

$string["levelToGD"] = "Zreuploaduj poziom do wybranego serwera";
$string["levelToGDDesc"] = "Możesz tutaj zreuploadować poziom do wybranego serwera!";
$string["usernameTarget"] = "Nazwa na wybranym serwerze";
$string["passwordTarget"] = "Hasło na wybranym serwerze";
$string["notYourLevel"] = "To nie twój poziom!";
$string["reuploadFailed"] = "Błąd w ponownym wysyłaniu poziomu!";

$string["search"] = "Wyszukaj...";
$string["searchCancel"] = "Cofnij wyszukiwanie";
$string["emptySearch"] = "Nic nie znaleziono!";

$string["demonlist"] = 'Demonlista';
$string["demonlistRecord"] = 'Rekord <b>%s</b>';
$string["alreadyApproved"] = 'Już zatwierdzono!';
$string["alreadyDenied"] = 'Już  odrzucono!';
$string["approveSuccess"] = 'Pomyślnie zatwierdziłeś(aś) rekord <b>%s</b>!';
$string["denySuccess"] = 'Pomyślnie odrzuciłeś(aś) rekord <b>%s</b>!';
$string["recordParameters"] = '<b>%s</b> przeszedł(ła) <b>%s</b> w <b>%d</b> próbach';
$string["approve"] = 'Zatwierdź';
$string["deny"] = 'Odrzuć';
$string["submitRecord"] = 'Prześlij rekord';
$string["submitRecordForLevel"] = 'Prześlij rekord dla <b>%s</b>';
$string["alreadySubmitted"] = 'Już przesłano rekord dla <b>%s</b>!';
$string["submitSuccess"] = 'Pomyślnie przesłano rekord dla <b>%s</b>!';
$string["submitRecordDesc"] = 'Przesyłaj rekordy tylko jeśli przeszedłeś(szłaś) poziom!';
$string["atts"] = 'Próby';
$string["ytlink"] = 'ID filmu youtube (dQw4w9WgXcQ)';
$string["submit"] = 'Wyślij';
$string["addDemonTitle"] = 'Dodaj demona';
$string["addDemon"] = 'Dodaj demona do demonlisty';
$string["addedDemon"] = 'Dodałeś(aś) <b>%s</b> na <b>%d</b> miejsce!';
$string["addDemonDesc"] = 'Możesz tutaj dodać demona na demonlistę!';
$string["place"] = 'Miejsce';
$string["giveablePoints"] = 'Dawalne punkty';
$string["add"] = 'Dodaj';
$string["recordApproved"] = 'Rekord zatwierdzony!';
$string["recordDenied"] = 'Rekord odrzucony!';
$string["recordSubmitted"] = 'Rekord wysłany!';
$string["nooneBeat"] = 'nikt nie przeszedł'; //let it be lowercase
$string["oneBeat"] = '1 gracz przeszedł'; 
$string["lower5Beat"] = '%d graczy przeszło'; // russian syntax, sorry
$string["above5Beat"] = '%d graczy przeszło'; 
$string["demonlistLevel"] = '%s <text class="dltext">przez <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';
$string["noDemons"] = 'Wygląda na to, że demonlista nie ma żadnych demonów...';
$string["addSomeDemons"] = 'Dodaj trochę demonów żeby zapełnić demonlistę!';
$string["askForDemons"] = 'Zapytaj administratora serwera aby trochę dodać!';
$string["recordList"] = 'Lista rekordów';
$string["status"] = 'Status';
$string["checkRecord"] = 'Sprawdź rekord';
$string["record"] = 'Rekord';
$string["recordDeleted"] = 'Rekord został usunięty!';
$string["changeDemon"] = 'Zmień demona';
$string["demonDeleted"] = 'Demon został usunięty!';
$string["changedDemon"] = 'Zmieniono <b>%s</b> na <b>%d</b> miejsce!';
$string["changeDemonDesc"] = 'Możesz tutaj zmienić demona!<br>
Jeśli chcesz usunąć demona, ustaw miejsce na 0.';

$string["didntActivatedEmail"] = 'Nie aktywowałeś(aś) swojego konta za pomocą emaila!';
$string["checkMail"] = 'Powinieneś(innaś) sprawdzić swój email...';

$string["likeSong"] = "Dodaj piosenkę do ulubionych";
$string["dislikeSong"] = "Usuń piosenkę z ulubionych";
$string["favouriteSongs"] = "Ulubione piosenki";
$string["howMuchLiked"] = "Jak dużo polubiło?";
$string["nooneLiked"] = "Nikt nie polubił";

$string["clan"] = "Klan";
$string["joinedAt"] = "Dołączono do klanu o: <b>%s</b>";
$string["createdAt"] = "Stworzono klan o: <b>%s</b>";
$string["clanMembers"] = "Członkowie klanu";
$string["noMembers"] = "Brak członków";
$string["clanOwner"] = "Właściciel klanu";
$string["noClanDesc"] = "<i>Brak opisu</i>";
$string["noClan"] = "Ten klan nie istnieje!";
$string["clanName"] = "Nazwa klanu";
$string["clanTag"] = "Znak klanu (3-5 znaków)";
$string["clanDesc"] = "Opis klanu";
$string["clanColor"] = "Kolor klanu";
$string["dangerZone"] = "Niebezpieczna strefa";
$string["giveClan"] = "Oddaj klan";
$string["deleteClan"] = "Usuń klan";
$string["goBack"] = "Wróć";
$string["areYouSure"] = "Jesteś pewien(wna)?";
$string["giveClanDesc"] = "Tutaj możesz oddać klan graczowi.";
$string["notInYourClan"] = "Ten gracz nie jest w twoim klanie!";
$string["givedClan"] = "Pomyślnie oddano klan graczowi <b>%s</b>!";
$string["deletedClan"] = "Usunięto klan <b>%s</b>.";
$string["deleteClanDesc"] = "Możesz tutaj usunąć swój klan.";
$string["yourClan"] = "Twój klan";
$string["members0"] = "<b>1</b> członek";
$string["members1"] = "<b>%d</b> członków"; 
$string["members2"] = "<b>%d</b> członków"; 
$string["noRequests"] = "Nie ma próśb. Spokojnie!";
$string["pendingRequests"] = "Prośby klanu";
$string["closedClan"] = "Zamknięty klan";
$string["kickMember"] = "Wyrzuć członka";
$string["leaveFromClan"] = "Opuść klan";
$string["askToJoin"] = "Wyślij prośbę dołączenia";
$string["removeClanRequest"] = "Usuń prośbę dołączenia";
$string["joinClan"] = "Dołącz do klanu";
$string["noClans"] = "Nie ma klanów";
$string["clans"] = "Klany";
$string["alreadyInClan"] = "Już jesteś w klanie!";
$string["createClan"] = "Stwórz klan";
$string["createdClan"] = "Pomyślnie utworzono klan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Możesz tutaj stworzyć klan!";
$string["create"] = "Stwórz";
$string["mainSettings"] = "Główne ustawienia";
$string["takenClanName"] = "Ta nazwa klanu jest zajęta!";
$string["takenClanTag"] = "Ten znak klanu jest zajęty!";
$string["badClanName"] = "Please choose another clan name.";
$string["badClanTag"] = "Please choose another clan tag.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> zasuggestował(a) <b>%4$s%3$s</b> dla</text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> został zgłoszony</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Listy";
$string['listTableMod'] = "Ukryte listy";
$string['listTableYour'] = "Twoje ukryte listy";

$string['forgotPasswordChangeTitle'] = "Zmień hasło";
$string["successfullyChangedPass"] = "Hasło zostało pomyślnie zmienione!";
$string['forgotPasswordTitle'] = "Zapomniałeś(aś) hasła?";
$string['maybeSentAMessage'] = "Wyślemy do ciebie wiadomość jeśli te konto istnieje.";
$string['forgotPasswordDesc'] = "Możesz tutaj poprosić o link resetowania hasła jeśli go zapomniałeś(aś)!";
$string['forgotPasswordButton'] = "Poproś o link";

$string['sfxAdd'] = "Dodaj SFX";
$string["sfxAddError-5"] = "Rozmiar SFX jest większy niż $sfxSize megabajtów!";
$string["sfxAddError-6"] = "Coś poszło nie tak w trakcie wysyłania SFX!";
$string["sfxAddError-7"] = "Możesz wysyłać tylko audio!";
$string['sfxAdded'] = 'Dodano SFX';
$string['yourNewSFX'] = "Zobacz swój nowy SFX!";
$string["sfxAddAnotherBTN"] = "Jeszcze jeden SFX?";
$string["sfxAddDesc"] = "Możesz tutaj dodać swój SFX!";
$string["chooseSFX"] = "Wybierz SFX";
$string["sfxAddNameFieldPlaceholder"] = "Nazwa";
$string['sfxs'] = 'SFX';
$string['sfxID'] = 'ID SFX';
$string['manageSFX'] = 'Zarządzaj SFX';

$string['featureLevel'] = 'Featuruj poziom';

$string['banList'] = 'Lista zbanowanych osób';
$string['expires'] = 'Wygasa';
$string['unbanPerson'] = 'Odbanuj';
$string['IP'] = 'Adres IP';
$string['noBanInPast'] = 'Nie możesz zbanować do przeszłości!';
$string['banSuccess'] = 'Pomyślnie zbanowano <b>%1$s</b> do <b>%3$s</b> w «<b>%2$s</b>»!';
$string['person'] = 'Osoba';
$string['youAreBanned'] = 'Zostałeś(aś) zbanowany(na) do <b>%2$s</b> za:<br><b>%1$s</b>';
$string['banChange'] = 'Zmień';
$string['system'] = 'System';

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

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Wyślij";
$string["errorGeneric"] = "Pojawił się błąd!";
$string["smthWentWrong"] = "Coś poszło nie tak!";
$string["tryAgainBTN"] = "Spróbuj ponownie";
//songAdd.php
$string["songAddDesc"] = "Możesz tutaj dodać swoją piosenkę!";
$string["songAddUrlFieldLabel"] = "URL Piosenki: (Tylko Dropbox lub docelowy link)";
$string["songAddUrlFieldPlaceholder"] = "URL Piosenki";
$string["songAddNameFieldPlaceholder"] = "Nazwa";
$string["songAddAuthorFieldPlaceholder"] = "Autor";
$string["songAddButton"] = "Wybierz piosenkę";
$string["songAddAnotherBTN"] = "Inna Piosenka?";
$string["songAdded"] = "Piosenka dodana";
$string["deletedSong"] = "Pomyślnie usunięto piosenkę";
$string["renamedSong"] = "Pomyślnie zmieniono nazwę piosenki na";
$string["songID"] = "ID Piosenki: ";
$string["songIDw"] = "ID Piosenki";
$string["songAuthor"] = "Autor";
$string["size"] = "Rozmiar";
$string["delete"] = "Usuń";
$string["change"] = "Zmień";
$string["chooseFile"] = "Wybierz piosenkę";
$string['yourNewSong'] = "Sprawdź swoją nową piosenkę!";
///errors
$string["songAddError-2"] = "Nieprawidłowy URL";
$string["songAddError-3"] = "Ta piosenka już została wysłana ponownie z ID:";
$string["songAddError-4"] = "Tej piosenki nie można wysłać ponownie";
$string["songAddError-5"] = "Rozmiar piosenki jest większy niż $songSize megabajtów";
$string["songAddError-6"] = "Coś poszło nie tak podczas ponownego wysyłania piosenki!";
$string["songAddError-7"] = "Możesz wysyłać tylko audio!";

$string[400] = "Zła prośba!";
$string["400!"] = "Sparwdź sterowniki swojego sprzętu sieciowego.";
$string[403] = "Zabronione!";
$string["403!"] = "Nie masz dostępu do tej strony!";
$string[404] = "Strona nie znaleziona!";
$string["404!"] = "Jesteś pewien(na) że wipsałeś(aś) adres poprawnie?";
$string[500] = "Wewnętrzny błąd serwera!";
$string["500!"] = "Koder zrobił błąd w kodzie,</br>
proszę powiedzieć o tym błędzie tutaj:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Serwer padł!";
$string["502!"] = "Obciążenie serwera jest zbyt duże.</br>
Wróć za kilka godzin!";

$string["invalidCaptcha"] = "Nieprawidłowa odpowiedź captcha!";
$string["page"] = "Strona";
$string["emptyPage"] = "Ta strona jest pusta!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orby";
$string["stars"] = "Starsy";
$string["coins"] = "Coiny";
$string["accounts"] = "Konta";
$string["levels"] = "Poziomy";
$string["songs"] = "Piosenki";
$string["author"] = "Twórca";
$string["name"] = "Nazwa";
$string["date"] = "Data";
$string["type"] = "Typ";
$string["reportCount"] = "Liczba zgłoszeń";
$string["reportMod"] = "Zgłoszenia";
$string["username"] = "Nazwa";
$string["accountID"] = "ID Konta";
$string["registerDate"] = "Data rejestracji";
$string["levelAuthor"] = "Autor poziomu";
$string["isAdmin"] = "Rola na serwerze";
$string["isAdminYes"] = "Tak";
$string["isAdminNo"] = "Nie";
$string["userCoins"] = "User coiny";
$string["time"] = "Czas";
$string["deletedLevel"] = "Usunięty poziom";
$string["mod"] = "Moderator";
$string["count"] = "Liczba akcji";
$string["ratedLevels"] = "Ocenione poziomy";
$string["lastSeen"] = "Ostatni raz Online";
$string["level"] = "Poziom";
$string["pageInfo"] = "Strona %s z %s";
$string["first"] = "Pierwsza";
$string["previous"] = "Poprzedni";
$string["next"] = "Następny";
$string["never"] = "Nigdy";
$string["last"] = "Ostatni";
$string["go"] = "Idź";
$string["levelid"] = "ID Poziomu";
$string["levelname"] = "Nazwa poziomu";
$string["leveldesc"] = "Opis poziomu";
$string["noDesc"] = "Brak opisu";
$string["levelpass"] = "Hasło";
$string["nopass"] = "Brak hasła";
$string["unrated"] = "Nieoceniony";
$string["rate"] = "Ocena";
$string["stats"] = "Statystyki";
$string["suggestFeatured"] = "Featurowane?";
$string["whoAdded"] = "Kto dodał?";
$string["moons"] = "Moonsy";
//modActionsList
$string["banDesc"] = "Możesz tutaj zbanować gracza!";
$string["playerTop"] = 'Top graczy';
$string["creatorTop"] = 'Top twórców';
$string["levelUploading"] = 'Wysyłanie poziomów';
$string["successfullyBanned"] = 'Gracz <b>%1$s</b> z ID konta <b>%2$s</b> został pomyślnie zbanowany!';
$string["successfullyUnbanned"] = 'Gracz <b>%1$s</b> z ID konta <b>%2$s</b> został pomyślnie odbanowany!';
$string["commentBan"] = 'Komentowanie';

$string["admin"] = "Administrator";
$string["elder"] = "Elder moderator";
$string["moder"] = "Moderator";
$string["player"] = "Gracz";

$string["starsLevel2"] = "starsów";
$string["starsLevel1"] = "starsy";
$string["starsLevel0"] = "star";
$string["coins2"] = "coinów";
$string["coins1"] = "coiny";
$string["coins0"] = "coin";
$string["time0"] = "czas";
$string["time1"] = "czasy";
$string["times"] = "czasów";
$string["action0"] = "akcja";
$string["action1"] = "akcje";
$string["action2"] = "akcji";
$string["lvl0"] = "poziom";
$string["lvl1"] = "poziomy";
$string["lvl2"] = "poziomów";
$string["player0"] = "gracz";
$string["player1"] = "graczy";
$string["player2"] = "graczy";
$string["unban"] = "Odbanowanie";
$string["isBan"] = "Banowanie";

$string["noCoins"] = "Brak coinów";
$string["noReason"] = "Brak powodu";
$string["noActions"] = "Brak akcji";
$string["noRates"] = "Brak ocen";

$string["future"] = "Przyszłość";

$string["spoiler"] = "Spoiler";
$string["accid"] = "z ID konta";
$string["banned"] = "został pomyślnie zbanowany!";
$string["unbanned"] = "został pomyślnie odbanowany!";
$string["ban"] = "Zbanuj";
$string["nothingFound"] = "Ten gracz nie istnieje!";
$string["banUserID"] = "Nazwa lub ID konta";
$string["banUserPlace"] = "Zbanuj użytkownika";
$string["banYourself"] = "Nie możesz sam(a) się zbanować!"; 
$string["banYourSelfBtn!"] = "Zbanój kogoś innego";
$string["banReason"] = "Powód bana";
$string["action"] = "Akcja";
$string["value"] = "Pierwsza wartość";
$string["value2"] = "Druga wartość";
$string["value3"] = "Trzecia wartość";
$string["modAction1"] = "Oceniono poziom";
$string["modAction2"] = "Od-polecił poziom";
$string["modAction3"] = "Od-weryfikował coiny";
$string["modAction4"] = "Od-epikował poziom";
$string["modAction5"] = "Ustaw jako dzienny polecony";
$string["modAction6"] = "Usunął poziom";
$string["modAction7"] = "Zmiana twórcy";
$string["modAction8"] = "Zmienił nazwę poziomu";
$string["modAction9"] = "Zmienił hasło poziomu";
$string["modAction10"] = "Zmienił trudność demona";
$string["modAction11"] = "Udostępnił CP";
$string["modAction12"] = "Od-publikował poziom";
$string["modAction13"] = "Zmienił opis poziomu";
$string["modAction14"] = "Włączył/wyłączył LDM";
$string["modAction15"] = "Odbanował/zbanował na tabeli wyników";
$string["modAction16"] = "Zmiana ID piosenki";
$string["modAction17"] = "Stworzył Map Packa";
$string["modAction18"] = "Stworzył Gauntlet";
$string["modAction19"] = "Zmienił piosenkę";
$string["modAction20"] = "Promował gracza na moderatora";
$string["modAction21"] = "Zmienił Map Packa";
$string["modAction22"] = "Zmienił Gauntlet";
$string["modAction23"] = "Zmienił questa";
$string["modAction24"] = "Reassigned a player";
$string["modAction25"] = "Stworzył questa";
$string["modAction26"] = "Zmienił nazwę/hasło gracza";
$string["modAction27"] = "Zmienił SFX";
$string["modAction28"] = "Zbanował osobę";
$string["modAction29"] = "Locked/unlocked level updating";
$string["modAction30"] = "Ocenił lista";
$string["modAction31"] = "Wysłał listę";
$string["modAction32"] = "Polecił/od-polecił listę";
$string["modAction33"] = "Opublikował/od-publikował";
$string["modAction34"] = "Usunął listę";
$string["modAction35"] = "Zmienił twórcę listy";
$string["modAction36"] = "Zmienił nazwę listy";
$string["modAction37"] = "Zmienił opis listy";
$string["modAction38"] = "Locked/unlocked level commenting";
$string["modAction39"] = "Locked/unlocked list commenting";
$string["everyActions"] = "Jakiekolwiek akcje";
$string["everyMod"] = "Wszyscy moderatorzy";
$string["Kish!"] = "Idź sobie!";
$string["noPermission"] = "Nie masz uprawnień!";
$string["noLogin?"] = "Nie jesteś zalogowany(na) na swoje konto!";
$string["LoginBtn"] = "Zaloguj się na swoje konto";
$string["dashboard"] = "Panel";
$string["userID"] = 'ID użytkownika';
//errors
$string["errorNoAccWithPerm"] = "Błąd: Nie znaleziono kont z uprawnieniem '%s'";
