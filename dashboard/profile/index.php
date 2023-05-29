<?php
session_start();
include "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/exploitPatch.php";
include_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(!isset($_GET["id"])) header("Location: ".$gs->getAccountName(ExploitPatch::number($_POST["accountID"])));
include "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
$clan = $none = "";
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0 AND empty($_POST["accountID"]) AND empty($_GET["id"])) {
  	$dl->title($dl->getLocalizedString("profile"));
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'profile');
  	die();
}
if(!empty($_POST["accountID"])) $accid = ExploitPatch::number($_POST["accountID"]);
elseif(isset($_GET["id"])) {
    $dl->printFooter('../../');
	$getID = explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-1];
	if($getID == "settings") {
	    $getID = explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-2];
	    $_POST["settings"] = 1;
	}
	$accid = ExploitPatch::remove($getID);
	if(!is_numeric($accid)) $accid = $gs->getAccountIDFromName($accid);
}
else {
    $accid = $_SESSION["accountID"];
    $dl->printFooter('../');
}
if(!$accid) $accid = $_SESSION["accountID"];
$accname = $gs->getAccountName($accid);
$dl->title($dl->getLocalizedString("profile").', '.$accname);
if($accid != $_SESSION["accountID"]) {
    $block = $db->prepare("SELECT * FROM blocks WHERE person1 = :p1 AND person2 = :p2");
    $block->execute([':p1' => $accid, ':p2' => $_SESSION["accountID"]]);
    $block = $block->fetch();
    if(!empty($block)) exit($dl->printSong('<div class="form">
            	   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
           	 	   <form class="form__inner" method="post" action="">
          		  <p>'.$dl->getLocalizedString("youBlocked").'</p>
          		  <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("dashboard").'</button>
  				 </form>
			</div>'));
}
if(!empty($_POST["msg"])) {
  	  $query = $db->prepare("SELECT timestamp FROM acccomments WHERE userID=:accid ORDER BY timestamp DESC LIMIT 1");
      $query->execute([':accid' => $gs->getUserID($accid)]);
      $res = $query->fetch();
      $time = time() - 30;
      if($res["timestamp"] > $time) {
     		$dl->printSong('<div class="form">
            	   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
           	 	   <form class="form__inner" method="post" action="">
          		  <p>'.$dl->getLocalizedString("tooFast").'</p>
          		  <button type="button" onclick="a(\'profile/'.$accname.'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("tryAgainBTN").'</button>
  				 </form>
			</div>', 'profile');
     die();
    }
	$msg = base64_encode(ExploitPatch::remove($_POST["msg"]));
	$query = $db->prepare("INSERT INTO acccomments (userID, userName, comment, timestamp) VALUES (:id, :name, :msg, :time)");
  	$query->execute([':id' => $gs->getUserID($accid), ':name' => $accname, ':msg' => $msg, ':time' => time()]);
}
if(isset($_POST["settings"]) AND $_POST["settings"] == 1 AND $accid == $_SESSION["accountID"]) {
    if(!isset($_POST["ichangedsmth"]) OR $_POST["ichangedsmth"] != 1) {
        echo '<base href="../../">';
        $query = $db->prepare("SELECT mS, frS, cS, youtubeurl, twitter, twitch FROM accounts WHERE accountID=:id");
        $query->execute([':id' => $accid]);
        $query = $query->fetch();
    	exit($dl->printSong('<div class="form" style="width: 60vw;max-height: 80vh;position:relative">
        	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;flex-wrap:wrap">
            	<form method="post" style="margin:0px" action=""><button type="button" onclick="a(\'profile/'.$accname.'\', true, true, \'GET\')" class="goback" style="margin-top:0px"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>
                  <div style="display: flex;flex-direction: column;align-items: center"><h1>'.$dl->getLocalizedString("settings").'</h1></div>
                  <form method="post" style="display: flex;grid-gap:10px;width: 100%;margin-bottom: 15px">
                          <div class="messenger" style="grid-gap: 10px;display: grid;">
                            <div>
                                <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("allowMessagesFrom").'</h2>
                                <select class="field" style="margin: 0px" name="messages">
                                 <option value="0">'.$dl->getLocalizedString("all").'</option>
                                 <option value="1">'.$dl->getLocalizedString("friends").'</option>
                                 <option value="2">'.$dl->getLocalizedString("none").'</option>
                                </select>
                            </div>
                            <div>
                            <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("allowFriendReqsFrom").'</h2>
                                <select class="field" style="margin: 0px" name="friendreqs">
                                 <option value="0">'.$dl->getLocalizedString("all").'</option>
                                 <option value="1">'.$dl->getLocalizedString("none").'</option>
                                </select>
                            </div>
                            <div>
                            <h2 style="text-align:left;margin:0;margin-bottom: 3px">'.$dl->getLocalizedString("showCommentHistory").'</h2>
                                <select class="field" style="margin: 0px" name="comments">
                                 <option value="0">'.$dl->getLocalizedString("all").'</option>
                                 <option value="1">'.$dl->getLocalizedString("friends").'</option>
                                 <option value="2">'.$dl->getLocalizedString("none").'</option>
                                </select>
                            </div>
                            <script>
                                document.getElementsByName("messages")[0].value = '.$query["mS"].';
                                document.getElementsByName("friendreqs")[0].value = '.$query["frS"].';
                                document.getElementsByName("comments")[0].value = '.$query["cS"].';
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
                    </form>
                <button style="margin-bottom:10px" class="btn-song" type="button" onclick="a(\'profile/'.$accname.'/settings\', true, true, \'POST\')">'.$dl->getLocalizedString("saveSettings").'</button>
            </div>
    </div></div>'));
    } else {
        if(ExploitPatch::number($_POST["messages"]) > 2 OR ExploitPatch::number($_POST["messages"]) < 0 OR empty(ExploitPatch::number($_POST["messages"]))) $_POST["messages"] = 0;
        if(ExploitPatch::number($_POST["friendreqs"]) > 1 OR ExploitPatch::number($_POST["friendreqs"]) < 0 OR empty(ExploitPatch::number($_POST["friendreqs"]))) $_POST["friendreqs"] = 0;
        if(ExploitPatch::number($_POST["comments"]) > 2 OR ExploitPatch::number($_POST["comments"]) < 0 OR empty(ExploitPatch::number($_POST["comments"]))) $_POST["comments"] = 0;
        $query = $db->prepare("UPDATE accounts SET mS = :ms, frS = :frs, cS = :cs, youtubeurl = :yt, twitter = :twt, twitch = :ttv WHERE accountID=:id");
        $query->execute([':id' => $accid, ':ms' => ExploitPatch::number($_POST["messages"]), ':frs' => ExploitPatch::number($_POST["friendreqs"]), ':cs' => ExploitPatch::number($_POST["comments"]), ':yt' => ExploitPatch::remove($_POST["youtube"]), ':twt' => ExploitPatch::remove($_POST["twitter"]), ':ttv' => ExploitPatch::remove($_POST["twitch"])]);
    }
}
$query = $db->prepare("SELECT extID, stars, demons, coins, userCoins, creatorPoints, diamonds, isCreatorBanned, dlPoints, isBanned, banReason, clan FROM users WHERE extID=:id");
$query->execute([':id' => $accid]);
$res = $query->fetch();
if($res["isBanned"] == 1) $maybeban = '<h1 style="text-decoration:line-through;color:#432529;margin:0px">'.$accname.'</h1>'; else $maybeban = '<h1 style="color:rgb('.$gs->getAccountCommentColor($accid).');margin:0px">'.$accname.'</h1>';
if(isset($_SERVER["HTTP_REFERER"])) $back = '<form method="post" action="'.$_SERVER["HTTP_REFERER"].'"><button type="button" onclick="a(\''.$_SERVER["HTTP_REFERER"].'\', true, true, \'GET\')" class="goback"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>'; else $back = '';
if($res["stars"] == 0) $st = ''; else $st = '<p class="profilepic">'.$res["stars"].' <i class="fa-solid fa-star"></i></p>';
if($res["diamonds"] == 0) $dm = ''; else $dm = ' <p class="profilepic">'.$res["diamonds"].' <i class="fa-solid fa-gem"></i></p>';
if($res["coins"] == 0) $gc = ''; else $gc = '<p class="profilepic">'.$res["coins"].' <i class="fa-solid fa-coins" style="color:#ffffbb"></i></p>';
if($res["userCoins"] == 0) $uc = ''; else $uc = '<p class="profilepic">'.$res["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
if($res["demons"] == 0) $dn = ''; else $dn = '<p class="profilepic">'.$res["demons"].' <i class="fa-solid fa-dragon"></i></p>';
if($res["isCreatorBanned"] == 1) {
	$banhaha = 'style="text-decoration:line-through;color:#432529"';
	$creatorban = 'style="text-decoration: line-through"';
} else $banhaha = $creatorban = '';
if($res["creatorPoints"] == 0) $cp = ''; else $cp = '<p class="profilepic" '.$banhaha.'>'.$res["creatorPoints"].' <i class="fa-solid fa-screwdriver-wrench" '.$creatorban.'></i></p>';
$all = $st.''.$dm.''.$gc.''.$uc.''.$dn.''.$cp;
if(empty($all)) $all = '<p style="font-size:25px;color:#212529">'.$dl->getLocalizedString("empty").'</p>';
$msgs = $db->prepare("SELECT * FROM acccomments WHERE userID=:uid ORDER BY commentID DESC");
$msgs->execute([':uid' => $gs->getUserID($accid)]);
$msgs = $msgs->fetchAll();
$comments = $send = '';
foreach($msgs AS &$msg) {
	$reply = $db->prepare("SELECT count(*) FROM replies WHERE commentID = :id");
	$reply->execute([':id' => $msg["commentID"]]);
	$reply = $reply->fetchColumn();	
  	$message = base64_decode($msg["comment"]);
  	$time = $msg["timestamp"];
	$likes = $msg["likes"];
	if($likes >= 0) $likes = $likes.' <i class="fa-regular fa-thumbs-up"></i>'; else $likes = mb_substr($likes, 1).' <i class="fa-regular fa-thumbs-down"></i>';
	if($reply == 0) $none = 'display:none';
	$replies = '<button id="btnreply'.$msg["commentID"].'" onclick="reply('.$msg["commentID"].')" class="btn-rendel" style="padding: 7 10;margin-right: 10px;min-width: max-content;width: max-content;'.$none.'">'.$dl->getLocalizedString("replies").' ('.$reply.')</button>';
	if($_SESSION["accountID"] != 0) $input = '<div class="field" style="display:flex;margin-right:10px"><input id="inputReply'.$msg["commentID"].'" type="text" placeholder="'.$dl->getLocalizedString("replyToComment").'"><button onclick="sendReply('.$msg["commentID"].')" id="btninput'.$msg["commentID"].'" style="width: max-content;margin-left: 10px;padding: 8px;" class="btn-rendel"><i style="color:white" class="fa-regular fa-paper-plane" aria-hidden="true"></i></button></div>';
  	$comments .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display:flex"><h2 class="profilenick">'.$accname.'</h2><p style="text-align:right">'.$likes.'</p></div>
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
}
if($_SESSION["accountID"] == 0) $msgtopl = '';
if($res["dlPoints"] != 0) $points = '<i style="position: absolute;font-size: 20;right: 50;color: gray;" class="fa-solid fa-medal"> '.$res["dlPoints"].'</i>';
if($gs->isPlayerInClan($accid)) {
	$claninfo = $gs->getClanInfo($res["clan"]);
	if($claninfo["clanOwner"] == $accid) $own = '<i style="color:#ffff91" class="fa-solid fa-crown"></i>';
	$clan = '<button type="button" onclick="a(\'clan/'.$claninfo["clan"].'\', true, true)" style="display:contents;cursor:pointer"><h2 class="music" style="grid-gap:5px;color:#'.$claninfo["color"].'">'.$claninfo["clan"].$own.'</h2></button>';
}
$dl->printSong('<div class="form profileform">
    	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;">
        	'.$back.'
              <div style="display: flex;flex-direction: column;align-items: center;margin:5px 0px 10px 0px">'.$maybeban.$clan.'</div>'.$msgtopl.$points.$discordbtn.'
        </div>
        <div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$all.'</div>
        <div class="form-control dmbox" style="overflow-wrap: anywhere;display: flex;border-radius: 30px;margin-top: 20px;flex-wrap: wrap;padding-top: 0;max-height: 45vh;padding-bottom: 10px;min-width: 100%;height: max-content;margin-bottom: 17px;align-items: center;">
        	'.$comments.'
        </div>
		'.$send.'
</div></div>
<script>
function reply(id) {
	document.getElementById("spin" + id).style.display = "block";
	replies = new XMLHttpRequest();
    replies.open("GET", "profile/replies.php?id=" + id, true);
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
	replies.send();
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
		repsend.open("GET", "profile/replies.php?id=" + id + "&body=" + input.value, true);
		repsend.onload = function () {
			if(repsend.response == 1) {
				document.getElementById("spin" + id).style.display = "none";
				replyCount++;
				input.value = "";
				document.getElementById("btninput" + id).removeAttribute("disabled");
				document.getElementById("btninput" + id).classList.remove("btn-block");
				document.getElementById("reply" + id).innerHTML = "";
				document.getElementById("replyBtn" + id).innerHTML = \'<button id="btnreply\' +  id+ \'" onclick="reply(\' +  id+ \')" class="btn-rendel" style="padding: 7 10;margin-right: 5px;min-width: max-content;width: max-content">'.$dl->getLocalizedString("replies").' (\' + replyCount + \')</button>\';
				reply(id);
			}
		}
		repsend.send();
	}
}
function deleteReply(rid, id) {
	document.getElementById("spin" + id).style.display = "block";
	del = new XMLHttpRequest();
    del.open("GET", "profile/replies.php?id=" + rid + "&delete=1", true);
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
	del.send();
}
function b64DecodeUnicode(str) {
    return decodeURIComponent(atob(str).split(\'\').map(function(c) {
        return \'%\' + (\'00\' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(\'\'));
}
</script>', 'profile');
?>