<?php
include "../connection.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$secret = "";
//registering

$query = $db->prepare("select * from accounts where userName = '".$userName."' AND password = '".$password."'");

$query->execute();
$result = $query->fetchAll();
$account = $result[0];
//userID
$id = $account["accountID"];
$query2 = $db->prepare("SELECT * FROM users WHERE extID = '".$id."'");

$query2->execute();
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$select = $result[0];
$userID = $select[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID)
VALUES ('$register','$id')");

$query->execute();
$userID = $db->lastInsertId();
}
//result
echo $id.",".$userID;
?>