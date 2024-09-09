<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Beranda";
$string["welcome"] = "Selamat Datang di ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Peringatan!</b> Anda belum memasang dasbor sepenuhnya! Klik pada teks untuk melakukan ini.</div>";
$string["levelsWeek"] = "Level diunggah dalam seminggu";
$string["levels3Months"] = "Level diunggah dalam 3 bulan";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Selamat datang di Dasbor! Kami memberi Anda beberapa petunjuk setelah instalasi:<br>
1. Tampaknya izin baru telah muncul di SQL di tabel 'roles'! Anda harus memeriksanya...<br>
2. Jika Anda meletakkan 'icon.png' pada folder 'dashboard', maka ikon GDPS Anda akan muncul di kiri atas!<br>
3. Anda harus mengkonfigurasi config/dashboard.php!";
$string["wwygdt"] = "Apa yang akan kamu lakukan hari ini?";
$string["game"] = "Permainan";
$string["guest"] = "tamu";
$string["account"] = "Akun";
$string["levelsOptDesc"] = "Lihat daftar level";
$string["songsOptDesc"] = "Lihat daftar lagu";
$string["yourClanOptDesc"] = "Lihat klan \"%s\"";
$string["clanOptDesc"] = "Lihat daftar klan";
$string["yourProfile"] = "Profil Anda";
$string["profileOptDesc"] = "Lihat profil Anda";
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
$string["yourYouTube"] = "Saluran YouTube Anda";
$string["yourVK"] = "Halaman Anda di VK";
$string["yourTwitter"] = "Halaman Anda di Twitter";
$string["yourTwitch"] = "Saluran Twitch Anda";
$string["saveSettings"] = "Simpan pengaturan";
$string["all"] = "Semua";
$string["friends"] = "Teman-teman";
$string["none"] = "Tidak ada";
$string["youBlocked"] = "Pemain ini memblokir Anda!";
$string["cantMessage"] = "Anda tidak dapat mengirim pesan kepada pemain ini!";
  
$string["accountManagement"] = "Manajemen akun";
$string["changePassword"] = "Ubah kata sandi";
$string["changeUsername"] = "Ubah nama pengguna";
$string["unlistedLevels"] = "Level Anda yang tidak terdaftar";

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
$string["loginSuccess"] = "Anda berhasil masuk ke akun Anda!";
$string["loginAlready"] = "Anda sudah masuk!";
$string["clickHere"] = "Dasbor";
$string["enterUsername"] = "Masukkan nama pengguna";
$string["enterPassword"] = "Masukkan kata sandi";
$string["loginDesc"] = "Disini Anda dapat masuk ke akun Anda!";

$string["register"] = "Daftar";
$string["registerAcc"] = "Pendaftaran akun";
$string["registerDesc"] = "Daftarkan akun Anda!";
$string["repeatpassword"] = "Ulangi kata sandi";
$string["email"] = "Email";
$string["repeatemail"] = "Ulangi email";
$string["smallNick"] = "Nama pengguna terlalu kecil!";
$string["smallPass"] = "Kata sandi terlalu kecil!";
$string["passDontMatch"] = "Kata sandi tidak cocok!";
$string["emailDontMatch"] = "Email tidak cocok";
$string["registered"] = "Anda berhasil mendaftarkan akun!";
$string["bigNick"] = "Nama pengguna terlalu panjang!";
$string["mailExists"] = "Ada akun yang terdaftar menggunakan email ini!";
$string["badUsername"] = "Silakan pilih nama pengguna lain.";

$string["changePassTitle"] = "Ubah kata sandi";
$string["changedPass"] = "Kata sandi berhasil diubah! Anda harus masuk ke akun Anda lagi.";
$string["wrongPass"] = "Kata sandi salah!";
$string["samePass"] = "Kata sandi yang Anda masukkan sama!";
$string["changePassDesc"] = "Di sini Anda dapat mengubah kata sandi Anda!";
$string["oldPassword"] = "Sandi lama";
$string["newPassword"] = "Sandi baru";
$string["confirmNew"] = "Konfirmasi sandi";

$string["forcePassword"] = "Paksa ubah kata sandi";
$string["forcePasswordDesc"] = "Disini Anda dapat memaksa mengubah kata sandi pemain!";
$string["forceNick"] = "Ganti paksa nama pengguna";
$string["forceNickDesc"] = "Disini Anda dapat memaksa mengubah nama pengguna pemain!";
$string["forceChangedPass"] = "Kata sandi <b>%s</b>'s telah berhasil diubah!";
$string["forceChangedNick"] = "Nama pengguna <b>%s</b>'s telah berhasil diubah!";
$string["changePassOrNick"] = "Ubah nama pengguna atau kata sandi pemain";

