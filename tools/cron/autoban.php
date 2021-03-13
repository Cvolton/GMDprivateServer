<hr>
<?php
include "../../incl/lib/connection.php";
echo "Initializing autoban<br>";
ob_flush();
flush();
//note: this needs a better algorithm
$query = $db->prepare("
	SELECT 10+FLOOR(coins.coins*1.25) as coins, 3+FLOOR(levels.demons*1.0625) as demons, 200+FLOOR((levels.stars+gauntlets.stars+mappacks.stars)*1.25) as stars FROM
		(SELECT SUM(coins) as coins FROM levels WHERE starCoins <> 0) coins
	JOIN
		(SELECT SUM(starDemon) as demons, SUM(starStars) as stars FROM levels) levels
	JOIN
	(
		SELECT (level1.stars + level2.stars + level3.stars + level4.stars + level5.stars) as stars FROM
			(SELECT SUM(starStars) as stars FROM gauntlets
			INNER JOIN levels on levels.levelID = gauntlets.level1) level1
		JOIN
			(SELECT SUM(starStars) as stars FROM gauntlets
			INNER JOIN levels on levels.levelID = gauntlets.level2) level2
		JOIN
			(SELECT SUM(starStars) as stars FROM gauntlets
			INNER JOIN levels on levels.levelID = gauntlets.level3) level3
		JOIN
			(SELECT SUM(starStars) as stars FROM gauntlets
			INNER JOIN levels on levels.levelID = gauntlets.level4) level4
		JOIN
			(SELECT SUM(starStars) as stars FROM gauntlets
			INNER JOIN levels on levels.levelID = gauntlets.level5) level5
	) gauntlets
	JOIN
		(SELECT SUM(stars) as stars FROM mappacks) mappacks

	");
$query->execute();
$levelstuff = $query->fetch();
$stars = $levelstuff['stars']; $coins = $levelstuff['coins']; $demons = $levelstuff['demons']; 
$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE stars > :stars OR demons > :demons OR coins > :coins");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins]);
$query = $db->prepare("SELECT userID, userName FROM users WHERE stars > :stars OR demons > :demons OR coins > :coins");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins]);
$result = $query->fetchAll();
foreach($result as $user){
	echo "Banned ".htmlspecialchars($user["userName"],ENT_QUOTES)." - ".$user["userID"]."<br>";
}
//banips
$query = $db->prepare("SELECT IP FROM bannedips");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$ip){
	$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE IP LIKE CONCAT(:ip, '%')");
	$query->execute([':ip' => $ip["IP"]]);
}
echo "<hr>Autoban finished";
ob_flush();
flush();
//done
//echo "<hr>Banned everyone with over $stars stars and over $coins user coins and over $demons demons!<hr>done";
?>
<hr>