<?php
include "../../config/discord.php";
include "../../incl/lib/connection.php";
if(!$discordEnabled){
	exit("Discord integration is disabled.");
}
if($_GET["secret"] != $secret){
	exit("-1");
}
$discordID = htmlspecialchars($_GET["discordID"], ENT_QUOTES, 'UTF-8');
$roles = htmlspecialchars($_GET["roles"], ENT_QUOTES, 'UTF-8');
$rolesarray = explode(",", $roles);
$query = $db->prepare("SELECT accountID FROM accounts WHERE discordID = :discordID");
$query->execute([':discordID' => $discordID]);
if($query->rowCount() == 0){
	exit("Your Discord account isn't linked to a GDPS account <@$discordID>");
}
$accountID = $query->fetchColumn();
$query = $db->prepare("DELETE FROM roleassign WHERE accountID = :accountID");
$query->execute([':accountID' => $accountID]);
foreach($rolesarray as &$role){
	$query = $db->prepare("INSERT INTO roleassign (roleID, accountID) VALUES (:roleID, :accountID)");	
	$query->execute([':roleID' => $role, ':accountID' => $accountID]);
}
echo "Roles transferred! <@$discordID>";
?>