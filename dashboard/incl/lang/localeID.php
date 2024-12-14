<?php
global $dbPath;
require __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Beranda";
$string["welcome"] = "Selamat Datang di ".$gdps.'!';
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Selamat datang di Dasbor! Kami memberi Kamu beberapa petunjuk setelah instalasi:<br>
1. Tampaknya izin baru telah muncul di SQL di tabel 'roles'! Kamu harus memeriksanya...<br>
2. Jika Kamu meletakkan 'icon.png' pada folder 'dashboard', maka ikon GDPS Kamu akan muncul di kiri atas!<br>
3. Kamu harus mengkonfigurasi config/dashboard.php!";
$string["wwygdt"] = "Apa yang akan kamu lakukan hari ini?";
$string["game"] = "Permainan";
$string["guest"] = "tamu";
$string["account"] = "Akun";
$string["levelsOptDesc"] = "Lihat daftar level";
$string["songsOptDesc"] = "Lihat daftar lagu";
$string["yourClanOptDesc"] = "Lihat klan \"%s\"";
$string["clanOptDesc"] = "Lihat daftar klan";
$string["yourProfile"] = "Profil Kamu";
$string["profileOptDesc"] = "Lihat profil Kamu";
$string["messengerOptDesc"] ="Buka utusan";
$string["addSongOptDesc"] = "Tambahkan lagu ke server";
$string["loginOptDesc"] = "Masuk ke akun";
$string["createAcc"] = "Buat akun";
$string["registerOptDesc"] = "Daftar di %s";
$string["downloadOptDesc"] = "Unduh %s";

$string["tryCron"] = "Jalankan Cron";
$string["cronSuccess"] = "Sukses!";
$string["cronError"] = "Kesalahan!";

$string["profile"] = "Profil";
$string["empty"] = "Kosong...";
$string["writeSomething"] = "Tulis sesuatu!";  
$string["replies"] = "Balasan";
$string["replyToComment"] = "Membalas komentar";
$string["settings"] = "Pengaturan";
$string["allowMessagesFrom"] = "Izinkan pesan dari...";
$string["allowFriendReqsFrom"] = "Izinkan permintaan pertemanan dari...";
$string["showCommentHistory"] = "Tampilkan riwayat komentar...";
$string["timezoneChoose"] = "Pilih zona waktu";
$string["yourYouTube"] = "Saluran YouTube Kamu";
$string["yourVK"] = "Halaman Kamu di VK";
$string["yourTwitter"] = "Halaman Kamu di Twitter";
$string["yourTwitch"] = "Saluran Twitch Kamu";
$string["saveSettings"] = "Simpan pengaturan";
$string["all"] = "Semua";
$string["friends"] = "Teman-teman";
$string["none"] = "Tidak ada";
$string["youBlocked"] = "Pemain ini memblokir Kamu!";
$string["cantMessage"] = "Kamu tidak dapat mengirim pesan kepada pemain ini!";
  
$string["accountManagement"] = "Manajemen akun";
$string["changePassword"] = "Ubah kata sandi";
$string["changeUsername"] = "Ubah nama pengguna";
$string["unlistedLevels"] = "Level Kamu yang tidak terdaftar";

$string["manageSongs"] = "Kelola lagu";
$string["gauntletManage"] = "Kelola Gauntlets";
$string["suggestLevels"] = "Level yang disarankan";

$string["modTools"] = "Alat mod";
$string["leaderboardBan"] = "Larang pengguna";
$string["unlistedMod"] = "Level yang tidak terdaftar";

$string["reuploadSection"] = "Unggah ulang";
$string["songAdd"] = "Tambahkan lagu";
$string["songLink"] = "Tambahkan lagu melalui tautan";
$string["packManage"] = "Kelola Paket Peta";

$string["browse"] = "Jelajahi";
$string["statsSection"] = "Statistik";
$string["dailyTable"] = "Level Harian";
$string["modActionsList"] = "Tindakan mod";
$string["modActions"] = "Moderator server";
$string["gauntletTable"] = "Daftar Gauntlets";
$string["packTable"] = "Daftar Paket Peta";
$string["leaderboardTime"] = "Kemajuan papan peringkat";

$string["download"] = "Unduh";
$string["forwindows"] = "Untuk Windows";
$string["forandroid"] = "Untuk Android";
$string["formac"] = "Untuk Mac";
$string["forios"] = "Untuk iOS";
$string["third-party"] = "Pihak ketiga";
$string["thanks"] = "Terima kasih kepada orang-orang ini!";
$string["language"] = "Bahasa";

