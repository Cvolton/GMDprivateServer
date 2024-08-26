<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/mainLib.php";
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
$rate['extID'] = is_numeric($rate['extID']) ? $rate['extID'] : 0;
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
$level = [
	'ID' => $rate['levelID'],
	'name' => $rate['levelName'],
	'desc' => ExploitPatch::rucharclean(ExploitPatch::url_base64_decode($rate['levelDesc'])),
	'stats' => [
		'stars' => $rate['starStars'],
		'featured' => ($rate['starFeatured'] == 0 ? false : true),
		'isRated' => ($rate['starStars'] == 0 ? false : true),
		'isCoinsRated' => ($rate['starCoins'] == 0 ? false : true),
		'coins' => $rate['coins'],
		'likes' => $rate['likes'] - ($rate['dislikes'] ?? 0),
		'downloads' => $rate['downloads'],
		'requestedStars' => $rate['requestedStars'],
		'epic' => $rate['starEpic']
	],
	'diffuculty' => [
		'number' => $rate['starDifficulty'],
		'demonDiff' => $rate['starDemonDiff'],
		'name' => $gs->getDifficulty($rate['starDifficulty'], $rate['starAuto'], $rate['starDemon']),
		'isDemon' => ($rate['starDemon'] == 0 ? false : true),
		'isAuto' => ($rate['starAuto'] == 0 ? false : true)
	],
	'author' => [
		'username' => $rate['userName'],
		'accountID' => $rate['extID'],
		'userID' => $rate['userID']
	],
	'timestamps' => [
		'uploadDate' => $rate['uploadDate'],
		'updateDate' => $rate['updateDate'],
		'rateDate' => $rate['rateDate']
	],
	'song' => $song
];
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $level]));
?>