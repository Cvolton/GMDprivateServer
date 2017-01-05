<?php
include "connection.php";
	//$me = 249;
	//$extid=249;
	$me = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
	$extid = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
	$query = "SELECT * FROM users WHERE extID = '".$extid."'";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$user = $result[0];
	//placeholders
	$creatorpoints = $user["creatorPoints"];
	$youtubeurl = "";
	// GET POSITION
	$e = "SET @rownum := 0;";
	$query = $db->prepare($e);
	$query->execute();
	$f = "SELECT rank, stars FROM (
                    SELECT @rownum := @rownum + 1 AS rank, stars, extID
                    FROM users ORDER BY stars DESC
                    ) as result WHERE extID='$extid'";
	$query = $db->prepare($f);
	$query->execute();
	$leaderboard = $query->fetchAll();
	$leaderboard = $leaderboard[0];
	$rank = $leaderboard["rank"];
	//var_dump($leaderboard);
	if($me==$extid){
		/* notifications */
			//friends
				$query = "SELECT * FROM friendreqs WHERE toAccountID = '$me'";
				$query = $db->prepare($query);
				$query->execute();
				$requests = $query->rowCount();
		/* sending the data */
			//38,39,40 are notification counters
			//18 = enabled (0) or disabled (1) messaging
			//19 = enabled (0) disabled (1) friend requests
			//31 = isnt (0) or is (1) friend or (3) incoming request or (4) outgoing request
			//:32:9558256:35:XiB0cnU=:37:3 months
			echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$creatorpoints.":18:0:19:0:20:".$youtubeurl.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:1:47:1:30:".$rank.":16:".$user["extID"].":31:0:44::45::38:3:39:".$requests.":40:9:29:1";
	}else{
		/* friend state */
			$friendstate=0;
		//check if INCOING friend request
			$query = "SELECT * FROM friendreqs WHERE accountID = '$extid' AND toAccountID = '$me'";
			$query = $db->prepare($query);
			$query->execute();
			$INCrequests = $query->rowCount();
			$INCrequestinfo = $query->fetchAll();
			$uploaddate = 0;
			if($INCrequests > 0){
				$friendstate=3;
			}
		//check if OUTCOMING friend request
			$query = "SELECT * FROM friendreqs WHERE toAccountID = '$extid' AND accountID = '$me'";
			$query = $db->prepare($query);
			$query->execute();
			$OUTrequests = $query->rowCount();
			$OUTrequestinfo = $query->fetchAll();
			$uploaddate = 0;
			if($OUTrequests > 0){
				$friendstate=4;
			}
		//check if friend ALREADY
			$query = "SELECT * FROM accounts WHERE accountID = '$me'";
			$query = $db->prepare($query);
			$query->execute();
			$result = $query->fetchAll();
			$account = $result[0];
			$friendlist = $account["friends"];
			$friendsarray = explode(',',$friendlist);
			if(in_array($extid, $friendsarray, true)){
				$friendstate=1;
			}
		/* sending the data */
		//$friendstate is :31:
		echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$creatorpoints.":18:0:19:0:20:".$youtubeurl.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:1:47:1:30:".$rank.":16:".$user["extID"].":31:".$friendstate.":44::45::29:1";
		if ($INCrequests > 0){
			$request = $INCrequestinfo[0];
			echo ":32:".$request["ID"].":35:".$request["comment"].":37:".$uploaddate;
		}
		}
?>