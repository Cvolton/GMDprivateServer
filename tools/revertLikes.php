<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
exit("tool not ready yet");

if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["levelID"]) AND !empty($_POST["timestamp"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$levelID = ExploitPatch::remove($_POST["levelID"]);
	$timestamp = ExploitPatch::remove($_POST["timestamp"]);
	$pass = GeneratePass::isValidUsrname($userName, $password);

	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($gs->checkPermission($accountID, "toolLeaderboardsban")){ //TODO: create a permission for this
			if(!is_numeric($levelID))
				exit("Invalid level ID");

			$query = $db->prepare("SELECT count(*) FROM actions WHERE value = :levelID AND type = 3 AND timestamp >= :timestamp");
			$query->execute([':levelID' => $levelID, ':timestamp' => $timestamp]);
			$count = $query->fetchColumn();

			$query = $db->prepare("UPDATE levels SET likes = likes + :count WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID, ':count' => $count]);

			if($query->rowCount() != 0){
				echo "Banned succesfully.";
			}else{
				echo "Ban failed.";
			}

			$query = $db->prepare("INSERT INTO modactions  (type, value, value2, value3, timestamp, account) 
													VALUES ('17',:levelID, '1',  :now,:account)");
			$query->execute([':levelID' => $levelID,':timestamp' => $timestamp, ':now' => time(), ':account' => $accountID]);

		}else{
			exit("You do not have the permission to do this action. <a href='revertLikes.php'>Try again</a>");
		}
	}else{
		echo "Invalid password or nonexistant account. <a href='revertLikes.php'>Try again</a>";
	}
}else{
	echo '<form action="revertLikes.php" method="post">Your Username: <input type="text" name="userName">
		<br>Your Password: <input type="password" name="password">
		<br>Level ID: <input type="text" name="levelID">
		<br>Timestamp since: <input type="text" name="timestamp">
		<br><input type="submit" value="Revert"></form>';
}
?>