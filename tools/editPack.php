<HTML><HEAD><title>Edit Map Packs</title></HEAD><BODY>

<?php

include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require_once "../incl/lib/exploitPatch.php";

$stage = array_key_exists("userName", $_POST) AND array_key_exists("password", $_POST) AND array_key_exists("packName", $_POST);

if ($stage == false)
{
	echo '<form action="editPack.php" method="post">
Username: <input type="text" name="userName"><br>
Password: <input type="password" name="password"><br>
Pack Name: <input type="text" name="packName">
<input type="submit" value="Load">
</form>';
}
else if ($stage AND array_key_exists("levels", $_POST) == false)
{
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($_POST["userName"], $_POST["password"]);
	if ($pass == 1)
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $_POST["userName"]]);
		if($query->rowCount()==0)
		{
			exit("Account isn't mod.");
		}
		
		$query1 = $db->prepare("SELECT * FROM mappacks WHERE name LIKE :name");
		$query1->execute([':name' => $_POST["packName"]]);
		if ($query->rowCount()==0)
		{
			exit("Cannot find map pack, did you enter the name correctly?");
		}
		
		$pack = $query1->fetchAll()[0];
		
		$col = explode(',', $pack["rgbcolors"]);
		$rgb = dechex($col[0]).dechex($col[1]).dechex($col[2]);
		
		echo '<script src="incl/jscolor/jscolor.js"></script>
<form action="editPack.php" method="post">
Username: <input type="text" name="userName" 		value="'.$_POST["userName"].'"><br>
Password: <input type="password" name="password" 	value="'.$_POST["password"].'"><br>
Pack Name: <input type="text" name="packName"		value="'.$_POST["packName"].'"><br>
Level IDs: <input type="text" name="levels"		value="'.$pack["levels"].'"> (separate by commas)<br>
Stars: <input type="text" name="stars"			value="'.$pack["stars"].'"> (max 10)<br>
Coins: <input type="text" name="coins"			value="'.$pack["coins"].'"> (max 2)<br>
Color: <input name="color" class="jscolor" 		value="'.$rgb.'"><br>
<input type="submit" value="Edit">
</form>';
	}
	else
	{
		echo "Incorrect username or password. ";
	}
}
else
{
	$ep = new exploitPatch();
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($_POST["userName"], $_POST["password"]);
	if ($pass == 1)
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $_POST["userName"]]);
		if($query->rowCount()==0)
		{
			exit("Account isn't mod.");
		}
		
		$query1 = $db->prepare("SELECT * FROM mappacks WHERE name LIKE :name");
		$query1->execute([':name' => $_POST["packName"]]);
		if ($query->rowCount()==0)
		{
			exit("Cannot find map pack, did you enter the name correctly?");
		}
		
		$packName = $ep->remove($_POST["packName"]);
		$levels = $ep->remove($_POST["levels"]);
		$stars = $ep->remove($_POST["stars"]);
		$coins = $ep->remove($_POST["coins"]);
		$color = $ep->remove($_POST["color"]);
		
		if(!is_numeric($stars) OR !is_numeric($coins) OR $stars > 10 OR $coins > 2)
		{
			exit("Invalid stars/coins value");
		}
		if(strlen($color) != 6)
		{
			exit("Unknown color value");
		}
		$rgb = hexdec(substr($color,0,2)).",".hexdec(substr($color,2,2)).",".hexdec(substr($color,4,2));
		
		$accid = $query->fetchAll()[0]["accountID"];
		$lvlsarray = explode(",", $levels);
		foreach($lvlsarray AS &$level)
		{
			if(!is_numeric($level))
			{
				exit("$level isn't a number");
			}
			$query = $db->prepare("SELECT levelName FROM levels WHERE levelID=:levelID");	
			$query->execute([':levelID' => $level]);
			if($query->rowCount() == 0)
			{
				exit("Level #$level doesn't exist.");
			}
			$levelName = $query->fetchAll()[0]["levelName"];
			$levelstring .= $levelName . ", ";
		}
		$levelstring = substr($levelstring,0,-2);
		$diff = 0;
		$diffname = "Auto";
		switch($stars)
		{
			case 1:
				$diffname = "Auto";
				$diff = 0;
				break;
			case 2:
				$diffname = "Easy";
				$diff = 1;
				break;
			case 3:
				$diffname = "Normal";
				$diff = 2;
				break;
			case 4:
			case 5:
				$diffname = "Hard";
				$diff = 3;
				break;
			case 6:
			case 7:
				$diffname = "Harder";
				$diff = 4;
				break;
			case 8:
			case 9:
				$diffname = "Insane";
				$diff = 5;
				break;
			case 10:
				$diffname = "Demon";
				$diff = 6;
				break;
		}
		
		$queryFIN = $db->prepare("UPDATE mappacks SET name=:name, levels=:levels, stars=:stars, coins=:coins, difficulty=:difficulty, rgbcolors=:rgbcolors WHERE name LIKE :pName");
		$queryFIN->execute([':name' => $packName, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':difficulty' => $diff, ':rgbcolors' => $rgb, ':pName' => $packName]);
		
		echo "Map Pack edited. ".$queryFIN->rowCount();
		
		$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3, value4, value7) 
													VALUES ('11',:value,:timestamp,:account,:levels, :stars, :coins, :rgb)");
			$query->execute([':value' => $packName, ':timestamp' => time(), ':account' => $accid, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':rgb' => $rgb]);
		
	}
}

?>

</BODY></HTML>