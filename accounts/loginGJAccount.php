<?php
include "../connection.php";
require "../incl/generatePass.php";
require_once "../incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$userName = $ep->remove($_POST["userName"]);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
//registering
$query = "select * from accounts where userName = :userName";
$query = $db->prepare($query);
$query->execute([':userName' => $userName]);
$result = $query->fetchAll();
$account = $result[0];
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
//userID
$id = $account["accountID"];
$query2 = $db->prepare("SELECT * FROM users WHERE extID = :id");

$query2->execute([':id' => $id]);
$result = $query2->fetchAll();
if ($query2->rowCount() > 0) {
$select = $result[0];
$userID = $select[1];
} else {
$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName)
VALUES (1, :id, :userName)");

$query->execute([':id' => $id, ':userName' => $userName]);
$userID = $db->lastInsertId();
}
if($account["isAdmin"]==1){
$query4 = $db->prepare("select * from modips where accountID = :id");
$query4->execute([':id' => $id]);
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
if ($query4->rowCount() > 0) {
$query6 = $db->prepare("UPDATE modips SET IP=:hostname WHERE accountID=:id");
$query6->execute([':hostname' => $ip, ':id' => $id]);
}else{
$query6 = $db->prepare("INSERT INTO modips (IP, accountID, isMod) VALUES (:hostname,:id,'1')");
$query6->execute([':hostname' => $ip, ':id' => $id]);
}
}
//result
echo $id.",".$userID;
}else{
	echo -1;
}
?>