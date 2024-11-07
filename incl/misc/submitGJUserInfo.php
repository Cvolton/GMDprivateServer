<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$id = $gs->getIDFromPost();
if(empty($_POST["levelsInfo"])) exit('-2');
/* GD doesn't XOR encrypts this data, i just want to encrypt it */
$data = ExploitPatch::url_base64_encode(XORCipher::cipher($_POST["levelsInfo"], 24157));
file_put_contents("../../data/info/$id", $data);
echo 1;
?>