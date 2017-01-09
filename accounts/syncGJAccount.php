<?php
error_reporting(0);
include "../connection.php";
//here im getting all the data
$userName = explode("(", explode(";", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0];
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$secret = "";
//registering
$query = $db->prepare("select * from accounts where userName = '".$userName."' AND password = '".$password."'");
$query->execute();
$result = $query->fetchAll();
$account = $result[0];
//var_dump($account);
echo base64_decode($account["saveData"]);
?>