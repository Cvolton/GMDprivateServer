<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
$GJPCheck = new GJPCheck();
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
$ep = new exploitPatch();
//here im getting all the data
$levelDesc = $ep->remove($_POST["levelDesc"]);
$levelID = $ep->remove($_POST["levelID"]);
if (isset($_POST['udid']) && !empty($_POST['udid'])) {
	$id = $ep->remove($_POST["udid"]);
	if (is_numeric($id)) {
		exit("-1");
	}
} else {
	$id = $ep->remove($_POST["accountID"]);
	$gjp = $ep->remove($_POST["gjp"]);
	$gjpresult = $GJPCheck->check($gjp, $id);
	if ($gjpresult != 1) {
		exit("-1");
	}
}
$levelDesc = str_replace('-', '+', $levelDesc);
$levelDesc = str_replace('_', '/', $levelDesc);
$rawDesc = base64_decode($levelDesc);
if (strpos($rawDesc, '<c') !== false) {
	$tags = substr_count($rawDesc, '<c');
	if ($tags > substr_count($rawDesc, '</c>')) {
		$tags = $tags - substr_count($rawDesc, '</c>');
		for ($i = 0; $i < $tags; $i++) {
			$rawDesc .= '</c>';
		}
		$levelDesc = str_replace('+', '-', base64_encode($rawDesc));
		$levelDesc = str_replace('/', '_', $levelDesc);
	}
}
$query = $db->prepare("UPDATE levels SET levelDesc=:levelDesc WHERE levelID=:levelID AND extID=:extID");
$query->execute([':levelID' => $levelID, ':extID' => $id, ':levelDesc' => $levelDesc]);
echo 1;
