<?php
session_start();
include "../../incl/lib/connection.php";
include "../../incl/lib/exploitPatch.php";
include "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->printFooter('../');
if(!isset($_SESSION["accountID"]) OR $_SESSION["accountID"] == 0 AND empty($_POST["accountID"])) {
  	$dl->title($dl->getLocalizedString("profile"));
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard/login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'profile');
  	die();
}
if(!empty($_POST["accountID"])) $accid = ExploitPatch::number($_POST["accountID"]); else $accid = $_SESSION["accountID"];
$accname = $gs->getAccountName($accid);
$dl->title($accname);
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
          		  <button type="submit" class="btn-primary" name="accountID" value="'.$accid.'">'.$dl->getLocalizedString("tryAgainBTN").'</button>
  				 </form>
			</div>', 'profile');
     die();
    }
	$msg = base64_encode(ExploitPatch::remove($_POST["msg"]));
	$query = $db->prepare("INSERT INTO acccomments (userID, userName, comment, timestamp) VALUES (:id, :name, :msg, :time)");
  	$query->execute([':id' => $gs->getUserID($accid), ':name' => $gs->getAccountName($accid), ':msg' => $msg, ':time' => time()]);
}
$query = $db->prepare("SELECT isBanned, banReason FROM users WHERE extID=:id");
$query->execute([':id' => $accid]);
$query = $query->fetch();
if($query["banReason"] != 'none' OR $query["isBanned"] == 1) $maybeban = '<h1 style="text-decoration:line-through;color:#432529">'.$accname.'</h1>'; else $maybeban = '<h1 style="color:rgb('.$gs->getAccountCommentColor($accid).')">'.$accname.'</h1>';
if(isset($_SERVER["HTTP_REFERER"])) $back = '<form method="post" action="'.$_SERVER["HTTP_REFERER"].'"><button class="goback"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button></form>'; else $back = '';
$query = $db->prepare("SELECT extID, stars, demons, coins, userCoins, creatorPoints, diamonds, isCreatorBanned FROM users WHERE extID=:id");
$query->execute([':id' => $accid]);
$res = $query->fetch();
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
  	$message = base64_decode($msg["comment"]);
  	$time = $msg["timestamp"];
  	$likes = $msg["likes"];
  	if($likes >= 0) $likes = $likes.' <i class="fa-regular fa-thumbs-up"></i>'; else $likes = mb_substr($likes, 1).' <i class="fa-regular fa-thumbs-down"></i>';
  	$comments .= '<div class="profile"><div style="display:flex"><h2 class="profilenick">'.$accname.'</h2><p style="text-align:right">'.$likes.'</p></div>
			<h3 class="profilemsg">'.$message.'</h3>
			<h3 id="comments">'.$dl->convertToDate($time).'<h3></div>';
}
if(empty($comments)) $comments = '<p class="profile" style="font-size:25px;color:#c0c0c0">'.$dl->getLocalizedString("empty").'</p>';
$msgtopl = '<form method="post" action="messenger/"><button class="msgupd" name="accountID" value="'.$accid.'"><i class="fa-regular fa-comment" aria-hidden="true"></i></button></form>';
if($accid == $_SESSION["accountID"]) {
if(empty($comments)) $comments = '<p class="profile" style="font-size:25px;color:#c0c0c0">'.$dl->getLocalizedString("writeSomething").'</p>';
$send = '<div class="field" style="margin-top:10px">
			<form method="post" action=""><input type="text" name="msg" placeholder="'.$dl->getLocalizedString("msg").'"></input>
			<button style="margin-top: 10px;" class="btn-primary">'.$dl->getLocalizedString("send").'</button></form>
		</div>';
$msgtopl = '';
}
$dl->printSong('<div class="form" style="width: 60vw;height: max-content">
    	<div style="height: 100%;width: 100%;"><div style="display: flex;align-items: center;justify-content: center;">
        	'.$back.'
              <h1>'.$maybeban.'</h1>'.$msgtopl.'
        </div>
        <div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$all.'</div>
        <div class="form-control dmbox" style="display: flex;border-radius: 30px;margin-top: 20px;flex-wrap: wrap;padding-top: 0;max-height: 535px;padding-bottom: 10px;min-width: 100%;height: max-content;margin-bottom: 17px;align-items: center;">
        	'.$comments.'
        </div>
		'.$send.'
        
</div></div>', 'profile');
?>
