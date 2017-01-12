<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$GJPCheck = new GJPCheck();
$levelsstring = "";
$songsstring  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
if($type != 10){
	$query = "";
	$additional = "";
	$additionalnowhere ="";
	$len = htmlspecialchars($_POST["len"],ENT_QUOTES);
	$diff = htmlspecialchars($_POST["diff"],ENT_QUOTES);
	//ADDITIONAL PARAMETERS
	if($_POST["featured"]==1){
		$additional = "WHERE NOT starFeatured = 0 ";
		$additionalnowhere = "AND NOT starFeatured = 0 ";
	}
	if($_POST["original"]==1){
		if($additional == ""){
			$additional = "WHERE original = 0 ";
			$additionalnowhere = "AND original = 0 ";
		}else{
			$additional = $additional."AND original = 0 ";
			$additionalnowhere = $additional."AND original = 0 ";
		}
	}
	if($_POST["uncompleted"]==1){
		$completedLevels = htmlspecialchars($_POST["completedLevels"],ENT_QUOTES);
		$completedLevels = str_replace("(","", $completedLevels);
		$completedLevels = str_replace(")","", $completedLevels);
		$completedLevels = $db->quote($completedLevels);
		$completedLevels = str_replace("'","", $completedLevels);
		$completedLevels = str_replace(",","' AND NOT levelID = '", $completedLevels);
		if($additional == ""){
			$additional = "WHERE NOT levelID = '".$completedLevels."' ";
			$additionalnowhere = "AND NOT levelID = '".$completedLevels."' ";
		}else{
			$additional = $additional."AND NOT levelID = '".$completedLevels."' ";
			$additionalnowhere = $additional."AND NOT levelID = '".$completedLevels."' ";
		}
	}
	if($_POST["song"]!=0){
		if($_POST["customSong"]==0){
			$song = htmlspecialchars($_POST["song"],ENT_QUOTES);
			$song = $db->quote($song);
			$song = $song -1;
			if($additional == ""){
				$additional = "WHERE audioTrack = '".$song."' AND songID <> 0 ";
				$additionalnowhere = "AND audioTrack = '".$song."' AND songID <> 0 ";
			}else{
				$additional = $additional."AND audioTrack = '".$song."' AND songID <> 0 ";
				$additionalnowhere = $additional."AND audioTrack = '".$song."' AND songID <> 0 ";
			}
		}else{
			$song = htmlspecialchars($_POST["song"],ENT_QUOTES);
			if($additional == ""){
				$additional = "WHERE songID = '".$song."' ";
				$additionalnowhere = "AND songID = '".$song."' ";
			}else{
				$additional = $additional."AND songID = '".$song."' ";
				$additionalnowhere = $additional."AND songID = '".$song."' ";
			}
		}
	}
	if($_POST["twoPlayer"]==1){
		if($additional == ""){
			$additional = "WHERE twoPlayer = 1 ";
			$additionalnowhere = "AND twoPlayer = 1 ";
		}else{
			$additional = $additional."AND twoPlayer = 1 ";
			$additionalnowhere = $additional."AND twoPlayer = 1 ";
		}
	}
	if($_POST["star"]==1){
		if($additional == ""){
			$additional = "WHERE NOT starStars = 0 ";
			$additionalnowhere = "AND NOT starStars = 0 ";
		}else{
			$additional = $additional."AND NOT starStars = 0 ";
			$additionalnowhere = $additional."AND NOT starStars = 0 ";
		}
	}
	if($_POST["noStar"]==1){
		if($additional == ""){
			$additional = "WHERE starStars = 0 ";
			$additionalnowhere = "AND starStars = 0 ";
		}else{
			$additional = $additional."AND starStars = 0 ";
			$additionalnowhere = $additional."AND starStars = 0 ";
		}
	}
	//DIFFICULTY FILTERS
	$diff = $db->quote($diff);
	$diff = str_replace("'","", $diff);
	if($diff != "-"){
		//IF NA
		if($diff == -1){
			if($additional == ""){
				$additional = "WHERE starDifficulty = 0 ";
				$additionalnowhere = "AND starDifficulty = 0 ";
			}else{
				$additional = $additional."AND starDifficulty = 0 ";
				$additionalnowhere = $additional."AND starDifficulty = 0 ";
			}
		}else if($diff == -3){
			if($additional == ""){
				$additional = "WHERE starAuto = 1 ";
				$additionalnowhere = "AND starAuto = 1 ";
			}else{
				$additional = $additional."AND starAuto = 1 ";
				$additionalnowhere = $additional."AND starAuto = 1 ";
			}
		}else if($diff == -2){
			if($additional == ""){
				$additional = "WHERE starDemon = 1 ";
				$additionalnowhere = "AND starDemon = 1 ";
			}else{
				$additional = $additional."AND starDemon = 0 ";
				$additionalnowhere = $additional."AND starDemon = 0 ";
			}
		}else{
			$diffarray = explode(",", $diff);
			$difficulties = "";
			foreach ($diffarray as &$difficulty) {
				if($difficulties != ""){
					$difficulties = $difficulties . "' OR starDifficulty = '";
				}
				$newdiff = $difficulty * 10;
				$difficulties = $difficulties . $newdiff;
			}
			if($additional == ""){
				$additional = "WHERE starAuto = 0 AND starDemon = 0 AND starDifficulty = '".$difficulties."' ";
				$additionalnowhere = "AND starAuto = 0 AND starDemon = 0 AND starDifficulty = '".$difficulties."' ";
			}else{
				$additional = $additional."AND starAuto = 0 AND starDemon = 0 AND starDifficulty = '".$difficulties."' ";
				$additionalnowhere = $additional."AND starAuto = 0 AND starDemon = 0 AND starDifficulty = '".$difficulties."' ";
			}
		}
	}
	//LENGTH FILTERS
	$len = $db->quote($len);
	$len = str_replace("'","", $len);
	if($len != "-"){
		$len = str_replace(",", "' OR levelLength = '", $len);
		if($additional == ""){
			$additional = "WHERE levelLength = '".$len."' ";
			$additionalnowhere = "AND levelLength = '".$len."' ";
		}else{
			$additional = $additional."AND levelLength = '".$len."' ";
			$additionalnowhere = $additional."AND levelLength = '".$len."' ";
		}
	}
	//TYPE DETECTION
        $str = htmlspecialchars($_POST["str"], ENT_QUOTES);
		$str = $db->quote($str);
	$str = str_replace("'","", $str);
	if($type==0 OR $type==15){ //most liked, changed to 15 in GDW for whatever reason
		if($str!=""){
		if(is_numeric($str)){
			$query = "SELECT * FROM levels WHERE levelID = '".$str."' ". $additionalnowhere . " ORDER BY likes DESC";
		}else{
			$query = "SELECT * FROM levels WHERE levelName LIKE '".$str."%' ". $additionalnowhere . " ORDER BY likes DESC";
		}
		}else{$type=2;}
		
	}
	$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
		$page = $db->quote($page);
	$page = str_replace("'","", $page);
	$lvlpagea = $page*10;
	$lvlpageaend = $lvlpagea +10;
	if($type==1){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY downloads DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==2){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY likes DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==3){ //RECENT
		$uploadDate = time() - (7 * 24 * 60 * 60);
		$query = "SELECT * FROM levels WHERE uploadDate > ".$uploadDate . " " . $additionalnowhere . " ORDER BY likes DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==4){ //RECENT
		$query = "SELECT * FROM levels ". $additional . " ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
    if($type==5){
		$query = "SELECT * FROM levels WHERE userID = '".$str."'ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==6 OR $type==17){
		$query = "SELECT * FROM levels WHERE NOT starFeatured = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==7){ //MAGIC
		$query = "SELECT * FROM levels WHERE objects > 9999 ". $additionalnowhere . " ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==11){
		$query = "SELECT * FROM levels WHERE NOT starStars = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==12){ //FOLLOWED
		$followed = htmlspecialchars($_POST["followed"],ENT_QUOTES);
			$followed = $db->quote($followed);
	$followed = str_replace("'","", $followed);
		$whereor = str_replace(",", " OR extID = ", $followed);
		$query = "SELECT * FROM levels WHERE extID = ".$whereor." ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==13){ //FRIENDS
		$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
			$accountID = $db->quote($accountID);
	$accountID = str_replace("'","", $accountID);
		$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
			$gjp = $db->quote($gjp);
	$gjp = str_replace("'","", $gjp);
		$gjpresult = $GJPCheck->check($gjp,$accountID);
		if($gjpresult == 1){
			$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
			$query = $db->prepare($query);
			$query->execute();
			$result = $query->fetchAll();
			$account = $result[0];
			$friendlist = $account["friends"];
			$friendsarray = explode(",", $friendlist);
			$whereor = str_replace(",", " OR extID = ", $friendlist);
			$query = "SELECT * FROM levels WHERE extID = ".$whereor." ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
		}
	}
	//echo $query;
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	$levelcount = $query->rowCount();
	for ($x = 0; $x < $levelcount; $x++) {
	$lvlpage = 0;
	$level1 = $result[$lvlpage+$x];
	if($level1["levelID"]!=""){
		if($x != 0){
		echo "|";
		$lvlsmultistring = $lvlsmultistring . ",";
	}
	$lvlsmultistring = $lvlsmultistring . $level1["levelID"];
	echo "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["userID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level1["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$level1["userID"]."'");
	$query12->execute();
$result12 = $query12->fetchAll();
if ($query12->rowCount() > 0) {
$userIDalmost = $result12[0];
$userID = $userIDalmost["extID"];
if(is_numeric($userID)){
	$userIDnumba = $userID;
}else{
	$userIDnumba = 0;
}
}
	if($x == 0){
	$levelsstring = $levelsstring . $level1["userID"] . ":" . $level1["userName"] . ":" . $userIDnumba;
	}else{
	$levelsstring = $levelsstring ."|" . $level1["userID"] . ":" . $level1["userName"] . ":" . $userIDnumba;
	}
	$userid = $userid + 1;
	}
	}
	echo "#".$levelsstring;
	echo "#".$songsstring;
	if (array_key_exists(8,$result)){
		echo "#9999:".$lvlpagea.":10";
	}else{
		$totallvlcount = $lvlpagea+$levelcount;
		echo "#".$totallvlcount.":".$lvlpagea.":10";
	}
}
if($type == 10){
		$str = $db->quote(htmlspecialchars($_POST["str"],ENT_QUOTES));
	$str = str_replace("'","", $str);
	$arr = explode( ',', $str);
	foreach ($arr as &$value) {
		if ($colonmarker != 1337){
			echo "|";
			$lvlsmultistring = $lvlsmultistring . ",";
		}
		$query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($value,ENT_QUOTES));
		$query->execute();
		$result2 = $query->fetchAll();
		$result = $result2[0];
				$timeago = $result["uploadDate"];
				$timeago2 = date('Y-M-D', $timeago);
				echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
				$lvlsmultistring = $lvlsmultistring . $result["levelID"];
				if ($colonmarker != 1337){
					$levelsstring = $levelsstring . "|";
				}
				if($result["songID"]!=0){
					array_push($songs, $result["songID"]);
				}
				$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$result["userID"]."'");
				$query12->execute();
				$result12 = $query12->fetchAll();
				if ($query12->rowCount() > 0) {
				$userIDalmost = $result12[0];
				$userID = $userIDalmost["extID"];
				if(is_numeric($userID)){
					$userIDnumba = $userID;
				}else{
					$userIDnumba = 0;
				}
				}
				$levelsstring = $levelsstring . $result["userID"] . ":" . $result["userName"] . ":" . $userIDnumba;
				$userid = $userid + 1;
				$colonmarker = 1335;
	}
	echo "#".$levelsstring;
	echo "#";
/*		foreach ($songs as $key => $value) {
			$query3=$db->prepare("select * from songs where ID = ".$value." ORDER BY ID ASC");
			$query3->execute();
			$result3 = $query3->fetchAll();
			$result4 = $result3[0];
			if($songcolonmarker != 1337){
				echo ":";
			}
			$songcolonmarker = 1335;
			echo "~1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0~";
		}*/
	echo "#1:0:10";
}
echo "#";
require "incl/generateHash.php";
$hash = new generateHash();
echo $hash->genMulti($lvlsmultistring);
?>