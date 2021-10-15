<?php
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
$playername = ExploitPatch::remove($_GET["player"]);
//checking who has blocked him
$query = "SELECT * FROM users WHERE userName = :userName OR userID = :userName ORDER BY stars DESC LIMIT 1";
$query = $db->prepare($query);
$query->execute([':userName' => $playername]);
if($query->rowCount() == 0){
	$query = "SELECT * FROM users WHERE userName LIKE CONCAT(:str, '%') ORDER BY stars DESC LIMIT 1";
	$query = $db->prepare($query);
	$query->execute([':str' => $playername]);
	if($query->rowCount() == 0){
		exit("No account with this or a similiar name has been found");
	}
}
	$result = $query->fetchAll();
	$user = $result[0];
	//placeholders
	$creatorpoints = $user["creatorPoints"];
	// GET POSITION
	$e = "SET @rownum := 0;";
	$query = $db->prepare($e);
	$query->execute();
	$extid = $user["extID"];
	$f = "SELECT rank, stars FROM (
                    SELECT @rownum := @rownum + 1 AS rank, stars, extID, isBanned
                    FROM users WHERE isBanned = '0' AND gameVersion > 19 ORDER BY stars DESC
                    ) as result WHERE extID=:extid";
	$query = $db->prepare($f);
	$query->execute([':extid' => $extid]);
	$rank = $query->fetchColumn();
	$e = "SET @rownum := 0;";
	$query = $db->prepare($e);
	$query->execute();
	$f = "SELECT rank, creatorPoints FROM (
                    SELECT @rownum := @rownum + 1 AS rank, creatorPoints, extID, isCreatorBanned
                    FROM users WHERE isCreatorBanned = '0' ORDER BY creatorPoints DESC
                    ) as result WHERE extID=:extid";
	$query = $db->prepare($f);
	$query->execute([':extid' => $extid]);
	$crearank = $query->fetchColumn();
	$query = "SELECT * FROM accounts WHERE accountID = :extID";
	$query = $db->prepare($query);
	$query->execute([':extID' => $extid]);
	$accinfo = $query->fetch();
	$discordID = 0;
		echo "**Name:** ".$user["userName"].
		"\r\n**User ID:** ".$user["userID"];
		if(is_numeric($extid)){
			echo "\r\n**Account ID:** " . $extid;
			$query = $db->prepare("SELECT discordID FROM accounts WHERE accountID = :extid");
			$query->execute([':extid' => $extid]);
			$discordID = $query->fetchColumn();
		}
		echo "\r\n**------------------------------------**".
		"\r\n**Stars:** ".$user["stars"].
		"\r\n**Coins:** ".$user["coins"].
		"\r\n**User Coins:** ".$user["userCoins"].
		"\r\n**Diamonds:** ".$user["diamonds"].
		"\r\n**Demons: **".$user["demons"].
		"\r\n**Orbs: **".$user["orbs"].
		"\r\n**Completed Levels: **".$user["completedLvls"].
		"\r\n**Creator points:** ".$creatorpoints.
		"\r\n**------------------------------------**".
		"\r\n**Leaderboards rank:** ".$rank.
		"\r\n**Creator leaderboards rank:** ".$crearank.
		"\r\n**------------------------------------**";
		if($accinfo["youtubeurl"] != ""){
			echo "\r\n**YouTube:** http://youtube.com/channel/".$accinfo["youtubeurl"];
		}
		if($accinfo["twitter"] != ""){
			echo "\r\n**Twitter:** http://twitter.com/".$accinfo["twitter"];
		}
		if($accinfo["twitch"] != ""){
			echo "\r\n**Twitch:** http://twitch.tv/".$accinfo["twitch"]."";
		}
		if($discordID == 0){
			echo "\r\n**Discord:** None";
		}else{
			echo "\r\n**Discord:** " . $gs->getDiscordAcc($discordID) . " ($discordID)";
		}
?>