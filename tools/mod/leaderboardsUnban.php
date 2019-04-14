<!DOCTYPE HTML>
<html>
	<head>
		<title>Leaderboard UnBan</title>
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
	$reason = $_POST["reason"];
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$userID = $ep->remove($_POST["userID"]);
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $userName]);
		if($query->rowCount()==0){
			echo "<p>Account doesn't have moderator access to the server</p><a href=''>Try again</a>";
		}else{
			if(!is_numeric($userID)){
				exit("Invalid userID");
			}
			$query = $db->prepare("UPDATE users SET isBanned = 0, banReason = :reason WHERE userID = :id");
			$query->execute([':id' => $userID, ':reason' => "Unbanned"]);
			if($query->rowCount() != 0)
			{
				PostToHook("Leaderboard Unban", "User $userID has been unbanned with reason: \"$reason\".", 0x00FF00);
				echo "<p>Unbanned succesfully</p>";
			}else{
				echo "<p>Unban failed</p>";
			}
		}
	}else{
		echo "<p>Invalid password or nonexistant account</p><a href=''>Try again</a>";
	}
}else{
	echo '<form action="" method="post">
				<input class="smain" type="text" placeholder="Mod Username" name="userName"><br>
				<input class="smain" type="password" placeholder="Mod Password" name="password"><br>
				<input class="smain" type="text" placeholder="UserID" name="userID"><br>
				<textarea class="smain" name="reason" placeholder="Reason" cols="40" rows="4"></textarea><br>
				<input class="smain" type="submit" value="Unban">
			</form>';
}
?>
		</div>
	</body>
</html>