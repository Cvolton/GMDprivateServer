<?php
//error_reporting(0);
include "../connection.php";
$api_key = "dc467dd431fc48eb0244b0aead929ccd";
if($_POST["songlink"]){
$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$_POST["songlink"]);
if (filter_var($song, FILTER_VALIDATE_URL) == TRUE) {
	if(strpos($song, 'soundcloud.com') !== false){
		$songinfo = file_get_contents("https://api.soundcloud.com/resolve.json?url=".$song."&client_id=".$api_key);
		$array = json_decode($songinfo);
		if($array->downloadable == true){
			$song = trim($array->download_url . "?client_id=".$api_key);
			$name = $array->title;
			$author = $array->user->username;
			$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
			echo "Processing Soundcloud song ".htmlspecialchars($name,ENT_QUOTES)." by ".htmlspecialchars($author,ENT_QUOTES)." with the download link ".htmlspecialchars($song,ENT_QUOTES)." <br>";
		}else{
			exit("This song isn't downloadable.<br>");
		}
	}else{
		$song = str_replace("?dl=0","",$song);
		$song = str_replace("?dl=1","",$song);
		$song = trim($song);
		$name = str_replace(".mp3", "", basename($song));
		$name = str_replace(".webm", "", $name);
		$name = str_replace(".mp4", "", $name);
		$name = urldecode($name);
		$name = str_replace("#", "", $name);
		$name = str_replace(":", "", $name);
		$name = str_replace("~", "", $name);
		$name = str_replace("|", "", $name);
		$author = "Reupload";
	}
	 $ch = curl_init($song);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	 curl_setopt($ch, CURLOPT_HEADER, TRUE);
	 curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	 $data = curl_exec($ch);
	 $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
	 curl_close($ch);
	 $size = round($size / 1024 / 1024, 2);
    $query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download)
	VALUES (:name, '9', :author, :size, :download)");
	$query->execute([':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size]);
	echo "Song reuploaded: <b>".$db->lastInsertId()."</b><hr>";
}else{
	echo "The download link isn't a valid URL";
}
}
	echo '<b>Soundcloud links</b> or <b>Direct links</b> or <b>Dropbox links</b> only accepted, <b><font size="5">NO YOUTUBE LINKS</font></b><br><form action="songAdd.php" method="post">Link: <input type="text" name="songlink"><br><input type="submit" value="Reupload"></form>';

?>