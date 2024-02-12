<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function audioTrack($tr){
    $out = array();
    $songNames= array(
    0 => "Stereo Madness",
    1 => "Back on Track",
    2 => "Polargeist",
    3 => "Dry Out",
    4 => "Base After Base",
    5 => "Can't Let Go",
    6 => "Jumper",
    7 => "Time Machine",
    8 => "Cycles",
    9 => "xStep",
    10 => "Clutterfunk",
    11 => "Theory of Everything",
    12 => "Electroman Adventures",
    13 => "Clubstep",
    14 => "Electrodynamix",
    15 => "Hexagon Force",
    16 => "Blast Processing",
    17 => "Theory of Everything 2",
    18 => "Geometrical Dominator",
    19 => "Deadlocked",
    20 => "Fingerdash",
    21 => "Dash",
    22 => "Explorers",
    23 => "The Seven Seas",
    24 => "Viking Arena",
    25 => "Airborne Robots",
    26 => "Secret",
    27 => "Payload",
    28 => "Beast Mode",
    29 => "Machina",
    30 => "Years",
    31 => "Frontliners",
    32 => "Space Pirates",
    33 => "Strikers",
    34 => "Embers",
    35 => "Round 1",
    36 => "Monster Dance Off",
    37 => "Press Start",
    38 => "Nock Em",
    39 => "Power Trip",
    );
    
    $songArtists= array(
    0 => "ForeverBound",
    1 => "DJVI",
    2 => "Step",
    3 => "DJVI",
    4 => "DJVI",
    5 => "DJVI",
    6 => "Waterflame",
    7 => "Waterflame",
    8 => "DJVI",
    9 => "DJVI",
    10 => "Waterflame",
    11 => "DJ-Nate",
    12 => "Waterflame",
    13 => "DJ-Nate",
    14 => "DJ-Nate",
    15 => "Waterflame",
    16 => "Waterflame",
    17 => "DJ-Nate",
    18 => "Waterflame",
    19 => "F-777",
    20 => "MDK",
    21 => "MDK",
    22 => "Hinkik",
    23 => "F-777",
    24 => "F-777",
    25 => "F-777",
    26 => "RobTop",
    27 => "Dex Arson",
    28 => "Dex Arson",
    29 => "Dex Arson",
    30 => "Dex Arson",
    31 => "Dex Arson",
    32 => "Waterflame",
    33 => "Waterflame",
    34 => "Dex Arson",
    35 => "Dex Arson",
    36 => "F-777",
    37 => "MDK",
    38 => "Bossfight",
    39 => "Boom Kitty",
    );

    $out['songName'] = $songNames[$tr];
    $out['songArtist'] = $songArtists[$tr];
    $out['songSize'] = 0;
    $out["songLink"] = "Level ".$tr+1;

    return $out;
}



//make this better for demon and auto
function getDifficultyRating($n) {
    switch ($n) {
        case 0:
            return "Unrated";
        case 10:
            return "Easy";
        case 20:
            return "Normal";
        case 30:
            return "Hard";
        case 40:
            return "Harder";
        case 50:
            return "Insane";
        default:
            return "Unknown";
    }
}

function getLengthDescription($n) {
    switch ($n) {
        case 0:
            return "Tiny";
        case 1:
            return "Short";
        case 2:
            return "Medium";
        case 3:
            return "Long";
        case 4:
            return "XL";
        case 5:
            return "Plat";
        default:
            return "Unknown";
    }
}

function getOrbs($n) {
    switch ($n) {
        case 0:
        case 1:
            return 0;
        case 2:
            return 50;
        case 3:
            return 75;
        case 4:
            return 125;
        case 5:
            return 175;
        case 6:
            return 225;
        case 7:
            return 275;
        case 8:
            return 350;
        case 9:
            return 425;
        case 10:
            return 500;
        default:
            return 0;
    }
}

function getDiamonds($n) {
    switch ($n) {
        case 0:
        case 1:
            return 0;
        case 2:
            return 4;
        case 3:
            return 5;
        case 4:
            return 6;
        case 5:
            return 7;
        case 6:
            return 8;
        case 7:
            return 9;
        case 8:
            return 10;
        case 9:
            return 11;
        case 10:
            return 12;
        default:
            return 0;
    }
}

function torf($n){
    switch ($n){
        case 0:
            return 1 == $n;
        case 1:
            return 1 == $n;
        default:
            return 1 <= $n;
    }
}

// Function to parse the song info string
function songInfoParser($Sstr) {
    $Sparts = explode('~|~', $Sstr);
    $Sdict = [];
    for ($Si = 0; $Si < count($Sparts); $Si += 2) {
        if(isset($Sparts[$Si + 1])) {
            $Sdict[$Sparts[$Si]] = $Sparts[$Si + 1];
        }
    }
    return $Sdict;
}

// Extract levelID from the query parameter or URL segment
$levelID = isset($_GET['levelID']) ? $_GET['levelID'] : '';

include "../lib/connection.php";
require "../lib/XORCipher.php";
require_once "../lib/songReup.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
require "../lib/generateHash.php";
require "../lib/GJPCheck.php";
if(empty($_GET["levelID"])){
	exit("-1");
}
$ip = $gs->getIP();
$levelID = ExploitPatch::remove($_GET["levelID"]);
$binaryVersion = !empty($_POST["binaryVersion"]) ? ExploitPatch::remove($_POST["levelID"]) : 0;
$feaID = 0;

