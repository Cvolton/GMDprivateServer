<?php
global $dbPath;
require __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Ana Sayfa";
$string["welcome"] = $gdps." sunucusuna hoş geldiniz!";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Kontrol paneline hoş geldin! Kurulumdan sonra bir kaç tavsiye:<br>
1. SQL içerisinde 'roles' tablosunda yeni izinler belirmiş gibi gözüküyor! Bunlara baksan çok iyi olur...<br>
2. 'dashboard' klasörüne 'icon.png' koyarsan, ikonun en sol köşede belirir!<br>
3. config/dashboard.php dosyanısı configüre et!";
$string["wwygdt"] = "Bugün ne yapacaksın?";
$string["game"] = "Oyun";
$string["guest"] = "ziyaterçi";
$string["account"] = "Hesap";
$string["levelsOptDesc"] = "Seviye listesini göster";
$string["songsOptDesc"] = "Şarkı listesini göster";
$string["yourClanOptDesc"] = "\"%s\" klanını göster";
$string["clanOptDesc"] = "Klan listesini göster";
$string["yourProfile"] = "Profilin";
$string["profileOptDesc"] = "Profilini göster";
$string["messengerOptDesc"] ="Messenger'ı aç";
$string["addSongOptDesc"] = "Sunucuya şarkı ekle";
$string["loginOptDesc"] = "Hesapa giriş yap";
$string["createAcc"] = "Hesap oluştur";
$string["registerOptDesc"] = "%s sunucusuna kayıt ol";
$string["downloadOptDesc"] = "%s için indir";

$string["tryCron"] = "Cron çalıştır";
$string["cronSuccess"] = "Başarılı!";
$string["cronError"] = "Hata!";

$string["profile"] = "Profil";
$string["empty"] = "Boş...";
$string["writeSomething"] = "Bir şeyler yaz!";
$string["replies"] = "Cevaplar";
$string["replyToComment"] = "Yoruma cevap yaz"; 
$string["settings"] = "Ayarlar";
$string["allowMessagesFrom"] = "Şuradan mesajlara izin ver...";
$string["allowFriendReqsFrom"] = "Şuradan arkadaşlık isteklerine izin ver...";
$string["showCommentHistory"] = "Yorum geçmişini göster...";
$string["timezoneChoose"] = "Choose timezone";
$string["yourYouTube"] = "YouTube kanalın";
$string["yourVK"] = "VK sayfan";
$string["yourTwitter"] = "Twitter sayfan";
$string["yourTwitch"] = "Twitch kanalın";
$string["saveSettings"] = "Ayarları kaydet";
$string["all"] = "Hepsi";
$string["friends"] = "Arkadaşlar";
$string["none"] = "Hiçbiri";
$string["youBlocked"] = "Bu oyuncu seni engelledi!";
$string["cantMessage"] = "Bu oyuncuya mesaj yazamazsınız!";

$string["accountManagement"] = "Hesap yönetimi";
$string["changePassword"] = "Şifreyi değiştir";
$string["changeUsername"] = "Kullanıcı adını değiştir";
$string["unlistedLevels"] = "Liste dışı bölümleriniz";

$string["manageSongs"] = "Şarkıları yönet";
$string["gauntletManage"] = "Gauntlet'leri yönet";
$string["suggestLevels"] = "Önerilen bölümler";

$string["modTools"] = "Mod Araçları";
$string["leaderboardBan"] = "Kullanıcı Banla";
$string["unlistedMod"] = "Liste dışı bölümler";

$string["reuploadSection"] = "Yeniden yükleme";
$string["songAdd"] = "Şarkı ekle";
$string["songLink"] = "Linkle şarkı ekle";
$string["packManage"] = "Harita paketlerini yönet";

$string["browse"] = "Gez";
$string["statsSection"] = "İstatistik";
$string["dailyTable"] = "Günlük bölümler";
$string["modActionsList"] = "Mod günlüğü";
$string["modActions"] = "Sunucu moderatörleri";
$string["gauntletTable"] = "Gauntlet listesi";
$string["packTable"] = "Harita paketi listesi";
$string["leaderboardTime"] = "Liderlik tablosu";

$string["download"] = "İndir";
$string["forwindows"] = "Windows";
$string["forandroid"] = "Android";
$string["formac"] = "Mac";
$string["forios"] = "iOS";
$string["third-party"] = "Üçüncü taraf";
$string["thanks"] = "Bu insanlara teşekkürler!";
$string["language"] = "Dil";

