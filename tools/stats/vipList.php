<h1>VIP List</h1>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT roleID, roleName FROM roles WHERE priority > 0 ORDER BY priority DESC");
$query->execute();
$result = $query->fetchAll();
foreach ($result as $role) {
	echo "<h2>" . $role['roleName'] . "</h2>";
	$query2 = $db->prepare("SELECT users.userName, users.lastPlayed FROM roleassign INNER JOIN users ON roleassign.accountID = users.extID WHERE roleassign.roleID = :roleID");
	$query2->execute([':roleID' => $role["roleID"]]);
	$account = $query2->fetchAll();
	echo '<table border="1"><tr><th>User</th><th>Last Online</th></tr>';
	foreach ($account as $user) {
		$time = date("d/m/Y G:i:s", $user["lastPlayed"]);
		$username = htmlspecialchars($user["userName"], ENT_QUOTES);
		echo "<tr><td>" . $username . "</td><td>$time</td></tr>";
	}
	echo "</table>";
}
