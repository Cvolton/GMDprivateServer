<?php
include "../connection.php";
if($_POST["userName"] != ""){
//here im getting all the data
$userName = explode("(", explode(";", htmlspecialchars($_POST["userName"],ENT_QUOTES))[0])[0];
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$email = explode("(", explode(";", htmlspecialchars($_POST["email"],ENT_QUOTES))[0])[0];
$secret = "";
//checking if name is taken
$query2 = $db->prepare("SELECT * FROM accounts WHERE userName='$userName'");

$query2->execute();
$regusrs = $query2->rowCount();
if ($regusrs > 0) {
echo "-1";
}else{
//registering
$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret)
VALUES ('$userName', '$password', '$email', '$secret')");

$query->execute();
echo "1";
}
}
?>