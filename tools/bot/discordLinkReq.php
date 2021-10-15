<?php
//error_reporting(0);
include "../../config/discord.php";
include "../../incl/lib/connection.php";
require "../../incl/lib/XORCipher.php";
$xc = new XORCipher();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
if(!$discordEnabled){
	exit("Discord integration is disabled.");
}
if($_GET["secret"] != $secret){
	exit("-1");
}
$discordID = $_GET["discordID"];
$account = $_GET["account"];
$query = $db->prepare("SELECT discordLinkReq FROM accounts WHERE userName = :account");
$query->execute([':account' => $account]);
$discordLinkReq = $query->fetchColumn();
if($discordLinkReq != 0){
	exit("This user has an ongoing link request already");
}
$query = $db->prepare("SELECT count(*) FROM accounts WHERE discordID = :discordID OR discordLinkReq = :discordID");
$query->execute([':discordID' => $discordID]);
if($query->fetchColumn() != 0){
	exit("You're linked or have sent a link request to a different account already");
}
$query = $db->prepare("UPDATE accounts SET discordLinkReq = :discordID WHERE userName = :account");
$query->execute([':account' => $account, ':discordID' => $discordID]);
if($query->rowCount() == 0){
	exit("This account doesn't exist.");
}
//in-game message
$accinfo = $gs->getDiscordAcc($discordID);
//sending the msg
$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :account");
$query->execute([':account' => $account]);
$accountID = $query->fetchColumn();
$message = $xc->cipher("The Discord account '$accinfo' has attempted to link to this GDPS account. If that was you, please comment '!discord accept' on your profile. If it wasn't you, please comment '!discord deny'. If you ever wish to unlink, please comment '!discord unlink' on your profile.", 14251);
$message = base64_encode($message);
$query = $db->prepare("INSERT INTO messages (subject, body, accID, userID, userName, toAccountID, secret, timestamp)
VALUES ('TmV3IEFjY291bnQgTGluayBSZXF1ZXN0', :body, 263, 388, 'GDPS Bot', :toAccountID, 'Automatic Message', :uploadDate)");
$query->execute([':body' => $message, ':toAccountID' => $accountID, ':uploadDate' => time()]);
echo "Link request has been succesfully sent, please check your in-game messages";
?>