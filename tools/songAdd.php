<?php
//error_reporting(0);
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$api_key = "dc467dd431fc48eb0244b0aead929ccd";
if(!empty($_POST["songlink"])){
$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$_POST["songlink"]);
if (filter_var($song, FILTER_VALIDATE_URL) == TRUE) {
	$soundcloud = false;
	if(strpos($song, 'soundcloud.com') !== false){
		$soundcloud = true;
		$songinfo = file_get_contents("https://api.soundcloud.com/resolve.json?url=".$song."&client_id=".$api_key);
		$array = json_decode($songinfo);
		if($array->downloadable == true){
			$song = trim($array->download_url . "?client_id=".$api_key);
			$name = $ep->remove($array->title);
			$author = $array->user->username;
			$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
			echo "Processing Soundcloud song ".htmlspecialchars($name,ENT_QUOTES)." by ".htmlspecialchars($author,ENT_QUOTES)." with the download link ".htmlspecialchars($song,ENT_QUOTES)." <br>";
		}else{
			if(!$array->id){
				exit("This song is neither downloadable, nor streamable");
			}
			$song = trim("https://api.soundcloud.com/tracks/".$array->id."/stream?client_id=".$api_key);
			$name = $ep->remove($array->title);
			$author = $array->user->username;
			$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
			echo "This song isn't downloadable, attempting to insert it anyways<br>";
		}
	}else{
		$song = str_replace("?dl=0","",$song);
		$song = str_replace("?dl=1","",$song);
		$song = trim($song);
		$name = str_replace(".mp3", "", basename($song));
		$name = str_replace(".webm", "", $name);
		$name = str_replace(".mp4", "", $name);
		$name = urldecode($name);
		$name = $ep->remove($name);
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
	$hash = "";
	//$hash = sha1_file($song);
	$count = 0;
	$query = $db->prepare("SELECT count(*) FROM songs WHERE download = :download");
	$query->execute([':download' => $song]);	
	$count = $query->fetchColumn();
	if(!$soundcloud){
		//$query = $db->prepare("SELECT count(*) FROM songs WHERE hash = :hash");
		//$query->execute([':hash' => $hash]);
		//$count += $query->fetchColumn();
	}
	if($count != 0){
		echo "This song already exists in our database.";
	}else{
	    $query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download, hash)
		VALUES (:name, '9', :author, :size, :download, :hash)");
		$query->execute([':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash]);
		echo "Song reuploaded: <b>".$db->lastInsertId()."</b><hr>";
	}
}else{
	echo "The download link isn't a valid URL";
}
}
	echo '<b>Soundcloud links</b> or <b>Direct links</b> or <b>Dropbox links</b> only accepted, <b><font size="5">NO YOUTUBE LINKS</font></b><br><form action="songAdd.php" method="post">Link: <input type="text" name="songlink"><br><input type="submit" value="Add Song"></form>';

?>