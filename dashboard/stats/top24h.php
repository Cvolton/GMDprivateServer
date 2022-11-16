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
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("stars").'</th></tr>';
$time = time() - 86400;
$query = $db->prepare("SELECT users.extID, SUM(actions.value) AS stars, users.userName FROM actions INNER JOIN users ON actions.account = users.userID WHERE type = '9' AND timestamp > :time AND users.isBanned = 0 GROUP BY (stars) DESC ORDER BY stars DESC LIMIT 10");
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
	if($stars < 1) break;
	$table .= "<tr><th scope='row'>".$x."</th><td>".$userid."</td><td>".$username."</td><td>".$stars."</td></tr>";
	$x++;
}
if(empty(str_replace( '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("stars").'</th></tr>', '', $table))) {
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
$packcount = count($result);
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "stats");

?>