<html><head><title>Session Time Left</title></head><body><h1>SESSION EXPIRE TIME</h1>
<form action="sessionExpireTime.php" method="get">Username: <input type="text" name="u"><input type="submit" value="Go"></form>

<?php
require_once "../incl/lib/sessions.php";
include "../incl/lib/connection.php";		

if (array_key_exists('u', $_GET))
{
	$u = $_GET['u'];

	$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :u");
	$query->execute([':u' => $u]);
	$accid = $query->fetch()['accountID'];

	$session = new accSession();
	$init = $session->getTimeLeft($accid);

	$hours = floor($init / 3600);
	$minutes = floor(($init / 60) % 60);
	$seconds = $init % 60;

	if ($init >= 0)
	{
		echo "Session expires in: ".$hours."h:".$minutes."m:".$seconds."s";
	}
	else
	{
		echo "Session already expired or no session found for \"$u\" account on this IP";
	}
}
?></body></html>