<?php
include "../../incl/lib/connection.php";

switch ($_GET["order"]) {
	case 1:
		$order = "ORDER BY downloadCount DESC";
		break;
	case 2:
		$order = "ORDER BY hackID ASC";
		break;
	default:
		$order = "ORDER BY title";
		break;
}

$query = $db->prepare("SELECT * FROM hackList ".$order);
$query->execute();
$result = $query->fetchAll();

foreach ($result as &$hack) {
	echo $hack["hackID"].",".$hack["title"].",".$hack["author"]."|";
}

?>