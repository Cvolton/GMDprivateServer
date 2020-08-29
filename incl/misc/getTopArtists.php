<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../lib/exploitPatch.php";
require "../../config/topArtists.php";
$ep = new exploitPatch();
$str = "";

if(isset($_POST["page"]) AND is_numeric($_POST["page"])){
	$offset = $ep->number($_POST["page"]) . "0";
	$offset = $offset*2; // ask robtop
}else{
	$offset = 0;
}

if($redirect == 1) {
	// parse
	$url = "http://boomlings.com/database/getGJTopArtists.php";
	$request = "page=$offset&secret=Wmfd2893gb7";
	parse_str($request, $post);
	// post
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	// send result
	echo $result;
} else {
	// select
	$query = $db->prepare("SELECT authorName FROM songs WHERE (authorName NOT LIKE '%Reupload%') GROUP BY authorName ORDER BY COUNT(authorName) DESC LIMIT 20 OFFSET :off");
	$query->execute([':off' => $offset]);
	$res = $query->fetchAll();
	// count
	$countquery = $db->prepare("SELECT count(DISTINCT(authorName)) FROM songs WHERE (authorName NOT LIKE '%Reupload%')");
	$countquery->execute();
	$totalCount = $countquery->fetchColumn();
	// parse
	foreach($res as $name){
		$str .= "4:$name[0]|";
	}
	$str = rtrim($str, "|");
	$str .= "#$totalCount:$offset:20";
	// send result
	echo "$str";
}
?>
