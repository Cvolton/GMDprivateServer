<?php
require_once __DIR__ . "/ip_in_range.php";
class mainLib {
	public function getAudioTrack($id) {
		$songs = [
			"Stereo Madness by ForeverBound",
			"Back on Track by DJVI",
			"Polargeist by Step",
			"Dry Out by DJVI",
			"Base after Base by DJVI",
			"Can't Let Go by DJVI",
			"Jumper by Waterflame",
			"Time Machine by Waterflame",
			"Cycles by DJVI",
			"xStep by DJVI",
			"Clutterfunk by Waterflame",
			"Theory of Everything by DJ Nate",
			"Electroman Adventures by Waterflame",
			"Club Step by DJ Nate",
			"Electrodynamix by DJ Nate",
			"Hexagon Force by Waterflame",
			"Blast Processing by Waterflame",
			"Theory of Everything 2 by DJ Nate",
			"Geometrical Dominator by Waterflame",
			"Deadlocked by F-777",
			"Fingerbang by MDK",
			"Dash by MDK",
			"Explorers by Hinkik",
			"The Seven Seas by F-777",
			"Viking Arena by F-777",
			"Airborne Robots by F-777",
			"Secret by RobTopGames",
			"Payload by Dex Arson",
			"Beast Mode by Dex Arson",
			"Machina by Dex Arson",
			"Years by Dex Arson",
			"Frontlines by Dex Arson",
			"Space Pirates by Waterflame",
			"Striker by Waterflame",
			"Embers by Dex Arson",
			"Round 1 by Dex Arson",
			"Monster Dance Off by F-777",
			"Press Start by MDK",
			"Nock Em by Bossfight",
			"Power Trip by Boom Kitty"
		];
		if($id === -1) return "Practice: Stay Inside Me by OcularNebula";
		if($id < 0 || $id >= count($songs)) return "Unknown by DJVI";
		return $songs[$id];
	}
	public function getDifficulty($diff, $auto, $demon, $demonDiff = 1) {
		if($auto != 0) return "Auto";
		if($demon != 0) {
			switch($demonDiff) {
				case 0:
					return 'Hard Demon';
					break;
				case 3:
					return 'Easy Demon';
					break;
				case 4:
					return 'Medium Demon';
					break;
				case 5:
					return 'Insane Demon';
					break;
				case 6:
					return 'Extreme Demon';
					break;
				default:
					return 'Demon';
					break;
			}
		} else {
			switch($diff) {
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
			default:
				$diffname = "N/A";
				$diff = 0;
				$demon = 0;
				break;
		}
		return array('diff' => $diff, 'auto' => $auto, 'demon' => $demon, 'name' => $diffname);
	}
	public function getLevelDiff($levelID) {
		require __DIR__ . "/connection.php";
		$diff = $db->prepare("SELECT starDifficulty FROM levels WHERE levelID = :id");
		$diff->execute([':id' => $levelID]);
		$diff = $diff->fetch();
		$diff = $this->getDifficulty($diff["starDifficulty"], 0, 0);
		return $diff;
	}
	public function getLevelStars($levelID) {
		require __DIR__ . "/connection.php";
		$diff = $db->prepare("SELECT starStars FROM levels WHERE levelID = :id");
		$diff->execute([':id' => $levelID]);
		$diff = $diff->fetch();
		return $diff["starStars"];
	}
	public function getLength($length) {
		switch($length) {
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
			case 5:
				return "Platformer";
				break;
			default:
				return "Unknown";
				break;
		}
	}
	public function getGameVersion($version) {
		switch(true) {
			case $version > 17:
				return $version / 10;
				break;
			case $version == 11:
				return "1.8";
				break;
			case $version == 10:
				return "1.0";
				break;
			default:
				$version--;
				return "1.$version";
				break;
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
			case 5:
				return "Insane";
				break;
			case 6:
				return "Extreme";
				break;
			default:
				return "Hard";
				break;
		}
	}
	public function getDiffFromName($name) {
		$name = strtolower($name);
		$starAuto = 0;
		$starDemon = 0;
		switch ($name) {
			default:
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
	public function getGauntletName($id, $wholeArray = false){
		$gauntlets = ["Unknown", "Fire", "Ice", "Poison", "Shadow", "Lava", "Bonus", "Chaos", "Demon", "Time", "Crystal", "Magic", "Spike", "Monster", "Doom", "Death", 'Forest', 'Rune', 'Force', 'Spooky', 'Dragon', 'Water', 'Haunted', 'Acid', 'Witch', 'Power', 'Potion', 'Snake', 'Toxic', 'Halloween', 'Treasure', 'Ghost', 'Spider', 'Gem', 'Inferno', 'Portal', 'Strange', 'Fantasy', 'Christmas', 'Surprise', 'Mystery', 'Cursed', 'Cyborg', 'Castle', 'Grave', 'Temple', 'World', 'Galaxy', 'Universe', 'Discord', 'Split', 'NCS I', 'NCS II', 'Space', 'Cosmos'];
		if($wholeArray) return $gauntlets;
		if($id < 0 || $id >= count($gauntlets))
			return $gauntlets[0];
		return $gauntlets[$id];
	}
	public function getGauntletCount() {
		return count($this->getGauntletName(0, true))-1;
	}
	public function makeTime($time) {
		require __DIR__ . "/../../config/dashboard.php";
		if(!isset($timeType)) $timeType = 0;
		switch($timeType) {
			case 1:
				if(date("d.m.Y", $time) == date("d.m.Y", time())) return date("G;i", $time);
				elseif(date("Y", $time) == date("Y", time())) return date("d.m", $time);
				else return date("d.m.Y", $time);
				break;
			case 2:
				// taken from https://stackoverflow.com/a/36297417
				$time = time() - $time;
				$time = ($time < 1) ? 1 : $time;
				$tokens = array (31536000 => 'year', 2592000 => 'month', 604800 => 'week', 86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second');
				foreach($tokens as $unit => $text) {
					if($time < $unit) continue;
					$numberOfUnits = floor($time / $unit);
					return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
				}
				break;
			default:
				return date("d/m/Y G.i", $time);
				break;
		}
	}
	public function getIDFromPost() {
		require __DIR__ . "/../../config/security.php";
		require_once __DIR__ . "/exploitPatch.php";
		require_once __DIR__ . "/GJPCheck.php";
		if(!empty($_POST["udid"]) && $unregisteredSubmissions) {
			$id = ExploitPatch::remove($_POST["udid"]);
			if(is_numeric($id)) exit("-1");
		} elseif(!empty($_POST["accountID"]) AND $_POST["accountID"] !="0") $id = GJPCheck::getAccountIDOrDie();
		else exit("-1");
		return $id;
	}
	public function getUserID($extID, $userName = "Undefined") {
		require __DIR__ . "/connection.php";
		if(is_numeric($extID)){
			$register = 1;
		}else{
			$register = 0;
		}
		$query = $db->prepare("SELECT userID FROM users WHERE extID LIKE BINARY :id");
		$query->execute([':id' => $extID]);
		if ($query->rowCount() > 0) {
			$userID = $query->fetchColumn();
		} else {
			$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName, lastPlayed, IP)
			VALUES (:register, :id, :userName, :uploadDate, :IP)");
			$ip = $this->getIP();
			$query->execute([':id' => $extID, ':register' => $register, ':userName' => $userName, ':uploadDate' => time(), ':IP' => $ip]);
			$userID = $db->lastInsertId();
		}
		return $userID;
	}
	public function getAccountName($accountID) {
		require __DIR__ . "/connection.php";
		if(is_numeric($accountID)) {
			$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :id");
			$query->execute([':id' => $accountID]);
			$userName = $query->fetchColumn();
		} else {
			$query = $db->prepare("SELECT userName FROM users WHERE extID = :id");
			$query->execute([':id' => $accountID]);
			$userName = $query->fetchColumn();
		}
		return $userName;
	}
	public function getUserName($userID) {
		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT userName FROM users WHERE userID = :id");
		$query->execute([':id' => $userID]);
		if ($query->rowCount() > 0) {
			$userName = $query->fetchColumn();
		} else {
			$userName = false;
		}
		return $userName;
	}
	public function getAccountIDFromName($userName) {
		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName LIKE :usr");
		$query->execute([':usr' => $userName]);
		if ($query->rowCount() > 0) {
			$accountID = $query->fetchColumn();
		} else {
			$accountID = 0;
		}
		return $accountID;
	}
	public function getExtID($userID) {
		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT extID FROM users WHERE userID = :id");
		$query->execute([':id' => $userID]);
		if ($query->rowCount() > 0) {
			return $query->fetchColumn();
		}else{
			return 0;
		}
	}
	public function getUserString($userdata) {
		$userdata['userName'] = $this->makeClanUsername($userdata);
		$extID = is_numeric($userdata['extID']) ? $userdata['extID'] : 0;
		return "{$userdata['userID']}:{$userdata["userName"]}:{$extID}";
	}
	public function getSongString($song){
		require __DIR__ . "/connection.php";
		require_once __DIR__ . "/exploitPatch.php";
		$librarySong = false;
		$extraSongString = '';
		if(!isset($song['ID'])) {
			$librarySong = true;
			$song = $this->getLibrarySongInfo($song['songID']);
		}
		if(!$song || $song['ID'] == 0 || empty($song['ID']) || $song["isDisabled"] == 1) return false;
		$dl = $song["download"];
		if(strpos($dl, ':') !== false){
			$dl = urlencode($dl);
		}
		if($librarySong) {
			$artistsNames = [];
			$artistsArray = explode('.', $song['artists']);
			if(count($artistsArray) > 0) {
				foreach($artistsArray AS &$artistID) {
					$artistData = $this->getLibrarySongAuthorInfo($artistID);
					if(!$artistData) continue;
					$artistsNames[] = $artistID;
					$artistsNames[] = $artistData['name'];
				}
			}
			$artistsNames = implode(',', $artistsNames);
			$extraSongString = '~|~9~|~'.$song['priorityOrder'].'~|~11~|~'.$song['ncs'].'~|~12~|~'.$song['artists'].'~|~13~|~'.($song['new'] ? 1 : 0).'~|~14~|~'.$song['new'].'~|~15~|~'.$artistsNames;
		}
		return "1~|~".$song["ID"]."~|~2~|~".ExploitPatch::translit(str_replace("#", "", $song["name"]))."~|~3~|~".$song["authorID"]."~|~4~|~".ExploitPatch::translit($song["authorName"])."~|~5~|~".$song["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~1".$extraSongString;
	}
	public function getSongInfo($id, $column = "*", $library = false) {
	    if(!is_numeric($id)) return;
	    require __DIR__ . "/connection.php";
	    $sinfo = $db->prepare("SELECT $column FROM songs WHERE ID = :id");
	    $sinfo->execute([':id' => $id]);
	    $sinfo = $sinfo->fetch();
	    if(empty($sinfo)) {
			$sinfo = $this->getLibrarySongInfo($id, 'music', $library);
			if(!$sinfo) return false;
			else {
				if($column != "*")  return $sinfo[$column];
				else return array("isLocalSong" => false, "ID" => $sinfo["ID"], "name" => $sinfo["name"], "authorName" => $sinfo["authorName"], "size" => $sinfo["size"], "duration" => $sinfo["duration"], "download" => $sinfo["download"], "reuploadTime" => $sinfo["reuploadTime"], "reuploadID" => $sinfo["reuploadID"]);
			}
		} else {
	        if($column != "*")  return $sinfo[$column];
	        else return array("isLocalSong" => true, "ID" => $sinfo["ID"], "name" => $sinfo["name"], "authorName" => $sinfo["authorName"], "size" => $sinfo["size"], "duration" => $sinfo["duration"], "download" => $sinfo["download"], "reuploadTime" => $sinfo["reuploadTime"], "reuploadID" => $sinfo["reuploadID"]);
	    }
	}
	public function getSFXInfo($id, $column = "*") {
	    if(!is_numeric($id)) return;
	    require __DIR__ . "/connection.php";
	    $sinfo = $db->prepare("SELECT $column FROM sfxs WHERE ID = :id");
	    $sinfo->execute([':id' => $id]);
	    $sinfo = $sinfo->fetch();
	    if(empty($sinfo)) return false;
	    else {
	        if($column != "*")  return $sinfo[$column];
	        else return array("ID" => $sinfo["ID"], "name" => $sinfo["name"], "authorName" => $sinfo["authorName"], "size" => $sinfo["size"], "download" => $sinfo["download"], "reuploadTime" => $sinfo["reuploadTime"], "reuploadID" => $sinfo["reuploadID"]);
	    }
	}
	public function getClanInfo($clan, $column = "*") {
	    global $dashCheck;
	    if(!is_numeric($clan) || $dashCheck === 'no') return false;
	    require __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT $column FROM clans WHERE ID = :id");
	    $claninfo->execute([':id' => $clan]);
	    $claninfo = $claninfo->fetch();
	    if(empty($claninfo)) return false;
	    else {
	        if($column != "*") {
	            if($column != "clan" AND $column != "desc" AND $column != "tag") return $claninfo[$column];
	            else return base64_decode($claninfo[$column]);
	        }
	        else return array("ID" => $claninfo["ID"], "clan" => base64_decode($claninfo["clan"]), "tag" => base64_decode($claninfo["tag"]), "desc" => base64_decode($claninfo["desc"]), "clanOwner" => $claninfo["clanOwner"], "color" => $claninfo["color"], "isClosed" => $claninfo["isClosed"], "creationDate" => $claninfo["creationDate"]);
	    }
	}
	public function getClanID($clan) {
		global $dashCheck;
	    if($dashCheck === 'no') return false;
	    require __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT ID FROM clans WHERE clan = :id");
	    $claninfo->execute([':id' => base64_encode($clan)]);
	    $claninfo = $claninfo->fetch();
	    return $claninfo["ID"];
	}
	public function isPlayerInClan($id) {
		global $dashCheck;
	    if(!is_numeric($id) || $dashCheck === 'no') return false;
	    require __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT clan FROM users WHERE extID = :id");
	    $claninfo->execute([':id' => $id]);
	    $claninfo = $claninfo->fetch();
	    if(!empty($claninfo)) return $claninfo["clan"];
	    else return false;
	}
	public function isPendingRequests($clan) {
		global $dashCheck;
	    if(!is_numeric($clan) || $dashCheck === 'no') return false;
		require __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT count(*) FROM clanrequests WHERE clanID = :id");
		$claninfo->execute([':id' => $clan]);
		return $claninfo->fetchColumn();
	}
    public function sendDiscordPM($receiver, $message, $json = false){
		require __DIR__ . "/../../config/discord.php";
		if(!$discordEnabled) {
			return false;
		}
		//findind the channel id
		$data = array("recipient_id" => $receiver);                                                                    
		$data_string = json_encode($data);
		$url = "https://discord.com/api/v8/users/@me/channels";
		//echo $url;
		$crl = curl_init($url);
		$headr = array();
		$headr['User-Agent'] = 'GMDprivateServer (https://github.com/Cvolton/GMDprivateServer, 1.0)';
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($crl, CURLOPT_POSTFIELDS, $data_string);
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bot '.$bottoken;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($crl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$response = curl_exec($crl);
		curl_close($crl);
		$responseDecode = json_decode($response, true);
		$channelID = $responseDecode["id"];
		//sending the msg
		$data = array("content" => $message);                                                                    
		$data_string = json_encode($data);
		$url = "https://discord.com/api/v8/channels/".$channelID."/messages";
		//echo $url;
		$crl = curl_init($url);
		$headr = array();
		$headr['User-Agent'] = 'GMDprivateServer (https://github.com/Cvolton/GMDprivateServer, 1.0)';
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		if(!$json) curl_setopt($crl, CURLOPT_POSTFIELDS, $data_string);
		else curl_setopt($crl, CURLOPT_POSTFIELDS, $message);
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bot '.$bottoken;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($crl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$response = curl_exec($crl);
		curl_close($crl);
		return $response;
	}
	public function getDiscordAcc($discordID){
		require __DIR__ . "/../../config/discord.php";
		///getting discord acc info
		$url = "https://discord.com/api/v8/users/".$discordID;
		$crl = curl_init($url);
		$headr = array();
		$headr['User-Agent'] = 'GMDprivateServer (https://github.com/Cvolton/GMDprivateServer, 1.0)';
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bot '.$bottoken;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($crl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$response = curl_exec($crl);
		curl_close($crl);
		$userinfo = json_decode($response, true);
		//var_dump($userinfo);
		if($userinfo["discriminator"] != "0") $userinfo["discriminator"] = '#'.$userinfo["discriminator"];
		else $userinfo["discriminator"] = '';
		return $userinfo["username"].$userinfo["discriminator"];
	}
	public function getDesc($lid, $dashboard = false) {
		require __DIR__ . "/connection.php";
		require __DIR__ . "/exploitPatch.php";
		$desc = $db->prepare("SELECT levelDesc FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		if(empty($desc["levelDesc"])) return !$dashboard ? '*This level doesn\'t have description*' : '<text style="font-style:italic">This level doesn\'t have description</text>';
		else return ExploitPatch::url_base64_decode($desc["levelDesc"]);
	}
	public function getLevelName($lid) {
		require __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT levelName FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]); 
		$desc = $desc->fetch();
		if(!empty($desc["levelName"])) return $desc["levelName"]; else return false;
	} 
	public function getLevelStats($lid) {
		require __DIR__ . "/connection.php";
		$info = $db->prepare("SELECT downloads, likes, requestedStars FROM levels WHERE levelID = :id");
		$info->execute([':id' => $lid]);
		$info = $info->fetch();
		$likes = $info["likes"]; // - $info["dislikes"];
		if(!empty($info)) return array('dl' => $info["downloads"], 'likes' => $likes, 'req' => $info["requestedStars"]);
	}
	public function getLevelAuthor($lid) {
		require __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		return $desc["extID"];
	}
	public function isRated($lid) {
		require __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT starStars FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		if($desc["starStars"] == 0) return false; 
		else return true;
	} 
	public function hasDiscord($acc) {
		require __DIR__ . "/connection.php";
		$ds = $db->prepare("SELECT discordID, discordLinkReq FROM accounts WHERE accountID = :id");
		$ds->execute([':id' => $acc]); 
		$ds = $ds->fetch();
		if($ds["discordID"] != 0 AND $ds["discordLinkReq"] == 0) return $ds["discordID"];
		else return false;
	}
	public function randomString($length = 6) {
		$randomString = openssl_random_pseudo_bytes($length);
		if($randomString == false){
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		$randomString = bin2hex($randomString);
		return $randomString;
	}
	public function getAccountsWithPermission($permission){
		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT roleID FROM roles WHERE $permission = 1 ORDER BY priority DESC");
		$query->execute();
		$result = $query->fetchAll();
		$accountlist = array();
		foreach($result as &$role){
			$query = $db->prepare("SELECT accountID FROM roleassign WHERE roleID = :roleID");
			$query->execute([':roleID' => $role["roleID"]]);
			$accounts = $query->fetchAll();
			foreach($accounts as &$user){
				$accountlist[] = $user["accountID"];
			}
		}
		return $accountlist;
	}
	public function checkPermission($accountID, $permission){
		if(!is_numeric($accountID)) return false;

		require __DIR__ . "/connection.php";
		//isAdmin check
		$query = $db->prepare("SELECT isAdmin FROM accounts WHERE accountID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$isAdmin = $query->fetchColumn();
		if($isAdmin == 1){
			return 1;
		}
		
		$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$roleIDarray = $query->fetchAll();
		if(empty($roleIDarray)) return false;
		$roleIDlist = "";
		foreach($roleIDarray as &$roleIDobject){
			$roleIDlist .= $roleIDobject["roleID"] . ",";
		}
		$roleIDlist = substr($roleIDlist, 0, -1);
		if($roleIDlist != ""){
			$query = $db->prepare("SELECT $permission FROM roles WHERE roleID IN ($roleIDlist) ORDER BY priority DESC");
			$query->execute();
			$roles = $query->fetchAll();
			foreach($roles as &$role){
				if($role[$permission] == 1){
					return true;
				}
				if($role[$permission] == 2){
					return false;
				}
			}
		}
		$query = $db->prepare("SELECT $permission FROM roles WHERE isDefault = 1");
		$query->execute();
		$permState = $query->fetchColumn();
		if($permState == 1){
			return true;
		}
		if($permState == 2){
			return false;
		}
		return false;
	}
	public function isCloudFlareIP($ip) {
		$cf_ipv4s = array(
			'173.245.48.0/20',
			'103.21.244.0/22',
			'103.22.200.0/22',
			'103.31.4.0/22',
			'141.101.64.0/18',
			'108.162.192.0/18',
			'190.93.240.0/20',
			'188.114.96.0/20',
			'197.234.240.0/22',
			'198.41.128.0/17',
			'162.158.0.0/15',
			'104.16.0.0/13',
			'104.24.0.0/14',
			'172.64.0.0/13',
			'131.0.72.0/22'
	    );
		$cf_ipv6s = array(
			'2400:cb00::/32',
			'2606:4700::/32',
			'2803:f800::/32',
			'2405:b500::/32',
			'2405:8100::/32',
			'2a06:98c0::/29',
			'2c0f:f248::/32'
	    );
	    foreach($cf_ipv4s as $cf_ip) {
	        if(ipInRange::ipv4_in_range($ip, $cf_ip)) return true;
	    }
	    foreach($cf_ipv6s as $cf_ip) {
	        if(ipInRange::ipv6_in_range($ip, $cf_ip)) return true;
	    }
	    return false;
	}
	public function getIP(){
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $this->isCloudFlareIP($_SERVER['REMOTE_ADDR'])) //CLOUDFLARE REVERSE PROXY SUPPORT
  			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ipInRange::ipv4_in_range($_SERVER['REMOTE_ADDR'], '127.0.0.0/8')) //LOCALHOST REVERSE PROXY SUPPORT (7m.pl)
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['REMOTE_ADDR'] == "10.0.1.10") // 141412 PROXY SUPPORT FUCK YOU HESTIA
            		return explode(",", $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // fuck my life
		return $_SERVER['REMOTE_ADDR'];
	}
	public function checkModIPPermission($permission){
		require __DIR__ . "/connection.php";
		$ip = $this->getIP();
		$query=$db->prepare("SELECT modipCategory FROM modips WHERE IP = :ip");
		$query->execute([':ip' => $ip]);
		$categoryID = $query->fetchColumn();
		
		$query=$db->prepare("SELECT $permission FROM modipperms WHERE categoryID = :id");
		$query->execute([':id' => $categoryID]);
		$permState = $query->fetchColumn();
		
		if($permState == 1){
			return true;
		}
		if($permState == 2){
			return false;
		}
		return false;
	}
	public function getFriends($accountID){
		if(!is_numeric($accountID)) return false;

		require __DIR__ . "/connection.php";
		$friendsarray = array();
		$query = "SELECT person1,person2 FROM friendships WHERE person1 = :accountID OR person2 = :accountID"; //selecting friendships
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		$result = $query->fetchAll();//getting friends
		if($query->rowCount() == 0){
			return array();
		}
		else
		{//oh so you actually have some friends kden
			foreach ($result as &$friendship) {
				$person = $friendship["person1"];
				if($friendship["person1"] == $accountID){
					$person = $friendship["person2"];
				}
				$friendsarray[] = $person;
			}
		}
		return $friendsarray;
	}
	public function isFriends($accountID, $targetAccountID) {
		if(!is_numeric($accountID) || !is_numeric($targetAccountID)) return false;

		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT count(*) FROM friendships WHERE person1 = :accountID AND person2 = :targetAccountID OR person1 = :targetAccountID AND person2 = :accountID");
		$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
		return $query->fetchColumn() > 0;
	}
	public function getMaxValuePermission($accountID, $permission){
		if(!is_numeric($accountID)) return false;

		require __DIR__ . "/connection.php";
		$maxvalue = 0;
		$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$roleIDarray = $query->fetchAll();
		$roleIDlist = "";
		foreach($roleIDarray as &$roleIDobject){
			$roleIDlist .= $roleIDobject["roleID"] . ",";
		}
		$roleIDlist = substr($roleIDlist, 0, -1);
		if($roleIDlist != ""){
			$query = $db->prepare("SELECT $permission FROM roles WHERE roleID IN ($roleIDlist) ORDER BY priority DESC");
			$query->execute();
			$roles = $query->fetchAll();
			foreach($roles as &$role){ 
				if($role[$permission] > $maxvalue){
					$maxvalue = $role[$permission];
				}
			}
		}
		return $maxvalue;
	}
	public function getAccountCommentColor($accountID){
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
		$query->execute([':accountID' => $accountID]);
		$roleIDarray = $query->fetchAll();
		$roleIDlist = "";
		foreach($roleIDarray as &$roleIDobject){
			$roleIDlist .= $roleIDobject["roleID"] . ",";
		}
		$roleIDlist = substr($roleIDlist, 0, -1);
		if($roleIDlist != ""){
			$query = $db->prepare("SELECT commentColor FROM roles WHERE roleID IN ($roleIDlist) ORDER BY priority DESC");
			$query->execute();
			$roles = $query->fetchAll();
			foreach($roles as &$role){
				if($role["commentColor"] != "000,000,000"){
					return $role["commentColor"];
				}
			}
		}
		$query = $db->prepare("SELECT commentColor FROM roles WHERE isDefault = 1");
		$query->execute();
		if($query->rowCount() > 0)
			return $query->fetchColumn();
		return "255,255,255";
	}
	public function rateLevel($accountID, $levelID, $stars, $difficulty, $auto, $demon) {
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		require __DIR__ . "/../../config/misc.php";
		require_once __DIR__ . "/cron.php";
		$diffName = $this->getDiffFromStars($stars)["name"];
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':stars' => $stars, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $diffName, ':timestamp' => time(), ':id' => $accountID, ':value2' => $stars, ':levelID' => $levelID]);
		$this->sendRateWebhook($accountID, $levelID);
		if($automaticCron) Cron::updateCreatorPoints($accountID, false);
	}
	public function featureLevel($accountID, $levelID, $state) {
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT starFeatured FROM levels WHERE levelID=:levelID ORDER BY starFeatured DESC LIMIT 1");
		$query->execute([':levelID' => $levelID]);
		$featured = $query->fetchColumn();
		if(!$featured) {
			$query = $db->prepare("SELECT starFeatured FROM levels ORDER BY starFeatured DESC LIMIT 1");
			$query->execute();
			$featured = $query->fetchColumn() + 1;
		}
		switch($state) {
			case 0:
				$feature = 0;
				$epic = 0;
				break;
			case 1:
			case 2:
			case 3:
			case 4:
				$feature = $featured;
				$epic = $state - 1;
				break;
		}
		$query = $db->prepare("UPDATE levels SET starFeatured = :feature, starEpic = :epic, rateDate = :now WHERE levelID = :levelID");
		$query->execute([':feature' => $feature, ':epic' => $epic, ':levelID' => $levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $state, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
	public function verifyCoinsLevel($accountID, $levelID, $coins) {
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starCoins=:coins WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':coins' => $coins, ':levelID'=>$levelID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $coins, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
	public function songReupload($url, $author, $name, $accountID) {
		require __DIR__ . "/../../incl/lib/connection.php";
		require_once __DIR__ . "/../../incl/lib/exploitPatch.php";
		$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$url);
		if(filter_var($song, FILTER_VALIDATE_URL) == TRUE && substr($song, 0, 4) == "http") {
			$song = str_replace(["?dl=0","?dl=1"],"",$song);
			$song = trim($song);
			$query = $db->prepare("SELECT ID FROM songs WHERE download = :download");
			$query->execute([':download' => $song]);	
			$count = $query->fetch();
			if(!empty($count)){
				return "-3".$count["ID"];
			}
			$freeID = false;
			while(!$freeID) {
				$db_fid = rand(99, 7999999);
				$checkID = $db->prepare('SELECT count(*) FROM songs WHERE ID = :id'); // If randomized ID picks existing song ID
				$checkID->execute([':id' => $db_fid]);
				if($checkID->fetchColumn() == 0) $freeID = true;
			}
			if(empty($name)) $name = ExploitPatch::remove(urldecode(str_replace([".mp3",".webm",".mp4",".wav"], "", basename($song))));
			if(empty($author)) $author = "Reupload";
			$info = $this->getFileInfo($song);
			$size = round($info['size'] / 1024 / 1024, 2);
			if(substr($info['type'], 0, 6) != "audio/" || $size == 0 || $size == '-0') return "-4";
			$hash = "";
			$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, download, hash, reuploadTime, reuploadID)
			VALUES (:songID, :name, '9', :author, :size, :download, :hash, :time, :accountID)");
			$query->execute([':songID' => $db_fid, ':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash, ':time' => time(), ':accountID' => $accountID]);
			return $db_fid;
		} else {
			return "-2";
		}
	}
	public function getFileInfo($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		//curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		$data = curl_exec($ch);
		$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		$mime = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		//$status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		curl_close($ch);
		return ['size' => $size, 'type' => $mime];
	}
	public function suggestLevel($accountID, $levelID, $difficulty, $stars, $feat, $auto, $demon) {
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare("INSERT INTO suggest (suggestBy, suggestLevelID, suggestDifficulty, suggestStars, suggestFeatured, suggestAuto, suggestDemon, timestamp) VALUES (:account, :level, :diff, :stars, :feat, :auto, :demon, :timestamp)");
		$query->execute([':account' => $accountID, ':level' => $levelID, ':diff' => $difficulty, ':stars' => $stars, ':feat' => $feat, ':auto' => $auto, ':demon' => $demon, ':timestamp' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, account, timestamp) VALUES ('41', :value, :value3, :id, :timestamp)");
		$query->execute([':value' => $stars, ':value3' => $levelID, ':id' => $accountID, ':timestamp' => time()]);
		$this->sendSuggestWebhook($accountID, $levelID, $difficulty, $stars, $feat, $auto, $demon);
	}
	public function removeSuggestedLevel($accountID, $levelID) {
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare("DELETE FROM suggest WHERE suggestLevelId = :levelID");
		$query->execute([':levelID' => $levelID]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('40', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => "1", ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
 	public function isUnlisted($levelID) {
        require __DIR__."/connection.php";
        $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted > 0 AND levelID = :id");
        $query->execute([':id' => $levelID]);
        $query = $query->fetch();
        if(!empty($query)) return true; 
        else return false;
	}
	public function getListOwner($listID) {
		if(!is_numeric($listID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare('SELECT accountID FROM lists WHERE listID = :id');
		$query->execute([':id' => $listID]);
		return $query->fetchColumn();
	}
	public function getListLevels($listID) {
		if(!is_numeric($listID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare('SELECT listlevels FROM lists WHERE listID = :id');
		$query->execute([':id' => $listID]);
		return $query->fetchColumn();
	}
	public function getListDiffName($diff) {
		$diffs = ['Auto', 'Easy', 'Normal', 'Hard', 'Harder', 'Extreme', 'Easy Demon', 'Medium Demon', 'Hard Demon', 'Insane Demon', 'Extreme Demon'];
		if($diff == -1 || $diff >= count($diffs)) return 'N/A';
		return $diffs[$diff];
	}
	public function getListName($listID) {
		if(!is_numeric($listID)) return false;
		require __DIR__ . "/connection.php";
		$query = $db->prepare('SELECT listName FROM lists WHERE listID = :id');
		$query->execute([':id' => $listID]);
		return $query->fetchColumn();
	}
	public function makeClanUsername($user) {
		require __DIR__ . "/../../config/dashboard.php";
		if($clansEnabled && $user['clan'] > 0 && !isset($_REQUEST['noClan'])) {
			$clan = $this->getClanInfo($user['clan'], 'tag');
			if(!empty($clan)) return '['.$clan.'] '.$user['userName'];
		}
		return $user['userName'];
	}
	public function updateLibraries($token, $expires, $mainServerTime, $type = 0) {
		require __DIR__ . "/../../config/dashboard.php";
		$servers = [];
		$types = ['sfx', 'music'];
		if(!isset($customLibrary)) $customLibrary = [[1, 'Geometry Dash', 'https://geometrydashfiles.b-cdn.net'], [3, $gdps, null]]; 
		foreach($customLibrary AS $library) {
			if(($types[$type] == 'sfx' AND $library[3] === 1) OR ($types[$type] == 'music' AND $library[3] === 0)) continue;
			if($library[2] !== null) {
				$servers['s'.$library[0]] = $library[2];
			}
		}
		$updatedLib = false;
		foreach($servers AS $key => &$server) {
			if($types[$type] == 'music') {
			    $versionUrl = $server.'/'.$types[$type].'/'.$types[$type].'library_version_02.txt';
			    $dataUrl = $server.'/'.$types[$type].'/'.$types[$type].'library_02.dat';
			} else {
			    $versionUrl = $server.'/'.$types[$type].'/'.$types[$type].'library_version.txt';
			    $dataUrl = $server.'/'.$types[$type].'/'.$types[$type].'library.dat';
			}
			if(file_exists(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt')) $oldVersion = explode(', ', file_get_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt'));
			else $oldVersion = [0, 0];
			if($oldVersion[1] + 600 > time()) continue; // Download library only once per 10 minutes
			$curl = curl_init($versionUrl.'?token='.$token.'&expires='.$expires);
			curl_setopt_array($curl, [
				CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_FOLLOWLOCATION => 1
			]);
			$newVersion = (int)curl_exec($curl);
			curl_close($curl);
			if($newVersion > $oldVersion[0]) {
				file_put_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt', $newVersion.', '.time());
				$download = curl_init($dataUrl.'?token='.$token.'&expires='.$expires.'&dashboard=1');
				curl_setopt_array($download, [
					CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_FOLLOWLOCATION => 1
				]);
				$dat = curl_exec($download);
				$resultStatus = curl_getinfo($download, CURLINFO_HTTP_CODE);
				curl_close($download);
				if($resultStatus == 200) {
					file_put_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat', $dat);
					$updatedLib = true;
				}
			}
		}
		// Now this server's version check
		if(file_exists(__DIR__.'/../../'.$types[$type].'/gdps.txt')) $oldVersion = file_get_contents(__DIR__.'/../../'.$types[$type].'/gdps.txt');
		else {
			$oldVersion = 0;
			file_put_contents(__DIR__.'/../../'.$types[$type].'/gdps.txt', $mainServerTime);
		}
		if($oldVersion < $mainServerTime || $updatedLib) $this->generateDATFile($mainServerTime, $type);
	}
	public function generateDATFile($mainServerTime, $type = 0) {
		require __DIR__ . "/connection.php";
		require __DIR__ . "/exploitPatch.php";
		require __DIR__ . "/../../config/dashboard.php";
		$library = $servers = $serverIDs = $serverTypes = [];
		if(!isset($customLibrary)) $customLibrary = [[1, 'Geometry Dash', 'https://geometrydashfiles.b-cdn.net', 2], [3, $gdps, null, 2]]; 
		$types = ['sfx', 'music'];
		foreach($customLibrary AS $customLib) {
			if($customLib[2] !== null) {
				$servers['s'.$customLib[0]] = $customLib[0];
			}
			$serverIDs[$customLib[2]] = $customLib[0];
			if($types[$type] == 'sfx') {
				$library['folders'][($customLib[0] + 1)] = [
					'name' => ExploitPatch::escapedat($customLib[1]),
					'type' => 1,
					'parent' => 1
				];
			} else {
				$library['tags'][$customLib[0]] = [
					'ID' => $customLib[0],
					'name' => ExploitPatch::escapedat($customLib[1]),
				];
			}
		}
		if(file_exists(__DIR__.'/../../'.$types[$type].'/ids.json')) $idsConverter = json_decode(file_get_contents(__DIR__.'/../../'.$types[$type].'/ids.json'), true);
		else $idsConverter = ['count' => ($type == 0 ? count($customLibrary) + 2 : 8000000), 'IDs' => [], 'originalIDs' => []];
		if(file_exists(__DIR__.'/../../config/skipSFXIDs.json')) $skipSFXIDs = json_decode(file_get_contents(__DIR__.'/../../config/skipSFXIDs.json'), true);
		else $skipSFXIDs = [];
		foreach($servers AS $key => $server) {
			if(!file_exists(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat')) continue;
			$res = null;
			$bits = null;
			$res = file_get_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat');
			$res = mb_convert_encoding($res, 'UTF-8', 'UTF-8');
			try {
				$res = ExploitPatch::url_base64_decode($res);
				$res = zlib_decode($res);
			} catch(Exception $e) {
				unlink(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat');
				continue;
			}
			$res = explode('|', $res);
			if(!$type) {
				for($i = 0; $i < count($res); $i++) { // SFX library decoding was made by MigMatos, check their ObeyGDBot! https://obeybd.web.app/
					$res[$i] = explode(';', $res[$i]);
					if($i === 0) {
						$library['version'] = $mainServerTime;
						$version = explode(',', $res[0][0]);
						$version[1] = $mainServerTime;
						$version = implode(',', $version);
					}
					for($j = 1; $j <= count($res[$i]); $j++) {
						$bits = explode(',', $res[$i][$j]);
						switch($i) {
							case 0: // File/Folder
								if(empty(trim($bits[1])) || empty($bits[0]) || !is_numeric($bits[0])) break;
								if(empty($idsConverter['originalIDs'][$server][$bits[0]])) {
									$idsConverter['count']++;
									while(in_array($idsConverter['count'], $skipSFXIDs)) $idsConverter['count']++;
									$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $bits[0], 'name' => $bits[1], 'type' => $bits[2]];
									$idsConverter['originalIDs'][$server][$bits[0]] = $idsConverter['count'];
									$bits[0] = $idsConverter['count'];
								} else {
									$bits[0] = $idsConverter['originalIDs'][$server][$bits[0]];
									if(!isset($idsConverter['IDs'][$bits[0]]['name'])) $idsConverter['IDs'][$bits[0]] = ['server' => $server, 'ID' => $bits[0], 'name' => $bits[1], 'type' => $bits[2]];
								}
								if($bits[3] != 1) {
									if(empty($idsConverter['originalIDs'][$server][$bits[3]])) {
										$idsConverter['count']++;
										while(in_array($idsConverter['count'], $skipSFXIDs)) $idsConverter['count']++;
										$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $bits[3], 'name' => $bits[1], 'type' => 1];
										$idsConverter['originalIDs'][$server][$bits[3]] = $idsConverter['count'];
										$bits[3] = $idsConverter['count'];
									} else $bits[3] = $idsConverter['originalIDs'][$server][$bits[3]];
								} else $bits[3] = $server + 1;
								if($bits[2]) {
									$library['folders'][$bits[0]] = [
										'name' => ExploitPatch::escapedat($bits[1]),
										'type' => (int)$bits[2],
										'parent' => (int)$bits[3]
									];
								} else {
									$library['files'][$bits[0]] = [
										'name' => ExploitPatch::escapedat($bits[1]),
										'type' => (int)$bits[2],
										'parent' => (int)$bits[3],
										'bytes' => (int)$bits[4],
										'milliseconds' => (int)$bits[5],
									];
								}
								break;
							case 1: // Credit
								if(empty(trim($bits[0])) || empty(trim($bits[1]))) continue 2;
								$library['credits'][ExploitPatch::escapedat($bits[0])] = [
									'name' => ExploitPatch::escapedat($bits[0]),
									'website' => ExploitPatch::escapedat($bits[1]),
								];
								break;
						}
					}
				}
			} else {
				$version = $mainServerTime;
				array_shift($res);
				$x = 0;
				foreach($res AS &$data) {
					$data = rtrim($data, ';');
					$music = explode(';', $data);
					foreach($music AS &$songString) {
						$song = explode(',', $songString);
						$originalID = $song[0];
						if(empty($song[0]) || !is_numeric($song[0])) continue;
						if(empty($idsConverter['originalIDs'][$server][$song[0]])) {
							$idsConverter['count']++;
							$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $song[0], 'type' => $x];
							$idsConverter['originalIDs'][$server][$song[0]] = $idsConverter['count'];
							$song[0] = $idsConverter['count'];
						} else $song[0] = $idsConverter['originalIDs'][$server][$song[0]];
						switch($x) {
							case 0:
								$idsConverter['IDs'][$song[0]] = $library['authors'][$song[0]] = [
									'server' => $server,
									'type' => $x,
									'originalID' => $originalID,
									'authorID' => $song[0],
									'name' => ExploitPatch::escapedat($song[1]),
									'link' => ExploitPatch::escapedat($song[2]),
									'yt' => ExploitPatch::escapedat($song[3])
								];
								break;
							case 1:
								if(empty($idsConverter['originalIDs'][$server][$song[2]])) {
									$idsConverter['count']++;
									$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $song[2], 'type' => $x];
									$idsConverter['originalIDs'][$server][$song[2]] = $idsConverter['count'];
									$song[2] = $idsConverter['count'];
								} else $song[2] = $idsConverter['originalIDs'][$server][$song[2]];
								$tags = explode('.', $song[5]);
								$newTags = [];
								foreach($tags AS &$tag) {
									if(empty($tag)) continue;
									if(empty($idsConverter['originalIDs'][$server][$tag])) {
										$idsConverter['count']++;
										$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $tag, 'type' => 2];
										$idsConverter['originalIDs'][$server][$tag] = $idsConverter['count'];
										$tag = $idsConverter['count'];
									} else $tag = $idsConverter['originalIDs'][$server][$tag];
									$newTags[] = $tag;
								}
								$newTags[] = $server;
								$tags = '.'.implode('.', $newTags).'.';
								$newArtists = [];
								$artists = explode('.', $song[7]);
								foreach($artists AS &$artist) {
									if(empty($artist)) continue;
									if(empty($idsConverter['originalIDs'][$server][$artist])) {
										$idsConverter['count']++;
										$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $artist, 'type' => 0];
										$idsConverter['originalIDs'][$server][$artist] = $idsConverter['count'];
										$artist = $idsConverter['count'];
									} else $artist = $idsConverter['originalIDs'][$server][$artist];
									$newArtists[] = $artist;
								}
								$artists = implode('.', $newArtists);
								$idsConverter['IDs'][$song[0]] = $library['songs'][$song[0]] = [
									'server' => $server,
									'type' => $x,
									'originalID' => $originalID,
									'ID' => $song[0],
									'name' => ExploitPatch::escapedat($song[1]),
									'authorID' => $song[2],
									'size' => $song[3],
									'seconds' => $song[4],
									'tags' => $tags,
									'ncs' => $song[6] ?: 0,
									'artists' => $artists,
									'externalLink' => $song[8] ?: '',
									'new' => $song[9] ?: 0,
									'priorityOrder' => $song[10] ?: 0
								];
								break;
							case 2:
								$idsConverter['IDs'][$song[0]] = $library['tags'][$song[0]] = [
									'server' => $server,
									'type' => $x,
									'originalID' => $originalID,
									'ID' => $song[0],
									'name' => ExploitPatch::escapedat($song[1])
								];
								break;
						}
					}
					$x++;
				}
			}
		}
		if(!$type) {
			$sfxs = $db->prepare("SELECT sfxs.*, accounts.userName FROM sfxs JOIN accounts ON accounts.accountID = sfxs.reuploadID");
			$sfxs->execute();
			$sfxs = $sfxs->fetchAll();
			$folderID = $gdpsLibrary = [];
			$server = $serverIDs[null];
			foreach($sfxs AS &$customSFX) {
				if(!isset($folderID[$customSFX['reuploadID']])) {
					if(empty($idsConverter['originalIDs'][$server][$customSFX['reuploadID']])) {
						$idsConverter['count']++;
						$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $customSFX['ID'], 'name' => $customSFX['userName'].'\'s SFXs', 'type' => 1];
						$idsConverter['originalIDs'][$server][$customSFX['reuploadID']] = $idsConverter['count'];
						$newID = $idsConverter['count'];
					} else $newID = $idsConverter['originalIDs'][$server][$customSFX['reuploadID']];
					$library['folders'][$newID] = [
						'name' => ExploitPatch::escapedat($customSFX['userName']).'\'s SFXs',
						'type' => 1,
						'parent' => (int)($server + 1)
					];
					$gdpsLibrary['folders'][$newID] = [
						'name' => ExploitPatch::escapedat($customSFX['userName']).'\'s SFXs',
						'type' => 1,
						'parent' => 1
					];
					$folderID[$customSFX['reuploadID']] = true;
				}
				if(empty($idsConverter['originalIDs'][$server][$customSFX['ID'] + 8000000])) {
					$idsConverter['count']++;
					$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $customSFX['ID'], 'name' => $customSFX['name'], 'type' => 0];
					$idsConverter['originalIDs'][$server][$customSFX['ID'] + 8000000] = $idsConverter['count'];
					$customSFX['ID'] = $idsConverter['count'];
				} else $customSFX['ID'] = $idsConverter['originalIDs'][$server][$customSFX['ID'] + 8000000];
				$library['files'][$customSFX['ID']] = $gdpsLibrary['files'][$customSFX['ID']] = [
					'name' => ExploitPatch::escapedat($customSFX['name']),
					'type' => 0,
					'parent' => (int)$idsConverter['originalIDs'][$server][$customSFX['reuploadID']],
					'bytes' => (int)$customSFX['size'],
					'milliseconds' => (int)($customSFX['milliseconds'] / 10)
				];
			}
			$filesEncrypted = $creditsEncrypted = [];
			foreach($library['folders'] AS $id => &$folder) $filesEncrypted[] = implode(',', [$id, $folder['name'], 1, $folder['parent'], 0, 0]);
			foreach($library['files'] AS $id => &$file) $filesEncrypted[] = implode(',', [$id, $file['name'], 0, $file['parent'], $file['bytes'], $file['milliseconds']]);
			foreach($library['credits'] AS &$credit) $creditsEncrypted[] = implode(',', [$credit['name'], $credit['website']]);
			$encrypted = $version.";".implode(';', $filesEncrypted)."|" .implode(';', $creditsEncrypted).';';
			$filesEncrypted = $creditsEncrypted = [];
			foreach($gdpsLibrary['folders'] AS $id => &$folder) $filesEncrypted[] = implode(',', [$id, $folder['name'], 1, $folder['parent'], 0, 0]);
			foreach($gdpsLibrary['files'] AS $id => &$file) $filesEncrypted[] = implode(',', [$id, $file['name'], 0, $file['parent'], $file['bytes'], $file['milliseconds']]);
			$creditsEncrypted[] = implode(',', [$gdps, $_SERVER['SERVER_NAME']]);
			$gdpsEncrypted = $version.";".implode(';', $filesEncrypted)."|" .implode(';', $creditsEncrypted).';';
		} else {
			$songs = $db->prepare("SELECT songs.*, accounts.userName FROM songs JOIN accounts ON accounts.accountID = songs.reuploadID WHERE isDisabled = 0");
			$songs->execute();
			$songs = $songs->fetchAll();
			$folderID = $accIDs = $gdpsLibrary = [];
			$c = 100;
			foreach($songs AS &$customSongs) {
				$c++;
				$authorName = trim(ExploitPatch::rucharclean(ExploitPatch::escapedat(ExploitPatch::translit($customSongs['authorName'])), 40));
				if(empty($authorName)) $authorName = 'Reupload';
				if(empty($folderID[$authorName])) {
					$folderID[$authorName] = $c;
					$library['authors'][$serverIDs[null]. 0 .$folderID[$authorName]] = $gdpsLibrary['authors'][$serverIDs[null]. 0 .$folderID[$authorName]] = [
						'authorID' => (int)($serverIDs[null]. 0 .$folderID[$authorName]),
						'name' => $authorName,
						'link' => ' ',
						'yt' => ' '
					];
				}
				if(empty($accIDs[$customSongs['reuploadID']])) {
					$c++;
					$accIDs[$customSongs['reuploadID']] = $c;
					$library['tags'][$serverIDs[null]. 0 .$accIDs[$customSongs['reuploadID']]] = $gdpsLibrary['tags'][$serverIDs[null]. 0 .$accIDs[$customSongs['reuploadID']]] = [
						'ID' => (int)($serverIDs[null]. 0 .$accIDs[$customSongs['reuploadID']]),
						'name' => ExploitPatch::rucharclean(ExploitPatch::escapedat($customSongs['userName']), 30),
					];
				}
				$customSongs['name'] = trim(ExploitPatch::rucharclean(ExploitPatch::escapedat(ExploitPatch::translit($customSongs['name'])), 40));
				$library['songs'][$customSongs['ID']] = $gdpsLibrary['songs'][$customSongs['ID']] = [
					'ID' => ($customSongs['ID']),
					'name' => !empty($customSongs['name']) ? $customSongs['name'] : 'Unnamed',
					'authorID' => (int)($serverIDs[null]. 0 .$folderID[$authorName]),
					'size' => $customSongs['size'] * 1024 * 1024,
					'seconds' => $customSongs['duration'],
					'tags' => '.'.$serverIDs[null].'.'.$serverIDs[null]. 0 .$accIDs[$customSongs['reuploadID']].'.',
					'ncs' => 0,
					'artists' => '',
					'externalLink' => urlencode($customSongs['download']),
					'new' => ($customSongs['reuploadTime'] > time() - 604800 ? 1 : 0),
					'priorityOrder' => 0
				];
			}
			$authorsEncrypted = $songsEncrypted = $tagsEncrypted = [];
			foreach($library['authors'] AS &$authorList) {
				unset($authorList['server']);
				unset($authorList['type']);
				unset($authorList['originalID']);
				$authorsEncrypted[] = implode(',', $authorList);
			}
			foreach($library['songs'] AS &$songsList) {
				unset($songsList['server']);
				unset($songsList['type']);
				unset($songsList['originalID']);
				$songsEncrypted[] = implode(',', $songsList);
			}
			foreach($library['tags'] AS &$tagsList) {
				unset($tagsList['server']);
				unset($tagsList['type']);
				unset($tagsList['originalID']);
				$tagsEncrypted[] = implode(',', $tagsList);
			}
			$encrypted = $version."|".implode(';', $authorsEncrypted).";|" .implode(';', $songsEncrypted).";|" .implode(';', $tagsEncrypted).';';
			$authorsEncrypted = $songsEncrypted = $tagsEncrypted = [];
			foreach($gdpsLibrary['authors'] AS &$authorList) {
				unset($authorList['server']);
				unset($authorList['type']);
				unset($authorList['originalID']);
				$authorsEncrypted[] = implode(',', $authorList);
			}
			foreach($gdpsLibrary['songs'] AS &$songsList) {
				unset($songsList['server']);
				unset($songsList['type']);
				unset($songsList['originalID']);
				$songsEncrypted[] = implode(',', $songsList);
			}
			foreach($gdpsLibrary['tags'] AS &$tagsList) {
				unset($tagsList['server']);
				unset($tagsList['type']);
				unset($tagsList['originalID']);
				$tagsEncrypted[] = implode(',', $tagsList);
			}
			$gdpsEncrypted = $version."|".implode(';', $authorsEncrypted).";|" .implode(';', $songsEncrypted).";|" .implode(';', $tagsEncrypted).';';
		}
		file_put_contents(__DIR__.'/../../'.$types[$type].'/ids.json', json_encode($idsConverter, JSON_PRETTY_PRINT | JSON_INVALID_UTF8_IGNORE));
		$encrypted = zlib_encode($encrypted, ZLIB_ENCODING_DEFLATE);
		$encrypted = ExploitPatch::url_base64_encode($encrypted);
		file_put_contents(__DIR__.'/../../'.$types[$type].'/gdps.dat', $encrypted);
		$gdpsEncrypted = zlib_encode($gdpsEncrypted, ZLIB_ENCODING_DEFLATE);
		$gdpsEncrypted = ExploitPatch::url_base64_encode($gdpsEncrypted);
		file_put_contents(__DIR__.'/../../'.$types[$type].'/standalone.dat', $gdpsEncrypted);
	}
	public function getAudioDuration($file) {
		require_once(__DIR__.'/../../config/getid3/getid3.php');
		$getID3 = new getID3;
		$info = $getID3->analyze($file);
		$result = (isset($info['playtime_seconds']) ? (int)($info['playtime_seconds']) : false);
		return $result;
	}
	public function convertSFX($file, $server, $name, $token) {
		require __DIR__."/../../config/dashboard.php";
		if(!$convertEnabled) return false;
		$link = $convertSFXAPI[rand(0, count($convertSFXAPI) - 1)];
		$filePath = $file['tmp_name'];
		$type = $file['type'];
		$post = [
			'name' => $name,
			'token' => $token,
			'server' => $server,
			'file' => new CURLFile(realpath($filePath), $type, $filePath)
		];
		$curl = curl_init($link.'/convert');
		curl_setopt_array($curl, [
			CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $post
		]);
		$response = json_decode(curl_exec($curl), true);
		$result = isset($response['success']) ? $response['success'] : false;
		return $result;
	}
	public function getLibrarySongInfo($id, $type = 'music', $extraLibrary = false) {
		require __DIR__."/../../config/dashboard.php";
		if(!file_exists(__DIR__.'/../../'.$type.'/ids.json')) return false;
		$servers = $serverIDs = $serverNames = [];
		foreach($customLibrary AS $customLib) {
			$servers[$customLib[0]] = $customLib[2];
			$serverNames[$customLib[0]] = $customLib[1];
			$serverIDs[$customLib[2]] = $customLib[0];
		}
		$library = $extraLibrary ? $extraLibrary : json_decode(file_get_contents(__DIR__.'/../../'.$type.'/ids.json'), true);
		if(!isset($library['IDs'][$id]) || ($type == 'music' && $library['IDs'][$id]['type'] != 1)) return false;
		if($type == 'music') {
			$song = $library['IDs'][$id];
			$author = $library['IDs'][$song['authorID']];
			$token = $this->randomString(11);
			$expires = time() + 3600;
			$link = $servers[$song['server']].'/music/'.$song['originalID'].'.ogg?token='.$token.'&expires='.$expires;
			return ['server' => $song['server'], 'ID' => $id, 'name' => $song['name'], 'authorID' => $song['authorID'], 'authorName' => $author['name'], 'size' => round($song['size'] / 1024 / 1024, 2), 'download' => $link, 'seconds' => $song['seconds'], 'tags' => $song['tags'], 'ncs' => $song['ncs'], 'artists' => $song['artists'], 'externalLink' => $song['externalLink'], 'new' => $song['new'], 'priorityOrder' => $song['priorityOrder']];
		} else {
			$SFX = $library['IDs'][$id];
			$token = $this->randomString(11);
			$expires = time() + 3600;
			$link = $servers[$SFX['server']] != null ? $servers[$SFX['server']].'/sfx/s'.$SFX['ID'].'.ogg?token='.$token.'&expires='.$expires : $this->getSFXInfo($SFX['ID'], 'download');
			return ['isLocalSFX' => $servers[$SFX['server']] == null, 'server' => $SFX['server'], 'ID' => $id, 'name' => $song['name'], 'download' => $link, 'originalID' => $SFX['ID']];
		}
	}
	public function getLibrarySongAuthorInfo($id) {
		require __DIR__."/../../config/dashboard.php";
		if(!file_exists(__DIR__.'/../../music/ids.json')) return false;
		$library = json_decode(file_get_contents(__DIR__.'/../../music/ids.json'), true);
		if(!isset($library['IDs'][$id])) return false;
		return $library['IDs'][$id];
	}
	public function sendRateWebhook($modAccID, $levelID) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require_once __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($levelID) OR !in_array("rate", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($rateWebhook);
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
		$level->execute([':levelID' => $levelID]);
		$level = $level->fetch();
		if(!$level) return false;
		$modUsername = $this->getAccountName($modAccID);
		$modHasDiscord = $this->hasDiscord($modAccID);
		$modFormattedUsername = $modHasDiscord ? "<@".$modHasDiscord.">" : "**".$modUsername."**";
		$creatorAccID = $level['extID'];
		$creatorUsername = $this->getAccountName($creatorAccID);
		$creatorHasDiscord = $this->hasDiscord($creatorAccID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
        $isRated = $level['starStars'] != 0;
        $difficulty = $this->getDifficulty($level['starDifficulty'], $level['starAuto'], $level['starDemon'], $level['starDemonDiff']);
        $starsIcon = 'stars';
        $diffIcon = 'na';
        switch(true) {
            case ($level['starEpic'] > 0):
                $starsArray = ['', 'epic', 'legendary', 'mythic'];
                $starsIcon = $starsArray[$level['starEpic']];
                break;
            case ($level['starFeatured'] > 0):
                $starsIcon = 'featured';
                break;
        }
        $diffArray = ['n/a' => 'na', 'auto' => 'auto', 'easy' => 'easy', 'normal' => 'normal', 'hard' => 'hard', 'harder' => 'harder', 'insane' => 'insane', 'demon' => 'demon-hard', 'easy demon' => 'demon-easy', 'medium demon' => 'demon-medium', 'hard demon' => 'demon-hard', 'insane demon' => 'demon-insane', 'extreme demon' => 'demon-extreme'];
        $diffIcon = $diffArray[strtolower($difficulty)] ?? 'na';
        $originalDiffColorArray = ['na' => 'a9a9a9', 'auto' => 'f5c96b', 'easy' => '00e0ff', 'normal' => '00ff3a', 'hard' => 'ffb438', 'harder' => 'fc1f1f', 'insane' => 'f91ffc', 'demon-easy' => 'aa6bf5', 'demon-medium' => 'ac2974', 'demon-hard' => 'ff0000', 'demon-insane' => 'b31548', 'demon-extreme' => '8e0505'];
        $originalDiffColor = $originalDiffColor && empty($successColor);
        if($level['starStars'] != 0) {
            $setColor = empty($successColor) ? $originalDiffColorArray[$diffIcon] : $successColor;
			$setTitle = $this->webhookLanguage('rateSuccessTitle', $webhookLangArray);
			$dmTitle = $this->webhookLanguage('rateSuccessTitleDM', $webhookLangArray);
			$setDescription = sprintf($this->webhookLanguage('rateSuccessDesc', $webhookLangArray), $modFormattedUsername);
			$dmDescription = sprintf($this->webhookLanguage('rateSuccessDescDM', $webhookLangArray), $modFormattedUsername, $tadaEmoji);
			$setNotificationText = $rateNotificationText;
		} else {
			$setColor = $failColor;
			$setTitle = $this->webhookLanguage('rateFailTitle', $webhookLangArray);
			$dmTitle = $this->webhookLanguage('rateFailTitleDM', $webhookLangArray);
			$setDescription = sprintf($this->webhookLanguage('rateFailDesc', $webhookLangArray), $modFormattedUsername);
			$dmDescription = sprintf($this->webhookLanguage('rateFailDescDM', $webhookLangArray), $modFormattedUsername, $sobEmoji);
			$setNotificationText = $unrateNotificationText;
		}
		$stats = $downloadEmoji.' '.$level['downloads'].' • '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
		$levelField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
		$IDField = [$this->webhookLanguage('levelIDTitle', $webhookLangArray), $level['levelID'], true];
		if($level['starStars'] == 1) $action = 0; elseif(($level['starStars'] < 5 AND $level['starStars'] != 0) AND !($level['starStars'] > 9 AND $level['starStars'] < 20)) $action = 1; else $action = 2;
		$difficultyField = [$this->webhookLanguage('difficultyTitle', $webhookLangArray), sprintf($this->webhookLanguage('difficultyDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $difficulty, $level['starStars']), true];
		$statsField = [$this->webhookLanguage('statsTitle', $webhookLangArray), $stats, true];
		if($level['requestedStars'] == 1) $action = 0; elseif(($level['requestedStars'] < 5 AND $level['requestedStars'] != 0) AND !($level['requestedStars'] > 9 AND $level['requestedStars'] < 20)) $action = 1; else $action = 2;
		$requestedField = $level['requestedStars'] > 0 ? [$this->webhookLanguage('requestedTitle', $webhookLangArray), sprintf($this->webhookLanguage('requestedDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $level['requestedStars']), true] : [];
		$descriptionField = [$this->webhookLanguage('descTitle', $webhookLangArray), (!empty($level['levelDesc']) ? ExploitPatch::url_base64_decode($level['levelDesc']) : $this->webhookLanguage('descDesc', $webhookLangArray)), false];
		$setThumbnail = $difficultiesURL.$starsIcon.'/'.$diffIcon.'.png';
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $rateTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($levelField, $IDField, $difficultyField, $statsField, $requestedField, $descriptionField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send(); 
		if($dmNotifications && $creatorHasDiscord) {
			$embed = $this->generateEmbedArray(
				[$gdps, $authorURL, $authorIconURL],
				$setColor,
				[$dmTitle, $rateTitleURL],
				$dmDescription,
				$setThumbnail,
				[$levelField, $IDField, $difficultyField, $statsField, $requestedField, $descriptionField],
				[$setFooter, $footerIconURL]
			);
			$json = json_encode([
				"content" => "",
				"tts" => false,
				"embeds" => [$embed]
			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			$this->sendDiscordPM($creatorHasDiscord, $json, true);
		}
	}
	public function generateEmbedArray($author, $color, $title, $description, $thumbnail, $fieldsArray, $footer) {
		if(!is_array($author) || !is_array($title) || !is_array($fieldsArray) || !is_array($footer)) return false;
		$fields = [];
		$author = [
			"name" => $author[0],
			"url" => $author[1],
			"icon_url" => $author[2]
		];
		foreach($fieldsArray AS &$field) {
			if(!empty($field)) $fields[] = [
				"name" => $field[0],
				"value" => $field[1],
				"inline" => $field[2]
			];
		}
		$footer = [
			"text" => $footer[0],
			"icon_url" => $footer[1]
		];
		return [
			"type" => "rich",
			"timestamp" => date("c", time()),
			"title" => $title[0],
			"url" => $title[1],
			"color" => hexdec($color),
			"description" => $description,
			"thumbnail" => ["url" => $thumbnail],
			"footer" => $footer,
			"author" => $author,
			"fields" => $fields
		];
	}
	public function webhookStartLanguage($lang) {
		$fileExists = file_exists(__DIR__."/../../config/webhooks/lang/".$lang.".php");
		if(!$fileExists) return false;
		require __DIR__."/../../config/webhooks/lang/".$lang.".php";
		return $webhookLang;
	}
	public function webhookLanguage($langString, $webhookLangArray) {
		if(isset($webhookLangArray[$langString])) {
			if(is_array($webhookLangArray[$langString])) return $webhookLangArray[$langString][rand(0, count($webhookLangArray[$langString]) - 1)];
			else return $webhookLangArray[$langString];
		}
		return $langString;
	}
	public function changeDifficulty($accountID, $levelID, $difficulty, $auto, $demon) {
		if(!is_numeric($accountID)) return false;
		require __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $diffName, ':timestamp' => time(), ':id' => $accountID, ':value2' => 0, ':levelID' => $levelID]);
	}
	public function sendSuggestWebhook($modAccID, $levelID, $difficulty, $stars, $featured, $auto, $demon) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($levelID) OR !in_array("suggest", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($suggestWebhook);
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
		$level->execute([':levelID' => $levelID]);
		$level = $level->fetch();
		if(!$level) return false;
		$modUsername = $this->getAccountName($modAccID);
		$modHasDiscord = $this->hasDiscord($modAccID);
		$modFormattedUsername = $modHasDiscord ? "<@".$modHasDiscord.">" : "**".$modUsername."**";
		$creatorAccID = $level['extID'];
		$creatorUsername = $this->getAccountName($creatorAccID);
		$creatorHasDiscord = $this->hasDiscord($creatorAccID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$difficulty = $this->getDifficulty($difficulty, $auto, $demon);
		$starsArray = ['stars', 'featured', 'epic', 'legendary', 'mythic'];
		$starsIcon = $starsArray[$featured] ?? 'stars';
		$diffArray = ['n/a' => 'na', 'auto' => 'auto', 'easy' => 'easy', 'normal' => 'normal', 'hard' => 'hard', 'harder' => 'harder', 'insane' => 'insane', 'demon' => 'demon-hard', 'easy demon' => 'demon-easy', 'medium demon' => 'demon-medium', 'hard demon' => 'demon-hard', 'insane demon' => 'demon-insane', 'extreme demon' => 'demon-extreme'];
		$diffIcon = $diffArray[strtolower($difficulty)] ?? 'na';
		$originalDiffColorArray = ['na' => 'a9a9a9', 'auto' => 'f5c96b', 'easy' => '00e0ff', 'normal' => '00ff3a', 'hard' => 'ffb438', 'harder' => 'fc1f1f', 'insane' => 'f91ffc', 'demon-easy' => 'aa6bf5', 'demon-medium' => 'ac2974', 'demon-hard' => 'ff0000', 'demon-insane' => 'b31548', 'demon-extreme' => '8e0505'];
        $originalDiffColor = $originalDiffColor && empty($successColor);
        $setColor = empty($successColor) ? $originalDiffColorArray[$diffIcon] : $successColor;
		$setTitle = $this->webhookLanguage('suggestTitle', $webhookLangArray);
		$setDescription = sprintf($this->webhookLanguage('suggestDesc', $webhookLangArray), $modFormattedUsername);
		$stats = $downloadEmoji.' '.$level['downloads'].' • '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
		$levelField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
		$IDField = [$this->webhookLanguage('levelIDTitle', $webhookLangArray), $level['levelID'], true];
		if($stars == 1) $action = 0; elseif(($stars < 5 AND $stars != 0) AND !($stars > 9 AND $stars < 20)) $action = 1; else $action = 2;
		$difficultyField = [$this->webhookLanguage('difficultyTitle', $webhookLangArray), sprintf($this->webhookLanguage('difficultyDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $difficulty, $stars), true];
		$statsField = [$this->webhookLanguage('statsTitle', $webhookLangArray), $stats, true];
		if($level['requestedStars'] == 1) $action = 0; elseif(($level['requestedStars'] < 5 AND $level['requestedStars'] != 0) AND !($level['requestedStars'] > 9 AND $level['requestedStars'] < 20)) $action = 1; else $action = 2;
		$requestedField = $level['requestedStars'] > 0 ? [$this->webhookLanguage('requestedTitle', $webhookLangArray), sprintf($this->webhookLanguage('requestedDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $level['requestedStars']), true] : [];
		$descriptionField = [$this->webhookLanguage('descTitle', $webhookLangArray), (!empty($level['levelDesc']) ? ExploitPatch::url_base64_decode($level['levelDesc']) : $this->webhookLanguage('descDesc', $webhookLangArray)), false];
		$setThumbnail = $difficultiesURL.$starsIcon.'/'.$diffIcon.'.png';
		$setFooter = sprintf($this->webhookLanguage('footerSuggest', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($suggestNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $rateTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($levelField, $IDField, $difficultyField, $statsField, $requestedField, $descriptionField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendBanWebhook($banID, $modAccID) {
		require __DIR__."/connection.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($banID) OR !in_array("ban", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($banWebhook);
		$ban = $this->getBanByID($banID);
		switch($ban['personType']) {
			case 0:
				$playerAccID = $ban['person'];
				$user = $db->prepare('SELECT * FROM users WHERE extID = :ID');
				$user->execute([':ID' => $playerAccID]);
				$user = $user->fetch();
				if(!$user) return false;
				$playerUsername = $this->getAccountName($playerAccID);
				$playerHasDiscord = $this->hasDiscord($playerAccID);
				$playerFormattedUsername = $playerHasDiscord ? "<@".$playerHasDiscord.">" : "**".$playerUsername."**";
				break;
			case 1:
				$playerFormattedUsername = "**".$this->getUserName($ban['person'])."**";
				break;
			case 2:
				$playerFormattedUsername = "||**".$ban['person']."**||";
				break;
		}
		$modUsername = $this->getAccountName($modAccID);
		$modHasDiscord = $this->hasDiscord($modAccID);
		$modFormattedUsername = $modHasDiscord ? "<@".$modHasDiscord.">" : "**".$modUsername."**";
		switch($ban['banType']) {
			case 0:
				if($ban['isActive']) {
					$setColor = $failColor;
					$setTitle = $this->webhookLanguage('playerBanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerBanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerBanTopDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerBanTopDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $banThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footerBan', $webhookLangArray), $gdps);
				} else {
					$setColor = $successColor;
					$setTitle = $this->webhookLanguage('playerUnbanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerUnbanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerUnbanTopDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerUnbanTopDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $unbanThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
				}
				break;
			case 1:
				if($ban['isActive']) {
					$setColor = $failColor;
					$setTitle = $this->webhookLanguage('playerBanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerBanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerBanCreatorDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerBanCreatorDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $banThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footerBan', $webhookLangArray), $gdps);
				} else {
					$setColor = $successColor;
					$setTitle = $this->webhookLanguage('playerUnbanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerUnbanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerUnbanCreatorDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerUnbanCreatorDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $unbanThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
				}
				break;
			case 2:
				if($ban['isActive']) {
					$setColor = $failColor;
					$setTitle = $this->webhookLanguage('playerBanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerBanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerBanUploadDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerBanUploadDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $banThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footerBan', $webhookLangArray), $gdps);
				} else {
					$setColor = $successColor;
					$setTitle = $this->webhookLanguage('playerUnbanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerUnbanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerUnbanUploadDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerUnbanUploadDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $unbanThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
				}
				break;
			case 3:
				if($ban['isActive']) {
					$setColor = $failColor;
					$setTitle = $this->webhookLanguage('playerBanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerBanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerBanCommentDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerBanCommentDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $banThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footerBan', $webhookLangArray), $gdps);
				} else {
					$setColor = $successColor;
					$setTitle = $this->webhookLanguage('playerUnbanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerUnbanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerUnbanCommentDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerUnbanCommentDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $unbanThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
				}
				break;
			case 4:
				if($ban['isActive']) {
					$setColor = $failColor;
					$setTitle = $this->webhookLanguage('playerBanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerBanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerBanAccountDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerBanAccountDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $banThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footerBan', $webhookLangArray), $gdps);
				} else {
					$setColor = $successColor;
					$setTitle = $this->webhookLanguage('playerUnbanTitle', $webhookLangArray);
					$dmTitle = $this->webhookLanguage('playerUnbanTitleDM', $webhookLangArray);
					$setDescription = sprintf($this->webhookLanguage('playerUnbanAccountDesc', $webhookLangArray), $modFormattedUsername, $playerFormattedUsername);
					$dmDescription = sprintf($this->webhookLanguage('playerUnbanAccountDescDM', $webhookLangArray), $modFormattedUsername);
					$setThumbnail = $unbanThumbnailURL;
					$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
				}
				break;
		}
		$modField = [$this->webhookLanguage('playerModTitle', $webhookLangArray), $modFormattedUsername, true];
		$expiresField = $ban['isActive'] ? [$this->webhookLanguage('playerExpiresTitle', $webhookLangArray), '<t:'.$ban['expires'].':R>', true] : [];
		$personTypeField = [$this->webhookLanguage('playerTypeTitle', $webhookLangArray), $this->webhookLanguage('playerTypeName'.$ban['personType'], $webhookLangArray), true];
		$reasonField = [$this->webhookLanguage('playerReasonTitle', $webhookLangArray), !empty($ban['reason']) ? base64_decode($ban['reason']) : $this->webhookLanguage('playerBanReason', $webhookLangArray)];
		$dw->newMessage()
		->setContent($banNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $demonlistTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($modField, $expiresField, $personTypeField, $reasonField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
		if($dmNotifications && $playerHasDiscord) {
			$embed = $this->generateEmbedArray(
				[$gdps, $authorURL, $authorIconURL],
				$setColor,
				[$dmTitle, $demonlistTitleURL],
				$dmDescription,
				$setThumbnail,
				[$modField, $expiresField, $personTypeField, $reasonField],
				[$setFooter, $footerIconURL]
			);
			$json = json_encode([
				"content" => "",
				"tts" => false,
				"embeds" => [$embed]
			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			$this->sendDiscordPM($playerHasDiscord, $json, true);
		}
	}
	public function sendDailyWebhook($levelID, $type) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($levelID) OR !is_numeric($type) OR !in_array("daily", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($dailyWebhook);
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
		$level->execute([':levelID' => $levelID]);
		$level = $level->fetch();
		if(!$level) return false;
		switch($type) {
			case 0:
			case 1:
				$daily = $db->prepare('SELECT * FROM dailyfeatures WHERE levelID = :levelID AND type = :type');
				$daily->execute([':levelID' => $levelID, ':type' => $type]);
				break;
			case 2:
				$daily = $db->prepare('SELECT * FROM events WHERE levelID = :levelID');
				$daily->execute([':levelID' => $levelID]);
				break;
		}
		$daily = $daily->fetch();
		if(!$daily) return false;
		$creatorAccID = $level['extID'];
		$creatorUsername = $this->getAccountName($creatorAccID);
		$creatorHasDiscord = $this->hasDiscord($creatorAccID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$difficulty = $this->getDifficulty($level['starDifficulty'], $level['starAuto'], $level['starDemon'], $level['starDemonDiff']);
		$starsIcon = 'stars';
		$diffIcon = 'na';
		switch(true) {
			case ($level['starEpic'] > 0):
				$starsArray = ['', 'epic', 'legendary', 'mythic'];
				$starsIcon = $starsArray[$level['starEpic']];
				break;
			case ($level['starFeatured'] > 0):
				$starsIcon = 'featured';
				break;
		}
		$diffArray = ['n/a' => 'na', 'auto' => 'auto', 'easy' => 'easy', 'normal' => 'normal', 'hard' => 'hard', 'harder' => 'harder', 'insane' => 'insane', 'demon' => 'demon-hard', 'easy demon' => 'demon-easy', 'medium demon' => 'demon-medium', 'hard demon' => 'demon-hard', 'insane demon' => 'demon-insane', 'extreme demon' => 'demon-extreme'];
		$diffIcon = $diffArray[strtolower($difficulty)] ?? 'na';
		switch($type) {
			case 0:
				$setColor = $dailyColor;
				$setTitle = $this->webhookLanguage('dailyTitle', $webhookLangArray);
				$dmTitle = $this->webhookLanguage('dailyTitleDM', $webhookLangArray);
				$setDescription = $this->webhookLanguage('dailyDesc', $webhookLangArray);
				$dmDescription = sprintf($this->webhookLanguage('dailyDescDM', $webhookLangArray), $tadaEmoji);
				$setNotificationText = $dailyNotificationText;
				break;
			case 1:
				$setColor = $weeklyColor;
				$setTitle = $this->webhookLanguage('weeklyTitle', $webhookLangArray);
				$dmTitle = $this->webhookLanguage('weeklyTitleDM', $webhookLangArray);
				$setDescription = $this->webhookLanguage('weeklyDesc', $webhookLangArray);
				$dmDescription = sprintf($this->webhookLanguage('weeklyDescDM', $webhookLangArray), $tadaEmoji);
				$setNotificationText = $weeklyNotificationText;
				break;
			case 2:
				$setColor = $eventColor;
				$setTitle = $this->webhookLanguage('eventTitle', $webhookLangArray);
				$dmTitle = $this->webhookLanguage('eventTitleDM', $webhookLangArray);
				$setDescription = $this->webhookLanguage('eventDesc', $webhookLangArray);
				$dmDescription = sprintf($this->webhookLanguage('eventDescDM', $webhookLangArray), $tadaEmoji);
				$setNotificationText = $eventNotificationText;
				break;
		}
		$stats = $downloadEmoji.' '.$level['downloads'].' • '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
		$levelField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
		$IDField = [$this->webhookLanguage('levelIDTitle', $webhookLangArray), $level['levelID'], true];
		if($level['starStars'] == 1) $action = 0; elseif(($level['starStars'] < 5 AND $level['starStars'] != 0) AND !($level['starStars'] > 9 AND $level['starStars'] < 20)) $action = 1; else $action = 2;
		$difficultyField = [$this->webhookLanguage('difficultyTitle', $webhookLangArray), sprintf($this->webhookLanguage('difficultyDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $difficulty, $level['starStars']), true];
		$statsField = [$this->webhookLanguage('statsTitle', $webhookLangArray), $stats, true];
		if($level['requestedStars'] == 1) $action = 0; elseif(($level['requestedStars'] < 5 AND $level['requestedStars'] != 0) AND !($level['requestedStars'] > 9 AND $level['requestedStars'] < 20)) $action = 1; else $action = 2;
		$requestedField = $level['requestedStars'] > 0 ? [$this->webhookLanguage('requestedTitle', $webhookLangArray), sprintf($this->webhookLanguage('requestedDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $level['requestedStars']), true] : [];
		$descriptionField = [$this->webhookLanguage('descTitle', $webhookLangArray), (!empty($level['levelDesc']) ? ExploitPatch::url_base64_decode($level['levelDesc']) : $this->webhookLanguage('descDesc', $webhookLangArray)), false];
		$setThumbnail = $difficultiesURL.$starsIcon.'/'.$diffIcon.'.png';
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $rateTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($levelField, $IDField, $difficultyField, $statsField, $requestedField, $descriptionField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send(); 
		if($dmNotifications && $creatorHasDiscord) {
			$embed = $this->generateEmbedArray(
				[$gdps, $authorURL, $authorIconURL],
				$setColor,
				[$dmTitle, $rateTitleURL],
				$dmDescription,
				$setThumbnail,
				[$levelField, $IDField, $difficultyField, $statsField, $requestedField, $descriptionField],
				[$setFooter, $footerIconURL]
			);
			$json = json_encode([
				"content" => "",
				"tts" => false,
				"embeds" => [$embed]
			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			$this->sendDiscordPM($creatorHasDiscord, $json, true);
		}
	}
	public function getAllBans($onlyActive = true) {
		require __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute();
		return $bans->fetchAll();
	}
	public function getAllBansFromPerson($person, $personType, $onlyActive = true) {
		require __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans WHERE person = :person AND personType = :personType'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute([':person' => $person, ':personType' => $personType]);
		return $bans->fetchAll();
	}
	public function getAllBansOfPersonType($personType, $onlyActive = true) {
		require __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans WHERE personType = :personType'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute([':personType' => $personType]);
		return $bans->fetchAll();
	}
	public function getAllBansOfBanType($banType, $onlyActive = true) {
		require __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans WHERE banType = :banType'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute([':banType' => $banType]);
		return $bans->fetchAll();
	}
	public function banPerson($modID, $person, $reason, $banType, $personType, $expires) {
		require __DIR__."/connection.php";
		if($banType == 4) {
			switch($personType) {
				case 0:
					$removeAuth = $db->prepare('UPDATE accounts SET auth = "none" WHERE accountID = :accountID');
					$removeAuth->execute([':accountID' => $person]);
					break;
				case 2:
					$banIP = $db->prepare("INSERT INTO bannedips (IP) VALUES (:IP)");
					$banIP->execute([':IP' => $person]);
					break;
			}
		}
		if($personType == 2) $person = $this->IPForBan($person);
		$check = $this->getBan($person, $personType, $banType);
		if($check) {
			if($check['expires'] <= $expires) return $check['banID'];
			$this->unbanPerson($check['banID'], $modID);
		}
		$reason = base64_encode($reason);
		$ban = $db->prepare('INSERT INTO bans (modID, person, reason, banType, personType, expires, timestamp) VALUES (:modID, :person, :reason, :banType, :personType, :expires, :timestamp)');
		$ban->execute([':modID' => $modID, ':person' => $person, ':reason' => $reason, ':banType' => $banType, ':personType' => $personType, ':expires' => $expires, ':timestamp' => ($modID != 0 ? time() : 0)]);
		$banID = $db->lastInsertId();
		if($modID != 0) {
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, value4, value5, value6, timestamp, account) VALUES ('28', :value, :value2, :value3, :value4, :value5, :value6, :timestamp, :account)");
			$query->execute([':value' => $person, ':value2' => $reason, ':value3' => $personType, ':value4' => $banType, ':value5' => $expires, ':value6' => 1, ':timestamp' => time(), ':account' => $_SESSION['accountID']]);
			$this->sendBanWebhook($banID, $modID);
		}
		return $banID;
	}
	public function getBan($person, $personType, $banType) {
		require __DIR__."/connection.php";
		$ban = $db->prepare('SELECT * FROM bans WHERE person = :person AND personType = :personType AND banType = :banType AND isActive = 1 ORDER BY timestamp DESC');
		$ban->execute([':person' => $person, ':personType' => $personType, ':banType' => $banType]);
		return $ban->fetch();
	}
	public function unbanPerson($banID, $modID) {
		require __DIR__."/connection.php";
		$ban = $this->getBanByID($banID);
		if($ban) {
			if($ban['personType'] == 2 && $ban['banType'] == 4) {
				$banIP = $db->prepare("DELETE FROM bannedips WHERE IP = :IP");
				$banIP->execute([':IP' => $ban['person']]);
			}
			$unban = $db->prepare('UPDATE bans SET isActive = 0 WHERE banID = :banID');
			$unban->execute([':banID' => $banID]);
			if($modID != 0) {
				$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, value4, value5, value6, timestamp, account) VALUES ('28', :value, :value2, :value3, :value4, :value5, :value6, :timestamp, :account)");
				$query->execute([':value' => $ban['person'], ':value2' => $ban['reason'], ':value3' => $ban['personType'], ':value4' => $ban['banType'], ':value5' => $ban['expires'], ':value6' => 0, ':timestamp' => time(), ':account' => $modID]);
				$this->sendBanWebhook($banID, $modID);
			}
			return true;
		}
		return false;
	}
	public function getBanByID($banID) {
		require __DIR__."/connection.php";
		$ban = $db->prepare('SELECT * FROM bans WHERE banID = :banID');
		$ban->execute([':banID' => $banID]);
		return $ban->fetch();
	}
	public function getPersonBan($accountID, $userID, $banType, $IP = false) {
		require __DIR__."/connection.php";
		$IP = $IP ? $this->IPForBan($IP) : $this->IPForBan($this->getIP());
		$ban = $db->prepare('SELECT * FROM bans WHERE ((person = :accountID AND personType = 0) OR (person = :userID AND personType = 1) OR (person = :IP AND personType = 2)) AND banType = :banType AND isActive = 1 ORDER BY expires DESC');
		$ban->execute([':accountID' => $accountID, ':userID' => $userID, ':IP' => $IP, ':banType' => $banType]);
		return $ban->fetch();
	}
	public function IPForBan($IP, $isSearch = false) {
		$IP = explode('.', $IP);
		return $IP[0].'.'.$IP[1].'.'.$IP[2].($isSearch ? '' : '.0');
	}
	public function changeBan($banID, $modID, $reason, $expires) {
		require __DIR__."/connection.php";
		$ban = $this->getBanByID($banID);
		$reason = base64_encode($reason);
		if($ban && $ban['isActive'] != 0) {
			$unban = $db->prepare('UPDATE bans SET reason = :reason, expires = :expires WHERE banID = :banID');
			$unban->execute([':banID' => $banID, ':reason' => $reason, ':expires' => $expires]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, value4, value5, value6, timestamp, account) VALUES ('28', :value, :value2, :value3, :value4, :value5, :value6, :timestamp, :account)");
			$query->execute([':value' => $ban['person'], ':value2' => $reason, ':value3' => $ban['personType'], ':value4' => $ban['banType'], ':value5' => $expires, ':value6' => 2, ':timestamp' => time(), ':account' => $modID]);
			$this->sendBanWebhook($banID, $modID);
			return true;
		}
		return false;
	}
	public function sendLogsRegisterWebhook($accountID) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($accountID) OR !in_array("register", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsRegisterWebhook);
		$account = $db->prepare('SELECT * FROM accounts WHERE accountID = :accountID');
		$account->execute([':accountID' => $accountID]);
		$account = $account->fetch();
		if(!$account) return false;
		$setTitle = $this->webhookLanguage('logsRegisterTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('logsRegisterDesc', $webhookLangArray);
		$usernameField = [$this->webhookLanguage('logsUsernameField', $webhookLangArray), $account['userName'], true];
		$playerIDField = [$this->webhookLanguage('logsPlayerIDField', $webhookLangArray), $accountID.' • '.$this->getUserID($accountID, $account['userName']), true]; // Yes, this line creates userID for account. Yes, i did this on purpose.
		$isActivatedField = [$this->webhookLanguage('logsIsActivatedField', $webhookLangArray), $this->webhookLanguage('logsRegister'.($account['isActive'] ? 'Yes' : 'No'), $webhookLangArray), true];
		$registerTimeField = [$this->webhookLanguage('logsRegisterTimeField', $webhookLangArray), '<t:'.$account['registerDate'].':F>', false];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($logsRegisterNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($logsRegisterColor)
		->setTitle($setTitle, $logsRegisterTitleURL)
		->setDescription($setDescription)
		->setThumbnail($logsRegisterThumbnailURL)
		->addFields($usernameField, $playerIDField, $isActivatedField, $registerTimeField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendLogsLevelChangeWebhook($levelID, $whoChangedID, $levelData = []) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($levelID) OR !in_array("levels", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsLevelChangeWebhook);
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
		$level->execute([':levelID' => $levelID]);
		$level = $level->fetch();
		$isDeleted = false;
		if(!$level) {
			if(empty($levelData)) return false;
			$isDeleted = true;
			$level = $levelData;
		}
		$creatorAccID = $level['extID'];
		$creatorUsername = $this->getAccountName($creatorAccID);
		$creatorHasDiscord = $this->hasDiscord($creatorAccID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$whoChangedUsername = $this->getAccountName($whoChangedID);
		$whoChangedHasDiscord = $this->hasDiscord($whoChangedID);
		$whoChangedFormattedUsername = $whoChangedHasDiscord ? "<@".$whoChangedHasDiscord.">" : "**".$whoChangedUsername."**";
		$difficulty = $this->getDifficulty($level['starDifficulty'], $level['starAuto'], $level['starDemon'], $level['starDemonDiff']);
		$starsIcon = 'stars';
		$diffIcon = 'na';
		switch(true) {
			case ($level['starEpic'] > 0):
				$starsArray = ['', 'epic', 'legendary', 'mythic'];
				$starsIcon = $starsArray[$level['starEpic']];
				break;
			case ($level['starFeatured'] > 0):
				$starsIcon = 'featured';
				break;
		}
		$diffArray = ['n/a' => 'na', 'auto' => 'auto', 'easy' => 'easy', 'normal' => 'normal', 'hard' => 'hard', 'harder' => 'harder', 'insane' => 'insane', 'demon' => 'demon-hard', 'easy demon' => 'demon-easy', 'medium demon' => 'demon-medium', 'hard demon' => 'demon-hard', 'insane demon' => 'demon-insane', 'extreme demon' => 'demon-extreme'];
		$diffIcon = $diffArray[strtolower($difficulty)] ?? 'na';
		$newLevelNameField = $newExtIDField = $newLevelDescField = $newSongIDField = $newAudioTrackField = $newPasswordField = $newStarCoinsField = $newUnlistedField = $newUnlisted2Field = $newUpdateLockedField = $newCommentLockedField = [];
		$whoChangedField = [$this->webhookLanguage('logsLevelChangeWhoField', $webhookLangArray), $whoChangedFormattedUsername, false];
		$whatWasChangedField = [$this->webhookLanguage('logsWhatWasChangedField', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername).', *'.$level['levelID'].'*', false];
		$setNotificationText = $logsLevelChangedNotificationText;
		if($isDeleted || empty($levelData)) {
			if($isDeleted) {
				$whatWasChangedField = [];
				$setColor = $failColor;
				$setTitle = $this->webhookLanguage('logsLevelDeletedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsLevelDeletedDesc', $webhookLangArray);
			} else {
				$whoChangedField = $whatWasChangedField = [];
				$setColor = $successColor;
				$setTitle = $this->webhookLanguage('logsLevelUploadedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsLevelUploadedDesc', $webhookLangArray);
			}
			$stats = $downloadEmoji.' '.$level['downloads'].' • '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
			$levelField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
			$IDField = [$this->webhookLanguage('levelIDTitle', $webhookLangArray), $level['levelID'], true];
			if($level['starStars'] == 1) $action = 0; elseif(($level['starStars'] < 5 AND $level['starStars'] != 0) AND !($level['starStars'] > 9 AND $level['starStars'] < 20)) $action = 1; else $action = 2;
			$difficultyField = [$this->webhookLanguage('difficultyTitle', $webhookLangArray), sprintf($this->webhookLanguage('difficultyDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $difficulty, $level['starStars']), true];
			$statsField = [$this->webhookLanguage('statsTitle', $webhookLangArray), $stats, true];
			if($level['requestedStars'] == 1) $action = 0; elseif(($level['requestedStars'] < 5 AND $level['requestedStars'] != 0) AND !($level['requestedStars'] > 9 AND $level['requestedStars'] < 20)) $action = 1; else $action = 2;
			$requestedField = $level['requestedStars'] > 0 ? [$this->webhookLanguage('requestedTitle', $webhookLangArray), sprintf($this->webhookLanguage('requestedDesc'.$action, $webhookLangArray), $level['requestedStars']), true] : [];
			$descriptionField = [$this->webhookLanguage('descTitle', $webhookLangArray), (!empty($level['levelDesc']) ? ExploitPatch::url_base64_decode($level['levelDesc']) : $this->webhookLanguage('descDesc', $webhookLangArray)), false];
			$songInfo = $this->getSongInfo($level['songID']);
			$newSongIDField = [$this->webhookLanguage('songTitle', $webhookLangArray), (!empty($level['songID']) ? '**'.$songInfo['authorName'].'** — **'.$songInfo['name'].'**, *'.$songInfo['ID'].'*' : '**'.str_replace(' by ', '** by **', $this->getAudioTrack($level['audioTrack'])).'**'), true];
			$unlistedArray = [$this->webhookLanguage('levelIsPublic', $webhookLangArray), $this->webhookLanguage('levelOnlyForFriends', $webhookLangArray), $this->webhookLanguage('levelIsUnlisted', $webhookLangArray)];
			$unlistedText = $unlistedArray[$level['unlisted']];
			$newUnlistedField = [$this->webhookLanguage('unlistedTitle', $webhookLangArray), $unlistedText, true];
		} else {
			$setColor = $pendingColor;
			$setTitle = $this->webhookLanguage('logsLevelChangedTitle', $webhookLangArray);
			$setDescription = $this->webhookLanguage('logsLevelChangedDesc', $webhookLangArray);
			if($levelData['levelName'] != $level['levelName']) $newLevelNameField = [$this->webhookLanguage('logsLevelChangeNameField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeNameValue', $webhookLangArray), '`'.$levelData['levelName'].'`', '`'.$level['levelName'].'`'), false];
			if($levelData['extID'] != $level['extID']) $newExtIDField = [$this->webhookLanguage('logsLevelChangeExtIDField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeExtIDValue', $webhookLangArray), '`'.$levelData['extID'].'`', '`'.$level['extID'].'`'), false];
			if($levelData['levelDesc'] != $level['levelDesc']) $newLevelDescField = [$this->webhookLanguage('logsLevelChangeDescField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeDescValue', $webhookLangArray), (!empty($levelData['levelDesc']) ? '`'.ExploitPatch::url_base64_decode($levelData['levelDesc']).'`' : $this->webhookLanguage('descDesc', $webhookLangArray)), (!empty($level['levelDesc']) ? '`'.ExploitPatch::url_base64_decode($level['levelDesc']).'`' : $this->webhookLanguage('descDesc', $webhookLangArray))), false];
			if($levelData['songID'] != $level['songID']) $newSongIDField = [$this->webhookLanguage('logsLevelChangeSongIDField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeSongIDValue', $webhookLangArray), '`'.$levelData['songID'].'`', '`'.$level['songID'].'`'), false];
			if($levelData['audioTrack'] != $level['audioTrack']) $newAudioTrackField = [$this->webhookLanguage('logsLevelChangeAudioTrackField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeAudioTrackValue', $webhookLangArray), '`'.$this->getAudioTrack($levelData['audioTrack']).'`', '`'.$this->getAudioTrack($level['audioTrack']).'`'), false];
			if($levelData['password'] != $level['password']) $newPasswordField = [$this->webhookLanguage('logsLevelChangePasswordField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangePasswordValue', $webhookLangArray), '`'.$levelData['password'].'`', '`'.$level['password'].'`'), false];
			if($levelData['starCoins'] != $level['starCoins']) $newStarCoinsField = [$this->webhookLanguage('logsLevelChangeCoinsField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeCoinsValue', $webhookLangArray), ($levelData['starCoins'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray)), ($level['starCoins'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray))), false];
			if($levelData['unlisted'] != $level['unlisted']) {
				$unlistedArray = [$this->webhookLanguage('levelIsPublic', $webhookLangArray), $this->webhookLanguage('levelOnlyForFriends', $webhookLangArray), $this->webhookLanguage('levelIsUnlisted', $webhookLangArray)];
				$oldUnlistedText = $unlistedArray[$levelData['unlisted']];
				$newUnlistedText = $unlistedArray[$level['unlisted']];
				$newUnlistedField = [$this->webhookLanguage('logsLevelChangeUnlistedField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeUnlistedValue', $webhookLangArray), $oldUnlistedText, $newUnlistedText), true];
			}
			// I don't think we need this, but i already made it lol // if($levelData['unlisted2'] != $level['unlisted2']) $newUnlisted2Field = [$this->webhookLanguage('logsLevelChangeUnlisted2Field', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeUnlisted2Value', $webhookLangArray), ($levelData['unlisted2'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray)), ($level['unlisted2'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray))), false];
			if($levelData['updateLocked'] != $level['updateLocked']) $newUpdateLockedField = [$this->webhookLanguage('logsLevelChangeUpdateLockedField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeUpdateLockedValue', $webhookLangArray), ($levelData['updateLocked'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray)), ($level['updateLocked'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray))), false];
			if($levelData['commentLocked'] != $level['commentLocked']) $newCommentLockedField = [$this->webhookLanguage('logsLevelChangeCommentLockedField', $webhookLangArray), sprintf($this->webhookLanguage('logsLevelChangeCommentLockedValue', $webhookLangArray), ($levelData['commentLocked'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray)), ($level['commentLocked'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray))), false];
		}
		$setThumbnail = $difficultiesURL.$starsIcon.'/'.$diffIcon.'.png';
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $logsLevelChangeTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($whoChangedField, $whatWasChangedField, $levelField, $IDField, $difficultyField, $statsField, $requestedField, $descriptionField, $newLevelNameField, $newExtIDField, $newLevelDescField, $newSongIDField, $newAudioTrackField, $newPasswordField, $newStarCoinsField, $newUnlistedField, $newUnlisted2Field, $newUpdateLockedField, $newCommentLockedField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send(); 
	}
	public function sendLogsAccountChangeWebhook($accountID, $whoChangedID, $accountData) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($accountID) OR empty($accountData) OR !in_array("account", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsAccountChangeWebhook);
		$newAccountData = $db->prepare('SELECT * FROM accounts WHERE accountID = :accountID');
		$newAccountData->execute([':accountID' => $accountID]);
		$newAccountData = $newAccountData->fetch();
		$creatorUsername = $this->getAccountName($accountID);
		$creatorHasDiscord = $this->hasDiscord($accountID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$whoChangedUsername = $this->getAccountName($whoChangedID);
		$whoChangedHasDiscord = $this->hasDiscord($whoChangedID);
		$whoChangedFormattedUsername = $whoChangedHasDiscord ? "<@".$whoChangedHasDiscord.">" : "**".$whoChangedUsername."**";
		$whoChangedField = [$this->webhookLanguage('logsAccountChangeWhoField', $webhookLangArray), $whoChangedFormattedUsername, false];
		$whatWasChangedField = [$this->webhookLanguage('logsWhatWasChangedField', $webhookLangArray), $creatorFormattedUsername.', *'.$newAccountData['accountID'].'*', false];
		$newUsernameField = $newPasswordField = $newMSField = $newFRSField = $newCSField = $newYoutubeField = $newTwitterField = $newTwitchField = $newIsActivatedField = [];
		$setColor = $pendingColor;
		$setTitle = $this->webhookLanguage('logsAccountChangedTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('logsAccountChangedDesc', $webhookLangArray);	
		$setNotificationText = $logsAccountChangedNotificationText;
		if($newAccountData['userName'] != $accountData['userName']) $newUsernameField = [$this->webhookLanguage('logsAccountChangeUsernameField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeUsernameValue'), $accountData['userName'], $newAccountData['userName']), false];
		if($newAccountData['password'] != $accountData['password']) $newPasswordField = [$this->webhookLanguage('logsAccountChangePasswordField', $webhookLangArray), $this->webhookLanguage('logsAccountChangePasswordValue', $webhookLangArray), false];
		if($newAccountData['mS'] != $accountData['mS']) {
			$msArray = [$this->webhookLanguage('mS0', $webhookLangArray), $this->webhookLanguage('mS1', $webhookLangArray), $this->webhookLanguage('mS2', $webhookLangArray)];
			$oldMS = $msArray[$accountData['mS']];
			$newMS = $msArray[$newAccountData['mS']];
			$newMSField = [$this->webhookLanguage('logsAccountChangeMSField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeMSValue', $webhookLangArray), $oldMS, $newMS), false];
		}
		if($newAccountData['frS'] != $accountData['frS']) {
			$frsArray = [$this->webhookLanguage('frS0', $webhookLangArray), $this->webhookLanguage('frS1', $webhookLangArray)];
			$oldFRS = $frsArray[$accountData['frS']];
			$newFRS = $frsArray[$newAccountData['frS']];
			$newFRSField = [$this->webhookLanguage('logsAccountChangeFRSField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeFRSValue', $webhookLangArray), $oldFRS, $newFRS), false];
		}
		if($newAccountData['cS'] != $accountData['cS']) {
			$csArray = [$this->webhookLanguage('cS0', $webhookLangArray), $this->webhookLanguage('cS1', $webhookLangArray), $this->webhookLanguage('cS2', $webhookLangArray)];
			$oldCS = $csArray[$accountData['cS']];
			$newCS = $csArray[$newAccountData['cS']];
			$newCSField = [$this->webhookLanguage('logsAccountChangeCSField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeCSValue', $webhookLangArray), $oldCS, $newCS), false];
		}
		if($newAccountData['youtubeurl'] != $accountData['youtubeurl']) $newYoutubeField = [$this->webhookLanguage('logsAccountChangeYTField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeYTValue', $webhookLangArray), (!empty($accountData['youtubeurl']) ? $accountData['youtubeurl'] : $this->webhookLanguage('logsAccountChangeNoYT', $webhookLangArray)), (!empty($newAccountData['youtubeurl']) ? $newAccountData['youtubeurl'] : $this->webhookLanguage('logsAccountChangeNoYT', $webhookLangArray))), false];
		if($newAccountData['twitter'] != $accountData['twitter']) $newTwitterField = [$this->webhookLanguage('logsAccountChangeTWField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeTWValue', $webhookLangArray), (!empty($accountData['twitter']) ? $accountData['twitter'] : $this->webhookLanguage('logsAccountChangeNoTW', $webhookLangArray)), (!empty($newAccountData['twitter']) ? $newAccountData['twitter'] : $this->webhookLanguage('logsAccountChangeNoTW', $webhookLangArray))), false];
		if($newAccountData['twitch'] != $accountData['twitch']) $newTwitchField = [$this->webhookLanguage('logsAccountChangeTTVField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeTTVValue', $webhookLangArray), (!empty($accountData['twitch']) ? $accountData['twitch'] : $this->webhookLanguage('logsAccountChangeNoTTV', $webhookLangArray)), (!empty($newAccountData['twitch']) ? $newAccountData['twitch'] : $this->webhookLanguage('logsAccountChangeNoTTV', $webhookLangArray))), false];
		if($newAccountData['isActive'] != $accountData['isActive']) $newIsActivatedField = [$this->webhookLanguage('logsAccountChangeActiveField', $webhookLangArray), sprintf($this->webhookLanguage('logsAccountChangeActiveValue', $webhookLangArray), $this->webhookLanguage('logsRegister'.($accountData['isActive'] ? 'Yes' : 'No'), $webhookLangArray), $this->webhookLanguage('logsRegister'.($newAccountData['isActive'] ? 'Yes' : 'No'), $webhookLangArray)), true];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $logsAccountChangeTitleURL)
		->setDescription($setDescription)
		->setThumbnail($logsAccountChangeThumbnailURL)
		->addFields($whoChangedField, $whatWasChangedField, $newUsernameField, $newPasswordField, $newMSField, $newFRSField, $newCSField, $newYoutubeField, $newTwitterField, $newTwitchField, $newIsActivatedField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendLogsListChangeWebhook($listID, $whoChangedID, $listData = []) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($listID) OR !in_array("lists", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsListChangeWebhook);
		$newListData = $db->prepare('SELECT * FROM lists WHERE listID = :listID');
		$newListData->execute([':listID' => $listID]);
		$newListData = $newListData->fetch();
		$isDeleted = false;
		if(!$newListData) {
			if(empty($listData)) return false;
			$isDeleted = true;
			$newListData = $listData;
		}
		$accountID = $newListData['accountID'];
		$creatorUsername = $this->getAccountName($accountID);
		$creatorHasDiscord = $this->hasDiscord($accountID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$whoChangedUsername = $this->getAccountName($whoChangedID);
		$whoChangedHasDiscord = $this->hasDiscord($whoChangedID);
		$whoChangedFormattedUsername = $whoChangedHasDiscord ? "<@".$whoChangedHasDiscord.">" : "**".$whoChangedUsername."**";
		$whoChangedField = [$this->webhookLanguage('logsListChangeWhoField', $webhookLangArray), $whoChangedFormattedUsername, false];
		$whatWasChangedField = [$this->webhookLanguage('logsWhatWasChangedField', $webhookLangArray), $creatorFormattedUsername.', *'.$newListData['listID'].'*', false];
		$setNotificationText = $logsListChangedNotificationText;
		$diffArray = ['n/a' => 'na', 'auto' => 'auto', 'easy' => 'easy', 'normal' => 'normal', 'hard' => 'hard', 'harder' => 'harder', 'insane' => 'insane', 'demon' => 'demon-hard', 'easy demon' => 'demon-easy', 'medium demon' => 'demon-medium', 'hard demon' => 'demon-hard', 'insane demon' => 'demon-insane', 'extreme demon' => 'demon-extreme'];
		$starsIcon = $newListData['starFeatured'] > 0 ? 'featured' : 'stars';
		$diffIcon = $diffArray[strtolower($this->getListDiffName($newListData['starDifficulty']))] ?? 'na';
		if($isDeleted || empty($listData)) {
			if($isDeleted) {
				$whatWasChangedField = [];
				$setColor = $failColor;
				$setTitle = $this->webhookLanguage('logsListDeletedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsListDeletedDesc', $webhookLangArray);
			} else {
				$whoChangedField = $whatWasChangedField = [];
				$setColor = $successColor;
				$setTitle = $this->webhookLanguage('logsListUploadedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsListUploadedDesc', $webhookLangArray);
			}
			$stats = $downloadEmoji.' '.$newListData['downloads'].' • '.($newListData['likes'] - $newListData['dislikes'] >= 0 ? $likeEmoji.' '.abs($newListData['likes'] - $newListData['dislikes']) : $dislikeEmoji.' '.abs($newListData['likes'] - $newListData['dislikes']));
			$listField = [$this->webhookLanguage('listTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$newListData['listName'].'**', $creatorFormattedUsername), true];
			$IDField = [$this->webhookLanguage('listIDTitle', $webhookLangArray), $newListData['listID'], true];
			$actions = $newListData['starStars'][strlen($newListData['starStars'])-1] ?? $newListData['starStars'];
			if($actions == 1) $action = 0; elseif($actions < 5 AND $actions != 0 AND !($newListData['starStars'] > 9 AND $newListData['starStars'] < 20)) $action = 1; else $action = 2;
			$difficultyField = [$this->webhookLanguage('difficultyTitle', $webhookLangArray), sprintf($this->webhookLanguage('difficultyListDesc'.$action, $webhookLangArray), $this->getListDiffName($newListData['starDifficulty']), $newListData['starStars']), true];
			$statsField = [$this->webhookLanguage('statsTitle', $webhookLangArray), $stats, true];
			$descriptionField = [$this->webhookLanguage('descTitle', $webhookLangArray), (!empty($newListData['listDesc']) ? ExploitPatch::url_base64_decode($newListData['listDesc']) : $this->webhookLanguage('descDesc', $webhookLangArray)), false];
			$unlistedArray = [$this->webhookLanguage('listIsPublic', $webhookLangArray), $this->webhookLanguage('listOnlyForFriends', $webhookLangArray), $this->webhookLanguage('listIsUnlisted', $webhookLangArray)];
			$unlistedText = $unlistedArray[$newListData['unlisted']] ?? $unlistedArray[1];
			$newUnlistedField = [$this->webhookLanguage('unlistedListTitle', $webhookLangArray), $unlistedText, true];
		} else {
			$setColor = $pendingColor;
			$setTitle = $this->webhookLanguage('logsListChangedTitle', $webhookLangArray);
			$setDescription = $this->webhookLanguage('logsListChangedDesc', $webhookLangArray);	
			if($listData['listName'] != $newListData['listName']) $newListNameField = [$this->webhookLanguage('logsListChangeNameField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeNameValue', $webhookLangArray), '`'.$listData['listName'].'`', '`'.$newListData['listName'].'`'), true];
			if($listData['accountID'] != $newListData['accountID']) $newExtIDField = [$this->webhookLanguage('logsListChangeAccountIDField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeAccountIDValue', $webhookLangArray), '`'.$listData['accountID'].'`', '`'.$newListData['accountID'].'`'), true];
			if($listData['listDesc'] != $newListData['listDesc']) $newListDescField = [$this->webhookLanguage('logsListChangeDescField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeDescValue', $webhookLangArray), (!empty($listData['listDesc']) ? '`'.ExploitPatch::url_base64_decode($listData['listDesc']).'`' : $this->webhookLanguage('descDesc', $webhookLangArray)), (!empty($newListData['listDesc']) ? '`'.ExploitPatch::url_base64_decode($newListData['listDesc']).'`' : $this->webhookLanguage('descDesc', $webhookLangArray))), false];
			if($listData['starStars'] != $newListData['starStars']) {
				$oldReward = $listData['starStars'][strlen($listData['starStars'])-1] ?? $listData['starStars'];
				if($oldReward == 1) $action = 0; elseif($oldReward < 5 AND $oldReward != 0 AND !($listData['starStars'] > 9 AND $listData['starStars'] < 20)) $action = 1; else $action = 2;
				$oldReward = sprintf($this->webhookLanguage('logsListChangeReward'.$action, $webhookLangArray), $listData['starStars']);
				$newReward = $newListData['starStars'][strlen($newListData['starStars'])-1] ?? $newListData['starStars'];
				if($newReward == 1) $action = 0; elseif($newReward < 5 AND $newReward != 0 AND !($newListData['starStars'] > 9 AND $newListData['starStars'] < 20)) $action = 1; else $action = 2;
				$newReward = sprintf($this->webhookLanguage('logsListChangeReward'.$action, $webhookLangArray), $newListData['starStars']);
				$newRewardField = [$this->webhookLanguage('logsListChangeRewardField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeRewardValue', $webhookLangArray), $oldReward, $newReward), true];
			}
			if($listData['unlisted'] != $newListData['unlisted']) {
				$unlistedArray = [$this->webhookLanguage('listIsPublic', $webhookLangArray), $this->webhookLanguage('listOnlyForFriends', $webhookLangArray), $this->webhookLanguage('listIsUnlisted', $webhookLangArray)];
				$oldUnlistedText = $unlistedArray[$listData['unlisted']] ?? $unlistedArray[1];
				$newUnlistedText = $unlistedArray[$newListData['unlisted']] ?? $unlistedArray[1];
				$newUnlistedField = [$this->webhookLanguage('logsListChangeUnlistedField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeUnlistedValue', $webhookLangArray), $oldUnlistedText, $newUnlistedText), false];
			}
			if($listData['starDifficulty'] != $newListData['starDifficulty']) {
				$oldDiffText = $this->getListDiffName($listData['starDifficulty']);
				$newDiffText = $this->getListDiffName($newListData['starDifficulty']);
				$newDiffField = [$this->webhookLanguage('logsListChangeDiffField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeDiffValue', $webhookLangArray), $oldDiffText, $newDiffText), true];
			}
			if($listData['listlevels'] != $newListData['listlevels']) $newLevelsField = [$this->webhookLanguage('logsListChangeLevelsField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeLevelsValue', $webhookLangArray), $listData['listlevels'], $newListData['listlevels']), false];
			if($listData['countForReward'] != $newListData['countForReward']) {
				$oldReward = $listData['countForReward'][strlen($listData['countForReward'])-1] ?? $listData['countForReward'];
				if($oldReward == 1) $action = 0; elseif($oldReward < 5 AND $oldReward != 0 AND !($listData['countForReward'] > 9 AND $listData['countForReward'] < 20)) $action = 1; else $action = 2;
				$oldReward = sprintf($this->webhookLanguage('logsListChangeRewardCount'.$action, $webhookLangArray), $listData['countForReward']);
				$newReward = $newListData['countForReward'][strlen($newListData['countForReward'])-1] ?? $newListData['countForReward'];
				if($newReward == 1) $action = 0; elseif($newReward < 5 AND $newReward != 0 AND !($newListData['countForReward'] > 9 AND $newListData['countForReward'] < 20)) $action = 1; else $action = 2;
				$newReward = sprintf($this->webhookLanguage('logsListChangeRewardCount'.$action, $webhookLangArray), $newListData['countForReward']);
				$newRewardCountField = [$this->webhookLanguage('logsListChangeRewardCountField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeRewardCountValue', $webhookLangArray), $oldReward, $newReward), true];
			}
			if($listData['commentLocked'] != $newListData['commentLocked']) $newCommentLockedField = [$this->webhookLanguage('logsListChangeCommentLockedField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeCommentLockedValue', $webhookLangArray), ($listData['commentLocked'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray)), ($newListData['commentLocked'] ? $this->webhookLanguage('logsRegisterYes', $webhookLangArray) : $this->webhookLanguage('logsRegisterNo', $webhookLangArray))), false];
		}
		$setThumbnail = $difficultiesURL.$starsIcon.'/'.$diffIcon.'.png';
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $logsListChangeTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($whoChangedField, $whatWasChangedField, $listField, $IDField, $difficultyField, $statsField, $descriptionField, $newUnlistedField, $newListNameField, $newExtIDField, $newListDescField, $newLevelsField, $newRewardField, $newDiffField, $newRewardCountField, $newCommentLockedField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendLogsModChangeWebhook($modID, $whoChangedID, $assignID, $modData = []) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($modID) OR !is_numeric($assignID) OR !in_array("mods", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsModChangeWebhook);
		$newAssignData = $db->prepare('SELECT * FROM roleassign WHERE assignID = :assignID');
		$newAssignData->execute([':assignID' => $assignID]);
		$newAssignData = $newAssignData->fetch();
		$isDeleted = false;
		if(!$newAssignData) {
			if(empty($modData)) return false;
			$isDeleted = true;
			$newAssignData = $modData;
		}
		$creatorUsername = $this->getAccountName($modID);
		$creatorHasDiscord = $this->hasDiscord($modID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$whoChangedUsername = $this->getAccountName($whoChangedID);
		$whoChangedHasDiscord = $this->hasDiscord($whoChangedID);
		$whoChangedFormattedUsername = $whoChangedHasDiscord ? "<@".$whoChangedHasDiscord.">" : "**".$whoChangedUsername."**";
		$whoChangedField = [$this->webhookLanguage('logsModChangeWhoField', $webhookLangArray), $whoChangedFormattedUsername, false];
		$whatWasChangedField = [$this->webhookLanguage('logsWhatWasChangedField', $webhookLangArray), $creatorFormattedUsername.', *'.$modID.'*', false];
		$setNotificationText = $logsModChangedNotificationText;
		if($isDeleted || empty($modData)) {
			if($isDeleted) {
				$setColor = $failColor;
				$setTitle = $this->webhookLanguage('logsModDemotedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsModDemotedDesc', $webhookLangArray);
			} else {
				$setColor = $successColor;
				$setTitle = $this->webhookLanguage('logsModPromotedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsModPromotedDesc', $webhookLangArray);
			}
			$getRole = $db->prepare("SELECT roleName FROM roles WHERE roleID = :roleID");
			$getRole->execute([':roleID' => $newAssignData['roleID']]);
			$getRole = $getRole->fetchColumn();
			if(empty($getRole)) $getRole = $this->webhookLanguage('logsModChangeRoleUnknown', $webhookLangArray);
			$roleField = [$this->webhookLanguage('roleField', $webhookLangArray), $getRole, true];
		} else {
			$setColor = $pendingColor;
			$setTitle = $this->webhookLanguage('logsModChangedTitle', $webhookLangArray);
			$setDescription = $this->webhookLanguage('logsModChangedDesc', $webhookLangArray);	
			if($modData['roleID'] != $newAssignData['roleID']) {
				$getRole = $db->prepare("SELECT roleName FROM roles WHERE roleID = :roleID");
				$getRole->execute([':roleID' => $modData['roleID']]);
				$oldRole = $getRole->fetchColumn();
				if(empty($oldRole)) $oldRole = $this->webhookLanguage('logsModChangeRoleUnknown', $webhookLangArray);
				$getRole = $db->prepare("SELECT roleName FROM roles WHERE roleID = :roleID");
				$getRole->execute([':roleID' => $newAssignData['roleID']]);
				$newRole = $getRole->fetchColumn();
				if(empty($newRole)) $newRole = $this->webhookLanguage('logsModChangeRoleUnknown', $webhookLangArray);
				$roleField = [$this->webhookLanguage('logsModChangeRoleField', $webhookLangArray), sprintf($this->webhookLanguage('logsModChangeRoleValue', $webhookLangArray), $oldRole, $newRole), true];
			}
		}
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $logsModChangeTitleURL)
		->setDescription($setDescription)
		->setThumbnail($logsModChangeThumbnailURL)
		->addFields($whoChangedField, $whatWasChangedField, $roleField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendLogsGauntletChangeWebhook($gauntletID, $whoChangedID, $gauntletData = []) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($gauntletID) OR !in_array("gauntlets", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsGauntletChangeWebhook);
		$newGauntletData = $db->prepare('SELECT * FROM gauntlets WHERE ID = :gauntletID');
		$newGauntletData->execute([':gauntletID' => $gauntletID]);
		$newGauntletData = $newGauntletData->fetch();
		$isDeleted = false;
		if(!$newGauntletData) {
			if(empty($gauntletData)) return false;
			$isDeleted = true;
			$newGauntletData = $gauntletData;
		}
		$whoChangedUsername = $this->getAccountName($whoChangedID);
		$whoChangedHasDiscord = $this->hasDiscord($whoChangedID);
		$whoChangedFormattedUsername = $whoChangedHasDiscord ? "<@".$whoChangedHasDiscord.">" : "**".$whoChangedUsername."**";
		$whoChangedField = [$this->webhookLanguage('logsGauntletChangeWhoField', $webhookLangArray), $whoChangedFormattedUsername, false];
		$whatWasChangedField = [$this->webhookLanguage('logsWhatWasChangedField', $webhookLangArray), $this->getGauntletName($newGauntletData['ID']).' Gauntlet', false];
		$setNotificationText = $logsGauntletChangedNotificationText;
		if($isDeleted || empty($gauntletData)) {
			$whatWasChangedField = [];
			if($isDeleted) {
				$setColor = $failColor;
				$setTitle = $this->webhookLanguage('logsGauntletDeletedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsGauntletDeletedDesc', $webhookLangArray);
			} else {
				$setColor = $successColor;
				$setTitle = $this->webhookLanguage('logsGauntletCreatedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsGauntletCreatedDesc', $webhookLangArray);
			}
			$gauntletName = [$this->webhookLanguage('gauntletNameField', $webhookLangArray), $this->getGauntletName($newGauntletData['ID']).' Gauntlet', false];
			$getLevels = $db->prepare('SELECT levelName, levelID, extID FROM levels WHERE levelID IN ('.$newGauntletData['level1'].', '.$newGauntletData['level2'].', '.$newGauntletData['level3'].', '.$newGauntletData['level4'].', '.$newGauntletData['level5'].')');
			$getLevels->execute();
			$getLevels = $getLevels->fetchAll();
			$level1Author = $getLevels[0]['extID'];
			$level1AuthorUsername = $this->getAccountName($level1Author);
			$level1AuthorHasDiscord = $this->hasDiscord($level1Author);
			$level1AuthorFormattedUsername = $level1AuthorHasDiscord ? "<@".$level1AuthorHasDiscord.">" : "**".$level1AuthorUsername."**";
			$level2Author = $getLevels[1]['extID'];
			$level2AuthorUsername = $this->getAccountName($level2Author);
			$level2AuthorHasDiscord = $this->hasDiscord($level2Author);
			$level2AuthorFormattedUsername = $level2AuthorHasDiscord ? "<@".$level2AuthorHasDiscord.">" : "**".$level2AuthorUsername."**";
			$level3Author = $getLevels[2]['extID'];
			$level3AuthorUsername = $this->getAccountName($level3Author);
			$level3AuthorHasDiscord = $this->hasDiscord($level3Author);
			$level3AuthorFormattedUsername = $level3AuthorHasDiscord ? "<@".$level3AuthorHasDiscord.">" : "**".$level3AuthorUsername."**";
			$level4Author = $getLevels[3]['extID'];
			$level4AuthorUsername = $this->getAccountName($level4Author);
			$level4AuthorHasDiscord = $this->hasDiscord($level4Author);
			$level4AuthorFormattedUsername = $level4AuthorHasDiscord ? "<@".$level4AuthorHasDiscord.">" : "**".$level4AuthorUsername."**";
			$level5Author = $getLevels[4]['extID'];
			$level5AuthorUsername = $this->getAccountName($level5Author);
			$level5AuthorHasDiscord = $this->hasDiscord($level5Author);
			$level5AuthorFormattedUsername = $level5AuthorHasDiscord ? "<@".$level5AuthorHasDiscord.">" : "**".$level5AuthorUsername."**";
			$level1Field = [$this->webhookLanguage('level1Field', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $getLevels[0]['levelName'], $level1AuthorFormattedUsername).', *'.$getLevels[0]['levelID'].'*', false];
			$level2Field = [$this->webhookLanguage('level2Field', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $getLevels[1]['levelName'], $level2AuthorFormattedUsername).', *'.$getLevels[1]['levelID'].'*', false];
			$level3Field = [$this->webhookLanguage('level3Field', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $getLevels[2]['levelName'], $level3AuthorFormattedUsername).', *'.$getLevels[2]['levelID'].'*', false];
			$level4Field = [$this->webhookLanguage('level4Field', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $getLevels[3]['levelName'], $level4AuthorFormattedUsername).', *'.$getLevels[3]['levelID'].'*', false];
			$level5Field = [$this->webhookLanguage('level5Field', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $getLevels[4]['levelName'], $level5AuthorFormattedUsername).', *'.$getLevels[4]['levelID'].'*', false];
		} else {
			$setColor = $pendingColor;
			$setTitle = $this->webhookLanguage('logsGauntletChangedTitle', $webhookLangArray);
			$setDescription = $this->webhookLanguage('logsGauntletChangedDesc', $webhookLangArray);
			if($gauntletData['ID'] != $newGauntletData['ID']) $level1Field = [$this->webhookLanguage('logsGauntletChangeGauntletField', $webhookLangArray), sprintf($this->webhookLanguage('logsGauntletChangeGauntletValue', $webhookLangArray), $this->getGauntletName($gauntletData['ID']).' Gauntlet', $this->getGauntletName($newGauntletData['ID']).' Gauntlet'), false];
			if($gauntletData['level1'] != $newGauntletData['level1']) {
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $gauntletData['level1']]);
				$oldLevel1 = $getLevel->fetch();
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $newGauntletData['level1']]);
				$newLevel1 = $getLevel->fetch();
				$oldLevel1AuthorUsername = $this->getAccountName($oldLevel1['extID']);
				$oldLevel1AuthorHasDiscord = $this->hasDiscord($oldLevel1['extID']);
				$oldLevel1AuthorFormattedUsername = $oldLevel1AuthorHasDiscord ? "<@".$oldLevel1AuthorHasDiscord.">" : "**".$oldLevel1AuthorUsername."**";
				$newLevel1AuthorUsername = $this->getAccountName($newLevel1['extID']);
				$newLevel1AuthorHasDiscord = $this->hasDiscord($newLevel1['extID']);
				$newLevel1AuthorFormattedUsername = $newLevel1AuthorHasDiscord ? "<@".$newLevel1AuthorHasDiscord.">" : "**".$newLevel1AuthorUsername."**";
				$level1Field = [$this->webhookLanguage('logsGauntletChangeLevel1Field', $webhookLangArray), sprintf($this->webhookLanguage('logsGauntletChangeLevelValue', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $oldLevel1['levelName'], $oldLevel1AuthorFormattedUsername).', *'.$oldLevel1['levelID'].'*', sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $newLevel1['levelName'], $newLevel1AuthorFormattedUsername).', *'.$newLevel1['levelID'].'*'), false];
			}
			if($gauntletData['level2'] != $newGauntletData['level2']) {
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $gauntletData['level2']]);
				$oldLevel2 = $getLevel->fetch();
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $newGauntletData['level2']]);
				$newLevel2 = $getLevel->fetch();
				$oldLevel2AuthorUsername = $this->getAccountName($oldLevel2['extID']);
				$oldLevel2AuthorHasDiscord = $this->hasDiscord($oldLevel2['extID']);
				$oldLevel2AuthorFormattedUsername = $oldLevel2AuthorHasDiscord ? "<@".$oldLevel2AuthorHasDiscord.">" : "**".$oldLevel2AuthorUsername."**";
				$newLevel2AuthorUsername = $this->getAccountName($newLevel2['extID']);
				$newLevel2AuthorHasDiscord = $this->hasDiscord($newLevel2['extID']);
				$newLevel2AuthorFormattedUsername = $newLevel2AuthorHasDiscord ? "<@".$newLevel2AuthorHasDiscord.">" : "**".$newLevel2AuthorUsername."**";
				$level2Field = [$this->webhookLanguage('logsGauntletChangeLevel2Field', $webhookLangArray), sprintf($this->webhookLanguage('logsGauntletChangeLevelValue', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $oldLevel2['levelName'], $oldLevel2AuthorFormattedUsername).', *'.$oldLevel2['levelID'].'*', sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $newLevel2['levelName'], $newLevel2AuthorFormattedUsername).', *'.$newLevel2['levelID'].'*'), false];
			}
			if($gauntletData['level3'] != $newGauntletData['level3']) {
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $gauntletData['level3']]);
				$oldLevel3 = $getLevel->fetch();
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $newGauntletData['level3']]);
				$newLevel3 = $getLevel->fetch();
				$oldLevel3AuthorUsername = $this->getAccountName($oldLevel3['extID']);
				$oldLevel3AuthorHasDiscord = $this->hasDiscord($oldLevel3['extID']);
				$oldLevel3AuthorFormattedUsername = $oldLevel3AuthorHasDiscord ? "<@".$oldLevel3AuthorHasDiscord.">" : "**".$oldLevel3AuthorUsername."**";
				$newLevel3AuthorUsername = $this->getAccountName($newLevel3['extID']);
				$newLevel3AuthorHasDiscord = $this->hasDiscord($newLevel3['extID']);
				$newLevel3AuthorFormattedUsername = $newLevel3AuthorHasDiscord ? "<@".$newLevel3AuthorHasDiscord.">" : "**".$newLevel3AuthorUsername."**";
				$level3Field = [$this->webhookLanguage('logsGauntletChangeLevel3Field', $webhookLangArray), sprintf($this->webhookLanguage('logsGauntletChangeLevelValue', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $oldLevel3['levelName'], $oldLevel3AuthorFormattedUsername).', *'.$oldLevel3['levelID'].'*', sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $newLevel3['levelName'], $newLevel3AuthorFormattedUsername).', *'.$newLevel3['levelID'].'*'), false];
			}
			if($gauntletData['level4'] != $newGauntletData['level4']) {
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $gauntletData['level4']]);
				$oldLevel4 = $getLevel->fetch();
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $newGauntletData['level4']]);
				$newLevel4 = $getLevel->fetch();
				$oldLevel4AuthorUsername = $this->getAccountName($oldLevel4['extID']);
				$oldLevel4AuthorHasDiscord = $this->hasDiscord($oldLevel4['extID']);
				$oldLevel4AuthorFormattedUsername = $oldLevel4AuthorHasDiscord ? "<@".$oldLevel4AuthorHasDiscord.">" : "**".$oldLevel4AuthorUsername."**";
				$newLevel4AuthorUsername = $this->getAccountName($newLevel4['extID']);
				$newLevel4AuthorHasDiscord = $this->hasDiscord($newLevel4['extID']);
				$newLevel4AuthorFormattedUsername = $newLevel4AuthorHasDiscord ? "<@".$newLevel4AuthorHasDiscord.">" : "**".$newLevel4AuthorUsername."**";
				$level4Field = [$this->webhookLanguage('logsGauntletChangeLevel4Field', $webhookLangArray), sprintf($this->webhookLanguage('logsGauntletChangeLevelValue', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $oldLevel4['levelName'], $oldLevel4AuthorFormattedUsername).', *'.$oldLevel4['levelID'].'*', sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $newLevel4['levelName'], $newLevel4AuthorFormattedUsername).', *'.$newLevel4['levelID'].'*'), false];
			}
			if($gauntletData['level5'] != $newGauntletData['level5']) {
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $gauntletData['level5']]);
				$oldLevel5 = $getLevel->fetch();
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $newGauntletData['level5']]);
				$newLevel5 = $getLevel->fetch();
				$oldLevel5AuthorUsername = $this->getAccountName($oldLevel5['extID']);
				$oldLevel5AuthorHasDiscord = $this->hasDiscord($oldLevel5['extID']);
				$oldLevel5AuthorFormattedUsername = $oldLevel5AuthorHasDiscord ? "<@".$oldLevel5AuthorHasDiscord.">" : "**".$oldLevel5AuthorUsername."**";
				$newLevel5AuthorUsername = $this->getAccountName($newLevel5['extID']);
				$newLevel5AuthorHasDiscord = $this->hasDiscord($newLevel5['extID']);
				$newLevel5AuthorFormattedUsername = $newLevel5AuthorHasDiscord ? "<@".$newLevel5AuthorHasDiscord.">" : "**".$newLevel5AuthorUsername."**";
				$level5Field = [$this->webhookLanguage('logsGauntletChangeLevel5Field', $webhookLangArray), sprintf($this->webhookLanguage('logsGauntletChangeLevelValue', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $oldLevel5['levelName'], $oldLevel5AuthorFormattedUsername).', *'.$oldLevel5['levelID'].'*', sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), $newLevel5['levelName'], $newLevel5AuthorFormattedUsername).', *'.$newLevel5['levelID'].'*'), false];
			}
		}
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $logsGauntletChangeTitleURL)
		->setDescription($setDescription)
		->setThumbnail($logsGauntletChangeThumbnailURL)
		->addFields($whoChangedField, $whatWasChangedField, $gauntletName, $level1Field, $level2Field, $level3Field, $level4Field, $level5Field)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendLogsMapPackChangeWebhook($packID, $whoChangedID, $packData = []) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($packID) OR !in_array("mappacks", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($logsMapPackChangeWebhook);
		$newPackData = $db->prepare('SELECT * FROM mappacks WHERE ID = :packID');
		$newPackData->execute([':packID' => $packID]);
		$newPackData = $newPackData->fetch();
		$isDeleted = false;
		if(!$newPackData) {
			if(empty($packData)) return false;
			$isDeleted = true;
			$newPackData = $packData;
		}
		$whoChangedUsername = $this->getAccountName($whoChangedID);
		$whoChangedHasDiscord = $this->hasDiscord($whoChangedID);
		$whoChangedFormattedUsername = $whoChangedHasDiscord ? "<@".$whoChangedHasDiscord.">" : "**".$whoChangedUsername."**";
		$whoChangedField = [$this->webhookLanguage('logsMapPackChangeWhoField', $webhookLangArray), $whoChangedFormattedUsername, false];
		$whatWasChangedField = [$this->webhookLanguage('logsWhatWasChangedField', $webhookLangArray), $newPackData['name'].', *'.$packID.'*', false];
		$setNotificationText = $logsMapPackChangedNotificationText;
		if($isDeleted || empty($packData)) {
			$whatWasChangedField = [];
			if($isDeleted) {
				$setColor = $failColor;
				$setTitle = $this->webhookLanguage('logsMapPackDeletedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsMapPackDeletedDesc', $webhookLangArray);
			} else {
				$setColor = $successColor;
				$setTitle = $this->webhookLanguage('logsMapPackCreatedTitle', $webhookLangArray);
				$setDescription = $this->webhookLanguage('logsMapPackCreatedDesc', $webhookLangArray);
			}
			$packField = [$this->webhookLanguage('packField', $webhookLangArray), $newPackData['name'], true];
			if($newPackData['stars'] == 1) $action = 0; elseif(($newPackData['stars'] < 5 AND $newPackData['stars'] != 0)) $action = 1; else $action = 2;
			$starsText = sprintf($this->webhookLanguage('requestedDesc'.$action, $webhookLangArray), $newPackData['stars']);
			if($newPackData['coins'] == 1) $action = 0; elseif(($newPackData['coins'] < 5 AND $newPackData['coins'] != 0)) $action = 1; else $action = 2;
			$coinsText = sprintf($this->webhookLanguage('packRewardCoins'.$action, $webhookLangArray), $newPackData['coins']);
			$packRewardField = [$this->webhookLanguage('packRewardField', $webhookLangArray), sprintf($this->webhookLanguage('packRewardValue', $webhookLangArray), $starsText, $coinsText), true];
			$packLevels = explode(',', $newPackData['levels']);
			$packLevelsValue = '';
			foreach($packLevels AS &$packLevel) {
				$getLevel = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
				$getLevel->execute([':levelID' => $packLevel]);
				$getLevel = $getLevel->fetch();
				if(!$getLevel) {
					$packLevelsValue .= $this->webhookLanguage('undefinedLevel', $webhookLangArray).PHP_EOL;
					continue;
				}
				$levelAuthorUsername = $this->getAccountName($getLevel['extID']);
				$levelAuthorHasDiscord = $this->hasDiscord($getLevel['extID']);
				$levelAuthorFormattedUsername = $levelAuthorHasDiscord ? "<@".$levelAuthorHasDiscord.">" : "**".$levelAuthorUsername."**";
				$difficulty = $this->getDifficulty($getLevel['starDifficulty'], $getLevel['starAuto'], $getLevel['starDemon'], $getLevel['starDemonDiff']);
				if($getLevel['starStars'] == 1) $action = 0; elseif(($getLevel['starStars'] < 5 AND $getLevel['starStars'] != 0) AND !($getLevel['starStars'] > 9 AND $getLevel['starStars'] < 20)) $action = 1; else $action = 2;
				$packLevelsValue .= sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$getLevel['levelName'].'**', $levelAuthorFormattedUsername).' • '.sprintf($this->webhookLanguage('difficultyDesc' . ($getLevel['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $difficulty, $getLevel['starStars']).' (*'.$packLevel.'*)'.PHP_EOL;
			}
			$packLevelsField = [$this->webhookLanguage('packLevelsField', $webhookLangArray), $packLevelsValue, false];
			$packColorsField = [$this->webhookLanguage('packColorsField', $webhookLangArray), sprintf($this->webhookLanguage('packColorsValue', $webhookLangArray), $newPackData['rgbcolors'], $newPackData['colors2']), true];
			$packTimestampField = [$this->webhookLanguage('packTimestampField', $webhookLangArray), '<t:'.$newPackData['timestamp'].':F>', false];
		} else {
			$setColor = $pendingColor;
			$setTitle = $this->webhookLanguage('logsMapPackChangedTitle', $webhookLangArray);
			$setDescription = $this->webhookLanguage('logsMapPackChangedDesc', $webhookLangArray);	
			if($packData['name'] != $newPackData['name']) $packField = [$this->webhookLanguage('logsMapPackChangeNameField', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeNameValue', $webhookLangArray), $packData['name'], $newPackData['name']), false];
			if($packData['levels'] != $newPackData['levels']) $packLevelsField = [$this->webhookLanguage('logsMapPackChangeLevelsField', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeLevelsValue', $webhookLangArray), $packData['levels'], $newPackData['levels']), false];
			if($packData['stars'] != $newPackData['stars']) {
				if($packData['stars'] == 1) $action = 0; elseif(($packData['stars'] < 5 AND $packData['stars'] != 0)) $action = 1; else $action = 2;
				$oldStarsText = sprintf($this->webhookLanguage('requestedDesc'.$action, $webhookLangArray), $packData['stars']);
				if($newPackData['stars'] == 1) $action = 0; elseif(($newPackData['stars'] < 5 AND $newPackData['stars'] != 0)) $action = 1; else $action = 2;
				$newStarsText = sprintf($this->webhookLanguage('requestedDesc'.$action, $webhookLangArray), $newPackData['stars']);
				$packStarsField = [$this->webhookLanguage('logsMapPackChangeStarsField', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeStarsValue', $webhookLangArray), $oldStarsText, $newStarsText), false];
			}
			if($packData['coins'] != $newPackData['coins']) {
				if($packData['coins'] == 1) $action = 0; elseif(($packData['coins'] < 5 AND $packData['coins'] != 0)) $action = 1; else $action = 2;
				$oldCoinsText = sprintf($this->webhookLanguage('packRewardCoins'.$action, $webhookLangArray), $packData['coins']);
				if($newPackData['coins'] == 1) $action = 0; elseif(($newPackData['coins'] < 5 AND $newPackData['coins'] != 0)) $action = 1; else $action = 2;
				$newCoinsText = sprintf($this->webhookLanguage('packRewardCoins'.$action, $webhookLangArray), $newPackData['coins']);
				$packCoinsField = [$this->webhookLanguage('logsMapPackChangeCoinsField', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeCoinsValue', $webhookLangArray), $oldCoinsText, $newCoinsText), false];
			}
			if($packData['difficulty'] != $newPackData['difficulty']) {
				$diffarray = ['Auto', 'Easy', 'Normal', 'Hard', 'Harder', 'Insane', 'Demon'];
				$packDifficultyField = [$this->webhookLanguage('logsMapPackChangeDifficultyField', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeDifficultyValue', $webhookLangArray), $diffarray[$packData['difficulty']], $diffarray[$newPackData['difficulty']]), false];
			}
			if($packData['rgbcolors'] != $newPackData['rgbcolors']) $packColor1Field = [$this->webhookLanguage('logsMapPackChangeColor1Field', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeColorValue', $webhookLangArray), $packData['rgbcolors'], $newPackData['rgbcolors']), false];
			if($packData['colors2'] != $newPackData['colors2']) $packColor2Field = [$this->webhookLanguage('logsMapPackChangeColor2Field', $webhookLangArray), sprintf($this->webhookLanguage('logsMapPackChangeColorValue', $webhookLangArray), $packData['colors2'], $newPackData['colors2']), false];
		}
		$diffarray = ['auto', 'easy', 'normal', 'hard', 'harder', 'insane', 'demon-hard'];
		$setThumbnail = $difficultiesURL.'stars/'.$diffarray[$newPackData['difficulty']].'.png';
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($setNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $logsMapPackChangeTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($whoChangedField, $whatWasChangedField, $packField, $packRewardField, $packStarsField, $packCoinsField, $packDifficultyField, $packColor1Field, $packColor2Field, $packColorsField, $packLevelsField, $packTimestampField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function logAction($accountID, $type, $value1 = '', $value2 = '', $value3 = 0, $value4 = 0, $value5 = 0, $value6 = 0) {
		require __DIR__."/connection.php";
		$insertAction = $db->prepare('INSERT INTO actions (account, type, timestamp, value, value2, value3, value4, value5, value6, IP) VALUES (:account, :type, :timestamp, :value, :value2, :value3, :value4, :value5, :value6, :IP)');
		$insertAction->execute([':account' => $accountID, ':type' => $type, ':value' => $value1, ':value2' => $value2, ':value3' => $value3, ':value4' => $value4, ':value5' => $value5, ':value6' => $value6, ':timestamp' => time(), ':IP' => $this->getIP()]);
		return $db->lastInsertId();
	}
	public function sendLevelsWarningWebhook($levelsYesterday, $levelsToday) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($levelsYesterday) OR !is_numeric($levelsToday) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('levelsWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('levelsWarningDesc', $webhookLangArray);
		$lYchar = $levelsYesterday[strlen($levelsYesterday)-1] ?? $levelsYesterday;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($levelsYesterday > 9 AND $levelsYesterday < 20)) $action = 1; else $action = 2;
		$levelsYesterdayField = [$this->webhookLanguage('levelsYesterdayField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeRewardCount'.$action, $webhookLangArray), $levelsYesterday), true];
		$lTchar = $levelsToday[strlen($levelsToday)-1] ?? $levelsToday;
		if($lTchar == 1) $action = 0; elseif($lTchar < 5 AND $lTchar != 0 AND !($levelsToday > 9 AND $levelsToday < 20)) $action = 1; else $action = 2;
		$levelsTodayField = [$this->webhookLanguage('levelsTodayField', $webhookLangArray), sprintf($this->webhookLanguage('logsListChangeRewardCount'.$action, $webhookLangArray), $levelsToday), true];
		if($levelsYesterday != 0) $levelsPercent = ceil($levelsToday / $levelsYesterday * 10) / 10;
		else $levelsPercent = '∞';
		$levelsCompareField = [$this->webhookLanguage('levelsCompareField', $webhookLangArray), sprintf($this->webhookLanguage('levelsCompareValue', $webhookLangArray), $levelsPercent), true];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($levelsYesterdayField, $levelsTodayField, $levelsCompareField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendAccountsWarningWebhook($accountsYesterday, $accountsToday) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($accountsYesterday) OR !is_numeric($accountsToday) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('accountsWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('accountsWarningDesc', $webhookLangArray);
		$lYchar = $accountsYesterday[strlen($accountsYesterday)-1] ?? $accountsYesterday;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($accountsYesterday > 9 AND $accountsYesterday < 20)) $action = 1; else $action = 2;
		$accountsYesterdayField = [$this->webhookLanguage('accountsYesterdayField', $webhookLangArray), sprintf($this->webhookLanguage('accountsCountValue'.$action, $webhookLangArray), $accountsYesterday), true];
		$lTchar = $accountsToday[strlen($accountsToday)-1] ?? $accountsToday;
		if($lTchar == 1) $action = 0; elseif($lTchar < 5 AND $lTchar != 0 AND !($accountsToday > 9 AND $accountsToday < 20)) $action = 1; else $action = 2;
		$accountsTodayField = [$this->webhookLanguage('accountsTodayField', $webhookLangArray), sprintf($this->webhookLanguage('accountsCountValue'.$action, $webhookLangArray), $accountsToday), true];
		if($accountsYesterday != 0) $accountsPercent = ceil($accountsToday / $accountsYesterday * 10) / 10;
		else $accountsPercent = '∞';
		$accountsCompareField = [$this->webhookLanguage('levelsCompareField', $webhookLangArray), sprintf($this->webhookLanguage('levelsCompareValue', $webhookLangArray), $accountsPercent), true];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($accountsYesterdayField, $accountsTodayField, $accountsCompareField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendCommentsSpammingWarningWebhook($similarCommentsCount, $similarCommentsAuthors) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($similarCommentsCount) OR !is_array($similarCommentsAuthors) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('commentsSpammingWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('commentsSpammingWarningDesc', $webhookLangArray);
		$lYchar = $similarCommentsCount[strlen($similarCommentsCount)-1] ?? $similarCommentsCount;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($similarCommentsCount > 9 AND $similarCommentsCount < 20)) $action = 1; else $action = 2;
		$similarCommentsField = [$this->webhookLanguage('similarCommentsField', $webhookLangArray), sprintf($this->webhookLanguage('similarCommentsValue'.$action, $webhookLangArray), $similarCommentsCount), true];
		$similarCommentsAuthorsText = '';
		foreach($similarCommentsAuthors AS &$commentAuthor) {
			$commentAuthorID = $this->getExtID($commentAuthor);
			$commentAuthorUsername = $this->getAccountName($commentAuthorID);
			$commentAuthorHasDiscord = $this->hasDiscord($commentAuthorID);
			$commentAuthorFormattedUsername = $commentAuthorHasDiscord ? "<@".$commentAuthorHasDiscord.">" : "**".$commentAuthorUsername."**";
			$similarCommentsAuthorsText .= $commentAuthorFormattedUsername.', '.$commentAuthorID.' • '.$commentAuthor.PHP_EOL;
		}
		$similarCommentsAuthorsField = [$this->webhookLanguage('similarCommentsAuthorsField', $webhookLangArray), $similarCommentsAuthorsText, false];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($similarCommentsField, $similarCommentsAuthorsField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendCommentsSpammerWarningWebhook($similarCommentsCount, $commentSpammer) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($similarCommentsCount) OR !is_numeric($commentSpammer) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('commentsSpammerWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('commentsSpammerWarningDesc', $webhookLangArray);
		$lYchar = $similarCommentsCount[strlen($similarCommentsCount)-1] ?? $similarCommentsCount;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($similarCommentsCount > 9 AND $similarCommentsCount < 20)) $action = 1; else $action = 2;
		$similarCommentsField = [$this->webhookLanguage('similarCommentsField', $webhookLangArray), sprintf($this->webhookLanguage('similarCommentsValue'.$action, $webhookLangArray), $similarCommentsCount), true];
		$commentAuthorID = $this->getExtID($commentSpammer);
		$commentAuthorUsername = $this->getAccountName($commentAuthorID);
		$commentAuthorHasDiscord = $this->hasDiscord($commentAuthorID);
		$commentAuthorFormattedUsername = $commentAuthorHasDiscord ? "<@".$commentAuthorHasDiscord.">" : "**".$commentAuthorUsername."**";
		$similarCommentsAuthorsField = [$this->webhookLanguage('commentSpammerField', $webhookLangArray), $commentAuthorFormattedUsername.', '.$commentAuthorID.' • '.$commentSpammer, true];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($similarCommentsField, $similarCommentsAuthorsField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendAccountPostsSpammingWarningWebhook($similarCommentsCount, $similarCommentsAuthors) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($similarCommentsCount) OR !is_array($similarCommentsAuthors) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('accountPostsSpammingWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('accountPostsSpammingWarningDesc', $webhookLangArray);
		$lYchar = $similarCommentsCount[strlen($similarCommentsCount)-1] ?? $similarCommentsCount;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($similarCommentsCount > 9 AND $similarCommentsCount < 20)) $action = 1; else $action = 2;
		$similarCommentsField = [$this->webhookLanguage('similarAccountPostsField', $webhookLangArray), sprintf($this->webhookLanguage('similarAccountPostsValue'.$action, $webhookLangArray), $similarCommentsCount), true];
		$similarCommentsAuthorsText = '';
		foreach($similarCommentsAuthors AS &$commentAuthor) {
			$commentAuthorID = $this->getExtID($commentAuthor);
			$commentAuthorUsername = $this->getAccountName($commentAuthorID);
			$commentAuthorHasDiscord = $this->hasDiscord($commentAuthorID);
			$commentAuthorFormattedUsername = $commentAuthorHasDiscord ? "<@".$commentAuthorHasDiscord.">" : "**".$commentAuthorUsername."**";
			$similarCommentsAuthorsText .= $commentAuthorFormattedUsername.', '.$commentAuthorID.' • '.$commentAuthor.PHP_EOL;
		}
		$similarCommentsAuthorsField = [$this->webhookLanguage('similarAccountPostsAuthorsField', $webhookLangArray), $similarCommentsAuthorsText, false];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($similarCommentsField, $similarCommentsAuthorsField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendAccountPostsSpammerWarningWebhook($similarCommentsCount, $commentSpammer) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($similarCommentsCount) OR !is_numeric($commentSpammer) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('accountPostsSpammerWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('accountPostsSpammerWarningDesc', $webhookLangArray);
		$lYchar = $similarCommentsCount[strlen($similarCommentsCount)-1] ?? $similarCommentsCount;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($similarCommentsCount > 9 AND $similarCommentsCount < 20)) $action = 1; else $action = 2;
		$similarCommentsField = [$this->webhookLanguage('similarAccountPostsField', $webhookLangArray), sprintf($this->webhookLanguage('similarAccountPostsValue'.$action, $webhookLangArray), $similarCommentsCount), true];
		$commentAuthorID = $this->getExtID($commentSpammer);
		$commentAuthorUsername = $this->getAccountName($commentAuthorID);
		$commentAuthorHasDiscord = $this->hasDiscord($commentAuthorID);
		$commentAuthorFormattedUsername = $commentAuthorHasDiscord ? "<@".$commentAuthorHasDiscord.">" : "**".$commentAuthorUsername."**";
		$similarCommentsAuthorsField = [$this->webhookLanguage('accountPostsSpammerField', $webhookLangArray), $commentAuthorFormattedUsername.', '.$commentAuthorID.' • '.$commentSpammer, true];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($similarCommentsField, $similarCommentsAuthorsField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendRepliesSpammingWarningWebhook($similarCommentsCount, $similarCommentsAuthors) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($similarCommentsCount) OR !is_array($similarCommentsAuthors) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('repliesSpammingWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('repliesSpammingWarningDesc', $webhookLangArray);
		$lYchar = $similarCommentsCount[strlen($similarCommentsCount)-1] ?? $similarCommentsCount;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($similarCommentsCount > 9 AND $similarCommentsCount < 20)) $action = 1; else $action = 2;
		$similarCommentsField = [$this->webhookLanguage('similarRepliesField', $webhookLangArray), sprintf($this->webhookLanguage('similarRepliesValue'.$action, $webhookLangArray), $similarCommentsCount), true];
		$similarCommentsAuthorsText = '';
		foreach($similarCommentsAuthors AS &$commentAuthorID) {
			$commentAuthorUsername = $this->getAccountName($commentAuthorID);
			$commentAuthor = $this->getUserID($commentAuthorID, $commentAuthorUsername);
			$commentAuthorHasDiscord = $this->hasDiscord($commentAuthorID);
			$commentAuthorFormattedUsername = $commentAuthorHasDiscord ? "<@".$commentAuthorHasDiscord.">" : "**".$commentAuthorUsername."**";
			$similarCommentsAuthorsText .= $commentAuthorFormattedUsername.', '.$commentAuthorID.' • '.$commentAuthor.PHP_EOL;
		}
		$similarCommentsAuthorsField = [$this->webhookLanguage('similarRepliesAuthorsField', $webhookLangArray), $similarCommentsAuthorsText, false];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($similarCommentsField, $similarCommentsAuthorsField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendRepliesSpammerWarningWebhook($similarCommentsCount, $commentAuthorID) {
		require __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) require __DIR__."/exploitPatch.php";
		require __DIR__."/../../config/dashboard.php";
		require __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($similarCommentsCount) OR !is_numeric($commentAuthorID) OR !in_array("warnings", $webhooksToEnable)) return false;
		require_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($warningsWebhook);
		$setTitle = $this->webhookLanguage('repliesSpammerWarningTitle', $webhookLangArray);
		$setDescription = $this->webhookLanguage('repliesSpammerWarningDesc', $webhookLangArray);
		$lYchar = $similarCommentsCount[strlen($similarCommentsCount)-1] ?? $similarCommentsCount;
		if($lYchar == 1) $action = 0; elseif($lYchar < 5 AND $lYchar != 0 AND !($similarCommentsCount > 9 AND $similarCommentsCount < 20)) $action = 1; else $action = 2;
		$similarCommentsField = [$this->webhookLanguage('similarRepliesField', $webhookLangArray), sprintf($this->webhookLanguage('similarRepliesValue'.$action, $webhookLangArray), $similarCommentsCount), true];
		$commentAuthorUsername = $this->getAccountName($commentAuthorID);
		$commentAuthor = $this->getUserID($commentAuthorID, $commentAuthorUsername);
		$commentAuthorHasDiscord = $this->hasDiscord($commentAuthorID);
		$commentAuthorFormattedUsername = $commentAuthorHasDiscord ? "<@".$commentAuthorHasDiscord.">" : "**".$commentAuthorUsername."**";
		$similarCommentsAuthorsField = [$this->webhookLanguage('repliesSpammerField', $webhookLangArray), $commentAuthorFormattedUsername.', '.$commentAuthorID.' • '.$commentAuthor, true];
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($warningsNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($failColor)
		->setTitle($setTitle, $warningsTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($similarCommentsField, $similarCommentsAuthorsField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function getGMDFile($levelID) {
		require __DIR__."/connection.php";
		if(!is_numeric($levelID)) return false;
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
		$level->execute([':levelID' => $levelID]);
		$level = $level->fetch();
		if(!$level) return false;
		$levelString = file_get_contents(__DIR__.'/../../data/levels/'.$levelID) ?? $level['levelString'];
		$gmdFile = '<?xml version="1.0"?><plist version="1.0" gjver="2.0"><dict>';
		
		$gmdFile .= '<k>k1</k><i>'.$levelID.'</i>';
		$gmdFile .= '<k>k2</k><s>'.$level['levelName'].'</s>';
		$gmdFile .= '<k>k3</k><s>'.$level['levelDesc'].'</s>';
		$gmdFile .= '<k>k4</k><s>'.$levelString.'</s>';
		$gmdFile .= '<k>k5</k><s>'.$level['userName'].'</s>';
		$gmdFile .= '<k>k6</k><i>'.$level['userID'].'</i>';
		$gmdFile .= '<k>k8</k><i>'.$level['audioTrack'].'</i>';
		$gmdFile .= '<k>k11</k><i>'.$level['downloads'].'</i>';
		$gmdFile .= '<k>k13</k><t />';
		$gmdFile .= '<k>k16</k><i>'.$level['levelVersion'].'</i>';
		$gmdFile .= '<k>k21</k><i>2</i>';
		$gmdFile .= '<k>k23</k><i>'.$level['levelLength'].'</i>';
		$gmdFile .= '<k>k42</k><i>'.$level['levelID'].'</i>';
		$gmdFile .= '<k>k45</k><i>'.$level['songID'].'</i>';
		$gmdFile .= '<k>k47</k><t />';
		$gmdFile .= '<k>k48</k><i>'.$level['objects'].'</i>';
		$gmdFile .= '<k>k50</k><i>'.$level['binaryVersion'].'</i>';
		$gmdFile .= '<k>k87</k><i>556365614873111</i>';
		$gmdFile .= '<k>k101</k><i>0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0</i>';
		$gmdFile .= '<k>kl1</k><i>0</i>';
		$gmdFile .= '<k>kl2</k><i>0</i>';
		$gmdFile .= '<k>kl3</k><i>1</i>';
		$gmdFile .= '<k>kl5</k><i>1</i>';
		$gmdFile .= '<k>kl6</k><k>kI6</k><d><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s><k>0</k><s>0</s></d>';
		
		$gmdFile .= '</dict></plist>';
		return $gmdFile;
	}
	public function getDownloadLinkWithCobalt($link) {
		require __DIR__."/../../config/dashboard.php";
		if(!$useCobalt) return false;
		$cobalt = $cobaltAPI[rand(0, count($cobaltAPI) - 1)];
		$data = array(
			"url" => $link,
			"audioFormat" => "mp3",
			"downloadMode" => "audio"
		);
		$postdata = json_encode($data);
		$ch = curl_init($cobalt); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
		$result = json_decode(curl_exec($ch));
		curl_close($ch);
		$url = $result->url;
		if(!$url) return false;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_USERAGENT, "");
		return curl_exec($ch);
	}
	public function getRewardTypes() {
		return [
			0 => '',
			1 => 'Fire Shard',
			2 => 'Ice Shard',
			3 => 'Poison Shard',
			4 => 'Shadow Shard',
			5 => 'Lava Shard',
			6 => 'Demon Key',
			7 => 'Orbs',
			8 => 'Diamond',
			9 => '',
			10 => 'Earth Shard',
			11 => 'Blood Shard',
			12 => 'Metal Shard',
			13 => 'Light Shard',
			14 => 'Soul Shard',
			15 => 'Gold Key',
			1001 => 'Cube',
			1002 => 'Color 1',
			1003 => 'Color 2',
			1004 => 'Ship',
			1005 => 'Ball',
			1006 => 'UFO',
			1007 => 'Wave',
			1008 => 'Robot',
			1009 => 'Spider',
			1010 => 'Trail',
			1011 => 'Death Effect',
			1012 => 'Items',
			1013 => 'Swing',
			1014 => 'Jetpack',
			1015 => 'Ship fire',
		];
	}
  	public function mail($mail = '', $user = '', $isForgotPass = false) {
		if(empty($mail) OR empty($user)) return;
		require __DIR__."/../../config/mail.php";
		if($mailEnabled) {
			require __DIR__."/connection.php";
			require __DIR__."/../../config/dashboard.php";
			require __DIR__."/../../config/mail/PHPMailer.php";
			require __DIR__."/../../config/mail/SMTP.php";
			require __DIR__."/../../config/mail/Exception.php";
			$m = new PHPMailer\PHPMailer\PHPMailer();
			$m->CharSet = 'utf-8';
			$m->isSMTP();
			$m->SMTPAuth = true;
			$m->Host = $mailbox;
			$m->Username = $mailuser;
			$m->Password = $mailpass;
			$m->Port = $mailport;
			if($mailtype) $m->SMTPSecure = $mailtype;
			else {
				$m->SMTPSecure = 'tls';
				$m->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
			}
			$m->setFrom($yourmail, $gdps);
			$m->addAddress($mail, $user);
			$m->isHTML(true);
			if(!$isForgotPass) {
				$string = $this->randomString(4);
				$query = $db->prepare("UPDATE accounts SET mail = :mail WHERE userName = :user");
				$query->execute([':mail' => $string, ':user' => $user]);
				$m->Subject = 'Confirm link';
				$m->Body = '<h1 align=center>Hello, <b>'.$user.'</b>!</h1><br>
				<h2 align=center>It seems, that you wanna register new account in <b>'.$gdps.'</b></h2><br>
				<h2 align=center>Here is your link!</h2><br>
				<h1 align=center>'.dirname('https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']).'/activate.php?mail='.$string.'</h1>';
			} else {
				$m->Subject = 'Forgot password?';
				$m->Body = '<h1 align=center>Hello, <b>'.$user.'</b>!</h1><br>
				<h2 align=center>It seems, that you forgot your password in <b>'.$gdps.'</b>...</h2><br>
				<h2 align=center>Here is your link!</h2><br>
				<h1 align=center>https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'].'?code='.$isForgotPass.'</h1>';
			}
			return $m->send();
		}
	}
}