$string["loginHeader"] = "Selamat Datang, %s!";
$string["logout"] = "Keluar";
$string["login"] = "Masuk";
$string["wrongNickOrPass"] = "Nama pengguna atau kata sandi salah!";
$string["invalidid"] = "ID tidak valid!";
$string["loginBox"] = "Masuk ke akun";
$string["loginSuccess"] = "Kamu berhasil masuk ke akun Kamu!";
$string["loginAlready"] = "Kamu sudah masuk!";
$string["clickHere"] = "Dasbor";
$string["enterUsername"] = "Masukkan nama pengguna";
$string["enterPassword"] = "Masukkan kata sandi";
$string["loginDesc"] = "Disini Kamu dapat masuk ke akun Kamu!";

$string["register"] = "Daftar";
$string["registerAcc"] = "Pendaftaran akun";
$string["registerDesc"] = "Daftarkan akun Kamu!";
$string["repeatpassword"] = "Ulangi kata sandi";
$string["email"] = "Email";
$string["repeatemail"] = "Ulangi email";
$string["smallNick"] = "Nama pengguna terlalu kecil!";
$string["smallPass"] = "Kata sandi terlalu kecil!";
$string["passDontMatch"] = "Kata sandi tidak cocok!";
$string["emailDontMatch"] = "Email tidak cocok";
$string["registered"] = "Kamu berhasil mendaftarkan akun!";
$string["bigNick"] = "Nama pengguna terlalu panjang!";
$string["mailExists"] = "Ada akun yang terdaftar menggunakan email ini!";
$string["badUsername"] = "Silakan pilih nama pengguna lain.";

$string["changePassTitle"] = "Ubah kata sandi";
$string["changedPass"] = "Kata sandi berhasil diubah! Kamu harus masuk ke akun Kamu lagi.";
$string["wrongPass"] = "Kata sandi salah!";
$string["samePass"] = "Kata sandi yang Kamu masukkan sama!";
$string["changePassDesc"] = "Di sini Kamu dapat mengubah kata sandi Kamu!";
$string["oldPassword"] = "Sandi lama";
$string["newPassword"] = "Sandi baru";
$string["confirmNew"] = "Konfirmasi sandi";

$string["forcePassword"] = "Paksa ubah kata sandi";
$string["forcePasswordDesc"] = "Disini Kamu dapat memaksa mengubah kata sandi pemain!";
$string["forceNick"] = "Ganti paksa nama pengguna";
$string["forceNickDesc"] = "Disini Kamu dapat memaksa mengubah nama pengguna pemain!";
$string["forceChangedPass"] = "Kata sandi <b>%s</b>'s telah berhasil diubah!";
$string["forceChangedNick"] = "Nama pengguna <b>%s</b>'s telah berhasil diubah!";
$string["changePassOrNick"] = "Ubah nama pengguna atau kata sandi pemain";

$string["changeNickTitle"] = "Ubah nama pengguna";
$string["changedNick"] = "Nama pengguna berhasil diubah! Kamu harus masuk ke akun Kamu lagi.";
$string["wrongNick"] = "Nama pengguna salah!";
$string["sameNick"] = "Nama pengguna yang Kamu masukkan sama!";
$string["alreadyUsedNick"] = "Nama pengguna yang Kamu masukkan sudah dipakai!";
$string["changeNickDesc"] = "Disini Kamu dapat mengubah nama pengguna Kamu!";
$string["oldNick"] = "Nama pengguna lama";
$string["newNick"] = "Nama pengguna baru";
$string["password"] = "Kata sandi";

$string["packCreate"] = "Buat Paket Peta";
$string["packCreateTitle"] = "Buat Paket Peta";
$string["packCreateDesc"] = "Disini Kamu dapat membuat Paket Peta!";
$string["packCreateSuccess"] = "Kamu berhasil membuat Paket Peta bernama";
$string["packCreateOneMore"] = "Satu Paket Peta lagi?";
$string["packName"] = "Nama Paket Peta";
$string["color"] = "Warna";
$string["sameLevels"] = "Kamu memilih level yang sama!";
$string["show"] = "Menunjukkan";
$string["packChange"] = "Ubah Paket Peta";
$string["createNewPack"] = "Buat Paket Peta baru!"; // Terjemahkan kata "buat" seperti ajakan bertindaknya

$string["gauntletCreate"] = "Buat Gauntlet";
$string["gauntletCreateTitle"] = "Buat Gauntlet";
$string["gauntletCreateDesc"] = "Disini Kamu dapat membuat Gauntlet!";
$string["gauntletCreateSuccess"] = "Kamu berhasil membuat Gauntlet!";
$string["gauntletCreateOneMore"] = "Satu Gauntlet lagi?";
$string["chooseLevels"] = "Pilih level!";
$string["checkbox"] = "Mengonfirmasi";
$string["level1"] = "1st level";
$string["level2"] = "2nd level";
$string["level3"] = "3rd level";
$string["level4"] = "4th level";
$string["level5"] = "5th level";
$string["gauntletChange"] = "Ganti Gauntlet";
$string["createNewGauntlet"] = "Buat Gauntlet baru!"; // Terjemahkan kata "buat" seperti ajakan bertindaknya
$string["gauntletCreateSuccessNew"] = 'Kamu berhasil membuat <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Pilih Gauntlet secara otomatis";

