<?php
//error_reporting(0);
include "connection.php";
$levelsstring = "";
$songsstring  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
//here da code begins
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
$mode = htmlspecialchars($_POST["mode"],ENT_QUOTES);
if($mode==0){
	$query = "SELECT * FROM comments WHERE levelID = :levelID ORDER BY commentID DESC";	
}else{
	$query = "SELECT * FROM comments WHERE levelID = :levelID ORDER BY likes DESC";
}
$query = $db->prepare($query);
$query->execute([':levelID' => $levelID]);
$result = $query->fetchAll();
$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
for ($x = 0; $x < 9; $x++) {
	$commentpage = $page*10;
	$comment1 = $result[$commentpage+$x];
	if($comment1["commentID"]!=""){
		if($x != 0){
		echo "|";
	}
	$uploadDate = date("d/m/Y G.i", $comment1["timestamp"]);
	echo "2~".$comment1["comment"]."~3~".$comment1["userID"]."~4~".$comment1["likes"]."~5~0~7~0~9~".$uploadDate."~6~".$comment1["commentID"]."~10~".$comment1["percent"]."";
	$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$comment1["userID"]."'");
	$query12->execute();
	$result12 = $query12->fetchAll();
	if ($query12->rowCount() > 0) {
		$user = $result12[0];
		echo ":1~".$user["userName"]."~9~".$user["icon"]."~10~".$user["color1"]."~11~".$user["color2"]."~14~".$user["iconType"]."~15~".$user["special"]."~16~".$user["extID"]."";
	}
}
}
	echo "#9999:".$commentpage.":10";
?>