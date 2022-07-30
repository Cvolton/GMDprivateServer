<?php
session_start();
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
error_reporting(E_ERROR | E_PARSE);
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if ($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
    $file_type = $_FILES['filename']['type'];
    $allowed = array("audio/mpeg", "audio/ogg", "audio/mp3");

    if (!in_array($file_type, $allowed)) {
        $db_fid = -7;
    } else {
        $maxsize = 12582912;

        if ($_FILES['filename']['size'] >= $maxsize) {
            $db_fid = -5;
        } else {
            $length = 10;
            $db_fid = rand(5, 999999);
            move_uploaded_file($_FILES['filename']['tmp_name'], "$db_fid.mp3");
            $size = ($_FILES['filename']['size'] / 1048576);
            $size = round($size, 2);
            $hash = "";
            $name = $ep->remove($_POST['name']);
            $author = $ep->remove($_POST['author']);
            if ($name == null) {$name = "Unnamed";}
            if ($author == null) {$author = "Reupload";}
            $servername = $_SERVER['SERVER_NAME'];
			$accountID = $_SESSION["accountID"];
            $song = "http://$servername/database/dashboard/songs/$db_fid.mp3";
            $query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, download, hash, reuploadTime, reuploadID) VALUES (:id, :name, '9', :author, :size, :download, :hash, :reuploadTime, :reuploadID)");
            $query->execute([':id' => $db_fid, ':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash, ':reuploadTime' => time(), ':reuploadID' => $accountID]);
			
        } 
    }  if($db_fid < 0) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("songAddError$db_fid").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>');
} else {
	$dl->printSong('<div class="form">
	  <h1>'.$dl->getLocalizedString("songAdded").'</h1>
	  <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("songID").''.$db_fid.'</p>
		<button type="submit" class="btn-primary">'.$dl->getLocalizedString("songAddAnotherBTN").'</button>
	  </form>');
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("songAdd").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
        <div class="btn-song" id="upload"><input type="file" name="filename" size="10" accept=".mp3, .ogg, .mpeg"></div>
        <div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
        <div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>
        <button type="submit" class="btn-song">'.$dl->getLocalizedString("reuploadBTN").'</button>
    </form>
</div>');
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="../dashboard/login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>');
}
?>