$string["addQuest"] = "Tambahkan pencarian";
$string["addQuestDesc"] = "Di sini Kamu dapat membuat misi!";
$string["questName"] = "Nama pencarian";
$string["questAmount"] = "Jumlah yang dibutuhkan";
$string["questReward"] = "Hadiah";
$string["questCreate"] = "Buat pencarian";
$string["questsSuccess"] = "Kamu berhasil membuat misi";
$string["invalidPost"] = "Datanya tidak valid!";
$string["fewMoreQuests"] = "Disarankan untuk membuat beberapa misi lagi.";
$string["oneMoreQuest?"] = "Satu pencarian lagi?";
$string["changeQuest"] = "Ubah pencarian";
$string["createNewQuest"] = "Buat pencarian baru!"; // seperti gauntlets dan mappack di atas

$string["levelReupload"] = "Unggah ulang level";
$string["levelReuploadDesc"] = "Disini Kamu dapat mengunggah ulang level dari server mana pun!";
$string["advanced"] = "Opsi lanjutan";
$string["errorConnection"] = "Kesalahan koneksi!";
$string["levelNotFound"] = "Level ini tidak ada!";
$string["robtopLol"] = "RobTop tidak menyukaimu :c";
$string["sameServers"] = "Server host dan server target sama!";
$string["levelReuploaded"] = "Level diunggah ulang! ID Level:";
$string["oneMoreLevel?"] = "Satu level lagi?";
$string["levelAlreadyReuploaded"] = "Level sudah diunggah ulang!";
$string["server"] = "Server";
$string["levelID"] = "ID Level";
$string["pageDisabled"] = "Halaman ini dinonaktifkan!";
$string["levelUploadBanned"] = "Kamu dilarang mengunggah level!";

$string["activateAccount"] = "Aktivasi akun";
$string["activateDesc"] = "Aktifkan akun Kamu!";
$string["activated"] = "Akun Kamu telah berhasil diaktifkan!";
$string["alreadyActivated"] = "Akun Kamu sudah diaktifkan";
$string["maybeActivate"] = "Mungkin Kamu belum mengaktifkan akun Kamu.";
$string["activate"] = "Mengaktifkan";
$string["activateDisabled"] = "Aktivasi akun dinonaktifkan!";

$string["addMod"] = "Tambahkan moderator";
$string["addModDesc"] = "Disini Kamu dapat mempromosikan seseorang menjadi Moderator!";
$string["modYourself"] = "Kamu tidak dapat memberi diri Kamu Moderator!";
$string["alreadyMod"] = "Pemain ini sudah menjadi Moderator!";
$string["addedMod"] = "Kamu berhasil memberikan Moderator kepada seorang pemain";
$string["addModOneMore"] = "Satu lagi moderator?";
$string["modAboveYourRole"] = "Kamu mencoba memberikan peran di atas peran Kamu!";
$string["makeNewMod"] = "Jadikan seseorang sebagai moderator!";
$string["reassignMod"] = "Tetapkan kembali moderator";
$string["reassign"] = "Menugaskan kembali";
$string['demotePlayer'] = "Turunkan pemain";
$string['demotedPlayer'] = "Kamu berhasil diturunkan jabatannya <b>%s</b>!";
$string['addedModNew'] = "Kamu telah berhasil mempromosikan <b>%s</b> menjadi Moderator!";
$string['demoted'] = 'Diturunkan';

$string["shareCPTitle"] = "Bagikan Poin Pembuat Konten";
$string["shareCPDesc"] = "Disini Kamu dapat berbagi Poin Kreator dengan pemain!";
$string["shareCP"] = "Membagikan";
$string["alreadyShared"] = "Level ini sudah membagikan CP kepada pemain ini!";
$string["shareToAuthor"] = "Kamu mencoba membagikan CP ke penulis level!";
$string["userIsBanned"] = "Pemain ini dilarang!";
$string["shareCPOneMore"] = "Satu bagian lagi?";
$string['shareCPSuccessNew'] = 'Kamu berhasil membagikan level Poin Kreator <b>%1$s</b> untuk pemain <b>%2$s</b>!';

$string["messenger"] = "kurir";
$string["write"] = "Menulis";
$string["send"] = "Mengirim";
$string["noMsgs"] = "Mulai dialog!";
$string["subject"] = "Subjek";
$string["msg"] = "Pesan";
$string["tooFast"] = "Kamu mengetik terlalu cepat!";
$string["messengerYou"] = "Kamu:";
$string["chooseChat"] = "Pilih obrolan";

