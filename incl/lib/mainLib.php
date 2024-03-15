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
			"Monster Dance Off by F-777"];
		if($id < 0 || $id >= count($songs))
			return "Unknown by DJVI";
		return $songs[$id];
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
		$gauntlets = ["Unknown", "Fire", "Ice", "Poison", "Shadow", "Lava", "Bonus", "Chaos", "Demon", "Time", "Crystal", "Magic", "Spike", "Monster", "Doom", "Death", 'Forest', 'Rune', 'Force', 'Spooky', 'Dragon', 'Water', 'Haunted', 'Acid', 'Witch', 'Power', 'Potion', 'Snake', 'Toxic', 'Halloween', 'Treasure', 'Ghost', 'Spider', 'Gem', 'Inferno', 'Portal', 'Strange', 'Fantasy', 'Christmas', 'Surprise', 'Mystery', 'Cursed', 'Cyborg', 'Castle', 'Grave', 'Temple', 'World', 'Galaxy', 'Universe', 'Discord', 'Split'];
		if($wholeArray) return $gauntlets;
		if($id < 0 || $id >= count($gauntlets))
			return $gauntlets[0];
		return $gauntlets[$id];
	}
	public function getGauntletCount() {
		return count($this->getGauntletName(0, true))-1;
	}
	function makeTime($delta)
	{
		if ($delta < 31536000)
		{
			if ($delta < 2628000)
			{
				if ($delta < 604800)
				{
					if ($delta < 86400)
					{
						if ($delta < 3600)
						{
							if ($delta < 60)
							{
								return $delta." second".($delta == 1 ? "" : "s");
							}
							else
							{
                        					$rounded = floor($delta / 60);
								return $rounded." minute".($rounded == 1 ? "" : "s");
							}
						}
						else
						{
							$rounded = floor($delta / 3600);
							return $rounded." hour".($rounded == 1 ? "" : "s");
						}
					}
					else
					{
						$rounded = floor($delta / 86400);
						return $rounded." day".($rounded == 1 ? "" : "s");
					}
				}
				else
				{
					$rounded = floor($delta / 604800);
					return $rounded." week".($rounded == 1 ? "" : "s");
				}
			}
			else
			{
				$rounded = floor($delta / 2628000); 
				return $rounded." month".($rounded == 1 ? "" : "s");
			}
		}
		else
		{
			$rounded = floor($delta / 31536000);
			return $rounded." year".($rounded == 1 ? "" : "s");
		}
	}
	public function getIDFromPost(){
		include __DIR__ . "/../../config/security.php";
		include_once __DIR__ . "/exploitPatch.php";
		include_once __DIR__ . "/GJPCheck.php";

		if(!empty($_POST["udid"]) AND $_POST['gameVersion'] < 20 AND $unregisteredSubmissions) 
		{
			$id = ExploitPatch::remove($_POST["udid"]);
			if(is_numeric($id)) exit("-1");
		}
		elseif(!empty($_POST["accountID"]) AND $_POST["accountID"]!="0")
		{
			$id = GJPCheck::getAccountIDOrDie();
		}
		else
		{
			exit("-1");
		}
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
		/*include __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT extID FROM users WHERE userID = :id");
		$query->execute([':id' => $userID]);
		$userdata = $query->fetch();
		$query = $db->prepare("SELECT userName FROM accounts WHERE accountID = :id");
		$query->execute([':id' => $extID]);
		$userName = $query->fetch();*/
		$extID = is_numeric($userdata['extID']) ? $userdata['extID'] : 0;
		return "{$userdata['userID']}:{$userdata["userName"]}:{$extID}";
	}
	public function getSongString($song){
		include __DIR__ . "/connection.php";
		include_once __DIR__ . "/exploitPatch.php";
		/*$query3=$db->prepare("SELECT ID,name,authorID,authorName,size,isDisabled,download FROM songs WHERE ID = :songid LIMIT 1");
		$query3->execute([':songid' => $songID]);*/
		if($song['ID'] == 0 || empty($song['ID'])){
			return false;
		}
		//$song = $query3->fetch();
		if($song["isDisabled"] == 1){
			return false;
		}
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
	    if(empty($sinfo)) return false;
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
	            if($column != "clan" AND $column != "desc") return $claninfo[$column];
	            else return base64_decode($claninfo[$column]);
	        }
	        else return array("ID" => $claninfo["ID"], "clan" => base64_decode($claninfo["clan"]), "desc" => base64_decode($claninfo["desc"]), "clanOwner" => $claninfo["clanOwner"], "color" => $claninfo["color"], "isClosed" => $claninfo["isClosed"], "creationDate" => $claninfo["creationDate"]);
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
	public function sendDiscordPM($receiver, $message){
		include __DIR__ . "/../../config/discord.php";
		if(!$discordEnabled){
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
		curl_setopt($crl, CURLOPT_POSTFIELDS, $data_string);
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
		$desc = $db->prepare("SELECT levelDesc FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		if(empty($desc["levelDesc"])) return !$dashboard ? '*This level doesn\'t have description*' : '<text style="font-style:italic">This level doesn\'t have description</text>';
		else return base64_decode($desc["levelDesc"]);
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
		if (empty($roleIDarray)) {
			return false;
		}
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
	public function rateLevel($accountID, $levelID, $stars, $difficulty, $auto, $demon){
		if(!is_numeric($accountID)) return false;
		include __DIR__ . "/connection.php";
		$diffName = $this->getDiffFromStars($stars)["name"];
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':stars' => $stars, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $diffName, ':timestamp' => time(), ':id' => $accountID, ':value2' => $stars, ':levelID' => $levelID]);
	}
	public function featureLevel($accountID, $levelID, $state) {
		if(!is_numeric($accountID)) return false;
		switch($state) {
            case 0:
                $feature = 0;
                $epic = 0;
                break;
            case 1:
                $feature = 1;
                $epic = 0;
                break;
            case 2: // Stole from TheJulfor
                $feature = 1;
                $epic = 1;
                break;
            case 3:
                $feature = 1;
                $epic = 2;
                break;
            case 4:
                $feature = 1;
                $epic = 3;
                break;
        }
		include __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starFeatured=:feature, starEpic=:epic, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
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
	public function suggestLevel($accountID, $levelID, $difficulty, $stars, $feat, $auto, $demon){
		if(!is_numeric($accountID)) return false;
		include __DIR__ . "/connection.php";
		$query = "INSERT INTO suggest (suggestBy, suggestLevelID, suggestDifficulty, suggestStars, suggestFeatured, suggestAuto, suggestDemon, timestamp) VALUES (:account, :level, :diff, :stars, :feat, :auto, :demon, :timestamp)";
		$query = $db->prepare($query);
		$query->execute([':account' => $accountID, ':level' => $levelID, ':diff' => $difficulty, ':stars' => $stars, ':feat' => $feat, ':auto' => $auto, ':demon' => $demon, ':timestamp' => time()]);
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
	public function updateLibraries($token, $expires, $mainServerTime, $type = 0) {
		include __DIR__ . "/../../config/dashboard.php";
		$servers = [];
		$types = ['sfx', 'music'];
		foreach($customLibrary AS $library) {
			if($library[2] !== null) {
				$servers['s'.$library[0]] = $library[2];
			}
		}
		$updatedLib = false;
		foreach($servers AS $key => &$server) {
			if(file_exists(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt')) $oldVersion = explode(', ', file_get_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt'));
			else $oldVersion = [0, 0];
			if($oldVersion[1] + 600 > time()) continue; // Download library only once per 10 minutes
			$curl = curl_init($server.'/'.$types[$type].'/'.$types[$type].'library_version.txt?token='.$token.'&expires='.$expires);
			curl_setopt_array($curl, [
				CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
				CURLOPT_RETURNTRANSFER => 1
			]);
			$newVersion = (int)curl_exec($curl);
			curl_close($curl);
			$jsonVersion = $newVersion.', '.time();
			file_put_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.txt', $jsonVersion);
			if($newVersion > $oldVersion[0]) {
				$download = curl_init($server.'/'.$types[$type].'/'.$types[$type].'library.dat?token='.$token.'&expires='.$expires);
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
		$library = $servers = $serverIDs = [];
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
		foreach($servers AS $key => $server) {
			if(!file_exists(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat')) continue;
			$res = null;
			$bits = null;
			$res = file_get_contents(__DIR__.'/../../'.$types[$type].'/'.$key.'.dat');
			$res = mb_convert_encoding($res, 'UTF-8', 'UTF-8');
			$res = base64_decode(strtr($res, '-_.', '+/='));
			$res = zlib_decode($res);
			$res = explode('|', $res);
			if(!$type) {
				for($i = 0; $i < count($res); $i++) { // SFX library decoding was made by MigMatos
					$res[$i] = explode(';', $res[$i]);
					//array_pop($res[$i]);
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
								if(empty(trim($bits[1]))) continue;
								$bits[0] = $server . 0 . $bits[0];
								$bits[3] = $server . 0 . $bits[3];
								if($bits[2]) {
									$library['folders'][$bits[0]] = [
										'name' => ExploitPatch::escapedat($bits[1]),
										'type' => (int)$bits[2],
										'parent' => (int)($bits[3] == $server. '01' ? (1 + $server) : $bits[3])
									];
								} else {
									$library['files'][$bits[0]] = [
										'name' => ExploitPatch::escapedat($bits[1]),
										'type' => (int)$bits[2],
										'parent' => (int)($bits[3] == $server. '01' ? (1 + $server) : $bits[3]),
										'bytes' => (int)$bits[4],
										'milliseconds' => (int)$bits[5],
									];
								}
								break;
							case 1: // Credit
								if(empty(trim($bits[0])) || empty(trim($bits[1]))) continue;
								$library['credits'][] = [
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
						$song[0] = $server . 0 . $song[0];
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
								$song[2] = $server . 0 . $song[2];
								$song[4] = $server . 0 . $song[4];
								$tags = explode('.', $song[5]);
								$newTags = [];
								foreach($tags AS &$tag) {
									if(empty($tag)) continue;
									$newTags[] = $server. 0 .$tag;
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
			$folderID = [];
			foreach($sfxs AS &$customSFX) {
				if(!isset($folderID[$customSFX['reuploadID']])) {
					$library['folders'][$serverIDs[null]. 0 .$customSFX['reuploadID']] = [
						'name' => ExploitPatch::escapedat($customSFX['userName']).'\'s SFXs',
						'type' => 1,
						'parent' => (int)($serverIDs[null] + 1)
					];
					$folderIDs[$customSFX['reuploadID']] = true;
				}
				$library['files'][$serverIDs[null]. 0 .$customSFX['ID']] = [
					'name' => ExploitPatch::escapedat($customSFX['name']),
					'type' => 0,
					'parent' => (int)($serverIDs[null]. 0 .$customSFX['reuploadID']),
					'bytes' => (int)$customSFX['size'],
					'milliseconds' => (int)$customSFX['milliseconds']
				];
			}
			foreach($library['folders'] AS $id => &$folder) $filesEncrypted[$id] = implode(',', [$id, $folder['name'], 1, $folder['parent'], 0, 0]);
			foreach($library['files'] AS $id => &$file) $filesEncrypted[$id] = implode(',', [$id, $file['name'], 0, $file['parent'], $file['bytes'], $file['milliseconds']]);
			foreach($library['credits'] AS &$credit) $creditsEncrypted[] = implode(',', [$credit['name'], $credit['website']]);
			$encrypted = $version.";".implode(';', $filesEncrypted)."|" .implode(';', $creditsEncrypted).';';
		} else {
			$songs = $db->prepare("SELECT songs.*, accounts.userName FROM songs JOIN accounts ON accounts.accountID = songs.reuploadID");
			$songs->execute();
			$songs = $songs->fetchAll();
			$folderID = $accIDs = [];
			$c = 0;
			foreach($songs AS &$customSongs) {
				$c++;
				$authorName = ExploitPatch::escapedat(ExploitPatch::rutoen(trim($customSongs['authorName'])));
				if(!isset($folderID[$authorName])) {
					$folderID[$authorName] = $c;
					$library['authors'][$serverIDs[null]. 0 .$folderID[$authorName]] = [
						'authorID' => ($serverIDs[null]. 0 .$folderID[$authorName]),
						'name' => $authorName,
						'link' => ' ',
						'yt' => ' '
					];
				}
				if(!isset($accIDs[$customSongs['reuploadID']])) {
					$accIDs[$customSongs['reuploadID']] = true;
					$library['tags'][$serverIDs[null]. 0 .$customSongs['reuploadID']] = [
						'ID' => ($serverIDs[null]. 0 .$customSongs['reuploadID']),
						'name' => ExploitPatch::escapedat($customSongs['userName']),
					];
				}
				$customSongs['name'] = trim($customSongs['name']);
				$library['songs'][$customSongs['ID']] = [
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
		}
		$encrypted = zlib_encode($encrypted, ZLIB_ENCODING_DEFLATE);
		$encrypted = strtr(base64_encode($encrypted), '+/=', '-_=');
		file_put_contents(__DIR__.'/../../'.$types[$type].'/gdps.dat', $encrypted);
	}
	public function getAudioDuration($file) {
		require_once(__DIR__.'/../../config/getid3/getid3.php');
		$getID3 = new getID3;
		$info = $getID3->analyze($file);
		$result = (isset($info['playtime_seconds']) ? (int)($info['playtime_seconds']) : false);
		return $result;
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
