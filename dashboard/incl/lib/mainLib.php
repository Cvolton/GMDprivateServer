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
				$diffname = "N/A: " . $stars;
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
	public function getGauntletName($id){
		$gauntlets = ["Unknown", "Fire", "Ice", "Poison", "Shadow", "Lava", "Bonus", "Chaos", "Demon", "Time", "Crystal", "Magic", "Spike", "Monster", "Doom", "Death"];
		if($id < 0 || $id >= count($gauntlets))
			return $gauntlets[0];
		return $gauntlets[$id];
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
		return "${userdata['userID']}:${userdata["userName"]}:${extID}";
	}
	public function getSongString($song){
		include __DIR__ . "/connection.php";
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
		return "1~|~".$song["ID"]."~|~2~|~".str_replace("#", "", $song["name"])."~|~3~|~".$song["authorID"]."~|~4~|~".$song["authorName"]."~|~5~|~".$song["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~1";
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
		return $userinfo["username"] . "#" . $userinfo["discriminator"];
	}
	public function getDesc($lid) {
		include __DIR__ . "/connection.php";
		$desc = $db->prepare("SELECT levelDesc FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $lid]);
		$desc = $desc->fetch();
		if(empty($desc["levelDesc"])) return '*Нет описания*';
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
		if(!empty($info)) return array('dl' => $info["downloads"], 'likes' => $info["likes"], 'req' => $info["requestedStars"]);
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
	public function dlSubmit($accountID, $levelID, $atts, $yt, $str) {
		$nick = $this->getAccountName($accountID);
		$level = $this->getLevelName($levelID);
		$timestamp = date("c", strtotime("now"));
		$json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "Кто-то опубликовал свой рекорд!",
					"type" => "rich",
					"description" => "**$nick** опубликовал своё прохождение на уровень **$level**! Ссылка для подтверждения: ||https://gcs.icu/demonlist/approve.php?str=$str||",
					"url" => "https://gcs.icu/demonlist",
					"timestamp" => $timestamp,
					"color" => hexdec("3EE667"),
					"footer" => [
						"text" => "GreenCatsServer, приятной игры!",
						"icon_url" => "https://gcs.icu/favicon.png"
					],
					"thumbnail" => ["url" => ""],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/demonlist",
						"icon_url" => "https://gcs.icu/favicon.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "Автор рекорда",
										"value" => "$nick",
										"inline" => true
									],
									[
										"name" => "Доказательство",
										"value" => "https://youtu.be/$yt",
										"inline" => true
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		    $ch = curl_init('https://discord.com/api/webhooks/1043219669122822174/Ip9aoQapSA_G-P3F-iSFmotMo5KAWsz4gnADq5w5acHHVSj7GXz0NuaONYR1x9p0Rbq9');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
	}
	public function dlApprove($str, $accountID) {
		include __DIR__ . '/connection.php';
		$stats = $db->prepare("SELECT * FROM dlsubmits WHERE auth = :str");
		$stats->execute([':str' => $str]);
		$stats = $stats->fetch();
		$nick = $this->getAccountName($accountID);
		$submitter = $this->getAccountName($stats["accountID"]);
		$level = $this->getLevelName($stats["levelID"]);
		$yt = $stats["ytlink"];
		$timestamp = date("c", strtotime("now"));
		$json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "Рекорд был подтверждён!",
					"type" => "rich",
					"description" => "**$nick** подтвердил рекорд **$submitter** на уровень **$level**!",
					"url" => "https://gcs.icu/demonlist",
					"timestamp" => $timestamp,
					"color" => hexdec("5EFFAF"),
					"footer" => [
						"text" => "GreenCatsServer, приятной игры!",
						"icon_url" => "https://gcs.icu/favicon.png"
					],
					"thumbnail" => ["url" => ""],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/demonlist",
						"icon_url" => "https://gcs.icu/favicon.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "Автор рекорда",
										"value" => "$submitter",
										"inline" => true
									],
									[
										"name" => "Доказательство",
										"value" => "https://youtu.be/$yt",
										"inline" => true
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		    $ch = curl_init('https://discord.com/api/webhooks/1043219669122822174/Ip9aoQapSA_G-P3F-iSFmotMo5KAWsz4gnADq5w5acHHVSj7GXz0NuaONYR1x9p0Rbq9');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
	}
	public function dlDeny($str, $accountID) {
		include __DIR__ . '/connection.php';
		$stats = $db->prepare("SELECT * FROM dlsubmits WHERE auth = :str");
		$stats->execute([':str' => $str]);
		$stats = $stats->fetch();
		$nick = $this->getAccountName($accountID);
		$submitter = $this->getAccountName($stats["accountID"]);
		$level = $this->getLevelName($stats["levelID"]);
		$yt = $stats["ytlink"];
		$timestamp = date("c", strtotime("now"));
		$json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "Рекорд был отклонён!",
					"type" => "rich",
					"description" => "**$nick** отклонил рекорд **$submitter** на уровень **$level**!",
					"url" => "https://gcs.icu/demonlist",
					"timestamp" => $timestamp,
					"color" => hexdec("FFB1AB"),
					"footer" => [
						"text" => "GreenCatsServer, приятной игры!",
						"icon_url" => "https://gcs.icu/favicon.png"
					],
					"thumbnail" => ["url" => ""],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/demonlist",
						"icon_url" => "https://gcs.icu/favicon.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "Автор рекорда",
										"value" => "$submitter",
										"inline" => true
									],
									[
										"name" => "Доказательство",
										"value" => "https://youtu.be/$yt",
										"inline" => true
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		    $ch = curl_init('https://discord.com/api/webhooks/1043219669122822174/Ip9aoQapSA_G-P3F-iSFmotMo5KAWsz4gnADq5w5acHHVSj7GXz0NuaONYR1x9p0Rbq9');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
	}
    public function sendWebhookMessage($diff, $star, $nick, $level, $lid, $diff2, $suggOrRate, $unrate = 0, $isRated = false) {
		$timestamp = date("c", strtotime("now"));
		if($diff < 5 AND $diff != 1) {
          $stars2 = 'звезды';
		} elseif($diff > 4) {
          $stars2 = 'звёзд';
		} else {
          $stars2 = 'звезда';
		}
		$info = $this->getLevelStats($lid);
		if($info["req"] != 0) {
			if($info["req"] > 10) $info["req"] = 10;
			if($info["req"]  < 5 AND $info["req"]  != 1) {
			$stars3 = 'звезды';
			} elseif($info["req"]  > 4) {
			$stars3 = 'звёзд';
			} else {
			$stars3 = 'звезду';
			}
		}
		$dl = $info["dl"];
		$likes = $info["likes"] >= 0 ? '<:like:1035838459904020551> '.$info["likes"] : '<:dislike:1035838457962049587> '.mb_substr($info["likes"], 1);
		if($star > 1 AND !$suggOrRate) $star = 1;
		if($diff == 0 OR (!empty($isRated) AND $suggOrRate) AND $unrate == 0) return;
		if(empty($star)) $star = 0;
		if(!$suggOrRate) $json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "Проверьте уровень!",
					"type" => "rich",
					"description" => "**$nick** отправил уровень на оценку!",
					"url" => "https://gcs.icu/stats/suggestList.php",
					"timestamp" => $timestamp,
					"color" => hexdec("3EE667"),
					"footer" => [
						"text" => "GreenCatsServer, приятного модерирования!",
						"icon_url" => "https://gcs.icu/WTFIcons/favicon.png"
					],
					"thumbnail" => ["url" => "https://gcs.icu/WTFIcons/$star/$diff.png"],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/",
						"icon_url" => "https://gcs.icu/WTFIcons/yesbg.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "ID уровня",
										"value" => "$lid",
										"inline" => true
									],
									[
										"name" => "Сложность",
										"value" => "$diff2, $diff $stars2",
										"inline" => true
									], 
									[
										"name" => "Статистика",
										"value" => "<:downloads:1050001089094750291> $dl | $likes",
										"inline" => true
									], 
									[
										"name" => "Описание уровня",
										"value" => $this->getDesc($lid),
										"inline" => false
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		if($suggOrRate) {
			if($info["req"] != 0) $json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "Новый оценённый уровень!",
					"type" => "rich",
					"description" => "**$nick** оценил уровень!",
					"url" => "https://gcs.icu/stats/levelsList.php",
					"timestamp" => $timestamp,
					"color" => hexdec("3EE667"),
					"footer" => [
						"text" => "GreenCatsServer, приятной игры!",
						"icon_url" => "https://gcs.icu/WTFIcons/favicon.png"
					],
					"thumbnail" => ["url" => "https://gcs.icu/WTFIcons/$star/$diff.png"],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/",
						"icon_url" => "https://gcs.icu/WTFIcons/yesbg.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "ID уровня",
										"value" => "$lid",
										"inline" => true
									],
									[
										"name" => "Сложность",
										"value" => "$diff2, $diff $stars2",
										"inline" => true
									], 
									[
										"name" => "Статистика",
										"value" => "<:downloads:1050001089094750291> $dl | $likes",
										"inline" => true
									], 
									[
										"name" => "Автор запросил",
										"value" => $info["req"]." ".$stars3,
										"inline" => true
									],
									[
										"name" => "Описание уровня",
										"value" => $this->getDesc($lid),
										"inline" => false
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		else $json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "Новый оценённый уровень!",
					"type" => "rich",
					"description" => "**$nick** оценил уровень!",
					"url" => "https://gcs.icu/stats/levelsList.php",
					"timestamp" => $timestamp,
					"color" => hexdec("3EE667"),
					"footer" => [
						"text" => "GreenCatsServer, приятной игры!",
						"icon_url" => "https://gcs.icu/WTFIcons/favicon.png"
					],
					"thumbnail" => ["url" => "https://gcs.icu/WTFIcons/$star/$diff.png"],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/",
						"icon_url" => "https://gcs.icu/WTFIcons/yesbg.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "ID уровня",
										"value" => "$lid",
										"inline" => true
									],
									[
										"name" => "Сложность",
										"value" => "$diff2, $diff $stars2",
										"inline" => true
									], 
									[
										"name" => "Статистика",
										"value" => "<:downloads:1050001089094750291> $dl | $likes",
										"inline" => true
									],
									[
										"name" => "Описание уровня",
										"value" => $this->getDesc($lid),
										"inline" => false
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		}
			if($unrate != 0) $json_data = json_encode([
			"content" => "",
			"username" => "GreenCatsServer!",
			"tts" => false,
			"embeds" => [
				[
					"title" => "С уровня сняли оценку!",
					"type" => "rich",
					"description" => "**$nick** снял оценку с уровня!",
					"url" => "https://gcs.icu/stats/levelsList.php",
					"timestamp" => $timestamp,
					"color" => hexdec("3EE667"),
					"footer" => [
						"text" => "GreenCatsServer, приятной игры!",
						"icon_url" => "https://gcs.icu/WTFIcons/favicon.png"
					],
					"thumbnail" => ["url" => "https://gcs.icu/WTFIcons/3/$diff.png"],
					"author" => [
						"name" => "GreenCatsServer",
						"url" => "https://gcs.icu/",
						"icon_url" => "https://gcs.icu/WTFIcons/yesbg.png"
					],
					        "fields" => [
									[
										"name" => "Уровень",
										"value" => "$level",
										"inline" => true
									],
									[
										"name" => "ID уровня",
										"value" => "$lid",
										"inline" => true
									],
									[
										"name" => "Сложность",
										"value" => "$diff2",
										"inline" => true
									],
									[
										"name" => "Статистика",
										"value" => "<:downloads:1050001089094750291> $dl | $likes",
										"inline" => true
									], 									
									[
										"name" => "Описание уровня",
										"value" => $this->getDesc($lid),
										"inline" => false
									]
								]
				]
			]
		], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $ch = curl_init($suggOrRate ? 'https://discord.com/api/webhooks/1048243870380605450/Lic00vvH9Dbrz0AZj-dz2qAaJe63YtVYiIURuwhDuej8ThMC3NOTM1KTy8JGFQ18hyJu' : 'https://discord.com/api/webhooks/1043219669122822174/Ip9aoQapSA_G-P3F-iSFmotMo5KAWsz4gnADq5w5acHHVSj7GXz0NuaONYR1x9p0Rbq9');
            // $ch = curl_init('https://discord.com/api/webhooks/1047904830267592734/o6dweD6YhXTGOe5m4wIYU9oX5aoUQ4hXyuX2I-vCwd5yS_JZtW3pYDy1jKfsKcwiiHqN'); // for testing epta
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
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
	public function rateLevel($accountID, $levelID, $stars, $difficulty, $auto, $demon, $feat){
		if(!is_numeric($accountID)) return false;
		$diffic = $this->getDiffFromStars($stars);
		if($diffic["demon"] == 1) $diffic = 'Demon';
		elseif($diffic["auto"] == 1) $diffic = 'Auto';
		else $diffic = $diffic["name"];
		include __DIR__ . "/connection.php";
		$this->sendWebhookMessage($stars, $feat, $this->getAccountName($accountID), $this->getLevelName($levelID), $levelID, $diffic, true, 0, $this->isRated($levelID));
		//lets assume the perms check is done properly before
		$query = "UPDATE levels SET starDemon=:demon, starAuto=:auto, starDifficulty=:diff, starStars=:stars, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':demon' => $demon, ':auto' => $auto, ':diff' => $difficulty, ':stars' => $stars, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
		$query->execute([':value' => $this->getDiffFromStars($stars)["name"], ':timestamp' => time(), ':id' => $accountID, ':value2' => $stars, ':levelID' => $levelID]);
	}
	public function featureLevel($accountID, $levelID, $feature){
		if(!is_numeric($accountID)) return false;

		include __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starFeatured=:feature, rateDate=:now WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':feature' => $feature, ':levelID'=>$levelID, ':now' => time()]);
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $feature, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
	public function verifyCoinsLevel($accountID, $levelID, $coins){
		if(!is_numeric($accountID)) return false;

		include __DIR__ . "/connection.php";
		$query = "UPDATE levels SET starCoins=:coins WHERE levelID=:levelID";
		$query = $db->prepare($query);	
		$query->execute([':coins' => $coins, ':levelID'=>$levelID]);
		
		$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
		$query->execute([':value' => $coins, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
	}
	public function songReupload($url, $author, $name, $accountID){
		require __DIR__ . "/../../incl/lib/connection.php";
		require_once __DIR__ . "/../../incl/lib/exploitPatch.php";
		$song = str_replace("www.dropbox.com","dl.dropboxusercontent.com",$url);
		if (filter_var($song, FILTER_VALIDATE_URL) == TRUE && substr($song, 0, 4) == "http") {
			$song = str_replace(["?dl=0","?dl=1"],"",$song);
			$song = trim($song);
			$query = $db->prepare("SELECT ID FROM songs WHERE download = :download");
			$query->execute([':download' => $song]);	
			$count = $query->fetch();
			if(!empty($count)){
				return "-3".$count["ID"];
			}
			if(empty($name)) $name = ExploitPatch::remove(urldecode(str_replace([".mp3",".webm",".mp4",".wav"], "", basename($song))));
			if(empty($author)) $author = "Reupload";
			$info = $this->getFileInfo($song);
			$size = $info['size'];
			if(substr($info['type'], 0, 6) != "audio/")
				return "-4";
			$size = round($size / 1024 / 1024, 2);
			$hash = "";
			$query = $db->prepare("INSERT INTO songs (name, authorID, authorName, size, download, hash, reuploadTime, reuploadID)
			VALUES (:name, '9', :author, :size, :download, :hash, :time, :ID)");
			$query->execute([':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash, ':time' => time(), ':ID' => $accountID]);
			return $db->lastInsertId();
		}else{
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
		$diffic = $this->getDiffFromStars($stars);
		if($diffic["demon"] == 1) $diffic = 'Demon';
		elseif($diffic["auto"] == 1) $diffic = 'Auto';
		else $diffic = $diffic["name"];
		$this->sendWebhookMessage($stars, $feat, $this->getAccountName($accountID), $this->getLevelName($levelID), $levelID, $diffic, false, 0);
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
	public function voteLevel($accountID, $levelID, $difficulty, $demon){
		include __DIR__ . "/connection.php";
		include __DIR__ . "/../../config/difVote.php";

		$permState = $this->checkPermission($accountID, "actionRateDifficulty");
		$power = 0;
		if ($permState) {
			$power = 1;
		}

		$query = $db->prepare("SELECT starDemon, starDemonDiff FROM levels WHERE levelID = :level");
		$query->execute([':level' => $levelID]);
		$result1 = $query->fetch();
		if ($query->rowCount() > 0) {
			$isDemon = $result1['starDemon'];
			if ($power == 0 && $isDemon == 1 && ($result1['starDemonDiff']-$demon >= 30 || $result1['starDemonDiff']-$demon <= -30)) {
				return;
			}
		} else {
			$isDemon = 0;
		}

		$query = $db->prepare("INSERT INTO difvote (levelID, userID, difficulty, demon, timestamp) VALUES (:level, :account, :diff, :demon, :timestamp)");
		$query->execute([':account' => $accountID, ':level' => $levelID, ':diff' => $difficulty, ':demon' => $demon, ':timestamp' => time()]);
		if ($power == 1) {
			for ($loop = 1; $loop < $powerRate; $loop++) {
				$query = $db->prepare("INSERT INTO difvote (levelID, userID, difficulty, demon, timestamp, isPower) VALUES (:level, :account, :diff, :demon, :timestamp, 1)");
				$query->execute([':account' => $accountID, ':level' => $levelID, ':diff' => $difficulty, ':demon' => $demon, ':timestamp' => time()]);
			}
		}

		if ($isDemon == 0 || $demon == 0) {
			$query = $db->prepare("SELECT Count(*) as count FROM difvote WHERE levelID = :level");
			$query->execute([':level' => $levelID]);
			$isVoted = $query->fetchColumn();
			if ($isVoted >= $minimumVotes) {
				$query = $db->prepare("SELECT AVG(difficulty) AS diff FROM difvote WHERE levelID = :level");
				$query->execute([':level' => $levelID]);
				$result = $query->fetchColumn();
				$diff = round($result, -1);
				$auto = 0;
				if ($diff == 0) {
					$auto = 1;
				}

				$query = $db->prepare("UPDATE levels SET starAuto=:auto, starDifficulty=:diff WHERE levelID=:levelID");	
				$query->execute([':auto' => $auto, ':diff' => $diff, ':levelID'=>$levelID]);
			}
		} else {
			$query = $db->prepare("SELECT Count(*) as count FROM difvote WHERE demon != 0 AND levelID = :level");
			$query->execute([':level' => $levelID]);
			$isVoted = $query->fetchColumn();
			if ($isVoted >= $minimumVotes) {
				$query = $db->prepare("SELECT AVG(demon) AS diff FROM difvote WHERE demon != 0 AND levelID = :level");
				$query->execute([':level' => $levelID]);
				$result = $query->fetchColumn();
				$demon_face = 0;
				if ($result >= 10 && $result < 18) {
					$demon_face = 3;
				}
				else if ($result >= 18 && $result < 26) {
					$demon_face = 4;
				}
				else if ($result >= 26 && $result < 34) {
					$demon_face = 2;
				}
				else if ($result >= 34 && $result < 42) {
					$demon_face = 5;
				}
				else if ($result >= 42 && $result <= 50) {
					$demon_face = 6;
				}

				$query = $db->prepare("UPDATE levels SET starDemonDiff=:diff WHERE levelID=:levelID");	
				$query->execute([':diff' => $demon_face, ':levelID'=>$levelID]);
			}
		}
	}
  	public function mail($mail = '', $user = '') {
      	include __DIR__."/connection.php";
      	if(empty($mail) OR empty($user)) return;
      	$string = $this->randomString(4);
      	$query = $db->prepare("UPDATE accounts SET mail = :mail WHERE userName = :user");
      	$query->execute([':mail' => $string, ':user' => $user]);
		$headers[]  = 'MIME-Version: 1.0\n';
        $headers[] .= 'Content-type: text/html; charset=utf8\n';
        $headers[] .= 'From: "GreenCatsServer!" <noreply@gcs.icu>';
      	$mail = '"'.$user.'" <'.$mail.'>';
        imap_mail($mail, 'Подтверждение почты', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" style="font-family:arial, \'helvetica neue\', helvetica, sans-serif"><head>
          <meta charset="UTF-8">
          <meta content="width=device-width, initial-scale=1" name="viewport">
          <meta name="x-apple-disable-message-reformatting">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta content="telephone=no" name="format-detection">
          <title>Подтверждение почты</title><!--[if (mso 16)]>
            <style type="text/css">
            a {text-decoration: none;}
            </style>
            <![endif]--><!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--><!--[if gte mso 9]>
        <xml>
            <o:OfficeDocumentSettings>
            <o:AllowPNG></o:AllowPNG>
            <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <![endif]--><!--[if !mso]><!-- -->
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"><!--<![endif]-->
          <style type="text/css">
        #outlook a {
            padding:0;
        }
        .es-button {
            mso-style-priority:100!important;
            text-decoration:none!important;
        }
        a[x-apple-data-detectors] {
            color:inherit!important;
            text-decoration:none!important;
            font-size:inherit!important;
            font-family:inherit!important;
            font-weight:inherit!important;
            line-height:inherit!important;
        }
        .es-desk-hidden {
            display:none;
            float:left;
            overflow:hidden;
            width:0;
            max-height:0;
            line-height:0;
            mso-hide:all;
        }
        [data-ogsb] .es-button {
            border-width:0!important;
            padding:10px 20px 10px 20px!important;
        }
        [data-ogsb] .es-button.es-button-1 {
            padding:10px 15px!important;
        }
        @media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120% } h1 { font-size:30px!important; text-align:left } h2 { font-size:24px!important; text-align:left } h3 { font-size:20px!important; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px!important; text-align:left } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:24px!important; text-align:left } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important; text-align:left } .es-menu td a { font-size:14px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button, button.es-button { font-size:18px!important; display:inline-block!important } .es-adaptive table, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; max-height:inherit!important } .h-auto { height:auto!important } }
        </style>
         <style>[_nghost-egh-c52]{font-family:Open Sans,sans-serif;color:#121212}</style></head>
         <body style="width:100%;font-family:arial, \'helvetica neue\', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
          <div class="es-wrapper-color" style="background-color:#36393e"><!--[if gte mso 9]>
                    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                        <v:fill type="tile" color="#f6f6f6"></v:fill>
                    </v:background>
                <![endif]-->
           <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#36393e">
             <tbody><tr>
              <td valign="top" style="padding:0;Margin:0">
               <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                 <tbody><tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table class="es-header-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                     <tbody><tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;background: #36393e;padding-left:20px;padding-right:20px">
                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tbody><tr>
                          <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                           <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tbody><tr>
                              <td align="center" style="padding:0;Margin:0;font-size:0px"><img class="adapt-img" src="https://gcs.icu/logo.png" alt="" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="560"></td>
                             </tr>
                           </tbody></table></td>
                         </tr>
                       </tbody></table></td>
                     </tr>
                   </tbody></table></td>
                 </tr>
               </tbody></table>
               <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tbody><tr>
                  <td align="center" style="padding:0;Margin:0">
                   <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                     <tbody><tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;background: #36393e;padding-left:20px;padding-right:20px">
                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tbody><tr>
                          <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                           <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tbody><tr>
                              <td align="center" style="padding:0;Margin:0;padding-bottom:10px"><h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;;font-size:24px;font-style:normal;font-weight:normal;;;;;;;;;;;;;;;;;color: #ffffff;;;;;;;;;;;">Привет, '.$user.'!</h2></td>
                             </tr>
                           </tbody></table></td>
                         </tr>
                       </tbody></table></td>
                     </tr>
                     <tr>
                      <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;background: #36393e;">
                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tbody><tr>
                          <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                           <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tbody><tr>
                              <td esdev-links-color="#ffffff" align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:18px;;;;;;;;;;;;;;color: #ffffff;;;;;;;;;;;;;;font-size:15px">Видимо, ты указал свою почту при регистрации на GreenCatsServer.</p></td>
                             </tr>
                           </tbody></table></td>
                         </tr>
                       </tbody></table></td>
                     </tr>
                   </tbody></table></td>
                 </tr>
               </tbody></table>
               <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                 <tbody><tr>
                  <td align="center" style="padding:0;Margin:0;">
                   <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                     <tbody><tr>
                      <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;background: #36393e;padding-right:20px;padding-bottom: 20px;">
                       <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                         <tbody><tr>
                          <td valign="top" align="center" style="padding:0;Margin:0;width:560px">
                           <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                             <tbody><tr>
                              <td align="center" style="padding:0;Margin:0"><span class="msohide es-button-border" style="border-style:solid;border-color:#2cb543;background:#31cb4b;border-width:0px;display:inline-block;border-radius:30px;width:auto;mso-hide:all"><a href="https://gcs.icu/mail/'.$string.'" class="es-button es-button-1" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;border-style:solid;border-color:#31CB4B;border-width:10px 15px;display:inline-block;background:#31CB4B;border-radius:30px;font-family:verdana, geneva, sans-serif;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center">Подтвердить почту</a></span><!--<![endif]--></td>
                             </tr>
                           </tbody></table></td>
                         </tr>
                       </tbody></table></td>
                     </tr>
                   </tbody></table></td>
                 </tr>
               </tbody></table></td>
             </tr>
           </tbody></table>
          </div>
        <div at-magnifier-wrapper=""><div class="at-theme-dark"><div class="at-base notranslate" translate="no"><div class="Z1-AJ" style="top: 0px; left: 0px;"></div></div></div></div></body><app-content ng-version="14.2.0"></app-content></html>
        ', implode("\n", $headers));
	}
}