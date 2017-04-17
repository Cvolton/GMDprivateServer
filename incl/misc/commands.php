<?php
class Commands {
	public function doCommands($accountID, $comment, $levelID) {
		include dirname(__FILE__)."/../lib/connection.php";
		$gs = new mainLib();
		$commentarray = explode(' ', $comment);
		$uploadDate = time();
		//GETTING USERINFO
		$query2 = $db->prepare("SELECT isAdmin FROM accounts WHERE accountID = :accID");
		$query2->execute([':accID' => $accountID]);
		$userinfo = $query2->fetchAll()[0];
		//LEVELINFO
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchAll()[0]["extID"];
		//ADMIN COMMANDS
		if ($userinfo["isAdmin"] == 1) {
			if(substr($comment,0,5) == '!rate'){
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
				file_put_contents(dirname(__FILE__)."/../../data/levels/wtf.txt","$starDifficulty:$levelID");
				$query = $db->prepare("UPDATE levels SET starStars=:starStars, starDifficulty=:starDifficulty, starDemon=:starDemon, starAuto=:starAuto WHERE levelID=:levelID");
				$query->execute([':starStars' => $starStars, ':starDifficulty' => $starDifficulty, ':starDemon' => $starDemon, ':starAuto' => $starAuto, ':levelID' => $levelID]);
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
		if ($userinfo["isAdmin"] == 2) {
			if(substr($comment,0,8) == '!feature'){
				$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,5) == '!epic'){
				$query = $db->prepare("UPDATE levels SET starEpic='1' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,7) == '!unepic'){
				$query = $db->prepare("UPDATE levels SET starEpic='0' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('4', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,12) == '!verifycoins'){
				$query = $db->prepare("UPDATE levels SET starCoins='1' WHERE levelID = :levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		if ($userinfo["isAdmin"] == 3) {
			if(substr($comment,0,6) == '!daily'){
				$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE levelID = :level");
				$query->execute([':level' => $levelID]);
				if($query->fetchColumn() != 0){
					return false;
				}
				$query = $db->prepare("SELECT timestamp FROM dailyfeatures WHERE timestamp >= :tomorrow ORDER BY timestamp DESC LIMIT 1");
				$query->execute([':tomorrow' => strtotime("tomorrow 00:00:00")]);
				if($query->rowCount() == 0){
					$timestamp = strtotime("tomorrow 00:00:00");
				}else{
					$timestamp = $query->fetchAll()[0]["timestamp"] + 86400;
				}
				$query = $db->prepare("INSERT INTO dailyfeatures (levelID, timestamp) VALUES (:levelID, :uploadDate)");
				$query->execute([':levelID' => $levelID, ':uploadDate' => $timestamp]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account, value2) VALUES ('5', :value, :levelID, :timestamp, :id, :dailytime)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID, ':dailytime' => $timestamp]);
				return true;
			}
		if ($userinfo["isAdmin"] == 4) {
			if(substr($comment,0,6) == '!delet'){
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
			if(substr($comment,0,7) == '!setacc'){
				$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName LIMIT 1");
				$query->execute([':userName' => $commentarray[1]]);
				$targetAcc = $query->fetchAll()[0];
				//var_dump($result);
				$query = $db->prepare("SELECT userID FROM users WHERE extID = :extID LIMIT 1");
				$query->execute([':extID' => $targetAcc["accountID"]]);
				$userID = $query->fetchColumn();
				$query = $db->prepare("UPDATE levels SET extID=:extID, userID=:userID, userName=:userName WHERE levelID=:levelID");
				$query->execute([':extID' => $targetAcc["accountID"], ':userID' => $userID, ':userName' => $commentarray[1], ':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('7', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => $commentarray[1], ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
		}
		//NON-ADMIN COMMANDS
		if ($userinfo["isAdmin"] == 1 OR $targetExtID == $accountID) {
			if(substr($comment,0,7) == '!rename'){
				$name = $ep->remove(str_replace("!rename ", "", $comment));
				$query = $db->prepare("UPDATE levels SET levelName=:levelName WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':levelName' => $name]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $name, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,5) == '!pass'){
				$pass = $ep->remove(str_replace("!pass ", "", $comment));
				if(is_numeric($pass)){
					$pass = sprintf("%06d", $pass);
					if($pass == "000000"){
						$pass = "";
					}
					$pass = "1".$pass;
					$query = $db->prepare("UPDATE levels SET password=:password WHERE levelID=:levelID");
					$query->execute([':levelID' => $levelID, ':password' => $pass]);
					$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('8', :value, :timestamp, :id, :levelID)");
					$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					return true;
				}
			}
			if(substr($comment,0,12) == '!description'){
				$desc = base64_encode($ep->remove(str_replace("!description ", "", $comment)));
				$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':desc' => $desc]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,7) == '!public'){
				$query = $db->prepare("UPDATE levels SET unlisted='0' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('10', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,7) == '!unlist'){
				$query = $db->prepare("UPDATE levels SET unlisted='1' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('10', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,8) == '!sharecp'){
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
		}
		return false;
	}
}
?>
