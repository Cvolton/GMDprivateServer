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
$levelInfo = $query->fetch();
if(!$levelInfo) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => "This level wasn't found."]));
$query = $db->prepare("SELECT * FROM levels WHERE levelID = :lvid");
$query->execute([':lvid' => $levelID]);
$result = $query->fetchAll();
foreach($result as &$action){
	$data[] = [
		'name' => $action['levelName'],
		'description' => base64_decode($action['levelDesc']),
		'author' => $action['userName'],
		'authorID' => $action['extID'],
		'version' => $action['levelVersion'],
		'gameVersion' => $action['gameVersion'],
		'binaryVersion' => $action['binaryVersion'],
		'songID' => ($action['audioTrack'] != 0) ? $action['audioTrack'] : $action['songID'],
		'isTwoPlayer' => $action['twoPlayer'],
		'objects' => $action['objects'],
		'coins' => $action['coins'],
		'requestedStars' => $action['requestedStars'],
		'downloads' => $action['downloads'],
		'likes' => $action['likes'],
		'stars' => $action['starStars'],
		'uploadDate' => $action['uploadDate'],
		'updateDate' => $action['updateDate'],
		'rateDate' => $action['rateDate'],
	];
}
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $data]));
?>