$string["loginHeader"] = "Merhaba, %s!";
$string["logout"] = "Çıkış";
$string["login"] = "Giriş";
$string["wrongNickOrPass"] = "Hatalı kullanıcı adı veya şifre!";
$string["invalidid"] = "Geçersiz ID!";
$string["loginBox"] = "Hesaba giriş yap";
$string["loginSuccess"] = "Hesabına başarıyla giriş yaptın!";
$string["loginAlready"] = "Zaten giriş yaptın!";
$string["clickHere"] = "Dashboard";
$string["enterUsername"] = "Kullanıcı adı gir";
$string["enterPassword"] = "Şifre gir";
$string["loginDesc"] = "Burada hesabına giriş yapabilirsin!";

$string["register"] = "Kayıt ol";
$string["registerAcc"] = "Hesap kaydı";
$string["registerDesc"] = "Hesabını kaydettir!";
$string["repeatpassword"] = "Şifre tekrarı";
$string["email"] = "E-Posta";
$string["repeatemail"] = "E-Posta tekrarı";
$string["smallNick"] = "Kullanıcı adı çok kısa!";
$string["smallPass"] = "Şifre çok kısa!";
$string["passDontMatch"] = "Şifreler eşleşmiyor!";
$string["emailDontMatch"] = "E-Postalar eşleşmiyor";
$string["registered"] = "Hesap başarıyla oluşturuldu!";
$string["bigNick"] = "Kullanıcı adı çok uzun!";
$string["mailExists"] = "Bu e-postayı kullanan bir hesap mevcut!";
$string["badUsername"] = "Başka bir kullanıcı adı seçin.";

$string["changePassTitle"] = "Şifre değiştir";
$string["changedPass"] = "Şifre başarıyla değiştirildi! Hesabına yeniden giriş yapman gerekiyor.";
$string["wrongPass"] = "Hatalı şifre!";
$string["samePass"] = "Girilen şifreler aynı!";
$string["changePassDesc"] = "Burada şifreni değiştirebilirsin!";
$string["oldPassword"] = "Eski şifre";
$string["newPassword"] = "Yeni şifre";
$string["confirmNew"] = "Şifreyi doğrula";

$string["forcePassword"] = "Zorla şifre değiştir";
$string["forcePasswordDesc"] = "Burada zorla bir oyuncunun şifresini değiştirebilirsin!";
$string["forceNick"] = "Zorla kullanıcı adı değiştir";
$string["forceNickDesc"] = "Burada zorla bir oyuncunun kullanıcı adını değiştirebilirsin!";
$string["forceChangedPass"] = "<b>%s</b> adlı üyenin şifresi başarıyla değiştirildi!";
$string["forceChangedNick"] = "<b>%s</b> adlı üyenin kullanıcı adı başarıyla değiştirildi!";
$string["changePassOrNick"] = "Üyenin kullanıcı adını ya da şifresini değiştir";

$string["changeNickTitle"] = "Kullanıcı adı değiştir";
$string["changedNick"] = "Kullanıcı adı başarıyla değiştirildi! Hesabına yeniden giriş yapman gerekiyor.";
$string["wrongNick"] = "Hatalı kullanıcı adı!";
$string["sameNick"] = "Girilen kullanıcı adları aynı!";
$string["alreadyUsedNick"] = "Girilen kullanıcı adı zaten alınmış!";
$string["changeNickDesc"] = "Burada kullanıcı adını değiştirebilirsin!";
$string["oldNick"] = "Eski kullanıcı adı";
$string["newNick"] = "Yeni kullanıcı adı";
$string["password"] = "Şifre";

$string["packCreate"] = "Harita Paketi Yarat";
$string["packCreateTitle"] = "Harita Paketi Yarat";
$string["packCreateDesc"] = "Burada harita paketi yaratabilirsin!";
$string["packCreateSuccess"] = "Başarıyla harita paketi yaratıldı:";
$string["packCreateOneMore"] = "Başka ekle?";
$string["packName"] = "Paketin ismi";
$string["color"] = "Renk";
$string["sameLevels"] = "Aynı bölümleri seçtin!";
$string["show"] = "Göster";
$string["packChange"] = "Harita Paketi Değiştir";
$string["createNewPack"] = "Yeni Harita Paketi Oluştur!"; // Translate word "create" like its call to action

