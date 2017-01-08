<?php
$songid = htmlspecialchars($_POST["songID"], ENT_QUOTES);

$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
$data = array('songID' => $songid, 'secret' => 'Wmfd2893gb7');
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result == "-1") {
    $songinfo = file_get_contents("http://www.newgrounds.com/audio/listen/".$songid);
    $songurl = explode('","', explode('"url":"', $songinfo)[1])[0];
    $songname = substr($songurl, 43);
    $realsongurl = "http://audio.ngfiles.com/".round($songid, -3)."/".$songid."_".$songname;
    if (url_exists($realsongurl)) {
        echo "1~|~".$songid."~|~2~|~".substr($songname, 0, -4)."~|~3~|~undefined~|~4~|~undefined~|~5~|~69.69~|~6~|~~|~10~|~".urlencode($realsongurl)."~|~7~|~~|~8~|~0";
    } else {
        die('-1');   
    }
} else {
    echo $result;
}      
function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}
?>
