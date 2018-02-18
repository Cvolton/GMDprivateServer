<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$gjp = $ep->remove($_POST["gjp"]);
$extid = $ep->remove($_POST["targetAccountID"]);
if(!empty($_POST["accountID"])){
	$me = $ep->remove($_POST["accountID"]);
	$GJPCheck = new GJPCheck(); //gjp check
	$gjpresult = $GJPCheck->check($gjp,$me);
	if($gjpresult != 1){
		exit("-1");
	}
}else{
	$me = 0;
}
//checking who has blocked him
$query = "SELECT count(*) FROM blocks WHERE (person1 = :extid AND person2 = :me) OR (person2 = :extid AND person1 = :me)";
$query = $db->prepare($query);
$query->execute([':extid' => $extid, ':me' => $me]);
if($query->fetchColumn() > 0){
	exit("-1");
}
	$query = "SELECT * FROM users WHERE extID = :extid";
	$query = $db->prepare($query);
	$query->execute([':extid' => $extid]);
	$user = $query->fetch();
	//placeholders
	$creatorpoints = round($user["creatorPoints"], PHP_ROUND_HALF_DOWN);
	// GET POSITION
	$e = "SET @rownum := 0;";
	$query = $db->prepare($e);
	$query->execute();
	$f = "SELECT rank FROM (
                    SELECT @rownum := @rownum + 1 AS rank, extID
                    FROM users WHERE isBanned = '0' AND gameVersion > 19 AND stars > 25 ORDER BY stars DESC
                    ) as result WHERE extID=:extid";
	$query = $db->prepare($f);
	$query->execute([':extid' => $extid]);
	$rank = $query->fetchColumn();
	//var_dump($leaderboard);
		//accinfo
			$query = "SELECT youtubeurl,twitter,twitch, frS, mS, cS FROM accounts WHERE accountID = :extID";
			$query = $db->prepare($query);
			$query->execute([':extID' => $extid]);
			$accinfo = $query->fetch();
			$reqsstate = $accinfo["frS"];
			$msgstate = $accinfo["mS"];
			$commentstate = $accinfo["cS"];
			$badge = $gs->getMaxValuePermission($extid, "modBadgeLevel");
	if($me==$extid){
		/* notifications */
			//friendreqs
				$query = "SELECT count(*) FROM friendreqs WHERE toAccountID = :me";
				$query = $db->prepare($query);
				$query->execute([':me' => $me]);
				$requests = $query->fetchColumn();
			//messages
				$query = "SELECT count(*) FROM messages WHERE toAccountID = :me AND isNew=0";
				$query = $db->prepare($query);
				$query->execute([':me' => $me]);
				$pms = $query->fetchColumn();
			//friends
				$query = "SELECT count(*) FROM friendships WHERE (person1 = :me AND isNew2 = '1') OR  (person2 = :me AND isNew1 = '1')";
				$query = $db->prepare($query);
				$query->execute([':me' => $me]);
				$friends = $query->fetchColumn();
		/* sending the data */
			//38,39,40 are notification counters
			//18 = enabled (0) or disabled (1) messaging
			//19 = enabled (0) disabled (1) friend requests
			//31 = isnt (0) or is (1) friend or (3) incoming request or (4) outgoing request
			//:32:9558256:35:XiB0cnU=:37:3 months
			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:".$user["diamonds"].":4:".$user["demons"].":8:".$creatorpoints.":18:".$msgstate.":19:".$reqsstate.":50:".$commentstate.":20:".$accinfo["youtubeurl"].":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:".$user["accSpider"].":47:".$user["accExplosion"].":30:".$rank.":16:".$user["extID"].":31:0:44:".$accinfo["twitter"].":45:".$accinfo["twitch"].":38:".$pms.":39:".$requests.":40:".$friends.":29:1:49:".$badge;
	}else{
		/* friend state */
			$friendstate=0;
		//check if INCOING friend request
			$query = "SELECT ID,comment,uploadDate FROM friendreqs WHERE accountID = :extid AND toAccountID = :me";
			$query = $db->prepare($query);
			$query->execute([':extid' => $extid, ':me' => $me]);
			$INCrequests = $query->rowCount();
			$INCrequestinfo = $query->fetch();
			$uploaddate = date("d/m/Y G.i", $INCrequestinfo["uploadDate"]);;
			if($INCrequests > 0){
				$friendstate=3;
			}
		//check if OUTCOMING friend request
			$query = "SELECT count(*) FROM friendreqs WHERE toAccountID = :extid AND accountID = :me";
			$query = $db->prepare($query);
			$query->execute([':extid' => $extid, ':me' => $me]);
			$OUTrequests = $query->fetchColumn();
			if($OUTrequests > 0){
				$friendstate=4;
			}
		//check if friend ALREADY
			$query = "SELECT count(*) FROM friendships WHERE (person1 = :me AND person2 = :extID) OR (person2 = :me AND person1 = :extID)";
			$query = $db->prepare($query);
			$query->execute([':me' => $me, ':extID' => $extid]);
			$frs = $query->fetchColumn();
			if($frs > 0){
				$friendstate=1;
			}
		/* sending the data */
		//$friendstate is :31:
		//$reqsstate is :19:
		echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:".$user["diamonds"].":4:".$user["demons"].":8:".$creatorpoints.":18:0:19:".$reqsstate.":50:".$commentstate.":20:".$accinfo["youtubeurl"].":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:".$user["accSpider"].":47:".$user["accExplosion"].":30:".$rank.":16:".$user["extID"].":31:".$friendstate.":44:".$accinfo["twitter"].":45:".$accinfo["twitch"].":29:1:49:".$badge;
		if ($INCrequests > 0){
			echo ":32:".$INCrequestinfo["ID"].":35:".$INCrequestinfo["comment"].":37:".$uploaddate;
		}
	}
?>