<?php
global $dbPath;
require __DIR__."/../../".$dbPath."config/dashboard.php";

$string["homeNavbar"] = "Trang Chủ";
$string["welcome"] = "Chào mừng bạn đến với ".$gdps.'!';
$string["footer"] = $gdps.", ".date('Y', time());
$string["tipsAfterInstalling"] = "Chào mừng bạn đến với Bảng Điều Khiển! Chúng tôi cung cấp cho bạn một số gợi ý sau khi cài đặt:<br>
1. Có vẻ như các quyền mới đã xuất hiện trong SQL trong bảng 'roles'! Bạn nên kiểm tra nó...<br>
2. Nếu bạn đặt 'icon.png' vào thư mục 'dashboard', thì biểu tượng GDPS của bạn sẽ xuất hiện ở trên cùng bên trái!<br>
3. Bạn nên cấu hình config/dashboard.php!";
$string["wwygdt"] = "Hôm nay bạn định làm gì?";
$string["game"] = "Trò chơi";
$string["guest"] = "Khách";
$string["account"] = "Tài khoản";
$string["levelsOptDesc"] = "Xem danh sách các level";
$string["songsOptDesc"] = "Xem danh sách nhạc";
$string["yourClanOptDesc"] = "Xem clan \"%s\"";
$string["clanOptDesc"] = "Xem danh sách các clan";
$string["yourProfile"] = "Xem hồ sơ";
$string["profileOptDesc"] = "Xem hồ sơ của bạn";
$string["messengerOptDesc"] ="Mở tin nhắn";
$string["addSongOptDesc"] = "Thêm nhạc vào máy chủ";
$string["loginOptDesc"] = "Đăng nhập vào tài khoản";
$string["createAcc"] = "Tạo tài khoản";
$string["registerOptDesc"] = "Đăng ký trên %s";
$string["downloadOptDesc"] = "Tải xuống %s";

$string["tryCron"] = "Chạy Cron";
$string["cronSuccess"] = "Thành công!";
$string["cronError"] = "Lỗi!";

$string["profile"] = "Hồ sơ";
$string["empty"] = "Trống...";
$string["writeSomething"] = "Hãy viết thứ gì đó!";
$string["replies"] = "Trả lời";
$string["replyToComment"] = "Trả lời một bình luận";
$string["settings"] = "Cài đặt";
$string["allowMessagesFrom"] = "Cho phép tin nhắn từ...";
$string["allowFriendReqsFrom"] = "Cho phép yêu cầu kết bạn từ...";
$string["showCommentHistory"] = "Hiển thị lịch sử bình luận...";
$string["timezoneChoose"] = "Chọn múi giờ";
$string["yourYouTube"] = "Kênh YouTube của bạn";
$string["yourVK"] = "Trang của bạn trên VK";
$string["yourTwitter"] = "Trang của bạn trên Twitter";
$string["yourTwitch"] = "Kênh Twitch của bạn";
$string["saveSettings"] = "Lưu cài đặt";
$string["all"] = "Tất cả";
$string["friends"] = "Bạn bè";
$string["none"] = "Không có gì";
$string["youBlocked"] = "Người chơi này đã chặn bạn!";
$string["cantMessage"] = "Bạn không thể nhắn tin cho người chơi này!";
 
$string["accountManagement"] = "Quản lý tài khoản";
$string["changePassword"] = "Đổi mật khẩu";
$string["changeUsername"] = "Đổi tên người dùng";
$string["unlistedLevels"] = "Các level không công khai của bạn";

$string["manageSongs"] = "Quản lý nhạc";
$string["gauntletManage"] = "Quản lý Gauntlets";
$string["suggestLevels"] = "Level được đề xuất";

$string["modTools"] = "Công cụ mod";
$string["leaderboardBan"] = "Cấm người dùng";
$string["unlistedMod"] = "Các level không công khai";

$string["reuploadSection"] = "Reupload";
$string["songAdd"] = "Thêm nhạc";
$string["songLink"] = "Thêm nhạc bằng liên kết";
$string["packManage"] = "Quản lý Map Pack";

$string["browse"] = "Duyệt";
$string["statsSection"] = "Thống kê";
$string["dailyTable"] = "Các level hàng ngày";
$string["modActionsList"] = "Các hành động của mod";
$string["modActions"] = "Người điều hành máy chủ";
$string["gauntletTable"] = "Danh sách Gauntlets";
$string["packTable"] = "Danh sách các Map Pack";
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
$string["invalidUsername"] = "Tên người dùng không hợp lệ!";
$string["wrongNickOrPass"] = "Sai tên người dùng hoặc mật khẩu!";
$string["invalidid"] = "ID không hợp lệ!";
$string["loginBox"] = "Đăng nhập vào tài khoản";
$string["loginSuccess"] = "Bạn đăng nhập thành công vào tài khoản của mình!";
$string["loginAlready"] = "Bạn đã đăng nhập rồi!";
$string["clickHere"] = "Bảng điều khiển";
$string["enterUsername"] = "Nhập tên người dùng";
$string["enterPassword"] = "Nhập mật khẩu";
$string["loginDesc"] = "Tại đây bạn có thể đăng nhập vào tài khoản của mình!";

