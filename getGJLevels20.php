<?php
error_reporting(0);
include "connection.php";
$levelsstring = "";
$songsstring  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
if($type == 0 OR $type == 1 OR $type == 2 OR $type == 4 OR $type == 5 OR $type == 6 OR $type == 11){
	$query = "";
	$additional = "";
	$additionalnowhere ="";
	//ADDITIONAL PARAMETERS
	if($_POST["featured"]==1){
		$additional = "WHERE NOT starFeatured = 0 ";
		$additionalnowhere = "AND NOT starFeatured = 0 ";
	}
	if($_POST["original"]==1){
		if($additional = ""){
			$additional = "WHERE original = 0 ";
			$additionalnowhere = "AND original = 0 ";
		}else{
			$additional = $additional."AND original = 0 ";
			$additionalnowhere = $additional."AND original = 0 ";
		}
	}
	if($_POST["twoPlayer"]==1){
		if($additional = ""){
			$additional = "WHERE twoPlayer = 1 ";
			$additionalnowhere = "AND twoPlayer = 1 ";
		}else{
			$additional = $additional."AND twoPlayer = 1 ";
			$additionalnowhere = $additional."AND twoPlayer = 1 ";
		}
	}
	if($_POST["star"]==1){
		if($additional = ""){
			$additional = "WHERE NOT starStars = 0 ";
			$additionalnowhere = "AND NOT starStars = 0 ";
		}else{
			$additional = $additional."AND NOT starStars = 0 ";
			$additionalnowhere = $additional."AND NOT starStars = 0 ";
		}
	}
	//TYPE DETECTION
        $str = htmlspecialchars($_POST["str"], ENT_QUOTES);
	if($type==0){
		if(is_numeric($_POST["str"])){
			$query = "SELECT * FROM levels WHERE levelID = '".$str."' ". $additionalnowhere . " ORDER BY likes DESC";
		}else{
			$query = "SELECT * FROM levels WHERE levelName LIKE '".$str."%' ". $additionalnowhere . " ORDER BY likes DESC";
		}
		
	}
	$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
	$lvlpagea = $page*10;
	$lvlpageaend = $lvlpage +10;
	if($type==1){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY downloads DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==2){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY likes DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==4){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
        if($type==5){
		$query = "SELECT * FROM levels WHERE userID = '".$str."'ORDER BY likes DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==6){
		$query = "SELECT * FROM levels WHERE NOT starFeatured = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	if($type==11){
		$query = "SELECT * FROM levels WHERE NOT starStars = 0 ".$additionalnowhere." ORDER BY uploadDate DESC LIMIT ".$lvlpagea.",".$lvlpageaend."";
	}
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	for ($x = 0; $x < 9; $x++) {
	$lvlpage = 0;
	$level1 = $result[$lvlpage+$x];
	if($level1["levelID"]!=""){
		if($x != 0){
		echo "|";
	}
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
	echo "#9999:".$lvlpagea.":10";
}
if($type == 10){
	$arr = explode( ',', htmlspecialchars($_POST["str"],ENT_QUOTES) );
	foreach ($arr as &$value) {
		if ($colonmarker != 1337){
			echo "|";
		}
		$query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($value,ENT_QUOTES));
		$query->execute();
		$result2 = $query->fetchAll();
		$result = $result2[0];
				$timeago = $result["uploadDate"];
				$timeago2 = date('Y-M-D', $timeago);
				//TO JE KOD NA STAHOVANI TY DEMENTE AAAA echo"1:".$result["levelID"].":2:".$result["levelName"].":3:".$result["levelDesc"].":4:".$result["levelString"].":5:".$result["levelVersion"].":6:0:8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":11::12:0:13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":".$level1["starFeatured"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:28:".$timeago2. ":29:".$timeago2. ":35:118355:36:".$result["extraString"].":37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":27:AwYDBwcBAQ==";
				echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
				if ($colonmarker != 1337){
					$levelsstring = $levelsstring . "|";
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
				$levelsstring = $levelsstring . $result["userID"] . ":" . $level1["userName"] . ":" . $userIDnumba;
				if($result["songID"]!=0){
					$query3=$db->prepare("select * from songs where ID = ".$result["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
				}
				$userid = $userid + 1;
				$colonmarker = 1335;
	}
	echo "#".$levelsstring;
	echo "#".$songsstring;
	echo "#9999:0:10";
}
?>	