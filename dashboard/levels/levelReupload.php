<?php
session_start();
include "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
$dl = new dashboardLib();
global $lrEnabled;
$dl->title($dl->getLocalizedString("levelReupload"));
$dl->printFooter('../');
if($lrEnabled == 1) {
function chkarray($source, $default = 0){
	if($source == ""){
		$target = $default;
	}else{
		$target = $source;
	}
	return $target;
}
//error_reporting(0);
include "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/XORCipher.php";
require "../".$dbPath."config/reuploadAcc.php";
require "../".$dbPath."config/proxy.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if(!empty($_POST["levelid"])){
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
		die();
	}
	if($_POST["debug"] == 1) $debug = 1;
	else $debug = 0;
	$levelID = $_POST["levelid"];
	$levelID = preg_replace("/[^0-9]/", '', $levelID);
	$url = $_POST["server"];
	$post = ['gameVersion' => '21', 'binaryVersion' => '33', 'gdw' => '0', 'levelID' => $levelID, 'secret' => 'Wmfd2893gb7', 'inc' => '1', 'extras' => '0'];
	$ch = curl_init($url);
	// "StackOverflow is a lifesaver" - masckmaster 2023
	if($proxytype == 1){
		curl_setopt($ch, CURLOPT_PROXY, $host);
	} elseif($proxytype == 2) {
		curl_setopt($ch, CURLOPT_PROXY, $host);
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	}
	if(!empty($auth)) { 
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no") {
		if($result=="") {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("errorConnection").'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
		} else if($result=="-1") {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("levelNotFound").'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
		} else {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("robtopLol").'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
		}
	} else {
		$level = explode('#', $result)[0];
		$resultarray = explode(':', $level);
		$levelarray = array();
		$x = 1;
		foreach($resultarray as &$value){
			if ($x % 2 == 0) {
				$levelarray["a$arname"] = $value;
			}else{
				$arname = $value;
			}
			$x++;
		}
		//echo $result;
		if($levelarray["a4"] == ""){
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.htmlspecialchars($result,ENT_QUOTES).'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
		}
		$uploadDate = time();
		//old levelString
		$levelString = chkarray($levelarray["a4"]);
		$gameVersion = chkarray($levelarray["a13"]);
		if(substr($levelString,0,2) == 'eJ'){
			$levelString = str_replace("_","/",$levelString);
			$levelString = str_replace("-","+",$levelString);
			$levelString = gzuncompress(base64_decode($levelString));
			if($gameVersion > 18){
				$gameVersion = 18;
			}
		}
		//check if exists
		$query = $db->prepare("SELECT count(*) FROM levels WHERE originalReup = :lvl OR original = :lvl");
		$query->execute([':lvl' => $levelarray["a1"]]);
		if($query->fetchColumn() == 0){
			$parsedurl = parse_url($url);
			if($parsedurl["host"] == $_SERVER['SERVER_NAME']){
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("sameServers").'</p>
					<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>', 'reupload');
				die();
			}
			$hostname = $gs->getIP();
			//values
			$twoPlayer = chkarray($levelarray["a31"]);
			$songID = chkarray($levelarray["a35"]);
			$coins = chkarray($levelarray["a37"]);
			$reqstar = chkarray($levelarray["a39"]);
			$extraString = chkarray($levelarray["a36"], "");
			$starStars = chkarray($levelarray["a18"]);
			$isLDM = chkarray($levelarray["a40"]);
			$password = chkarray($levelarray["a27"]);
			if($password != "0"){
				$password = XORCipher::cipher(base64_decode($password),26364);
			}
			$starCoins = 0;
			$starDiff = 0;
			$starDemon = 0;
			$starAuto = 0;
			if($parsedurl["host"] == "www.boomlings.com"){
				if($starStars != 0){
					$starCoins = chkarray($levelarray["a38"]);
					$starDiff = chkarray($levelarray["a9"]);
					$starDemon = chkarray($levelarray["a17"]);
					$starAuto = chkarray($levelarray["a25"]);
				}
			}else{
				$starStars = 0;
			}
			$targetUserID = chkarray($levelarray["a6"]);
			//linkacc
			$userID = $gs->getUserID($_SESSION["accountID"]);
			$extID = $_SESSION["accountID"];
			//query
			$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, updateDate, originalReup, userID, extID, unlisted, hostname, starStars, starCoins, starDifficulty, starDemon, starAuto, isLDM)
												VALUES (:name ,:gameVersion, '27', 'Reupload', :desc, :version, :length, :audiotrack, '0', :password, :originalReup, :twoPlayer, :songID, '0', :coins, :reqstar, :extraString, :levelString, '', '', '$uploadDate', '$uploadDate', :originalReup, :userID, :extID, '0', :hostname, :starStars, :starCoins, :starDifficulty, :starDemon, :starAuto, :isLDM)");
			$query->execute([':password' => $password, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':gameVersion' => $gameVersion, ':name' => $levelarray["a2"], ':desc' => $levelarray["a3"], ':version' => $levelarray["a5"], ':length' => $levelarray["a15"], ':audiotrack' => $levelarray["a12"], ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':coins' => $coins, ':reqstar' => $reqstar, ':extraString' => $extraString, ':levelString' => "", ':originalReup' => $levelarray["a1"], ':hostname' => $hostname, ':starStars' => 0, ':starCoins' => 0, ':starDifficulty' => $starDiff, ':userID' => $userID, ':extID' => $extID, ':isLDM' => $isLDM]);
			$levelID = $db->lastInsertId();
			file_put_contents("../".$dbPath."data/levels/$levelID", $levelString);
		if($debug == 1) {
			$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("levelReupload").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("levelReuploaded").' '.$levelID.'!</p>
					<details style="color:white">
					<summary>Debug</summary>
					'.$result.'
					</details>
					<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("oneMoreLevel?").'</button>
					</form>
				</div>', 'reupload');
		} else {
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("levelReupload").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("levelReuploaded").' '.$levelID.'</p>
					<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("oneMoreLevel?").'</button>
					</form>
				</div>', 'reupload');
		}
		} else {
				$dl->printSong('<div class="form">
					<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
					<form class="form__inner" method="post" action="">
					<p>'.$dl->getLocalizedString("levelAlreadyReuploaded").'</p>
					<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
					</form>
				</div>', 'reupload');
		}
	}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("levelReupload").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("levelReuploadDesc").'</p>
        <div class="field"><input type="text" name="levelid" id="p1" placeholder="'.$dl->getLocalizedString("levelID").'"></div>
		<details class="details">
			<summary style="width: 100%;">'.$dl->getLocalizedString("advanced").'</summary>
			<div class="field" style="display: inline-flex;width:100%;justify-content: space-between;">
            	<input type="text" name="server" id="p2" value="http://www.boomlings.com/database/downloadGJLevel22.php" placeholder="'.$dl->getLocalizedString("server").'" style="width: 86%;">
			<input class="checkbox" type="checkbox" name="debug" value="1" placeholder="Debug" style="width: 8%;">
			</div>
		</details>', 'reupload');
		Captcha::displayCaptcha();
        echo '
        <button type="button" onclick="a(\'levels/levelReupload.php\', true, true, \'POST\')" class="btn-song btn-block" id="submit" disabled>'.$dl->getLocalizedString("reuploadBTN").'</button>
    </form>
</div>
<script>
$(document).on("keyup keypress change keydown",function(){
   const p1 = document.getElementById("p1");
   const p2 = document.getElementById("p2");
   const btn = document.getElementById("submit");
   if(!p1.value.trim().length || !p2.value.trim().length) {
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
	        <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'reupload');
}
} else {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>', 'reupload');
}
?>
