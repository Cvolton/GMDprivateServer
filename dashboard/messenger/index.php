<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require_once "../incl/XOR.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/automod.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$dl = new dashboardLib();
$gs = new mainLib();
$xor = new XORCipher();
$dl->printFooter('../');
if(!isset($_POST["receiver"])) {
	$getID = str_replace('%20', ' ', explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-1]);
	$receiver = ExploitPatch::charclean($getID);
	if(!empty($receiver)) {
		if(is_numeric($receiver)) $_POST["receiver"] = ExploitPatch::number($receiver);
		else $_POST["receiver"] = $gs->getAccountIDFromName(ExploitPatch::charclean($receiver));
	}
}
$allChats = '<div class="empty-section">
	<i class="fa-solid fa-comment-slash"></i>
</div>';
$allChatsEmpty = true;
$friendsChats = '<div class="empty-section">
	<i class="fa-solid fa-face-sad-cry"></i>
</div>';
$friendsChatsEmpty = true;
$alertScript = '';
$chatBox = '<div class="empty-section">
	<i class="fa-solid fa-comments"></i>
	<p>'.$dl->getLocalizedString('chooseChat').'</p>
</div>';
$pageScript = 'function friendsList() {
	if(window.currentMessengerTab == "chats") {
		document.getElementById("lastChats").classList.add("hide");
		document.getElementById("friendsChats").classList.remove("hide");
		window.currentMessengerTab = "friends";
		if(friendsChatsEmpty) document.getElementById("itemoverflow").classList.add("empty-itemoverflow");
		else document.getElementById("itemoverflow").classList.remove("empty-itemoverflow");
	} else {
		document.getElementById("lastChats").classList.remove("hide");
		document.getElementById("friendsChats").classList.add("hide");
		window.currentMessengerTab = "chats";
		if(allChatsEmpty) document.getElementById("itemoverflow").classList.add("empty-itemoverflow");
		else document.getElementById("itemoverflow").classList.remove("empty-itemoverflow");
	}
}';
if($msgEnabled == 0) {
	$dl->title($dl->getLocalizedString("messenger"));
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("pageDisabled").'</p>
		<button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>', 'msg'));
}
if(!isset($_SESSION["accountID"]) || $_SESSION["accountID"] == 0) {
	$dl->title($dl->getLocalizedString("messenger"));
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="./login/login.php">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
		<button type="button" onclick="a(\'login/login.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
		</form>
	</div>', 'msg'));
}
if($_POST['receiver'] != 0 && ExploitPatch::number($_POST['receiver']) != $_SESSION['accountID'] && !empty($gs->getAccountName(ExploitPatch::number($_POST['receiver'])))) {
	$receiver = ExploitPatch::number($_POST['receiver']);
	$receiverUsername = $gs->getAccountName($receiver);
	if(isset($_POST['subject']) && isset($_POST['body'])) {
		$checkBan = $gs->getPersonBan($_SESSION['accountID'], $gs->getUserID($_SESSION['accountID']), 3);
		if($checkBan) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" action="" method="post">
			<p id="dashboard-error-text">'.sprintf($dl->getLocalizedString("youAreBanned"), htmlspecialchars(base64_decode($checkBan['reason'])), date("d.m.Y G:i", $checkBan['expires'])).'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>'));
		$subject = ExploitPatch::url_base64_encode(trim(ExploitPatch::rucharclean($_POST["subject"])));
		$body = ExploitPatch::rucharclean($_POST["body"]);
		if(Automod::isAccountsDisabled(3)) {
			$alertScript = $dl->getLocalizedString('messagingIsDisabled');
			$subject = $body = "";
		}
		if(is_numeric(mb_substr($body, -3)) && !is_numeric(mb_substr($body, -4))) $body .= ' ';
		$body = base64_encode(trim($xor->cipher($body, 14251)));
        $query = $db->prepare("SELECT timestamp FROM messages WHERE accID = :accountID AND toAccountID = :toAccountID ORDER BY timestamp DESC LIMIT 1");
        $query->execute([':accountID' => $_SESSION['accountID'], ':toAccountID' => $receiver]);
        $res = $query->fetch();
        $time = time() - 3;
        if($res["timestamp"] > $time) {
			$alertScript = $dl->getLocalizedString("tooFast");
			$subject = $body = "";
		}
		$privacySettings = $db->prepare("SELECT mS FROM accounts WHERE accountID = :receiver");
		$privacySettings->execute([':receiver' => $receiver]);
		$privacySettings = $privacySettings->fetchColumn();
		$block = $db->prepare("SELECT count(*) FROM blocks WHERE (person1 = :receiver AND person2 = :accountID) OR (person2 = :receiver AND person1 = :accountID)");
        $block->execute([':receiver' => $receiver, ':accountID' => $_SESSION['accountID']]);
        $block = $block->fetchColumn();
		if(($privacySettings == 1 && !$gs->isFriends($receiver, $_SESSION["accountID"])) || $privacySettings == 2 || $block > 0) {
			$alertScript = $dl->getLocalizedString("cantMessage");
			$subject = $body = "";
		}
		if(!empty($subject) && !empty($body) && !empty($receiverUsername)) {
			$query = $db->prepare("INSERT INTO messages (userID, userName, body, subject, accID, toAccountID, timestamp, secret, isNew)
			VALUES (:userID, :userName, :body, :subject, :accountID, :receiver, :time, 'Wmfd2893gb7', '0')");
			$query->execute([':userID' => $gs->getUserID($_SESSION['accountID']), ':userName' => $gs->getAccountName($_SESSION['accountID']), ':body' => $body, ':subject' => $subject, ':accountID' => $_SESSION['accountID'], ':receiver' => $receiver, 'time' => time()]);
		}
	}
	if($_POST['deleteMessage']) {
		$deleteMessageID = ExploitPatch::number($_POST['deleteMessage']);
		$messageCheck = $db->prepare("SELECT count(*) FROM messages WHERE toAccountID = :receiver AND accID = :accountID AND messageID = :messageID");
		$messageCheck->execute([':receiver' => $receiver, ':accountID' => $_SESSION['accountID'], ':messageID' => $deleteMessageID]);
		$messageCheck = $messageCheck->fetchColumn();
		if($messageCheck) {
			$deleteMessage = $db->prepare("DELETE FROM messages WHERE messageID = :messageID");
			$deleteMessage->execute([':messageID' => $deleteMessageID]);
		}
	}
	$query = $db->prepare("SELECT * FROM messages WHERE (accID = :accountID AND toAccountID = :receiver) OR (accID = :receiver AND toAccountID = :accountID) ORDER BY timestamp ASC");
	$query->execute([':accountID' => $_SESSION['accountID'], ':receiver' => $receiver]);
	$result = $query->fetchAll();
	foreach($result AS &$messages) {
        $div = $messages["accID"] == $_SESSION['accountID'] ? 'you' : 'notyou';
		$subject = htmlspecialchars(ExploitPatch::url_base64_decode($messages["subject"]));
		$body = $dl->parseMessage(htmlspecialchars($xor->plaintext(ExploitPatch::url_base64_decode($messages["body"]), 14251)));
		$replyToMessageButton = $deleteMessageButton = $wasReadIcon = '';
		if($div == 'notyou') $replyToMessageButton = '<button class="btn-circle" onclick="replyToMessage('.$messages['messageID'].')"><i class="fa-solid fa-reply"></i></button>';
		else {
			$deleteMessageButton = '<button class="btn-circle" onclick="deleteMessage('.$messages['messageID'].')"><i class="fa-solid fa-trash"></i></button>';
			$wasReadIcon = ' <text>•</text> <i class="fa-solid fa-check'.($messages['readTime'] ? '-double" title="'.$dl->convertToDate($messages['readTime'], true) : '').'"></i>';
		}
		$chatMessages .= '<div class="message '.$div.'">
			'.$deleteMessageButton.'
			<div class="messenger'.$div.'">
				<h2 id="messageSubject'.$messages['messageID'].'" class="subject'.$div.'">'.$subject.'</h2>
				<h3 class="message'.$div.'">'.$body.'</h3>
				<h3 class="comments" style="justify-content:flex-end">'.$dl->convertToDate($messages["timestamp"], true).$wasReadIcon.'</h3>
			</div>
			'.$replyToMessageButton.'
		</div>';
	}
	if(empty($chatMessages)) $chatMessages = '<div class="empty-section">
		<i class="fa-solid fa-comment"></i>
		<p>'.$dl->getLocalizedString('noMsgs').'</p>
	</div>';
	$readAllMessages = $db->prepare("UPDATE messages SET isNew = 1, readTime = :readTime WHERE accID = :receiver AND toAccountID = :accountID AND readTime = 0");
	$readAllMessages->execute([':receiver' => $receiver, ':accountID' => $_SESSION['accountID'], ':readTime' => time()]);
	$chatBox = '<div class="messenger-username">
        <button type="button" onclick="a(\'profile/'.$receiverUsername.'\', true, true, \'GET\')" class="goback" name="accountID" value="'.$receiver.'"><i class="fa-regular fa-user" aria-hidden="true"></i></button>
        <h1>'.$receiverUsername.'</h1>
        <button type="button" onclick="a(\'messenger/'.$receiverUsername.'\', true, true, \'GET\')" class="msgupd" name="accountID" value="'.$receiver.'"><i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i></button>
    </div>
	<div class=" form-control new-form-control dmbox list" id="chatMessages">'.$chatMessages.'</div>
	<form class="form__inner" method="post" action="">
		<div class="field"><input type="text" name="subject" id="chatSubject" placeholder="'.$dl->getLocalizedString("subject").'"></input></div>
		<div class="field"><input type="text" name="body" id="chatBody" placeholder="'.$dl->getLocalizedString("msg").'"></input></div>
		<input type="hidden" name="receiver" value="'.$receiver.'"></input>
		<input type="hidden" id="deleteMessage" name="deleteMessage" value="0"></input>
	<button type="button" onclick="a(\'messenger/'.$receiverUsername.'\', true, true, \'POST\')"; class="btn-primary btn-block" id="chatSubmit" disabled>'.$dl->getLocalizedString("send").'</button></form>';
	$dl->title($dl->getLocalizedString("messenger").", ".$receiverUsername);
	$pageScript .= PHP_EOL.'var element = document.getElementById("chatMessages");
		element.scrollTop = element.scrollHeight;
		var scrollAll = document.getElementById("chat-opened-all");
		if(scrollAll !== null) scrollAll.scrollIntoView();
		var scrollFriends = document.getElementById("chat-opened-friends");
		if(scrollFriends !== null) scrollFriends.scrollIntoView();
		$(document).on("keyup keypress change keydown", function() {
		   const p1 = document.getElementById("chatSubject");
		   const p2 = document.getElementById("chatBody");
		   const btn = document.getElementById("chatSubmit");
		   if(!p1.value.trim().length || !p2.value.trim().length) {
				btn.disabled = true;
				btn.classList.add("btn-block");
				btn.classList.remove("btn-primary");
			} else {
				btn.removeAttribute("disabled");
				btn.classList.remove("btn-block");
				btn.classList.remove("btn-size");
				btn.classList.add("btn-primary");
			}
		});
		function replyToMessage(messageID) {
			messageSubject = document.getElementById("messageSubject" + messageID).innerHTML;
			if(!messageSubject.startsWith("Re:")) messageSubject = "Re: " + messageSubject;
			document.getElementById("chatSubject").value = messageSubject;
			document.getElementById("chatBody").focus();
		}
		function deleteMessage(messageID) {
			document.getElementById("deleteMessage").value = messageID;
			a("messenger/'.$receiverUsername.'", true, true, "POST");
		}
		'.(!empty($alertScript) ? 'alert("'.$alertScript.'");' : '').'';
}
$query = $db->prepare("SELECT * FROM messages, (SELECT max(messageID) messageIDs, (CASE WHEN accID = :accountID THEN toAccountID ELSE accID END) receiverID FROM messages WHERE accID = :accountID OR toAccountID = :accountID GROUP BY receiverID ORDER BY timestamp DESC) messageIDs WHERE messageID = messageIDs ORDER BY timestamp DESC");
$query->execute([':accountID' => $_SESSION['accountID']]);
$result = $query->fetchAll();
$playersLastMessage = [];
if(!empty($result)) {
	$allChats = '';
	$allChatsEmpty = false;
}
foreach($result AS &$chat) {
	$youreLast = $chat['accID'] != $_SESSION['accountID'] ? false : true;
	$receiver = $chat['receiverID'];
	$username = !$youreLast ? $chat['userName'] : $gs->getAccountName($chat['receiverID']);
	$body = ($youreLast ? $dl->getLocalizedString("messengerYou").' ' : '').htmlspecialchars($xor->plaintext(ExploitPatch::url_base64_decode($chat["body"]), 14251));
	if(strlen($body) > 50) $body = mb_substr($body, 0, 50).'...';
	$playersLastMessage[$receiver] = $body;
	// Avatar management
	$queryAvatar = $db->prepare("SELECT * FROM users WHERE extID = :accountID");
    $queryAvatar->execute([':accountID' => $receiver]);	
    if($action = $queryAvatar->fetch()) {
		$iconType = ($action['iconType'] > 8) ? 0 : $action['iconType'];
		$iconTypeMap = [0 => ['type' => 'cube', 'value' => $action['accIcon']], 1 => ['type' => 'ship', 'value' => $action['accShip']], 2 => ['type' => 'ball', 'value' => $action['accBall']], 3 => ['type' => 'ufo', 'value' => $action['accBird']], 4 => ['type' => 'wave', 'value' => $action['accDart']], 5 => ['type' => 'robot', 'value' => $action['accRobot']], 6 => ['type' => 'spider', 'value' => $action['accSpider']], 7 => ['type' => 'swing', 'value' => $action['accSwing']], 8 => ['type' => 'jetpack', 'value' => $action['accJetpack']]];
		$iconValue = $iconTypeMap[$iconType]['value'] ?: 1;
		$avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $action['color1'] . '&color2=' . $action['color2'] . ($action['accGlow'] != 0 ? '&glow=' . $action['accGlow'] . '&color3=' . $action['color3'] : '') . '" alt="avatar" style="width: 25px; object-fit: contain;">';
	}
    // Badge management
    $badgeImg = '';
    $queryRoleID = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
    $queryRoleID->execute([':accountID' => $receiver]);	
    if($roleAssignData = $queryRoleID->fetch()) {
        $queryBadgeLevel = $db->prepare("SELECT modBadgeLevel FROM roles WHERE roleID = :roleID");
        $queryBadgeLevel->execute([':roleID' => $roleAssignData['roleID']]);	    
        if(($modBadgeLevel = $queryBadgeLevel->fetchColumn() ?? 0) >= 1 && $modBadgeLevel <= 3) {
            $badgeImg = '<img src="https://raw.githubusercontent.com/Fenix668/GMDprivateServer/master/dashboard/modBadge_0' . $modBadgeLevel . '_001.png" alt="badge" style="width: 25px; height: 25px; margin-left: -3px; vertical-align: middle;">';
        }
    }
	$newMessage = $db->prepare("SELECT min(isNew) newMessage, count(*) messageCount FROM messages WHERE accID = :receiver AND toAccountID = :accountID");
    $newMessage->execute([':receiver' => $receiver, ':accountID' => $_SESSION['accountID']]);	
    $newMessage = $newMessage->fetch();
	$newMessages = '';
	if($newMessage['newMessage'] == 0 && $newMessage['messageCount'] > 0) {
		$newMessagesCount = $db->prepare('SELECT count(*) FROM messages WHERE accID = :receiver AND toAccountID = :accountID AND isNew = 0');
		$newMessagesCount->execute([':receiver' => $receiver, ':accountID' => $_SESSION['accountID']]);	
		$newMessagesCount = $newMessagesCount->fetchColumn();
		$newMessages = '<span class="new-messages-notify">'.$newMessagesCount.'</span>';
	}
	$allChats .= '<button type="submit" onclick="a(\'messenger/'.$username.'\', true, true, \'POST\', false, \'messengerReceiver'.$receiver.'\')" class="btn-primary itembtn'.(isset($_POST['receiver']) && $_POST['receiver'] == $receiver ? ' chat-opened" id="chat-opened-all"' : '"').'>
		<h2 class="subjectnotyou accounts-badge-icon-div">'.$avatarImg.$username.$badgeImg.$newMessages.'</h2>
		<h2 class="messagenotyou chat" style="font-size: 15px;color: #c0c0c0;">'.$body.'</h2>
		<h3 id="comments" style="justify-content: flex-end; margin: 0px;">'.$dl->convertToDate($chat["timestamp"], true).'</h3>
	</button>
	<form style="display: none" name="messengerReceiver'.$receiver.'"><input type="hidden" name="receiver" value="'.$receiver.'"></input></form>';
}
$friends = $db->prepare("SELECT * FROM friendships INNER JOIN users ON users.extID = (CASE WHEN person1 = :accountID THEN person2 ELSE person1 END) WHERE person1 = :accountID OR person2 = :accountID ORDER BY userName ASC");
$friends->execute([':accountID' => $_SESSION['accountID']]);
$friends = $friends->fetchAll();
if(!empty($friends)) {
	$friendsChats = '';
	$friendsChatsEmpty = false;
}
foreach($friends AS &$friend) {
	$receiver = $friend['extID'];
	$username = $friend['userName'];
	$body = isset($playersLastMessage[$receiver]) ? $playersLastMessage[$receiver] : $dl->getLocalizedString('noMsgs');
	// Avatar management
	$queryAvatar = $db->prepare("SELECT * FROM users WHERE extID = :accountID");
    $queryAvatar->execute([':accountID' => $receiver]);	
    if($action = $queryAvatar->fetch()) {
		$iconType = ($action['iconType'] > 8) ? 0 : $action['iconType'];
		$iconTypeMap = [0 => ['type' => 'cube', 'value' => $action['accIcon']], 1 => ['type' => 'ship', 'value' => $action['accShip']], 2 => ['type' => 'ball', 'value' => $action['accBall']], 3 => ['type' => 'ufo', 'value' => $action['accBird']], 4 => ['type' => 'wave', 'value' => $action['accDart']], 5 => ['type' => 'robot', 'value' => $action['accRobot']], 6 => ['type' => 'spider', 'value' => $action['accSpider']], 7 => ['type' => 'swing', 'value' => $action['accSwing']], 8 => ['type' => 'jetpack', 'value' => $action['accJetpack']]];
		$iconValue = $iconTypeMap[$iconType]['value'] ?: 1;
		$avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $action['color1'] . '&color2=' . $action['color2'] . ($action['accGlow'] != 0 ? '&glow=' . $action['accGlow'] . '&color3=' . $action['color3'] : '') . '" alt="avatar" style="width: 25px; object-fit: contain;">';
	}
    // Badge management
    $badgeImg = '';
    $queryRoleID = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
    $queryRoleID->execute([':accountID' => $receiver]);	
    if($roleAssignData = $queryRoleID->fetch()) {
        $queryBadgeLevel = $db->prepare("SELECT modBadgeLevel FROM roles WHERE roleID = :roleID");
        $queryBadgeLevel->execute([':roleID' => $roleAssignData['roleID']]);	    
        if(($modBadgeLevel = $queryBadgeLevel->fetchColumn() ?? 0) >= 1 && $modBadgeLevel <= 3) {
            $badgeImg = '<img src="https://raw.githubusercontent.com/Fenix668/GMDprivateServer/master/dashboard/modBadge_0' . $modBadgeLevel . '_001.png" alt="badge" style="width: 25px; height: 25px; margin-left: -3px; vertical-align: middle;">';
        }
    }
	$friendsChats .= '<button type="submit" onclick="a(\'messenger/'.$username.'\', true, true, \'POST\', false, \'messengerReceiver'.$receiver.'\')" class="btn-primary itembtn'.(isset($_POST['receiver']) && $_POST['receiver'] == $receiver ? ' chat-opened" id="chat-opened-friends"' : '"').'>
		<h2 class="subjectnotyou accounts-badge-icon-div">'.$avatarImg.$username.$badgeImg.'</h2>
		<h2 class="messagenotyou chat" style="font-size: 15px;color: #c0c0c0;">'.$body.'</h2>
	</button>
	<form style="display: none" name="messengerReceiver'.$receiver.'"><input type="hidden" name="receiver" value="'.$receiver.'"></input></form>';
}
$dl->printSong('<div class="form-control itemsbox chatdiv" style="width: 75%;">
	<div class="friends-button-div">
		<div class="itemoverflow '.($allChatsEmpty ? 'empty-itemoverflow' : '').'" id="itemoverflow">
			<div class="itemslist" id="lastChats">
				'.$allChats.'
			</div>
			<div class="itemslist hide" id="friendsChats">
				'.$friendsChats.'
			</div>
		</div>
		<button type="button" onclick="friendsList()" class="btn-primary friends-button"><i class="fa-solid fa-user-group"></i></button>
	</div>
		<div class="form another-chat-div" style="margin:0;width:150%">
			<div class="chatbox">
				'.$chatBox.'
			</div>
		</div>
	</div>
</div><script>
	'.$pageScript.'
	allChatsEmpty = '.($allChatsEmpty ? 'true' : 'false').';
	friendsChatsEmpty = '.($friendsChatsEmpty ? 'true' : 'false').';
	if(typeof window.currentMessengerTab == "undefined") window.currentMessengerTab = "chats";
	else if(window.currentMessengerTab == "friends") {
		window.currentMessengerTab = "chats";
		friendsList();
	}
</script>', 'msg');
?>