<?php
include "connection.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$levelsstring = "";
$songsstring  = "";
$getSent = $ep->remove($_POST["getSent"]);
$accountID = $ep->remove($_POST["accountID"]);
$page = $ep->remove($_POST["page"]);
if($getSent == 0){
	$query = "SELECT * FROM friendreqs WHERE toAccountID = :accountID";
}else if($getSent == 1){
	$query = "SELECT * FROM friendreqs WHERE accountID = :accountID";
}
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
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
	$query = "SELECT * FROM users WHERE extID = :requester";
	$query = $db->prepare($query);
	$query->execute([':requester' => $requester]);
	$result2 = $query->fetchAll();
	$user = $result2[0];
	$uploadTime = date("d/m/Y G.i", $request["uploadDate"]);
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
	echo "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":32:".$request["ID"].":35:".$request["comment"].":41:1:37:".$uploadTime;

}
	echo "#".$requests.":".$startreqs.":".$shownreqs;
?>