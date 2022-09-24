<?php
//error_reporting(0);
include dirname(__FILE__)."/../../config/connection.php";
@header('Content-Type: text/html; charset=utf-8');
include_once dirname(__FILE__)."/mainLib.php";
$gs = new mainLib();
if(!isset($port))
	$port = 3306;
// banip check
    $banipcheck = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password, array(PDO::ATTR_PERSISTENT => true));
    $banip = $banipcheck->prepare("SELECT IP FROM bannedips WHERE IP=:ip");
  	$banip->execute([':ip' => $gs->getIP()]);
  	$banip2 = $banip->fetch();
  	if($banip2 != 0) exit(-1);
try {
    $db = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password, array(
    PDO::ATTR_PERSISTENT => true
));
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
