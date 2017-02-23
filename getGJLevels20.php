<?php
//error_reporting(0);
include "connection.php";
require_once "incl/GJPCheck.php";
$GJPCheck = new GJPCheck();
$levelsstring = "";
$songsstring  = "";
$gameVersion = htmlspecialchars($_POST["gameVersion"],ENT_QUOTES);
if($gameVersion == 20){
	$binaryVersion = htmlspecialchars($_POST["binaryVersion"],ENT_QUOTES);
	if($binaryVersion > 27){
		$gameVersion++;
	}
}
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$gauntlet = htmlspecialchars($_POST["gauntlet"],ENT_QUOTES);
$demonFilter = htmlspecialchars($_POST["demonFilter"],ENT_QUOTES);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
if($type != 10 AND $gauntlet == ""){
	$query = "";
	$len = htmlspecialchars($_POST["len"],ENT_QUOTES);
	$diff = htmlspecialchars($_POST["diff"],ENT_QUOTES);
	//ADDITIONAL PARAMETERS
	$additional = "WHERE NOT unlisted = 1 ";
	$additionalnowhere = "AND NOT unlisted = 1 ";
	if($gameVersion==""){
		if($additional == ""){
			$additional = "WHERE gameVersion <= 18";
			$additionalnowhere = "AND gameVersion <= 18";
		}else{
			$additional = $additional."AND gameVersion <= 18";
			$additionalnowhere = $additionalnowhere."AND gameVersion <= 18";
		}
	}else{
		$gameVersion = $db->quote($gameVersion);
		$gameVersion = str_replace("'", "", $gameVersion);
		if($additional == ""){
			$additional = "WHERE gameVersion <= '".$gameVersion."'";
			$additionalnowhere = "AND gameVersion <= '".$gameVersion."'";
		}else{
			$additional = $additional."AND gameVersion <= '".$gameVersion."'";
			$additionalnowhere = $additionalnowhere."AND gameVersion <= '".$gameVersion."'";
		}
	}
	if($_POST["featured"]==1){
		if($additional == ""){
			$additional = "WHERE starFeatured = 1 ";
			$additionalnowhere = "AND starFeatured = 1 ";
		}else{
			$additional = $additional."AND starFeatured = 1 ";
			$additionalnowhere = $additionalnowhere."AND starFeatured = 1 ";
		}
	}
	if($_POST["original"]==1){
		if($additional == ""){
			$additional = "WHERE original = 0 ";
			$additionalnowhere = "AND original = 0 ";
		}else{
			$additional = $additional."AND original = 0 ";
			$additionalnowhere = $additionalnowhere."AND original = 0 ";
		}
	}
	if($_POST["coins"]==1){
		if($additional == ""){
			$additional = "WHERE starCoins = 1 AND NOT coins = 0 ";
			$additionalnowhere = "AND starCoins = 1 AND NOT coins = 0 ";
		}else{
			$additional = $additional."AND starCoins = 1 AND NOT coins = 0 ";
			$additionalnowhere = $additionalnowhere."AND starCoins = 1 AND NOT coins = 0 ";
		}
	}
	if($_POST["epic"]==1){
		if($additional == ""){
			$additional = "WHERE starEpic = 1 ";
			$additionalnowhere = "AND starEpic = 1 ";
		}else{
			$additional = $additional."AND starEpic = 1 ";
			$additionalnowhere = $additionalnowhere."AND starEpic = 1 ";
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
			$additionalnowhere = $additionalnowhere."AND NOT levelID = '".$completedLevels."' ";
		}
	}
	if($_POST["onlyCompleted"]==1){
		$completedLevels = htmlspecialchars($_POST["completedLevels"],ENT_QUOTES);
		$completedLevels = str_replace("(","", $completedLevels);
		$completedLevels = str_replace(")","", $completedLevels);
		$completedLevels = $db->quote($completedLevels);
		$completedLevels = str_replace("'","", $completedLevels);
		$completedLevels = str_replace(",","' OR levelID = '", $completedLevels);
		if($additional == ""){
			$additional = "WHERE levelID = '".$completedLevels."' ";
			$additionalnowhere = "OR levelID = '".$completedLevels."' ";
		}else{
			$additional = $additional."AND levelID = '".$completedLevels."' ";
			$additionalnowhere = $additionalnowhere."OR levelID = '".$completedLevels."' ";
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
				$additionalnowhere = $additionalnowhere."AND audioTrack = '".$song."' AND songID <> 0 ";
			}
		}else{
			$song = htmlspecialchars($_POST["song"],ENT_QUOTES);
			if($additional == ""){
				$additional = "WHERE songID = '".$song."' ";
				$additionalnowhere = "AND songID = '".$song."' ";
			}else{
				$additional = $additional."AND songID = '".$song."' ";
				$additionalnowhere = $additionalnowhere."AND songID = '".$song."' ";
			}
		}
	}
	if($_POST["twoPlayer"]==1){
		if($additional == ""){
			$additional = "WHERE twoPlayer = 1 ";
			$additionalnowhere = "AND twoPlayer = 1 ";
		}else{
			$additional = $additional."AND twoPlayer = 1 ";
			$additionalnowhere = $additionalnowhere."AND twoPlayer = 1 ";
		}
	}
	if($_POST["star"]==1){
		if($additional == ""){
			$additional = "WHERE NOT starStars = 0 ";
			$additionalnowhere = "AND NOT starStars = 0 ";
		}else{
			$additional = $additional."AND NOT starStars = 0 ";
			$additionalnowhere = $additionalnowhere."AND NOT starStars = 0 ";
		}
	}
	if($_POST["noStar"]==1){
		if($additional == ""){
			$additional = "WHERE starStars = 0 ";
			$additionalnowhere = "AND starStars = 0 ";
		}else{
			$additional = $additional."AND starStars = 0 ";
			$additionalnowhere = $additionalnowhere."AND starStars = 0 ";
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
				$additionalnowhere = $additionalnowhere."AND starDifficulty = 0 ";
			}
		}else if($diff == -3){
			if($additional == ""){
				$additional = "WHERE starAuto = 1 ";
				$additionalnowhere = "AND starAuto = 1 ";
			}else{
				$additional = $additional."AND starAuto = 1 ";
				$additionalnowhere = $additionalnowhere."AND starAuto = 1 ";
			}
		}else if($diff == -2){
			if($additional == ""){
				$additional = "WHERE starDemon = 1 ";
				$additionalnowhere = "AND starDemon = 1 ";
			}else{
				$additional = $additional."AND starDemon = 1 ";
				$additionalnowhere = $additionalnowhere."AND starDemon = 1 ";
			}
			if($demonFilter == 1){
				if($additional == ""){
					$additional = "WHERE starDemonDiff = 3 ";
					$additionalnowhere = "AND starDemonDiff = 3 ";
				}else{
					$additional = $additional."AND starDemonDiff = 3 ";
					$additionalnowhere = $additionalnowhere."AND starDemonDiff = 3 ";
				}	
			}
			if($demonFilter == 2){
				if($additional == ""){
					$additional = "WHERE starDemonDiff = 4 ";
					$additionalnowhere = "AND starDemonDiff = 4 ";
				}else{
					$additional = $additional."AND starDemonDiff = 4 ";
					$additionalnowhere = $additionalnowhere."AND starDemonDiff = 4 ";
				}	
			}
			if($demonFilter == 3){
				if($additional == ""){
					$additional = "WHERE starDemonDiff = 0 ";
					$additionalnowhere = "AND starDemonDiff = 0 ";
				}else{
					$additional = $additional."AND starDemonDiff = 0 ";
					$additionalnowhere = $additionalnowhere."AND starDemonDiff = 0 ";
				}	
			}
			if($demonFilter == 4){
				if($additional == ""){
					$additional = "WHERE starDemonDiff = 5 ";
					$additionalnowhere = "AND starDemonDiff = 5 ";
				}else{
					$additional = $additional."AND starDemonDiff = 5 ";
					$additionalnowhere = $additionalnowhere."AND starDemonDiff = 5 ";
				}	
			}
			if($demonFilter == 5){
				if($additional == ""){
					$additional = "WHERE starDemonDiff = 6 ";
					$additionalnowhere = "AND starDemonDiff = 6 ";
				}else{
					$additional = $additional."AND starDemonDiff = 6 ";
					$additionalnowhere = $additionalnowhere."AND starDemonDiff = 6 ";
				}
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
				$additionalnowhere = $additionalnowhere."AND starAuto = 0 AND starDemon = 0 AND starDifficulty = '".$difficulties."' ";
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
			$additionalnowhere = $additionalnowhere."AND levelLength = '".$len."' ";
		}
	}
	//TYPE DETECTION
   $str = htmlspecialchars($_POST["str"], ENT_QUOTES);
		$str = $db->quote($str);
	$str = str_replace("'","", $str);
	$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
	$lvlpagea = $page*10;
	if($type==0 OR $type==15){ //most liked, changed to 15 in GDW for whatever reason
		if($str!=""){
		if(is_numeric($str)){
			$query = "SELECT * FROM levels WHERE levelID = '".$str."' ORDER BY likes DESC LIMIT 10 OFFSET $lvlpagea";
		}else{
			$query = "SELECT * FROM levels WHERE levelName LIKE '".$str."%' ". $additionalnowhere . " ORDER BY likes DESC LIMIT 10 OFFSET $lvlpagea";
		}
		}else{$type=2;}
		
	}
	if($type==1){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY downloads DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==2){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY likes DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==3){ //TRENDING
		$uploadDate = time() - (7 * 24 * 60 * 60);
		$query = "SELECT * FROM levels WHERE uploadDate > ".$uploadDate . " " . $additionalnowhere . " ORDER BY likes DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==4){ //RECENT
		$query = "SELECT * FROM levels ". $additional . " ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
    if($type==5){
		$query = "SELECT * FROM levels WHERE userID = '".$str."' " . $additionalnowhere . " ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==6 OR $type==17){
		$query = "SELECT * FROM levels WHERE NOT starFeatured = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==16){ //HALL OF FAME
		$query = "SELECT * FROM levels WHERE NOT starEpic = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==7){ //MAGIC
		$query = "SELECT * FROM levels WHERE objects > 9999 ". $additionalnowhere . " ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==11){
		$query = "SELECT * FROM levels WHERE NOT starStars = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==12){ //FOLLOWED
		$followed = htmlspecialchars($_POST["followed"],ENT_QUOTES);
		$followed = $db->quote($followed);
		$followed = str_replace("'","", $followed);
		$whereor = str_replace(",", " OR extID = ", $followed);
		$query = "SELECT * FROM levels WHERE extID = ".$whereor." ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
	}
	if($type==13){ //FRIENDS
		$peoplearray = array();
		$accountID = htmlspecialchars($_POST["accountID"], ENT_QUOTES);
		$query = "SELECT * FROM friendships WHERE person1 = :accountID OR person2 = :accountID"; //selecting friendships
		$query = $db->prepare($query);
		$query->execute([':accountID' => $accountID]);
		$result = $query->fetchAll();//getting friends
		if($query->rowCount() == 0){
			echo "-2";//if youre lonely
		}
		else
		{//oh so you actually have some friends kden
			foreach ($result as &$friendship) {
				$person = $friendship["person1"];
				if($friendship["person1"] == $accountID){
					$person = $friendship["person2"];
				}
				$peoplearray[] = $person;
			}
			$gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
			$gjp = $db->quote($gjp);
			$gjp = str_replace("'","", $gjp);
			$gjpresult = $GJPCheck->check($gjp,$accountID);
			if($gjpresult == 1){
				$whereor = implode(" OR extID = ", $peoplearray);
				$query = "SELECT * FROM levels WHERE extID = ".$whereor." ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT 10 OFFSET $lvlpagea";
			}
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
			echo "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["userID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":43:".$level1["starDemonDiff"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"].":42:".$level1["starEpic"]."";
			if($level1["songID"]!=0){
				$query3=$db->prepare("select * from songs where ID = ".$level1["songID"]);
				$query3->execute();
				$result3 = $query3->fetchAll();
				$result4 = $result3[0];
				if($result4["name"] != ""){
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . "~:~";
					}
					$dl = $result4["download"];
					if(strpos($dl, ':') !== false){
						$dl = urlencode($dl);
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
				}
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
			if($x != 0){
				$levelsstring = $levelsstring . "|";
			}
			$levelsstring = $levelsstring . $level1["userID"] . ":" . $level1["userName"] . ":" . $userIDnumba;
		}
	}
	echo "#".$levelsstring;
	if($gameVersion > 18){
		echo "#".$songsstring;
	}
	if (array_key_exists(8,$result)){
		echo "#9999:".$lvlpagea.":10";
	}else{
		$totallvlcount = $lvlpagea+$levelcount;
		echo "#".$totallvlcount.":".$lvlpagea.":10";
	}
}
if($type == 10 OR $gauntlet != ""){
	if($gauntlet != ""){
		$query=$db->prepare("select * from gauntlets where ID = :gauntlet");
		$query->execute([':gauntlet' => $gauntlet]);
		$actualgauntlet = $query->fetchAll();
		$actualgauntlet = $actualgauntlet[0];
		$str = $actualgauntlet["level1"].",".$actualgauntlet["level2"].",".$actualgauntlet["level3"].",".$actualgauntlet["level4"].",".$actualgauntlet["level5"];
	}
	if($type == 10){
		$str = $db->quote(htmlspecialchars($_POST["str"],ENT_QUOTES));
		$str = str_replace("'","", $str);	
	}
	$arr = explode( ',', $str);
	foreach ($arr as &$value) {
		if ($colonmarker != 1337){
			echo "|";
			$lvlsmultistring = $lvlsmultistring . ",";
		}
		$query=$db->prepare("select * from levels where levelID = :value");
		$query->execute([':value' => $value]);
		$result2 = $query->fetchAll();
		$result = $result2[0];
		$timeago = $result["uploadDate"];
		$timeago2 = date('Y-M-D', $timeago);
		echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":43:".$result["starDemonDiff"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"].":42:".$result["starEpic"]."";
		if($gauntlet != ""){
			echo ":44:".$gauntlet."";
		}
		$lvlsmultistring = $lvlsmultistring . $result["levelID"];
		if ($colonmarker != 1337){
			$levelsstring = $levelsstring . "|";
		}
		if($result["songID"]!=0){
			$query3=$db->prepare("select * from songs where ID = ".$result["songID"]);
			$query3->execute();
			$result3 = $query3->fetchAll();
			$result4 = $result3[0];
			if($songcolonmarker != 1337){
				$songsstring = $songsstring . "~:~";
			}
			$dl = $result4["download"];
			if(strpos($dl, ':') !== false){
				$dl = urlencode($dl);
			}
			$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$dl."~|~7~|~~|~8~|~0";
			$songcolonmarker = 1335;
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
	if($gameVersion > 18){
		echo "#".$songsstring;
	}
	echo "#1:0:10";
}
echo "#";
require "incl/generateHash.php";
$hash = new generateHash();
echo $hash->genMulti($lvlsmultistring);
?>