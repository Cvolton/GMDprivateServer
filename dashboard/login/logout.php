<?php
session_start();
$_SESSION["accountID"] = 0;
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
if(isset($_SERVER["HTTP_REFERER"])){
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}
$dl->printLoginBox("<p>You are now logged out. <a href='..'>Click here to continue</a></p>");
?>