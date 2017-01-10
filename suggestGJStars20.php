<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$gjp = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["gjp"],ENT_QUOTES))[0])[0])[0])[0];
$stars = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["stars"],ENT_QUOTES))[0])[0])[0])[0];
$feature = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["feature"],ENT_QUOTES))[0])[0])[0])[0];
$levelID = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["levelID"],ENT_QUOTES))[0])[0])[0])[0];
$id = explode("(", explode(";", explode("|", explode("~", htmlspecialchars($_POST["accountID"],ENT_QUOTES))[0])[0])[0])[0];
$query2 = $db->prepare("SELECT * FROM users WHERE extID = '".$id."'");
$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$userIDalmost = $result[0];
$userID = $userIDalmost[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES ('$register','$id')");

$query->execute();
$userID = $db->lastInsertId();
}
$uploadDate = time();

$query = $db->prepare("SELECT * FROM accounts WHERE accountID = '$id'");
if($id != "" AND $gjp != ""){
	$GJPCheck = new GJPCheck();
	$gjpresult = $GJPCheck->check($gjp,$id);
	if($gjpresult == 1){
		$query->execute();
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
			$query = $db->prepare("SELECT * FROM levels WHERE levelID = '$levelID'");
			$query->execute();
			$result = $query->fetchAll();
			$lvlinfo = $result[0];
			/*CvoltonGDPS stuff
			
			$length = $lvlinfo["levelLength"] +1;
			$stars = $stars * $length * 2;*/
			$query = "UPDATE levels SET starDemon='$demon', starAuto='$auto', starDifficulty='$diff', starStars='$stars', starCoins='1',  starFeatured='$feature' WHERE levelID='$levelID'";
			echo $query;
			$query = $db->prepare($query);	
			$query->execute();
			echo $levelID;
		}else{
			echo -1;
		}
	}else{echo -1;}
}else{echo -1;}
?>