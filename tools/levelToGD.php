<html>
<head>
<title>LEVEL REUPLOAD TO NORMAL GD</title>
</head>
<body>
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
		exit("Wrong local username/password combination");
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
		exit("This level doesn't belong to the account you're trying to reupload from");
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
			echo "An error has occured while connecting to the login server.";
		}else if($result=="-1"){
			echo "Login to the target server failed.";
		}else{
			echo "RobTop doesn't like you or something...";
		}
		exit("<br>Error code: $result");
	}
	if(!is_numeric($levelID)){ //checking if lvlid is numeric cuz exploits
		exit("Invalid levelID");
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
			echo "An error has occured while connecting to the upload server.";
		}else if($result=="-1"){
			echo "Reuploading level failed.";
		}else{
			echo "RobTop doesn't like you or something... (upload)";
		}
		exit("<br>Error code: $result");
	}
	echo "Level reuploaded - $result";
}else{
	echo '<form action="levelToGD.php" method="post">Your password for the target server is NOT saved, it\'s used for one-time verification purposes only.
	<h3>CvoltonGDPS</h3>Username: <input type="text" name="userhere"><br>
	Password: <input type="password" name="passhere"><br>
	Level ID: <input type="text" name="levelID"><br>
	<h3>Target server</h3>Username: <input type="text" name="usertarg"><br>
	Password: <input type="password" name="passtarg"><br>
	URL (dont change if you dont know what youre doing): <input type="text" name="server" value="http://www.boomlings.com/database/"><br>
	Debug Mode (0=off, 1=on): <input type="text" name="debug" value="0"><br>
	<input type="submit" value="Reupload"></form><br>Alternative servers to reupload to:<br>
	http://www.boomlings.com/database/ - Robtops server<br>
	http://pi.michaelbrabec.cz:9010/a/ - CvoltonGDPS<br>
	http://teamhax.altervista.org/dbh/ - TeamHax GDPS';
}
?>
</body>
</html>