$string["register"] = "Đăng ký";
$string["registerAcc"] = "Đăng ký tài khoản";
$string["registerDesc"] = "Đăng ký tài khoản của bạn!";
$string["repeatpassword"] = "Nhập lại mật khẩu";
$string["email"] = "Email";
$string["repeatemail"] = "Nhập lại email";
$string["smallNick"] = "Tên người dùng quá ngắn!";
$string["smallPass"] = "Mật khẩu quá ngắn!";
$string["passDontMatch"] = "Mật khẩu không khớp!";
$string["emailDontMatch"] = "Email không khớp";
$string["registered"] = "Bạn đã đăng ký tài khoản thành công!";
$string["bigNick"] = "Tên người dùng quá dài!";
$string["mailExists"] = "Có tài khoản đã đăng ký sử dụng email này!";
$string["badUsername"] = "Vui lòng chọn tên người dùng khác.";

$string["changePassTitle"] = "Đổi mật khẩu";
$string["changedPass"] = "Mật khẩu đã được đổi thành công! Bạn cần đăng nhập lại vào tài khoản của mình.";
$string["wrongPass"] = "Sai mật khẩu!";
$string["samePass"] = "Mật khẩu bạn nhập vào giống nhau!";
$string["changePassDesc"] = "Tại đây bạn có thể thay đổi mật khẩu của mình!";
$string["oldPassword"] = "Mật khẩu cũ";
$string["newPassword"] = "Mật khẩu mới";
$string["confirmNew"] = "Xác nhận mật khẩu";

$string["forcePassword"] = "Buộc đổi mật khẩu";
$string["forcePasswordDesc"] = "Tại đây bạn có thể buộc thay đổi mật khẩu của người chơi!";
$string["forceNick"] = "Buộc đổi tên người dùng";
$string["forceNickDesc"] = "Tại đây bạn có thể buộc thay đổi tên người dùng của người chơi!";
$string["forceChangedPass"] = "Mật khẩu của <b>%s</b> đã được thay đổi thành công!";
$string["forceChangedNick"] = "Tên người dùng của <b>%s</b> đã được thay đổi thành công!";
$string["changePassOrNick"] = "Đổi tên người dùng hoặc mật khẩu của người chơi";

$string["changeNickTitle"] = "Đổi tên người dùng";
$string["changedNick"] = "Tên người dùng đã được thay đổi thành công! Bạn cần đăng nhập lại vào tài khoản của mình.";
$string["wrongNick"] = "Sai tên người dùng!";
$string["sameNick"] = "Tên người dùng bạn nhập vào giống nhau!";
$string["alreadyUsedNick"] = "Tên người dùng bạn nhập đã được sử dụng!";
$string["changeNickDesc"] = "Tại đây bạn có thể đổi tên người dùng của mình!";
$string["oldNick"] = "Tên người dùng cũ";
$string["newNick"] = " Tên người dùng mới";
$string["password"] = "Mật khẩu";

$string["packCreate"] = "Tạo Map Pack";
$string["packCreateTitle"] = "Tạo Map Pack";
$string["packCreateDesc"] = "Tại đây bạn có thể tạo Map Pack!";
$string["packCreateSuccess"] = "Bạn đã tạo thành công Map Pack có tên";
$string["packCreateOneMore"] = "Muốn tạo thêm một Map Pack nữa?";
$string["packName"] = "Tên Map Pack";
$string["color"] = "Màu";
$string["sameLevels"] = "Bạn đã chọn level giống nhau!";
$string["show"] = "Hiển thị";
$string["packChange"] = "Thay đổi Map Pack";
$string["createNewPack"] = "Tạo Map Pack mới!";

$string["gauntletCreate"] = "Tạo Gauntlets";
$string["gauntletCreateTitle"] = "Tạo Gauntlets";
$string["gauntletCreateDesc"] = "Tại đây bạn có thể tạo Gauntlets!";
$string["gauntletCreateSuccess"] = "Bạn đã tạo Gauntlet thành công!";
$string["gauntletCreateOneMore"] = "Muốn tạo thêm một Gauntlet nữa?";
$string["chooseLevels"] = "Chọn level!";
$string["checkbox"] = "Xác nhận";
$string["level1"] = "Level 1";
$string["level2"] = "Level 2";
$string["level3"] = "Level 3";
$string["level4"] = "Level 4";
$string["level5"] = "Level 5";
$string["gauntletChange"] = "Thay đổi Gauntlets";
$string["createNewGauntlet"] = "Tạo Gauntlets mới!";
$string["gauntletCreateSuccessNew"] = 'Bạn đã tạo thành công <b>%1$s</b>!';
$string["gauntletSelectAutomatic"] = "Tự động chọn Gauntlet";

