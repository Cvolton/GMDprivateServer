<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."config/dashboard.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("modActionsList"));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0) {
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
} else {
	$page = 0;
	$actualpage = 1;
}
if(!isset($_GET["search"])) $_GET["search"] = "";
if(!isset($_GET["type"])) $_GET["type"] = "";
if(!isset($_GET["ng"])) $_GET["ng"] = "";
if(!isset($_GET["who"])) $_GET["who"] = "";
$srcbtn = "";
$pagelol = explode("/", $_SERVER["REQUEST_URI"]);
$pagelol = $pagelol[count($pagelol)-2]."/".$pagelol[count($pagelol)-1];
$pagelol = explode("?", $pagelol)[0];
$seltype = !empty($_GET["type"]) ? ExploitPatch::number($_GET["type"]) : 0; 
$selname = !empty($_GET["who"]) ? ExploitPatch::number($_GET["who"]) : 0;
if(!empty($_GET["type"]) OR !empty($_GET["who"])) {
	$where = 'WHERE';
	$srcbtn = '<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\')"  href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></button>';
}
else $where = '';
$requesttype = !empty($_GET["type"]) ? 'type = '.ExploitPatch::number($_GET["type"]) : '';
$requestwho = !empty($_GET["who"]) ? 'account = '.ExploitPatch::number($_GET["who"]) : '';
if(!empty($_GET["type"]) AND !empty($_GET["who"])) $requesttype .= ' AND';
$query = $db->prepare("SELECT * FROM modactions $where $requesttype $requestwho ORDER BY ID DESC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
if(empty($result)) {
	$dl->printSong('<div class="form">
    <h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
    <form class="form__inner" method="post" action=".">
		<p id="dashboard-error-text">'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
foreach($result as &$action){
	$account = $gs->getAccountName($action["account"]);
	$value = htmlspecialchars($action["value"]);
	$value2 = htmlspecialchars($action["value2"]);
	$value3 = htmlspecialchars($action["value3"]);
	$value4 = htmlspecialchars($action["value4"]);
	$value5 = htmlspecialchars($action["value5"]);
	$value6 = htmlspecialchars($action["value6"]);
	$actionname = $dl->getLocalizedString("modAction".$action["type"]);
	switch($action["type"]) {
		case 1:
			if($value2 == 1) $star = 0; elseif($value2 < 5 AND $value2 != 0) $star = 1; else $star = 2;
			$value2 = $value2.' '.$dl->getLocalizedString("starsLevel$star");
			if($value == 0) $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminNo").'</text>';
			break;
		case 2:
		case 3:
		case 4:
		case 12:
		case 14:
		case 29:
		case 38:
			if($action["value"] == 1) $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminYes").'</text>';
			else $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminNo").'</text>';
			$value2 = $gs->getLevelName($value3);
			break;
		case 5:
			$value = $value3;
			if(is_numeric($value2)) $value3 = date("d.m.Y", $value2);
			$value2 = $gs->getLevelName($value);
			break;
		case 6:
		case 34:
			$value = $value3;
			if(empty($value2)) $value2 = '<text style="color:gray">'.$dl->getLocalizedString('empty').'</text>';
			$value3 = date("d.m.Y", $action["timestamp"]);
			break;
		case 8:
			$value2 = $value;
			$value = htmlspecialchars($action['value2']);
			if(empty($action['value2'])) $value = '<text style="color:gray">'.$dl->getLocalizedString('empty').'</text>';
			break;
		case 9:
			if(!$gs->checkPermission($_SESSION['accountID'], "dashboardModTools")) $value = '<text style="color:gray">'.$dl->getLocalizedString('empty').'</text>';
			else $value = substr($value, 1);
			break;
		case 7:
		case 10:
		case 11:
		case 16:
			$value2 = $gs->getLevelName($value3);
			break;
		case 13:
			$value = ExploitPatch::url_base64_decode($value);
			break;
		case 15:
			$value = $gs->getAccountName($value);
			switch($value4) {
				case 'isBanned':
					$value4 = $dl->getLocalizedString('playerTop');
					break;
				case 'isCreatorBanned':
					$value4 = $dl->getLocalizedString('creatorTop');
					break;
				case 'isUploadBanned':
					$value4 = $dl->getLocalizedString('levelUploading');
					break;
				case 'isCommentBanned':
					$value4 = $dl->getLocalizedString('commentBan');
					break;
			}
			if($value3 == 0) $value3 = $value4.', <span style="color:#a9ffa9">'.$dl->getLocalizedString("unban").'</span>';
			else $value3 = $value4.', <span style="color:#ffa9a9">'.$dl->getLocalizedString("isBan").'</span>';
			if($value2 == 'banned' OR $value2 == 'none') $value2 = '<span style="color:gray">'.$dl->getLocalizedString("noReason").'</span>';
			break;
		case 18:
		case 22:
			$value2 = $value;
			$action['value2'] = $action['value'];
			$value = $action['value'] = $gs->getGauntletName($value3);
			break;
		case 17:
		case 21:
			if($value3 == 1) $star = 0; elseif($value3 < 5) $star = 1; else $star = 2;
			if($action["value4"] == 1) $coin = 0; elseif($action["value4"] != 0) $coin = 1; else $coin = 2; 
			$value = '<span style="color:rgb('.$action["value7"].');font-weight:700">'.$value.'</span>';
			$value3 = $value3.' '.$dl->getLocalizedString("starsLevel$star").', '.$action["value4"].' '.$dl->getLocalizedString("coins$coin");
			break;
		case 20:
		case 24:
			$value = '<form style="margin:0" method="post" action="./profile/"><button type="button" onclick="a(\'profile/'.$value.'\', true, true, \'POST\')" style="margin:0" class="accbtn" name="accountID" value="'.$value2.'">'.$value.'</button></form>';
			if(!empty($value3) && $value3 != "-1") {
				$clr = $db->prepare("SELECT commentColor, roleName FROM roles WHERE roleID = :id");
				$clr->execute([':id' => $value3]);
				$clr = $clr->fetch();
			} else {
				$clr['roleName'] = $dl->getLocalizedString('demoted');
				$clr['commentColor'] = '227, 81, 81';
			}
			$value3 = '<text style="color:rgb('.$clr["commentColor"].')">'.$clr['roleName'].'</text>';
			break;
		case 23:
		case 25:
			$value = $value4;
			$questTypes = ['Unknown', $dl->getLocalizedString("orbs"), $dl->getLocalizedString("coins"), $dl->getLocalizedString("stars")]; 
			$value2 = $questTypes[$action['value']];
			$value3 = $action["value2"].' | '.$action["value3"];
			break;
		case 26:
			$username26 = $gs->getAccountName($action["value"]);
			$value = '<button href="profile/'.$username26.'" class="accbtn" onclick="a(\'profile/'.$username26.'\', true, true)">'.$username26.'</button>';
			$value2 = $action["value"];
			if($value2 == 'Password') $value3 = $dl->getLocalizedString("password");
			else $value3 = $dl->getLocalizedString("username");
			break;
		case 28:
			switch($value3) {
				case 0:
					$username28 = $gs->getAccountName($action["value"]);
					$value = '<button href="profile/'.$username28.'" class="accbtn" onclick="a(\'profile/'.$username28.'\', true, true)">'.$username28.'</button>';
					break;
				case 1:
					$value = $gs->getUserName($value);
					break;
				case 2: 
					$value = $dl->getLocalizedString('IP');
					break;
			}
			$value2 = $action['value2'] = base64_decode($action['value2']);
			$banTextArray = ['unban', 'isBan', 'banChange'];
			$banColorArray = ['BBFFBB', 'FFBBBB', 'FFEEBB'];
			if(empty($value2)) $value2 = "<i>".$dl->getLocalizedString('noReason')."</i>";
			$value2 .= " <text>|</text> <span style='color: #".$banColorArray[$value6]."'>".$dl->getLocalizedString($banTextArray[$value6]).'</span>';
			$value3 = date("d.m.Y G:i", $value5);
			break;
		case 30:
		case 31:
			$value = $gs->getListName($action["value3"]).', '.$action['value3'];
			$value2 = $gs->getListDiffName($action["value2"]);
			$value3 = $action['value'];
			break;
		case 32:
		case 33:
			$value = $gs->getListName($action["value3"]);
			$value2 = $action['value'];
			break;
		case 35:
			$value = $gs->getListName($action["value3"]);
			$value2 = $gs->getAccountName($action['value']);
			break;
		case 37:
			$value = ExploitPatch::url_base64_decode($action['value']);
			$value2 = $gs->getListName($action["value3"]);
			break;
		case 39:
			if($action["value"] == 1) $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminYes").'</text>';
			else $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminNo").'</text>';
			$value2 = $gs->getListName($value3);
			break;
		case 40:
			$value = $value3;
			$value2 = $gs->getLevelName($value3);
			$value3 = date("d.m.Y", $action["timestamp"]);
			break;
		case 41:
			$value2 = $value.' '.$dl->getLocalizedString("starsLevel1");
			$value = $value3;
			$value3 = $gs->getLevelName($value3);
			break;
		case 42:
		case 43:
			$rewardTypes = ['Nothing', 'Fire Shard', 'Ice Shard', 'Poison Shard', 'Shadow Shard', 'Lava Shard', 'Demon Key', 'Orbs', 'Diamond', 'Nothing', 'Earth Shard', 'Blood Shard', 'Metal Shard', 'Light Shard', 'Soul Shard', 'Gold Key'];
			$value = $rewardTypes[$value2].', '.$value3;
			$value2 = $value5;
			$value3 = $dl->convertToDate($value4, true);
			break;
		case 44:
			$rewardTypes = ['Nothing', 'Fire Shard', 'Ice Shard', 'Poison Shard', 'Shadow Shard', 'Lava Shard', 'Demon Key', 'Orbs', 'Diamond', 'Nothing', 'Earth Shard', 'Blood Shard', 'Metal Shard', 'Light Shard', 'Soul Shard', 'Gold Key'];
			$value = $dl->convertToDate($value, true);
			$value2 = $rewardTypes[$value2].', '.$value4;
			$value3 = $gs->getLevelName($value3);
			break;
	}
	if(mb_strlen($action["value"]) > 18) $value = "<details><summary class='modactionsspoiler'>".$dl->getLocalizedString("spoiler")."</summary>$value</details>";
  	if(mb_strlen($action["value2"]) > 18) $value2 = "<details><summary class='modactionsspoiler'>".$dl->getLocalizedString("spoiler")."</summary>$value2</details>";
	$time = $dl->convertToDate($action["timestamp"], true);
	$v1 = '<div class="profilepic"><i class="fa-solid fa-1" style="background: #29282c; padding: 5px 11.5px; border-radius: 500px;"></i> '.$value.'</div>';
	$v2 = '<div class="profilepic"><i class="fa-solid fa-2" style="background: #29282c; padding: 5px 9.5px; border-radius: 500px;"></i> '.$value2.'</div>';
	$v3 = '<div class="profilepic"><i class="fa-solid fa-3" style="background: #29282c; padding: 5px 6.5px; border-radius: 500px;"></i> '.$value3.'</div>';
	$stats = $v1.$v2.$v3;
	// Avatar management
    $queryUserDetails = $db->prepare("SELECT u.iconType, u.accIcon, u.accShip, u.accBall, u.accBird, u.accDart, u.accRobot, u.accSpider, u.accSwing, u.accJetpack, u.color1, u.color2, u.color3, u.accGlow FROM users u JOIN modactions m ON u.extID = m.account WHERE m.account = :accountID");
    $queryUserDetails->execute([':accountID' => $action['account']]);
    if($userDetails = $queryUserDetails->fetch(PDO::FETCH_ASSOC)) {
        $iconType = ($userDetails['iconType'] > 8) ? 0 : $userDetails['iconType'];
        $iconTypeMap = [0 => ['type' => 'cube', 'value' => $userDetails['accIcon']], 1 => ['type' => 'ship', 'value' => $userDetails['accShip']], 2 => ['type' => 'ball', 'value' => $userDetails['accBall']], 3 => ['type' => 'ufo', 'value' => $userDetails['accBird']], 4 => ['type' => 'wave', 'value' => $userDetails['accDart']], 5 => ['type' => 'robot', 'value' => $userDetails['accRobot']], 6 => ['type' => 'spider', 'value' => $userDetails['accSpider']], 7 => ['type' => 'swing', 'value' => $userDetails['accSwing']], 8 => ['type' => 'jetpack', 'value' => $userDetails['accJetpack']]];
        $iconValue = (isset($iconTypeMap[$iconType]) && $iconTypeMap[$iconType]['value'] > 0) ? $iconTypeMap[$iconType]['value'] : 1;
        $avatarImg = '<img src="'.$iconsRendererServer.'/icon.png?type=' . $iconTypeMap[$iconType]['type'] . '&value=' . $iconValue . '&color1=' . $userDetails['color1'] . '&color2=' . $userDetails['color2'] . ($userDetails['accGlow'] != 0 ? '&glow=' . $userDetails['accGlow'] . '&color3=' . $userDetails['color3'] : '') . '" alt="avatar" style="width: 31px; margin-right: 5px; object-fit: contain;">';
    }
    $members .= '<div style="width: 100%; display: flex; flex-wrap: wrap; justify-content: center;">
        <div class="profile" style="width: 100%;">
            <div style="display: flex; align-items: center; margin-bottom: 7px;">
                <div style="display: flex; align-items: center;">
                    '.$avatarImg.'
                    <div>
                        <h1 class="dlh1 profh1 suggest" style="margin: 0;">
                            '.(!empty($account) ? '<button type="button" onclick="a(\'profile/'.$account.'\', true, true)" class="accbtn" name="accountID">'.$account.'</button>' : $dl->getLocalizedString("system")).'
                            <text class="dltext"> '.$actionname.'</text>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="form-control song-info longfc">'.$stats.'</div>
            <div class="acccomments">
                <h3 class="comments" style="margin: 0; width: max-content;">'.$dl->getLocalizedString("ID").':&nbsp;<b>'.$action["ID"].'</b></h3>
                <h3 class="comments" style="justify-content: flex-end; grid-gap: 0.5vh; margin: 0; width: max-content;">'.$dl->getLocalizedString("date").': <b>'.$time.'</b></h3>
            </div>
        </div>
    </div>';
	$x++;
}
$mods = $db->prepare("SELECT * FROM roleassign GROUP BY accountID");
$mods->execute();
$mods = $mods->fetchAll();
$options = '';
foreach($mods as &$mod) {
	$name = $gs->getAccountName($mod["accountID"]);
	$options .= '<option value="'.$mod["accountID"].'">'.$name.'</option>';
};
$pagel = '<div class="form new-form">
<h1 style="margin-bottom:5px">'.$dl->getLocalizedString("modActionsList").'</h1>
<div class="form-control new-form-control">
		'.$members.'
	</div></div><form method="get" name="searchform" class="form__inner">
	<div class="field" style="display:flex">
		<select id="sel1" style="border-top-right-radius: 0;margin:0;border-bottom-right-radius: 0;" name="type" value="'.$_GET["type"].'" placeholder="'.$dl->getLocalizedString("search").'">
		    <option value="0">'.$dl->getLocalizedString("everyActions").'</option>
			<option value="1">'.$dl->getLocalizedString("modAction1").' (1)</option>
			<option value="2">'.$dl->getLocalizedString("modAction2").' (2)</option>
			<option value="3">'.$dl->getLocalizedString("modAction3").' (3)</option>
			<option value="4">'.$dl->getLocalizedString("modAction4").' (4)</option>
			<option value="5">'.$dl->getLocalizedString("modAction5").' (5)</option>
			<option value="6">'.$dl->getLocalizedString("modAction6").' (6)</option>
			<option value="7">'.$dl->getLocalizedString("modAction7").' (7)</option>
			<option value="8">'.$dl->getLocalizedString("modAction8").' (8)</option>
			<option value="9">'.$dl->getLocalizedString("modAction9").' (9)</option>
			<option value="10">'.$dl->getLocalizedString("modAction10").' (10)</option>
			<option value="11">'.$dl->getLocalizedString("modAction11").' (11)</option>
			<option value="12">'.$dl->getLocalizedString("modAction12").' (12)</option>
			<option value="13">'.$dl->getLocalizedString("modAction13").' (13)</option>
			<option value="14">'.$dl->getLocalizedString("modAction14").' (14)</option>
			<option value="15">'.$dl->getLocalizedString("modAction15").' (15)</option>
			<option value="16">'.$dl->getLocalizedString("modAction16").' (16)</option>
			<option value="17">'.$dl->getLocalizedString("modAction17").' (17)</option>
			<option value="18">'.$dl->getLocalizedString("modAction18").' (18)</option>
			<option value="19">'.$dl->getLocalizedString("modAction19").' (19)</option>
			<option value="20">'.$dl->getLocalizedString("modAction20").' (20)</option>
            <option value="21">'.$dl->getLocalizedString("modAction21").' (21)</option>
            <option value="22">'.$dl->getLocalizedString("modAction22").' (22)</option>
            <option value="23">'.$dl->getLocalizedString("modAction23").' (23)</option>
            <option value="24">'.$dl->getLocalizedString("modAction24").' (24)</option>
			<option value="25">'.$dl->getLocalizedString("modAction25").' (25)</option>
			<option value="26">'.$dl->getLocalizedString("modAction26").' (26)</option>
			<option value="27">'.$dl->getLocalizedString("modAction27").' (27)</option>
			<option value="28">'.$dl->getLocalizedString("modAction28").' (28)</option>
			<option value="29">'.$dl->getLocalizedString("modAction29").' (29)</option>
			<option value="30">'.$dl->getLocalizedString("modAction30").' (30)</option>
			<option value="31">'.$dl->getLocalizedString("modAction31").' (31)</option>
			<option value="32">'.$dl->getLocalizedString("modAction32").' (32)</option>
			<option value="33">'.$dl->getLocalizedString("modAction33").' (33)</option>
			<option value="34">'.$dl->getLocalizedString("modAction34").' (34)</option>
			<option value="35">'.$dl->getLocalizedString("modAction35").' (35)</option>
			<option value="36">'.$dl->getLocalizedString("modAction36").' (36)</option>
			<option value="37">'.$dl->getLocalizedString("modAction37").' (37)</option>
			<option value="38">'.$dl->getLocalizedString("modAction38").' (38)</option>
			<option value="39">'.$dl->getLocalizedString("modAction39").' (39)</option>
			<option value="40">'.$dl->getLocalizedString("modAction40").' (40)</option>
         	<option value="41">'.$dl->getLocalizedString("modAction41").' (41)</option>
         	<option value="42">'.$dl->getLocalizedString("modAction42").' (42)</option>
         	<option value="43">'.$dl->getLocalizedString("modAction43").' (43)</option>
         	<option value="44">'.$dl->getLocalizedString("modAction44").' (44)</option>
		</select>
		<select id="sel2" style="border-radius: 0;margin:0;width:35%" name="who" value="'.$_GET["who"].'" placeholder="'.$dl->getLocalizedString("search").'">
			<option value="0">'.$dl->getLocalizedString("everyMod").'</option>
			'.$options.'
		</select>
		<button type="button" onclick="a(\''.$pagelol.'\', true, true, \'GET\', 69)"  style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>';
$query = $db->prepare("SELECT count(*) FROM modactions $where $requesttype $requestwho");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($pagel.$bottomrow.'<script>
	document.querySelector("#sel1").value='.$seltype.';
	document.querySelector("#sel2").value='.$selname.';
</script>', true, "stats");
?>