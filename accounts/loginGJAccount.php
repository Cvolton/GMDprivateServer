<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$ep = new exploitPatch();
//here im getting all the data
$udid = $ep->remove($_POST["udid"]);
$userName = $ep->remove($_POST["userName"]);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
//registering
$query = "select * from accounts where userName = :userName";
$query = $db->prepare($query);
$query->execute([':userName' => $userName]);
$result = $query->fetchAll();
$account = $result[0];
//rate limiting
$newtime = time() - 3600;
$query6 = $db->prepare("SELECT * FROM actions WHERE type = '1' AND timestamp > :time AND value2 = :ip");
$query6->execute([':time' => $newtime, ':ip' => $ip]);
if($query6->rowCount > 2){
	exit("-12");
}
//authenticating
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) { //success
	//userID
	$id = $account["accountID"];
	$query2 = $db->prepare("SELECT * FROM users WHERE extID = :id");

	$query2->execute([':id' => $id]);
	$result = $query2->fetchAll();
	if ($query2->rowCount() > 0) {
	$select = $result[0];
	$userID = $select[1];
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
		$query2 = $db->prepare("SELECT * FROM users WHERE extID = :udid");
		$query2->execute([':udid' => $udid]);
		$usrid2 = $query->fetchAll()[0]["userID"];
		$query2 = $db->prepare("UPDATE levels SET userID = :userID, extID = :extID WHERE userID = :usrid2");
		$query2->execute([':userID' => $userID, ':extID' => $id, ':usrid2' => $usrid2]);	
	}
}else{ //failure
	echo -1;
	$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
												('1',:username,:time,:ip)");
	$query6->execute([':username' => $userName, ':time' => time(), ':ip' => $ip]);
}
?>