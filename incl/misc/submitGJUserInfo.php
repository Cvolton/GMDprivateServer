<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$secret = ExploitPatch::remove($_POST["secret"]);
$id = $gs->getIDFromPost();
$data = $_POST["levelsInfo"];

if ($secret != "Wmfd2893gb7") {
	exit("-1");
}

file_put_contents("../../data/info/$id",$data);

echo 1;
?>