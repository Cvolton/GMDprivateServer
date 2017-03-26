<?php
error_reporting(0);
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$userName = $ep->remove($_POST["userName"]);
$pass2 = $_POST["password"];
$password = md5($pass2 . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$secret = "";
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
	$query = $db->prepare("select * from accounts where userName = :userName");
	$query->execute([':userName' => $userName]);
	$result = $query->fetchAll();
	$account = $result[0];
	$accountID = $account["accountID"];
	if(!is_numeric($accountID)){
		exit("-1");
	}
	if(!file_exists("../data/accounts/$accountID")){
			$saveData = $account["saveData"];
		if(substr($saveData,0,4) == "SDRz"){
			$saveData = base64_decode($saveData);
		}
	}else{
		$saveData = file_get_contents("../data/accounts/$accountID");
	}
	echo $saveData.";21;30;a;a";
}
else
{echo -1;}
?>