<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/GJPCheck.php";
$gs = new mainLib();
if(!isset($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);

$accountID = GJPCheck::getAccountIDOrDie(true);
if(!$accountID) {
	http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'Please supply a valid account credentials.'])); 
}

http_response_code(400); // Set the bad request response code now to not repeat it after

$levelID = isset($_POST['level']) ? ExploitPatch::number(urldecode($_POST['level'])) : exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => 'Please specify a valid level ID.']));
$demon = isset($_POST['demon']) ? ExploitPatch::number(urldecode($_POST['demon'])) : exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 3, 'message' => 'Please specify a demon difficulty.']));

// Check for valid demon difficulty
if (!empty($demon) && $demon < 0 || $demon > 5) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 4, 'message' => 'Please specify a valid demon difficulty.']));

// Check for rate demon permission
if ($gs->getMaxValuePermission($accountID, "actionRateDemon") == false) {
    http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 5, 'message' => 'You do not have the necessary permission to change the demon difficulty of a level!']));
}

$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
$query->execute([':levelID' => $levelID]);
$query = $query->fetch();

// Check if the level exists
if (!$query) {
    http_response_code(404);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 6, 'message' => 'This level does not exist!']));
}

if (!$query['starDemon']) {
    http_response_code(404);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 7, 'message' => 'This level is not a Demon level!']));
}

// Taken from incl/levels/rateGJDemon.php
switch($demon){
	case 1:
		$dmn = 3;
		$dmnname = "Easy";
		break;
	case 2:
		$dmn = 4;
		$dmnname = "Medium";
		break;
	case 3:
		$dmn = 0;
		$dmnname = "Hard";
		break;
	case 4:
		$dmn = 5;
		$dmnname = "Insane";
		break;
	case 5:
		$dmn = 6;
		$dmnname = "Extreme";
		break;
}

// Change demon difficulty
$query = $db->prepare("UPDATE levels SET starDemonDiff = :demon WHERE levelID = :levelID");	
$query->execute([':demon' => $dmn, ':levelID' => $levelID]);
// Insert into mod actions
$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('10', :value, :levelID, :timestamp, :id)");
$query->execute([':value' => $dmnname, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);

http_response_code(200); // Set back the response code to 200 before exitting
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $levelID]));
?>