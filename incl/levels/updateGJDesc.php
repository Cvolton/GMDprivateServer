<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
$GJPCheck = new GJPCheck();
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$mainLib = new mainLib();
$levelDesc = ExploitPatch::remove($_POST["levelDesc"]);
$levelID = ExploitPatch::numbercolon($_POST["levelID"]);
if (isset($_POST['udid']) && !empty($_POST['udid'])) {
	$id = ExploitPatch::remove($_POST["udid"]);
	if (is_numeric($id)) {
		exit("-1");
	}
} else {
	$id = GJPCheck::getAccountIDOrDie();
}
$rawDesc = ExploitPatch::url_base64_decode($levelDesc);
if (strpos($rawDesc, '<c') !== false) {
	$tags = substr_count($rawDesc, '<c');
	if ($tags > substr_count($rawDesc, '</c>')) {
		$tags = $tags - substr_count($rawDesc, '</c>');
		for ($i = 0; $i < $tags; $i++) {
			$rawDesc .= '</c>';
		}
		$levelDesc = ExploitPatch::url_base64_encode($rawDesc);
	}
}
$query = $db->prepare("UPDATE levels SET levelDesc=:levelDesc WHERE levelID=:levelID AND extID=:extID");
$query->execute([':levelID' => $levelID, ':extID' => $id, ':levelDesc' => $levelDesc]);
echo 1;
