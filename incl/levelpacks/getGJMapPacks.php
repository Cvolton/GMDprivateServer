<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$page = $ep->remove($_POST["page"]);
$packpage = $page*10;
$packpageend = $packpage + 10;
$query = $db->prepare("SELECT * FROM `mappacks` ORDER BY `ID` ASC LIMIT $packpage,$packpageend");
$query->execute();
$result = $query->fetchAll();
$packcount = $query->rowCount();
for ($x = 0; $x < $packcount; $x++) {
	if($x != 0){
		echo "|";$lvlsmultistring = $lvlsmultistring . ",";
	}
	$mappack = $result[$x];
	$lvlsmultistring = $lvlsmultistring . $mappack["ID"];
	echo "1:".$mappack["ID"].":2:".$mappack["name"].":3:".$mappack["levels"].":4:".$mappack["stars"].":5:".$mappack["coins"].":6:".$mappack["difficulty"].":7:".$mappack["rgbcolors"].":8:".$mappack["rgbcolors"];
}
$query = $db->prepare("SELECT count(*) FROM mappacks");
$query->execute();
$totalpackcount = $query->fetchAll()[0][0];
echo "#".$totalpackcount.":".$packpage.":10";
echo "#";
require "../lib/generateHash.php";
$hash = new generateHash();
echo $hash->genPack($lvlsmultistring);
?>