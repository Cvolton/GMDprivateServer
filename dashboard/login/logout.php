<?php
session_start();
$_SESSION["accountID"] = 0;
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
if(isset($_SERVER["HTTP_REFERER"])){
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}
header('Location: ../');
?>