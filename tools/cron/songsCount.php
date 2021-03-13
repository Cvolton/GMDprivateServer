<?php
chdir(dirname(__FILE__));
set_time_limit(0);
include "../../incl/lib/connection.php";
//var_dump($result);
//getting accounts
echo "Calculating levelsCount for songs";
$query = $db->prepare("UPDATE songs
	LEFT JOIN
	(
	    SELECT count(*) AS levelsCount, songID FROM levels GROUP BY songID
	) calculated
	ON calculated.songID = songs.ID
	SET songs.levelsCount = IFNULL(calculated.levelsCount, 0)");
$query->execute();
echo "<hr>";
?>
