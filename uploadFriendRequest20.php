<?php
//error_reporting(0);
include "connection.php";
//here im getting all the data
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
$toAccountID = htmlspecialchars($_POST["toAccountID"],ENT_QUOTES);
$comment = htmlspecialchars($_POST["comment"],ENT_QUOTES);
$uploadDate = date();
//INSERT GJP CHECK HERE
$query = $db->prepare("INSERT INTO friendreqs (accountID, toAccountID, comment, uploadDate)
VALUES ('$accountID', '$toAccountID', '$comment', '$uploadDate')");
$query->execute();
echo 1;
?>