$string["levelToGD"] = "Unggah ulang level ke server target";
$string["levelToGDDesc"] = "Di sini Kamu dapat mengunggah ulang level Kamu ke server target!";
$string["usernameTarget"] = "Nama pengguna untuk server target";
$string["passwordTarget"] = "Kata sandi untuk server target";
$string["notYourLevel"] = "Ini bukan levelmu!";
$string["reuploadFailed"] = "Kesalahan pengunggahan ulang level!";

$string["search"] = "Mencari...";
$string["searchCancel"] = "Batalkan pencarian";
$string["emptySearch"] = "Tidak ada yang ditemukan!";

$string["approve"] = 'Menyetujui';
$string["deny"] = 'Membantah';
$string["submit"] = 'Kirim';
$string["place"] = 'Tempat';
$string["add"] = 'Menambahkan';
$string["demonlistLevel"] = '%s <text class="dltext">oleh <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';

$string["didntActivatedEmail"] = 'Kamu tidak mengaktifkan akun Kamu melalui email!';
$string["checkMail"] = 'Kamu harus memeriksa email Kamu...';

$string["likeSong"] = "Tambahkan lagu ke favorit";
$string["dislikeSong"] = "Hapus lagu dari favorit";
$string["favouriteSongs"] = "Lagu favorit";
$string["howMuchLiked"] = "Berapa banyak yang menyukainya?";
$string["nooneLiked"] = "Tidak ada yang menyukai";

$string["clan"] = "Klan";
$string["joinedAt"] = "Bergabung dengan klan di: <b>%s</b>";
$string["createdAt"] = "Klan dibuat di: <b>%s</b>";
$string["clanMembers"] = "Anggota klan";
$string["noMembers"] = "Tidak ada anggota";
$string["clanOwner"] = "Pemilik klan";
$string["noClanDesc"] = "<i>Tidak ada deskripsi</i>";
$string["noClan"] = "Klan ini tidak ada!";
$string["clanName"] = "Nama klan";
$string["clanTag"] = "Tag klan (3-5 karakter)";
$string["clanDesc"] = "Deskripsi klan";
$string["clanColor"] = "Warna klan";
$string["dangerZone"] = "Zona bahaya";
$string["giveClan"] = "Berikan klan";
$string["deleteClan"] = "Hapus klan";
$string["goBack"] = "Kembali";
$string["areYouSure"] = "Apa kamu yakin?";
$string["giveClanDesc"] = "Disini Kamu dapat memberikan klan Kamu kepada pemain.";
$string["notInYourClan"] = "Pemain ini tidak ada dalam klan Kamu!";
$string["givedClan"] = "Kamu berhasil memberikan klan Kamu kepada <b>%s</b>!";
$string["deletedClan"] = "Kamu menghapus klan <b>%s</b>.";
$string["deleteClanDesc"] = "Disini Kamu dapat menghapus klan Kamu.";
$string["yourClan"] = "Klan Kamu";
$string["members0"] = "<b>1</b> anggota";
$string["members1"] = "<b>%d</b> anggota"; 
$string["members2"] = "<b>%d</b> anggota"; 
$string["noRequests"] = "Tidak ada permintaan. Santai!";
$string["pendingRequests"] = "Permintaan klan";
$string["closedClan"] = "Klan tertutup";
$string["kickMember"] = "Tendang Anggota";
$string["leaveFromClan"] = "Tinggalkan klan";
$string["askToJoin"] = "Kirim permintaan bergabung";
$string["removeClanRequest"] = "Hapus permintaan bergabung";
$string["joinClan"] = "Bergabunglah dengan klan";
$string["noClans"] = "Tidak ada klan";
$string["clans"] = "Klan";
$string["alreadyInClan"] = "Kamu sudah menjadi anggota klan!";
$string["createClan"] = "Buat klan";
$string["createdClan"] = "Kamu berhasil membuat klan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Disini Kamu dapat membuat klan!";
$string["create"] = "Membuat";
$string["mainSettings"] = "Pengaturan utama";
$string["takenClanName"] = "Nama klan ini sudah dipakai!";
$string["takenClanTag"] = "Tag klan ini sudah dipakai!";
$string["badClanName"] = "Silakan pilih nama klan lain.";
$string["badClanTag"] = "Silakan pilih tag klan lain.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> disarankan <b>%4$s%3$s</b> for</text><text class="levelname">%2$s</text>'; // %1$s - Mod username, %2$s - level name, %3$s - x stars, %4$s - Featured/Epic (%4$s%3$s - Featured, x stars)
$string["reportedName"] = '%1$s<text class="dltext"> telah dilaporkan</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Daftar";
$string['listTableMod'] = "Daftar tidak terdaftar";
$string['listTableYour'] = "Daftar Kamu yang tidak terdaftar";

