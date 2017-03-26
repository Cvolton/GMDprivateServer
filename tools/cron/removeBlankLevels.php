<?php
include "../../incl/lib/connection.php";
$query = $db->prepare("DELETE FROM users WHERE extID = ''");
$query->execute();
$query = $db->prepare("DELETE FROM songs WHERE download = ''");
$query->execute();
$query = $db->prepare("show tables");
$query->execute();
$tables = $query->fetchAll();
foreach($tables as &$table){
	$table = $table[0];
	$query = $db->prepare("OPTIMIZE TABLE $table");
	$query->execute();
}
echo "<hr>If you do not see any errors above, the deletion was most probably succesful"
?>