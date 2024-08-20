<?php
include_once "../incl/lib/connection.php";
include_once "../incl/lib/mainLib.php";
include "../config/dashboard.php";
require "../config/proxy.php";
$gs = new mainLib();
$file = trim(basename($_GET['request']));
switch($file) {
	case 'sfxlibrary.dat':
		$datFile = isset($_GET['dashboard']) ? 'standalone.dat' : 'gdps.dat';
		if(!file_exists($datFile)) {
			$time = $db->prepare('SELECT reuploadTime FROM sfxs ORDER BY reuploadTime DESC LIMIT 1');
			$time->execute();
			$time = $time->fetchColumn();
			$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 0);
		}
		echo file_get_contents($datFile);
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
		$servers = [];
		foreach($customLibrary AS $library) {
			$servers[$library[0]] = $library[2];
		}
		$sfxID = explode('.', substr($file, 1, strlen($file)))[0];
		if(!file_exists('ids.json')) {
			$time = $db->prepare('SELECT reuploadTime FROM sfxs ORDER BY reuploadTime DESC LIMIT 1');
			$time->execute();
			$time = $time->fetchColumn();
			$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 0);
		}
		$song = $gs->getLibrarySongInfo($sfxID, 'sfx');
		$url = urldecode($song['download']);
		header("Location: $url");
		break;
}
?>