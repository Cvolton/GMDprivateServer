<?php
include "../connection.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$email = htmlspecialchars($_POST["email"],ENT_QUOTES);
$secret = "";
//registering
$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret)
VALUES ('$userName', '$password', '$email', '$secret')");

$query->execute();
echo "1";
?>