<?php
error_reporting(0);
include "connection.php";
$accountID = explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0];
$type = explode(";", htmlspecialchars($_POST["type"],ENT_QUOTES))[0];
if($type == "top" OR $type == "creators" OR $type == "relative"){
	if($type == "top"){
	$query = "SELECT * FROM users ORDER BY stars DESC";
	}
	if($type == "creators"){
	$query = "SELECT * FROM users ORDER BY creatorPoints DESC";
	}
	if($type == "relative"){
	$query = "SELECT * FROM users WHERE extID = '$accountID'";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$user = $result[0];
	$stars = $user["stars"];
	$count = explode(";", htmlspecialchars($_POST["count"],ENT_QUOTES))[0];
	$count = $count / 2;
	$query = "SELECT  A.* FROM  (
   (
      SELECT  *  FROM users
      WHERE stars <= $stars
      ORDER BY stars DESC
      LIMIT $count
   )
  UNION
   (
      SELECT * FROM users
      WHERE stars >= $stars
      ORDER BY stars ASC
      LIMIT $count
   )

 ) as A
ORDER BY A.stars DESC";
	}
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$people = $query->rowCount();
	$xy = 1;
	if($type == "relative"){
		$user = $result[0];
		$extid = $user["extID"];
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
		//var_dump($leaderboard);
		$leaderboard = $leaderboard[0];
		$xy = $leaderboard["rank"];
	}
	for ($x = 0; $x < $people; $x++) {
	if($x != 0){
		echo "|";
	}
	$user = $result[$x];
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
$xi = $x + $xy;
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"].":7:".$extid;
}
}
if($type == "friends"){
	$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$account = $result[0];
	$friendlist = $account["friends"];
	$whereor = str_replace(",", " OR extID = ", $friendlist);
	$query = "SELECT * FROM users WHERE extID = ".$accountID." OR extID = ".$whereor . " ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$people = $query->rowCount();
	for ($x = 0; $x < $people; $x++) {
	if($x != 0){
		echo "|";
	}
	$user = $result[$x];
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
	$xi = $x + 1;
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"].":7:".$extid;
}
}
?>		