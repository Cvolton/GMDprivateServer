<!DOCTYPE HTML>
<html>
	<head>
		<title>New Session</title>
		<?php include "../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
<?php
require_once "../incl/lib/sessions.php";
include "../incl/lib/connection.php";		

if (!empty($_POST['userName']) AND !empty($_POST['password'])) {
	$session = new accSession();
	echo $session->newSession($_POST['userName'], $_POST['password']) ? "Success" : "Failed, checks the username and password combination is correct";
} else {
	echo '<form action="" method="post">
			<input class="smain" type="text" placeholder="Username" name="userName"><br>
			<input class="smain" type="password" placeholder="Password" name="password"><br>
		<input class="smain" type="submit" value="Go"></form>';
}



?>
		</div>
	</body>
</html>