<?php
class Commands {
	public static function ownCommand($comment, $command, $accountID, $targetExtID){
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$commandInComment = strtolower("!".$command);
		$commandInPerms = ucfirst(strtolower($command));
		$commandlength = strlen($commandInComment);
		if(substr($comment,0,$commandlength) == $commandInComment AND (($gs->checkPermission($accountID, "command".$commandInPerms."All") OR ($targetExtID == $accountID AND $gs->checkPermission($accountID, "command".$commandInPerms."Own"))))){
			return true;
		}
		return false;
	}
	public static function doCommands($accountID, $comment, $levelID) {
		if(!is_numeric($accountID)) return false;
		if($levelID < 0) return self::doListCommands($accountID, $comment, $levelID);
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		//LEVELINFO
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchColumn();
		//ADMIN COMMANDS
		if(substr($comment,0,5) == '!rate' AND $gs->checkPermission($accountID, "commandRate")){
			$starStars = $commentarray[2];
			if($starStars == ""){
				$starStars = 0;
			}
			$starCoins = $commentarray[3];
			$starFeatured = $commentarray[4];
			$diffArray = $gs->getDiffFromName($commentarray[1]);
			$starDemon = $diffArray[1];
			$starAuto = $diffArray[2];
			$starDifficulty = $diffArray[0];
			$query = $db->prepare("UPDATE levels SET starStars=:starStars, starDifficulty=:starDifficulty, starDemon=:starDemon, starAuto=:starAuto, rateDate=:timestamp WHERE levelID=:levelID");
			$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':timestamp' => $uploadDate, ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value2, value3, timestamp, account) VALUES ('1', :value, :value2, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':value2' => $starStars, ':levelID' => $levelID]);
			if($starFeatured != ""){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $starFeatured, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);	
				$query = $db->prepare("UPDATE levels SET starFeatured=:starFeatured WHERE levelID=:levelID");
				$query->execute([':starFeatured' => $starFeatured, ':levelID' => $levelID]);
			}
			if($starCoins != ""){
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $starCoins, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				$query = $db->prepare("UPDATE levels SET starCoins=:starCoins WHERE levelID=:levelID");
				$query->execute([':starCoins' => $starCoins, ':levelID' => $levelID]);
			}
			return true;
		}
		if(substr($comment,0,8) == '!feature' AND $gs->checkPermission($accountID, "commandFeature")){
			$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(substr($comment,0,5) == '!epic' AND $gs->checkPermission($accountID, "commandEpic")){
			$query = $db->prepare("UPDATE levels SET starEpic='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(substr($comment,0,7) == '!unepic' AND $gs->checkPermission($accountID, "commandUnepic")){
			$query = $db->prepare("UPDATE levels SET starEpic='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
		}
		if(substr($comment,0,12) == '!verifycoins' AND $gs->checkPermission($accountID, "commandVerifycoins")){
			$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID = :levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(substr($comment,0,6) == '!daily' AND $gs->checkPermission($accountID, "commandDaily")){
			$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE levelID = :level AND type = 0");
				$query->execute([':level' => $levelID]);
			if($query->fetchColumn() != 0){
				return false;
			}
			$query = $db->prepare("SELECT timestamp FROM dailyfeatures WHERE timestamp >= :tomorrow AND type = 0 ORDER BY timestamp DESC LIMIT 1");
			$query->execute([':tomorrow' => strtotime("tomorrow 00:00:00")]);
			if($query->rowCount() == 0){
				$timestamp = strtotime("tomorrow 00:00:00");
			}else{
				$timestamp = $query->fetchColumn() + 86400;
			}
			$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type) VALUES (:levelID, :uploadDate, 0)");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account, value2, value4) VALUES ('5', :value, :levelID, :timestamp, :id, :dailytime, 0)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID, ':dailytime' => $timestamp]);
			return true;
		}
		if(substr($comment,0,7) == '!weekly' AND $gs->checkPermission($accountID, "commandWeekly")){
			$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE levelID = :level AND type = 1");
			$query->execute([':level' => $levelID]);
			if($query->fetchColumn() != 0){
				return false;
			}
			$query = $db->prepare("SELECT timestamp FROM dailyfeatures WHERE timestamp >= :tomorrow AND type = 1 ORDER BY timestamp DESC LIMIT 1");
				$query->execute([':tomorrow' => strtotime("next monday")]);
			if($query->rowCount() == 0){
				$timestamp = strtotime("next monday");
			}else{
				$timestamp = $query->fetchColumn() + 604800;
			}
			$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp, type) VALUES (:levelID, :uploadDate, 1)");
			$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account, value2, value4) VALUES ('5', :value, :levelID, :timestamp, :id, :dailytime, 1)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID, ':dailytime' => $timestamp]);
			return true;
		}
		if(substr($comment,0,6) == '!delet' AND $gs->checkPermission($accountID, "commandDelete")){
			if(!is_numeric($levelID)){
				return false;
			}
			$query = $db->prepare("DELETE from levels WHERE levelID=:levelID LIMIT 1");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('6', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			if(file_exists(dirname(__FILE__)."../../data/levels/$levelID")){
				rename(dirname(__FILE__)."../../data/levels/$levelID",dirname(__FILE__)."../../data/levels/deleted/$levelID");
			}
			return true;
		}
		if(substr($comment,0,7) == '!setacc' AND $gs->checkPermission($accountID, "commandSetacc")){
			$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName OR accountID = :userName LIMIT 1");
			$query->execute([':userName' => $commentarray[1]]);
			if($query->rowCount() == 0){
				return false;
			}
			$targetAcc = $query->fetchColumn();
			//var_dump($result);
			$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID LIMIT 1");
			$query->execute([':extID' => $targetAcc]);
			$userID = $query->fetchColumn();
			$query = $db->prepare("UPDATE levels SET extID=:extID, userID=:userID, userName=:userName WHERE levelID=:levelID");
			$query->execute([':extID' => $targetAcc, ':userID' => $userID, ':userName' => $commentarray[1], ':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}

		
	//NON-ADMIN COMMANDS
		if(self::ownCommand($comment, "rename", $accountID, $targetExtID)){
			$name = ExploitPatch::remove(str_replace("!rename ", "", $comment));
			$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':levelName' => $name]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
			$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "pass", $accountID, $targetExtID)){
			$pass = ExploitPatch::remove(str_replace("!pass ", "", $comment));
			if(is_numeric($pass)){
				$pass = sprintf("%06d", $pass);
				if($pass == "000000"){
					$pass = "";
				}
				$pass = "1".$pass;
				$query = $db->prepare("UPDATE levels SET password=:password WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':password' => $pass]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		}
		if(self::ownCommand($comment, "song", $accountID, $targetExtID)){
			$song = ExploitPatch::remove(str_replace("!song ", "", $comment));
			if(is_numeric($song)){
				$query = $db->prepare("UPDATE levels SET songID=:song WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':song' => $song]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('16', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		}
		if(self::ownCommand($comment, "description", $accountID, $targetExtID)){
			$desc = base64_encode(ExploitPatch::remove(str_replace("!description ", "", $comment)));
			$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':desc' => $desc]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
			$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "public", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET unlisted='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "unlist", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET unlisted='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "sharecp", $accountID, $targetExtID)){
			$query = $db->prepare("SELECT userID FROM users WHERE userName = :userName ORDER BY isRegistered DESC LIMIT 1");
			$query->execute([':userName' => $commentarray[1]]);
			$targetAcc = $query->fetchColumn();
			//var_dump($result);
			$query = $db->prepare("INSERT INTO cpshares (levelID, userID) VALUES (:levelID, :userID)");
			$query->execute([':userID' => $targetAcc, ':levelID' => $levelID]);
			$query = $db->prepare("UPDATE levels SET isCPShared='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('11', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "ldm", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET isLDM='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if(self::ownCommand($comment, "unldm", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET isLDM='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
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
				$name = base64_encode(trim(ExploitPatch::charclean(implode(' ', $carray))));
				$query = $db->prepare("UPDATE lists SET listDesc = :name WHERE listID = :listID");
				$query->execute([':listID' => $listID, ':name' => $name]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('37', :value, :listID, :timestamp, :id)");
				$query->execute([':value' => $name, ':timestamp' => time(), ':id' => $accountID, ':listID' => $listID]);
				break;
		}
		return true;
	}
	public static function doProfileCommands($accountID, $command){
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
				$gs = new mainLib();
		if(substr($command, 0, 8) == '!discord'){
			if(substr($command, 9, 6) == "accept"){
				$query = $db->prepare("UPDATE accounts SET discordID = discordLinkReq, discordLinkReq = '0' WHERE accountID = :accountID AND discordLinkReq <> 0");
				$query->execute([':accountID' => $accountID]);
				$query = $db->prepare("SELECT discordID, userName FROM accounts WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				$account = $query->fetch();
				$gs->sendDiscordPM($account["discordID"], "Your link request to " . $account["userName"] . " has been accepted!");
				return true;
			}
			if(substr($command, 9, 4) == "deny"){
				$query = $db->prepare("SELECT discordLinkReq, userName FROM accounts WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				$account = $query->fetch();
				$gs->sendDiscordPM($account["discordLinkReq"], "Your link request to " . $account["userName"] . " has been denied!");
				$query = $db->prepare("UPDATE accounts SET discordLinkReq = '0' WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				return true;
			}
			if(substr($command, 9, 6) == "unlink"){
				$query = $db->prepare("SELECT discordID, userName FROM accounts WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				$account = $query->fetch();
				$gs->sendDiscordPM($account["discordID"], "Your Discord account has been unlinked from " . $account["userName"] . "!");
				$query = $db->prepare("UPDATE accounts SET discordID = '0' WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				return true;
			}
		}
		return false;
	}
}
?>
