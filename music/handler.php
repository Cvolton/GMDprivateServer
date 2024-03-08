<?php
include_once "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
include "../config/dashboard.php";
$gs = new mainLib();
$file = trim(basename($_GET['request']));
$type = explode('.', $file);
$type = $type[count($type)-1];
switch($file) {
	case 'musiclibrary.dat': 
		if(!file_exists('gdps.dat')) {
			$time = $db->prepare('SELECT reuploadTime FROM songs WHERE reuploadTime > 0 ORDER BY reuploadTime DESC LIMIT 1');
			$time->execute();
			$time = $time->fetchColumn();
			$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 1);
		}
		echo file_get_contents('gdps.dat');
		break;
	case 'musiclibrary_version.txt': 
		$time = $db->prepare('SELECT reuploadTime FROM songs WHERE reuploadTime > 0 ORDER BY reuploadTime DESC LIMIT 1');
		$time->execute();
		$time = $time->fetchColumn();
		if(!$time) $time = 1;
		$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 1);
		$times = [];
		foreach($customLibrary AS $library) {
			if($library[2] !== null) $times[] = explode(', ', file_get_contents('s'.$library[0].'.txt'))[1];
		}
		$times[] = $time;
		rsort($times);
		echo $times[0];
		break;
	default:
		$explode = explode('0', $file);
		$servers = [];
		foreach($customLibrary AS $library) {
			$servers[$library[0]] = $library[2];
		}
		$music = substr($file, strlen($explode[0]) + 1, strlen($file));
		$musicID = explode('.', substr($file, strlen($explode[0]) + 1, strlen($file)))[0];
		if($servers[$explode[0]] !== null) $url = $servers[$explode[0]].'/music/'.$music.'?token='.$_GET['token'].'&expires='.$_GET['expires'];
		else $url = $gs->getSongInfo($musicID);
		$curl = curl_init($url['download']);
		curl_setopt_array($curl, [
			CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
			CURLOPT_RETURNTRANSFER => 1
		]);
		echo curl_exec($curl);
		curl_close($curl);
		break;
}
?>