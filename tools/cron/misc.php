<?php
ob_flush();
flush();

if(file_exists("../logs/misc.txt")) {
	$cptime = file_get_contents("../logs/misc.txt");
	$newtime = time() - 30;
	if($cptime > $newtime) exit("-1");
}
include "../../incl/lib/connection.php";
include_once "../../incl/lib/mainLib.php";
$gs = new mainLib();

/* Unbanning everyone who has expired ban */

$bans = $db->prepare('UPDATE bans SET isActive = 0 WHERE expires < :time');
$bans->execute([':time' => time()]);

/* Unbanning IPs */

$getIPBans = $db->prepare("SELECT person FROM bans WHERE personType = 2 AND banType = 4 AND isActive = 0");
$getIPBans->execute();
$getIPBans = $getIPBans->fetchAll();
$IPBans = [];
foreach($getIPBans AS &$ban) {
	$IPBans[] = $gs->IPForBan($ban['person'], true);
}
$bannedIPsString = implode("|", $IPBans);
$unbanIPs = $db->prepare('DELETE FROM bannedips WHERE IP REGEXP "'.$bannedIPsString.'"');
$unbanIPs->execute();

file_put_contents("../logs/misc.txt",time());
ob_flush();
flush();
?>