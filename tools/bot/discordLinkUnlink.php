<?php
include "../../config/discord.php";
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
if(!$discordEnabled){
	exit("Discord integration is disabled.");
}
if($_GET["secret"] != $secret){
	exit("-1");
}
$discordID = $_GET["discordID"];
include "../../incl/lib/connection.php";
$message = "You're not linked to an account.";
$query = $db->prepare("UPDATE accounts SET discordID=0 WHERE discordID=:discordID");	
$query->execute([':discordID' => $discordID]);
if($query->rowCount() > 0){
	$message = "Your GDPS account has been unlinked.";
}
$query = $db->prepare("UPDATE accounts SET discordLinkReq=0 WHERE discordLinkReq=:discordID");	
$query->execute([':discordID' => $discordID]);
if($query->rowCount() > 0){
	$message = "Your link request has been cancelled.";
}
echo $message;
?>