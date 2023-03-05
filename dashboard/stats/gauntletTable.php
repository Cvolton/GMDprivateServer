<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("gauntletTable"));
$dl->printFooter('../');
include "../".$dbPath."incl/lib/connection.php";
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$x = $page + 1;
$gauntlettable = "";
$query = $db->prepare("SELECT * FROM gauntlets ORDER BY ID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>');
	die();
} 
foreach($result as &$gauntlet){
	$lvlarray = array();
	for ($y = 1; $y < 6; $y++) {
		$lvlarray[] = $gauntlet["level".$y];
	}
	$lvltable = "";
	foreach($lvlarray as &$lvl){
		$query = $db->prepare("SELECT levelID,levelName,starStars,userID,coins FROM levels WHERE levelID = :levelID");
		$query->execute([':levelID' => $lvl]);
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
      	$user =  '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$gs->getUserName($level["userID"]).'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID" value="">'.$gs->getUserName($level["userID"]).'</button></form>';
		$lvltable .= "<tr>
						<td class='tcell'>".$level["levelID"]."</td>
						<td class='tcell'>".$level["levelName"]."</td>
						<td class='tcell'>".$user."</td>
						<td class='tcell'>".$stars."</td>
						<td class='tcell'>".$coins."</td>
					</tr>";
	}
	$gauntlettable .= "<tr>
					<th scope='row'>$x</th>
					<td>".$gs->getGauntletName($gauntlet["ID"]).' Gauntlet</td>
					<td><a class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							'.$dl->getLocalizedString("show").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;top: 0px;right: auto;position: absolute;transform: translate3d(308px, 163px, 0px);left: 0px;will-change: transform;">
							<table class="table" id="kek">
								<thead>
									<tr>
										<th class="tcell">'.$dl->getLocalizedString("ID").'</th>
										<th class="tcell">'.$dl->getLocalizedString("name").'</th>
										<th class="tcell">'.$dl->getLocalizedString("author").'</th>
										<th class="tcell">'.$dl->getLocalizedString("stars").'</th>
										<th class="tcell">'.$dl->getLocalizedString("userCoins").'</th>
									</tr>
								</thead>
								<tbody>
									'.$lvltable.'
								</tbody>
							</table>
						</div>
					</td>
					</tr>';
	$x++;
	echo "</td></tr>";
}
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM gauntlets");
$query->execute();
$gauntletcount = $query->fetchColumn();
$pagecount = ceil($gauntletcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
/* 
	printing
*/
$dl->printPage('<table class="table table-inverse">
  <thead>
    <tr>
      <th>#</th>
      <th>'.$dl->getLocalizedString("name").'</th>
      <th>'.$dl->getLocalizedString("levels").'</th>
    </tr>
  </thead>
  <tbody>
    '.$gauntlettable.'
  </tbody>
</table>'
.$bottomrow, true, "browse");
?>