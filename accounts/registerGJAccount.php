<?php

chdir(dirname(__FILE__));
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$ip = $_SERVER['REMOTE_ADDR'];
if($_POST["userName"] != ""){
	//here im getting all the data
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$email = $ep->remove($_POST["email"]);
	$secret = "";
	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	//rate limiting
	$query3 = $db->prepare("SELECT count(*) FROM accounts WHERE registerDate > :time AND ip = :ip");
	$query3->execute([':time' => time() - 300 /*5 minutes*/, ':ip' => $ip]);
	$ratelimit1 = $query3->fetchColumn();
	
	if ($ratelimit1 > 0)
	{
		echo "-13";
	}
	else if ($regusrs > 0)
	{
		echo "-2";
	}
	else
	{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey, ip)
		VALUES (:userName, :password, :email, :secret, '', :time, '', :ip)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time(), ':ip' => $ip]);
		echo "1";
	}
}
?>