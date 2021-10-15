<form action="songList.php" method="post">
	Search: <input type="text" name="name" placeholder="Enter field">
	<br>Search Type: <select name="type">
		<option value="1">Song Name</option>
		<option value="2">Song Author</option>
	</select>
	<input type="submit" value="Search">
</form>
<table border="1">
	<tr>
		<th>ID</th>
		<th>Song Name</th>
		<th>Song Author</th>
		<th>Size</th>
	</tr>

	<?php
	include "../../incl/lib/connection.php";
	require "../../incl/lib/exploitPatch.php";
	if (isset($_POST['type']) == true) {
		$type = ExploitPatch::number($_POST['type']);
	} else {
		$type = 2;
	}
	switch ($type) {
		case 1:
			$searchType = "name";
			break;
		case 2:
			$searchType = "authorName";
			break;
		default:
			$searchType = "name";
			break;
	}
	if (isset($_POST['name']) == true) {
		$name = ExploitPatch::remove($_POST['name']);
	} else {
		$name = 'reupload';
	}
	$query = $db->prepare("SELECT ID,name,authorName,size FROM songs WHERE " . $searchType . " LIKE CONCAT('%', :name, '%') ORDER BY ID DESC LIMIT 5000");
	$query->execute([':name' => $name]);
	$result = $query->fetchAll();
	foreach ($result as &$song) {
		echo "<tr><td>" . $song["ID"] . "</td><td>" . htmlspecialchars($song["name"], ENT_QUOTES) . "</td><td>" . $song['authorName'] . "</td><td>" . $song['size'] . "mb</td></tr>";
	}
	?>
</table>
