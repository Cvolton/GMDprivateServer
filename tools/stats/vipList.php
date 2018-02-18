<h1>VIP List</h1>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT roleID, roleName FROM roles WHERE priority > 0 ORDER BY priority DESC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$role){
	echo "<h1>" . $role["roleName"] . "</h1>";
	$query = $db->prepare("SELECT accountID FROM roleassign WHERE roleID = :roleID");
	$query->execute([':roleID' => $role["roleID"]]);
	$accounts = $query->fetchAll();
	echo '<table border="1"><tr><th>User</th><th>Last time online</th></tr>';
	foreach($accounts as &$user){
		$query = $db->prepare("SELECT userName, lastPlayed FROM users WHERE extID = :id");
		$query->execute([':id' => $user["accountID"]]);
		$account = $query->fetch();
		$time = date("d/m/Y G:i:s", $account["lastPlayed"]);
		$username = htmlspecialchars($account["userName"], ENT_QUOTES);
		echo "<tr><td>".$username."</td><td>$time</td></tr>";
	}
	echo "</table>";
}
?>
</table>