<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$dl->title($dl->getLocalizedString("packCreateTitle"));
$dl->printFooter('../');
if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")){
	$query = $db->prepare("SELECT levelID, levelName, starStars FROM levels");
	$query->execute();
	$result = $query->fetchAll();
if(!empty($_POST["packName"])) {
		if(!Captcha::validateCaptcha()) {
			$dl->printSong('<div class="form">
				<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
				<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
				<button type="submit" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
				</form>
			</div>', 'mod');
		die();
		}
	$accountID = $_SESSION["accountID"];
	if($_POST['level_1'] == $_POST['level_3'] OR $_POST['level_3'] == $_POST['level_2'] OR $_POST['level_1'] == $_POST['level_2']) {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("sameLevels").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>', 'mod');
		die();
	}
	$name = ExploitPatch::remove($_POST["packName"]);
	$color = ExploitPatch::remove($dl->hex2RGB($_POST["color"], true));
	$stars = ExploitPatch::remove($_POST["stars"]);
	$coins = ExploitPatch::remove($_POST["coins"]);
	if(!is_numeric($_POST['level_1']) OR !is_numeric($_POST['level_2']) OR !is_numeric($_POST['level_3'])) {
	$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidPost").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'mod');
		die();
	}
	$levels = ExploitPatch::remove($_POST['level_1']) . ',' . ExploitPatch::remove($_POST['level_2']) . ',' . ExploitPatch::remove($_POST['level_3']);
	switch($stars){
				case 1:
					$diffname = "Auto";
					$diff = 0;
					break;
				case 2:
					$diffname = "Easy";
					$diff = 1;
					break;
				case 3:
					$diffname = "Normal";
					$diff = 2;
					break;
				case 4:
				case 5:
					$diffname = "Hard";
					$diff = 3;
					break;
				case 6:
				case 7:
					$diffname = "Harder";
					$diff = 4;
					break;
				case 8:
				case 9:
					$diffname = "Insane";
					$diff = 5;
					break;
				case 10:
					$diffname = "Demon";
					$diff = 6;
					break;
			}
	$query = $db->prepare("INSERT INTO mappacks (name, levels, stars, coins, difficulty, rgbcolors, colors2) VALUES (:name, :levels, :stars, :coins, :diff, :rgb, :c2)");
	$query->execute([':name' => $name, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':diff' => $diff, ':rgb' => $color, ':c2' => 'none']);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3, value4, value7) VALUES ('17',:value,:timestamp,:account,:levels, :stars, :coins, :rgb)");
	$query->execute([':value' => $name, ':timestamp' => time(), ':account' => $accountID, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':rgb' => $color]);
	$success = $dl->getLocalizedString("packCreateSuccess").' <b style="color:'.$_POST["color"].'">'.$name."</b>!";
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("packCreateTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$success.'</p>
	    <button type="submit" class="btn-primary">'.$dl->getLocalizedString("packCreateOneMore").'</button>
    </form>
</div>', 'mod');
} else {
	$options = '';
	foreach ($result as $i => $row) {
		if ($row['starStars'] != 0) {
			$options .= '<option value="'. $row['levelID'] .'">'. $row['levelName'] .'</option>';
		}
	}
	$dl->printSong('<div class="form">
    <h1>' . $dl->getLocalizedString("packCreateTitle") . '</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>' . $dl->getLocalizedString("packCreateDesc") . '</p>
    <div class="field"><input type="text" name="packName" id="p1" placeholder="' . $dl->getLocalizedString("packName") . '"></div>
	<div class="field color123"><input type="color" name="color" placeholder="' . $dl->getLocalizedString("color") . '"></div>
	<div id="selecthihi">
	<select name="stars">
	<option value="10">10 '.$dl->getLocalizedString("starsLevel2").'</option>
	<option value="9">9 '.$dl->getLocalizedString("starsLevel2").'</option>
	<option value="8">8 '.$dl->getLocalizedString("starsLevel2").'</option>
	<option value="7">7 '.$dl->getLocalizedString("starsLevel2").'</option>
	<option value="6">6 '.$dl->getLocalizedString("starsLevel2").'</option>
	<option value="5">5 '.$dl->getLocalizedString("starsLevel2").'</option>
	<option value="4">4 '.$dl->getLocalizedString("starsLevel1").'</option>
	<option value="3">3 '.$dl->getLocalizedString("starsLevel1").'</option>
	<option value="2">2 '.$dl->getLocalizedString("starsLevel1").'</option>
	<option value="1">1 '.$dl->getLocalizedString("starsLevel0").'</option>
	</select>
	<select name="coins">
	<option value="2">2 '.$dl->getLocalizedString("coins1").'</option>
	<option value="1">1 '.$dl->getLocalizedString("coins0").'</option>
	</select>
	</div>
    <div>
    <select name="level_1">
        ' . $options . '
    </select>
    <select name="level_2">
        ' . $options . '
    </select>
    <select name="level_3">
        ' . $options . '
    </select>
    </div>', 'mod');
		Captcha::displayCaptcha();
        echo '
        <button type="submit" class="btn-primary btn-block" id="submit" disabled>' . $dl->getLocalizedString("packCreate") . '</button>
    </form>
    </div>
    <script>
$(document).change(function(){
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
        document.addEventListener("submit", () => {
            let selectData = [];
            document.querySelectorAll("select > option").forEach(el => {
                selectData.push(el.value);
            });

            var formData = new FormData();

            formData.append("select_data", selectData);

            var request = new XMLHttpRequest();
            request.open("POST", "/");
            request.send(formData);

        });
    </script>';
}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>', 'mod');
?>