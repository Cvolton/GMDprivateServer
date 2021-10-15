<?php
//error_reporting(0);
include_once "../../incl/lib/connection.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
$str = ExploitPatch::remove($_POST["str"]);
$difficulty = "";
$original = "";
//getting level data
echo "***SHOWING RESULT FOR $str***\r\n";
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :str OR userID = :str");
$query->execute([':str' => $str]);
//checking if exists
if($query->rowCount() == 0){
	exit("The user you are searching for doesn't exist");
}
$accountID = $query->fetchColumn();
$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID");
$query->execute([':extID' => $accountID]);
$userID = $query->fetchColumn();
$query = $db->prepare("SELECT levelName,levelID FROM levels WHERE userID = :userID"); //getting level info
$query->execute([':userID' => $userID]);
//checking if exists
if($query->rowCount() == 0){  
	exit("This user doesn't have any levels.");
}
echo "```";
$levels = $query->fetchAll();
echo str_pad("Level ID", 16, " ", STR_PAD_LEFT) . " | Level Name\r\n--------------------------------------\r\n";
foreach($levels as $level){
	$levelID = str_pad($level["levelID"], 16, " ", STR_PAD_LEFT);
	$levelName = $level["levelName"];
	echo "$levelID | $levelName\r\n";
}
echo "```";
?>
