<?php
//error_reporting(0);
$page = $_GET["page"];
if($page != 0){
	$page = $page -1;
}
$humanpage = $page +1;
$page = $page*20;
echo "***SHOWING PAGE $humanpage***\r\n";
include "../connection.php";
$query = $db->prepare("SELECT * FROM songs WHERE ID >= 5000000 LIMIT $page , 20");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$song){
	$name = str_replace("*", "", $song["name"]);
	$name = str_replace("_", " ", $song["name"]);
	echo "**".$song["ID"]." : **".$name."\r\n";
}
?>
***USE !songlist <page> TO SEE MORE SONGS***