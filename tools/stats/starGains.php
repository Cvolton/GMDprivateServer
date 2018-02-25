<html><head><title>Star Gains</title></head><body><h1>STAR GAINS</h1><p><b><i>NOTE: THIS MAY NOT BE 100% ACCURATE SO DON'T H4CKUSATE JUST BASED OFF OF INFO GIVEN HERE.</i></b> unless it's just like rly obvious lol</p><form action="starGains.php">UserID: <input type="text" name="id"></input><input type="submit" value="Go"></form><?php

include "../../incl/lib/connection.php";

if (!empty($_GET["id"]))
{
	$query = $db->prepare("SELECT userName, isBanned, stars FROM users WHERE userID = :userid");
	$query->execute([':userid' => (int)$_GET["id"]]);
	$u = $query->fetchAll()[0];
	$username = $u['userName'];
	$banned = $u['isBanned'] != 0 ? " (banned)." : ".";
	$stars = $u['stars'];

	echo "<p>Star gains for $username, $stars total stars$banned</p>";

	$query = $db->prepare("SELECT value, timestamp FROM actions WHERE type = 9 AND value <> 0 AND account = :userid ORDER BY timestamp DESC");
	$query->execute([':userid' => (int)$_GET["id"]]);

	echo "<table border=\"1\"><tr><th>Time</th><th>Gained</th></tr>";

	foreach ($query->fetchAll() as &$user)
	{
		$stars = $user["value"];
		$time = date("d/m/y H:i:s", $user["timestamp"]);
		
		$col = $stars > 750 ? "FF0000" : "00FF00";
		$col = $stars < 0 ? "FFFF00" : $col;
		
		echo "<tr bgcolor=\"$col\"><td>$time</td><td>$stars</td></tr>";
	}

	echo "</table>";
}

?></body></html>