<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require "../lib/exploitPatch.php";
require "../../config/topArtists.php";
//die("4:Waterflame|4:Xtrullor|4:F-777|4:ColBreakz|4:bossfightofficial|4:Acid-Notation|4:Rukkus|4:CreoMusic|4:Geoplex|4:Sharks|4:ThisIsTheFatRat|4:DJVI|4:dj-Nate|4:BoomKitty|4:meganeko|4:dexarson|4:garlagan|4:1f1n1ty|4:LemKuuja|4:KaixoMusic#20:0:20");
$ep = new exploitPatch();
$str = "";

if($_POST["page"]){
	$offset = $_POST["page"] . "0";
	$offset = $offset*2; // ask robtop
}else{
	$offset = 0;
}


if($redirect == 1) {
	// send result
	$url = "http://boomlings.com/database/getGJTopArtists.php";
	$request = "page=$offset&secret=Wmfd2893gb7";
	parse_str($request, $post);
	// post
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$robsult = curl_exec($ch);
	curl_close($ch);
	echo $robsult;
}
if($redirect == 0) {
	// select
	$querywhat = "SELECT authorName, download FROM songs WHERE (authorName NOT LIKE '%Reupload%' AND authorName NOT LIKE 'unknown') GROUP BY authorName ORDER BY COUNT(authorName) DESC LIMIT 20 OFFSET $offset"; // offset couldn't be used in prepare statement for some very odd reason
	$query = $db->prepare($querywhat);
	$query->execute();
	$res = $query->fetchAll();
	// count
	$countquery = $res;
	$totalCount = 100;
	// $countquery = $db->prepare("SELECT count(DISTINCT(authorName)) FROM songs WHERE (authorName NOT LIKE '%Reupload%' AND authorName NOT LIKE 'unknown') ORDER BY COUNT(authorName) DESC LIMIT 20 OFFSET $offset");
	// $countquery->execute();
	// $totalCount = $countquery->fetchColumn();
	// parse
	foreach($res as $sel){
		$str .= "4:".$sel[0];
		// TO-DO: Fetch YouTube links from RobTop's servers, as we are unable to auto-determine YouTube links.
		// Also credit to @Intelligent-Cat for this piece of code

		if (substr($sel[1], 0, 26) != "https://api.soundcloud.com") {
			if (strpos(urlencode($sel[0]), '+' ) !== false) {
				$str .= ":7:../redirect?q=https%3A%2F%2Fsoundcloud.com%2Fsearch%2Fpeople?q=".$sel[0];
				// search is used instead of directly redirecting the user due to how user links work with spaces in them
			} else {
				$str .= ":7:../redirect?q=https%3A%2F%2Fsoundcloud.com%2F".$sel[0];
				// unlikely to hit a different account if there are multiple users with the same name.
			}
		}

		$str .= "|";
	}
	$str = rtrim($str, "|");
	$str = str_replace("\n", "", $str);
	$str .= "#".$totalCount.":".$offset.":20";
	// send result
	exit($str);
}
?>
