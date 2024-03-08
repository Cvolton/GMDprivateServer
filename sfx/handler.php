<?php
include_once "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
include "../config/dashboard.php";
global $customLibrary;
$gs = new mainLib();
$file = trim(basename($_GET['request']));
$type = explode('.', $file);
$type = $type[count($type)-1];
//var_dump($_GET);
switch($file) {
	case 'sfxlibrary.dat': 
		if(!file_exists('gdps.dat')) $gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 0);
		echo file_get_contents('gdps.dat');
		break;
	case 'sfxlibrary_version.txt': 
		$time = $db->prepare('SELECT reuploadTime FROM sfxs WHERE reuploadTime > 0 ORDER BY reuploadTime DESC LIMIT 1');
		$time->execute();
		$time = $time->fetchColumn();
		if(!$time) $time = 1;
		$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 0);
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
			$servers['s'.$library[0]] = $library[2];
		}
		$sfx = 's'.substr($file, strlen($explode[0]) + 1, strlen($file));
		$sfxID = explode('.', substr($file, strlen($explode[0]) + 1, strlen($file)))[0];
		if($servers[$explode[0]] !== null) $url = $servers[$explode[0]].'/sfx/'.$sfx.'?token='.$_GET['token'].'&expires='.$_GET['expires'];
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