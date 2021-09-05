WARNING: SAVE DATA MIGHT BE LINKED TO YOUR PASSWORD, YOU COULD ESSENTIALLY BRICK YOUR LOAD FUNCTIONALITY BY USING THIS INSTEAD OF <a href="changePassword.php">changePassword.php</a><br>

<?php
include "../../incl/lib/connection.php";
include_once "../../config/security.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$userName = $ep->remove($_POST["userName"]);
$oldpass = $_POST["oldpassword"];
$newpass = $_POST["newpassword"];
$salt = "";
if($userName != "" AND $newpass != "" AND $oldpass != ""){
	$pass = GeneratePass::isValidUsrname($userName, $oldpass);
	if ($pass == 1) {
		//creating pass hash
		$passhash = password_hash($newpass, PASSWORD_DEFAULT);
		$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
		$query->execute([':password' => $passhash, ':userName' => $userName, ':salt' => $salt]);
		echo "Password changed. <a href='accountManagement.php'>Go back to account management</a>";
	}else{
		echo "Invalid old password or nonexistent account. <a href='changePassword.php'>Try again</a>";

	}
}else{
	echo '<form action="changePasswordNoSave.php" method="post">Username: <input type="text" name="userName"><br>Old password: <input type="password" name="oldpassword"><br>New password: <input type="password" name="newpassword"><br><input type="submit" value="Change"></form>';
}
?>