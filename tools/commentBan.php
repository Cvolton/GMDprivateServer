<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["userID"])){
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$userID = $ep->remove($_POST["userID"]);
	$duration = $ep->remove($_POST["duration"]);
	$reason = $ep->remove($_POST["reason"]);
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($gs->checkPermission($accountID, "toolCommentban")){
			if(!is_numeric($userID)){
				exit("Invalid userID");
			}
			if(!is_numeric($duration)){
				exit("Invalid duration");
			}
			$query = $db->prepare("UPDATE users SET commentBanDuration = :duration, commentBanTime = :time, commentBanReason = :reason WHERE userID = :id");
			$query->execute([':id' => $userID, ':duration' => $duration, ':time' => time(), ':reason' => $reason]);
			if($query->rowCount() != 0){
				echo "Banned succesfully.";
			}else{
				echo "Ban failed.";
			}
			$query = $db->prepare("INSERT INTO modactions  (type, value, value2, timestamp, account) 
													VALUES ('16',:userID, :duration,  :timestamp,:account)");
			$query->execute([':userID' => $userID, ':timestamp' => time(), ':account' => $accountID, ':duration' => $duration]);
		}else{
			exit("You do not have the permission to do this action. <a href='commentBan.php'>Try again</a>");
		}
	}else{
		echo "Invalid password or nonexistant account. <a href='commentBan.php'>Try again</a>";
	}
}else{
	echo '<form action="commentBan.php" method="post">Your Username: <input type="text" name="userName">
		<br>Your Password: <input type="password" name="password">
		<br>Target UserID: <input type="text" name="userID">
		<br>Ban Duration: <input type="text" name="duration">
		<br>Reason: <input type="text" name="reason" value="Violation of commenting rules">
		<br><input type="submit" value="Ban"></form>
		<br>Duration Time :
		<ul><li>1 = 1 second</li>
		<li>60 = 1 minute</li>
		<li>3600 = 1 hour</li>
		<li>43200 = 12 hours</li>
		<li>86400 = 1 day</li>
		<li>604800 = 1 week</li></ul>';
}
?>