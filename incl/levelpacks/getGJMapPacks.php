<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require "../lib/generateHash.php";
require "../../config/misc.php";
if(!isset($orderMapPacksByStars)) global $orderMapPacksByStars;
$page = ExploitPatch::number($_POST["page"]);
$packpage = $page*10;
$mappackstring = "";
$lvlsmultistring = [];
if($orderMapPacksByStars) $query = $db->prepare("SELECT * FROM `mappacks` ORDER BY `stars` ASC LIMIT 10 OFFSET $packpage");
else $query = $db->prepare("SELECT * FROM `mappacks` ORDER BY `ID` ASC LIMIT 10 OFFSET $packpage");
$query->execute();
$result = $query->fetchAll();
$packcount = $query->rowCount();
foreach($result as &$mappack) {
	$lvlsmultistring[] = ['ID' => $mappack["ID"], 'stars' => $mappack["stars"], 'coins' => $mappack["coins"]];
	$colors2 = $mappack["colors2"];
	if($colors2 == "none" OR $colors2 == "") $colors2 = $mappack["rgbcolors"];
	$mappackstring .= "1:".$mappack["ID"].":2:".ExploitPatch::translit($mappack["name"]).":3:".$mappack["levels"].":4:".$mappack["stars"].":5:".$mappack["coins"].":6:".$mappack["difficulty"].":7:".$mappack["rgbcolors"].":8:".$colors2."|";
}
$query = $db->prepare("SELECT count(*) FROM mappacks");
$query->execute();
$totalpackcount = $query->fetchColumn();
$mappackstring = substr($mappackstring, 0, -1);
echo $mappackstring;
echo "#".$totalpackcount.":".$packpage.":10";
echo "#";
echo GenerateHash::genPack($lvlsmultistring);
?>