<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/songReup.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
require "../../config/proxy.php";
if(empty($_POST["songID"])){
	exit("-1");
}
$songid = ExploitPatch::remove($_POST["songID"]);
$query3=$db->prepare("SELECT ID,name,authorID,authorName,size,isDisabled,download FROM songs WHERE ID = :songid LIMIT 1");
$query3->execute([':songid' => $songid]);
$librarySong = $gs->getLibrarySongInfo($songid);
//todo: move this logic away from this file
if($query3->rowCount() == 0 && !$librarySong) {
	$url = 'https://www.boomlings.com/database/getGJSongInfo.php';
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
	if ($result == "-2" OR $result == "-1" OR $result == "") {
		$url = 'https://www.boomlings.com/database/getGJLevels21.php';
		$data = array(
			'gameVersion' => '21',
			'binaryVersion' => '33',
			'gdw' => '0',
			'type' => '2',
			'str' => '',
			'diff' => '-',
			'len' => '-',
			'page' => '0',
			'total' => '9999',
			'uncompleted' => '0',
			'onlyCompleted' => '0',
			'featured' => '0',
			'original' => '0',
			'twoPlayer' => '0',
			'coins' => '0',
			'epic' => '0',
			'song' => $songid,
			'customSong' => '1',
			'secret' => 'Wmfd2893gb7'
		);

		$ch = curl_init($url);
		if($proxytype == 1) curl_setopt($ch, CURLOPT_PROXY, $host);
		elseif($proxytype == 2) {
			curl_setopt($ch, CURLOPT_PROXY, $host);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
		}
		if(!empty($auth)) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$result = curl_exec($ch);
		curl_close($ch);
		if(substr_count($result, "1~|~".$songid."~|~2") != 0){
			$result = explode('#',$result)[2];
		}else{
			$ch = curl_init();
			if($proxytype == 1) curl_setopt($ch, CURLOPT_PROXY, $host);
			elseif($proxytype == 2) {
				curl_setopt($ch, CURLOPT_PROXY, $host);
				curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
			}
			if(!empty($auth)) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $auth); 
			curl_setopt($ch, CURLOPT_URL, "https://www.newgrounds.com/audio/listen/".$songid); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$songinfo = curl_exec($ch); 
			curl_close($ch);
			if(empty(explode('"url":"', $songinfo)[1])){
				exit("-1");
			}
			$songurl = explode('","', explode('"url":"', $songinfo)[1])[0];
			$songauthor = explode('","', explode('artist":"', $songinfo)[1])[0];
			$songurl = str_replace("\/", "/", $songurl);
			$songname = explode("<title>", explode("</title>", $songinfo)[0])[1];
			if($songurl == ""){
				exit("-1");
			}
			$result = "1~|~".$songid."~|~2~|~".$songname."~|~3~|~1234~|~4~|~".$songauthor."~|~5~|~6.69~|~6~|~~|~10~|~".$songurl."~|~7~|~~|~8~|~1";
		}
	}
	echo $result;
	$reup = SongReup::reup($result);
} else {
	$result4 = !$librarySong ? $query3->fetch() : $librarySong;
	if($result4["isDisabled"] == 1) exit("-2");
	$dl = $result4["download"];
	if(strpos($dl, ':') !== false) $dl = urlencode($dl);
	echo "1~|~".$result4["ID"]."~|~2~|~".ExploitPatch::translit($result4["name"])."~|~3~|~".$result4["authorID"]."~|~4~|~".ExploitPatch::translit($result4["authorName"])."~|~5~|~".$result4["size"]."~|~6~|~~|~7~|~~|~8~|~0~|~10~|~".$dl."";
	if($librarySong) {
		$artistsNames = [];
		$artistsArray = explode('.', $result4['artists']);
		if(count($artistsArray) > 0) {
			foreach($artistsArray AS &$artistID) {
				$artistData = $gs->getLibrarySongAuthorInfo($artistID);
				if(!$artistData) continue;
				$artistsNames[] = $artistID;
				$artistsNames[] = $artistData['name'];
			}
		}
		$artistsNames = implode(',', $artistsNames);
		echo '~|~9~|~'.$result4['priorityOrder'].'~|~11~|~'.$result4['ncs'].'~|~12~|~'.$result4['artists'].'~|~13~|~'.($result4['new'] ? 1 : 0).'~|~14~|~'.$result4['new'].'~|~15~|~'.$artistsNames;
	}
}
?>
