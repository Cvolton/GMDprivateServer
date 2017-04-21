<?php
chdir(dirname(__FILE__));
if(file_exists("../logs/fixfrndlog.txt")){
	$cptime = file_get_contents("../logs/fixfrndlog.txt");
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
file_put_contents("../logs/fixfrndlog.txt",time());
set_time_limit(0);
$frndlog = "";
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT accountID, userName FROM accounts");
$query->execute();
$result = $query->fetchAll();
//getting accounts
foreach($result as $account){
	//getting friends count
	$me = $account["accountID"];
	$query2 = $db->prepare("SELECT count(*) FROM friendships WHERE person1 = :me OR person2 = :me");
	$query2->execute([':me' => $me]);
	$friendscount = $query2->fetchColumn();
	$frndlog .= $account["userName"] . " - " . $friendscount . "\r\n";
	//inserting friends count value
	if($friendscount != 0){
		echo htmlspecialchars($account["userName"],ENT_QUOTES) . " now has $friendscount friends... <br>";
		ob_flush();
		flush();
		$query4 = $db->prepare("UPDATE accounts SET friendsCount=:friendscount WHERE accountID=:me");
		$query4->execute([':friendscount' => $friendscount, ':me' => $me]);
	}
}
file_put_contents("../logs/frndlog.txt",$frndlog);
echo "<hr>";
?>
