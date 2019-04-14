<!DOCTYPE HTML>
<html>
	<head>
		<title>Cron Job</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">

<?php
chdir(dirname(__FILE__));
set_time_limit(0);
include "fixcps.php";
ob_flush();
flush();
include "autoban.php";
ob_flush();
flush();
include "deleteInvalidUsersAndSongs.php";
ob_flush();
flush();
file_put_contents("../logs/cronlastrun.txt",time());
?>

		</div>
	</body>
</html>