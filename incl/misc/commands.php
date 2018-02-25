<?php
class Commands {
	public function doCommands($accountID, $comment, $levelID) {
		include dirname(__FILE__)."/../lib/connection.php";
		require_once "../lib/exploitPatch.php";
		require_once "../lib/mainLib.php";
		require_once "../lib/webhooks/webhook.php";
		$ep = new exploitPatch();
		$gs = new mainLib();
		$uname = $gs->getAccName($accountID);
		$commentarray = explode(' ', $comment, 5);
		$uploadDate = time();
		//GETTING USERINFO
		$query2 = $db->prepare("SELECT isAdmin FROM accounts WHERE accountID = :accID");
		$query2->execute([':accID' => $accountID]);
		$userinfo = $query2->fetchAll()[0];
		//LEVELINFO
		$query2 = $db->prepare("SELECT extID FROM levels WHERE levelID = :id");
		$query2->execute([':id' => $levelID]);
		$targetExtID = $query2->fetchAll()[0]["extID"];
		
		$queryNAME = $db->prepare("SELECT levelName, userName FROM levels WHERE levelID = :id");
		$queryNAME->execute([':id' => $levelID]);
		$res = $queryNAME->fetchAll();
		$aLevelName = $res[0]["levelName"];
		$aUserName = $res[0]["userName"];
		//ADMIN COMMANDS
		if ($userinfo["isAdmin"] == 1) {
			if(substr($comment,0,5) == '!rate'){
				$starStars = $commentarray[2];
				if($starStars == "" or $starStars > 20){
					$starStars = 0;
				}
				//$starCoins = $commentarray[3];
				$rateReason = $commentarray[4];
				if ($rateReason == "")
				{
					$rateReason = "None";
				}
				else
				{
					$rateReason = "\"".$rateReason."\"";
				}
				$starFeatured = $commentarray[3];
				$diffArray = $gs->getDiffFromName($commentarray[1]);
				$diffName = $commentarray[1];
				$starDemon = $diffArray[1];
				$starAuto = $diffArray[2];
				$starDifficulty = $diffArray[0];
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
				//if($starCoins != ""){
				//	$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('3', :value, :levelID, :timestamp, :id)");
				//	$query->execute([':value' => $starCoins, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				//	$query = $db->prepare("UPDATE levels SET starCoins=:starCoins WHERE levelID=:levelID");
				//	$query->execute([':starCoins' => $starCoins, ':levelID' => $levelID]);
				//}
				if ($starFeatured) {
					$featurestr = "Yes";
				} else {
					$featurestr = "No";
				}
				PostToHook("Command - Rate", "$uname rated $aLevelName by $aUserName ($levelID).\nStars: $starStars\nDifficulty: $diffName\nFeatured: $featurestr\nReason: $rateReason");
				return true;
			}
			if(substr($comment,0,8) == '!feature'){
				$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				PostToHook("Command - Feature", "$uname featured $aLevelName by $aUserName ($levelID).");

				return true;
			}
			if(substr($comment,0,5) == '!nocp'){
				$query = $db->prepare("UPDATE levels SET giveNoCP='1' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => '1', ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				PostToHook("Command - NoCP", "$uname set $aLevelName by $aUserName ($levelID) to give no creator points.", 0x800000);
				
				return true;
			}
			if(substr($comment,0,7) == '!givecp'){
				$query = $db->prepare("UPDATE levels SET giveNoCP='0' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('14', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => '0', ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				PostToHook("Command - GiveCP", "$uname set $aLevelName by $aUserName ($levelID) to give creator points.", 0x008000);
				
				return true;
			}
			if(substr($comment,0,7) == '!delete'){
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
				PostToHook("Command - Delete", "$uname deleted $aLevelName by $aUserName (x-$levelID).", 0x800000);
				
				return true;
			}
			if(substr($comment,0,7) == '!setacc'){
				$query = $db->prepare("SELECT accountID FROM accounts WHERE userName = :userName LIMIT 1");
				$query->execute([':userName' => implode(' ', array_slice($commentarray, 1))]);
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
					$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('9', :value, :timestamp, :id, :levelID)");
					$query->execute([':value' => $pass, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
					return true;
				}
			}
			if(substr($comment,0,12) == '!description'){
				$desc = base64_encode($ep->remove(str_replace("!description ", "", $comment)));
				$query = $db->prepare("UPDATE levels SET levelDesc=:desc WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID, ':desc' => $desc]);
				$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value3) VALUES ('13', :value, :timestamp, :id, :levelID)");
				$query->execute([':value' => $desc, ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,7) == '!public'){
				$query = $db->prepare("UPDATE levels SET unlisted='0' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
				$query->execute([':value' => "0", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
				return true;
			}
			if(substr($comment,0,7) == '!unlist'){
				$query = $db->prepare("UPDATE levels SET unlisted='1' WHERE levelID=:levelID");
				$query->execute([':levelID' => $levelID]);
				$query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('12', :value, :levelID, :timestamp, :id)");
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