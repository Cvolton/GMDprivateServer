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
$time = ExploitPatch::number(urldecode($_GET['checkRateTime']));
if(empty($time)) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'Please specify your last rate check time.']));
$rates = $db->prepare("SELECT * FROM levels WHERE rateDate != 0 AND rateDate > :time ORDER BY rateDate DESC");
$rates->execute([':time' => $time]);
$rates = $rates->fetchAll();
if(empty($rates)) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => 'Nothing was rated!']));
foreach($rates as &$rate) {
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
	$levels[] = [
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
}
exit(json_encode(['dashboard' => true, 'success' => true, 'levels' => $levels]));
?>