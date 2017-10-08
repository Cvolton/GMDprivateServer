<html><head><title>GDPS Demon List</title><body><h1>GDPS Demon List</h1>
<?php
include "../../incl/lib/connection.php";

echo '<a href="http://gdpslist.weebly.com/demons-list.html">Original</a>';
$query = $db->prepare("SELECT * FROM demonList ORDER BY listIndex ASC");
$query->execute();
$result = $query->fetchAll();

echo '<table border=1><tr><th>#</th><th>Title</th><th>Author</th><th>Video</th></tr>';
foreach ($result as &$demon) {
	echo '<tr><td>'.$demon["listIndex"].'</td><td>'.$demon["Title"].'</td><td>'.$demon["Creator"].'</td><td>';
	if ($demon["videoURL"] != "none") {
		echo '<a href=https://www.youtube.com/watch?v='.$demon["videoURL"].'>Here</a>';
	}
	echo '</td></tr>';
}
echo '</table>';

?>
</BODY></HTML>