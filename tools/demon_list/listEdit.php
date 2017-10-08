<html><head><title>GDPS List Editor</title></head><body>
<?php

if ($_POST["done"] != "1")
{
	echo '<form action="listEdit.php" method="post">
<input type="hidden" name="done" value="1">
Username:        <input type="text" name="u">
<br>Password:    <input type="password" name="p">
<br>Position:    <input type="text" name="pos">
<br>Demon Name:  <input type="text" name="dn">
<br>Creator Name:<input type="text" name="dc">
<br>VideoID:     <input type="text" name="vid" value="none">
<br><input type="submit" value="Add"></form>';
} else {

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";

$username = $_POST["u"];
$password = $_POST["p"];

$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($username, $password);
if ($pass == 1) {
	$queryAdmin = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");
	$queryAdmin->execute([':userName' => $username]);
	if ($queryAdmin->rowCount() == 0) {
		exit("account isn't admin");
	}
	if (!is_numeric($_POST["pos"])) {
		exit("invalid position");
	}
	
	$queryTotal = $db->prepare("SELECT count(*) FROM demonList WHERE 1");
	$queryTotal->execute();
	$total = $queryTotal->fetchColumn();
	
	$queryIndex = $db->prepare("UPDATE demonList SET listIndex = listIndex + 1 WHERE listIndex >= :ind");
	$queryIndex->execute([':ind' => $_POST["pos"]]);
	
	$queryInsert = $db->prepare("INSERT INTO demonList (listIndex, Title, Creator, videoURL) VALUES (:pos ,:title ,:author ,:videoid)");
	$queryInsert->execute([':pos' => $_POST["pos"], ':title' => $_POST["dn"], ':author' => $_POST["dc"], ':videoid' => $_POST["vid"]]);
	
	echo 'probably worked';
} else {
	echo 'incorrect username or password, byebye';
}

}

?>
</body></html>