$string["gauntletCreate"] = "Gauntlet Oluştur";
$string["gauntletCreateTitle"] = "Gauntlet Oluştur";
$string["gauntletCreateDesc"] = "Burada Gauntlet yaratabilirsin!";
$string["gauntletCreateSuccess"] = "Başarıyla Gauntlet oluşturdun!";
$string["gauntletCreateOneMore"] = "Başka ekle?";
$string["chooseLevels"] = "Bölümleri seç!";
$string["checkbox"] = "Onayla";
$string["level1"] = "1 bölüm";
$string["level2"] = "2 bölüm";
$string["level3"] = "3 bölüm";
$string["level4"] = "4 bölüm";
$string["level5"] = "5 bölüm";
$string["gauntletChange"] = "Gauntlet Değiştir";
$string["createNewGauntlet"] = "Yeni Gauntlet Oluştur!"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'Başarıyla <b>%1$s</b> adlı Gauntlet oluşturuldu!';
$string["gauntletSelectAutomatic"] = "Otomatik olarak Gauntlet Seç";

$string["addQuest"] = "Quest Ekle";
$string["addQuestDesc"] = "Burada quest ekleyebilirsin!";
$string["questName"] = "Quest adı";
$string["questAmount"] = "Gerekli sayı";
$string["questReward"] = "Ödül";
$string["questCreate"] = "Quest oluştur";
$string["questsSuccess"] = "Başarıyla quest oluşturdun";
$string["invalidPost"] = "Geçersiz data!";
$string["fewMoreQuests"] = "Birkaç tane daha quest oluşturmanız önerilir.";
$string["oneMoreQuest?"] = "Başka ekle?";
$string["changeQuest"] = "Quest değiştir";
$string["createNewQuest"] = "Yeni Quest Oluştur!"; // like gauntlets and mappacks above

$string["levelReupload"] = "Bölüm aktarma";
$string["levelReuploadDesc"] = "Burada başka bir sunucudan bölüm aktarabilirsin!";
$string["advanced"] = "Gelişmiş seçenekler";
$string["errorConnection"] = "Bağlantı hatası!";
$string["levelNotFound"] = "Bu bölüm yok!";
$string["robtopLol"] = "RobTop sizi sevmiyor :c";
$string["sameServers"] = "Kaynak ve hedef sunucu aynı!";
$string["levelReuploaded"] = "Bölüm aktarıldı! Bölüm ID:";
$string["oneMoreLevel?"] = "Başka ekle?";
$string["levelAlreadyReuploaded"] = "Bölüm zaten aktarılmış!";
$string["server"] = "Sunucu";
$string["levelID"] = "Bölüm ID";
$string["pageDisabled"] = "Bu sayfa devre dışı!";
$string["levelUploadBanned"] = "Bölüm yüklemekten yasaklandınız!";

$string["activateAccount"] = "Hesap aktifleştirme";
$string["activateDesc"] = "Hesabını aktif et!";
$string["activated"] = "Hesabın başarıyla aktif edildi!";
$string["alreadyActivated"] = "Hesabın zaten aktif";
$string["maybeActivate"] = "Belki de hesabını henüz aktif etmedin.";
$string["activate"] = "Aktif et";
$string["activateDisabled"] = "Hesap aktifleştirme devre dışı!";

$string["addMod"] = "Moderatör ekle";
$string["addModDesc"] = "Burada moderatör ekleyebilirsin!";
$string["modYourself"] = "Kendini moderatör yapamazsın!";
$string["alreadyMod"] = "Kullanıcı zaten moderatör!";
$string["addedMod"] = "Kullanıcıya moderatörlük verildi";
$string["addModOneMore"] = "Başka ekle?";
$string["modAboveYourRole"] = "Senden daha yüksek bir rolü vermeye çalışıyorsun!";
$string["makeNewMod"] = "Birini moderatör yap!";
$string["reassignMod"] = "Yeniden moderatör ata";
$string["reassign"] = "Yeniden ata";
$string['demotePlayer'] = "Oyuncunun yetkisini düşür";
$string['demotedPlayer'] = "<b>%s</b> adlı oyuncunun yetkisini başarıyla düşürdün!";
$string['addedModNew'] = "<b>%s</b> adlı oyuncuya başarıyla moderatör yetkisi verdin!";
$string['demoted'] = 'Yetkisi düşürüldü';

