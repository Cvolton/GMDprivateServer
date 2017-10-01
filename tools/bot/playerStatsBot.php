<?php
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$playername = $ep->remove($_GET["player"]);
//checking who has blocked him
$query = "SELECT * FROM users WHERE userName = :userName OR userID = :userName ORDER BY stars DESC LIMIT 1";
$query = $db->prepare($query);
$query->execute([':userName' => $playername]);
if($query->rowCount() == 0){
	$query = "SELECT * FROM users WHERE userName LIKE CONCAT(:str, '%') ORDER BY stars DESC LIMIT 1";
	$query = $db->prepare($query);
	$query->execute([':str' => $playername]);
	if($query->rowCount() == 0){
		exit(":warning: Player not found.");
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
	/*$f = "SELECT rank, creatorPoints FROM (
                    SELECT @rownum := @rownum + 1 AS rank, creatorPoints, extID, isCreatorBanned
                    FROM users WHERE isCreatorBanned = '0' ORDER BY creatorPoints DESC
                    ) as result WHERE extID=:extid";
	$query = $db->prepare($f);
	$query->execute([':extid' => $extid]);
	$leaderboard = $query->fetchAll();
	$leaderboard = $leaderboard[0];																	OK CVOLTON
	$crearank = $leaderboard["rank"];*/
	$query = "SELECT * FROM accounts WHERE accountID = :extID";
	$query = $db->prepare($query);
	$query->execute([':extID' => $extid]);
	$accinfo = $query->fetchAll();
	$accinfo = $accinfo[0];
		echo "`Name`: ".$user["userName"].
		"\r\n`User ID`: ".$user["userID"].
		"\r\n`Stars`: ".$user["stars"].
		"\r\n`Coins`: ".$user["coins"].
		"\r\n`Demons`:".$user["demons"].
		"\r\n`Creator points`: ".$creatorpoints;
		//"\r\n`Leaderboards rank`: ".$rank;
		//"\r\n**Creator leaderboards rank:** ".$crearank;
		if($accinfo["youtubeurl"] != ""){
			echo "\r\n`YouTube:` http://youtube.com/channel/".$accinfo["youtubeurl"];
		}
		if($accinfo["twitter"] != ""){
			echo "\r\n`Twitter:` http://twitter.com/".$accinfo["twitter"];
		}
		if($accinfo["twitch"] != ""){
			echo "\r\n`Twitch:` http://twitch.tv/".$accinfo["twitch"]."";
		}
?>