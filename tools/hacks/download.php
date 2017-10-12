<?php
include "../../incl/lib/connection.php";

if (empty($_GET["id"])) {
	exit('Missing GET Parameter: "id"');
}

$query = $db->prepare("SELECT downloadLink FROM hackList WHERE hackID = :id");
$query->execute([':id' => $_GET["id"]]);

if ($query->rowCount() > 0) {
	$result = $query->fetch();
	
	$ip = $_SERVER['REMOTE_ADDR']; //has already downloaded?
	$queryChk = $db->prepare("SELECT * FROM hackDownloads WHERE ip = :IP AND hackID = :id");
	$queryChk->execute([':IP' => $ip, ':id' => $_GET["id"]]);
	
	if ($queryChk->rowCount() == 0) {
		$queryInc = $db->prepare("UPDATE hackList SET downloadCount = downloadCount + 1 WHERE hackID = :id");
		$queryInc->execute([':id' => $_GET["id"]]);
	}
	
	$queryRec = $db->prepare("INSERT INTO  hackDownloads (hackID, ip) VALUES (:id, :IP)");
	$queryRec->execute([':id' => $_GET["id"], ':IP' => $ip]);
	
	header('Location: '.$result["downloadLink"]);
} else {
	exit("Invalid ID");
}
?>