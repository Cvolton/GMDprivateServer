<?php
session_start();
include "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
	$dl->printLoginBox('<h3>'.$dl->getLocalizedString("loginAlready").'</h3>
	<form class="form__inner" method="post" action="../dashboard">
	<button type="submit" class="btn-primary" >'.$dl->getLocalizedString("clickHere").'</button>');
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
		$dl->printLoginBoxError($dl->getLocalizedString("invalidid"));
		exit();
	}
	$_SESSION["accountID"] = $accountID;
	if(isset($_POST["ref"])){
		header('Location: ' . $_POST["ref"]);
	}elseif(isset($_SERVER["HTTP_REFERER"])){
		header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
	$dl->printLoginBox("<p>".$dl->getLocalizedString("loginSuccess")." <a href=''>".$dl->getLocalizedString("clickHere")."</a></p>");
}else{
	$loginbox = '<form action="" method="post">
							<div class="form-group">
								<label for="usernameField">Username</label>
								<input type="text" class="form-control login-input" id="usernameField" name="userName" placeholder="'.$dl->getLocalizedString("enterUsername").'">
							</div>
							<div class="form-group">
								<label for="passwordField">Password</label>
								<input type="password" class="form-control" id="passwordField" name="password" placeholder="'.$dl->getLocalizedString("enterPassword").'">
							</div>';
	if(isset($_SERVER["HTTP_REFERER"])){
		$loginbox .= '<input type="hidden" name="ref" value="'.$_SERVER["HTTP_REFERER"].'">';
	}
	$loginbox .= '<button type="submit" class="btn btn-primary">'.$dl->getLocalizedString("login").'</button>
						</form>';
	$dl->printLoginBox($loginbox);
}
?>
