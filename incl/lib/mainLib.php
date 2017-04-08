<?php
class mainLib {
	public function getAudioTrack($id) {
		switch($id){
			case 0:
				return "Stereo Madness by ForeverBound";
				break;
			case 1:
				return "Back on Track by DJVI";
				break;
			case 2:
				return "Polargeist by Step";
				break;
			case 3:
				return "Dry Out by DJVI";
				break;
			case 4:
				return "Base after Base by DJVI";
				break;
			case 5:
				return "Can't Let Go by DJVI";
				break;
			case 6:
				return "Jumper by Waterflame";
				break;
			case 7:
				return "Time Machine by Waterflame";
				break;
			case 8:
				return "Cycles by DJVI";
				break;
			case 9:
				return "xStep by DJVI";
				break;
			case 10:
				return "Clutterfunk by Waterflame";
				break;
			case 11:
				return "Theory of Everything by DJ Nate";
				break;
			case 12:
				return "Electroman Adventures by Waterflame";
				break;
			case 13:
				return "Club Step by DJ Nate";
				break;
			case 14:
				return "Electrodynamix by DJ Nate";
				break;
			case 15:
				return "Hexagon Force by Waterflame";
				break;
			case 16:
				return "Blast Processing by Waterflame";
				break;
			case 17:
				return "Theory of Everything 2 by DJ Nate";
				break;
			case 18:
				return "Geometrical Dominator by Waterflame";
				break;
			case 19:
				return "Deadlocked by F-777";
				break;
			case 20:
				return "Fingerbang by MDK";
				break;
			case 21:
				return "The Seven Seas by F-777";
				break;
			case 22:
				return "Viking Arena by F-777";
				break;
			case 23:
				return "Airborne Robots by F-777";
				break;
			case 24:
				return "Secret by RobTopGames";
				break;
			case 25:
				return "Payload by Dex Arson";
				break;
			case 26:
				return "Beast Mode by Dex Arson";
				break;
			case 27:
				return "Machina by Dex Arson";
				break;
			case 28:
				return "Years by Dex Arson";
				break;
			case 29:
				return "Frontlines by Dex Arson";
				break;
			case 30:
				return "Space Pirates by Waterflame";
				break;
			case 31:
				return "Striker by Waterflame";
				break;
			case 32:
				return "Embers by Dex Arson";
				break;
			case 33:
				return "Round 1 by Dex Arson";
				break;
			case 34:
				return "Monster Dance Off by F-777";
				break;
			default:
				return "Unknown by DJVI";
				break;
			
		}
	}
	public function getDifficulty($diff,$auto,$demon) {
		if($auto != 0){
			return "Auto";
		}else if($demon != 0){
			return "Demon";
		}else{
			switch($diff){
				case 0:
					return "N/A";
					break;
				case 10:
					return "Easy";
					break;
				case 20:
					return "Normal";
					break;
				case 30:
					return "Hard";
					break;
				case 40:
					return "Harder";
					break;
				case 50:
					return "Insane";
					break;
				default:
					return "Unknown";
					break;
			}
		}
	}
	public function getDiffFromStars($stars) {
		$auto = 0;
		$demon = 0;
		switch($stars){
			case 1:
				$diffname = "Auto";
				$diff = 50;
				$auto = 1;
				break;
			case 2:
				$diffname = "Easy";
				$diff = 10;
				break;
			case 3:
				$diffname = "Normal";
				$diff = 20;
				break;
			case 4:
			case 5:
				$diffname = "Hard";
				$diff = 30;
				break;
			case 6:
			case 7:
				$diffname = "Harder";
				$diff = 40;
				break;
			case 8:
			case 9:
				$diffname = "Insane";
				$diff = 50;
				break;
			case 10:
				$diffname = "Demon";
				$diff = 50;
				$demon = 1;
				break;
		}
		return array('diff' => $diff, 'auto' => $auto, 'demon' => $demon, 'name' => $diffname);
	}
	public function getLength($length) {
		switch($length){
			case 0:
				return "Tiny";
				break;
			case 1:
				return "Short";
				break;
			case 2:
				return "Medium";
				break;
			case 3:
				return "Long";
				break;
			case 4:
				return "XL";
				break;
			default:
				return "Unknown";
				break;
		}
	}
	public function getGameVersion($version) {
		if($version > 17){
			return $version / 10;
		}else{
			$version--;
			return "1.$version";
		}
	}
	public function getDemonDiff($dmn) {
		switch($dmn){
			case 3:
				return "Easy";
				break;
			case 4:
				return "Medium";
				break;
			case 0:
			case 1:
			case 2:
				return "Hard";
				break;
			case 5:
				return "Insane";
				break;
			case 6:
				return "Extreme";
				break;
		}
	}
	public function getDiffFromName($name) {
		$name = strtolower($name);
		$starAuto = 0;
		$starDemon = 0;
		switch ($name) {
			case "na":
				$starDifficulty = 0;
				break;
			case "easy":
				$starDifficulty = 10;
				break;
			case "normal":
				$starDifficulty = 20;
				break;
			case "hard":
				$starDifficulty = 30;
				break;
			case "harder":
				$starDifficulty = 40;
				break;
			case "insane":
				$starDifficulty = 50;
				break;
			case "auto":
				$starDifficulty = 50;
				$starAuto = 1;
				break;
			case "demon":
				$starDifficulty = 50;
				$starDemon = 1;
				break;
		}
		return array($starDifficulty, $starDemon, $starAuto);
	}
	public function getUserID($extID, $userName = "Undefined") {
		include __DIR__ . "/connection.php";
		if(is_numeric($extID)){
			$register = 1;
		}else{
			$register = 0;
		}
		$query = $db->prepare("SELECT userID FROM users WHERE extID = :id");
		$query->execute([':id' => $extID]);
		if ($query->rowCount() > 0) {
			$userID = $query->fetchAll()[0]["userID"];
		} else {
			$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName)
			VALUES (:register, :id, :userName)");

			$query->execute([':id' => $extID, ':register' => $register, ':userName' => $userName]);
			$userID = $db->lastInsertId();
		}
		return $userID;
	}
}
?>