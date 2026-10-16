<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$reqstring = "";
$getSent = !empty($_POST["getSent"]) ? ExploitPatch::number($_POST["getSent"]) : 0;
$bcgjp = ($_POST["gameVersion"] > 21) ? $_POST["gjp2"] : $_POST["gjp"]; // Backwards Compatible GJP
if(empty($_POST["accountID"]) OR (!isset($_POST["page"]) OR !is_numeric($_POST["page"])) OR empty($bcgjp)) {
	exit("-1");
}
$accountID = GJPCheck::getAccountIDOrDie();
$page = ExploitPatch::number($_POST["page"]) ?: 0;
$offset = $page*10;

switch($getSent) {
	case 0: // Pending requests
		$query = "SELECT accountID, toAccountID, uploadDate, ID, comment, isNew FROM friendreqs WHERE toAccountID = :accountID AND isNew != 2 LIMIT 10 OFFSET $offset";
		$countquery = "SELECT count(*) FROM friendreqs WHERE toAccountID = :accountID AND isNew != 2";
		break;
	case 1: // Sent requests
		$query = "SELECT * FROM friendreqs WHERE accountID = :accountID LIMIT 10 OFFSET $offset";
		$countquery = "SELECT count(*) FROM friendreqs WHERE accountID = :accountID";
		break;
	case 2: // Ignored requests
		$query = "SELECT accountID, toAccountID, uploadDate, ID, comment, isNew FROM friendreqs WHERE toAccountID = :accountID AND isNew = 2 LIMIT 10 OFFSET $offset";
		$countquery = "SELECT count(*) FROM friendreqs WHERE toAccountID = :accountID AND isNew = 2";
		break;
	default:
		exit("-1");
}

$query = $db->prepare($query);
$query->execute([':accountID' => $accountID]);
$result = $query->fetchAll();
$countquery = $db->prepare($countquery);
$countquery->execute([':accountID' => $accountID]);
$reqcount = $countquery->fetchColumn();
if($reqcount == 0) exit("-2");
foreach($result as &$request) {
	if($getSent == 1) {
		$requester = $request["toAccountID"];
	} else {
		$requester = $request["accountID"];
	}
	$query = "SELECT userName, userID, icon, color1, color2, iconType, special, extID, clan FROM users WHERE extID = :requester";
	$query = $db->prepare($query);
	$query->execute([':requester' => $requester]);
	$user = $query->fetch();
	$uploadTime = $gs->makeTime($request["uploadDate"]);
	$extid = is_numeric($user["extID"]) ? $user['extID'] : 0;
	$user["userName"] = $gs->makeClanUsername($user);
	$request["comment"] = ExploitPatch::url_base64_decode($request["comment"]);
	if($_POST["binaryVersion"] < 51) $request["comment"] = ExploitPatch::translit($request["comment"]);
	$request["comment"] = ExploitPatch::url_base64_encode($request["comment"]);
	$request["isNew"] = $request["isNew"] == 1 ? 1 : 0;
	$reqstring .= "1:".$user["userName"].":2:".$user["userID"].":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":32:".$request["ID"].":35:".$request["comment"].":41:".$request["isNew"].":37:".$uploadTime."|";

}
$reqstring = substr($reqstring, 0, -1);
echo $reqstring;
echo "#${reqcount}:${offset}:10";
?>