<?php
chdir(dirname(__FILE__));
require_once "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
require_once "../../config/misc.php";

$gs = new mainLib();

$songIDs = ExploitPatch::remove($_POST["songIDs"] ?? "");
$sfxIDs = ExploitPatch::remove($_POST["sfxIDs"] ?? "");

$songIDs = array_values(array_filter(array_map("intval", explode(",", $songIDs)))) ?: [0];
$sfxIDs = array_values(array_filter(array_map("intval", explode(",", $sfxIDs)))) ?: [0];

if (count($songIDs) > 101 || count($sfxIDs) > 1001) exit("-1"); // robtop

echo $gs->getTotalAudioFilesize($songIDs, $sfxIDs) . ":" . $maxAudioFilesize * 1_048_576;
?>