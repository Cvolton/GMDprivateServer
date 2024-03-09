<?php
session_start();
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
$gs = new mainLib();
include "../".$dbPath."incl/lib/connection.php";
$dl->title($dl->getLocalizedString("modActionsList"));
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("mod").'</th><th>'.$dl->getLocalizedString("action").'</th><th>'.$dl->getLocalizedString("value").'</th><th>'.$dl->getLocalizedString("value2").'</th><th>'.$dl->getLocalizedString("value3").'</th><th>'.$dl->getLocalizedString("time").'</th></tr>';
$seltype = !empty($_GET["type"]) ? ExploitPatch::number($_GET["type"]) : 0; 
$selname = !empty($_GET["who"]) ? ExploitPatch::number($_GET["who"]) : 0;
if(!empty($_GET["type"]) OR !empty($_GET["who"])) {
	$where = 'WHERE';
	$srcbtn = '<a href="'.$_SERVER["SCRIPT_NAME"].'" style="width: 0%;display: flex;margin-left: 5px;align-items: center;justify-content: center;color: indianred; text-decoration:none" class="btn-primary" title="'.$dl->getLocalizedString("searchCancel").'"><i class="fa-solid fa-xmark"></i></a>';
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
		<p>'.$dl->getLocalizedString("emptyPage").'</p>
        <button type="submit" class="btn-primary">'.$dl->getLocalizedString("dashboard").'</button>
    </form>
</div>', 'stats');
	die();
} 
foreach($result as &$action){
	//detecting mod
	$account = $action["account"];
	$account =  '<form style="margin:0" method="post" action="profile/"><button style="margin:0" class="accbtn" name="accountID" value="'.$action["account"].'">'.$gs->getAccountName($account).'</button></form>';
	//detecting action
	$value = $action["value"];
	$value2 = $action["value2"];
	$value3 = $action["value3"];
	if($action["type"] == 5){
      	$value = $value3;
		if(is_numeric($value2)){
			$value3 = date("d.m.Y", $value2);
		}
	}
	if($action["type"] == 15) {
		$value = $gs->getAccountName($value);
	}
	$actionname = $dl->getLocalizedString("modAction".$action["type"]);
  	
  	if($action["type"] == 1) {
		if($value2 == 1) $star = 0; elseif($value2 < 5 AND $value2 != 0) $star = 1; else $star = 2;
      	$value2 = $value2.' '.$dl->getLocalizedString("starsLevel$star");
		if($value == 0) $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminNo").'</text>';
    }
	if($action["type"] == 2 OR $action["type"] == 3 OR $action["type"] == 4){
		if($action["value"] == 1) $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminYes").'</text>';
      	else $value = '<text style="color:gray">'.$dl->getLocalizedString("isAdminNo").'</text>';
		$value2 = $gs->getLevelName($value3);
    }
	if($action["type"] == 13){
		$value = base64_decode($value);
	}
  	if($action["type"] == 15) {
    	if($value3 == 0) $value3 = '<div style="color:#a9ffa9">'.$dl->getLocalizedString("unban").'</div>';
      	else $value3 = '<div style="color:#ffa9a9">'.$dl->getLocalizedString("isBan").'</div>';
      	if($value2 == 'banned' OR $value2 == 'none') $value2 = '<div style="color:gray">'.$dl->getLocalizedString("noReason").'</div>';
    } 
  	if($action["type"] == 26) {
		if($value2 == 'Password') $value2 = $dl->getLocalizedString("password");
		else $value2 = $dl->getLocalizedString("username");
	}
  	if($action["type"] == 17) { 
      	if($value3 == 1) $star = 0; elseif($value3 < 5) $star = 1; else $star = 2;
      	if($action["value4"] == 1) $coin = 0; elseif($action["value4"] != 0) $coin = 1; else $coin = 2; 
		$value = '<div style="color:rgb('.$action["value7"].');font-weight:700">'.$value.'</div>';
      	$value3 = $value3.' '.$dl->getLocalizedString("starsLevel$star").', '.$action["value4"].' '.$dl->getLocalizedString("coins$coin");
	}
	if(strlen($action["value"]) > 18) $value = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$value</details>";
  	if(strlen($action["value2"]) > 18) $value2 = "<details><summary>".$dl->getLocalizedString("spoiler")."</summary>$value2</details>";
	$time = $dl->convertToDate($action["timestamp"]);
	if($action["type"] == 5){
		$desc = $db->prepare("SELECT levelName FROM levels WHERE levelID = :id");
		$desc->execute([':id' => $value]);
		$desc = $desc->fetch();
		$value2 = $desc["levelName"];
	}
	$table .= "<tr><th scope='row'>".$x."</th><td>".$account."</td><td>".$actionname."</td><td>".$value."</td><td>".$value2."</td><td>".$value3."</td><td>".$time."</td></tr>";
	$x++;
}
$mods = $db->prepare("SELECT * FROM roleassign");
$mods->execute();
$mods = $mods->fetchAll();
$options = '';
foreach($mods as &$mod) {
	$name = $gs->getAccountName($mod["accountID"]);
	$options .= '<option value="'.$mod["accountID"].'">'.$name.'</option>';
};
$table .= '</table><form method="get" class="form__inner">
	<div class="field" style="display:flex">
		<select id="sel1" style="border-top-right-radius: 0;margin:0;border-bottom-right-radius: 0;" name="type" value="'.$_GET["type"].'" placeholder="'.$dl->getLocalizedString("search").'">
		    <option value="0">Любые действия</option>
			<option value="1">'.$dl->getLocalizedString("modAction1").'</option>
			<option value="2">'.$dl->getLocalizedString("modAction2").'</option>
			<option value="3">'.$dl->getLocalizedString("modAction3").'</option>
			<option value="4">'.$dl->getLocalizedString("modAction4").'</option>
			<option value="5">'.$dl->getLocalizedString("modAction5").'</option>
			<option value="6">'.$dl->getLocalizedString("modAction6").'</option>
			<option value="7">'.$dl->getLocalizedString("modAction7").'</option>
			<option value="8">'.$dl->getLocalizedString("modAction8").'</option>
			<option value="9">'.$dl->getLocalizedString("modAction9").'</option>
			<option value="10">'.$dl->getLocalizedString("modAction10").'</option>
			<option value="11">'.$dl->getLocalizedString("modAction11").'</option>
			<option value="12">'.$dl->getLocalizedString("modAction12").'</option>
			<option value="13">'.$dl->getLocalizedString("modAction13").'</option>
			<option value="14">'.$dl->getLocalizedString("modAction14").'</option>
			<option value="15">'.$dl->getLocalizedString("modAction15").'</option>
			<option value="16">'.$dl->getLocalizedString("modAction16").'</option>
			<option value="17">'.$dl->getLocalizedString("modAction17").'</option>
			<option value="18">'.$dl->getLocalizedString("modAction18").'</option>
			<option value="19">'.$dl->getLocalizedString("modAction19").'</option>
			<option value="20">'.$dl->getLocalizedString("modAction20").'</option>
			<option value="25">'.$dl->getLocalizedString("modAction25").'</option>
			<option value="26">'.$dl->getLocalizedString("modAction26").'</option>
		</select>
		<select id="sel2" style="border-radius: 0;margin:0;width:35%" name="who" value="'.$_GET["who"].'" placeholder="'.$dl->getLocalizedString("search").'">
			<option value="0">Все модераторы</option>
			'.$options.'
		</select>
		<button style="width: 6%;border-top-left-radius:0px !important;border-bottom-left-radius:0px !important" type="submit" class="btn-primary" title="'.$dl->getLocalizedString("search").'"><i class="fa-solid fa-magnifying-glass"></i></button>
		'.$srcbtn.'
	</div>
</form>
<script>
	document.querySelector("#sel1").value='.$seltype.';
	document.querySelector("#sel2").value='.$selname.';
</script>';
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM modactions $where $requesttype $requestwho");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "stats");
?>