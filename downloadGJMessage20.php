<?php
include "connection.php";
$messageID = htmlspecialchars($_POST["messageID"],ENT_QUOTES);
$query=$db->prepare("select * from messages where messageID = '".$messageID."'");
$query->execute();
$result2 = $query->fetchAll();
$result = $result2[0];
echo "6:".$result["userName"].":3:".$result["userID"].":2:".$result["accID"].":1:".$result["messageID"].":4:".$result["subject"].":8:1:9:0:5:".$result["body"].":7:CVOLTON GDPS";
?>