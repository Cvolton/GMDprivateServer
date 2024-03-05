<?php
include_once "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
$gs = new mainLib();
$file = trim(basename($_GET['request']));
$type = explode('.', $file);
$type = $type[count($type)-1];
//var_dump($_GET);
switch($file) {
	case 'sfxlibrary.dat': 
		if(!file_exists('gdps.dat')) $gs->updateLibraries($_GET['token'], $_GET['expires'], $time);
		echo file_get_contents('gdps.dat');
		break;
	case 'sfxlibrary_version.txt': 
		$time = $db->prepare('SELECT reuploadTime FROM sfxs WHERE reuploadTime > 0 ORDER BY reuploadTime DESC LIMIT 1');
		$time->execute();
		$time = $time->fetchColumn();
		if(!$time) $time = 1;
		$gs->updateLibraries($_GET['token'], $_GET['expires'], $time);
		$s1time = explode(', ', file_get_contents('s1.txt'))[1];
		$s2time = explode(', ', file_get_contents('s2.txt'))[1];
		$times = [$s1time, $s2time, $time];
		rsort($times);
		echo $times[0];
		break;
	default:
		if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) $https = 'https';
		else $https = 'http';
		$thisServerURL = dirname(dirname($https."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"));
		$explode = explode('0', $file);
		$servers = ['s1' => 'https://geometrydashfiles.b-cdn.net/', 's2' => 'https://libs.noxicloud.es/', 's3' => $thisServerURL];
		$sfx = 's'.substr($file, strlen($explode[0]) + 1, strlen($file));
		$sfxID = explode('.', substr($file, strlen($explode[0]) + 1, strlen($file)))[0];
		if($explode[0] != 's3') $url = $servers[$explode[0]].'/sfx/'.$sfx.'?token='.$_GET['token'].'&expires='.$_GET['expires'];
		else $url = $gs->getSFXInfo($sfxID, 'download');
		$curl = curl_init($url);
		curl_setopt_array($curl, [
			CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
			CURLOPT_RETURNTRANSFER => 1
		]);
		echo curl_exec($curl);
		curl_close($curl);
		break;
}
?>