if(!is_numeric($levelID)){
	echo -1;
}else{
	$daily = 0;
	//downloading the level
	if($daily == 1)
		$query=$db->prepare("SELECT levels.*, users.userName, users.extID FROM levels LEFT JOIN users ON levels.userID = users.userID WHERE levelID = :levelID");
	else
		$query=$db->prepare("SELECT * FROM levels WHERE levelID = :levelID");

	$query->execute([':levelID' => $levelID]);
	$lvls = $query->rowCount();
	if($lvls!=0){
		$result = $query->fetch();

		//Verifying friends only unlisted
		if($result["unlisted2"] != 0){
			$accountID = GJPCheck::getAccountIDOrDie();
			if(! ($result["extID"] == $accountID || $gs->isFriends($accountID, $result["extID"])) ) exit("-1");
		}

		
		//getting the days since uploaded... or outputting the date in Y-M-D format at least for now...
		$uploadDate = date("d-m-Y G-i", $result["uploadDate"]);
		$updateDate = date("d-m-Y G-i", $result["updateDate"]);
		//password xor
		$pass = $result["password"];
		$desc = $result["levelDesc"];
		if($gs->checkModIPPermission("actionFreeCopy") == 1){
			$pass = "1";
		}
		$xorPass = $pass;
		if($gameVersion > 19){
			if($pass != 0) $xorPass = base64_encode(XORCipher::cipher($pass,26364));
		}else{
			$desc = base64_decode($desc);
		}
		// Initialize cURL session
        $Sch = curl_init('https://www.boomlings.com/database/getGJSongInfo.php');

        // The songID will be dynamically assigned based on your requirement
        // Example songID value, replace it with the actual songID you need to query
        $SsongID = $result['songID'];

        // Prepare POST data
        $Sdata = http_build_query([
            'songID' => $SsongID,
            'secret' => 'Wmfd2893gb7'
        ]);

        // Set cURL options for POST request and empty user agent
         
        curl_setopt($Sch, CURLOPT_USERAGENT, ''); // Set an empty user agent
        curl_setopt($Sch, CURLOPT_POST, true); // Enable POST method
        curl_setopt($Sch, CURLOPT_POSTFIELDS, $Sdata); // Set POST fields
        curl_setopt($Sch, CURLOPT_RETURNTRANSFER, true); // Return response instead of outputting

        // Execute cURL session and get the response
        $Sresponse = curl_exec($Sch);

        // Close cURL session
        curl_close($Sch);

        // Now, parse the response
        $SparsedResult = songInfoParser($Sresponse);


		$stmt = $db->prepare("SELECT userName,extID FROM users WHERE userID = :userID");
		$stmt->execute(["userID" => $result['userID']]);
		$res1 = $stmt->fetch(PDO::FETCH_ASSOC);
		$resp["name"] = $result['levelName'];
		$resp['id'] = (string) $result['levelID'];
		$resp['description'] = $desc;
		$resp['author'] = $res1['userName'] ?? "-";
		$resp['playerID'] = $res1['extID'];
		$resp['accountID'] = (string) $result['userID'];
		$resp['difficulty'] = $result['starDifficulty'];
		$resp['downloads'] = $result['downloads'];
		$resp['likes'] = $result['likes'];
		$resp['disliked'] = $result['likes'] < 0;
		$resp['length'] = getLengthDescription($result['levelLength']);
		$resp['platformer'] = $result['levelLength'] == 5;
		$resp['stars'] = $result['starStars'];
		$resp['orbs'] = getOrbs($result['starStars']);
        if (torf($result['starFeatured'])) {
                 $resp['diamonds'] = getDiamonds($result['starStars']);
       } else {
                 $resp['diamonds'] = 0;
       }

		$resp['featured'] = torf($result['starFeatured']);
		
		$resp['epic'] = torf($result['starEpic']);
		$resp['epicValue'] = $result['starEpic'];
		$resp['legendary'] = $result['starEpic'] === 2;
		$resp['mythic'] = $result['starEpic'] === 3;
		$resp['gameVersion'] = $result['gameVersion'];
		$resp['editorTime'] = $result['wt'];
		$resp['totalEditorTime'] = $result['wt2'];
		$resp['version'] = $result['levelVersion'];
		$resp['copiedID'] = (string) $result['original'];
		$resp['twoPlayer'] = torf($result['twoPlayer']);
		$resp['officialSong'] = $result['audioTrack'];
		$resp['customSong'] = $result['songID'];
		$resp['coins'] = $result['coins'];
		if ($result['starStars']) {
		    $resp['verifiedCoins'] = true;
		} else {
		    $resp['verifiedCoins'] = false;
		}
		$resp['starsRequested'] = $result['requestedStars'];
		$resp['ldm'] = torf($result['isLDM']);
		$resp['objects'] = $result['objects'];
		$resp['large'] = $result['objects'] >= 65536;
		$resp['cp'] = 0; // I dont what this means tho, hut GDBrowser has this.
		$resp['partialDiff'] = null; //TOOD: implement this
		$resp['difficultyFace'] = null; //TODO: implement this
	    if ($result['audioTrack'] >= 0 && $result['audioTrack'] <= 39) {
        if ($result['songID'] === 0) {
        $parsedResult = audioTrack($result['audioTrack']);
        $resp['songName'] = $parsedResult['songName'];
        $resp['songAuthor'] = $parsedResult['songArtist'];
        $resp['songSize'] = $parsedResult['songSize']."MB";
        $resp['songID'] =  $parsedResult['songLink'];
        } else {
        $resp['songName'] = $SparsedResult[2];
        $resp['songAuthor'] = $SparsedResult[4];
        $resp['songSize'] = "$SparsedResult[5]MB";
        $resp['songID'] = $result['songID'];
        $resp['songLink'] = str_replace('\\', '', urldecode($SparsedResult[10]));
       }
}
		
		header('Content-Type: application/json');
		echo str_replace('    ', '  ', json_encode($resp, JSON_PRETTY_PRINT));
		
	} else {
	    echo "-1";
	}
}
?>