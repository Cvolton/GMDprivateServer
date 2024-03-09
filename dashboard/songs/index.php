<?php
session_start();
require "../../incl/lib/Captcha.php";
include "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
error_reporting(E_ERROR | E_PARSE);
$dl->title($dl->getLocalizedString("songAdd"));
$dl->printFooter('../');
if(strpos($songEnabled, '1') === false) {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("pageDisabled").'</p>
		<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'reupload');
	die();
}
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
		die();
	} else {
    $file_type = $_FILES['filename']['type'];
    $allowed = array("audio/mpeg", "audio/ogg", "audio/mp3");
    if(!in_array($file_type, $allowed)) {
        $db_fid = -7;
    } else {
        $maxsize = $songSize * 1024 * 1024;
        if($_FILES['filename']['size'] >= $maxsize) {
            $db_fid = -5;
        } else {
            $length = 10;
            $db_fid = rand(5, 999999);
            move_uploaded_file($_FILES['filename']['tmp_name'], "$db_fid.mp3");
            $size = ($_FILES['filename']['size'] / 1048576);
            $size = round($size, 2);
            $hash = "";
          	$types = array('.mp3', '.ogg', '.mpeg');
          	$nAu = explode(' - ', str_replace($types, '', $_FILES['filename']['name']));
          	if(!empty($nAu[1])) {
                if(!empty($_POST['name'])) $name = ExploitPatch::charclean($_POST['name']);
                else $name = trim(ExploitPatch::charclean($nAu[1]));
                if(!empty($_POST['author'])) $author = ExploitPatch::charclean($_POST['author']);
                else $author = trim(ExploitPatch::charclean($nAu[0]));
            }
            if(empty($name)) $name = "Unnamed";
            if(empty($author)) $author = "Reupload";
            $servername = $_SERVER['SERVER_NAME'];
			$accountID = $_SESSION["accountID"];
          	$path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);
			$path =  str_replace('index.php', '', $path);
            $song = "http://".$servername."".$path."".$db_fid.".mp3";
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
</div>', 'reupload');
} else {
	$dl->printSong('<div class="form">
	  <h1>'.$dl->getLocalizedString("songAdded").'</h1>
	  <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("songID").''.$db_fid.'</p>
		<button type="submit" class="btn-primary">'.$dl->getLocalizedString("songAddAnotherBTN").'</button>
	  </form>', 'reupload');
}
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("songAdd").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("songAddDesc").'</p>
        <div style="width:100%;text-align:center">
          <label for="upload" class="btn-upload-song">
          	 <i style="margin:0;font-size: 17" class="fa-solid fa-music icon"></i> 
              <input id="upload" type="file" name="filename" size="10" accept=".mp3, .ogg, .mpeg">
                  <text style="font-size: 21">
                    <span>
                        '.$dl->getLocalizedString("chooseFile").'
                    </span>
                  </text>
             <i style="margin:0;font-size: 17" class="fa-solid fa-music icon fa-flip-horizontal"></i>
		  </label>
        </div>
        <div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
        <div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>', 'reupload');
Captcha::displayCaptcha();
echo '<button style="margin-top:5px;margin-bottom:5px" type="submit" class="btn-song">'.$dl->getLocalizedString("reuploadBTN").'</button></form>
		<script>
			$(".btn-upload-song input[type=file]").on("change", function(){
			let file = this.files[0];
			$(this).next().html(file.name.split(".").slice(0, -1).join("."));
			});
		</script>';
}
} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="../dashboard/login/login.php">
		<p>'.$dl->getLocalizedString("noLogin?").'</p>
		<button type="submit" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
		</form>
	</div>', 'reupload');
}
?>
