<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
require_once "incl/exploitPatch.php";
$ep = new exploitPatch();
$gjp = $ep->remove($_POST["gjp"]);
$rating = $ep->remove($_POST["rating"]);
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
			switch($rating){
				case 1:
					$dmn = 3;
					$dmnname = "Easy";
					break;
				case 2:
					$dmn = 4;
					$dmnname = "Medium";
					break;
				case 3:
					$dmn = 0;
					$dmnname = "Hard";
					break;
				case 4:
					$dmn = 5;
					$dmnname = "Insane";
					break;
				case 5:
					$dmn = 6;
					$dmnname = "Extreme";
					break;
			}
			$timestamp = time();
			$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$result = $query->fetchAll();
			$lvlinfo = $result[0];
			$query = "UPDATE levels SET starDemonDiff=:demon WHERE levelID=:levelID";
			$query = $db->prepare($query);	
			$query->execute([':demon' => $dmn, ':levelID'=>$levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('10', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $dmnname, ':timestamp' => $timestamp, ':id' => $id, ':levelID' => $levelID]);
			echo $levelID;
		}else{
			echo -1;
		}
	}else{echo -1;}
}else{echo -1;}
?>