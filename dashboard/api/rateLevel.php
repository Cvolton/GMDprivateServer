<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/connection.php";
require "../".$dbPath."incl/lib/mainLib.php";
require "../".$dbPath."incl/lib/exploitPatch.php";
require_once "../".$dbPath."incl/lib/GJPCheck.php";
$gs = new mainLib();
if(!isset($_POST)) $_POST = json_decode(file_get_contents('php://input'), true);

$accountID = GJPCheck::getAccountIDOrDie(true);
if(!$accountID) {
	http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'Please supply a valid account credentials.'])); 
}

http_response_code(400);

$levelID = isset($_POST['level']) ? ExploitPatch::number(urldecode($_POST['level'])) : exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 2, 'message' => 'Please supply a valid level ID.']));;
$stars = ExploitPatch::number(urldecode($_POST['stars']));
$feature = ExploitPatch::number(urldecode($_POST['feature']));
$featuredID = ExploitPatch::number(urldecode($_POST['featuredID']));
$coins = ExploitPatch::number(urldecode($_POST['coins']));

// Set Star Auto to 1 if stars is equal to 1
$starAuto = !empty($stars) && $stars == 1 ? 1 : 0;

// Check for rate permissions
if($gs->getMaxValuePermission($accountID, "commandRate") == false || $gs->getMaxValuePermission($accountID, "actionRateStars") == false) {
    http_response_code(403);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 3, 'message' => 'You do not have the necessary permissions to use this!']));
}

// Check for feature permission
if(!empty($feature) && $feature == 1) {
	if ($gs->getMaxValuePermission($accountID, "commandFeature") == false) {
		http_response_code(403);
		exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 4, 'message' => 'You do not have the necessary permission to feature a level!']));
	}
}

// Check for epic permission
if(!empty($feature) && $feature > 1) {
	if ($gs->getMaxValuePermission($accountID, "commandEpic") == false) {
		http_response_code(403);
		exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 5, 'message' => 'You do not have the necessary permission to make a level epic!']));
	}
}

// Check for permission to use feature ID parameter
if(!empty($featuredID) && $featuredID >= 1) {
	if ($gs->getMaxValuePermission($accountID, "commandFeature") == false) {
		http_response_code(403);
		exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 6, 'message' => 'You do not have the necessary permission to set a custom feature ID!']));
	}
}

// Check for permission to use coins parameter
if (!empty($coins) && !$gs->getMaxValuePermission($accountID, "commandVerifycoins")) {
	http_response_code(403);
	exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 7, 'message' => 'You do not have the necessary permission to verify the coins of a level!']));
}

// Check for valid amount of stars
if (!empty($stars) && $stars < 0 || $stars > 10) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 8, 'message' => 'Please specify a valid amount of stars.']));

// Check for valid feature state
if (!empty($feature) && $feature < 0 || $feature > 5) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 9, 'message' => 'Please specify a valid feature state.']));

// Check for valid coins (false/true)
if (isset($_POST['coins']) && $coins < 0 || $coins > 1) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 10, 'message' => 'Please specify a valid true/false boolean for the coins parameter.']));

if (isset($_POST['featuredID']) && $featuredID <= 0) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 11, 'message' => 'You cannot set a featured ID below 0.']));

$query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
$query->execute([':levelID' => $levelID]);
$query = $query->fetch();

// Check if the level exists
if (!$query) {
    http_response_code(404);
    exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 12, 'message' => 'This level does not exist!']));
}

// Set star auto from database if it cant fetch stars from parameters
if (empty($stars)) $starAuto = $query["starAuto"];

// Check for coins only update
if (!isset($_POST['stars']) && !isset($_POST['feature']) && !isset($_POST['featuredID']) && isset($_POST['coins'])) {
	if ($query["starStars"] > 0) {
		$gs->verifyCoinsLevel($accountID, $levelID, $coins);
		
        http_response_code(200);
        exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $levelID]));
	} else {
        http_response_code(404);
		exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 13, 'message' => 'This level is not star rated!']));
	}
}

