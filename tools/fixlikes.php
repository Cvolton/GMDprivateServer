<?php
include "../connection.php";
$query = $db->prepare("SELECT levelID, levelName, likes, downloads FROM levels");
$query->execute();
$result = $query->fetchAll();
//getting users
foreach($result as $level){
	if($level["likes"] > $level["downloads"]){
		$query = $db->prepare("UPDATE levels SET likes = 0 WHERE levelID = :levelID");
		$query->execute([':levelID' => $level["levelID"]]);
		echo $level["levelID"] . " - " . htmlspecialchars($level["levelName"],ENT_QUOTES) . " - Likes: " . $level["likes"] . " - Downloads: " . $level["downloads"] . "<br>";
	}
}
?>
