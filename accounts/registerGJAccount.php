<?php
require "../config/security.php";
require "../config/mail.php";
require "../incl/lib/connection.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/generatePass.php";
require_once "../incl/lib/automod.php";
if(Automod::isAccountsDisabled(0)) exit('-1');
if(!isset($preactivateAccounts)) $preactivateAccounts = true;
if(!isset($filterUsernames)) global $filterUsernames;
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["email"])) {
	$userName = str_replace(' ', '', ExploitPatch::charclean($_POST["userName"]));
	$password = $_POST["password"];
    $email = ExploitPatch::rucharclean($_POST["email"]);
	if($filterUsernames >= 1) {
		$bannedUsernamesList = array_map('strtolower', $bannedUsernames);
		switch($filterUsernames) {
			case 1:
				if(in_array(strtolower($userName), $bannedUsernamesList)) exit("-4");
				break;
			case 2:
				foreach($bannedUsernamesList as $bannedUsername) {
					if(!empty($bannedUsername) && mb_strpos(strtolower($userName), $bannedUsername) !== false) exit("-4");
				}
		}
	}
	if(strlen($userName) > 20) exit("-4");
	if(strlen($userName) < 3) exit("-9");
	if(strlen($password) < 6) exit("-8");
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) exit("-6");
	if($mailEnabled) {
		$checkMail = $db->prepare("SELECT count(*) FROM accounts WHERE email LIKE :mail");
		$checkMail->execute([':mail' => $email]);
		$checkMail = $checkMail->fetchColumn();
		if($checkMail > 0) exit("-3");
	}
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	if($regusrs > 0) {
		echo "-2";
	} else {
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$gjp2 = GeneratePass::GJP2hash($password);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive, gjp2)
		VALUES (:userName, :password, :email, :time, :isActive, :gjp)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0, ':gjp' => $gjp2]);
		$accountID = $db->lastInsertId();
		echo "1";
		$gs->logAction($accountID, 1, $userName, $email, $gs->getUserID($accountID, $userName));
		$gs->sendLogsRegisterWebhook($accountID);
      	if($mailEnabled) $gs->mail($email, $userName);
	}
} else echo "-1";
?>
