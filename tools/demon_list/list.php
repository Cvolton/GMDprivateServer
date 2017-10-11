<?php
include "../../incl/lib/connection.php";

$query = $db->prepare("SELECT * FROM demonList ORDER BY listIndex ASC");
$query->execute();
$result = $query->fetchAll();
$split = ",";

if ($_POST['client'] == "android") {
	$split = ":";
}
foreach ($result as &$demon) {
	echo $demon["Title"].$split.$demon["Creator"].$split.$demon["videoURL"]."|";
}
?>