<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/mainLib.php";
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
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("coins").'</th></tr>';
$time = time() - 86400;
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND users.isBanned = 0 GROUP BY (stars) DESC ORDER BY stars DESC LIMIT 10 OFFSET $page");
$query->execute([':time' => $time]);
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'mod');
	die();
} 
foreach($result as &$action){
	$userid = $action["extID"];
	$username =  '<form style="margin:0" method="post" action="profile/"><button style="margin:0" class="accbtn" name="accountID" value="'.$action["extID"].'">'.$action["userName"].'</button></form>';
	$stars = $action["stars"];
	$strs = end(str_split($stars));
	if($strs == 1) $star = 0; elseif($strs < 5 AND $strs != 0 AND $stars > 20 OR $stars < 10) $star = 1; else $star = 2;
    $stars = $stars.' '.$dl->getLocalizedString("starsLevel$star");
	if($stars < 1) break;
	$coin = $db->prepare("SELECT coins FROM levelscores WHERE accountID = :id");
	$coin->execute([':id' => $userid]);
	$coins = $coin->fetchColumn();
	if(empty($coins)) $coins = 0;
	if($coins > 1) $coin = 1; elseif($coins == 0) $coin = 2; else $coin = 0;
	$coins = $coins.' '.$dl->getLocalizedString("coins$coin");
 	$table .= "<tr><th scope='row'>".$x."</th><td>".$userid."</td><td>".$username."</td><td>".$stars."</td><td>".$coins."</td></tr>";
	$x++;
}
if(empty(str_replace( '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("stars").'</th><th>'.$dl->getLocalizedString("coins").'</th></tr>', '', $table))) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'mod');
	die();
} 
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND users.isBanned = 0 GROUP BY (stars) DESC ORDER BY stars DESC");
$query->execute([':time' => $time]);
$packcount = count($query->fetchColumn());
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "stats");
?>