<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Trang Chủ";
$string["welcome"] = "Chào mừng đến với ".$gdps.'!';
$string["didntInstall"] = "<div style='color:#47a0ff'><b>Cảnh báo!</b> Bạn chưa cài đặt đầy đủ trang chủ! Bấm vào văn bản để làm nó ngay.</div>";
$string["levelsWeek"] = "Những cấp độ được tải lên trong mỗi tuần";
$string["levels3Months"] = "Những cấp độ được tải lên trong mỗi 3 tháng";
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Welcome to Dashboard! We give you some hints after installation:<br>
1. It seems that new permissions have appeared in SQL in the 'roles' table! You should check it out...<br>
2. If you put 'icon.png' to the 'dashboard' folder, then the icon of your GDPS will appear on the top left!<br>
3. You should configure config/dashboard.php!";
$string["wwygdt"] = "Bạn sẽ làm gì trong hôm nay?";
$string["game"] = "Trò chơi";
$string["guest"] = "Khách";
$string["account"] = "Tài khoản";
$string["levelsOptDesc"] = "Xem danh sách các cấp độ";
$string["songsOptDesc"] = "Xem danh sách các bản nhạc";
$string["yourClanOptDesc"] = "Xem clan \"%s\"";
$string["clanOptDesc"] = "Xem danh sách các clan";
$string["yourProfile"] = "Xem hồ sơ";
$string["profileOptDesc"] = "Xem hồ sơ của bạn";
$string["messengerOptDesc"] ="Mở tin nhắn";
$string["addSongOptDesc"] = "Thêm nhạc vào máy chủ";
$string["loginOptDesc"] = "Đăng nhập vào tài khoản";
$string["createAcc"] = "Tạo một tài khoản";
$string["registerOptDesc"] = "Đăng ký vào %s";
$string["downloadOptDesc"] = "Tải xuống %s";

$string["tryCron"] = "Chạy Cron";
$string["cronSuccess"] = "Thành công!";
$string["cronError"] = "Đã có lỗi!";

$string["profile"] = "Hồ sơ";
$string["empty"] = "Trống...";
$string["writeSomething"] = "Viết cái gì đó!";  
$string["replies"] = "Trả lời";
$string["replyToComment"] = "Trả lời lại một bình luận";
$string["settings"] = "Cài đặt";
$string["allowMessagesFrom"] = "Cho phép các tin nhắn từ...";
$string["allowFriendReqsFrom"] = "Cho phép lời mời kết bạn từ...";
$string["showCommentHistory"] = "Hiển thị lịch sử bình luận...";
$string["timezoneChoose"] = "Chọn múi giờ";
$string["yourYouTube"] = "Kênh Youtube của bạn";
$string["yourVK"] = "Trang của bạn trên VK";
$string["yourTwitter"] = "Trang của bạn trên Twitter";
$string["yourTwitch"] = "Kênh Twitch của bạn";
$string["saveSettings"] = "Lưu lại thay đổi";
$string["all"] = "Tất cả";
$string["friends"] = "Bạn bè";
$string["none"] = "Không";
$string["youBlocked"] = "Người chơi này đã chặn bạn!";
$string["cantMessage"] = "Bạn không thể nhắn tin với người chơi này!";
  
$string["accountManagement"] = "Quản lý tài khoản";
$string["changePassword"] = "Đổi mật khẩu";
$string["changeUsername"] = "Đổi tên người dùng";
$string["unlistedLevels"] = "Cấp độ không công khai của bạn";

$string["manageSongs"] = "Quản lý những bản nhạc";
$string["gauntletManage"] = "Quản lý Gauntlets";
$string["suggestLevels"] = "Cấp độ được đề xuất";

$string["modTools"] = "Công cụ của người điều hành";
$string["leaderboardBan"] = "Cấm một người dùng";
$string["unlistedMod"] = "Các cấp độ không công khai";

$string["reuploadSection"] = "Nhạc và SFX";
$string["songAdd"] = "Thêm một bản nhạc";
$string["songLink"] = "Thêm một bản nhạc bằng liên kết";
$string["packManage"] = "Quản lý các gói cấp độ";

