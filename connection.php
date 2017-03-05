<?php
header('Content-Type: text/html; charset=utf-8');
$servername = "localhost";
$username = "cvoltongdps";
$password = "";
$dbname = "my_cvoltongdps";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(
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