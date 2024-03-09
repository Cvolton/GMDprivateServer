<?php
error_reporting(0);
include "../../incl/lib/connection.php";
ob_flush();
flush();
//note: this needs a better algorithm
$query = $db->prepare("
SELECT 10+IFNULL(FLOOR(coins.coins*1.25)+(coins1.coins),0) as coins, 3+IFNULL(FLOOR(levels.demons*1.0625)+(demons.demons),0) as demons, 200+FLOOR((IFNULL(levels.stars,0)+IFNULL(gauntlets.stars,0)+IFNULL(mappacks.stars,0))+IFNULL(stars.stars,0)*1.25) as stars FROM
		(SELECT SUM(coins) as coins FROM levels WHERE starCoins <> 0) coins
	JOIN
		(SELECT SUM(starDemon) as demons, SUM(starStars) as stars FROM levels) levels
     JOIN 
		(SELECT SUM(starStars) as stars FROM dailyfeatures 
        INNER JOIN levels on levels.levelID = dailyfeatures.levelID) stars
	JOIN
		(SELECT SUM(starCoins) as coins FROM dailyfeatures 
        INNER JOIN levels on levels.levelID = dailyfeatures.levelID) coins1
	JOIN
		(SELECT SUM(starDemon) as demons FROM dailyfeatures 
        INNER JOIN levels on levels.levelID = dailyfeatures.levelID) demons
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
$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE stars > :stars OR demons > :demons OR userCoins > :coins OR stars < 0 OR demons < 0 OR coins < 0 OR userCoins < 0 OR diamonds < 0");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins]);
$query = $db->prepare("SELECT userID, userName FROM users WHERE stars > :stars OR demons > :demons OR userCoins > :coins OR stars < 0 OR demons < 0 OR coins < 0 OR userCoins < 0 OR diamonds < 0");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins]);
$result = $query->fetchAll();
//banips
$query = $db->prepare("SELECT IP FROM bannedips");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$ip){
	$query = $db->prepare("UPDATE users SET isBanned = '1' WHERE IP LIKE CONCAT(:ip, '%')");
	$query->execute([':ip' => $ip["IP"]]);
}
ob_flush();
flush();
//done
//echo "<hr>Banned everyone with over $stars stars and over $coins user coins and over $demons demons!<hr>done";
?>