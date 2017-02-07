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
	$query = $db->prepare("SELECT * FROM levels WHERE originalReup = :lvl");
	$query->execute([':lvl' => $_POST["levelid"]]);
	if($query->rowCount() == 0){
		$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, starDifficulty,originalReup)
		VALUES (:name ,'20', '27', 'ORS', :a, :b, :c, :d, '0', '1337666', '0', :e, :f, '0', :g, :h, :i, :j, '0', '0', '$uploadDate', :k, :l)");
		$query->execute([':name' => $resultarray[3], ':a' => $resultarray[5], ':b' => $resultarray[9], ':c' => $resultarray[35], ':d' => $resultarray[21], ':e' => $resultarray[39], ':f' => $resultarray[45], ':g' => $resultarray[49], ':h' => $resultarray[53], ':i' => $resultarray[47], ':j' => $resultarray[7], ':k' => $resultarray[15], ':l' => $resultarray[1]]);
		echo "Level reuploaded, ID: " . $db->lastInsertId() . "<br><hr><br>";
	}else{
		echo "This level has been already reuploaded";
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