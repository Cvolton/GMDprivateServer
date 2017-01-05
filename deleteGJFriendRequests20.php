<?php
include "connection.php";
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
//REMOVING THE REQUEST
$query = $db->prepare("DELETE from friendreqs WHERE toAccountID='$accountID' AND accountID='$targetAccountID' LIMIT 1");
$query->execute();
//RESPONSE SO IT DOESNT SAY "FAILED"
echo "1";
?>