<?php
global $dbPath;
include __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Trang Chủ";
$string["welcome"] = "Chào mừng đến với ".$gdps.'!';
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Chào mừng đến với Bảng Điều Khiển! Chúng tôi cung cấp cho bạn một số gợi ý sau khi cài đặt:<br>
1. Có vẻ như các quyền mới đã xuất hiện trong SQL trong bảng 'roles'! Bạn nên kiểm tra nó...<br>
2. Nếu bạn đặt 'icon.png' vào thư mục 'dashboard', thì biểu tượng của GDPS của bạn sẽ xuất hiện ở góc trên bên trái!<br>
3. Bạn nên cấu hình config/dashboard.php!";
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

$string["levelReupload"] = "Đăng lại cấp độ";
$string["levelReuploadDesc"] = "Ở đây bạn có thể đăng lại một cấp độ từ bất kỳ máy chủ nào!";
$string["advanced"] = "Tùy chọn nâng cao";
$string["errorConnection"] = "Lỗi kết nối!";
$string["levelNotFound"] = "Cấp độ này không tồn tại!";
$string["robtopLol"] = "RobTop không thích bạn :c";
$string["sameServers"] = "Máy chủ lưu trữ và máy chủ mục tiêu giống nhau!";
$string["levelReuploaded"] = "Cấp độ đã được đăng lại! ID cấp độ:";
$string["oneMoreLevel?"] = "Một cấp độ nữa?";
$string["levelAlreadyReuploaded"] = "Cấp độ đã được đăng lại!";
$string["server"] = "Máy chủ";
$string["levelID"] = "ID cấp độ";
$string["pageDisabled"] = "Trang này đã bị vô hiệu hóa!";
$string["levelUploadBanned"] = "Bạn bị cấm đăng cấp độ!";

$string["activateAccount"] = "Kích hoạt tài khoản";
$string["activateDesc"] = "Kích hoạt tài khoản của bạn!";
$string["activated"] = "Tài khoản của bạn đã được kích hoạt thành công!";
$string["alreadyActivated"] = "Tài khoản của bạn đã được kích hoạt";
$string["maybeActivate"] = "Có thể bạn chưa kích hoạt tài khoản của mình.";
$string["activate"] = "Kích hoạt";
$string["activateDisabled"] = "Kích hoạt tài khoản đã bị vô hiệu hóa!";

$string["addMod"] = "Thêm người điều hành";
$string["addModDesc"] = "Ở đây bạn có thể thăng cấp ai đó lên làm người điều hành!";
$string["modYourself"] = "Bạn không thể tự thăng cấp mình lên làm người điều hành!";
$string["alreadyMod"] = "Người chơi này đã là người điều hành!";
$string["addedMod"] = "Bạn đã thăng cấp thành công một người chơi lên làm người điều hành";
$string["addModOneMore"] = "Thêm một người điều hành nữa?";
$string["modAboveYourRole"] = "Bạn đang cố gắng cấp một vai trò cao hơn của bạn!";
$string["makeNewMod"] = "Thăng cấp ai đó lên làm người điều hành!";
$string["reassignMod"] = "Chuyển lại người điều hành";
$string["reassign"] = "Chuyển lại";
$string['demotePlayer'] = "Giáng chức người chơi";
$string['demotedPlayer'] = "Bạn đã giáng chức thành công <b>%s</b>!";
$string['addedModNew'] = "Bạn đã thăng cấp thành công <b>%s</b> lên làm người điều hành!";
$string['demoted'] = 'Đã giáng chức';

$string["shareCPTitle"] = "Chia sẻ Điểm Sáng Tạo";
$string["shareCPDesc"] = "Ở đây bạn có thể chia sẻ Điểm Sáng Tạo với người chơi!";
$string["shareCP"] = "Chia sẻ";
$string["alreadyShared"] = "Cấp độ này đã chia sẻ Điểm Sáng Tạo cho người chơi này!";
$string["shareToAuthor"] = "Bạn đã cố gắng chia sẻ Điểm Sáng Tạo cho tác giả cấp độ!";
$string["userIsBanned"] = "Người chơi này đã bị cấm!";
$string["shareCPOneMore"] = "Chia sẻ thêm một lần nữa?";
$string['shareCPSuccessNew'] = 'Bạn đã chia sẻ thành công Điểm Sáng Tạo của cấp độ <b>%1$s</b> cho người chơi <b>%2$s</b>!';

