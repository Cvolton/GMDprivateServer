<html><head><title>Tools</title><link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'></head><body><style>
body
{
  font-family: "Source Sans Pro", Arial, sans-serif;
  font-weight: 300;
  font-size: 16px;
  line-height: 1.2;
  background: #fff;
  height: 100%;
  position: relative;
}

a:link
{
	transition: all 0.25s;
	color:#0000ff;
}
a:visited
{
	color:#0000aa;
}
a:hover
{
	color: #ff00ff;
}
</style><center><h1>TOOLS</h1><hr><?php

function getname($file)
{
	return str_replace('Mac O S', 'MacOS', str_replace('G D', 'GD', ucfirst(implode(' ', preg_split('/(?=[A-Z,0-25])/', str_replace('.php', '', $file))))));
}

function listdir($dir)
{
	$dirstring = array();
	$files = scandir($dir);
	foreach($files as $file)
	{
		if(pathinfo($file, PATHINFO_EXTENSION) == "php" AND $file != "index.php" AND $file != "list.php")
		{
			array_push($dirstring, "<b><a href='$dir/$file' class=\"link2\">".getname($file)."</a></b>");
		}
	}
	return implode(' - ', $dirstring);
}
echo '<h2>Download:</h2>';
echo listdir("download");
echo '<h2>Account Management:</h2>';
echo listdir("account");
echo '<h2>Moderation, Reuploads, Songs & Sessions:</h2>';
echo listdir(".");
echo "<h2>Update:</h2>";
echo listdir("cron");
echo "<h2>Search, Statistics & Data:</h2>";
echo listdir("stats");
echo "<h2>ADMIN:</h2>";
echo listdir("admin");
?></ul></center></body></html>