<?php
include "connection.php";
$query3=$db->prepare("select * from songs where ID = '".htmlspecialchars($_POST["songID"],ENT_QUOTES)."'");
$query3->execute();
$result3 = $query3->fetchAll();
$result4 = $result3[0];
echo "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
?>