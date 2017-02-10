<?php
//error_reporting(0);
include "../connection.php";
$query = $db->prepare("SELECT * FROM modactions WHERE value3 = :lvid AND type = '1'");
$query->execute([':lvid' => $_GET["level"]]);
$result = $query->fetchAll();
if(!is_numeric($_GET["level"])){
	exit("Please supply a valid level ID.");
}
if($query->rowCount() == 0){
	echo "Nobody did!";
}
foreach($result as &$action){
	$query = $db->prepare("SELECT * FROM accounts WHERE accountID = :id");
	$query->execute([':id' => $action["account"]]);
	$result2 = $query->fetchAll();
	$result2 = $result2[0];
	echo $result2["userName"]." did!\r\n";
}
?>
