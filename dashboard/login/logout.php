<?php
session_start();
$_SESSION["accountID"] = 0;
setcookie('auth', 'no', 2147483647, '/');
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
if(isset($_SERVER["HTTP_REFERER"])){
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}
header('Location: ../');
?>