$string['forgotPasswordChangeTitle'] = "Ubah kata sandi";
$string["successfullyChangedPass"] = "Kata sandi berhasil diubah!";
$string['forgotPasswordTitle'] = "Lupa kata sandi?";
$string['maybeSentAMessage'] = "Kami akan mengirimkan pesan kepada Kamu jika akun ini ada.";
$string['forgotPasswordDesc'] = "Di sini Kamu dapat meminta tautan ubah kata sandi jika Kamu lupa!";
$string['forgotPasswordButton'] = "Minta tautan";

$string['sfxAdd'] = "Tambahkan SFX";
$string["sfxAddError-5"] = "Ukuran SFX lebih tinggi dari $sfxSize megabita!";
$string["sfxAddError-6"] = "Ada yang tidak beres saat mengunggah SFX!";
$string["sfxAddError-7"] = "Kamu hanya dapat mengunggah audio!";
$string['sfxAdded'] = 'SFX ditambahkan';
$string['yourNewSFX'] = "Lihatlah SFX baru Kamu!";
$string["sfxAddAnotherBTN"] = "Satu SFX lagi?";
$string["sfxAddDesc"] = "Disini Kamu dapat menambahkan SFX Kamu!";
$string["chooseSFX"] = "Pilih SFX";
$string["sfxAddNameFieldPlaceholder"] = "Nama";
$string['sfxs'] = 'SFXs';
$string['sfxID'] = 'ID SFX';
$string['manageSFX'] = 'Kelola SFX';

$string['featureLevel'] = 'Tingkat fitur';

$string['banList'] = 'Daftar orang yang dilarang';
$string['expires'] = 'Kedaluwarsa';
$string['unbanPerson'] = 'Batalkan pelarangan';
$string['IP'] = 'alamat IP';
$string['noBanInPast'] = 'Kamu tidak dapat melarang sampai lewat!';
$string['banSuccess'] = 'Kamu berhasil memblokir <b>%1$s</b> hingga <b>%3$s</b> di «<b>%2$s</b>»!';
$string['person'] = 'Orang';
$string['youAreBanned'] = 'Kamu diblokir hingga <b>%2$s</b> karena alasan:<br><b>%1$s</b>';
$string['banChange'] = 'Mengubah';
$string['system'] = 'Sistem';

$string['levelComments'] = 'Komentar tingkat';
$string['levelLeaderboards'] = 'Papan peringkat tingkat';
$string['manageLevel'] = 'Kelola level';
$string['noComments'] = 'Tidak ada komentar!';
$string['commentHere'] = 'Publikasikan komentar...';
$string['weekLeaderboards'] = 'Selama seminggu';
$string['noLeaderboards'] = 'Tidak ada papan peringkat!';
$string['manageLevelDesc'] = 'Di sini Kamu dapat mengubah level!';
$string['silverCoins'] = 'Koin perak';
$string['unlistedLevel'] = 'Tingkat tidak terdaftar';
$string['lockUpdates'] = 'Kunci pembaruan';
$string['lockCommenting'] = 'Kunci komentar';
$string['successfullyChangedLevel'] = 'Kamu berhasil mengubah level!';
$string['successfullyDeletedLevel'] = 'Kamu berhasil menghapus level!';

$string['resendMailTitle'] = 'Kirim pesan email lagi';
$string['resendMailHint'] = 'Tidak mendapatkan pesan email?';
$string['resendMailDesc'] = 'Disini kamu bisa mengirim pesan email lagi kalau kamu tidak mendapatkannya!';
$string['resendMailButton'] = 'Kirim pesan';

