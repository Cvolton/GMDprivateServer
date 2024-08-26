<?php
// Original Idea by Cirno
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");
require_once "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
// 2592000 seconds = 30d
$query = $db->prepare("SELECT
    (SELECT COUNT(*) FROM users) AS users,
    (SELECT COUNT(*) FROM users WHERE lastPlayed > :time - 2592000) AS activeUsers, 
    (SELECT COUNT(*) FROM levels) AS levels,
    (SELECT COUNT(*) FROM levels WHERE starStars >= 1) AS ratedLevels,
    (SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 0) AS featuredLevels,
    (SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 1) AS epicLevels,
    (SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 2) AS legendaryLevels,
    (SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 3) AS mythicLevels,
    (SELECT COUNT(*) FROM dailyfeatures WHERE type = 0) AS dailies,
    (SELECT COUNT(*) FROM dailyfeatures WHERE type = 1) AS weeklies,
    (SELECT COUNT(*) FROM gauntlets) AS gauntlets,
    (SELECT COUNT(*) FROM mappacks) AS mapPacks,
    (SELECT SUM(downloads) FROM levels) AS downloads,
    (SELECT SUM(objects) FROM levels) AS objects,
    (SELECT SUM(likes) FROM levels) AS likes,
    (SELECT (SELECT COUNT(*) FROM comments) + (SELECT COUNT(*) FROM acccomments)) AS totalComments,
    (SELECT COUNT(*) FROM comments) AS comments,
    (SELECT COUNT(*) FROM acccomments) AS posts,
    (SELECT COUNT(*) FROM replies) AS postReplies,
    (SELECT SUM(stars) FROM users) AS stars,
    (SELECT SUM(creatorPoints) FROM users) AS creatorPoints,
	(SELECT COUNT(*) FROM bans) AS bannedPlayers,
	(SELECT COUNT(personType) FROM bans WHERE personType = 0) AS accountIDBans,
	(SELECT COUNT(personType) FROM bans WHERE personType = 1) AS userIDBans,
	(SELECT COUNT(personType) FROM bans WHERE personType = 2) AS IPBans,
	(SELECT COUNT(banType) FROM bans WHERE banType = 0) AS leaderboardBans,
	(SELECT COUNT(banType) FROM bans WHERE banType = 1) AS creatorBans,
	(SELECT COUNT(banType) FROM bans WHERE banType = 2) AS levelUploadBans,
	(SELECT COUNT(banType) FROM bans WHERE banType = 3) AS commentBans,
	(SELECT COUNT(banType) FROM bans WHERE banType = 4) AS accountBans
");
$query->execute([':time' => time()]);
$stats = $query->fetch(PDO::FETCH_ASSOC);
$stats = [
    'users' => [
        'total' => (int)$stats['users'],
        'active' => (int)$stats['activeUsers']
    ],
    'levels' => [
        'total' => (int)$stats['levels'],
        'rated' => (int)$stats['ratedLevels'],
        'featured' => (int)$stats['featuredLevels'],
        'epic' => (int)$stats['epicLevels'],
        'legendary' => (int)$stats['legendaryLevels'],
        'mythic' => (int)$stats['mythicLevels']
    ],
    'special' => [
        'dailies' => (int)$stats['dailies'],
        'weeklies' => (int)$stats['weeklies'],
        'gauntlets' => (int)$stats['gauntlets'],
        'map_packs' => (int)$stats['mapPacks']
    ],
    'downloads' => [
        'total' => (int)$stats['downloads'],
        'average' => (double)($stats['downloads'] / $stats['levels'])
    ],
    'objects' => [
        'total' => (int)$stats['objects'],
        'average' => (double)($stats['objects'] / $stats['levels'])
    ],
    'likes' => [
        'total' => (int)$stats['likes'],
        'average' => (double)($stats['likes'] / $stats['levels'])
    ],
    'comments' => [
        'total' => (int)$stats['totalComments'],
        'comments' => (int)$stats['comments'],
        'posts' => (int)$stats['posts'],
        'post_replies' => (int)$stats['postReplies']
    ],
    'gained_stars' => [
        'total' => (int)$stats['stars'],
        'average' => (double)($stats['stars'] / $stats['users'])
    ],
    'creator_points' => [
        'total' => (float)$stats['creatorPoints'],
        'average' => (double)($stats['creatorPoints'] / $stats['users'])
    ],
    'bans' => [
        'total' => (int)$stats['bannedPlayers'],
        'personTypes' => [
			'accountIDBans' => (int)$stats['accountIDBans'],
			'userIDBans' => (int)$stats['userIDBans'],
			'IPBans' => (int)$stats['IPBans']
		],
		'banTypes' => [
			'leaderboardBans' => (int)$stats['leaderboardBans'],
			'creatorBans' => (int)$stats['creatorBans'],
			'levelUploadBans' => (int)$stats['levelUploadBans'],
			'commentBans' => (int)$stats['commentBans'],
			'accountBans' => (int)$stats['accountBans']
		]
    ]
];
exit(json_encode(['dashboard' => true, 'success' => true, 'stats' => $stats]));
?>