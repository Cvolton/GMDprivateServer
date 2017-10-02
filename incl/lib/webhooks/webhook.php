<?php
require 'Client.php';
require 'Embed.php';

function PostToHook($em_title, $em_message)
{
	$token = "TOKEN HERE";
	$enabled = true;
	
	if ($enabled) {
		$webhook = new Client($token);
		$embed = new Embed();

		$embed->title("$em_title");
		$embed->description("$em_message");
		$embed->color(0x5c00a8);

		$webhook->embed($embed)->send();
	}
}
?>