<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/exploitPatch.php";
require "../incl/XOR.php";
$xor = new XORCipher();
global $msgEnabled;
$dl->printFooter('../');
if(!isset($_POST["accountID"])) $_POST["accountID"] = 0;
if(!isset($_POST["receiver"])) $_POST["receiver"] = 0;
if($msgEnabled == 1) {
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
  	$newMsgs = $_SESSION["msgNew"];
	$accid = $_SESSION["accountID"];
	$notyou = ExploitPatch::number($_POST["accountID"]);
  	if(!isset($_GET["id"])) {
		if(empty($notyou)) {
			if(is_numeric($_POST["receiver"])) $notyou = ExploitPatch::number($_POST["receiver"]);
			else $notyou = $gs->getAccountIDFromName(ExploitPatch::remove($_POST["receiver"]));
		} 
	} else {
		$getID = str_replace('%20', ' ', explode("/", $_GET["id"])[count(explode("/", $_GET["id"]))-1]);
		$notyou = ExploitPatch::charclean($getID);
		if(is_numeric($notyou)) $notyou = ExploitPatch::number($notyou);
		else $notyou = $gs->getAccountIDFromName(ExploitPatch::charclean($notyou));
	}
  	$check = $gs->getAccountName($notyou);
 	if(empty($check) OR $notyou == $accid) $dl->title($dl->getLocalizedString("messenger")); else $dl->title($dl->getLocalizedString("messenger").", ".$check);
	if(!empty($notyou) AND is_numeric($notyou) AND $notyou != 0 AND $notyou != $accid AND !empty($check)) {
	    $checkmsg = $db->prepare("SELECT mS FROM accounts WHERE accountID = :id");
		$checkmsg->execute([':id' => $notyou]);
		$checkmsg = $checkmsg->fetch();
		if($checkmsg["mS"] == 1) {
		    if(!$gs->isFriends($notyou, $_SESSION["accountID"])) exit($dl->printSong('<div class="form">
              <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
         	   <form class="form__inner" method="post" action="">
        	  <p>'.$dl->getLocalizedString("cantMessage").'</p>
        	  <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("dashboard").'</button>
  		 </form>
		</div>'));
		} elseif($checkmsg["mS"] == 2) exit($dl->printSong('<div class="form">
                	   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
               	 	   <form class="form__inner" method="post" action="">
              		  <p>'.$dl->getLocalizedString("cantMessage").'</p>
              		  <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("dashboard").'</button>
      				 </form>
    			</div>'));
		   else {
    	    $block = $db->prepare("SELECT * FROM blocks WHERE person1 = :p1 AND person2 = :p2");
            $block->execute([':p1' => $notyou, ':p2' => $_SESSION["accountID"]]);
            $block = $block->fetch();
            if(!empty($block)) exit($dl->printSong('<div class="form">
                	   <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
               	 	   <form class="form__inner" method="post" action="">
              		  <p>'.$dl->getLocalizedString("cantMessage").'</p>
              		  <button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("dashboard").'</button>
      				 </form>
    			</div>'));
		}
		if(!empty($_POST["subject"]) AND !empty($_POST["msg"])) {
			$checkBan = $gs->getPersonBan($accid, $gs->getUserID($accid, $gs->getAccountName($accid)), 3);
			if($checkBan) exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" action="" method="post">
				<p>'.sprintf($dl->getLocalizedString("youAreBanned"), htmlspecialchars(base64_decode($checkBan['reason'])), date("d.m.Y G:i", $checkBan['expires'])).'</p>
				<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
				</form>
			</div>'));
			$sendsub = ExploitPatch::url_base64_encode(strip_tags(ExploitPatch::rucharclean($_POST["subject"])));
          	$query = $db->prepare("SELECT timestamp FROM messages WHERE accID=:accid AND toAccountID=:toaccid ORDER BY timestamp DESC LIMIT 1");
          	$query->execute([':accid' => $accid, ':toaccid' => $notyou]);
          	$res = $query->fetch();
          	$time = time() - 3;
          	if($res["timestamp"] > $time) {
     			   $dl->printSong('<div class="form">
            	        <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
           	 	        <form class="form__inner" method="post" action="">
          		          <p>'.$dl->getLocalizedString("tooFast").'</p>
          		          <button type="button" onclick="a(\'messenger/'.$check.'\', true, true, \'POST\')" class="btn-primary" name="accountID" value="'.$notyou.'">'.$dl->getLocalizedString("tryAgainBTN").'</button>
  						  </form>
					</div>', 'msg');
              die();
            }
			$sendmsg = ExploitPatch::url_base64_encode($xor->cipher(strip_tags(ExploitPatch::rucharclean($_POST["msg"])), 14251));
			$query = $db->prepare("INSERT INTO messages (userID, userName, body, subject, accID, toAccountID, timestamp, secret, isNew)
			VALUES (:uid, :nick, :body, :subject, :accid, :notyou, :time, 'Wmfd2893gb7', '0')");
			$query->execute([':uid' => $gs->getUserID($accid), ':nick' => $gs->getAccountName($accid), ':body' => $sendmsg, ':subject' => $sendsub, ':accid' => $accid, ':notyou' => $notyou, 'time' => time()]);
		}
		$query = $db->prepare("SELECT * FROM messages WHERE accID=:you AND toAccountID=:notyou OR accID=:notyou AND toAccountID=:you ORDER BY messageID DESC");
		$query->execute([':you' => $accid, ':notyou' => $notyou]);
		$res = $query->fetchAll();
		$msgs = '';
		foreach($res as $i => $msg) {
			if($msg["accID"] == $accid) $div = 'you';
            else $div = 'notyou';
			$subject = ExploitPatch::url_base64_decode($msg["subject"]);
			$body = $xor->plaintext(ExploitPatch::url_base64_decode($msg["body"]), 14251);
			$msgs .= '<div class="message '.$div.'"><div class="messenger'.$div.'"><h2 class="subject'.$div.'">'.htmlspecialchars($subject).'</h2>
			<h3 class="message'.$div.'">'.htmlspecialchars($body).'</h3>
			<h3 id="comments" style="justify-content:flex-end">'.$dl->convertToDate($msg["timestamp"], true).'</h3></div></div>';
		}
		if(count($res) == 0) {
			$msgs .= '<div class="messenger"><p>'.$dl->getLocalizedString("noMsgs").'</p></div>';
		}
        $_SESSION["msgNew"] = $newMsgs = 0;
        $dl->printSong('<div class="form messengerbox">
			<div style="display: inherit;align-items: center;margin: -5px -5px 15px -5px;">
              <button type="button" onclick="a(\'profile/'.$check.'\', true, true, \'GET\')" class="goback" name="accountID" value="'.$notyou.'"><i class="fa-regular fa-user" aria-hidden="true"></i></button>
              <button type="button" class="a a-btn" onclick="a(\'messenger\', true)"><h1>'.$check.'</h1></button>
              <button type="button" onclick="a(\'messenger/'.$check.'\', true, true, \'GET\')" class="msgupd" name="accountID" value="'.$notyou.'"><i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i></button>
            </div>
			<form class="form__inner" method="post" action="">
				<div class=" form-control new-form-control dmbox list" style="margin: 0px">'.$msgs.'</div>
			</form>
			<form class="form__inner" method="post" action="">
				<div class="field"><input type="text" name="subject" id="p1" placeholder="'.$dl->getLocalizedString("subject").'"></input></div>
				<div class="field"><input type="text" name="msg" id="p2" placeholder="'.$dl->getLocalizedString("msg").'"></input></div>
				<input type="hidden" name="accountID" value="'.$notyou.'"></input>
			<button type="button" onclick="a(\'messenger/'.$check.'\', true, true, \'POST\')"; class="btn-primary btn-block" id="submit" disabled>'.$dl->getLocalizedString("send").'</button></form></div>
        <script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const btn = document.getElementById("submit");
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
			var notify = '.$newMsgs.';
            var elem = document.getElementById("notify");
            if(notify == 0) elem.parentNode.removeChild(elem);
        </script>', 'msg');
		$query = $db->prepare("UPDATE messages SET isNew=1 WHERE accID=:notyou AND toAccountID=:you");
		$query->execute([':you' => $accid, ':notyou' => $notyou]);
	} else {
		$query = $db->prepare("SELECT * FROM friendships WHERE person1=:acc OR person2=:acc");
		$query->execute([':acc' => $accid]);
		$result = $query->fetchAll();
		$options = '';
		foreach ($result as $i => $row) {
			if($row["person1"] == $accid) {
				$receiver = $gs->getAccountName($row["person2"]);
				$recid = $row["person2"];
			}
			else {
				$receiver = $gs->getAccountName($row["person1"]);
				$recid = $row["person1"];
			}
            $new = $db->prepare("SELECT count(isNew) FROM messages WHERE accID=:toid AND toAccountID=:id AND isNew=0");
          	$new->execute([':id' => $accid, ':toid' => $recid]);
          	$new2 = $new->fetchColumn();
          	$notify = '';
            if($new2 != 0) $notify = '<i class="fa fa-circle" aria-hidden="true" style="font-size: 10px;margin-left:5px;color: #e35151;"></i>';
			$options .= '<div class="messenger msgs"><text class="receiver">'.$receiver.''.$notify.'</text><br>
			<button type="button" onclick="a(\'messenger/'.$gs->getAccountName($recid).'\', true, true)" class="btn-rendel" style="margin-top:5px;width:100%">'.$dl->getLocalizedString("write").'</button></div>';
		}
		if(strpos($options, '<i class="fa fa-circle" aria-hidden="true" style="font-size: 10px;margin-left:5px;color: #e35151;"></i>') === FALSE AND $_SESSION["msgNew"] == 1) {
			$query = $db->prepare("SELECT accID FROM messages WHERE toAccountID=:acc AND isNew=0");
			$query->execute([':acc' => $accid]);
			$result = $query->fetchAll();
			foreach ($result as $i => $row) {
				$receiver = $gs->getAccountName($row["accID"]);
				$recid = $row["accID"];
				$notify = '<i class="fa fa-circle" aria-hidden="true" style="font-size: 10px;margin-left:5px;color: #e35151;"></i>';
				$options .= '<div class="messenger msgs"><text class="receiver">'.$receiver.''.$notify.'</text><br>
				<button type="button" onclick="a(\'messenger/'.$gs->getAccountName($recid).'\', true, true)" class="btn-rendel" style="margin-top:5px;width:100%">'.$dl->getLocalizedString("write").'</button></div>';
			}
		}
      	if(empty($options)) $options = '<div class="icon" style="height: 70px;width: 70px;margin: 0px;background:#36393e"><text class="receiver" style="font-size:50px"><i class="fa-regular fa-face-sad-cry"></i></text></div>';
		$dl->printSong('<div class="form messengerbox">
			<h1>'.$dl->getLocalizedString("messenger").'</h1>
			<form class="form__inner" method="post" action="messenger/">
			<div class="form-control new-form-control msgbox list">
				'.$options.'
			</div>
			</form>
            <form class="field" method="post" action="messenger/">
            <div class="messenger"><input class="field" id="p1" type="text" name="receiver" placeholder="'.$dl->getLocalizedString("banUserID").'"></input>
			<input type="hidden" id="p2" value="Sus amongus" placeholder="It breaks something, so keep it hidden"></input>
            <button type="button" onclick="a(\'messenger\', true, false, \'POST\')"; class="btn-rendel btn-block" id="submit" style="margin-top:5px" disabled>'.$dl->getLocalizedString("write").'</button></div></form>
		<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-rendel");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-rendel");
	}
});
			var notify = '.$newMsgs.';
            var elem = document.getElementById("notify");
            if(notify == 0) elem.parentNode.removeChild(elem);
        </script>', 'msg');
		}
} else {
  	$dl->title($dl->getLocalizedString("messenger"));
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\', true, true, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'msg');
}
} else {
  		$dl->title($dl->getLocalizedString("messenger"));
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, true, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>');
}
?>