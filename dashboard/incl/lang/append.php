<?php
$files = scandir(__DIR__);
foreach($files as $file) {
	if($file != "..." AND $file != ".." AND $file != "." AND $file != ".dropbox" AND $file != "" AND $file != "desktop.ini" AND $file != "append.php" AND $file != "append.txt" AND $file != "localeEN.php"){
		$content = file_get_contents(__DIR__ . '/' . $file) . file_get_contents(__DIR__ . "/" . "append.txt");
		file_put_contents(__DIR__ . "/" . $file, $content);
	}
}