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
	if($me==$extid){
		//38,39,40 are notification counters
		echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$creatorpoints.":18:0:19:0:20:".$youtubeurl.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:1:47:1:30:69:16:".$user["extID"].":31:0:44::45::38:0:39:0:40:0:29:1";
	}else{
		echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":10:".$user["color1"].":11:".$user["color2"].":3:".$user["stars"].":46:0:4:".$user["demons"].":8:".$creatorpoints.":18:0:19:0:20:".$youtubeurl.":21:".$user["accIcon"].":22:".$user["accShip"].":23:".$user["accBall"].":24:".$user["accBird"].":25:".$user["accDart"].":26:".$user["accRobot"].":28:".$user["accGlow"].":43:1:47:1:30:69:16:".$user["extID"].":31:0:44::45::29:1";
	}
?>