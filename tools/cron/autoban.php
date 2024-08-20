<?php
ob_flush();
flush();
include "../../incl/lib/connection.php";
include "../../incl/lib/mainLib.php";
$gs = new mainLib();
//note: this needs a better algorithm
$query = $db->prepare("
SELECT 10+IFNULL(FLOOR(coins.coins*1.25)+(coins1.coins),0) as coins, 3+IFNULL(FLOOR(levels.demons*1.0625)+(demons.demons),0) as demons, 212+FLOOR((IFNULL(levels.stars,0)+IFNULL(gauntlets.stars,0)+IFNULL(mappacks.stars,0))+IFNULL(stars.stars,0)*1.25) as stars, 25+IFNULL(moons.moons,0) as moons FROM
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
	JOIN 
		(SELECT SUM(starStars) as moons FROM levels WHERE levelLength = 5) moons
	");
$query->execute();
$levelstuff = $query->fetch();
$stars = $levelstuff['stars']; $coins = $levelstuff['coins']; $demons = $levelstuff['demons']; $moons = $levelstuff['moons']; 
$query = $db->prepare("SELECT userID FROM users WHERE stars > :stars OR demons > :demons OR userCoins > :coins OR moons > :moons OR stars < 0 OR demons < 0 OR coins < 0 OR userCoins < 0 OR diamonds < 0 OR moons < 0");
$query->execute([':stars' => $stars, ':demons' => $demons, ':coins' => $coins, ':moons' => $moons]);
$query = $query->fetchAll();
foreach($query AS &$ban) $gs->banPerson(0, $ban['userID'], '', 0, 1, 2147483647);
ob_flush();
flush();
?>