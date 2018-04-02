<?php
$date = date("d-m");
if($date == "01-04"){
	exit();
}
chdir(dirname(__FILE__));
echo "Please wait...<br>";
ob_flush();
flush();
if(file_exists("../logs/fixnameslog.txt")){
	$cptime = file_get_contents("../logs/fixnameslog.txt");
	$newtime = time() - 30;
	if($cptime > $newtime){
		$remaintime = time() - $cptime;
		$remaintime = 30 - $remaintime;
		$remainmins = floor($remaintime / 60);
		$remainsecs = $remainmins * 60;
		$remainsecs = $remaintime - $remainsecs;
		exit("Please wait $remainmins minutes and $remainsecs seconds before running ". basename($_SERVER['SCRIPT_NAME'])." again");
	}
}
file_put_contents("../logs/fixcpslog.txt",time());
set_time_limit(0);
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT userName, accountID FROM accounts");
$query->execute();
$result = $query->fetchAll();
//getting users
foreach($result as $account){
	$accountID = $account["accountID"];
	$userName = $account["userName"];
	$query4 = $db->prepare("UPDATE users SET userName = :userName WHERE extID = :accountID");
	$query4->execute([':userName' => $userName, ':accountID' => $accountID]);
	echo htmlspecialchars($accountID, ENT_QUOTES) . " - " . htmlspecialchars($userName, ENT_QUOTES) . "<br>";
	ob_flush();
	flush();
}
echo "Done<hr>";
?>