$string["addQuest"] = "Thêm nhiệm vụ";
$string["addQuestDesc"] = "Tại đây bạn có thể tạo một nhiệm vụ!";
$string["questName"] = "Tên nhiệm vụ";
$string["questAmount"] = "Số tiền bắt buộc";
$string["questReward"] = "Phần thưởng";
$string["questCreate"] = "Tạo nhiệm vụ";
$string["questsSuccess"] = "Bạn đã tạo nhiệm vụ thành công";
$string["invalidPost"] = "Dữ liệu không hợp lệ!";
$string["fewMoreQuests"] = "Nên tạo thêm một vài nhiệm vụ nữa.";
$string["oneMoreQuest?"] = "Muốn tạo thêm một nhiệm vụ nữa?";
$string["changeQuest"] = "Thay đổi nhiệm vụ";
$string["createNewQuest"] = "Tạo nhiệm vụ mới!";

$string["levelReupload"] = "Tải lên lại level";
$string["levelReuploadDesc"] = "Tại đây bạn có thể tải lên lại level từ bất kỳ máy chủ nào!";
$string["advanced"] = "Tùy chọn nâng cao";
$string["errorConnection"] = "Lỗi kết nối!";
$string["levelNotFound"] = "level này không tồn tại!";
$string["robtopLol"] = "RobTop không thích bạn :c";
$string["sameServers"] = "Máy chủ chính và máy chủ đích giống nhau!";
$string["levelReuploaded"] = "Đã tải lại level! ID level:";
$string["oneMoreLevel?"] = "Muốn đăng lại một level nữa?";
$string["levelAlreadyReuploaded"] = "Level đã được tải lên lại!";
$string["server"] = "Máy chủ";
$string["levelID"] = "ID Level";
$string["pageDisabled"] = "Trang này bị vô hiệu hóa!";

$string["activateAccount"] = "Kích hoạt tài khoản";
$string["activateDesc"] = "Kích hoạt tài khoản của bạn!";
$string["activated"] = "Tài khoản của bạn đã được kích hoạt thành công!";
$string["alreadyActivated"] = "Tài khoản của bạn đã được kích hoạt rồi";
$string["maybeActivate"] = "Có thể bạn chưa kích hoạt tài khoản của mình.";
$string["activate"] = "Kích hoạt";
$string["activateDisabled"] = "Kích hoạt tài khoản bị vô hiệu hóa!";

$string["addMod"] = "Thêm người điều hành";
$string["addModDesc"] = "Tại đây bạn có thể cấp quyền cho người điều hành!";
$string["modYourself"] = "Bạn không thể cấp cho mình người điều hành!";
$string["alreadyMod"] = "Người chơi này đã là người điều hành!";
$string["addedMod"] = "Bạn đã cấp thành công người điều hành cho người chơi";
$string["addModOneMore"] = "Thêm một người điều hành nữa?";
$string["modAboveYourRole"] = "Bạn đang cố gắng giao một vai trò cao hơn vai trò của mình!";
$string["makeNewMod"] = "Chỉ định ai đó làm người điều hành!";
$string["reassignMod"] = "Chỉ định lại người điều hành";
$string["reassign"] = "Phân công lại";
$string['demotePlayer'] = "Hạ chức người chơi";
$string['demotedPlayer'] = "Bạn đã hạ chức thành công người chơi <b>%s</b>!";
$string['addedModNew'] = "Bạn đã chức thành công người điều hành cho người chơi <b>%s</b>!";
$string['demoted'] = 'Đã bị hạ chức';

$string["shareCPTitle"] = "Chia sẻ điểm của người sáng tạo";
$string["shareCPDesc"] = "Tại đây bạn có thể chia sẻ Điểm sáng tạo với người chơi!";
$string["shareCP"] = "Chia sẻ";
$string["alreadyShared"] = "Level này đã chia sẻ CP cho người chơi này!";
$string["shareToAuthor"] = "Bạn đã cố chia sẻ CP với tác giả level!";
$string["userIsBanned"] = "Người chơi này bị cấm!";
$string["shareCPOneMore"] = "Thêm một lần chia sẻ?";
$string['shareCPSuccessNew'] = 'Bạn đã chia sẻ thành công Điểm người sáng tạo ở level <b>%1$s</b> tới người chơi <b>%2$s</b>!';

$string["messenger"] = "Tin Nhắn";
$string["write"] = "Viết";
$string["send"] = "Gửi";
$string["noMsgs"] = "Hộp thoại bắt đầu!";
$string["subject"] = "Chủ đề";
$string["msg"] = "Tin nhắn";
$string["tooFast"] = "Bạn đang gõ quá nhanh!";
$string["messengerYou"] = "Bạn:";
$string["chooseChat"] = "Chọn chat";

