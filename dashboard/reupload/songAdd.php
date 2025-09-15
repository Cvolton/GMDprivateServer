<?php
session_start();
require_once "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."config/dashboard.php";
$dl = new dashboardLib();
$gs = new mainLib();
$dl->title($dl->getLocalizedString("songLink"));
$dl->printFooter('../');
if(strpos($songEnabled, '2') === false) {
	exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("pageDisabled").'</p>
		<button type="button" onclick="a(\'reupload/songAdd.php\', true, true, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'reupload'));
}
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) {
	if(!empty($_POST["url"])) {
		if(!Captcha::validateCaptcha()) {
			exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="button" onclick="a(\'reupload/songAdd.php\', true, true, \'GET\')"class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload'));
		}
		$song = $_POST['url'];
		$author = strip_tags(ExploitPatch::rucharclean($_POST["author"], 30)) ?: 'Reupload';
		$name = strip_tags(ExploitPatch::rucharclean($_POST["name"], 40)) ?: 'Unnamed';
		$songID = $gs->songReupload($song, $author, $name, $_SESSION["accountID"]);
		if($songID == '-4' && strpos($songEnabled, '1') !== false) {
			$songFile = $gs->getDownloadLinkWithCobalt($song);
			if($songFile) {
				$cobaltSongSize = strlen($songFile);
				if($cobaltSongSize >= $songSize * 1024 * 1024) exit($dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
						<p id="dashboard-error-text">'.$dl->getLocalizedString("songAddError-5").'</p>
						<button type="button" onclick="a(\'reupload/songAdd.php\', true, true, \'GET\')"class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
					</div>', 'reupload'));
				$freeID = false;
				while(!$freeID) {
					$songID = rand(99, 7999999);
					$checkID = $db->prepare('SELECT count(*) FROM songs WHERE ID = :id'); // If randomized ID picks existing song ID
					$checkID->execute([':id' => $songID]);
					if($checkID->fetchColumn() == 0) $freeID = true;
				}
				file_put_contents(__DIR__.'/../songs/'.$songID.'.mp3', $songFile);
				$duration = $gs->getAudioDuration(realpath(__DIR__.'/../songs/'.$songID.'.mp3'));
				$duration = empty($duration) ? 0 : $duration;
				$dirPath = dirname(dirname($_SERVER["REQUEST_URI"]));
				if($dirPath == '/') $dirPath = ''; 
				$songUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER["HTTP_HOST"].$dirPath.'/songs/'.$songID.".mp3";
				$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, duration, download, hash, reuploadTime, reuploadID, isDisabled) VALUES (:id, :name, '9', :author, :size, :duration, :download, :hash, :reuploadTime, :reuploadID, :isDisabled)");
				$query->execute([':id' => $songID, ':name' => $name, ':download' => $songUrl, ':author' => $author, ':size' => round($cobaltSongSize / 1048576, 2), ':duration' => $duration, ':hash' => '', ':reuploadTime' => time(), ':reuploadID' => $_SESSION['accountID'], ':isDisabled' => ($preenableSongs ? 0 : 1)]);
			}
		}
		if($songID < 0) {
			$existed = str_replace('-3', '', $songID);
			if($songID != $existed) {
				exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
					<p id="dashboard-error-text">'.$dl->getLocalizedString("songAddError-3").' '.$existed.'</p>
					<button type="button" onclick="a(\'reupload/songAdd.php\', true, true, \'GET\')"class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
				</div>', 'reupload'));
			}
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("songAddError$songID").'</p>
				<button type="button" onclick="a(\'reupload/songAdd.php\', true, true, \'GET\')"class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'reupload');
		} else {
			$songArray = $db->prepare('SELECT * FROM songs WHERE ID = :ID');
			$songArray->execute([':ID' => $songID]);
			$songArray = $songArray->fetch();
			$wholiked = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-heart"></i> 0</p>';
			$whoused = '<p class="profilepic" style="display: inline-flex;justify-content: center;grid-gap: 7px;"><i class="fa-solid fa-gamepad"></i> 0</p>';
			$songs = $dl->generateSongCard($songArray, $wholiked.$whoused, false);
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("songAdded").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("yourNewSong").'</p>
			<div class="songUploadDiv">'.$songs.'</div>
			<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("songAddAnotherBTN").'</button>
			</form>', 'reupload');
		}
	}else{
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("songAdd").'</h1>
		<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("songAddDesc").'</p>
			<div class="field"><input type="text" name="url" id="p1" placeholder="'.$dl->getLocalizedString("songAddUrlFieldPlaceholder").'"></div>
			<div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
			<div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>
			'.Captcha::displayCaptcha(true).'<button type="button" onclick="a(\'reupload/songAdd.php\', true, true, \'POST\')" class="btn-song" id="submit">'.$dl->getLocalizedString("reuploadBTN").'</button>
		</form>
	</div>', 'reupload');
	}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\')" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'reupload');
}
?>