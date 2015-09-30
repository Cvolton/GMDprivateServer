<?php
error_reporting(0);
include "connection.php";
$levelsstring = "";
$songsstring  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$colonmarker = 1337;
$songcolonmarker = 1337;
$userid = 1337;
if($type == 1 OR $type == 2 OR $type == 4 OR $type == 6 OR $type == 11){
	$query = "";
	$additional = "";
	$additionalnowhere ="";
	//ADDITIONAL PARAMETERS
	if($_POST["featured"]==1){
		$additional = "WHERE starFeatured = 1 ";
		$additionalnowhere = "AND starFeatured = 1 ";
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
	if($type==1){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY downloads DESC";
	}
	if($type==2){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY likes DESC";
	}
	if($type==4){
		$query = "SELECT * FROM levels ". $additional . " ORDER BY uploadDate DESC";
	}
	if($type==6){
		$query = "SELECT * FROM levels WHERE starFeatured = 1 ".$additionalnowhere." ORDER BY uploadDate DESC";
	}
	if($type==11){
		$query = "SELECT * FROM levels WHERE NOT starStars = 0 ".$additionalnowhere." ORDER BY uploadDate DESC";
	}
	$query = $db->prepare($query);
	$query->execute();
	$page = htmlspecialchars($_POST["page"],ENT_QUOTES);
	$lvlpage = $page*10;
	$result = $query->fetchAll();
	$level1 = $result[$lvlpage];
	if($level1["levelID"]!=""){
	echo "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$userid.":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"];
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
	$levelsstring = $levelsstring . $userid . ":" . $level1["userName"] . ":" . $level1["accountID"];
	$userid = $userid + 1;
	}
	$level2 = $result[$lvlpage+1];
	if($level2["levelID"]!=""){
	echo "|1:".$level2["levelID"].":2:".$level2["levelName"].":5:".$level2["levelVersion"].":6:".$userid.":8:10:9:".$level2["starDifficulty"].":10:".$level2["downloads"].":12:".$level2["audioTrack"].":13:".$level2["gameVersion"].":14:".$level2["likes"].":17:".$level2["starDemon"].":25:".$level2["starAuto"].":18:".$level2["starStars"].":19:".$level2["starFeatured"].":3:".$level2["levelDesc"].":15:".$level2["levelLength"].":30:".$level2["original"].":31:0:37:".$level2["coins"].":38:".$level2["starCoins"].":39:".$level2["requestedStars"].":35:".$level2["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level2["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level2["userName"] . ":" . $level2["accountID"];
	$userid = $userid + 1;
	}
	$level3 = $result[$lvlpage+2];
	if($level3["levelID"]!=""){
	echo "|1:".$level3["levelID"].":2:".$level3["levelName"].":5:".$level3["levelVersion"].":6:".$userid.":8:10:9:".$level3["starDifficulty"].":10:".$level3["downloads"].":12:".$level3["audioTrack"].":13:".$level3["gameVersion"].":14:".$level3["likes"].":17:".$level3["starDemon"].":25:".$level3["starAuto"].":18:".$level3["starStars"].":19:".$level3["starFeatured"].":3:".$level3["levelDesc"].":15:".$level3["levelLength"].":30:".$level3["original"].":31:0:37:".$level3["coins"].":38:".$level3["starCoins"].":39:".$level3["requestedStars"].":35:".$level3["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level3["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level3["userName"] . ":" . $level3["accountID"];
	$userid = $userid + 1;
	}
	$level4 = $result[$lvlpage+3];
	if($level4["levelID"]!=""){
	echo "|1:".$level4["levelID"].":2:".$level4["levelName"].":5:".$level4["levelVersion"].":6:".$userid.":8:10:9:".$level4["starDifficulty"].":10:".$level4["downloads"].":12:".$level4["audioTrack"].":13:".$level4["gameVersion"].":14:".$level4["likes"].":17:".$level4["starDemon"].":25:".$level4["starAuto"].":18:".$level4["starStars"].":19:".$level4["starFeatured"].":3:".$level4["levelDesc"].":15:".$level4["levelLength"].":30:".$level4["original"].":31:0:37:".$level4["coins"].":38:".$level4["starCoins"].":39:".$level4["requestedStars"].":35:".$level4["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level4["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level4["userName"] . ":" . $level4["accountID"];
	$userid = $userid + 1;
	}
	$level5 = $result[$lvlpage+4];
	if($level5["levelID"]!=""){
	echo "|1:".$level5["levelID"].":2:".$level5["levelName"].":5:".$level5["levelVersion"].":6:".$userid.":8:10:9:".$level5["starDifficulty"].":10:".$level5["downloads"].":12:".$level5["audioTrack"].":13:".$level5["gameVersion"].":14:".$level5["likes"].":17:".$level5["starDemon"].":25:".$level5["starAuto"].":18:".$level5["starStars"].":19:".$level5["starFeatured"].":3:".$level5["levelDesc"].":15:".$level5["levelLength"].":30:".$level5["original"].":31:0:37:".$level5["coins"].":38:".$level5["starCoins"].":39:".$level5["requestedStars"].":35:".$level5["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level5["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level5["userName"] . ":" . $level5["accountID"];
	$userid = $userid + 1;
	}
	$level6 = $result[$lvlpage+5];
	if($level6["levelID"]!=""){
	echo "|1:".$level6["levelID"].":2:".$level6["levelName"].":5:".$level6["levelVersion"].":6:".$userid.":8:10:9:".$level6["starDifficulty"].":10:".$level6["downloads"].":12:".$level6["audioTrack"].":13:".$level6["gameVersion"].":14:".$level6["likes"].":17:".$level6["starDemon"].":25:".$level6["starAuto"].":18:".$level6["starStars"].":19:".$level6["starFeatured"].":3:".$level6["levelDesc"].":15:".$level6["levelLength"].":30:".$level6["original"].":31:0:37:".$level6["coins"].":38:".$level6["starCoins"].":39:".$level6["requestedStars"].":35:".$level6["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level6["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level6["userName"] . ":" . $level6["accountID"];
	$userid = $userid + 1;
	}
	$level7 = $result[$lvlpage+6];
	if($level7["levelID"]!=""){
	echo "|1:".$level7["levelID"].":2:".$level7["levelName"].":5:".$level7["levelVersion"].":6:".$userid.":8:10:9:".$level7["starDifficulty"].":10:".$level7["downloads"].":12:".$level7["audioTrack"].":13:".$level7["gameVersion"].":14:".$level7["likes"].":17:".$level7["starDemon"].":25:".$level7["starAuto"].":18:".$level7["starStars"].":19:".$level7["starFeatured"].":3:".$level7["levelDesc"].":15:".$level7["levelLength"].":30:".$level7["original"].":31:0:37:".$level7["coins"].":38:".$level7["starCoins"].":39:".$level7["requestedStars"].":35:".$level7["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level7["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level7["userName"] . ":" . $level7["accountID"];
	$userid = $userid + 1;
	}
	$level8 = $result[$lvlpage+7];
	if($level8["levelID"]!=""){
	echo "|1:".$level8["levelID"].":2:".$level8["levelName"].":5:".$level8["levelVersion"].":6:".$userid.":8:10:9:".$level8["starDifficulty"].":10:".$level8["downloads"].":12:".$level8["audioTrack"].":13:".$level8["gameVersion"].":14:".$level8["likes"].":17:".$level8["starDemon"].":25:".$level8["starAuto"].":18:".$level8["starStars"].":19:".$level8["starFeatured"].":3:".$level8["levelDesc"].":15:".$level8["levelLength"].":30:".$level8["original"].":31:0:37:".$level8["coins"].":38:".$level8["starCoins"].":39:".$level8["requestedStars"].":35:".$level8["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level8["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level8["userName"] . ":" . $level8["accountID"];
	$userid = $userid + 1;
	}
	$level9 = $result[$lvlpage+8];
	if($level9["levelID"]!=""){
	echo "|1:".$level9["levelID"].":2:".$level9["levelName"].":5:".$level9["levelVersion"].":6:".$userid.":8:10:9:".$level9["starDifficulty"].":10:".$level9["downloads"].":12:".$level9["audioTrack"].":13:".$level9["gameVersion"].":14:".$level9["likes"].":17:".$level9["starDemon"].":25:".$level9["starAuto"].":18:".$level9["starStars"].":19:".$level9["starFeatured"].":3:".$level9["levelDesc"].":15:".$level9["levelLength"].":30:".$level9["original"].":31:0:37:".$level9["coins"].":38:".$level9["starCoins"].":39:".$level9["requestedStars"].":35:".$level9["songID"];
	if($songid!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level9["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level9["userName"] . ":" . $level9["accountID"];
	$userid = $userid + 1;
	}
	$level10 = $result[$lvlpage+9];
	if($level10["levelID"]!=""){
	echo "|1:".$level10["levelID"].":2:".$level10["levelName"].":5:".$level10["levelVersion"].":6:".$userid.":8:10:9:".$level10["starDifficulty"].":10:".$level10["downloads"].":12:".$level10["audioTrack"].":13:".$level10["gameVersion"].":14:".$level10["likes"].":17:".$level10["starDemon"].":25:".$level10["starAuto"].":18:".$level10["starStars"].":19:".$level10["starFeatured"].":3:".$level10["levelDesc"].":15:".$level10["levelLength"].":30:".$level10["original"].":31:0:37:".$level10["coins"].":38:".$level10["starCoins"].":39:".$level10["requestedStars"].":35:".$level10["songID"];
	if($level10["songID"]!=0){
		$query3=$db->prepare("select * from songs where ID = ".$level10["songID"]);
					$query3->execute();
					$result3 = $query3->fetchAll();
					$result4 = $result3[0];
					if($songcolonmarker != 1337){
						$songsstring = $songsstring . ":";
					}
					$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
					$songcolonmarker = 1335;
	}
	$levelsstring = $levelsstring ."|" . $userid . ":" . $level10["userName"] . ":" . $level10["accountID"];
	$userid = $userid + 1;
	}
	echo "#".$levelsstring;
	echo "#".$songsstring;
	echo "#9999:".$lvlpage.":10";
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
				echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$userid.":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
				if ($colonmarker != 1337){
					$levelsstring = $levelsstring . "|";
				}
				$levelsstring = $levelsstring . $userid . ":" . $result["userName"] . ":" . $result["accountID"];
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