<html>
<head>
<title>LEVEL REUPLOAD</title>
</head>
<body>
<?php
//error_reporting(0);
include "../connection.php";
if($_POST["levelid"]!=""){
	$levelID = $_POST["levelid"];
	$levelID = preg_replace("/[^0-9]/", '', $levelID);
	$url = $_POST["server"];
	$post = ['levelID' => $levelID, 'secret' => 'Wmfd2893gb7'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1"){
		if($result==""){
			echo "An error has occured while connecting to the server.";
		}else{
			echo "This level doesn't exist.";
		}
	}else{
		$resultarray = explode(':', $result);
		//echo $result;
		//var_dump($resultarray);
		$uploadDate = time();
		$query = $db->prepare("SELECT * FROM levels WHERE originalReup = :lvl");
		$query->execute([':lvl' => $levelID]);
		if($query->rowCount() == 0){
			//var_dump($resultarray);
			$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, updateDate, originalReup, userID, extID, unlisted)
																			VALUES (:name ,'20', '27', 'Reupload', :desc, :version, :length, :audiotrack, '0', '1337666', '0', :twoPlayer, :songID, '0', :coins, :reqstar, :extraString, :levelString, '0', '0', '$uploadDate', '$uploadDate', :originalReup, '388', '263', '0')");
			$query->execute([':name' => $resultarray[3], ':desc' => $resultarray[5], ':version' => $resultarray[9], ':length' => $resultarray[41], ':audiotrack' => $resultarray[21], ':twoPlayer' => $resultarray[45], ':songID' => $resultarray[51], ':coins' => $resultarray[55], ':reqstar' => $resultarray[59], ':extraString' => $resultarray[53], ':levelString' => $resultarray[7], ':originalReup' => $resultarray[1]]);
			echo "Level reuploaded, ID: " . $db->lastInsertId() . "<br><hr><br>";
		}else{
			echo "This level has been already reuploaded";
		}
	}
}else{
	echo '<form action="levelReupload.php" method="post">ID: <input type="text" name="levelid"><br>URL (dont change if you dont know what youre doing): <input type="text" name="server" value="http://www.boomlings.com/database/downloadGJLevel22.php"><br><input type="submit" value="Reupload"></form><br>Alternative servers to reupload from:<br>
	http://www.boomlings.com/database/downloadGJLevel22.php - Robtops server<br>
	http://cvoltongdps.altervista.org/downloadGJLevel22.php - CvoltonGDPS<br>
	http://teamhax.altervista.org/dbh/downloadGJLevel22.php - TeamHax GDPS';
}
?>
</body>
</html>