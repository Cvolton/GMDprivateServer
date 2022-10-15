<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Ana Sayfa";
$string["welcome"] = $gdps." sunucusuna hoş geldiniz!";
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Uyarı!</b> Dashboard'ı tam olarak kurmamışsınız! Buraya basarak tam kurulumu yapın.</div>";
$string["levelsWeek"] = "Bir hafta içinde yüklenen bölümler";
$string["levels3Months"] = "3 ayda yüklenen bölümler";
$string["footer"] = $gdps.", ".date('Y', time());

$string["profile"] = "Profil";
$string["empty"] = "Boş...";
$string["writeSomething"] = "Bir şeyler yaz!";  

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
$string["changePassOrNick"] = "Change player's username or password";

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

$string["addQuest"] = "Quest ekle";
$string["addQuestDesc"] = "Burada quest ekleyebilirsin!";
$string["questName"] = "Quest adı";
$string["questAmount"] = "Gerekli sayı";
$string["questReward"] = "Ödül";
$string["questCreate"] = "Quest oluştur";
$string["questsSuccess"] = "Başarıyla quest oluşturdun";
$string["invalidPost"] = "Geçersiz data!";
$string["fewMoreQuests"] = "Birkaç tane daha quest oluşturmanız önerilir.";
$string["oneMoreQuest?"] = "Başka ekle?";

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

$string["shareCPTitle"] = "Creator Point ekle";
$string["shareCPDesc"] = "Burada kullanıcılara CP ekleyebilirsin!";
$string["shareCP"] = "Ekle";
$string["alreadyShared"] = "Bu bölüm zaten kullanıcıya puan eklemiş!";
$string["shareToAuthor"] = "Bölüm sahibine CP paylaşmaya çalıştın!";
$string["userIsBanned"] = "Kullanıcının yasağı var!";
$string["shareCPSuccess"] = "Başarıyla bu bölüm için CP paylaşıldı. ";
$string["shareCPSuccess2"] = "Paylaşılan kullanıcı:";
$string["updateCron"] = "Belki de CP güncellemen lazım.";
$string["shareCPOneMore"] = "Başka ekle?";

$string["messenger"] = "Messenger";
$string["write"] = "Yaz";
$string["send"] = "Gönder";
$string["noMsgs"] = "Diyalog başlat!";
$string["subject"] = "Konu";
$string["msg"] = "Mesaj";
$string["tooFast"] = "Çok hızlı yazıyorsun!";

$string["levelToGD"] = "Bölümü hedef sunucuya aktar";
$string["levelToGDDesc"] = "Burada bölümünü hedef sunucuya aktarabilirsin!";
$string["usernameTarget"] = "Hedef sunucudaki kullanıcı adı";
$string["passwordTarget"] = "Hedef sunucudaki şifre";
$string["notYourLevel"] = "Bu senin bölümün değil!";
$string["reuploadFailed"] = "Aktarma hatası!";

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Transfer Et";
$string["errorGeneric"] = "Hata!";
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
$string["renamedSong"] = "Şarkıyı başarıyla yeniden adlandırdın:";
$string["songID"] = "Şarkı ID: ";
$string["songIDw"] = "Şarkı ID";
$string["songAuthor"] = "Sahip";
$string["size"] = "Boyut";
$string["delete"] = "Sil";
$string["change"] = "Değiştir";
$string["chooseFile"] = "Bir şarkı seç";
///errors
$string["songAddError-2"] = "Geçersiz URL (Şarkının bu linkte bulunduğundan emin olun.)";
$string["songAddError-3"] = "Bu şarkı zaten transfer edilmiş. ID:";
$string["songAddError-4"] = "Bu şarkı transfer edilemez";
$string["songAddError-5"] = "Şarkı boyutu $songSize megabyte'dan daha büyük";
$string["songAddError-6"] = "Bir şeyler ters gitti! :с";
$string["songAddError-7"] = "Sadece ses dosyası yükleyebilirsin!";

$string[400] = "Kötü istek!";
$string[403] = "Yasak!";
$string[404] = "Sayfa bulunamadı!";
$string[500] = "İç sunucu hatası!";
$string[502] = "Sunucuya ulaşılamıyor!";

$string["invalidCaptcha"] = "Invalid captcha response!";
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
$string["levelAuthor"] = "Bölüm sahibi";
$string["isAdmin"] = "Sunucu rolü";
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
$string["suggestFeatured"] = "Tavsiye et?";
$string["whoAdded"] = "Kim ekledi?";
//modActionsList
$string["banDesc"] = "Burada bir kullanıcıyı sıralamadan yasaklayabilirsin!";

$string["admin"] = "Yönetici";
$string["elder"] = "Büyük moderatör";
$string["moder"] = "Moderatör";
$string["player"] = "Oyuncu";

$string["starsLevel2"] = "yıldız";
$string["starsLevel1"] = "yıldız";
$string["starsLevel0"] = "yıldız";
$string["coins2"] = "coin";
$string["coins1"] = "coin";
$string["coins0"] = "coin";
$string["time0"] = "süre";
$string["time1"] = "süre";
$string["times"] = "süre";
$string["action0"] = "aksiyon";
$string["action1"] = "aksiyon";
$string["action2"] = "aksiyon";
$string["lvl0"] = "bölüm";
$string["lvl1"] = "bölüm";
$string["lvl2"] = "bölüm";
$string["unban"] = "Unban";
$string["isBan"] = "Ban";

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
$string["modAction1"] = "(1)Bölüm derecelendirdi";
$string["modAction2"] = "(2)Bölüm onayladı/onaylamadı";
$string["modAction3"] = "(3)Parayı onayladı/onaylamadı";
$string["modAction4"] = "(4)Bölüm üstün kılındı/kılınmadı";
$string["modAction5"] = "(5)Günlük bölüm ayarladı.";
$string["modAction6"] = "(6)Bölüm sildi";
$string["modAction7"] = "(7)Sahip değiştirildi";
$string["modAction8"] = "(8)Bölüm ismi değiştirildi";
$string["modAction9"] = "(9)Bölüm şifresi değiştirildi";
$string["modAction10"] = "(10)Demon seviyesi değiştirildi";
$string["modAction11"] = "(11)CP paylaşıldı";
$string["modAction12"] = "(12)Bölüm açıldı/kapatıldı";
$string["modAction13"] = "(13)Bölüm açıklaması değiştirildi";
$string["modAction14"] = "(14)LDM açıldı/açılmadı";
$string["modAction15"] = "(15)Kullanıcı banlandı/unbanlandı";
$string["modAction16"] = "(16)Şarkı ID değiştirme";
$string["modAction17"] = "(17)Harita paketi oluşturdu";
$string["modAction18"] = "(18)Gauntlet oluşturuldu";
$string["modAction19"] = "(19)Şarkı değiştirildi";
$string["modAction20"] = "(20)Moderatörlük verdi";
$string["modAction25"] = "(25)Quest oluşturdu";
$string["modAction26"] = "(26)Kullanıcı adı/şifre değiştirdi";
$string["Kish!"] = "Uzak dur!";
$string["noPermission"] = "İznin yok!";
$string["noLogin?"] = "Hesabına giriş yapmadın!";
$string["LoginBtn"] = "Hesaba giriş yap";
$string["dashboard"] = "Dashboard";
//errors
$string["errorNoAccWithPerm"] = "HATA: '%s' izni hiçbir hesapta bulunamadı.";