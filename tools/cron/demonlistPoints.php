<?php
include '../../incl/lib/connection.php';
$dl = $db->prepare("SELECT accountID, levelID FROM dlsubmits WHERE approve = 1 ORDER BY accountID ASC");
$dl->execute();
$dl = $dl->fetchAll();
$demonlist[] = array();
foreach($dl as &$demon) {
	$dli = $db->prepare("SELECT giveablePoints FROM demonlist WHERE levelID = :lid");
	$dli->execute([':lid' => $demon["levelID"]]);
	$dli = $dli->fetch();
	$acc = $demon["accountID"];
	$demonlist[$acc] = $demonlist[$acc] + $dli["giveablePoints"];
	$dem[] = $acc;
}
$db->query("UPDATE users SET dlPoints = 0 WHERE dlPoints > 0");
foreach($dem as &$ac) {
	$del = $db->prepare("UPDATE users SET dlPoints = :dl WHERE extID = :acc");
	$del->execute(['dl' => $demonlist[$ac], ':acc' => $ac]);
}
?>