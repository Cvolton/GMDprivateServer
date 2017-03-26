<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$type = $_POST["type"] + 2;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$itemID = $ep->remove($_POST["itemID"]);
$query6 = $db->prepare("SELECT * FROM actions WHERE type=:type AND value=:itemID AND value2=:ip");
$query6->execute([':type' => $type, ':itemID' => $itemID, ':ip' => $ip]);
if($query6->rowCount() > 2){
	exit("-1");
}
$query6 = $db->prepare("INSERT INTO actions (type, value, timestamp, value2) VALUES 
											(:type,:itemID, :time, :ip)");
$query6->execute([':type' => $type, ':itemID' => $itemID, ':time' => time(), ':ip' => $ip]);
if($_POST["type"]=="1"){ //level
	if($_POST["like"]==1){
	$query=$db->prepare("select * from levels where levelID = :itemID");
	$query->execute([':itemID' => $itemID]);
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE levels SET likes = :likes WHERE levelID = :itemID");
	$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
	echo "1";
	}else if($_POST["like"]==0){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from levels where levelID = :itemID");
	$query->execute([':itemID' => $itemID]);
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] - 1;
	$query2=$db->prepare("UPDATE levels SET likes = :likes WHERE levelID = :itemID");
	$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
	echo "1";
	}
}
if($_POST["type"]=="2"){ //comments
	if($_POST["like"]=="1"){
		$query=$db->prepare("select * from comments where commentID = :itemID");
	$query->execute([':itemID' => $itemID]);
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE comments SET likes = :likes WHERE commentID = :itemID");
	$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
	echo "1";
	}else if($_POST["like"]==0){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from comments where commentID = :itemID");
	$query->execute([':itemID' => $itemID]);
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] - 1;
	$query2=$db->prepare("UPDATE comments SET likes = :likes WHERE commentID = :itemID");
	$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
	echo "1";
	}
}
if($_POST["type"]=="3"){ //acc comments
	if($_POST["like"]=="1"){
		$query=$db->prepare("select * from acccomments where commentID = :itemID");
	$query->execute([':itemID' => $itemID]);
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] + 1;
	$query2=$db->prepare("UPDATE acccomments SET likes = :likes WHERE commentID = :itemID");
	$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
	echo "1";
	}else if($_POST["like"]==0){
	$itemID = $_POST["itemID"];
	$query=$db->prepare("select * from acccomments where commentID = :itemID");
	$query->execute([':itemID' => $itemID]);
	$result2 = $query->fetchAll();
	$result = $result2[0];
	$likes = $result["likes"] - 1;
	$query2=$db->prepare("UPDATE acccomments SET likes = :likes WHERE commentID = :itemID");
	$query2->execute([':itemID' => $itemID, ':likes' => $likes]);
	echo "1";
	}
}
?>