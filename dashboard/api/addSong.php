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
$name = ExploitPatch::rucharclean(urldecode($_GET['name']));
$author = ExploitPatch::rucharclean(urldecode($_GET['author']));
$download = ExploitPatch::rucharclean(urldecode($_GET['download']));
$reuploadID = $gs->getAccountIDFromName('ObeyGDBot');
if(!$reuploadID) $reuploadID = 0;
if(!$download) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'Please specify song download link.']));
$songReupload = $gs->songReupload($download, $author, $name, $reuploadID);
if($songReupload < 0) {
	$error = mb_substr($songReupload, 0, 2);
	switch($error) {
		case '-2':
			$errorNumber = 2;
			$errorMessage = 'Your download link is not link.';
			break;
		case '-3':
			$errorNumber = 3;
			$errorMessage = 'This song was already reuploaded.';
			break;
		case '-4':
			$errorNumber = 4;
			$errorMessage = 'Your download link is not link to an audio.';
			break;
		default:
			$errorNumber = 0;
			$errorMessage = 'Unexpected error.';
			break;
	}
	exit(json_encode(['dashboard' => true, 'success' => false, 'error' => $errorNumber, 'message' => $errorMessage]));
} else {
	$songInfo = $gs->getSongInfo($songReupload);
	$song = [
		'ID' => $songInfo['ID'],
		'author' => $songInfo['authorName'],
		'name' => $songInfo['name'],
		'size' => $songInfo['size'],
		'download' => urldecode($songInfo['download']),
		'reuploader' => [
			'accountID' => $reuploadID,
			'userID' => $gs->getUserID($reuploadID, 'ObeyGDBot'),
			'username' => 'ObeyGDBot'
		],
		'newgrounds' => false,
		'customSong' => true
	];
	exit(json_encode(['dashboard' => true, 'success' => true, 'song' => $song]));
}
?>