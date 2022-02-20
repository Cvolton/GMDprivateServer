<html>
<head>
<title>ACCOUNT LINKING</title>
</head>
<body>
<?php
//error_reporting(-1);
include "../incl/lib/connection.php";
require_once "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
if(!empty($_POST["userhere"]) AND !empty($_POST["passhere"]) AND !empty($_POST["usertarg"]) AND !empty($_POST["passtarg"])){
	$userhere = ExploitPatch::remove($_POST["userhere"]);
	$passhere = ExploitPatch::remove($_POST["passhere"]);
	$usertarg = ExploitPatch::remove($_POST["usertarg"]);
	$passtarg = ExploitPatch::remove($_POST["passtarg"]);
	$pass = GeneratePass::isValidUsrname($userhere, $passhere);
	//echo $pass;
	if ($pass == 1) {
		$url = $_POST["server"];
		$udid = "S" . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(1,9);
		$sid = mt_rand(111111111,999999999) . mt_rand(11111111,99999999);
		//echo $udid;
		$post = ['userName' => $usertarg, 'udid' => $udid, 'password' => $passtarg, 'sID' => $sid, 'secret' => 'Wmfv3899gc9'];
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
				echo "Login to the target server failed.";
			}else{
				echo "RobTop doesn't like you or something...";
			}
			echo "<br>Error code: $result";
		}else{
			if($_POST["debug"] == 1){
				echo "<br>$result<br>";
			}
			$parsedurl = parse_url($url);
			if($parsedurl["host"] == $_SERVER['SERVER_NAME']){
				exit("You can't link 2 accounts on the same server.");
			}
			//getting stuff
			$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName LIMIT 1");
			$query->execute([':userName' => $userhere]);
			$accountID = $query->fetchColumn();
			$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID LIMIT 1");
			$query->execute([':extID' => $accountID]);
			$userID = $query->fetchColumn();
			$targetAccountID = explode(",",$result)[0];
			$targetUserID = explode(",",$result)[1];
			$query = $db->prepare("SELECT count(*) FROM links WHERE targetAccountID = :targetAccountID LIMIT 1");
			$query->execute([':targetAccountID' => $targetAccountID]);
			if($query->fetchColumn() != 0){
				exit("The target account is linked to an account already.");
			}
			//echo $accountID;
			if(!is_numeric($targetAccountID) OR !is_numeric($accountID)){
				exit("Invalid AccountID found");
			}
			$server = $parsedurl["host"];
			//query
			$query = $db->prepare("INSERT INTO links (accountID, targetAccountID, server, timestamp, userID, targetUserID)
											 VALUES (:accountID,:targetAccountID,:server,:timestamp,:userID,:targetUserID)");
			$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID, ':server' => $server, ':timestamp' => time(), 'userID' => $userID, 'targetUserID' => $targetUserID]);
			echo "Account linked succesfully.";
		}
	}else{
		echo "Invalid local username/password combination.";
	}
}else{
	echo '<form action="linkAcc.php" method="post">Your password for the target server is NOT saved, it\'s used for one-time verification purposes only.
	<h3>This server</h3>
	Username: <input type="text" name="userhere"><br>
	Password: <input type="password" name="passhere"><br>
	<h3>Target server</h3>
	Username: <input type="text" name="usertarg"><br>
	Password: <input type="password" name="passtarg"><br>
	<details>
		<summary>Advanced options</summary>
		URL: <input type="text" name="server" value="http://www.boomlings.com/database/accounts/loginGJAccount.php"><br>
		Debug Mode (0=off, 1=on): <input type="text" name="debug" value="0"><br>
	</details>
	<input type="submit" value="Link Accounts"></form>';
}
?>
</body>
</html>