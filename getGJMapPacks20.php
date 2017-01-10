<?php
//error_reporting(0);
include "connection.php";
$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
$packpage = $page*10;
$packpageend = $packpage + 9;
$query = $db->prepare("SELECT * FROM `mappacks` ORDER BY `ID` ASC LIMIT $packpage,$packpageend");
$query->execute();
$result = $query->fetchAll();
$packcount = $query->rowCount();
for ($x = 0; $x < $packcount; $x++) {
if($x != 0){echo "|";$lvlsmultistring = $lvlsmultistring . ",";}
$mappack = $result[$x];
$lvlsmultistring = $lvlsmultistring . $mappack["ID"];
echo "1:".$mappack["ID"].":2:".$mappack["name"].":3:".$mappack["levels"].":4:".$mappack["stars"].":5:".$mappack["coins"].":6:".$mappack["difficulty"].":7:".$mappack["rgbcolors"].":8:".$mappack["rgbcolors"];
}
if (array_key_exists(8,$result)){
		echo "#9999:".$packpage.":10";
	}else{
		$totalpackcount = $packpagea+$levelcount;
		echo "#".$totalpackcount.":".$packpage.":10";
	}
	echo "#";
require "incl/generateHash.php";
$hash = new generateHash();
echo $hash->genPack($lvlsmultistring);
?>