$string["browse"] = "Duyệt qua";
$string["statsSection"] = "Thống kê";
$string["dailyTable"] = "Các cấp độ mỗi ngày";
$string["modActionsList"] = "Hành động của người điều hành";
$string["modActions"] = "Những người điều hành máy chủ";
$string["gauntletTable"] = "Danh sách Gauntlets";
$string["packTable"] = "Danh sách gói cấp độ";
$string["leaderboardTime"] = "Tiến trình bảng xếp hạng";

$string["download"] = "Tải xuống";
$string["forwindows"] = "Cho Windows";
$string["forandroid"] = "Cho Android";
$string["formac"] = "Cho Mac";
$string["forios"] = "Cho iOS";
$string["third-party"] = "Bên thứ ba";
$string["thanks"] = "Cảm ơn những người này!";
$string["language"] = "Ngôn ngữ";

$string["loginHeader"] = "Chào mừng, %s!";
$string["logout"] = "Đăng xuất";
$string["login"] = "Đăng nhập";
$string["wrongNickOrPass"] = "Sai tên người dùng hoặc mật khẩu!";
$string["invalidid"] = "ID không hợp lệ!";
$string["loginBox"] = "Đăng nhập vào tài khoản của bạn";
$string["loginSuccess"] = "Bạn đã đăng nhập thành công vào tài khoản của mình!";
$string["loginAlready"] = "Bạn đã đăng nhập!";
$string["clickHere"] = "Bảng điều khiển";
$string["enterUsername"] = "Nhập tên người dùng";
$string["enterPassword"] = "Nhập mật khẩu";
$string["loginDesc"] = "Ở đây bạn có thể đăng nhập vào tài khoản của mình!";

$string["register"] = "Đăng ký";
$string["registerAcc"] = "Đăng ký tài khoản";
$string["registerDesc"] = "Đăng ký tài khoản của bạn!";
$string["repeatpassword"] = "Nhập lại mật khẩu";
$string["email"] = "Email";
$string["repeatemail"] = "Nhập lại email";
$string["smallNick"] = "Tên người dùng quá ngắn!";
$string["smallPass"] = "Mật khẩu quá ngắn!";
$string["passDontMatch"] = "Mật khẩu không khớp!";
$string["emailDontMatch"] = "Email không khớp!";
$string["registered"] = "Bạn đã đăng ký tài khoản thành công!";
$string["bigNick"] = "Tên người dùng quá dài!";
$string["mailExists"] = "Có một tài khoản đã đăng ký bằng email này!";
$string["badUsername"] = "Làm ơn hãy chọn một tên người dùng khác";

$string["changePassTitle"] = "Đổi mật khẩu";
$string["changedPass"] = "Mật khẩu đã được đổi thành công! Bạn cần đăng nhập lại vào tài khoản của mình.";
$string["wrongPass"] = "Sai mật khẩu!";
$string["samePass"] = "Mật khẩu bạn nhập giống nhau!";
$string["changePassDesc"] = "Ở đây bạn có thể đổi mật khẩu của mình!";
$string["oldPassword"] = "Mật khẩu cũ";
$string["newPassword"] = "Mật khẩu mới";
$string["confirmNew"] = "Xác nhận mật khẩu";

$string["forcePassword"] = "Buộc đổi mật khẩu";
$string["forcePasswordDesc"] = "Ở đây bạn có thể bắt buộc thay đổi mật khẩu của những người chơi!";
$string["forceNick"] = "Buộc đổi tên người dùng";
$string["forceNickDesc"] = "Ở đây bạn có thể bắt buộc thay đổi tên người dùng của những người chơi!";
$string["forceChangedPass"] = "<b>%s</b> đã được thay dổi mật khẩu!";
$string["forceChangedNick"] = "<b>%s</b> đã được thay đổi tên người dùng!";
$string["changePassOrNick"] = "Đổi tên người dùng hoặc mật khẩu của người chơi";

$string["changeNickTitle"] = "Đổi tên người dùng";
$string["changedNick"] = "Tên người dùng đã được đổi thành công! Bạn cần đăng nhập lại vào tài khoản của mình.";
$string["wrongNick"] = "Sai tên người dùng!";
$string["sameNick"] = "Tên người dùng của bạn giống nhau!";
$string["alreadyUsedNick"] = "Tên người dùng bạn nhập đã được sử dụng!";
$string["changeNickDesc"] = "Ở đây bạn có thể đổi tên người dùng của mình!";
$string["oldNick"] = "Tên người dùng cũ";
$string["newNick"] = " Tên người dùng mới";
$string["password"] = "Mật khẩu";