$string["changeNickTitle"] = "Ubah nama pengguna";
$string["changedNick"] = "Nama pengguna berhasil diubah! Anda harus masuk ke akun Anda lagi.";
$string["wrongNick"] = "Nama pengguna salah!";
$string["sameNick"] = "Nama pengguna yang Anda masukkan sama!";
$string["alreadyUsedNick"] = "Nama pengguna yang Anda masukkan sudah dipakai!";
$string["changeNickDesc"] = "Disini Anda dapat mengubah nama pengguna Anda!";
$string["oldNick"] = "Nama pengguna lama";
$string["newNick"] = "Nama pengguna baru";
$string["password"] = "Kata sandi";

$string["packCreate"] = "Buat Paket Peta";
$string["packCreateTitle"] = "Buat Paket Peta";
$string["packCreateDesc"] = "Disini Anda dapat membuat Paket Peta!";
$string["packCreateSuccess"] = "Anda berhasil membuat Paket Peta bernama";
$string["packCreateOneMore"] = "Satu Paket Peta lagi?";
$string["packName"] = "Nama Paket Peta";
$string["color"] = "Warna";
$string["sameLevels"] = "Anda memilih level yang sama!";
$string["show"] = "Menunjukkan";
$string["packChange"] = "Ubah Paket Peta";
$string["createNewPack"] = "Buat Paket Peta baru!"; // Terjemahkan kata "buat" seperti ajakan bertindaknya

$string["gauntletCreate"] = "Buat Gauntlet";
$string["gauntletCreateTitle"] = "Buat Gauntlet";
$string["gauntletCreateDesc"] = "Disini Anda dapat membuat Gauntlet!";
$string["gauntletCreateSuccess"] = "Anda berhasil membuat Gauntlet!";
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
$string["gauntletCreateSuccessNew"] = 'Anda berhasil membuat <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Pilih Gauntlet secara otomatis";

$string["addQuest"] = "Tambahkan pencarian";
$string["addQuestDesc"] = "Di sini Anda dapat membuat misi!";
$string["questName"] = "Nama pencarian";
$string["questAmount"] = "Jumlah yang dibutuhkan";
$string["questReward"] = "Hadiah";
$string["questCreate"] = "Buat pencarian";
$string["questsSuccess"] = "Anda berhasil membuat misi";
$string["invalidPost"] = "Datanya tidak valid!";
$string["fewMoreQuests"] = "Disarankan untuk membuat beberapa misi lagi.";
$string["oneMoreQuest?"] = "Satu pencarian lagi?";
$string["changeQuest"] = "Ubah pencarian";
$string["createNewQuest"] = "Buat pencarian baru!"; // seperti gauntlets dan mappack di atas

$string["levelReupload"] = "Unggah ulang level";
$string["levelReuploadDesc"] = "Disini Anda dapat mengunggah ulang level dari server mana pun!";
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
$string["levelUploadBanned"] = "Anda dilarang mengunggah level!";

$string["activateAccount"] = "Aktivasi akun";
$string["activateDesc"] = "Aktifkan akun Anda!";
$string["activated"] = "Akun Anda telah berhasil diaktifkan!";
$string["alreadyActivated"] = "Akun Anda sudah diaktifkan";
$string["maybeActivate"] = "Mungkin Anda belum mengaktifkan akun Anda.";
$string["activate"] = "Mengaktifkan";
$string["activateDisabled"] = "Aktivasi akun dinonaktifkan!";

$string["addMod"] = "Tambahkan moderator";
$string["addModDesc"] = "Disini Anda dapat mempromosikan seseorang menjadi Moderator!";
$string["modYourself"] = "Anda tidak dapat memberi diri Anda Moderator!";
$string["alreadyMod"] = "Pemain ini sudah menjadi Moderator!";
$string["addedMod"] = "Anda berhasil memberikan Moderator kepada seorang pemain";
$string["addModOneMore"] = "Satu lagi moderator?";
$string["modAboveYourRole"] = "Anda mencoba memberikan peran di atas peran Anda!";
$string["makeNewMod"] = "Jadikan seseorang sebagai moderator!";
$string["reassignMod"] = "Tetapkan kembali moderator";
$string["reassign"] = "Menugaskan kembali";
$string['demotePlayer'] = "Turunkan pemain";
$string['demotedPlayer'] = "Anda berhasil diturunkan jabatannya <b>%s</b>!";
$string['addedModNew'] = "Anda telah berhasil mempromosikan <b>%s</b> menjadi Moderator!";
$string['demoted'] = 'Diturunkan';

