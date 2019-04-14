<?php
chdir(dirname(__FILE__));
require_once "../incl/lib/sessions.php";
include "../incl/lib/connection.php";		

if (!empty($_POST['u']) AND !empty($_POST['p']))
{
	$session = new accSession();
	echo $session->newSession($_POST['u'], $_POST['p']) ? "1" : "Incorrect username/password.";
}
else
{
	echo 'Invalid parameters.';
}

?>