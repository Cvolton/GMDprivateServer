<?php
$server = $_POST["server"];
$userName = $_POST["userName"];
$password = $_POST["password"];
$dbname = $_POST["databaseName"];
if (!empty($server) AND !empty($userName) AND !empty($password) AND !empty($dbname)) {
  try {
    $db = new PDO("mysql:host=$server;dbname=$dbname", $userName, $password, [PDO::ATTR_PERSISTENT => true]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "OK";
    $sql = file_get_contents("../database.sql");
    $db->exec($sql);
    $file = '<?php'.PHP_EOL.'$servername = "'.$server.'";'.PHP_EOL.'$username = "'.$userName.'";'.PHP_EOL.'$password = "'.$password.'";'.PHP_EOL.'$dbname = "'.$dbname.'";'.PHP_EOL.'?>';
    file_put_contents(dirname(__FILE__)."/../../config/connection.php", $file);
  } catch(PDOException $e) {
    echo "-2|".$e->getMessage();
  }
} else {
	echo "-1";
}
?>