$string["messenger"] = "Tin nhắn";
$string["write"] = "Viết";
$string["send"] = "Gửi";
$string["noMsgs"] = "Bắt đầu cuộc trò chuyện!";
$string["subject"] = "Chủ đề";
$string["msg"] = "Tin nhắn";
$string["tooFast"] = "Bạn đang gõ quá nhanh!";

$string["levelToGD"] = "Đăng lại cấp độ lên máy chủ mục tiêu";
$string["levelToGDDesc"] = "Ở đây bạn có thể đăng lại cấp độ của mình lên máy chủ mục tiêu!";
$string["usernameTarget"] = "Tên người dùng cho máy chủ mục tiêu";
$string["passwordTarget"] = "Mật khẩu cho máy chủ mục tiêu";
$string["notYourLevel"] = "Đây không phải là cấp độ của bạn!";
$string["reuploadFailed"] = "Lỗi đăng lại cấp độ!";

$string["search"] = "Tìm kiếm...";
$string["searchCancel"] = "Hủy tìm kiếm";
$string["emptySearch"] = "Không tìm thấy gì!";

$string["approve"] = 'Chấp thuận';
$string["deny"] = 'Từ chối';
$string["submit"] = 'Gửi';
$string["place"] = 'Vị trí';
$string["add"] = 'Thêm';
$string["demonlistLevel"] = '%s <text class="dltext">bởi <button type="button" onclick="a(\'profile/%3$s\', true, true)" style="font-size:25px" class="accbtn" name="accountID" value="%d">%s</button></text>';

$string["didntActivatedEmail"] = 'Bạn chưa kích hoạt tài khoản của mình qua email!';
$string["checkMail"] = 'Bạn nên kiểm tra email của mình...';

$string["likeSong"] = "Thêm bài hát vào yêu thích";
$string["dislikeSong"] = "Xóa bài hát khỏi yêu thích";
$string["favouriteSongs"] = "Bài hát yêu thích";
$string["howMuchLiked"] = "Bao nhiêu người thích?";
$string["nooneLiked"] = "Không ai thích";

