<?php
session_start();
$_SESSION["accountID"] = 0;
setcookie('auth', 'no', 2147483647, '/');
if(!empty($_SERVER["HTTP_REFERER"])) header('Location: '.$_SERVER["HTTP_REFERER"]);
else header('Location: ../');
?>