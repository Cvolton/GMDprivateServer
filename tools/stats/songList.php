<table border="1"><tr><th>ID</th><th>AltID</th><th>Name</th></tr>
<?php
//error_reporting(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT ID,name FROM songs WHERE ID >= 5000000 ORDER BY ID DESC");
$query->execute();
$result = $query->fetchAll();

echo "<p>Count: ".count($result)."</p>";

foreach($result as &$song)
{
	echo "<tr><td>".$song["ID"]."</td><td>".(string)($song["ID"] - 4115655)."</td><td>".htmlspecialchars($song["name"],ENT_QUOTES)."</td></tr>";
}
?>
</table>