<?php
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
include "../config/rateLimits.php";
$ep = new exploitPatch();
if($_POST["userName"] != ""){
	if ($accountsMade != 0) { //AntiBotting
		$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 17 AND value = 'Account Registeration' AND timestamp > :timestamp");
		$query->execute([':timestamp' => time() - $accountsDuration]);
		if ($query->fetchColumn() >= $accountsMade) {
			$query = $db->prepare("SELECT count(*) FROM actions WHERE type = 17 AND value = 'Registeration Disabled' AND timestamp > :timestamp");
			$query->execute([':timestamp' => time() - $disableAccountRegisterationTime]);
			if ($query->fetchColumn() == 0) {
				$query = $db->prepare("INSERT INTO actions (type, value, timestamp) VALUES (17, 'Registeration Disabled', :timestamp)");
				$query->execute([':timestamp' => time()]);
			}
			exit("-1");
		} 
	}
	//here im getting all the data
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$email = $ep->remove($_POST["email"]);
	$secret = "";
	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	if ($regusrs > 0) {
		echo "-2";
	}else{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey)
		VALUES (:userName, :password, :email, :secret, '', :time, '')");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time()]);
		$query = $db->prepare("INSERT INTO actions (type, value, timestamp) VALUES (17, 'Account Registeration', :timestamp)");
		$query->execute([':timestamp' => time()]);
		echo "1";
	}
}
?>