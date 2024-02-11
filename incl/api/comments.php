<?php
//error_reporting(32767);

//ini_set('display_errors', 1);
ob_start();
require_once "../lib/exploitPatch.php";
include "../lib/connection.php";
require_once "../lib/mainLib.php";
include "timeAgo.php";
$gs = new mainLib();


$filterID = ExploitPatch::number($_GET['levelID']);
if (!$filterID){
    exit -1;
}
$page = isset($_GET['page']) ? ExploitPatch::number($_GET['page']) : 0;
$count = isset($_GET['count']) ? ExploitPatch::number($_GET['count']) : 10;

$out = array();

function iconType($icon){
    switch($icon){
        case 0:
            return "icon";
        case 1:
            return "ship";
        case 2:
            return "ball";
        case 3:
            return "ufo";
        case 4:
            return "wave";
        case 5:
            return "robot";
        case 6:
            return "spider";
        case 7:
            return "swing";
        case 8:
            return "jetpack";
    }
}

function proc() {
    global $db;
    global $filterID;
    global $page;
    global $count;
    global $gs;
    $filterColumn = 'levelID';
    $userListJoin = $userListWhere = $userListColumns = "";
    $commentpage = $page*$count;
    $countquery = "SELECT count(*) FROM comments $userListJoin WHERE ${filterToFilter}${filterColumn} = :filterID $userListWhere";
    $countquery = $db->prepare($countquery);
    $countquery->execute([':filterID' => $filterID]);
    $commentcount = $countquery->fetchColumn();
    if($commentcount == 0){
	    exit("");
    }
    $res = array();
    $out = array();
    $query = "SELECT comments.levelID, comments.commentID, comments.timestamp, comments.comment, comments.userID, comments.likes, comments.isSpam, comments.percent, users.userName, users.icon, users.color1, users.color2,  users.color3, users.accGlow, users.iconType, users.special, users.extID FROM comments LEFT JOIN users ON comments.userID = users.userID ${userListJoin} WHERE comments.${filterColumn} = :filterID ${userListWhere} ORDER BY comments.${filterColumn} DESC LIMIT ${count} OFFSET ${commentpage}";
    $query = $db->prepare($query);
    $query->execute([':filterID' => $filterID]);
    $result = $query->fetchAll();
    
    // actual parsing
    $idx = 0;
    foreach($result as &$cm){
        $idx++;
        
        $out1 = array();
        
        $out1['form'] = iconType($cm['iconType']);
        $out1['icon'] = $cm['icon'];
        $out1['col1'] = $cm['color1'];
        $out1['col2'] = $cm['color2'];
        $out1['colG'] = $cm['color3'];
        $out1['glow'] = (boolean) $cm['accGlow'];
        
        $badge = $gs->getMaxValuePermission($cm['extID'], "modBadgeLevel");
        $uploadDate = timeAgo($cm["timestamp"])." ago";
		$commentText = base64_decode($cm["comment"]);
		$out['content'] = $commentText;
		$out['ID'] = $cm['commentID'];
		$out['likes'] = $cm['likes'];
		$out['date'] = $uploadDate;
		$out['username'] = $cm['userName'];
		$out['playerID'] = (string) $cm['extID'];
		$out['accountID'] = (string) $cm['userID'];
		$out['cp'] = $out['moons'] = $out['demons'] = $out['userCoins'] = $out['coins'] = $out["diamonds"] = $out['stars'] = $out['rank'] = null; // trying to replicate some stuffs as much as i can possibly do
		$out['icon'] = $out1;
		$out['col1RGB'] = array("r" => null, "g" => null, "b" => null);
        $out['col2RGB'] = array("r" => null, "g" => null, "b" => null);
        $out['colGRGB'] = null;
        $out['levelID'] = $cm['levelID'];
        $out['color'] = null;
        $out['moderator'] = $badge;
        if ($idx === 1){
            $out['results'] = $commentcount;
            $out['pages'] = ceil($commentcount/$count);
            // Calculate the start and end range of comments for the current page
            $startRange = ( ($page - 1) * $count + 1)+10;
            $endRange = ( min($page * $count, $commentcount))+10;
            if ($endRange > $commentcount){
                $out['range'] = "$startRange to $commentcount";
            } else {
                $out['range'] = "$startRange to $endRange";
            }
        } else {
            unset($out['results']);
            unset($out['pages']);
            unset($out['range']);
        }
		$res[]=$out;
    }
    return $res;
}

$out = proc();
header('Content-Type: application/json');
echo str_replace('    ', '  ', json_encode($out, JSON_PRETTY_PRINT));
?>