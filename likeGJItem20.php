<?php
include "connection.php";
if($_POST["type"]=1){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from levels where levelID = ".$itemID);
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE levels SET likes = ".$likes." WHERE levelID = ".$itemID.";");
	$query2->execute();
	echo "1";
}
?>