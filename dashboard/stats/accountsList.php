<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
error_reporting(0);
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("accounts"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("username").'</th><th>'.$dl->getLocalizedString("accountID").'</th><th>'.$dl->getLocalizedString("registerDate").'</th><th>'.$dl->getLocalizedString("isAdmin").'</th><th>'.$dl->getLocalizedString("lastSeen").'</th></tr>';
$query = $db->prepare("SELECT * FROM accounts ORDER BY accountID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
	die();
} 
foreach($result as &$action){
	$isAdmin = $action["isAdmin"];
	$accountID = $action["accountID"].' <text style="color:gray">|</text> '.$gs->getUserID($action["accountID"]);
  	if($action["accountID"] == $gs->getUserID($action["accountID"])) $accountID = $action["accountID"];
  	$username = '<form style="margin:0" method="post" action="profile/"><button style="margin:0" class="accbtn" name="accountID" value="'.$action["accountID"].'">'.$action["userName"].'</button></form>';
  	$query = $db->prepare("SELECT lastPlayed FROM users WHERE extID=:id");
  	$query->execute([':id' => $action["accountID"]]);
  	$lastseen = $query->fetch();
  	$lastPlayed = $dl->convertToDate($lastseen["lastPlayed"]);
  	if($lastseen["lastPlayed"] == 0 OR empty($lastseen)) $lastPlayed = '<div style="color:gray">'.$dl->getLocalizedString("never").'</div>';
	$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID =:accid");
	$query->execute([':accid' => $accountID]);
	$resultRole = implode($query->fetch());
	if(empty($resultRole)){
		$resultRole = $dl->getLocalizedString("player");
	} else {
      	$color = mb_substr($resultRole, 1);
		switch($resultRole) {
			case 11:
				$resultRole = $dl->getLocalizedString("admin");
				break;
			case 22:
				$resultRole = $dl->getLocalizedString("elder");
				break;
			case 33:
				$resultRole = $dl->getLocalizedString("moder");
				break;
		}
    $query = $db->prepare("SELECT commentColor FROM roles WHERE roleID = :rid");
  	$query->execute([':rid' => $color]);
  	$color = $query->fetch();
  	$resultRole = '<div style="color:rgb('.$color["commentColor"].')">'.$resultRole.'</div>';
	}
	$registerDate = date("d.m.Y", $action["registerDate"]);
	$table .= "<tr><th scope='row'>".$x."</th><td>".$username."</td><td>".$accountID."</td><td>".$registerDate."</td><td>".$resultRole."</td><td>".$lastPlayed."</td></tr>";
	$x++;
}
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM accounts");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
?>