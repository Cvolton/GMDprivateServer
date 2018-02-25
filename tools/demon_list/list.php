<?php

$url = "https://gdps-dlist.glitch.me/demon-list.txt";

$content = explode("\n", file_get_contents($url));

for ($i = 0; $i < 29; $i++)
{
	echo $content[$i] . "\n";
}

echo $content[29];

?>