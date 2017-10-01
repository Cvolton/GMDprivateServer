<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
if(empty($_POST["stars"]) OR empty($_POST["levelID"])){
	exit("-1");
}
$stars = $ep->remove($_POST["stars"]);
$levelID = $ep->remove($_POST["levelID"]);
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$query=$db->prepare("SELECT accountID FROM modips WHERE IP = :ip");
$query->execute([":ip" => $ip]);
$ips = $query->rowCount();
if($ips == 0){
	exit(-1);
}
$accid = $query->fetchColumn();
$diffinfo = $gs->getDiffFromStars($stars);
$diff = $diffinfo["diff"];
$demon = $diffinfo["demon"];
$stars = $diffinfo["stars"];
$auto = $diffinfo["auto"];
$diffname = $diffinfo["name"];
$query = $db->prepare("UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars WHERE levelID=:levelID");	
$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $diff, ':stars' => "0", ':levelID'=>$levelID]);
echo 1;
$timestamp = time();
$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
$query->execute([':value' => $diffname, ':timestamp' => $timestamp, ':id' => $accid, ':value2' => "0", ':levelID' => $levelID]);
?>