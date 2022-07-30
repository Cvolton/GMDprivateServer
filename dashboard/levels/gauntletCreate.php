<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
include "../../incl/lib/connection.php";
include "../../incl/lib/exploitPatch.php";
error_reporting(0);
$ep = new exploitPatch();
if($gs->checkPermission($_SESSION["accountID"], "dashboardLevelPackCreate")){
	$query = $db->prepare("SELECT levelID, levelName, starStars FROM levels");
	$query->execute();
	$result = $query->fetchAll();
if($_POST["checkbox_data"] == 'on') {
	$accountID = $_SESSION["accountID"];
	if ($_POST['level_1'] == $_POST['level_2'] ||
    $_POST['level_1'] == $_POST['level_3'] ||
    $_POST['level_1'] == $_POST['level_4'] ||
    $_POST['level_1'] == $_POST['level_5'] ||
    $_POST['level_2'] == $_POST['level_1'] ||
    $_POST['level_2'] == $_POST['level_3'] ||
    $_POST['level_2'] == $_POST['level_4'] ||
    $_POST['level_2'] == $_POST['level_5'] ||
    $_POST['level_3'] == $_POST['level_1'] ||
    $_POST['level_3'] == $_POST['level_2'] ||  /* Sorry */
    $_POST['level_3'] == $_POST['level_4'] ||  /* Say "no" to same levels! */
    $_POST['level_3'] == $_POST['level_5'] || 
    $_POST['level_4'] == $_POST['level_1'] ||
    $_POST['level_4'] == $_POST['level_2'] ||
    $_POST['level_4'] == $_POST['level_3'] ||
    $_POST['level_4'] == $_POST['level_5'] ||
    $_POST['level_5'] == $_POST['level_1'] ||
    $_POST['level_5'] == $_POST['level_2'] ||
    $_POST['level_5'] == $_POST['level_3'] ||
	$_POST['level_5'] == $_POST['level_4']) {
		$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("sameLevels").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
    </form>
</div>');
		die();
	}
	if($_POST['level_1'] == "l1" OR $_POST['level_2'] == "l2" OR $_POST['level_3'] == "l3" OR $_POST['level_4'] == "l4" OR $_POST['level_5'] == "l5") { // bruh
	$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("chooseLevels").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>');
		die();
	}
	$levels = $_POST['level_1'] . ',' . $_POST['level_2'] . ',' . $_POST['level_3']. ',' . $_POST['level_4']. ',' . $_POST['level_5'];
	$query = $db->prepare("INSERT INTO gauntlets (level1, level2, level3, level4, level5) VALUES (:l1, :l2, :l3, :l4, :l5)");
	$query->execute([':l1' => $_POST["level_1"], ':l2' => $_POST["level_2"], ':l3' => $_POST["level_3"], ':l4' => $_POST["level_4"], ':l5' => $_POST["level_5"]]);
	$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account) VALUES ('18',:value,:timestamp,:account)");
	$query->execute([':value' => $levels, ':timestamp' => time(), ':account' => $accountID]);
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("gauntletCreateTitle").'</h1>
    <form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("gauntletCreateSuccess").'</p>
	    <button type="submit" class="btn-primary">'.$dl->getLocalizedString("gauntletCreateOneMore").'</button>
    </form>
</div>');
} else {
	$options = '';
	foreach ($result as $i => $row) {
		if ($row['starStars'] != 0) {
			$options .= '<option value="'. $row['levelID'] .'">'. $row['levelName'] .'</option>';
		}
	}
	$dl->printSong('<div class="form">
    <h1>' . $dl->getLocalizedString("gauntletCreateTitle") . '</h1>
    <form class="form__inner form__create" method="post" action="">
    <p>' . $dl->getLocalizedString("gauntletCreateDesc") . '</p>
    <div id="selecthihi">
    <select name="level_1">
	<option value="l1">'.$dl->getLocalizedString("level1").'</option>
        ' . $options . '
    </select>
    <select name="level_2">
	<option value="l2">'.$dl->getLocalizedString("level2").'</option>
        ' . $options . '
    </select>
	</div>
	<div id="selecthihi">
    <select name="level_3">
	<option value="l3">'.$dl->getLocalizedString("level3").'</option>
        ' . $options . '
    </select>
	</div>
	<div id="selecthihi">
	<select name="level_4">
	<option value="l4">'.$dl->getLocalizedString("level4").'</option>
        ' . $options . '
    </select>
    <select name="level_5">
	<option value="l5">'.$dl->getLocalizedString("level5").'</option>
        ' . $options . '
    </select>
    </div>
	<div class="checkbox"><input class="checkbox" type="checkbox" name="checkbox_data" required>'.$dl->getLocalizedString("checkbox").'</div>
        <button type="submit" class="btn-primary">' . $dl->getLocalizedString("gauntletCreate") . '</button>
    </form>
    </div>
    <script>
        document.addEventListener("submit", ()		=> {
    let selectData = [];
    let checkboxData;
    document.querySelectorAll("select > option").forEach(el => {
        selectData.push(el.value);
    });
    checkboxData = document.querySelector("input[type=checkbox]").value;
    var formData = new FormData();
    formData.append("select_data", selectData);
    formData.append("checkbox_data", checkboxData);
    var request = new XMLHttpRequest();
    request.open("POST", "/");
    request.send(formData);
});
    </script>');
}
} else
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("noPermission").'</p>
	        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("Kish!").'</button>
    </form>
</div>');
?>