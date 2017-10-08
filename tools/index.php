<?php
function listdir($dir){
	$dirstring = "";
	$files = scandir($dir);
	foreach($files as $file) {
		if(pathinfo($file, PATHINFO_EXTENSION) == "php" AND $file != "index.php" AND $file != "list.php"){
			$dirstring .= "<li><a href='$dir/$file'>$file</a></li>";
		}
	}
	return $dirstring;
}
echo '<h1>Account Management:</h1><ul>';
echo listdir("account");
echo '</ul><h1>Moderation/Reuploads/Sessions:</h1><ul>';
echo listdir(".");
echo "</ul><h1>Demon List:</h1><ul>";
echo listdir("demon_list");
echo "</ul><h1>The Cron Job (fixing CPs, autoban, etc.):</h1><ul>";
echo "<li><a href='cron/cron.php'>cron.php</a></li>";
echo "</ul><h1>Statistics:</h1><ul>";
echo listdir("stats");
?>