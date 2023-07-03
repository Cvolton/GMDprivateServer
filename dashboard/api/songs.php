<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
require "../incl/dashboardLib.php";
error_reporting(E_ALL);
include "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$json = json_decode(file_get_contents('php://input'), true);
$search = trim(ExploitPatch::remove(urldecode($json["search"])));
if(!empty($search)) {
	if(!is_numeric($search)) {
		if(isset($json["mysongs"])) {
			$ds = trim(ExploitPatch::number(urldecode($json["mysongs"])));
			$discord = $db->prepare("SELECT accountID FROM accounts WHERE discordID = :id AND discordLinkReq = 0");
			$discord->execute([':id' => $ds]);
			$acc = $discord->fetch();
			if($acc["accountID"]) {
				$songs = $db->prepare("SELECT * FROM songs WHERE reuploadID = :id AND isDisabled = 0 ORDER BY reuploadTime DESC");
				$songs->execute([':id' => $acc["accountID"]]);
				$songs = $songs->fetchAll();
				if($songs) {
					foreach($songs as &$song) {
						$song["download"] = str_replace("http://", 'https://', str_replace("gcsdb/dashboard/", '', $song["download"]));
						$data[] = ["ID" => $song["ID"], "author" => $song["authorName"], "name" => $song["name"], "download" => $song["download"], "reuploadID" => $song["reuploadID"], "reuploadTime" => $song["reuploadTime"]];
					}
					$count = count($data);
					if($count > 0) {
						if($count == 1) exit(json_encode(["success" => true, "numeric" => true, $data[0]]));
						else exit(json_encode(["success" => true, "songs" => $data, "count" => $count, "numeric" => false]));
					}
				} else exit(json_encode(["success" => false, "error" => 4]));
			} else exit(json_encode(["success" => false, "error" => 3]));
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
				if($count == 1) exit(json_encode(["success" => true, "numeric" => true, "song" => $data[0]]));
				else exit(json_encode(["success" => true, "songs" => $data, "count" => $count, "numeric" => false]));
			} else exit(json_encode(["success" => false, "error" => 2]));
		}
	} else {
		$songs = $db->prepare("SELECT * FROM songs WHERE ID = :id AND reuploadID > 0 AND isDisabled = 0");
		$songs->execute([':id' => $search]);
		$song = $songs->fetch();
		if($song) {
			$song["download"] = str_replace("http://", 'https://', str_replace("gcsdb/dashboard/", '', $song["download"]));
			exit(json_encode(["success" => true, "numeric" => true, "song" => ["ID" => $song["ID"], "author" => $song["authorName"], "name" => $song["name"], "download" => $song["download"], "reuploadID" => $song["reuploadID"], "reuploadTime" => $song["reuploadTime"]]]));
		}
		else exit(json_encode(["success" => false, "error" => 1]));
	}
}
echo json_encode(["success" => false, 'error' => 0]);
?>
