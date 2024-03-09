<?php
session_start();
require_once "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("songLink"));
$dl->printFooter('../');
if(strpos($songEnabled, '2') === false) {
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
        <div class="field"><input type="text" name="url" id="p1" placeholder="'.$dl->getLocalizedString("songAddUrlFieldPlaceholder").'"></div>
		<div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
		<div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>
		', 'reupload');
		Captcha::displayCaptcha();
        echo '<button type="submit" class="btn-song btn-block" id="submit" disabled>'.$dl->getLocalizedString("reuploadBTN").'</button>
    </form>
</div>
<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length) {
                btn.disabled = true;
                btn.classList.add("btn-block");
                btn.classList.remove("btn-song");
	} else {
		        btn.removeAttribute("disabled");
                btn.classList.remove("btn-block");
                btn.classList.remove("btn-size");
                btn.classList.add("btn-song");
	}
});
</script>';
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p>'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="submit" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'reupload');
}
?>