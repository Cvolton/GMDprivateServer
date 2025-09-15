<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
global $clansEnabled;
if(!$clansEnabled) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>', 'browse'));
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/security.php";
$isPlayerInClan = $gs->isPlayerInClan($_SESSION["accountID"]);
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("createClan"));
if($isPlayerInClan) die($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("alreadyInClan").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse'));
if(isset($_POST["name"]) AND isset($_POST["desc"]) AND isset($_POST["color"])) {
        $name = strip_tags(ExploitPatch::rucharclean(str_replace(' ', '', $_POST["name"]), 20));
		$tag = strip_tags(ExploitPatch::charclean(str_replace(' ', '', strtoupper($_POST["tag"])), 5));
        $desc = base64_encode(strip_tags(ExploitPatch::rucharclean($_POST["desc"], 255)));
        $color = ExploitPatch::charclean(mb_substr($_POST["color"], 1), 6);
		if(!empty($name) AND !empty($color) AND !empty($tag) AND strlen($tag) > 1) {
			if($filterClanNames >= 1) {
				$bannedClanNamesList = array_map('strtolower', $bannedClanNames);
				switch($filterClanNames) {
					case 1:
						if(in_array(strtolower($name), $bannedClanNamesList)) exit($dl->printSong('<div class="form">
							<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
							<form class="form__inner" method="post" action="">
							<p id="dashboard-error-text">'.$dl->getLocalizedString("badClanName").'</p>
							<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
							</form>
						</div>'));
						break;
					case 2:
						foreach($bannedClanNamesList as $bannedClanName) {
							if(!empty($bannedClanName) && mb_strpos(strtolower($name), $bannedClanName) !== false) exit($dl->printSong('<div class="form">
							<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
							<form class="form__inner" method="post" action="">
							<p id="dashboard-error-text">'.$dl->getLocalizedString("badClanName").'</p>
							<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
							</form>
						</div>'));
						}
				}
			}
			if($filterClanTags >= 1) {
				$bannedClanTagsList = array_map('strtolower', $bannedClanTags);
				switch($filterClanTags) {
					case 1:
						if(in_array(strtolower($tag), $bannedClanTagsList)) exit($dl->printSong('<div class="form">
							<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
							<form class="form__inner" method="post" action="">
							<p id="dashboard-error-text">'.$dl->getLocalizedString("badClanTag").'</p>
							<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
							</form>
						</div>'));
						break;
					case 2:
						foreach($bannedClanTagsList as $bannedClanTag) {
							if(!empty($bannedClanTag) && mb_strpos(strtolower($tag), $bannedClanTag) !== false) exit($dl->printSong('<div class="form">
							<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
							<form class="form__inner" method="post" action="">
							<p id="dashboard-error-text">'.$dl->getLocalizedString("badClanTag").'</p>
							<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
							</form>
						</div>'));
						}
				}
			}
			$name = base64_encode($name);
			$tag = base64_encode($tag);
			$check = $db->prepare('SELECT count(*) FROM clans WHERE clan LIKE :c');
			$check->execute([':c' => $name]);
			$check = $check->fetchColumn();
			if($check > 0) exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action=".">
					<p id="dashboard-error-text">'.$dl->getLocalizedString("takenClanName").'</p>
						<button type="button" onclick="a(\'clans/create.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'browse'));
			$check = $db->prepare('SELECT count(*) FROM clans WHERE tag LIKE :t');
			$check->execute([':t' => $tag]);
			$check = $check->fetchColumn();
			if($check > 0) exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action=".">
					<p id="dashboard-error-text">'.$dl->getLocalizedString("takenClanTag").'</p>
						<button type="button" onclick="a(\'clans/create.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'browse'));
			$clan = $db->prepare("INSERT INTO clans (`clan`, `desc`, `clanOwner`, `color`, `creationDate`, `tag`) VALUES (:c, :d, :co, :col, :cr, :t)");
			$clan->execute([':c' => $name, ':d' => $desc, ':co' => $_SESSION["accountID"], ':col' => $color, ':cr' => time(), ':t' => $tag]);
			$owner = $db->prepare("UPDATE users SET clan = :c, joinedAt = :j WHERE extID = :i");
			$owner->execute([':c' => $db->lastInsertId(), ':j' => time(), ':i' => $_SESSION["accountID"]]);
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("createClan").'</h1>
				<form class="form__inner" method="post" action=".">
					<p>'.sprintf($dl->getLocalizedString("createdClan"), $color, base64_decode($name)).'</p>
						<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
				</form>
			</div>', 'browse');
		}
} else $dl->printSong('<div class="form">
   <h1>'.$dl->getLocalizedString("createClan").'</h1>
   <form class="form__inner" method="post" action="">
  <p>'.$dl->getLocalizedString("createClanDesc").'</p>
	<div class="field"><input type="text" name="name" id="p1" placeholder="'.$dl->getLocalizedString("clanName").'"></div>
	<div class="field"><input type="text" name="tag" id="p2" placeholder="'.$dl->getLocalizedString("clanTag").'"></div>
	<div class="field"><input type="text" name="desc" placeholder="'.$dl->getLocalizedString("clanDesc").'"></div>
	<div class="field color123"><input type="color" id="color" name="color" placeholder="'.$dl->getLocalizedString("clanColor").'"></div>
  <button type="button" id="submit" onclick="a(\'clans/create.php\', true, false, \'POST\')" class="btn-primary">'.$dl->getLocalizedString("create").'</button>
 </form>
</div>', 'browse');
?>