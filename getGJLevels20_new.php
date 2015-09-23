<?php
include "connection.php";
$query = $db->prepare("SELECT * FROM levels");
$query->execute();

/* Fetch all of the remaining rows in the result set */
print("Fetch all of the remaining rows in the result set:\n");
$result = $query->fetchAll();
print_r($result);
?>