$string['automodTitle'] = 'Automod';
$string['possibleLevelsSpamming'] = 'Kemungkinan spamming level';
$string['disableLevelsUploading'] = 'Nonaktifkan mengunggah level';
$string['possibleAccountsSpamming'] = 'Kemungkinan spamming akun';
$string['disableAccountsRegistering'] = 'Nonaktifkan mendaftar akun';
$string['possibleCommentsSpamming'] = 'Kemungkinan spamming komentar';
$string['disableComments'] = 'Nonaktifkan komentar';
$string['similarCommentsCount'] = 'Komentar serupa dihitung';
$string['similarityValueOfAllComments'] = 'Nilai kesamaan dari semua komentar';
$string['possibleCommentsSpammer'] = 'Kemungkinan spammer komentar';
$string['banCommenting'] = 'Larang berkomentar';
$string['spammerUsername'] = 'Nama pengguna spammer';
$string['possibleAccountPostsSpamming'] = 'Kemungkinan postingan akun spam';
$string['disablePosting'] = 'Nonaktifkan posting';
$string['similarPostsCount'] = 'Postingan serupa dihitung';
$string['similarityValueOfAllPosts'] = 'Nilai kesamaan dari semua postingan';
$string['possibleAccountPostsSpammer'] = 'Kemungkinan spammer postingan akun';
$string['possibleRepliesSpamming'] = 'Kemungkinan balasan spam';
$string['possibleRepliesSpammer'] = 'Kemungkinan balasan spammer';
$string['similarRepliesCount'] = 'Balasan serupa dihitung';
$string['similarityValueOfAllReplies'] = 'Nilai kesamaan dari semua balasan';
$string['unknownWarning'] = 'Peringatan tidak dikenal';
$string['before'] = 'Sebelum';
$string['after'] = 'Setelah';
$string['compare'] = 'Membandingkan';
$string['resolvedWarning'] = 'Peringatan terselesaikan';
$string['resolveWarning'] = 'Selesaikan peringatan';
$string['enabled'] = 'Diaktifkan';
$string['disabled'] = 'Dinonaktifkan';
$string['yesterday'] = 'Kemarin';
$string['today'] = 'Hari ini';
$string['uploading'] = 'Mengunggah';
$string['commenting'] = 'Berkomentar';
$string['leaderboardSubmits'] = 'Kiriman leaderboard';
$string['manageLevels'] = 'Kelola level';
$string['disableLevelsUploading'] = 'Nonaktifkan pengunggahan level';
$string['disableLevelsCommenting'] = 'Nonaktifkan komentar level';
$string['disableLevelsLeaderboardSubmits'] = 'Nonaktifkan kiriman leaderboard level';
$string['disable'] = 'Nonaktifkan';
$string['enable'] = 'Aktifkan';
$string['registering'] = 'Mendaftar';
$string['accountPosting'] = 'membuat postingan akun';
$string['updatingProfileStats'] = 'Memperbarui statistik profil';
$string['messaging'] = 'Pesan';
$string['manageAccounts'] = 'Mengelola akun';
$string['disableAccountsRegistering'] = 'Nonaktifkan mendaftarkan akun baru';
$string['disableAccountPosting'] = 'Nonaktifkan membuat postingan akun';
$string['disableUpdatingProfileStats'] = 'Nonaktifkan pembaruan statistik profil';
$string['disableMessaging'] = 'Nonaktifkan pesan';

$string['cantPostCommentsAboveChars'] = 'Kamu tidak bisa posting komentar diatas %1$s huruf!';
$string['replyingIsDisabled'] = 'Membalas komentar sedang dinonaktifkan!';
$string['youAreBannedFromCommenting'] = 'Kamu dilarang berkomentar!';
$string['cantPostAccountCommentsAboveChars'] = 'Kamu tidak bisa memposting komentar akun di atas %1$s huruf!';
$string['commentingIsDisabled'] = 'Berkomentar sedang dinonaktifkan!';
$string['noWarnings'] = 'Tidak ada peringatan';
$string['messagingIsDisabled'] = 'Direct messages are currently disabled!';

$string['downloadLevelAsGMD'] = 'Simpan sebagai .gmd';

$string['songIsAvailable'] = 'Tersedia';
$string['songIsDisabled'] = 'Tidak tersedia';
$string['disabledSongs'] = 'Lagu-lagu yang dinonaktifkan';
$string['disabledSFXs'] = 'SFX yang dinonaktifkan';

$string['vaultCodesTitle'] = 'Tambah kode vault';
$string['vaultCodeExists'] = 'Kode dengan nama ini sudah ada!';
$string['reward'] = 'Hadiah';
$string['vaultCodePickOption'] = 'Pilih tipe hadiah';
$string['vaultCodesCreate'] = 'Buat kode';
$string['createNewVaultCode'] = 'Buat kode baru!';
$string['vaultCodesDesc'] = 'Disini kamu bisa membuat kode baru!';
$string['vaultCodesEditTitle'] = 'Ganti kode vault';
$string['vaultCodesEditDesc'] = 'Disini kamu bisa ganti kode yang sudah ada!';
$string['vaultCodeName'] = 'Kode';
$string['vaultCodeUses'] = 'Jumlah penggunaan (0 untuk penggunaan tidak terbatas)';
$string['editRewards'] = 'Ganti hadiah';
$string['rewards'] = 'Hadiah';

