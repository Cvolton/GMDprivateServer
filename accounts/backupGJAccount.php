<?php
include "../connection.php";
//here im getting all the data
$userName = $_POST["userName"];
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$saveData = $_POST["saveData"];
//registering
$query = $db->prepare("UPDATE `accounts` SET `saveData` = '".$saveData."' WHERE userName = '".$userName."' AND password = '".$password."'");

$query->execute();
$result = $query->fetchAll();
$account = $result[0];
echo "1";
?>