$string["shareCPTitle"] = "Creator Point ekle";
$string["shareCPDesc"] = "Burada kullanıcılara CP ekleyebilirsin!";
$string["shareCP"] = "Ekle";
$string["alreadyShared"] = "Bu bölüm zaten kullanıcıya puan eklemiş!";
$string["shareToAuthor"] = "Bölüm sahibine CP paylaşmaya çalıştın!";
$string["userIsBanned"] = "Kullanıcının yasağı var!";
$string["shareCPOneMore"] = "Başka ekle?";
$string['shareCPSuccessNew'] = '<b>%1$s</b> adlı seviyeye ve <b>%2$s</b> adlı oyuncuya başarıyla Creator Point paylaştın!';

$string["messenger"] = "Messenger";
$string["write"] = "Yaz";
$string["send"] = "Gönder";
$string["noMsgs"] = "Diyalog başlat!";
$string["subject"] = "Konu";
$string["msg"] = "Mesaj";
$string["tooFast"] = "Çok hızlı yazıyorsun!";
$string["messengerYou"] = "Sen:";
$string["chooseChat"] = "Sohbet seç";

$string["levelToGD"] = "Bölümü hedef sunucuya aktar";
$string["levelToGDDesc"] = "Burada bölümünü hedef sunucuya aktarabilirsin!";
$string["usernameTarget"] = "Hedef sunucudaki kullanıcı adı";
$string["passwordTarget"] = "Hedef sunucudaki şifre";
$string["notYourLevel"] = "Bu senin bölümün değil!";
$string["reuploadFailed"] = "Aktarma hatası!";

$string["search"] = "Ara...";
$string["searchCancel"] = "Aramayı iptal et";
$string["emptySearch"] = "Hiçbir şey bulunamadı!";

$string["approve"] = 'Onayla';
$string["deny"] = 'Reddet';
$string["submit"] = 'Gönder';
$string["place"] = 'Sıra';
$string["add"] = 'Ekle';
$string["demonlistLevel"] = '%s<text class="dltext"><button type="button" onclick="a(\'profile/%3$s\', true, true)" style="margin-left: 5px; font-size: 25px" class="accbtn" name="accountID" value="%d">%s %4$s</button> tarafından</text>';

$string["didntActivatedEmail"] = 'Hesabını e-posta üzerinden aktive etmedin!';
$string["checkMail"] = 'E-postanı kontrol etmelisin...';

$string["likeSong"] = "Şarkıyı favorilere ekle";
$string["dislikeSong"] = "Favorilerden şarkı kaldır";
$string["favouriteSongs"] = "Favori şarkılar";
$string["howMuchLiked"] = "Ne kadar beğenildi?";
$string["nooneLiked"] = "Kimse beğenmedi";

$string["clan"] = "Klan";
$string["joinedAt"] = "Şu klana katıldın: <b>%s</b>";
$string["createdAt"] = "Klan oluşturdun: <b>%s</b>";
$string["clanMembers"] = "Klan üyeleri";
$string["noMembers"] = "Üye yok";
$string["clanOwner"] = "Klan sahibi";
$string["noClanDesc"] = "<i>Açıklama yok</i>";
$string["noClan"] = "Bu klan mevcut değil!";
$string["clanName"] = "Klan ismi";
$string["clanTag"] = "Klan etiketi (3-5 karakter)";
$string["clanDesc"] = "Klan açıklaması";
$string["clanColor"] = "Klan rengi";
$string["dangerZone"] = "Tehlikeli bölge";
$string["giveClan"] = "Klanı ver";
$string["deleteClan"] = "Klanı sil";
$string["goBack"] = "Geri dön";
$string["areYouSure"] = "Emin misin?";
$string["giveClanDesc"] = "Burada klanı başka bir oyuncuya verebilirsin.";
$string["notInYourClan"] = "Bu oyuncu klanında değil!";
$string["givedClan"] = "Klanı başarıyla <b>%s</b> adlı oyuncuya verdin!";
$string["deletedClan"] = "<b>%s</b> klanını sildin.";
$string["deleteClanDesc"] = "Burada klanını silebilirsin.";
$string["yourClan"] = "Klanın";
$string["members0"] = "<b>1</b> üye";
$string["members1"] = "<b>%d</b> üye"; 
$string["members2"] = "<b>%d</b> üye"; 
$string["noRequests"] = "Hiç istek yok. Sakinleş!";
$string["pendingRequests"] = "Klan istekleri";
$string["closedClan"] = "Kapalı klan";
$string["kickMember"] = "Üye at";
$string["leaveFromClan"] = "Klandan ayrıl";
$string["askToJoin"] = "Katılma isteği gönder";
$string["removeClanRequest"] = "Katılma isteğini sil";
$string["joinClan"] = "Klana katıl";
$string["noClans"] = "Klan yok";
$string["clans"] = "Klanlar";
$string["alreadyInClan"] = "Zaten bir klan üyesisin!";
$string["createClan"] = "Klan oluştur";
$string["createdClan"] = "<span style='font-weight:700;color:#%s'>%s</span> klanını oluşturdun!";
$string["createClanDesc"] = "Burada klan oluşturabilirsin!";
$string["create"] = "Oluştur";
$string["mainSettings"] = "Ana ayarlar";
$string["takenClanName"] = "Bu klan ismi zaten alınmış!";
$string["takenClanTag"] = "Bu klan etiketi zaten alınmış!";
$string["badClanName"] = "Lütfen başka bir klan ismi seç.";
$string["badClanTag"] = "Lütfen başka bir klan etiketi seç.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> adlı oyuncu </text><text class="levelname">%2$s</text><text class="dltext"> adlı bölümü <b>%4$s%3$s</b> için önerdi.</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s <text class="levelname">%2$s</text><text class="dltext"> adlı bölümü raporladı</text>';

