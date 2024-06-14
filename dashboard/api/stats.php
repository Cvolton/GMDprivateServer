<?php
// Original Idea by Cirno
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");
require_once "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/connection.php";


$query = $db->prepare("SELECT COUNT(*) FROM users");
$query->execute();
$users = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM users WHERE lastPlayed > :time - 2592000"); // 2592000 seconds = 30d
$query->execute([':time' => time()]);
$activeUsers = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM levels");
$query->execute();
$levels = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM levels WHERE starStars >= 1");
$query->execute();
$ratedLevels = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 0");
$query->execute();
$featuredLevels = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 1");
$query->execute();
$epicLevels = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 2");
$query->execute();
$legendaryLevels = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM levels WHERE starStars >= 1 AND starFeatured >= 1 AND starEpic = 3");
$query->execute();
$mythicLevels = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM dailyfeatures WHERE type = 0");
$query->execute();
$dailies = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM dailyfeatures WHERE type = 1");
$query->execute();
$weeklies = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM gauntlets");
$query->execute();
$gauntlets = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM mappacks");
$query->execute();
$mapPacks = $query->fetchColumn();

$query = $db->prepare("SELECT SUM(downloads) FROM levels");
$query->execute();
$downloads = $query->fetchColumn();

$query = $db->prepare("SELECT SUM(objects) FROM levels");
$query->execute();
$objects = $query->fetchColumn();

$query = $db->prepare("SELECT SUM(likes) FROM levels");
$query->execute();
$likes = $query->fetchColumn();

$query = $db->prepare("SELECT (SELECT COUNT(*) FROM comments) + (SELECT COUNT(*) FROM acccomments)");
$query->execute();
$comments = $query->fetchColumn();

$query = $db->prepare("SELECT SUM(stars) FROM users");
$query->execute();
$stars = $query->fetchColumn();

$query = $db->prepare("SELECT SUM(creatorPoints) FROM users");
$query->execute();
$creatorPoints = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM users WHERE isBanned = 1 OR isCommentBanned = 1 OR isCreatorBanned = 1 OR isUploadBanned = 1");
$query->execute();
$bannedPlayers = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM users WHERE isBanned = 1");
$query->execute();
$leaderboardBanned = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM users WHERE isCommentBanned = 1");
$query->execute();
$commentBanned = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM users WHERE isCreatorBanned = 1");
$query->execute();
$creatorBanned = $query->fetchColumn();

$query = $db->prepare("SELECT COUNT(*) FROM users WHERE isUploadBanned = 1");
$query->execute();
$uploadBanned = $query->fetchColumn();

$stats = [
    'users' => (int)$users,
    'active_users' => (int)$activeUsers,

    'levels' => (int)$levels,
    'rated_levels' => (int)$ratedLevels,
    'featured_levels' => (int)$featuredLevels,
    'epic_levels' => (int)$epicLevels,
    'legendary_levels' => (int)$legendaryLevels,
    'mythic_levels' => (int)$mythicLevels,

    'dailies' => (int)$dailies,
    'weeklies' => (int)$weeklies,
    'gauntlets' => (int)$gauntlets,
    'map_packs' => (int)$mapPacks,

    'downloads' => (int)$downloads,
    'avg_downloads' => (double)$downloads / $levels,

    'objects' => (int)$objects,
    'avg_objects' => $objects / $levels,

    'likes' => (int)$likes,
    'avg_likes' => (double)$likes / $levels,

    'comments' => (int)$comments,

    'stars' => (int)$stars,
    'creator_points' => (int)$creatorPoints,
    'avg_creator_points' => (double)$creatorPoints / $users,

    'banned_players' => (int)$bannedPlayers,
    'leaderboard_banned' => (int)$leaderboardBanned,
    'comment_banned' => (int)$commentBanned,
    'creator_banned' => (int)$creatorBanned,
    'upload_banned' => (int)$uploadBanned
];

exit(json_encode(['dashboard' => true, 'success' => true, 'stats' => $stats]));
?>
