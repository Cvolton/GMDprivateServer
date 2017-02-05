<html>
<head>
<title>LEVEL REUPLOAD</title>
</head>
<body>
<?php
//error_reporting(0);
include "../connection.php";
if($_POST["levelid"]!=0){
	$levelid = $_POST["levelid"];
	$url = $_POST["server"];
	$data = array('levelID' => $levelid, 'secret' => 'Wmfd2893gb7');
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$resultarray = explode(':', $result);
	//echo $result;
	//var_dump($resultarray);
	$uploadDate = time();
	$query = $db->prepare("SELECT * FROM levels WHERE originalReup = '$resultarray[1]'");
	$query->execute();
	if($query->rowCount() == 0){
		$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, starDifficulty,originalReup)
		VALUES (?,'20', '27', 'ORS', ?, ?, ?, ?, '0', '1337666', '0', ?, ?, '0', ?, ?, ?, ?, '0', '0', '$uploadDate', ?, ?)");
		$query->execute([$resultarray[3], $resultarray[5], $resultarray[9], $resultarray[35], $resultarray[21], $resultarray[39], $resultarray[45], $resultarray[49], $resultarray[53], $resultarray[47], $resultarray[7], $resultarray[15], $resultarray[1]]);
		echo "Level reuploaded, ID: " . $db->lastInsertId() . "<br><hr><br>";
	}else{
		echo "This level has been already reuploaded";
	}
}else{
	echo '<form action="levelReupload.php" method="post">ID: <input type="text" name="levelid"><br>URL (dont change if you dont know what youre doing): <input type="text" name="server" value="http://www.boomlings.com/database/downloadGJLevel21.php"><br><input type="submit" value="Reupload"></form><br>Alternative servers to reupload from:<br>
	http://www.boomlings.com/database/downloadGJLevel21.php - Robtops server<br>
	http://cvoltongdps.altervista.org/downloadGJLevel21.php - CvoltonGDPS<br>
	http://teamhax.altervista.org/dbh/downloadGJLevel21.php - TeamHax GDPS';
}
?>
</body>
</html>