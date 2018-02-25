<html><head><title>MacOS Download</title></head><body><h1>STEAM VERIFICATION - MACOS</h1><a href="macOS.php">Retry</a><p>FOR THIS TO WORK YOUR STEAM ACCOUNT NEEDS TO BE PUBLICLY VIEWABLE.</p><p>NO INFORMATION ABOUT YOUR STEAM ACCOUNT IS STORED.</p><p>To download just sign in through a Steam account that owns Geometry Dash (322170).</p><hr>

<?php

require 'include/openid.php';

$_STEAMAPI = "";

try
{
	$openid = new LightOpenID('http://gdps.nettik.co.uk/database/tools/download/macOS.php');
	if (!$openid->mode)
	{
		if (isset($_GET['login']))
		{
			$openid->identity = "http://steamcommunity.com/openid";
			header('Location: '.$openid->authUrl());
		}
		else
		{
			echo "<a href=\"?login\"><img src=\"http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_02.png\"></a>";
		}
	}
	elseif ($openid->mode == 'cancel')
	{
		echo 'Error: Authentication cancelled';
	}
	else
	{
		if ($openid->validate())
		{
			$id = $openid->identity;
			$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
			preg_match($ptn, $id, $matches);
			
			$url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$_STEAMAPI&steamid=$matches[1]&format=json";
			$json_object = file_get_contents($url);
			$decoded = json_decode($json_object, true);
			$games = $decoded['response']['games'];

			$hasgame = false;

			for ($i = 0; $i < count($games); $i++)
			{
				if ($games[$i]['appid'] == 322170) //if owns geometry dash
				{
					$hasgame = true;
					echo 'Success, download will start in 3 seconds.';
					header("refresh:3; url=http://download1502.mediafire.com/k59md3zgliag/sm0swgbw1yxdhy9/1.9+GDPS.dmg");
//					header('Location: http://download1510.mediafire.com/hcxrx1l5m1qg/cr5dahgddwcvcuh/19PS+SETUP+1.5.1.exe');
				}
			}
			
			if (!$hasgame)
			{
				echo 'Error: User has not purchased game';
			}
		}
		else
		{
			echo 'Error: User not logged in';
		}
	}
}
catch (ErrorException $e)
{
	echo 'Error: '.$e->getMessage();
}

?>

</body></html>