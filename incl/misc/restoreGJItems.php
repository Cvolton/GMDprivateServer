<?php
chdir(dirname(__FILE__));
require "../lib/connection.php";
require_once "../lib/exploitPatch.php";
require_once "../lib/XORCipher.php";
require_once "../lib/mainLib.php";
$gs = new mainLib();
$id = $gs->getIDFromPost();

if(!file_exists("../../data/info/$id")) exit("-1");
echo XORCipher::cipher(ExploitPatch::url_base64_decode(file_get_contents("../../data/info/$id")), 24157);
?>