$string["levelToGD"] = "Tải lại level lên máy chủ đích";
$string["levelToGDDesc"] = "Tại đây bạn có thể tải lại level của mình lên máy chủ đích!";
$string["usernameTarget"] = "Tên người dùng cho máy chủ đích";
$string["passwordTarget"] = "Mật khẩu cho máy chủ đích";
$string["notYourLevel"] = "Đây không phải là level của bạn!";
$string["reuploadFailed"] = "Lỗi tải lên lại level!";

$string["search"] = "Tìm kiếm...";
$string["searchCancel"] = "Hủy tìm kiếm";
$string["emptySearch"] = "Không tìm thấy gì!";

$string["approve"] = 'Phê duyệt';
$string["deny"] = 'Từ chối';
$string["submit"] = 'Gửi';
$string["place"] = 'Vị trí';
$string["add"] = 'Thêm';
$string["demonlistLevel"] = '%s <text class="dltext">bởi <button type="button" onclick="a(\'profile/%3$s\', true, true)" style= "font-size:25px" class="accbtn" name="accountID" value="%d">%s</button>%4$s</text>';

$string["didntActivatedEmail"] = 'Bạn chưa kích hoạt tài khoản của mình qua email!';
$string["checkMail"] = 'Bạn nên kiểm tra email của mình...';

$string["likeSong"] = "Thêm nhạc vào mục yêu thích";
$string["dislikeSong"] = "Xóa nhạc khỏi mục yêu thích";
$string["favouriteSongs"] = "Nhạc yêu thích";
$string["howMuchLiked"] = "Bao nhiêu lượt thích?";
$string["nooneLiked"] = "Không ai thích";

$string["clan"] = "Clan";
$string["joinedAt"] = "Đã gia nhập clan: <b>%s</b>";
$string["createdAt"] = "Đã tạo clan: <b>%s</b>";
$string["clanMembers"] = "Thành viên clan";
$string["noMembers"] = "Không có thành viên nào";
$string["clanOwner"] = "Chủ clan";
$string["noClanDesc"] = "<i>Không có mô tả</i>";
$string["noClan"] = "Clan này không tồn tại!";
$string["clanName"] = "Tên clan";
$string["clanTag"] = "Thẻ clan (3-5 ký tự)";
$string["clanDesc"] = "Mô tả clan";
$string["clanColor"] = "Màu clan";
$string["dangerZone"] = "Khu vực nguy hiểm";
$string["giveClan"] = "Chuyển clan";
$string["deleteClan"] = "Xóa clan";
$string["goBack"] = "Quay lại";
$string["areYouSure"] = "Bạn có chắc chức?";
$string["giveClanDesc"] = "Tại đây bạn có thể trao clan của mình cho một người chơi.";
$string["notInYourClan"] = "Người chơi này không thuộc clan của bạn!";
$string["givedClan"] = "Bạn đã trao thành công clan của mình cho <b>%s</b>!";
$string["deletedClan"] = "Bạn đã xóa clan <b>%s</b>.";
$string["deleteClanDesc"] = "Tại đây bạn có thể xóa clan của mình.";
$string["yourClan"] = "Clan của bạn";
$string["members0"] = "<b>1</b> thành viên";
$string["members1"] = "<b>%d</b> thành viên";
$string["members2"] = "<b>%d</b> thành viên";
$string["noRequests"] = "Không có yêu cầu nào. Thư giãn đi!";
$string["pendingRequests"] = "Yêu cầu vào clan";
$string["closedClan"] = "Clan đã đóng";
$string["kickMember"] = "Kick thành viên";
$string["leaveFromClan"] = "Rời khỏi clan";
$string["askToJoin"] = "Gửi yêu cầu tham gia";
$string["removeClanRequest"] = "Xóa yêu cầu tham gia";
$string["joinClan"] = "Tham gia clan";
$string["noClans"] = "Không có clan nào";
$string["clans"] = "Clans";
$string["alreadyInClan"] = "Bạn đã ở trong clan!";
$string["createClan"] = "Tạo clan";
$string["createdClan"] = "Bạn đã tạo thành công clan <span style='font-weight:700;color:#%s'>%s</span>!";
$string["createClanDesc"] = "Tại đây bạn có thể tạo clan!";
$string["create"] = "Tạo";
$string["mainSettings"] = "Cài đặt chính";
$string["takenClanName"] = "Tên clan này đã được sử dụng!";
$string["takenClanTag"] = "Thẻ clan này đã được sử dụng!";
$string["badClanName"] = "Vui lòng hãy chọn tên clan khác.";
$string["badClanTag"] = "Vui lòng hãy chọn tên clan khác.";

$string["suggestedName"] = '<button type="button" onclick="a(\'profile/%1$s\', true, true)" class="accbtn" name="accountID">%1 $s</button><text class="dltext"> đã đề xuất <b>%4$s%3$s</b> cho</text><text class="levelname">%2$s</text >';
$string["reportedName"] = '%1$s<text class="dltext"> đã được báo cáo</text><text class="levelname">%2$s</text>';

