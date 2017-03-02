<?php
include "../connection.php";
require "../incl/generatePass.php";
require_once "../incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$userName = $ep->remove($_POST["userName"]);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$saveData = base64_encode($ep->remove($_POST["saveData"]));
$generatePass = new generatePass();
$pass = $generatePass->isValidUsrname($userName, $password);
if ($pass == 1) {
$query = $db->prepare("UPDATE `accounts` SET `saveData` = :saveData WHERE userName = :userName");

$query->execute([':saveData' => $saveData, ':userName' => $userName]);
echo "1";
}
else{echo -1;}
?>