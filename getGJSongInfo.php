<?php
include "connection.php";
$songid = htmlspecialchars($_POST["songID"],ENT_QUOTES);
$query3=$db->prepare("select * from songs where ID = '$songid'");
$query3->execute();
if($query3->rowCount() == 0) {
$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
$data = array('songID' => $songid, 'secret' => 'Wmfd2893gb7');
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;
}else{
$result3 = $query3->fetchAll();
$result4 = $result3[0];
echo "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
}
?>