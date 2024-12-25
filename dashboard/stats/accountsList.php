<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("accounts"));
$dl->printFooter('../');
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0) {
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
$srcbtn = $members = "";
if(!isset($_GET["search"]) OR empty(trim(ExploitPatch::remove($_GET["search"])))) {
	$query = $db->prepare("SELECT * FROM accounts INNER JOIN users WHERE isActive = 1 AND accounts.accountID = users.extID ORDER BY accountID ASC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action=".">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
			<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
		</form>
	</div>');
		die();
	} 
} else {
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
	$query = $db->prepare("SELECT * FROM accounts INNER JOIN users WHERE accounts.userName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' AND isActive = 1 AND accounts.accountID = users.extID ORDER BY accountID ASC LIMIT 10 OFFSET $page");
	$query->execute();
	$result = $query->fetchAll();
	if(empty($result)) {
		$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="'.$_SERVER["SCRIPT_NAME"].'">
			<p id="dashboard-error-text">'.$dl->getLocalizedString("emptySearch").'</p>
			<button type="button" onclick="a(\'stats/accountsList.php\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>');
		die();
	} 
}
$x = $page + 1;
foreach($result as &$action){
	$clan = $own = '';
	$accUserID = $action["userID"];
	$accountID = $action["accountID"].' <text style="font-weight: 100;">|</text> '.$accUserID;
  	if($action["accountID"] == $accUserID) $accountID = $action["accountID"];
	$query = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accid");
	$query->execute([':accid' => $accountID]);
	$resultPls = $query->fetch();
	if(!$resultPls) $resultRole = $dl->getLocalizedString("player");
	else {
		$resultRole = $resultPls["roleID"];
		if(empty($resultRole)) {
			$resultRole = $dl->getLocalizedString("player");
		} else {
			$query = $db->prepare("SELECT roleName FROM roles WHERE roleID = :id");
			$query->execute([':id' => $resultRole]);
			$resultRole = $query->fetch()["roleName"];
		}
	}
	if($action["clan"] != 0) {
		$claninfo = $gs->getClanInfo($action["clan"]);
		if($claninfo["clanOwner"] == $action["accountID"]) $own = '<i style="color:#ffff91" class="fa-solid fa-crown"></i>';
		$clan = '<span style="display:contents;cursor:pointer"><h2 class="music" style="width: max-content;margin-left: 5px;grid-gap:5px;color:#'.$claninfo["color"].'">'.$claninfo["clan"].$own.'</h2></span>';
	}
	// Avatar management
    $iconType = ($action['iconType'] > 8) ? 0 : $action['iconType'];
    $iconTypeMap = [0 => ['type' => 'cube', 'value' => $action['accIcon']], 1 => ['type' => 'ship', 'value' => $action['accShip']], 2 => ['type' => 'ball', 'value' => $action['accBall']], 3 => ['type' => 'ufo', 'value' => $action['accBird']], 4 => ['type' => 'wave', 'value' => $action['accDart']], 5 => ['type' => 'robot', 'value' => $action['accRobot']], 6 => ['type' => 'spider', 'value' => $action['accSpider']], 7 => ['type' => 'swing', 'value' => $action['accSwing']], 8 => ['type' => 'jetpack', 'value' => $action['accJetpack']]];
    $iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
    $avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $action['color1'] . '&color2=' . $action['color2'] . ($action['accGlow'] != 0 ? '&glow=' . $action['accGlow'] . '&color3=' . $action['color3'] : '') . '" alt="avatar" style="width: 31px; object-fit: contain;">';
    // Badge management
    $badgeImg = '';
    $queryRoleID = $db->prepare("SELECT roleID FROM roleassign WHERE accountID = :accountID");
    $queryRoleID->execute([':accountID' => $accountID]);	
    if($roleAssignData = $queryRoleID->fetch(PDO::FETCH_ASSOC)) {        
        $queryBadgeLevel = $db->prepare("SELECT modBadgeLevel FROM roles WHERE roleID = :roleID");
        $queryBadgeLevel->execute([':roleID' => $roleAssignData['roleID']]);	    
        if(($modBadgeLevel = $queryBadgeLevel->fetchColumn() ?? 0) >= 1 && $modBadgeLevel <= 3) {
            $badgeImg = '<img src="https://raw.githubusercontent.com/Fenix668/GMDprivateServer/master/dashboard/modBadge_0' . $modBadgeLevel . '_001.png" alt="badge" style="width: 34px; height: 34px; margin-left: -3px; margin-top: -3px; vertical-align: middle;">';
        }
    }		
	$stats = $dl->createProfileStats($action['stars'], $action['moons'], $action['diamonds'], $action['coins'], $action['userCoins'], $action['demons'], $action['creatorPoints'], 0);
	$registerDate = date("d.m.Y", $action["registerDate"]);
	if($action['userName'] == "Undefined") $action['userName'] = $gs->getAccountName($action["accountID"]);
	$members .= '<div style="width: 100%;display: flex;flex-wrap: wrap;justify-content: center;">
			<div class="profile">
				<div style="display: flex;width: 100%;justify-content: space-between;margin-bottom: 7px;align-items: center;">
					<button style="display:contents;cursor:pointer" type="button" onclick="a(\'profile/'.$action["userName"].'\', true, true, \'GET\')">
						<div class="acclistdiv">
							<h2 style="color:rgb('.$gs->getAccountCommentColor($action["accountID"]).');" class="profilenick acclistnick">
								<div class="accounts-badge-icon-div">'.$avatarImg.' '.$action["userName"].' '.$badgeImg.'</div> '.$clan.'
							</h2>
							<h2 class="accresultrole">'.$resultRole.'</h2>
						</div>
					</button>
				</div>
			<div class="form-control song-info" style="display: flex;width: 100%;height: max-content;align-items: center;">'.$stats.'</div>
			<div class="acccomments">
				<h3 class="comments" style="margin: 0px;width: max-content;">'.$dl->getLocalizedString("accountID").': <b>'.$accountID.'</b></h3>
				<h3 class="comments" style="justify-content: flex-end;grid-gap: 0.5vh;margin: 0px;width: max-content;">'.$dl->getLocalizedString("registerDate").': <b>'.$registerDate.'</b></h3>
			</div>
		</div></div>';
	$x++;
}
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("accounts").'</h1>
<div class="form-control new-form-control">
		'.$members.'
	</div></div><form name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<input id="searchinput" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" type="text" name="search" value="'.$_GET["search"].'" placeholder="'.$dl->getLocalizedString("search").'">
		<button id="searchbutton" type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)" style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
if(empty(trim(ExploitPatch::remove($_GET["search"])))) $query = $db->prepare("SELECT count(*) FROM accounts INNER JOIN users WHERE isActive = 1 AND accounts.accountID = users.extID");
else $query = $db->prepare("SELECT count(*) FROM accounts INNER JOIN users WHERE accounts.userName LIKE '%".trim(ExploitPatch::remove($_GET["search"]))."%' AND isActive = 1 AND accounts.accountID = users.extID");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel . $bottomrow, true, "browse");
?>