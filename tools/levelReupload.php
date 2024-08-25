<html>
<head>
<title>LEVEL REUPLOAD</title>
</head>
<body>
<?php
function chkarray($source, $default = 0){
	if($source == ""){
		$target = $default;
	}else{
		$target = $source;
	}
	return $target;
}
//error_reporting(0);
include "../incl/lib/connection.php";
require "../incl/lib/XORCipher.php";
require "../config/reuploadAcc.php";
require_once "../incl/lib/mainLib.php";
require_once "../incl/lib/exploitPatch.php";
$gs = new mainLib();
if(!empty($_POST["levelid"])){
	$levelID = $_POST["levelid"];
	$levelID = preg_replace("/[^0-9]/", '', $levelID);
	$url = $_POST["server"];
	$post = ['gameVersion' => '22', 'binaryVersion' => '37', 'gdw' => '0', 'levelID' => $levelID, 'secret' => 'Wmfd2893gb7', 'inc' => '0', 'extras' => '0'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no"){
		if($result==""){
			echo "An error has occured while connecting to the server.";
		}else if($result=="-1"){
			echo "This level doesn't exist.";
		}else{
			echo "RobTop doesn't like you or something...";
		}
		echo "<br>Error code: $result";
	}else{
		$level = explode('#', $result)[0];
		$resultarray = explode(':', $level);
		$levelarray = array();
		$x = 1;
		foreach($resultarray as &$value){
			if ($x % 2 == 0) {
				$levelarray["a$arname"] = $value;
			}else{
				$arname = $value;
			}
			$x++;
		}
		//echo $result;
		if($_POST["debug"] == 1){
			echo "<br>".$result . "<br>";
			var_dump($levelarray);
		}
		if($levelarray["a4"] == ""){
			echo "An error has occured.<br>Error code: ".htmlspecialchars($result,ENT_QUOTES);
		}
		$uploadDate = time();
		//old levelString
		$levelString = chkarray($levelarray["a4"]);
		$gameVersion = chkarray($levelarray["a13"]);
		if(substr($levelString,0,2) == 'eJ'){
			$levelString = str_replace("_","/",$levelString);
			$levelString = str_replace("-","+",$levelString);
			$levelString = gzuncompress(base64_decode($levelString));
			if($gameVersion > 18){
				$gameVersion = 18;
			}
		}
		//check if exists
		$query = $db->prepare("SELECT count(*) FROM levels WHERE originalReup = :lvl OR original = :lvl");
		$query->execute([':lvl' => $levelarray["a1"]]);
		if($query->fetchColumn() == 0){
			$parsedurl = parse_url($url);
			if($parsedurl["host"] == $_SERVER['SERVER_NAME']){
				exit("You're attempting to reupload from the target server.");
			}
			$hostname = $gs->getIP();
			//values
			$twoPlayer = chkarray($levelarray["a31"]);
			$songID = chkarray($levelarray["a35"]);
			$coins = chkarray($levelarray["a37"]);
			$reqstar = chkarray($levelarray["a39"]);
			$extraString = chkarray($levelarray["a36"], "");
			$starStars = chkarray($levelarray["a18"]);
			$isLDM = chkarray($levelarray["a40"]);
			$password = chkarray($levelarray["a27"]);
			if($password != "0"){
				$password = XORCipher::cipher(base64_decode($password),26364);
			}
			$starCoins = 0;
			$starDiff = 0;
			$starDemon = 0;
			$starAuto = 0;
			if($parsedurl["host"] == "www.boomlings.com"){
				if($starStars != 0){
					$starCoins = chkarray($levelarray["a38"]);
					$starDiff = chkarray($levelarray["a9"]);
					$starDemon = chkarray($levelarray["a17"]);
					$starAuto = chkarray($levelarray["a25"]);
				}
			}else{
				$starStars = 0;
			}
			$targetUserID = chkarray($levelarray["a6"]);
			//linkacc
			$query = $db->prepare("SELECT accountID, userID FROM links WHERE targetUserID=:target AND server=:url");
			$query->execute([':target' => $targetUserID, ':url' => $parsedurl["host"]]);
			if($query->rowCount() == 0){
				$userID = $reupUID;
				$extID = $reupAID;
			}else{
				$userInfo = $query->fetchAll()[0];
				$userID = $userInfo["userID"];
				$extID = $userInfo["accountID"];
			}
			//query
			$levelarray["a2"] = ExploitPatch::remove($levelarray["a2"]);
			$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, updateDate, originalReup, userID, extID, unlisted, hostname, starStars, starCoins, starDifficulty, starDemon, starAuto, isLDM, songIDs, sfxIDs, ts)
												VALUES (:name ,:gameVersion, '27', 'Reupload', :desc, :version, :length, :audiotrack, '0', :password, :originalReup, :twoPlayer, :songID, '0', :coins, :reqstar, :extraString, :levelString, '', '', '$uploadDate', '$uploadDate', :originalReup, :userID, :extID, '0', :hostname, :starStars, :starCoins, :starDifficulty, :starDemon, :starAuto, :isLDM, :songIDs, :sfxIDs, :ts)");
			$query->execute([':password' => $password, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':gameVersion' => $gameVersion, ':name' => $levelarray["a2"], ':desc' => $levelarray["a3"], ':version' => $levelarray["a5"], ':length' => $levelarray["a15"], ':audiotrack' => $levelarray["a12"], ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':coins' => $coins, ':reqstar' => $reqstar, ':extraString' => $extraString, ':levelString' => "", ':originalReup' => $levelarray["a1"], ':hostname' => $hostname, ':starStars' => $starStars, ':starCoins' => $starCoins, ':starDifficulty' => $starDiff, ':userID' => $userID, ':extID' => $extID, ':isLDM' => $isLDM, ':songIDs' => $levelarray["a52"], ':sfxIDs' => $levelarray["a53"], ':ts' => $levelarray["a57"]]);
			$levelID = $db->lastInsertId();
			file_put_contents("../data/levels/$levelID",$levelString);
			echo "Level reuploaded, ID: $levelID<br><hr><br>";
		}else{
			echo "This level has been already reuploaded";
		}
	}
}else{
	echo '<h4><a href="linkAcc.php">LINKING YOUR ACCOUNT USING linkAcc.php RECOMMENDED</a></h4>
		<form action="levelReupload.php" method="post">ID: <input type="text" name="levelid"><br>
		<details>
		    <summary>Advanced options</summary>
		    URL: <input type="text" name="server" value="http://www.boomlings.com/database/downloadGJLevel22.php"><br>
			Debug Mode (0=off, 1=on): <input type="text" name="debug" value="0"><br>
		</details>
		<input type="submit" value="Reupload"></form>';
}
?>
</body>
</html>
