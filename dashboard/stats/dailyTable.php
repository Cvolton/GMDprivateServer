<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
require "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("dailyTable"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$dailytable = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$query = $db->prepare("SELECT * FROM dailyfeatures WHERE timestamp < :time ORDER BY feaID DESC LIMIT 10 OFFSET $page");
$query->execute([':time' => time()]);
$result = $query->fetchAll();
$query = $db->prepare("SELECT count(*) FROM dailyfeatures WHERE timestamp < :time");
$query->execute([':time' => time()]);
$dailycount = $query->fetchColumn();
$x = $dailycount - $page;
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
//printing data
foreach($result as &$daily){
	//getting level data
  	if($daily["type"] == 0) $type = 'Daily'; else $type = 'Weekly';
    $query = $db->prepare("SELECT levelName,userID,starStars,coins FROM levels WHERE levelID = :levelID");
	$query->execute([':levelID' => $daily["levelID"]]);
	$level = $query->fetch();
  	$stars = $level["starStars"];
        if($stars < 5) $star = 1;
        elseif($stars > 4) $star = 2;
        else $star = 0;
		$stars = $level["starStars"].' '.$dl->getLocalizedString("starsLevel$star");
    $coins = $level["coins"];
        if($coins == 1) $coin = 0;
     	else $coin = 1;
		$coins = $level["coins"].' '.$dl->getLocalizedString("coins$coin");
      	if($level["coins"] == 0) $coins = '<div style="color:grey">'.$dl->getLocalizedString("noCoins").'</div>';
	if($query->rowCount() == 0){
		$level["levelName"] = $dl->getLocalizedString("deletedLevel");
		$level["userID"] = 0;
		$stars = -1;
		$coins = -1;
	}
  	$user =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$gs->getUserName($level["userID"]).'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID" value="">'.$gs->getUserName($level["userID"]).'</button></form>';
	$dailytable .= '<tr>
					<th scope="row">'.$x.'</th>
					<td>'.$daily["levelID"].'</th>
					<td>'.$level["levelName"].'</td>
					<td>'.$user.'</td>
					<td>'.$stars.'</td>
					<td>'.$coins.'</td>
					<td>'.date('d.m.Y', $daily["timestamp"]).'</td>
                    <td>'.$type.'</td>
				</tr>';
	$x--;
	echo "</td></tr>";
}
/*
	bottom row
*/
$pagecount = ceil($dailycount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
/* 
	printing
*/
$dl->printPage('<table class="table table-inverse">
	<thead>
		<tr>
			<th>#</th>
			<th>'.$dl->getLocalizedString("ID").'</th>
			<th>'.$dl->getLocalizedString("name").'</th>
			<th>'.$dl->getLocalizedString("author").'</th>
			<th>'.$dl->getLocalizedString("stars").'</th>
			<th>'.$dl->getLocalizedString("userCoins").'</th>
			<th>'.$dl->getLocalizedString("time").'</th>
            <th>'.$dl->getLocalizedString("type").'</th>
		</tr>
	</thead>
	<tbody>
		'.$dailytable.'
	</tbody>
</table>'
.$bottomrow, true, "stats");
?>