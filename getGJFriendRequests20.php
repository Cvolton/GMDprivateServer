<?php
include "connection.php";
$levelsstring = "";
$songsstring  = "";
$getSent = explode("(", explode(";", htmlspecialchars($_POST["getSent"],ENT_QUOTES))[0])[0];
$accountID = explode("(", explode(";", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0];
$page = explode("(", explode(";", htmlspecialchars($_POST["page"],ENT_QUOTES))[0])[0];
if($getSent == 0){
	$query = "SELECT * FROM friendreqs WHERE toAccountID = '$accountID'";
}else if($getSent == 1){
	$query = "SELECT * FROM friendreqs WHERE accountID = '$accountID'";
}
	$query = $db->prepare($query);
	$query->execute();
	$requests = $query->rowCount();
	$result = $query->fetchAll();
	$startreqs = $page*10;
	$finalreqs = $page+1;
	$finalreqs = $finalreqs*10;
	$finalreqs = $finalreqs-1;
	if($finalreqs > $requests){
		$shownreqs = $requests;
	}else{
		$shownreqs = $finalreqs;
	}
	for ($x = $startreqs; $x < $requests; $x++) {
	if($x != 0){
		echo "|";
	}
	$request = $result[$x];
if($getSent == 0){
	$requester = $request["accountID"];
}else if($getSent == 1){
	$requester = $request["toAccountID"];
}
	$query = "SELECT * FROM users WHERE extID = '$requester'";
	$query = $db->prepare($query);
	$query->execute();
	$result2 = $query->fetchAll();
	$user = $result2[0];
	$uploadTime = 0;
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
	echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":32:".$request["ID"].":35:".$request["comment"].":41:1:37:".$uploadTime;

}
	echo "#".$requests.":".$startreqs.":".$shownreqs;
?>