$string["packCreate"] = "Tạo gói cấp độ";
$string["packCreateTitle"] = "Tạo một gói cấp độ";
$string["packCreateDesc"] = "Ở đây bạn có thể tạo một gói cấp độ!";
$string["packCreateSuccess"] = "Bạn đã tạo thành công một gói cấp độ!";
$string["packCreateOneMore"] = "Một gói cấp độ nữa?";
$string["packName"] = "Tên gói cấp độ";
$string["color"] = "Màu";
$string["sameLevels"] = "Bạn chọn cấp độ giống nhau!";
$string["show"] = "Hiện";
$string["packChange"] = "Thay đổi gói cấp độ";
$string["createNewPack"] = "Tạo một gói cấp độ!"; // cai comment nay co y nghia j

$string["gauntletCreate"] = "Tạo Gauntlet";
$string["gauntletCreateTitle"] = "Tạo Gauntlet";
$string["gauntletCreateDesc"] = "Ở đây bạn có thể tạo một Gauntlet!";
$string["gauntletCreateSuccess"] = "Bạn đã tạo thành công một Gauntlet!";
$string["gauntletCreateOneMore"] = "Một Gauntlet nữa?";
$string["chooseLevels"] = "Chọn các cấp độ!";
$string["checkbox"] = "Xác nhận";
$string["level1"] = "1st level";
$string["level2"] = "2nd level";
$string["level3"] = "3rd level";
$string["level4"] = "4th level";
$string["level5"] = "5th level";
$string["gauntletChange"] = "Đổi Gauntlet";
$string["createNewGauntlet"] = "Tạo Gauntlet mới!"; // Translate word "create" like its call to action
$string["gauntletCreateSuccessNew"] = 'Bạn đã tạo thành công <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Tự động chọn Gauntlet";

$string["addQuest"] = "Thêm nhiệm vụ";
$string["addQuestDesc"] = "Ở đây bạn có thể thêm một nhiệm vụ!";
$string["questName"] = "Tên nhiệm vụ";
$string["questAmount"] = "Số lượng bắt buộc";
$string["questReward"] = "Phần thưởng";
$string["questCreate"] = "Tạo một nhiệm vụ";
$string["questsSuccess"] = "Bạn đã tạo thành công một nhiệm vụ";
$string["invalidPost"] = "Dữ liệu không hợp lệ!";
$string["fewMoreQuests"] = "Bạn nên tạo thêm một vài nhiệm vụ nữa.";
$string["oneMoreQuest?"] = "Một nhiệm vụ nữa?";
$string["changeQuest"] = "Thay đổi nhiệm vụ";
$string["createNewQuest"] = "Tạo một nhiệm vụ mới!"; // giong het gaunlet va cai jj do k biet nvn

$string["levelReupload"] = "Reupload level";
$string["levelReuploadDesc"] = "Here you can reupload a level from any server!";
$string["advanced"] = "Advanced options";
$string["errorConnection"] = "Connection error!";
$string["levelNotFound"] = "This level doesn't exist!";
$string["robtopLol"] = "RobTop doesn't like you :c";
$string["sameServers"] = "Host server and the target server are the same!";
$string["levelReuploaded"] = "Level reuploaded! Level ID:";
$string["oneMoreLevel?"] = "One more level?";
$string["levelAlreadyReuploaded"] = "Level already reuploaded!";
$string["server"] = "Server";
$string["levelID"] = "Level ID";
$string["pageDisabled"] = "This page is disabled!";
$string["levelUploadBanned"] = "You're banned from uploading levels!";

$string["activateAccount"] = "Account activation";
$string["activateDesc"] = "Activate your account!";
$string["activated"] = "Your account has been successfully activated!";
$string["alreadyActivated"] = "Your account is already activated";
$string["maybeActivate"] = "Maybe you didn't activated your account yet.";
$string["activate"] = "Activate";
$string["activateDisabled"] = "Account activation is disabled!";

