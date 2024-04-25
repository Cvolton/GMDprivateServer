<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."config/dashboard.php";
$gs = new mainLib();
if($convertEnabled && $_POST['token'] && $_FILES && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
	$server = (((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http").dirname("://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]").'/';
	$token = trim(ExploitPatch::charclean($_POST['token']));
	if(empty($token) || strlen($token) != 32) exit(json_encode(['success' => false, 'code' => 0, 'error' => 'Invalid params.']));
	$check = $db->prepare('SELECT ID FROM sfxs WHERE token = :token');
	$check->execute([':token' => $token]);
	$check = $check->fetchColumn();
	if(!$check) exit(json_encode(['success' => false, 'code' => 1, 'error' => 'Invalid token.']));
	$info = new finfo(FILEINFO_MIME);
	$file_type = explode(';', $info->buffer(file_get_contents($_FILES['file']['tmp_name'])))[0];
	if($file_type != 'audio/ogg' || $_FILES['file']['size'] >= $SFXsize * 1024 * 1024 || $_FILES['file']['size'] == 0) exit(json_encode(['success' => false, 'code' => 2, 'error' => 'Invalid file.']));
	move_uploaded_file($_FILES['file']['tmp_name'], $check.'.ogg');
	if(file_exists($check.'_temp.ogg')) unlink($check.'_temp.ogg');
	$song = $server.$check.".ogg";
	$change = $db->prepare('UPDATE sfxs SET token = "", download = :dl WHERE ID = :id');
	if($change->execute([':dl' => $song, ':id' => $check])) exit(json_encode(['success' => true]));
	exit(json_encode(['success' => false, 'code' => 3, 'error' => 'Something went wrong.']));
}
exit(json_encode(['success' => false, 'code' => 0, 'error' => 'Invalid params.']));
?>