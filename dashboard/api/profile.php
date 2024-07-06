<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/generatePass.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
if(empty($_GET)) $json = json_decode(file_get_contents('php://input'), true);
else $json = $_GET;
$accountID = $json['accountID'] ?? 0;
if(isset($json['auth'])) {
	$check = GeneratePass::IsValidToken(ExploitPatch::charclean($json['auth']));
	if(!is_array($check)) exit(json_encode(['success' => false, 'error' => $check]));
	if(isset($json['accountID'])) $accountID = $json['accountID'];
	else $accountID = $check['accountID'];
}
if(empty($accountID)) exit(json_encode(['success' => false, 'error' => 0, 'message' => 'You didn\'t specify account ID.']));
$profile = $db->prepare('SELECT * FROM users WHERE extID = :accountID');
$profile->execute([':accountID' => $accountID]);
$profile = $profile->fetch();
if(!$profile) exit(json_encode(['success' => false, 'error' => 1, 'message' => 'Nothing was found.']));
$clan = $stats = $icons = $bans = $posts = $demonsCount = $starsCount = $platformerCount = $bans = [];
if($profile['clan']) {
	$clanInfo = $gs->getClanInfo($profile['clan']);
	if($clanInfo) {
		$clan = [
			'ID' => (int)$clanInfo['ID'],
			'name' => $clanInfo['clan'],
			'tag' => $clanInfo['tag'],
			'desc' => $clanInfo['desc'],
			'owner' => [
				'accountID' => (int)$clanInfo['clanOwner'],
				'userID' => (int)$gs->getUserID($clanInfo['clanOwner']),
				'userName' => $gs->getAccountName($clanInfo['clanOwner'])
			],
			'color' => $clanInfo['color'],
			'isClosed' => $clanInfo['isClosed'] == 1,
			'creationDate' => (int)$clanInfo['creationDate']
		];
	}
}
if($profile['dinfo']) {
	$demonsArray = explode(',', $profile['dinfo']);
	$demonsCount = [
		'easy' => [
			'classic' => (int)$demonsArray[0],
			'platformer' => (int)$demonsArray[5]
		],
		'medium' => [
			'classic' => (int)$demonsArray[1],
			'platformer' => (int)$demonsArray[6]
		],
		'hard' => [
			'classic' => (int)$demonsArray[2],
			'platformer' => (int)$demonsArray[7]
		],
		'insane' => [
			'classic' => (int)$demonsArray[3],
			'platformer' => (int)$demonsArray[8]
		],
		'extreme' => [
			'classic' => (int)$demonsArray[4],
			'platformer' => (int)$demonsArray[9]
		],
		'weekly' => (int)$demonsArray[10],
		'gauntlet' => (int)$demonsArray[11]
	];
}
if($profile['sinfo']) {
	$starsArray = explode(',', $profile['sinfo']);
	$starsCount = [
		'auto' => (int)$starsArray[0],
		'easy' => (int)$starsArray[1],
		'normal' => (int)$starsArray[2],
		'hard' => (int)$starsArray[3],
		'harder' => (int)$starsArray[4],
		'extreme' => (int)$starsArray[5],
		'daily' => (int)$starsArray[6],
		'weekly' => (int)$starsArray[7]
	];
}
if($profile['pinfo']) {
	$platformerArray = explode(',', $profile['pinfo']);
	$platformerCount = [
		'auto' => (int)$platformerArray[0],
		'easy' => (int)$platformerArray[1],
		'normal' => (int)$platformerArray[2],
		'hard' => (int)$platformerArray[3],
		'harder' => (int)$platformerArray[4],
		'extreme' => (int)$platformerArray[5],
		'map' => (int)$platformerArray[6]
	];
}
$stats = [
	'stars' => (int)$profile['stars'],
	'moons' => (int)$profile['moons'],
	'demons' => (int)$profile['demons'],
	'diamonds' => (int)$profile['diamonds'],
	'goldCoins' => (int)$profile['coins'],
	'userCoins' => (int)$profile['userCoins'],
	'creatorPoints' => (int)$profile['creatorPoints'],
	'demonsCount' => $demonsCount,
	'starsCount' => $starsCount,
	'platformerCount' => $platformerCount
];
$icons = [
	'currentIcon' => [
		'iconType' => (int)$profile['iconType'],
		'iconID' => (int)$profile['icon']
	],
	'colors' => [
		'mainColor' => (int)$profile['color1'],
		'secondaryColor' => (int)$profile['color2'],
		'glowColor' => (int)$profile['color3']
	],
	'special' => (int)$profile['special'],
	'cube' => (int)$profile['accIcon'],
	'ship' => (int)$profile['accShip'],
	'ball' => (int)$profile['accBall'],
	'wave' => (int)$profile['accDart'],
	'robot' => (int)$profile['accRobot'],
	'spider' => (int)$profile['accSpider'],
	'glow' => $profile['accGlow'] == 1,
	'swing' => (int)$profile['accSwing'],
	'jetpack' => (int)$profile['accJetpack'],
	'explosion' => (int)$profile['accExplosion']
];
$allBans = $gs->getAllBansFromPerson($accountID, 0);
foreach($allBans AS &$ban) {
	$bans[] = [
		'banID' => $ban['banID'],
		'moderator' => [
			'accountID' => (int)$ban['modID'],
			'userID' => (int)$gs->getUserID($ban['modID']),
			'userName' => $gs->getAccountName($ban['modID'])
		],
		'reason' => ExploitPatch::rucharclean(base64_decode($ban['banType'])),
		'banType' => $ban['banType'],
		'personType' => $ban['personType'],
		'expires' => $ban['expires'],
		'timestamp' => $ban['timestamp'],
	];
}
$postComments = $db->prepare('SELECT * FROM acccomments WHERE userID = :userID ORDER BY commentID DESC');
$postComments->execute([':userID' => $profile['userID']]);
$postComments = $postComments->fetchAll();
foreach($postComments AS &$postComment) {
	$replies = [];
	$repliesCheck = $db->prepare('SELECT * FROM replies WHERE commentID = :commentID ORDER BY replyID DESC');
	$repliesCheck->execute([':commentID' => $postComment['commentID']]);
	$repliesCheck = $repliesCheck->fetchAll();
	foreach($repliesCheck AS &$reply) {
		$replies[] = [
			'replyID' => (int)$reply['replyID'],
			'account' => [
				'accountID' => (int)$reply['accountID'],
				'userID' => (int)$gs->getUserID($reply['accountID']),
				'userName' => $gs->getAccountName($reply['accountID'])
			],
			'text' => base64_decode($reply['body']),
			'timestamp' => (int)$reply['timestamp']
		];
	}
	$posts[] = [
		'commentID' => (int)$postComment['commentID'],
		'post' => base64_decode($postComment['comment']),
		'likes' => (int)$postComment['likes'],
		'dislikes' => (int)$postComment['dislikes'],
		'isSpam' => (int)$postComment['isSpam'],
		'timestamp' => (int)$postComment['timestamp'],
		'replies' => $replies
	];
}
exit(json_encode([
	'accountID' => (int)$profile['extID'],
	'userID' => (int)$profile['userID'],
	'userName' => $profile['userName'],
	'clan' => $clan,
	'dlPoints' => (int)$profile['dlPoints'],
	'stats' => $stats,
	'icons' => $icons,
	'lastPlayed' => (int)$profile['lastPlayed'],
	'bans' => $bans,
	'posts' => $posts
]));
?>