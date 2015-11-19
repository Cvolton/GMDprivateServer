<?php
include "../connection.php";
$query = $db->prepare("SELECT * FROM users");
$query->execute();
$result = $query->fetchAll();
//getting users
foreach($result as $user){
//getting starred lvls count
$query2 = $db->prepare("SELECT * FROM levels WHERE userID = '".$user["userID"]."' AND starStars != 0");
$query2->execute();
$creatorpoints = $query2->rowCount();
//getting featured lvls count
$query3 = $db->prepare("SELECT * FROM levels WHERE userID = '".$user["userID"]."' AND starFeatured != 0");
$query3->execute();
$creatorpoints = $creatorpoints + $query3->rowCount();
//inserting cp value
$query4 = $db->prepare("UPDATE users SET creatorPoints='$creatorpoints' WHERE userID='".$user["userID"]."'");
$query4->execute();
echo $user["userName"] . " has now ".$creatorpoints." creator points... <br>";
}
echo "<hr>done";
?>