$string["clan"] = "Clan";
$string["joinedAt"] = "Tham gia clan vào: <b>%s</b>";
$string["createdAt"] = "Tạo clan vào: <b>%s</b>";
$string["clanMembers"] = "Thành viên clan";
$string["noMembers"] = "Không có thành viên";
$string["clanOwner"] = "Chủ clan";
$string["noClanDesc"] = "<i>Không có mô tả</i>";
$string["noClan"] = "Clan này không tồn tại!";
$string["clanName"] = "Tên clan";
$string["clanTag"] = "Tag clan (3-5 ký tự)";
$string["clanDesc"] = "Mô tả clan";
$string["clanColor"] = "Màu clan";
$string["dangerZone"] = "Khu vực nguy hiểm";
$string["giveClan"] = "Chuyển clan";
$string["deleteClan"] = "Xóa clan";
$string["goBack"] = "Quay lại";
$string["areYouSure"] = "Bạn có chắc không?";
$string["giveClanDesc"] = "Ở đây bạn có thể chuyển clan của mình cho một người chơi.";
$string["notInYourClan"] = "Người chơi này không ở trong clan của bạn!";
$string["givedClan"] = "Bạn đã chuyển clan của mình thành công cho <b>%s</b>!";
$string["deletedClan"] = "Bạn đã xóa clan <b>%s</b>.";
$string["deleteClanDesc"] = "Ở đây bạn có thể xóa clan của mình.";
$string["yourClan"] = "Clan của bạn";
$string["members0"] = "<b>1</b> thành viên";
$string["members1"] = "<b>%d</b> thành viên"; 
$string["members2"] = "<b>%d</b> thành viên"; 
$string["noRequests"] = "Không có yêu cầu nào. Thư giãn!";
$string["pendingRequests"] = "Yêu cầu clan";
$string["closedClan"] = "Clan đã đóng";
$string["kickMember"] = "Đuổi thành viên";
$string["leaveFromClan"] = "Rời khỏi clan";
$string["askToJoin"] = "Gửi yêu cầu tham gia";
$string["removeClanRequest"] = "Xóa yêu cầu tham gia";
$string["joinClan"] = "Tham gia clan";
$string["noClans"] = "Không có clan nào";
$string["clans"] = "Clans";
$string["alreadyInClan"] = "Bạn đã ở trong clan!";
$string["createClan"] = "Tạo clan";
$string["createdClan"] = "Bạn đã tạo thành công clan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Ở đây bạn có thể tạo một clan!";
$string["create"] = "Tạo";
$string["mainSettings"] = "Cài đặt chính";
$string["takenClanName"] = "Tên clan này đã được sử dụng!";
$string["takenClanTag"] = "Tag clan này đã được sử dụng!";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1$s</button><text class="dltext"> đã đề xuất <b>%4$s%3$s</b> cho</text><text class="levelname">%2$s</text>'; // %1$s - Tên người dùng Mod, %2$s - tên cấp độ, %3$s - x sao, %4$s - Nổi bật/Epic (%4$s%3$s - Nổi bật, x sao)
$string["reportedName"] = '%1$s<text class="dltext"> đã báo cáo</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Danh sách";
$string['listTableMod'] = "Danh sách chưa được liệt kê";
$string['listTableYour'] = "Danh sách chưa được liệt kê của bạn";

$string['forgotPasswordChangeTitle'] = "Đổi mật khẩu";
$string["successfullyChangedPass"] = "Mật khẩu đã được thay đổi thành công!";
$string['forgotPasswordTitle'] = "Quên mật khẩu?";
$string['maybeSentAMessage'] = "Chúng tôi sẽ gửi cho bạn một tin nhắn nếu tài khoản này tồn tại.";
$string['forgotPasswordDesc'] = "Ở đây bạn có thể yêu cầu liên kết đổi mật khẩu nếu bạn quên!";
$string['forgotPasswordButton'] = "Yêu cầu liên kết";

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

$string['levelComments'] = 'Bình luận trong level';
$string['levelLeaderboards'] = 'Bảng xếp hạng của level';
$string['manageLevel'] = 'Quản lý level';
$string['noComments'] = 'Không có bình luận!';
$string['commentHere'] = 'Đăng bình luận...';
$string['weekLeaderboards'] = 'Trong một tuần';
$string['noLeaderboards'] = 'Không có xếp hạng!';
$string['manageLevelDesc'] = 'Ở đây bạn có thể chỉnh sửa level!';
$string['silverCoins'] = 'Xu bạc';
$string['unlistedLevel'] = 'Level không được liệt kê';
$string['lockUpdates'] = 'Khoá cập nhật';
$string['lockCommenting'] = 'Khoá bình luận';
$string['successfullyChangedLevel'] = 'Bạn đã chỉnh sửa level thành công!';
$string['successfullyDeletedLevel'] = 'Bạn đã xoá level thành công!';

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

$string['downloadLevelAsGMD'] = 'Save as .gmd';

$string['songIsAvailable'] = 'Available';
$string['songIsDisabled'] = 'Not available';
$string['disabledSongs'] = 'Disabled songs';
$string['disabledSFXs'] = 'Disabled SFXs';

/*
	ĐĂNG LẠI
*/

$string["reuploadBTN"] = "Tải lên";
$string["errorGeneric"] = "Đã xảy ra lỗi!";
$string["smthWentWrong"] = "Đã có lỗi xảy ra!";
$string["tryAgainBTN"] = "Thử lại";
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

