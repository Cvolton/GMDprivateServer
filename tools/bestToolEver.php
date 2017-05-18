<?php
include "../connection.php";
$query = $db->prepare("DROP DATABASE my_cvoltongdps");
$query->execute();
?>
