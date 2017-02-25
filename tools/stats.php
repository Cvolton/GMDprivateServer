<h1>Levels</h1>
<table border="1">
<tr><th>Difficulty</th><th>Total</th><th>Rated</th><th>Unrated</th></tr>
<?php
include "../connection.php";
function genLvlRow($params, $params2, $params3, $params4){
	include "../connection.php";
	$query = $db->prepare("SELECT gameVersion FROM levels ".$params4." ".$params2);
	$query->execute();
	$row = "<tr><td>$params3</td><td>".$query->rowCount()."</td>";
	$query = $db->prepare("SELECT gameVersion FROM levels WHERE starStars <> 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->rowCount()."</td>";
	$query = $db->prepare("SELECT gameVersion FROM levels WHERE starStars = 0 ".$params." ".$params2);
	$query->execute();
	$row .= "<td>".$query->rowCount()."</td></tr>";
	return $row;
}
//error_reporting(0);
echo genLvlRow("","","Total");
echo genLvlRow("AND","starDifficulty = 0 AND starDemon = 0 AND starAuto = 0", "N/A", "WHERE");
echo genLvlRow("AND","starAuto = 1", "Auto", "WHERE");
echo genLvlRow("AND","starDifficulty = 10 AND starDemon = 0 AND starAuto = 0", "Easy", "WHERE");
echo genLvlRow("AND","starDifficulty = 20 AND starDemon = 0 AND starAuto = 0", "Normal", "WHERE");
echo genLvlRow("AND","starDifficulty = 30 AND starDemon = 0 AND starAuto = 0", "Hard", "WHERE");
echo genLvlRow("AND","starDifficulty = 40 AND starDemon = 0 AND starAuto = 0", "Harder", "WHERE");
echo genLvlRow("AND","starDifficulty = 50 AND starDemon = 0 AND starAuto = 0", "Insane", "WHERE");
echo genLvlRow("AND","starDemon = 1", "Demon", "WHERE");
?>
</table>