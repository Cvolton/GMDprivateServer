<?php
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();

$secret = ExploitPatch::remove($_POST["secret"]);
$id = $gs->getIDFromPost();

if ($secret != "Wmfd2893gb7") {
	exit("-1");
}

if(file_exists("../../data/info/$id")){
	$str = file_get_contents("../../data/info/$id");
} else {
	exit("-1");
}

echo $str;

?>