<?php
chdir(dirname(__FILE__));
//error_reporting(0);
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$commentstring = "";
$accountid = ExploitPatch::remove($_POST["accountID"]);
$page = ExploitPatch::remove($_POST["page"]);
$commentpage = $page*10;
$userID = $gs->getUserID($accountid);
$query = "SELECT comment, userID, likes, isSpam, commentID, timestamp FROM acccomments WHERE userID = :userID ORDER BY timeStamp DESC LIMIT 10 OFFSET $commentpage";
$query = $db->prepare($query);
$query->execute([':userID' => $userID]);
$result = $query->fetchAll();
if($query->rowCount() == 0){
	exit("#0:0:0");
}
$countquery = $db->prepare("SELECT count(*) FROM acccomments WHERE userID = :userID");
$countquery->execute([':userID' => $userID]);
$commentcount = $countquery->fetchColumn();
foreach($result as &$comment1) {
	if($comment1["commentID"]!=""){
      	if(time() - 86400 > $comment1["timestamp"] OR date('d', $comment1["timestamp"]) < date('d', time())) $uploadDate = date("d.m.Y", $comment1["timestamp"]);
		else $uploadDate = date("G:i", $comment1["timestamp"]);
		$reply = $db->prepare("SELECT count(*) FROM replies WHERE commentID = :id");
		$reply->execute([':id' => $comment1["commentID"]]);
		$reply = $reply->fetchColumn();
		if($reply > 0) {
			$rep = $reply > 1 ? 'replies)' : 'reply)';
			$comment1["comment"] = base64_decode($comment1["comment"]);
			$comment1["comment"] = base64_encode($comment1["comment"].' ('.$reply.' '.$rep);
		}
		$commentstring .= "2~".$comment1["comment"]."~3~".$comment1["userID"]."~4~".$comment1["likes"]."~5~0~7~".$comment1["isSpam"]."~9~".$uploadDate."~6~".$comment1["commentID"]."|";
	}
}
$commentstring = substr($commentstring, 0, -1);
echo $commentstring;
echo "#".$commentcount.":".$commentpage.":10";
?>
