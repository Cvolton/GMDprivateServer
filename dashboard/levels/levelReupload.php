<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/automod.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/reuploadAcc.php";
require "../".$dbPath."config/proxy.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/XORCipher.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$dl = new dashboardLib();
global $lrEnabled;
$dl->title($dl->getLocalizedString("levelReupload"));
$dl->printFooter('../');
if($lrEnabled == 1 && !Automod::isLevelsDisabled()) {
function chkarray($source, $default = 0) {
	if($source == "") $target = $default;
	else $target = $source;
	return $target;
}
$gs = new mainLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0) {
$checkBan = $gs->getPersonBan($_SESSION['accountID'], $gs->getUserID($_SESSION['accountID'], $gs->getAccountName($_SESSION['accountID'])), 2);
if($checkBan) exit($dl->printSong('<div class="form">
<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="">
	<p id="dashboard-error-text">'.sprintf($dl->getLocalizedString("youAreBanned"), htmlspecialchars(base64_decode($checkBan['reason'])), date("d.m.Y G:i", $checkBan['expires'])).'</p>
	<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
	</form>
</div>', 'reupload'));
if(!empty($_POST["levelid"])) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
		die();
	}
	if($_POST["debug"] == 1) $debug = 1;
	else $debug = 0;
	$levelID = ExploitPatch::number($_POST["levelid"]);
	$url = $_POST["server"];
	if(mb_substr($url, 0, 4) != 'http') exit($dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("invalidPost").'</p>
		<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'reupload'));
	$post = ['gameVersion' => '22', 'binaryVersion' => '42', 'gdw' => '0', 'levelID' => $levelID, 'secret' => 'Wmfd2893gb7', 'inc' => '0', 'extras' => '0'];
	if($requireAccountForReuploading) {
		$usertarg = ExploitPatch::charclean($_POST["usertarg"]);
		$passtarg = GeneratePass::GJP2fromPassword($_POST["passtarg"]);
		$udid = "S" . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(111111111,999999999) . mt_rand(1,9); //getting accountid
		$sid = mt_rand(111111111,999999999) . mt_rand(11111111,99999999);
		//echo $udid;
		$post1 = ['userName' => $usertarg, 'udid' => $udid, 'gjp2' => $passtarg, 'sID' => $sid, 'secret' => 'Wmfv3899gc9'];
		$ch = curl_init($url . "/accounts/loginGJAccount.php");
		if($proxytype == 1) {
			curl_setopt($ch, CURLOPT_PROXY, $host);
		} elseif($proxytype == 2) {
			curl_setopt($ch, CURLOPT_PROXY, $host);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
		}
		if(!empty($auth)) { 
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post1);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_USERAGENT, "");
		$result = curl_exec($ch);
		curl_close($ch);
		if($result == "" OR $result == "-1" OR $result == "No no no") {
			$errorArray = ["" => $dl->getLocalizedString("errorConnection"), '-1' => $dl->getLocalizedString("wrongNickOrPass"), 'No no no' => $dl->getLocalizedString("robtopLol")];
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$errorArray[$result].'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
		}
		$resultArray = explode(",",$result);
		$targetAccountID = $resultArray[0];
		$targetUserID = $resultArray[1];
		if(!$targetAccountID) {
			die($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("errorConnection").'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload'));
		}
		$post['accountID'] = $targetAccountID;
		$post['gjp2'] = $passtarg;
		$post['uuid'] = $targetUserID;
	}
	$ch = curl_init($url.'/downloadGJLevel22.php');
	// "StackOverflow is a lifesaver" - masckmaster 2023
	if($proxytype == 1) curl_setopt($ch, CURLOPT_PROXY, $host);
	elseif($proxytype == 2) {
		curl_setopt($ch, CURLOPT_PROXY, $host);
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	}
	if(!empty($auth)) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
	curl_setopt($ch, CURLOPT_USERAGENT, "");
	$result = curl_exec($ch);
	curl_close($ch);
	if($result == "" OR $result == "-1" OR $result == "No no no") {
		$errorArray = ["" => $dl->getLocalizedString("errorConnection"), '-1' => $dl->getLocalizedString("levelNotFound"), 'No no no' => $dl->getLocalizedString("robtopLol")];
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p id="dashboard-error-text">'.$errorArray[$result].'</p>
			<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
	} else {
		$level = explode('#', $result)[0];
		$resultarray = explode(':', $level);
		$levelarray = array();
		$x = 1;
		foreach($resultarray as &$value) {
			if($x % 2 == 0) $levelarray["a$arname"] = $value;
			else$arname = $value;
			$x++;
		}
		if($levelarray["a4"] == "") {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.htmlspecialchars($result, ENT_QUOTES).'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
		}
		$levelUserID = chkarray($levelarray["a6"]);
		if($targetUserID != $levelUserID && ($requireAccountForReuploading && $disallowReuploadingNotUserLevels)) {
			die($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("notYourLevel").'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload'));
		}
		//echo $result;
		$uploadDate = time();
		//old levelString
		$levelString = chkarray($levelarray["a4"]);
		$gameVersion = chkarray($levelarray["a13"]);
		if(substr($levelString,0,2) == 'eJ') {
			$levelString = gzuncompress(ExploitPatch::url_base64_decode($levelString));
			if($gameVersion > 18) $gameVersion = 18;
		}
		//check if exists
		$parsedurl = parse_url($url);
		if($parsedurl["host"] == $_SERVER['SERVER_NAME']) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p id="dashboard-error-text">'.$dl->getLocalizedString("sameServers").'</p>
				<button type="button" onclick="a(\'levels/levelReupload.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'reupload');
			die();
		}
		$query = $db->prepare("SELECT * FROM levels WHERE originalReup = :lvl AND originalServer = :server");
		$query->execute([':lvl' => $levelarray["a1"], ':server' => $parsedurl["host"]]);
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
		$songIDs = isset($levelarray["a52"]) ? $levelarray["a52"] : '';
		$sfxIDs = isset($levelarray["a53"]) ? $levelarray["a53"] : '';
		$ts = chkarray($levelarray["a57"]);
		if($password != "0") $password = XORCipher::cipher(ExploitPatch::url_base64_decode($password), 26364);
		$starCoins = 0;
		$starDiff = 0;
		$starDemon = 0;
		$starAuto = 0;
		$starStars = 0;
		//linkacc
		if($automaticID) {
			$reupUID = $gs->getUserID($_SESSION["accountID"]);
			$reupAID = $_SESSION["accountID"];
		}
		//query
		$levelData = $query->fetch();
		$levelID = $levelData['levelID'];
		if(!$levelID) {
			$levelName = strip_tags($levelarray["a2"]);
			$levelDesc = strip_tags($levelarray["a3"]);
			$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, updateDate, originalReup, originalServer, userID, extID, unlisted, hostname, starStars, starCoins, starDifficulty, starDemon, starAuto, isLDM, songIDs, sfxIDs, ts, settingsString) VALUES (:name ,:gameVersion, '27', 'Reupload', :desc, :version, :length, :audiotrack, '0', :password, :originalReup, :twoPlayer, :songID, '0', :coins, :reqstar, :extraString, :levelString, '', '', '$uploadDate', '$uploadDate', :originalReup, :originalServer, :userID, :extID, '0', :hostname, :starStars, :starCoins, :starDifficulty, :starDemon, :starAuto, :isLDM, :songIDs, :sfxIDs, :ts, '')");
			$query->execute([':password' => $password, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':gameVersion' => $gameVersion, ':name' => $levelName, ':desc' => $levelDesc, ':version' => $levelarray["a5"], ':length' => $levelarray["a15"], ':audiotrack' => $levelarray["a12"], ':twoPlayer' => $twoPlayer, ':songID' => $songID, ':coins' => $coins, ':reqstar' => $reqstar, ':extraString' => $extraString, ':levelString' => "", ':originalReup' => $levelarray["a1"], ':originalServer' => $parsedurl['host'], ':hostname' => $hostname, ':starStars' => 0, ':starCoins' => 0, ':starDifficulty' => $starDiff, ':userID' => $reupUID, ':extID' => $reupAID, ':isLDM' => $isLDM, ':songIDs' => $songIDs, ':sfxIDs' => $sfxIDs, ':ts' => $ts]);
			$levelID = $db->lastInsertId();
			$gs->logAction($_SESSION['accountID'], 22, $levelName, $levelDesc, $levelID);
		} else $gs->logAction($_SESSION['accountID'], 23, $levelData['levelName'], $levelData['levelDesc'], $levelData['levelID']);
		$gs->sendLogsLevelChangeWebhook($levelID, $_SESSION['accountID'], $levelData);
		Automod::checkLevelsCount();
		file_put_contents("../".$dbPath."data/levels/$levelID", $levelString);
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
    <h1>'.$dl->getLocalizedString("levelReupload").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("levelReuploadDesc").'</p>
        <div class="field"><input type="text" name="levelid" id="p1" placeholder="'.$dl->getLocalizedString("levelID").'"></div>
		'.($requireAccountForReuploading ? '
			<div class="field"><input type="text" name="usertarg" id="p2" placeholder="'.$dl->getLocalizedString("usernameTarget").'"></div>
			<div class="field"><input type="password" name="passtarg" id="p3" placeholder="'.$dl->getLocalizedString("passwordTarget").'"></div>
		' : '').'
		<div class="field" style="display: inline-flex;width:100%;justify-content: space-between;">
           	<input type="text" name="server" id="p2" value="https://www.boomlings.com/database/" placeholder="'.$dl->getLocalizedString("server").'" style="width: 100%;">
		</div>
		'.Captcha::displayCaptcha(true).'
        <button type="button" onclick="a(\'levels/levelReupload.php\', true, true, \'POST\')" class="btn-song" id="submit">'.$dl->getLocalizedString("reuploadBTN").'</button>
    </form>
</div>', 'reupload');
}
} else {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
	<form class="form__inner" method="post" action="./login/login.php">
	<p id="dashboard-error-text">'.$dl->getLocalizedString("noLogin?").'</p>
	        <button type="button" onclick="a(\'login/login.php\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
    </form>
</div>', 'reupload');
}
} else {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>', 'reupload');
}
?>