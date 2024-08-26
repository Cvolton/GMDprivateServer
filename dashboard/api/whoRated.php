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
$levelInfo = $query->fetch();
if(!$levelInfo) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => "This level wasn't found."]));
$query = $db->prepare("SELECT * FROM modactions WHERE value3 = :lvid AND type = '1'");
$query->execute([':lvid' => $levelID]);
$result = $query->fetchAll();
if($query->rowCount() == 0) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 3, 'message' => "This level wasn't rated."]));
foreach($result as &$action){
	$userName = $gs->getAccountName($action['account']);
	$data[] = [
		'username' => $userName,
		'accountID' => $action['account'],
		'difficulty' => $action['value'],
		'stars' => $action['value2'],
		'timestamp' => $action['timestamp']
	];
}
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => ['name' => $levelInfo['levelName'], 'author' => $levelInfo['userName']], 'rates' => $data]));
?>