<hr>
<?php
include "../connection.php";
//unbanning everyone
$query = $db->prepare("UPDATE users SET isBanned = '0'");
$query->execute();
$query = $db->prepare("SELECT starStars, coins, starCoins FROM levels");
$query->execute();
$levelstuff = $query->fetchAll();
//counting stars
$stars = 0;
foreach($levelstuff as $level){
	$stars = $stars + $level["starStars"];
	if($level["starCoins"]){
		$coins = $coins + $level["coins"];
	}
}
$query = $db->prepare("SELECT stars FROM mappacks");
$query->execute();
$result = $query->fetchAll();
//counting stars
echo "<h3>Stars based bans</h3>";
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
//counting coins
echo "<h3>User coins based bans</h3>";
$quarter = floor($coins / 4);
$coins = $coins + $quarter;
$query = $db->prepare("SELECT userID, userName FROM users WHERE userCoins > :coins");
$query->execute([':coins' => $coins]);
$result = $query->fetchAll();
//banning ppl
foreach($result as $user){
	$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE userID = :id");
	$query->execute([':id' => $user["userID"]]);
	echo "Banned ".$user["userName"]." - ".$user["userID"]."<br>";
}
//done
echo "<hr>Banned everyone with over ".$stars." stars and over ".$coins." user coins<hr>done";
?>