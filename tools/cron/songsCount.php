<?php
chdir(dirname(__FILE__));
set_time_limit(0);
$frndlog = "";
include "../../incl/lib/connection.php";
$query = $db->prepare("SELECT ID FROM songs");
$query->execute();
$result = $query->fetchAll();
//var_dump($result);
//getting accounts
foreach($result as &$songData){
	//var_dump($songData);
	//getting friends count
	$song = $songData["ID"];
	$query2 = $db->prepare("SELECT count(*) FROM levels WHERE songID = :song");
	$query2->execute([':song' => $song]);
	$count = $query2->fetchColumn();
	$frndlog .= $song . " - " . $count . "\r\n";
	//inserting friends count value
	if($count != 0){
		echo htmlspecialchars($song,ENT_QUOTES) . " now has $count levels... <br>";
		$query4 = $db->prepare("UPDATE songs SET levelsCount=:count WHERE ID=:songID");
		$query4->execute([':count' => $count, ':songID' => $song]);
	}
}
file_put_contents("../logs/snglog.txt",$frndlog);
echo "<hr>";
?>
