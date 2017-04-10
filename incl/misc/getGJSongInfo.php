<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/songReup.php";
$songReup = new songReup();
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
$songid = $ep->remove($_POST["songID"]);
$query3=$db->prepare("SELECT ID,name,authorID,authorName,size,isDisabled,download FROM songs WHERE ID = :songid LIMIT 1");
$query3->execute([':songid' => $songid]);
if($query3->rowCount() == 0) {
	$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
	$data = array('songID' => $songid, 'secret' => 'Wmfd2893gb7');
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result == "-2" OR $result == "-1" OR $result == "") {
		$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "http://www.newgrounds.com/audio/listen/".$songid); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $songinfo = curl_exec($ch); 
        curl_close($ch);
		$songurl = explode('","', explode('"url":"', $songinfo)[1])[0];
		$songauthor = explode('","', explode('artist":"', $songinfo)[1])[0];
		$songurl = str_replace("\/", "/", $songurl);
		$songname = explode("<title>", explode("</title>", $songinfo)[0])[1];
		if($songurl == ""){
			exit("-1");
		}
		$result = "1~|~".$songid."~|~2~|~".$songname."~|~3~|~1234~|~4~|~".$songauthor."~|~5~|~6.69~|~6~|~~|~10~|~".$songurl."~|~7~|~~|~8~|~1";
	}
	echo $result;
	$reup = $songReup->reup($result);
}else{
	$result4 = $query3->fetch();
	if($result4["isDisabled"] == 1){
		exit("-2");
	}
	$dl = $result4["download"];
	if(strpos($dl, ':') !== false){
		$dl = urlencode($dl);
	}
	echo "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~0";
}
?>