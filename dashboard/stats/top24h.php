<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("leaderboardTime"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$time = time() - 86400;
$bans = $gs->getAllBansOfBanType(0);
$extIDs = $userIDs = $bannedIPs = [];
foreach($bans AS &$ban) {
	switch($ban['personType']) {
		case 0:
			$extIDs[] = $ban['person'];
			break;
		case 1:
			$userIDs[] = $ban['person'];
			break;
		case 2:
			$bannedIPs[] = $gs->IPForBan($ban['person'], true);
			break;
	}
}
$extIDsString = "'".implode("','", $extIDs)."'";
$userIDsString = "'".implode("','", $userIDs)."'";
$bannedIPsString = implode("|", $bannedIPs);
$queryArray = [];
if($extIDsString != '') $queryArray[] = "users.extID NOT IN (".$extIDsString.")";
if($userIDsString != '') $queryArray[] = "users.userID NOT IN (".$userIDsString.")";
if(!empty($bannedIPsString)) $queryArray[] = "users.IP NOT REGEXP '".$bannedIPsString."'";
$queryText = !empty($queryArray) ? '('.implode(' AND ', $queryArray).') AND' : '';
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND ".$queryText." actions.value > 0 GROUP BY (stars) DESC ORDER BY stars DESC LIMIT 10 OFFSET $page");
$query->execute([':time' => $time]);
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
foreach($result as &$action){
	$userid = $action["extID"];
	$stars = $action["stars"];
	$strs = $stars[strlen($stars)-1];
	if($strs == 1) $star = 0; elseif($strs < 5 AND $strs != 0 AND ($stars > 20 OR $stars < 10)) $star = 1; else $star = 2;
	$coin = $db->prepare("SELECT SUM(coins) FROM levelscores WHERE accountID = :id AND uploadDate > :time");
	$coin->execute([':id' => $userid, ':time' => $time]);
	$coins = $coin->fetchColumn();
	if(empty($coins)) $coins = 0;
	$cns = $coins[strlen($coins)-1];
  	if($cns == 1) $lvl = 0; elseif($cns < 5 AND $cns > 0 AND ($cns > 20 OR $cns < 10)) $lvl = 1; else $lvl = 2;
	if(empty($action["userCoins"])) $action["userCoins"] = 0;
	$st = '<p class="profilepic">'.$action["stars"].' <i class="fa-solid fa-star"></i></p>';
	$uc = '<p class="profilepic">'.$action["userCoins"].' <i class="fa-solid fa-coins"></i></p>';
	$stats = $dl->createProfileStats($action["stars"], 0, 0, 0, $action['userCoins'], 0, 0, 0);
	switch($x) {
		case 1:
			$place = '<i class="fa-solid fa-trophy" style="color:#ffd700; margin-right: 5px;"> 1</i>';
			break;
		case 2:
			$place = '<i class="fa-solid fa-trophy" style="color:#c0c0c0; margin-right: 5px;"> 2</i>';
			break;
		case 3:
			$place = '<i class="fa-solid fa-trophy" style="color:#cd7f32; margin-right: 5px;"> 3</i>';
			break;
		default:
			$place = '<i class="fa" style="color:white; margin-right: 5px;"># '.$x.'</i>';
			break;
	}
	$members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile"><div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;"><button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'GET\')"><div class="acclistdiv">
				<h2 style="color:rgb('.$gs->getAccountCommentColor($userid).'); align-items: baseline;" class="profilenick acclistnick">'.$place.$action["userName"].'</h2>
			</div></button></div>
			<div class="form-control" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div class="acccomments"><h3 class="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("accountID").': <b>'.$userid.'</b></h3></div>
		</div></div>';
		$x++;
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("leaderboardTime").'</h1>
<div class="form-control new-form-control">
		'.$members.'
	</div></div>';
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND users.isBanned = 0 GROUP BY (stars) DESC ORDER BY stars DESC");
$query->execute([':time' => $time]);
$packcount = 0;
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow, true, "stats");
?>