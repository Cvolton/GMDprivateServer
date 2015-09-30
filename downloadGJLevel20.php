<?php
include "connection.php";
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
$query=$db->prepare("select * from levels where levelID = '".$levelID."'");
$query->execute();
$result2 = $query->fetchAll();
$result = $result2[0];
$timeago = $result["uploadDate"];
$timeago2 = date('Y-M-D', $timeago);
echo "1:".$result["levelID"].":2:".$result["levelName"].":3:".$result["levelDesc"].":4:".$result["levelString"].":5:".$result["levelVersion"].":6:".$result["accountID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":11:1:12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:28:".$timeago2. ":29:".$timeago2. ":35:".$result["songID"].":36:".$result["extraString"].":37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":27:0";
$downloads = $result["downloads"] + 1;
$query2=$db->prepare("UPDATE levels SET downloads = ".$downloads." WHERE levelID = ".$levelID.";");
$query2->execute();
?>