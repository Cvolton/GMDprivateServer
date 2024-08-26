<?php
require_once "../incl/lib/connection.php";
require_once "../incl/lib/mainLib.php";
require "../config/dashboard.php";
require "../config/proxy.php";
$gs = new mainLib();
$file = trim(basename($_GET['request']));
switch($file) {
	case 'musiclibrary.dat': 
	case 'musiclibrary_02.dat': 
		$datFile = isset($_GET['dashboard']) ? 'standalone.dat' : 'gdps.dat';
		if(!file_exists($datFile)) {
			$time = $db->prepare('SELECT reuploadTime FROM songs WHERE reuploadTime > 0 ORDER BY reuploadTime DESC LIMIT 1');
			$time->execute();
			$time = $time->fetchColumn();
			$gs->updateLibraries($_GET['token'], $_GET['expires'], $time, 1);
		}
		echo file_get_contents($datFile);
		break;
	case 'musiclibrary_version.txt': 
	case 'musiclibrary_version_02.txt': 
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
		$song = $gs->getLibrarySongInfo($musicID, true);
		if($song) $url = urldecode($song['download']);
		else $url = urldecode($gs->getSongInfo($musicID, 'download'));
		if(empty($url)) header("Location: https://www.newgrounds.com/audio/listen/$musicID");
		header("Location: $url");
		break;
}
?>
