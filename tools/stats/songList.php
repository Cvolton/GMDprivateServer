<table border="1"><tr><th>ID</th><th>Name</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT ID,name FROM songs WHERE ID >= 5000000 ORDER BY ID DESC");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$song){
	echo "<tr><td>".$song["ID"]."</td><td>".htmlspecialchars($song["name"],ENT_QUOTES)."</td></tr>";
}
?>
</table>