$string['listTable'] = "Listeler";
$string['listTableMod'] = "Liste dışı listeler";
$string['listTableYour'] = "Liste dışı listelerin";

$string['forgotPasswordChangeTitle'] = "Şifreni değiştir";
$string["successfullyChangedPass"] = "Şifre başarıyla değiştirildi!";
$string['forgotPasswordTitle'] = "Şifreni mi unuttun?";
$string['maybeSentAMessage'] = "Hesap mevcutsa size bir mesaj göndereceğiz.";
$string['forgotPasswordDesc'] = "Buradan şifreni unuttuysan şifre sıfırlama linki alabilirsin!";
$string['forgotPasswordButton'] = "Link iste";

$string['sfxAdd'] = "SFX ekle";
$string["sfxAddError-5"] = "SFX boyutu $sfxSize megabayttan fazla!";
$string["sfxAddError-6"] = "SFX eklerken bir sorun oluştu!";
$string["sfxAddError-7"] = "Sadece ses ekleyebilirsin!";
$string['sfxAdded'] = 'SFX eklendi';
$string['yourNewSFX'] = "Yeni SFX'ine bir göz at!";
$string["sfxAddAnotherBTN"] = "Daha fazla SFX ekle?";
$string["sfxAddDesc"] = "Burada SFX ekleyebilirsin!";
$string["chooseSFX"] = "SFX seç";
$string["sfxAddNameFieldPlaceholder"] = "İsim";
$string['sfxs'] = 'SFX';
$string['sfxID'] = 'SFX ID';
$string['manageSFX'] = "SFX'leri yönet";

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

$string["reuploadBTN"] = "Transfer Et";
$string["errorGeneric"] = "Hata!";
$string["smthWentWrong"] = "Bir şeyler ters gitti!";
$string["tryAgainBTN"] = "Tekrar Dene";
//songAdd.php
$string["songAddDesc"] = "Burada kendi şarkını ekleyebilirsin!";
$string["songAddUrlFieldLabel"] = "Şarkı Linki: (Direkt veya DropBox. YOUTUBE LINKI ÇALIŞMAZ!)";
$string["songAddUrlFieldPlaceholder"] = "Şarkı Linki";
$string["songAddNameFieldPlaceholder"] = "İsim";
$string["songAddAuthorFieldPlaceholder"] = "Sahip";
$string["songAddButton"] = "Şarkı seç";
$string["songAddAnotherBTN"] = "Başka ekle?";
$string["songAdded"] = "Song eklendi!";
$string["deletedSong"] = "Şarkıyı başarıyla sildin";
$string["songID"] = "Şarkı ID: ";
$string["songIDw"] = "Şarkı ID";
$string["songAuthor"] = "Sahip";
$string["size"] = "Boyut";
$string["delete"] = "Sil";
$string["change"] = "Değiştir";
$string["chooseFile"] = "Bir şarkı seç";
$string['yourNewSong'] = "Yeni şarkına bir göz at!";
///errors
$string["songAddError-2"] = "Geçersiz URL (Şarkının bu linkte bulunduğundan emin olun.)";
$string["songAddError-3"] = "Bu şarkı zaten transfer edilmiş. ID:";
$string["songAddError-4"] = "Bu şarkı transfer edilemez";
$string["songAddError-5"] = "Şarkı boyutu $songSize megabayttan daha büyük";
$string["songAddError-6"] = "Bir şeyler ters gitti! :с";
$string["songAddError-7"] = "Sadece ses dosyası yükleyebilirsin!";

