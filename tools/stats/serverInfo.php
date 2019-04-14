<!DOCTYPE HTML>
<html>
	<head>
		<title>Server Info</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">

			<h1>Levels</h1>
			<table>
				<tr><th>Difficulty</th><th>Total</th><th>Unrated</th><th>Rated</th><th>Featured</th><th>Epic</th></tr>
<?php
include "../../incl/lib/connection.php";
function genLvlRow($params, $params2, $params3, $params4){
	include "../../incl/lib/connection.php";
	$query = $db->prepare("SELECT count(*) FROM levels ".$params4." ".$params2);
	$query->execute();
	$row = "<tr><td>$params3</td><td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starStars = 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starStars <> 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starFeatured <> 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td>";
	$query = $db->prepare("SELECT count(*) FROM levels WHERE starEpic <> 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->fetchColumn()."</td></tr>";
	return $row;
}
//error_reporting(0);

echo genLvlRow("","","Total", "");
echo genLvlRow("AND","starDifficulty = 0 AND starDemon = 0 AND starAuto = 0 AND unlisted = 0", "N/A", "WHERE");
echo genLvlRow("AND","starAuto = 1  AND unlisted = 0", "Auto", "WHERE");
echo genLvlRow("AND","starDifficulty = 10 AND starDemon = 0 AND starAuto = 0 AND unlisted = 0", "Easy", "WHERE");
echo genLvlRow("AND","starDifficulty = 20 AND starDemon = 0 AND starAuto = 0 AND unlisted = 0", "Normal", "WHERE");
echo genLvlRow("AND","starDifficulty = 30 AND starDemon = 0 AND starAuto = 0 AND unlisted = 0", "Hard", "WHERE");
echo genLvlRow("AND","starDifficulty = 40 AND starDemon = 0 AND starAuto = 0 AND unlisted = 0", "Harder", "WHERE");
echo genLvlRow("AND","starDifficulty = 50 AND starDemon = 0 AND starAuto = 0 AND unlisted = 0", "Insane", "WHERE");
echo genLvlRow("AND","starDemon = 1", "Demon", "WHERE");

?>
			</table>
			<h1>Accounts</h1>
			<table>
				<tr><th>Type</th><th>Count</th></tr>
<?php

$query = $db->prepare("SELECT count(*) FROM users");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Total</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT count(*) FROM accounts");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Registered</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT count(*) FROM actions");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Total Actions</td><td>$thing</td></tr>";

$qt = time() - 2592000;
$query = $db->prepare("SELECT count(*) FROM actions WHERE ID IN (SELECT MIN(ID) FROM actions GROUP BY value2) AND timestamp > :lastPlayed AND value2 IS NOT NULL");
$query->execute([':lastPlayed' => $qt]);
$thing = $query->fetchColumn();
echo "<tr><td>Active this Month</td><td>$thing</td></tr>";

$qt = time() - 604800;
$query = $db->prepare("SELECT count(*) FROM actions WHERE ID IN (SELECT MIN(ID) FROM actions GROUP BY value2) AND timestamp > :lastPlayed AND value2 IS NOT NULL");
$query->execute([':lastPlayed' => $qt]);
$thing = $query->fetchColumn();
echo "<tr><td>Active this Week</td><td>$thing</td></tr>";

?>
			</table>
			<h1>Comments</h1>
			<table>
				<tr><th>From</th><th>Count</th></tr>
<?php

$query = $db->prepare("SELECT count(*) FROM comments");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Everyone</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT count(*) FROM comments WHERE userid IN (SELECT userID FROM users WHERE extID IN (SELECT accountID FROM accounts WHERE isAdmin = 1 OR isHeadAdmin = 1))");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Moderators</td><td>$thing</td></tr>";

?>
			</table>
			<h1>Leaderboards</h1>
			<table>
				<tr><th>Stat</th><th>Count</th></tr>
<?php

$query = $db->prepare("SELECT count(*) FROM users WHERE isBanned = 0");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Total</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT count(*) FROM users WHERE isBanned = 1");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Banned</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT sum(stars) FROM users WHERE isBanned = 0");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Stars Collected</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT sum(coins) FROM users WHERE isBanned = 0");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Coins Collected</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT sum(demons) FROM users WHERE isBanned = 0");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Demons Completed</td><td>$thing</td></tr>";

$query = $db->prepare("SELECT sum(creatorPoints) FROM users WHERE userName <> 'Reupload'");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Creator Points Rewarded</td><td>$thing</td></tr>";

?>
			</table>
		</div>
	</body>
</html>