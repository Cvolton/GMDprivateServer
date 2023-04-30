<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Ana Sayfa";
$string["welcome"] = $gdps." sunucusuna hoş geldiniz!";
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Uyarı!</b> Dashboard'ı tam olarak kurmamışsınız! Buraya basarak tam kurulumu yapın.</div>";
$string["levelsWeek"] = "Bir hafta içinde yüklenen bölümler";
$string["levels3Months"] = "3 ayda yüklenen bölümler";
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
$string["createNewPack"] = "Yeni Harita Paketi Oluştur!"; // Translate word "create" like "You'll need to create new map pack!", but its call to action

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
$string["createNewGauntlet"] = "Yeni Gauntlet Oluştur!"; // Translate word "create" like "You'll need to create new gauntlet!", but its call to action

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

$string["search"] = "Ara...";
$string["searchCancel"] = "Aramayı iptal et";
$string["emptySearch"] = "Hiçbir şey bulunamadı!";

$string["demonlist"] = 'Demon listesi';
$string["demonlistRecord"] = '<b>%s</b> adlı oyuncunun rekoru';
$string["alreadyApproved"] = 'Zaten onaylı!';
$string["alreadyDenied"] = 'Zaten red edilmiş!';
$string["approveSuccess"] = 'Başarıyla <b>%s</b>\ adlı oyuncunun rekorunu onayladın!';
$string["denySuccess"] = 'Başarıyla <b>%s</b>\ adlı oyuncunun rekorunu reddettin!';
$string["recordParameters"] = '<b>%s</b> <b>%s</b> adlı oyuncuyu <b>%d</b> denemede yendi';
$string["approve"] = 'Onayla';
$string["deny"] = 'Reddet';
$string["submitRecord"] = 'Rekoru gönder';
$string["submitRecordForLevel"] = '<b>%s</b> için rekor gönder';
$string["alreadySubmitted"] = 'Zaten <b>%s</b> için rekor gönderdin!';
$string["submitSuccess"] = '<b>%s</b> için rekor gönderildi!';
$string["submitRecordDesc"] = 'Rekorları sadece bölümü geçtiyseniz gönderin!';
$string["atts"] = 'Deneme';
$string["ytlink"] = 'YouTube video kodu (dQw4w9WgXcQ)';
$string["submit"] = 'Gönder';
$string["addDemonTitle"] = 'Demon ekle';
$string["addDemon"] = 'Demon listesine demon ekle';
$string["addedDemon"] = '<b>%s</b> bölümünü <b>%d</b> sıraya ekledin!';
$string["addDemonDesc"] = 'Burada demon seviyesi bir bölümü demon listesine ekleyebilirsin!';
$string["place"] = 'Sıra';
$string["giveablePoints"] = 'Verilebilir puan';
$string["add"] = 'Ekle';
$string["recordApproved"] = 'Rekor onaylandı!';
$string["recordDenied"] = 'Rekor reddedildi!';
$string["recordSubmitted"] = 'Rekor gönderildi!';
$string["nooneBeat"] = 'kimse geçemedi'; //let it be lowercase
$string["oneBeat"] = '1 oyuncu geçti'; 
$string["lower5Beat"] = '%d oyuncu geçti'; // russian syntax, sorry
$string["above5Beat"] = '%d oyuncu geçti'; 
$string["demonlistLevel"] = '%s<text style="display: inline-flex;font-size: 25px;font-weight:400"><form style="margin:0" method="post" action="profile/"><button style="margin-left:7;font-size:25" class="accbtn" name="accountID" value="%d">%s</button></form> tarafından</text>';
$string["noDemons"] = 'Görünüşe göre demon listesi demon seviyesi bölüm içermiyor...';
$string["addSomeDemons"] = 'Listeyi doldurmak için demon seviyesi bölüm ekle!';
$string["askForDemons"] = 'Bir yöneticiden bu listeye eklemesini iste!';
$string["recordList"] = 'Rekor listesi';
$string["status"] = 'Durum';
$string["checkRecord"] = 'Rekoru kontrol et';
$string["record"] = 'Rekor';
$string["recordDeleted"] = 'Rekor silindi!';
$string["changeDemon"] = 'Change demon';
$string["demonDeleted"] = 'Demon was deleted!';
$string["changedDemon"] = 'You replaced <b>%s</b> to <b>%d</b> place!';
$string["changeDemonDesc"] = 'Here you can change a demon!<br>
If you want to delete demon, set place to 0.';

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
$string["stats"] = "İstatistik";
$string["suggestFeatured"] = "Tavsiye et?";
$string["whoAdded"] = "Kim ekledi?";
//modActionsList
$string["banDesc"] = "Burada bir kullanıcıyı sıralamadan yasaklayabilirsin!";
$string["playerTop"] = 'Top of players';
$string["creatorTop"] = 'Top of creators';

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
$string["player0"] = "oyuncu";
$string["player1"] = "oyuncu";
$string["player2"] = "oyuncu";
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
$string["modAction21"] = "(21)Harita Paketi değiştirdi";
$string["modAction22"] = "(22)Gauntlet değiştirdi";
$string["modAction23"] = "(23)Quest değiştirdi";
$string["modAction24"] = "(24)Oyuncuyu yeniden atadı";
$string["modAction25"] = "(25)Quest oluşturdu";
$string["modAction26"] = "(26)Kullanıcı adı/şifre değiştirdi";
$string["everyActions"] = "Tüm eylemler";
$string["everyMod"] = "Tüm moderatörler";
$string["Kish!"] = "Uzak dur!";
$string["noPermission"] = "İznin yok!";
$string["noLogin?"] = "Hesabına giriş yapmadın!";
$string["LoginBtn"] = "Hesaba giriş yap";
$string["dashboard"] = "Dashboard";
//errors
$string["errorNoAccWithPerm"] = "HATA: '%s' izni hiçbir hesapta bulunamadı.";