$string[400] = "Kötü istek!";
$string["400!"] = "Sürücülerini veya bağlantı cihazlarını kontrol et.";
$string[403] = "Yasak!";
$string["403!"] = "Bu sayfaya erişim iznin yok!";
$string[404] = "Sayfa bulunamadı!";
$string["404!"] = "Adresi doğru yazdığından emin misin?";
$string[500] = "İç sunucu hatası!";
$string["500!"] = "Geliştirici kodda bir hata yapmış,</br>
lütfen sorunu buradan bildirin:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Sunucuya ulaşılamıyor!";
$string["502!"] = "Sunucudaki yük çok ağır.</br>
Birkaç saat içerisinde tekrar ziyaret edin!";

$string["invalidCaptcha"] = "Geçersiz Captcha isteği!";
$string["page"] = "Sayfa";
$string["emptyPage"] = "Bu sayfa boş!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "Orblar";
$string["stars"] = "Yıldız";
$string["coins"] = "Coin";
$string["accounts"] = "Hesaplar";
$string["levels"] = "Bölümler";
$string["songs"] = "Şarkılar";
$string["author"] = "Oluşturucu";
$string["name"] = "İsim";
$string["date"] = "Tarih";
$string["type"] = "Tür";
$string["reportCount"] = "Rapor sayısı";
$string["reportMod"] = "Raporlar";
$string["username"] = "Kullanıcı adı";
$string["accountID"] = "Hesap ID";
$string["registerDate"] = "Kayıt tarihi";
$string["isAdminYes"] = "Evet";
$string["isAdminNo"] = "Hayır";
$string["userCoins"] = "Kullanıcı coinleri";
$string["time"] = "Zaman";
$string["deletedLevel"] = "Silinen bölüm";
$string["mod"] = "Moderatör";
$string["count"] = "Aksiyon sayısı";
$string["ratedLevels"] = "Derecelendirilen Bölümler";
$string["lastSeen"] = "Son Çevrimiçi";
$string["level"] = "Bölüm";
$string["pageInfo"] = "Sayfa %s / %s";
$string["first"] = "İlk";
$string["previous"] = "Önceki";
$string["next"] = "Sonraki";
$string["never"] = "Asla";
$string["last"] = "Son";
$string["go"] = "İleri";
$string["levelid"] = "Bölüm ID";
$string["levelname"] = "Bölüm ismi";
$string["leveldesc"] = "Bölüm açıklaması";
$string["noDesc"] = "Açıklama yok";
$string["levelpass"] = "Şifre";
$string["nopass"] = "Şifre yok";
$string["unrated"] = "Derecesiz";
$string["rate"] = "Derecelendir";
$string["stats"] = "İstatistik";
$string["suggestFeatured"] = "Tavsiye et?";
$string["whoAdded"] = "Kim ekledi?";
$string["moons"] = "Moons";
//modActionsList
$string["banDesc"] = "Here you can ban a player!";
$string["playerTop"] = 'En iyi oyuncular';
$string["creatorTop"] = 'En iyi yaratıcılar';
$string["levelUploading"] = 'Bölümler yükleniyor';
$string["successfullyBanned"] = '<b>%1$s</b> adlı oyuncu <b>%2$s</b> ID ile başarıyla yasaklandı!';
$string["successfullyUnbanned"] = '<b>%1$s</b> adlı oyuncu <b>%2$s</b> ID ile başarıyla yasaklanmadan kurtarıldı!';
$string["commentBan"] = 'Yorum';

$string["player"] = "Oyuncu";

$string["starsLevel2"] = "yıldız";
$string["starsLevel1"] = "yıldız";
$string["starsLevel0"] = "yıldız";
$string["coins1"] = "coin";
$string["coins0"] = "coin";
$string["unban"] = "Yasak kaldırma";
$string["isBan"] = "Yasaklama";

