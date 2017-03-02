<?php
//error_reporting(0);
include "connection.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
if($_POST["accountID"]){
	$accountID = $ep->remove($_POST["accountID"]);
}else{
	$accountID = $ep->remove($_POST["udid"]);
}

$type = $ep->remove($_POST["type"]);
if($type == "top" OR $type == "creators" OR $type == "relative"){
	if($type == "top"){
	$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY stars DESC LIMIT 100";
	}
	if($type == "creators"){
	$query = "SELECT * FROM users WHERE isBanned = '0' ORDER BY creatorPoints DESC LIMIT 100";
	}
	if($type == "relative"){
	$query = "SELECT * FROM users WHERE extID = :accountID";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	$user = $result[0];
	$stars = $user["stars"];
	if($_POST["count"]){
		$count = $ep->remove($_POST["count"]);
	}else{
		$count = 50;
	}
	$count = floor($count / 2);
	$query = "SELECT  A.* FROM  (
   (
      SELECT  *  FROM users
      WHERE stars <= :stars
	  AND isBanned = 0
      ORDER BY stars DESC
      LIMIT $count
   )
  UNION
   (
      SELECT * FROM users
      WHERE stars >= :stars
	  AND isBanned = 0
      ORDER BY stars ASC
      LIMIT $count
   )

 ) as A
ORDER BY A.stars DESC";
	}
	$query = $db->prepare($query);
	$query->execute([':stars' => $stars, ':count' => $count]);
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
                    SELECT @rownum := @rownum + 1 AS rank, stars, extID, isBanned
                    FROM users WHERE isBanned = '0' ORDER BY stars DESC
                    ) as result WHERE extID=:extid";
		$query = $db->prepare($f);
		$query->execute([':extid' => $extid]);
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
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"]."";
}
}
if($type == "friends"){
	$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();
	$people = "";
	foreach ($result as &$friendship) {
		$person = $friendship["person1"];
		if($friendship["person1"] == $accountID){
			$person = $friendship["person2"];
		}
		$people = $people." OR extID = ".$person;
	}
	$query = "SELECT * FROM users WHERE extID = :accountID ".$people . " ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
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
	echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"]."";
}
}
?>