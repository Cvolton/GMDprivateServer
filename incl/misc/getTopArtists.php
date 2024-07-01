<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../lib/mainLib.php";
$gs = new mainLib();
require "../lib/exploitPatch.php";
require "../../config/topArtists.php";
$str = "";

if(isset($_POST["page"]) AND is_numeric($_POST["page"])){
	$offset = ExploitPatch::number($_POST["page"]) . "0";
	$offset = $offset*2; // ask robtop
}else{
	$offset = 0;
}


if($redirect == 1) {
	// send result
	$url = "https://www.boomlings.com/database/getGJTopArtists.php";
	$request = "page=$offset&secret=Wmfd2893gb7";
	parse_str($request, $post);
	// post
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	$robsult = curl_exec($ch);
	curl_close($ch);
	echo $robsult;
} else { 
	$IPcheck = $db->prepare("SELECT extID FROM users WHERE IP = :ip ORDER BY lastPlayed DESC");
	$IPcheck->execute([':ip' => $gs->getIP()]);
	$IPcheck = $IPcheck->fetch();
	$querywhat = "SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC LIMIT 20 OFFSET $offset"; 
	$query = $db->prepare($querywhat);
	$query->execute([':id' => $IPcheck["extID"]]);
	$res = $query->fetchAll();
	foreach($res as $sel){
		$str .= "4:".$sel["authorName"]." - ".$sel["name"].", ".$sel["ID"];
		$str .= ":7:../redirect?q=".urlencode($sel["download"]);
		$str .= "|";
	}
	if(empty($str)) $str = "4:There is no songs!|4:If you liked some...|4:Update your IP!|4:Go to your profile to do that.";
	$str = rtrim($str, "|");
	$querywhat = "SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC"; 
	$query = $db->prepare($querywhat);
	$query->execute([':id' => $IPcheck["extID"]]);
	$res = $query->fetchAll();
	$totalCount = count($res);
	$str .= "#$totalCount:$offset:20";
	echo "$str";
}
?>
