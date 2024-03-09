<?php
include "../config/security.php";
include "../config/mail.php";
include "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
$gs = new mainLib();
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/generatePass.php";
if(!isset($preactivateAccounts)) $preactivateAccounts = true;
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["email"])) {
	$userName = ExploitPatch::charclean($_POST["userName"]);
	$password = $_POST["password"];
    $email = ExploitPatch::rucharclean($_POST["email"]);
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
		echo "1";
      	if($mailEnabled) $gs->mail($email, $userName);
	}
} else echo "-1";
?>