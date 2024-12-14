<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/XORCipher.php";
require_once "../lib/mainLib.php";
require_once "../lib/generateHash.php";
require_once "../lib/exploitPatch.php";
$gs = new mainLib();
$gh = new generateHash();

$extID = $gs->getIDFromPost() ?: 0;
$rewardKey = ExploitPatch::charclean($_POST["rewardKey"]);
$chk = XORCipher::cipher(ExploitPatch::url_base64_decode(substr(ExploitPatch::charclean($_POST["chk"]), 5)), 59182);

$vaultCode = $db->prepare('SELECT * FROM vaultcodes WHERE code = :code');
$vaultCode->execute([':code' => base64_encode($rewardKey)]);
$vaultCode = $vaultCode->fetch();

if(!$vaultCode || $vaultCode['uses'] == 0 || ($vaultCode['duration'] != 0 && $vaultCode['duration'] <= time())) exit('-1');

$check = $db->prepare("SELECT count(*) FROM actions WHERE type = 38 AND value = :vaultCode AND account = :extID");
$check->execute([':vaultCode' => $vaultCode['rewardID'], ':extID' => $extID]);
$check = $check->fetchColumn();
if($check) exit('-1');

if($vaultCode['uses'] > 0) {
	$reduceUses = $db->prepare('UPDATE vaultcodes SET uses = uses - 1 WHERE rewardID = :rewardID');
	$reduceUses->execute([':rewardID' => $vaultCode['rewardID']]);
}

$gs->logAction($extID, 38, $vaultCode['rewardID'], $vaultCode['rewards'], $rewardKey);
$string = ExploitPatch::url_base64_encode(XORCipher::cipher('Sa1nt:'.$chk.':'.$vaultCode['rewardID'].':1:'.$vaultCode['rewards'], 59182));
$hash = $gh->genSolo4($string);
echo 'Sa1nt'.$string.'|'.$hash;
?>