<?php
include "connection.php";
$extID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
$query=$db->prepare("select * from users where extID = '".$extID."'");
$query->execute();
$result2 = $query->fetchAll();
$result = $result2[0];
echo "1:".$result["userName"].":2:".$result["userID"].":13:".$result["coins"].":17:".$result["userCoins"].":10:".$result["color1"].":11:".$result["color2"].":3:".$result["stars"].":4:".$result["demons"].":8:0:18:0:19:0:20:UC9uH5ecBeZU4ubnazK1H_JQ:21:".$result["accIcon"].":22:".$result["accShip"].":23:".$result["accBall"].":24:".$result["accBird"].":25:".$result["accDart"].":26:".$result["accRobot"].":28:".$result["accGlow"].":30:69:16:".$result["extID"].":31:0:38:0:39:0:40:0:29:1";
?>
