<?php
/* 
    [ WARNING: VERY EXPERIMENTAL ]

    Using it:
    In your binary, replace
    * https://www.newgrounds.com/audio/listen/%i
    with
    * https://path.to/ngMusic.php?id=%i
    This needs to be 42 CHARACTERS in length!
*/
include "incl/lib/connection.php";
require_once "incl/lib/exploitPatch.php";
$id = $_GET["id"] ? ExploitPatch::remove($_GET["id"]) : exit("Where ID?");
$query = "SELECT download, reuploadTime FROM songs WHERE ID = :id";
$query = $db->prepare($query);
$query->execute([':id' => $id]);
$result = $query->fetchAll();
if($query->rowCount() == 0) exit("<center><h1>No song found</h1></center>");

$row = $result[0]; // Assuming you expect only one row
$reuploadTime = $row["reuploadTime"];
$download = $row["download"];

if ($reuploadTime == "0") {
    // Newgrounds
    header("Location: https://www.newgrounds.com/audio/listen/$id");
} else {
    // Not newgrounds
    header("Location: $download");
}
exit();
