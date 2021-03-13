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
include "../../incl/lib/connection.php";
echo "Calculating the amount of friends everyone has";
$query = $db->prepare("UPDATE accounts
	LEFT JOIN
	(
	    SELECT a.person, (IFNULL(a.friends, 0) + IFNULL(b.friends, 0)) AS friends FROM (
	        SELECT count(*) as friends, person1 AS person FROM friendships GROUP BY(person1) 
	    ) AS a
	    JOIN
	    (
	        SELECT count(*) as friends, person2 AS person FROM friendships GROUP BY(person2) 
	    ) AS b ON a.person = b.person
	) calculated
	ON accounts.accountID = calculated.person
	SET accounts.friendsCount = IFNULL(calculated.friends, 0)");
$query->execute();
echo "<hr>";
?>
