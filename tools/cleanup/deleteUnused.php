<hr>
<?php
include "../../incl/lib/connection.php";
$x = 0;
$query = $db->prepare("SELECT userID, userName, extID, lastPlayed FROM users WHERE NOT extID REGEXP '^[0-9]+$' AND lastPlayed < :time");
$query->execute([':time' => time() - 604800]);
$users = $query->fetchAll();
foreach($users as $user){
	$query = $db->prepare("SELECT count(*) FROM levels WHERE userID = :userID");
	$query->execute([':userID' => $user["userID"]]);
	$count = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM comments WHERE userID = :userID");
	$query->execute([':userID' => $user["userID"]]);
	$count += $query->fetchColumn();
	if($count == 0){
		$query = $db->prepare("DELETE FROM users WHERE userID = :userID");
		$query->execute([':userID' => $user["userID"]]);
		echo "Deleted ".htmlspecialchars($user["userName"],ENT_QUOTES)." - ".$user["userID"]." - ".$user["extID"]." - ".date("d-m-Y G-i", $user["lastPlayed"])."<br>";
		ob_flush();
		flush();
		$x++;
	}
}
echo "<hr>".$x;
?>