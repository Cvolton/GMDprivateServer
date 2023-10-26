<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
$gs = new mainLib();
/*
	generating modtable
*/
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
foreach($result as &$mod){
	$row++;
	$query = $db->prepare("SELECT lastPlayed FROM users WHERE extID = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$time = $dl->convertToDate($query->fetchColumn());
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id");
	$query->execute([':id' => $mod["accountID"]]);
	$actionscount = $query->fetchColumn();
	$query = $db->prepare("SELECT count(*) FROM modactions WHERE account = :id AND type = '1'");
	$query->execute([':id' => $mod["accountID"]]);
	$lvlcount = $query->fetchColumn();
	$modtable .= "<tr><th scope='row'>".$row."</th><td>".$mod["userName"]."</td><td>".$actionscount."</td><td>".$lvlcount."</td><td>".$time."</td></tr>";
}

/* 
	printing
*/
$dl->printPage('<table class="table table-inverse">
  <thead>
    <tr>
      <th>#</th>
      <th>'.$dl->getLocalizedString("mod").'</th>
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