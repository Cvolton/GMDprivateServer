<?php

if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off" and false)
{
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

function getname($file)
{
	return str_replace('Mac O S', 'MacOS', str_replace('G D', 'GD', ucfirst(implode(' ', preg_split('/(?=[A-Z,0-25])/', str_replace('.php', '', $file))))));
}

function listdir($dir){
	$dirstring = "";
	$files = scandir($dir);
	foreach($files as $file) {
		if(pathinfo($file, PATHINFO_EXTENSION) == "php" AND $file != "legacyTools.php"){
			$dirstring .= "<li><a href='$dir/$file'>$file</a></li>";
		}
	}
	return $dirstring;
}
echo '<h1>Account Management:</h1>';
echo listdir("account");
echo '<h1>Reuploads, Songs & Sessions:</h1>';
echo listdir(".");
echo "<h1>Update:</h1>";
echo listdir("cron");
echo "<h1>Search, Statistics & Data:</h1>";
echo listdir("stats");
echo "<h1>Moderation:</h1>";
echo listdir("mod");
echo "<h1>Administration:</h1>";
echo listdir("admin");
echo "<h1>Super:</h1>";
echo listdir("super");
?>