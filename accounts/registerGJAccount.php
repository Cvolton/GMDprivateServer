<?php
include "../incl/lib/connection.php";
include "../incl/lib/Mail/SendMail.php";
require_once "../incl/lib/exploitPatch.php";
$sm = new SendMail();
$ep = new exploitPatch();
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
	if ($regusrs > 0) {
		echo "-2";
	}else{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey)
		VALUES (:userName, :password, :email, :secret, '', :time, '')");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time()]);
        $link = "server.geometrydashchinese.com/accounts/active/active.php?ID=".base64_encode($email)."&Key=".$hashpass;
        $Title = "Verify Your Account";//Mail Title
        $content = $link;//Mail Content
        $active = $sm->Send($email, $Title, $content);
      if ($active == "1") {
		echo "1";
      } else {
        echo "-1";
      }
    }
}
?>
