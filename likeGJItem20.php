<?php
include "connection.php";
if($_POST["type"]=1){
	if($_POST["like"]==1){
	$itemID = htmlspecialchars($_POST["itemID"],ENT_QUOTES);
	$query=$db->prepare("select * from levels where levelID = '$itemID'");
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE levels SET likes = '$likes' WHERE levelID = '$itemID';");
	$query2->execute();
	echo "1";
	}else if($_POST["like"]==0){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from levels where levelID = '$itemID'");
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] - 1;
	$query2=$db->prepare("UPDATE levels SET likes = '$likes' WHERE levelID = '$itemID';");
	$query2->execute();
	echo "1";
	}
}
if($_POST["type"]=2){
	if($_POST["like"]==1){
	$itemID = htmlspecialchars($_POST["itemID"],ENT_QUOTES);
	$query=$db->prepare("select * from comments where commentID = '$itemID'");
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE comments SET likes = '$likes' WHERE commentID = '$itemID';");
	$query2->execute();
	echo "1";
	}else if($_POST["like"]==0){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from comments where commentID = '$itemID'");
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] - 1;
	$query2=$db->prepare("UPDATE comments SET likes = '$likes' WHERE commentID = '$itemID';");
	$query2->execute();
	echo "1";
	}
}
if($_POST["type"]=3){
	if($_POST["like"]==1){
	$itemID = htmlspecialchars($_POST["itemID"],ENT_QUOTES);
	$query=$db->prepare("select * from acccomments where commentID = '$itemID'");
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE acccomments SET likes = '$likes' WHERE commentID = '$itemID';");
	$query2->execute();
	echo "1";
	}else if($_POST["like"]==0){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from acccomments where commentID = '$itemID'");
	$query->execute();
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] - 1;
	$query2=$db->prepare("UPDATE acccomments SET likes = '$likes' WHERE commentID = '$itemID';");
	$query2->execute();
	echo "1";
	}
}
?>