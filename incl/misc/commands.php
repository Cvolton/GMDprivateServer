<?php
class Commands {
	public function ownCommand($comment, $command, $accountID, $targetExtID){
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
	public function doCommands($accountID, $comment, $levelID) {
		foreach (glob("cmd/*.php") as $filename) {
    		include $filename;
		}
		include dirname(__FILE__)."/../lib/connection.php";
		include "../../config/commands.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$ep = new exploitPatch();
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		$prefixLen = len($prefix);
		//LEVEL INFO
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchColumn();
		//ADMIN COMMANDS
		if(substr($comment, 0, 4 + $prefixLen) == $prefix.'rate' AND $gs->checkPermission($accountID, "commandRate") AND $commandRate == 1){
			rate($uploadDate, $gs, $commentarray, $accountID, $levelID);
		}
		if(substr($comment, 0, 7 + $prefixLen) == $prefix.'feature' AND $gs->checkPermission($accountID, "commandFeature") AND $commandFeature == 1){
			feature($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 4 + $prefixLen) == $prefix.'epic' AND $gs->checkPermission($accountID, "commandEpic") AND $commandEpic == 1){
			epic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 6 + $prefixLen) == $prefix.'unepic' AND $gs->checkPermission($accountID, "commandUnepic") AND $commandUnepic == 1){
			unepic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 5 + $prefixLen) == $prefix.'magic' AND $gs->checkPermission($accountID, "commandMagic") AND $commandMagic == 1 AND $isMagicSectionManual = 1){
			magic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 7 + $prefixLen) == $prefix.'unmagic' AND $gs->checkPermission($accountID, "commandUnmagic") AND $commandUnmagic == 1 AND $isMagicSectionManual = 1){
			unmagic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 11 + $prefixLen) == $prefix.'verifycoins' AND $gs->checkPermission($accountID, "commandVerifycoins") AND $commandVerifyCoins == 1){
			verifycoins($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 5 + $prefixLen) == $prefix.'daily' AND $gs->checkPermission($accountID, "commandDaily") AND $commandDaily == 1){
			daily($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 6 + $prefixLen) == $prefix.'weekly' AND $gs->checkPermission($accountID, "commandWeekly") AND $commandWeekly == 1){
			weekly($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 5 + $prefixLen) == $prefix.'delet' AND ($gs->checkPermission($accountID, "commandDelete") OR $accountID == $targetExtID) AND $commandDelete == 1){
			delete($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 6 + $prefixLen) == $prefix.'setacc' AND $gs->checkPermission($accountID, "commandSetacc") AND $commandSetAcc == 1){
			setacc($commentarray, $uploadDate, $accountID, $levelID);
		}
		
		//NON-ADMIN COMMANDS
		if($this->ownCommand($comment, "rename", $accountID, $targetExtID)){
			$name = $ep->remove(str_replace("!rename ", "", $comment));
			$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':levelName' => $name]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
			$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if($this->ownCommand($comment, "pass", $accountID, $targetExtID)){
			$pass = $ep->remove(str_replace("!pass ", "", $comment));
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
		if($this->ownCommand($comment, "song", $accountID, $targetExtID)){
			$song = $ep->remove(str_replace("!song ", "", $comment));
			if(is_numeric($song)){
				$query = $db->prepare("UPDATE levels SET songID=:song WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':song' => $song]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('16', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $song, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		}
		if($this->ownCommand($comment, "description", $accountID, $targetExtID)){
			$desc = base64_encode($ep->remove(str_replace("!description ", "", $comment)));
			$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID, ':desc' => $desc]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
			$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if($this->ownCommand($comment, "public", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET unlisted='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if($this->ownCommand($comment, "unlist", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET unlisted='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if($this->ownCommand($comment, "sharecp", $accountID, $targetExtID)){
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
		if($this->ownCommand($comment, "ldm", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET isLDM='1' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		if($this->ownCommand($comment, "unldm", $accountID, $targetExtID)){
			$query = $db->prepare("UPDATE levels SET isLDM='0' WHERE levelID=:levelID");
			$query->execute([':levelID' => $levelID]);
			$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
			$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
			return true;
		}
		return false;
	}
	public function doProfileCommands($accountID, $command){
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$ep = new exploitPatch();
		$gs = new mainLib();
		if(substr($command, 0, 7 + $prefixLen) == $prefix.'discord'){
			if(substr($command, 8 + $prefixLen, 5) == "accept"){
				$query = $db->prepare("UPDATE accounts SET discordID = discordLinkReq, discordLinkReq = '0' WHERE accountID = :accountID AND discordLinkReq <> 0");
				$query->execute([':accountID' => $accountID]);
				$query = $db->prepare("SELECT discordID, userName FROM accounts WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				$account = $query->fetch();
				$gs->sendDiscordPM($account["discordID"], "Your link request to " . $account["userName"] . " has been accepted!");
				return true;
			}
			if(substr($command, 8 + $prefixLen, 3) == "deny"){
				$query = $db->prepare("SELECT discordLinkReq, userName FROM accounts WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				$account = $query->fetch();
				$gs->sendDiscordPM($account["discordLinkReq"], "Your link request to " . $account["userName"] . " has been denied!");
				$query = $db->prepare("UPDATE accounts SET discordLinkReq = '0' WHERE accountID = :accountID");
				$query->execute([':accountID' => $accountID]);
				return true;
			}
			if(substr($command, 8 + $prefixLen, 6) == "unlink"){
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