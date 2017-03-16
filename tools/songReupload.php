<?php
//error_reporting(0);
include "../connection.php";
if($_POST["songid"]!=0){
$songid = $_POST["songid"];
$url = $_POST["server"];
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
if($result != "-1"){
	require_once "../incl/songReup.php";
	$resultfixed = str_replace("~", "", $result);
	$resultarray = explode('|', $resultfixed);
	$song = urldecode($resultarray[13]);
	//if (filter_var($song, FILTER_VALIDATE_URL) == TRUE AND preg_match('/^[a-zA-Z0-9]+$/', $resultarray[7]) AND preg_match('/^[a-zA-Z0-9]+$/', $resultarray[9]) AND strpos($resultarray[3], ';') == false) 
	//{
		$songReup = new songReup();
		echo $songReup->reup($result);
	//}else{
	//	echo "This song has triggered our spam prevention filter.";
	//}
}else{
	echo "This song either doesnt exist, or the author isnt scouted -_-";
}
}else{
	echo '<form action="songReupload.php" method="post">ID: <input type="text" name="songid"><br>URL: <input type="text" name="server" value="http://www.boomlings.com/database/getGJSongInfo.php"><br><input type="submit" value="Reupload"></form>';
}
?>