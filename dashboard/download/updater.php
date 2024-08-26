<?php
error_reporting(0);
require "../incl/dashboardLib.php";
require "../".$dbPath."config/dashboard.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
if(!isset($_GET["dl"])) {
	$time = filemtime($gdps.".zip");
	$client = filemtime("GDPS-Client.exe");
	exit(json_encode(['success' => true, 'time' => $time, 'client' => $client]));
} else {
	if($_GET["dl"] == "updater") $fileName = $file = "GDPS-Updater.exe";
	elseif($_GET["dl"] == "client") $fileName = $file = "GDPS-Client.exe";
	else $fileName = $file = $gdps.".zip";
	$bufferSize = 2097152;
	$filesize = filesize($file);
	$offset = 0;
	$length = $filesize;
	if (isset($_SERVER['HTTP_RANGE'])) {
		preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
		$offset = intval($matches[1]);
		$end = $matches[2] || $matches[2] === '0' ? intval($matches[2]) : $filesize - 1;
		$length = $end + 1 - $offset;
		header('HTTP/1.1 206 Partial Content');
		header("Content-Range: bytes $offset-$end/$filesize");
	}
	header('Content-Type: ' . mime_content_type($file));
	header("Content-Length: $filesize");
	header("Content-Disposition: attachment; filename=\"$fileName\"");
	header('Accept-Ranges: bytes');

	$file = fopen($file, 'r');
	fseek($file, $offset);
	while ($length >= $bufferSize)
	{
		print(fread($file, $bufferSize));
		$length -= $bufferSize;
	}
	if ($length) print(fread($file, $length));
	fclose($file);
}
?>