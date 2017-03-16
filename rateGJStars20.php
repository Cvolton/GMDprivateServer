<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$stars = $ep->remove($_POST["stars"]);
$levelID = $ep->remove($_POST["levelID"]);
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$query=$db->prepare("SELECT * FROM modips WHERE IP = :ip");
$query->execute([":ip" => $ip]);
$ips = $query->rowCount();
if($ips == 0){
	exit(-1);
}
$accid = $query->fetchAll()[0]["accountID"];
if($levelID != ""){
	$auto = 0;
	$demon = 0;
	switch($stars){
		case 1:
			$diffname = "Auto";
			$diff = 50;
			$auto = 1;
			break;
		case 2:
			$diffname = "Easy";
			$diff = 10;
			break;
		case 3:
			$diffname = "Normal";
			$diff = 20;
			break;
		case 4:
		case 5:
			$diffname = "Hard";
			$diff = 30;
			break;
		case 6:
		case 7:
			$diffname = "Harder";
			$diff = 40;
			break;
		case 8:
		case 9:
			$diffname = "Insane";
			$diff = 50;
			break;
		case 10:
			$diffname = "Demon";
			$diff = 50;
			$demon = 1;
			break;
	}
	$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $levelID]);
	$result = $query->fetchAll();
	$lvlinfo = $result[0];
	$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars WHERE levelID=:levelID";
	$query = $db->prepare($query);	
	$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $diff, ':stars' => "0", ':levelID'=>$levelID]);
	echo -1;
	$timestamp = time();
	$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
	$query->execute([':value' => $diffname, ':timestamp' => $timestamp, ':id' => $accid, ':value2' => "0", ':levelID' => $levelID]);
}
else
{
	echo -1;
}
?>