<?php
include "../../incl/lib/connection.php";
$query = $db->prepare("DELETE FROM users WHERE extID = ''");
$query->execute();
$query = $db->prepare("DELETE FROM songs WHERE download = ''");
$query->execute();
echo "Deleted invalid users and songs.<br>";
ob_flush();
flush();
$query = $db->prepare("SELECT accountID, userName, registerDate FROM accounts");
$query->execute();
$result = $query->fetchAll();
echo "Deleting unused accounts<br>";
ob_flush();
flush();
/*foreach($result as &$account){
	$query = $db->prepare("SELECT count(*) FROM users WHERE extID = :accountID");
	$query->execute([':accountID' => $account["accountID"]]);
	if($query->fetchColumn() == 0){
		$time = time() - 2592000;
		if($account["registerDate"] < $time){
			echo "Deleted " . htmlspecialchars($account["userName"],ENT_QUOTES) . "<br>";
			$query = $db->prepare("DELETE FROM accounts WHERE accountID = :accountID");
			$query->execute([':accountID' => $account["accountID"]]);
			ob_flush();
			flush();
		}
	}
}*/
/*$query = $db->prepare("show tables");
$query->execute();
$tables = $query->fetchAll();
echo "Optimizing tables.<br>";
ob_flush();
flush();
foreach($tables as &$table){
	$table = $table[0];
	$query = $db->prepare("OPTIMIZE TABLE $table");
	$query->execute();
	echo "Optimized $table <br>";
	ob_flush();
	flush();
}*/
echo "<hr>Success probably";
ob_flush();
flush();
?>