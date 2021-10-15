<?php
//error_reporting(0);
include_once "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
$str = ExploitPatch::remove($_GET["str"]);
$string = "";
echo "***SHOWING RESULTS FOR $str***\r\n";
include "../../incl/lib/connection.php";
$query = $db->prepare("(SELECT ID,name FROM songs WHERE ID = :str) UNION (SELECT ID,name FROM songs WHERE name LIKE CONCAT('%', :str, '%')) ORDER BY ID DESC"); //getting song info
$query->execute([':str' => $str]);
$result = $query->fetchAll();
foreach($result as &$song){
	$name = str_replace("*", "", $song["name"]);
	$name = str_replace("_", " ", $song["name"]);
	$string .= "**".$song["ID"]." : **".$name."\r\n";
}
if(strlen($string) > 1900){
	echo "Too many results, please specify your search query.";
}else{
	if($string == ""){
		echo "Nothing found.";
	}
	echo $string;
}
?>