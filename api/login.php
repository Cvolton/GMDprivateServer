<?php

require_once "../incl/lib/auth.php";
include "../incl/lib/connection.php";	

$errors = array('1' => 'invalid username/password',
				'2' => 'could not find user',
				'3' => 'max number of devices reached, logout of at least one device to continue',
				'4' => 'failed to create authentication key');

if (!isset($_POST['username']) || !isset($_POST['password']) || !is_string($_POST['username']) || !is_string($_POST['password']))
{
	exit(json_encode(['success' => false, 'error' => 'invalid parameters']));
}

$result = Auth::make_auth($_POST['username'], $_POST['password']);

if (!is_string($result))
{
	exit(json_encode(['success' => false, 'error' => $errors[(string)$result]]));
}
else
{
	exit(json_encode(['success' => true, 'message' => 'Successfully logged in!', 'authkey' => $result]));
}

?>