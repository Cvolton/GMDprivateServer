<?php
include "../config/security.php";
include "../config/mail.php";
include "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
$gs = new mainLib();
require_once "../incl/lib/exploitPatch.php";

if(!isset($preactivateAccounts)){
	$preactivateAccounts = true;
}

if($_POST["userName"] != ""){
    $check = $db->prepare("SELECT registerDate FROM accounts ORDER BY registerDate DESC");
    $check->execute();
    $check = $check->fetch();
    if($check["registerDate"] > time() - 5) {
      $proverka = $db->prepare("SELECT count(*) FROM actions WHERE type = '99' AND value = :value AND timestamp > :time");
      $proverka->execute([':value' => $gs->getIP(), ':time' => time() - 15]);
      $proverka = $proverka->fetch();
      if($proverka > 10) {
		$ban = $db->prepare("INSERT INTO bannedips (IP) VALUES (:ip)");
        $ban->execute([':ip' => $gs->getIP()]);
        die('-1');
      }
	  $action = $db->prepare("INSERT INTO actions (type, value, timestamp) VALUES ('99', :value, :time)");
      $action->execute([':value' => $gs->getIP(), ':time' => time()]);
      die('-1');
    }
	//here im getting all the data
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
    if($password == "GDPSMOMENTSPAMMER") die(1);
	$email = ExploitPatch::remove($_POST["email"]);
	$secret = "";
	//checking if username is within the GD length limit
	if(strlen($userName) > 20)
		exit("-4");
	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	if ($regusrs > 0) {
		echo "-2";
	}else{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, registerDate, isActive)
		VALUES (:userName, :password, :email, :time, :isActive)");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':time' => time(), ':isActive' => $preactivateAccounts ? 1 : 0]);
		echo "1";
      	if($mailEnabled) $gs->mail($email, $userName);
	}
}
?>