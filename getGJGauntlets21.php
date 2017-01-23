<?php
include "connection.php";
require_once "incl/generateHash.php";
$generateHash = new generateHash();
$query = $db->prepare("SELECT * FROM gauntlets ORDER BY ID");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$gauntlet){
	echo "1:".$gauntlet["ID"].":3:".$gauntlet["levels"]."|";
	$string = $string.$gauntlet["ID"].$gauntlet["levels"];
}
echo "#".$generateHash->genSolo2($string);
?>