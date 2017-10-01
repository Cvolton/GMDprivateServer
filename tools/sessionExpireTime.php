<?php
require_once "../incl/lib/sessions.php";
include "../incl/lib/connection.php";		

if (!empty($_GET['accountID'])){
	$session = new accSession();
	$init = $session->getTimeLeft($_GET['accountID']);

	$hours = floor($init / 3600);
	$minutes = floor(($init / 60) % 60);
	$seconds = $init % 60;

	echo "Session expires in: ".$hours."h:".$minutes."m:".$seconds."s";

} else {
	echo 'Missing GET Parameter: "accountID"';
}
?>