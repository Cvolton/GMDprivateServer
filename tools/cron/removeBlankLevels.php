<?php
include "../../incl/lib/connection.php";
$query = $db->prepare("DELETE FROM users WHERE extID = ''");
$query->execute();
$query = $db->prepare("DELETE FROM songs WHERE download = ''");
$query->execute();
echo "Deleted invalid users and songs.<br>";
ob_flush();
flush();
$query = $db->prepare("show tables");
$query->execute();
$tables = $query->fetchAll();
echo "Optimizing tables.";
ob_flush();
flush();
foreach($tables as &$table){
	$table = $table[0];
	$query = $db->prepare("OPTIMIZE TABLE $table");
	$query->execute();
	echo "Optimized $table <br>";
	ob_flush();
	flush();
}
echo "<hr>Success probably";
ob_flush();
flush();
?>