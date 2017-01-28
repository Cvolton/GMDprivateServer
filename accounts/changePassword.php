<?php
include "../connection.php";
require "../incl/generatePass.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$oldpassword = md5($_POST["oldpassword"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$newpassword = md5($_POST["newpassword"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
if($userName != "" AND $newpassword != "" AND $oldpassword != ""){
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $oldpassword);
if ($pass == 1) {
	//creating pass hash
	CRYPT_BLOWFISH or die ('-2');
	//This string tells crypt to use blowfish for 5 rounds.
	$Blowfish_Pre = '$2a$05$';
	$Blowfish_End = '$';
	// Blowfish accepts these characters for salts.
	$Allowed_Chars =
	'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
	$Chars_Len = 63;
	$Salt_Length = 21;
	$salt = "";
	for($i=0; $i < $Salt_Length; $i++)
	{
		$salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
	}
	$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
	$password = crypt($newpassword, $bcrypt_salt);
	$query = $db->prepare("UPDATE accounts SET password=:password, salt=:salt WHERE userName=:userName");	
	$query->execute([':password' => $password, ':userName' => $userName, ':salt' => $salt]);
	echo "Password changed. <a href='accountManagement.php'>Go back to account management</a>";
}else{
	echo "Invalid old password or nonexistent account. <a href='changePassword.php'>Try again</a>";

}
}else{
	echo '<form action="changePassword.php" method="post">Username: <input type="text" name="userName"><br>Old password: <input type="password" name="oldpassword"><br>New password: <input type="password" name="newpassword"><br><input type="submit" value="Reupload"></form>';
}
?>