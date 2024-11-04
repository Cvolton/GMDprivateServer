<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require "../lib/XORCipher.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
require "../lib/generateHash.php";
require "../lib/GJPCheck.php";
if(empty($_POST["gameVersion"])){
	$gameVersion = 1;
}else{
	$gameVersion = ExploitPatch::remove($_POST["gameVersion"]);
}
if(empty($_POST["levelID"])){
	exit("-1");
}
$extras = !empty($_POST["extras"]) && $_POST["extras"];
$inc = !empty($_POST["inc"]) && $_POST["inc"];
$ip = $gs->getIP();
$levelID = ExploitPatch::remove($_POST["levelID"]);
$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["levelID"]) : 0;
$feaID = 0;
if(!is_numeric($levelID)){
	echo -1;
}else{
	switch($levelID){
		case -1: //Daily level
			$query = $db->prepare("SELECT feaID, levelID FROM dailyfeatures WHERE timestamp < :time AND type = 0 ORDER BY timestamp DESC LIMIT 1");
			$query->execute([':time' => time()]);
			$result = $query->fetch();
			$levelID = $result["levelID"];
			$feaID = $result["feaID"];
			$daily = 1;
			break;
		case -2: //Weekly level
			$query = $db->prepare("SELECT feaID, levelID FROM dailyfeatures WHERE timestamp < :time AND type = 1 ORDER BY timestamp DESC LIMIT 1");
			$query->execute([':time' => time()]);
			$result = $query->fetch();
			$levelID = $result["levelID"];
			$feaID = $result["feaID"];
			$feaID = $feaID + 100001;
			$daily = 1;
			break;
		case -3: //Event level
			$query = $db->prepare("SELECT feaID, levelID FROM dailyfeatures WHERE timestamp < :time AND type = 2 ORDER BY timestamp DESC LIMIT 1");
			$query->execute([':time' => time()]);
			$result = $query->fetch();
			$levelID = $result["levelID"];
			$feaID = $result["feaID"];
			$feaID = $feaID + 200001;
			$daily = 1;
			break;
		default:
			$daily = 0;
	}
	//downloading the level
	if($daily == 1)
		$query=$db->prepare("SELECT levels.*, users.userName, users.extID FROM levels LEFT JOIN users ON levels.userID = users.userID WHERE levelID = :levelID");
	else
		$query=$db->prepare("SELECT * FROM levels WHERE levelID = :levelID");

	$query->execute([':levelID' => $levelID]);
	$lvls = $query->rowCount();
	if($lvls!=0){
		$result = $query->fetch();

		//Verifying friends only unlisted
		if($result["unlisted2"] != 0){
			$accountID = GJPCheck::getAccountIDOrDie();
			if(! ($result["extID"] == $accountID || $gs->isFriends($accountID, $result["extID"])) ) exit("-1");
		}

		//adding the download
		$query6 = $db->prepare("SELECT count(*) FROM actions_downloads WHERE levelID=:levelID AND ip=INET6_ATON(:ip)");
		$query6->execute([':levelID' => $levelID, ':ip' => $ip]);
		if($inc && $query6->fetchColumn() < 2){
			$query2=$db->prepare("UPDATE levels SET downloads = downloads + 1 WHERE levelID = :levelID");
			$query2->execute([':levelID' => $levelID]);
			$query6 = $db->prepare("INSERT INTO actions_downloads (levelID, ip) VALUES 
														(:levelID,INET6_ATON(:ip))");
			$query6->execute([':levelID' => $levelID, ':ip' => $ip]);
		}
		//getting the days since uploaded... or outputting the date in Y-M-D format at least for now...
		$uploadDate = date("d-m-Y G-i", $result["uploadDate"]);
		$updateDate = date("d-m-Y G-i", $result["updateDate"]);
		//password xor
		$pass = $result["password"];
		$desc = $result["levelDesc"];
		if($gs->checkModIPPermission("actionFreeCopy") == 1){
			$pass = "1";
		}
		$xorPass = $pass;
		if($gameVersion > 19){
			if($pass != 0) $xorPass = base64_encode(XORCipher::cipher($pass,26364));
		}else{
			$desc = ExploitPatch::remove(base64_decode($desc));
		}
		//submitting data
		if(file_exists("../../data/levels/$levelID")){
			$levelstring = file_get_contents("../../data/levels/$levelID");
		}else{
			$levelstring = $result["levelString"];
		}
		if($gameVersion > 18){
			if(substr($levelstring,0,3) == 'kS1'){
				$levelstring = base64_encode(gzcompress($levelstring));
				$levelstring = str_replace("/","_",$levelstring);
				$levelstring = str_replace("+","-",$levelstring);
			}
		}
		$response = "1:".$result["levelID"].":2:".$result["levelName"].":3:".$desc.":4:".$levelstring.":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":11:1:12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":43:".$result["starDemonDiff"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":42:".$result["starEpic"].":45:".$result["objects"].":15:".$result["levelLength"].":30:".$result["original"].":31:".$result['twoPlayer'].":28:".$uploadDate. ":29:".$updateDate. ":35:".$result["songID"].":36:".$result["extraString"].":37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":46:".$result["wt"].":47:".$result["wt2"].":48:".$result["settingsString"].":40:".$result["isLDM"].":27:$xorPass:52:".$result["songIDs"].":53:".$result["sfxIDs"].":57:".$result['ts'];
		if($daily == 1) $response .= ":41:".$feaID;
		if($extras) $response .= ":26:" . $result["levelInfo"];
		//2.02 stuff
		$response .= "#" . GenerateHash::genSolo($levelstring) . "#";
		//2.1 stuff
		$somestring = $result["userID"].",".$result["starStars"].",".$result["starDemon"].",".$result["levelID"].",".$result["starCoins"].",".$result["starFeatured"].",".$pass.",".$feaID;
		$response .= GenerateHash::genSolo2($somestring);
		if($daily == 1){
			$response .= "#" . $gs->getUserString($result);
		}elseif($binaryVersion == 30){
			/*
				This was only part of the response for a brief time prior to GD 2.1's relase.
				This binary version corresponds to the original release of Geometry Dash World.
				It is currently unknown if it's required, so it is left in for now.
			*/
			$response .= "#" . $somestring;
		}
		echo $response;
	}else{
		echo -1;
	}
}
?>
