<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/Captcha.php";
require_once "../../incl/lib/exploitPatch.php";
//here im getting all the data
if(!empty($_POST["userName"]) && !empty($_POST["password"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	if(!Captcha::validateCaptcha())
		exit("Invalid captcha response");
	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == -2){
		$query = $db->prepare("UPDATE accounts SET isActive = 1 WHERE userName LIKE :userName");
		$query->execute(['userName' => $userName]);
		echo "Account has been succesfully activated.";
	}
	elseif ($pass == 1) {
		echo "Account is already activated.";
	}else{
		echo "Invalid password or nonexistant account. <a href='activateAccount.php'>Try again</a>";
	}
}else{
	echo '<form method="post">
		Username: <input type="text" name="userName"><br>
		Password: <input type="password" name="password"><br>';
		Captcha::displayCaptcha();
	echo '<input type="submit" value="Activate"></form>';
}
?>