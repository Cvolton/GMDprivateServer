<?php

require_once "../incl/lib/auth.php";
include "../incl/lib/connection.php";

if (!isset($_POST['authkey']) || !isset($_POST['mode']) || !is_string($_POST['authkey']))
{
	exit(json_encode(['success' => false, 'error' => 'invalid parameters']));
}

if ($_POST['mode'] === "single")
{
	$result = Auth::revoke_auth($_POST['authkey']);
	
	if ($result)
		exit(json_encode(['success' => true, 'message' => 'Successfully logged out']));
	else
		exit(json_encode(['success' => true, 'message' => 'Already logged out']));
}
else if ($_POST['mode'] === "all")
{
	$result = Auth::revoke_all_auth($_POST['authkey']);
	
	if ($result)
		exit(json_encode(['success' => true, 'message' => 'Successfully logged out all devices']));
	else
		exit(json_encode(['success' => false, 'error' => 'failed to authenticate']));
}
else exit(json_encode(['success' => false, 'error' => 'invalid mode parameter']));

?>