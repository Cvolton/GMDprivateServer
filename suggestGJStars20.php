<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$stars = htmlspecialchars($_POST["stars"],ENT_QUOTES);
$feature = htmlspecialchars($_POST["feature"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
$id = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
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
					$diff = 50;
					$auto = 1;
					break;
				case 2:
					$diff = 10;
					break;
				case 3:
					$diff = 20;
					break;
				case 4:
				case 5:
					$diff = 30;
					break;
				case 6:
				case 7:
					$diff = 40;
					break;
				case 8:
				case 9:
					$diff = 50;
					break;
				case 10:
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
		}else{
			echo -1;
		}
	}else{echo -1;}
}else{echo -1;}
?>