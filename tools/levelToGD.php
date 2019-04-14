<html>
	<head>
		<title>Level To GD</title>
		<?php include "../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../incl/navigation.php"; ?>
		
		<div class="smain">
<?php
function chkarray($source){
	if($source == ""){
		$target = "0";
	}else{
		$target = $source;
	}
	return $target;
}
//error_reporting(0);
include "../incl/lib/connection.php";
require "../incl/lib/XORCipher.php";
$xc = new XORCipher();
require_once "../incl/lib/generatePass.php";
$generatePass = new generatePass();
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../incl/lib/generateHash.php";
$gh = new generateHash();
if(!empty($_POST["userhere"]) AND !empty($_POST["passhere"]) AND !empty($_POST["usertarg"]) AND !empty($_POST["passtarg"]) AND !empty($_POST["levelID"])){
	$userhere = $ep->remove($_POST["userhere"]);
	$passhere = $ep->remove($_POST["passhere"]);
	$usertarg = $ep->remove($_POST["usertarg"]);
	$passtarg = $ep->remove($_POST["passtarg"]);
	$levelID = $ep->remove($_POST["levelID"]);
	$server = trim($_POST["server"]);
	$pass = $generatePass->isValidUsrname($userhere, $passhere);
	if ($pass != 1) { //verifying if valid local usr
		exit("<p>Wrong local username/password combination</p>");
	}
	$query = $db->prepare("SELECT * FROM levels WHERE levelID = :level");
	$query->execute([':level' => $levelID]);
	$levelInfo = $query->fetch();
	$userID = $levelInfo["userID"];
	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :user");
	$query->execute([':user' => $userhere]);
	$accountID = $query->fetchColumn();
	$query = $db->prepare("SELECT userID FROM users WHERE extID = :ext");
	$query->execute([':ext' => $accountID]);
	if($query->fetchColumn() != $userID){ //verifying if lvl owned
		exit("<p>This level doesn't belong to the account you're trying to reupload from</p>");
	}
	$udid = "S" . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(1,9); //getting accountid
	$sid = mt_rand(111111111,999999999) . mt_rand(11111111,99999999);
	//echo $udid;
	$post = ['userName' => $usertarg, 'udid' => $udid, 'password' => $passtarg, 'sID' => $sid, 'secret' => 'Wmfv3899gc9'];
	$ch = curl_init($server . "/accounts/loginGJAccount.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no"){
		if($result==""){
			echo "<p>An error has occured while connecting to the login server</p>";
		}else if($result=="-1"){
			echo "<p>Login to the target server failed</p>";
		}else{
			echo "<p>RobTop doesn't like you or something...</p>";
		}
		exit("<p>Error code: $result</p>");
	}
	if(!is_numeric($levelID)){ //checking if lvlid is numeric cuz exploits
		exit("<p>Invalid levelID</p>");
	}
	$levelString = file_get_contents("../data/levels/$levelID"); //generating seed2
	$seed2 = base64_encode($xc->cipher($gh->genSeed2noXor($levelString),41274));
	$accountID = explode(",",$result)[0]; //and finally reuploading
	$gjp = base64_encode($xc->cipher($passtarg,37526));
	$post = ['gameVersion' => $levelInfo["gameVersion"], 
	'binaryVersion' => $levelInfo["binaryVersion"], 
	'gdw' => "0", 
	'accountID' => $accountID, 
	'gjp' => $gjp,
	'userName' => $usertarg,
	'levelID' => "0",
	'levelName' => $levelInfo["levelName"],
	'levelDesc' => $levelInfo["levelDesc"],
	'levelVersion' => $levelInfo["levelVersion"],
	'levelLength' => $levelInfo["levelLength"],
	'audioTrack' => $levelInfo["audioTrack"],
	'auto' => $levelInfo["auto"],
	'password' => $levelInfo["password"],
	'original' => "0",
	'twoPlayer' => $levelInfo["twoPlayer"],
	'songID' => $levelInfo["songID"],
	'objects' => $levelInfo["objects"],
	'coins' => $levelInfo["coins"],
	'requestedStars' => $levelInfo["requestedStars"],
	'unlisted' => "0",
	'wt' => "0",
	'wt2' => "3",
	'extraString' => $levelInfo["extraString"],
	'seed' => "v2R5VPi53f",
	'seed2' => $seed2,
	'levelString' => $levelString,
	'levelInfo' => $levelInfo["levelInfo"],
	'secret' => "Wmfd2893gb7"];
	if($_POST["debug"] == 1){
		var_dump($post);
	}
	$ch = curl_init($server . "/uploadGJLevel21.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no"){
		if($result==""){
			echo "<p>An error has occured while connecting to the upload server</p>";
		}else if($result=="-1"){
			echo "<p>Reuploading level failed</p>";
		}else{
			echo "<p>RobTop doesn't like you or something... (upload)</p>";
		}
		exit("<p>Error code: $result</p>");
	}
	echo "<p>Level reuploaded - $result</p>";
}else{
	echo '<form action="" method="post">
			<p><b>Your password for the target server is NOT saved, it\'s used for one-time verification purposes only.</b></p>
			<h3>1.9 GDPS</h3>
			<input class="smain" type="text" placeholder="Username" name="userhere"><br>
			<input class="smain" type="password" placeholder="Password" name="passhere"><br>
			<input class="smain" type="text" placeholder="LevelID" name="levelID"><br>
			<h3>Target server</h3>
			<input class="smain" class="smain" type="text" placeholder="Username" name="usertarg"><br>
			<input class="smain" type="password" placeholder="Password" name="passtarg"><br>
			<input class="smain" type="text" placeholder="URL" name="server" value="http://www.boomlings.com/database/"><br>
			<input class="smain" type="text" placeholder="Debug Mode" name="debug" value="0"><br>
			<input class="smain" type="submit" value="Reupload">
		</form>
			<p>Alternative servers to reupload to:</p>
			<p>http://www.boomlings.com/database/ - Robtops server</p>
			<p>http://pi.michaelbrabec.cz:9010/a/ - CvoltonGDPS</p>
			<p>http://gdu.cloud/_______/database/ - GD Ultimate</p>';
}
?>
		</div>
	</body>
</html>