$string['alsoBanIP'] = 'Larang juga IP';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Mengunggah";
$string["errorGeneric"] = "Kesalahan muncul!";
$string["smthWentWrong"] = "Ada yang tidak beres!";
$string["tryAgainBTN"] = "Coba lagi";
//songAdd.php
$string["songAddDesc"] = "Disini Kamu dapat menambahkan lagu Kamu!";
$string["songAddUrlFieldLabel"] = "URL Lagu: (hanya tautan Direct atau Dropbox)";
$string["songAddUrlFieldPlaceholder"] = "URL Lagu";
$string["songAddNameFieldPlaceholder"] = "Nama";
$string["songAddAuthorFieldPlaceholder"] = "Pencipta";
$string["songAddButton"] = "Pilih lagu";
$string["songAddAnotherBTN"] = "Lagu lain?";
$string["songAdded"] = "Lagu ditambahkan";
$string["deletedSong"] = "Kamu berhasil menghapus lagu";
$string["songID"] = "ID Lagu: ";
$string["songIDw"] = "ID Lagu";
$string["songAuthor"] = "Pengarang";
$string["size"] = "Ukuran";
$string["delete"] = "Menghapus";
$string["change"] = "Mengubah";
$string["chooseFile"] = "Pilih sebuah lagu";
$string['yourNewSong'] = "Lihatlah lagu barumu!";
///errors
$string["songAddError-2"] = "URL tidak valid";
$string["songAddError-3"] = "Lagu ini sudah diupload ulang dengan ID:";
$string["songAddError-4"] = "Lagu ini tidak dapat diunggah ulang";
$string["songAddError-5"] = "Ukuran lagu lebih tinggi dari $songSize megabytes";
$string["songAddError-6"] = "Ada yang tidak beres saat mengupload lagu!";
$string["songAddError-7"] = "Kamu hanya dapat mengunggah audio!";

$string[400] = "Permintaan buruk!";
$string["400!"] = "Periksa driver perangkat keras jaringan Kamu.";
$string[403] = "Terlarang!";
$string["403!"] = "Kamu tidak memiliki akses ke halaman ini!";
$string[404] = "Halaman tidak ditemukan!";
$string["404!"] = "Apakah Kamu yakin Kamu mengetik alamat dengan benar?";
$string[500] = "Kesalahan server internal!";
$string["500!"] = "Pembuat kode membuat kesalahan dalam kode,</br>
tolong katakan tentang masalah ini di sini:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Server sedang down!";
$string["502!"] = "Beban di server terlalu besar.</br>
Kembali lagi nanti dalam beberapa jam!";

$string["invalidCaptcha"] = "Respons captcha tidak valid!";
$string["page"] = "Halaman";
$string["emptyPage"] = "Halaman ini kosong!";

/*
	STATS
*/
$string["ID"] = "ID";
$string["orbs"] = "bola";
$string["stars"] = "Bintang";
$string["coins"] = "Koin";
$string["accounts"] = "Akun";
$string["levels"] = "Tingkat";
$string["songs"] = "Lagu";
$string["author"] = "Pencipta";
$string["name"] = "Nama";
$string["date"] = "Tanggal";
$string["type"] = "Jenis";
$string["reportCount"] = "Jumlah laporan";
$string["reportMod"] = "Laporan";
$string["username"] = "Nama belakang";
$string["accountID"] = "ID Akun";
$string["registerDate"] = "Tanggal Pendaftaran";
$string["levelAuthor"] = "Penulis tingkat";
$string["isAdmin"] = "Peran di server";
$string["isAdminYes"] = "Ya";
$string["isAdminNo"] = "Tidak";
$string["userCoins"] = "Koin Pengguna";
$string["time"] = "Waktu";
$string["deletedLevel"] = "Tingkat yang Dihapus";
$string["mod"] = "Moderator";
$string["count"] = "Jumlah tindakan";
$string["ratedLevels"] = "Tingkat yang Dinilai";
$string["lastSeen"] = "Terakhir Kali Daring";
$string["level"] = "Level";
$string["pageInfo"] = "Menampilkan halaman %s dari %s";
$string["first"] = "Pertama";
$string["previous"] = "Sebelumnya";
$string["next"] = "Berikutnya";
$string["never"] = "Tidak pernah";
$string["last"] = "Terakhir";
$string["go"] = "Pergi";
$string["levelid"] = "ID Tingkat";
$string["levelname"] = "Nama tingkat";
$string["leveldesc"] = "Deskripsi tingkat";
$string["noDesc"] = "Tidak ada deskripsi";
$string["levelpass"] = "Kata sandi";
$string["nopass"] = "Tidak ada kata sandi";
$string["unrated"] = "Belum diberi peringkat";
$string["rate"] = "Kecepatan";
$string["stats"] = "Statistik";
$string["suggestFeatured"] = "Unggulan?";
$string["whoAdded"] = "Siapa yang menambahkan?";
$string["moons"] = "Bulan";

$string["banDesc"] = "Disini Kamu dapat melarang pemain!";
$string["playerTop"] = 'Pemain terbaik';
$string["creatorTop"] = 'Pembuat konten teratas';
$string["levelUploading"] = 'Mengunggah level';
$string["successfullyBanned"] = 'Pemain <b>%1$s</b> dengan ID akun <b>%2$s</b> berhasil diblokir!';
$string["successfullyUnbanned"] = 'Pemain <b>%1$s</b> dengan ID akun <b>%2$s</b> berhasil dibatalkan pemblokirannya!';
$string["commentBan"] = 'Mengomentari';

