<?php
session_start();
include "../../incl/lib/connection.php";
include_once "../../config/security.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
include_once "../../incl/lib/defuse-crypto.phar";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
use Defuse\Crypto\KeyProtectedByPassword;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
$ep = new exploitPatch();
error_reporting(E_ERROR | E_PARSE);
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_POST["oldnickname"] != "" AND $_POST["newnickname"] != "" AND $_POST["password"] != "") {
	$userName = $gs->getAccountName($_SESSION["accountID"]);
	$accID = $_SESSION["accountID"];
	$oldnick = $_POST["oldnickname"];
	$newnick = $_POST["newnickname"];
	if($oldnick != $userName){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("wrongNick").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>');
		die();
	} elseif($userName == $newnick OR $oldnick == $newnick){
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("sameNick").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>');
		die();
	}
	$pass = $_POST["password"];
	$pass = GeneratePass::isValidUsrname($userName, $pass);
	$salt = "";
if ($pass == 1) {
	$query = $db->prepare("UPDATE accounts SET userName=:userName, salt=:salt WHERE accountID=:accountid");	
	$query->execute([':userName' => $newnick, ':salt' => $salt, ':accountid' => $accID]);
	$query = $db->prepare("UPDATE users SET userName=:userName WHERE extID=:accountid");
	$query->execute([':userName' => $newnick,':accountid' => $accID]);
	$_SESSION["accountID"] = 0;
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changeNickTitle").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("changedNick").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
		</div>');
} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("wrongPass").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
		</div>');
} 

} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("changeNickTitle").'</h1>
		<form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("changeNickDesc").'</p>
        <div class="field"><input type="text" name="oldnickname" placeholder="'.$dl->getLocalizedString("oldNick").'"></div>
        <div class="field"><input type="text" name="newnickname" placeholder="'.$dl->getLocalizedString("newNick").'"></div>
		<div class="field"><input type="password" name="password" placeholder="'.$dl->getLocalizedString("password").'"></div>
        <button type="submit" class="btn-song">'.$dl->getLocalizedString("changeUsername").'</button>
		</form>
		</div>');
}} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="../dashboard/login/login.php">
		<p>'.$dl->getLocalizedString("noLogin?").'</p>
	    <button type="submit" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
		</form>
		</div>');
}
?>