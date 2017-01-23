<?php
include "connection.php";
require_once "incl/songReup.php";
$songReup = new songReup();
$songid = htmlspecialchars($_POST["songID"],ENT_QUOTES);
$query3=$db->prepare("select * from songs where ID = '$songid'");
$query3->execute();
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
	if ($result == "-1" OR $result == "") {
		$ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "http://www.newgrounds.com/audio/listen/".$songid); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $songinfo = curl_exec($ch); 
        curl_close($ch);      
		echo $songinfo;
		echo "tomasek";
		$songurl = explode('","', explode('"url":"', $songinfo)[1])[0];
		$songauthor = explode('","', explode('artist":"', $songinfo)[1])[0];
		$songurl = str_replace("\/", "/", $songurl);
		$songname = explode("<title>", explode("</title>", $songinfo)[0])[1];
		$result = "1~|~".$songid."~|~2~|~".$songname."~|~3~|~1234~|~4~|~".$songauthor."~|~5~|~6.69~|~6~|~~|~10~|~".$songurl."~|~7~|~~|~8~|~0";
	}
	echo $result;
	$reup = $songReup->reup($result);
}else{
	$result3 = $query3->fetchAll();
	$result4 = $result3[0];
	echo "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
}
?>