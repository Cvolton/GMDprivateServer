<?php

$f = $_SERVER['QUERY_STRING'];

if ($f != "1.6.1")
{
	echo "An update is available! Version 1.6.1 comes with a bug-fixed texture pack picker, a seperate extension loader button, light theme, and other minor changes.\nhttp://www.mediafire.com/file/kaj18cbwk5obcwf/1.9+GE+Setup+1.6.1.exe";
}
else
{
	echo 0;
}

?>