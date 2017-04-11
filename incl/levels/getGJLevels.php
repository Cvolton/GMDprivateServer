<?php
//error_reporting(0);
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
require_once "../lib/mainLib.php";
$gs = new mainLib();
$GJPCheck = new GJPCheck();
$lvlstring = "";
$userstring = "";
$songsstring  = "";
$lvlsmultistring = "";
$params = array("NOT unlisted = 1");
if(isset($_POST["gameVersion"])){
	$gameVersion = $ep->remove($_POST["gameVersion"]);
}else{
	$gameVersion = 0;
}
if(!is_numeric($gameVersion)){
	exit("-1");
}
if($gameVersion == 20){
	$binaryVersion = $ep->remove($_POST["binaryVersion"]);
	if($binaryVersion > 27){
		$gameVersion++;
	}
}
if(isset($_POST["type"])){
	$type = $ep->remove($_POST["type"]);
}else{
	$type = 0;
}
$query = "";
if(isset($_POST["len"])){
	$len = $ep->remove($_POST["len"]);
}else{
	$len = "-";
}
if(isset($_POST["len"])){
	$diff = $ep->remove($_POST["diff"]);
}else{
	$diff = "-";
}
//ADDITIONAL PARAMETERS
if($gameVersion==0){
	$params[] = "gameVersion <= 18";
}else{
	$params[] = " gameVersion <= '$gameVersion'";
}
if(isset($_POST["featured"]) AND $_POST["featured"]==1){
	$params[] = "starFeatured = 1";
}
if(isset($_POST["original"]) AND $_POST["original"]==1){
	$params[] = "original = 0";
}
if(isset($_POST["coins"]) AND $_POST["coins"]==1){
		$params[] = "starCoins = 1 AND NOT coins = 0";
}
if(isset($_POST["epic"]) AND $_POST["epic"]==1){
	$params[] = "starEpic = 1";
}
if(isset($_POST["uncompleted"]) AND $_POST["uncompleted"]==1){
	$completedLevels = $ep->remove($_POST["completedLevels"]);
	$completedLevels = explode("(",$completedLevels)[1];
	$completedLevels = explode(")",$completedLevels)[0];
	$completedLevels = $db->quote($completedLevels);
	$completedLevels = str_replace("'","", $completedLevels);
	$params[] = "NOT levelID IN ($completedLevels)";
}
if(isset($_POST["onlyCompleted"]) AND $_POST["onlyCompleted"]==1){
	$completedLevels = $ep->remove($_POST["completedLevels"]);
	$completedLevels = explode("(","", $completedLevels)[1];
	$completedLevels = explode(")","", $completedLevels)[0];
	$completedLevels = $db->quote($completedLevels);
	$completedLevels = str_replace("'","", $completedLevels);
	$params[] = "levelID IN ($completedLevels)";
}
if(isset($_POST["song"])){
	if($_POST["customSong"]==0){
		$song = $ep->remove($_POST["song"]);
		$song = $db->quote($song);
		$song = $song -1;
		$params[] = "audioTrack = '$song' AND songID <> 0";
	}else{
		$song = $ep->remove($_POST["song"]);
		$params[] = "songID = '$song'";
	}
}
if(isset($_POST["twoPlayer"]) AND $_POST["twoPlayer"]==1){
	$params[] = "twoPlayer = 1";
}
if(isset($_POST["star"])){
	$params[] = "NOT starStars = 0";
}
if(isset($_POST["noStar"])){
	$params[] = "starStars = 0";
}
if(isset($_POST["gauntlet"])){
	$gauntlet = $ep->remove($_POST["gauntlet"]);
	$query=$db->prepare("SELECT * FROM gauntlets WHERE ID = :gauntlet");
	$query->execute([':gauntlet' => $gauntlet]);
	$actualgauntlet = $query->fetch();
	$str = $actualgauntlet["level1"].",".$actualgauntlet["level2"].",".$actualgauntlet["level3"].",".$actualgauntlet["level4"].",".$actualgauntlet["level5"];
	$params[] = "levelID IN ($str)";
}
//DIFFICULTY FILTERS
$diff = $db->quote($diff);
$diff = str_replace("'","", $diff);
$diff = explode(")",$diff)[0];
switch($diff){
	case -1:
		$params[] = "starDifficulty = '0'";
		break;
	case -3:
		$params[] = "starAuto = '1'";
		break;
	case -2:
		if(isset($_POST["demonFilter"])){
			$demonFilter = $ep->remove($_POST["demonFilter"]);
		}else{
			$demonFilter = 0;
		}
		$params[] = "starDemon = 1";
		switch($demonFilter){
			case 1:
				$params[] = "starDemonDiff = '3'";
				break;
			case 2:
				$params[] = "starDemonDiff = '4'";
				break;
			case 3:
				$params[] = "starDemonDiff = '0'";
				break;
			case 4:
				$params[] = "starDemonDiff = '5'";
				break;
			case 5:
				$params[] = "starDemonDiff = '6'";
				break;
			default:
				break;
		}
		break;
	case "-";
		break;
	default:
		$diff = str_replace(",", "0,", $diff) . "0";
		$params[] = "starDifficulty IN ($diff) AND starAuto = '0' AND starDemon = '0'";
		break;
}
//LENGTH FILTERS
$len = $db->quote($len);
$len = str_replace("'","", $len);
if($len != "-"){
	$params[] = "levelLength IN ($len)";
}
//TYPE DETECTION
if(isset($_POST["str"])){
	$str = $ep->remove($_POST["str"]);
	$str = $db->quote($str);
	$str = str_replace("'","", $str);
}else{
	$str = "";
}
if(isset($_POST["page"])){
	$page = $ep->remove($_POST["page"]);
	$page = $db->quote($page);
	$page = str_replace("'","", $page);
}else{
	$page = 0;
}
$lvlpagea = $page*10;
if($type==0 OR $type==15){ //most liked, changed to 15 in GDW for whatever reason
	$order = "likes";
	if($str!=""){
		if(is_numeric($str)){
			$params = array("levelID = '$str'");
		}else{
			$params[] = "levelName LIKE '%$str%'";
		}
	}
}
if($type==1){
	$order = "downloads";
}
if($type==2){
	$order = "likes";
}
if($type==3){ //TRENDING
	$uploadDate = time() - (7 * 24 * 60 * 60);
	$params[] = "uploadDate > $uploadDate ";
}
if($type==5){
	$params[] = "userID = '$str'";
}
if($type==6 OR $type==17){ //featured
	$params[] = "NOT starFeatured = 0";
}
if($type==16){ //HALL OF FAME
	$params[] = "NOT starEpic = 0";
}
if($type==7){ //MAGIC
	$params[] = "objects > 9999";
}
if($type==10){ //MAP PACKS
	$params[] = "levelID IN ($str)";
}
if($type==11){
	$params[] = "NOT starStars = 0";
}
if($type==12){ //FOLLOWED
	$followed = $ep->remove($_POST["followed"]);
	$followed = $db->quote($followed);
	$followed = explode(")",$followed)[0];
	$followed = str_replace("'","", $followed);
	$params[] = "extID IN ($followed)";
}
if($type==13){ //FRIENDS
	$peoplearray = array();
	$accountID = $ep->remove($_POST["accountID"]);
	$query = "SELECT person1,person2 FROM friendships WHERE person1 = :accountID OR person2 = :accountID"; //selecting friendships
	$query = $db->prepare($query);
	$query->execute([':accountID' => $accountID]);
	$result = $query->fetchAll();//getting friends
	if($query->rowCount() == 0){
		exit("-2");//if youre lonely
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
		$gjp = $ep->remove($_POST["gjp"]);
		$gjp = $db->quote($gjp);
		$gjp = str_replace("'","", $gjp);
		$gjpresult = $GJPCheck->check($gjp,$accountID);
		if($gjpresult == 1){
			$whereor = implode(",", $peoplearray);
			$params[] = "extID in ($whereor)";
		}
	}
}
if(!isset($order)){
	$order = "uploadDate";
}
$querybase = "FROM levels";
if(!empty($params)){
	$querybase .= " WHERE (" . implode(" ) AND ( ", $params) . ")";
}
$query = "(SELECT * $querybase ) ORDER BY $order DESC LIMIT 10 OFFSET $lvlpagea";
//echo $query;
$countquery = "SELECT count(*) $querybase";
$query = $db->prepare($query);
$query->execute();
//echo $countquery;
$countquery = $db->prepare($countquery);
$countquery->execute();
$totallvlcount = $countquery->fetchColumn();
$result = $query->fetchAll();
$levelcount = $query->rowCount();
foreach($result as &$level1) {
	if($level1["levelID"]!=""){
		$lvlsmultistring .= $level1["levelID"].",";
		if(isset($gauntlet)){
			$lvlstring .= "44:$gauntlet:";
		}
		$lvlstring .= "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["userID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":43:".$level1["starDemonDiff"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":42:".$level1["starEpic"].":45:".$level1["objects"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":46:1:47:2".":35:".$level1["songID"]."|";
		if($level1["songID"]!=0){
			$song = $gs->getSongString($level1["songID"]);
			if($song){
				$songsstring .= $gs->getSongString($level1["songID"]) . "~:~";
			}
		}
		$userstring .= $gs->getUserString($level1["userID"])."|";
	}
}
$lvlstring = substr($lvlstring, 0, -1);
$lvlsmultistring = substr($lvlsmultistring, 0, -1);
$userstring = substr($userstring, 0, -1);
$songsstring = substr($songsstring, 0, -3);
echo $lvlstring."#".$userstring;
if($gameVersion > 18){
	echo "#".$songsstring;
}
echo "#".$totallvlcount.":".$lvlpagea.":10";
echo "#";
require "../lib/generateHash.php";
$hash = new generateHash();
echo $hash->genMulti($lvlsmultistring);
?>