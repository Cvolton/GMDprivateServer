<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/generateHash.php";
$generateHash = new generateHash();
$query = $db->prepare("SELECT * FROM gauntlets ORDER BY ID");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$gauntlet){
	if($gauntlet["level5"] != 0){
		$lvls = $gauntlet["level1"].",".$gauntlet["level2"].",".$gauntlet["level3"].",".$gauntlet["level4"].",".$gauntlet["level5"];
		echo "1:".$gauntlet["ID"].":3:".$lvls."|";
		$string = $string.$gauntlet["ID"].$lvls;
	}
}
echo "#".$generateHash->genSolo2($string);
?>