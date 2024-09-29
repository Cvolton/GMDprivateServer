<?php
session_start();
error_reporting(E_ALL);
require '../incl/dashboardLib.php';
require '../'.$dbPath.'incl/lib/connection.php';
require '../'.$dbPath.'incl/lib/exploitPatch.php';
require '../'.$dbPath.'incl/lib/mainLib.php';
$id = ExploitPatch::number($_GET["id"]);
$gs = new mainLib();
if(!empty($id)) {
	if(!empty($_GET["name"]) AND !empty($_GET["levels"]) AND !empty($_GET["color"]) AND !empty($_GET["stars"]) AND !empty($_GET["coins"]) AND $gs->checkPermission($_SESSION["accountID"], 'dashboardLevelPackCreate')) {
		switch(ExploitPatch::number($_GET["stars"])) {
			case 1:
				$diff = 0;
				break;
			case 2:
				$diff = 1;
				break;
			case 3:
				$diff = 2;
				break;
			case 4:
			case 5:
				$diff = 3;
				break;
			case 6:
			case 7:
				$diff = 4;
				break;
			case 8:
			case 9:
				$diff = 5;
				break;
			case 10:
				$diff = 6;
				break;
		}
		$levels = explode(',', ExploitPatch::remove($_GET["levels"]));
		if(!$gs->getLevelName($levels[0]) OR !$gs->getLevelName($levels[1]) OR !$gs->getLevelName($levels[2])) die("-1");
		$color = explode(',', ExploitPatch::remove($_GET["color"]));
		if($color[0] > 255) $color[0] = 255; elseif($color[0] < 0) $color[0] = 0;
		if($color[1] > 255) $color[1] = 255; elseif($color[1] < 0) $color[1] = 0;
		if($color[2] > 255) $color[2] = 255; elseif($color[2] < 0) $color[2] = 0;
		$color = $color[0].','.$color[1].','.$color[2];
		if($_GET["stars"] > 10) $stars = 10; elseif($_GET["stars"] < 1) $stars = 1; else $stars = ExploitPatch::number($_GET["stars"]);
		if($_GET["coins"] > 2) $coins = 2; elseif($_GET["coins"] < 1) $coins = 1; else $coins = ExploitPatch::number($_GET["coins"]);
		$getPack = $db->prepare("SELECT * FROM mappacks WHERE ID = :packID");
		$getPack->execute([':packID' => $id]);
		$getPack = $getPack->fetch();
		$change = $db->prepare("UPDATE mappacks SET name = :n, levels = :l, rgbcolors = :r, stars = :s, coins = :c, difficulty = :d WHERE id = :i");
		$change->execute([':n' => ExploitPatch::remove($_GET["name"]), ':l' => ExploitPatch::remove($_GET["levels"]), ':r' => $color, ':s' => $stars, ':c' => $coins, ':i' => $id, ':d' => $diff]);
		$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3, value4, value7) VALUES ('21',:value,:timestamp,:account,:levels, :stars, :coins, :rgb)");
		$query->execute([':value' => ExploitPatch::remove($_GET["name"]), ':timestamp' => time(), ':account' => $_SESSION["accountID"], ':levels' => ExploitPatch::remove($_GET["levels"]), ':stars' => $stars, ':coins' => $coins, ':rgb' => $color]);
		$gs->sendLogsMapPackChangeWebhook($id, $_SESSION['accountID'], $getPack);
		echo 1;
	} else {
	  $pck = $db->prepare("SELECT * FROM mappacks WHERE ID = :id");
	  $pck->execute([':id' => $id]);
	  $map = $pck->fetch();
	  echo $map["ID"].' | '.$map["name"].' | '.$map["stars"].' | '.$map["coins"].' | '.$map["rgbcolors"].' | '.$map["levels"];
	}
}
?>