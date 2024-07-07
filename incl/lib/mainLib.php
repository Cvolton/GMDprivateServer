<?php
include_once __DIR__ . "/ip_in_range.php";
class mainLib {
	public function getAudioTrack($id) {
		$songs = ["Stereo Madness by ForeverBound",
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
  		        "Power Trip by Boom Kitty"];
		if($id < 0 || $id >= count($songs))
			return "Unknown by DJVI";
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
		include __DIR__ . "/connection.php";
		$diff = $db->prepare("SELECT starDifficulty FROM levels WHERE levelID = :id");
		$diff->execute([':id' => $levelID]);
		$diff = $diff->fetch();
		$diff = $this->getDifficulty($diff["starDifficulty"], 0, 0);
		return $diff;
	}
	public function getLevelStars($levelID) {
		include __DIR__ . "/connection.php";
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
		if($version > 17){
			return $version / 10;
		}elseif($version == 11){
			return "1.8";
		}elseif($version == 10){
			return "1.7";
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
		$gauntlets = ["Unknown", "Fire", "Ice", "Poison", "Shadow", "Lava", "Bonus", "Chaos", "Demon", "Time", "Crystal", "Magic", "Spike", "Monster", "Doom", "Death", 'Forest', 'Rune', 'Force', 'Spooky', 'Dragon', 'Water', 'Haunted', 'Acid', 'Witch', 'Power', 'Potion', 'Snake', 'Toxic', 'Halloween', 'Treasure', 'Ghost', 'Spider', 'Gem', 'Inferno', 'Portal', 'Strange', 'Fantasy', 'Christmas', 'Surprise', 'Mystery', 'Cursed', 'Cyborg', 'Castle', 'Grave', 'Temple', 'World', 'Galaxy', 'Universe', 'Discord', 'Split', 'NCS I', 'NCS II'];
		if($wholeArray) return $gauntlets;
		if($id < 0 || $id >= count($gauntlets))
			return $gauntlets[0];
		return $gauntlets[$id];
	}
	public function getGauntletCount() {
		return count($this->getGauntletName(0, true))-1;
	}
	public function makeTime($time) {
		include __DIR__ . "/../../config/dashboard.php";
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
		include __DIR__ . "/../../config/security.php";
		include_once __DIR__ . "/exploitPatch.php";
		include_once __DIR__ . "/GJPCheck.php";
		if(!empty($_POST["udid"]) AND $_POST['gameVersion'] < 20 AND $unregisteredSubmissions) {
			$id = ExploitPatch::remove($_POST["udid"]);
			if(is_numeric($id)) exit("-1");
		} elseif(!empty($_POST["accountID"]) AND $_POST["accountID"] !="0") $id = GJPCheck::getAccountIDOrDie();
		else exit("-1");
		return $id;
	}
	public function getUserID($extID, $userName = "Undefined") {
		include __DIR__ . "/connection.php";
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
			$query = $db->prepare("INSERT INTO users (isRegistered, extID, userName, lastPlayed)
			VALUES (:register, :id, :userName, :uploadDate)");

			$query->execute([':id' => $extID, ':register' => $register, ':userName' => $userName, ':uploadDate' => time()]);
			$userID = $db->lastInsertId();
		}
		return $userID;
	}
	public function getAccountName($accountID) {
		if(!is_numeric($accountID)) return false;

		include __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :id");
		$query->execute([':id' => $accountID]);
		if ($query->rowCount() > 0) {
			$userName = $query->fetchColumn();
		} else {
			$userName = false;
		}
		return $userName;
	}
	public function getUserName($userID) {
		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
		include_once __DIR__ . "/exploitPatch.php";
		if(!isset($song['ID'])) $song = $this->getLibrarySongInfo($song['songID']);
		if(!$song || $song['ID'] == 0 || empty($song['ID']) || $song["isDisabled"] == 1) return false;
		$dl = $song["download"];
		if(strpos($dl, ':') !== false){
			$dl = urlencode($dl);
		}
		return "1~|~".$song["ID"]."~|~2~|~".ExploitPatch::rutoen(str_replace("#", "", $song["name"]))."~|~3~|~".$song["authorID"]."~|~4~|~".ExploitPatch::rutoen($song["authorName"])."~|~5~|~".$song["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~1";
	}
	public function getSongInfo($id, $column = "*") {
	    if(!is_numeric($id)) return;
	    include __DIR__ . "/connection.php";
	    $sinfo = $db->prepare("SELECT $column FROM songs WHERE ID = :id");
	    $sinfo->execute([':id' => $id]);
	    $sinfo = $sinfo->fetch();
	    if(empty($sinfo)) {
			$sinfo = $this->getLibrarySongInfo($id, 'music');
			if(!$sinfo) return false;
			else {
				if($column != "*")  return $sinfo[$column];
				else return array("ID" => $sinfo["ID"], "name" => $sinfo["name"], "authorName" => $sinfo["authorName"], "size" => $sinfo["size"], "duration" => $sinfo["duration"], "download" => $sinfo["download"], "reuploadTime" => $sinfo["reuploadTime"], "reuploadID" => $sinfo["reuploadID"]);
			}
		}
	    else {
	        if($column != "*")  return $sinfo[$column];
	        else return array("ID" => $sinfo["ID"], "name" => $sinfo["name"], "authorName" => $sinfo["authorName"], "size" => $sinfo["size"], "duration" => $sinfo["duration"], "download" => $sinfo["download"], "reuploadTime" => $sinfo["reuploadTime"], "reuploadID" => $sinfo["reuploadID"]);
	    }
	}
	public function getSFXInfo($id, $column = "*") {
	    if(!is_numeric($id)) return;
	    include __DIR__ . "/connection.php";
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
	    include __DIR__ . "/connection.php";
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
	    include __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT ID FROM clans WHERE clan = :id");
	    $claninfo->execute([':id' => base64_encode($clan)]);
	    $claninfo = $claninfo->fetch();
	    return $claninfo["ID"];
	}
	public function isPlayerInClan($id) {
		global $dashCheck;
	    if(!is_numeric($id) || $dashCheck === 'no') return false;
	    include __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT clan FROM users WHERE extID = :id");
	    $claninfo->execute([':id' => $id]);
	    $claninfo = $claninfo->fetch();
	    if(!empty($claninfo)) return $claninfo["clan"];
	    else return false;
	}
	public function isPendingRequests($clan) {
		global $dashCheck;
	    if(!is_numeric($clan) || $dashCheck === 'no') return false;
		include __DIR__ . "/connection.php";
	    $claninfo = $db->prepare("SELECT count(*) FROM clanrequests WHERE clanID = :id");
		$claninfo->execute([':id' => $clan]);
		return $claninfo->fetchColumn();
	}
    public function sendDiscordPM($receiver, $message, $json = false){
		include __DIR__ . "/../../config/discord.php";
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
		include __DIR__ . "/../../config/discord.php";
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
		include __DIR__ . "/connection.php";
		include __DIR__ . "/exploitPatch.php";
		$desc = $db->prepare("SELECT levelDesc FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		if(empty($desc["levelDesc"])) return !$dashboard ? '*This level doesn\'t have description*' : '<text style="font-style:italic">This level doesn\'t have description</text>';
		else return ExploitPatch::url_base64_decode($desc["levelDesc"]);
	}
	public function getLevelName($lid) {
		include __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT levelName FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]); 
		$desc = $desc->fetch();
		if(!empty($desc["levelName"])) return $desc["levelName"]; else return false;
	} 
	public function getLevelStats($lid) {
		include __DIR__ . "/connection.php";
		$info = $db->prepare("SELECT downloads, likes, requestedStars FROM levels WHERE levelID = :id");
		$info->execute([':id' => $lid]);
		$info = $info->fetch();
		$likes = $info["likes"]; // - $info["dislikes"];
		if(!empty($info)) return array('dl' => $info["downloads"], 'likes' => $likes, 'req' => $info["requestedStars"]);
	}
	public function getLevelAuthor($lid) {
		include __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		return $desc["extID"];
	}
	public function isRated($lid) {
		include __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT starStars FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		if($desc["starStars"] == 0) return false; 
		else return true;
	} 
	public function hasDiscord($acc) {
		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
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

		include __DIR__ . "/connection.php";
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
    	$cf_ips = array(
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
	    foreach ($cf_ips as $cf_ip) {
	        if (ipInRange::ipv4_in_range($ip, $cf_ip)) {
	            return true;
	        }
	    }
	    return false;
	}
	public function getIP(){
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $this->isCloudFlareIP($_SERVER['REMOTE_ADDR'])) //CLOUDFLARE REVERSE PROXY SUPPORT
  			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ipInRange::ipv4_in_range($_SERVER['REMOTE_ADDR'], '127.0.0.0/8')) //LOCALHOST REVERSE PROXY SUPPORT (7m.pl)
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		return $_SERVER['REMOTE_ADDR'];
	}
	public function checkModIPPermission($permission){
		include __DIR__ . "/connection.php";
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

		include __DIR__ . "/connection.php";
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

		include __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT count(*) FROM friendships WHERE person1 = :accountID AND person2 = :targetAccountID OR person1 = :targetAccountID AND person2 = :accountID");
		$query->execute([':accountID' => $accountID, ':targetAccountID' => $targetAccountID]);
		return $query->fetchColumn() > 0;
	}
	public function getMaxValuePermission($accountID, $permission){
		if(!is_numeric($accountID)) return false;

		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
		$diffName = $this->getDiffFromStars($stars)["name"];
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':stars' => $stars, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $diffName, ':timestamp' => time(), ':id' => $accountID, ':value2' => $stars, ':levelID' => $levelID]);
		$this->sendRateWebhook($accountID, $levelID);
	}
	public function featureLevel($accountID, $levelID, $state) {
		if(!is_numeric($accountID)) return false;
		include __DIR__ . "/connection.php";
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
		include __DIR__ . "/connection.php";
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
				$db_fid = rand(99, 9999999);
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
		include __DIR__ . "/connection.php";
		$query = $db->prepare("INSERT INTO suggest (suggestBy, suggestLevelID, suggestDifficulty, suggestStars, suggestFeatured, suggestAuto, suggestDemon, timestamp) VALUES (:account, :level, :diff, :stars, :feat, :auto, :demon, :timestamp)");
		$query->execute([':account' => $accountID, ':level' => $levelID, ':diff' => $difficulty, ':stars' => $stars, ':feat' => $feat, ':auto' => $auto, ':demon' => $demon, ':timestamp' => time()]);
		$this->sendSuggestWebhook($accountID, $levelID, $difficulty, $stars, $feat, $auto, $demon);
	}
 	public function isUnlisted($levelID) {
        include __DIR__."/connection.php";
        $query = $db->prepare("SELECT count(*) FROM levels WHERE unlisted = 1, levelID = :id");
        $query->execute([':id' => $levelID]);
        $query = $query->fetch();
        if(!empty($query)) return true; 
        else return false;
	}
	public function getListOwner($listID) {
		if(!is_numeric($listID)) return false;
		include __DIR__ . "/connection.php";
		$query = $db->prepare('SELECT accountID FROM lists WHERE listID = :id');
		$query->execute([':id' => $listID]);
		return $query->fetchColumn();
	}
	public function getListLevels($listID) {
		if(!is_numeric($listID)) return false;
		include __DIR__ . "/connection.php";
		$query = $db->prepare('SELECT listlevels FROM lists WHERE listID = :id');
		$query->execute([':id' => $listID]);
		return $query->fetchColumn();
	}
	public function getListDiffName($diff) {
		if($diff == -1) return 'N/A';
		$diffs = ['Auto', 'Easy', 'Normal', 'Hard', 'Harder', 'Extreme', 'Easy Demon', 'Medium Demon', 'Hard Demon', 'Insane Demon', 'Extreme Demon'];
		return $diffs[$diff];
	}
	public function getListName($listID) {
		if(!is_numeric($listID)) return false;
		include __DIR__ . "/connection.php";
		$query = $db->prepare('SELECT listName FROM lists WHERE listID = :id');
		$query->execute([':id' => $listID]);
		return $query->fetchColumn();
	}
	public function makeClanUsername($user) {
		include __DIR__ . "/../../config/dashboard.php";
		if($clansEnabled && $user['clan'] > 0 && !isset($_REQUEST['noClan'])) {
			$clan = $this->getClanInfo($user['clan'], 'tag');
			if(!empty($clan)) return '['.$clan.'] '.$user['userName'];
		}
		return $user['userName'];
	}
	public function updateLibraries($token, $expires, $mainServerTime, $type = 0) {
		include __DIR__ . "/../../config/dashboard.php";
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
			if ($types[$type] == 'music') {
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
				CURLOPT_RETURNTRANSFER => 1
			]);
			$newVersion = (int)curl_exec($curl);
			curl_close($curl);
			if($newVersion > $oldVersion[0]) {
				file_put_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt', $newVersion.', '.time());
				$download = curl_init($dataUrl.'?token='.$token.'&expires='.$expires.'&dashboard=1');
				curl_setopt_array($download, [
					CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
					CURLOPT_RETURNTRANSFER => 1
				]);
				$dat = curl_exec($download);
				file_put_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat', $dat);
				curl_close($download);
				$updatedLib = true;
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
		include __DIR__ . "/connection.php";
		include __DIR__ . "/exploitPatch.php";
		include __DIR__ . "/../../config/dashboard.php";
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
			$res = ExploitPatch::url_base64_decode($res);
			$res = zlib_decode($res);
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
								if(empty(trim($bits[1]))) continue 2;
								if(!isset($idsConverter['originalIDs'][$server][$bits[0]]) && !isset($idsConverter['IDs'][$bits[0]])) {
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
									if(!isset($idsConverter['originalIDs'][$server][$bits[3]]) && !isset($idsConverter['IDs'][$bits[3]])) {
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
						if(empty($song[0])) continue;
						if(!isset($idsConverter['originalIDs'][$server][$song[0]]) && !isset($idsConverter['IDs'][$song[0]])) {
							$idsConverter['count']++;
							$fuckText .= $song[1].' ('.$song[0].') was not found! New ID: '.$idsConverter['count'].PHP_EOL;
							$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $song[0], 'name' => $song[1], 'type' => $x];
							if($x == 1) {
								$idsConverter['IDs'][$idsConverter['count']]['size'] = $song[3];
								if(!isset($idsConverter['originalIDs'][$server][$song[2]]) && !isset($idsConverter['IDs'][$song[2]])) {
									$idsConverter['count']++;
									$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $song[2], 'type' => 0];
									$idsConverter['originalIDs'][$server][$song[2]] = $idsConverter['count'];
									$song[2] = $idsConverter['count'];
								} else $song[2] = $idsConverter['originalIDs'][$server][$song[2]];
								$idsConverter['IDs'][$idsConverter['count']]['authorID'] = $song[2];
							}
							$idsConverter['originalIDs'][$server][$song[0]] = $idsConverter['count'];
							$song[0] = $idsConverter['count'];
						} else {
							$fuckText .= $song[1].' ('.$song[0].') was found! ID: '.$idsConverter['originalIDs'][$server][$song[0]].PHP_EOL;
							$song[0] = $idsConverter['originalIDs'][$server][$song[0]];
							if($x == 1) {
								$idsConverter['IDs'][$idsConverter['count']]['size'] = $song[3];
								if(!isset($idsConverter['originalIDs'][$server][$song[2]]) && !isset($idsConverter['IDs'][$song[2]])) {
									$idsConverter['count']++;
									$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $song[2], 'type' => 0];
									$idsConverter['originalIDs'][$server][$song[2]] = $idsConverter['count'];
									$song[2] = $idsConverter['count'];
								} else $song[2] = $idsConverter['originalIDs'][$server][$song[2]];
								$idsConverter['IDs'][$idsConverter['count']]['authorID'] = $song[2];
							} elseif(!isset($idsConverter['IDs'][$song[0]]['name'])) $idsConverter['IDs'][$song[0]] = ['server' => $idsConverter['IDs'][$song[0]][0], 'ID' => $idsConverter['IDs'][$song[0]][1], 'name' => $song[1], 'type' => $x];
						}
						switch($x) {
							case 0:
								$library['authors'][$song[0]] = [
									'authorID' => $song[0],
									'name' => ExploitPatch::escapedat($song[1]),
									'link' => ExploitPatch::escapedat($song[2]),
									'yt' => ExploitPatch::escapedat($song[3])
								];
								break;
							case 1:
								$tags = explode('.', $song[5]);
								$newTags = [];
								foreach($tags AS &$tag) {
									if(empty($tag)) continue;
									if(!isset($idsConverter['originalIDs'][$server][$tag]) && !isset($idsConverter['IDs'][$tag])) {
										$idsConverter['count']++;
										$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $tag, 'type' => 2];
										$idsConverter['originalIDs'][$server][$tag] = $idsConverter['count'];
										$tag = $idsConverter['count'];
									} else $tag = $idsConverter['originalIDs'][$server][$tag];
									$newTags[] = $tag;
								}
								$newTags[] = $server;
								$tags = '.'.implode('.', $newTags).'.';
								$library['songs'][$song[0]] = [
									'ID' => $song[0],
									'name' => ExploitPatch::escapedat($song[1]),
									'authorID' => $song[2],
									'size' => $song[3],
									'seconds' => $song[4],
									'tags' => $tags
								];
								break;
							case 2:
								$library['tags'][$song[0]] = [
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
					$idsConverter['count']++;
					$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $customSFX['ID'], 'name' => $customSFX['userName'].'\'s SFXs', 'type' => 1];
					$idsConverter['originalIDs'][$server][$customSFX['reuploadID']] = $idsConverter['count'];
					$newID = $idsConverter['count'];
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
				$idsConverter['count']++;
				$idsConverter['IDs'][$idsConverter['count']] = ['server' => $server, 'ID' => $customSFX['ID'], 'name' => $customSFX['name'], 'type' => 0];
				$idsConverter['originalIDs'][$server][$customSFX['ID']] = $idsConverter['count'];
				$customSFX['ID'] = $idsConverter['count'];
				$library['files'][$customSFX['ID']] = $gdpsLibrary['files'][$customSFX['ID']] = [
					'name' => ExploitPatch::escapedat($customSFX['name']),
					'type' => 0,
					'parent' => (int)$idsConverter['originalIDs'][$server][$customSFX['reuploadID']],
					'bytes' => (int)$customSFX['size'],
					'milliseconds' => (int)($customSFX['milliseconds'] / 10)
				];
			}
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
			$songs = $db->prepare("SELECT songs.*, accounts.userName FROM songs JOIN accounts ON accounts.accountID = songs.reuploadID");
			$songs->execute();
			$songs = $songs->fetchAll();
			$folderID = $accIDs = $gdpsLibrary = [];
			$c = 0;
			foreach($songs AS &$customSongs) {
				$c++;
				$authorName = ExploitPatch::escapedat(ExploitPatch::rutoen(trim($customSongs['authorName'])));
				if(!isset($folderID[$authorName])) {
					$folderID[$authorName] = $c;
					$library['authors'][$serverIDs[null]. 0 .$folderID[$authorName]] = $gdpsLibrary['authors'][$serverIDs[null]. 0 .$folderID[$authorName]] = [
						'authorID' => ($serverIDs[null]. 0 .$folderID[$authorName]),
						'name' => $authorName,
						'link' => ' ',
						'yt' => ' '
					];
				}
				if(!isset($accIDs[$customSongs['reuploadID']])) {
					$accIDs[$customSongs['reuploadID']] = true;
					$library['tags'][$serverIDs[null]. 0 .$customSongs['reuploadID']] = $gdpsLibrary['tags'][$serverIDs[null]. 0 .$customSongs['reuploadID']] = [
						'ID' => ($serverIDs[null]. 0 .$customSongs['reuploadID']),
						'name' => ExploitPatch::escapedat($customSongs['userName']),
					];
				}
				$customSongs['name'] = trim($customSongs['name']);
				$library['songs'][$customSongs['ID']] = $gdpsLibrary['songs'][$customSongs['ID']] = [
					'ID' => ($customSongs['ID']),
					'name' => !empty($customSongs['name']) ? ExploitPatch::escapedat(ExploitPatch::rutoen($customSongs['name'])) : 'Unnamed',
					'authorID' => ($serverIDs[null]. 0 .$folderID[$authorName]),
					'size' => ($customSongs['size'] * 1024 * 1024),
					'seconds' => $customSongs['duration'],
					'tags' => '.'.$serverIDs[null].'.'.$serverIDs[null]. 0 .$customSongs['reuploadID'].'.'
				];
			}
			foreach($library['authors'] AS &$authorList) $authorsEncrypted[] = implode(',', $authorList);
			foreach($library['songs'] AS &$songsList) $songsEncrypted[] = implode(',', $songsList);
			foreach($library['tags'] AS &$tagsList) $tagsEncrypted[] = implode(',', $tagsList);
			$encrypted = $version."|".implode(';', $authorsEncrypted).";|" .implode(';', $songsEncrypted).";|" .implode(';', $tagsEncrypted).';';
			$authorsEncrypted = $songsEncrypted = $tagsEncrypted = [];
			foreach($gdpsLibrary['authors'] AS &$authorList) $authorsEncrypted[] = implode(',', $authorList);
			foreach($gdpsLibrary['songs'] AS &$songsList) $songsEncrypted[] = implode(',', $songsList);
			foreach($gdpsLibrary['tags'] AS &$tagsList) $tagsEncrypted[] = implode(',', $tagsList);
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
		include __DIR__."/../../config/dashboard.php";
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
	public function getLibrarySongInfo($id, $type = 'music') {
		include __DIR__."/../../config/dashboard.php";
		if(!file_exists(__DIR__.'/../../'.$type.'/ids.json')) return false;
		$servers = $serverIDs = $serverNames = [];
		foreach($customLibrary AS $customLib) {
			$servers[$customLib[0]] = $customLib[2];
			$serverNames[$customLib[0]] = $customLib[1];
			$serverIDs[$customLib[2]] = $customLib[0];
		}
		$library = json_decode(file_get_contents(__DIR__.'/../../'.$type.'/ids.json'), true);
		if(!isset($library['IDs'][$id])) return false;
		if($type == 'music') {
			$song = $library['IDs'][$id];
			$author = $library['IDs'][$song['authorID']];
			$token = $this->randomString(11);
			$expires = time() + 3600;
			$link = $servers[$song['server']].'/music/'.$song['ID'].'.ogg?token='.$token.'&expires='.$expires;
			return ['server' => $song['server'], 'ID' => $id, 'name' => $song['name'], 'authorID' => $song['authorID'], 'authorName' => $author['name'], 'size' => round($song['size'] / 1024 / 1024, 2), 'download' => $link];
		} else {
			$SFX = $library['IDs'][$id];
			$token = $this->randomString(11);
			$expires = time() + 3600;
			$type = $type == 'sfx' ? 'sfx/s' : 'music/';
			$link = $servers[$SFX['server']] != null ? $servers[$SFX['server']].'/'.$type.$SFX['ID'].'.ogg?token='.$token.'&expires='.$expires : $this->getSFXInfo($SFX['ID'], 'download');
			return ['server' => $SFX['server'], 'ID' => $id, 'name' => $song['name'], 'download' => $link];
		}
	}
	public function sendRateWebhook($modAccID, $levelID) {
		include __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) include_once __DIR__."/exploitPatch.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($modAccID) OR !is_numeric($levelID) OR !in_array("rate", $webhooksToEnable)) return false;
		include_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
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
		$stats = $downloadEmoji.' '.$level['downloads'].' | '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
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
		include __DIR__."/../../config/webhooks/lang/".$lang.".php";
		return $webhookLang;
	}
	public function webhookLanguage($langString, $webhookLangArray) {
		if(isset($webhookLangArray[$langString])) {
			if(is_array($webhookLangArray[$langString])) return $webhookLangArray[$langString][rand(0, count($webhookLangArray[$langString]) - 1)];
			else return $webhookLangArray[$langString];
		}
		return false;
	}
	public function changeDifficulty($accountID, $levelID, $difficulty, $auto, $demon) {
		if(!is_numeric($accountID)) return false;
		include __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $diffName, ':timestamp' => time(), ':id' => $accountID, ':value2' => 0, ':levelID' => $levelID]);
	}
	public function sendSuggestWebhook($modAccID, $levelID, $difficulty, $stars, $featured, $auto, $demon) {
		include __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) include __DIR__."/exploitPatch.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($modAccID) OR !is_numeric($levelID) OR !in_array("suggest", $webhooksToEnable)) return false;
		include_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
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
		$stats = $downloadEmoji.' '.$level['downloads'].' | '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
		$levelField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
		$IDField = [$this->webhookLanguage('levelIDTitle', $webhookLangArray), $level['levelID'], true];
		if($stars == 1) $action = 0; elseif(($stars < 5 AND $stars != 0) AND !($stars > 9 AND $stars < 20)) $action = 1; else $action = 2;
		$difficultyField = [$this->webhookLanguage('difficultyTitle', $webhookLangArray), sprintf($this->webhookLanguage('difficultyDesc' . ($level['levelLength'] == 5 ? 'Moon' : '') . $action, $webhookLangArray), $difficulty, $level['starStars']), true];
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
	public function sendDemonlistRecordWebhook($recordAccID, $recordID) {
		include __DIR__."/connection.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($recordAccID) OR !is_numeric($recordID) OR !in_array("demonlist", $webhooksToEnable)) return false;
		include_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($dlApproveWebhook);
		$record = $db->prepare('SELECT * FROM dlsubmits WHERE ID = :ID');
		$record->execute([':ID' => $recordID]);
		$record = $record->fetch();
		if(!$record) return false;
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :ID');
		$level->execute([':ID' => $record['levelID']]);
		$level = $level->fetch();
		if(!$level) return false;
		$recordUsername = $this->getAccountName($recordAccID);
		$recordHasDiscord = $this->hasDiscord($recordAccID);
		$recordFormattedUsername = $recordHasDiscord ? "<@".$recordHasDiscord.">" : "**".$recordUsername."**";
		$creatorAccID = $level['extID'];
		$creatorUsername = $this->getAccountName($creatorAccID);
		$creatorHasDiscord = $this->hasDiscord($creatorAccID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		$setColor = $pendingColor;
		$setTitle = $this->webhookLanguage('demonlistTitle', $webhookLangArray);
		$setDescription = sprintf($this->webhookLanguage('demonlistDesc', $webhookLangArray), $recordFormattedUsername, '**'.$level['levelName'].'**', $demonlistLink.'/approve.php?str='.$record['auth']);
		$recordField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
		$authorField = [$this->webhookLanguage('recordAuthorTitle', $webhookLangArray), $recordFormattedUsername, true];
		if($record['atts'] == 1) $action = 0; elseif(($record['atts'] < 5 AND $record['atts'] != 0) AND !($record['atts'] > 9 AND $record['atts'] < 20)) $action = 1; else $action = 2;
		$attemptsField = [$this->webhookLanguage('recordAttemptsTitle', $webhookLangArray), sprintf($this->webhookLanguage('recordAttemptsDesc'.$action, $webhookLangArray), $record['atts']), true];
		$proofField = [$this->webhookLanguage('recordProofTitle', $webhookLangArray), "https://youtu.be/".$record['ytlink'], true];
		$setThumbnail = $demonlistThumbnailURL;
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($dlsubmitNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $rateTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($recordField, $authorField, $attemptsField, $proofField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
	}
	public function sendDemonlistResultWebhook($modAccID, $recordID) {
		include __DIR__."/connection.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($modAccID) OR !is_numeric($recordID) OR !in_array("demonlist", $webhooksToEnable)) return false;
		include_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($dlWebhook);
		$record = $db->prepare('SELECT * FROM dlsubmits WHERE ID = :ID');
		$record->execute([':ID' => $recordID]);
		$record = $record->fetch();
		if(!$record) return false;
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :ID');
		$level->execute([':ID' => $record['levelID']]);
		$level = $level->fetch();
		if(!$level) return false;
		$modUsername = $this->getAccountName($modAccID);
		$modHasDiscord = $this->hasDiscord($modAccID);
		$modFormattedUsername = $modHasDiscord ? "<@".$modHasDiscord.">" : "**".$modUsername."**";
		$recordAccID = $record['accountID'];
		$recordUsername = $this->getAccountName($recordAccID);
		$recordHasDiscord = $this->hasDiscord($recordAccID);
		$recordFormattedUsername = $recordHasDiscord ? "<@".$recordHasDiscord.">" : "**".$recordUsername."**";
		$creatorAccID = $level['extID'];
		$creatorUsername = $this->getAccountName($creatorAccID);
		$creatorHasDiscord = $this->hasDiscord($creatorAccID);
		$creatorFormattedUsername = $creatorHasDiscord ? "<@".$creatorHasDiscord.">" : "**".$creatorUsername."**";
		if($record['approve'] == '1') {
			$setColor = $successColor;
			$setTitle = $this->webhookLanguage('demonlistApproveTitle', $webhookLangArray);
			$dmTitle = $this->webhookLanguage('demonlistApproveTitleDM', $webhookLangArray);
			$setDescription = sprintf($this->webhookLanguage('demonlistApproveDesc', $webhookLangArray), $modFormattedUsername, $recordFormattedUsername, '**'.$level['levelName'].'**');
			$dmDescription = sprintf($this->webhookLanguage('demonlistApproveDescDM', $webhookLangArray), $modFormattedUsername, '**'.$level['levelName'].'**');
		} else {
			$setColor = $failColor;
			$setTitle = $this->webhookLanguage('demonlistDenyTitle', $webhookLangArray);
			$dmTitle = $this->webhookLanguage('demonlistDenyTitleDM', $webhookLangArray);
			$setDescription = sprintf($this->webhookLanguage('demonlistDenyDesc', $webhookLangArray), $modFormattedUsername, $recordFormattedUsername, '**'.$level['levelName'].'**');
			$dmDescription = sprintf($this->webhookLanguage('demonlistDenyDescDM', $webhookLangArray), $modFormattedUsername, '**'.$level['levelName'].'**');
		}
		$recordField = [$this->webhookLanguage('levelTitle', $webhookLangArray), sprintf($this->webhookLanguage('levelDesc', $webhookLangArray), '**'.$level['levelName'].'**', $creatorFormattedUsername), true];
		$authorField = [$this->webhookLanguage('recordAuthorTitle', $webhookLangArray), $recordFormattedUsername, true];
		if($record['atts'] == 1) $action = 0; elseif(($record['atts'] < 5 AND $record['atts'] != 0) AND !($record['atts'] > 9 AND $record['atts'] < 20)) $action = 1; else $action = 2;
		$attemptsField = [$this->webhookLanguage('recordAttemptsTitle', $webhookLangArray), sprintf($this->webhookLanguage('recordAttemptsDesc'.$action, $webhookLangArray), $record['atts']), true];
		$proofField = [$this->webhookLanguage('recordProofTitle', $webhookLangArray), "https://youtu.be/".$record['ytlink'], true];
		$setThumbnail = $demonlistThumbnailURL;
		$setFooter = sprintf($this->webhookLanguage('footer', $webhookLangArray), $gdps);
		$dw->newMessage()
		->setContent($dlresultNotificationText)
		->setAuthor($gdps, $authorURL, $authorIconURL)
		->setColor($setColor)
		->setTitle($setTitle, $demonlistTitleURL)
		->setDescription($setDescription)
		->setThumbnail($setThumbnail)
		->addFields($recordField, $authorField, $attemptsField, $proofField)
		->setFooter($setFooter, $footerIconURL)
		->setTimestamp()
		->send();
		if($dmNotifications && $recordHasDiscord) {
			$embed = $this->generateEmbedArray(
				[$gdps, $authorURL, $authorIconURL],
				$setColor,
				[$dmTitle, $demonlistTitleURL],
				$dmDescription,
				$setThumbnail,
				[$recordField, $authorField, $attemptsField, $proofField],
				[$setFooter, $footerIconURL]
			);
			$json = json_encode([
				"content" => "",
				"tts" => false,
				"embeds" => [$embed]
			], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			$this->sendDiscordPM($recordHasDiscord, $json, true);
		}
	}
	public function sendBanWebhook($banID, $modAccID) {
		include __DIR__."/connection.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($banID) OR !is_numeric($modAccID) OR !in_array("ban", $webhooksToEnable)) return false;
		include_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
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
		include __DIR__."/connection.php";
		if(!class_exists('ExploitPatch')) include __DIR__."/exploitPatch.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		if(!$webhooksEnabled OR !is_numeric($levelID) OR !is_numeric($type) OR !in_array("daily", $webhooksToEnable)) return false;
		include_once __DIR__."/../../config/webhooks/DiscordWebhook.php";
		$webhookLangArray = $this->webhookStartLanguage($webhookLanguage);
		$dw = new DiscordWebhook($dailyWebhook);
		$level = $db->prepare('SELECT * FROM levels WHERE levelID = :levelID');
		$level->execute([':levelID' => $levelID]);
		$level = $level->fetch();
		if(!$level) return false;
		$daily = $db->prepare('SELECT * FROM dailyfeatures WHERE levelID = :levelID AND type = :type');
		$daily->execute([':levelID' => $levelID, ':type' => $type]);
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
				$dmTitle = $this->webhookLanguage('eventDM', $webhookLangArray);
				$setDescription = $this->webhookLanguage('eventDesc', $webhookLangArray);
				$dmDescription = sprintf($this->webhookLanguage('eventDescDM', $webhookLangArray), $tadaEmoji);
				$setNotificationText = $eventNotificationText;
				break;
		}
		$stats = $downloadEmoji.' '.$level['downloads'].' | '.($level['likes'] - $level['dislikes'] >= 0 ? $likeEmoji.' '.abs($level['likes'] - $level['dislikes']) : $dislikeEmoji.' '.abs($level['likes'] - $level['dislikes']));
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
		include __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute();
		return $bans->fetchAll();
	}
	public function getAllBansFromPerson($person, $personType, $onlyActive = true) {
		include __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans WHERE person = :person AND personType = :personType'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute([':person' => $person, ':personType' => $personType]);
		return $bans->fetchAll();
	}
	public function getAllBansOfPersonType($personType, $onlyActive = true) {
		include __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans WHERE personType = :personType'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute([':personType' => $personType]);
		return $bans->fetchAll();
	}
	public function getAllBansOfBanType($banType, $onlyActive = true) {
		include __DIR__."/connection.php";
		$bans = $db->prepare('SELECT * FROM bans WHERE banType = :banType'.($onlyActive ? ' AND isActive = 1' : '').' ORDER BY timestamp DESC');
		$bans->execute([':banType' => $banType]);
		return $bans->fetchAll();
	}
	public function banPerson($modID, $person, $reason, $banType, $personType, $expires) {
		include __DIR__."/connection.php";
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
			if($check['expires'] < $expires) return true;
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
		include __DIR__."/connection.php";
		$ban = $db->prepare('SELECT * FROM bans WHERE person = :person AND personType = :personType AND banType = :banType AND isActive = 1 ORDER BY timestamp DESC');
		$ban->execute([':person' => $person, ':personType' => $personType, ':banType' => $banType]);
		return $ban->fetch();
	}
	public function unbanPerson($banID, $modID) {
		include __DIR__."/connection.php";
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
		include __DIR__."/connection.php";
		$ban = $db->prepare('SELECT * FROM bans WHERE banID = :banID');
		$ban->execute([':banID' => $banID]);
		return $ban->fetch();
	}
	public function getPersonBan($accountID, $userID, $banType, $IP = false) {
		include __DIR__."/connection.php";
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
		include __DIR__."/connection.php";
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
  	public function mail($mail = '', $user = '', $isForgotPass = false) {
		if(empty($mail) OR empty($user)) return;
		include __DIR__."/../../config/mail.php";
		if($mailEnabled) {
			include __DIR__."/connection.php";
			include __DIR__."/../../config/dashboard.php";
			include __DIR__."/../../config/mail/PHPMailer.php";
			include __DIR__."/../../config/mail/SMTP.php";
			include __DIR__."/../../config/mail/Exception.php";
			$m = new PHPMailer\PHPMailer\PHPMailer();
			$m->CharSet = 'utf-8';
			$m->isSMTP();
			$m->SMTPAuth = true;
			$m->Host = $mailbox;
			$m->Username = $mailuser;
			$m->Password = $mailpass;
			$m->Port = $mailport;
			if($mailtype) $m->SMTPSecure = $mailtype;
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