$string["player"] = "Pemain";

$string["starsLevel2"] = "bintang";
$string["starsLevel1"] = "bintang";
$string["starsLevel0"] = "bintang";
$string["coins1"] = "koin";
$string["coins0"] = "koin";
$string["unban"] = "Batalkan pelarangan";
$string["isBan"] = "Melarang";

$string["noCoins"] = "Tanpa koin";
$string["noReason"] = "Tidak ada alasan";
$string["noActions"] = "Tidak ada tindakan";
$string["noRates"] = "Tidak ada tarif";

$string["future"] = "Masa depan";

$string["spoiler"] = "Bocoran";
$string["accid"] = "dengan ID akun";
$string["banned"] = "berhasil dilarang!";
$string["unbanned"] = "berhasil dibatalkan pemblokirannya!";
$string["ban"] = "Melarang";
$string["nothingFound"] = "Pemain ini tidak ada!";
$string["banUserID"] = "Nama pengguna atau ID akun";
$string["banUserPlace"] = "Larang pengguna";
$string["banYourself"] = "Kamu tidak bisa melarang diri Kamu sendiri!"; 
$string["banYourSelfBtn!"] = "Larang orang lain";
$string["banReason"] = "Alasan larangan";
$string["action"] = "Tindakan";
$string["value"] = "nilai pertama";
$string["value2"] = "nilai ke-2";
$string["value3"] = "nilai ke-3";
$string["modAction1"] = "nilai tingkat";
$string["modAction2"] = "Membatalkan/menampilkan level";
$string["modAction3"] = "Koin yang tidak/terverifikasi";
$string["modAction4"] = "Membatalkan/mengeluarkan level";
$string["modAction5"] = "Tetapkan sebagai fitur harian";
$string["modAction6"] = "Menghapus satu level";
$string["modAction7"] = "Perubahan pencipta";
$string["modAction8"] = "Mengganti nama level";
$string["modAction9"] = "Kata sandi tingkat diubah";
$string["modAction10"] = "Mengubah kesulitan demon";
$string["modAction11"] = "CP Bersama";
$string["modAction12"] = "Tingkat tidak/dipublikasikan";
$string["modAction13"] = "Deskripsi level diubah";
$string["modAction14"] = "LDM diaktifkan/dinonaktifkan";
$string["modAction15"] = "Papan peringkat tidak/dilarang";
$string["modAction16"] = "Perubahan ID Lagu";
$string["modAction17"] = "Membuat Paket Peta";
$string["modAction18"] = "Menciptakan Tantangan";
$string["modAction19"] = "Lagu yang diubah";
$string["modAction20"] = "Diberikan moderator kepada pemain";
$string["modAction21"] = "Paket Peta Berubah";
$string["modAction22"] = "Tantangan yang Berubah";
$string["modAction23"] = "Pencarian yang diubah";
$string["modAction24"] = "Menugaskan kembali seorang pemain";
$string["modAction25"] = "Membuat misi";
$string["modAction26"] = "Mengubah nama pengguna/kata sandi pemain";
$string["modAction27"] = "Mengubah SFX";
$string["modAction28"] = "Orang yang dilarang";
$string["modAction29"] = "Pembaruan level terkunci/tidak terkunci";
$string["modAction30"] = "Daftar yang diberi peringkat";
$string["modAction31"] = "Daftar terkirim";
$string["modAction32"] = "Daftar tidak/diunggulkan";
$string["modAction33"] = "Daftar yang tidak/diterbitkan";
$string["modAction34"] = "Daftar yang dihapus";
$string["modAction35"] = "Mengubah pembuat daftar";
$string["modAction36"] = "Mengubah nama daftar";
$string["modAction37"] = "Deskripsi daftar diubah";
$string["modAction38"] = "Komentar level terkunci/tidak terkunci";
$string["modAction39"] = "Komentar daftar terkunci/tidak terkunci";
$string["modAction40"] = "Menghapus level terkirim";
$string["modAction41"] = "Tingkat yang disarankan";
$string["modAction42"] = "Kode vault dibuat";
$string["modAction43"] = "Kode vault diubah";
$string["modAction44"] = "Atur tingkat sebagai tingkat event";
$string["everyActions"] = "Tindakan apa pun";
$string["everyMod"] = "Semua moderator";
$string["Kish!"] = "Pergilah!";
$string["noPermission"] = "Kamu tidak memiliki izin!";
$string["noLogin?"] = "Kamu belum masuk ke akun Kamu!";
$string["LoginBtn"] = "Masuk ke akun";
$string["dashboard"] = "Dasbor";
$string["userID"] = 'ID Pengguna';