$string["noCoins"] = "Coin yok";
$string["noReason"] = "Sebep yok";
$string["noActions"] = "Aksiyon yok";
$string["noRates"] = "Derecelendirme yok";

$string["future"] = "Gelecek";

$string["spoiler"] = "Spoiler";
$string["accid"] = "ID'si";
$string["banned"] = "başarıyla yasaklandı!";
$string["unbanned"] = "başarıyla yasağı kaldırıldı!";
$string["ban"] = "Yasak";
$string["nothingFound"] = "Bu oyuncu mevcut değil!";
$string["banUserID"] = "Kullanıcı adı veya hesap ID'si";
$string["banUserPlace"] = "Kullanıcı yasakla";
$string["banYourself"] = "Kendini yasaklayamazsın!"; 
$string["banYourSelfBtn!"] = "Başkasını yasakla";
$string["banReason"] = "Yasak sebebi";
$string["action"] = "Aksiyon";
$string["value"] = "1. değer";
$string["value2"] = "2. değer";
$string["value3"] = "3. değer";
$string["modAction1"] = "Bölüm derecelendirdi";
$string["modAction2"] = "Bölüm onayladı/onaylamadı";
$string["modAction3"] = "Parayı onayladı/onaylamadı";
$string["modAction4"] = "Bölüm üstün kılındı/kılınmadı";
$string["modAction5"] = "Günlük bölüm ayarladı.";
$string["modAction6"] = "Bölüm sildi";
$string["modAction7"] = "Sahip değiştirildi";
$string["modAction8"] = "Bölüm ismi değiştirildi";
$string["modAction9"] = "Bölüm şifresi değiştirildi";
$string["modAction10"] = "Demon seviyesi değiştirildi";
$string["modAction11"] = "CP paylaşıldı";
$string["modAction12"] = "Bölüm açıldı/kapatıldı";
$string["modAction13"] = "Bölüm açıklaması değiştirildi";
$string["modAction14"] = "LDM açıldı/açılmadı";
$string["modAction15"] = "Kullanıcı yasaklandı/yasaklamadan kurtarıldı";
$string["modAction16"] = "Şarkı ID değiştirme";
$string["modAction17"] = "Harita paketi oluşturdu";
$string["modAction18"] = "Gauntlet oluşturuldu";
$string["modAction19"] = "Şarkı değiştirildi";
$string["modAction20"] = "Moderatörlük verdi";
$string["modAction21"] = "Harita Paketi değiştirdi";
$string["modAction22"] = "Gauntlet değiştirdi";
$string["modAction23"] = "Quest değiştirdi";
$string["modAction24"] = "Oyuncuyu yeniden atadı";
$string["modAction25"] = "Quest oluşturdu";
$string["modAction26"] = "Kullanıcı adı/şifre değiştirdi";
$string["modAction27"] = "SFX değiştirildi";
$string["modAction28"] = "Banned person";
$string["modAction29"] = "Locked/unlocked level updating";
$string["modAction30"] = "Derecelendirilen liste";
$string["modAction31"] = "Gönderilen liste";
$string["modAction32"] = "Liste onayladı/onaylamadı";
$string["modAction33"] = "Liste paylaşıldı/paylaşılmadı";
$string["modAction34"] = "Liste silindi";
$string["modAction35"] = "Liste sahibi değiştirildi";
$string["modAction36"] = "Liste ismi değiştirildi";
$string["modAction37"] = "Liste açıklaması değiştirildi";
$string["modAction38"] = "Locked/unlocked level commenting";
$string["modAction39"] = "Locked/unlocked list commenting";
$string["modAction40"] = "Removed sent level";
$string["modAction41"] = "Suggested level";
$string["modAction42"] = "Created vault code";
$string["modAction43"] = "Changed vault code";
$string["modAction44"] = "Set level as event level";
$string["everyActions"] = "Tüm eylemler";
$string["everyMod"] = "Tüm moderatörler";
$string["Kish!"] = "Uzak dur!";
$string["noPermission"] = "İznin yok!";
$string["noLogin?"] = "Hesabına giriş yapmadın!";
$string["LoginBtn"] = "Hesaba giriş yap";
$string["dashboard"] = "Dashboard";
$string["userID"] = 'Kullanıcı ID';