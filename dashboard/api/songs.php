<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
include "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
if(!isset($_GET)) $json = json_decode(file_get_contents('php://input'), true);
else $json = $_GET;
$search = trim(ExploitPatch::rucharclean(urldecode($json["search"])));
if(!empty($search)) {
	if(!is_numeric($search)) {
		if(isset($json["mysongs"])) {
			$ds = trim(ExploitPatch::number(urldecode($json["mysongs"])));
			$discord = $db->prepare("SELECT accountID FROM accounts WHERE discordID = :id AND discordLinkReq = 0");
			$discord->execute([':id' => $ds]);
			$acc = $discord->fetch();
			if($acc["accountID"]) {
				if($search == 'MySongs') $songs = $db->prepare("SELECT * FROM songs WHERE reuploadID = :id AND isDisabled = 0 ORDER BY reuploadTime DESC");
				else $songs = $db->prepare("SELECT * FROM favsongs INNER JOIN songs on favsongs.songID = songs.ID WHERE favsongs.accountID = :id ORDER BY favsongs.ID DESC");
				$songs->execute([':id' => $acc["accountID"]]);
				$songs = $songs->fetchAll();
				if($songs) {
					foreach($songs as &$song) {
						$song["download"] = str_replace("http://", 'https://', str_replace("gcsdb/dashboard/", '', $song["download"]));
						$data[] = ["ID" => $song["ID"], "author" => $song["authorName"], "name" => $song["name"], "download" => $song["download"], "reuploadID" => $song["reuploadID"], "reuploadTime" => $song["reuploadTime"]];
					}
					$count = count($data);
					if($count > 0) {
						if($count == 1) exit(json_encode(["dashboard" => true, "success" => true, "numeric" => true, $data[0]]));
						else exit(json_encode(["dashboard" => true, "success" => true, "songs" => $data, "count" => $count, "numeric" => false]));
					}
				} else exit(json_encode(["dashboard" => true, "success" => false, "error" => 4]));
			} else exit(json_encode(["dashboard" => true, "success" => false, "error" => 3]));
		} else {
			$explode = explode(" - ", str_replace(" — ", " - ", $search), 2);
			if(!$explode[1]) {
				$author = $name = $search;
				$separator = 'OR';
			}
			else {
				$author = $explode[0];
				$name = $explode[1];
				$separator = 'AND';
			}
			$songs = $db->prepare("SELECT * FROM songs WHERE (authorName LIKE '%".$author."%' ".$separator." name LIKE '%".$name."%') AND reuploadID > 0 AND isDisabled = 0");
			$songs->execute();
			$songs = $songs->fetchAll();
			foreach($songs as &$song) {
				$song["download"] = str_replace("http://", 'https://', str_replace("gcsdb/dashboard/", '', $song["download"]));
				$data[] = ["ID" => $song["ID"], "author" => $song["authorName"], "name" => $song["name"], "download" => $song["download"], "reuploadID" => $song["reuploadID"], "reuploadTime" => $song["reuploadTime"]];
			}
			$count = count($data);
			if($count > 0) {
				if($count == 1) exit(json_encode(["dashboard" => true, "success" => true, "numeric" => true, "song" => $data[0], 'songs' => $data[0]]));
				else exit(json_encode(["dashboard" => true, "success" => true, "songs" => $data, "count" => $count, "numeric" => false]));
			} else exit(json_encode(["dashboard" => true, "success" => false, "error" => 2]));
		}
	} else {
		$songs = $db->prepare("SELECT * FROM songs WHERE ID = :id AND reuploadID > 0 AND isDisabled = 0");
		$songs->execute([':id' => $search]);
		$song = $songs->fetch();
		if($song) {
			$song["download"] = str_replace("http://", 'https://', str_replace("gcsdb/dashboard/", '', $song["download"]));
			$oneSong = ["ID" => $song["ID"], "author" => $song["authorName"], "name" => $song["name"], "download" => $song["download"], "reuploadID" => $song["reuploadID"], "reuploadTime" => $song["reuploadTime"]];
			exit(json_encode(["dashboard" => true, "success" => true, "numeric" => true, "song" => $oneSong, 'songs' => $oneSong]));
		}
		else exit(json_encode(["dashboard" => true, "success" => false, "error" => 1]));
	}
}
echo json_encode(["dashboard" => true, "success" => false, 'error' => 0]);
?>