$string[400] = "Yêu cầu không hợp lệ!";
$string["400!"] = "Kiểm tra trình điều khiển phần cứng mạng của bạn.";
$string[403] = "Bị cấm truy cập!";
$string["403!"] = "Bạn không có quyền truy cập trang này!";
$string[404] = "Không tìm thấy trang!";
$string["404!"] = "Bạn có chắc đã nhập đúng địa chỉ không?";
$string[500] = "Lỗi máy chủ nội bộ!";
$string["500!"] = "Lập trình viên đã mắc lỗi trong mã,</br>
vui lòng báo cáo vấn đề này tại đây:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Máy chủ không hoạt động!";
$string["502!"] = "Tải trên máy chủ quá lớn.</br>
Hãy quay lại sau vài giờ nữa!";

$string["invalidCaptcha"] = "Phản hồi captcha không hợp lệ!";
$string["page"] = "Trang";
$string["emptyPage"] = "Trang này trống!";

/*
	THỐNG KÊ
*/
$string["ID"] = "ID";
$string["orbs"] = "Orbs";
$string["stars"] = "Sao";
$string["coins"] = "Xu";
$string["accounts"] = "Tài khoản";
$string["levels"] = "Cấp độ";
$string["songs"] = "Bài hát";
$string["author"] = "Người tạo";
$string["name"] = "Tên";
$string["date"] = "Ngày";
$string["type"] = "Loại";
$string["reportCount"] = "Số lượng báo cáo";
$string["reportMod"] = "Báo cáo";
$string["username"] = "Tên người dùng";
$string["accountID"] = "ID Tài khoản";
$string["registerDate"] = "Ngày đăng ký";
$string["levelAuthor"] = "Tác giả cấp độ";
$string["isAdmin"] = "Vai trò trên máy chủ";
$string["isAdminYes"] = "Có";
$string["isAdminNo"] = "Không";
$string["userCoins"] = "Xu người dùng";
$string["time"] = "Thời gian";
$string["deletedLevel"] = "Cấp độ đã xóa";
$string["mod"] = "Người kiểm duyệt";
$string["count"] = "Số lượng hành động";
$string["ratedLevels"] = "Cấp độ đã đánh giá";
$string["lastSeen"] = "Lần cuối trực tuyến";
$string["level"] = "Cấp độ";
$string["pageInfo"] = "Đang hiển thị trang %s trên %s";
$string["first"] = "Đầu tiên";
$string["previous"] = "Trước";
$string["next"] = "Tiếp";
$string["never"] = "Chưa bao giờ";
$string["last"] = "Cuối cùng";
$string["go"] = "Đi";
$string["levelid"] = "ID Cấp độ";
$string["levelname"] = "Tên cấp độ";
$string["leveldesc"] = "Mô tả cấp độ";
$string["noDesc"] = "Không có mô tả";
$string["levelpass"] = "Mật khẩu";
$string["nopass"] = "Không có mật khẩu";
$string["unrated"] = "Chưa đánh giá";
$string["rate"] = "Đánh giá";
$string["stats"] = "Thống kê";
$string["suggestFeatured"] = "Đề xuất nổi bật?";
$string["whoAdded"] = "Ai đã thêm?";

$string["banDesc"] = "Ở đây bạn có thể cấm (hoặc bỏ cấm) một người chơi khỏi bảng xếp hạng!";
$string["playerTop"] = 'Top người chơi';
$string["creatorTop"] = 'Top người tạo';
$string["levelUploading"] = 'Đang tải lên cấp độ';
$string["successfullyBanned"] = 'Người chơi <b>%1$s</b> với ID tài khoản <b>%2$s</b> đã bị cấm thành công!';
$string["successfullyUnbanned"] = 'Người chơi <b>%1$s</b> với ID tài khoản <b>%2$s</b> đã được bỏ cấm thành công!';
$string["commentBan"] = 'Bình luận';

$string["player"] = "Người chơi";

$string["starsLevel2"] = "sao";
$string["starsLevel1"] = "sao";
$string["starsLevel0"] = "sao";
$string["coins1"] = "xu";
$string["coins0"] = "xu";
$string["unban"] = "Bỏ cấm";
$string["isBan"] = "Cấm";

