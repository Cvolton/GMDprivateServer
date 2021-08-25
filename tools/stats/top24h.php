<h1>TOP LEADERBOARD PROGRESS</h1>
<table border="1"><tr><th>#</th><th>UserID</th><th>UserName</th><th>Stars</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$starsgain = array();
$time = time() - 86400;
$x = 0;
$query = $db->prepare("SELECT users.userID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND users.isBanned = 0 GROUP BY(users.userID)");
$query->execute([':time' => $time]);
$result = $query->fetchAll();
foreach($result as &$gain){
	$x++;
	echo "<tr><td>$x</td><td>${gain['userID']}</td><td>${gain['userName']}</td><td>${gain['stars']}</td></tr>";
}
?>
</table>