$string['listTable'] = "Danh sách";
$string['listTableMod'] = "Danh sách không công khai";
$string['listTableYour'] = "Danh sách không công khai của bạn";

$string['forgotPasswordChangeTitle'] = "Đổi mật khẩu";
$string["successivelyChangedPass"] = "Mật khẩu đã được thay đổi thành công!";
$string['forgotPasswordTitle'] = "Quên mật khẩu?";
$string['maybeSentAMessage'] = "Chúng tôi sẽ gửi tin nhắn cho bạn nếu tài khoản này tồn tại.";
$string['forgotPasswordDesc'] = "Tại đây bạn có thể yêu cầu liên kết thay đổi mật khẩu nếu bạn quên!";
$string['forgotPasswordButton'] = "Yêu cầu liên kết";

$string['sfxAdd'] = "Thêm SFX";
$string["sfxAddError-5"] = "Kích thước của SFX lớn hơn $SFXsize megabyte!";
$string["sfxAddError-6"] = "Đã xảy ra lỗi khi tải lên SFX!";
$string["sfxAddError-7"] = "Bạn chỉ có thể tải lên âm thanh!";
$string['sfxAdded'] = 'Đã thêm SFX';
$string['yourNewSFX'] = "Nghe thử SFX mới của bạn!";
$string["sfxAddAnotherBTN"] = "Muốn tải lên một SFX nữa?";
$string["sfxAddDesc"] = "Tại đây bạn có thể thêm SFX của mình!";
$string["chooseSFX"] = "Chọn SFX";
$string["sfxAddNameFieldPlaceholder"] = "Tên";
$string['sfxs'] = 'SFX';
$string['sfxID'] = 'SFX ID';
$string['manageSFX'] = 'Quản lý SFX';

$string['featureLevel'] = 'Level nổi bật';

$string['banList'] = 'Danh sách người bị cấm';
$string['expires'] = 'Hết hạn';
$string['unbanPerson'] = 'Bỏ cấm';
$string['IP'] = 'Địa chỉ IP';
$string['noBanInPast'] = 'Bạn không thể cấm đến quá khứ!';
$string['banSuccess'] = 'Bạn đã cấm thành công <b>%1$s</b> cho đến <b>%3$s</b> trong «<b>%2$s</b>»! ';
$string['person'] = 'Người';
$string['youAreBanned'] = 'Bạn đã bị cấm cho đến <b>%2$s</b> vì lý do:<br><b>%1$s</b>';
$string['banChange'] = 'Thay đổi';
$string['system'] = 'Hệ thống';

$string['levelComments'] = 'Level comments';
$string['levelLeaderboards'] = 'Bảng xếp hạng level';
$string['manageLevel'] = 'Quản lý level';
$string['noComments'] = 'Không có comment nào!';
$string['commentHere'] = 'Đăng comment...';
$string['weekLeaderboards'] = 'Trong một tuần';
$string['noLeaderboards'] = 'Không có bảng xếp hạng!';
$string['manageLevelDesc'] = 'Ở đây bạn có thể thay đổi level!';
$string['silverCoins'] = 'Xu bạc';
$string['unlistedLevel'] = 'Level không công khai';
$string['lockUpdates'] = 'Khóa cập nhật';
$string['lockCommenting'] = 'Khóa comment';
$string['successfullyChangedLevel'] = 'Bạn đã thay đổi level thành công!';
$string['successfullyDeletedLevel'] = 'Bạn đã xóa level thành công!';

$string['resendMailTitle'] = 'Gửi lại tin nhắn email';
$string['resendMailHint'] = 'Không nhận được tin nhắn?';
$string['resendMailDesc'] = 'Tại đây bạn có thể gửi lại email nếu bạn không nhận được tin nhắn!';
$string['resendMailButton'] = 'Gửi tin nhắn';

