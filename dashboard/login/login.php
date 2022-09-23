<?php
session_start();
include "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
	$dl->printLoginBox("<p>You are already logged in. <a href='..'>Click here to continue</a></p>");
	exit();
}
if(isset($_POST["userName"]) AND isset($_POST["password"])){
	$userName = $_POST["userName"];
	$password = $_POST["password"];
	$valid = GeneratePass::isValidUsrname($userName, $password);
	if($valid != 1){
		$dl->printLoginBoxInvalid();
		exit();
	}
	$accountID = $gs->getAccountIDFromName($userName);
	if($accountID == 0){
		$dl->printLoginBoxError("Invalid accountID");
		exit();
	}
	$_SESSION["accountID"] = $accountID;
	if(isset($_POST["ref"])){
		header('Location: ' . $_POST["ref"]);
	}elseif(isset($_SERVER["HTTP_REFERER"])){
		header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
	$dl->printLoginBox("<p>You are now logged in. <a href='..'>Please click here to continue.</a></p>");
}else{
	$loginbox = '<form action="" method="post">
							<div class="form-group">
								<label for="usernameField">Username</label>
								<input type="text" class="form-control" id="usernameField" name="userName" placeholder="Enter username">
							</div>
							<div class="form-group">
								<label for="passwordField">Password</label>
								<input type="password" class="form-control" id="passwordField" name="password" placeholder="Password">
							</div>';
	if(isset($_SERVER["HTTP_REFERER"])){
		$loginbox .= '<input type="hidden" name="ref" value="'.$_SERVER["HTTP_REFERER"].'">';
	}
	$loginbox .= '<button type="submit" class="btn btn-primary">Log In</button>
						</form>';
	$dl->printLoginBox($loginbox);
}
?>
