<?php
error_reporting(0);
include "../connection.php";
if($_POST["songlink"]){
$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$_POST["songlink"]);
$song = str_replace("?dl=0","",$song);
$song = htmlspecialchars($song, ENT_QUOTES);
$name = str_replace(".mp3", "", basename($song));
$name = str_replace(".webm", "", $name);
$name = str_replace(".mp4", "", $name);
$name = urldecode($name);
$query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download)
VALUES (:name, '9', 'Reupload', '6.9', :download)");
$query->execute([':name' => $name, ':download' => $song]);
echo $db->lastInsertId();
}else{
	echo 'Direct links or Dropbox links only accepted, NO YOUTUBE LINKS<br><form action="songAdd.php" method="post">Link: <input type="text" name="songlink"><br><input type="submit" value="Reupload"></form>';
}
?>