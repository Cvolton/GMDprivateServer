<?php
session_start();
//error_reporting(0);
require "../../incl/lib/Captcha.php";
include "../../incl/lib/connection.php";
require_once "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("songLink"));
$dl->printFooter('../');
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if(!empty($_POST["url"])){
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
		die();
	}
	$songID = $gs->songReupload($_POST["url"], $_POST["author"], $_POST["name"], $_SESSION["accountID"]);
	if($songID < 0){
		$existed = str_replace('-3', '', $songID);
		if($songID != $existed) {
					$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
						<p>'.$dl->getLocalizedString("songAddError-3").' '.$existed.'</p>
						<a class="btn btn-primary btn-block" href="'.$_SERVER["REQUEST_URI"].'">'.$dl->getLocalizedString("tryAgainBTN").'</a>
				</form>
				</div>', 'reupload');
				die();
		}
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
						<p>'.$dl->getLocalizedString("songAddError$songID").'</p>
						<a class="btn btn-primary btn-block" href="'.$_SERVER["REQUEST_URI"].'">'.$dl->getLocalizedString("tryAgainBTN").'</a>
				</form>
				</div>', 'reupload');
	}else{
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("songAdd").'</h1>
		<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("songID").''.$songID.'</p>
				<a class="btn btn-primary btn-block" href="'.$_SERVER["REQUEST_URI"].'">'.$dl->getLocalizedString("songAddAnotherBTN").'</a>
			</form>
		</div>', 'reupload');
	}
}else{
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("songAdd").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("songAddUrlFieldLabel").'</p>
        <div class="field"><input type="text" name="url" placeholder="'.$dl->getLocalizedString("songAddUrlFieldPlaceholder").'"></div>
		<div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
		<div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>
		', 'reupload');
		Captcha::displayCaptcha();
        echo '<button type="submit" class="btn-song">'.$dl->getLocalizedString("reuploadBTN").'</button>
    </form>
</div>';
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