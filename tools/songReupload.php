<?php
error_reporting(0);
include "../connection.php";
if($_POST["songid"]!=0){
$songid = $_POST["songid"];
$url = 'http://boomlings.com/database/getGJSongInfo.php';
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
$resultfixed = str_replace("~", "", $result);
$resultarray = explode('|', $resultfixed);
//var_dump($resultarray);
$uploadDate = time();
$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, download)
VALUES ('$resultarray[1]','$resultarray[3]', '$resultarray[5]', '$resultarray[7]', '$resultarray[9]', '$resultarray[13]')");
$query->execute();
echo $db->lastInsertId();
}else{
	echo '<form action="songReupload.php" method="post">ID: <input type="text" name="songid"><br><input type="submit" value="Reupload"></form>';
}
?>