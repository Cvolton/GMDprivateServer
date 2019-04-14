<!DOCTYPE HTML>
<html>
	<head>
		<title>Leaderboard Ban</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
require "../../incl/lib/webhooks/webhook.php";

$ep = new exploitPatch();
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["userID"])){
	if(empty($_POST["reason"])){
		exit("Reason can't be empty.");
	}
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$userID = $ep->remove($_POST["userID"]);
	$reason = $_POST["reason"];
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $userName]);
		if($query->rowCount()==0){
			echo "<p>Account doesn't have moderator access to the server</p><a href='leaderboardsBan.php'>Try again</a>";
		}else{
			if(!is_numeric($userID)){
				exit("<p>Invalid userID</p>");
			}
			$query = $db->prepare("UPDATE users SET isBanned = 1, banReason = :reason WHERE userID = :id");
			$query->execute([':id' => $userID, ':reason' => htmlspecialchars($reason)]);
			if($query->rowCount() != 0)
			{
				PostToHook("Leaderboard Ban", "User $userID has been banned with reason: \"$reason\".", 0xFF0000);
				echo "<p>Banned succesfully</p>";
			}else{
				echo "<p>Ban failed</p>";
			}
		}
	}else{
		echo "<p>Invalid password or nonexistant account</p><a href='leaderboardsBan.php'>Try again</a>";
	}
}else{
	echo '<p><b><i>BANNING IS ONLY ALLOWED IF THE USER HAS HACKED THEIR STATS, ABUSED A GLITCH TO GAIN AN UNFAIR ADVANTAGE OVER OTHER PLAYERS OR HAS DUPLICATE ACCOUNTS ON THE LEADERBOARD</i></b></p><p><b><i>OTHER REASONS WILL MOST LIKELY LEAD TO AN UNBAN OF THE TARGET PLAYER.</i></b></p>
			<form action="" method="post">
				<input class="smain" type="text" placeholder="Mod Username" name="userName"><br>
				<input class="smain" type="password" placeholder="Mod Password" name="password"><br>
				<input class="smain" type="text" placeholder="UserID" name="userID"><br>
				<textarea class="smain" name="reason" placeholder="Reason" cols="40" rows="4"></textarea><br>
				<input class="smain" type="submit" value="Ban">
			</form>';
}
?>
		</div>
	</body>
</html>
