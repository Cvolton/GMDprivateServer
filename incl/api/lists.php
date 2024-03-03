<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include "../lib/connection.php";
require_once "../lib/GJPCheck.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
require "../lib/generateHash.php";

$lvlstring = ""; $userstring = ""; $songsstring = ""; $lvlsmultistring = []; $str = ""; $order = "uploadDate";

$morejoins = ""
;
if (!empty($_GET['listID'])){
   $listID = ExploitPatch::number($_GET['listID']);
} else {
    exit("-1");
}

$query = $db->prepare('SELECT * FROM lists WHERE listID = :listID AND unlisted = 0');
$query->execute(['listID' => $listID]);
$result = $query->fetchAll();
foreach($result as &$list) {
    $out['name'] = $list['listName'];
        $out['ID'] = (string) $list['listID'];
    $out['desc'] = base64_decode($list['listDesc']) or $list['listDesc'];
    $query2 = $db->prepare('SELECT userName, extID FROM users WHERE userID = :userID');
    $query2->execute(['userID' => $list['accountID']]);
    $author = $query2->fetch();
    $out['author'] = $author['userName'];
    $out['playerID'] = (string) $author['extID'];
    $out['accountID'] = (string) $list['accountID'];
    $out['difficulty'] = null; # TODO: implement this
    $out['downloads'] = $list['downloads'];
    $out['likes'] = $list['likes'];
    $out['disliked'] = $list['likes'] < 0;
    $out['featured'] = $list['starFeatured'] >= 1;
    $out['levelRequired'] = $list['countForReward'];
    $out['levelIDs'] = explode(',', $list['listlevels']);
    $out['diamonds'] = $list['starStars'];
    $out['version'] = $list['listVersion'];
}
if (!$out){
    exit("-1");
}

header('Content-Type: application/json');
echo str_replace('    ', '  ', json_encode($out, JSON_PRETTY_PRINT));
?>
