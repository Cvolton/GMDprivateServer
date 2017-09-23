<h1>Levels</h1>
<table border="1">
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
<h1>Demons</h1>
<table border="1">
<tr><th>Difficulty</th><th>Total</th><th>Unrated</th><th>Rated</th><th>Featured</th><th>Epic</th></tr>
<?php
echo genLvlRow("AND","starDemon = 1", "Total", "WHERE");
echo genLvlRow("AND","starDemon = 1 AND starDemonDiff = 3", "Easy", "WHERE");
echo genLvlRow("AND","starDemon = 1 AND starDemonDiff = 4", "Medium", "WHERE");
echo genLvlRow("AND","starDemon = 1 AND starDemonDiff = 0", "Hard", "WHERE");
echo genLvlRow("AND","starDemon = 1 AND starDemonDiff = 5", "Insane", "WHERE");
echo genLvlRow("AND","starDemon = 1 AND starDemonDiff = 6", "Extreme", "WHERE");
?>
</table>
<h1>Accounts</h1>
<table border="1">
<tr><th>Type</th><th>Count</th>
<?php
$query = $db->prepare("SELECT count(*) FROM users");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Total</td><td>$thing</td></tr>";
$query = $db->prepare("SELECT count(*) FROM accounts");
$query->execute();
$thing = $query->fetchColumn();
echo "<tr><td>Registered</td><td>$thing</td></tr>";
$sevendaysago = time() - 86400;
$query = $db->prepare("SELECT count(*) FROM users WHERE lastPlayed > :lastPlayed");
$query->execute([':lastPlayed' => $sevendaysago]);
$thing = $query->fetchColumn();
echo "<tr><td>Active</td><td>$thing</td></tr>";
?>
</table>