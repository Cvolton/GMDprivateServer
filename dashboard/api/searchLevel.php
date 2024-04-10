<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/connection.php";
include "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
if(!isset($_GET)) $_GET = json_decode(file_get_contents('php://input'), true);
$levelID = ExploitPatch::number(urldecode($_GET['level']));
if(empty($levelID)) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => "Please supply a valid level ID."]));
$query = $db->prepare("SELECT * FROM levels WHERE levelID = :lvid");
$query->execute([':lvid' => $levelID]);
$rate = $query->fetch();
if(!$rate) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => "This level wasn't found."]));
$songInfo = $song = $songName = false;
if($rate['songID'] != 0) {
	$songInfo = $gs->getSongInfo($rate['songID']);
	if($songInfo) {
		$song = [
			'ID' => $songInfo['ID'],
			'author' => $songInfo['authorName'],
			'name' => $songInfo['name'],
			'size' => $songInfo['size'],
			'download' => urldecode($songInfo['download']),
			'reuploader' => false,
			'newgrounds' => true,
			'customSong' => true
		];
		if($songInfo['reuploadID'] != 0) {
			$accountName = $gs->getAccountName($songInfo['reuploadID']);
			$song['reuploader'] = [
				'accountID' => $songInfo['reuploadID'],
				'userID' => $gs->getUserID($songInfo['reuploadID'], $accountName),
				'username' => $accountName
			];
			$song['newgrounds'] = false;
		}
	} else {
		$songName = explode(' by ', $gs->getAudioTrack($rate['audioTrack']));
		$song = [
			'audioTrack' => $rate['audioTrack'],
			'name' => $songName[0],
			'author' => $songName[1],
			'customSong' => false
		];
	}
} else {
	$songName = explode(' by ', $gs->getAudioTrack($rate['audioTrack']));
	$song = [
		'audioTrack' => $rate['audioTrack'],
		'name' => $songName[0],
		'author' => $songName[1],
		'customSong' => false
	];
}
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $data]));
];
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $level]));
?>