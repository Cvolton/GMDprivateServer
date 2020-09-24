<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();

$isVerify = $_POST['isVerify'];

if (!is_numeric($_POST["page"]))
{
	exit("-1");
}

$page = $ep->remove($_POST["page"]);
$packpage = $page*10;
$mappackstring = "";
$lvlsmultistring = "";

if ($isVerify)
	$query = $db->prepare("SELECT ID,name,levels,stars,coins FROM `mappacks` ORDER BY `stars` ASC");
else
	$query = $db->prepare("SELECT colors2,rgbcolors,ID,name,levels,stars,coins,difficulty FROM `mappacks` ORDER BY `stars` ASC LIMIT 10 OFFSET $packpage");

$query->execute();
$result = $query->fetchAll();
$packcount = $query->rowCount();
foreach($result as &$mappack) {
	$lvlsmultistring .= $mappack["ID"] . ",";
	$colors2 = $mappack["colors2"];
	if($colors2 == "none" OR $colors2 == ""){
		$colors2 = $mappack["rgbcolors"];
	}
	
	if ($isVerify)
		$mappackstring .= "1:".$mappack["ID"].":3:".$mappack["levels"].":4:".$mappack["stars"].":5:".$mappack["coins"]."|";
	else
		$mappackstring .= "1:".$mappack["ID"].":2:".$mappack["name"].":3:".$mappack["levels"].":4:".$mappack["stars"].":5:".$mappack["coins"].":6:".$mappack["difficulty"].":7:".$mappack["rgbcolors"].":8:".$colors2."|";
}
$query = $db->prepare("SELECT count(*) FROM mappacks");
$query->execute();
$totalpackcount = $query->fetchColumn();
$mappackstring = substr($mappackstring, 0, -1);
$lvlsmultistring = substr($lvlsmultistring, 0, -1);
echo $mappackstring;

if ($isVerify)
	echo "#".$totalpackcount.":".$packpage.":".$totalpackcount;
else
	echo "#".$totalpackcount.":".$packpage.":10";
echo "#";
require "../lib/generateHash.php";
$hash = new generateHash();
echo $hash->genPack($lvlsmultistring);
?>
