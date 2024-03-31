<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
$reqstring = "";
$getSent = !empty($_POST["getSent"]) ? ExploitPatch::remove($_POST["getSent"]) : 0;

$bcgjp = ($_POST["gameVersion"] > 21) ? $_POST["gjp2"] : $_POST["gjp"]; // Backwards Compatible GJP
if(empty($_POST["accountID"]) OR (!isset($_POST["page"]) OR !is_numeric($_POST["page"])) OR empty($bcgjp)){
	exit("-1");
}

$accountID = GJPCheck::getAccountIDOrDie();
$page = ExploitPatch::number($_POST["page"]);
$offset = $page*10;
if($getSent == 0){
	$query = "SELECT accountID, toAccountID, uploadDate, ID, comment, isNew FROM friendreqs WHERE toAccountID = :accountID LIMIT 10 OFFSET $offset";
	$countquery = "SELECT count(*) FROM friendreqs WHERE toAccountID = :accountID";
}elseif($getSent == 1){
	$query = "SELECT * FROM friendreqs WHERE accountID = :accountID LIMIT 10 OFFSET $offset";
	$countquery = "SELECT count(*) FROM friendreqs WHERE accountID = :accountID";
}else{
	exit("-1");
}
$query = $db->prepare($query);
$query->execute([':accountID' => $accountID]);
$result = $query->fetchAll();
$countquery = $db->prepare($countquery);
$countquery->execute([':accountID' => $accountID]);
$reqcount = $countquery->fetchColumn();
if($reqcount == 0){
	exit("-2");
}
foreach($result as &$request) {
	if($getSent == 0){
		$requester = $request["accountID"];
	}else if($getSent == 1){
		$requester = $request["toAccountID"];
	}
	$query = "SELECT userName, userID, icon, color1, color2, iconType, special, extID FROM users WHERE extID = :requester";
	$query = $db->prepare($query);
	$query->execute([':requester' => $requester]);
	$result2 = $query->fetchAll();
	$user = $result2[0];
	$uploadTime = date("d/m/Y G.i", $request["uploadDate"]);
	$extid = is_numeric($user['extID']) ? $user['extID'] : 0;
	$reqstring .= "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":32:".$request["ID"].":35:".$request["comment"].":41:".$request["isNew"].":37:".$uploadTime."|";

}
$reqstring = substr($reqstring, 0, -1);
echo $reqstring;
echo "#${reqcount}:${offset}:10";
?>
