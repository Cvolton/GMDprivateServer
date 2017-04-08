<?php
chdir(dirname(__FILE__));
if(file_exists("../logs/fixcpslog.txt")){
	$cptime = file_get_contents("../logs/fixcpslog.txt");
	$newtime = time() - 30;
	if($cptime > $newtime){
		$remaintime = time() - $cptime;
		$remaintime = 30 - $remaintime;
		$remainmins = floor($remaintime / 60);
		$remainsecs = $remainmins * 60;
		$remainsecs = $remaintime - $remainsecs;
		exit("Please wait $remainmins minutes and $remainsecs seconds before running ". basename($_SERVER['SCRIPT_NAME'])." again");
	}
}
file_put_contents("../logs/fixcpslog.txt",time());
set_time_limit(0);
$cplog = "";
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT userID, userName FROM users");
$query->execute();
$result = $query->fetchAll();
//getting users
foreach($result as $user){
	$userID = $user["userID"];
	//getting starred lvls count
	$query2 = $db->prepare("SELECT count(*) FROM levels WHERE userID = :userID AND starStars != 0");
	$query2->execute([':userID' => $userID]);
	$creatorpoints = $query2->fetchColumn();
	$cplog .= $user["userName"] . " - " . $creatorpoints . "\r\n";
	//getting featured lvls count
	$query3 = $db->prepare("SELECT count(*) FROM levels WHERE userID = :userID AND starFeatured != 0");
	$query3->execute([':userID' => $userID]);
	$cpgain = $query3->fetchColumn();
	$creatorpoints = $creatorpoints + $cpgain;
	$cplog .= $user["userName"] . " - " . $creatorpoints . "\r\n";
	//getting epic lvls count
	$query3 = $db->prepare("SELECT count(*) FROM levels WHERE userID = :userID AND starEpic != 0");
	$query3->execute([':userID' => $userID]);
	$cpgain = $query3->fetchColumn();
	$creatorpoints = $creatorpoints + $cpgain + $cpgain;
	$cplog .= $user["userName"] . " - " . $creatorpoints . "\r\n";
	//inserting cp value
	$query4 = $db->prepare("UPDATE users SET creatorPoints = :creatorpoints WHERE userID=:userID");
	$query4->execute([':userID' => $userID, ':creatorpoints' => $creatorpoints]);
	if($creatorpoints != 0){
		echo htmlspecialchars($user["userName"],ENT_QUOTES) . " now has ".$creatorpoints." creator points... <br>";
		ob_flush();
		flush();
	}
}
/*
	NOW to update GAUNTLETS CP
*/
echo "<hr><h1>GAUNTLETS UPDATE</h1><hr>";
$query = $db->prepare("SELECT level1,level2,level3,level4,level5 FROM gauntlets");
$query->execute();
$result = $query->fetchAll();
//getting gauntlets
foreach($result as $gauntlet){
	//getting lvls
	for($x = 0; $x < 6; $x++){
		$query = $db->prepare("SELECT userID, levelID FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $gauntlet["level".$x]]);
		$result = $query->fetchAll();
		$result = $result[0];
		//getting users
		if($result["userID"] != ""){
			$query = $db->prepare("SELECT userName, userID, creatorPoints FROM users WHERE userID = ".$result["userID"]);
			$query->execute();
			$result = $query->fetchAll();
			$user = $result[0];
			$creatorpoints = $user["creatorPoints"];
			$creatorpoints++;
			$cplog .= $user["userName"] . " - " . $creatorpoints . "\r\n";
			//inserting cp value
			$query4 = $db->prepare("UPDATE users SET creatorPoints='$creatorpoints' WHERE userID='".$user["userID"]."'");
			$query4->execute();	
			echo htmlspecialchars($user["userName"],ENT_QUOTES) . " now has ".$creatorpoints." creator points... <br>";
			ob_flush();
			flush();
		}
	}
}
/*
	NOW to update DAILY CP
*/
echo "<hr><h1>DAILY LEVELS UPDATE</h1><hr>";
$query = $db->prepare("SELECT levelID FROM dailyfeatures WHERE timestamp < :time");
$query->execute([':time' => time()]);
$result = $query->fetchAll();
//getting gauntlets
foreach($result as $daily){
	//getting lvls
	$query = $db->prepare("SELECT userID, levelID FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $daily["levelID"]]);
	$result = $query->fetch();
	//getting users
	if($result["userID"] != ""){
		$query = $db->prepare("SELECT userName, userID, creatorPoints FROM users WHERE userID = ".$result["userID"]);
		$query->execute();
		$result = $query->fetchAll();
		$user = $result[0];
		$creatorpoints = $user["creatorPoints"];
		$creatorpoints++;
		$cplog .= $user["userName"] . " - " . $creatorpoints . "\r\n";
		//inserting cp value
		$query4 = $db->prepare("UPDATE users SET creatorPoints='$creatorpoints' WHERE userID='".$user["userID"]."'");
		$query4->execute();	
		echo htmlspecialchars($user["userName"],ENT_QUOTES) . " now has ".$creatorpoints." creator points... <br>";
		ob_flush();
		flush();
	}
}
/*
	DONE
*/
echo "<hr>done";
//april fools
$date = date("d-m");
if($date == "01-04"){
	$query4 = $db->prepare("UPDATE users SET creatorPoints='99999', userName='sakujes', stars='999', secret='april'");
	$query4->execute();
}else{
	$query4 = $db->prepare("UPDATE users SET gameVersion='0', stars='0' WHERE secret='april'");
	$query4->execute();
	$query4 = $db->prepare("UPDATE users SET creatorPoints='0' WHERE creatorPoints='99999'");
	$query4->execute();
}
file_put_contents("../logs/cplog.txt",$cplog);
?>