$string["addMod"] = "Add moderator";
$string["addModDesc"] = "Here you can promote someone to Moderator!";
$string["modYourself"] = "You can't grant yourself Moderator!";
$string["alreadyMod"] = "This player is already a Moderator!";
$string["addedMod"] = "You successfully granted Moderator to a player";
$string["addModOneMore"] = "One more moderator?";
$string["modAboveYourRole"] = "You\'re trying to give a role above yours!";
$string["makeNewMod"] = "Make someone moderator!";
$string["reassignMod"] = "Reassign moderator";
$string["reassign"] = "Reassign";
$string['demotePlayer'] = "Demote player";
$string['demotedPlayer'] = "You successfully demoted <b>%s</b>!";
$string['addedModNew'] = "You successfully promoted <b>%s</b> to Moderator!";
$string['demoted'] = 'Demoted';

$string["shareCPTitle"] = "Share Creator Points";
$string["shareCPDesc"] = "Here you can share Creator Points with player!";
$string["shareCP"] = "Share";
$string["alreadyShared"] = "This level already shared CP to this player!";
$string["shareToAuthor"] = "You tried to share CP to level author!";
$string["userIsBanned"] = "This player is banned!";
$string["shareCPSuccess"] = "You successfully shared Creator Points of level";
$string["shareCPSuccess2"] = "to player";
$string["updateCron"] = "Maybe you should update Creator Points.";
$string["shareCPOneMore"] = "One more share?";
$string['shareCPSuccessNew'] = 'You successfully shared Creator Points of level <b>%1$s</b> to player <b>%2$s</b>!';

$string["messenger"] = "Messenger";
$string["write"] = "Write";
$string["send"] = "Send";
$string["noMsgs"] = "Start dialog!";
$string["subject"] = "Subject";
$string["msg"] = "Message";
$string["tooFast"] = "You're typing too fast!";

$string["levelToGD"] = "Reupload level to target server";
$string["levelToGDDesc"] = "Here you can reupload your level to target server!";
$string["usernameTarget"] = "Username for target server";
$string["passwordTarget"] = "Password for target server";
$string["notYourLevel"] = "This is not your level!";
$string["reuploadFailed"] = "Level reupload error!";

$string["search"] = "Search...";
$string["searchCancel"] = "Cancel search";
$string["emptySearch"] = "Nothing found!";

$string["demonlist"] = 'Demonlist';
$string["demonlistRecord"] = '<b>%s</b>\'s record';
$string["alreadyApproved"] = 'Already approved!';
$string["alreadyDenied"] = 'Already denied!';
$string["approveSuccess"] = 'You\'ve successfully approved <b>%s</b>\'s record!';
$string["denySuccess"] = 'You\'ve successfully denied <b>%s</b>\'s record!';
$string["recordParameters"] = '<b>%s</b> has beated <b>%s</b> in <b>%d</b> attempts';
$string["approve"] = 'Approve';
$string["deny"] = 'Deny';
$string["submitRecord"] = 'Submit record';
$string["submitRecordForLevel"] = 'Submit record for <b>%s</b>';
$string["alreadySubmitted"] = 'You\'ve already submitted an record for <b>%s</b>!';
$string["submitSuccess"] = 'You\'ve successfully submitted an record for <b>%s</b>!';
$string["submitRecordDesc"] = 'Submit records only if you beated the level!';
$string["atts"] = 'Attempts';
$string["ytlink"] = 'YouTube video ID (dQw4w9WgXcQ)';
$string["submit"] = 'Submit';
$string["addDemonTitle"] = 'Add demon';
$string["addDemon"] = 'Add demon to demonlist';
$string["addedDemon"] = 'You\'ve been added <b>%s</b> to <b>%d</b> place!';
$string["addDemonDesc"] = 'Here you can add a demon to demonlist!';
$string["place"] = 'Place';
$string["giveablePoints"] = 'Giveable points';
$string["add"] = 'Add';
$string["recordApproved"] = 'Record approved!';
$string["recordDenied"] = 'Record denied!';
$string["recordSubmitted"] = 'Record submitted!';
$string["nooneBeat"] = 'noone has beaten'; //let it be lowercase
$string["oneBeat"] = '1 player has beaten'; 
$string["lower5Beat"] = '%d players have beaten'; // russian syntax, sorry
$string["above5Beat"] = '%d players have beaten'; 
$string["demonlistLevel"] = '%s <text class="dltext">by <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';
$string["noDemons"] = 'It seems that your demonlist doesn\'t have any demons...';
$string["addSomeDemons"] = 'Add some demons to fill up demonlist!';
$string["askForDemons"] = 'Ask server\'s administrator to add some!';
$string["recordList"] = 'List of records';
$string["status"] = 'Status';
$string["checkRecord"] = 'Check record';
$string["record"] = 'Record';
$string["recordDeleted"] = 'Record was deleted!';
$string["changeDemon"] = 'Change demon';
$string["demonDeleted"] = 'Demon was deleted!';
$string["changedDemon"] = 'You replaced <b>%s</b> to <b>%d</b> place!';
$string["changeDemonDesc"] = 'Here you can change a demon!<br>
If you want to delete demon, set place to 0.';

