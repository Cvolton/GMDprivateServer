<?php
class Commands {
	public static function ownCommand($command, $accountID, $targetExtID){
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$commandInPerms = ucfirst(strtolower($command));
		if($gs->checkPermission($accountID, "command".$commandInPerms."All") OR ($targetExtID == $accountID AND $gs->checkPermission($accountID, "command".$commandInPerms."Own"))) return true;
		return false;
	}
	public static function doCommands($accountID, $comment, $levelID) {
		if(!is_numeric($accountID) || !is_numeric($levelID) || substr($comment, 0, 1) != '!') return false;
		if($levelID < 0) return self::doListCommands($accountID, $comment, $levelID);
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchColumn();
		switch($commentarray[0]) {
			case '!r':
			case '!rate':
				if(!$gs->checkPermission($accountID, "commandRate")) return false;
				$starStars = ExploitPatch::number($commentarray[2]);
				if(!is_numeric($starStars)) $starStars = 0;
				if($starStars == 0) return 'Please use !unrate.';
				$starCoins = ExploitPatch::number($commentarray[3]);
				$starFeatured = ExploitPatch::number($commentarray[4]);
				if(!is_numeric($starFeatured)) $starFeatured = 0;
				$diffArray = $gs->getDiffFromName(ExploitPatch::charclean($commentarray[1]));
				$starDemon = $diffArray[1];
				$starAuto = $diffArray[2];
				$starDifficulty = $diffArray[0];
				$diffic = $gs->getDiffFromStars($starStars);
				if($diffic["demon"] == 1) $diffic = 'Demon';
				elseif($diffic["auto"] == 1) $diffic = 'Auto';
				else $diffic = $diffic["name"];
				$query = $db->prepare("UPDATE levels SET starStars = :starStars, starDifficulty = :starDifficulty, starDemon = :starDemon, starAuto = :starAuto, rateDate = :timestamp WHERE levelID = :levelID");
				$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':timestamp' => $uploadDate, ':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
				$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':value2' => $starStars, ':levelID' => $levelID]);
				if(!empty($starFeatured)) {
					if($starFeatured > 1) {
						$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
						$query->execute([':value' => $starFeatured - 1, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);	
						$query = $db->prepare("UPDATE levels SET starEpic = :starEpic WHERE levelID = :levelID");
						$query->execute([':starEpic' => $starFeatured - 1, ':levelID' => $levelID]);
					} elseif($starFeatured == 1) {
						$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
						$query->execute([':value' => 1, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);	
						$query = $db->prepare("SELECT starFeatured FROM levels WHERE levelID=:levelID ORDER BY starFeatured DESC LIMIT 1");
						$query->execute([':levelID' => $levelID]);
						$featuredID = $query->fetchColumn();
						if(!$featuredID) {
							$query = $db->prepare("SELECT starFeatured FROM levels ORDER BY starFeatured DESC LIMIT 1");
							$query->execute();
							$featuredID = $query->fetchColumn() + 1;
						}
						$query = $db->prepare("UPDATE levels SET starFeatured=:starFeatured WHERE levelID=:levelID");
						$query->execute([':starFeatured' => $featuredID + 1, ':levelID' => $levelID]);
					}
				} else $starFeatured = 0;
				if(!empty($starCoins)){
					if($starCoins > 1 OR $starCoins < 0) $starCoins = 1;
					$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
					$query->execute([':value' => $starCoins, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					$query = $db->prepare("UPDATE levels SET starCoins=:starCoins WHERE levelID=:levelID");
					$query->execute([':starCoins' => $starCoins, ':levelID' => $levelID]);
				}
				$gs->sendRateWebhook($accountID, $levelID);
				return 'You successfully rated '.$gs->getLevelName($levelID).' as '.$diffic.', '.$starStars.' star'.($starStars == 1 ? '' : 's').'!';
				break;
			case '!unr':
			case '!unrate':
				if(!$gs->checkPermission($accountID, "commandRate")) return false;
				$query = $db->prepare("UPDATE levels SET starStars = 0, starDemon = 0, rateDate = :timestamp, starFeatured = 0, starEpic = 0, starCoins = 0 WHERE levelID = :levelID");
				$query->execute([':timestamp' => $uploadDate, ':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
				$query->execute([':value' => 0, ':timestamp' => $uploadDate, ':id' => $accountID, ':value2' => 0, ':levelID' => $levelID]);
				$levelDiff = $gs->getLevelDiff($levelID);
				$gs->sendRateWebhook($accountID, $levelID);
				return 'You successfully unrated '.$gs->getLevelName($levelID).'!';
				break;
			case '!f':
			case '!feature':
			case '!epic':
			case '!legendary':
			case '!mythic':
			case '!unfeature':
			case '!unepic':
			case '!unlegendary':
			case '!unmythic':
				if(!isset($commentarray[1])) {
					$starArray = ['!f' => 1, '!feature' => 1, '!epic' => 2, '!legendary' => 3, '!mythic' => 4, '!unfeature' => 0, '!unepic' => 0, '!unlegendary' => 0, '!unmythic' => 0];
					if($starArray[$commentarray[0]] > 1) {
						if(!$gs->checkPermission($accountID, "commandEpic")) return false;
						$column = 'starEpic';
						$starFeatured = $starArray[$commentarray[0]] - 1;
						$returnTextArray = ['!epic' => 'epiced %1$s!', '!legendary' => 'set %1$s as a legendary level!', '!mythic' => 'set %1$s as a mythic level!'];
						$returnText = 'You successfully '.sprintf($returnTextArray[$commentarray[0]], $gs->getLevelName($levelID));
					} else {
						if(!$gs->checkPermission($accountID, "commandFeature")) return false;
						$column = 'starFeatured';
						if($starArray[$commentarray[0]] != 0) {
							$query = $db->prepare("SELECT starFeatured FROM levels WHERE levelID=:levelID ORDER BY starFeatured DESC LIMIT 1");
							$query->execute([':levelID' => $levelID]);
							$starFeatured = $query->fetchColumn();
							if(!$starFeatured) {
								$query = $db->prepare("SELECT starFeatured FROM levels ORDER BY starFeatured DESC LIMIT 1");
								$query->execute();
								$starFeatured = $query->fetchColumn() + 1;
							}
							$returnText = 'You successfully featured '.$gs->getLevelName($levelID).'!';
						} else $returnText = 'You successfully unfeatured '.$gs->getLevelName($levelID).'!';
					}
				} else {
					if($commentarray[1] > 1) {
						if(!$gs->checkPermission($accountID, "commandEpic")) return false;
						$column = 'starEpic';
						$starFeatured = ExploitPatch::number($commentarray[1]) - 1;
						$returnTextArray = ['!epic' => 'epiced %1$s!', '!legendary' => 'set %1$s as a legendary level!', '!mythic' => 'set %1$s as a mythic level!'];
						$returnText = 'You successfully '.sprintf($returnTextArray[$commentarray[0]], $gs->getLevelName($levelID));
					} else {
						if(!$gs->checkPermission($accountID, "commandFeature")) return false;
						$column = 'starFeatured';
						if($starArray[$commentarray[0]] != 0) {
							$query = $db->prepare("SELECT starFeatured FROM levels WHERE levelID=:levelID ORDER BY starFeatured DESC LIMIT 1");
							$query->execute([':levelID' => $levelID]);
							$starFeatured = $query->fetchColumn();
							if(!$starFeatured) {
								$query = $db->prepare("SELECT starFeatured FROM levels ORDER BY starFeatured DESC LIMIT 1");
								$query->execute();
								$starFeatured = $query->fetchColumn() + 1;
							}
							$returnText = 'You successfully featured '.$gs->getLevelName($levelID).'!';
						} else $returnText = 'You successfully unfeatured '.$gs->getLevelName($levelID).'!';
					}
				}
				if($starArray[$commentarray[0]] == 0 && $commentarray[1] == 0) $column = 'starFeatured = 0, starEpic';
				$query = $db->prepare("UPDATE levels SET $column = :starFeatured WHERE levelID = :levelID");
				$query->execute([':levelID' => $levelID, ':starFeatured' => $starFeatured]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('".($column == 'starEpic' ? 4 : 2)."', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => ($column == 'starEpic' ? $starArray[$commentarray[0]] - 1 : $starArray[$commentarray[0]]), ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return $returnText;
				break;
			case '!vc':
			case '!verifycoins':
			case '!unverifycoins':
				if(!$gs->checkPermission($accountID, "commandVerifycoins")) return false;
				if(!isset($commentarray[1])) {
					$coinsArray = ['!vc' => 1, '!verifycoins' => 1, '!unverifycoins' => 0];
					$verifyCoins = $coinsArray[ExploitPatch::number($commentarray[0])] ?? 1;
				} else $verifyCoins = ExploitPatch::number($commentarray[0]) > 1 ? 1 : ExploitPatch::number($commentarray[0]);
				$query = $db->prepare("UPDATE levels SET starCoins = :starCoins WHERE levelID = :levelID");
				$query->execute([':levelID' => $levelID, ':starCoins' => $verifyCoins]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $verifyCoins, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return 'You successfully '.($verifyCoins ? '' : 'un').'verified coins in '.$gs->getLevelName($levelID).'!';
				break;
			case '!da':
			case '!daily':
				if(!$gs->checkPermission($accountID, "commandDaily")) return false;
				$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE levelID = :level AND type = 0");
				$query->execute([':level' => $levelID]);
				if($query->fetchColumn() != 0) return $gs->getLevelName($levelID).' is already daily!';
				$query = $db->prepare("SELECT timestamp FROM dailyfeatures WHERE timestamp >= :tomorrow AND type = 0 ORDER BY timestamp DESC LIMIT 1");
				$query->execute([':tomorrow' => strtotime("tomorrow 00:00:00")]);
				if($query->rowCount() == 0) $timestamp = strtotime("tomorrow 00:00:00");
				else $timestamp = $query->fetchColumn() + 86400;
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type) VALUES (:levelID, :uploadDate, 0)");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account, value2, value4) VALUES ('5', :value, :levelID, :timestamp, :id, :dailytime, 0)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID, ':dailytime' => $timestamp]);
				return 'You successfully made '.$gs->getLevelName($levelID).' daily!';
				break;
			case '!w':
			case '!weekly':
				if(!$gs->checkPermission($accountID, "commandWeekly")) return false;
				$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE levelID = :level AND type = 1");
				$query->execute([':level' => $levelID]);
				if($query->fetchColumn() != 0) return $gs->getLevelName($levelID).' is already weekly!';
				$query = $db->prepare("SELECT timestamp FROM dailyfeatures WHERE timestamp >= :tomorrow AND type = 1 ORDER BY timestamp DESC LIMIT 1");
				$query->execute([':tomorrow' => strtotime("next monday")]);
				if($query->rowCount() == 0) $timestamp = strtotime("next monday");
				else $timestamp = $query->fetchColumn() + 604800;
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type) VALUES (:levelID, :uploadDate, 1)");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account, value2, value4) VALUES ('5', :value, :levelID, :timestamp, :id, :dailytime, 1)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID, ':dailytime' => $timestamp]);
				return 'You successfully made '.$gs->getLevelName($levelID).' weekly!';
				break;
			case '!d':
			case '!delet':
			case '!delete':
				if(!$gs->checkPermission($accountID, "commandDelete")) return false;
				$levelName = $gs->getLevelName($levelID);
				if(!$levelName) return false;
				$query = $db->prepare("DELETE FROM comments WHERE levelID = :levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("DELETE from levels WHERE levelID = :levelID LIMIT 1");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('6', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				if(file_exists(dirname(__FILE__)."../../data/levels/$levelID")) rename(dirname(__FILE__)."../../data/levels/$levelID", dirname(__FILE__)."../../data/levels/deleted/$levelID");
				return 'You successfully deleted '.$levelName.'!';
				break;
			case '!sa':
			case '!setacc':
				if(!$gs->checkPermission($accountID, "commandSetacc")) return false;
				$query = $db->prepare("SELECT accountID, userName FROM accounts WHERE userName = :userName OR accountID = :userName LIMIT 1");
				$query->execute([':userName' => ExploitPatch::charclean($commentarray[1])]);
				$query = $query->fetch();
				if(!$query) return false;
				$targetAcc = $query['accountID'];
				$targetUserName = $query['userName'];
				$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID LIMIT 1");
				$query->execute([':extID' => $targetAcc]);
				$userID = $query->fetchColumn();
				$query = $db->prepare("UPDATE levels SET extID = :extID, userID = :userID, userName = :userName WHERE levelID = :levelID");
				$query->execute([':extID' => $targetAcc, ':userID' => $userID, ':userName' => $targetUserName, ':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $targetUserName, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return 'You successfully set '.$gs->getAccountName($targetAcc).' as creator of '.$gs->getLevelName($levelID).'!';
				break;
			case '!re':
			case '!rename':
				if(self::ownCommand("rename", $accountID, $targetExtID)) {
					$name = ExploitPatch::rucharclean(str_replace($commentarray[0]." ", "", $comment));
					$levelName = $gs->getLevelName($levelID);
					if(!$levelName) return false;
					$query = $db->prepare("UPDATE levels SET levelName = :levelName WHERE levelID = :levelID");
					$query->execute([':levelID' => $levelID, ':levelName' => $name]);
					$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
					$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					return 'You successfully renamed '.$levelName.' to'.$gs->getLevelName($levelID).'!';
				}
				break;
			case '!p':
			case '!pass':
			case '!password':
				if(self::ownCommand("pass", $accountID, $targetExtID)) {
					$pass = ExploitPatch::number($commentarray[1]);
					if(is_numeric($pass)) {
						$pass = sprintf("%06d", $pass);
						if($pass == "000000") $pass = "";
						$pass = "1".$pass;
						$query = $db->prepare("UPDATE levels SET password = :password WHERE levelID = :levelID");
						$query->execute([':levelID' => $levelID, ':password' => $pass]);
						$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
						$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
						$returnText = empty($pass) ? 'You successfully removed password of level '.$gs->getLevelName($levelID).'!' : 'You successfully set password of level '.$gs->getLevelName($levelID).' to '.ExploitPatch::number($commentarray[1]).'!';
						return $returnText;
					}
				}
				break;
			case '!s':
			case '!song':
				if(self::ownCommand("song", $accountID, $targetExtID)) {
					$song = ExploitPatch::number($commentarray[1]);
					if(is_numeric($song)) {
						$songInfo = $gs->getSongInfo($song);
						if(!$songInfo) return false;
						$query = $db->prepare("UPDATE levels SET songID = :song WHERE levelID = :levelID");
						$query->execute([':levelID' => $levelID, ':song' => $song]);
						$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('16', :value, :timestamp, :id, :levelID)");
						$query->execute([':value' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
						return 'You successfully changed song of level '.$gs->getLevelName($levelID).' to '.$songInfo['authorName'].' - '.$songInfo['name'].' ('.$songInfo['ID'].')!';
					}
				}
				break;
			case '!desc':
			case '!description':
				if(self::ownCommand("description", $accountID, $targetExtID)) {
					$desc = base64_encode(ExploitPatch::rucharclean(str_replace($commentarray[0]." ", "", $comment)));
					$query = $db->prepare("UPDATE levels SET levelDesc = :desc WHERE levelID = :levelID");
					$query->execute([':levelID' => $levelID, ':desc' => $desc]);
					$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
					$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					return 'You successfully changed description of level '.$gs->getLevelName($levelID).'!';
				}
				break;
			case '!pub':
			case '!public':
			case '!unlist':
				if(!isset($commentarray[1])) {
					$permsArray = ['!pub' => 'public', '!public' => 'public', '!unlist' => 'unlist'];
					$permission = $permsArray[$commentarray[0]];
				} else $permission = $commentarray[1] == 1 ? 'public' : 'unlist';
				if(self::ownCommand($permission, $accountID, $targetExtID)) {
					$unlisted = $permission == 'public' ? 0 : 1;
					$query = $db->prepare("UPDATE levels SET unlisted = :unlisted WHERE levelID = :levelID");
					$query->execute([':levelID' => $levelID, ':unlisted' => $unlisted]);
					$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
					$query->execute([':value' => $unlisted, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					$returnText = $unlisted ? 'You successfully unlisted level '.$gs->getLevelName($levelID).'!' : 'You successfully made level '.$gs->getLevelName($levelID).' public!';
					return $returnText;
				}
				break;
			case '!cp':
			case '!sharecp':
				if(self::ownCommand("sharecp", $accountID, $targetExtID)) {
					$query = $db->prepare("SELECT userID FROM users WHERE userName = :userName ORDER BY isRegistered DESC LIMIT 1");
					$query->execute([':userName' => ExploitPatch::charclean($commentarray[1])]);
					$targetAcc = $query->fetchColumn();
					$query = $db->prepare("INSERT INTO cpshares (levelID, userID) VALUES (:levelID, :userID)");
					$query->execute([':userID' => $targetAcc, ':levelID' => $levelID]);
					$query = $db->prepare("UPDATE levels SET isCPShared = '1' WHERE levelID = :levelID");
					$query->execute([':levelID' => $levelID]);
					$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('11', :value, :levelID, :timestamp, :id)");
					$query->execute([':value' => ExploitPatch::charclean($commentarray[1]), ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					return 'You successfully shared Creator Points of level '.$gs->getLevelName($levelID).' with '.ExploitPatch::charclean($commentarray[1]).'!';
				}
				break;
			case '!ldm':
			case '!unldm':
				if(!isset($commentarray[1])) {
					$permsArray = ['!ldm' => 'ldm', '!unldm' => 'unldm'];
					$permission = $permsArray[$commentarray[0]];
				} else $permission = $commentarray[1] == 1 ? 'ldm' : 'unldm';
				if(self::ownCommand($permission, $accountID, $targetExtID)) {
					$ldm = $permission == 'ldm' ? 1 : 0;
					$query = $db->prepare("UPDATE levels SET isLDM = :ldm WHERE levelID=:levelID");
					$query->execute([':levelID' => $levelID, ':ldm' => $ldm]);
					$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
					$query->execute([':value' => $ldm, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					return 'You successfully '.($ldm ? 'added LDM to' : 'removed LDM from').' level '.$gs->getLevelName($levelID).'!';
				}
		}
		return false;
	}
	public static function doListCommands($accountID, $command, $listID) {
		if(substr($command,0,1) != '!') return false;
		$listID = $listID * -1;
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$carray = explode(' ', $command);
		switch($carray[0]) {
			case '!r':
			case '!rate':
				$getList = $db->prepare('SELECT * FROM lists WHERE listID = :listID');
				$getList->execute([':listID' => $listID]);
				$getList = $getList->fetch();
				$reward = ExploitPatch::number($carray[1]);
				$diff = ExploitPatch::charclean($carray[2]);
				$featured = is_numeric($carray[3]) ? ExploitPatch::number($carray[3]) : ExploitPatch::number($carray[4]);
				$count = is_numeric($carray[3]) ? ExploitPatch::number($carray[4]) : ExploitPatch::number($carray[5]);
				if(empty($count)) {
					$levelsCount = $getList['listlevels'];
					$count = count(explode(',', $levelsCount));
				}
				if(!is_numeric($diff)) {
					$diff = strtolower($diff);
					if(isset($carray[3]) AND strtolower($carray[3]) == "demon") {
						$diffList = ['easy' => 1, 'medium' => 2, 'hard' => 3, 'insane' => 4, 'extreme' => 5];
						$diff = 5+$diffList[$diff];
					} else {
						$diffList = ['na' => -1, 'auto' => 0, 'easy' => 1, 'normal' => 2, 'hard' => 3, 'harder' => 4, 'demon' => 5];
						$diff = $diffList[$diff];
					}
				}
				if(!isset($diff)) $diff = $getList['starDifficulty'];
				if($gs->checkPermission($accountID, "commandRate")) {
					$query = $db->prepare("UPDATE lists SET starStars = :reward, starDifficulty = :diff, starFeatured = :feat, countForReward = :count WHERE listID = :listID");
					$query->execute([':listID' => $listID, ':reward' => $reward, ':diff' => $diff, ':feat' => $featured, ':count' => $count]);
					$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('30', :value, :value2, :listID, :timestamp, :id)");
					$query->execute([':value' => $reward, ':value2' => $diff, ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				} elseif($gs->checkPermission($accountID, "actionSuggestRating")) {
					$query = $db->prepare("INSERT INTO suggest (suggestBy, suggestLevelId, suggestDifficulty, suggestStars, suggestFeatured, timestamp) VALUES (:accID, :listID, :diff, :reward, :feat, :time)");
					$query->execute([':listID' => $listID*-1, ':reward' => $reward, ':diff' => $diff, ':accID' => $accountID, ':feat' => $featured, ':time' => time()]);
					$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('31', :value, :value2, :listID, :timestamp, :id)");
					$query->execute([':value' => $reward, ':value2' => $diff, ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				} else return false;
				break;
			case '!f':
			case '!feature':
				if(!$gs->checkPermission($accountID, "commandFeature")) return false;
				if(!isset($carray[1])) $carray[1] = 1;
				$query = $db->prepare("UPDATE lists SET starFeatured = :feat WHERE listID=:listID");
				$query->execute([':listID' => $listID, ':feat' => $carray[1]]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('32', :value, :listID, :timestamp, :id)");
				$query->execute([':value' => $carray[1], ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
			case '!un':
			case '!unlist':
				$accCheck = $gs->getListOwner($listID);
				if(!$gs->checkPermission($accountID, "commandUnlistAll") AND $accountID != $accCheck) return false;
				if(!isset($carray[1])) $carray[1] = 1;
				$query = $db->prepare("UPDATE lists SET unlisted = :unlisted WHERE listID=:listID");
				$query->execute([':listID' => $listID, ':unlisted' => $carray[1]]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('33', :value, :listID, :timestamp, :id)");
				$query->execute([':value' => $carray[1], ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
			case '!d':
			case '!delete':
				if(!$gs->checkPermission($accountID, "commandDelete")) return false;
				$query = $db->prepare("DELETE FROM lists WHERE listID = :listID");
				$query->execute([':listID' => $listID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('34', 0, :listID, :timestamp, :id)");
				$query->execute([':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
			case '!acc':
			case '!setacc':
				if(!$gs->checkPermission($accountID, "commandSetacc")) return false;
				if(is_numeric($carray[1])) $acc = ExploitPatch::number($carray[1]);
				else $acc = $gs->getAccountIDFromName(ExploitPatch::charclean($carray[1]));
				if(empty($acc)) return false;
				$query = $db->prepare("UPDATE lists SET accountID = :accID WHERE listID=:listID");
				$query->execute([':listID' => $listID, ':accID' => $acc]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('35', :value, :listID, :timestamp, :id)");
				$query->execute([':value' => $acc, ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
			case '!re':
			case '!rename':
				$accCheck = $gs->getListOwner($listID);
				if(!$gs->checkPermission($accountID, "commandRenameAll") AND $accountID != $accCheck) return false;
				$carray[0] = '';
				$oldName = $gs->getListName($listID);
				$name = trim(ExploitPatch::charclean(implode(' ', $carray)));
				$query = $db->prepare("UPDATE lists SET listName = :name WHERE listID = :listID");
				$query->execute([':listID' => $listID, ':name' => $name]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('36', :value, :value2, :listID, :timestamp, :id)");
				$query->execute([':value' => $name, ':value2' => $oldName, ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
			case '!desc':
			case '!description':
				$accCheck = $gs->getListOwner($listID);
				if(!$gs->checkPermission($accountID, "commandDescriptionAll") AND $accountID != $accCheck) return false;
				$carray[0] = '';
				$name = ExploitPatch::url_base64_encode(trim(ExploitPatch::charclean(implode(' ', $carray))));
				$query = $db->prepare("UPDATE lists SET listDesc = :name WHERE listID = :listID");
				$query->execute([':listID' => $listID, ':name' => $name]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('37', :value, :listID, :timestamp, :id)");
				$query->execute([':value' => $name, ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
		}
		return true;
	}
	public static function doProfileCommands($accountID, $command){
		include __DIR__."/connection.php";
		require_once __DIR__."/exploitPatch.php";
		require_once __DIR__."/mainLib.php";
		include __DIR__."/../../config/dashboard.php";
		include __DIR__."/../../config/discord.php";
		$gs = new mainLib();
		$carray = explode(' ', $command);
		$acc = $gs->getAccountName($accountID);
		$timestamp = date("c", strtotime("now"));
		if(substr($command, 0, 8) == '!discord') {
			$webhookLangArray = $gs->webhookStartLanguage($webhookLanguage);
			if(substr($command, 9, 6) == "accept") {
				$query = $db->prepare("SELECT accountID, discordID FROM accounts WHERE discordLinkReq = :id");
				$query->execute([':id' => ExploitPatch::number($carray[2])]);
				$check = $query->fetch();
				if($check["accountID"] != $accountID) return false;
				else {
					$query = $db->prepare("UPDATE accounts SET discordLinkReq = '0' WHERE accountID = :accountID");
					$query->execute([':accountID' => $accountID]);
					$setColor = $successColor;
					$setTitle = $gs->webhookLanguage('accountAcceptTitle', $webhookLangArray);
					$setDescription = sprintf($gs->webhookLanguage('accountAcceptDesc', $webhookLangArray), '**'.$acc.'**');
					$setThumbnail = $acceptThumbnailURL;
					$setFooter = sprintf($gs->webhookLanguage('footer', $webhookLangArray), $gdps);
					$embed = $gs->generateEmbedArray(
						[$gdps, $authorURL, $authorIconURL],
						$setColor,
						[$setTitle, $linkTitleURL],
						$setDescription,
						$setThumbnail,
						[],
						[$setFooter, $footerIconURL]
					);
					$json = json_encode([
						"content" => "",
						"tts" => false,
						"embeds" => [$embed]
					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
					$gs->sendDiscordPM($check["discordID"], $json, true);
					$gs->linkMember($check["discordID"], $acc);
					return true;
			    }
			}
			if(substr($command, 9, 6) == "unlink") {
				$query = $db->prepare("SELECT discordID, discordLinkReq FROM accounts WHERE accountID = :id");
				$query->execute([':id' => $accountID]);
				$check = $query->fetch();
				if($check["discordID"] == 0 || $check['discordLinkReq'] != 0) return false;
				else {
					$query = $db->prepare("UPDATE accounts SET discordID = '0' WHERE accountID = :accountID");
					$query->execute([':accountID' => $accountID]);
					$setColor = $failColor;
					$setTitle = $gs->webhookLanguage('accountUnlinkTitle', $webhookLangArray);
					$setDescription = sprintf($gs->webhookLanguage('accountUnlinkDesc', $webhookLangArray), '**'.$acc.'**');
					$setThumbnail = $unlinkThumbnailURL;
					$setFooter = sprintf($gs->webhookLanguage('footer', $webhookLangArray), $gdps);
					$embed = $gs->generateEmbedArray(
						[$gdps, $authorURL, $authorIconURL],
						$setColor,
						[$setTitle, $linkTitleURL],
						$setDescription,
						$setThumbnail,
						[],
						[$setFooter, $footerIconURL]
					);
					$json = json_encode([
						"content" => "",
						"tts" => false,
						"embeds" => [$embed]
					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
					$gs->sendDiscordPM($check["discordID"], $json, true);
					$gs->unlinkMember($check["discordID"]);
					return true;
			    }
			}
			if(substr($command, 9, 4) == "link") {
				$query = $db->prepare("SELECT discordID, discordLinkReq FROM accounts WHERE accountID = :id");
				$query->execute([':id' => $accountID]);
				$check = $query->fetch();
				if($check["discordID"] != 0 && $check['discordLinkReq'] == 0) return false;
				$query = $db->prepare("SELECT count(*) FROM accounts WHERE discordID = :id AND discordLinkReq = 0");
				$query->execute([':id' => $carray[2]]);
				$check = $query->fetchColumn();
				if($check > 0) return false;
				$code = rand(1000, 9999);
				$emojis = [":zero:", ":one:", ":two:", ":three:", ":four:", ":five:", ":six:", ":seven:", ":eight:", ":nine:"];
				$acode = str_split($code);
				$acode = [$emojis[$acode[0]], $emojis[$acode[1]], $emojis[$acode[2]], $emojis[$acode[3]]];
				$setColor = $pendingColor;
				$setTitle = $gs->webhookLanguage('accountLinkTitle', $webhookLangArray);
				$setDescription = sprintf($gs->webhookLanguage('accountLinkDesc', $webhookLangArray), '**'.$acc.'**');
				$setThumbnail = $linkThumbnailURL;
				$codeFirst = [$gs->webhookLanguage('accountCodeFirst', $webhookLangArray), $acode[0], true];
				$codeSecond = [$gs->webhookLanguage('accountCodeSecond', $webhookLangArray), $acode[1], true];
				$codeThird = [$gs->webhookLanguage('accountCodeThird', $webhookLangArray), $acode[2], true];
				$codeFourth = [$gs->webhookLanguage('accountCodeFourth', $webhookLangArray), $acode[3], true];
				$setFooter = sprintf($gs->webhookLanguage('footer', $webhookLangArray), $gdps);
				$embed = $gs->generateEmbedArray(
					[$gdps, $authorURL, $authorIconURL],
					$setColor,
					[$setTitle, $linkTitleURL],
					$setDescription,
					$setThumbnail,
					[$codeFirst, $codeSecond, $codeThird, $codeFourth],
					[$setFooter, $footerIconURL]
				);
				$json = json_encode([
					"content" => "",
					"tts" => false,
					"embeds" => [$embed]
				], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
				$query = $db->prepare("UPDATE accounts SET discordLinkReq = :id, discordID = :did WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID, ':id' => $code, ':did' => ExploitPatch::number($carray[2])]);
				$gs->sendDiscordPM($carray[2], $json, true);
				return true;
			}
		}
		return false;
	}
}
?>
