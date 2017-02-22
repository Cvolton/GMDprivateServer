<?php
include "connection.php";
require "incl/XORCipher.php";
//$levelID = 2632;
$gameVersion = htmlspecialchars($_POST["gameVersion"],ENT_QUOTES);
$levelID = htmlspecialchars($_POST["levelID"],ENT_QUOTES);
$feaID = 0;
if(!is_numeric($levelID)){
	echo -1;
}else{
	if($levelID == "-1"){
				$query = $db->prepare("SELECT * FROM dailyfeatures ORDER BY timestamp DESC LIMIT 1");
				$query->execute();
				$result = $query->fetchAll();
				$result = $result[0];
				$levelID = $result["levelID"];
				$feaID = $result["feaID"];
				$daily = 1;
	}
$query=$db->prepare("select * from levels where levelID = ?");
$query->execute(array($levelID));
$lvls = $query->rowCount();
if($lvls!=0){
$result2 = $query->fetchAll();
$result = $result2[0];
//getting the days since uploaded... or outputting the date in Y-M-D format at least for now...
$uploadDate = date("d-m-Y G-i", $result["uploadDate"]);
$updateDate = date("d-m-Y G-i", $result["updateDate"]);
//password xor
$pass = $result["password"];
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$query=$db->prepare("SELECT * FROM modips WHERE IP = :ip");
$query->execute([":ip" => $ip]);
$ips = $query->rowCount();
if($ips > 0){
	$pass = "1";
}
if($gameVersion > 19){
	$xor = new XORCipher();
	$xorPass = base64_encode($xor->cipher($pass,26364));
}else{
	$xorPass = $pass;
}
//submitting data
$desc = $result["levelDesc"];
$levelstring = $result["levelString"];
if($gameVersion < 20){
	$desc = base64_decode($desc);
}
if($gameVersion > 18){
	if(substr($levelstring,0,3) == 'kS1'){
			$levelstring = base64_encode(gzcompress($levelstring));
			$levelstring = str_replace("/","_",$levelstring);
			$levelstring = str_replace("+","-",$levelstring);
	}
}
echo "1:".$result["levelID"].":2:".$result["levelName"].":3:".$desc.":4:".$levelstring.":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":11:1:12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":43:".$result["starDemonDiff"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":42:".$result["starEpic"].":45:0:15:".$result["levelLength"].":30:".$result["original"].":31:0:28:".$uploadDate. ":29:".$updateDate. ":35:".$result["songID"].":36:".$result["extraString"].":37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":46:1:47:2:27:$xorPass";
if($daily == 1){
	echo ":41:".$feaID;
}
//2.02 stuff
echo "#";
require "incl/generateHash.php";
$hash = new generateHash();
echo $hash->genSolo($levelstring);
//2.1 stuff
echo "#";
$somestring = $result["userID"].",".$result["starStars"].",".$result["starDemon"].",".$result["levelID"].",".$result["starCoins"].",".$result["starFeatured"].",".$pass.",".$feaID;
echo $hash->genSolo2($somestring);
echo "#";
if($daily == 1){
	$userIDquery = $db->prepare("SELECT * FROM users WHERE userID = '".$result["userID"]."'");
	$userIDquery->execute();
	$userID = $userIDquery->fetchAll();
	if ($userIDquery->rowCount() > 0) {
		$userID = $userID[0];
		$userID = $userID["extID"];
		if(is_numeric($userID)){
			$userID = $userID;
		}else{
			$userID = 0;
		}
	}
	echo $result["userID"] . ":" . $result["userName"] . ":" . $userID;
}else{
	echo $somestring;
}
//adding the download
$downloads = $result["downloads"] + 1;
$query2=$db->prepare("UPDATE levels SET downloads = :downloads WHERE levelID = :levelID");
$query2->execute([':downloads' => $downloads, ':levelID' => $levelID]);
}else{
	echo -1;
}
}
?>