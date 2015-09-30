<?php
include "../connection.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$saveData = htmlspecialchars($_POST["saveData"],ENT_QUOTES);
//registering
$query = $db->prepare("UPDATE `accounts` SET `saveData` = '".$saveData."' WHERE userName = '".$userName."' AND password = '".$password."'");

$query->execute();
$result = $query->fetchAll();
$account = $result[0];
echo "1";
?>