<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
$generatePass = new generatePass();
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$udid = $ep->remove($_POST["udid"]);
$userName = $ep->remove($_POST["userName"]);
$password = $ep->remove($_POST["password"]);
//registering
$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :userName");
$query->execute([':userName' => $userName]);
if($query->rowCount() == 0){
	exit("-1");
}
$id = $query->fetchColumn();
//rate limiting
$newtime = time() - 3600;
/*$query6 = $db->prepare("SELECT count(*) FROM actions WHERE type = '1' AND timestamp > :time AND value2 = :ip");
$query6->execute([':time' => $newtime, ':ip' => $ip]);
if($query6->fetchColumn() > 5){
	exit("-12");
}*/
//authenticating
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) { //success
	//userID
	$query2 = $db->prepare("SELECT userID FROM users WHERE extID = :id");

	$query2->execute([':id' => $id]);
	if ($query2->rowCount() > 0) {
		$userID = $query2->fetchColumn();
	} else {
		$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName)
		VALUES (1, :id, :userName)");

		$query->execute([':id' => $id, ':userName' => $userName]);
		$userID = $db->lastInsertId();
	}
	//logging
	$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
												('2',:username,:time,:ip)");
	$query6->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
	//result
	echo $id.",".$userID;
	if(!is_numeric($udid)){
		$query2 = $db->prepare("SELECT userID FROM users WHERE extID = :udid");
		$query2->execute([':udid' => $udid]);
		$usrid2 = $query2->fetchColumn();
		$query2 = $db->prepare("UPDATE levels SET userID = :userID, extID = :extID WHERE userID = :usrid2");
		$query2->execute([':userID' => $userID, ':extID' => $id, ':usrid2' => $usrid2]);	
	}
}elseif ($pass == -1){ //failure
	echo -12;
}else{
	echo -1;
}
?>