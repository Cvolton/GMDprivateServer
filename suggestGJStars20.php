<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$stars = $ep->remove($_POST["stars"]);
$feature = $ep->remove($_POST["feature"]);
$levelID = $ep->remove($_POST["levelID"]);
$id = $ep->remove($_POST["accountID"]);
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :id");
$query2->execute([':id' => $id]);
$result = $query2->fetchAll();

$query = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute([':id' => $id]);
		$result = $query->fetchAll();
		$accinfo = $result[0];
		if($accinfo["isAdmin"]==1){
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
			/*CvoltonGDPS stuff
			
			$length = $lvlinfo["levelLength"] +1;
			$stars = $stars * $length * 2;*/
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