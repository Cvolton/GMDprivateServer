<h1>Unused Accounts</h1>
<table border="1"><tr><th>#</th><th>ID</th><th>Name</th><th>Registration date</th></tr>
<?php
if(function_exists("set_time_limit")) set_time_limit(0);
ob_flush();
flush();
//error_reporting(0);
include "../../incl/lib/connection.php";
$x = 1;
$query = $db->prepare("SELECT accountID, userName, registerDate FROM accounts");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$account){
	$query = $db->prepare("SELECT count(*) FROM users WHERE extID = :accountID");
	$query->execute([':accountID' => $account["accountID"]]);
	if($query->fetchColumn() == 0){
		$register = date("d/m/Y G:i:s", $account["registerDate"]);
		echo "<tr><td>$x</td><td>".$account["accountID"] . "</td><td>" . $account["userName"] . "</td><td>$register</td>";
		ob_flush();
		flush();
		$time = time() - 2592000;
		if($account["registerDate"] < $time){
			echo "<td>1</td>";
		}
		echo "</tr>";
		$x++;
	}
}
?>
</table>