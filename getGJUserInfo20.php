<?php
include "connection.php";
$me = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$extid = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
//checking who has blocked him
$query = "SELECT * FROM blocks WHERE person1 = :extid AND person2 = :me";
$query = $db->prepare($query);
$query->execute([':extid' => $extid, ':me' => $me]);
if($query->rowCount() > 0){
	exit(-1);
}
$query = "SELECT * FROM blocks WHERE person2 = :extid AND person1 = :me";
$query = $db->prepare($query);
$query->execute([':extid' => $extid, ':me' => $me]);
if($query->rowCount() > 0){
	exit(-1);
}
	$query = "SELECT * FROM users WHERE extID = :extid";
	$query = $db->prepare($query);
	$query->execute([':extid' => $extid]);
	$result = $query->fetchAll();
	$user = $result[0];
	//placeholders
	$creatorpoints = $user["creatorPoints"];
	$youtubeurl = $accinfo["youtubeurl"];
	// GET POSITION
	$e = "SET @rownum := 0;";
	$query = $db->prepare($e);
	$query->execute();
	$f = "SELECT rank, stars FROM (
                    SELECT @rownum := @rownum + 1 AS rank, stars, extID
                    FROM users ORDER BY stars DESC
                    ) as result WHERE extID=:extid";
	$query = $db->prepare($f);
	$query->execute([':extid' => $extid]);
	$leaderboard = $query->fetchAll();
	$leaderboard = $leaderboard[0];
	$rank = $leaderboard["rank"];
	//var_dump($leaderboard);
			//check if friend REQUESTS allowed
			$query = "SELECT * FROM accounts WHERE accountID = :me";
			$query = $db->prepare($query);
			$query->execute([':me' => $me]);
			$result = $query->fetchAll();
			$account = $result[0];
			$reqsstate = $account["frS"];
		//check if messaging allowed
			//$msgstate = 0;
			$msgstate = $account["mS"];
	if($me==$extid){
		/* notifications */
			//friendreqs
				$query = "SELECT * FROM friendreqs WHERE toAccountID = :me";
				$query = $db->prepare($query);
				$query->execute([':me' => $me]);
				$requests = $query->rowCount();
			//messages
				$query = "SELECT * FROM messages WHERE toAccountID = :me AND isNew=0";
				$query = $db->prepare($query);
				$query->execute([':me' => $me]);
				$pms = $query->rowCount();
			//friends
				$query = "SELECT * FROM friendships WHERE person1 = :me OR person2=:me";
				$query = $db->prepare($query);
				$query->execute([':me' => $me]);
				$friendArray = $query->fetchAll();
				$friends = 0;
				foreach ($friendArray as &$friendship) {
					if($friendship["person1"] == $me){
						if($friendship["isNew2"] == 1){
							$friends++;
						}
					}
					if($friendship["person2"] == $me){
						if($friendship["isNew1"] == 1){
							$friends++;
						}
					}
				}
		/* sending the data */
			//38,39,40 are notification counters
			//18 = enabled (0) or disabled (1) messaging
			//19 = enabled (0) disabled (1) friend requests
			//31 = isnt (0) or is (1) friend or (3) incoming request or (4) outgoing request
			//:32:9558256:35:XiB0cnU=:37:3 months
			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:".$user["diamonds"].":4:".$user["demons"].":8:".$creatorpoints.":18:".$msgstate.":19:".$reqsstate.":20:".$youtubeurl.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:".$user["accSpider"].":47:".$user["accExplosion"].":30:".$rank.":16:".$user["extID"].":31:0:44:".$account["twitter"].":45:".$result["twitch"].":38:".$pms.":39:".$requests.":40:".$friends.":29:1";
	}else{
		/* friend state */
			$friendstate=0;
		//check if INCOING friend request
			$query = "SELECT * FROM friendreqs WHERE accountID = :extid AND toAccountID = :me";
			$query = $db->prepare($query);
			$query->execute([':extid' => $extid, ':me' => $me]);
			$INCrequests = $query->rowCount();
			$INCrequestinfo = $query->fetchAll();
			$uploaddate = 0;
			if($INCrequests > 0){
				$friendstate=3;
			}
		//check if OUTCOMING friend request
			$query = "SELECT * FROM friendreqs WHERE toAccountID = :extid AND accountID = :me";
			$query = $db->prepare($query);
			$query->execute([':extid' => $extid, ':me' => $me]);
			$OUTrequests = $query->rowCount();
			$OUTrequestinfo = $query->fetchAll();
			$uploaddate = 0;
			if($OUTrequests > 0){
				$friendstate=4;
			}
		//check if friend ALREADY
			$query = "SELECT * FROM friendships WHERE person1 = :me AND person2 = :extID";
			$query = $db->prepare($query);
			$query->execute([':me' => $me, ':extID' => $extid]);
			$frs = $query->rowCount();
			if($frs > 0){
				$friendstate=1;
			}else{
				$query = "SELECT * FROM friendships WHERE person2 = :me AND person1 = :extID";
				$query = $db->prepare($query);
				$query->execute([':me' => $me, ':extID' => $extid]);
				$frs = $query->rowCount();
				if($frs > 0){
					$friendstate=1;
				}
			}
		/* sending the data */
		//$friendstate is :31:
		//$reqsstate is :19:
		echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:".$user["diamonds"].":4:".$user["demons"].":8:".$creatorpoints.":18:0:19:".$reqsstate.":20:".$youtubeurl.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:".$user["accSpider"].":47:".$user["accExplosion"].":30:".$rank.":16:".$user["extID"].":31:".$friendstate.":44:".$account["twitter"].":45:".$result["twitch"].":29:1";
		if ($INCrequests > 0){
			$request = $INCrequestinfo[0];
			echo ":32:".$request["ID"].":35:".$request["comment"].":37:".$uploaddate;
		}
		}
?>