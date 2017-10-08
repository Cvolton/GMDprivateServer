<?php
include "../../incl/lib/connection.php";

$query = $db->prepare("SELECT * FROM demonList ORDER BY listIndex ASC");
$query->execute();
$result = $query->fetchAll();

echo "http://gdpslist.weebly.com/demons-list.html|";

foreach ($result as &$demon) {
	echo $demon["Title"].",".$demon["Creator"].",".$demon["videoURL"]."|";
}

?>