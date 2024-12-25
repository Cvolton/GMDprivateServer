<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require "../".$dbPath."config/misc.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/automod.php";
$gs = new mainLib();
$dl = new dashboardLib();

function generate_timezone_list()
{
    static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach( $regions as $region )
    {
        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
    }

    $timezone_offsets = array();
    foreach( $timezones as $timezone )
    {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    // sort timezone by offset
    asort($timezone_offsets);

    $timezone_list = array();
    foreach( $timezone_offsets as $timezone => $offset )
    {
        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate( 'H:i', abs($offset) );

        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

        $timezone_list .= '<option value="'.$timezone.'">('.$pretty_offset.') '.$timezone.'</option>';
    }

    return $timezone_list;
}

$clan = $none = "";
if((!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0) AND (empty($_POST["accountID"]) AND empty($_GET["id"]))) {
  	$dl->title($dl->getLocalizedString("profile"));
	$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="./login/login.php">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
			</form>
		</div>', 'profile');
  	die();
}
if(!empty($_POST["accountID"])) {
	$accid = ExploitPatch::remove($_POST["accountID"]);
	if(!is_numeric($accid)) $userID = $gs->getUserID($accid);
}
elseif(isset($_GET["id"])) {
    $dl->printFooter('../../');
	$getID = explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-1];
	if($getID == "settings") {
	    $getID = explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-2];
	    $_POST["settings"] = 1;
	}
	$accid = ExploitPatch::charclean($getID);
	if(!is_numeric($accid)) $accid = $gs->getAccountIDFromName(str_replace('%20', ' ', $accid));
	if(!$accid) {
		$userCheck = $db->prepare("SELECT * FROM users WHERE userName = :name LIMIT 1");
		$userCheck->execute([":name" => ExploitPatch::remove($getID)]);
		$userCheck = $userCheck->fetch();
		if($userCheck) {
			$userID = $userCheck['userID'];
			$accid = $userCheck['extID'];
		} else {
			$userCheck = $db->prepare("SELECT * FROM users WHERE extID = :id");
			$userCheck->execute([":id" => ExploitPatch::remove($getID)]);
			$userCheck = $userCheck->fetch();
			if($userCheck) {
				$userID = $userCheck['userID'];
				$accid = $userCheck['extID'];
			}
		}
	}
}
else {
    $accid = $_SESSION["accountID"];
    $dl->printFooter('../');
}
if(!$accid) $accid = $_SESSION["accountID"];
if(!$userID) $userID = $gs->getUserID($accid);
if(is_numeric($accid)) $accname = $gs->getAccountName($accid);
else $accname = $gs->getUserName($userID);
$dl->title($dl->getLocalizedString("profile").', '.$accname);
if($accid != $_SESSION["accountID"] && is_numeric($accid)) {
    $block = $db->prepare("SELECT * FROM blocks WHERE person1 = :p1 AND person2 = :p2");
    $block->execute([':p1' => $accid, ':p2' => $_SESSION["accountID"]]);
    $block = $block->fetch();
    if(!empty($block)) exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
        <form class="form__inner" method="post" action="">
        <p id="dashboard-error-text">'.$dl->getLocalizedString("youBlocked").'</p>
        <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("dashboard").'</button>
  		</form>
	</div>'));
}
if(!empty($_POST["msg"])) {
	if(Automod::isAccountsDisabled(1)) die($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
       	<form class="form__inner" method="post" action="">
       	<p id="dashboard-error-text">'.$dl->getLocalizedString("postingIsDisabled").'</p>
       	<button type="button" onclick="a(\'profile/'.$accname.'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'profile'));
	$checkBan = $gs->getPersonBan($accid, $userID, 3);
	if($checkBan) exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" action="" method="post">
		<p id="dashboard-error-text">'.sprintf($dl->getLocalizedString("youAreBanned"), htmlspecialchars(base64_decode($checkBan['reason'])), date("d.m.Y G:i", $checkBan['expires'])).'</p>
		<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>'));
    $query = $db->prepare("SELECT timestamp FROM acccomments WHERE userID=:accid ORDER BY timestamp DESC LIMIT 1");
    $query->execute([':accid' => $userID]);
    $res = $query->fetch();
    $time = time() - 5;
    if($res["timestamp"] > $time) die($dl->printSong('<div class="form">
	<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
       	<form class="form__inner" method="post" action="">
       	<p id="dashboard-error-text">'.$dl->getLocalizedString("tooFast").'</p>
       	<button type="button" onclick="a(\'profile/'.$accname.'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'profile'));
	$msg = ExploitPatch::url_base64_encode(ExploitPatch::rucharclean($_POST["msg"]));
	if($enableCommentLengthLimiter && strlen(ExploitPatch::url_base64_decode($msg)) > $maxAccountCommentLength) $msgTooLong = true;
	else {
		$query = $db->prepare("INSERT INTO acccomments (userID, userName, comment, timestamp) VALUES (:id, :name, :msg, :time)");
		$query->execute([':id' => $userID, ':name' => $accname, ':msg' => $msg, ':time' => time()]);
		$gs->logAction($_SESSION['accountID'], 14, $accname, $msg, $db->lastInsertId());
		Automod::checkAccountPostsSpamming($userID);
	}
}
if(isset($_POST["settings"]) AND $_POST["settings"] == 1 AND $accid == $_SESSION["accountID"]) {
    if(!isset($_POST["ichangedsmth"]) OR $_POST["ichangedsmth"] != 1) {
        echo '<base href="../../">';
        $query = $db->prepare("SELECT mS, frS, cS, youtubeurl, twitter, twitch, timezone FROM accounts WHERE accountID=:id");
        $query->execute([':id' => $accid]);
        $query = $query->fetch();
		$query["youtubeurl"] = mb_ereg_replace("(?!^@)[^a-zA-Z0-9_]", "", $query["youtubeurl"]);
		$query["twitter"] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $query["twitter"]);
		$query["twitch"] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $query["twitch"]);
    	exit($dl->printSong('<div class="form" style="width: 60vw;max-height: 80vh;position:relative">
        	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;flex-wrap:wrap">
            	<form method="post" style="margin:0px" action=""><button type="button" onclick="a(\'profile/'.$accname.'\', true, true, \'GET\')" class="goback" style="margin-top:0px"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>
                  <div style="display: flex;flex-direction: column;align-items: center"><h1>'.$dl->getLocalizedString("settings").'</h1></div>
                  <form method="post" style="display: flex;grid-gap:10px;width: 100%;margin-bottom: 15px">
                          <div class="messenger" style="grid-gap: 10px;display: grid;">
                            <div>
                                <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("allowMessagesFrom").'</h2>
                                <select class="field field-options" style="margin: 0px" name="messages">
                                 <option value="0">'.$dl->getLocalizedString("all").'</option>
                                 <option value="1">'.$dl->getLocalizedString("friends").'</option>
                                 <option value="2">'.$dl->getLocalizedString("none").'</option>
                                </select>
                            </div>
                            <div>
                            <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("allowFriendReqsFrom").'</h2>
                                <select class="field field-options" style="margin: 0px" name="friendreqs">
                                 <option value="0">'.$dl->getLocalizedString("all").'</option>
                                 <option value="1">'.$dl->getLocalizedString("none").'</option>
                                </select>
                            </div>
                            <div>
                            <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("showCommentHistory").'</h2>
                                <select class="field field-options" style="margin: 0px" name="comments">
                                 <option value="0">'.$dl->getLocalizedString("all").'</option>
                                 <option value="1">'.$dl->getLocalizedString("friends").'</option>
                                 <option value="2">'.$dl->getLocalizedString("none").'</option>
                                </select>
                            </div>
							<div>
                            <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("timezoneChoose").'</h2>
                                <select class="field field-options" style="margin: 0px" name="timezone">
                                  '.generate_timezone_list().'
                                </select>
                            </div>
                            <script>
                                document.getElementsByName("messages")[0].value = '.$query["mS"].';
                                document.getElementsByName("friendreqs")[0].value = '.$query["frS"].';
                                document.getElementsByName("comments")[0].value = '.$query["cS"].';
								document.getElementsByName("timezone")[0].value = "'.$query["timezone"].'";
                            </script>
                         </div>
                         <div class="messenger" style="grid-gap: 10px;display: grid;">
                            <div>
                                <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("yourYouTube").'</h2>
                                <input class="form-control" type="text" value="'.$query["youtubeurl"].'" name="youtube" placeholder="youtube.com/channel/..."></input>
                            </div>
                            <div>
                                <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("yourTwitter").'</h2>
                                <input class="form-control" type="text" value="'.$query["twitter"].'" name="twitter" placeholder="twitter.com/..."></input>
                            </div>
                            <div>
                                <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("yourTwitch").'</h2>
                                <input class="form-control" type="text" value="'.$query["twitch"].'" name="twitch" placeholder="twitch.tv/..."></input>
                            </div>
                    </div>
                    <input type="hidden" name="ichangedsmth" value="1"></input>
					<input type="hidden" name="settings" value="1"></input>
                    </form>
                <button style="margin-bottom:10px" class="btn-song" type="button" onclick="a(\'profile/'.$accname.'/settings\', true, true, \'POST\')">'.$dl->getLocalizedString("saveSettings").'</button>
            </div>
    </div></div>'));
    } else {
		$getAccountData = $db->prepare("SELECT * FROM accounts WHERE accountID = :accountID");
		$getAccountData->execute([':accountID' => $accid]);
		$getAccountData = $getAccountData->fetch();
        if(ExploitPatch::number($_POST["messages"]) > 2 OR ExploitPatch::number($_POST["messages"]) < 0 OR empty(ExploitPatch::number($_POST["messages"]))) $_POST["messages"] = 0;
        if(ExploitPatch::number($_POST["friendreqs"]) > 1 OR ExploitPatch::number($_POST["friendreqs"]) < 0 OR empty(ExploitPatch::number($_POST["friendreqs"]))) $_POST["friendreqs"] = 0;
        if(ExploitPatch::number($_POST["comments"]) > 2 OR ExploitPatch::number($_POST["comments"]) < 0 OR empty(ExploitPatch::number($_POST["comments"]))) $_POST["comments"] = 0;
		$_POST["youtube"] = mb_ereg_replace("(?!^@)[^a-zA-Z0-9_]", "", $_POST["youtube"]);
		$_POST["twitter"] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $_POST["twitter"]);
		$_POST["twitch"] = mb_ereg_replace("[^a-zA-Z0-9_]", "", $_POST["twitch"]);
        $query = $db->prepare("UPDATE accounts SET mS = :ms, frS = :frs, cS = :cs, youtubeurl = :yt, twitter = :twt, twitch = :ttv, timezone = :tz WHERE accountID=:id");
        $query->execute([':id' => $accid, ':ms' => ExploitPatch::number($_POST["messages"]), ':frs' => ExploitPatch::number($_POST["friendreqs"]), ':cs' => ExploitPatch::number($_POST["comments"]), ':yt' => ExploitPatch::remove($_POST["youtube"]), ':twt' => ExploitPatch::remove($_POST["twitter"]), ':ttv' => ExploitPatch::remove($_POST["twitch"]), ':tz' => ExploitPatch::rucharclean($_POST["timezone"])]);
		$gs->sendLogsAccountChangeWebhook($accid, $accid, $getAccountData);
    }
}
$query = $db->prepare("SELECT * FROM users WHERE userID=:id");
$query->execute([':id' => $userID]);
$res = $query->fetch();
$badgeImg = '';
$queryRoleID = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
$queryRoleID->execute([':accountID' => $accid]);	
if($roleAssignData = $queryRoleID->fetch(PDO::FETCH_ASSOC)) {        
    $queryBadgeLevel = $db->prepare("SELECT modBadgeLevel FROM roles WHERE roleID = :roleID");
    $queryBadgeLevel->execute([':roleID' => $roleAssignData['roleID']]);	    
    if(($modBadgeLevel = $queryBadgeLevel->fetchColumn() ?? 0) >= 1 && $modBadgeLevel <= 3) {
        $badgeImg = '<img src="https://raw.githubusercontent.com/Fenix668/GMDprivateServer/master/dashboard/modBadge_0' . $modBadgeLevel . '_001.png" alt="badge" style="width: 34px; height: 34px; margin-top: -3px; vertical-align: middle;">';
    }
}
$maybeban = '<h1 class="profilename" style="color:rgb('.$gs->getAccountCommentColor($accid).');">'.$accname.$badgeImg.'</h1>';
if(isset($_SERVER["HTTP_REFERER"])) $back = '<form method="post" action="'.$_SERVER["HTTP_REFERER"].'"><button type="button" onclick="a(\''.$_SERVER["HTTP_REFERER"].'\', true, true, \'GET\')" class="goback"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>'; else $back = '';
$all = $dl->createProfileStats($res['stars'], $res['moons'], $res['diamonds'], $res['coins'], $res['userCoins'], $res['demons'], $res['creatorPoints'], 0);
$msgs = $db->prepare("SELECT * FROM acccomments WHERE userID = :uid ORDER BY commentID DESC");
$msgs->execute([':uid' => $userID]);
$msgs = $msgs->fetchAll();
$comments = $send = '';
foreach($msgs AS &$msg) {
	$none = '';
	$reply = $db->prepare("SELECT count(*) FROM replies WHERE commentID = :id");
	$reply->execute([':id' => $msg["commentID"]]);
	$reply = $reply->fetchColumn();	
  	$message = $dl->parseMessage(htmlspecialchars(ExploitPatch::url_base64_decode($msg["comment"])));
	if($enableCommentLengthLimiter) $message = substr($message, 0, $maxAccountCommentLength);
  	$time = $msg["timestamp"];
	$likes = '<span style="color: #c0c0c0;">'.$msg["likes"].'</span>';
	$dislikes = '<span style="color: #c0c0c0;">'.$msg["dislikes"].'</span>';
	$stats = '<i class="fa-regular fa-thumbs-up"></i> '.$likes.' '.(isset($msg['dislikes']) ? '<text style="color: gray;">•</text> <i class="fa-regular fa-thumbs-down"></i> '.$dislikes : '');
	if($reply < 1) $none = 'display:none';
	$replies = '<button id="btnreply'.$msg["commentID"].'" onclick="reply('.$msg["commentID"].')" class="btn-rendel" style="padding: 7 10;margin-right: 10px;min-width: max-content;width: max-content;'.$none.'">'.$dl->getLocalizedString("replies").' ('.$reply.')</button>';
	if($_SESSION["accountID"] != 0) $input = '<div class="field" style="display:flex;margin-right:10px"><input id="inputReply'.$msg["commentID"].'" type="text" placeholder="'.$dl->getLocalizedString("replyToComment").'"><button onclick="sendReply('.$msg["commentID"].')" id="btninput'.$msg["commentID"].'" style="width: max-content;margin-left: 10px;padding: 8px;" class="btn-rendel"><i style="color:white" class="fa-regular fa-paper-plane" aria-hidden="true"></i></button></div>';
  	$comments .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display:flex"><h2 class="profilenick">'.$accname.'</h2><p style="text-align:right">'.$stats.'</p></div>
			<h3 class="profilemsg">'.$message.'</h3>
			<h3 id="comments"><div id="replyBtn'.$msg["commentID"].'">'.$replies.'</div><i style="display: none;margin-right: 10px;color: white;font-size: 13px;" id="spin'.$msg["commentID"].'" class="fa-solid fa-spinner fa-spin"></i>'.$input.''.$dl->convertToDate($time, true).'</h3></div>
			<div style="width: 90%;" id="reply'.$msg["commentID"].'"></div>
		</div>';
}
if(empty($comments)) $comments = '<p class="profile" style="font-size:25px;color:#c0c0c0">'.$dl->getLocalizedString("empty").'</p>';
$msgtopl = '<form method="post" action="messenger/'.$accname.'"><button type="button" onclick="a(\'messenger/'.$accname.'\', true, true, \'GET\')" class="msgupd" name="accountID" value="'.$accid.'"><i class="fa-regular fa-comment" aria-hidden="true"></i></button></form>';
if($accid == $_SESSION["accountID"]) {
	if(empty($comments)) $comments = '<p class="profile" style="font-size:25px;color:#c0c0c0">'.$dl->getLocalizedString("writeSomething").'</p>';
	$send = '<div class="field" style="margin-top:10px">
		<form method="post" action=""><input type="text" name="msg" id="p1" placeholder="'.$dl->getLocalizedString("msg").'"></input>
		<button type="button" onclick="a(\'profile/'.$accname.'\', true, true, \'POST\')" style="margin-top: 10px;" class="btn-primary btn-block" id="submit" disabled>'.$dl->getLocalizedString("send").'</button></form>
	</div><script>
	$(document).on("keyup keypress change keydown",function(){
	   const p1 = document.getElementById("p1");
	   const btn = document.getElementById("submit");
	   if(!p1.value.trim().length) {
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
	</script>';
	$msgtopl = '<form method="post" name="settingsform"><input type="hidden" name="settings" value="1"><button type="button" onclick="a(\'profile/'.$accname.'/settings\', true, true, \'POST\', false, \'settingsform\')" title="'.$dl->getLocalizedString("settings").'" class="msgupd" name="settings" value="1"><i class="fa-solid fa-user-gear" aria-hidden="true"></i></button></form>';
} else {
	$privacySettings = $db->prepare("SELECT mS FROM accounts WHERE accountID = :receiver");
	$privacySettings->execute([':receiver' => $accid]);
	$privacySettings = $privacySettings->fetchColumn();
	$block = $db->prepare("SELECT count(*) FROM blocks WHERE (person1 = :receiver AND person2 = :accountID) OR (person2 = :receiver AND person1 = :accountID)");
	$block->execute([':receiver' => $accid, ':accountID' => $_SESSION['accountID']]);
	$block = $block->fetchColumn();
	if(($privacySettings == 1 && !$gs->isFriends($accid, $_SESSION["accountID"])) || $privacySettings == 2 || $block > 0) $msgtopl = '';
}
if($_SESSION["accountID"] == 0) $msgtopl = '';
if($res["dlPoints"] != 0) $points = '<i class="fa-solid fa-medal dlpoints"> '.$res["dlPoints"].'</i>';
if($gs->isPlayerInClan($accid)) {
	$claninfo = $gs->getClanInfo($res["clan"]);
	if($claninfo["clanOwner"] == $accid) $own = '<i style="color:#ffff91" class="fa-solid fa-crown"></i>';
	$clan = '<button type="button" onclick="a(\'clan/'.$claninfo["clan"].'\', true, true)" style="display:contents;cursor:pointer"><h2 class="music" style="grid-gap:5px;color:#'.$claninfo["color"].'">'.$claninfo["clan"].$own.'</h2></button>';
}
$kit = '<div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=cube&value='.($res['accIcon'] ? $res['accIcon'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-cube" style="opacity: 0;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=ship&value='.($res['accShip'] ? $res['accShip'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-ship" style="opacity: 0; animation-delay: 100ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=ball&value='.($res['accBall'] ? $res['accBall'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-ball" style="opacity: 0; animation-delay: 150ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=ufo&value='.($res['accBird'] ? $res['accBird'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-ufo" style="opacity: 0; animation-delay: 200ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=wave&value='.($res['accDart'] ? $res['accDart'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-wave" style="opacity: 0; animation-delay: 250ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=robot&value='.($res['accRobot'] ? $res['accRobot'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-robot" style="opacity: 0; animation-delay: 300ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=spider&value='.($res['accSpider'] ? $res['accSpider'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-spider" style="opacity: 0; animation-delay: 350ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=swing&value='.($res['accSwing'] ? $res['accSwing'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-swing" style="opacity: 0; animation-delay: 400ms;">
</div><div class="icon-kit-div">
	<img src="'.$iconsRendererServer.'/icon.png?type=jetpack&value='.($res['accJetpack'] ? $res['accJetpack'] : 1).'&color1='.$res['color1'].'&color2='.$res['color2'].($res['accGlow'] && $res['accGlow'] != 0 ? '&glow='.$res['accGlow'].'&color3='.$res['color3'] : '').'" class="icon-kit-icon icon-jetpack" style="opacity: 0; animation-delay: 450ms;">
</div>';

$dl->printSong('<div class="form profileform">
    	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;">
        	'.$back.'
              <div class="profilewclanname">'.$maybeban.$clan.'</div>'.$msgtopl.$points.'
        </div>
        <div class="form-control profile-stats">'.$all.'</div>
		<div class="form-control icon-kit">'.$kit.'</div>
        <div class="form-control dmbox profile-comments">
        	'.$comments.'
        </div>
		'.$send.'
</div></div>
<script>
'.(isset($msgTooLong) ? 'alert("You cannot post account comments above '.$maxAccountCommentLength.' characters!");':'').'
function reply(id) {
	document.getElementById("spin" + id).style.display = "block";
    replies = new XMLHttpRequest();
    replies.open("POST", "profile/replies.php", true);
    replies.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    replies.onload = function () {
		document.getElementById("spin" + id).style.display = "none";
		str = replies.response;
		if(!str.trim().length) document.getElementById("replyBtn" + id).innerHTML = "";
		str2 = str.split(" | ");
		r = 0;
		str2.forEach(element => {
			rep = element.split(", ");
			rid = rep[0];
			cid = rep[1];
			accid = rep[2];
			body = b64DecodeUnicode(rep[3]);
			r = r + 1;
			time = rep[4];
			replyCount = rep[5];
			const div = document.createElement("div");
			div.className = "profile";
			div.style.background = "none";
			if(r > 1) {
				hr = document.createElement("hr");
				hr.innerHTML = `<hr style="width:90%">`;
				document.getElementById("reply" + id).appendChild(hr);
			}
			if(rep[2] == "'.$gs->getAccountName($_SESSION["accountID"]).'") div.innerHTML = `<div style="display:flex;height: max-content;justify-content: space-between;">
				<h2 class="profilenick" style="width:max-content">` + accid + `</h2>
				<button onclick="deleteReply(`+ rid + `, ` + cid +`)" id="delete` + id + `" style="width: max-content;margin-left: 10px;padding: 8px;height: max-content;font-size: 10px;" class="btn-rendel">
				<i style="margin: 0 2px 0 2px;color:#ffb1ab" class="fa-solid fa-xmark" aria-hidden="true"></i>
				</button>
			</div>
			<div style="display:flex;justify-content:space-between"><h3 class="profilemsg">` + body + `</h3><h3 id="comments" style="justify-content:flex-end">` + time + `</h3></div>`;
			else div.innerHTML = `<div style="display:flex;height: max-content;justify-content: space-between;">
				<h2 class="profilenick" style="width:max-content">` + accid + `</h2>
			</div>
			<div style="display:flex;justify-content:space-between"><h3 class="profilemsg">` + body + `</h3><h3 id="comments" style="justify-content:flex-end">` + time + `</h3></div>`;
			document.getElementById("reply" + id).appendChild(div);
			document.getElementById("btnreply" + id).setAttribute( "onClick", "hideReplies(" + id + ");" );
		});
		if(r < 1) document.getElementById("replyBtn" + id).innerHTML = "";
	}
    replies.send("id=" + id);
}
function showReplies(id) {
	document.getElementById("reply" + id).style.display = "block";
	document.getElementById("btnreply" + id).setAttribute( "onClick", "hideReplies(" + id + ");" );
}
function hideReplies(id) {
	document.getElementById("reply" + id).style.display = "none";
	document.getElementById("btnreply" + id).setAttribute( "onClick", "showReplies(" + id + ");"  );
}
function sendReply(id) {
	if(typeof replyCount == "undefined") replyCount = 0;
	document.getElementById("spin" + id).style.display = "block";
	const input = document.getElementById("inputReply" + id);
	if(input.value.trim().length) {
		document.getElementById("btninput" + id).disabled = true;
		document.getElementById("btninput" + id).classList.add("btn-block");
		repsend = new XMLHttpRequest();
		repsend.open("POST", "profile/replies.php", true);
		repsend.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		repsend.onload = function () {
			document.getElementById("spin" + id).style.display = "none";
			document.getElementById("btninput" + id).removeAttribute("disabled");
			document.getElementById("btninput" + id).classList.remove("btn-block");
			if(repsend.response == -1) return alert("'.sprintf($dl->getLocalizedString('cantPostAccountCommentsAboveChars'), $maxAccountCommentLength).'");
			if(repsend.response == -2) return alert("'.$dl->getLocalizedString('replyingIsDisabled').'");
			if(repsend.response == -3) return alert("'.$dl->getLocalizedString('youAreBannedFromCommenting').'");
			if(repsend.response == 1) {
				replyCount++;
				input.value = "";
				document.getElementById("reply" + id).innerHTML = "";
				document.getElementById("replyBtn" + id).innerHTML = \'<button id="btnreply\' +  id+ \'" onclick="reply(\' +  id+ \')" class="btn-rendel" style="padding: 7 10;margin-right: 5px;min-width: max-content;width: max-content">'.$dl->getLocalizedString("replies").' (\' + replyCount + \')</button>\';
				reply(id);
			}
		}
		repsend.send("id=" + id + "&body=" + input.value);
	}
}
function deleteReply(rid, id) {
	document.getElementById("spin" + id).style.display = "block";
	del = new XMLHttpRequest();
    del.open("POST", "profile/replies.php", true);
	del.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	del.onload = function () {
			if(del.response == 1) {
			document.getElementById("spin" + id).style.display = "none";
			replyCount--;
			document.getElementById("reply" + id).innerHTML = "";
			if(r > 0) document.getElementById("replyBtn" + id).innerHTML = \'<button id="btnreply\' +  id+ \'" onclick="reply(\' +  id+ \')" class="btn-rendel" style="padding: 7 10;margin-right: 5px;min-width: max-content;width: max-content">'.$dl->getLocalizedString("replies").' (\' + replyCount + \')</button>\';
			else document.getElementById("replyBtn" + id).innerHTML = "";
			reply(id);
		}
	}
	del.send("id=" + rid + "&delete=1");
}
function b64DecodeUnicode(str) {
    return decodeURIComponent(atob(str).split(\'\').map(function(c) {
        return \'%\' + (\'00\' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(\'\'));
}
</script>', 'profile');
?>