$string["shareCPTitle"] = "Bagikan Poin Pembuat Konten";
$string["shareCPDesc"] = "Disini Anda dapat berbagi Poin Kreator dengan pemain!";
$string["shareCP"] = "Membagikan";
$string["alreadyShared"] = "Level ini sudah membagikan CP kepada pemain ini!";
$string["shareToAuthor"] = "Anda mencoba membagikan CP ke penulis level!";
$string["userIsBanned"] = "Pemain ini dilarang!";
$string["shareCPSuccess"] = "Anda berhasil membagikan level Poin Kreator";
$string["shareCPSuccess2"] = "untuk pemain";
$string["updateCron"] = "Mungkin Anda harus memperbarui Poin Pembuat Konten.";
$string["shareCPOneMore"] = "Satu bagian lagi?";
$string['shareCPSuccessNew'] = 'Anda berhasil membagikan level Poin Kreator <b>%1$s</b> untuk pemain <b>%2$s</b>!';

$string["messenger"] = "kurir";
$string["write"] = "Menulis";
$string["send"] = "Mengirim";
$string["noMsgs"] = "Mulai dialog!";
$string["subject"] = "Subjek";
$string["msg"] = "Pesan";
$string["tooFast"] = "Anda mengetik terlalu cepat!";
$string["messengerYou"] = "Anda:";
$string["chooseChat"] = "Pilih obrolan";

$string["levelToGD"] = "Unggah ulang level ke server target";
$string["levelToGDDesc"] = "Di sini Anda dapat mengunggah ulang level Anda ke server target!";
$string["usernameTarget"] = "Nama pengguna untuk server target";
$string["passwordTarget"] = "Kata sandi untuk server target";
$string["notYourLevel"] = "Ini bukan levelmu!";
$string["reuploadFailed"] = "Kesalahan pengunggahan ulang level!";

$string["search"] = "Mencari...";
$string["searchCancel"] = "Batalkan pencarian";
$string["emptySearch"] = "Tidak ada yang ditemukan!";

$string["demonlist"] = 'Daftar Demon';
$string["demonlistRecord"] = 'catatan <b>%s</b>';
$string["alreadyApproved"] = 'Sudah disetujui!';
$string["alreadyDenied"] = 'Sudah ditolak!';
$string["approveSuccess"] = 'Anda telah berhasil menyetujui catatan <b>%s</b>!';
$string["denySuccess"] = 'Anda berhasil menolak rekor <b>%s</b>!';
$string["recordParameters"] = '<b>%s</b> telah mengalahkan <b>%s</b> dalam <b>%d</b> percobaan';
$string["approve"] = 'Menyetujui';
$string["deny"] = 'Membantah';
$string["submitRecord"] = 'Kirim catatan';
$string["submitRecordForLevel"] = 'Kirimkan data untuk <b>%s</b>';
$string["alreadySubmitted"] = 'Anda telah mengirimkan rekor untuk <b>%s</b>!';
$string["submitSuccess"] = 'Anda telah berhasil mengirimkan rekor untuk <b>%s</b>!';
$string["submitRecordDesc"] = 'Kirimkan rekor hanya jika Anda berhasil menyelesaikan levelnya!';
$string["atts"] = 'Percobaan';
$string["ytlink"] = 'ID video YouTube (dQw4w9WgXcQ)';
$string["submit"] = 'Kirim';
$string["addDemonTitle"] = 'Tambahkan Demon';
$string["addDemon"] = 'Tambahkan demon ke daftar demon';
$string["addedDemon"] = 'Anda telah ditambahkan <b>%s</b> ke tempat <b>%d</b>!';
$string["addDemonDesc"] = 'Disini Anda dapat menambahkan demon ke daftar demon!';
$string["place"] = 'Tempat';
$string["giveablePoints"] = 'Poin yang bisa diberikan';
$string["add"] = 'Menambahkan';
$string["recordApproved"] = 'Rekor disetujui!';
$string["recordDenied"] = 'Rekor ditolak!';
$string["recordSubmitted"] = 'Rekor dikirimkan!';
$string["nooneBeat"] = 'tidak ada yang mengalahkan'; //biarkan huruf kecil
$string["oneBeat"] = '1 pemain telah dikalahkan'; 
$string["lower5Beat"] = '%d pemain telah dikalahkan'; // sintaksis Rusia, maaf
$string["above5Beat"] = '%d pemain telah dikalahkan'; 
$string["demonlistLevel"] = '%s <text class="dltext">oleh <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';
$string["noDemons"] = 'Tampaknya daftar demon- Anda tidak memiliki demon apa pun...';
$string["addSomeDemons"] = 'Tambahkan beberapa demon untuk mengisi daftar demon!';
$string["askForDemons"] = 'Minta administrator server untuk menambahkan beberapa!';
$string["recordList"] = 'Daftar catatan';
$string["status"] = 'Status';
$string["checkRecord"] = 'Periksa catatan';
$string["record"] = 'Catatan';
$string["recordDeleted"] = 'Catatan telah dihapus!';
$string["changeDemon"] = 'Ubah demon';
$string["demonDeleted"] = 'Demon telah dihapus!';
$string["changedDemon"] = 'Anda mengganti <b>%s</b> ke posisi <b>%d</b>!';
$string["changeDemonDesc"] = 'Di sini Anda dapat mengubah demon!<br> Jika Anda ingin menghapus demon, setel tempat ke 0.';

