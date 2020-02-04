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
			default:
				$diffname = "N/A: " . $stars;
				$diff = 0;
				$demon = 0;
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
	public function getGauntletName($id){
		switch($id){
		case 1:
			$gauntletname = "Fire";
			break;
		case 2:
			$gauntletname = "Ice";
			break;
		case 3:
			$gauntletname = "Poison";
			break;
		case 4:
			$gauntletname = "Shadow";
			break;
		case 5:
			$gauntletname = "Lava";
			break;
		case 6:
			$gauntletname = "Bonus";
			break;
		case 7:
			$gauntletname = "Chaos";
			break;
		case 8:
			$gauntletname = "Demon";
			break;
		case 9:
			$gauntletname = "Time";
			break;
		case 10:
			$gauntletname = "Crystal";
			break;
		case 11:
			$gauntletname = "Magic";
			break;
		case 12:
			$gauntletname = "Spike";
			break;
		case 13:
			$gauntletname = "Monster";
			break;
		case 14:
			$gauntletname = "Doom";
			break;
		case 15:
			$gauntletname = "Death";
			break;
		default:
			$gauntletname = "Unknown";
			break;
		}
		return $gauntletname;
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
	public function getUserString($userID) {
		include __DIR__ . "/connection.php";
		$query = $db->prepare("SELECT userName, extID FROM users WHERE userID = :id");
		$query->execute([':id' => $userID]);
		$userdata = $query->fetch();
		if(is_numeric($userdata["extID"])){
			$extID = $userdata["extID"];
		}else{
			$extID = 0;
		}
		return $userID . ":" . $userdata["userName"] . ":" . $extID;
	}
	public function getSongString($songID){
		include __DIR__ . "/connection.php";
		$query3=$db->prepare("SELECT ID,name,authorID,authorName,size,isDisabled,download FROM songs WHERE ID = :songid LIMIT 1");
		$query3->execute([':songid' => $songID]);
		if($query3->rowCount() == 0){
			return false;
		}
		$result4 = $query3->fetch();
		if($result4["isDisabled"] == 1){
			return false;
		}
		$dl = $result4["download"];
		if(strpos($dl, ':') !== false){
			$dl = urlencode($dl);
		}
		return "1~|~".$result4["ID"]."~|~2~|~".str_replace("#", "", $result4["name"])."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~0";
	}
	public function sendDiscordPM($receiver, $message){
		include __DIR__ . "/../../config/discord.php";
		if($discordEnabled != 1){
			return false;
		}
		//findind the channel id
		$data = array("recipient_id" => $receiver);                                                                    
		$data_string = json_encode($data);
		$url = "https://discordapp.com/api/v6/users/@me/channels";
		//echo $url;
		$crl = curl_init($url);
		$headr = array();
		$headr['User-Agent'] = 'CvoltonGDPS (http://pi.michaelbrabec.cz:9010, 1.0)';
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($crl, CURLOPT_POSTFIELDS, $data_string);
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bot '.$bottoken;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($crl);
		curl_close($crl);
		$responseDecode = json_decode($response, true);
		$channelID = $responseDecode["id"];
		//sending the msg
		$data = array("content" => $message);                                                                    
		$data_string = json_encode($data);
		$url = "https://discordapp.com/api/v6/channels/".$channelID."/messages";
		//echo $url;
		$crl = curl_init($url);
		$headr = array();
		$headr['User-Agent'] = 'CvoltonGDPS (http://pi.michaelbrabec.cz:9010, 1.0)';
		curl_setopt($crl, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($crl, CURLOPT_POSTFIELDS, $data_string);
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bot '.$bottoken;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($crl);
		curl_close($crl);
		return $response;
	}
	public function getDiscordAcc($discordID){
		include __DIR__ . "/../../config/discord.php";
		///getting discord acc info
		$url = "https://discordapp.com/api/v6/users/".$discordID;
		$crl = curl_init($url);
		$headr = array();
		$headr['User-Agent'] = 'CvoltonGDPS (http://pi.michaelbrabec.cz:9010, 1.0)';
		$headr[] = 'Content-type: application/json';
		$headr[] = 'Authorization: Bot '.$bottoken;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1); 
		$response = curl_exec($crl);
		curl_close($crl);
		$userinfo = json_decode($response, true);
		//var_dump($userinfo);
		return $userinfo["username"] . "#" . $userinfo["discriminator"];
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
			'104.16.0.0/12',
			'172.64.0.0/13',
			'131.0.72.0/22'
	    );
	    foreach ($cf_ips as $cf_ip) {
	        if (ip_in_range($ip, $cf_ip)) {
	            return true;
	        }
	    }
	    return false;
	}
	public function getIP(){
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]) && $this->isCloudFlareIP($_SERVER['REMOTE_ADDR'])) {
  			return $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
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
	public function getMaxValuePermission($accountID, $permission){
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
		$role = $query->fetch();
		return $role["commentColor"];
	}
	public function rateLevel($accountID, $levelID, $stars, $difficulty, $auto, $demon){
		include __DIR__ . "/connection.php";
		//lets assume the perms check is done properly before
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':stars' => $stars, ':levelID'=>$levelID, ':now' => time()]);
		
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $this->getDiffFromStars($stars)["name"], ':timestamp' => time(), ':id' => $accountID, ':value2' => $stars, ':levelID' => $levelID]);
		
		
	}
	public function featureLevel($accountID, $levelID, $feature){
		include __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starFeatured=:feature, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':feature' => $feature, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $feature, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
	public function verifyCoinsLevel($accountID, $levelID, $coins){
		include __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starCoins=:coins WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':coins' => $coins, ':levelID'=>$levelID]);
		
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $coins, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
	public function songReupload($url){
		require __DIR__ . "/../../incl/lib/connection.php";
		require __DIR__ . "/../../incl/lib/exploitPatch.php";
		include __DIR__ . "/../../config/songAdd.php";
		$ep = new exploitPatch();
		$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$url);
		if (filter_var($song, FILTER_VALIDATE_URL) == TRUE) {
			if(strpos($song, 'soundcloud.com') !== false){
				$songinfo = file_get_contents("https://api.soundcloud.com/resolve.json?url=".$song."&client_id=".$api_key);
				$array = json_decode($songinfo);
				if($array->downloadable == true){
					$song = trim($array->download_url . "?client_id=".$api_key);
					$name = $ep->remove($array->title);
					$author = $array->user->username;
					$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
				}else{
					if(!$array->id){
						return "-4";
					}
					$song = trim("https://api.soundcloud.com/tracks/".$array->id."/stream?client_id=".$api_key);
					$name = $ep->remove($array->title);
					$author = $array->user->username;
					$author = preg_replace("/[^A-Za-z0-9 ]/", '', $author);
				}
			}else{
				$song = str_replace(["?dl=0","?dl=1"],"",$song);
				$song = trim($song);
				$name = $ep->remove(urldecode(str_replace([".mp3",".webm",".mp4",".wav"], "", basename($song))));
				$author = "Reupload";
			}
			$size = $this->getFileSize($song);
			$size = round($size / 1024 / 1024, 2);
			$hash = "";
			$query = $db->prepare("SELECT count(*) FROM songs WHERE download = :download");
			$query->execute([':download' => $song]);	
			$count = $query->fetchColumn();
			if($count != 0){
				return "-3";
			}else{
				$query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download, hash)
				VALUES (:name, '9', :author, :size, :download, :hash)");
				$query->execute([':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash]);
				return $db->lastInsertId();
			}
		}else{
			return "-2";
		}
	}
	public function getFileSize($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		$data = curl_exec($ch);
		$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		curl_close($ch);
		return $size;
	}
	public function suggestLevel($accountID, $levelID, $difficulty, $stars, $feat, $auto, $demon){
		include __DIR__ . "/connection.php";
		$query = "INSERT INTO suggest (suggestBy, suggestLevelID, suggestDifficulty, suggestStars, suggestFeatured, suggestAuto, suggestDemon, timestamp) VALUES (:account, :level, :diff, :stars, :feat, :auto, :demon, :timestamp)";
		$query = $db->prepare($query);
		$query->execute([':account' => $accountID, ':level' => $levelID, ':diff' => $difficulty, ':stars' => $stars, ':feat' => $feat, ':auto' => $auto, ':demon' => $demon, ':timestamp' => time()]);
	}
}