$string['automodTitle'] = 'Automod';
$string['possibleLevelsSpamming'] = 'Có thể là spam level';
$string['disableLevelsUploading'] = 'Tắt chức năng tải lên level';
$string['possibleAccountsSpamming'] = 'Có thể là các tài khoản spam';
$string['disableAccountsRegistering'] = 'Tắt chức năng đăng ký tài khoản';
$string['possibleCommentsSpamming'] = 'Có thể là các bình luận spam';
$string['disableComments'] = 'Tắt chức năng bình luận';
$string['similarCommentsCount'] = 'Số lượng bình luận tương tự';
$string['similarityValueOfAllComments'] = 'Nội dung tương tự trong số tất cả các bình luận';
$string['possibleCommentsSpammer'] = 'Có thể là người spam bình luận';
$string['banCommenting'] = 'Cấm bình luận';
$string['spammerUsername'] = 'Tên người dùng của người gửi thư rác';
$string['possibleAccountPostsSpamming'] = 'Có thể tài khoản đang gửi thư rác';
$string['disablePosting'] = 'Tắt chức năng đăng bài';
$string['similarPostsCount'] = 'Số lượng bài đăng tương tự';
$string['similarityValueOfAllPosts'] = 'Nội dung tương tự trong số tất cả các bài đăng';
$string['possibleAccountPostsSpammer'] = 'Có thể tài khoản đang gửi thư rác';
$string['possibleRepliesSpamming'] = 'Có thể trả lời thư rác';
$string['possibleRepliesSpammer'] = 'Có thể là người spam trở lời';
$string['similarRepliesCount'] = 'Số lượng trả lời tương tự';
$string['similarityValueOfAllReplies'] = 'Nội dung tương tự trong tất cả các phản hồi';
$string['unknownWarning'] = 'Cảnh báo không xác định';
$string['before'] = 'Trước';
$string['after'] = 'Sau';
$string['compare'] = 'So sánh';
$string['resolvedWarning'] = 'Cảnh báo đã giải quyết';
$string['resolveWarning'] = 'Giải quyết cảnh báo';
$string['enabled'] = 'Đã bật';
$string['disabled'] = 'Đã tắt';
$string['yesterday'] = 'Hôm qua';
$string['today'] = 'Hôm nay';
$string['uploading'] = 'Đang tải lên';
$string['commenting'] = 'Đang bình luận';
$string['leaderboardSubmits'] = 'Gửi bảng xếp hạng';
$string['manageLevels'] = 'Quản lý level';
$string['disableLevelsUploading'] = 'Tắt chức năng tải lên level';
$string['disableLevelsCommenting'] = 'Tắt chức năng bình luận level';
$string['disableLevelsLeaderboardSubmits'] = 'Tắt chức năng gửi bảng xếp hạng level';
$string['disable'] = 'Tắt';
$string['enable'] = 'Bật';
$string['registering'] = 'Đang đăng ký';
$string['accountPosting'] = 'Tạo bài đăng tài khoản';
$string['updatingProfileStats'] = 'Đang cập nhật số liệu thống kê hồ sơ';
$string['messaging'] = 'Nhắn tin';
$string['manageAccounts'] = 'Quản lý tài khoản';
$string['disableAccountsRegistering'] = 'Tắt chức năng đăng ký tài khoản mới';
$string['disableAccountPosting'] = 'Tắt chức năng đăng bài viết cho tài khoản';
$string['disableUpdatingProfileStats'] = 'Tắt chức năng cập nhật số liệu thống kê cho hồ sơ';
$string['disableMessaging'] = 'Tắt chức năng nhắn tin';

$string['cantPostCommentsAboveChars'] = 'Bạn không thể đăng bình luận có độ dài trên %1$s ký tự!';
$string['replyingIsDisabled'] = 'Hiện tại, chức năng trả lời bình luận đã bị tắt!';
$string['youAreBannedFromCommenting'] = 'Bạn đã bị cấm bình luận!';
$string['cantPostAccountCommentsAboveChars'] = 'Bạn không thể đăng bình luận có độ dài trên %1$s ký tự!';
$string['commentingIsDisabled'] = 'Hiện tại, chức năng bình luận đã bị tắt!';
$string['noWarnings'] = 'Không có cảnh báo';
$string['messagingIsDisabled'] = 'Tin nhắn trực tiếp đang bị vô hiệu hóa!';

$string['downloadLevelAsGMD'] = 'Lưu dưới dạng .gmd';

$string['songIsAvailable'] = 'Có sẵn';
$string['songIsDisabled'] = 'Không có sẵn';
$string['disabledSongs'] = 'Nhạc bị vô hiệu hóa';
$string['disabledSFXs'] = 'SFX bị vô hiệu hóa';

$string['vaultCodesTitle'] = 'Thêm mã vault';
$string['vaultCodeExists'] = 'Mã có tên này đã tồn tại!';
$string['reward'] = 'Phần thưởng';
$string['vaultCodePickOption'] = 'Chọn loại phần thưởng';
$string['vaultCodesCreate'] = 'Tạo mã';
$string['createNewVaultCode'] = 'Tạo mã mới!';
$string['vaultCodesDesc'] = 'Tại đây bạn có thể tạo mã mới!';
$string['vaultCodesEditTitle'] = 'Thay đổi mã vault';
$string['vaultCodesEditDesc'] = 'Tại đây bạn có thể thay đổi mã hiện có!';
$string['vaultCodeName'] = 'Mã';
$string['vaultCodeUses'] = 'Số lần sử dụng (0 cho số lần sử dụng vô hạn)';
$string['editRewards'] = 'Thay đổi phần thưởng';
$string['rewards'] = 'Phần thưởng';

$string['alsoBanIP'] = 'Cũng là cấm IP';

/*
TẢI LẠI
*/

