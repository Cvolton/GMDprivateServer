<?php
include "../connection.php";
$query = $db->prepare("DELETE FROM levels WHERE levelString = ''");
$query->execute();
$query = $db->prepare("DELETE FROM users WHERE extID = ''");
$query->execute();
echo "<hr>If you do not see any errors above, the deletion was most probably succesful"
?>