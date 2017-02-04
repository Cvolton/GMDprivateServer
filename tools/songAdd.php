<?php
//error_reporting(0);
include "../connection.php";
$api_key = "YOUR API KEY HERE"
if($_POST["songlink"]){
$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$_POST["songlink"]);
if (filter_var($song, FILTER_VALIDATE_URL) == TRUE) {
	if(strpos($song, 'soundcloud.com') !== false){
		$songinfo = file_get_contents("https://api.soundcloud.com/resolve.json?url=".$song."&client_id=".$api_key);
		$array = json_decode($songinfo);
		if($array->downloadable == true){
			$song = htmlspecialchars($array->download_url . "?client_id=".$api_key);
			$name = $array->title;
			$author = $array->user->username;
			$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
			echo "Processing Soundcloud song $name by $author with the download link $song <br>";
		}else{
			exit("This song isn't downloadable.<br>");
		}
	}else{
		$song = str_replace("?dl=0","",$song);
		$song = htmlspecialchars($song, ENT_QUOTES);
		$name = str_replace(".mp3", "", basename($song));
		$name = str_replace(".webm", "", $name);
		$name = str_replace(".mp4", "", $name);
		$name = urldecode($name);
		$author = "Reupload";
	}
    $query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download)
	VALUES (:name, '9', :author, '6.9', :download)");
	$query->execute([':name' => $name, ':download' => $song, ':author' => $author]);
	echo "Song reuploaded: <b>".$db->lastInsertId()."</b>";
	echo '<meta http-equiv="refresh" content="3;url=songAdd.php">';
}else{
	echo "The download link isn't a valid URL";
}
}else{
	echo '<b>Soundcloud links</b> or <b>Direct links</b> or <b>Dropbox links</b> only accepted, <b><font size="5">NO YOUTUBE LINKS</font></b><br><form action="songAdd.php" method="post">Link: <input type="text" name="songlink"><br><input type="submit" value="Reupload"></form>';
}
?>