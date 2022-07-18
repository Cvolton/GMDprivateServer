<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["packName"]) AND !empty($_POST["levels"]) AND !empty($_POST["stars"]) AND !empty($_POST["coins"]) AND !empty($_POST["color"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$packName = ExploitPatch::remove($_POST["packName"]);
	$levels = ExploitPatch::remove($_POST["levels"]);
	$stars = ExploitPatch::remove($_POST["stars"]);
	$coins = ExploitPatch::remove($_POST["coins"]);
	$color = preg_replace('/[^0-9A-Fa-f]/', '', $_POST['color']);
	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($gs->checkPermission($accountID, "toolPackcreate") == false){
			echo "This account doesn't have the permissions to access this tool. <a href='packCreate.php'>Try again</a>";
		}else{
			if(!is_numeric($stars) OR !is_numeric($coins) OR $stars > 10 OR $coins > 2){
				exit("Invalid stars/coins value");
			}
			if(strlen($color) != 6){
				exit("Unknown color value");
			}
			$rgb = hexdec(substr($color,0,2)).
				",".hexdec(substr($color,2,2)).
				",".hexdec(substr($color,4,2));
			$lvlsarray = explode(",", $levels);
			foreach($lvlsarray AS &$level){
				if(!is_numeric($level)){
					exit("$level isn't a number");
				}
				$query = $db->prepare("SELECT levelName FROM levels WHERE levelID=:levelID");	
				$query->execute([':levelID' => $level]);
				if($query->rowCount() == 0){
					exit("Level #$level doesn't exist.");
				}
				$levelName = $query->fetchColumn();
				$levelstring .= $levelName . ", ";
			}
			$levelstring = substr($levelstring,0,-2);
			$diff = 0;
			$diffname = "Auto";
			switch($stars){
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
			echo "AccountID: $accountID <br>
				Pack Name: $packName <br>
				Levels: $levelstring ($levels)<br>
				Difficulty: $diffname ($diff)<br>
				Stars: $stars <br>
				Coins: $coins <br>
				RGB Color: $rgb";
			$query = $db->prepare("INSERT INTO mappacks     (name, levels, stars, coins, difficulty, rgbcolors)
													VALUES (:name,:levels,:stars,:coins,:difficulty,:rgbcolors)");
			$query->execute([':name' => $packName, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':difficulty' => $diff, ':rgbcolors' => $rgb]);
			$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3, value4, value7) 
													VALUES ('11',:value,:timestamp,:account,:levels, :stars, :coins, :rgb)");
			$query->execute([':value' => $packName, ':timestamp' => time(), ':account' => $accountID, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':rgb' => $rgb]);
		}
	}else{
		echo "Invalid password or nonexistant account. <a href='packCreate.php'>Try again</a>";
	}
}else{
	echo '<form action="packCreate.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password">
		<br>Pack Name: <input type="text" name="packName">
		<br>Level IDs: <input type="text" name="levels"> (separate by commas)
		<br>Stars: <input type="text" name="stars"> (max 10)
		<br>Coins: <input type="text" name="coins"> (max 2)
		<br>Color: <input type="color" name="color" value="#ffffff">
		<input type="submit" value="Create"></form>';
}
?>
