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
		if(!isset($_GET['token'])) {
			$_GET['token'] = $gs->randomString(11);
			$_GET['expires'] = time() + 3600;
		}
		$servers = [];
		foreach($customLibrary AS $library) {
			$servers[$library[0]] = $library[2];
		}
		if(!file_exists('ids.json')) {
			$time = $db->prepare('SELECT reuploadTime FROM songs WHERE reuploadTime > 0 ORDER BY reuploadTime DESC LIMIT 1');
			$time->execute();
			$time = $time->fetchColumn();
			$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 1);
		}
		$musicID = explode('.', $file)[0];
		$music = json_decode(file_get_contents('ids.json'), true)['IDs'][$musicID];
		if(empty($music)) $url = $gs->getSongInfo($musicID, 'download');
		elseif($servers[$music[0]] === null) $url = $gs->getSongInfo($music[1], 'download');
		else $url = $servers[$music[0]].'/music/'.$music[1].'.ogg?token='.$_GET['token'].'&expires='.$_GET['expires'];
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