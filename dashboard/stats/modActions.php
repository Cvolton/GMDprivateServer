<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("modActions"));
$dl->printFooter('../');
$modtable = "";
$accounts = implode(",",$gs->getAccountsWithPermission("toolModactions"));
if($accounts == ""){
	$dl->printBox(sprintf($dl->getLocalizedString("errorNoAccWithPerm"), "toolsModactions"));
	exit();
}
$query = $db->prepare("SELECT accountID, userName FROM accounts WHERE accountID IN ($accounts) ORDER BY userName ASC");
$query->execute();
$result = $query->fetchAll();
$row = 0;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action="../dashboard">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
foreach($result as &$mod){
	$row++;
	$query = $db->prepare("SELECT lastPlayed FROM users WHERE extID = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$lastPlayed = $query->fetchColumn();
  	$time = $dl->convertToDate($lastPlayed);
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->fetchColumn();
	if ($lastPlayed == 0) $time = '<div style="color:gray">'.$dl->getLocalizedString("never").'</div>';
 	$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID =:accid");
	$query->execute([':accid' => $mod["accountID"]]);
	$resultRole = implode($query->fetch());
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
  	$actions = $actionscount[strlen($actionscount)-1];
  	if($actions == 1) $action = 0; elseif($actions < 5) $action = 1; else $action = 2;
  	if($actionscount > 9 AND $actionscount < 20) $action = 2;
  	$actionscount = $actionscount.' '.$dl->getLocalizedString("action$action");
  	$levels = $lvlcount[strlen($lvlcount)-1];
  	if($levels == 1) $lvl = 0; elseif($levels < 5) $lvl = 1; else $lvl = 2;
  	if($lvlcount > 9 AND $lvlcount < 20) $lvl = 2;
  	$lvlcount = $lvlcount.' '.$dl->getLocalizedString("lvl$lvl");
  	if($actionscount == 0) $actionscount = '<div style="color:grey">'.$dl->getLocalizedString("noActions").'</div>';
	if($lvlcount == 0) $lvlcount = '<div style="color:grey">'.$dl->getLocalizedString("noRates").'</div>';
	$modtable .= "<tr><th scope='row'>".$row."</th><td>".$mod["userName"]."</td><td>".$resultRole."</td><td>".$actionscount."</td><td>".$lvlcount."</td><td>".$time."</td></tr>";
}

/* 
	printing
*/
$dl->printPage('<table class="table table-inverse">
  <thead>
    <tr>
      <th>#</th>
      <th>'.$dl->getLocalizedString("mod").'</th>
      <th>'.$dl->getLocalizedString("isAdmin").'</th>
      <th>'.$dl->getLocalizedString("count").'</th>
      <th>'.$dl->getLocalizedString("ratedLevels").'</th>
	<th>'.$dl->getLocalizedString("lastSeen").'</th>
    </tr>
  </thead>
  <tbody>
    '.$modtable.'
  </tbody>
</table>', true, "stats");
?>