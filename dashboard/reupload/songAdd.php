<?php
session_start();
//error_reporting(0);
include "../../incl/lib/connection.php";
require_once "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if(!empty($_POST["url"])){
	$songID = $gs->songReupload($_POST["url"]);
	if($songID < 0){
		$errorDesc = $dl->getLocalizedString("songAddError$songID");
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
						<p>'.$dl->getLocalizedString("songAddError$songID").'</p>
						<a class="btn btn-primary btn-block" href="'.$_SERVER["REQUEST_URI"].'">'.$dl->getLocalizedString("tryAgainBTN").'</a>
				</form>
				</div>');
	}else{
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("songAdd").'</h1>
		<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("songID").''.$songID.'</p>
				<a class="btn btn-primary btn-block" href="'.$_SERVER["REQUEST_URI"].'">'.$dl->getLocalizedString("songAddAnotherBTN").'</a>
			</form>
		</div>');
	}
}else{
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("songAdd").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("songAddUrlFieldLabel").'</p>
        <div class="field"><input type="text" name="url" placeholder="'.$dl->getLocalizedString("songAddUrlFieldPlaceholder").'"></div>
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