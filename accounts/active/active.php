<?php
error_reporting(0);
include "../../incl/lib/connection.php";
$Email = base64_decode($_GET["ID"]);
$password = $_GET["Key"];
$query = $db->prepare("UPDATE accounts SET active = 1 WHERE email = :email AND password = :password");
$query->execute([":email" => $Email, ":password" => $password]);
$count = $query->rowcount();
if ($count != 0) {
  echo '<center><br><div class="jumbotron">Success!</div></center>';
} else {
  echo '<center><br><div class="jumbotron">Failed</div></center>';
}
?>
