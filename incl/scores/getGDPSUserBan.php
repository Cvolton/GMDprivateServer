<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
//here im getting all the data
if(!isset($_POST["userID"])){
	exit("-2");
}
$userID = $_POST["userID"];
$query = $db->prepare("SELECT isBanned FROM users WHERE userID=:userID LIMIT 1"); //getting differences
$query->execute([':userID' => $userID]);
$old = $query->fetch();
echo $userID;
?>