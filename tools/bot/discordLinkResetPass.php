<?php
include "../../config/discord.php";
require "../../incl/lib/mainLib.php";
require "../../incl/lib/generatePass.php";
$gs = new mainLib();
if(!$discordEnabled){
	exit("Discord integration is disabled.");
}
if($_GET["secret"] != $secret){
	exit("-1");
}
$discordID = $_GET["discordID"];
include "../../incl/lib/connection.php";
$newpass = $gs->randomString();
$passhash = password_hash($newpass, PASSWORD_DEFAULT);
$query = $db->prepare("UPDATE accounts SET password=:password, gjp2=:gjp2 WHERE discordID=:discordID");	
$query->execute([':password' => $passhash, ':discordID' => $discordID, ':gjp2' => GeneratePass::GJP2hash($newpass)]);
$gs->sendDiscordPM($discordID, "Password changed to $newpass\r\nFor your security we advise you to go change your password to http://pi.michaelbrabec.cz:9010/a/tools/account/changePassword.php");
echo "Please check your DMs";
?>