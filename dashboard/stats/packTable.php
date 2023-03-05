<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl->title($dl->getLocalizedString("packTable"));
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
$packtable = "";
$query = $db->prepare("SELECT levels,name,stars,coins,rgbcolors FROM mappacks ORDER BY ID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'browse');
	die();
} 
foreach($result as &$pack){
	$lvlarray = explode(",", $pack["levels"]);
	$lvltable = "";
  	$color = $pack['rgbcolors'];
     $starspack = $pack["stars"];
     if($starspack < 5) {
              $star = 1;
     } elseif($starspack > 4) {
              $star = 2;
     } else {
              $star = 0;
     }
		$starspack = $pack["stars"].' '.$dl->getLocalizedString("starsLevel$star");
  	    $coinspack = $pack["coins"];
        	if($coinspack == 1) $coin = 0;
     		else $coin = 1;
			$coinspack = $pack["coins"].' '.$dl->getLocalizedString("coins$coin");
      		if($pack["coins"] == 0) $coinspack = '<div style="color:grey">'.$dl->getLocalizedString("noCoins").'</div>';
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
	$packtable .= "<tr>
					<th scope='row'>$x</th>
					<td style='color:rgb(".$color.");font-weight:700'>".htmlspecialchars($pack["name"],ENT_QUOTES)."</td>
					<td>".$starspack."</td>
					<td>".$coinspack.'</td>
					<td><a class="btn-rendel" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							'.$dl->getLocalizedString("show").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding: 17px 17px 0px;position: absolute;transform: translate3d(416px, 163px, 0px);top: 0px;left: 0px;will-change: transform;">
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
}
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM mappacks");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
/* 
	printing
*/
$dl->printPage('<table class="table table-inverse">
  <thead>
    <tr>
      <th>#</th>
      <th>'.$dl->getLocalizedString("name").'</th>
      <th>'.$dl->getLocalizedString("stars").'</th>
      <th>'.$dl->getLocalizedString("coins").'</th>
	  <th>'.$dl->getLocalizedString("levels").'</th>
    </tr>
  </thead>
  <tbody>
    '.$packtable.'
  </tbody>
</table>'
.$bottomrow, true, 'browse');
?>