$string["noCoins"] = "Không có xu";
$string["noReason"] = "Không có lý do";
$string["noActions"] = "Không có hành động";
$string["noRates"] = "Không có đánh giá";

$string["future"] = "Tương lai";

$string["spoiler"] = "Tiết lộ";
$string["accid"] = "với ID tài khoản";
$string["banned"] = "đã bị cấm thành công!";
$string["unbanned"] = "đã được bỏ cấm thành công!";
$string["ban"] = "Cấm";
$string["nothingFound"] = "Người chơi này không tồn tại!";
$string["banUserID"] = "Tên người dùng hoặc ID tài khoản";
$string["banUserPlace"] = "Cấm một người dùng";
$string["banYourself"] = "Bạn không thể cấm chính mình!"; 
$string["banYourSelfBtn!"] = "Cấm người khác";
$string["banReason"] = "Lý do cấm";
$string["action"] = "Hành động";
$string["value"] = "Giá trị 1";
$string["value2"] = "Giá trị 2";
$string["value3"] = "Giá trị 3";
$string["modAction1"] = "Đánh giá một cấp độ";
$string["modAction2"] = "Bỏ/đặt nổi bật một cấp độ";
$string["modAction3"] = "Bỏ/xác minh xu";
$string["modAction4"] = "Bỏ/đặt epic cho một cấp độ";
$string["modAction5"] = "Đặt làm tính năng hàng ngày";
$string["modAction6"] = "Xóa một cấp độ";
$string["modAction7"] = "Thay đổi người tạo";
$string["modAction8"] = "Đổi tên một cấp độ";
$string["modAction9"] = "Thay đổi mật khẩu cấp độ";
$string["modAction10"] = "Thay đổi độ khó demon";
$string["modAction11"] = "Chia sẻ CP";
$string["modAction12"] = "Bỏ/công khai cấp độ";
$string["modAction13"] = "Thay đổi mô tả cấp độ";
$string["modAction14"] = "Bật/tắt LDM";
$string["modAction15"] = "Bỏ cấm/cấm bảng xếp hạng";
$string["modAction16"] = "Thay đổi ID bài hát";
$string["modAction17"] = "Tạo một Map Pack";
$string["modAction18"] = "Tạo một Gauntlet";
$string["modAction19"] = "Thay đổi bài hát";
$string["modAction20"] = "Cấp quyền Người kiểm duyệt cho người chơi";
$string["modAction21"] = "Thay đổi Map Pack";
$string["modAction22"] = "Thay đổi Gauntlet";
$string["modAction23"] = "Thay đổi nhiệm vụ";
$string["modAction24"] = "Phân công lại một người chơi";
$string["modAction25"] = "Tạo một nhiệm vụ";
$string["modAction26"] = "Thay đổi tên người dùng/mật khẩu của người chơi";
$string["modAction27"] = "Thay đổi SFX";
$string["modAction30"] = "Đánh giá danh sách";
$string["modAction31"] = "Gửi danh sách";
$string["modAction32"] = "Bỏ/đặt nổi bật danh sách";
$string["modAction33"] = "Bỏ/công khai danh sách";
$string["modAction34"] = "Xóa danh sách";
$string["modAction35"] = "Thay đổi người tạo danh sách";
$string["modAction36"] = "Thay đổi tên danh sách";
$string["modAction37"] = "Thay đổi mô tả danh sách";
$string["modAction40"] = "Removed sent level";
$string["modAction41"] = "Suggested level";
$string["everyActions"] = "Mọi hành động";
$string["everyMod"] = "Tất cả người kiểm duyệt";
$string["Kish!"] = "Đi đi!";
$string["noPermission"] = "Bạn không có quyền!";
$string["noLogin?"] = "Bạn chưa đăng nhập vào tài khoản của mình!";
$string["LoginBtn"] = "Đăng nhập vào tài khoản";
$string["dashboard"] = "Bảng điều khiển";
$string["userID"] = 'ID Người dùng';