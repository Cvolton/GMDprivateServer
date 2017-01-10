<?php
error_reporting(0);
include "../connection.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$secret = "";
//registering
$query = $db->prepare("select * from accounts where userName = :userName AND password = :password");
$query->execute([':userName' => $userName, ':password' => $password]);
$result = $query->fetchAll();
$account = $result[0];
//var_dump($account);
echo base64_decode($account["saveData"]);
?>