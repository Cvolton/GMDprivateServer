<?php
include '../incl/dashboardLib.php';
include '../'.$dbPath.'incl/lib/connection.php';
include '../'.$dbPath.'incl/lib/mainLib.php';
include '../'.$dbPath.'incl/lib/exploitPatch.php';
$gs = new mainLib();
$demonlist = $db->prepare("SELECT * FROM demonlist ORDER BY pseudoPoints DESC");
$demonlist->execute();
$demonlist = $demonlist->fetchAll();
$x = 1;
foreach($demonlist as &$dl) {
	$author = ["authorID" => $dl["authorID"], "username" => $gs->getAccountName($dl["authorID"])];
	$data[] = ["place" => $x, "name" => $gs->getLevelName($dl["levelID"]), "desc" => ExploitPatch::remove($gs->getDesc($dl["levelID"])), "points" => $dl["giveablePoints"], "youtube" => $dl["youtube"], "id" => $dl["levelID"], "author" => $author];
	$x++;
}
echo json_encode(["gdps" => $gdps, "count" => $x, "demons" => $data]);