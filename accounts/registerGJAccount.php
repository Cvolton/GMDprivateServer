<?php
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
if($_POST["userName"] != ""){
	//here im getting all the data
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$email = $ep->remove($_POST["email"]);
	$secret = "";
	//checking if name is taken
	$query2 = $db->prepare("SELECT * FROM accounts WHERE userName=:userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->rowCount();
	if ($regusrs > 0) {
		echo "-2";
	}else{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate)
		VALUES (:userName, :password, :email, :secret, '', :time)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time()]);
		echo "1";
	}
}
?>