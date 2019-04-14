<!DOCTYPE HTML>
<html>
	<head>
		<title>New Map Pack</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";

$ep = new exploitPatch();
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["packName"]) AND !empty($_POST["levels"]) AND !empty($_POST["stars"]) AND !empty($_POST["coins"]) AND !empty($_POST["color"])){
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$packName = $ep->remove($_POST["packName"]);
	$levels = $ep->remove($_POST["levels"]);
	$stars = $ep->remove($_POST["stars"]);
	$coins = $ep->remove($_POST["coins"]);
	$color = $ep->remove($_POST["color"]);
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $userName]);
		if($query->rowCount()==0){
			echo "<p>Account doesn't have moderator access to the server</p><a href=''>Try again</a>";
		}else{
			if(!is_numeric($stars) OR !is_numeric($coins) OR $stars > 10 OR $coins > 2){
				exit("<p>Invalid stars/coins value</p>");
			}
			if(strlen($color) != 6){
				exit("<p>Unknown color value</p>");
			}
			$rgb = hexdec(substr($color,0,2)).
				",".hexdec(substr($color,2,2)).
				",".hexdec(substr($color,4,2));
			$accid = $query->fetchAll()[0]["accountID"];
			$lvlsarray = explode(",", $levels);
			foreach($lvlsarray AS &$level){
				if(!is_numeric($level)){
					exit("<p>$level isn't a number</p>");
				}
				$query = $db->prepare("SELECT levelName FROM levels WHERE levelID=:levelID");	
				$query->execute([':levelID' => $level]);
				if($query->rowCount() == 0){
					exit("<p>Level #$level doesn't exist</p>");
				}
				$levelName = $query->fetchAll()[0]["levelName"];
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
			echo "<p>AccountID: $accid</p>
				<p>Pack Name: $packName</p>
				<p>Levels: $levelstring ($levels)</p>
				<p>Difficulty: $diffname ($diff)</p>
				<p>Stars: $stars</p>
				<p>Coins: $coins</p>
				<p>RGB Color: $rgb</p>";
			$query = $db->prepare("INSERT INTO mappacks     (name, levels, stars, coins, difficulty, rgbcolors)
													VALUES (:name,:levels,:stars,:coins,:difficulty,:rgbcolors)");
			$query->execute([':name' => $packName, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':difficulty' => $diff, ':rgbcolors' => $rgb]);
			$query = $db->prepare("INSERT INTO modactions  (type, value, timestamp, account, value2, value3, value4, value7) 
													VALUES ('11',:value,:timestamp,:account,:levels, :stars, :coins, :rgb)");
			$query->execute([':value' => $packName, ':timestamp' => time(), ':account' => $accid, ':levels' => $levels, ':stars' => $stars, ':coins' => $coins, ':rgb' => $rgb]);
		}
	}else{
		echo "<p>Invalid password or nonexistant account</p><a href=''>Try again</a>";
	}
}else{
	echo '<script src="../incl/jscolor/jscolor.js"></script>
			<form action="" method="post">
				<input class="smain" type="text" placeholder="Username" name="userName"><br>
				<input class="smain" type="password" placeholder="Password" name="password"><br>
				<input class="smain" type="text" placeholder="Pack Name" name="packName"><br>
				<input class="smain" type="text" placeholder="Level IDs (seperated by commas)" name="levels"><br>
				<input class="smain" type="text" placeholder="Stars (max 10)" name="stars"><br>
				<input class="smain" type="text" placeholder="Coins (max 2)" name="coins"><br>
				<input placeholder="Colour" name="color" class="jscolor" value="ffffff"><br>
				<input class="smain" type="submit" value="Create">
			</form>';
}
?>
		</div>
	</body>
</html>