$string["didntActivatedEmail"] = 'Anda tidak mengaktifkan akun Anda melalui email!';
$string["checkMail"] = 'Anda harus memeriksa email Anda...';

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
$string["giveClanDesc"] = "Disini Anda dapat memberikan klan Anda kepada pemain.";
$string["notInYourClan"] = "Pemain ini tidak ada dalam klan Anda!";
$string["givedClan"] = "Anda berhasil memberikan klan Anda kepada <b>%s</b>!";
$string["deletedClan"] = "Anda menghapus klan <b>%s</b>.";
$string["deleteClanDesc"] = "Disini Anda dapat menghapus klan Anda.";
$string["yourClan"] = "Klan Anda";
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
$string["alreadyInClan"] = "Anda sudah menjadi anggota klan!";
$string["createClan"] = "Buat klan";
$string["createdClan"] = "Anda berhasil membuat klan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Disini Anda dapat membuat klan!";
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
$string['listTableYour'] = "Daftar Anda yang tidak terdaftar";

$string['forgotPasswordChangeTitle'] = "Ubah kata sandi";
$string["successfullyChangedPass"] = "Kata sandi berhasil diubah!";
$string['forgotPasswordTitle'] = "Lupa kata sandi?";
$string['maybeSentAMessage'] = "Kami akan mengirimkan pesan kepada Anda jika akun ini ada.";
$string['forgotPasswordDesc'] = "Di sini Anda dapat meminta tautan ubah kata sandi jika Anda lupa!";
$string['forgotPasswordButton'] = "Minta tautan";

$string['sfxAdd'] = "Tambahkan SFX";
$string["sfxAddError-5"] = "Ukuran SFX lebih tinggi dari $sfxSize megabita!";
$string["sfxAddError-6"] = "Ada yang tidak beres saat mengunggah SFX!";
$string["sfxAddError-7"] = "Anda hanya dapat mengunggah audio!";
$string['sfxAdded'] = 'SFX ditambahkan';
$string['yourNewSFX'] = "Lihatlah SFX baru Anda!";
$string["sfxAddAnotherBTN"] = "Satu SFX lagi?";
$string["sfxAddDesc"] = "Disini Anda dapat menambahkan SFX Anda!";
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
$string['noBanInPast'] = 'Anda tidak dapat melarang sampai lewat!';
$string['banSuccess'] = 'Anda berhasil memblokir <b>%1$s</b> hingga <b>%3$s</b> di «<b>%2$s</b>»!';
$string['person'] = 'Orang';
$string['youAreBanned'] = 'Anda diblokir hingga <b>%2$s</b> karena alasan:<br><b>%1$s</b>';
$string['banChange'] = 'Mengubah';
$string['system'] = 'Sistem';