$string["didntActivatedEmail"] = 'You didn\'t activated your account through email!';
$string["checkMail"] = 'You should check your email...';

$string["likeSong"] = "Add song to favourites";
$string["dislikeSong"] = "Remove song from favourites";
$string["favouriteSongs"] = "Favourite songs";
$string["howMuchLiked"] = "How much liked?";
$string["nooneLiked"] = "Noone liked";

$string["clan"] = "Clan";
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

$string['sfxAdd'] = "Thêm SFX";
$string["sfxAddError-5"] = "Kích cỡ của SFX đã nặng hơn $sfxSize MB!";
$string["sfxAddError-6"] = "Có lỗi đã xảy ra trong khi tải lên SFX";
$string["sfxAddError-7"] = "Bạn chỉ có thể tải lên tệp âm thanh!";
$string['sfxAdded'] = 'SFX đã được thêm!';
$string['yourNewSFX'] = "Nghe qua SFX của bạn!";
$string["sfxAddAnotherBTN"] = "Một SFX nữa?";
$string["sfxAddDesc"] = "Ở đây bạn có thể thêm SFX!";
$string["chooseSFX"] = "Chọn SFX";
$string["sfxAddNameFieldPlaceholder"] = "Tên";
$string['sfxs'] = 'SFX';
$string['sfxID'] = 'SFX ID';
$string['manageSFX'] = 'Quản lý SFXs';

/*
	REUPLOAD
*/

$string["reuploadBTN"] = "Upload";
$string["errorGeneric"] = "Error appeared!";
$string["smthWentWrong"] = "Something went wrong!";
$string["tryAgainBTN"] = "Try again";
//songAdd.php
$string["songAddDesc"] = "Ở đây bạn có thể tải nhạc lên!";
$string["songAddUrlFieldLabel"] = "URL nhạc: (Trực tiếp hoặc chỉ Dropbox link)";
$string["songAddUrlFieldPlaceholder"] = "URL nhạc";
$string["songAddNameFieldPlaceholder"] = "Tên";
$string["songAddAuthorFieldPlaceholder"] = "Tác giả";
$string["songAddButton"] = "Chọn nhạc";
$string["songAddAnotherBTN"] = "Thêm một bản nhạc nữa?";
$string["songAdded"] = "Nhạc đã được thêm!";
$string["deletedSong"] = "Bạn đã xóa nhạc thành công!";
$string["renamedSong"] = "Bạn đã đổi tên nhạc thành";
$string["songID"] = "ID Nhạc: ";
$string["songIDw"] = "ID Nhạc";
$string["songAuthor"] = "Tác giả";
$string["size"] = "Kích cỡ";
$string["delete"] = "Xóa";
$string["change"] = "Thay đổi";
$string["chooseFile"] = "Chọn một bản nhạc";
$string['yourNewSong'] = "Nghe qua bản nhạc của bạn!";
///errors
$string["songAddError-2"] = "URL không hợp lệ!";
$string["songAddError-3"] = "Bản nhạc này đã được đăng lại với ID:";
$string["songAddError-4"] = "Bản nhạc này chưa được đăng lại";
$string["songAddError-5"] = "Kích cỡ của nhạc đã nặng hơn $songSize MB!";
$string["songAddError-6"] = "Đã có lỗi xảy ra trong khi tải nhạc lên!";
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
//modActionsList
$string["banDesc"] = "Here you can ban (or unban) a player from leaderboard!";
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
$string["modAction20"] = "Granted Moderator to player";
$string["modAction21"] = "Changed Map Pack";
$string["modAction22"] = "Changed Gauntlet";
$string["modAction23"] = "Changed quest";
$string["modAction24"] = "Reassigned a player";
$string["modAction25"] = "Created a quest";
$string["modAction26"] = "Changed player's username/password";
$string["modAction27"] = "Changed SFX";
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