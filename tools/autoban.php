<?php
include "../connection.php";
$query = $db->prepare("SELECT starStars FROM levels");
$query->execute();
$result = $query->fetchAll();
//counting stars
$stars = 0;
foreach($result as $level){
	$stars = $stars + $level["starStars"];
}
$query = $db->prepare("SELECT stars FROM mappacks");
$query->execute();
$result = $query->fetchAll();
//counting stars
foreach($result as $pack){
	$stars = $stars + $pack["stars"];
}
$quarter = floor($stars / 4);
$stars = $stars + 200 + $quarter;
$query = $db->prepare("SELECT userID, userName FROM users WHERE stars > :stars");
$query->execute([':stars' => $stars]);
$result = $query->fetchAll();
//banning ppl
foreach($result as $user){
	$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE userID = :id");
	$query->execute([':id' => $user["userID"]]);
	echo "Banned ".$user["userName"]." - ".$user["userID"]."<br>";
}
//done
echo "<hr>Banned everyone with over ".$stars." stars<hr>done";
?>