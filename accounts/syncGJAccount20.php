<?php
error_reporting(0);
include "../connection.php";
require "../incl/generatePass.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$secret = "";
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
$query = $db->prepare("select * from accounts where userName = :userName");
$query->execute([':userName' => $userName]);
$result = $query->fetchAll();
$account = $result[0];
//var_dump($account);
echo base64_decode($account["saveData"]).";21;30;a;a";
}
else
{echo -1;}
?>