$string['levelComments'] = 'Komentar tingkat';
$string['levelLeaderboards'] = 'Papan peringkat tingkat';
$string['manageLevel'] = 'Kelola level';
$string['noComments'] = 'Tidak ada komentar!';
$string['commentHere'] = 'Publikasikan komentar...';
$string['weekLeaderboards'] = 'Selama seminggu';
$string['noLeaderboards'] = 'Tidak ada papan peringkat!';
$string['manageLevelDesc'] = 'Di sini Anda dapat mengubah level!';
$string['silverCoins'] = 'Koin perak';
$string['unlistedLevel'] = 'Tingkat tidak terdaftar';
$string['lockUpdates'] = 'Kunci pembaruan';
$string['lockCommenting'] = 'Kunci komentar';
$string['successfullyChangedLevel'] = 'Anda berhasil mengubah level!';
$string['successfullyDeletedLevel'] = 'Anda berhasil menghapus level!';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Mengunggah";
$string["errorGeneric"] = "Kesalahan muncul!";
$string["smthWentWrong"] = "Ada yang tidak beres!";
$string["tryAgainBTN"] = "Coba lagi";
//songAdd.php
$string["songAddDesc"] = "Disini Anda dapat menambahkan lagu Anda!";
$string["songAddUrlFieldLabel"] = "URL Lagu: (hanya tautan Direct atau Dropbox)";
$string["songAddUrlFieldPlaceholder"] = "URL Lagu";
$string["songAddNameFieldPlaceholder"] = "Nama";
$string["songAddAuthorFieldPlaceholder"] = "Pengarang";
$string["songAddButton"] = "Pilih lagu";
$string["songAddAnotherBTN"] = "Lagu lain?";
$string["songAdded"] = "Lagu ditambahkan";
$string["deletedSong"] = "Anda berhasil menghapus lagu";
$string["renamedSong"] = "Anda berhasil mengganti nama lagu menjadi";
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
$string["songAddError-7"] = "Anda hanya dapat mengunggah audio!";

$string[400] = "Permintaan buruk!";
$string["400!"] = "Periksa driver perangkat keras jaringan Anda.";
$string[403] = "Terlarang!";
$string["403!"] = "Anda tidak memiliki akses ke halaman ini!";
$string[404] = "Halaman tidak ditemukan!";
$string["404!"] = "Apakah Anda yakin Anda mengetik alamat dengan benar?";
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
$string["registerDate"] = "Register date";
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
//modActionsList
$string["banDesc"] = "Disini Anda dapat melarang pemain!";
$string["playerTop"] = 'Pemain terbaik';
$string["creatorTop"] = 'Pembuat konten teratas';
$string["levelUploading"] = 'Mengunggah level';
$string["successfullyBanned"] = 'Pemain <b>%1$s</b> dengan ID akun <b>%2$s</b> berhasil diblokir!';
$string["successfullyUnbanned"] = 'Pemain <b>%1$s</b> dengan ID akun <b>%2$s</b> berhasil dibatalkan pemblokirannya!';
$string["commentBan"] = 'Mengomentari';

$string["admin"] = "Administrator";
$string["elder"] = "Elder Moderator";
$string["moder"] = "Moderator";
$string["player"] = "Pemain";

$string["starsLevel2"] = "bintang";
$string["starsLevel1"] = "bintang";
$string["starsLevel0"] = "bintang";
$string["coins2"] = "koin";
$string["coins1"] = "koin";
$string["coins0"] = "koin";
$string["time0"] = "waktu";
$string["time1"] = "waktu";
$string["times"] = "waktu";
$string["action0"] = "tindakan";
$string["action1"] = "tindakan";
$string["action2"] = "tindakan";
$string["lvl0"] = "level";
$string["lvl1"] = "level";
$string["lvl2"] = "level";
$string["player0"] = "pemain";
$string["player1"] = "pemain";
$string["player2"] = "pemain";
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
$string["banYourself"] = "Anda tidak bisa melarang diri Anda sendiri!"; 
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
$string["everyActions"] = "Tindakan apa pun";
$string["everyMod"] = "Semua moderator";
$string["Kish!"] = "Pergilah!";
$string["noPermission"] = "Anda tidak memiliki izin!";
$string["noLogin?"] = "Anda belum masuk ke akun Anda!";
$string["LoginBtn"] = "Masuk ke akun";
$string["dashboard"] = "Dasbor";
$string["userID"] = 'ID Pengguna';
//errors
$string["errorNoAccWithPerm"] = "Kesalahan: Tidak ditemukan akun dengan izin '%s'";
