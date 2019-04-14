<?php

require_once "../incl/lib/auth.php";
include "../incl/lib/connection.php";

if (!isset($_POST['authkey']) || !is_string($_POST['authkey']))
{
	exit(json_encode(['success' => false, 'error' => 'invalid parameters']));
}

$result = Auth::make_session($_POST['authkey']);

if (result)
{
	exit(json_encode(['success' => true]));
}
else
{
	exit(json_encode(['success' => false, 'error' => 'authentication failed']));
}

?>