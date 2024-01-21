<?php
include "../config/security.php";
include "../config/mail.php";
include "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
$gs = new mainLib();
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/generatePass.php";
if(!isset($preactivateAccounts)) $preactivateAccounts = true;
if($_POST["userName"] != "") {
	$userName = ExploitPatch::charclean($_POST["userName"]);
	$password = $_POST["password"];
    $email = ExploitPatch::rucharclean($_POST["email"]);
	if(strlen($userName) > 20) exit("-4");
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	if($regusrs > 0) {
		echo "-2";
	} else {
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive)
		VALUES (:userName, :password, :email, :time, :isActive)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0]);
		GeneratePass::assignGJP2($db->lastInsertId(), $password);
		echo "1";
      	if($mailEnabled) $gs->mail($email, $userName);
	}
}
?>