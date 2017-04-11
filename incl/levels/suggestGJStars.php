<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$stars = $ep->remove($_POST["stars"]);
$feature = $ep->remove($_POST["feature"]);
$levelID = $ep->remove($_POST["levelID"]);
$id = $ep->remove($_POST["accountID"]);
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query = $db->prepare("SELECT count(*) FROM accounts WHERE accountID = :id AND NOT isAdmin = 0");
		$query->execute([':id' => $id]);
		if($query->fetchColumn()==1){
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
			$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars, starCoins='1',  starFeatured=:feature WHERE levelID=:levelID";
			echo $query;
			$query = $db->prepare($query);	
			$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $diff, ':stars' => $stars, ':feature' => $feature, ':levelID'=>$levelID]);
			echo $levelID;
			$timestamp = time();
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
			$query->execute([':value' => $diffname, ':timestamp' => $timestamp, ':id' => $id, ':value2' => $stars, ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $feature, ':timestamp' => $timestamp, ':id' => $id, ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $timestamp, ':id' => $id, ':levelID' => $levelID]);
		}else{
			echo -1;
		}
	}else{echo -1;}
}else{echo -1;}
?>