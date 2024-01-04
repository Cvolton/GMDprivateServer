<?php
$date = date("d-m");
if($date == "01-04"){
	exit();
}
chdir(dirname(__FILE__));
echo "Setting user names to account names<br>";
ob_flush();
flush();
if(function_exists("set_time_limit")) set_time_limit(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("UPDATE users
	INNER JOIN accounts ON accounts.accountID = users.extID
	SET users.userName = accounts.userName
	WHERE users.extID REGEXP '^-?[0-9]+$'
	AND LENGTH(accounts.userName) <= 69");
$query->execute();
$query = $db->prepare("UPDATE users
	INNER JOIN accounts ON accounts.accountID = users.extID
	SET users.userName = 'Invalid Username'
	WHERE users.extID REGEXP '^-?[0-9]+$'
	AND LENGTH(accounts.userName) > 69");
$query->execute();
echo "Done<hr>";