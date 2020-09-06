<?php
class Commands {
	public function ownCommand($comment, $command, $accountID, $targetExtID){
		include "../../config/commands.php";
		require_once "../lib/mainLib.php";
		$gs = new mainLib();
		$commandInComment = strtolower($prefix.$command);
		$commandInPerms = ucfirst(strtolower($command));
		$commandlength = strlen($commandInComment);
		if(substr($comment,0,$commandlength) == $commandInComment AND (($gs->checkPermission($accountID, "command".$commandInPerms."All") OR ($targetExtID == $accountID AND $gs->checkPermission($accountID, "command".$commandInPerms."Own"))))){
			return true;
		}
		return false;
	}
	public function doCommands($accountID, $comment, $levelID) {
		chdir(dirname(__FILE__));
		foreach (glob("cmd/*.php") as $filename) {
    		include $filename;
		}
		include "../lib/connection.php";
		include "../../config/commands.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		$ep = new exploitPatch();
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		$prefixLen = strlen($prefix);
		//LEVEL INFO
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchColumn();
		//ADMIN COMMANDS
		if(substr($comment, 0, 4 + $prefixLen) == $prefix.'rate' AND $gs->checkPermission($accountID, "commandRate") AND $commandRate == 1){
			return rate($uploadDate, $gs, $commentarray, $accountID, $levelID);
		}
		if(substr($comment, 0, 7 + $prefixLen) == $prefix.'feature' AND $gs->checkPermission($accountID, "commandFeature") AND $commandFeature == 1){
			return feature($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 4 + $prefixLen) == $prefix.'epic' AND $gs->checkPermission($accountID, "commandEpic") AND $commandEpic == 1){
			return epic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 6 + $prefixLen) == $prefix.'unepic' AND $gs->checkPermission($accountID, "commandEpic") AND $commandEpic == 1){
			return unepic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 5 + $prefixLen) == $prefix.'magic' AND $gs->checkPermission($accountID, "commandMagic") AND $commandMagic == 1 AND $isMagicSectionManual == 1){
			return magic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 7 + $prefixLen) == $prefix.'unmagic' AND $gs->checkPermission($accountID, "commandMagic") AND $commandMagic == 1 AND $isMagicSectionManual == 1){
			return unmagic($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 11 + $prefixLen) == $prefix.'verifycoins' AND $gs->checkPermission($accountID, "commandVerifycoins") AND $commandVerifyCoins == 1){
			return verifycoins($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 5 + $prefixLen) == $prefix.'daily' AND $gs->checkPermission($accountID, "commandDaily") AND $commandDaily == 1){
			return daily($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 6 + $prefixLen) == $prefix.'weekly' AND $gs->checkPermission($accountID, "commandWeekly") AND $commandWeekly == 1){
			return weekly($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 5 + $prefixLen) == $prefix.'delet' AND $gs->checkPermission($accountID, "commandDelete") AND $commandDelete == 1){
			return delete($uploadDate, $accountID, $levelID);
		}
		if(substr($comment, 0, 6 + $prefixLen) == $prefix.'setacc' AND $gs->checkPermission($accountID, "commandSetacc") AND $commandSetAcc == 1){
			return setacc($commentarray, $uploadDate, $accountID, $levelID);
		}
		//NON-ADMIN COMMANDS
		if($this->ownCommand($comment, "rename", $accountID, $targetExtID) AND $commandRename == 1){
			return renamelevel($comment, $uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "pass", $accountID, $targetExtID) AND $commandPass == 1){
			return pass($comment, $uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "song", $accountID, $targetExtID) AND $commandSong == 1){
			return song($comment, $uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "description", $accountID, $targetExtID) AND $commandDescription == 1){
			return description($comment, $uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "public", $accountID, $targetExtID) AND $commandPublic == 1){
			return publiclevel($uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "unlist", $accountID, $targetExtID) AND $commandUnlist == 1){
			return unlist($uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "sharecp", $accountID, $targetExtID) AND $commandShareCP == 1){
			return sharecp($commentarray, $uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "ldm", $accountID, $targetExtID) AND $commandLDM == 1){
			return ldm($uploadDate, $accountID, $levelID);
		}
		if($this->ownCommand($comment, "unldm", $accountID, $targetExtID) AND $commandUnLDM == 1){
			return unldm($uploadDate, $accountID, $levelID);
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