$string["reuploadBTN"] = "Tải lên";
$string["errorGeneric"] = "Đã xảy ra lỗi!";
$string["smthWentWrong"] = "Đã có lỗi xảy ra!";
$string["tryAgainBTN"] = "Thử lại";
//songAdd.php
$string["songAddDesc"] = "Tại đây bạn có thể thêm nhạc của mình!";
$string["songAddUrlFieldLabel"] = "URL nhạc: (Chỉ liên kết trực tiếp hoặc Dropbox)";
$string["songAddUrlFieldPlaceholder"] = "URL nhạc";
$string["songAddNameFieldPlaceholder"] = "Tên";
$string["songAddAuthorFieldPlaceholder"] = "Tác giả";
$string["songAddButton"] = "Chọn nhạc";
$string["songAddAnotherBTN"] = "Tải lên một bài khác?";
$string["songAdded"] = "Đã thêm nhạc!";
$string["deletedSong"] = "Bạn đã xóa nhạc thành công";
$string["songID"] = "ID nhạc: ";
$string["songIDw"] = "ID nhạc";
$string["songAuthor"] = "Tác giả";
$string["size"] = "Dung lượng";
$string["detele"] = "Xóa";
$string["change"] = "Thay đổi";
$string["chooseFile"] = "Chọn một bài nhạc";
$string['yourNewSong'] = "Hãy nghe thử bài nhạc mới của bạn!";
///lỗi
$string["songAddError-2"] = "URL không hợp lệ";
$string["songAddError-3"] = "Nhạc này đã được tải lên lại với ID:";
$string["songAddError-4"] = "Không thể tải lại bài nhạc này lên";
$string["songAddError-5"] = "Dung lượng nhạc lớn hơn $songSize megabyte";
$string["songAddError-6"] = "Đã xảy ra lỗi khi tải bài nhạc lên! :с";
$string["songAddError-7"] = "Bạn chỉ có thể tải lên âm thanh!";

$string[400] = "Yêu cầu không hợp lệ!";
$string["400!"] = "Kiểm tra trình điều khiển phần cứng mạng của bạn.";
$string[403] = "Bị cấm!";
$string["403!"] = "Bạn không có quyền truy cập vào trang này!";
$string[404] = "Không tìm thấy trang!";
$string["404!"] = "Bạn có chắc là mình đã nhập địa chỉ chính xác không?";
$string[500] = "Lỗi máy chủ nội bộ!";
$string["500!"] = "Người viết mã đã mắc lỗi trong mã,</br>
hãy báo cáo về vấn đề này tại đây:</br>
https://github.com/Cvolton/GMDprivateServer/pull/883";
$string[502] = "Máy chủ ngừng hoạt động!";
$string["502!"] = "Máy chủ đang bị quá tải.</br>
Hãy quay lại sau trong vòng vài giờ!";

$string["invalidCaptcha"] = "Phản hồi Captcha không hợp lệ!";
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
$string["levels"] = "Levels";
$string["songs"] = "Nhạc";
$string["author"] = "Người tạo";
$string["name"] = "Tên";
$string["date"] = "Ngày";
$string["type"] = "Loại";
$string["reportCount"] = "Số lượng báo cáo";
$string["reportMod"] = "Báo cáo";
$string["username"] = "Tên người dùng";
$string["accountID"] = "ID tài khoản";
$string["registerDate"] = "Ngày đăng ký";
$string["isAdminYes"] = "Có";
$string["isAdminNo"] = "Không";
$string["userCoins"] = "Xu của người dùng";
$string["time"] = "Thời gian";
$string["deletedLevel"] = "Level đã xóa";
$string["mod"] = "Người điều hành";
$string["count"] = "Số lượng hành động";
$string["ratedLevels"] = "Level đã đánh giá";
$string["lastSeen"] = "Lần cuối trực tuyến";
$string["level"] = "level";
$string["pageInfo"] = "Hiển thị trang %s của %s";
$string["first"] = "Đầu tiên";
$string["previous"] = "Trước";
$string["next"] = "Tiếp";
$string["never"] = "Không bao giờ";
$string["last"] = "Cuối cùng";
$string["go"] = "Đi";
$string["levelid"] = "ID level";
$string["levelname"] = "Tên level";
$string["leveldesc"] = "Mô tả level";
$string["noDesc"] = "Không có mô tả";
$string["levelpass"] = "Mật khẩu";
$string["nopass"] = "Không có mật khẩu";
$string["unrated"] = "Chưa được xếp hạng";
$string["rate"] = "Đánh giá";
$string["stats"] = "Thống kê";
$string["suggestFeatured"] = "Featured?";
$string["whoAdded"] = "Ai đã thêm?";
$string["moons"] = "Mặt trăng";

$string["banDesc"] = "Tại đây bạn có thể cấm một người chơi!";
$string["playerTop"] = 'Người chơi hàng đầu';
$string["creatorTop"] = 'Người sáng tạo hàng đầu';
$string["levelUploading"] = 'Đang tải lên các level';
$string["successivelyBanned"] = 'Người chơi <b>%1$s</b> có ID tài khoản <b>%2$s</b> đã bị cấm thành công!';
$string["successivelyUnbanned"] = 'Người chơi <b>%1$s</b> có ID tài khoản <b>%2$s</b> đã được bỏ cấm thành công!';
$string["commentBan"] = 'Đang bình luận';

