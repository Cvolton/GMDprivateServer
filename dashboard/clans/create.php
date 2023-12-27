<?php
session_start();
include "../incl/dashboardLib.php";
$dl = new dashboardLib();
global $clansEnabled;
if(!$clansEnabled) exit($dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action=".">
			<p>'.$dl->getLocalizedString("pageDisabled").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("dashboard").'</button>
			</form>
		</div>', 'browse'));
include "../".$dbPath."incl/lib/exploitPatch.php";
include_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$isPlayerInClan = $gs->isPlayerInClan($_SESSION["accountID"]);
$dl->printFooter('../');
$dl->title($dl->getLocalizedString("createClan"));
if($isPlayerInClan) die($dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("alreadyInClan").'</p>
	        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse'));
if(isset($_POST["name"]) AND isset($_POST["desc"]) AND isset($_POST["color"])) {
        $name = base64_encode(strip_tags(ExploitPatch::rucharclean(str_replace(' ', '', $_POST["name"]), 20)));
        $desc = base64_encode(strip_tags(ExploitPatch::rucharclean($_POST["desc"], 255)));
        $color = ExploitPatch::charclean(mb_substr($_POST["color"], 1), 6);
		if(!empty($name) AND !empty($color)) {
			$check = $db->prepare('SELECT count(*) FROM clans WHERE clan LIKE :c');
			$check->execute([':c' => $name]);
			$check = $check->fetchColumn();
			if($check > 0) exit($dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action=".">
					<p>'.$dl->getLocalizedString("takenClanName").'</p>
						<button type="button" onclick="a(\'clans/create.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'browse'));
			$clan = $db->prepare("INSERT INTO clans (`clan`, `desc`, `clanOwner`, `color`, `creationDate`) VALUES (:c, :d, :co, :col, :cr)");
			$clan->execute([':c' => $name, ':d' => $desc, ':co' => $_SESSION["accountID"], ':col' => $color, ':cr' => time()]);
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
	<div class="field"><input type="text" name="desc" placeholder="'.$dl->getLocalizedString("clanDesc").'"></div>
	<div class="field color123"><input type="color" id="color" name="color" placeholder="'.$dl->getLocalizedString("clanColor").'"></div>
  <button type="button" id="submit" onclick="a(\'clans/create.php\', true, false, \'POST\')" class="btn-primary btn-block" disabled>'.$dl->getLocalizedString("create").'</button>
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
})
</script>', 'browse');
?>