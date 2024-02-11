<?php
//error_reporting(32767);

//ini_set('display_errors', 1);
ob_start();
require_once "../lib/exploitPatch.php";
include "../lib/connection.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$n = ExploitPatch::remove($_GET['accID']);
if (!is_numeric($n)){
    $uname = $n;
    $accID = null;
    $nIsNum = false;
} else {
    $uname = null;
    $accID = $n;
    $nIsNum = true;
}

function parseStates($type, $data){
    switch ($type){
        case "mS":
            switch ($data){
                case 0:
                    return "all";
                case 1:
                    return "friends";
                case 2:
                    return "none";
            }
        case "frS":
            switch ($data){
                case 0:
                    return true;
                case 1:
                    return false;
            }
        case "cS":
            switch ($data){
                case 0:
                    return "all";
                case 1:
                    return "friends";
                case 2:
                    return "none";
            }
    }
}


function proc($data){
    global $db;
    global $gs;
    $out = array();
    $query = $db->prepare("SELECT count(*) FROM users WHERE stars > :stars AND isBanned = 0");
    $query->execute([':stars' => $data["stars"]]);
    if($query->rowCount() > 0){
     	$rank = $query->fetchColumn() + 1;
    }else{
    	$rank = 0;
    }
    
    $query2 = $db->prepare("SELECT youtubeurl,twitter,twitch, frS, mS, cS FROM accounts WHERE accountID = :accID");
    $query2->execute(["accID" => $data['userID']]);
    $data2 = $query2->fetch();
    $badge = $gs->getMaxValuePermission($data['extID'], "modBadgeLevel");
    
    $out['username'] = $data['userName'];
    $out["playerID"] = (string) $data['extID'];
    $out['accountID'] = (string)  $data['userID'];
    $out['rank'] = $rank;
    $out['stars'] = $data['stars'];
    $out['coins'] = $data['coins'];
    $out['userCoins'] = $data['userCoins'];
    $out['demons'] = $data['demons'];
    $out['moons'] = $data['moons'];
    $out['cp'] = $data['creatorPoints'];
    $out['icon'] = $data['icon'];
    $out['friendRequests'] = parseStates('frS', $data2['frS']);
    $out['messages'] =parseStates('mS', $data2['mS']);
    $out['commentHistory'] = parseStates('cS', $data2['cS']);
    $out['moderator'] = $badge;
    $out['youtube'] = $data2['youtubeurl'] ? $data2['youtubeurl'] : null;
    $out['twitter'] = $data2['twitter'] ? $data2['twitter'] : null;
    $out['twitch'] = $out['twitch'] ? $data2['twitch'] : null;
    $out['ship'] = $data['accShip'];
    $out['out'] = $data['accBall'];
    $out['ufo'] = $data['accBird'];
    $out['wave'] = $data['accDart'];
    $out['robot'] = $data['accRobot'];
    $out['spider'] = $data['accSpider'];
    $out['swing'] = $data["accSwing"];
    $out['jetpack'] = $data['accJetpack'];
    $out['col1'] = $data['color1'];
    $out['col2'] = $data['color2'];
    $out['colG'] = $data['accGlow'];
    $out['deathEffect'] = $data['accExplosion'];
    $out['glow'] = (boolean) $data['accGlow'];
    $out['demonTypes'] = null;
    $out['col1RGB'] = array("r" => null, "g" => null, "b" => null);
    $out['col2RGB'] = array("r" => null, "g" => null, "b" => null);
    $out['colGRGB'] = array("r" => null, "g" => null, "b" => null);
    header('Content-Type: application/json');
    return str_replace('    ', '  ', json_encode($out, JSON_PRETTY_PRINT));
}
ob_end_flush();
if ($nIsNum){
    $stmt = $db->prepare('SELECT * FROM users WHERE userID = :accID');
    $stmt->execute(["accID" => $accID]);
    $res1 = $stmt->fetch();
    if ($res1){
        unset($res1['IP']);
        unset($res1[26]);
        echo proc($res1);
    } else {
        echo -1;
    }
} else {
    $stmt = $db->prepare('SELECT * FROM users WHERE userName = :userName');
    $stmt->execute(["userName" => $uname]);
    $res1 = $stmt->fetch();
    if ($res1){
        unset($res1['IP']);
        unset($res1[26]);
        echo proc($res1);
    } else {
        echo -1;
    }
}

?>