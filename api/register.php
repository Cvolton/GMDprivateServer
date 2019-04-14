<?php

chdir(dirname(__FILE__));

include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
	if (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 20)
	{
		exit(json_encode(['success' => false, 'error' => 'username length not 3-20']));
	}
	
	if (strlen($_POST['password']) < 6 || strlen($_POST['password']) > 20)
	{
		exit(json_encode(['success' => false, 'error' => 'password length not 6-20']));
	}
	
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		exit(json_encode(['success' => false, 'error' => 'invalid email']));
	}
	
	//here im getting all the data
	$userName = $ep->remove($_POST["username"]);
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
		exit(json_encode(['success' => false, 'error' => 'rate limit reached, try again later']));
	}
	else if ($regusrs > 0)
	{
		exit(json_encode(['success' => false, 'error' => 'username taken']));
	}
	else
	{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey, ip)
		VALUES (:userName, :password, :email, :secret, '', :time, '', :ip)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time(), ':ip' => $ip]);
		
		exit(json_encode(['success' => true, 'message' => 'Successfully registered account']));
	}
}
else
{
	exit(json_encode(['success' => false, 'error' => 'invalid parameters']));
}
?>