$string["player"] = "Người chơi";

$string["starsLevel2"] = "sao";
$string["starsLevel1"] = "sao";
$string["starsLevel0"] = "sao";
$string["coins1"] = "xu";
$string["coins0"] = "xu";
$string["unban"] = "Bỏ cấm";
$string["isBan"] = "Cấm";

$string["noCoins"] = "Không có xu";
$string["noReason"] = "Không có lý do nào";
$string["noActions"] = "Không có hành động nào";
$string["noRates"] = "Không có đánh giá";

$string["future"] = "Future";

$string["spoiler"] = "Spoiler";
$string["accid"] = "với ID tài khoản";
$string["banned"] = "đã bị cấm thành công!";
$string["unbanned"] = "đã được bỏ cấm thành công!";
$string["ban"] = "Cấm";
$string["nothingFound"] = "Người chơi này không tồn tại!";
$string["banUserID"] = "Tên người dùng hoặc ID tài khoản";
$string["banUserPlace"] = "Cấm người dùng";
$string["banYourself"] = "Bạn không thể cấm chính mình!";
$string["banYourSelfBtn!"] = "Cấm người khác";
$string["banReason"] = "Lý do cấm";
$string["action"] = "Hành động";
$string["value"] = "Giá trị 1";
$string["value2"] = "Giá trị 2";
$string["value3"] = "Giá trị 3";
$string["modAction1"] = "Đánh giá một level";
$string["modAction2"] = "Bỏ/đặt nổi bật một level";
$string["modAction3"] = "Bỏ/xác minh xu";
$string["modAction4"] = "Bỏ/đặt epic cho một level";
$string["modAction5"] = "Đặt làm tính năng hàng ngày";
$string["modAction6"] = "Xóa một level";
$string["modAction7"] = "Thay đổi người tạo";
$string["modAction8"] = "Đổi tên một level";
$string["modAction9"] = "Thay đổi mật khẩu level";
$string["modAction10"] = "Thay đổi độ khó demon";
$string["modAction11"] = "Chia sẻ CP";
$string["modAction12"] = "Bỏ/công khai level";
$string["modAction13"] = "Thay đổi mô tả level";
$string["modAction14"] = "Bật/tắt LDM";
$string["modAction15"] = "Bỏ cấm/cấm bảng xếp hạng";
$string["modAction16"] = "Thay đổi ID nhạc";
$string["modAction17"] = "Tạo một Map Pack";
$string["modAction18"] = "Tạo một Gauntlet";
$string["modAction19"] = "Thay đổi nhạc";
$string["modAction20"] = "Cấp quyền người điều hành cho người chơi";
$string["modAction21"] = "Thay đổi Map Pack";
$string["modAction22"] = "Thay đổi Gauntlet";
$string["modAction23"] = "Thay đổi nhiệm vụ";
$string["modAction24"] = "Phân công lại một người chơi";
$string["modAction25"] = "Tạo một nhiệm vụ";
$string["modAction26"] = "Thay đổi tên người dùng/mật khẩu của người chơi";
$string["modAction27"] = "Thay đổi SFX";
$string["modAction28"] = "Người đã bị cấm";
$string["modAction29"] = "Khóa/Bỏ khóa cập nhật level";
$string["modAction30"] = "Đánh giá danh sách";
$string["modAction31"] = "Gửi danh sách";
$string["modAction32"] = "Bỏ/đặt nổi bật danh sách";
$string["modAction33"] = "Bỏ/công khai danh sách";
$string["modAction34"] = "Xóa danh sách";
$string["modAction35"] = "Thay đổi người tạo danh sách";
$string["modAction36"] = "Thay đổi tên danh sách";
$string["modAction37"] = "Thay đổi mô tả danh sách";
$string["modAction38"] = "Khóa/Bỏ khóa level comment";
$string["modAction39"] = "Khóa/Bỏ khóa danh sách comment";
$string["modAction40"] = "Đã xóa level đã gửi";
$string["modAction41"] = "Level được đề xuất";
$string["modAction42"] = "Đã tạo mã vault";
$string["modAction43"] = "Mã vault đã thay đổi";
$string["modAction44"] = "Đặt level làm level sự kiện";
$string["everyActions"] = "Mọi hành động";
$string["everyMod"] = "Tất cả người kiểm duyệt";
$string["Kish!"] = "Đi đi!";
$string["noPermission"] = "Bạn không có quyền!";
$string["noLogin?"] = "Bạn chưa đăng nhập vào tài khoản của mình!";
$string["LoginBtn"] = "Đăng nhập vào tài khoản";
$string["dashboard"] = "Bảng điều khiển";
$string["userID"] = 'ID Người dùng';