// Check for feature only update
if (!isset($_POST['stars']) && isset($_POST['feature']) && !isset($_POST['coins'])) {
	if ($query["starStars"] != 0) {
		if (isset($_POST['featuredID'])) {
			switch($feature) {
				case 0:
					$featureState = $featuredID;
					$epic = 0;
					break;
				case 1:
				case 2:
				case 3:
				case 4:
					$featureState = $featuredID;
					$epic = $feature - 1;
					break;
			}
			$query = $db->prepare("UPDATE levels SET starFeatured=:feature, starEpic=:epic, rateDate = :timestamp WHERE levelID=:levelID");
			$query->execute([':feature' => $feature, ':epic' => $epic, ':timestamp' => time(), ':levelID' => $levelID]);

            // Insert action into mod actions
            $query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
            $query->execute([':value' => $featureState, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
		} else $gs->featureLevel($accountID, $levelID, $feature);

        http_response_code(200);
		exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $levelID]));
	} else {
        http_response_code(404);
        exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 14, 'message' => 'This level is not star rated!']));
    }
}

// Check for featured ID only update
if (!isset($_POST['stars']) && !isset($_POST['feature']) && !isset($_POST['coins']) && isset($_POST['featuredID'])) {
	if ($query["starStars"] > 0 && $query["starFeatured"] > 0) {
		$query = $db->prepare("UPDATE levels SET starFeatured = :starFeatured, rateDate = :timestamp WHERE levelID = :levelID");
		$query->execute([':starFeatured' => $featuredID, ':timestamp' => time(), ':levelID' => $levelID]);

        http_response_code(200);
		exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $levelID]));
	} else {
        http_response_code(404);
        exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 15, 'message' => 'This level is not rated/featured!']));
    }
}

// Check if stars has been set before doing any requests here
if (!isset($_POST['stars'])) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 16, 'message' => 'Please supply an amount of stars.']));

$difficulty = $gs->getDiffFromStars($stars);

// Solve $feature problems
if (!isset($_POST['feature'])) {
	if (isset($_POST['stars']) && $stars == 0) $feature = 0;
	elseif ($query['starFeatured'] >= 1 && $query['starEpic'] >= 1) $feature = $query['starEpic'];
	elseif ($query['starFeatured'] >= 1 && $query['starEpic'] == 0) $feature = 1;
}

// Set coins from database if it cant fetch coins from parameters
if (!isset($_POST['coins'])) $coins = $query["starCoins"];
// Set coins to 0 if the level is set to be unrated
if (isset($_POST['stars']) && $stars == 0 && $query['starStars'] >= 1 && $coins == 0) $coins = 0;

$gs->rateLevel($accountID, $levelID, $stars, $difficulty["diff"], $difficulty["auto"], $difficulty["demon"]);
// Feature ID check
if (!empty($featuredID) && !empty($feature) && $featuredID >= 1) {
    switch($feature) {
        case 0:
            $featureState = $featuredID;
            $epic = 0;
            break;
        case 1:
        case 2:
        case 3:
        case 4:
            $featureState = $featuredID;
            $epic = $feature - 1;
            break;
    }
    $query = $db->prepare("UPDATE levels SET starFeatured=:feature, starEpic=:epic, rateDate = :timestamp WHERE levelID=:levelID");
    $query->execute([':feature' => $feature, ':epic' => $epic, ':timestamp' => time(), ':levelID' => $levelID]);

    // Insert action into mod actions
    $query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('2', :value, :levelID, :timestamp, :id)");
    $query->execute([':value' => $featureState, ':timestamp' => time(), ':id' => $accountID, ':levelID' => $levelID]);
} else $gs->featureLevel($accountID, $levelID, $feature);

if ($stars <= 0) $gs->verifyCoinsLevel($accountID, $levelID, 0);
else $gs->verifyCoinsLevel($accountID, $levelID, isset($_POST['coins']) ? $coins : $query["starCoins"]);

http_response_code(200);
exit(json_encode(['dashboard' => true, 'success' => true, 'level' => $levelID]));
?>