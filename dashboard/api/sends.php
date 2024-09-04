<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/mainLib.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";

$gs = new mainLib();

$levelID = ExploitPatch::number(urldecode($_GET['level']));

if(empty($levelID)) {
    http_response_code(400);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => "Please supply a valid level ID."]));
}

$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
$query->execute([":levelID" => $levelID]);
$query = $query->fetch();

if(!$query) {
    http_response_code(404);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => "This level wasn't found."]));
}

$query = $db->prepare("SELECT * FROM suggest WHERE suggestLevelId = :levelID ORDER BY timestamp DESC");
$query->execute([":levelID" => $levelID]);
$sendsInfo = $query->fetchAll();

if(!$sendsInfo) {
    http_response_code(404);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 3, 'message' => "This level wasn't sent."]));
}

$sends = [];

foreach ($sendsInfo as $send) {
    $sends[] = [
        "modUsername" => $gs->getAccountName($send["suggestBy"]),
        "modID" => $send["suggestBy"],
        "stars" => $send["suggestStars"],
        "featured" => $send["suggestFeatured"],
        "timestamp" => $send["timestamp"]
    ];
}

exit(json_encode(['dashboard' => true, 'success' => true, 'sends' => $sends]));
?>