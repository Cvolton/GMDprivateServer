<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

if(!isset($_POST['levelID']))
	exit(-1);

$itemID = ExploitPatch::remove($_POST['levelID']);
$ip = $gs->getIP();

$query = $db->prepare("SELECT count(*) FROM actions_likes WHERE itemID=:itemID AND type=:type AND ip=INET6_ATON(:ip)");
$query->execute([':type' => 1, ':itemID' => $itemID, ':ip' => $ip]);
if($query->fetchColumn() > 2)
	exit("-1");

$query = $db->prepare("INSERT INTO actions_likes (itemID, type, isLike, ip) VALUES 
											(:itemID, 1, 1, INET6_ATON(:ip))");
$query->execute([':itemID' => $itemID, ':ip' => $ip]);

$query=$db->prepare("SELECT likes FROM levels WHERE levelID = :itemID LIMIT 1");
$query->execute([':itemID' => $itemID]);
$likes = $query->fetchColumn();

$query=$db->prepare("UPDATE $table SET likes = likes + 1 WHERE $column = :itemID");
$query->execute([':itemID' => $itemID]);
echo "1";
?>
