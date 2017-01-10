<?php
include "../connection.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$oldpassword = md5($_POST["oldpassword"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$newpassword = md5($_POST["newpassword"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
if($userName != "" AND $newpassword != "" AND $oldpassword != ""){
$query = $db->prepare("UPDATE accounts SET password=:newpassword WHERE userName=:userName AND password=:oldpassword");	
$query->execute([':newpassword' => $newpassword, ':userName' => $userName, ':oldpassword' => $oldpassword]);
if($query->rowCount()==0){
	echo "Invalid old password or nonexistent account. <a href='changePassword.php'>Try again</a>";
}else{
	echo "Password changed. <a href='accountManagement.php'>Go back to account management</a>";
}
}else{
	echo '<form action="changePassword.php" method="post">Username: <input type="text" name="userName"><br>Old password: <input type="text" name="oldpassword"><br>New password: <input type="text" name="newpassword"><br><input type="submit" value="Reupload"></form>';
}
?>