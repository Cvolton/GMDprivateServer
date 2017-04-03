<hr>
<?php
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT userName, accountID FROM accounts");
$query->execute();
$accountstuff = $query->fetchAll();
foreach($accountstuff as $account){
	$query = $db->prepare("UPDATE users SET userName = :user WHERE extID = :acc");
	$query->execute([':user' => $account["userName"], ':acc' => $account["accountID"]]);
	echo "Fixed ".htmlspecialchars($account["userName"],ENT_QUOTES)."<br>";
}
?>