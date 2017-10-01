<?php
require_once "../incl/lib/sessions.php";
include "../incl/lib/connection.php";		

if (!empty($_POST['userName']) AND !empty($_POST['password'])) {
	$session = new accSession();
	echo $session->newSession($_POST['userName'], $_POST['password']);
} else {
	echo '<form action="newSession.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password">
		<br><input type="submit" value="Go"></form>';
}



?>