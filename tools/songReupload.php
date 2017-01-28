<?php
error_reporting(0);
include "../connection.php";
if($_POST["songid"]!=0){
$songid = $_POST["songid"];
$url = 'http://'.$_POST["server"].'/database/getGJSongInfo.php';
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
	$songReup = new songReup();
	echo $songReup->reup($result);
}else{
echo "This song either doesnt exist, or the author isnt scouted -_-";
}
}else{
	echo '<form action="songReupload.php" method="post">ID: <input type="text" name="songid"><br>Server: <input type="text" name="server" value="www.boomlings.com"><br><input type="submit" value="Reupload"></form>';
}
?>